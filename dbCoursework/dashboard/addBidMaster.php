<?php session_start();

$siteroot = '/Databases-Group22/dbCoursework/'; ?>
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

                // HERE GOES THE LOGIC TO EMAIL NOTIFY THE PREVIOUS HIGH BIDDER THAT THEY HAVE BEEN OUTBID
                // - sql query the bids table to find the highest bid on the item (before the new bid is placed in the table)
                // - send email to user
                // ALSO POTENTIALLY THE LOGIC TO EMAIL NOTIFY THE SELLER THAT THEIR ITEM HAS A NEW BID
                // - sql query the items table to find the sellerID
                // - send email to seller
                $date = new DateTime();
                $result = $date->format('Y-m-d H:i:s');
                $currentPrice = $_POST["bid"];
                $conn->query("UPDATE bids SET bidWinning = 0 WHERE itemID = ".$itemID." AND bidWinning = 1");
                $conn->query("INSERT INTO bids (itemID, buyerID, bidAmount, bidWinning) VALUES (" . $itemID . "," . $buyerID . "," . $_POST["bid"] . ", 1 ) ");
                $message = "Your bid has been registered. Thank you!";
//                include "signalNecessaryNotifications.php";



                // Signal that bids need notifications to be sent out where necessary
                // (the highest bid on the same item from all users who have bid on it, apart from the user who has just made the new highest bid)

                $toBeNotified = $conn -> prepare("SELECT bids1.bidID, T.highestBid, T.buyerID FROM (SELECT * FROM bids) AS bids1 JOIN
                                                                                
                                                                                (SELECT bids2.buyerID, bids2.bidID, max(bids2.bidAmount) as highestBid FROM (SELECT * FROM bids) as bids2 
                                                                                WHERE bids2.itemID = ? AND bids2.buyerID <> ? GROUP BY bids2.buyerID) AS T
                                                                                ON bids1.buyerID = T.buyerID AND bids1.bidAmount = T.highestBid");
                $toBeNotified -> execute([$itemID, $buyerID]);
                $toBeNotified = $toBeNotified->fetchAll();

                foreach ($toBeNotified as $row) {

                    $buyerID = $row['buyerID'];

                    $notification = '' . $_SESSION['login_user'] . 'outbid you on '.$itemName.' with a bid of ' . $currentPrice;


                    $insertNotifications = $conn->prepare("INSERT INTO communication (senderID, receiverID, communicationtype, message, isBuyer, unread) VALUES (".$_SESSION['user_ID'].", ".$buyerID.", \"rivalBid\", \"".$notification."\", 1, 1)");
                    $insertNotifications -> execute();
                }

                $notification = '' . $_SESSION['login_user'] . 'placed a bid of '.$currentPrice.' on your item: ' . $itemName;
                $insertNotifications = $conn->prepare("INSERT INTO communication (senderID, receiverID, communicationtype, message, isBuyer, unread) VALUES (".$_SESSION['user_ID'].", ".$sellerID.", \"receivedBid\", \"".$notification."\", 0, 1)");
                $insertNotifications->execute();

//                var_dump($notification);
//                var_dump($_SESSION['login_user']);
//                var_dump($sellerID);

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
