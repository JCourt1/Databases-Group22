
<?php



    $myHighestBids = $_SESSION['myHighestBids'];
    $itemsImSelling = $_SESSION['itemsImSelling'];




    foreach ($myHighestBids as $highestBid) {

        $itemID = $highestBid[0];
        $bidAmount = $highestBid[1];

        echo '<script>
            
            $(function () {
                       setInterval(function() {
                           $.ajax({
            
                               url: "checkForHigherBids.php",
                               type: "POST",
                               data: {"itemID":'.$itemID.', "highestBid":'.$bidAmount.'},
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
                                       
                                       
                                       alert(response);
            
                                       $("#bidTable").prepend(response.newRows.toString());
                                   }
            
            
                           }, error: function (request, status, error) {
                                   alert(request.responseText);
                               },
            
            
                               dataType: "json"});
                        }, 5000);
                    });
        </script>';



    }














?>



