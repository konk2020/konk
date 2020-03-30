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
    
                   
    $sql = "UPDATE deck SET draw='0' WHERE 1=1";
    if ($conn->query($sql) === TRUE) {
        echo "Table deck: Cards re-shuffled successfully!";
    } else {
             echo "<br>";
             echo "Error updating deck table: " . $conn->error;
    }
                
     $sql = "DELETE from hand WHERE 1=1";
    if ($conn->query($sql) === TRUE) {
        echo "<br>";
        echo "Table hand: All cards deleted successfully!";
    } else {
             
             echo "Error deleting from hand table: " . $conn->error;
    }            
     
     $sql = "DELETE from played WHERE 1=1";
    if ($conn->query($sql) === TRUE) {
        echo "<br>";
        echo "Table played: All cards deleted successfully!";
    } else {
             
             echo "Error deleting from played table: " . $conn->error;
    }  
    
    /* update all players last hand to 0 */
    $sql = "UPDATE players SET player_just_played = '0', knocked='0'";
    
    $conn->query($sql);
    
    /* update players last hand to 1 for host */
    $sql = "UPDATE players SET player_just_played = '1' where player='host'";
    
    $conn->query($sql);
    
    
    
            
    // Free result set
    $result->free();
    
    CloseCon($conn);

?>


</body>
</html>