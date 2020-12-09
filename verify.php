<?php
    $con = mysqli_connect('localhost','root','','email_verification');
    $id = $_GET['id'];
    $token = $_GET['token'];
    $update = "UPDATE accounts SET verified = 'Active' WHERE id = '$id' AND token = '$token'";

    $result= mysqli_query ($con, $update);
    if($result){
        echo 'Your registration is successful, please <a href="login.php">Login</a>';
    }else{
        echo "Verify failed";
    }
?>