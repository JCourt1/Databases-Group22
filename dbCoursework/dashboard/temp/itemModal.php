<?php
$siteroot = '/Databases-Group22/dbCoursework/';
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

 ?>
