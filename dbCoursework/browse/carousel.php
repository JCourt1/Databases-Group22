
<?php


# select 4 items to have been bid upon most recently
$query_result = $conn->query("SELECT b.bidDate, i.itemID, i.title, i.description, i.photo, i.endDate, i.startPrice
FROM items as i
JOIN bids as b ON i.itemID = b.itemID
ORDER BY b.bidDate DESC LIMIT 4;");




$first = $query_result -> fetch();
$second = $query_result -> fetch();
$third = $query_result -> fetch();
$fourth = $query_result -> fetch();

$string = '

<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
    <div class="placeholder" style="width: 100%;">
      <img src=" '  . $first['photo'] . ' " width="200" height="200" class="img center-block">
    </div>
    </div>

    <div class="item">
    <div class="placeholder">
      <img src=" '  . $second['photo'] . ' " width="200" height="200" class="img center-block">
    </div>
    </div>
    
    
    <div class="item">
    <div class="placeholder">
      <img src=" '  . $third['photo'] . ' " width="200" height="200" class="img center-block">
    </div>
    </div>
      
    <div class="item">
    <div class="placeholder">
        <img src=" '  . $fourth['photo'] . ' " width="200" height="200" class="img center-block">
    </div>
    </div>
      
  </div>

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


?>