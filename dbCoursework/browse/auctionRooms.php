<?php include("../dashboard/baseHead.php"); ?>

<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>

<link href="../resources/css/auctionRooms.css" rel="stylesheet">

  <body>

    <?php include('../dashboard/baseHeader.php'); ?>

    <?php include('../dashboard/sideMenu.php'); ?>


    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


        <?php


            if (isset($_GET['itemID'])) {
                $result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items  WHERE itemRemoved = 0 AND itemID = " . $_GET['itemID']);
                $data1 = $result->fetch();
                $itemID = $data1['itemID'];
                $title = $data1['title'];
                $description = $data1['description'];
                $photo = $data1['photo'];
                $date = $data1['endDate'];
                $startPrice = $data1['startPrice'];

                echo '<div class="col-sm-offset-5 col-md-offset-5"><img src="' . $photo . '" width="200" height="200" class="img" alt="Generic placeholder thumbnail" style="border-radius: 50%;">
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

        <br>
        <h1 style="text-align: center">Bidding ends on <?php echo date_format(date_create($endDate1['endDate']),"d-m-Y"); ?> at <?php echo date_format(date_create($endDate1['endDate']),"H:i:s"); ?></h1>
        <br>
        <?php if(!empty($res)) {?>

        <table id="table_id" class="table table-dark" data-pagination="true"
                   data-id-field="name"
                   data-page-list="[5, 10, 25, 50, 100, ALL]"
                   data-page-size="5">
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





















    <?php } else {


            echo "<p style='font-style: italic; font-size: 24px; color: grey;'>Item doesn't currently have any bids.</p>";


        } ?>


        <br>
        <br>
        <form id="bidForm" style="font-size: 20px;" class="centered" action="<?php echo $siteroot;?>dashboard/addBidMaster.php?itemID=<?php echo $itemID;?>&currentPrice=<?php if(!empty($highestBid)){echo $highestBid;}?>&buyerID=<?php echo $_SESSION['user_ID'];?>" method="post">
            Make a bid: <input type="text" name="bid" style="width: 200px;
                           ;">
            <input type="submit" value="Bid">
        </form>
        <br>
        <br>
        <br>
        <br>




            </div>

                <footer class="footer col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
                    <panel>
                        <h3 class="text-center">Customers who placed bids on the same items as you were also interested in:</h3>
                    </panel>
                    <br>
                    <container>
                       <?php include('carousel.php');

                       $itemID = -1;
                       if (isset($_GET['itemID'])) {
                           $itemID = $_GET['itemID'];
                       }

                       printCollaborativeFilteredCarousel($_SESSION['user_ID'], $itemID, $conn);
                       ?>
                    </container>




<!--else statement referring to "if (isset($_GET['itemID']))" towards ~ line 50-->
<?php } else {?>

            </div>
                <footer class="footer col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
                    <panel>
                        <h1 class="text-center" >Items with most recent bids:</h1>
                    </panel>

                    <container>
                       <?php include('carousel.php');

                       $itemID = -1;
                       if (isset($_GET['itemID'])) {
                           $itemID = $_GET['itemID'];
                       }

                       printCarousel($itemID, $conn);
                       ?>
                    </container>

<?php }?>

                </footer>

           <?php include("../dashboard/baseFooter.php");

           ;?>

             </body>

</html>

<script>

    $.noConflict();
    $(document).ready( function () {
        $('#table_id').DataTable(
            {"pageLength": 10, "order": [[ 1, "desc" ]], searching: false, "lengthChange": false});
    } );
</script>