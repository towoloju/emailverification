<?php


    require('PHPMailer/PHPMailerAutoload.php');
    require('credentials.php');
  
    $error= NULL;

?>

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

    if(isset($_POST['submit'])){
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $email= $_POST['email'];
        $pword = $_POST['password'];
        $cpword = $_POST['cpassword'];
        $token = md5(rand(10000,99999));
        $verified = "inactive";

        if($pword !== $cpword){
            $error = "<p style='color : red';>Passwords dont match</p>";
        }else{
            $insert = "INSERT INTO accounts (firstname, lastname, email, password, token, verified) 
            VALUES ('$fname', '$lname', '$email', '$pword', '$token', '$verified')";
            $result = mysqli_query($con,$insert);
            $last_id = mysqli_insert_id($con);
            $url = 'http://'.$_SERVER['SERVER_NAME'].'/emailverification/verify.php?id='.$last_id.'&token='.$token;
            $output = '<div>Thanks for signing up, please click the link below to activate your account.' .$url. 
            '<br> This link would expire in 1 hour </div>';

            if($result==true){
                
         
                date_default_timezone_set('Etc/UTC');
                $mail = new PHPMailer;

                //$mail->SMTPDebug = 3;                               // Enable verbose debug output

                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';
                 // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = EMAIL;                 // SMTP username
                $mail->Password = PASSWORD;                           // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;  
                //$mail->SMTPDebug = SMTP::DEBUG_CONNECTION;  
                // $mail->SMTPOptions = array(
                //     'ssl'=>array(
                //         'verify_peer'=> false,
                //         'verify_peer_name' => false,
                //         'allow_self_signed' => true
                //     )
                // );                              // TCP port to connect to

                $mail->setFrom(EMAIL, 'Apple & Gold');
                $mail->addAddress($email, $lname);     // Add a recipient
                // $mail->addAddress('ellen@example.com');               // Name is optional
                // $mail->addReplyTo('info@example.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                $mail->isHTML(true);                                  // Set email format to HTML

                

                $mail->Subject = 'Account Verification';
                $mail->Body    = $output;
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    if(!$mail->send()) {
                        echo 'Message could not be sent.';
                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                    } else {
                        $msg = "Congratulations, your registration is successful. We've sent an activation link to  " .$email.  ". ";
                    }
            }
        }
    }
    
    
    ?>

    <div class="form-container">
        <div class ="alert alert-successful">
            <?php
                if(isset($msg)){
                    echo $msg;
                }
            ?>
        </div>
    
        <form method="POST" action="">
            <input type="text" name="firstname" id="firstname" placeholder="Firstname" class="form-control" required>
            <input type="text" name="lastname" id="lastname" placeholder="Lastname" class="form-control" required>
            <input type="email" name="email" id="email" placeholder="Email" class="form-control" required>
            <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
            <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" class="form-control" required>
            <?php
                echo $error;
            ?>
            <div>
                <p>Already have an account? <a href="login.php">Login</a></p>
                <input type="submit" name="submit" value="SignUp" class="btn btn-primary">
            </div>
            

            

        </form>
      
           
            
        
    </div>

    
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>  
</body>

</html>