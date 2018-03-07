

    <h3 class="page-header">Most Popular Items</h3>

 
<?php include 'increaseViewCount.php' ?>

  

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
            

            $chaine = '<div class="col-xs-6 col-sm-3 placeholder">
            
            
                <!-- Modal -->
                <div id="myModal' . $rownumber . '" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h2 class="modal-title">' . $title . '</h4>
                            </div>
                            <div class="modal-body">
                                <img src="' . $photo . '" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail"
                                <p>' . $description . '</p>
                                <h3>Bidding ends: ' . $elapsed . ' </h2>
                                <h3 id="countdown'.$rownumber.'">  </h3>
                                <h3 > Start Price: ' . $startPrice . ' </h2>
                                <h3> Current Price: ' . $currentPrice . ' </h2>
                                <h3> Last Bid: ' . $lastBid . ' </h2>
                            </div>
                            <div class="modal-footer">
                            <div class="form-group pull-left">
                            <form action="addBid'.$rownumber.'.php" method="post">
                            Bid: <input type="text" name="bid"><br>
                            <input type="submit" value="Bid" >
                            </form>
                            </div>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <img src="' . $photo . '" width="200" height="200" class="img" alt="Generic placeholder thumbnail" data-toggle="modal"   data-target="#myModal' . $rownumber . '">
                <a  data-toggle="modal" data-target="#myModal' . $rownumber . '">
                    <h4>' . $title . '
                    </h4>
                    <span class="text-muted">  ' . $description . ' </span>
                </a>
            </div>';
    
          
            echo $chaine;
            
        
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

            $chaine = '<div class="col-xs-6 col-sm-3 placeholder">
  <!-- Modal -->
  <div id="myModal' . $modalReference . '" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h2 class="modal-title">' . $title . '</h4>
  </div>
  <div class="modal-body">
    <img src="' . $photo . '" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail"
    <p>' . $description . '</p>
    <h3>Bidding ends: ' . $elapsed . ' </h2>
    <h3> Start Price: ' . $startPrice . ' </h2>
    <h3> Current Price: ' . $currentPrice . ' </h2>
    <h3> Last Bid: ' . $lastBid . ' </h2>
    </div>
    <div class="modal-footer">
    <div class="form-group pull-left">
    <form action="addBid'.$modalReference.'.php" method="post">
    Bid: <input type="text" name="bid"><br>
    <input type="submit" value="Bid" >
    </form>
    </div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>
</div>
</div>
              <img src="' . $photo . '" width="200" height="200" class="img" alt="Generic placeholder thumbnail" data-toggle="modal" data-target="#myModal' . $modalReference . '">
              <a  data-toggle="modal" data-target="#myModal' . $modalReference . '">
              <h4>' . $title . '
              </h4>
              <span class="text-muted">  ' . $description . ' </span>
              </a>
            </div>';
            echo $chaine;
        }
    }
        ?>


    </div>
</div>