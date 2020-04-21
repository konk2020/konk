<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">  
<!--<form method="POST" action="includes/reset-password.inc.php"> -->
<table border="0" align="center" cellpadding="5">
<tr>
    <td colspan="2" style = "text-align:center;">Reset your password</td>   
</tr>

<tr>
    <td colspan="2" style = "text-align:center;"> <a href="login.php"><img src="images/konk_logo.jpg"></a></td>
</tr>

<?php
$selector = $_GET["selector"];
$validator = $_GET["validator"];



if (empty ($selector) || empty($validator)){
   // selector or validator is empty
   // have the user try again
      
    echo "Could not validate your request!";

} else {
    if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ) {
        ?>

        <form method="POST" name="form1" action="includes/reset-password.inc.php" onsubmit=" return comparepwd()"> 
        <tr>
        <td colspan="2" style = "text-align:center;">  
            <input type="hidden" name="selector" value="<?php echo $selector ?>">
        </td>
        </tr>
        <tr>
        <td colspan="2" style = "text-align:center;">  
        <input type="hidden" name="validator" value="<?php echo $validator ?>">
        </td>
        </tr>
        <tr>
        <td colspan="2" style = "text-align:center;">  
        <input type="password" name="pwd" required placeholder="Enter new password....">
        </td>
        </tr>
        <tr>
        <td colspan="2" style = "text-align:center;">  
        <input type="password" name="pwd-repeat" required placeholder="Repeat new password....">
        </td>
        </tr>
        <tr>
        <td colspan="2" style = "text-align:center;">  
        <button type="submit" class="submit" name="reset-password-submit">Reset password</button>
        </td>
        </tr>
    

        </form>
        <script src="custom-functions.js"></script>

        <?php

    }

}

?>


</div>

<tr>
    <td colspan="2" style = "text-align:center; font:20px Aria;">&copy; Konk The Game | version 3.0</td>
</tr>
</table>

</body>
</html>