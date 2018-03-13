<?php

try {
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_dbv3;charset=utf8",
                    "team22@ibe-database",
                    "ILoveCS17");
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}



$senderID = $_GET['senderID'];
$receiverID = $_GET['receiverID'];
$itemID = $_GET['itemID'];
$isPositive = $_POST['feedback'];
$from = $_GET['from'];

$feedback_query = $conn->prepare("UPDATE communication
                    SET isPositive = ?
                    WHERE communicationType = 'Feedback'
                    AND senderID = ?
                    AND receiverID = ?
                    AND itemID = ?");

$feedback_query->execute([$isPositive, $senderID, $receiverID, $itemID]);


header('Location: '.$from.'.php');


 ?>
