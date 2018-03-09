<?php

        try {
            $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                            "team22@ibe-database",
                            "ILoveCS17");
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        $itemID = $_POST['itemID'];
        $myHighestBid = $_POST['highestBid'];

        $result = $conn->prepare("SELECT bidID, bidDate, bidAmount, users.username FROM bids JOIN users 
        on bids.buyerID = users.userID WHERE itemID = ? AND bidAmount > ? ORDER BY bidDate DESC");
        $result->execute([$itemID, $myHighestBid]);
        $result2 = $result->fetchAll();

        $newHighest = 0;
        $rows = $result->rowCount();
        if ($rows > 0) {
            $newHighest = $result2[0]["bidAmount"];
        }

        $finalresult = "";
        foreach ($result2 as $row) {

            $finalresult = $finalresult . $row[] . $row[];


        }





?>







#### update the _SESSION variable if anything interesting has happened




##### OUTPUT A NOTIFICATION (or just a <p></p> to be placed in an alert:


<p>
    Someone outbid you! (<?php echo $otherUser?> with a bid of <?php echo $theirBid?>)
</p>