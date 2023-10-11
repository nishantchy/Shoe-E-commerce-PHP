<?php
include "../databaseconnection/dbconnect.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hamro Jutta</title>
    <link rel="stylesheet" type="text/css" href="../Main Page/style.css">
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
    crossorigin="anonymous"
  />
    <style>
  
.user ul{
    position: absolute;
    top: 120%;
    right: 0;
    display: flex;
    flex-direction: column;
    box-shadow: 0 3rem 3rem rgba(0,0,0,0.4);
    visibility: hidden;
    opacity: 0;
    transition: all 300ms ease;
    background-color: #868383;
    padding: 0.3rem 1rem;
    border-radius: 0.7rem;
}


.user:hover > ul{
    visibility: visible;
    opacity: 1;
}
.change-img{
    background-color: #233565;
    border-radius: 50%;
    padding: 0.1rem;
    margin-left: 3px;
}
#products{
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 3rem;
}
.product-container {
    gap: 0.5rem;
    flex-wrap: wrap;
}
.no-result{
    text-align: center;
    margin-top: 3rem;
    margin-right: 4rem;
}

    </style>
</head>
<body>
    <nav id="navigation">
        <div class="logo"><a href="../Main Page/index.php"><img src="../../svgs/logo-no-background.svg" alt=""></a></div>
        <div class="menu">
            <div class="search-bar">
                <li><form action="../search/search.php" method="get">
                <li><input type="text" placeholder="Search" name="search" id=""></li>
                <button type="submit"><img src="../../svgs/icons8-search.svg" alt=""></button>
                </form></li>
            </div>
            <div class="list">
                <ul class="list-menu">
                    <li><a href="../Main Page/index.php">Home</a></li>
                    <li><a href="../Main Page/index.php">Our Products</a></li>
                    <li><a href="../contact us/contact.php">Contact Us</a></li>
            </div>
        </div>
        <div class="right-nav">
            <div class="cart">
                <a href="../cart/cart.php"><img src="../../svgs/cart.svg" alt=""></a>
            </div>
            <div class="user">
                <div class="change-img">
                <?php
                session_start();
                // echo $_SESSION['loggedin'];
                 if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=true){
                    $email = $_SESSION['email'];
                    // echo $email;
                    $sql = "SELECT * from `register` WHERE email='$email'";   
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result); 
                        ?>
                        <img src="<?php echo '../../uploads/'.$row['profilePic']; ?>" />
                        <?php
                    } 
                }else{?>
                        <img src="<?php echo '../../uploads/default.png' ?>" alt="">
                    <?php
                    }
                
                    ?>
               
                </div>
                
                    <ul>
                        <li><a href="../signup and login/login.php">Login</a></li>
                        <li><a href="../signup and login/signup.php">Sign Up</a></li>
                        <li><a href="../signup and login/logout.php">Logout</a></li>
                        <div id="dashboard">
                        <li><a href="../admin panel/addpost/addpost.php">
                        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
                         $email = $_SESSION['email'];
                         $sql = "SELECT * from `register` WHERE email='$email'";
                         $result = mysqli_query($conn, $sql);
                         if(mysqli_num_rows($result) > 0) {
                         $row = mysqli_fetch_assoc($result); 
                         if($row['isAdmin']==1){
                            echo "Dashboard";
                            echo "<script>document.getElementById('dashboard').style.display = 'block';</script>";
                         }
                         else{
                            echo "<script>document.getElementById('dashboard').style.display = 'none';</script>";
                         }
                         ?>
                         <?php
                         }}?></a></li>
                        </div>
                    </ul>
            </div>
        </div>
    </nav>
    <!-- End of Navigation -->
    <div class="search-container">
    <?php
    
    if (isset($_GET['search'])) {
        $searchTerm = $_GET['search'];
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM products WHERE productName LIKE '%$searchTerm%'";
    
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product = $row;
                echo "<div class='product'>";?>
                 <div class="search-img"><img src="<?php echo '../../uploads/'.$row['productImage']; ?>" /></div>
                 <div class="search-content">
                 <?php
                echo "<h3>" . $row['productName'] . "</h3>";
                echo "<p>" . $row['details'] . "</p>";
                echo '<p class="price">Rs. ' . $product["price"] . '</p>';
                echo '<button class="buy-specific"><a href="../buynow/buynow.php?id=' . $product["product_id"] . '">View details</a></button>';
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo '<p class="no-result">Result not found</p>';
        }
        $conn->close();
    } else {
        echo "Please enter a search term.";
    }
    
    
    ?>
    </div>

</body>
</html>