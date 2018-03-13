<?php


function writeOutbidNotification($receiver, $sendingUser, $currentPrice, $itemName) {

//    global $conn;

    try {
                $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                                "team22@ibe-database",
                                "ILoveCS17");
            }
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }

    $notification = '' . $sendingUser . 'outbid you on '.$itemName.' with a bid of ' . $currentPrice;


    try {

                $conn->beginTransaction();

            $insertCommunication = $conn->prepare("INSERT INTO communication (senderID, receiverID, message) VALUES (".$_SESSION['user_ID'].", ".$receiver.", \"".$notification."\")");
            $insertCommunication -> execute();

            $lastid = $conn->lastInsertId();

            $insertNotifications = $conn->prepare("INSERT INTO Notification (communicationID, unread, isBuyer) VALUES (".$lastid.", 1, 1)");
            $insertNotifications -> execute();

            $conn->commit();

    } catch (Exception $e) {
                echo $e->getMessage();
                $conn->rollBack();
    }



}



function updateSeller($sellerID, $sendingUser, $currentPrice, $itemName) {

//    global $conn;

    try {
                $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                                "team22@ibe-database",
                                "ILoveCS17");
            }
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }

    $notification = '' . $sendingUser . ' placed a bid of '.$currentPrice.' on your item: ' . $itemName;
    $insertCommunication = $conn->prepare("INSERT INTO communication (senderID, receiverID, communicationtype, message) VALUES (".$_SESSION['user_ID'].", ".$sellerID.", \"Notification\", \"".$notification."\")");
    $insertCommunication->execute();


    try {

                    $conn->beginTransaction();

                $insertCommunication = $conn->prepare("INSERT INTO communication (senderID, receiverID, communicationtype, message) VALUES (".$_SESSION['user_ID'].", ".$receiver.", \"Notification\", \"".$notification."\")");
                $insertCommunication -> execute();

                $lastid = $conn->lastInsertId();

                $insertNotifications = $conn->prepare("INSERT INTO Notification (communicationID, unread, isBuyer) VALUES (".$lastid.", 0, 1)");
                $insertNotifications -> execute();

                $conn->commit();

        } catch (Exception $e) {
                    echo $e->getMessage();
                    $conn->rollBack();
        }

}

?>
