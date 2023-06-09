<?php
// include "../../databaseconnection/dbconnect.php";
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
    <title>Orders</title>
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
                <li><input type="text" placeholder="Search" name="" id=""></li>
                <li><button><img src="../../../svgs/icons8-search.svg" alt=""></button></li>
                </ul>
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
        <p>Order Details</p> 
        <div class="table-section">
            <table id="example" class="table table-striped" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Product Details</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nishant</td>
                                <td>Nike Air Force</td>
                                <td>4000</td>
                            </tr>
                            <tr>
                                <td>Nike Shoes</td>
                                <td>Nike Air Force</td>
                                <td>3000</td>
                            </tr>
                            <tr>
                                <td>Nike Shoes</td>
                                <td>Nike Air Force</td>
                                <td>2000</td>
                            </tr>
                            <tr>
                                <td>Nike Shoes</td>
                                <td>Nike Air Force</td>
                                <td>3000</td>
                            </tr>
                           
                            </tbody>
                            </table>
        </div>
    </div>
    </div>
</div>
<script src="/html/admin panel/order/main.js"></script>
    </body>
</html>