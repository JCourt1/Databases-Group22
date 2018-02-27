<?php include("../dashboard/baseHead.php"); ?>

<link href="../dist/css/historyPage.css" rel="stylesheet">


  <body>

    <?php include('../dashboard/baseHeader.php'); ?>

    <?php include('../dashboard/sideMenu.php'); ?>



    <!-- TODO: list the items that the user is currently bidding on, as well as past ones, with successes before failures. -->


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">History</h1>




            <?php

            $userID = 1; // hard coded for the moment

            $itemsOnWatchList = $conn->query("SELECT i.itemID, i.title, i.description, i.photo, i.endDate, i.startPrice FROM items as i JOIN watchlist_items as wli ON i.itemID = wli.itemID WHERE wli.userId = $userID");
            $count_result = $conn -> query("SELECT COUNT(itemID) FROM (
SELECT i.itemID FROM items as i JOIN watchlist_items as wli ON i.itemID = wli.itemID 
WHERE wli.userId = $userID) AS T");



            $data3 = $count_result -> fetch();
            $rowcount = $data3['COUNT(itemID)'];


            echo "<table class=\"table table-striped\">
              <tbody>";



            for($rownumber = 0; $rownumber<$rowcount; $rownumber++){

            $watchListItem = $itemsOnWatchList -> fetch();

            $itemID = $watchListItem['itemID'];
            $title = $watchListItem['title'];
            $description = $watchListItem['description'];
            $photo = $watchListItem['photo'];
            $date = $watchListItem['endDate'];
            $startPrice = $watchListItem['startPrice'];


            $findTopBid = $conn->query( "SELECT bidAmount, bidDate FROM bids WHERE itemID = ".$watchListItem['itemID']." ORDER BY bidAmount LIMIT 1");
            $latestBid = $findTopBid -> fetch();

            $currentPrice = $latestBid['bidAmount'];
            $lastBid = $latestBid['bidDate'];

            $findLatestBidOnItem = $conn->query( "SELECT bidAmount, bidDate FROM bids WHERE itemID = ".$watchListItem['itemID']." AND buyerID = $userID ORDER BY bidAmount LIMIT 1");
            $mylatestBid = $findLatestBidOnItem -> fetch();

            $mycurrentPrice = $mylatestBid['bidAmount'];
            $mylastBidDate = $mylatestBid['bidDate'];





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
    <h3>Bidding ends: '.$date.' </h2>
    <h3> Start Price: '.$startPrice.' </h2>
    <h3> Current Price: '.$currentPrice.' </h2>
    <h3> Last Bid: '.$lastBid.' </h2>
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
                        <td class='historyTableData rightSide'> My latest bid: ".$mycurrentPrice."<br> Date: ".$mylastBidDate."</td>
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
