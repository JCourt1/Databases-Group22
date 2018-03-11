<?php $siteroot = '/Databases-Group22/dbCoursework'; ?>

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

        <h1 class="page-header" style="display:inline-block">Dashboard</h1>

        <h3 style="display:inline-block; float: right"><span class="glyphicon glyphicon-menu-down"></span>  Most Popular Items</h3>

        <div class="container-fluid panel panel-success" style="border: 3px solid transparent;
          border-color: #a5a6ff;">
          <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/commonElements/browsePopularItems.php";?>
        </div>

        </div>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>

  </body>

</html>
