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

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHeader.php";?>


    <p> Admin page </p>




    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>

  </body>

</html>
