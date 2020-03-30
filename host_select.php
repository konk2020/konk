<!-- 10host select file -->

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Konk The Game</title>
<style type-"text/css">
    table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;

}

tr:nth-child(even) {
    background-color: white;
}

    
</style>

</head>
  <body>
    <h2>------- HOST --------</h2>  
	<h2><a href="/">Go Back</a></h2>
	<br>
	<h2><a href="/host_select.php">Refresh</a></h2>
	
	<table>
	    <tr>
	        <th>Card Drawn</th>
	    </tr>
	  
	    
<?php

include 'query_functions.php';


//include 'konkdb_connection.php';

$conn = OpenCon();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$cards_in_hand = count_cards('host'); 

$host_just_played = just_played('host');

//echo "host just played value ". $host_just_played;
//echo "cards in hand: ". $cards_in_hand;

$player_par = $_POST["player"];
$draw_par = $_POST["draw"];

    if ($cards_in_hand < 4 and $host_just_played=='0') {
//       echo "The number of cards read in hand for host is: " . $cards_in_hand;
       echo "<br>";
//       echo "<h2><a href='/host_select.php'>Draw a Card</a></h2>";
       
       echo "<form method='post' action='host_select.php'> <input type='hidden' name='player' value='host'> <input type='hidden' name='draw' value='yes'> <input type='submit' value='Draw1 Card'></input></form>";
       echo "<br>";
       
            if ($draw_par == "yes"){
                /*draw a card */
                $card_drawn_from_deck = draw_a_card('host');
                $draw_par == "no";
            }
       
       
    }


$card_suit =  substr($card_drawn_from_deck,0,1);


            echo "<tr>";
            

           if ($card_suit == "C"){
                $imagepath = "\images\Clubs". substr($card_drawn_from_deck,-1) . ".png";
            }
            else if ($card_suit == "D"){
                $imagepath = "\images\Diamonds". substr($card_drawn_from_deck,-1) . ".png";
            } else if ($card_suit == "H"){
                $imagepath = "\images\Hearts". substr($card_drawn_from_deck,-1) . ".png";
            } else if ($card_suit == "S"){
                $imagepath = "\images\Spades". substr($card_drawn_from_deck,-1) . ".png";
            }    
                
            // show the card value and the image
            echo "<td>" . $card_drawn_from_deck . "&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath'>" . "</td>";
            echo "</tr>";      
            


/* how many cards does host has in his hands */
$cards_in_hand = count_cards('host'); 

/* check to see if the flag is set to yes=1, it means he will not draw */
$host_just_played = just_played('host');

/* if host has 3 cards and he was not the last player to play then we show the Draw a Card link */
if ($cards_in_hand < 4 and $host_just_played='0') {
   echo "The number of cards read in hand for host is: " . $cards_in_hand;
   echo "<br>";
   echo "<h2><a href='/host_select.php'>Draw a Card</a></h2>";
   echo "<br>";
}


/* show my hand */
$sql = "SELECT * FROM hand where player = 'host' order by card_delt"; 
echo "<table>";
echo "<tr>";
echo "<th>Player</th>";
echo "<th>Hand</th>";
echo "</tr>";
if($result = $conn->query($sql)){
    if($result->num_rows > 0){
        while($row = $result->fetch_array()){
            echo "<tr>";
            
            $card_delt = $row['card_delt'];  

            
            $card =  substr($card_delt,0,1);
            
            if ($card == "C"){
                $imagepath = "\images\Clubs". substr($card_delt,-1) . ".png";
             //   echo $imagepath;
            }
            else if ($card == "D"){
                $imagepath = "\images\Diamonds". substr($card_delt,-1) . ".png";
            //    echo $imagepath;
            } else if ($card == "H"){
                $imagepath = "\images\Hearts". substr($card_delt,-1) . ".png";
          //      echo $imagepath;
            } else if ($card == "S"){
                $imagepath = "\images\Spades". substr($card_delt,-1) . ".png";
        //        echo $imagepath;
            }    
                
                  echo "<td>" . $row['player'] . "</td>";
                  echo "<td>" . $row['card_delt'] . "&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath'>" . "<form method='post' action='played.php'> <input type='hidden' name='card_to_discard' value='". $row['card_delt'] . "'><input type='hidden' name='player' value='host'> <input type='submit' value='Discard'></input></form>" . "</td>";
            
                
            //    echo "<td>" . $row['card_delt'] . "</td>";
            
            echo "</tr>";
        }
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
echo "<table>";
echo "<tr>";
echo "<th>Player</th>";
echo "<th>Last card played, pick it up if you need it.</th>";
echo "</tr>";
if($result = $conn->query($sql)){
    if($result->num_rows > 0){
        while($row = $result->fetch_array()){
            echo "<tr>";
            
            $last_card_played = $row['card_played'];  
            
            $card =  substr($last_card_played,0,1);
            
            if ($card == "C"){
                $imagepath = "\images\Clubs". substr($last_card_played,-1) . ".png";
             //   echo $imagepath;
            }
            else if ($card == "D"){
                $imagepath = "\images\Diamonds". substr($last_card_played,-1) . ".png";
            //    echo $imagepath;
            } else if ($card == "H"){
                $imagepath = "\images\Hearts". substr($last_card_played,-1) . ".png";
          //      echo $imagepath;
            } else if ($card == "S"){
                $imagepath = "\images\Spades". substr($last_card_played,-1) . ".png";
        //        echo $imagepath;
            }    
                
                  echo "<td>" . $row['player'] . "</td>";
                    echo "<td>" . $row['card_played'] . "&nbsp;&nbsp;&nbsp;" . "<img src='$imagepath'>" . "<form method='post' action='table_pick.php'> <input type='hidden' name='card_to_pick' value='". $row['card_played'] . "'><input type='hidden' name='player' value='host'> <input type='submit' value='Pick it up'></input></form>" . "</td>";
           //       echo "<td>" . $row['card_played'] . "&nbsp;&nbsp;&nbsp;" . "//<img src='$imagepath'>" . "</td>";
            //      echo "<td>" . "<img src='$imagepath'>". "</td>";
                 
            
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        $result->free();
    } else{
        echo "No cards on the table to pick";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . $conn->error;
}





CloseCon($conn);

?>	    
 



</table>
</body>
</html>