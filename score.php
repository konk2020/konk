<?php




include 'konkdb_connection.php';

$conn = OpenCon();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



/* show my score */
$sql = "SELECT player_name, score FROM players"; 
echo "<table>";
echo "<tr>";
echo "<th>Player</th>";
echo "<th>Score</th>";
echo "</tr>";
if($result = $conn->query($sql)){
    if($result->num_rows > 0){
        while($row = $result->fetch_array()){
            echo "<tr>";
                    
                  echo "<td>" . $row['player_name'] . "</td>";
                  echo "<td>" . $row['score'] . "</td>";
                
            
            echo "</tr>";
        }
        echo "</table>";
    }
}
CloseCon($conn);  

?>

