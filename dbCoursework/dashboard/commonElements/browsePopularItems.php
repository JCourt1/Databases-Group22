<h3 class="page-header">Most Popular Items</h3>

<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>

<?php
if(isset($_SESSION['user_ID'])){
    $buyerID = $_SESSION['user_ID'];
} else{
    $buyerID = NULL;
}
?>

<div class="row placeholders">
    <?php

    $statement = $conn->prepare("SELECT itemid, title, description, photo, enddate, startprice
                                FROM items
                                WHERE enddate > NOW()
                                ORDER BY itemviewcount DESC LIMIT 8");
    $statement->execute();
    $res = $statement->fetchAll();

    $rownumber = 0;
    // Iterate through the 8 most popular items:
    foreach ($res as $searchResult) {

        // Item information:
        $itemID = $searchResult['itemid'];
        $title = $searchResult['title'];
        $photo = $searchResult['photo'];
        $description = $searchResult['description'];
        $startPrice = $searchResult['startprice'];

        // Bid information:
        $bid_query = $conn->prepare("SELECT buyerid, bidamount, biddate
                                    FROM bids
                                    WHERE itemID = " .$itemID. "
                                    ORDER BY bidamount DESC LIMIT 1");
        $bid_query->execute();
        $bid = $bid_query->fetch();
        $currentPrice = $bid['bidamount'];
        $lastBid = $bid['biddate'];

        $current_date =  new DateTime();

        $bid_end_date =  new DateTime($searchResult['enddate']);
        $interval = $current_date->diff($bid_end_date);
        $elapsed = $interval->format('%y y %m m %a d %h h %i min %s s');

        if($startPrice >= $currentPrice){
            $currentPrice = $startPrice;
        }

        // MODAL:
        include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/commonElements/itemModal.php";

        $rownumber += 1;
    }

    ?>

</div>
