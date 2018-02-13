<!DOCTYPE html>
<html lang="en">
  <head>

  <?php
$servername = "ibe-database.mysql.database.azure.com"  ;
$dbname = "ibe_db" ;
$username =  "team22@ibe-database" ;
$password =  "ILoveCS17" ;
?>

<?php
try
{
  $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8", "team22@ibe-database", "ILoveCS17");
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>



    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Ibé</title>


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>



    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

<!-- Have to somewhere have a record of who is currently logged in so we have the userID etc. -->






"""
  </head>

  <body>



    <nav class="navbar navbar-inverse navbar-fixed-top">









      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand sitename" href="#">IBÉ</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="submit" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <h2> Account </h2>
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Dashboard <span class="sr-only">(current)</span></a></li>
            <li><a href="#">My current bids</a></li>
            <li><a href="#">History</a></li>
            <li><a href="#">Messages</a></li>
          </ul>
          <br>
          <h2> Shopping </h2>
          <ul class="nav nav-sidebar">
            <li><a href="search_result_page.php">Search item</a></li>
            <li><a href="">Categories</a></li>
            <li><a href="">Vendors</a></li>
            <li><a href="">Another nav item</a></li>
            <li><a href="">More navigation</a></li>
          </ul>
          <br>
          <h2> Extra </h2>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul>
        </div>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>

          <div class="row placeholders">

            <?php
            $querry_result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items ORDER BY itemViewCount DESC LIMIT 4");
            $count_result = $conn -> query("SELECT COUNT(itemID) FROM ( SELECT itemID FROM items ORDER BY itemViewCount DESC LIMIT 4 ) AS count");

            $data3 = $count_result -> fetch();
            $rowcount = $data3['COUNT(itemID)'];

            for($rownumber = 0; $rownumber<$rowcount; $rownumber++){

            $data1 = $querry_result -> fetch();

            $itemID = $data1['itemID'];
            $title = $data1['title'];
            $description = $data1['description'];
            $photo = $data1['photo'];
            $date = $data1['endDate'];
            $startPrice = $data1['startPrice'];


            $querry_result2 = $conn->query( "SELECT bidAmount, bidDate FROM bids WHERE itemID = ".$data1['itemID']." ORDER BY bidAmount LIMIT 1");

            $data2 = $querry_result2 -> fetch();

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
            $querry_result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items ORDER BY itemViewCount DESC LIMIT 8");
            $count_result = $conn -> query("SELECT COUNT(itemID) FROM ( SELECT itemID FROM items ORDER BY itemViewCount DESC LIMIT 8 ) AS count");

            $data3 = $count_result -> fetch();
            $rowcount = $data3['COUNT(itemID)']-4;

            $querry_result -> fetch();
            $querry_result -> fetch();
            $querry_result -> fetch();
            $querry_result -> fetch();

            for($rownumber = 0; $rownumber<$rowcount; $rownumber++){

            $data1 = $querry_result -> fetch();

            $itemID = $data1['itemID'];
            $title = $data1['title'];
            $description = $data1['description'];
            $photo = $data1['photo'];
            $date = $data1['endDate'];
            $startPrice = $data1['startPrice'];


            $querry_result2 = $conn->query( "SELECT bidAmount, bidDate FROM bids WHERE itemID = ".$data1['itemID']." ORDER BY bidAmount LIMIT 1");

            $data2 = $querry_result2 -> fetch();

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



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script  $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})> </script>
  </body>





</html>
