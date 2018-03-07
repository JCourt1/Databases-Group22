<?php include("../dashboard/baseHead.php"); ?>

<link href="../resources/css/auctionRooms.css" rel="stylesheet">

  <body>

    <?php include('../dashboard/baseHeader.php'); ?>

    <?php include('../dashboard/sideMenu.php'); ?>


    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


        <?php


            if (isset($_GET['itemID'])) {
                $result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items  WHERE itemID = " . $_GET['itemID']);
                $data1 = $result->fetch();
                $itemID = $data1['itemID'];
                $title = $data1['title'];
                $description = $data1['description'];
                $photo = $data1['photo'];
                $date = $data1['endDate'];
                $startPrice = $data1['startPrice'];

                echo '<div class="col-sm-offset-5 col-md-offset-5"><img src="' . $photo . '" width="200" height="200" class="img" alt="Generic placeholder thumbnail" data-toggle="modal" data-target="#myModal' . $modalReference . '">
                                  <a  data-toggle="modal" data-target="#myModal' . $modalReference . '">
                                  <h4>' . $title . '
                                  </h4>
                                  <span class="text-muted">  ' . $description . ' </span>
                                  </a> </div>';

                $result2 = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items  WHERE itemID = " . $_GET['itemID']);
                $data2 = $result2->fetch();





            }

            ?>





    <container>
        <?php include('carousel.php'); ?>
    </container>






















    </div>







    <?php include("../dashboard/baseFooter.php"); ?>

      </body>





    </html>
