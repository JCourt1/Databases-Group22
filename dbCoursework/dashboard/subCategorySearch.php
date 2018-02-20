<?php

try {
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                    "team22@ibe-database",
                    "ILoveCS17");
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$parentCategory = $_POST['parentCategory'];
echo "<option>Any</option>";

$res= $conn->query("SELECT * FROM categories WHERE parentCategory = '$parentCategory' ORDER BY categoryID ASC;");

    while($data=$res->fetch()) {
    ?>
        <option value="<?php echo $data['categoryID'];?>"><?php echo $data['categoryName'];?></option>
    <?php
    }

?>
