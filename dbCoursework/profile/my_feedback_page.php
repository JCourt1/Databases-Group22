<?php
    $siteroot = '/Databases-Group22/dbCoursework';

    include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHead.php";

    if (!isset($_SESSION['user_ID'])) {
        $failed = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
        header('Location: ' . $failed);
    }
?>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHeader.php";?>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/sideMenu.php";?>

    <?php
    // Session
    if(isset($_SESSION['user_ID'])){
        $userID = $_SESSION['user_ID'];
    } else {
        $userID = NULL;
    }

    // SQL QUERIES
    $query = "SELECT itemID, senderID, receiverID, isPositive
                FROM feedback
                WHERE receiverID = :userID AND isPositive IS NOT NULL";
    $statement = $conn->prepare($query);
    $statement->bindParam(':userID', $userID);
    $statement->execute();

    $res = $statement->fetchall();

    // Summary statistics
    $positive = 0;
    $total = 0;
    foreach ($res as $feedback) {
        if($feedback['isPositive'] != 0){
            $positive += 1;
        }
        $total += 1;
    }

    $negative = $total - $positive;

    // Percentage positive
    if($total > 0){
        $percentage = ($positive * 1.0)/$total;
        $percentage = round($percentage*100, 1);
    } else {
        $percentage = 0;
    }

    ?>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <h1 class="page-header">My Feedback</h1>

        <div class="container-fluid panel panel-success" style="padding-top: 30px; border: 3px solid transparent; border-color: #d6e9c6;">
            <h3 class="page-header">Summary</h3>

            <div class="col-xs-6 col-sm-3 placeholder" style="width: 30%; font-size: 150px;">
                <span style='color: green;' class='glyphicon glyphicon-thumbs-up'><p style='font-family: arial;'><?php echo ' '.$positive.' '; ?></p></span>
            </div>

            <div class="col-xs-6 col-sm-3 placeholder" style="width: 30%; font-size: 150px;">
                <span style='color: red;' class='glyphicon glyphicon-thumbs-down'><p style='font-family: arial;'><?php echo ' '.$negative.' '; ?></p></span>
            </div>

            <div class="col-xs-6 col-sm-3 placeholder" style="width: 30%; font-size: 150px;">
                <span style='color: black;' class='glyphicon glyphicon-heart'><p style='font-family: arial;'><?php echo ' '.$percentage.'%'; ?></p></span>
            </div>



        </div>


    </div>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>

  </body>

</html>
