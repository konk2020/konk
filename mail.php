<?php

//     ini_set('display_errors', 1);

require_once "phpmailer/vendor/autoload.php";

//use PHPMailer\PHPMailer\PHPMailer;


function sendMail($to, $subject, $message) {

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        //Enable SMTP debugging. 
//        $mail->SMTPDebug = 3;                               
        //Set PHPMailer to use SMTP.
        $mail->isSMTP();            
        //Set SMTP host name                          
        $mail->Host = "mail.konk.us";
        //Set this to true if SMTP host requires authentication to send email
        $mail->SMTPAuth = true;                          
        //Provide username and password     
        $mail->Username = "admin@konk.us";                 
        $mail->Password = "2019konk!";                           
        //If SMTP requires TLS encryption then set it
        $mail->SMTPSecure = "ssl";                           
        //Set TCP port to connect to 
        $mail->Port = 465;                                   

        $mail->From = "admin@konk.us";
        $mail->FromName = "Konk The Game Admin";

        //$mail->addAddress("richard@jvrtechllc.com", "Richard Negron");
        $mail->addAddress($to);

        $mail->isHTML(true);

        //$body = '<p><strong>Hello</strong> this is my first email with local PHP mailer</p>';
        $body = $message;

       // $mail->Subject = "Localhost Konk Mailer";
        $mail->Subject = $subject;
        

        $mail->Body = $body;

        //$mail->AltBody = strip_tags($body);

        if(!$mail->send()) 
        {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } 
        else 
        {
            //header('location:thankyou.php');
            header("Location: registration.php?email='$to'");
           // echo "Message has been sent successfully! We sent an email to ". $to;
        }
}