<?php
include "../databaseconnection/dbconnect.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav id="navigation">
        <div class="logo"><a href="../Main Page/index.php"><img src="../../svgs/logo-no-background.svg" alt=""></a></div>
        <div class="menu">
            <div class="search-bar">
                <li><input type="text" placeholder="Search" name="" id=""></li>
                <li><form action="" method="get">
                <button type="submit"><img src="../../svgs/icons8-search.svg" alt=""></button>
                </form></li>
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

<!-- Main Content -->
    <p class="intro">Khalti Mobile Wallet</p>
    <div class="container">
        <div class="payments">
            <div class="khalti">
                <a href=""><img src="../../svgs/khalti-seeklogo.com.svg" alt=""></a>
                <p>Khalti Wallet</p>
            </div>  
    </div>
                        </div>
    <div class="form-section">
    <div class="khalti-id">
        <input type="text" name="id" id="" placeholder="khalti Id">
    </div>
    <div class="khalti-name">
        <input type="text" name="name" id="" placeholder="Khalti Username">
    </div>
    <div class="pay">
        <input type="submit" name="submit" id="" value="Pay Now">
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