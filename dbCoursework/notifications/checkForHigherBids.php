<?php

        try {
            $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                            "team22@ibe-database",
                            "ILoveCS17");
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        $bidID = $_POST['bidID'];
        $itemName = $_POST['itemName'];
        $itemID = $_POST['itemID'];
        $myHighestBid = $_POST['highestBid'];


        $check = $conn -> query("SELECT needsNotification FROM bids WHERE bidID = $bidID");
        $check = $check -> fetch();

        $newHighest = 0;
        $finalresult = "";

        if ($check != 0) {

            $result = $conn->prepare("SELECT bidID, bidDate, bidAmount, users.username FROM bids JOIN users 
                    on bids.buyerID = users.userID WHERE itemID = ? AND bidAmount > ? AND needsNotification = 1 ORDER BY bidDate DESC");
                    $result->execute([$itemID, $myHighestBid]);
                    $result2 = $result->fetchAll();


                    $rows = $result->rowCount();
                    if ($rows > 0) {
                        $newHighest = $result2[0]["bidAmount"];
                    }


                    foreach ($result2 as $row) {

                        $finalresult = $finalresult . '<p>'. $row["username"] . 'outbid you with a bid of' . $row["bidAmount"] . '</p> <br>';


                    }


        }


        $returnArray = array('newHighest'=>$newHighest, 'responseMSG'=>$finalresult);

        echo json_encode($returnArray);




?>