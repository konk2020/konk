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

td, th {
    border: 5px solid #dddddd;
    text-align: center;
    padding: 8px;

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
 <h2>Konk The Game</h2>
    
<h3>Only 2 allowed to play at one time</h3>

<div class="container">
  <form method="post" action="players.php">
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
	  <form method='post' action='guest_select.php'> 	  
		 <input type='hidden' name='player' value='host'> 
		 <input type='submit' name="submitbtn" class='submit' value='Host Player'></input>
     </form>
     </td> 
    
      <td>  
	  <form method='post' action='guest_select.php'> 	  
		 <input type='hidden' name='player' value='guest'> 
		 <input type='submit' name="submitbtn" class='submit' value='GUEST Player'></input>
     </form>
     </td>  
     </tr>
     </table>

     </div>

<?php include_once 'query_functions.php';
    print_player_level_table();
    print_konk_log_table();
?>

</body>

<p><center>&copy; Konk The Game | version 1.0</p></center>

</html>




