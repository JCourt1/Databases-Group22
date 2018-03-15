<?php

        include 'vendor\email.php';
        try {
            $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_dbv3;charset=utf8",
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
                                        WHERE endDate < NOW() AND itemRemoved = 0 AND (notified = 0 OR notified IS NULL)");



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
            } else{

                $bid_query = $conn->prepare("SELECT  bidAmount, bidDate, buyerID
                                            FROM bids b1
                                            INNER JOIN (
                                                SELECT MAX(bidAmount) bidAmountA, itemID
                                                FROM bids
                                                GROUP BY itemID
                                            ) b2 ON b1.itemID = b2.itemID AND b1.bidAmount = b2.bidAmountA
                                            WHERE b1.itemID = ".$itemID."");
                $bid_query->execute();
                $bid = $bid_query->fetch();
                if(sizeof($bid)>0){
                    //if($bid['bidAmount'] >= $reservePrice){
                        $buyerID = $bid['buyerID'];
                        $bidAmount = $bid['bidAmount'];
                        $bidDate = $bid['bidDate'];
                        $buyer_query = $conn->prepare("SELECT u.email, c.firstName, c.lastName
                                                        FROM users u JOIN clients c ON c.userID = u.userID
                                                        WHERE u.userID = " .$buyerID. "");




                        $buyer_query->execute();
                        $buyer = $buyer_query->fetch();
                        $buyerFirstName = $buyer['firstName'];
                        $buyerLastName = $buyer['lastName'];
                        $buyerEmail = $buyer['email'];
                        $seller_query = $conn->prepare("SELECT u.email, c.firstName, c.lastName
                                                        FROM users u JOIN clients c ON c.userID = u.userID
                                                        WHERE u.userID = " .$sellerID. "");
                        $seller_query->execute();
                        $seller = $seller_query->fetch();

                            // THE ITEM WAS SOLD
                            if ($reservePrice <= $bidAmount){

                                // EMAILS
                                $sellerFirstName = $seller['firstName'];
                                $sellerLastName = $seller['lastName'];
                                $sellerEmail = $seller['email'];
                                $subject_seller = 'Your item has been sold';
                                $message_seller = 'Dear '.$sellerFirstName.' '.$sellerLastName.', Your item: \''.$title.'\' has been sold to '.$buyerFirstName.' '.$buyerLastName.' for the price of £'.$bidAmount.'. This is his/her email address: '.$buyerEmail.'';
                                $subject_buyer = 'You won the bidding!';
                                $message_buyer =  'Dear '.$sellerFirstName.' '.$sellerLastName.', Congratulations you have bought the item: \''.$title.'\' for the price of £'.$bidAmount.'. This is the seller\'s email address: '.$sellerEmail.' .';
                                array_push($emails, $sellerEmail, $buyerEmail);
                                array_push($subjects, $subject_seller, $subject_buyer);
                                array_push($messages, $message_seller, $message_buyer);

                                // PUT THE EMAILS INTO THE COMMUNICATION TABLE IN THE DB
                                $sellerMessageSubject = 'Your item has been sold!';
                                $buyerMessageSubject = 'Congratulations, you won!';
                                try {

                                    $conn->beginTransaction();

                                    $insertCommunication = $conn->prepare("INSERT INTO communication (senderID, receiverID, message) VALUES (6, ?, ?) ");
                                    $insertCommunication -> execute([$sellerID, $message_seller]);

                                    $lastid = $conn->lastInsertId();

                                    $insertNotifications = $conn->prepare("INSERT INTO private_message (communicationID, messageSubject, messageResolved) VALUES (?, ?, 0)");
                                    $insertNotifications -> execute([$lastid, $sellerMessageSubject]);

                                    $conn->commit();


                                } catch (Exception $e) {
                                         echo $e->getMessage();
                                         $conn->rollBack();
                                }

                                try {

                                    $conn->beginTransaction();

                                    $insertCommunication = $conn->prepare("INSERT INTO communication (senderID, receiverID, message) VALUES (6, ?, ?) ");
                                    $insertCommunication -> execute([$buyerID, $message_buyer]);

                                    $lastid = $conn->lastInsertId();

                                    $insertNotifications = $conn->prepare("INSERT INTO private_message (communicationID, messageSubject, messageResolved) VALUES (?, ?, 0)");
                                    $insertNotifications -> execute([$lastid, $buyerMessageSubject]);

                                    $conn->commit();


                                } catch (Exception $e) {
                                         echo $e->getMessage();
                                         $conn->rollBack();
                                }

                                // UPDATE THE FEEDBACK TABLE
                                $feedback = $conn->prepare("INSERT INTO feedback (senderID, receiverID, itemID, isPositive) VALUES (?, ?, ?, NULL)");
                                $feedback->execute([$sellerID, $buyerID, $itemID]);
                                $feedback->execute([$buyerID, $sellerID, $itemID]);

                            } else {
                                // LET THE SELLER KNOW THEY DIDN'T SELL THE ITEM
                            }

                            $conn ->query("UPDATE items SET  notified = 1 WHERE itemID = $itemID");


                    }
                }
            }
            send_email($emails, $subjects, $messages);
        ?>
