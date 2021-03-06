<?php $siteroot = '/dbCoursework'; ?>


<?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHead.php";?>


</head>

  <body>

    <?php include ('baseHeader.php');?>
    <?php include('sideMenu.php'); ?>


<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

  <h1 class="page-header">Listed Items</h1>

  <div class="container-fluid panel panel-success" style="padding-top: 30px; border: 3px solid transparent; border-color: #d6e9c6;">

    <?php

        //create connection
        $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_dbv3;charset=utf8","team22@ibe-database","ILoveCS17");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get the listed items
        $query = "SELECT *   FROM items WHERE itemRemoved = 0";
        $statement = $conn->prepare($query);
        $statement->execute();

    if(!empty($statement)) { ?>

      <!-- TABLE OF ITEMS CURRENTLY BIDDING ON -->
      <table class="table table-dark pageableTable"  >
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
        <tbody id="all items">
            <?php
                //display the results
                foreach ($statement as $row)
                {
                    // Get category:
                    $cat_query = "SELECT categoryName FROM categories WHERE categoryID = ".$row['categoryID'];
                    $statement2 = $conn->prepare($cat_query);
                    $statement2->execute();
                    $category = $statement2->fetch();
                    if(!$row['itemRemoved']){
                    include "items_row.php";
                    }
                }

            ?>


        </tbody>
      </table>
    <?php } else { echo "<p style='font-style: italic; font-size: 24px; color: grey;'>There are no listed items.</p>";} ?>
  </div>
</div>




    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>

  </body>

</html>

<script>

$.noConflict();
$(document).ready( function () {
    $('.pageableTable').DataTable(
        {"pageLength": 10, "order": [[ 3, "desc" ]], searching: true, "lengthChange": false});
} );
</script>
