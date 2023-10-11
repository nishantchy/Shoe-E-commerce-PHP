<?php
// include "../../databaseconnection/dbconnect.php";
$server = "localhost";
$username = "root";
$password = "";
$dbname = "fourthsem";

$conn = mysqli_connect($server, $username, $password, $dbname);


?>


<?php 
$success = $error = $uploadError = $fileError1 = $fileError = $error1 = $priceError = $priceError1= $titleError=null;
if(isset($_POST['submit'])){
    $title = htmlspecialchars($_POST['title']);
    $price = $_POST['price'];
    $details = htmlspecialchars($_POST['details']);
    $target_dir = "../../../uploads/";
    $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);
    $img = basename($_FILES["fileUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if(empty($title)){
        $titleError = "Please fill title";
    }
    else if(empty($price)){
        $priceError1 = "Fill price section";
    }
    else if($price < 0){
        $priceError = "Price cannot be negative";
    }
    
    else if($_FILES["fileUpload"]["size"]>500000000){
        $fileError1 = "Sorry, your file is too large"; 
        $uploadOk =0;
    }
    else if($imageFileType != "jpg" && $imageFileType !="png" && $imageFileType!="jpeg"){
        $fileError = "Sorry, only jpg, jpeg and png files are allowed.";
        $uploadOk = 0;
    }
    else if($uploadOk==0){
        $uploadError = "Sorry, your file was not uploaded";
    }
    
    else{
        if(move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)){
           $sql = "INSERT INTO `products` (`productName`, `price`, `details`, `productImage`) VALUES ('$title', '$price', '$details','$img')";
           $result = mysqli_query($conn, $sql);
            if($result){
            $success = "Product Added Successfully";
            }
            else{
            $error = "Error adding product";
            }
        }
        else{
            $error1 = "Sorry, there was an error uploading the file";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .success{
            display: none;
        }
        .user .change-img img{
    border-radius: 50%;
    width: 40px;
    height: 40px;
    object-fit: cover;    
 }
 .change-img{
    background-color: #dedede;
    border-radius: 50%;
    padding: 0.1rem;
    margin-left: 3px;
}
.error{
    display: none;
    color: red !important;
    font-size: 16px !important;
    margin-top: -8px !important;
}
.error1{
    display: none;
    color: red !important;
    font-size: 16px !important;
    margin-top: -7px !important;
}
.orders button{
    padding: 2rem 3rem;
}
.contactus button{
    padding: 2rem 2.7rem;
}
    </style>
    <?php
    if($success!=NULL){
        ?> <style>.success{display: block;color:white;background-color:green;width:15%;text-align:center;margin:auto;border-radius:0.2rem;padding:0.7rem}</style> <?php
    }
    if($error!= NULL){
        ?><?php echo "<script>alert('$error')</script>" ?> <?php
    }
    if($error1!= NULL){
        ?><style>.error1{display: block;color:red;}</style><?php
    }
    if($titleError!= NULL){
        ?><style>.error{display: block;color:red;}</style><?php
    }
    if($fileError!= NULL){
        ?><style>.error{display: block;color:red;}</style></style> <?php
    }
    if($fileError1!= NULL){
        ?><style>.error1{display: block;color:red;}</style><?php
    }
    if($uploadError!= NULL){
        ?><style>.error1{display: block;color:red;}</style><?php
    }
    if($priceError1!= NULL){
        ?> <style>.error1{display: block;color:red;}</style> <?php
    }
    if($priceError!= NULL){
        ?><style>.error{display: block;color:red;}</style> <?php
    }
    
    ?>
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
                    <li><a href="../Main Page/index.php">Our Products</a></li>
                    <li><a href="../contactus/contact.php">Contact Us</a></li>
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
    <div class="success">
        <?php
        echo $success;
        echo $error;
        ?>
    </div>
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
                <button id="addpost"><a href="../manage user/manageuser.php">Users</a></button>
            </div>
            <div class="contactus">
                <button id="addpost"><a href="../order/order.php">Orders</a></button>
            </div>
        </div>
        <div class="right-content">
            <p>Add Item</p>
            <div class="form-section">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="title">
                        <label for="">Title</label>
                    <input type="text" name="title" id="" class="title-border" value="<?php if(isset($_POST['title'])) echo $_POST['title'];?>">
                    <p class="error"><?php echo $titleError ?></p>
                    </div>
                    <div class="price">
                        <label for="">Price</label>
                    <input type="text" name="price" id="" class="price-border"value="<?php if(isset($_POST['price'])) echo $_POST['price'];?>">
                    <p class="error"><?php echo $priceError ?></p>
                    <p class="error1"><?php echo $priceError1 ?></p>
                    </div>
                    <div class="details">
                        <label for="">Details</label>
                        <textarea name="details" id="" cols="5" rows="5" class="details-border"></textarea>
                    </div>
                    <div class="file">
                        <input type="file" name="fileUpload" id="">
                        <p class="error"><?php echo $fileError ?></p>  
                    <p class="error1"><?php echo $fileError1 ?></p>
                    <p class="error1"><?php echo $uploadError ?></p>
                    <p class="error1"><?php echo $error1 ?></p>
                    </div>
                    <div class="save-post">
                        <input type="submit" name="submit" value="Add Item" id="">
                    </div>
                </form>
            </div>
        </div>
       </div>
    </div>
    <script src="/html/admin panel/addpost/main.js"></script>
    </body>
</html>
