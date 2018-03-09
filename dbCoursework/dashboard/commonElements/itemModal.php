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
    });
</script>

<?php
// THIS IS THE FILE FOR THE ITEM MODAL.
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
                <form action="'.$siteroot.'dashboard/addBidMaster.php?itemID='.$itemID.'&currentPrice='.$currentPrice.'&buyerID='.$buyerID.'" method="post">
                Bid: <input type="text" name="bid"><br>
                <input type="submit" value="Bid" >
                </form>
                <a href="'.$siteroot.'browse/auctionRooms.php?itemID='.$itemID.'">View in auction room</a>
                </div>
                
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <img src="' . $photo . '" width="200" height="200" class="img" id="img'.$rownumber.'" alt="Generic placeholder thumbnail" data-toggle="modal"   data-target="#myModal' . $rownumber . '">
    <a  data-toggle="modal" data-target="#myModal' . $rownumber . '">
        <h4>' . $title . '
        </h4>
        <span class="text-muted">  ' . $description . ' </span>
    </a>
</div>';


echo $chaine;

 ?>
