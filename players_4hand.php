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


          echo "<h2> ". get_players_name($_SESSION['player'])." (". $_SESSION['player'].") hand</h2>";    
        
	echo "<table>";
	
    if($result = $conn->query($sql)){
		if($result->num_rows > 0){
            echo "<tr>";
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
                  
                
				   if (!did_a_player_knocked()=='1') { 
				
                            if (get_picked_card($_SESSION['player']) <> $card_delt){ $imagepath = "images\Card.png";}
                               
                       
				     }  	
                
                    if (did_a_player_knocked()=='1') { 
                       echo "<td><img src='$imagepath' width='75' height='125'></td>";
                        
                       }  
                    else { 
                        echo "<td><img src='$imagepath' width='75' height='125'>" . "</td>";
                    }
				
				
			}

	
            echo "</tr>";
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
?>