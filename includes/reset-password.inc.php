<?php

if (isset($_POST["reset-password-submit"])) {

$selector = $_POST["selector"];
$validator = $_POST["validator"];
$password = $_POST["pwd"];
$passwordRepeat = $_POST["pwd-repeat"];

if (empty ($password) || empty($passwordRepeat)){
    header("Location: .. /create-new-password.php?newpwd=empty");
    exit();

} else if ($password != $passwordRepeat) {
    header("Location: .. /create-new-password.php?newpwd=pwdnotsame");
    exit ();
}

$currentDate = date("U");

require "konkusersdb_connection.php";
$conn = OpenCon();


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    exit();
}  else {
    // Make sure selector and the current exprire date is greater than current date
    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector='$selector' AND pwdResetExpires >= '$currentDate'";
    $result = $conn->query($sql);

    if($result->num_rows == 0){
        echo "You need to re-submit your reset request.";
        exit();
    } else {
                // Record exists and valid token, move on with pwd reset
                $row = $result->fetch_array();

                $tokenBin = hex2bin($validator);

                $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

                if ($tokenCheck === false) {
                    echo "You need to re-submit your reset request.";
                    exit();

                } elseif ($tokenCheck === true) {
                    $tokenEmail = $row["pwdResetEmail"];

                    $sql = "SELECT * from accounts WHERE email='$tokenEmail'";

                    $result = $conn->query($sql);
                    

                    if ($result->num_rows == 0) {
                        echo "Email was not found in table accounts. Re-submit your reset request";
                        exit();

                    } else {
                      //  $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                        $newPwdHash = md5($password);
                        $sql = "UPDATE accounts SET password='$newPwdHash' WHERE email='$tokenEmail'";
                        $conn->query($sql);

                        $sql = "DELETE FROM pwdReset WHERE pwdResetEmail='$tokenEmail'";
                        $conn->query($sql);
                        header("Location: ../login.php?newpwd=passwordupdated");

                    }   


                } 



        }   
        


    }

        $results->free();
        CloseCon($conn);





} else {

    header("Location: ../index.php");
}


?>
