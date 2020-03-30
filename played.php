<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Konk The Game</title>

</head>
  <body>

<!--	<h2><a href="/host_select.php">Go Back</a></h2> -->

<?php
    //be sure to validate and clean your variables
    
    echo  "passing.......". $_POST['player'];  
    $card_to_discard = $_POST['card_to_discard'];
    $player = $_POST['player'];
    
    if ($player == 'host'){
           echo  "passing is host.......".$player;   
      echo "<h2><a href='guest_select.php?player=host'>Go Back</a></h2>";
        
    }
    else {
        echo  "passing is guest.......".$player;  
      echo "<h2><a href='guest_select.php?player=guest'>Go Back</a></h2>";
        
    }
    
  
   echo "Param 1: ". $card_to_discard ." Param 2: " . $player;
   echo "<br>";
   
   
    include 'konkdb_connection.php';
    
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
                   
    $sql = "INSERT into played (card_played, player) values ('$card_to_discard','$player')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table played: Card inserted successfully!";
    } else {
             echo "<br>";
             echo "Error on insert to table played: " . $conn->error;
    }
                
     $sql = "DELETE from hand WHERE card_delt='$card_to_discard'";
    if ($conn->query($sql) === TRUE) {
        echo "<br>";
        echo "Table hand: Card deleted successfully!";
    } else {
             
             echo "Error deleting card: " . $conn->error;
    }            
                
                
    /* update all players last hand to 0 */
    $sql = "UPDATE players SET player_just_played = '0'";
    
    $conn->query($sql);
    
    /* update players last hand to 1 for the player send as parameter */
    $sql = "UPDATE players SET player_just_played = '1' where player='$player'";
    
    $conn->query($sql);                
    
                
            
    // Free result set
    $result->free();
    
    CloseCon($conn);
   

?>    


</body>
</html>