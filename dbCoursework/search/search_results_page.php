<?php
    include 'baseHead.php';
    include 'baseHeader.php';

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





    include 'baseFooter.php';
 ?>
