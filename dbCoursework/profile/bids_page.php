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

    // 1. Array of most recent bids on each item for the current user:
    $query_current_bids = "SELECT b1.*, i.sellerID, i.title, i.description, i.categoryID, i.startPrice, i.reservePrice, i.endDate
                            FROM bids b1
                            INNER JOIN (
                                SELECT max(bidAmount) MaxBidAmount, itemID, buyerID
                                FROM bids
                                WHERE buyerID = :userID
                                GROUP BY itemID
                            ) b2 ON b1.itemID = b2.itemID AND b1.bidAmount = b2.MaxBidAmount
                            LEFT JOIN items i ON i.itemID = b1.itemID
                              WHERE i.endDate > NOW()
                              ORDER BY b1.bidDate DESC";

    $statement1 = $conn->prepare($query_current_bids);
    $statement1->bindParam(':userID', $userID);
    $statement1->execute();
    $res_current_bids = $statement1->fetchAll();

    // 2. Array of bids on items that have expired:
    $query_past_bids = "SELECT b1.*, i.sellerID, i.title, i.description, i.categoryID, i.startPrice, i.reservePrice, i.endDate
                            FROM bids b1
                            INNER JOIN (
                                SELECT max(bidAmount) MaxBidAmount, itemID, buyerID
                                FROM bids
                                WHERE buyerID = :userID
                                GROUP BY itemID
                            ) b2 ON b1.itemID = b2.itemID AND b1.bidAmount = b2.MaxBidAmount
                            LEFT JOIN items i ON i.itemID = b1.itemID
                              WHERE i.endDate <= NOW()
                              ORDER BY i.endDate DESC";

    $statement2 = $conn->prepare($query_past_bids);
    $statement2->bindParam(':userID', $userID);
    $statement2->execute();
    $res_past_bids = $statement2->fetchAll();

    ?>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <h1 class="page-header">My Bids</h1>

        <div class="container-fluid panel panel-success" style="padding-top: 30px; border: 3px solid transparent; border-color: #d6e9c6;">
            <h3 class="page-header">Currently bidding on</h3>

            <!-- TABLE OF ITEMS CURRENTLY BIDDING ON -->
            <table class="table table-dark" >
                <thead>
                    <tr scope="row">
                        <th scope="col">Item Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">My Most Recent Bid</th>
                        <th scope="col">Bid Date</th>
                        <th scope="col">Winning?</th>
                        <th scope="col">Auction Room</th>
                        <th scope="col">Edit Bid</th>
                    </tr>
                </thead>
                <tbody id="currentBidsTable">

                    <?php

                        foreach ($res_current_bids as $row) {

                            // Get category:
                            $cat_query = "SELECT categoryName FROM categories WHERE categoryID = :categoryID";
                            $statement4 = $conn->prepare($cat_query);
                            $statement4->bindParam(':categoryID', $row['categoryID']);
                            $statement4->execute();
                            $category = $statement4->fetch();

                            // Get userID of current high bid on item to check if user is winning:
                            $user_query = "SELECT buyerID FROM bids b1
                                            INNER JOIN (
                                            	SELECT MAX(bidAmount) bidAmount, itemID
                                                FROM bids
                                                GROUP BY itemID
                                            ) b2 ON b1.itemID = b2.itemID AND b1.bidAmount = b2.bidAmount
                                            WHERE b1.itemID = :itemID";
                            $statement5 = $conn->prepare($user_query);
                            $statement5->bindParam(':itemID', $row['itemID']);
                            $statement5->execute();
                            $topBidder = $statement5->fetch();

                            // Is bid winning:
                            if ($topBidder['buyerID'] == $userID){
                                $bidWinning = "Yes";
                            } else {
                                $bidWinning = "No";
                            }

                            include "current_bids_row.php";
                        }

                    ?>
                </tbody>
            </table>
        </div>

        <div class="container-fluid panel panel-success" style="padding-top: 30px; border: 3px solid transparent; border-color: #d6e9c6;">
            <h3 class="page-header">Past bids</h3>

            <!-- TABLE OF ITEMS HISTORICALLY BID ON -->
            <table class="table table-dark" >
                <thead>
                    <tr scope="row">
                        <th scope="col">Item Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Auction Won?</th>
                        <th scope="col">Final Price</th>
                        <th scope="col">Auction Ended</th>
                        <th scope="col">Seller Email</th>
                    </tr>
                </thead>
                <tbody id="pastBidsTable">

                    <?php

                    $count = 0;

                    foreach ($res_past_bids as $row) {

                        // Get userID of current high bid on item to check if user won:
                        $user_query = "SELECT buyerID FROM bids b1
                                        INNER JOIN (
                                            SELECT MAX(bidAmount) bidAmount, itemID
                                            FROM bids
                                            GROUP BY itemID
                                        ) b2 ON b1.itemID = b2.itemID AND b1.bidAmount = b2.bidAmount
                                        WHERE b1.itemID = :itemID";
                        $statement5 = $conn->prepare($user_query);
                        $statement5->bindParam(':itemID', $row['itemID']);
                        $statement5->execute();
                        $topBidder = $statement5->fetch();

                        
                        if ($topBidder['buyerID'] != $userID){
                            $auctionWon = "No";
                            $finalPrice = "-";
                            $sellerEmail = "-";
                        } else if ($row['bidAmount'] < $row['reservePrice']){
                            $auctionWon = "No - did not meet reserve price";
                            $finalPrice = "-";
                            $sellerEmail = "-";
                        } else {
                            $auctionWon = "Yes";
                            $finalPrice = "£".$row['bidAmount'];
                            // Get seller email:
                            $email_query = "SELECT email FROM users WHERE userID = :userID";
                            $email_statement = $conn->prepare($email_query);
                            $email_statement->bindParam(':userID', $row['sellerID']);
                            $email_statement->execute();
                            $email = $email_statement->fetch();
                            $sellerEmail = $email['email'];
                        }

                        // Get category:
                        $cat_query = "SELECT categoryName FROM categories WHERE categoryID = :categoryID";
                        $statement4 = $conn->prepare($cat_query);
                        $statement4->bindParam(':categoryID', $row['categoryID']);
                        $statement4->execute();
                        $category = $statement4->fetch();

                        include "past_bids_row.php";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        </div>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>

  </body>

</html>
