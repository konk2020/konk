<?php

ini_set('display_errors', 1);

require_once "../mail.php";
require_once 'konkusersdb_connection.php';

if (isset($_POST["reset-request-submit"])) {

    // check to make sure the email sent over exists in the accouts table
    $conn = OpenCon();
    $userEmail = $_POST["email"];

    $sql = "SELECT * FROM accounts WHERE email='$userEmail' LIMIT 1";
    $result = $conn->query($sql);

    $row = $result->fetch_array();
                
    $userID = $row['username'];  

    if($result->num_rows == 0){
        header("Location: ../reset-password.php?email=noemailfound");
        exit(); 
    }


    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "http://localhost:8888/konk/create-new-password.php?selector=".$selector."&validator=".bin2hex($token);

    $expires = date("U") + 1800;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        exit();
    } else {
        // Delete from old token
        $sql = "DELETE from pwdReset WHERE pwdResetEmail='$userEmail'";
        $conn->query($sql); 

        // Inser into table toker for user's email
        $hashedToken = password_hash ($token, PASSWORD_DEFAULT);
        $sql = "INSERT INTO pwdReset(pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES ('$userEmail', '$selector', '$hashedToken', '$expires')";
        $conn->query($sql); 

    }

    CloseCon($conn);

    // prep email and send it
    $to = $userEmail;
    $subject = "Reset your password for Konk The Game";
    $message = '<p> We received a password reset request for username: <strong>'. $userID .'</strong>. The link to reset your password is below: <p><br>';
    $message .= '<a href="' . $url . '">' . $url. '</a></p>';

    // send the emmail code

    sendMail($to, $subject, $message);

    header("Location: ../reset-password.php?reset=success");


} else {

header("Location: ../index.php");

}