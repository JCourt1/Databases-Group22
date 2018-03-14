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





        try {

            $conn->beginTransaction();

            $insertCommunication = $conn->prepare("INSERT INTO communication (senderID, receiverID, message) VALUES (?, 6, ?) ");
            $insertCommunication -> execute([$userID, $message]);

            $lastid = $conn->lastInsertId();

            $insertNotifications = $conn->prepare("INSERT INTO private_message (communicationID, messageSubject, messageResolved) VALUES (?, ?, 0)");
            $insertNotifications -> execute([$lastid, $messageSubject]);

            $conn->commit();

            echo "<script type= 'text/javascript'>alert('Your message has been sent successfully. We will reply to you within 3 business days.');</script>";
            echo     '<script type="text/javascript">  window.location = "../dashboard/index.php"   </script>';


        } catch (Exception $e) {
                 echo $e->getMessage();
                 $conn->rollBack();
        }





    ?>
