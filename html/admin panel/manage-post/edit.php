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
    $title = $_POST['title'];
    $price = $_POST['price'];
    $details = $_POST['details'];
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
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                   $productId = $row['product_id'];
            $sql = "UPDATE `products` SET `productName` = '$title', `price` = '$price', `details` = '$details', `productImage` = '$img' WHERE `product_id` = $productId";
           $result = mysqli_query($conn, $sql);
            if($result){
            $success = "Product Edited Successfully";
            }
            else{
            $error = "Error Editing product";
            }
        }}
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
    <title>Edit Item</title>
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
.edit-form{
    width: 18%;
    margin: 0.3rem auto;
    display: flex;
    justify-items: center;
    align-items: center;
}
.title p{
    color: #233565;
    font-size: 35px;
    text-align: center;
    font-weight: bold;
}
.error{
    display: none;
}
.error1{
    display: none;
}
.success{
    display: none;
}
    </style>

    <style>
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

    <!-- END of Navigation -->
    <div class="title">
        <p>Edit Page</p>
    </div>
    <div class="edit-form">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="title">
            <label for="">Title</label>
            <input type="text" name="title" id="">
            <p class="error"><?php echo $titleError ?></p>
            </div>
            <div class="price">
            <label for="">Price</label>
            <input type="text" name="price" id="">
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
             <input type="submit" name="submit" value="Edit Item" id="">
            </div>
        </form>
    </div>
    </body>
    </html>