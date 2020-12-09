<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
      $con = mysqli_connect('localhost','root','','email_verification');
      if(isset($_POST['login'])){
          $email = $_POST['email'];
          $pword = $_POST['password'];
          $select ="SELECT * FROM accounts WHERE email = '$email' AND password ='$pword' AND verified= 'Active'";
          $result = mysqli_query($con, $select);
          $count = mysqli_num_rows($result);

          if($count==1){
              header("location:welcome.php");
          }else{
              $msg = "Email and password does not exist";
          }
      }
      
?>
    
    <div class="form-container">
        <form action="" method="POST">
           <center>
                <?php
                    if(isset($msg)){
                        echo $msg;
                    }
                ?>
           </center>
            <input type="email" name="email" id="email" placeholder="Email" class="form-control" required>
            <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
            <div>
                <p>Don't have an account? <a href="index.php">Signup</a></p>
                <input type="submit"name="login" value="LogIn" class="btn btn-primary">
            </div>
            

            

        </form>

    </div>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>