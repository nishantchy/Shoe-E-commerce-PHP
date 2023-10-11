<?php
include "../databaseconnection/dbconnect.php";
$email_error=$password_error=$password_error1=NULL;
$error = NULL;
if(isset($_POST['submit'])){
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $hashedPass = md5($pass);
  

  if(empty($email)){
    $email_error = "Email field cannot be empty";
  }
  else if(empty($pass)){
    $password_error =  "Password field cannot be empty";
  }
  else{
    $sql = "SELECT * FROM `register` WHERE email='$email' AND password='$hashedPass'";
    $result = mysqli_query($conn, $sql);
    if($result){
        if(mysqli_num_rows($result)==1){
          $user = $result->fetch_assoc();
        $user_id = $user['id'];
            session_start();
            $_SESSION['loggedin']=true;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email']=$email;
            header("Location: ../Main Page/index.php");
        }
        else{
            $error = "Invalid details";
        }
      
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
    <title>Login</title>
   
    <link rel="stylesheet" href="style.css">
    <style>
      .error{
        display: none;
      }
    </style>
    <?php
    if($email_error!=NULL){
        ?> <style> .email-error{display:block;color:red;}</style> <?php
    }
    if($password_error!=NULL){
        ?> <style> .password-error{display:block;color:red;}</style> <?php
    }
    if($error!=NULL){
        ?> <style> .detail-error{display:block;color:red;}</style> <?php
    }

?>
  </head>
  <body>
    <div class="main-container">
        <div class="logo">
            <img src="../../svgs/logo-no-background.png" alt="">
        </div>
        <div class="form">
            <form action="" method="post">
                
                <div class="column1 email">
                    <label for="">Email Address</label>
                    <input type="text" name="email" id="b" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>">
                    <p class="error email-error"><?php echo $email_error ?></p>
                </div>
                
                <div class="column1 cpassword">
                    <label for="">Password</label>
                    <input type="password" name="pass" id="pass">
                    <p class="error password-error"><?php echo $password_error ?></p>
                    <p class="error password-error"><?php echo $password_error1 ?>
                </div>

                <div class="column submit">
                    <input type="submit" name="submit" value="Sign In" id="sub">
                </div>
                <div class="display">
                    <p class="error detail-error"><?php echo $error ?></p>
                </div>
            </form>
        </div>
        <div class="footer foot1">
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p> 
        </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
