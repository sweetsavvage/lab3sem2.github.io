<?php 
include("dbConnect.php");

$publisher = $_GET['publisher'];

$stmt = $db->prepare("SELECT `name` FROM `literature` WHERE `publisher`= ?");
$stmt->execute(array($publisher));

$result = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    array_push ($result, $row['name']);
}
echo json_encode($result);
?>