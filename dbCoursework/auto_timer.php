<?php



        $siteroot = '/Databases-Group22/dbCoursework/';

        include 'C:\wamp64\www\Databases-Group22\vendor\email.php';

        try {
            $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                            "team22@ibe-database",
                            "ILoveCS17");
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
            echo '<script type="text/javascript"> console.log("connection to MySQL failed"); </script>';
        }



        echo '<script type="text/javascript"> console.log("connection Ok"); </script>';

        $statement = $conn->prepare("SELECT itemID, sellerID, title, endDate, startPrice, reservePrice, notified
        FROM items
        WHERE endDate < NOW() AND (notified = 0 OR notified IS NULL)");


        $statement->execute();
        $res = $statement->fetchAll();

        $emails = array();
        $subjects = array();
        $messages = array();

        foreach ($res as $searchResult) {




            $itemID = $searchResult['itemID'];
            $sellerID = $searchResult['sellerID'];
            $title = $searchResult['title'];
            $endDate = $searchResult['endDate'];
            $startPrice = $searchResult['startPrice'];
            $reservePrice = $searchResult['reservePrice'];
            $notified  = $searchResult['notified'];

        if($notified  == 1 ){
            continue;
        }

        else{
            $bid_query = $conn->prepare("SELECT buyerID, bidAmount, bidDate FROM bids b1
                                        INNER JOIN (
                                        	SELECT MAX(bidAmount) bidAmount, itemID
                                            FROM bids
                                            GROUP BY itemID
                                        ) b2 ON b1.itemID = b2.itemID AND b1.bidAmount = b2.bidAmount
                                        WHERE b1.itemID = :itemID");
            $bid_query->bindParam(':itemID', $itemID);
            $bid_query->execute();
            $bid = $bid_query->fetch();

            if(sizeof($bid)>0){

            $buyerID = $bid['buyerID'];
            $bidAmount = $bid['bidAmount'];
            $bidDate = $bid['bidDate'];



            $buyer_query = $conn->prepare("SELECT firstName, lastName, email
            FROM users
            WHERE userID = :buyerID");
            $buyer_query->bindParam(':buyerID', $buyerID);
            $buyer_query->execute();
            $buyer = $buyer_query->fetch();

            $buyerFirstName = $buyer['firstName'];
            $buyerLastName = $buyer['lastName'];
            $buyerEmail = $buyer['email'];


            $seller_query = $conn->prepare("SELECT firstName, lastName, email
            FROM users
            WHERE userID = :sellerID");
            $seller_query->bindParam(':sellerID', $sellerID);
            $seller_query->execute();
            $seller = $seller_query->fetch();

            $sellerFirstName = $seller['firstName'];
            $sellerLastName = $seller['lastName'];
            $sellerEmail = $seller['email'];

            $subject_seller = 'Your item has been sold';
            $message_seller = 'Dear '.$sellerFirstName.' '.$sellerLastName.', Your item: \''.$title.'\' has been sold to '.$buyerFirstName.' '.$buyerLastName.' for the price of £'.$bidAmount.'. This is his/her email address: '.$buyerEmail.'';

            $subject_buyer = 'You won the bidding!';
            $message_buyer =  'Dear '.$sellerFirstName.' '.$sellerLastName.', Congratulations you have bought the item: \''.$title.'\' for the price of £'.$bidAmount.'. This is the seller\'s email address: '.$sellerEmail.' .';


            array_push($emails,$sellerEmail, $buyerEmail);
            array_push($subjects, $subject_seller,$subject_buyer);
            array_push($messages, $message_seller, $message_buyer);

            $update_stmt = $conn ->prepare("UPDATE items SET  notified = 1 WHERE itemID = :itemID");
            $update_stmt->bindParam(':itemID', $itemID);
            $update_stmt->execute();

            }

        }

    }

    send_email($emails, $subjects, $messages);

        ?>
