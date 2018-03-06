
<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <h2> My Bids </h2>
      <ul class="nav nav-sidebar">

        <li><a href="<?php echo $siteroot; ?>profile/my_current_bids.php">My current bids</a></li>
        <li><a href="<?php echo $siteroot; ?>profile/history.php">History</a></li>

      </ul>
      <br>
        <h2> Sell </h2>
      <ul class="nav nav-sidebar">
          <li><a href="<?php echo $siteroot; ?>profile/AddNewItem.php">Add New Item</a></li>
      </ul>
        <br>

      <h2> Browse </h2>
      <ul class="nav nav-sidebar">
        <li><a href="">Search item</a></li>
        <li><a href="<?php echo $siteroot; ?>browse/auctionRooms.php">Auction Rooms</a></li>
      </ul>
      <br>
    </div>
    </div>
</div>
