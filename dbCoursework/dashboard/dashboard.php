<?php $siteroot = '/dbCoursework'; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHead.php";?>

<?php

if (!isset($_SESSION['user_ID'])) {
    $failed = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
    header('Location: ' . $failed);
}
?>


</head>

  <body>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHeader.php";?>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/sideMenu.php";?>



    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <h1 class="page-header"> Dashboard</h1>

        <h3> Most Popular Items</h3>

        <div class="container-fluid panel panel-success">
          <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/commonElements/browsePopularItems.php";?>
        </div>

        </div>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>


    <footer class="footer col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
             <panel>
                 <h1 class="text-center">Items with most recent bids</h1>

                 <br>
             </panel>



             <container>
                <?php include($_SERVER['DOCUMENT_ROOT']."$siteroot/browse/carousel.php");

                $itemID = -1;

                printCarousel($itemID, $conn);
                ?>
             </container>

             </footer>





  </body>

</html>
