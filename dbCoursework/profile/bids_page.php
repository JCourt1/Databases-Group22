<?php
    $siteroot = '/Databases-Group22/dbCoursework';

    include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHead.php";

    if (!isset($_SESSION['user_ID'])) {
        $failed = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
        header('Location: ' . $failed);
    }
?>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHeader.php";?>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/sideMenu.php";?>

    <?php
    // Session
    if(isset($_SESSION['user_ID'])){
        $userID = $_SESSION['user_ID'];
    } else {
        $userID = NULL;
    }

    // SQL QUERIES

    // 1. Array of items that are currently on sale belonging to this user:
    $query_current_bids = "SELECT *
                            FROM items i
                            WHERE i.sellerID = ".$userID."
                            AND i.endDate > NOW()
                            ORDER BY i.endDate DESC
                            ";
    $statement1 = $conn->prepare($query_current_sales);
    $statement1->execute();
    $res_current_sales = $statement1->fetchAll();

    // 2. Array of items that the user has had on sale in the past:
    $query_past_sales = "SELECT *
                        FROM items i
                        WHERE i.sellerID = ".$userID."
                        AND i.endDate <= NOW()
                        ORDER BY i.endDate DESC
                        ";
    $statement2 = $conn->prepare($query_past_sales);
    $statement2->execute();
    $res_past_sales = $statement2->fetchAll();


     ?>



    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <h1 class="page-header">My Listings</h1>

        <div class="container-fluid panel panel-success" style="padding-top: 30px; border: 3px solid transparent; border-color: #d6e9c6;">
            <h3 class="page-header">Items currently on sale</h3>

            <!-- TABLE OF ITEMS CURRENTLY ON SALE -->
            <table class="table table-dark" >
                <thead>
                    <tr scope="row">
                        <th scope="col">Item Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Current Price</th>
                        <th scope="col">Reserve Price</th>
                        <th scope="col">Item End Date</th>
                        <th scope="col">Auction Room</th>
                    </tr>
                </thead>
                <tbody id="currentSalesTable">

                    <?php

                        foreach ($res_current_sales as $row) {
                            // Get high bid information:
                            $bid_query = "SELECT MAX(bidAmount) bidAmount
                                            FROM bids b
                                            WHERE b.itemID = ".$row['itemID']."";
                            $statement3 = $conn->prepare($bid_query);
                            $statement3->execute();
                            $currentBid = $statement3->fetch();
                            if(empty($currentBid['bidAmount'])){
                                $currentBid['bidAmount'] = "No bids";
                            }

                            // Get category:
                            $cat_query = "SELECT categoryName FROM categories WHERE categoryID = ".$row['categoryID'];
                            $statement4 = $conn->prepare($cat_query);
                            $statement4->execute();
                            $category = $statement4->fetch();

                            include "current_sales_row.php";
                        }

                    ?>
                </tbody>
            </table>
        </div>

        <div class="container-fluid panel panel-success" style="padding-top: 30px; border: 3px solid transparent; border-color: #d6e9c6;">
            <h3 class="page-header">Sales History</h3>

            <!-- TABLE OF ITEMS HISTORICALLY ON SALE -->
            <table class="table table-dark" >
                <thead>
                    <tr scope="row">
                        <th scope="col">Item Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Item Sold?</th>
                        <th scope="col">Buyer Email</th>
                        <th scope="col">End Price</th>
                        <th scope="col">Item End Date</th>
                    </tr>
                </thead>
                <tbody id="pastSalesTable">

                    <?php

                    $count = 0;

                    foreach ($res_past_sales as $row) {

                        // Get high bid information:
                        $bid_query = "SELECT MAX(bidAmount) bidAmount, buyerID
                                        FROM bids b
                                        WHERE b.itemID = ".$row['itemID']."";
                        $statement3 = $conn->prepare($bid_query);
                        $statement3->execute();
                        $currentBid = $statement3->fetch();
                        if(empty($currentBid['bidAmount'])){
                            // NO BIDS AT ALL
                            $endPrice = 0;
                            $itemSold = "No";
                            $buyerEmail = "-";
                        } else if ($currentBid['bidAmount'] < $row['reservePrice']){
                            // RESERVE NOT MET
                            $endPrice = $currentBid['bidAmount'].", reserve not met";
                            $itemSold = "No";
                            $buyerEmail = "-";
                        } else {
                            // ITEM SOLD SUCCESSFULLY
                            $endPrice = $currentBid['bidAmount'];
                            $itemSold = "Yes";

                            $email_query = "SELECT email FROM users WHERE userID = ".$currentBid['buyerID'];
                            $email_statement = $conn->prepare($email_query);
                            $email_statement->execute();
                            $email = $email_statement->fetch();

                            $buyerEmail = $email['email'];
                        }

                        // Get category:
                        $cat_query = "SELECT categoryName FROM categories WHERE categoryID = ".$row['categoryID'];
                        $statement4 = $conn->prepare($cat_query);
                        $statement4->execute();
                        $category = $statement4->fetch();

                        include "past_sales_row.php";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        </div>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>

  </body>

</html>
