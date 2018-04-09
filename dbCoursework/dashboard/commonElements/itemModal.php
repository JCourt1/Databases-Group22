<!-- NECESSARY THINGS THAT YOU WILL NEED BEFORE USING THIS SCRIPT:
        $rownumber - if you have an array of items to display, this is the index of the array
        $title - item Name
        $photo - item photo
        $description - item description
        $elapsed - time until auction ends
        $startPrice - item's starting price
        $currentPrice - current highest bid
        $lastBid - date of the most recent high bid
        $buyerID - session ID of the user (incase they want to post a bid)
        $condition - item's condition
-->
<?php $siteroot = '/dbCoursework'; ?>

<script type="text/javascript">
    $(document).ready(function(){
        var image = '#img' + <?php echo $rownumber; ?>;
        var watchlist = "#watchlist" + <?php echo $rownumber; ?>;

        // VIEW COUNT
        $(image).on("click",function(){
            var number = <?php echo $itemID; ?>;

            $.ajax({
                url: "<?php echo $siteroot; ?>dashboard/increaseViewCount.php",
                type: "POST",
                data: "itemID="+number,
                success: function (response) {
                    console.log("hurray");
                },

                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        });

        // Initial watchlist
        $(watchlist).on("init", function(){
            console.log("INITIASDIAS");
        });

        // WATCHLIST
        $(watchlist).on("click",function(){
            var number = <?php echo $itemID; ?>;
            var userID;
            try {
                userID = <?php echo $buyerID; ?>;
            } catch (err){
                console.log("Nobody logged in");
                userID = -1;
            }

            $.ajax({
                url: "<?php echo $siteroot; ?>dashboard/handleWatchlistClick.php",
                type: "POST",
                data: {"itemID": number, "userID": userID},
                success: function (response) {
                    console.log("Watchlist Change");
                    $(watchlist).html(response);
                },

                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        });
    });
</script>

<?php
// User variables:
if(isset($_SESSION['user_ID'])){
    $buyerID = $_SESSION['user_ID'];
} else {
    $buyerID = NULL;
}

// Get the seller information
$seller_check = "SELECT sellerID FROM items WHERE itemID = ".$itemID;
$statement = $conn->prepare($seller_check);
$statement->execute();
$seller = $statement->fetch();

// Get the seller's feedback score
$feedback_score_query = $conn->prepare("SELECT 100*SUM(isPositive)/COUNT(isPositive) percentage, COUNT(isPositive) total FROM feedback WHERE receiverID = ".$seller['sellerID']);
$feedback_score_query->execute();
$feedback = $feedback_score_query->fetch();
$feedback_score = 0;
$total_feedback = '0 reviews';

if(!empty($feedback)){
    $feedback_score = round($feedback['percentage'], 1);
    $total_feedback = $feedback['total'];
    if($total_feedback == 1){
        $total_feedback = $total_feedback.' review';
    } else {
        $total_feedback = $total_feedback.' reviews';
    }
}

// For watchlist script when page is first loaded:
$watchlist_line = "<p>Log in to add item to watchlist</p>";
if (!empty($buyerID)){
    $query = "SELECT itemID, userID FROM watchlist_items w WHERE w.itemID = ".$itemID." AND w.userID = ".$buyerID;
    $statement = $conn->prepare($query);
    $statement->execute();
    $res = $statement->fetch();

    if ($buyerID != $seller['sellerID']){
        if (empty($res['itemID']) || empty($res['userID'])) {
            // Item not currently in watchlist
            $watchlist_line = "<a>Add to watchlist</a>";
        } else {
            // Item is currently in watchlist
            $watchlist_line = "<a>Remove from watchlist</a>";
        }
    } else {
        $watchlist_line = "<p></p>";
    }
}

// For formatting the date:
if(!empty($lastBid)){
    $lastBid = date_format(date_create($lastBid),"d-m-Y").' at '.date_format(date_create($lastBid),"H:i:s");
} else {
    $lastBid = "No bids have been placed on this item.";
}

// THIS IS THE FILE FOR THE ITEM MODAL.
$chaine = '<div class="col-xs-6 col-sm-3 col-m-3 col-lg-3 placeholder modalCentered">


    <!-- Modal -->
    <div id="myModal' . $rownumber . '" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title modalCentered">' . $title . '</h4>
                </div>
                <div class="modal-body">
                    <img src="' . $photo . '" width="190" height="190" class="img-responsive modalCentered" alt="Generic placeholder thumbnail">
                    <br>
                    <p class="modalCentered">' . $description . '</p>
                    <br>
                    <p style="font-weight: bold;" class="modalCentered">Seller has '.$feedback_score.'% positive feedback ('.$total_feedback.')</p>

                    <table class="table table-sm">
                      <tbody>
                        <tr>
                            <td>Item condition:</td>
                            <td>'.$condition.'</td>
                        <tr>
                        <tr>
                          <td>Bidding ends:</td>
                          <td>'.$elapsed.'</td>
                        </tr>
                        <h3 id="countdown'.$rownumber.'">  </h3>
                        <tr>
                          <td>Start Price:</td>
                          <td>£ '.$startPrice.'</td>
                        </tr>
                        <tr>
                          <td>Current Price:</td>
                          <td>£ '.$currentPrice.'</td>
                        </tr>
                        <tr>
                          <td>Last Bid:</td>
                          <td>'.$lastBid.'</td>
                        </tr>
                      </tbody>
                    </table>




                </div>
                <div class="modal-footer">
                <div class="form-group pull-left">
                <form action="'.$siteroot.'dashboard/addBidMaster.php?itemID='.$itemID.'&currentPrice='.$currentPrice.'&buyerID='.$buyerID.'" method="post">
                Amount: <input type="text" name="bid">
                <input type="submit" value="Place bid" >
                </form>

                </div>

                <div>
                <div>
                    <a href="'.$siteroot.'browse/auctionRooms.php?itemID='.$itemID.'">View in auction room</a>
                </div>
                <div class="watchlist" id="watchlist'.$rownumber.'">
                    '.$watchlist_line.'
                </div>

                </div>


                </div>
            </div>
        </div>
    </div>
    <img src="' . $photo . '"  class="img modalCentered" id="img'.$rownumber.'" alt="Generic placeholder thumbnail" data-toggle="modal"   data-target="#myModal' . $rownumber . '">
    <a  data-toggle="modal" data-target="#myModal' . $rownumber . '">
        <h4>' . $title . '
        </h4>
        <span class="text-muted">  ' . $description . ' </span>
    </a>
</div>';


echo $chaine;

 ?>
