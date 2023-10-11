<?php
include "../databaseconnection/dbconnect.php";
?>

<?php
session_start();
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
    $sql = "SELECT product_id, productName, price, details, productImage FROM products WHERE product_id = $product_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $_SESSION['product'] = $product;
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if the product is already in the cart
        $productExists = false;
        foreach ($_SESSION['cart'] as $cartProduct) {
            if ($cartProduct['product_id'] == $product_id) {
                $productExists = true;
                break;
            }
        }

        if (!$productExists) {
            // Add the quantity to the product array
            $product['quantity'] = $quantity;
            array_push($_SESSION['cart'], $product);
        } else {
            echo "Product is already in the cart.";
        }
    } else {
        echo "Product not found.";
    }
}
?>

<!-- Rest of the code remains the same -->




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hamro Jutta</title>
    <link rel="stylesheet" href="style.css">
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
 nav{
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 3rem;
    box-shadow: 0.5px 0.5px 8px 0.5px;
    width: 100%;
    position: fixed;
    top: 0;
    background-color: #233565;
}
nav ul li a{
    text-decoration: none;
    color: #fff;
}
.product{
    margin-top: 6rem;
}
#buynow{
    padding: 0.2rem;
    border: 2px solid black;
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
    
    <section class="product">
    <div class="fa-product">
        <div class="product-img">
            <img src="../../uploads/<?php echo $product['productImage']; ?>" alt="">
        </div>
        <div class="product-details">
            <div class="description">
                <p class="header"><?php echo $product['productName']; ?></p>
                <p class="price"><?php echo $product['details']; ?></p>
                <div class="quantity">
                <?php echo '<form action="../payment/payment.php?id=' . $product['product_id'] . '" method="post">'; ?>
                <!-- <p class="price">Rs. <?php echo $product['price']; ?></p> -->
                <input type="text" name="price" id="" value="<?php echo $product['price'];  ?>">
                Quantity: <input type="number" name="quantity" min="1" max="10" value="1" placeholder="1" onchange="updateQuantity()"><br>
                <input type="hidden" name="selected_quantity" value="1">
                </div>
                
            </div>
            <div class="main-btns">
                <div class="buy-now">
                    <input type="submit" name="submit" value="Buy Now" id="buynow">
                </div>
            </form>
                <div class="addtocart">
                    <?php echo '<form action="../cart/cart.php?id=' .$product['product_id'] .'" method="post" >'; ?>
                        <input type="submit" name="add" value="Add to Cart" id="addtocart">
                    </form>
                    </div>
            </div>
                <?php
                // echo '<button type="submit" class="buy" name="add">Add to Cart</button>';
                
                // echo '<button type="submit" class="buy" name="add" onclick="addToCart(\'?id=' . $product['product_id'] . '\');">Add to Cart</button>';   
                // echo '<script>
                // function addToCart(productId) {
                // const btn = document.querySelector(".buy");
                // document.getElementById("greencheck").style.display = "block";
                // btn.innerText = "Added to Cart ";
                // }
                // </script>';
?>

            </div>
            
            
                </div>
        </div>
    </div>
    <script>
function updateQuantity() {
    const quantityInput = document.querySelector('input[name="quantity"]');
    const selectedQuantityInput = document.querySelector('input[name="selected_quantity"]');
    
    // Update the hidden input with the selected quantity
    selectedQuantityInput.value = quantityInput.value;
}
</script>
</section>


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
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>
    <script src="main.js"></script>
</body>
</html>