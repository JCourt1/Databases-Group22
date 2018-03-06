<?php

session_start();

if (!isset($_SESSION['user_ID'])) {
    $failed = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
    header('Location: ' . $failed);
}
?>


<?php $siteroot = '/Databases-Group22/dbCoursework'; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHead.php";?>
</head>

  <body>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHeader.php";?>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/sideMenu.php";?>

    

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <h1 class="page-header">Dashboard</h1>

        <div class="container-fluid panel panel-success" style="padding-top: 30px; border: 3px solid transparent;
          border-color: #d6e9c6;">
    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/commonElements/browsePopularItems.php";?>
        </div>

        </div>

    <?php include 'addBid.php';?>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>

  </body>

</html>
