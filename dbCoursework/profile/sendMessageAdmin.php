<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>

<?php include('../dashboard/baseHead.php'); ?>



    <?php include('../dashboard/baseHeader.php'); ?>

    <?php include('../dashboard/sideMenu.php'); ?>
    <?php

echo '<script type="text/javascript"> console.log("sendMessageAdmin.php called"); </script>';

        try {
            $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_dbv3;charset=utf8",
                            "team22@ibe-database",
                            "ILoveCS17");
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
            echo '<script type="text/javascript"> console.log("connection to MySQL failed"); </script>';
        }

        //store the variables that come from the form
        $subject = $_POST['Subject'];
        $message = $_POST['Message'];
        $messageSubject = $_POST['Subject'];
        $userID = $_SESSION['user_ID'];


        // $query = $conn->prepare("INSERT INTO communication (senderID, receiverID, communicationType, message) VALUES (:userID, 6, :message) ");
        // $query->bindParam(':userID', $userID);
        // $query->bindParam(':message', $message);
        // $query->execute();



        try {

            $conn->beginTransaction();

            $insertCommunication = $conn->prepare("INSERT INTO communication (senderID, receiverID, message) VALUES (?, 6, ?) ");
            $insertCommunication -> execute([$userID, $message]);

            $lastid = $conn->lastInsertId();

            $insertNotifications = $conn->prepare("INSERT INTO private_message (communicationID, messageSubject, messageResolved) VALUES (?, ?, 0)");
            $insertNotifications -> execute([$lastid, $messageSubject]);

            $conn->commit();


        } catch (Exception $e) {
                 echo $e->getMessage();
                 $conn->rollBack();
        }





    ?>
