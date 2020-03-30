<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Konk The Game1</title>

</head>
  <body>
	<h2><a href=".">Go Back</a></h2><br>
	<h4>Deal</h4>
	
	

<?php
    //be sure to validate and clean your variables
  //  $card_to_discard = $_POST["card_to_discard"];
//    $player = $_POST["player"];
  
 //  echo "Param 1: ". $card_to_discard ." Param 2: " . $player;
  // echo "<br>";
   
   
    include 'konkdb_connection.php';
    
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
                   
 /*draw a card */
$sql = "SELECT card FROM deck WHERE draw='0' order by RAND() limit 1"; 
for ($x = 1; $x <= 7; $x++) {
        if($result = $conn->query($sql)){
            if($result->num_rows > 0){
                while($row = $result->fetch_array()){
                    echo "<tr>";
                    
                    $card_drawn = $row['card'];  
                    
                    $card =  substr($card_drawn,0,1);
                    
                    $sql1 = "UPDATE deck SET draw='1' WHERE card='$card_drawn'";
                    if ($conn->query($sql1) === TRUE) {
                        echo "<br>";
                        echo " Table deck: Record updated successfully!";
                    } else {
                         echo "Error updating record: " . $conn->error;
                    }
                    
                    // do the first three card to host then the last 4 to guest
                    if ($x <= 3) {
                        
                        $player = 'host';
                    } else {
                        
                        $player = 'guest';
                    }
                    
                    /* insert into hand table */
                    $sql1 = "INSERT INTO hand (player, card_delt)
                    VALUES ('$player', '$card_drawn')";
                    if ($conn->query($sql1) === TRUE) {
                        echo "<br>";
                        echo "Table hand: Record inserted successfully!";
                    } else {
                         echo "Error inserting record in table hand: " . $conn->error;
                    }
                    
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                $result->free();
            } else{
                echo "No records matching your query were found.";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . $conn->error;
        }
}
    CloseCon($conn);
   

?>    

</body>
</html>