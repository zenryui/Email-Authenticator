<?php
session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendemail_verify($name, $email, $verify_token)
{
    $mail = new PHPMailer(true);

        //Server settings
        // $mail->SMTPDebug = 2;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        
        $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
        $mail->Username   = 'user@example.com';                     //SMTP username
        $mail->Password   = 'secret';                               //SMTP password

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress('ellen@example.com');               //Name is optional
        
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email verification from Funda of Web IT';
        
        $email_template = "
            <h2>You have Registered with us</h2>
            <h5>Please click the link below to verify your account</h5>
            <br/><br/>
            <a href='http://localhost/register-login-with-verification/verify-email.php?token=$$verify_token'> Click Me </a>
        ";

        $mail->Body    = $email_template;
        $mail->send();
        // echo 'Message has been sent';


}

if(isset($_POST['register_btn']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verify_token = md5(rand());

    sendemail_verify("$name", "$email", "$verify_token");
    echo "sent or not ?";

    // // Email Exists or not
    // $check_email_query = "SELECT email FROM users where email='$email' LIMIT 1";
    // $check_email_query_run = mysqli_query($con, $check_email_query);

    // if(mysqli_num_rows($check_email_query_run) > 0)
    // {
    //     $_SESSION['status'] = "Email Id already Exists";
    //     header('Location: register.php');
    // }
    // else
    // {
    //     // Insert User / Registered User Data
    //     $query = "INSERT INTO users (name, phone, email, password, verify_token) VALUES ('$name', '$phone', '$email', '$password', '$verify_token')";
    //     $query_run = mysqli_query($con, $query);
    
    // if($query_run)
    // {
    //     sendemail_verify("$name", "$email", "$verify_token");

    //     $_SESSION['status'] = "Registration Successfull.! Please verify your Email Address.";
    //     header('Location: register.php');
    // }
    // else
    // {
    //     $_SESSION['status'] = "User Not Registered";
    //     header('Location: register.php');
    // }
    // }

}

?>