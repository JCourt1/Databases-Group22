<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>
<?php

session_start();// Starting Session




try {
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                    "team22@ibe-database",
                    "ILoveCS17");
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


$password = sha1($_POST['password']);
$query = $conn->prepare("SELECT userID, username FROM users WHERE username = ? AND password = ?");
$query->execute([$_POST['username'], $password]);


$adminquery = $conn->prepare("SELECT userID, username FROM users WHERE username = ? AND password = ? AND usertype = 'admin'");
$adminquery->execute([$_POST['username'], $password]);

if ($adminquery->rowCount()) {

    $row = $adminquery->fetch();
    $uName = $row['username'];
    $id = $row['userID'];
    $_SESSION['login_user'] = $uName;
    $_SESSION['admin_ID'] = $id;
    $_SESSION['user_ID'] = $id;

    include "../notifications/notificationsAtLogin.php";

    $adminPage = 'http://' . $_SERVER['HTTP_HOST'] . $siteroot . '/admin/admin.php';
     header('Location: ' . $adminPage);


} else if ($query->rowCount()) {


    $row = $query->fetch();

     $uName = $row['username'];
     $id = $row['userID'];

     $_SESSION['user_ID'] = $id;
     $_SESSION['login_user'] = $uName;

        if (!isset($_SESSION['user_ID'])) {
                throw new Exception('Username is not set. Should not happen.');
        }

     $_SESSION['loggedin'] = true;

    ##### Setting the Session variable containing information about the bids made by a user (in prep for notifications)
    $query_current_bids = "SELECT b1.bidID, b1.bidAmount, b1.itemID, i.title
                                    FROM bids b1
                                    INNER JOIN
                                    (
                                        SELECT max(bidAmount) MaxBidAmount, itemID, buyerID
                                        FROM bids
                                        WHERE buyerID = 1
                                        GROUP BY itemID
                                    ) b2
                                      ON b1.itemID = b2.itemID
                                      AND b1.bidAmount = b2.MaxBidAmount
                                    LEFT JOIN items i ON i.itemID = b1.itemID
                                      WHERE i.endDate > NOW()
                                      ORDER BY b1.bidDate DESC
                                ";
    $statement1 = $conn->prepare($query_current_bids);
    $statement1->execute();
    $res_current_bids = $statement1->fetchAll();

    $_SESSION['myBids'] = $res_current_bids;



    ##### Setting the Session variable with info about the items on sale of the user.
    $query_current_sales = "SELECT *
                                FROM items i
                                WHERE i.sellerID = ".$id."
                                AND i.endDate > NOW()
                                ORDER BY i.endDate DESC
                                ";
    $statement1 = $conn->prepare($query_current_sales);
    $statement1->execute();
    $res_current_sales = $statement1->fetchAll();


    $_SESSION['myItems'] = $res_current_sales;

    include "../notifications/notificationsAtLogin.php";



 $dashboard = 'http://' . $_SERVER['HTTP_HOST'] . $siteroot . '/dashboard/dashboard.php';
 header('Location: ' . $dashboard);
} else {

 echo "<script type='text/javascript'>alert('Invalid username or password, try again');
window.location.href = '../dashboard/index.php';</script>";
 
}


?>

