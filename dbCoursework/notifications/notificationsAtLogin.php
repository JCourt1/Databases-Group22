<?php


$query = $conn->prepare("SELECT * FROM communication WHERE receiverID = ?");

$result = $query->execute([$_POST['user_ID']]);

$_SESSION['notifications'] = $result;



?>