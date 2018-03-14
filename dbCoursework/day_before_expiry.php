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
        WHERE itemRemoved = 0 AND (endDate > NOW() ) AND (endDate < (NOW() + INTERVAL 1 DAY))");


        $statement->execute();
        $res = $statement->fetchAll();

        $emails = array();
        $subjects = array();
        $messages = array();



        if(sizeof($res)>0){

        foreach ($res as $searchResult) {


            $itemID = $searchResult['itemID'];
            $sellerID = $searchResult['sellerID'];
            $title = $searchResult['title'];
            $endDate = $searchResult['endDate'];
            $startPrice = $searchResult['startPrice'];
            $reservePrice = $searchResult['reservePrice'];
            $notified  = $searchResult['notified'];









            $watchlist_querry = $conn->prepare("SELECT userID FROM watchlist_items WHERE itemID = ".$itemID." ");

            $watchlist_querry->execute();
            $users = $watchlist_querry->fetchAll();

            foreach($users as $user){
            $userID = $user['userID'];


          
            $user_querry = $conn->prepare("SELECT u.email, c.firstName, c.lastName
            FROM users u JOIN clients c ON c.userID = u.userID
            WHERE u.userID = ".$userID." ");
            $user_querry->execute();
            $user_details = $user_querry->fetch();
            $watcherFirstName = $user_details['firstName'];
            $watcherLastName = $user_details['lastName'];
            $watcherEmail = $user_details['email'];

            $subject = 'Item \''.$title.'\' is expiring soon';
            $message = 'Dear '.$watcherFirstName.'  '.$watcherLastName.', the item \''.$title.'\' that you are watching is expiring on the '.$endDate.'.';

            array_push($emails,$watcherEmail);
            array_push($subjects, $subject);
            array_push($messages, $message);





            try {

                $conn->beginTransaction();
    
                $insertCommunication = $conn->prepare("INSERT INTO communication (senderID, receiverID, message) VALUES (6, ?, ?) ");
                $insertCommunication -> execute([$userID, $message]);
    
                $lastid = $conn->lastInsertId();
    
                $insertNotifications = $conn->prepare("INSERT INTO private_message (communicationID, messageSubject, messageResolved) VALUES (?, ?, 0)");
                $insertNotifications -> execute([$lastid, $subject]);
    
                $conn->commit();
    
    
            } catch (Exception $e) {
                     echo $e->getMessage();
                     $conn->rollBack();
            }


            }

        }

    }

    send_email($emails, $subjects, $messages);



        ?>
