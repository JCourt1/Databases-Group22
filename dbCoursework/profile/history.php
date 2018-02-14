<?php include("../dashboard/baseHead.php"); ?>


  <body>

    <?php include('../dashboard/baseHeader.php'); ?>

    <?php include('../dashboard/baseBody.php'); ?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">History</h1>

          <div class="row placeholders">

            <?php
            $query_result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items ORDER BY itemViewCount DESC LIMIT 4");
            $count_result = $conn -> query("SELECT COUNT(itemID) FROM ( SELECT itemID FROM items ORDER BY itemViewCount DESC LIMIT 4 ) AS count");

            $data3 = $count_result -> fetch();
            $rowcount = $data3['COUNT(itemID)'];

            for($rownumber = 0; $rownumber<$rowcount; $rownumber++){

            $data1 = $query_result -> fetch();

            $itemID = $data1['itemID'];
            $title = $data1['title'];
            $description = $data1['description'];
            $photo = $data1['photo'];
            $date = $data1['endDate'];
            $startPrice = $data1['startPrice'];


            $query_result2 = $conn->query( "SELECT bidAmount, bidDate FROM bids WHERE itemID = ".$data1['itemID']." ORDER BY bidAmount LIMIT 1");

            $data2 = $query_result2 -> fetch();

            $currentPrice = $data2['bidAmount'];
            $lastBid = $data2['bidDate'];




            $chaine = '<div class="col-xs-6 col-sm-3 placeholder">


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

            echo $chaine;
            }




function addBid(){
  if(isset($_POST["bid"]) && $currentPrice<$_POST["bid"]){
    $conn->query("INSERT INTO bids (itemID, buyerID, bidAmount, bidDate) VALUES (".$itemID.",".$buyerID.",".$_POST["bid"].",".date("Y-m-d")." ) ");
  }
}


            ?>

          </div>








 <!-- **********************    SECOND ROW     ***************************  -->
          <div class="row placeholders">
          <?php
            $query_result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items ORDER BY itemViewCount DESC LIMIT 8");
            $count_result = $conn -> query("SELECT COUNT(itemID) FROM ( SELECT itemID FROM items ORDER BY itemViewCount DESC LIMIT 8 ) AS count");

            $data3 = $count_result -> fetch();
            $rowcount = $data3['COUNT(itemID)']-4;

            $query_result -> fetch();
            $query_result -> fetch();
            $query_result -> fetch();
            $query_result -> fetch();

            for($rownumber = 0; $rownumber<$rowcount; $rownumber++){

            $data1 = $query_result -> fetch();

            $itemID = $data1['itemID'];
            $title = $data1['title'];
            $description = $data1['description'];
            $photo = $data1['photo'];
            $date = $data1['endDate'];
            $startPrice = $data1['startPrice'];


            $query_result2 = $conn->query( "SELECT bidAmount, bidDate FROM bids WHERE itemID = ".$data1['itemID']." ORDER BY bidAmount LIMIT 1");

            $data2 = $query_result2 -> fetch();

            $currentPrice = $data2['bidAmount'];
            $lastBid = $data2['bidDate'];

            $modalReference = $rownumber + 4;


            $chaine = '<div class="col-xs-6 col-sm-3 placeholder">


  <!-- Modal -->
  <div id="myModal'.$modalReference.'" class="modal fade" role="dialog">
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
    <button type="button" class="btn btn-default pull-left" action ="index.php">Bid</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>

</div>
</div>

              <img src="'.$photo.'" width="200" height="200" class="img" alt="Generic placeholder thumbnail" data-toggle="modal" data-target="#myModal'.$modalReference.'">
              <a  data-toggle="modal" data-target="#myModal'.$modalReference.'">
              <h4>' .$title.'
              </h4>
              <span class="text-muted">  '.$description.' </span>
              </a>
            </div>';

            echo $chaine;
            }

            ?>


          </div>
          <button type="button" class="btn btn-default " action ="index.php">Bid</button>
          <div>

          </div>

          <h2 class="sub-header">Current bids</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Item</th>
                  <th></th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Header</th>
                </tr>
              </thead>
              <tbody>



                <?php

                    $result = $conn->query("SELECT title, description, startPrice, categoryID FROM items");

                    for ($numLines = 1; $numLines < 4; $numLines++)
                    {
                      $data = $result->fetch();

                      echo "<tr>
                        <td>" . $data['title'] . "</td>
                        <td></td>
                        <td>" . $data['description'] . "</td>
                        <td>" . $data['startPrice'] . "</td>
                        <td>" . $data['categoryID'] . "</td>
                      </tr>";
                    }
                ?>

                    <!-- $data = $result->fetch();
                    echo $data['title']; -->






                <tr>
                  <td>1,001</td>
                  <td>Lorem</td>
                  <td>ipsum</td>
                  <td>dolor</td>
                  <td>sit</td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>



    <?php include("../dashboard/baseFooter.php"); ?>

  </body>





</html>
