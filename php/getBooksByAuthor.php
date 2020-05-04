<?php 
header("Content-Type: text/xml");
header("Cache-Control: no-cahe, must-revalidate");

include("dbConnect.php");

$name = $_GET['name'];

$stmt = $db->prepare("SELECT * FROM literature WHERE ID_Book IN (SELECT FID_Book FROM BOOK_AUTHORS WHERE FID_AUTHORS = (SELECT ID_Authors FROM authors Where name = ?));");
$stmt->execute(array($name));

echo "<?xml version='1.0' encoding='utf-8'?>";
echo "<books>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr><td style = 'border: 1px solid'>".$row['name']."</td></tr>";
}
echo "</books>";
?>