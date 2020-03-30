<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Konk The Game</title>

</head>
  <body>
	<h2><a href="/">Go Back</a></h2><br>
	<h4>Players</h4>
	

<?php
    //be sure to validate and clean your variables
    $host_name = $_POST["host_name"];
    $guest_name = $_POST["guest_name"];
    $reset_score_par = $_POST["reset_score"];
    $shuffle_cards_par = $_POST["shuffle_cards"];
      
      
  
   echo "Param 1: ". $host_name ." Param 2: " . $guest_name ." Param 3: " . $reset_score_par ." Param 4: " . $shuffle_cards_par;
   echo "<br>";
   
    include_once 'query_functions.php';
   // include 'konkdb_connection.php';
    
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
$sql = "SELECT * from players where 1=1";
if($result = $conn->query($sql)){
    
    if($result->num_rows > 0){    
        echo "<br>";
        echo "Table players already have players but updating names!";
        
        // --- update host name
        if (empty($_POST['host_name'] == false)){
            
            $sql = "UPDATE players set player_name='$host_name' where player='host'";
            $conn->query($sql);
            
        }
       
        if (empty($_POST['guest_name'] == false)){   
            // --- update guest name
            $sql = "UPDATE players set player_name='$guest_name' where player='guest'";
            $conn->query($sql);
        }
        
        if ($reset_score_par=='yes'){
          // --- update guest name
            $sql = "UPDATE players set score='0' where 1=1";
            $conn->query($sql);  
            
        }
        
        
        
    
    } //else {
        
       //insert into players table 
     
         //   $sql = "INSERT INTO players (player, player_name, player_just_played, dealer) VALUES ('host', '$host_name','1','1')";
    //        $sql1 = "INSERT INTO players (player, player_name,player_just_played, dealer) VALUES ('guest', '$guest_name', '0','0')";
    
    
      //      if ($conn->query($sql) === TRUE) {
        //        echo "<br>";
          //      echo " Table players: Record inserted successfully!";
        //    } else {
          //       echo "Error inserting table players record: " . $conn->error;
        //    }
            
        
            /* insert into hand table */
          //  if ($conn->query($sql1) === TRUE) {
            //    echo "<br>";
              //  echo "Table players: Record inserted successfully!";
            //} else {
             //    echo "Error inserting table players record: " . $conn->error;
        //    }      

   // }
    
} else {
    echo "ERROR: Could not able to execute $sql. " . $conn->error;
}    
    

    if ($shuffle_cards_par == 'yes') {
        
        $shuffle_rtn = shuffle_deck();
        $deal_cards_rtn = deal_cards();
        echo "<br>";
        echo "Shuffle and deal operation completed successfully!";
 
    } 
      
                    
    CloseCon($conn);
   

?>    

</body>
</html>