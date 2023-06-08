<?php
$ferror=$error = $success = $lerror = $ferror1 = $lerror1 = $eError = $eError1 = $perror = $perror1 = $PassError = $PassError1 = $PassError2 = $fileError=$fileError1 = null;
include "../databaseconnection/dbconnect.php";
if(isset($_POST['submit'])){
    $firstName = $_POST['first'];
    $lastName = $_POST['last'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $nameExp = "/^([a-zA-Z' ]+)$/";
    $phoneExp = "/^[0-9]{10}+$/";
    $target_dir = "../../uploads/";
    $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);
    $img = basename($_FILES["fileUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if(empty($firstName)){
        $ferror = "Please enter First Name";
    }
    else if(empty($lastName)){
        $lerror =  "Please enter Last Name";
    }
    else if(!preg_match($nameExp, $firstName)){
        $ferror1 = "Only letters are allowed";
    }
    else if(!preg_match($nameExp, $lastName)){
        $lerror1 = "Only letters are allowed";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $eError1 =  "Invalid email address";
    }
    else if(empty($phone)){
        $perror = "Please enter your phone number";
    }
    else if(empty($email)){
        $eError = "Please enter your email address";
    }
    else if(empty($pass) && empty($cpass)){
        $PassError = "Passwords field cannot be empty";
    }
    else if(!preg_match($phoneExp, $phone)){
        $perror1 = "Invalid phone number";
    }
    else if(strlen($pass)<8){
        $PassError1 = "Atleast 8 characters required";
    }
    else if($pass !== $cpass){
        $PassError2 = "Passwords do not match";
    }
    else if($_FILES["fileUpload"]["size"]>500000000){
        $fileError1 = "Sorry, your file is too large"; 
        $uploadOk =0;
    }
    else if($imageFileType != "jpg" && $imageFileType !="png" && $imageFileType!="jpeg"){
        $fileError = "Sorry, only jpg, jpeg and png fles are allowed.";
        $uploadOk = 0;
    }
    else if($uploadOk==0){
        echo "Sorry, your file was not uploaded";
    }
    else{
        if(move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)){
            $sql = "INSERT INTO `register` (`firstName`, `lastName`, `email`, `phone`, `password`,`profilePic`) VALUES ('$firstName', '$lastName', '$email','$phone', md5('$pass'),'$img')";
            $result = mysqli_query($conn, $sql);
            if($result){
            $success = "Signed Up Successfully";
            }
            else{
            $error = "Error signing up";
            }
        }
        else{
            echo "Sorry, there was an error uploading the file";
        }
        
       
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
   
    <link rel="stylesheet" href="style.css">
    <style>
        .error{
            display: none;
        }
        .error1{
            display: none;
        }
    </style>
    <?php
    if($ferror!= NULL){
        ?> <style>.fname-error{display: block;color:red;}</style> <?php
    }
    if($lerror!= NULL){
        ?> <style>.lname-error{display: block;color:red;}</style> <?php
    }
    if($eError!= NULL){
        ?> <style>.email-error{display: block;color:red;}</style> <?php
    }
    if($perror!= NULL){
        ?> <style>.phone-error{display: block;color:red;}</style> <?php
    }
    if($PassError!= NULL){
        ?> <style>.pass-error{display: block;color:red;}</style> <?php
    }
    if($fileError!=NULL){
        ?> <style>.file-error{display: block;color:red;}</style> <?php
    }
    if($success!=NULL){
        ?> <style>.success{display: block;color:white;background-color:green;width:15%;text-align:center;margin:auto;border-radius:0.2rem;padding:0.7rem}</style> <?php
    }
    ?>
    <?php

    if($ferror1!= NULL){
        ?> <style>.fname-error1{display: block;color:red;}</style> <?php
    }
    if($lerror1!= NULL){
        ?> <style>.lname-error1{display: block;color:red;}</style> <?php
    }
    if($eError1!= NULL){
        ?> <style>.email-error1{display: block;color:red;}</style> <?php
    }
    if($perror1!= NULL){
        ?> <style>.phone-error1{display: block;color:red;}</style> <?php
    }
    if($PassError1!= NULL){
        ?> <style>.pass-error1{display: block;color:red;}</style> <?php
    }
    if($fileError1!= NULL){
        ?> <style>.file-error1{display: block;color:red;}</style> <?php
    }
    ?>
    <?php
    if($PassError2!= NULL){
        ?> <style>.pass-error2{display: block;color:red;}</style> <?php
    }
    ?>
   
  </head>
  <body>
    <div class="main-container">
        <div class="logo">
            <img src="../../svgs/logo-no-background.png" alt="">
        </div>
        <div class="success">
            <?php
            echo $success;
            ?>
        </div>
        <div class="form">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="column first-name">
                    <label for="">First Name</label>
                    <input type="text" name="first" id="fname" value="<?php if(isset($_POST['first'])) echo $_POST['first'];?>">
                    <p class="error fname-error"><?php echo $ferror ?></p>  
                    <p class="error1 fname-error1"><?php echo $ferror1 ?></p>  
                </div>
                <div class="column last-name">
                    <label for="">Last Name</label>
                    <input type="text" name="last" id="lname" value="<?php if(isset($_POST['last'])) echo $_POST['last'];?>">
                    <p class="error lname-error"><?php echo $lerror ?></p>  
                    <p class="error1 lname-error1"><?php echo $lerror1 ?></p> 
                </div>
                <div class="column email">
                    <label for="">Email Address</label>
                    <input type="text" name="email" id="email" width="10px" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>">
                    <p class="error email-error"><?php echo $eError ?></p>  
                    <p class="error1 email-error1"><?php echo $eError1 ?></p> 
                </div>
                <div class="column phone">
                    <label for="">Phone Number</label>
                    <input type="text" name="phone" id="phone" width="10px" value="<?php if(isset($_POST['phone'])) echo $_POST['phone'];?>">
                    <p class="error phone-error"><?php echo $perror ?></p>  
                    <p class="error1 phone-error1"><?php echo $perror1 ?></p> 
                </div>
                <div class="column password">
                    <label for="">Password</label>
                    <input type="password" name="pass" id="pass" value="<?php if(isset($_POST['pass'])) echo $_POST['pass'];?>"> 
                    <p class="error pass-error"><?php echo $PassError ?></p>  
                    <p class="error1 pass-error1"><?php echo $PassError1 ?></p> 
                </div>
                <div class="column cpassword">
                    <label for="">Confirm Password</label>
                    <input type="password" name="cpass" id="cpass">
                    <p class="error1 pass-error2"><?php echo $PassError2 ?></p> 
                </div>
                <div class="column file">
                    <input type="file" name="fileUpload" id="file">
                    <p class="error file-error"><?php echo $fileError ?></p> 
                    <p class="error1 file-error1"><?php echo $fileError1 ?></p> 
                </div>
                <div class="column submit">
                    <input type="submit" name="submit" value="Sign Up" id="sub" onclick="validation()">
                </div>
            </form>
        </div>
        <div class="footer">
            <p>Already have an account? <a href="login.php">login</a></p> 
        </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>
    <script src="/html/signup and login/main.js"></script>
  </body>
</html>

