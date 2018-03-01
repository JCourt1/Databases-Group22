<?php $siteroot = '/Databases-Group22/dbCoursework'; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHead.php";?>
</head>

  <body>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHeader.php";?>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/sideMenu.php";?>

    

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/commonElements/browsePopularItems.php";?>
    </div>

    <?php include 'addBid.php';?>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>

  </body>





</html>
