
<?php


        ### To do:
        ### make sure Session variables are set at login.
        ### At login, Deal with any 1s in the needsNotification column.



    $myHighestBids = $_SESSION['myBids'];
    $itemsImSelling = $_SESSION['myItems'];

    foreach ($myHighestBids as $highestBid) {

        $itemID = $highestBid['itemID'];
        $itemName = $highestBid['title'];
        $bidID = $highestBid['bidID'];
        $bidAmount = $highestBid['bidAmount'];

        echo '<script>
            
            $(function () {
                       setInterval(function() {
                           $.ajax({
            
                               url: "checkForHigherBids.php",
                               type: "POST",
                               data: {"itemName":'.$itemName.', "itemID":'.$itemID.', "bidID":'.$bidID.', "highestBid":'.$bidAmount.'},
                               success: function(response) {
            
                                   if (response.newHighest != 0) {
                                       hBid = response.newHighest;
                                       alert(response.responseMSG);
                                   }
            
            
                           }, error: function (request, status, error) {
                                   alert(request.responseText);
                               },
            
            
                               dataType: "json"});
                        }, 8000);
                    });
        </script>';
    }



    foreach ($itemsImSelling as $itemImSelling) {

        $itemID = $itemImSelling['itemID'];
        $itemName = $itemImSelling['title'];
        $bidID = $itemImSelling[2];
        $bidAmount = $itemImSelling[3];

        echo '<script>
            
            $(function () {
                       setInterval(function() {
                           $.ajax({
            
                               url: "checkForHigherBids.php",
                               type: "POST",
                               data: {"itemID":'.$itemID.',"itemName":'.$itemName.', "bidID":'.$bidID.', "highestBidAmount":'.$bidAmount.'},
                               success: function(response) {
            
                                   if (response.newHighest != 0) {
                                       hBid = response.newHighest;
                                       alert(response.responseMSG);
                                   }
            
            
                           }, error: function (request, status, error) {
                                   alert(request.responseText);
                               },
            
            
                               dataType: "json"});
                        }, 8000);
                    });
        </script>';
    }





































?>



