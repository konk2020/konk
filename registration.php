<?php
$error = NULL;

     ini_set('display_errors', 1);

require_once "mail.php";

if (isset($_POST['submit'])){

    // Get form data
    $u = $_POST['u'];
    $p = $_POST['p'];
    $p2 = $_POST['p2'];
    $e = $_POST['e'];

    if (strlen($u) < 5 ){

        $error = "<p>Your username must be at least 5 characters</p>";
    } elseif ($p2 !== $p){
        $error = "<p>Your passwords do not match</p>";

    }else{
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

        // Inset account into the database
        $p=md5($p);
        $insert = $mysqli->query("INSERT INTO accounts(username, password, email, vkey)
        VALUES('$u','$p','$e','$vkey')");

        if ($insert){
            // Send EMail
            $to = $e;
            $subject = "Email Verification";
            $message = "<a href='http://localhost:8888/konk/verify.php?vkey=$vkey'>Register Account</a>";
            sendMail($to, $subject, $message);
            //echo ("Success!");

        }else {

            echo $mysqli->error;
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
    <td colspan="2" style = "text-align:center;"> <img src="images/konk_logo.jpg"></td>
   
</tr>
<tr>
    <td align="right">Username:</td>
    <td><input type="TEXT" name="u" required/></td>
</tr>
<tr>
    <td align="right">Password:</td>
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
    <td colspan="2" style = "text-align:center;"><input type="SUBMIT"  class="submit" name="submit" value="Register" required/></td>
</tr>
<tr>
    <td colspan="2" style = "text-align:center; font:20px Aria;">&copy; Konk The Game | version 3.0</td>
</tr>

</form>
</div>


<?php
$error = NULL;
?>
</center>

</body>
</html>
