<?php
include "../databaseconnection/dbconnect.php";
?>
<?php
  session_start();
//   if (isset($_SESSION['user_id'])) {
    if (isset($_GET['id'])) {
        $product_id = $_GET['id'];
        $sql = "SELECT product_id,productName, price,details, productImage FROM products WHERE product_id = $product_id";
        $result = $conn->query($sql);
        if ($result) {
           $product = $result->fetch_assoc();
           $orderProductName = $product['productName'];
           $orderPrice = $product['price'];
           $orderImage = $product['productImage'];
        //    $user_id = $_SESSION['user_id'];
   
        //    $insertSql = "INSERT INTO orders (user_id, o_name, o_price, o_image) VALUES ('$user_id','$orderProductName', $orderPrice, '$orderImage')";
           $insertSql = "INSERT INTO orders (o_name, o_price, o_image) VALUES ('$orderProductName', $orderPrice, '$orderImage')";
           $insertResult = $conn->query($insertSql);
   
           if ($insertResult) {
               // echo "Order details inserted successfully.";
           } else {
               echo "Error inserting order details: " . $conn->error;
           }
       } else {
           echo "Error fetching product details: " . $conn->error;
       }
   }
   
//   }
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
 /* footer{
    margin-top: 9.4rem;
 } */
 .order-info{
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20rem;
    margin-bottom: 6rem;
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
$total = $_POST['total'];
?>

<?php
date_default_timezone_set('UTC');
$currentDate = date('Y-m-d');
$futureDate = date('Y-m-d', strtotime($currentDate . ' +2 days'));

?>

           <div class="order-info">
              <p>Your total is Rs. <?php echo $total ?> and you will receive your order in <?= $futureDate?>.</p>
           </div>



<!-- Footer -->
<!-- <footer>
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
    </footer> -->
</body>
</html>