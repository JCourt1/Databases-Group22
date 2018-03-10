<?php


$query = $conn->prepare("SELECT * FROM communication WHERE receiverID = ? AND unread = 1");
$query->execute([$_SESSION['user_ID']]);
$count = $query->rowCount();
$result = $query->fetchall();

$query2 = $conn->prepare("UPDATE communication SET unread = 0 WHERE receiverID = ? AND unread = 1");
$query2->execute([$_SESSION['user_ID']]);

$_SESSION['notifications'] = $result;
$_SESSION['notificationsCount'] = $count;

$_SESSION['notificationsBoxRead'] = FALSE;



?>