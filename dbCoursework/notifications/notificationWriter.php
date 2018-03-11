<?php


function writeOutbidNotification($receiver, $sendingUser, $amount, $item) {

//    global $conn;

    try {
                $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                                "team22@ibe-database",
                                "ILoveCS17");
            }
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }

    $message = $sendingUser . ' outbid you on '.$item.' with a bid of ' . $amount;
    $conn->query("INSERT INTO notifications (receiverID, message, isBuyer) VALUES (".$receiver.", ".$message.", 1);");
//    $query->execute();
}



function updateSeller($sellerID, $sendingUser, $amount, $item) {

//    global $conn;

    try {
                $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                                "team22@ibe-database",
                                "ILoveCS17");
            }
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }




    $message = $sendingUser . ' placed a bid of '.$amount.' on your item: ' . $item;
    $query = $conn->prepare("INSERT INTO notifications (receiverID, message, isBuyer) VALUES (".$sellerID.", ".$message.", 0;)");
    $query->execute();
}

?>
