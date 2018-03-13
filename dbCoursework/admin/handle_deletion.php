<?php

try
{
    //create connection
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_dbv3;charset=utf8","team22@ibe-database","ILoveCS17");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    $query = "UPDATE items SET itemRemoved=1 WHERE itemID= '".$_POST['delete']."' ";
    

    $statement = $conn->prepare($query);


    //print the relevant message regarding the outcome of the insertion
    if ($statement->execute())
    {
        echo "<script type= 'text/javascript'>alert('Item deleted Successfully');</script>";
    }
    else
    {
        echo "<script type= 'text/javascript'>alert('A problem occured while deleting the item.');</script>";
    }
    //navigate to the main page
    echo     '<script type="text/javascript">  window.location = "listed_items.php"   </script>';
    $conn = null;
}

catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
?>

