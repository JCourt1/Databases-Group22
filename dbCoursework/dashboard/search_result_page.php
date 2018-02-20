<?php include('baseHead.php'); ?>

<body>


<?php include('baseHeader.php'); ?>

<?php include('baseBody.php'); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Search results</h1>

    <div class="row placeholders">
    <?php
    # Handle the search request:
    include('handle_search_term.php');

    $searchTerm = strtolower($searchTerm['searchTerm']); # Convert to lowercase

    $filtersForm = include('filterForm.php');

    echo($filtersForm);

    $query_result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice
                                FROM items i
                                WHERE LOWER(i.title) LIKE '%$searchTerm%'
                                    OR LOWER(i.description) LIKE '%$searchTerm%'
                                GROUP BY i.itemID
                                ORDER BY i.itemViewCount DESC");

    $count_result = $conn->query("SELECT COUNT(itemID) FROM (SELECT itemID
                          FROM items i
                          WHERE LOWER(i.title) LIKE '%$searchTerm%'
                              OR LOWER(i.description) LIKE '%$searchTerm%'
                          GROUP BY i.itemID
                          ORDER BY i.itemViewCount DESC) AS count");

    $temp = $count_result -> fetch();
    $number_of_results = $temp['COUNT(itemID)'];

    # Iterate through search results:
    for($itemCount = 0; $itemCount < $number_of_results; $itemCount++) {
        $result_table = $query_result->fetch(); # Fetch the query result into an array
        var_dump($result_table); # FOR TESTING

        # Variables:
        $itemID = $result_table['itemID'];
        $title = $result_table['title'];
        $description = $result_table['description'];
        $photo = $result_table['photo'];
        $date = $result_table['endDate'];
        $startPrice = $result_table['startPrice'];

        $bid_query = $conn->query("SELECT bidAmount, bidDate FROM bids WHERE itemID = $itemID ORDER BY bidAmount LIMIT 1");

        $bids_on_item = $bid_query -> fetch();
        var_dump($bids_on_item); # FOR TESTING

        # Variables:
        $currentPrice = $bids_on_item['bidAmount'];
        $lastBid = $bids_on_item['bidDate'];

    }
    ?>
    </div>
</div>

</body>

<?php include('baseFooter.php'); ?>
