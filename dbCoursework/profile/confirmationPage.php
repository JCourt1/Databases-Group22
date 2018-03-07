<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>

<html>
<?php include('../dashboard/baseHead.php'); ?>

<body>

    <?php include('../dashboard/baseHeader.php'); ?>

    <?php include('../dashboard/sideMenu.php'); ?>
    <?php
    try
    {  
        //create connection
        $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                        "team22@ibe-database",
                        "ILoveCS17");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        ?>

        <?php
        $itemTitle = $_POST['itemTitle'];
        $itemDescription = $_POST['itemDescription'];
        $startingPrice = $_POST['startingPrice'];
        $reservedPrice = $_POST['reservedPrice'];
        $photoLink = $_POST['photoLink'];
        $Condition = $_POST['Condition'];
        $parentCat2 = $_POST['parentCat2'];
        $subCat2 = $_POST['subCat2'];
        $expDate = $_POST['expDate'];


        $sql = "INSERT INTO items ( sellerID, title, description, itemCondition, categoryID, startPrice,reservePrice,endDate)
        VALUES ('".$_SESSION['user_ID']."','".$itemTitle."', '".$itemDescription."','".$Condition."','".$subCat2."', '".$startingPrice."','".$reservedPrice."','".$expDate."')";
        if ($conn->query($sql)) {
            echo "<script type= 'text/javascript'>alert('New Record Inserted Successfully');</script>";
            echo     '<script type="text/javascript">  window.location = "../dashboard/index.php"   </script>';
            


            }
            else{
            echo "<script type= 'text/javascript'>alert('Data not successfully Inserted.');</script>";

    <div id="fullscreen_bg" class="fullscreen_bg"/>
    <div class="container">
        <div class="row">
            <?php
                if (empty($_POST['itemTitle'])){
                    echo 'item title is not filled';
                }
            var_dump($_POST) ?>


            href="blablab.php?itemID=ghdfhfg&"


            function () {



            function($_GET['itemID'])

        </div>
    </div>
    </div>

            
        }
        $conn = null;
    }

    catch (Exception $e) 
    {
        die('Erreur : ' . $e->getMessage());
    }
    ?>

</body>

<?php include('../dashboard/baseFooter.php'); ?>


</html>




