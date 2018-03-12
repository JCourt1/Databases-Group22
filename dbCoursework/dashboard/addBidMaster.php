<?php session_start();



$siteroot = '/Databases-Group22/dbCoursework/';
include "../../vendor/email.php";
?>

<?php



        try {
            $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                            "team22@ibe-database",
                            "ILoveCS17");
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }


       $currentPrice =  $_GET['currentPrice'];
       $buyerID = $_GET['buyerID'];
       $itemID = $_GET['itemID'];
        $bid = $_POST["bid"];

       // Get the sellerID
       $sellerItem_query = "SELECT sellerID, title FROM items WHERE itemID = ".$itemID;
        $statement = $conn->prepare($sellerItem_query);
        $statement->execute();
        $firstRow = $statement->fetch();
        $sellerID = $firstRow["sellerID"];
        $itemName = $firstRow["title"];




            if(!isset($buyerID) ||  $buyerID == NULL){
                echo '<script type="text/javascript">';
                echo 'alert("You have to login or register first");';
                echo 'window.location.href = "index.php";';
                echo '</script>';
            } else if ($buyerID == $sellerID){
                echo '<script type="text/javascript">';
                echo 'alert("You cannot bid on your own item");';
                echo 'window.location.href = "index.php";';
                echo '</script>';
            }

            else{



            if (!empty($_POST["bid"]) && $currentPrice < $_POST["bid"]) {

 //////////////////////////////////////////////////////////////////////////////////////////

                // HERE GOES THE LOGIC TO EMAIL NOTIFY THE PREVIOUS HIGH BIDDER THAT THEY HAVE BEEN OUTBID
                // - sql query the bids table to find the highest bid on the item (before the new bid is placed in the table)
                // - send email to user
                // ALSO POTENTIALLY THE LOGIC TO EMAIL NOTIFY THE SELLER THAT THEIR ITEM HAS A NEW BID
                // - sql query the items table to find the sellerID
                // - send email to seller


                //initialising the arrays that will contain the emails, subjects and messages.
                $emails = array();
                $subjects = array();
                $messages = array();


                ///getting the seller's details
                $seller_query = $conn->prepare("SELECT firstName, lastName, email
                FROM users
                WHERE userID = " .$sellerID. "");
                $seller_query->execute();
                $seller = $seller_query->fetch();

                $sellerFirstName = $seller['firstName'];
                $sellerLastName = $seller['lastName'];
                $sellerEmail = $seller['email'];



                //getting the previous highest bid details
                $old_bid_query = $conn->prepare("SELECT  buyerID, bidAmount, bidDate
                FROM bids b1
                INNER JOIN (
                SELECT MAX(bidAmount) bidAmount, itemID
                FROM bids
                GROUP BY itemID
                ) b2 ON b1.itemID = b2.itemID AND b1.bidAmount = b2.bidAmount
                WHERE b1.itemID = ".$itemID."
                ");
                $old_bid_query->execute();
                $old_bid = $old_bid_query->fetch();

                $previous_buyerID = $old_bid['buyerID'];
                $previous_bidAmount = $old_bid['bidAmount'];
                $previous_bidDate = $old_bid['bidDate'];


                //getting thhe previous highest bidder details
                $older_bidder_query = $conn->prepare("SELECT firstName, lastName, email
                FROM users
                WHERE userID = " .$previous_buyerID. "");
                $older_bidder_query->execute();
                $old_bidder = $older_bidder_query->fetch();

                $old_bidder_firstName = $old_bidder['firstName'];
                $old_bidder_lastName = $old_bidder['lastName'];
                $old_bidder_email = $old_bidder['email'];


             //writing the email text
            $subject_seller = 'A new bid on your item has been placed';
            $message_seller = 'Dear '.$sellerFirstName.' '.$sellerLastName.', someone has placed a new bid of £'.$bid.' on  your item \''.$itemName.'\'. ';

            $subject_old_buyer = 'Someone has outbid you';
            $message_old_buyer = 'Dear '.$old_bidder_firstName.' '.$old_bidder_lastName.', someone has outbid you on the item \''.$itemName.'\' with a bid of  £'.$bid.'.<br>
            your bid was '.$previous_bidAmount.', placed on '.$previous_bidDate.'';



            array_push($emails,$sellerEmail, $old_bidder_email);
            array_push($subjects, $subject_seller,$subject_old_buyer);
            array_push($messages, $message_seller, $message_old_buyer);

            send_email($emails, $subjects, $messages);

///////////////////////////////////////////////////////////////////////////////////






                $date = new DateTime();
                $result = $date->format('Y-m-d H:i:s');
                $currentPrice = $_POST["bid"];
                // The following line is being commented out as we remove the bidWinning column:
                // $conn->query("UPDATE bids SET bidWinning = 0 WHERE itemID = ".$itemID." AND bidWinning = 1");

                //$conn->query("INSERT INTO bids (itemID, buyerID, bidAmount) VALUES (" . $itemID . "," . $buyerID . "," . $_POST["bid"] . " ) ");
                $new_bid_query = $conn->prepare("INSERT INTO bids (itemID, buyerID, bidAmount) VALUES (" . $itemID . "," . $buyerID . ", :bid ) ");
                $new_bid_query->bindParam(':bid', $_POST['bid']);
                $new_bid_query->execute();
                $message = "Your bid has been registered. Thank you!";
                include "../notifications/notificationWriter.php";



                // Signal that bids need notifications to be sent out where necessary
                // (the highest bid on the same item from all users who have bid on it, apart from the user who has just made the new highest bid)

                $toBeNotified = $conn -> prepare("SELECT bids1.bidID, T.highestBid, T.buyerID FROM (SELECT * FROM bids) AS bids1 JOIN

                                                                                (SELECT bids2.buyerID, bids2.bidID, max(bids2.bidAmount) as highestBid FROM (SELECT * FROM bids) as bids2
                                                                                WHERE bids2.itemID = ? AND bids2.buyerID <> ? GROUP BY bids2.buyerID) AS T
                                                                                ON bids1.buyerID = T.buyerID AND bids1.bidAmount = T.highestBid");
                $toBeNotified -> execute([$itemID, $buyerID]);
                $toBeNotified = $toBeNotified->fetchAll();

                foreach ($toBeNotified as $row) {


                    $receiver = $row['buyerID'];

//                    $notification = '' . $_SESSION['login_user'] . 'outbid you on '.$itemName.' with a bid of ' . $currentPrice;
//                    $insertNotifications = $conn->prepare("INSERT INTO communication (senderID, receiverID, communicationtype, message, isBuyer, unread) VALUES (".$_SESSION['user_ID'].", ".$buyerID.", \"rivalBid\", \"".$notification."\", 1, 1)");
//                    $insertNotifications -> execute();
                    writeOutbidNotification($receiver, $_SESSION['login_user'], $currentPrice, $itemName);
                }

                updateSeller($sellerID, $_SESSION['login_user'], $currentPrice, $itemName);

                //                $notification = '' . $_SESSION['login_user'] . 'placed a bid of '.$currentPrice.' on your item: ' . $itemName;
                //                $insertNotifications = $conn->prepare("INSERT INTO communication (senderID, receiverID, communicationtype, message, isBuyer, unread) VALUES (".$_SESSION['user_ID'].", ".$sellerID.", \"receivedBid\", \"".$notification."\", 0, 1)");
                //                $insertNotifications->execute();

                echo "<script type='text/javascript'>alert('$message');
                window.location.href = 'index.php';
                </script>";
            }
            elseif(empty($_POST["bid"])){
                $message = "The bid field cannot be empty!";
                echo "<script type='text/javascript'>alert('$message');
                window.location.href = 'index.php';


                </script>";
            }
            elseif(!empty($_POST["bid"]) && $currentPrice >= $_POST["bid"]){
                $message = "Your bid must be bigger than the current bid";
                echo "<script type='text/javascript'>alert('$message');
                window.location.href = 'index.php';
                </script>";
            }
            else{
                $message = "Please enter a valid number!";
                echo "<script type='text/javascript'>alert('$message');
                window.location.href = 'index.php';
                </script>";

            }


        }


?>
