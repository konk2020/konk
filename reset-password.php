<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="container">  
<table border="0" align="center" cellpadding="5">

<tr>
    <td colspan="2" style = "text-align:center;">Reset your password</td>   
</tr>
<tr>
<td colspan="2" style = "text-align:center; font:20px Aria;">An e-mail will be send to you with instructions on how to reset your password.</td>     
</tr>

<tr>
    <td colspan="2" style = "text-align:center;"> <img src="images/konk_logo.jpg"></td>
</tr>

<!--<form method="POST" action="includes/reset-request.inc.php1">-->
<form method="POST" action="includes/reset-request.inc.php">

<tr>
    <td colspan="2" style = "text-align:center;" ><input type="TEXT" name="email" placeholder="Enter your email-address..." required/></td>
</tr>


<tr>
    <td colspan="2" style = "text-align:center;"><input type="SUBMIT"  class="submit" name="reset-request-submit" value="Receive new password by mail"/></td>
</tr>

</form>
<tr>
    <td colspan="2" style = "text-align:center; font:20px Aria;">&copy; Konk The Game | version 3.0</td>
</tr>



<?php
if (isset($_GET["reset"])) {
    if ($_GET["reset"]== "success") {
        echo '<p class="signupsuccess">Check your e-mail!</p>';
        
    }

}
?>

</div>



</body>
</html>