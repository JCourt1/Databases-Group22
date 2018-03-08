
<?php
//establish the connection
try {
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                    "team22@ibe-database",
                    "ILoveCS17");
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
<html>
<?php include('../dashboard/baseHead.php'); ?>

<body>

    <?php include('../dashboard/baseHeader.php'); ?>

    <?php include('../dashboard/sideMenu.php'); ?>


</body>

<?php include('../dashboard/baseFooter.php'); ?>


</html>

