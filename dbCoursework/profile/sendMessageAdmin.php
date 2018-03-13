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
        $userID = $_SESSION['user_ID'];



     $conn->query("INSERT INTO communication (senderID, receiverID, communicationType, message) VALUES (".$userID.", '17', '".$message."') ");


     try {

                 $conn->beginTransaction();

             $insertCommunication = $conn->prepare("INSERT INTO communication (senderID, receiverID, message) VALUES (".$userID.", '17', '".$message."') ");
             $insertCommunication -> execute();

             $lastid = $conn->lastInsertId();

             $insertNotifications = $conn->prepare("INSERT INTO private_message (communicationID, messageSubject, messageResolved) VALUES (".$lastid.", '".$messageSubject."', 0)");
             $insertNotifications -> execute();

             $conn->commit();

     } catch (Exception $e) {
                 echo $e->getMessage();
                 $conn->rollBack();
     }



    ?>
