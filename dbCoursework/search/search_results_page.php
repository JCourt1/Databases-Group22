
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

    //include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/sideMenu.php";

    // ITEM SORTING OPTIONS:
    if (isset($_GET['sort'])){
        $sort = $_GET['sort'];
        $sql_sort = "";
        if ($sort == 1){
            $sql_sort = "ORDER BY i.endDate DESC";
        } else if ($sort == 2){
            $sql_sort = "ORDER BY bidAmount ASC";
        } else if ($sort == 3){
            $sql_sort = "ORDER BY bidAmount DESC";
        } else {
            // Default sort
            $sql_sort = "ORDER BY i.endDate ASC";
        }
    } else {
        $_GET['sort'] = 0; // default
        $sort = $_GET['sort'];
        $sql_sort = "ORDER BY i.endDate ASC";
    }
    print("Sort option chosen is ".$sort.". ");


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
        //$sort = $_GET['sort'];

        // Set the min price if there is one, otherwise set it = to 0.
        if (empty($minPrice)) {
            print("Minimum price was NOT chosen. ");
            $minPrice = 0;
        } else{
            print("Minimum price is £".$minPrice.". ");
        }

        // Same with the max price
        if (empty($maxPrice)){
            print("Maximum price was NOT chosen. ");
            $maxPrice = 10000000000;
        } else {
            print("Maximum price is £".$maxPrice.". ");
        }

        // THE FIRST PART OF THE SQL QUERY:
        $querySelect = "SELECT *
                        FROM items i
                        INNER JOIN (
                            SELECT b.itemID, b.bidAmount, b.bidDate
                            FROM bids b
                            INNER JOIN (
                                SELECT itemID, MAX(bidAmount) bidAmount
                                FROM bids
                                GROUP BY itemID
                            ) c ON b.itemID = c.itemID AND b.bidAmount = c.bidAmount
                        ) d ON i.itemID = d.itemID
                        WHERE (i.title LIKE '%".$searchTerm."%' OR i.description LIKE '%".$searchTerm."%')
                        AND (d.bidAmount BETWEEN ".$minPrice."  AND ".$maxPrice.") ";
        // IF THE PARENT CATEGORY WAS CHOSEN BUT NOT THE SUBCATEGORY
        $queryParentCategory = "AND i.itemID IN (SELECT i.itemID FROM items i, categories c
                                    WHERE i.categoryID = c.categoryID
                                    AND c.parentCategory = '".$parentCategory."') ";
        // ITEM CONDITION STATEMENT:
        $queryItemCondition = "AND i.itemCondition = '".$condition."' ";
        // SUB CATEGORY STATEMENT:
        $querySubCategory = "AND i.categoryID = ".$subCategory." ";

        // CASE: subcategory was picked.
        if (!$subCategory == 0){
            print("Subcategory was chosen. ");

            // CASE: item condition was picked:
            if (!$condition == 0){
                print("Item condition was chosen. ");
                $sql_query = $querySelect.$queryItemCondition.$querySubCategory.$sql_sort;

                print("SQL Query is: ".$sql_query." ");
                $statement = $conn->prepare($sql_query);

            } else {
                print("Item condition was NOT chosen. ");
                // CASE: item condition NOT picked
                $sql_query = $querySelect.$querySubCategory.$sql_sort;

                print("SQL Query is: ".$sql_query." ");
                $statement = $conn->prepare($sql_query);

            }

        } else {
            print("Subcategory was NOT chosen. ");

            // Parent Category WAS chosen
            if (!$parentCategory == 0){
                print("But parent category WAS chosen. ");

                // Check if condition was chosen:
                if (!$condition == 0){
                    print("Item condition was chosen. ");
                    $sql_query = $querySelect.$queryParentCategory.$queryItemCondition.$sql_sort;

                    print("SQL Query is: ".$sql_query." ");
                    $statement = $conn->prepare($sql_query);
                } else {
                    print("Item condition was NOT chosen. ");
                    // No condition was chosen -->
                    $sql_query = $querySelect.$queryParentCategory.$sql_sort;
                    $statement = $conn->prepare($sql_query);
                    print("SQL Query is: ".$sql_query." ");

                }

            } // Parent Category WAS NOT chosen
            else {
                print("Parent Category ALSO NOT chosen. ");

                // Check if condition was chosen:
                if (!$condition == 0){
                    $sql_query = $querySelect.$queryItemCondition.$sql_sort;
                    $statement = $conn->prepare($sql_query);
                    print("SQL Query is: ".$sql_query." ");

                } else {
                    print("Item condition was NOT chosen. ");
                    // No condition was chosen -->
                    $sql_query = $querySelect.$sql_sort;
                    $statement = $conn->prepare($sql_query);
                    print("SQL Query is: ".$sql_query." ");

                }

            }


        }

        $statement->execute();
        $res = $statement->fetchAll();
        $url = 'search_result_page.php?searchTerm='.$searchTerm.'&parentCategory='.$parentCategory.'&subCategory='.$subCategory.'&condition='.$condition;



    } else if (isset($_GET['searchBarSubmit'])) { // Search was made using the search bar only
        $searchTerm = $_GET['searchTerm']; // get the search term
        print("Searching for '".$searchTerm."'.");

        $sql_query =  "SELECT *
                        FROM items i
                        INNER JOIN (
                            SELECT b.itemID, b.bidAmount, b.bidDate
                            FROM bids b
                            INNER JOIN (
                                SELECT itemID, MAX(bidAmount) bidAmount
                                FROM bids
                                GROUP BY itemID
                            ) c ON b.itemID = c.itemID AND b.bidAmount = c.bidAmount
                        ) d ON i.itemID = d.itemID
                        WHERE (i.title LIKE '%".$searchTerm."%' OR i.description LIKE '%".$searchTerm."%')
                        ORDER BY i.endDate ASC;".$sql_sort;
        $statement = $conn->prepare($sql_query);
        $statement->bindValue(':searchTerm', '%'.$searchTerm.'%');

        $statement->execute();
        $res = $statement->fetchAll();
        $url = 'search_result_page.php?searchTerm='.$searchTerm;

    } else {
        print("Searching for everything!");
        // No search was made -->
        $sql_query = "SELECT *
                        FROM items i
                        INNER JOIN (
                            SELECT b.itemID, b.bidAmount, b.bidDate
                            FROM bids b
                            INNER JOIN (
                                SELECT itemID, MAX(bidAmount) bidAmount
                                FROM bids
                                GROUP BY itemID
                            ) c ON b.itemID = c.itemID AND b.bidAmount = c.bidAmount
                        ) d ON i.itemID = d.itemID
                        ORDER BY i.endDate ASC;".$sql_sort;
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

 <h1 class="page-header">Search Results:</h1>



 <div class="row placeholders">
     <form class="navbar-form" method='get' name='sortBy'>
         <div class="form-group">
             <label for="sort">Sort by:</label>
             <select id="sortDropDown" name="sortDropDown" class="form-control">
                 <option value="0">Items ending sooner</option>
                 <option value="1">Items ending later</option>
                 <option value="2">Price (Low to High)</option>
                 <option value="3">Price (High to Low)</option>
             </select>
         </div>
     </form>


     <div name="searchResults" id="searchResults">

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

             $current_date =  new DateTime();

             $bid_end_date =  new DateTime($searchResult['endDate']);
             $interval = $current_date->diff($bid_end_date);
             $elapsed = $interval->format('%y y %m m %a d %h h %i min %s s');

             // MODAL:
             include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/commonElements/itemModal.php";

             $rownumber += 1;

         }
     }
     # end php ?>
 </div>


 </div>
</body>



 <?php include $_SERVER['DOCUMENT_ROOT']."$siteroot/dashboard/baseFooter.php";?>
