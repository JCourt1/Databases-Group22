<?php


$query = $conn->prepare("SELECT * FROM communication JOIN Notification ON communication.communicationID = Notification.communicationID WHERE receiverID = ? AND Notification.unread = 1");
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
