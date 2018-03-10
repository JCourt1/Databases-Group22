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
      
        $statement = $conn->prepare("SELECT itemid, sellerid, title, enddate, startprice, reserveprice, notified
        FROM items
        WHERE enddate < NOW() AND (notified = 0 OR notified IS NULL)");


        $statement->execute();
        $res = $statement->fetchAll();

        $emails = array();
        $subjects = array();
        $messages = array();

        foreach ($res as $searchResult) {

            


            $itemID = $searchResult['itemid'];
            $sellerID = $searchResult['sellerid'];
            $title = $searchResult['title'];
            $endDate = $searchResult['enddate'];
            $startPrice = $searchResult['startprice'];
            $reservePrice = $searchResult['reserveprice'];
            $notified  = $searchResult['notified'];

        
        
        if($notified  == 1 ){
            

            continue;

        }

        else{

            

            $bid_query = $conn->prepare("SELECT buyerid, bidamount, biddate
            FROM bids
            WHERE itemid = " .$itemID. " AND bidwinning = 1");
            $bid_query->execute();
            $bid = $bid_query->fetch();


            $buyerID = $bid['buyerid'];
            $bidAmount = $bid['bidamount'];
            $bidDate = $bid['biddate'];



            $buyer_query = $conn->prepare("SELECT firstname, lastname, email
            FROM users
            WHERE userid = " .$buyerID. "");
            $buyer_query->execute();
            $buyer = $buyer_query->fetch();
           
            $buyerFirstName = $buyer['firstname'];
            $buyerLastName = $buyer['lastname'];
            $buyerEmail = $buyer['email'];


            $seller_query = $conn->prepare("SELECT firstname, lastname, email
            FROM users
            WHERE userid = " .$sellerID. "");
            $seller_query->execute();
            $seller = $seller_query->fetch();
           
            $sellerFirstName = $buyer['firstname'];
            $sellerLastName = $buyer['lastname'];
            $sellerEmail = $buyer['email'];


            


        
            $subject_seller = 'Your item has been sold';
            $message_seller = 'Dear '.$sellerFirstName.' '.$sellerLastName.', Your item: '.$title.' has been sold to '.$buyerFirstName.' '.$buyerLastName.' for the price of '.$bidAmount.'. This is his/her email address: '.$buyerEmail.'';

          

   

            $subject_buyer = 'You won the bidding!';
            $message_buyer =  'Dear '.$sellerFirstName.' '.$sellerLastName.', Congratulations you have bought the item: '.$title.' for the price of '.$bidAmount.'. This is the seller\'s email address: '.$sellerEmail.' .';

           
            array_push($emails,$sellerEmail, $buyerEmail);
            array_push($subjects, $subject_seller,$subject_buyer);
            array_push($messages, $message_seller, $message_buyer);

            $conn ->query("UPDATE items SET  notified = 1 WHERE itemid = $itemID");

            
            


        }


    }

    send_email($emails, $subjects, $messages);

       

        ?>