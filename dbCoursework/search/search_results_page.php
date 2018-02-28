<?php
    $siteroot = '/Databases-Group22/dbCoursework/';
    include '../dashboard/baseHead.php';
    include '../dashboard/baseHeader.php';

    // Check if search has been made:
    if (isset($_GET['filteredSubmit'])){
        $searchTerm = $_GET['searchTerm'];
        $parentCategory = $_GET['parentCat'];
        $subCategory = $_GET['subCat'];
        $condition = $GET['itemCondition'];
        $minPrice = $GET['minPrice'];
        $maxPrice = $GET['maxPrice'];



        /**
        INCLUDE PARAMETERS FOR SORTING THE SEARCH RESULTS LATER.
        ALSO NEED TO HANDLE PARENT CATEGORY LATER AND PRICES
        **/

        // Check if parent category was picked:
        if ($subCategory != 0){

            // Check if condition was chosen:
            if ($condition != 0){
                $sql_query = 'SELECT *
                                FROM items i
                                WHERE i.categoryID = :subCategory AND i.itemCondition = :condition
                                AND (i.title LIKE :searchTerm OR i.description LIKE :searchTerm)
                                ORDER BY i.endDate ASC';
                $statement = $conn->prepare($sql_query);
                $statement->bindValue(':subCategory', $subCategory);
                $statement->bindValue(':condition', $condition);
                $statement->bindValue(':searchTerm', '%'.$searchTerm.'%');


            } else {
                // No condition was chosen -->
                $sql_query = 'SELECT *
                                FROM items i
                                WHERE i.categoryID = :subCategory
                                AND (i.title LIKE :searchTerm OR i.description LIKE :searchTerm)
                                ORDER BY i.endDate ASC';
                $statement = $conn->prepare($sql_query);
                $statement->bindValue(':subCategory', $subCategory);
                $statement->bindValue(':searchTerm', '%'.$searchTerm.'%');
            }

        } else {
            // No parent category was picked -->

            // Check if condition was chosen:
            if ($condition != 0){
                $sql_query = 'SELECT *
                                FROM items i
                                WHERE i.itemCondition = :condition
                                AND (i.title LIKE :searchTerm OR i.description LIKE :searchTerm)
                                ORDER BY i.endDate ASC';
                $statement = $conn->prepare($sql_query);
                $statement->bindValue(':condition', $condition);
                $statement->bindValue(':searchTerm', '%'.$searchTerm.'%');
            } else {
                // No condition was chosen -->
                $sql_query = 'SELECT *
                                FROM items i
                                WHERE (i.title LIKE :searchTerm OR i.description LIKE :searchTerm)
                                ORDER BY i.endDate ASC';
                $statement = $conn->prepare($sql_query);
                $statement->bindValue(':searchTerm', '%'.$searchTerm.'%');
            }
        }

        $statement->execute();
        $res = $statement->fetchAll();
        $url = 'search_result_page.php?searchTerm='.$searchTerm.'subCategory='.$subCategory.'condition='.$condition;

    } else {
        // No search was made -->
        $sql_query = 'SELECT *
                        FROM items i
                        ORDER BY i.endDate ASC';
        $statement = $conn->prepare($sql_query);
        $statement->execute();
        $res = $statement->fetchAll();
        $url = 'search_result_page.php';
    }

 ?>

 <h1 class="page-header">Search Results:</h1>

 <div class="row placeholders">

     <?php # begin php
     $rownumber = 0;

     foreach ($res as $searchResult) {
         if (new DateTime($searchResult['endDate']) > new DateTime()) {

             # Get the bid information:
             $bidInfo = $conn->query("SELECT bidAmount, bidDate FROM bids WHERE itemID = " . $searchResult['itemID'] . " ORDER BY bidAmount LIMIT 1");

             $bid = $bidInfo->fetch();

             $chaine = '<div class="col-xs-6 col-sm-3 placeholder">

                 <!-- Modal -->
                 <div id="myModal' . $rownumber . '" class="modal fade" role="dialog">
                     <div class="modal-dialog">

                         <!-- Modal content-->
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 <h2 class="modal-title">' . $searchResult['title'] . '</h4>
                             </div>
                             <div class="modal-body">
                                 <img src="' . $searchResult['photo'] . '" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail"
                                 <p>' . $searchResult['description'] . '</p>
                                 <h3 id="countdown"> PLACEHOLDER </h3>
                                 <h3 > Start Price: ' . $searchResult['startPrice'] . ' </h2>
                                 <h3> Current Price: ' . $bid['bidAmount'] . ' </h2>
                                 <h3> Last Bid: ' . $bid['bidDate'] . ' </h2>
                             </div>
                             <div class="modal-footer">
                                 <div class="form-group pull-left">
                                     <input type="text" name="bid" id="inputBid" >
                                 </div>
                                 <button type="button" class="btn btn-default pull-left" action="addBid()" >Bid</button>
                                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                             </div>
                         </div>

                     </div>
                 </div>

                 <img src="' . $searchResult['photo'] . '" width="200" height="200" class="img" alt="Generic placeholder thumbnail" data-toggle="modal" data-target="#myModal' . $rownumber . '">
                 <a  data-toggle="modal" data-target="#myModal' . $rownumber . '">
                     <h4>' . $searchResult['title'] . '
                     </h4>
                     <span class="text-muted">  ' . $searchResult['description'] . ' </span>
                 </a>
             </div>';

             echo $chaine;
             $rownumber += 1;

         }
     }
     # end php ?>


 </div>

 <?php include '../dashboard/baseFooter.php'; ?>
