<?php
session_start();
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
 <center><img src="images/konk_logo.jpg"></center>
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

 <h2>Konk The Game</h2>
    
<h3>Only 2 allowed to play at one time</h3>

<div class="container">
    <form method='post' action='<?=$secure_url1?>'> 	
    <label for="host_name">Player (host) Name</label>
    <input type="text" id="host_name" name="host_name" placeholder="Host Player First Name..">

    <label for="guest_name">Player (guest) Name</label>
    <input type="text" id="guest_name" name="guest_name" placeholder="Guest Player First Name..">
     
    <label for="score_reset">Check to reset score (used in case you want to change players) --> </label>      
    <input type="checkbox" name="reset_score" value="yes">
     <br>  
    <br> 
      
    <label for="score_reset">Check to shuffle 52 card deck and deal cards to the two players  --> </label>      
    <input type="checkbox" name="shuffle_cards" value="yes">   
      
    <br> 
    <br>
    <input type="submit" value="Submit">
  </form>
</div>
    
    <div class="container">
    
    
      <table>
	  <tr>
      <td>     
	  <?php   echo "Session player (". $_SESSION ['player_for_index'] . ") if not host, btn disabled"; ?>
     
     <form method='post' action='<?=$secure_url?>'> 		   
		 <input type='hidden' name='player' value='host'> 
<?php 

if (isset($_SESSION ['player_for_index'])) {
    if ($_SESSION ['player_for_index']=='host'){

      $btn_host = 'enable';
    }
      else {

        $btn_host = 'disabled';
      }
  }  else {
      $btn_host = 'enable';
    } 

?>
		 <input type='submit' <?=$btn_host?> name="submitbtn" class='submit' value='Host Player'></input>

     </form>
     </td> 
    
      <td>  
      <?php   echo "Session player (". $_SESSION ['player_for_index'] . ") if not guest, btn disabled"; ?>
      <form method='post' action='<?=$secure_url?>'> 	 
		 <input type='hidden' name='player' value='guest'> 
<?php 
  
  if (isset($_SESSION ['player_for_index'])) {
        if ($_SESSION ['player_for_index']=='guest'){

          $btn_guest = 'enable';
        }
          else {

            $btn_guest = 'disabled';
          }
  } else {
    $btn_guest = 'enable';
  }



?>

		 <input type='submit' <?=$btn_guest?> name="submitbtn" class='submit' value='GUEST Player'></input>
     </form>
     </td>  
     </tr>
     </table>

     </div>

<?php include_once 'query_functions.php';
    print_player_level_table();
    print_players_stats();
    print_konk_log_table();
?>

</body>

<p><center>&copy; Konk The Game | version 2.0</p></center>

</html>




