<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Konk The Game</title>

</head>
  <body>
	

<?php
      
    session_start();
      
    //be sure to validate and clean your variables
    $card_to_pick = $_POST["card_to_pick"];
    $player = $_POST["player"];
    
    if ($player == 'host'){
      echo "<h2><a href='guest_select.php?player=host'>Go Back</a></h2>";
        
    }
    else {
        
      echo "<h2><a href='guest_select.php?player=guest'>Go Back</a></h2>";  
        
    }
    
    
  
   echo "Param 1: ". $card_to_pick ." Param 2: " . $player;
   echo "<br>";
   
   
    include 'konkdb_connection.php';
    
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
     // --- remove the knock in case the player picks another card
     $sql = "UPDATE players SET knocked='0'";
                
     $conn->query($sql);   
      
      
      
    $sql = "INSERT into hand (card_delt, player) values ('$card_to_pick','$player')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table hand: Card picked inserted successfully!";
    } else {
             echo "<br>";
             echo "Error on insert to table hand: " . $conn->error;
    }
                
     $sql = "DELETE from played WHERE card_played='$card_to_pick'";
    if ($conn->query($sql) === TRUE) {
        echo "<br>";
        echo "Table played: Card deleted successfully!";
    } else {
             
             echo "Error deleting card: " . $conn->error;
    }            
                
            
    // Free result set
    // whitespace
    $result->free();
    
    CloseCon($conn);
    
    unset($_SESSION['knocking']);
   

?>    


</body>
</html>
