<?php
$error = NULL;

     //ini_set('display_errors', 1);

require_once "mail.php";

// use the correct URL based on protoco

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//echo $url; // Outputs: Full URL

$protocol_var = 'http:';
$host_var = 'konk.us';

if (strpos($url, $protocol_var) !== false and strpos($url, $host_var) !== false) {
  // verify.php is used for the email being send to the user
  $secure_url = 'https://konk.us/verify.php';

} else {
  $secure_url = 'http://localhost:8888/konk/verify.php';
    
  }


if (isset($_POST['submit'])){

    // Get form data
    $u = $_POST['u'];
    $p = $_POST['p'];
    $p2 = $_POST['p2'];
    $e = $_POST['e'];

    if (strlen($u) < 2 ){

        $error = "<p>Your username must be at least 2 characters!</p>";

    } elseif ($p2 !== $p){

        $error = "<p>Your passwords do not match!</p>";

    } elseif (strlen($p) < 5 ) {
        
        $error = "<p>Your password must be 5 or more characters!</p>";  

    } else {
        // Form is valid

        // Connect to the database
        $mysqli = NEW MySQLi ('localhost','root','root', 'konkusers');

        // Sanitize from data
        $u = $mysqli->real_escape_string($u);
        $p = $mysqli->real_escape_string($p);
        $p2 = $mysqli->real_escape_string($p2);
        $e = $mysqli->real_escape_string($e);
        

        // Generate Vkey

        $vkey = md5 (time().$u);

        //check to see if the username exists 

        $insert = $mysqli->query("SELECT * FROM accounts WHERE username = '$u'");
        if ($insert->num_rows > 0) {


                // username exists 
                //send an error to the user
                header("Location: registration.php?username=exists");
                
        } else {

                 // is a new username
                // Inset account into the database
                $p=md5($p);
                $insert = $mysqli->query("INSERT INTO accounts(username, password, email, vkey)
                VALUES('$u','$p','$e','$vkey')");

                if ($insert){
                    // Send EMail
                    $to = $e;
                    $subject = "Konk The Game Email Verification";
                    $message = "Great to know that you want to join Konk The Game player community <br>";
                    $message .= "In order to play the game you have to validate your account. Click link below to get started.<br>";
                    $message .= "<a href='".$secure_url."?vkey=$vkey'>Register Your Account</a>";
                    sendMail($to, $subject, $message);
                    //echo ("Success!");

                }else {

                    echo $mysqli->error;
                }

        }

    }

}

?>


<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">    
<form method="POST" action="">
<table border="0" align="center" cellpadding="5">

<tr>
<tr>
    <td colspan="2" style = "text-align:center;"> <a href="registration.php"><img src="images/konk_logo.jpg"></a>
 <br> <br>
    Create your account to play Konk The Game! <br> <a href="index.php"> Already have an account?</a>
    <br> <br>

</td>
   
</tr>

<tr>
    <td align="right">Username (min 2 chars):</td>
    <td><input type="TEXT" name="u" required/></td>
</tr>
<tr>
    <td align="right">Password (min of 5 chars):</td>
    <td><input type="PASSWORD" name="p" required/></td>
</tr>
<tr>
    <td align="right">Repeat Password:</td>
    <td><input type="PASSWORD" name="p2" required/></td>
</tr>
<tr>
    <td align="right">Email Address:</td>
    <td><input type="EMAIL" name="e" required/></td>
</tr>
<tr>
<td colspan="2" style = "text-align:center; color:red;">
<?php
// tell the user the username is already in used
if (isset($_GET["username"])) {
    if ($_GET["username"]== "exists") {
        echo '<p class="signupsuccess">That user name already exists!</p>';
        echo "<a href='index.php'>Go to Game</a>";
        
    }
} elseif (!empty($error)) {
    echo $error;

} elseif (isset($_GET["email"])) {

    // email
     echo '<p class="signupsuccess"> Success! We sent an email to: '. $_GET["email"] .' so you can validate your email.</p>';

}
?>

</td>
</tr>

<tr>
    <td colspan="2" style = "text-align:center;"><input type="SUBMIT"  class="submit" name="submit" value="Register to Play!" required/></td>
</tr>
<tr>
    <td colspan="2" style = "text-align:center; font:20px Aria;">&copy; Konk The Game | version 3.0</td>
</tr>

</form>
</div>


</center>

</body>
</html>
