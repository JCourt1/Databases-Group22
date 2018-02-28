<?php include("../dashboard/baseHead.php"); ?>

<link href="../dist/css/historyPage.css" rel="stylesheet">


  <body>

    <?php include('../dashboard/baseHeader.php'); ?>

    <?php include('../dashboard/sideMenu.php'); ?>




    <!-- TODO: list the items that the user is currently bidding on, as well as past ones, with successes before failures. -->


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">My Current Bids</h1>




            <?php

            session_start();

            $userID = $_SESSION['user_ID'];

            // only selects bids that haven't already finished
            $itemsOnWatchList = $conn->query("SELECT i.itemID, i.title, i.description, i.photo, i.endDate, i.startPrice, max(b.bidAmount) as highestBid, b.bidDate FROM items as i JOIN watchlist_items as wli 
            ON i.itemID = wli.itemID 
            JOIN bids as b ON wli.itemID = b.itemID AND wli.userID = b.buyerID
            WHERE wli.userId = $userID AND i.itemID NOT IN (SELECT items.itemID FROM items JOIN bids ON items.itemID = bids.itemID WHERE bids.bidWon = 1)
            GROUP BY b.itemID
            ORDER BY b.bidDate DESC");


            $rowcount = $itemsOnWatchList->rowCount();

            echo "<table class=\"table table-striped\">
              <tbody>";


            for($rownumber = 0; $rownumber<$rowcount; $rownumber++){

            $watchListItem = $itemsOnWatchList -> fetch();

            $itemID = $watchListItem['itemID'];
            $title = $watchListItem['title'];
            $description = $watchListItem['description'];
            $photo = $watchListItem['photo'];
            $endDate = $watchListItem['endDate'];
            $startPrice = $watchListItem['startPrice'];
            $myLatestBid = $watchListItem['highestBid'];
            $mylastBidDate = $watchListItem['bidDate'];

            // Make a table with the bidamount and date of the highest bid(s) and then order them by date and take the oldest one.
            $TopBid = $conn->query( "SELECT bidAmount, bidDate, buyerID FROM bids WHERE itemID = $itemID AND bidAmount = (SELECT max(bidAmount) FROM bids 
WHERE itemID = $itemID) ORDER BY bidDate DESC LIMIT 1");
            $TopBid = $TopBid -> fetch();

            $currentPrice = $TopBid['bidAmount'];
            $currentTopBuyer = $TopBid['buyerID'];
            $bidStatus = 'Losing...';

            if ($currentTopBuyer = $userID) {
                $bidStatus = 'Winning!';
            }

            $wonOrNot = $conn->query( "SELECT buyerID FROM bids WHERE itemID = $itemID AND bidWon = true");

            if($wonOrNot->rowCount() == 1) {
                $wonOrNot = $wonOrNot->fetch();

                if ($wonOrNot['buyerID'] == $userID) {
                    $bidStatus = "Won!!!";
                } else {
                    $bidStatus = "Lost...";
                }

            }

            $chaine = '<div class="placeholder">


  <!-- Modal -->
  <div id="myModal'.$rownumber.'" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h2 class="modal-title">'.$title.'</h4>
  </div>
  <div class="modal-body">
    <img src="'.$photo.'" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail"
    <p>'.$description.'</p>
    <h2>Bidding ends: '.$endDate.' </h2>
    <h2> Start Price: '.$startPrice.' </h2>
    <h2> Current Highest Price: '.$currentPrice.' </h2>
    <h2> Last Bid: '.$myLatestBid.' </h2>
    <h2> Status: '.$bidStatus.' </h2>
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

              <img src="'.$photo.'" width="200" height="200" class="img" alt="Generic placeholder thumbnail" data-toggle="modal" data-target="#myModal'.$rownumber.'">
              <a  data-toggle="modal" data-target="#myModal'.$rownumber.'">
              <h4>' .$title.'
              </h4>
              <span class="text-muted">  '.$description.' </span>
              </a>
            </div>';


//                echo "<div class=\"col-xs-6 col-sm-6\">". $chaine . "</div>
//                        <div class=\"col-xs-6 col-sm-6\">".$mycurrentPrice."<br>".$mylastBidDate."</div>
//                      ";

                echo "<tr>
                        <td class='historyTableData leftSide'>" . $chaine . "</td>
                        <td class='historyTableData rightSide'> My latest bid: ".$myLatestBid."<br> Status: ".$bidStatus."<br>Date: ".$mylastBidDate."</td>
                        
                      </tr>";



//            echo $chaine;
//
//            echo '<p>'.$mycurrentPrice.'</p>';
//            echo '<p>'.$mylastBidDate.'</p>';
//
//            echo '<br><br><br><br><br><br><br><br><br><br><br>';

            }





            ?>

          </tbody>
          </table>

          </div>

        </div>



    <?php include("../dashboard/baseFooter.php"); ?>

  </body>





</html>