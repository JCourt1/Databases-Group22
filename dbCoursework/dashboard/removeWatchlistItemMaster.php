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

// Get item to be removed and session user variables:
$itemID = $_GET['itemID'];
$userID = $_SESSION['user_ID'];

// Get the id of the bid to be deleted, to check if the user deleting matches:
$watchlist_query = "SELECT userID, itemID FROM watchlist_items WHERE userID = ".$userID." AND itemID = ".$itemID;
$watchlist_statement = $conn->prepare($watchlist_query);
$watchlist_statement->execute();
$watchlist_item = $watchlist_statement->fetch();

if(empty($watchlist_item['userID']) || empty($watchlist_item['itemID'])){
    $failed = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
    header('Location: ' . $failed);
} else {
    // The item has been found in the watchlist and can now be deleted using queries:
    $conn->query("DELETE FROM watchlist_items WHERE itemID = ".$itemID." AND userID = ".$userID);

    // Now redirect:
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../profile/watchlist_page.php');
}

 ?>
