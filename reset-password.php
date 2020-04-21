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
    <td colspan="2" style = "text-align:center;"> <a href="login.php"><img src="images/konk_logo.jpg"></a></td>
</tr>

<!--<form method="POST" action="includes/reset-request.inc.php1">-->
<form method="POST" action="includes/reset-request.inc.php">

<tr>
    <td colspan="2" style = "text-align:center;" ><input type="TEXT" name="email" placeholder="Enter your email..." required/></td>
</tr>

<tr>
<td colspan="2" style = "text-align:center; font:20px Aria;">
<p>An e-mail will be sent to you with instructions on how to reset your password.<p>
</td>     
</tr>

<tr>
    <td colspan="2" style = "text-align:center;"><input type="SUBMIT"  class="submit" name="reset-request-submit" value="Get new password by e-mail"/></td>
</tr>

<tr>
<td colspan="2" style = "text-align:center;">
<?php
if (isset($_GET["email"])) {
    if ($_GET["email"]== "noemailfound") {
        echo '<p class="pwdreset">You did not use this email to register for the game.</p>';
        
    }
}
?>
</td>
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