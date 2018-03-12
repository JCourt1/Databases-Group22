<?php

$siteroot = '/Databases-Group22/dbCoursework/';


# select 4 items to have been bid upon most recently
# -> joins the items table with the bids table on unique item IDs, and only takes items which haven't expired (> now()).
# Groups by item ID and then selects the row with the max (most recent)
# bid date. These remaining rows of items are then ordered by bid date and only 4 are taken.

function generateCarouselItem($number) {

        global $siteroot;

        return '<div class="item">
        <div class="placeholder">
            <a href="'.$siteroot.'browse/auctionRooms.php?itemID='.$number['itemID'].'">
                <img src=" '  . $number['photo'] . ' " width="200" height="200" class="img center-block">
            </a>
        </div>
        </div>';

}


function printCarousel($itemIDNotToDisplay, $conn) {

    global $siteroot;

    $query_result = $conn->query("SELECT i.itemID, i.title, i.description, i.photo, i.endDate, i.startPrice, max(b.bidDate) as maxBidDate
    FROM items as i
    JOIN bids as b ON i.itemID = b.itemID
    WHERE i.endDate > NOW() AND itemRemoved = 0 AND i.itemID <> $itemIDNotToDisplay 
    GROUP BY i.itemID
    ORDER BY maxBidDate DESC LIMIT 6;");



    $rowCount = $query_result -> rowCount();
    $first = $query_result -> fetch();




    $string = '

        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
          <!-- Indicators -->


          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <div class="item active">
            <div class="placeholder">
            <a href="'.$siteroot.'browse/auctionRooms.php?itemID='.$first['itemID'].'">
              <img src=" '  . $first['photo'] . ' " width="200" height="200" class="img center-block">
              </a>
            </div>
            </div>


            ';

    for ($i = 1; $i < $rowCount; $i++) {
        $string = $string . generateCarouselItem($query_result -> fetch());
    }


    $string = $string . '</div>

          <!-- Left and right controls -->
          <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
          </a>
        </div> ';


    echo $string;

}

?>
