<?php
    $siteroot = '/dbCoursework';

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

    // 1. Array of items in the user's watchlist:
    $query_watchlist = "SELECT i.*
                            FROM watchlist_items w
                            LEFT JOIN items i ON i.itemID = w.itemID
                            WHERE w.userID = ".$userID." AND i.endDate > NOW() AND i.itemRemoved = 0
                            ORDER BY i.endDate ASC";
    $statement1 = $conn->prepare($query_watchlist);
    $statement1->execute();
    $res_watchlist = $statement1->fetchAll();
     ?>



    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <h1 class="page-header">My Watchlist</h1>

        <div class="container-fluid panel panel-success" style="padding-top: 30px; border: 3px solid transparent; border-color: #d6e9c6;">

            <?php if(!empty($res_watchlist)){ ?>
            <!-- TABLE OF ITEMS IN WATCHLIST -->
            <table class="table table-dark pageableTable" >
                <thead>
                    <tr scope="row">
                        <th scope="col">Item Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Auction End Date</th>
                        <th scope="col">Auction Room</th>
                        <th scope="col">Edit Item</th>
                    </tr>
                </thead>
                <tbody id="currentBidsTable">

                    <?php

                        foreach ($res_watchlist as $row) {

                            // Get category:
                            $cat_query = "SELECT categoryName FROM categories WHERE categoryID = ".$row['categoryID'];
                            $statement4 = $conn->prepare($cat_query);
                            $statement4->execute();
                            $category = $statement4->fetch();

                            include "watchlist_row.php";
                        }

                    ?>
                </tbody>
            </table>
        <?php } else { echo "<p style='font-style: italic; font-size: 24px; color: grey;'>You haven't added anything to your watchlist yet.</p>";} ?>

        </div>

    <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>

  </body>

</html>

<script>

    $.noConflict();
    $(document).ready( function () {
        $('.pageableTable').DataTable(
            {"pageLength": 10, "order": [[ 2, "asc" ]], searching: false, "lengthChange": false});
    } );
</script>