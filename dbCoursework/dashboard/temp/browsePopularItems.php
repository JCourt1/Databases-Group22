

    <h3 class="page-header">Most Popular Items</h3>


<?php
if(isset($_SESSION['user_ID'])){
    $buyerID = $_SESSION['user_ID'];
} else {
    $buyerID = NULL;
}


?>



    <div class="row placeholders">
        <?php



        $querry_result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items WHERE endDate > NOW() ORDER BY itemViewCount DESC LIMIT 4");
        $count_result = $conn->query("SELECT COUNT(itemID) FROM ( SELECT itemID FROM items WHERE endDate > NOW()   ORDER BY itemViewCount DESC LIMIT 4 ) AS count");
        $data3 = $count_result->fetch();
        $rowcount = $data3['COUNT(itemID)'];



        for ($rownumber = 0; $rownumber < $rowcount; $rownumber++) {


            $data1 = $querry_result->fetch();
            $itemID = $data1['itemID'];
            $title = $data1['title'];
            $description = $data1['description'];
            $photo = $data1['photo'];
            $date = $data1['endDate'];
            $startPrice = $data1['startPrice'];


            $current_date =  new DateTime();

            $bid_end_date =  new DateTime($date);
            $interval = $current_date->diff($bid_end_date);
            $elapsed = $interval->format('%y y %m m %a d %h h %i min %s s');
            $querry_result2 = $conn->query("SELECT buyerID, bidAmount, bidDate FROM bids WHERE itemID = " .$itemID. " ORDER BY bidAmount DESC LIMIT 1");
            $data2 = $querry_result2->fetch();
            $currentPrice = $data2['bidAmount'];
            $lastBid = $data2['bidDate'];



            $_SESSION['currentPrice'.$rownumber] = $currentPrice;
            $_SESSION['itemID'.$rownumber] = $itemID;

            // MODAL:
            include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/commonElements/itemModal.php";


        }
        ?>




    </div>








    <!-- **********************    SECOND ROW     ***************************  -->
    <div class="row placeholders">
        <?php
        $querry_result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items  WHERE endDate > NOW()  ORDER BY itemViewCount DESC LIMIT 8");
        $count_result = $conn->query("SELECT COUNT(itemID) FROM ( SELECT itemID FROM items WHERE endDate > NOW()  ORDER BY itemViewCount DESC LIMIT 8 ) AS count");
        $data3 = $count_result->fetch();
        $rowcount = $data3['COUNT(itemID)'] - 4;
        $querry_result->fetch();
        $querry_result->fetch();
        $querry_result->fetch();
        $querry_result->fetch();
        if($rowcount>0){
        for ($rownumber = 0; $rownumber < $rowcount; $rownumber++) {

            $data1 = $querry_result->fetch();
            $itemID = $data1['itemID'];
            $title = $data1['title'];
            $description = $data1['description'];
            $photo = $data1['photo'];
            $date = $data1['endDate'];
            $startPrice = $data1['startPrice'];

            $current_date =  new DateTime();

           $bid_end_date =  new DateTime($date);
           $interval = $current_date->diff($bid_end_date);
           $elapsed = $interval->format('%y y %m m %a d %h h %i min %s s');
            $querry_result2 = $conn->query("SELECT bidAmount, bidDate FROM bids WHERE itemID = " . $data1['itemID'] . " ORDER BY bidAmount LIMIT 1");
            $data2 = $querry_result2->fetch();
            $currentPrice = $data2['bidAmount'];
            $lastBid = $data2['bidDate'];





            $modalReference = $rownumber + 4;



            $_SESSION['currentPrice'.$modalReference] = $currentPrice;
            $_SESSION['itemID'.$modalReference] = $itemID;

            // MODAL:
            include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/commonElements/itemModal.php";

        }
    }
        ?>


    </div>
</div>
