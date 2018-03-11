
<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>
<div class="container-fluid nav-side-menu col-sm-3 col-md-2">

  <div class="row">

    <div class="col-sm-3 col-md-2 sidebar">
        <div style="background: #c7ddf7;">
            <br><br><br><br>
            </div>

        <div class='menustuff' style="background: #c7ddf7;">
      <h2> <span class="glyphicon glyphicon-user"></span> Profile </h2>
      <ul class="nav nav-sidebar">
        <li><a href="<?php echo $siteroot; ?>profile/profile_details.php"><span class="glyphicon glyphicon-chevron-right"></span> My account</a> </li>
      </ul>
      <br>
        <br>

      <h2> <span class="glyphicon glyphicon-shopping-cart"></span> Buyer </h2>
      <ul class="nav nav-sidebar">

        <li><a href="<?php echo $siteroot; ?>profile/bids_page.php"><span class="glyphicon glyphicon-chevron-right"></span> My Bids</a></li>
        <li><a href="<?php echo $siteroot; ?>profile/watchlist_page.php"><span class="glyphicon glyphicon-chevron-right"></span> Watchlist</a></li>

      </ul>
      <br>
        <br>


        <h2> <span class="glyphicon glyphicon-euro"></span> Seller </h2>
      <ul class="nav nav-sidebar">
          <li><a href="<?php echo $siteroot; ?>profile/AddNewItem.php"><span class="glyphicon glyphicon-chevron-right"></span> Add New Item</a></li>
          <li><a href="<?php echo $siteroot; ?>profile/sales_page.php"><span class="glyphicon glyphicon-chevron-right"></span> Selling Page</a></li>
      </ul>

      <br>
        </div>




    </div>
  </div>
</div>

