

<?php $siteroot = '/dbCoursework'; ?>

<?php include "baseHead.php"; ?>


<?php


if (isset($_SESSION['user_ID'])) {
    $dashboard = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/dashboard.php';
    header('Location: ' . $dashboard);
}
?>

<link href=<?php echo $siteroot; ?>"resources/css/base.css" rel="stylesheet">


</head>

<body>

<?php include 'baseHeader.php'; ?>

<div class=" col-sm-12 col-md-12 col-lg-12 main indexItems">
<?php include 'commonElements/browsePopularItems.php';?>
</div>


<?php include "baseFooter.php"; ?>



</body>





</html>
