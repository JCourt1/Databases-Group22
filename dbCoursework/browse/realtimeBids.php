<?php

        try {
            $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_dbv3;charset=utf8",
                            "team22@ibe-database",
                            "ILoveCS17");
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        $itemID = $_POST['itemID'];
        $highestBid = $_POST['highestBid'];

        $result = $conn->prepare("SELECT bidID, bidDate, bidAmount, users.username FROM bids JOIN users 
on bids.buyerID = users.userID WHERE itemID = ? AND bidAmount > ? ORDER BY bidDate DESC");
        $result->execute([$itemID, $highestBid]);
        $result2 = $result->fetchAll();

        $newHighest = 0;
        $rows = $result->rowCount();

        if ($rows > 0) {
            $newHighest = $result2[0]["bidAmount"];
        }


        $finalresult = "";
        foreach ($result2 as $row) {

//            $finalresult = $finalresult . include "bidsRow.php";

            $finalresult = $finalresult . '<tr scope="row" class="info">
                        
                                <td>
                                    '.$row["bidDate"].'
                                </td>
                        
                                <td>
                                    '.$row["bidAmount"].'
                                </td>
                        
                                <td>
                                    '.$row["username"].'
                                </td>
                        
                        </tr>';



        }

        $returnArray = array('newRows'=>$finalresult, 'newHighest'=>$newHighest);

        echo json_encode($returnArray);
?>