<?php
  
	session_start();
	
   //  ini_set('display_errors', 1);
  
include_once 'query_functions.php';


$player_par = "";

if (isset($_POST['player'])) {
	
	$player_par = $_POST['player'];
	$draw_par = $_POST['draw'];
    $re_shuffle_par = $_POST['re_shuffle'];
    $shuffle_deck_par = $_POST['shuffle'];
    $card_to_discard_par = $_POST['card_to_discard'];
    $discard_one_par = $_POST['discard_one'];
    $card_picked = $_POST['pick_from_table']; // yes/no
    $card_pick_from_table_par = $_POST['card_to_pick'];

//	echo "<h2>Your are the ". $player_par. "</h2>";

}
	
// --- coming from link get the value

if (isset($_GET['player'])){
    $player_par = $_GET['player'];
}

//echo "---coming from link or form----->" . $player_par;
	
	
?>


<!-- guest select file -->

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  
    
<title>Konk The Game</title>
<style type="text/css">
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

.submit {
  background-color: #4CAF50;
  border: none;
  color: black;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 25px;
  margin: 4px 2px;
  cursor: pointer;
  font-weight: 900;
}
    
</style>

<script src='refresh_form.js'></script>
    
</head>
  <body>
      <table>
      <tr>
      <td>Welcome to Konk The Game</td>  
      <td><a href='.'>Go HOME</a></td> 
	
	 <td><span>Form will automatically submit in <b id='timer'>3</b> <b>seconds</b>.</span></td> 
     <form method='post' id='form1' action='guest_select.php'> 
	 <input type='hidden' name='player' value="<?php echo $player_par; ?>">
<!--	 <input type='submit' name="submitbtn" class='submit' value='Refresh Page'></input> -->     
	 </form>	
     </tr>
           
	    
<?php
 

$conn = OpenCon();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$player_ready_to_knock = check_for_knock ($player_par);

//echo "player ready to know..... ". $player_ready_to_knock;


$cards_in_hand = count_cards($player_par); 

$guest_just_played = just_played($player_par);
        
$player_won = check_if_player_won($player_par);       
        
//echo "Shuffle deck parameter " . $shuffle_deck_par;
echo "<tr>";
echo "<td>"; 
          
console_log('$guest_just_played:'.$guest_just_played);
console_log('$$player_par:'.$player_par);
console_log('who_delt_last_func_return:'.who_delt_last());
console_log('$shuffle_deck_par:'.$shuffle_deck_par);  
console_log('did_a_player_knocked_func_return:'.did_a_player_knocked()); 
console_log('did_game_start_func_return:'.did_game_start());          
                    
          
if ($guest_just_played=='1' and did_a_player_knocked()<>'1') {

   echo "<img src='images/Wait.gif'>"; 
    
} else { if (did_a_player_knocked()=='1'){
                // -- 7 cards starts the game
                if ($player_par == who_delt_last()){
                    echo "<img src='images/Waitforshuffle.gif'>"; 
                }
    
                if (did_game_start()=='7'){
                    echo "<img src='images/Your_Turn.gif'>";
                    
                } else {
                            if ($shuffle_deck_par=='yes'){
                                    echo "<img src='images/Processing.gif'>";
                            } else { if ($player_par <> who_delt_last()) {echo "<img src='images/Shuffle.gif'>";}}
                                
                      }            
                
            }  else {    // -- just put processing image until the page refreshes, then wait will show up
                        if ($discard_one_par=='yes'){
                          
                            echo "<img src='images/Processing.gif'>"; 
                            console_log('RESETING the GLOBAL VAR flip_card_pick_from_table');   
                            unset($_SESSION['flip_card_pick_from_table']); // -- flip the card back 
                            
                        } else {echo "<img src='images/Your_Turn.gif'>"; }
                        
                    } 
       }
echo "</td>"; 
echo "<td>";          
//echo "Player who won parameter > ".$player_won;       
          console_log('count_cards_func_return:'.count_cards($player_par)); 
          console_log('$guest_just_played:'.$guest_just_played); 
    if ((count_cards($player_par) == '3' and $guest_just_played=='0') or did_a_player_knocked()=='1') {
  //     echo "The number of cards read in hand for guest is: " . $cards_in_hand;
     //  echo "<br>";
//       echo "<h2><a href='/guest_select.php'>Draw a Card</a></h2>";
       
        if (did_a_player_knocked()<>'1'){
           // don't show the draw button
            
           if (check_reshuffle()=='1') {
             
               echo "<form method='post' action='guest_select.php'> <input type='hidden' name='player' value='".$player_par."'> <input type='hidden' name='re_shuffle' value='yes'> <input type='submit' class='submit' value='Re-Shuffle Deck'></input></form>";
              echo "<br>";   
               
           }   else {
               
                     if ($card_picked !== 'yes'){
                      echo "<form method='post' action='guest_select.php'> <input type='hidden' name='player' value='".$player_par."'> <input type='hidden' name='draw' value='yes'> <input type='submit' class='submit' value='Draw1 Card'></input></form>";
                      echo "<br>"; 
                     }
               
           } 
           
        } // player knocked
        else { console_log('else portion.... to show Shuffle Cards button');   
            if ($shuffle_deck_par <> 'yes'){
                
                if ($player_par <> who_delt_last()) {
                
                        echo "<form method='post' action='guest_select.php'> <input type='hidden' name='player' value='".$player_par."'> <input type='hidden' name='shuffle' value='yes'> <input type='submit' class='submit' value='Shuffle Cards'></input></form>";
                                  echo "<br>"; }
            
            
            }
            
        }
        
     
        
       
       if ($draw_par == 'yes'){
                /*draw a card */
                $card_drawn_from_deck = draw_a_card($player_par);           
                $_SESSION['card_drawn_from_deck'] = $card_drawn_from_deck; // use for the border around the card
                $draw_par == "no";
        } else {unset($_SESSION['card_drawn_from_deck']);}
        
        // --- re-shuffle
        if ($re_shuffle_par == 'yes'){
                /*draw a card */
                $re_shuffled = re_shuffle_deck();
                $re_shuffle_par == "no";
        }
        // suffle after knock
        if ($shuffle_deck_par == 'yes'){
                /*draw a card */
                $player_delt_last = who_delt_last();
                $shuffle_deck_rtn = shuffle_deck($player_delt_last);
                $deal_cards_rtn = deal_cards();
                $shuffle_deck_par == "no";
        }
        
        
        
        
    }

    echo "</td>";

    echo "<td>";  
    if (checK_if_valid_match()==1) {
            echo "<img src='images/Matchbelt.png' width='250' height='125'>";
    }        
    else {
        echo "<h3>Not a match play, will not count for player ranking. You must play a player nor more than 2 levels down from you.";
    }       

    echo "</td>";

    echo "</tr>"; 
    echo "</table>";      
  
    
        //echo "==============>   " . $discard_one_par;
        
        if ($discard_one_par=='yes'){        
              /*draw a card */
                $discard_one_rtn = discard_card($card_to_discard_par, $player_par);
            
                if (check_for_knock($player_par)=='1'){
                    
                    $player_knocked = player_is_knocking($player_par); // record the score
                    $_SESSION['knocking'] = 'yes'; 
                    
                } else { 
                    // -- discarded card but is not a knock, then move to the other player
                    $set_just_played_flag_rtn = set_just_played_flag($player_par);
                    unset($_SESSION['knocking']); }
            
                $discard_one_par = "no";
            
        }    
    
       if ($card_picked == 'yes'){        
              /*draw a card */
                console_log('$card_pick_from_table_par:'.$card_pick_from_table_par);
                $discard_one_rtn = pick_from_table($card_pick_from_table_par, $player_par);
                $_SESSION['card_pick_from_table']=$card_pick_from_table_par; // use for the border around the card
                $_SESSION['flip_card_pick_from_table']=$_SESSION['card_pick_from_table']; 
                $card_picked = "no";
            
        }  else {unset($_SESSION['card_pick_from_table']); unset($_SESSION['flip_card_pick_from_table']); }
    
    
    
$card_suit =  substr($card_drawn_from_deck,0,1);


/* how many cards does guest has in his hands */
$cards_in_hand = count_cards($player_par); 

/* check to see if the flag is set to yes=1, it means he will not draw */
$guest_just_played = just_played($player_par);


/* show my hand */
//$sql = "SELECT * FROM hand where player ='".$player_par."' order by card_delt"; 
$sql = "SELECT * FROM hand INNER JOIN deck on hand.card_delt=deck.card where player ='".$player_par."' order by  deck.order, deck.suit_order"; 
                  
    echo "<h2>". get_players_name($player_par)." (". $player_par.") hand </h2>";
	
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
            
                   if ((did_a_player_knocked()=='1' or just_played_player()==$player_par) and count_cards($player_par)==3) { 
								// ----- no discard button --------
				      // echo "<td>" . $row['card_played'] . "&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath'></td>";
                       echo "<td>&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath' width='150' height='200'></td>";
                       
                       }  
                    else { 
                        
               
                        if ($cards_in_hand == '3' and $guest_just_played=='0') {
                                                // --- show discard button ---
                        //  echo $row['card_delt'];  
                          echo "<td>&nbsp;&nbsp;&nbsp;" . "<img id='" . $row['card_delt'] . "' src='$imagepath' width='100' height='150'></td>";
                        }
                        else {   if ($_SESSION['card_drawn_from_deck']==$row['card_delt'] or $_SESSION['card_pick_from_table']==$row['card_delt']){$border_val='4px';} else {$border_val='0px';}
                      //     echo $row['card_delt'];    
                     //      echo "<td>&nbsp;&nbsp;&nbsp;" . "<img border='".$border_val."' id='" . $row['card_delt'] . "' src='$imagepath' width='200' height='250'>" . "<form method='post' action='guest_select.php'> <input type='hidden' name='card_to_discard' value='". $row['card_delt'] . "'><input type='hidden' name='player' value='".$player_par."'> <input type='hidden' name='discard_one' value='yes'><input type='submit' class='submit' value='Discard'></input></form>" . "</td>"; 
                              
                         //  echo "<button type='submit' action='guest_select.php' formmethod='post' value='card'>//<img src='$imagepath' width='200' height='250' alt='card'><input //type='hidden' name='card_to_discard' value='". $row['card_delt'] . "'><input type='hidden' //name='player' value='".$player_par."'> <input type='hidden' name='discard_one' //value='yes'></button>";      
                        
                            echo "<td>&nbsp;&nbsp;&nbsp;"."<form action='guest_select.php' method='post'><input type='hidden' name='card_to_discard' value='". $row['card_delt'] . "'><input type='hidden' name='player' value='".$player_par."'> <input type='hidden' name='discard_one' value='yes'> <input type='image' src='$imagepath' width='100' height='150' border='".$border_val."' id='" . $row['card_delt'] . "' alt='Submit' /></form>"."</td>"; 
                          
                               //border='0' alt='Submit' style='width: 100px;' /></form>";                    
                              
                              
                        }    
                            
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

/*get last card played*/
$sql = "SELECT * FROM played order by time_card_played DESC limit 1"; 

    echo "<h2> ". get_players_name(just_played_player())." discard</h2>";
    echo "<table>";

if($result = $conn->query($sql)){
    if($result->num_rows > 0){
        while($row = $result->fetch_array()){
            echo "<tr>";
            
            $last_card_played = $row['card_played'];  
            
            $card =  substr($last_card_played,0,1);
            
            if ($card == "C"){
                $imagepath = "images\Clubs". substr($last_card_played,-1) . ".png";
             //   echo $imagepath;
            }
            else if ($card == "D"){
                $imagepath = "images\Diamonds". substr($last_card_played,-1) . ".png";
            //    echo $imagepath;
            } else if ($card == "H"){
                $imagepath = "images\Hearts". substr($last_card_played,-1) . ".png";
          //      echo $imagepath;
            } else if ($card == "S"){
                $imagepath = "images\Spades". substr($last_card_played,-1) . ".png";
        //        echo $imagepath;
            }    
                
             //     if (isset($_SESSION['knocking']) || did_opponent_knocked($player_par)=='1'){
			         
                    if (did_a_player_knocked()=='1'){
			
                //	echo "Knocking session variable not set";
                        $imagepath = "images\Knock.gif";
				     }  	
            
            
               //    echo "<td>" . $row['player'] . "</td>";
                   if (did_a_player_knocked()=='1' or just_played_player()==$player_par) { 
								// ----- no discard button --------
                       
                        if (did_a_player_knocked()=='1'){
				            echo "<td>&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath' width='250' height='250'></td>";
                        }
                        else {
                            
                             echo "<td>&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath' width='100' height='150'></td>";
                        }
                       
                       }  
                    else { 
                        
                        if ($cards_in_hand == '3'){
                             // --- show discard button ---
                        echo "<td>&nbsp;&nbsp;&nbsp;" . "<form method='post' action='guest_select.php'> <input type='hidden' name='card_to_pick' value='". $row['card_played'] . "'><input type='hidden' name='player' value='".$player_par."'> <input type='hidden' name='pick_from_table' value='yes'><input type='submit' class='submit' value='Pick it up'></input></form><img src='$imagepath' width='150' height='200'></td>"; 
                            
                            
                        } else {
                              // --- show discard button ---
                            echo "<td>&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath' width='100' height='150'></td>";
                            
                        }
                        
                      
                         }
            
                 
            
          //  echo "</tr>";
        }
      //  echo "</table>";
        // Free result set
        $result->free();
    } else{
        echo "No cards on the table to pick";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . $conn->error;
}

echo "<td>";
print_score_table();
echo "</td>"; 

          

// --------- show the oponents cards --------

//echo "oooooooo ".$player_par;
If ($player_par=='guest'){
	
	$_SESSION['player'] = 'host';
	
} else { 

	$_SESSION['player'] = 'guest'; 
}

echo "<td>";
include 'players_hand.php';
echo "</td>";
          
echo "</tr>";
echo "</table>";          
          

echo "<p><center>&copy; Konk The Game | version 1.0</p></center>";          


CloseCon($conn);

?>	    
 


</table>
</body>
</html>