<?php
$siteroot = '/Databases-Group22/dbCoursework';

include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHead.php";

if (!isset($_SESSION['user_ID'])) {
    $failed = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
    header('Location: ' . $failed);
}

try {
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                    "team22@ibe-database",
                    "ILoveCS17");
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$bidID = $_GET['bidID'];
$userID = $_SESSION['user_ID'];

// Get the id of the bid to be deleted, to check if the user deleting matches:
$buyer_query = "SELECT buyerID, itemID FROM bids WHERE bidID = ".$bidID;
$buyer_statement = $conn->prepare($buyer_query);
$buyer_statement->execute();
$buyerIDforChecking = $buyer_statement->fetch();
if($buyerIDforChecking['buyerID'] != $userID){
    $failed = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
    header('Location: ' . $failed);
} else {
    // HERE GOES THE LOGIC TO DO THE DELETION:
    $conn->query("DELETE FROM bids WHERE bidID = ".$bidID);

    // Find the next highest bid on that item and update it so that it is winning:
    $newBidID_query = "SELECT bidID
                        FROM bids b1
                        INNER JOIN
                        (
                        SELECT max(bidAmount) MaxBidAmount, itemID
                        FROM bids
                        WHERE itemID = ".$buyerIDforChecking['itemID']."
                        ) b2
                        ON b1.itemID = b2.itemID
                        AND b1.bidAmount = b2.MaxBidAmount";
    $newBid_statement = $conn->prepare($newBidID_query);
    $newBid_statement->execute();
    $newBidID = $newBid_statement->fetch();
    $conn->query("UPDATE bids SET bidWinning = 1 WHERE bidID = ".$newBidID['bidID']);


    // NOW REDIRECT BACK TO THE BID HISTORY PAGE FROM WHENCE WE CAME

}




 ?>
