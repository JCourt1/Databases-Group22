
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
$userID = $_POST['userID'];


if ($userID >= 0){
    // Search for the item in the database. If it's there, remove item and return "Add to Watchlist"
    // if it's not there, add it to watchlist and return "Remove from watchlist".
    $query = "SELECT itemID, userID FROM watchlist_items w WHERE w.itemID = ".$itemID." AND w.userID = ".$userID;
    $statement = $conn->prepare($query);
    $statement->execute();
    $res = $statement->fetch();

    if (empty($res['itemID']) || empty($res['userID'])) {
        // Item not currently in watchlist, so needs to be added
        $conn->query("INSERT INTO watchlist_items (userID, itemID) VALUES (".$userID.", ".$itemID.")");
        echo("<a>Remove from watchlist</a>");
    } else {
        // Item is currently in watchlist, so needs to be removed
        $conn->query("DELETE FROM watchlist_items WHERE itemID = ".$itemID." AND userID = ".$userID);
        echo("<a>Add to watchlist</a>");
    }
} else {
    echo("<a>You must log in first!</a>");
}

 ?>
