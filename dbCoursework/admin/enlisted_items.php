<?php $siteroot = '/Databases-Group22/dbCoursework'; ?>


<?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHead.php";?>

<?php

if (!isset($_SESSION['admin_ID'])) {
    $failed = 'http://' . $_SERVER['HTTP_HOST'] . $siteroot . '/index.php';
    header('Location: ' . $failed);
}
?>

</head>

  <body>

    <?php include ('baseHeader.php');?>
    <?php include('sideMenu.php'); ?>


<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

  <h1 class="page-header">Enlisted Items</h1>

  <div class="container-fluid panel panel-success" style="padding-top: 30px; border: 3px solid transparent; border-color: #d6e9c6;">

      <!-- TABLE OF ITEMS CURRENTLY BIDDING ON -->
      <table class="table table-dark" >
          <thead>
              <tr scope="row">
                  <th scope="col">Item Name</th>
                  <th scope="col">Category</th>
                  <th scope="col">Item condition</th>
                  <th scope="col">Start price</th>
                  <th scope="col">Reserve price</th>
                  <th scope="col">Bid Date</th>
                  <th scope="col">Total views</th>
                  <th scope="col">Delete</th>
              </tr>
          </thead>
          <tbody id="currentBidsTable">

          </tbody>
      </table>
  </div>
</div>




    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>

  </body>

</html>
