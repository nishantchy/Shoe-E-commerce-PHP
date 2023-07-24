<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "fourthsem";

$conn = mysqli_connect($server, $username, $password, $dbname);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User</title>
    <link rel="stylesheet" href="style.css">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
      crossorigin="anonymous"
    />
    <style>
        .user .change-img img{
    border-radius: 50%;
    width: 40px;
    height: 40px;
    object-fit: cover;    
 }
 #admin-btn{
    background-color: #233565;
    color: aliceblue;
    padding: 0.2rem 2rem;
    border: 0;
    border-radius: 0.2rem;
}
.contactus button{
    padding: 2rem 3.2rem;
}
.orders button{
    padding: 2rem 2.8rem;
}
    </style>
</head>
<body>
<nav>
        <div class="logo"><img src="../../../svgs/logo-no-background.png" alt=""></div>
        <div class="menu">
        <div class="search-bar">
                <li><form action="../../search/search.php" method="get">
                <li><input type="text" placeholder="Search" name="search" id=""></li>
                <button type="submit"><img src="../../../svgs/icons8-search.svg" alt=""></button>
                </form></li>
            </div>
            <div class="list">
                <ul>
                    <li><a href="../../Main Page/index.php">Home</a></li>
                    <li><a href="/html/Main Page/index.html/#products">Our Products</a></li>
                    <li><a href="/html/admin panel/contactus/contact.html">Contact Us</a></li>
            </div>
            
        </div>
        <div class="right-nav">
            <div class="cart">
            <a href="../../cart/cart.php"><img src="../../../svgs/cart2.svg" alt=""></a>
            </div>
            <div class="user">
            <div class="change-img">
                <?php
                session_start();
                // echo $_SESSION['loggedin'];
                 if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
                    $email = $_SESSION['email'];
                    // echo $email;
                    $sql = "SELECT * from `register` WHERE email='$email'";   
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result); 
                        ?>
                        <img src="<?php echo '../../../uploads/'.$row['profilePic']; ?>" />
                        <?php
                    } 
                }else{?>
                        <img src="<?php echo '../../svgs/default.png' ?>" alt="">
                    <?php
                    }
                
                    ?>
               
                </div>
                    <ul>
                    <li><a href="../../signup and login/login.php">Login</a></li>
                        <li><a href="../../signup and login/signup.php">Sign Up</a></li>
                        <li><a href="../../signup and login/logout.php">Logout</a></li>
                        <li><a href="../../admin panel/addpost/addpost.php">Dashboard</a></li>
                    </ul>
            </div>
        </div>
    </nav>
    <!-- End of navigation -->
    <div class="container">
       <div class="inside-container">
        <div class="left-content">
        <div class="add-post">
        <button id="addpost"><a href="../addpost/addpost.php">Add Item</a></button>
            </div>
            <div class="Manage-post">
                <button id="addpost"><a href="../manage-post/manage.php">Manage Item</a></button>
            </div>
            <div class="orders">
                <button id="addpost"><a href="../order/order.php">Orders</a></button>
            </div>
            <div class="contactus">
                <button id="addpost"><a href="../manage user/manageuser.php">Users</a></button>
            </div>
        </div>
        <div class="right-content">
    <p>Manage User</p>
    <div class="select-user">
        <form method="POST" action="">
            <select name="users" id="" onchange="this.form.submit()">
                <option value="0">Please Choose User</option>
                <?php
                $sql = "SELECT firstName, lastName FROM register";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    echo '<option value="' . $firstName . ' ' . $lastName . '">' . $firstName . ' ' . $lastName . '</option>';
                }
                ?>
            </select>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['users'])) {
                $selectedUser = $_POST['users'];
                $sql = "SELECT firstName, lastName, email, phone, profilePic, isAdmin FROM register WHERE CONCAT(firstName, ' ', lastName) = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $selectedUser);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $selectedUserData = mysqli_fetch_assoc($result);
                mysqli_stmt_close($stmt);

                if ($selectedUserData) {
                    ?>
                    <table class="table table-striped" style="width:100%;">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Profile Picture</th>
                        </tr>
                        <tr>
                            <td><?php echo $selectedUserData['firstName']; ?></td>
                            <td><?php echo $selectedUserData['lastName']; ?></td>
                            <td><?php echo $selectedUserData['email']; ?></td>
                            <td><?php echo $selectedUserData['phone']; ?></td>
                            <td>
                                <img src="<?php echo '../../../uploads/' . $selectedUserData['profilePic']; ?>"
                                     alt="Profile Picture" width="70" height="70">
                            </td>
                        </tr>
                    </table>
                    <div class="makeAdmin">
                        <form method="post" action="">
                            <input type="hidden" name="selectedUser" value="<?php echo $selectedUser; ?>">
                            <input type="checkbox" name="admin" id="">Admin <br>
                            <button type="submit" name="saveButton" id="admin-btn">Save</button>
                        </form>
                    </div>
                    <?php
                } else {
                    ?>
                    <p>No user selected</p>
                    <?php
                }
            }
        }
        ?>
    </div>
</div>

<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['saveButton'])) {
        $selectedUser = $_POST['selectedUser'];
        $isAdmin = isset($_POST['admin']) ? 1 : 0;

        $sql = "UPDATE register SET isAdmin = ? WHERE CONCAT(firstName, ' ', lastName) = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "is", $isAdmin, $selectedUser);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if ($isAdmin) {
            echo '<script>
                alert("User is assigned admin");
            </script>';
        }
        else{
            echo '<script>alert("User is not assigned admin")</script>';
        }
    }
}
?>

       </div>
    </div>
    <script src="/html/admin panel/manage user/main.js"></script>
    </body>
</html>