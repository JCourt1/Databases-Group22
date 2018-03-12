
<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>
<div class="container-fluid nav-side-menu col-sm-3 col-md-2" style="border-right: 10px solid #26224d;">

  <div class="row">

    <div class="col-sm-3 col-md-2 sidebar menustuff">
        <div style="background: #3c3f41;">
            <br><br><br><br>
            </div>


      <h2>Profile </h2>
      <ul class="nav nav-sidebar">
        <li><a href="<?php echo $siteroot; ?>profile/profile_details.php"><span class="glyphicon glyphicon-chevron-right"></span> My account</a> </li>
      </ul>
      <br>
        <br>

      <h2>Buyer </h2>
      <ul class="nav nav-sidebar">

        <li><a href="<?php echo $siteroot; ?>profile/bids_page.php"><span class="glyphicon glyphicon-chevron-right"></span> My Bids</a></li>
        <li><a href="<?php echo $siteroot; ?>profile/watchlist_page.php"><span class="glyphicon glyphicon-chevron-right"></span> Watchlist</a></li>

      </ul>
      <br>
        <br>


        <h2>Seller </h2>
      <ul class="nav nav-sidebar">
          <li><a href="<?php echo $siteroot; ?>profile/AddNewItem.php"><span class="glyphicon glyphicon-chevron-right"></span> Add New Item</a></li>
          <li><a href="<?php echo $siteroot; ?>profile/sales_page.php"><span class="glyphicon glyphicon-chevron-right"></span> Selling Page</a></li>
      </ul>

      <br>




    </div>
  </div>
</div>

