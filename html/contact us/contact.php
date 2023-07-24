<?php
include "../databaseconnection/dbconnect.php";
?>
<?php
$success = $error = $nameErr = $emailErr = $emailErr1 = null;
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    if(empty($name)){
        $nameErr = "Please fill your name"; 
    }
    else if(empty($email)){
        $emailErr = "Please fill your email";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailErr1 = "Invalid email";
    }
    else{
        $sql = "INSERT INTO `message` (`name`, `email`, `message`) VALUES ('$name', '$email', '$message')";
    $result = mysqli_query($conn, $sql);
    if($result){
        $success = "Message sent successfully";
    }
    else{
        $error = "Error sending message";
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
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
      crossorigin="anonymous"
    />
    <?php
    if($error!= NULL){
        ?> <style>.error{display: block;color:red;}</style> <?php
    }
    if($nameErr!= NULL){
        ?> <style>.name-error{display: block;color:red;}</style> <?php
    }
    if($emailErr!= NULL){
        ?> <style>.email-error{display: block;color:red;}</style> <?php
    }
    if($emailErr1!= NULL){
        ?> <style>.email-error1{display: block;color:red;}</style> <?php
    }
    if($success!= NULL){
        ?> <style>.success{display: block;color:white;background-color: green;width:90%;text-align:center;margin:auto;border-radius:0.2rem;padding:0.7rem; color: white; font-size: 15px;}</style> <?php
    }?>
    <style>
        .change-img{
    background-color: #233565;
    border-radius: 50%;
    padding: 0.1rem;
    margin-left: 3px;
}
.user .change-img img{
    border-radius: 50%;
    width: 40px;
    height: 40px;
    object-fit: cover;    
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
.container{
    margin-top: 6rem;
}
.user{
    position: relative;
    cursor: pointer;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    /* overflow: hidden; */
}
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
    background: #dedede;
    padding: 0.3rem 1rem;
    border-radius: 0.7rem;
}

.user ul li{
    font-size: 20px;
    margin-bottom: 2px;
    border-bottom: 1px solid #233565;
}

.user:hover > ul{
    visibility: visible;
    opacity: 1;
}
.search-bar button{
    padding: 0.45rem 0.6rem;
}
        /* .error{
            display: none;
        }
        .success{
            display: none;
        } */
    </style>
    
</head>
<body>
    <nav>
        <div class="logo"><img src="../../svgs/logo-no-background.svg" alt=""></div>
        <div class="menu">
        <div class="search-bar">
                <li><form action="../search/search.php" method="get">
                <li><input type="text" placeholder="Search" name="search" id=""></li>
                <button type="submit"><img src="../../svgs/icons8-search.svg" alt=""></button>
                </form></li>
            </div>
            <div class="list">
                <ul>
                    <li><a href="../Main Page/index.php">Home</a></li>
                    <li><a href="../Main Page/index.php">Our Products</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
            </div>
            
        </div>
        <div class="right-nav">
            <div class="cart">
                <img src="/svgs/cart img.png" alt="">
            </div>
            <div class="user">
                <div class="change-img">
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
    <!-- End of navigation -->
    <div class="container">
       <div class="inside-container">
        <div class="right-content">
            <p>Leave Us Message</p>
            <section class="error"><?php echo $error ?></section>  
            <section class="success"><?php echo $success ?></section>  
            <div class="form-section">
                <form action="" method="post">
                    <div class="name">
                        <label for="">Name</label>
                    <input type="text" name="name" id="" class="name-border">
                    <span class="name-error"><?php echo $nameErr ?></span>  
                    </div>
                    <div class="email">
                        <label for="">Email</label>
                    <input type="text" name="email" id="" class="email-border">
                    <span class="email-error"><?php echo $emailErr ?></span>  
                    <span class="email-error1"><?php echo $emailErr1 ?></span>  
                    </div>
                    <div class="message">
                        <label for="">Message</label>
                        <textarea name="message" id="" cols="5" rows="5" class="msg-border"></textarea>
                    </div>
                    
                    <div class="send">
                        <input type="submit" name="submit" value="Send" id="">
                    </div>
                </form>
            </div>
        </div>
       </div>
    </div>
    <script src="/html/admin panel/main.js"></script>
    </body>
</html>

