

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



//$querry = $conn->query("UPDATE items SET title = 'strangeToy' WHERE itemID =2 ");
 $conn->query("UPDATE items SET itemViewCount = itemViewCount + 1  WHERE itemID = ".$itemID."; ");

















?>
