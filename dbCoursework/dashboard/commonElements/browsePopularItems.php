


    <h1 class="page-header">Most Popular Items</h1>

    <div class="row placeholders">
        <?php
        $querry_result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items ORDER BY itemViewCount DESC LIMIT 4");
        $count_result = $conn->query("SELECT COUNT(itemID) FROM ( SELECT itemID FROM items ORDER BY itemViewCount DESC LIMIT 4 ) AS count");

        $data3 = $count_result->fetch();
        $rowcount = $data3['COUNT(itemID)'];

        $datalicious = "Sep 5, 2018 15:37:25";
        



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
                                <h3 id="countdown"> hello </h3>
                                <h3 > Start Price: ' . $startPrice . ' </h2>
                                <h3> Current Price: ' . $currentPrice . ' </h2>
                                <h3> Last Bid: ' . $lastBid . ' </h2>
                            </div>
                            <div class="modal-footer">
                                <div class="form-group pull-left">
                                    <input type="text" name="bid" id="inputBid" >
                                </div>
                                <button type="button" class="btn btn-default pull-left" action="addBid()" >Bid</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>

                <img src="' . $photo . '" width="200" height="200" class="img" alt="Generic placeholder thumbnail" data-toggle="modal" data-target="#myModal' . $rownumber . '">
                <a  data-toggle="modal" data-target="#myModal' . $rownumber . '">
                    <h4>' . $title . '
                    </h4>
                    <span class="text-muted">  ' . $description . ' </span>
                </a>
            </div>';

            echo $chaine;
        }

        function addBid()
        {
            if (isset($_POST["bid"]) && $currentPrice < $_POST["bid"]) {
                $conn->query("INSERT INTO bids (itemID, buyerID, bidAmount, bidDate) VALUES (" . $itemID . "," . $buyerID . "," . $_POST["bid"] . "," . date("Y-m-d") . " ) ");
            }
        }

        ?>

    </div>








    <!-- **********************    SECOND ROW     ***************************  -->
    <div class="row placeholders">
        <?php
        $querry_result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items ORDER BY itemViewCount DESC LIMIT 8");
        $count_result = $conn->query("SELECT COUNT(itemID) FROM ( SELECT itemID FROM items ORDER BY itemViewCount DESC LIMIT 8 ) AS count");

        $data3 = $count_result->fetch();
        $rowcount = $data3['COUNT(itemID)'] - 4;

        $querry_result->fetch();
        $querry_result->fetch();
        $querry_result->fetch();
        $querry_result->fetch();

        for ($rownumber = 0; $rownumber < $rowcount; $rownumber++) {

            $data1 = $querry_result->fetch();

            $itemID = $data1['itemID'];
            $title = $data1['title'];
            $description = $data1['description'];
            $photo = $data1['photo'];
            $date = $data1['endDate'];
            $startPrice = $data1['startPrice'];

            $querry_result2 = $conn->query("SELECT bidAmount, bidDate FROM bids WHERE itemID = " . $data1['itemID'] . " ORDER BY bidAmount LIMIT 1");

            $data2 = $querry_result2->fetch();

            $currentPrice = $data2['bidAmount'];
            $lastBid = $data2['bidDate'];

            $modalReference = $rownumber + 4;

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
    <h3>Bidding ends: ' . $date . ' </h2>
    <h3> Start Price: ' . $startPrice . ' </h2>
    <h3> Current Price: ' . $currentPrice . ' </h2>
    <h3> Last Bid: ' . $lastBid . ' </h2>
  </div>
  <div class="modal-footer">
  <div class="form-group pull-left">
  <input type="text" name="bid" id="inputBid" >
</div>
    <button type="button" class="btn btn-default pull-left" action ="dashboard.php">Bid</button>
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

        ?>


    </div>



    <script>
// Set the date we're counting down to
js_variable_name = "<?php echo $date; ?>";
var countDownDate = new Date(js_variable_name).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    document.getElementById("countdown").innerHTML = "Bid ends in " + days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("countdown").innerHTML = "EXPIRED";
    }
}, 1000);
</script>