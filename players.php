<?php
    //be sure to validate and clean your variables
    $host_name = $_POST["host_name"];
    $guest_name = $_POST["guest_name"];
    //$reset_score_par = $_POST["reset_score"];
    $reset_score_par = 'yes';
    //$shuffle_cards_par = $_POST["shuffle_cards"];
    $shuffle_cards_par = 'yes';
    // room number determine the database number. Room1=konk1, Room2=konk2, etc...
    $room_number = $_POST["room_number"];
    
  /* echo "Host Name: <strong>". $host_name . "</strong>";
   echo "<br>";
   echo "Guest Name: <strong>". $guest_name. "</strong>";
   echo "<br>";
   echo "Room Number: <strong>". $room_number. "</strong>";
   echo "<br>";
   echo "Reset Score for both players: <strong>". $reset_score_par. "</strong>";
   echo "<br>";
   echo "Shuffle Cards: <strong>". $shuffle_cards_par. "</strong>";
   echo "<br>"; */
   
    include_once 'query_functions.php';
   // include 'konkdb_connection.php';
    
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
$sql = "SELECT * from players where 1=1";
if($result = $conn->query($sql)){
    
    if($result->num_rows > 0){    
      //  echo "<br>";
      //  echo "<strong>Updating based on parameters above, if none, no results will be displayed below!</strong><br>";
        
        // --- update host name
        if (empty($_POST['host_name'] == false)){
            
           // $sql = "UPDATE players set player_name='$host_name', gameroom='$room_number' where player='host'";
            $sql = "UPDATE players set player_name='$host_name' where player='host'";
           
            $conn->query($sql);
         //   echo "<br>";
         //   echo "&#10004 Host name updated to ". $host_name;

            $sql = "UPDATE accounts SET playerinroom = 1 WHERE username='$host_name'";
            $conn->query($sql);
        //    echo "<br>";
        //    echo "&#10004 Player ". $host_name . " playing and can't be assigned to any other room";
            
        }
       
        if (empty($_POST['guest_name'] == false)){   
            // --- update guest name
           // $sql = "UPDATE players set player_name='$guest_name', gameroom='$room_number' where player='guest'";
            $sql = "UPDATE players set player_name='$guest_name' where player='guest'";
            
            $conn->query($sql);

           // echo "<br>";
           // echo "&#10004 Guest name updated to ". $guest_name;

            $sql = "UPDATE accounts SET playerinroom = 1 WHERE username='$guest_name'";
            $conn->query($sql);
          //  echo "<br>";
          //  echo "&#10004 Player ". $guest_name . " playing and can't be assigned to any other room";
    
        }

        if (empty($_POST['room_number'] == false) and empty($_POST['guest_name'] == false) and empty($_POST['host_name'] == false)){   
          // --- room number for both guest and host and update the kdatabase view to be used the database assigned to room 
          $sql = "UPDATE players set gameroom='$room_number'";
          $conn->query($sql);
          // update kdatabase view
          $sql = "UPDATE kdatabases set inuse='1' where databaseID='$room_number'";
          $conn->query($sql);

         /* echo "<br>";
          echo "&#10004 Game Room set to ". $room_number;
          echo "<br>";
          echo "&#10004 Database set to konk". $room_number; */
          
  
      }

        
        if ($reset_score_par=='yes'){
          // --- update guest name
            $sql = "UPDATE players set score='0' where 1=1";
            $conn->query($sql);  

          //  echo "<br>";
         //   echo "&#10004 Score reset to 0 succesfully for host and guest!";            
            
        }  
    
    } 
    
} else {
    console_log ("ERROR: Could not able to execute)". $sql. " " . $conn->error);
}    
    
    if ($shuffle_cards_par == 'yes') {
        
        $shuffle_rtn = shuffle_deck('guest');
        $deal_cards_rtn = deal_cards();
     
    /*    echo "<br>";
        echo "&#10004 Shuffle and deal operation completed successfully!";
        echo "<br>";
        echo "&#10004 Host deals cards on new game, so guest has 4 cards and host 3 to start game - Good Luck!";*/
 
    } 
  //  echo "<br>";
  //  echo "<br>";
  //  echo "Click Go Back on top of the page to return to the game home page...";
                    
    CloseCon($conn);
   // header("Location: index.php?reset=success");
    // header("Location: index.php?reset=success", true, 301); exit;
   header("Location: index.php?reset=success&gname=$guest_name&hname=$host_name&room=$room_number", true); exit;
?>    