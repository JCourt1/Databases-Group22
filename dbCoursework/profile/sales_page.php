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
    $query_current_sales = "SELECT *
                            FROM items i
                            WHERE i.sellerID = ".$userID."
                            AND i.endDate > NOW() AND i.itemRemoved = 0
                            ORDER BY i.endDate DESC
                            ";
    $statement1 = $conn->prepare($query_current_sales);
    $statement1->execute();
    $res_current_sales = $statement1->fetchAll();

    // 2. Array of items that the user has had on sale in the past:
    $query_past_sales = "SELECT *
                        FROM items i
                        WHERE i.sellerID = ".$userID."
                        AND i.endDate <= NOW() AND i.itemRemoved = 0
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

            <?php if(!empty($res_current_sales)){ ?>
            <!-- TABLE OF ITEMS CURRENTLY ON SALE -->
            <table class="table table-dark pageableTable" >
                <thead>
                    <tr scope="row">
                        <th scope="col">Item Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Current Price</th>
                        <th scope="col">Reserve Price</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Auction Room</th>
                        <th scope="col">Views</th>
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
        <?php } else { echo "<p style='font-style: italic; font-size: 24px; color: grey;'>You are not currently selling anything.</p>";} ?>
        </div>

        <div class="container-fluid panel panel-success" style="padding-top: 30px; border: 3px solid transparent; border-color: #d6e9c6;">
            <h3 class="page-header">Sales History</h3>

            <?php if(!empty($res_past_sales)){ ?>

            <!-- TABLE OF ITEMS HISTORICALLY ON SALE -->
            <table class="table table-dark pageableTable" >
                <thead>
                    <tr scope="row">
                        <th scope="col">Item Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Item Sold?</th>
                        <th scope="col">Buyer Email</th>
                        <th scope="col">End Price</th>
                        <th scope="col">Auction End Date</th>
                        <th scope="col">Give Feedback</th>
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
                            $feedbackHTML = "-";
                        } else if ($currentBid['bidAmount'] < $row['reservePrice']){
                            // RESERVE NOT MET
                            $endPrice = $currentBid['bidAmount'].", reserve not met";
                            $itemSold = "No";
                            $buyerEmail = "-";
                            $feedbackHTML = "-";
                        } else {
                            // ITEM SOLD SUCCESSFULLY
                            $endPrice = $currentBid['bidAmount'];
                            $itemSold = "Yes";

                            $email_query = "SELECT email, userID FROM users WHERE userID = ".$currentBid['buyerID'];
                            $email_statement = $conn->prepare($email_query);
                            $email_statement->execute();
                            $email = $email_statement->fetch();

                            $buyerEmail = $email['email'];
                            $buyerID = $email['userID'];

                            // Get feedback row from DB:
                            $feedback_query = "SELECT itemID, isPositive
                                            FROM feedback
                                            WHERE senderID = ".$userID."
                                            AND receiverID = ".$buyerID."
                                            AND itemID = ".$row['itemID'];
                            $feedback_statement = $conn->prepare($feedback_query);
                            $feedback_statement->execute();
                            $feedback = $feedback_statement->fetch();


                            // Check if the communication exists:
                            if(!empty($feedback['itemID'])){

                                if(strlen($feedback['isPositive']) < 1) {
                                    $from = "sales_page";
                                    $feedbackHTML = '<div class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Give Feedback</a>
                                                        <div class="dropdown-menu" style="padding: 15px;">
                                                            <form class="form-horizontal" method="post" action="handle_feedback.php?from='.$from.'&senderID='.$userID.'&receiverID='.$buyerID.'&itemID='.$row['itemID'].'" accept-charset="UTF-8">
                                                              <button class="btn btn-primary" type="submit" name="feedback" value="1"><span class="glyphicon glyphicon-thumbs-up"></span></button>
                                                              <button class="btn btn-danger" type="submit" name="feedback" value="0"><span class="glyphicon glyphicon-thumbs-down"></span></button>
                                                            </form>
                                                        </div>
                                                    </div>';

                                } else if ($feedback['isPositive'] == 0){
                                    // NEGATIVE FEEDBACK WAS GIVEN
                                    $feedbackHTML = "<span style='color: red;' class='glyphicon glyphicon-thumbs-down'></span>";
                                } else if ($feedback['isPositive'] == 1){
                                    // POSITIVE FEEDBACK WAS GIVEN
                                    $feedbackHTML = "<span style='color: green;' class='glyphicon glyphicon-thumbs-up'></span>";
                                }
                            } else {
                                $feedbackHTML = "Not available";
                            }
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
        <?php } else { echo "<p style='font-style: italic; font-size: 24px; color: grey;'>You don't have any auctions that have finished.</p>";} ?>

        </div>

        </div>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>

  </body>

</html>

<script>

    $.noConflict();
    $(document).ready( function () {
        $('.pageableTable').DataTable(
            {"pageLength": 10, "order": [[ 4, "asc" ]], searching: false, "lengthChange": false});
    } );
</script>
