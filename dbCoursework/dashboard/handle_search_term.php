<?php
    # Checks if the search term is valid:
    function isSearchTermValid(){
        $errorMessage = null;
        if (!isset($_POST['searchTerm']) or trim($_POST['searchTerm']) == '')
          $errorMessage = "You must enter something!";

        if ($errorMessage !== null)
        {
          echo <<<EOM
          <p>Error: $errorMessage</p>
EOM;
          return False;
        }
        return True;
    }

    # Returns the search term as a string
    function getSearchTerm(){
        $search["searchTerm"] = $_POST["searchTerm"];
        return $search;
    }

    # Prints the search term
    function printSearchTerm($search){
        echo "<p>Search query: ${search['searchTerm']}</p>";
    }

    if (isSearchTermValid()){
        $searchTerm = getSearchTerm();
        printSearchTerm($searchTerm);
    }
?>
