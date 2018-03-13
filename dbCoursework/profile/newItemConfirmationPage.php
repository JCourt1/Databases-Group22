<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>

<?php include('../dashboard/baseHead.php'); ?>

<body>

    <?php include('../dashboard/baseHeader.php'); ?>

    <?php include('../dashboard/sideMenu.php'); ?>
    <?php
    try
    {
        //create connection
        $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_dbv3;charset=utf8","team22@ibe-database","ILoveCS17");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //store the variables that come from the form
        $itemTitle = $_POST['itemTitle'];
        $itemDescription = $_POST['itemDescription'];
        $startingPrice = $_POST['startingPrice'];
        $reservePrice = $_POST['reservePrice'];
        $photoLink = $_POST['photoLink'];
        $Condition = $_POST['Condition'];
        $parentCat2 = $_POST['parentCat2'];
        $subCat2 = $_POST['subCat2'];
        $expDate = $_POST['expDate'];

        //update the database
        $sql = "INSERT INTO items ( sellerID, title, description, itemCondition, photo, categoryID, startPrice,reservePrice,endDate)
        VALUES (:sellerID,:itemTitle,:itemDescription,:Condition,:photoLink,:subCat2,:startingPrice,:reservePrice,:expDate )";
        
        $statement = $conn->prepare($sql);

        $statement->bindValue(':sellerID',$_SESSION['user_ID']);
        $statement->bindParam(':itemTitle', $itemTitle);
        $statement->bindParam(':itemDescription', $itemDescription);
        $statement->bindParam(':Condition', $Condition);
        $statement->bindParam(':photoLink', $photoLink);
        $statement->bindParam(':subCat2', $subCat2);
        $statement->bindParam(':startingPrice', $startingPrice);
        $statement->bindParam(':reservePrice', $reservePrice);
        $statement->bindParam(':expDate', $expDate);

        //print the relevant message regarding the outcome of the insertion
        if ($statement->execute())
        {
            echo "<script type= 'text/javascript'>alert('New Item Inserted Successfully');</script>";
        }
        else
        {
            echo "<script type= 'text/javascript'>alert('Item not successfully inserted.');</script>";
        }
        //navigate to the main page
        echo     '<script type="text/javascript">  window.location = "../dashboard/index.php"   </script>';
        $conn = null;
    }

    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
    ?>

</body>

<?php include('../dashboard/baseFooter.php'); ?>
