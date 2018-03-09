<?php include("../dashboard/baseHead.php"); ?>

<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>

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

                echo '<div class="col-sm-offset-5 col-md-offset-5"><img src="' . $photo . '" width="200" height="200" class="img" alt="Generic placeholder thumbnail">
                                  <h4>' . $title . '
                                  </h4>
                                  <span class="text-muted">  ' . $description . ' </span>
                                  </div>';


                # Get last 20 bids
                $result2 = $conn->prepare("SELECT bidID, bidDate, bidAmount, users.username FROM bids JOIN users on bids.buyerID = users.userID WHERE itemID = ? ORDER BY bidDate DESC");
                $result2->execute([$_GET['itemID']]);

                $endDate = $conn->prepare("SELECT endDate FROM items WHERE itemID = ?");
                $endDate->execute([$_GET['itemID']]);
                $endDate1 = $endDate -> fetch();

                $rows = $result2->rowCount();
                $res = $result2->fetchAll();


                ?>

        <h1>Bidding ends on: <?php echo convertDate($endDate1['endDate']); ?> at <?php echo convertTime($endDate1['endDate']); ?></h1>

        <table class="table table-dark" >
            <thead>
            <tr scope="row">
                <th scope="col">
                    Bid Date
                </th>
                <th scope="col">
                    Bid Amount
                </th>
                <th scope="col">
                    User
                </th>
            </tr>
            </thead>
            <tbody id="bidTable">

                <?php

                $highestBid = 0;
                $count = 0;

                foreach ($res as $row) {

                    if ($count == 0) {
                        $highestBid = $row['bidAmount'];
                        $count++;
                    }

                    include "bidsRow.php";
                }

                    ?>

            </tbody>
        </table>


        <form id="bidForm" action="<?php echo $siteroot;?>browse/addBidARoom.php?itemID=<?php echo $itemID;?>&currentPrice=<?php echo $highestBid;?>&buyerID=<?php echo $_SESSION['user_ID'];?>" method="post">
            Bid: <input type="text" name="bid"><br>
            <input type="submit" value="Bid" >
        </form>



<!--                    if ($i < 10) {-->
<!---->
<!--                    } else if ($i < 20) {-->
<!---->
<!--                    } else if ($i < 30) {-->
<!---->
<!--                    }-->
<!---->
<!--                }-->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!--            }-->
<!---->
<!--            ?>-->

<!--    <container>-->
<!--        --><?php //include('carousel.php');
//
//        printCarousel($_GET['itemID'], $conn);
//        ?>
<!--    </container>-->
<!---->
<!--    </div>-->
<!---->
<!---->
<!---->
<!---->
<!--    --><?php //include("../dashboard/baseFooter.php");
//
//    ;?>
<!---->
<!--      </body>-->

    <script>

            //console.log(<?php //echo json_encode($res); ?>//);
            var res=<?php echo json_encode($res); ?>;


            var hBid = <?php echo $highestBid;?>;
            console.log(hBid);

        $(function () {
           setInterval(function() {
               $.ajax({

                   url: "realtimeBids.php",
                   type: "POST",
                   data: {"itemID":<?php echo $_GET['itemID'];?>, "highestBid":hBid},
                   success: function(response) {

                       console.log("caca");
                       console.log(response);
                       console.log(response.newHighest);
                       console.log(response.newRows);


                       if (response.newHighest != 0) {
                           hBid = response.newHighest;
                           $("#bidForm").attr("action", function(index, previousValue){

                               var result = previousValue.replace(/currentPrice=.+&/, "currentPrice=" + hBid + "&");

                               return result;
                           });

                           $("#bidTable").prepend(response.newRows.toString());
                       }


               }, error: function (request, status, error) {
                       alert(request.responseText);
                   },


                   dataType: "json"});
            }, 5000);
        });

        </script>
    </div>
            <footer class="footer col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
            <panel>
            <h1 class="text-center" >Other items with most recent bids</h1>
            </panel>

<?php } else {?>

                </div>

            <footer class="footer col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
            <panel>
            <h1 class="text-center">Items with most recent bids</h1>
            </panel>


<?php }?>



            <container>
               <?php include('carousel.php');

               $itemID = -1;
               if (isset($_GET['itemID'])) {
                   $itemID = $_GET['itemID'];
               }

               printCarousel($itemID, $conn);
               ?>
            </container>

            </footer>






           <?php include("../dashboard/baseFooter.php");

           ;?>

             </body>

</html>