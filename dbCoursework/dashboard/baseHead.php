<!DOCTYPE html>
<html lang="en">
<head>

    <?php
        $servername = "ibe-database.mysql.database.azure.com"  ;
        $dbname = "ibe_db" ;
        $username =  "team22@ibe-database" ;
        $password =  "ILoveCS17" ;
    ?>

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



    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Ibé</title>


    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="../resources/css/base.css" rel="stylesheet">

    <!-- Have to somewhere have a record of who is currently logged in so we have the userID etc. -->





