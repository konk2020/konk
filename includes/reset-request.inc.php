<?php

ini_set('display_errors', 1);

require_once "../mail.php";
require_once 'konkusersdb_connection.php';

if (isset($_POST["reset-request-submit"])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "http://localhost:8888/konk/create-new-password.php?selector=".$selector."&validator=".bin2hex($token);

    $expires = date("U") + 1800;

    $userEmail = $_POST["email"];

    $conn = OpenCon();

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
    
    





    //$sql = "DELETE from pwdReset WHERE pwdResetEmail=?";
  
    //$stmt = $conn->stmt_init();

  //  if (!mysqli_stmt_prepare($stmt, $sql)) {
     //if (!$stmt->prepare($sql)) { 
       // echo "There was an error";
        //exit();

    //} else {
 
      //  mysqli_stmt_bind_param($stmt,"s",$userEmail);
       // mysqli_stmt_execute($stmt);
   // }



/*

$sql = "INSERT INTO pwdReset(pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES ('$userEmail', '$selector', '$hashedToken', '$expires')";
$stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
        exit();

    } else {

        $hashedToken = password_hash ($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt,"ssss",$userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn); */



    $to = $userEmail;
    $subject = "Reset your password for Konk The Game";
    $message = '<p> We received a password reset request. The link to reset password is below: <p><br>';
    $message .= '<a href="' . $url . '">' . $url. '</a></p>';

    // send the emmail code

    sendMail($to, $subject, $message);

    header("Location: ../reset-password.php?reset=success");


} else {

header("Location: ../index.php");

}