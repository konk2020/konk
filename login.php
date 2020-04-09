<?php
$error = NULL;

if (isset($_POST['submit'])){
    // Connect to the database

    $mysqli = NEW MySQLi('localhost','root','root', 'konkusers');

    // Get form data
    $u = $mysqli->real_escape_string($_POST['u']);
    $p = $mysqli->real_escape_string($_POST['p']);
    $p = md5($p);

    // Query the database
    $resultSet = $mysqli->query("SELECT * FROM accounts WHERE username = '$u' AND password = '$p' LIMIT 1");

    if ($resultSet->num_rows !== 0 ){
        // Process Login
        $row - $resultSet->fetch_assoc();
        $verified = $row['verified'];
        $email = $row ['email'];
        $date = $row['createdate'];
        $date = strtotime ($date);
        $date = date('M d Y', $date);

        if ($verified ==  1){
            // Continue processing

            echo "Your account has been verified and you have been loged in";

        } else {

            $error = "The account has not yet been revified. An email was send to $email on $date";
        }



    } else {
        // Invalid Credentials
        $error = "The username or password you entered is incorrect";

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
    <td colspan="2" style = "text-align:center;"><input type="SUBMIT"  class="submit" name="submit" value="Login" required/></td>
</tr>
<tr>
    <td colspan="2" style = "text-align:center; font:20px Aria;">&copy; Konk The Game | version 3.0</td>
</tr>

</form>
</div>



<center>
<?php

echo $error; 
?>

</center>

</body>
</html>