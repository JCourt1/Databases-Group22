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
    $insertNotifications = $conn->prepare("INSERT INTO communication (senderID, receiverID, communicationtype, message, isBuyer, unread) VALUES (".$_SESSION['user_ID'].", ".$receiver.", \"Notification\", \"".$notification."\", 1, 1)");
    $insertNotifications -> execute();
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
    $insertNotifications = $conn->prepare("INSERT INTO communication (senderID, receiverID, communicationtype, message, isBuyer, unread) VALUES (".$_SESSION['user_ID'].", ".$sellerID.", \"Notification\", \"".$notification."\", 0, 1)");
    $insertNotifications->execute();

}

?>
