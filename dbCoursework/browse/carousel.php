<?php

$siteroot = '/Databases-Group22/dbCoursework/';


# select 4 items to have been bid upon most recently
# -> joins the items table with the bids table on unique item IDs, and only takes items which haven't expired (> now()).
# Groups by item ID and then selects the row with the max (most recent)
# bid date. These remaining rows of items are then ordered by bid date and only 4 are taken.

function generateCarouselItem($number) {

        global $siteroot;

        return '<div class="item">
        <div class="placeholderCarousel">
            <a href="'.$siteroot.'browse/auctionRooms.php?itemID='.$number['itemID'].'">  
                <img src=" '  . $number['photo'] . ' " width="200" height="200" class="img center-block carouselIMG">
            </a>
            <p class="placeholderCarousel">'.$number['title'].'</p>
        </div>
        </div>';

}

function printCollaborativeFilteredCarousel($userID, $itemIDNotToDisplay, $conn) {

    global $siteroot;


    // Get a list of those items that have been bid on by other users,
    // where the items haven't expired or been removed, not taking the item currently displayed in the auction room,
    // nor any of the items that the user has already bid on, or any of the items the user is selling himself,
    // and also only picking other users who have bid on the same items as the user.

    $query_result = $conn->prepare("SELECT DISTINCT (bids.itemID), items.title, items.description, items.photo, items.endDate, items.startPrice
                    FROM bids JOIN items ON bids.itemID = items.itemID
                    WHERE  items.endDate > NOW() AND items.itemRemoved = 0 AND items.itemID <> :itemCurrentlyDisplayed 
                    AND items.itemID NOT IN (SELECT DISTINCT itemID
        												FROM bids
        												WHERE buyerID = :userInQuestion) 
        		  
        			AND items.itemID NOT IN (SELECT DISTINCT itemID 
                                                        FROM items 
                                                        WHERE sellerID = :userInQuestion)							
        											
        			AND buyerID IN
    
                    (SELECT buyerID FROM
                    (SELECT COUNT(DISTINCT itemID) freq, buyerID
                    FROM bids
                    WHERE buyerID <> :userInQuestion AND itemID IN (SELECT DISTINCT itemID
        												FROM bids 
        												WHERE buyerID = :userInQuestion)
                    GROUP BY buyerID
                    ORDER BY freq desc)T)");

    $query_result->bindParam(':userInQuestion', $userID);
    $query_result->bindParam(':itemCurrentlyDisplayed', $itemIDNotToDisplay);
    $query_result->execute();

    $rowCount = $query_result -> rowCount();
    $first = $query_result -> fetch();


    if ($rowCount > 0) {
        $firstID = '?itemID=' . $first['itemID'];
        $firstphoto = $first['photo'];
        $firstTitle = $first['title'];
    } else {
        $firstID = '';
        $firstphoto = "https://www.horizontrvl.com/assets/images/icon_warning_red.png";
        $firstTitle = 'Either you haven\'t bid on anything, or no one else has bid on the same items as you, or they have but haven\'t bid on any other items!';
    }


    $string = '
        
        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
          <!-- Indicators -->
          
        
          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <div class="item active">
            <div class="placeholderCarousel">
            <a href="'.$siteroot.'browse/auctionRooms.php'.$firstID.'">
              <img src=" '  . $firstphoto . ' " width="200" height="200" class="img center-block carouselIMG">
              </a>
              <p class="placeholderCarousel">'.$firstTitle.'</p>
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
            <div class="placeholderCarousel">
            <a href="'.$siteroot.'browse/auctionRooms.php?itemID='.$first['itemID'].'">
              <img src=" '  . $first['photo'] . ' " width="200" height="200" class="img center-block carouselIMG">
              <p class="placeholderCarousel">'.$first['title'].'</p>
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


