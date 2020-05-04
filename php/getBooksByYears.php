<?php 
include("dbConnect.php");

$string1 = $_GET['yearStart'];
$string2 = $_GET['yearEnd'];

$stmt = $db->prepare("SELECT * FROM `literature` WHERE `year` >= ? AND `year` <= ?;");
$stmt->execute(array($string1, $string2));

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr><td style = 'border: 1px solid'>".$row['name']."</td></tr>";
}
?>
