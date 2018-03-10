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
-->
<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>

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
// For watchlist script when page is first loaded:
$watchlist_line = "<p>Log in to add item to watchlist</p>";
if (!empty($buyerID)){
    $query = "SELECT itemID, userID FROM watchlist_items w WHERE w.itemID = ".$itemID." AND w.userID = ".$buyerID;
    $statement = $conn->prepare($query);
    $statement->execute();
    $res = $statement->fetch();

    if (empty($res['itemID']) || empty($res['userID'])) {
        // Item not currently in watchlist
        $watchlist_line = "<a>Add to watchlist</a>";
    } else {
        // Item is currently in watchlist
        $watchlist_line = "<a>Remove from watchlist</a>";
    }
}

// THIS IS THE FILE FOR THE ITEM MODAL.
$chaine = '<div class="col-xs-6 col-sm-3 placeholder modalCentered">


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
                    <img src="' . $photo . '" width="200" height="200" class="img-responsive modalCentered" alt="Generic placeholder thumbnail">
                    <br>
                    <p class="modalCentered">' . $description . '</p>
                    <br>
                    <table class="table table-sm">
                      <tbody>
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
                          <td>£ '.$lastBid.'</td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
                    
                    
                    
                    
                </div>
                <div class="modal-footer">
                <div class="form-group pull-left">
                <form action="'.$siteroot.'dashboard/addBidMaster.php?itemID='.$itemID.'&currentPrice='.$currentPrice.'&buyerID='.$buyerID.'" method="post">
                Amount: <input type="text" name="bid">
                <input type="submit" value="Bid!" >
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
    <img src="' . $photo . '" width="200" height="200" class="img modalCentered" id="img'.$rownumber.'" alt="Generic placeholder thumbnail" data-toggle="modal"   data-target="#myModal' . $rownumber . '">
    <a  data-toggle="modal" data-target="#myModal' . $rownumber . '">
        <h4>' . $title . '
        </h4>
        <span class="text-muted">  ' . $description . ' </span>
    </a>
</div>';


echo $chaine;

 ?>




