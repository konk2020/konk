<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.container {
  position: relative;
  text-align: center;
  color: black;
  
  
}

.centered {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
}
</style>
</head>
<body>

<?php
// --------- show 4th card only if KONK -------------
	session_start();


//include 'query_functions.php';

/* show my hand */
if (!isset($_SESSION['player'])){

	echo "No player selected in the session variable";

}
	
else {	
	// display the 4th card
    $sql = "SELECT card_played FROM played where player = '".$_SESSION['player']."' ORDER BY time_card_played DESC LIMIT 1"; 


	  //    echo "<h2> ". get_players_name($_SESSION['player'])." (". $_SESSION['player'].") hand</h2>";    
	       
        
	//echo "<table>";
	
    if($result = $conn->query($sql)){
		if($result->num_rows > 0){
         //   echo "<tr>";
			while($row = $result->fetch_array()){					
				$card_delt = $row['card_played'];  
 				
				$card =  substr($card_delt,0,1);
				
				if ($card == "C"){
					$imagepath = "images\Clubs". substr($card_delt,-1) . ".png";
				 
				}
				else if ($card == "D"){
					$imagepath = "images\Diamonds". substr($card_delt,-1) . ".png";
				
				} else if ($card == "H"){
					$imagepath = "images\Hearts". substr($card_delt,-1) . ".png";
			
				} else if ($card == "S"){
					$imagepath = "images\Spades". substr($card_delt,-1) . ".png";
			
				}                
                  
				   console_log("player 4th card: ". $_SESSION['player']);
				   console_log(did_opponent_knocked($_SESSION['player']));
				   console_log(did_a_player_knocked());
				   if (did_a_player_knocked()<>'1') { 
				
                          //  if (get_picked_card($_SESSION['player']) <> $card_delt){ 
						  // session valiable has been reversed so this funcion is checking current user if they have knocked 	
						  if (did_opponent_knocked($_SESSION['player'])==0){		
								$imagepath = "images\Card.png";
							
							}
                               
                       
				     }  	
					 console_log($imagepath);
                    if (did_a_player_knocked()=='1') { 
						// session valiable has been reversed so this funcion is checking current user if they have knocked 
						if (did_opponent_knocked($_SESSION['player'])==0){		
							$imagepath = "images\Card.png";
						
						} else {
									echo "<td>";
									echo "<div class='container'>";	
									echo "<img src='$imagepath' width='75' height='125'>";
									echo "<div class='centered'><b>KONK Card</b></div>";	
									echo "</div>";
									echo "</td>";
						        }
                       }  
                    else { 
                        echo "<td><img src='$imagepath' width='75' height='125'>" . "</td>";
                    }
					echo "</body>";
					echo "</html>";
				
			}
			// Free result set
			$result->free();
		} else{
			echo "No records matching your query were found.";
		}
	} else{
		echo "ERROR: Could not able to execute $sql. " . $conn->error;
	}
}	
?>