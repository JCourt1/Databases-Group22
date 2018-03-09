
<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <h2> Buyer </h2>
      <ul class="nav nav-sidebar">

        <li><a href="<?php echo $siteroot; ?>profile/bids_page.php">My Bids</a></li>
        <li><a href="<?php echo $siteroot; ?>profile/watchlist_page.php">Watchlist</a></li>

      </ul>
      <br>
        <h2> Seller </h2>
      <ul class="nav nav-sidebar">
          <li><a href="<?php echo $siteroot; ?>profile/AddNewItem.php">Add New Item</a></li>
          <li><a href="<?php echo $siteroot; ?>profile/sales_page.php">Selling Page</a></li>
      </ul>
        <br>
        <!--
      <h2> Browse </h2>
      <ul class="nav nav-sidebar">
        <li><a href="">Search item</a></li>
        <li><a href="<?php echo $siteroot; ?>browse/auctionRooms.php">Auction Rooms</a></li>
      </ul>
  -->
      <h2> Profile </h2>
      <ul class="nav nav-sidebar">

        <li><a href="<?php echo $siteroot; ?>profile/profile_details.php">My account</a></li>

      </ul>
      <br>
    </div>
  </div>
</div>
