<?php


$query = $conn->prepare("SELECT * FROM communication WHERE receiverID = ?");

$result = $query->execute([$_SESSION['user_ID']]);

$_SESSION['notifications'] = $result;



?>