<?php
include "../databaseconnection/dbconnect.php";
?>
<?php
session_start();
if(isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT product_id,productName, price,details, productImage FROM products WHERE product_id = $product_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $_SESSION['product'] = $products; 
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <style>
      .img img{
    width: 100px;
}
.item-one {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
    width: 100%;
}

.btns{
    gap: 1rem;
}
.items{
    display: flex;
    flex-direction: column;
}
.fa-container{
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 10rem;
}
.fa-details p{
    width: 70%;
}
.name p{
    font-size: 25px;
    font-weight: 500;  
}
.order-btns {
    display: flex;
    gap: 1rem;
}

.btn-checkout {
        display: flex;
        justify-content: flex-end;
        padding: 40px;
        margin-left: auto;
}


/* .btn-success{
    background-color: #4CAF50;
    color: #fff;
    border: 0;
  }
  .btn-danger{
    background-color: red;
    color: #fff;
    border: 0;
  } */
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

    <div class="fa-container">
    <?php

        echo '<h1>Your Cart</h1>';
        ?><?php
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            foreach ($_SESSION['cart'] as $product) {
        echo '<div class="cart-contents">';
        ?>
         <div class="cart-img"><img src="../../uploads/<?php echo $product['productImage']; ?>" alt=""></div>
        <div class="p-name"> <?php echo $product['productName'] ?></div>
        <div class="action">
        <?php
            echo '<form action="../payment/payment.php?id=' . $product['product_id'] . '" method="post">'; 
        ?>
        
        <div class="product-price">
        <b>Rs.</b> <input type="text" name="price" size="3" value="<?php echo $product['price'];  ?>">
        </div>
        <div class="product-quantity">
            <b>Quantity:</b> <input type="number" name="quantity" min="1" max="10" value="1">
        </div>
        
        <div class="proceed">
        <input type="submit" name="submit" value="Proceed to checkout">
        </div>
        
        </form>
        <div class="remove"><?php echo '<a href="cart.php?remove=' .$product['product_id'] .'">Remove from cart</a>'?></div>
        </div>
        <?php
    }?>
</div>
</div>
<?php
    // echo '<a href="../payment/payment.php">Proceed to Checkout</a>';
} else {
    echo '<p>Your cart is empty.</p>';
}

// Check if remove from cart link has been clicked
if (isset($_GET['remove'])) {
    $productId = $_GET['remove'];

    // Remove the product from the cart
    foreach ($_SESSION['cart'] as $key => $product) {
        if ($product['product_id'] == $productId) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
}
?>

</div>

<script>
    function checkout(productId) {
        window.location.href = "../payment/payment.php?id=" + productId;
    }

</script>




</body>
</html>

