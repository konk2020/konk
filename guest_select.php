<?php
// Author: Rihcard A. Negron
// Date: March 1, 2020
// Purpose: Main php file that both players used to play konk

    // allow the used of global variables
	session_start();
    
// un-comment to display PHP errors
   //  ini_set('display_errors', 1);
  

// -- all the functions for the game reside
include_once 'query_functions.php';

// -- set the player parameter to nothing
$player_par = "";
$keep_playing_btn_pressed = "no";

// -- is the player parameter sent via a form submit, then set all  passing parameters to variables
if (isset($_POST['player'])) {
	
	$player_par = $_POST['player'];
	$draw_par = $_POST['draw'];
    $re_shuffle_par = $_POST['re_shuffle'];
    $shuffle_deck_par = $_POST['shuffle']; // yes/no
    // -- discard
    $discard_one_par = $_POST['discard_one']; // yes/no
    $card_to_discard_par = $_POST['card_to_discard']; // actual card to discard
    // -- end of discard
    $card_picked = $_POST['pick_from_table']; // yes/no
    $card_pick_from_table_par = $_POST['card_to_pick'];
    $knock_btn_pressed = $_POST['knock'];
    $keep_playing_btn_pressed = $_POST['keep_going']; //yes/no

    console_log("DISCARD (yes/no): ". $discard_one_par );
    console_log("DISCARD Card: ".  $card_to_discard_parr );
   
    
    console_log("keep button pressesed :". $keep_playing_btn_pressed);

    
    if (($keep_playing_btn_pressed=='yes' and get_last_player_who_discarted_card()==$player_par) and 
     (check_for_knock($player_par)=='1' || check_for_knock($player_par)=='A' )){
    // -- this players has can knock and discarted a card already, if he presses the Keep Player is should go to the other player    
    //-- move to the next player
    console_log ("111AAAAAAAAAAAAAAAAAAA");
            set_just_played_flag($player_par);
    }




    if ($keep_playing_btn_pressed=='yes'){
        // -- a player press the continue playing button. They most likely going for KONK!!!
        //-- save the keep playing variables into the  global variables

            $_SESSION['keep_going'] = $player_par;
        
    } 

    // -- reset global variable 
    if (just_played($player_par)=='1' and isset($_SESSION['keep_going'])){
        // -- players goes and the button for keep going has not been pressed
        unset($_SESSION['keep_going']);
    }

    //else {
        // -- when the form is refreshed then check if the button is pressed if not unset the global variable
   //     unset($_SESSION['keep_going']);
    //        }
  //
  

    //console_log('$keep_playing_btn_pressed-->'.$keep_playing_btn_pressed);
    

    // -- player has one of the konks
    // 1) Return 1 for normal knock - 3 of a kind, or straight
    // 2) Return A for AC2C - player know with 4 points (2 Ace and a 2 of any suit)
    // 3) Return K for KONK - player has a 4 cards straight of the same suit

    // this btn only shows when player has one of the above - they can decide to continue playing
   
}
	
// -- GET is used if the parameter is coming from a link URL - not being used 
if (isset($_GET['player'])){
    $player_par = $_GET['player'];
}
	
?> 
<!-- END of PHP block -->


<!-- START of HTML block -->

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
<!-- uses the java script file refresh_form.js to refresh the page using the player parameter  -->
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
           

<!-- END of HTML block  -->


<!-- START of NEW PHP block -->
<?php
 
//-- opens the DB connections where the game settings and cards reside
$conn = OpenCon();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// -- sends player as parameter and checks for winning hand
// return 1, normaml knock
// return A, AC2C 2 aces and duce
// return K, is KONK straight of same suit + 4th card 
$player_ready_to_knock = check_for_knock ($player_par); // returns 1/A/K

// -- find the number of cards the player has in his hand 
$cards_in_hand = count_cards($player_par); // returns # of cards in hand

// -- find out if the player just played (meaning discarded a card)
$player_just_played = just_played($player_par); // -- reurns 1=yes or 0=no
        
// -- checks the scores if a player won by causing the other player to go over 100 points it will insert into konk_log table
// -- it will also set the player's level (ranking) after the score is recorded
$player_won = check_if_player_won($player_par); // returns name of player (not guest or host, the actual name, ex: Richard)      
        

echo "<tr>";
echo "<td>"; 
          
//console_log('$knock_btn_pressed '.$knock_btn_pressed);
//console_log('$$player_par:'.$player_par);
//console_log('who_delt_last_func_return:'.who_delt_last());
//console_log('$shuffle_deck_par:'.$shuffle_deck_par);  
//console_log('did_a_player_knocked_func_return:'.did_a_player_knocked()); 
//console_log('did_game_start_func_return:'.did_game_start());          
                    

if ($player_just_played=='1' and did_a_player_knocked()<>'1') {
        

        $knock_code = check_for_knock($player_par); // returns 1/A/K if there is a knock in position

     //   console_log("player just played: ".$player_just_played);
     //   console_log("did a player knocked: ".did_a_player_knocked());
     //   console_log("knock code: ".$knock_code);
     //   console_log('keep playing -->'.$_SESSION['keep_playing']);
     //   console_log('$discard_one_par -->'.$discard_one_par);
     //   console_log('$keep_playing_btn_pressed -->'.$keep_playing_btn_pressed);
        
        echo "<img src='images/Wait.gif'>"; 

        } else {  
                if (did_a_player_knocked()=='1'){
                        // a player knocked
                        if ($player_par == who_delt_last()){
                            // function who_delt_last returns the player who delt last (host or guest)
                            // player delt last so show the wait for shuffle 
                            echo "<img src='images/Waitforshuffle.gif'>"; 
                        }
                        
                        // -- game starts with 7 cards
                        if (did_game_start()=='7'){
                            // -- game started
                            echo "<img src='images/Your_Turn.gif'>";
                            
                        } else {    // game did not start but check if the shuffle btn was pressed
                                    if ($shuffle_deck_par=='yes'){
                                            // shuffle cards
                                            echo "<img src='images/Processing.gif'>";

                                    } else { if ($player_par <> who_delt_last()) {
                                                // -- player's turn to shuffle
                                                echo "<img src='images/Shuffle.gif'>";
                                                }
                                        }
                                        
                            }            
                    // -- players did not knock     
                    }  else {    
                                if ($discard_one_par=='yes'){
                                    // -- player discarded a card
                                    // -- just put processing image until the page refreshes, then wait will show up
                                    echo "<img src='images/Processing.gif'>"; 
                                    // -- global variable used to show card was picked, time to flip back  
                                    unset($_SESSION['flip_card_pick_from_table']); // -- flip the card back 
                                    
                                } else { 
                                
                                         echo "<img src='images/Your_Turn.gif'>";
                                        
                                    }
                                
                            } 
            }
      


echo "</td>"; 
echo "<td>";          

    if ((count_cards($player_par) == '3' and $player_just_played=='0') || did_a_player_knocked()=='1') {
       // -- a player knocked, current player has three cards and was not the one that played last 
       
        if (did_a_player_knocked()<>'1'){
           // no player knocked
            
           if (check_reshuffle()=='1') {
               // -- ran out of cards, show the btn to allow the player to re-shuffle the deck
               echo "<form method='post' action='guest_select.php'> <input type='hidden' name='player' value='".$player_par."'> <input type='hidden' name='re_shuffle' value='yes'> <input type='submit' class='submit' value='Re-Shuffle Deck'></input></form>";
               echo "<br>";   
               
           }   else { // -- no need to re-shuffle
                     console_log("VALUE of PAR:--> ".$draw_par);


                     if ($card_picked !== 'yes' and $draw_par !== 'yes' and 
                     check_for_knock($player_par)<>'1' and check_for_knock($player_par)<>'A' 
                     and check_for_knock($player_par)<>'K'){
                    
                    // -- card was not picked, no draw, and keep playing was not pressed (this btn also happens when player has knock btn available)
                    // show Dra1 Card btn
                        if ($draw_par =='yes' || $card_picked=='yes') {

                            if ($draw_par =='yes'){
                                echo "Card Drawn!";
                            } else {echo "Card Picked!";}

                        } else {

                            if (get_last_player_who_discarted_card()<>$player_par){
                                // -- only show if player hasent discarted a card
                            echo "<form method='post' action='guest_select.php'> <input type='hidden' name='player' value='".$player_par."'>
                            <input type='hidden' name='draw' value='yes'> <input type='submit' class='submit' value='Draw1 Card'></input></form>";
                            echo "<br>"; 
                        }

                        }

                     
                     } else {

                            if (isset($_SESSION['keep_going'])) {
                                // -- the button was been press to keep going (means the player has some type of konk)
                                if ($draw_par =='yes' || $card_picked=='yes') {
                                    
                                    if ($draw_par =='yes'){
                                        echo "Card Drawn!";
                                    } else {echo "Card Picked!";}
                                    
                                } else { 

                                    if (get_last_player_who_discarted_card()<>$player_par){
                                        // -- only show if player hasent discarted a card
                                    echo "<form method='post' action='guest_select.php'> <input type='hidden' name='player' value='".$player_par."'>
                                    <input type='hidden' name='draw' value='yes'> <input type='submit' class='submit' value='Draw1 Card'></input></form>";
                                    echo "<br>"; 
                                    }
                                }
                            }

                     }
               
           } 
           
        } // player knocked
        else { 

            if ($shuffle_deck_par <> 'yes'){
                // -- player did not suffle 
                if ($player_par <> who_delt_last()) {
                    // -- player turn to deal cards
                    // -- show shuffle cards btn
                        echo "<form method='post' action='guest_select.php'> <input type='hidden' name='player' value='".$player_par."'> <input type='hidden' name='shuffle' value='yes'> <input type='submit' class='submit' value='Shuffle Cards'></input></form>";
                                  echo "<br>"; }
            
            
            }
            
        }
        
     
        
       
       if ($draw_par == 'yes'){
                // -- draw a card 
                $card_drawn_from_deck = draw_a_card($player_par);           
                $_SESSION['card_drawn_from_deck'] = $card_drawn_from_deck; // use for the border around the card
                $_SESSION['card_pick_from_table'] = ''; // avoid two cards being selected
                $draw_par == "drawn";
        } else {unset($_SESSION['card_drawn_from_deck']);} // reset global variable
        
        // --- re-shuffle
        if ($re_shuffle_par == 'yes'){
                // -- re-shuffle the deck 
                $re_shuffled = re_shuffle_deck();
                $re_shuffle_par == "no";
        }
    
        if ($shuffle_deck_par == 'yes'){
                // -- shuffle the deck after knowck
                $player_delt_last = who_delt_last();
                $shuffle_deck_rtn = shuffle_deck($player_delt_last); // returns 1=success!
                $deal_cards_rtn = deal_cards(); // returns 1=success!
                $shuffle_deck_par == "no";
        }  
        
    }

    echo "</td>";
    echo "<td>";  

    // -- returns 1=match play, 2=not a match play
    if (checK_if_valid_match()==1) {
        // match play so show the belt image 

            echo "<img src='images/Matchbelt.png' width='250' height='125'>";
    }        
    else {
         // not a match show why not
        echo "<h3>Not a match play. You have to be within 2 levels of your opponent.";
    }       

    echo "</td>";

    echo "</tr>"; 
    echo "</table>";      

        
        if ($discard_one_par=='yes' || $knock_btn_pressed=='yes'){        
              // btn to discard was pressed or knocked btn pressed, or keep playing btn pressed
                if ($discard_one_par=='yes'){
                    // keep playing btn was not pressed, so process the discard card    
                    $discard_one_rtn = discard_card($card_to_discard_par, $player_par); // returns 1=success!
                    console_log("HERERERERREREREREREERRR");
                    if ((check_for_knock($player_par)<>'1' and check_for_knock($player_par)<>'A') and 
                    (get_last_player_who_discarted_card() == $player_par))
                    {
                        //-- move to the next player, this means that the user could knock, drew a card but was not KONK 
                        set_just_played_flag($player_par);
                    }

                }
            
                if (check_for_knock($player_par)=='1' || check_for_knock($player_par)=='A' 
                    || check_for_knock($player_par)=='K'){
                      
                    // -- player can knock but did not press keep playing btn
                    if ($knock_btn_pressed =='yes') {
                        // -- knock btn pressed, go ahead and record the score
                        $player_knocked = player_is_knocking($player_par, check_for_knock($player_par)); // record the score
                        $_SESSION['knocking'] = 'yes'; // -- set global variable 
                    }
                    
                } else { 
                    console_log("SETTING PLAYED FLAG");
                    // -- discarded card but is not a knock, then move to the other player
                    if (check_for_knock($player_par)=='A' || check_for_knock($player_par)=='1' || check_for_knock($player_par)=='K'){
                            // -- is not used anywhere
                            $hand_to_knock = check_for_knock($player_par);

                    } else {
                        console_log("ooooooooooooooooooooooooooo");
                        $set_just_played_flag_rtn = set_just_played_flag($player_par); // returns 1 (this function was added as a trigger instead)
                        unset($_SESSION['knocking']);
                        unset($_SESSION['keep_going']); // since moving to the other player reset

                    }
                    
                }
            
                    
                $discard_one_par = "no";
            
        }    
    
       if ($card_picked == 'yes'){        
              // -- user picked a card from the table
                $discard_one_rtn = pick_from_table($card_pick_from_table_par, $player_par);
                $_SESSION['card_pick_from_table']=$card_pick_from_table_par; // use for the border around the card
                $_SESSION['flip_card_pick_from_table']=$_SESSION['card_pick_from_table']; 
                $card_picked = "picked";
            
        }  else {/*unset($_SESSION['card_pick_from_table']);*/ unset($_SESSION['flip_card_pick_from_table']); }
    
    
    
$card_suit =  substr($card_drawn_from_deck,0,1);

/* how many cards does guest has in his hands */
$cards_in_hand = count_cards($player_par); 

/* check to see if the flag is set to yes=1, it means he will not draw */
$player_just_played = just_played($player_par);


/* show the knock button with the keep playing button */                  
    echo "<h2>". get_players_name($player_par)." (". $player_par.") hand </h2>";
	
    echo "<table>";
    console_log("SHOW KP knocking hand code:--> ".check_for_knock($player_par));
    console_log("SHOW KP did a player knock code:--> ".did_a_player_knocked());
    console_log("SHOW KP did player just played code:--> ".$player_just_played);
    console_log("GV SHOW KP player PRESSED keep going:--> ".$_SESSION['keep_going']);
    
    if ((check_for_knock($player_par)=='1' || check_for_knock($player_par)=='A' 
         || check_for_knock($player_par)=='K') and (did_a_player_knocked()=='0') and $player_just_played<>'1'){        // player has a knock hand, no player has knocked, and player just played 
         // -- player has a knocking hand, player has not knocked, and player has not played   
            echo "<tr>";
            echo "<td>";
            echo "<center>";
            echo "<form method='post' action='guest_select.php'> <input type='hidden' name='player' value='".$player_par."'> 
            <input type='hidden' name='knock' value='yes'> <input type='submit' class='submit' style='background-color:#d2d1f9;' value='You can Knock!!'></input></form>";
            echo "</center>";
            echo "<td>";    

            if (check_for_knock($player_par)<>'K' and !isset($_SESSION['keep_going'])){
                //-- dont show KEEP PLAYING if is a KONK hand, show for any other Knock code as they may want to go for the KONK
                //-- dont show if the global variable is set for the player = player pressed the continue button
                echo "<td>";
                echo "<center>";
                echo "<form method='post' action='guest_select.php'> <input type='hidden' name='player' value='".$player_par."'> 
                <input type='hidden' name='keep_going' value='yes'><input type='submit' class='submit' value='Keep Playing!!'></input>
                </form>";
                echo "</center>";
                echo "</td>"; 
            } else {

                if (get_last_player_who_discarted_card()==$player_par){

                    echo "<td>";
                    echo "<center>";
                    echo "<form method='post' action='guest_select.php'> <input type='hidden' name='player' value='".$player_par."'> 
                    <input type='hidden' name='keep_going' value='yes'><input type='submit' class='submit' value='Keep Playing!!'></input>
                    </form>";
                    echo "</center>";
                    echo "</td>"; 


                }

            }
    }

// -- show my hand
$sql = "SELECT * FROM hand INNER JOIN deck on hand.card_delt=deck.card where player ='".$player_par."' order by  deck.order, deck.suit_order"; 
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
					
                       echo "<td>&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath' width='150' height='200'></td>";
                       
                       }  
                    else { 
                        
               
                        if ($cards_in_hand == '3' and $player_just_played=='0') {
                            // -- 3 cards in hand and opponent just played
                          echo "<td>&nbsp;&nbsp;&nbsp;" . "<img id='" . $row['card_delt'] . "' src='$imagepath' width='100' height='150'></td>";
                        }
                        else {   if ($_SESSION['card_drawn_from_deck']==$row['card_delt'] or 
                                    $_SESSION['card_pick_from_table']==$row['card_delt']) {
console_log($_SESSION['card_drawn_from_deck']);
console_log($_SESSION['card_pick_from_table']);

                                        $border_val='4px';} 
                                        else {
                                            $border_val='0px';
                                        }
                    
                            echo "<td>&nbsp;&nbsp;&nbsp;"."<form action='guest_select.php' method='post'><input type='hidden' name='card_to_discard' value='". $row['card_delt'] . "'>
                            <input type='hidden' name='player' value='".$player_par."'> <input type='hidden' name='discard_one' value='yes'> 
                            <input type='image' src='$imagepath' width='100' height='150' border='".$border_val."' id='" . $row['card_delt'] . "' alt='Submit' /></form>"."</td>"; 
                                       
                        }    
                            
                        }        
            
        }
   //     echo "</tr>";
   //     echo "</table>";
        // Free result set
        $result->free();
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . $conn->error;
}

//-- show the 4th card 

if ($_SESSION['KONK']=='yes'){

 //   include 'players_4hand.php';
   echo "<tr>";
   echo "</table>";


} else {

       echo "</tr>";
	   echo "</table>";
}

/* show last card played this is used if the player did KONK */
$sql = "SELECT * FROM played order by time_card_played DESC limit 1"; 

 //   echo "<td align='left'>";
    echo "<h2> ". get_players_name(just_played_player())." discard</h2>";
  //  echo "</td>";
   // echo "</tr>";
   // echo "</table>";
    echo "<table>";

if($result = $conn->query($sql)){
    if($result->num_rows > 0){
        while($row = $result->fetch_array()){
            echo "<tr>";
            
            $last_card_played = $row['card_played'];  
            
        $card =  substr($last_card_played,0,1);
            
            if ($card == "C"){
                $imagepath = "images\Clubs". substr($last_card_played,-1) . ".png";
             
            }
            else if ($card == "D"){
                $imagepath = "images\Diamonds". substr($last_card_played,-1) . ".png";
            
            } else if ($card == "H"){
                $imagepath = "images\Hearts". substr($last_card_played,-1) . ".png";
          
            } else if ($card == "S"){
                $imagepath = "images\Spades". substr($last_card_played,-1) . ".png";
        
            }    

                    if (did_a_player_knocked()=='1'){
                        unset($_SESSION['KONK']);
                        
                        if (player_who_knocked()==$player_par) {
                               $knock_code = check_for_knock ($player_par);

                               switch ($knock_code) {
                                    case 'A':
                                        $imagepath = "images\AC2C.gif";
                                        break;
                                    case '1':
                                        $imagepath = "images\Knock.gif";
                                        break;
                                    case 'K':
                                        $imagepath = "images\KONK.gif";
                                        $_SESSION['KONK'] = 'yes';
                                        break;

                               } // - switch

                            } else {
                                    // -- the other player knocked
                                            $knock_code = check_for_knock (player_who_knocked());

                                            switch ($knock_code) {
                                                 case 'A':
                                                     $imagepath = "images\AC2C.gif";
                                                     break;
                                                 case '1':
                                                     $imagepath = "images\Knock.gif";
                                                     break;
                                                 case 'K':
                                                     $imagepath = "images\KONK.gif";
                                                     $_SESSION['KONK'] = 'yes';
                                                     break;
             
                                            } // - switch

                            }
   
                        } else {
                            
                            
                            unset($_SESSION['KONK']);}  

             
                   if (did_a_player_knocked()=='1' or just_played_player()==$player_par) { 
						// -- a player knocked or current player last to played		
                       
                        if (did_a_player_knocked()=='1'){
				            echo "<td>&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath' width='250' height='250'></td>";
                        }
                        else {
                            
                             echo "<td>&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath' width='100' height='150'></td>";
                        }
                       
                       }  
                    else { 
                   
                            console_log($cards_in_hand);
                            console_log("card picked---> ".$card_picked);
                            
                            if ($cards_in_hand == '3' and check_for_knock($player_par)<>'1' and check_for_knock($player_par)<>'A' 
                            and check_for_knock($player_par)<>'K' and $card_picked<>'picked'){
                                // -- show if the hand is 3 cards and no konk hand 
                                // --- show Pick it up button ---
                                if (get_last_player_who_discarted_card()<>$player_par){
                                    // -- only show if player has not discarted a card in table played
                                    echo "<td>&nbsp;&nbsp;&nbsp;" . "<form method='post' action='guest_select.php'> 
                                    <input type='hidden' name='card_to_pick' value='". $row['card_played'] . "'>
                                    <input type='hidden' name='player' value='".$player_par."'> <input type='hidden' name='pick_from_table' value='yes'>
                                    <input type='submit' class='submit' value='Pick it up'></input></form><img src='$imagepath' width='150' height='200'></td>"; 
                                }
                                
                            } else {
                                    // -- or is a konk hand and player wants to keep going but show only if 3 cards in hand
                                    if (isset($_SESSION['keep_going']) and $cards_in_hand == '3' and $card_picked<>'picked'){
                                      // -- only show if player has not discarted a card played
                                        if (get_last_player_who_discarted_card()<>$player_par){
                                        echo "<td>&nbsp;&nbsp;&nbsp;" . "<form method='post' action='guest_select.php'> 
                                        <input type='hidden' name='card_to_pick' value='". $row['card_played'] . "'>
                                        <input type='hidden' name='player' value='".$player_par."'> <input type='hidden' name='pick_from_table' value='yes'>
                                        <input type='submit' class='submit' value='Pick it up'></input></form><img src='$imagepath' width='150' height='200'></td>"; 
                                        }    
                                    } else {

                                            // --- show card on table without a Pick up BUTTON ---
                                            echo "<td>&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath' width='100' height='150'></td>";
                                    }
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

          
// show the oponents cards 

If ($player_par=='guest'){
	
	$_SESSION['player'] = 'host';
	
} else { 

	$_SESSION['player'] = 'guest'; 
}
//-- this is used for the index page in case the user goes back to try to see the opponets card
if ($player_par=='host') {
    $_SESSION['h_player_for_index'] = get_player_name($player_par);
} else {
    $_SESSION['g_player_for_index'] = get_player_name('guest');
}



echo "<td>";
include 'players_hand.php';
echo "</td>";

// show 4th card
if ($_SESSION['KONK']=='yes'){

  //  include 'players_4hand.php';

} else {

       echo "</tr>";
	   echo "</table>";
}

          
echo "</tr>";
echo "</table>";          
          

echo "<p><center>&copy; Konk The Game | version 2.0</p></center>";          


CloseCon($conn);

?>	    
 


</table>
</body>
</html>