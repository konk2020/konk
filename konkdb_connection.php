<?php

function OpenCon()
 {
 session_start();
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "root";
 if ($_SESSION['room']==1){
    $db = "konk";
 } elseif ($_SESSION['room']==2) {
    $db = "konk1";
} elseif ($_SESSION['room']==3) {
    $db = "konk2";
} elseif ($_SESSION['room']==4) {
    $db = "konk3";
} elseif ($_SESSION['room']==5) {
    $db = "konk4";    
} else {
    // default room1=konk database
    $db = "konk";
}

 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
?>