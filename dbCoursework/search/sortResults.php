<?php

try {
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                    "team22@ibe-database",
                    "ILoveCS17");
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$sort = $_POST['sort'];

$res = [1,2,4,3];
// Perform sort based on criteria:
if ($sort == 0){
    function cmp($a, $b){
        return strcmp($a['endDate'], $b['endDate']);
    }
    usort($res, "cmp");
} else if ($sort == 1){
    function cmp($a, $b){
        return strcmp($b['endDate'], $a['endDate']);
    }
    usort($res, "cmp");
} else if ($sort == 2){
    function cmp($a, $b){
        return($a['bidAmount'] < $b['bidAmount']) ? -1 : 1;
    }
    usort($res, "cmp");
} else if ($sort == 3){
    function cmp($a, $b){
        return($a['bidAmount'] > $b['bidAmount']) ? -1 : 1;
    }
    usort($res, "cmp");
}

echo($sort);





?>
