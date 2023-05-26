<?php
include "../databaseconnection/dbconnect.php";
?>
    <?php

session_start();
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT product_id, productName, price, details, productImage FROM products WHERE product_id = $product_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        array_push($_SESSION['cart'], $product);
    } else {
        echo "Product not found.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
    crossorigin="anonymous"
  />
</head>
<body>
    <nav id="navigation">
        <div class="logo"><a href="../Main Page/index.php"><img src="../../svgs/logo-no-background.svg" alt=""></a></div>
        <div class="menu">
            <div class="search-bar">
                <li><input type="text" placeholder="Search" name="" id=""></li>
                <li><button><img src="../../svgs/icons8-search.svg" alt=""></button></li>
                </ul>
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
                <a href="cart.php"><img src="../../svgs/cart.svg" alt=""></a>
            </div>
            <div class="user">
                <div class="change-img">
                <?php
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

<div class="cart-container">
<?php
function displayCartItems() {
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        foreach ($_SESSION['cart'] as $product) {
            echo '<div class="cart-item">';
            echo '<input type="checkbox" class="checkbox">';
            echo '<img src="../../uploads/' . $product['productImage'] . '" alt="">';
            echo '<div class="details">';
            echo '<h4>' . $product['productName'] . '</h4>';
            echo '<p>Rs. ' . $product['price'] . '</p>';
            echo '</div>';
            echo '<div class="quantity">
            <input class="text-center" type="number" min="1" max="10" value="1" name="quantity">
            </div>';
            echo '</div>';
        }
    } else {
        echo "<p class='empty'>Your cart is empty.</p>";
    }
}
?>
<div class="cart-items-container">
    <?php displayCartItems(); ?>
</div>
   <div class="buy-button">
            <button id="buy-now">Proceed to checkout</button>
            <button id="cancel">Cancel</button>
    </div>
    </div>
</body>
</html>

