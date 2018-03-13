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

        $notificazione = $conn -> prepare("SELECT message, messagedate, isBuyer FROM communication WHERE receiverID = ? and unread = 1");
        $notificazione -> execute([$_SESSION['user_ID']]);
        $notificazione = $notificazione -> fetchAll();


        $query2 = $conn->prepare("UPDATE communication SET unread = 0 WHERE receiverID = ? ");
        $query2->execute([$_SESSION['user_ID']]);

        $jsondata = json_encode($notificazione);


        echo $jsondata;

?>