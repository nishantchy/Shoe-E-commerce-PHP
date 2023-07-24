<?php
include "../databaseconnection/dbconnect.php";
?>
<?php
  session_start();
 if (isset($_GET['id'])) {
     $product_id = $_GET['id'];
     $sql = "SELECT product_id,productName, price,details, productImage FROM products WHERE product_id = $product_id";
     $result = $conn->query($sql);
     if ($result->num_rows > 0) {
         $product = $result->fetch_assoc(); 
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
    <title>Payment</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .user .change-img img{
    border-radius: 50%;
    width: 40px;
    height: 40px;
    object-fit: cover;    
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

<!-- Main Content -->
<?php  
$total = $_POST['price'] * $_POST['quantity']; 
?>

    <p class="intro">Select Payment Method</p>
    <div class="container">
        <div class="payments">
            <div class="esewa">
            <?php echo '<form action="../payment/stripe.php?id=' . $product['product_id'] . '" method="post">'; ?>
            <img src="../../svgs/stripe.svg" alt="">
            <p>Stripe</p>
            <input type="hidden" name="total" value="<?php echo $total; ?>">
            <?php
            echo '<input type="submit" name="submit" value="Pay through Stripe" id="buynow">';
            echo '</form>';
            ?>
            </div>
            <div class="cash">
                <img src="../../svgs/cash-on-delivery.png" alt="">
                <?php echo '<form action="../payment/cashond.php?id=' .$product['product_id'] . '" method="post">'; ?>
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <p>Cash on delivery</p>
                <?php echo '<input type="submit" name="submit" value="Cash On Delivery" id="buynow">';?>

                </form>
                
            </div>
        </div>
        <div class="summary">
            <p class="head">Order Summary</p>
            <p class="amount">Total Amount: Rs.  <input type="text" name="total" id="" value="<?php echo $total ?>"></p>
        </div>
    </div>
   <!-- Footer -->
   <footer>
        <div class="follow">
            <p>Follow Us</p>
        </div>
        <div class="icons">
            <div class="fb"><img src="../../svgs/icons8-facebook-circled.svg" alt=""></div>
            <div class="fb"><img src="../../svgs/icons8-instagram.svg" alt=""></div>
        </div>
        <div class="foot-contact">
            <p>hamrojutta.nepal.com</p>
            <p>01-4323232</p>
            <p>9868211546, 9843211483</p>
            <p>&copy;Nishant and Ganesh</p>
        </div>
    </footer>
</body>
</html>