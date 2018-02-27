<?php

    try {
        $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                        "team22@ibe-database",
                        "ILoveCS17");
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }



    ?>
