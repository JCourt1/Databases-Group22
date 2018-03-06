<?php


        try {
            $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                            "team22@ibe-database",
                            "ILoveCS17");
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        session_start();




            $currentPrice = $_SESSION['currentPrice'];
            $itemID = $_SESSION['itemID'];
            $buyerID = $_SESSION['buyerID'];
            

            echo "<script type='text/javascript'>alert('$itemID');</script>";

            
       
            if (!empty($_POST["bid"]) && $currentPrice < $_POST["bid"]) {
                $currentPrice = $_POST["bid"];
                $conn->query("INSERT INTO bids (itemID, buyerID, bidAmount, bidDate) VALUES (" . $itemID . "," . $buyerID . "," . $_POST["bid"] . "," . date("Y-m-d") . " ) ");
                $message = "Your bid has been registered. Thank you!";
                echo "<script type='text/javascript'>alert('$message');</script>";

            }

            elseif(empty($_POST["bid"])){

                $message = "The bid field cannot be empty!";
                echo "<script type='text/javascript'>alert('$message');</script>";

            }

            elseif(!empty($_POST["bid"]) && $currentPrice >= $_POST["bid"]){
                $message = "Your bid must be bigger than the current bid";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }

            else{

                $message = "Please enter a valid number!";
                echo "<script type='text/javascript'>alert('$message');</script>";
                
            }

        
        
        

?>