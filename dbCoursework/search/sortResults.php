<?php

try {
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                    "team22@ibe-database",
                    "ILoveCS17");
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$sort = $_POST['sort'];

$res = $_POST['res'];

// Perform sort based on criteria:
if ($sort == 0){
    function cmp($a, $b){
        return strcmp($a['endDate'], $b['endDate']);
    }
    usort($res, "cmp");
} else if ($sort == 1){
    function cmp($a, $b){
        return strcmp($b['endDate'], $a['endDate']);
    }
    usort($res, "cmp");
} else if ($sort == 2){
    function cmp($a, $b){
        return($a['bidAmount'] < $b['bidAmount']) ? -1 : 1;
    }
    usort($res, "cmp");
} else if ($sort == 3){
    function cmp($a, $b){
        return($a['bidAmount'] > $b['bidAmount']) ? -1 : 1;
    }
    usort($res, "cmp");
}

// Generate html:
$rownumber = 0;

foreach ($res as $searchResult) {
    if (new DateTime($searchResult['endDate']) > new DateTime()) {

        # Get the bid information:
        $bidInfo = $conn->query("SELECT bidAmount, bidDate FROM bids WHERE itemID = " . $searchResult['itemID'] . " ORDER BY bidAmount LIMIT 1");

        $bid = $bidInfo->fetch();

        $chaine = '<div class="col-xs-6 col-sm-3 placeholder">

            <!-- Modal -->
            <div id="myModal' . $rownumber . '" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title">' . $searchResult['title'] . '</h4>
                        </div>
                        <div class="modal-body">
                            <img src="' . $searchResult['photo'] . '" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail"
                            <p>' . $searchResult['description'] . '</p>
                            <h3 id="countdown"> PLACEHOLDER </h3>
                            <h3 > Start Price: ' . $searchResult['startPrice'] . ' </h2>
                            <h3> Current Price: ' . $searchResult['bidAmount'] . ' </h2>
                            <h3> Last Bid: ' . $searchResult['bidDate'] . ' </h2>
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

            <img src="' . $searchResult['photo'] . '" width="200" height="200" class="img" alt="Generic placeholder thumbnail" data-toggle="modal" data-target="#myModal' . $rownumber . '">
            <a  data-toggle="modal" data-target="#myModal' . $rownumber . '">
                <h4>' . $searchResult['title'] . '
                </h4>
                <span class="text-muted">  ' . $searchResult['description'] . ' </span>
            </a>
        </div>';

        echo $chaine;
        $rownumber += 1;

    }
}





?>
