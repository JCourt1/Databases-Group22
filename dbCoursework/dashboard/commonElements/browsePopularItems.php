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

        $querry_result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items WHERE endDate > NOW() ORDER BY itemViewCount DESC LIMIT 4");
        $count_result = $conn->query("SELECT COUNT(itemID) FROM ( SELECT itemID FROM items WHERE endDate > NOW()   ORDER BY itemViewCount DESC LIMIT 4 ) AS count");
        $data3 = $count_result->fetch();
        $rowcount = $data3['COUNT(itemID)'];

        // Test for now:///////////////////////////////////
        $statement = $conn->prepare("SELECT itemID, title, description, photo, endDate, startPrice
                                    FROM items
                                    WHERE endDate > NOW()
                                    ORDER BY itemViewCount DESC LIMIT 8");
        $statement->execute();
        $res = $statement->fetchAll();

        $rownumber = 0;
        // Iterate through the 8 most popular items:
        foreach ($res as $searchResult) {

            // Item information:
            $itemID = $searchResult['itemID'];
            $title = $searchResult['title'];
            $photo = $searchResult['photo'];
            $description = $searchResult['description'];
            $startPrice = $searchResult['startPrice'];

            // Bid information:
            $bid_query = $conn->prepare("SELECT buyerID, bidAmount, bidDate
                                        FROM bids
                                        WHERE itemID = " .$itemID. "
                                        ORDER BY bidAmount DESC LIMIT 1");
            $bid_query->execute();
            $bid = $bid_query->fetch();
            $currentPrice = $bid['bidAmount'];
            $lastBid = $bid['bidDate'];

            $current_date =  new DateTime();

            $bid_end_date =  new DateTime($searchResult['endDate']);
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

</div>
