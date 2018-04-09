
<?php $siteroot = '/dbCoursework'; ?>
<div class="container-fluid nav-side-menu col-sm-3 col-md-2">

  <div class="row">

    <div class="col-sm-3 col-md-2 sidebar menustuff">
        <div style="background: #3c3f41;">
            <br><br><br><br>
            </div>


      <h2>Profile </h2>
      <ul class="nav nav-sidebar">
        <li><a href="<?php echo $siteroot; ?>profile/profile_details.php"><span class="glyphicon glyphicon-chevron-right"></span> My account</a> </li>
        <li><a href="<?php echo $siteroot; ?>profile/my_feedback_page.php"><span class="glyphicon glyphicon-chevron-right"></span> My feedback</a> </li>
      </ul>
      <br>
        <br>

      <h2>Buyer </h2>
      <ul class="nav nav-sidebar">

        <li><a href="<?php echo $siteroot; ?>profile/bids_page.php"><span class="glyphicon glyphicon-chevron-right"></span> My bids</a></li>
        <li><a href="<?php echo $siteroot; ?>profile/watchlist_page.php"><span class="glyphicon glyphicon-chevron-right"></span> Watchlist</a></li>

      </ul>
      <br>
        <br>


        <h2>Seller </h2>
      <ul class="nav nav-sidebar">
          <li><a href="<?php echo $siteroot; ?>profile/AddNewItem.php"><span class="glyphicon glyphicon-chevron-right"></span> Add new item</a></li>
          <li><a href="<?php echo $siteroot; ?>profile/sales_page.php"><span class="glyphicon glyphicon-chevron-right"></span> Selling page</a></li>
      </ul>

      <br>
      <br>
      <br>

    <ul class="nav nav-sidebar">
        <li><a href="<?php echo $siteroot; ?>profile/help.php"><span class="glyphicon glyphicon-exclamation-sign"></span> Help and feeback</a></li>
    </ul>

    </div>
  </div>
</div>
