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






    </style>
</head>
<body>
    <nav id="navigation">
        <div class="logo"><a href="index.php"><img src="../../svgs/logo-no-background.svg" alt=""></a></div>
        <div class="menu">
            <div class="search-bar">
                <li><form action="../search/search.php" method="get">
                <li><input type="text" placeholder="Search" name="search" id=""></li>
                <button type="submit"><img src="../../svgs/icons8-search.svg" alt=""></button>
                </form></li>
            </div>
            <div class="list">
                <ul class="list-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#ourproducts">Our Products</a></li>
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
    <div class="welcome" id="welcome">
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && !isset($_SESSION['welcome_msg_displayed'])) {
        $email = $_SESSION['email'];
        $sql = "SELECT * FROM `register` WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $msg = 'Logged in as ' . $row['firstName'] . ' ' . $row['lastName'];
            ?>
            <p><?php echo "$msg"; ?><button id="cross">X</button></p>
            <?php
        }
        $_SESSION['welcome_msg_displayed'] = true;
    }
    ?>
    <script>
        const successMsg = document.getElementById('welcome');
        const cross = document.getElementById('cross');
        function disable() {
            successMsg.style.display = "none";
        }
        cross.onclick = () => disable();
    </script>
</div>

    <div class="display_page">
        <div class="img-slides">
            <div class="first-img">
                <div class="scroll-btn">
                    <button id="left"><img src="../../svgs/lessthan.svg" alt=""></button>
                </div>
                <div class="img-part"><img src="../../images/bgimgright.png" alt=""></div>
                <div class="cont">
                    <p class="line1">Let our</p>
                    <p class="line2">Design</p>
                    <p class="line1">Decide</p>
                    <p class="line2">your mood.</p>
                </div>
            </div>
        </div>       
        <div class="img-slides2">
            <div class="first-img">
                <div class="img-part"><img src="../../images/bgimg2.png" alt=""></div>
                <div class="cont">
                    <p class="line1">Try the</p>
                    <p class="line2">Best in the</p>
                    <p class="line1">Market</p>
                </div>
                <div class="scroll-btn">
                    <button id="right"><img src="../../svgs/greaterthan.svg" alt=""></button>
                </div>
            </div>
        </div>       
    </div>
    
    <!-- display page end -->
    <div class="items-page">
  <p class="our-products" id="ourproducts">OUR PRODUCTS</p>
  <div class="product-container">
    <?php
    $sql = "SELECT product_id, productName, price, productImage FROM products";
    $result = $conn->query($sql);
    $products = array();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $products[] = $row;
      }
    }

    // Generate HTML code for each product
    if (!empty($products)) {
      foreach ($products as $product) {
        echo '<div class="item-one">';
        echo '<div class="product-img">';
        echo '<img src="../../uploads/' . $product["productImage"] . '" alt="">';
        echo '</div>';
        echo '<div class="details">';
        echo '<p class="head">' . $product["productName"] . '</p>';
        echo '<p class="price">Rs. ' . $product["price"] . '</p>';
        echo '<button class="buy"><a href="../buynow/buynow.php?id=' . $product["product_id"] . '">View details</a></button>';
        echo '</div>';
        echo '</div>';
      }
    } else {
      echo "0 results";
    }
    ?>
  </div>
</div>

        <!-- <div class="next-page">
            <button class="one"><a href="index.php">1</a></button>
            <button class="two"><a href="secondpage.php">2</a></button>
        </div> -->
        </div>
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
    <script src="script.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>
    <script>
        // sliding image
const left = document.getElementById('left');
const right = document.getElementById('right');
const imgSlides2 = document.querySelector('.img-slides2');
const imgSlides1 = document.querySelector('.img-slides');

function leftslider(){
    imgSlides2.style.transitionDuration = "0.5s";
    imgSlides2.style.display = "block";
    imgSlides1.style.display = "none";
  
}

function rightslider(){
    imgSlides2.style.display = "none";
    imgSlides1.style.display = "block";
    imgSlides2.style.transitionDuration = "0.5s";
}

left.onclick=()=>leftslider()
right.onclick=()=>rightslider()
    </script>
</body>
</html>