<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">  
<form method="POST" action="includes/reset-password.inc.php">
<table border="0" align="center" cellpadding="5">
<tr>
    <td colspan="2" style = "text-align:center;"> <img src="images/konk_logo.jpg"></td>
</tr>

<?php
$selector = $_GET["selector"];
$validator = $_GET["validator"];

if (empty ($selector) || empty($validator)){
echo "Could not validate your request!";

} else {
    if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ) {
        ?>

        <form method="POST" action="includes/reset-password.inc.php"> 

        <input type="hidden" name="selector" value="<?php echo $selector ?>">
        <input type="hidden" name="validator" value="<?php echo $validator ?>">
        <input type="password" name="pwd" placeholder="Enter new password....">
        <input type="password" name="pwd-repeat" placeholder="Repeat new password....">
        <button type="submit" name="reset-password-submit">Reset password</button>

        </form>

        <?php

    }

}

?>






</div>

<center>

<?php

echo $error; 
?>

</center>

</body>
</html>