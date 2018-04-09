<?php $siteroot = '/dbCoursework'; ?>


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

  <h1 class="page-header">Homepage</h1>


</div>




    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>

  </body>

</html>
