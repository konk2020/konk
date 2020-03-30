<!-- Author: Richard A Negron
     Date: March 21 2020
     Purpose: re-suffle cards when players ran out of cards
    
     Changes:
             


-->
    
    




<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Konk The Game</title>

</head>
  <body>
	<h2><a href=".">Go Back</a></h2>

<?php
    include 'konkdb_connection.php';
    
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    
     $sql = "UPDATE deck SET draw = '0' where 1=1";  
      
    if ($conn->query($sql) === TRUE) {
        echo "Table deck: re-set successfully!";
    } else {
             echo "<br>";
             echo "Error updating deck table: " . $conn->error;
    }  
      
    $sql = "UPDATE hand, deck SET draw = '1' WHERE deck.cards = hand.card_delt";  
      
    if ($conn->query($sql) === TRUE) {
        echo "Table deck: Cards re-shuffled successfully!";
    } else {
             echo "<br>";
             echo "Error updating deck table: " . $conn->error;
    }
                 
            
    // Free result set
    $result->free();
    
    CloseCon($conn);

?>


</body>
</html>