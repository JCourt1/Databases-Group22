<?php


$query = $conn->prepare("SELECT * FROM communication c JOIN Notification n ON c.communicationID = n.communicationID WHERE receiverID = ? AND n.unread = 1");
$query->execute([$_SESSION['user_ID']]);
$count = $query->rowCount();
$result = $query->fetchall();



try {

        $conn->beginTransaction();
        $query2 = $conn->prepare("UPDATE Notification SET unread = 0 WHERE unread = 1 AND communicationID in (SELECT communicationID FROM communication WHERE receiverID = ?)");
        $query2->execute([$_SESSION['user_ID']]);
        $conn->commit();


} catch (Exception $e) {
            echo $e->getMessage();
            $conn->rollBack();
}



$_SESSION['notifications'] = $result;
$_SESSION['notificationsCount'] = $count;

$_SESSION['notificationsBoxRead'] = FALSE;



?>
