<?php   


//include 'konkdb_connection.php';
include 'query_functions.php';

$player_with_low_score  = player_lowest_points();

echo "result----> ". $player_with_low_score;

?>
