<?php
session_start();

include_once 'query_functions.php';
//ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #4CAF50;
  color: black;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 900;
  font-size: 25px;
}

button {

  background-color: #4CAF50;
  color: black;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 900;
  font-size: 25px;

}


input[type=submit]:hover {
  background-color: #45a049;
}

 table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td {
    border: 5px solid #dddddd;
    text-align: center;
    padding: 8px;

}

th {
    border: 5px solid #dddddd;
    text-align: center;
    padding: 8px;
    background-color: gray;
    font-size: 20px;

}




tr:nth-child(even) {
    background-color: white;
}   
    

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

</style>
</head>
<body>
 <center><a href="index.php"><img src="images/konk_logo.jpg"></a></center>


 
<?php

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//echo $url; // Outputs: Full URL

$protocol_var = 'http:';
$host_var = 'konk.us';

if (strpos($url, $protocol_var) !== false and strpos($url, $host_var) !== false) {

  $secure_url = 'https://konk.us/guest_select.php';
  $secure_url1 = 'https://konk.us/players.php';

} else {
    $secure_url = 'guest_select.php';
    $secure_url1 = 'players.php';
    
  }
 
?>


<?php 
// Remove folks from the room if they have been idle for more than 15 minutes
 $conn = OpenCon();
 $sql = "SELECT datescoreposted, databaseID FROM kdatabases WHERE inuse = 1";
 if($resultSet = $conn->query($sql)){
  if($resultSet->num_rows > 0){
      while($row = $resultSet->fetch_array()){

            $now    = time();
            $savedTime = $row['datescoreposted'];
            $savedTimeTimestam = strtotime($savedTime);
            $savedTimeTimestamp = date("U",$savedTimeTimestam);
           // $target = strtotime($row['datescoreposted']);
            $dbID = $row['databaseID'];
           // $diff   = $now - $target;
    //    echo date('Y/m/d h:i:s', $now); 
    //       echo "<br>";
    //       echo date('Y/m/d h:i:s', $savedTimeTimestamp); 
    //       echo "<br>";

            // 15 minutes = 15*60 seconds = 900
            if ($now > ($savedTimeTimestamp+60)) {
                                  // accounts reset  for dbID=room#
                                  $sql = "UPDATE accounts SET playerinroom = '0' where playerinroom='$dbID'";  
                                  $conn->query($sql);               
                                  // kdatabases reset for dbID=room#
                                  $sql = "UPDATE kdatabases SET inuse = '0', playing = null, datescoreposted = '' WHERE databaseID = '$dbID'";    
                                  $conn->query($sql);          
                                  // players reset 
                                  $sql = "UPDATE players SET gameroom = '0', player_name='' WHERE gameroom = '$dbID'";  
                                  $conn->query($sql);   
                             //echo "Room ".$dbID. " succesfully released!";
                              // reset all variables
                              unset($_SESSION['room']);
                              unset($_SESSION ['h_player_for_index']);
                              unset($_SESSION ['g_player_for_index']);

            } else {

              console_log("Good to go, no need to remove players from room!");

            }


      }
    }
  }

  CloseCon($conn); 
?>  



 <h2>Konk The Game</h2>
 <p>   
<h3>Only 2 allowed to play per room</h3>
<button onclick="window.location.href = 'registration.php';">Register to Play</button>
</p>
<table>
<th>Room 1</th>
<th>Room 2</th>
<th>Room 3</th>
<th>Room 4</th>
<th>Room 5</th>
<tr> 
<td>
<?php 
// ROOM 1 close/open image
 $conn = OpenCon();
 $resultSet = $conn->query("SELECT databaseID FROM kdatabases WHERE inuse = 1 and databaseID = 1 LIMIT 1");
 if ($resultSet->num_rows == 1) {
  $room_one_image = "images/closed1.gif";
} else {
  $room_one_image = "images/open1.gif";
}
  echo "<img src='$room_one_image'>";
  CloseCon($conn); 
?>  
</td>

  <td><img src="images/open1.gif"></td><td><img src="images/open1.gif"></td><td><img src="images/open1.gif"></td><td><img src="images/open1.gif"></td>
<tr>
<tr>
<td>
<?php 
// ROOM 1 PLAYERS
 $conn = OpenCon();
 $resultSet = $conn->query("SELECT playing FROM kdatabases WHERE databaseID = 1 LIMIT 1");
 $row = $resultSet->fetch_array();
 if (empty($row['playing'])) {
  echo "No players...";

 } else {
    echo $row['playing'];

 }
  CloseCon($conn); 
?>  
</td>


</td>
<td>Names....</td><td>Names....</td><td>Names....</td><td>Names....</td>
</tr>
<tr>
<td>Players will be removed after 15 minutes of inactivity</td><td>Players will be removed after 15 minutes of inactivity</td><td>Players will be removed after 15 minutes of inactivity</td><td>Players will be removed after 15 minutes of inactivity</td><td>Players will be removed after 15 minutes of inactivity</td>
</tr>
</table>



<div class="container">
    <form method='post' name='form1' action='<?=$secure_url1?>' onsubmit=' return comparenames()'> 	
    <label style='font-size: 30px;' for="host_name">Who will be the host (the one that  starts the game)?</label>
    
   <!-- <input type="text" id="host_name" name="host_name" placeholder="Host Player First Name.."> -->

  
<?php
// create drop down for Host Players
    $conn = OpenCon();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT username FROM accounts where verified = '1' and playerinroom <> '1' order by username";
    echo "<select style='font-size: 30px;'  id='host_name' name='host_name'>";
    echo "<option  disabled selected value> -- select host player -- </option>";
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_array()){

                     echo '<option>'.$row['username'].'</option>';
                     
            }
        
        }
    }
    CloseCon($conn); 
    echo '</select>';                    
  ?>  

    <label style='font-size: 30px;' for="guest_name">Who will be the guest?</label>
    <!-- <input type="text" id="guest_name" name="guest_name" placeholder="Guest Player First Name.."> -->

    <?php
// create drop down for Guest Players
    $conn = OpenCon();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT username FROM accounts where verified = '1' and playerinroom <> '1' order by username";
    echo "<select style='font-size: 30px;' id='guest_name' name='guest_name'>";
    echo "<option disabled selected value> -- select guest player -- </option>";
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_array()){
                     echo '<option>'.$row['username'].'</option>';
                     
            }
        
        }
    }
    CloseCon($conn); 
    echo '</select>';                    
  ?>  
 <label style='font-size: 30px;' for="room_number">Available Rooms to Play</label>
 <?php
// create drop down for Rooms to play
    $conn = OpenCon();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT databaseID FROM kdatabases where inuse=0";
    echo "<select style='font-size: 30px;' id='room_number' name='room_number'>";
    echo "<option disabled selected value> -- select Room to play in -- </option>";
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_array()){
                     echo "<option value='".$row['databaseID']."'>"."Room ". $row['databaseID']."</option>";
                     
            }
        
        }
    }
    CloseCon($conn); 
    echo '</select>';                    
  ?>  
 

  <!--  <label for="score_reset">Check to reset score (used in case you want to change players) </label>   
    <input type="checkbox" name="reset_score" value="yes">
     <br>  
    <br> 
      
    <label for="score_reset">Check to shuffle 52 card deck and deal cards to the two players </label>      
    <input type="checkbox" name="shuffle_cards" value="yes">   
  -->
    <br> 
    <br>
    <input type="submit" value="Start Game!">
  </form>
  <script src="custom-functions1.js"></script>
</div>
    
    <div class="container">
<?php    
    // Show message if paramters were saved and ready to continue
if (isset($_GET["reset"])) {
    if ($_GET["reset"]== "success") {
        echo '<center><h2 style="color:red;">Game started Successfully! Select your name and start playing - Good Luck!</h2></center>';
        $_SESSION['room']= $_GET["room"];
        if (isset($_GET["gname"])) {

          $btn_guest_name = $_GET["gname"];
          
        } else {$btn_guest_name = 'No player'; }

        if (isset($_GET["hname"])) {

          $btn_host_name = $_GET["hname"];
          
        } else {$btn_host_name = 'No player'; }
    }

}
?>

      <table>
	  <tr>
      <td>     
	  <?php //   echo "Session player (". $_SESSION ['player_for_index'] . ") if not host, btn disabled"; ?>
     
     <form method='post' action='<?=$secure_url?>'> 		   
		 <input type='hidden' name='player' value='host'> 
<?php 


// btn_host_name not set in $_GET
if (isset($_SESSION ['h_player_for_index'])) {
    $btn_host_name = $_SESSION ['h_player_for_index'];
    $btn_host = 'enable';
 } else {
          if (!isset($btn_host_name)) {
              $btn_host = 'disabled';
              $btn_host_name = 'Host Player';
          }
        
      }

?>
<!--     <input type='submit' <?=$btn_host?> name="submitbtn" class='submit' value='Host Player'></input> -->
     <input type='submit' name="submitbtn" class='submit' value='<?= $btn_host_name?>' ></input>

     

     </form>
     </td> 
    
      <td>  
     <?php //  echo "Session player (". $_SESSION ['player_for_index'] . ") if not guest, btn disabled"; ?>
      <form method='post' action='<?=$secure_url?>'> 	 
		 <input type='hidden' name='player' value='guest'> 
<?php 
  
  if (isset($_SESSION ['g_player_for_index'])) {
    $btn_guest_name = $_SESSION ['g_player_for_index'];
    $btn_guest = 'enable';
 } else {
          // btn_guest_name not set in $_GET
          if (!isset($btn_guest_name)) {
            $btn_guest = 'disabled';
            $btn_guest_name = 'Guest Player';
          }
      }


?>

<!--		 <input type='submit' <?=$btn_guest?> name="submitbtn" class='submit' value='GUEST Player'></input> -->
		 <input type='submit' name="submitbtn" class='submit' value='<?= $btn_guest_name?>'></input>

     </form>
     </td>  
     </tr>
     </table>

     </div>

<?php 
echo "<h1> Game Statistics for Game Room: ". $_SESSION['room']."</h1>";
    print_player_level_table();
    print_players_stats();
    print_konk_log_table();
?>

</body>

<p><center>&copy; Konk The Game | version 2.0</p></center>

</html>




