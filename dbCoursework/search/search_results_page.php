<?php
    $siteroot = '/Databases-Group22/dbCoursework/';
    include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHead.php";

?>

<body>

<?php
    if(isset($_SESSION['user_ID'])){
        $buyerID = $_SESSION['user_ID'];
    } else {
        $buyerID = NULL;
    }

    include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseHeader.php";

    include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/sideMenu.php";

    // SORTING:
    $sql_sort = "ORDER BY i.endDate ASC";

    // Check if advanced search has been made:
    if (isset($_GET['filteredSubmit'])){
        $searchTerm = $_GET['searchTerm'];
        $parentCategory = $_GET['parentCat'];
        // Check if subcategory has been submitted:
        if (isset($_GET['subCat'])){
            $subCategory = $_GET['subCat'];
        } else{
            $subCategory = 0; // Default "Any" subcategory is numbered 0
        }
        $condition = $_GET['itemCondition'];
        $minPrice = $_GET['minPrice'];
        $maxPrice = $_GET['maxPrice'];

        // Set the min price if there is one, otherwise set it = to 0.
        if (empty($minPrice)) {
            $minPrice = 0;
        }

        // Same with the max price
        if (empty($maxPrice)){
            $maxPrice = 10000000000;
        }

        // THE FIRST PART OF THE SQL QUERY:
        $querySelect = "SELECT i.*, d.bidAmount, d.bidDate
                        FROM items i
                        LEFT JOIN (
                            SELECT b.itemID, b.bidAmount, b.bidDate
                            FROM bids b
                            INNER JOIN (
                                SELECT itemID, MAX(bidAmount) bidAmount
                                FROM bids
                                GROUP BY itemID
                            ) c ON b.itemID = c.itemID AND b.bidAmount = c.bidAmount
                        ) d ON i.itemID = d.itemID
                        WHERE (i.title LIKE :searchTerm OR i.description LIKE :searchTerm)
                        AND i.endDate > NOW()
                        AND i.itemRemoved = 0
                        AND ((d.bidAmount BETWEEN :minPrice AND :maxPrice) OR ((i.startPrice BETWEEN :minPrice AND :maxPrice) AND d.bidAmount IS NULL)) ";
        // IF THE PARENT CATEGORY WAS CHOSEN BUT NOT THE SUBCATEGORY
        $queryParentCategory = "AND i.itemID IN (SELECT i.itemID FROM items i, categories c
                                    WHERE i.categoryID = c.categoryID
                                    AND c.parentCategory = :parentCategory) ";
        // ITEM CONDITION STATEMENT:
        $queryItemCondition = "AND i.itemCondition = :condition ";
        // SUB CATEGORY STATEMENT:
        $querySubCategory = "AND i.categoryID = :subCategory ";


        // CASE: subcategory was picked.
        if (!$subCategory == 0){

            // CASE: item condition was picked:
            if (!$condition == 0){
                $sql_query = $querySelect.$queryItemCondition.$querySubCategory.$sql_sort;

                $statement = $conn->prepare($sql_query);
                $statement->bindValue(':searchTerm', '%'.$searchTerm.'%');
                $statement->bindParam(':minPrice', $minPrice);
                $statement->bindParam(':maxPrice', $maxPrice);
                $statement->bindParam(':subCategory', $subCategory);
                $statement->bindParam(':condition', $condition);

            } else {
                // CASE: item condition NOT picked
                $sql_query = $querySelect.$querySubCategory.$sql_sort;

                $statement = $conn->prepare($sql_query);
                $statement->bindValue(':searchTerm', '%'.$searchTerm.'%');
                $statement->bindParam(':minPrice', $minPrice);
                $statement->bindParam(':maxPrice', $maxPrice);
                $statement->bindParam(':subCategory', $subCategory);

            }
        } else {

            // Parent Category WAS chosen
            if (!$parentCategory == 0){

                // Check if condition was chosen:
                if (!$condition == 0){
                    $sql_query = $querySelect.$queryParentCategory.$queryItemCondition.$sql_sort;

                    $statement = $conn->prepare($sql_query);
                    $statement->bindValue(':searchTerm', '%'.$searchTerm.'%');
                    $statement->bindParam(':minPrice', $minPrice);
                    $statement->bindParam(':maxPrice', $maxPrice);
                    $statement->bindParam(':parentCategory', $parentCategory);
                    $statement->bindParam(':condition', $condition);

                } else {
                    // No condition was chosen -->
                    $sql_query = $querySelect.$queryParentCategory.$sql_sort;
                    $statement = $conn->prepare($sql_query);
                    $statement->bindValue(':searchTerm', '%'.$searchTerm.'%');
                    $statement->bindParam(':minPrice', $minPrice);
                    $statement->bindParam(':maxPrice', $maxPrice);
                    $statement->bindParam(':parentCategory', $parentCategory);

                }
            } // Parent Category WAS NOT chosen
            else {
                // Check if condition was chosen:
                if (!$condition == 0){
                    $sql_query = $querySelect.$queryItemCondition.$sql_sort;
                    $statement = $conn->prepare($sql_query);
                    $statement->bindValue(':searchTerm', '%'.$searchTerm.'%');
                    $statement->bindParam(':minPrice', $minPrice);
                    $statement->bindParam(':maxPrice', $maxPrice);
                    $statement->bindParam(':condition', $condition);

                } else {
                    // No condition was chosen -->
                    $sql_query = $querySelect.$sql_sort;
                    $statement = $conn->prepare($sql_query);
                    $statement->bindValue(':searchTerm', '%'.$searchTerm.'%');
                    $statement->bindParam(':minPrice', $minPrice);
                    $statement->bindParam(':maxPrice', $maxPrice);

                }
            }
        }

        // Execute the query:
        $statement->execute();
        $res = $statement->fetchAll();
        $url = 'search_result_page.php?searchTerm='.$searchTerm.'&parentCategory='.$parentCategory.'&subCategory='.$subCategory.'&condition='.$condition;

    } else if (isset($_GET['searchBarSubmit'])) { // Search was made using the search bar only
        $searchTerm = $_GET['searchTerm']; // get the search term
        $sql_query =  "SELECT i.*, d.bidAmount, d.bidDate
                        FROM items i
                        LEFT JOIN (
                            SELECT b.itemID, b.bidAmount, b.bidDate
                            FROM bids b
                            INNER JOIN (
                                SELECT itemID, MAX(bidAmount) bidAmount
                                FROM bids
                                GROUP BY itemID
                            ) c ON b.itemID = c.itemID AND b.bidAmount = c.bidAmount
                        ) d ON i.itemID = d.itemID
                        WHERE (i.title LIKE :searchTerm OR i.description LIKE :searchTerm)
                        AND i.itemRemoved = 0
                        AND i.endDate > NOW() ".$sql_sort;
        $statement = $conn->prepare($sql_query);
        $statement->bindValue(':searchTerm', '%'.$searchTerm.'%');

        $statement->execute();
        $res = $statement->fetchAll();
        $url = 'search_result_page.php?searchTerm='.$searchTerm;

    } else {
        // No search was made -->
        $sql_query = "SELECT i.*, d.bidAmount, d.bidDate
                                FROM items i
                                LEFT JOIN (
                                    SELECT b.itemID, b.bidAmount, b.bidDate
                                    FROM bids b
                                    INNER JOIN (
                                        SELECT itemID, MAX(bidAmount) bidAmount
                                        FROM bids
                                        GROUP BY itemID
                                    ) c ON b.itemID = c.itemID AND b.bidAmount = c.bidAmount
                                ) d ON i.itemID = d.itemID
                                WHERE i.itemRemoved = 0
                                AND i.endDate > NOW()
                                ".$sql_sort;

        $statement = $conn->prepare($sql_query);
        $statement->execute();
        $res = $statement->fetchAll();
        $url = 'search_result_page.php';
    }

 ?>

 <!-- This script dynamically sorts the search results. It sends the data to the file:sortResults.php -->
 <script type="text/javascript">
 $(document).ready(function(){
     var res=<?php echo json_encode($res); ?>;
     console.log("Res: " + res);

     $('#sortDropDown').on("change",function () {
         var sort = $(this).find('option:selected').val();
         console.log(sort);

         //var res = "";
         $.ajax({
             url: "<?php echo $siteroot; ?>search/sortResults.php",
             type: "POST",
             data: {"sort": sort, "res": res},
             success: function (response) {
                 console.log("Response: " + response);
                 console.log("Sort: " + sort);
                 $("#searchResults").html(response);
             },
         });
     });

 });

 </script>
 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

     <h1 class="page-header">Search Results:</h1>

     <div class="container-fluid panel panel-success" style="padding-top: 30px; border: 3px solid transparent; border-color: #d6e9c6;">

         <?php
         
         if(!empty($res)){ ?>

         <form class="navbar-form" method='get' name='sortBy'>
             <div class="form-group">
                 <label for="sort">Sort by:</label>
                 <select id="sortDropDown" name="sortDropDown" class="form-control">
                     <option value="0">Items ending sooner</option>
                     <option value="1">Items ending later</option>
                     <option value="2">Price (Low to High)</option>
                     <option value="3">Price (High to Low)</option>
                     <option value="4">Popularity</option>
                 </select>
             </div>
         </form>

         <div class="row placeholders" name="searchResults" id="searchResults">

             <div class="row placeholders">

             <?php # begin php
             $rownumber = 0;

             foreach ($res as $searchResult) {
                 if (new DateTime($searchResult['endDate']) > new DateTime()) {

                     $itemID = $searchResult['itemID'];
                     $title = $searchResult['title'];
                     $photo = $searchResult['photo'];
                     $description = $searchResult['description'];
                     $startPrice = $searchResult['startPrice'];
                     $currentPrice= $searchResult['bidAmount'];
                     $lastBid = $searchResult['bidDate'];
                     $condition = $searchResult['itemCondition'];

                     $current_date =  new DateTime();

                     $bid_end_date =  new DateTime($searchResult['endDate']);
                     $interval = $current_date->diff($bid_end_date);
                     $elapsed = $interval->format('%y y %m m %a d %h h %i min %s s');

                     if($startPrice >= $currentPrice){
                         $currentPrice = $startPrice;
                     }

                     // MODAL:
                     include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/commonElements/itemModal.php";

                     $rownumber += 1;
                 }
             }
             # end php ?>
             </div>
        </div>
    <?php } else { echo "<p style='font-style: italic; font-size: 24px; color: grey;'>No results found that matched your criteria.</p>";} ?>

    </div>
</div>
</body>

 <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>
