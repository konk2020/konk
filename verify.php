<?php
if (isset($_GET['vkey'])){
    // Process Verification
    $vkey = $_GET['vkey'];

    $mysqli = NEW MySQLi('localhost','root','root', 'konkusers');

    $resultSet = $mysqli->query("SELECT verified, vkey FROM accounts WHERE verified = 0 AND vkey = '$vkey'");

    if ($resultSet->num_rows == 1) {
        // Validate The mail
        $update = $mysqli->query("UPDATE accounts SET verified = 1 WHERE vkey = '$vkey' LIMIT 1");

        if ($update){
            echo "<h1>Your account has been verified. <a href='index.php'>Click to Play!</a></h1>"; 

        } else {
            echo $mysqli->error;

        }
 
    } else {

        die ("Something went wrong");
    }

}

?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

</body>

</html>
