<?php

        session_start();

        try {
            $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_dbv3;charset=utf8",
                            "team22@ibe-database",
                            "ILoveCS17");
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        $notificazione = $conn -> prepare("SELECT c.communicationID, message, messagedate, isBuyer FROM communication c JOIN Notification n ON c.communicationID = n.communicationID 
        WHERE receiverID = ? AND n.unread = 1");
        $notificazione -> execute([$_SESSION['user_ID']]);
        $notificazione = $notificazione -> fetchAll();

        $commIDs = array();

        // storing communication Id for the upcoming SQL query, and the notifications in the session variable so they can be kept in the notifications box in the menu.
        foreach ($notificazione as $notificazion) {
            array_push($commIDs, $notificazion['communicationID']);
            $newNotification = array( "message" => $notificazion['message'], "messagedate" => $notificazion['messagedate']);
            array_push($_SESSION['notifications'], $newNotification);

        }
        $commIDs = implode(',', $commIDs);


        $query2 = $conn->prepare("UPDATE Notification SET unread = 0 WHERE communicationID in (?) ");
        $query2->execute([$commIDs]);

        $jsondata = json_encode($notificazione);


        echo $jsondata;

?>
