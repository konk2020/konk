<?php
// --------- show players hand -------------
	session_start();


//include 'query_functions.php';

/* show my hand */
if (!isset($_SESSION['player'])){

	echo "No player selected in the session variable";

}
	
else {	
	//$sql = "SELECT * FROM hand where player = '".$_SESSION['player']."' order by card_delt"; 
    $sql = "SELECT * FROM hand INNER JOIN deck on hand.card_delt=deck.card where player = '".$_SESSION['player']."' order by deck.order, deck.suit_order";

          echo "<h2> ". get_players_name($_SESSION['player'])." (". $_SESSION['player'].") hand</h2>";    
    
        
        
	echo "<table>";
	
    if($result = $conn->query($sql)){
		if($result->num_rows > 0){
            echo "<tr>";
			while($row = $result->fetch_array()){
				
				
				$card_delt = $row['card_delt'];  
                
             
				
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
					
					//  echo "<td>" . $row['player'] . "</td>";
                
                
                    // switch player so you can count the cards of the opponent
                    if ($_SESSION['player']=='guest') {
                        $player = 'host';
                    } else {
                        $player = 'guest';
                    }
                
					console_log('GLOBAL VAR flip_card_pick_from_table:'.$_SESSION['flip_card_pick_from_table']);
                    console_log('$card_delt:'.$card_delt);
                    console_log('$player OPPONENT HAND:'.$player);
                    console_log('get_picked_card_func_return:'.get_picked_card($_SESSION['player']));
                
				  //  if (!isset($_SESSION['knocking']) and did_opponent_knocked($player)=='0'){
				   if (!did_a_player_knocked()=='1') { 
				
                            if (get_picked_card($_SESSION['player']) <> $card_delt){ $imagepath = "images\Card.png";}
                            
            
                       
				     }  	
                
                    if (did_a_player_knocked()=='1') { 
								// ----- no discard button --------
				      // echo "<td>" . $row['card_delt'] . "&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath'></td>";
                       echo "<td><img src='$imagepath' width='75' height='125'></td>";
                        
                       }  
                    else { 
                        // --- show discard button ---
                        //echo "<td>" . $row['card_delt'] . "&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath'>" . "</td>";
                        echo "<td><img src='$imagepath' width='75' height='125'>" . "</td>";
                        }
        
				
					
				//    echo "<td>" . $row['card_delt'] . "</td>";
				
				
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