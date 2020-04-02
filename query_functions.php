        


<?php

include 'konkdb_connection.php';

//ini_set('display_errors', 1);

//check if need to re-shuffle 
function check_reshuffle() {
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT draw from deck where draw='1'";
    
    if($result = $conn->query($sql)){
    
        if($result->num_rows == 52){ 
            CloseCon($conn);
            return '1';
        } else { CloseCon($conn); return 0;}
    }  
//CloseCon($conn);       
}

//count the number of cards for a player 
function count_cards($player) {
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT player from hand where player='$player'";
    
    if($result = $conn->query($sql)){
    
        if($result->num_rows > 0){  
            CloseCon($conn);
            return $result->num_rows;
        } else { CloseCon($conn); return '0'; }
    }    
    
          
}        

function did_game_start() {
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT count(draw) as draw_count from deck where draw='1'";
    
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_array()){
                
                     CloseCon($conn); 
                     return $row['draw_count'];
   
            }
        
        }
    }
    
          
}        
//-- used for baby pic
function player_lowest_points() {
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT player_name, score from players";
    $one_time =0;
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_array()){

                    if ($one_time==0){
                        $player_row1_name = $row['player_name'];
                        $player_row1_score = $row['score'];
                        $one_time +=1;
                    } else {
                        $player_row2_name = $row['player_name'];
                        $player_row2_score = $row['score'];
                    }                 
   
            } // - while

            if ($player_row1_score < $player_row2_score) {
                CloseCon($conn); 
                return $player_row1_name;
            }

            if ($player_row2_score < $player_row1_score) {
                CloseCon($conn); 
                return $player_row2_name;
            } else {

                CloseCon($conn); 
                return 'equalscore';

            }

        }
    }
    
          
} 

function checK_if_valid_match() {
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
        $one_time=0;
        $sql = "SELECT players.player_name, player_level.player_lvl from players INNER join player_level on players.player_name=player_level.player_name";   
        if($result = $conn->query($sql)){
        
            if($result->num_rows > 0){ 
                while($row = $result->fetch_array()){

                    if ($one_time==0){
                        $player_row1_lvl = $row['player_lvl'];
                        $one_time +=1;
                    } else {
                        $player_row2_lvl = $row['player_lvl'];
                    }                  
                }   
            }   
        }  

        // -- check if it is a valid madtch 
        $player_level_delta = $player_row1_lvl - $player_row2_lvl;

        if (abs($player_level_delta)<=2) {
            $match_play = 1;

        } else {
            $match_play = 0; 
        }
        CloseCon($conn); 
        return $match_play;
}           
        



function print_score_table() {
 $conn = OpenCon();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    /* show my score */
    $sql = "SELECT players.player_name, player_lvl, score FROM players INNER JOIN player_level ON players.player_name = player_level.player_name"; 
    echo "<table>";
    echo "<tr>";
    echo "<th>Level</th>";
    echo "<th>Player</th>";
    echo "<th>Score</th>";
    echo "</tr>";

    $player_with_low_score  = player_lowest_points(); // func returns players name
    console_log("value of the function". $player_with_low_score);

    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_array()){
                echo "<tr>";
                 
                     if ($player_with_low_score == $row['player_name']) {
                        // -- player with baby
                        echo "<td style='font-size:2.25em;'>" . "L". $row['player_lvl'] . "</td>";
                        echo "<td style='font-size:2.25em;'> <img src='images/Baby.png' width='75' height='75' style='vertical-align:middle; border-radius:1000px;'/>" . $row['player_name'] . "</td>";
                        echo "<td style='font-size:2.25em;'>" . $row['score'] . "</td>";

                     } 
                     
                     else {
                        echo "<td style='font-size:2.25em;'>" . "L". $row['player_lvl'] . "</td>";
                        echo "<td style='font-size:2.25em;'>" . $row['player_name'] . "</td>";
                        echo "<td style='font-size:2.25em;'>" . $row['score'] . "</td>";
                     }
                   


                echo "</tr>";
            }
            echo "</table>";
        }
    }
    CloseCon($conn);  
}

function print_player_level_table() {
 $conn = OpenCon();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo "<h3>Player Ranking (10 being the highest, an experinced and most competitve)</h3>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Level</th>";
    echo "<th>Level</th>";
    for ($x = 10; $x >= 0; $x--) {
    echo "<tr>";
    echo "<td>".$x."</td>";
   // echo "</tr>";
//    echo "<tr>";
    echo "<td id='".$x."'>No Player on this level</td>";
    echo "</tr>";
        
}
     echo "</table>";
    
 
    
    /* show my score */
    $sql = "SELECT player_name, player_lvl FROM player_level order by player_lvl"; 

    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            $players_string0 = '';
            $players_string1 = '';
            $players_string2 = '';
            $players_string3 = '';
            $players_string4 = '';
            $players_string5 = '';
            $players_string6 = '';
            $players_string7 = '';
            $players_string8 = '';
            $players_string9 = '';
            $players_string10 = '';
            
            
            while($row = $result->fetch_array()){
              
                 //   console_log('row level:'.$row['player_lvl']);
                
                    if ($row['player_lvl']=='0') { $players_string0 .= $row['player_name']. "... ";}
                    if ($row['player_lvl']=='1') { $players_string1 .= $row['player_name']. "... ";}
                    if ($row['player_lvl']=='2') { $players_string2 .= $row['player_name']. "... ";}
                    if ($row['player_lvl']=='3') { $players_string3 .= $row['player_name']. "... ";}                 if ($row['player_lvl']=='4') { $players_string4 .= $row['player_name']. "...";}
                    if ($row['player_lvl']=='5') { $players_string5 .= $row['player_name']. "... ";}                
                    if ($row['player_lvl']=='6') { $players_string6 .= $row['player_name']. "... ";}
                    if ($row['player_lvl']=='7') { $players_string7 .= $row['player_name']. "... ";}
                    if ($row['player_lvl']=='8') { $players_string8 .= $row['player_name']. "... ";}
                    if ($row['player_lvl']=='9') { $players_string9 .= $row['player_name']. "... ";}    
                    if ($row['player_lvl']=='10') { $players_string10 .= $row['player_name']. "... ";}    
                
            }
            
            if (empty($players_string0)){echo "<script>document.getElementById('0').innerHTML = 'No Players on this level'</script>";} else {echo "<script>document.getElementById('0').innerHTML = '".$players_string0."'</script>";}
            if (empty($players_string1)){echo "<script>document.getElementById('1').innerHTML = 'No Players on this level'</script>";} else {echo "<script>document.getElementById('1').innerHTML = '".$players_string1."'</script>";}
            if (empty($players_string2)){echo "<script>document.getElementById('2').innerHTML = 'No Players on this level'</script>";} else {echo "<script>document.getElementById('2').innerHTML = '".$players_string2."'</script>";}
            if (empty($players_string3)){echo "<script>document.getElementById('3').innerHTML = 'No Players on this level'</script>";} else {echo "<script>document.getElementById('3').innerHTML = '".$players_string3."'</script>";}
            if (empty($players_string4)){echo "<script>document.getElementById('4').innerHTML = 'No Players on this level'</script>";} else {echo "<script>document.getElementById('4').innerHTML = '".$players_string4."'</script>";}
            if (empty($players_string5)){echo "<script>document.getElementById('5').innerHTML = 'No Players on this level'</script>";} else {echo "<script>document.getElementById('5').innerHTML = '".$players_string5."'</script>";}
            if (empty($players_string6)){echo "<script>document.getElementById('6').innerHTML = 'No Players on this level'</script>";} else {echo "<script>document.getElementById('6').innerHTML = '".$players_string6."'</script>";}
            if (empty($players_string7)){echo "<script>document.getElementById('7').innerHTML = 'No Players on this level'</script>";} else {echo "<script>document.getElementById('7').innerHTML = '".$players_string7."'</script>";}
            if (empty($players_string8)){echo "<script>document.getElementById('8').innerHTML = 'No Players on this level'</script>";} else {echo "<script>document.getElementById('8').innerHTML = '".$players_string8."'</script>";}
            if (empty($players_string9)){echo "<script>document.getElementById('9').innerHTML = 'No Players on this level'</script>";} else {echo "<script>document.getElementById('9').innerHTML = '".$players_string9."'</script>";}
            if (empty($players_string10)){echo "<script>document.getElementById('10').innerHTML = 'No Players on this level'</script>";} else {echo "<script>document.getElementById('10').innerHTML = '".$players_string10."'</script>";}
            
        }
    }
    CloseCon($conn);  
}


function print_konk_log_table() {
 $conn = OpenCon();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    /* show my score */
    $sql = "SELECT date_played, player1_name, score1, player2_name, score2 FROM konk_log order by date_played desc"; 
    echo "<h3>Electronic book of Konk games completed</h3>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Date Played</th>";
    echo "<th>Player1</th>";
    echo "<th>Score1</th>";
    echo "<th>Player2</th>";
    echo "<th>Score2</th>";
    echo "</tr>";
    
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_array()){
                echo "<tr>";
                      echo "<td>" . date('F d, Y', strtotime($row['date_played'])) . "</td>";
                      
                      if ($row['score1']<=100){
                            if ($row['score1']==0){
                                echo "<td style='background-color:#45a049;'><b>" . $row['player1_name'] . "</b></td>";
                                echo "<td style='background-color:#45a049;'><b>" . $row['score1'] . "</b></td>";  
                                echo "<td> <img src='images/Chiva.png' style='vertical-align:middle;'/>" . $row['player2_name'] . "</td>";
                                echo "<td>" . $row['score2'] . "</td>";
                                
                            } else {
                                echo "<td style='background-color:#45a049;'><b>" . $row['player1_name'] . "</b></td>";
                                echo "<td style='background-color:#45a049;'><b>" . $row['score1'] . "</b></td>";  
                                echo "<td>" . $row['player2_name'] . "</td>";
                                echo "<td>" . $row['score2'] . "</td>";
                            }
    
                      } 

                      if ($row['score2']<=100){
                        if ($row['score2']==0){
                            echo "<td> <img src='images/Chiva.png' style='vertical-align:middle;'/>" . $row['player1_name'] . "</td>";
                            echo "<td>" . $row['score1'] . "</b></td>";  
                            echo "<td style='background-color:#45a049;'><b>" . $row['player2_name'] .  "</b></td>";
                            echo "<td style='background-color:#45a049;'><b>" . $row['score2'] .  "</b></td>";
                            
                        } else {
                            
                            echo "<td>" . $row['player1_name'] . "</td>";
                            echo "<td>" . $row['score1'] . "</td>";
                            echo "<td style='background-color:#45a049;'><b>" . $row['player2_name'] . "</b></td>";
                            echo "<td style='background-color:#45a049;'><b>" . $row['score2'] . "</b></td>"; 
                        }
                      }

                echo "</tr>";
            }
            echo "</table>";
        }
    }
    CloseCon($conn);  
}



function just_played($player) {
   $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT player from players where player='$player' and player_just_played = '1'";
    
    if($result = $conn->query($sql)){
    
        if($result->num_rows > 0){ 
            CloseCon($conn);
            return $result->num_rows ;
        }
        else {
            CloseCon($conn);
            return '0';
        }
        
        
    }    
    
//CloseCon($conn);          
} 

function did_opponent_knocked($player) {
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT player from players where player='$player' and knocked = '1'";
    
    if($result = $conn->query($sql)){
    
        if($result->num_rows > 0){  
            CloseCon($conn);
            return $result->num_rows ;
        }
        else {
            CloseCon($conn);
            return '0';
        }
        
        
    }    
    
//CloseCon($conn);          
} 



//--- get the player that just played
function just_played_player() {
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT player from players where player_just_played = '1'";
    
    if($result = $conn->query($sql)){
    
        if($result->num_rows > 0){ 
			while($row = $result->fetch_array()){
							$player_last_played = $row['player'];  
		        CloseCon($conn);
				return $player_last_played;
			}	
        }
        else {
            CloseCon($conn);
            return 'uknown player';
        } 
        
    }    
    
//CloseCon($conn);          
} 

// -- return who delt last
function who_delt_last() {
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT player from players where dealer = '1'";
    
    if($result = $conn->query($sql)){
    
        if($result->num_rows > 0){ 
			while($row = $result->fetch_array()){
							$player_delt_last = $row['player'];  
		        CloseCon($conn);
				return $player_delt_last;
			}	
        }
        else {
            CloseCon($conn);
            return 'uknown player';
        } 
        
    }    
    
//CloseCon($conn);          
} 




//--- get the players real name 
function get_player_name($player) {
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT player_name from players where player='".$player."'";
    
    if($result = $conn->query($sql)){
    
        if($result->num_rows > 0){ 
			while($row = $result->fetch_array()){
							$players_name = $row['player_name'];  
		        CloseCon($conn);
				return $players_name;
			}	
        }
        else {
            CloseCon($conn);
            return 'uknown players name';
        } 
        
    }    
    
//CloseCon($conn);          
} 

function did_a_player_knocked() {
   $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT knocked from players where knocked='1'";
    
    if($result = $conn->query($sql)){
    
        if($result->num_rows > 0){ 
			while($row = $result->fetch_array()){
							$players_knock_val = $row['knocked'];  
		        CloseCon($conn);
				return $players_knock_val;
			}	
        }
        else {
            CloseCon($conn);
            return '0';
        } 
        
    }    
    
//CloseCon($conn);          
} 

function get_players_name($player) {
   $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT player_name from players where player='$player'";
    
    if($result = $conn->query($sql)){
    
        if($result->num_rows > 0){ 
			while($row = $result->fetch_array()){
							$players_name = $row['player_name'];  
		        CloseCon($conn);
				return $players_name;
			}	
        }
        else {
            CloseCon($conn);
            return 'Name is not set in table players';
        } 
        
    }    
    
//CloseCon($conn);          
} 

function get_picked_card($player) {
   $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT card_delt from hand where player='$player' and card_picked='1'";
    
    if($result = $conn->query($sql)){
    
        if($result->num_rows > 0){ 
			while($row = $result->fetch_array()){
							$card_picked = $row['card_delt'];  
		        CloseCon($conn);
				return $card_picked;
			}	
        }
        else {
            CloseCon($conn);
            return 'XXX';
        } 
        
    }    
    
//CloseCon($conn);          
} 


function draw_a_card($player){
  $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }     
    
    $sql = "SELECT card FROM deck WHERE draw='0' order by RAND() limit 1"; 

    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_array()){
                $card_drawn = $row['card'];  
                
                $sql = "UPDATE deck SET draw='1' WHERE card='$card_drawn'";
                
                $conn->query($sql); 
                
                /* insert into hand table */
                $sql = "INSERT INTO hand (player, card_delt)
                VALUES ('$player', '$card_drawn')";
                
                $conn->query($sql); 
                
                /* update all players last hand to 0 */
              //  $sql = "UPDATE players SET player_just_played = '0'";
                
             //   $conn->query($sql);
                
                /* update players last hand to 1 for the player send as parameter */
             //   $sql = "UPDATE players SET player_just_played = '1' where player='$player'";
                
              //  $conn->query($sql);
                
                // Free result set
                $result->free();
                
                CloseCon($conn);
                return $card_drawn; 
            }
           
            
        } 
    }
//CloseCon($conn);  
}

function re_shuffle_deck(){
   $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    
     $sql = "UPDATE deck SET draw = '0' where 1=1";  
      
     $conn->query($sql); 
    
      
     $sql = "UPDATE hand, deck SET draw = '1' WHERE deck.card = hand.card_delt";  
      
     $conn->query($sql); 
           
    
    CloseCon($conn); 
    
    return '1';
} 
    
function set_just_played_flag($player){
   $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    
       /* update all players last hand to 0 */
                $sql = "UPDATE players SET player_just_played = '0'";
                
                $conn->query($sql);
                
                /* update players last hand to 1 for the player send as parameter */
                $sql = "UPDATE players SET player_just_played = '1' where player='$player'";

		$conn->query($sql);
           
    
    CloseCon($conn); 
    
    return '1';
} 

//----- player is knocking ---- 
function player_is_knocking($player){
  $conn = OpenCon();
    
    $player_orginal_par = $player;
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }     
    
	// switch player so you can count the cards of the opponent
	if ($player=='guest') {
		$player = 'host';
	} else {
		$player = 'guest';
	}
	
	
    $sql = "SELECT card_delt FROM hand WHERE player='$player'"; 

    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
			$player_score = 0;
			$card_value = 0;
            while($row = $result->fetch_array()){
                
				$card = $row['card_delt'];  
				
				$card_suit = substr($card,0,1);
                $card_number = substr($card,-1);
				
				// --- convert the 10, K, J, Q to 10 points ----
				if ($card_number == '0' || $card_number == 'Q' || $card_number == 'K' || $card_number == 'J') {
					$card_value = 10;
				} else {
					$card_value = $card_number;
				}
				
				$player_score = $player_score + $card_value;

			}	
				//--- code to get the exisiting score of the player so we can then add it
                $sql1 = "select score from players where player='$player'";
                $result1 = $conn->query($sql1);
                 if($result1->num_rows > 0){
                    $player_saved_score = 0;
            
                    while($row = $result1->fetch_array()){
                        $player_saved_score = $row['score'];     
            
                    }
                 }
            
				//-------------------
			    $player_score = $player_score + $player_saved_score;
                $sql = "UPDATE players SET score='$player_score' where player='$player'";
                
                $conn->query($sql); 
            
                //--- reset player just played
                $sql = "UPDATE players SET player_just_played='0'";
                
                $conn->query($sql); 
            
                //--- record the last person to do the knock and just played
                $sql = "UPDATE players SET player_just_played='1', knocked='1' where player='$player_orginal_par'";
                
                $conn->query($sql); 
            
                //--- reset the deck
                $sql = "UPDATE deck SET draw='0'";            
                $conn->query($sql); 
            
				
                // Free result set
                $result->free();
            
                CloseCon($conn);  
                return 1; // this value is used to show the opponents hand
            
           
            
        } 
    }
//CloseCon($conn);  
}


function check_for_knock($player){
  $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }     
    
    $sql = "SELECT player, card_delt FROM hand WHERE player='$player' order by card_delt"; 

    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            $x = 1; 
            while($row = $result->fetch_array()){
                
                $card_drawn = $row['card_delt'];
                
                if ($x==1) {
                    $card_suit = substr($card_drawn,0,1);
                    $card_number = substr($card_drawn,-1);
                    
                } else {
                    $card_suit = $card_suit . substr($card_drawn,0,1);
                    $card_number = $card_number . substr($card_drawn,-1);
                }
                
                $x++; 
               
              //  echo "card:".$card_drawn;
               //    echo "<br>";
                
            }
            
          //  echo "-----:".$card_number;
          //  echo "<br>";
          //  echo "&&&&&: ".$card_suit;
            
            
            if ((($card_suit=='SSS' || $card_suit=='CCC' || $card_suit=='HHH' || $card_suit=='DDD') and ($card_number=='123' || $card_number=='234' || $card_number=='345' || $card_number=='456' || $card_number=='567' || $card_number=='678' || $card_number=='789' || $card_number=='890' || $card_number=='089' || $card_number=='90J' || $card_number=='09J' || $card_number=='0JQ' || $card_number=='JQK' || $card_number=='JKQ')) OR ($card_number=='111' || $card_number=='222' || $card_number=='333' || $card_number=='444' || $card_number=='555' || $card_number=='666' || $card_number=='777' || $card_number=='888' || $card_number=='999' || $card_number=='000' || $card_number=='JJJ' || $card_number=='QQQ' || $card_number=='KKK')) {

                $player_can_knock = '1';
                
            } else { $player_can_knock = '0'; }    
                
        } 
                
            // Free result set
            $result->free();
           
        
          CloseCon($conn);
          return $player_can_knock;
         // return $card_suit;
    }
//CloseCon($conn);  
}

function check_if_player_won(){
  $conn = OpenCon();
     
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }     
  
    $sql = "SELECT player_name, score FROM players"; 
    
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            $x = 1; 
            while($row = $result->fetch_array()){
            
                if ($x==1){
                    $player1_score = $row['score'];
                    $player1_name = $row['player_name'];
                    
                } else {
                   
                    $player2_score = $row['score'];
                    $player2_name = $row['player_name'];
                    
                }
                    
                
                $x++; 
            }
            
            // Free result set
            $result->free();
            
            $player_won = 'AA';
            
            if ($player1_score > 100){
                $player_won = $player1_name; 
            }
            
             if ($player2_score > 100){
                $player_won = $player2_name; 
            }
            
            If ($player1_score > 100 or $player2_score> 100){
                // go inser the score to the konk_log table  
                $insert_par = insert_score_into_log($player1_name, $player2_name, $player1_score, $player2_score);
                // -- set the level of the players that that they have been recorded in the konk_log
                set_player_level();
            }
            
            
                         
        } 
        
    }
CloseCon($conn);  
return $player_won;
    
    
}

function insert_score_into_log($player1_name, $player2_name, $player1_score, $player2_score){
  $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }     
            
    // -- lets make sure that the players are in a match by checking the rule. Its only a match if the players level differ by 2 levels
    // -- For Ex: L3 can only play a L1, L9 and only play a L7. 

    $sql = "SELECT player_name, player_lvl from player_level where player='$player1_name'";   
    if($result = $conn->query($sql)){
    
        if($result->num_rows > 0){ 
			while($row = $result->fetch_array()){
							$player1_level = $row['player_lvl'];  
			}	
        }   
    }  
    $sql = "SELECT player_name, player_lvl from player_level where player='$player2_name'";   
    if($result = $conn->query($sql)){
    
        if($result->num_rows > 0){ 
			while($row = $result->fetch_array()){
							$player2_level = $row['player_lvl'];  
			}	
        }   
    }  

    // -- check if it is a valid madtch 
    $player_level_delta = $player1_level - $player2_level;

    if (abs($player_level_delta)<=2) {
        $match_play = 1;

    } else {
        $match_play = 0; 
    }


    /* insert into hand table */
    $sql = "INSERT INTO konk_log (player1_name, player2_name, score1, score2, match_game) VALUES ('$player1_name', '$player2_name', '$player1_score', $player2_score, $match_play)";    
    $conn->query($sql); 
 
      /* insert into hand table */
    $sql = "UPDATE players set score='0'";    
    $conn->query($sql); 
    
    CloseCon($conn);
    return '1';; 

}
           



function shuffle_deck($player_delt_last) {
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
                   
    $sql = "UPDATE deck SET draw='0' WHERE 1=1";
    $conn->query($sql);
                
     $sql = "DELETE from hand WHERE 1=1";
     $conn->query($sql);
     
     $sql = "DELETE from played WHERE 1=1";
     $conn->query($sql);
    
     /* update all players last hand to 0 */
     $sql = "UPDATE players SET player_just_played = '0', knocked='0', dealer='0'";
     $conn->query($sql);
    
    //echo "Player that delt last" . $player_to_deal;
    
    if ($player_delt_last=='host'){
        
        $player_to_deal = 'guest';
        
    } else { $player_to_deal = 'host';}
    
    //echo "Player that will deal" . $player_to_deal;
    
     /* update players dealer status */
     $sql = "UPDATE players SET dealer = '1', player_just_played='1' where player='$player_to_deal'";
     $conn->query($sql);
          
     
     CloseCon($conn);
     return '1';
}

function deal_cards(){
   $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
        
     // -- this function will return the actual person that is dealing as the flag was set in shuffle_deck(); 
    if (who_delt_last()=='host'){
        $player_3_cards = 'host';
        $player_4_cards = 'guest';       
    } 
    if (who_delt_last()=='guest'){
        $player_3_cards = 'guest';
        $player_4_cards = 'host';
        
    } 
    
    /*draw a random card */
    $sql = "SELECT card FROM deck WHERE draw='0' order by RAND() limit 1"; 
    for ($x = 1; $x <= 7; $x++) {
            if($result = $conn->query($sql)){
                if($result->num_rows > 0){
                    while($row = $result->fetch_array()){
                     //   echo "<tr>";

                        $card_drawn = $row['card'];  

                        $card =  substr($card_drawn,0,1);

                        $sql1 = "UPDATE deck SET draw='1' WHERE card='$card_drawn'";
                        $conn->query($sql1);

                        
                         
                        // do the first three card to host then the last 4 to guest
                        if ($x <= 3) {

                            $player = $player_3_cards;
                        } else {

                            $player = $player_4_cards;
                        }

                        /* insert into hand table */
                        $sql1 = "INSERT INTO hand (player, card_delt) VALUES ('$player', '$card_drawn')";
                        $conn->query($sql1);
                    }
                    // Free result set
                    $result->free();
                } 
            } 
    }
    return '1';
    CloseCon($conn);  
  
    
}


function set_player_level(){
   $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
        // -- reset the level for all players then run this function to re-calculate
       $sql5 = "UPDATE player_level SET player_lvl = '0'";
       $conn->query($sql5);

    
    /*read table konk_log*/
    $sql = "SELECT player1_name, score1, player2_name, score2, date_played FROM konk_log WHERE match_game='1' order by date_played"; 
            $player_won_count = 0;
            $player_lost_count = 0;

            $player_won_name = '';
            $player_lost_name = '';
    
            $player1_lost_name = '';
    

            $arraywin = array();
            $arraylost = array();
            
            $posW = 1;
            $posL = 1;

    
            if($result = $conn->query($sql)){
                if($result->num_rows > 0){
                    while($row = $result->fetch_array()){

                        $player1_score = $row['score1'];
                       // $player2_score = $row['score2'];

                       $date_played = $row['date_played'];
                       $player_to_update = $row['player1_name']; // -- used with date_played

                        
                        // find the winner
                        if ($player1_score<=100){ 
                            $player_won_name = $row['player1_name'];
                            $player_lost_name = $row['player2_name'];
                        
                        }
                        else { 
                            
                            $player_won_name = $row['player2_name'];
                            $player_lost_name = $row['player1_name'];
                        
                        }
                       
                        $arraywin[$posW] = $player_won_name;
                        $posW += 1;
                        $arraylost[$posL] = $player_lost_name;
                        $posL += 1;

                    // --update the reconciled flad as being a processed records
                    //    $sql5 = "UPDATE konk_log SET reconciled = '1' where player1_name='$player_to_update' and date_played='$date_played'";
                    //    $conn->query($sql5);


                    }


                    $arraywinLength = count($arraywin);
                        
                    $i = 1;
                    $k = 0;
                    $f = 0;
                    $numoflos = 0;
                    $numofwin = 0;
                    
                    $lost_player = $arraylost[1];
                    $won_player = $arraywin[1];

                    $arraylvllos = array();
                    $arraylvlwin = array();
                    
                  
                    while ($i <= $arraywinLength) // - same for both arrays
                     {
                        if ($lost_player==$arraylost[$i]) {
                             $numoflos += 1;

                        } else {

                            if ($numoflos>=3){
                                $k += 1;
                                $arraylvllos[$k]= $arraylost[$i-1];
                                $k += 1;
                                $arraylvllos[$k]=$numoflos; // follow the loser with the number of losses

                                 // -- player to deduct lvl
                                // need to save the level to discount in the array
                            }
                            $numoflos = 1;
                            $lost_player = $arraylost[$i]; // change player
                        }
                        
        
                        // - winners
                        if ($won_player==$arraywin[$i]) {
                            $numofwin += 1;

                       } else {

                           if ($numofwin>=3){
                                $f += 1;
                               $arraylvlwin[$f]= $arraywin[$i-1]; // -- player to add lvl
                               $f += 1;
                               $arraylvlwin[$f]=$numofwin; // follow the loser with the number of winners
                               // need to save the level to discount in the array
                           }
                           $numofwin = 1;
                           $won_player = $arraywin[$i]; // change player
                       }


                       //  $arraywin[$i];

                        $i++;
                     }
                     // after the while loop
                     // -- check the last record for losers
                     if ($numoflos>=3){
                        $k += 1;
                        $arraylvllos[$k]= $arraylost[$i-1];
                        $k += 1;
                        $arraylvllos[$k]=$numoflos; // follow the loser with the number of losses
                     }
                    // -- check the last record of winners
                    if ($numofwin>=3){
                        $f += 1;
                        $arraylvlwin[$f]= $arraywin[$i-1];
                        $f += 1;
                        $arraylvlwin[$f]=$numofwin; // follow the loser with the number of winners
                    }
                            
                            //-- lets update the ranking for the winners
                            $i=1;
                            $arraywinLength = count($arraylvlwin);
                             // get the players name 

                            // add level of player has won more than 3 times
                            while ($i <= $arraywinLength) {

                                $remainder = $i % 2; // -- index is even, then contains the number
                             if ($remainder==0){       
                                switch ($arraylvlwin[$i]){
                                    case 3:
                                        $level_to_add_to_player = 1;
                                        break;
                                     case 4:
                                        $level_to_add_to_player = 2;
                                        break;
                                      case 5:
                                        $level_to_add_to_player = 3;
                                        break;
                                      case 6:
                                        $level_to_add_to_player = 4;
                                        break;
                                      case 7:
                                        $level_to_add_to_player = 5;
                                        break;
                                      case 8:
                                        $level_to_add_to_player = 6;
                                        break;
                                      case 9:
                                        $level_to_add_to_player = 7;
                                        break;
                                      case 10:
                                        $level_to_add_to_player = 8;
                                        break;
                                      case 11:
                                        $level_to_add_to_player = 9;
                                        break;
                                      case 12:
                                        $level_to_add_to_player = 10;
                                        break;
                                      default:
                                        $level_to_add_to_player = 10;
                                } // -- end of switch
                                
                            } else {
                                        // - array index is off means its a name of a player
                                         $winning_player = $arraylvlwin[$i];
                                         $level_to_add_to_player = 0;   
                                       }
                                    //--if
                                       
                                        
                           
                                if ($level_to_add_to_player > 0){
                                    // console_log('$level_to_add_to_player'.$level_to_add_to_player);
                                    //--- code to get the level from player so we can then add levels earned
                                    $sql1 = "SELECT player_lvl from player_level where player_name='$winning_player'";
                                    $result1 = $conn->query($sql1);
                                        if($result1->num_rows > 0){
                                        $player_saved_score = 0;

                                            while($row = $result1->fetch_array()){
                                                $winning_player_saved_level = $row['player_lvl'];     

                                            }
                                        }

                                    //-------------------
                                    $new_winning_player_level = $winning_player_saved_level + $level_to_add_to_player;
                                    if ($new_winning_player_level > 10) {$new_winning_player_level=10;}
                                    $sql = "UPDATE player_level SET player_lvl='$new_winning_player_level' where player_name='$winning_player'";

                                    $conn->query($sql);
                                }                 
                               
                                $i++; // -- array increment
                           }
                                
                                //-- lets update the ranking for the winners
                                $i=1;
                                $arraywinLength = count($arraylvllos);
                                // get the players name 

                                // substracts level of player that has lost 3 or more times
                                while ($i <= $arraywinLength) {

                                    $remainder = $i % 2; // -- index is even, then contains the number
                                if ($remainder==0){       
                                    switch ($arraylvllos[$i]){
                                        case 3:
                                            $level_to_sub_to_player = 1;
                                            break;
                                        case 4:
                                            $level_to_sub_to_player = 2;
                                            break;
                                        case 5:
                                            $level_to_sub_to_player = 3;
                                            break;
                                        case 6:
                                            $level_to_sub_to_player = 4;
                                            break;
                                        case 7:
                                            $level_to_sub_to_player = 5;
                                            break;
                                        case 8:
                                            $level_to_sub_to_player = 6;
                                            break;
                                        case 9:
                                            $level_to_sub_to_player = 7;
                                            break;
                                        case 10:
                                            $level_to_sub_to_player = 8;
                                            break;
                                        case 11:
                                            $level_to_sub_to_player = 9;
                                            break;
                                        case 12:
                                            $level_to_sub_to_player = 10;
                                            break;
                                        default:
                                            $level_to_sub_to_player = 10;
                                    } // -- end of switch
                                    
                                } else {
                                            // - array index is off means its a name of a player
                                            $lost_player = $arraylvllos[$i];
                                            $level_to_sub_to_player = 0;   
                                        }
                                        //--if
                                        
                                            
                            
                                    if ($level_to_sub_to_player > 0){
                                        // console_log('$level_to_add_to_player'.$level_to_add_to_player);
                                        //--- code to get the level from player so we can then add levels earned
                                        $sql1 = "SELECT player_lvl from player_level where player_name='$lost_player'";
                                        $result1 = $conn->query($sql1);
                                            if($result1->num_rows > 0){
                                            $player_saved_score = 0;

                                                while($row = $result1->fetch_array()){
                                                    $lost_player_saved_level = $row['player_lvl'];     

                                                }
                                            }

                                        //-------------------
                                        $new_lost_player_level = $lost_player_saved_level - $level_to_sub_to_player;
                                        if ($new_lost_player_level < 0) {$new_lost_player_level=0;}
                                        $sql = "UPDATE player_level SET player_lvl='$new_lost_player_level' where player_name='$lost_player'";

                                      //  will not commit per Tio Willie  $conn->query($sql);  
                                    }                 
                                
                                    $i++; // -- array increment
                            }
                                                            

                    // Free result set
                    $result->free();
                } 
            } 
    
    
    CloseCon($conn);  
  
    
}

// -- print the number of wins per player and the average gap (diff between the scores)
function print_players_stats(){
    $conn = OpenCon();
     
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     } 
         // -- reset the level for all players then run this function to re-calculate
      //  $sql5 = "UPDATE player_level SET player_lvl = '0'";
       // $conn->query($sql5);
 
     
     /*read table konk_log*/
     $sql = "SELECT player1_name, score1, player2_name, score2, date_played FROM konk_log WHERE match_game='1' order by date_played"; 
             $player_won_count = 0;
             $player_lost_count = 0;
 
             $player_won_name = '';
             $player_lost_name = '';
     
             $player1_lost_name = '';
     
 
             $arraywin = array();
             $arraylost = array();
             
             $posW = 1;
             $posL = 1;
 
     
             if($result = $conn->query($sql)){
                 if($result->num_rows > 0){
                     while($row = $result->fetch_array()){
 
                         $player1_score = $row['score1'];
                        // $player2_score = $row['score2'];
 
                        $date_played = $row['date_played'];
                        $player_to_update = $row['player1_name']; // -- used with date_played
 
                         
                         // find the winner
                         if ($player1_score<=100){ 
                             $player_won_name = $row['player1_name'];
                             $player_lost_name = $row['player2_name'];
                         
                         }
                         else { 
                             
                             $player_won_name = $row['player2_name'];
                             $player_lost_name = $row['player1_name'];
                         
                         }
                        
                         $arraywin[$posW] = $player_won_name;
                         $posW += 1;
                         $arraylost[$posL] = $player_lost_name;
                         $posL += 1;
 
        
 
                     }
 
 
                     $arraywinLength = count($arraywin);
                         
                     $i = 1;
                     $k = 0;
                     $f = 0;
                     $numoflos = 0;
                     $numofwin = 0;
                     
                     $lost_player = $arraylost[1];
                     $won_player = $arraywin[1];
 
                     $arraylvllos = array();
                     $arraylvlwin = array();
                     
                     echo "<table>";
                     echo "<th>Players with 3 or more block of consecutive wins</th>";
                     echo "<th>Wins per block.  Hint! 3+ consecutive wins will move a player 1 level+ on the ranking table above</th>";
                     
                     while ($i <= $arraywinLength) // - same for both arrays
                      {
                         if ($lost_player==$arraylost[$i]) {
                              $numoflos += 1;
 
                         } else {
 
                             if ($numoflos>=3){
                                 $k += 1;
                                 $arraylvllos[$k]= $arraylost[$i-1];
                                 $k += 1;
                                 $arraylvllos[$k]=$numoflos; // follow the loser with the number of losses
 
                                  // -- player to deduct lvl
                                 // need to save the level to discount in the array
                             }
                             $numoflos = 1;
                             $lost_player = $arraylost[$i]; // change player
                         }
                         
         
                         // - winners
                         if ($won_player==$arraywin[$i]) {
                             $numofwin += 1;
 
                        } else {
 
                            if ($numofwin>=3){
                                
                                $h = $i-1;
                                echo "<tr>";
                                echo "<td>";
                                echo $arraywin[$h];
                                echo "</td>";
                                echo "<td>";
                                echo $numofwin;
                                echo "</td>";
                                
                                $f += 1;
                                $arraylvlwin[$f]= $arraywin[$i-1]; // -- player to add lvl
                                $f += 1;
                                $arraylvlwin[$f]=$numofwin; // follow the loser with the number of winners
                                // need to save the level to discount in the array
                            }
                            $numofwin = 1;
                            $won_player = $arraywin[$i]; // change player
                        }
 
                        //  $arraywin[$i];
 
                         $i++;
                      }
                      echo "</tr>";
                    //  echo "</table>";
                   //   echo "<br>";

                    //  echo "<table>";
                    //  echo "<th align='left'>Number of Wins per Player</th>";
                      echo "<td>";
                    
                      echo "<b>Number of Wins per Player --></b>";              
                      echo "<td>";
                      echo print_r(array_count_values($arraywin));
                      echo "</td>";
                      echo "</tr>";
                      echo "</table>";
                      
                      // after the while loop
                      // -- check the last record for losers
                      if ($numoflos>=3){
                         $k += 1;
                         $arraylvllos[$k]= $arraylost[$i-1];
                         $k += 1;
                         $arraylvllos[$k]=$numoflos; // follow the loser with the number of losses
                      }
                     // -- check the last record of winners
                     if ($numofwin>=3){
                         $f += 1;
                         $arraylvlwin[$f]= $arraywin[$i-1];
                         $f += 1;
                         $arraylvlwin[$f]=$numofwin; // follow the loser with the number of winners
                     }
                                                                    
 
                     // Free result set
                     $result->free();
                 } 
             } 
     
     
     CloseCon($conn);  
   
     
 }




function discard_card($card_to_discard, $player){
    
 $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
                   
    $sql = "INSERT into played (card_played, player) values ('$card_to_discard','$player')";  
    $conn->query($sql);
      
                
    $sql = "DELETE from hand WHERE card_delt='$card_to_discard'";
    $conn->query($sql); 
    
      $sql = "UPDATE hand set card_picked='0'";
    $conn->query($sql); 
                
                
    /* update all players last hand to 0 */
 //   $sql = "UPDATE players SET player_just_played = '0'";    
  //  $conn->query($sql);
    
    /* update players last hand to 1 for the player send as parameter */
  //  $sql = "UPDATE players SET player_just_played = '1' where player='$player'";
   // $conn->query($sql);                
            
    
    CloseCon($conn);  
    return '1';
       
    
}

function pick_from_table ($card_to_pick, $player){
    
    session_start();
         
    $conn = OpenCon();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    // --- remove the knock in case the player picks another card
    $sql = "UPDATE players SET knocked='0'";         
    $conn->query($sql);   
      
      
      
    $sql = "INSERT into hand (card_delt, player, card_picked) values ('$card_to_pick','$player','1')";
    
    $conn->query($sql); 
                
    $sql = "DELETE from played WHERE card_played='$card_to_pick'";
    
    $conn->query($sql); 
                        
    CloseCon($conn);
    
    unset($_SESSION['knocking']);
          
    
}

// -- print to Google Chrome console for debugging 
// call it like this... console_log($variable);
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}



?>
