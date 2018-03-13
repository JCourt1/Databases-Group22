<?php


function writeOutbidNotification($receiver, $sendingUser, $currentPrice, $itemName) {

//    global $conn;

    try {
                $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_dbv3;charset=utf8",
                                "team22@ibe-database",
                                "ILoveCS17");
            }
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }

    $notification = '' . $sendingUser . 'outbid you on '.$itemName.' with a bid of ' . $currentPrice;


    try {

                $conn->beginTransaction();

                // 6 is admin
            $insertCommunication = $conn->prepare("INSERT INTO communication (senderID, receiverID, message) VALUES (6, ".$receiver.", \"".$notification."\")");
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

    global $conn;



    $notification = '' . $sendingUser . ' placed a bid of '.$currentPrice.' on your item: ' . $itemName;
    var_dump($notification);
    echo $notification;

    try {

                    $conn->beginTransaction();

//                    6 is admin
                $insertCommunication = $conn->prepare("INSERT INTO communication (senderID, receiverID, message) 
VALUES (6, ".$sellerID.", \"".$notification."\")");

                $insertCommunication -> execute();

                $lastid = $conn->lastInsertId();

                $insertNotifications = $conn->prepare("INSERT INTO notification (communicationID, unread, isBuyer) VALUES (".$lastid.", 1, 0)");
                $insertNotifications -> execute();

                $conn->commit();

        } catch (Exception $e) {
                    echo $e->getMessage();
                    $conn->rollBack();
        }


}

?>
