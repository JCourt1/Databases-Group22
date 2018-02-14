<?php include('baseHead.php'); ?>

<body>


  <?php# include('baseHeader.php'); ?>

  <?php #include('baseBody.php'); ?>

  <?php
  $searchTerm = "car"; # PLACEHOLDER SEARCH TERM UNTIL SEARCHBAR WORKS
  $searchTerm = strtolower($searchTerm); # Convert to lowercase

  echo($searchTerm); # For testing

  $query_result = $conn->query("SELECT itemID, title, description, photo, endDate, startPrice FROM items i WHERE i.title LIKE '%$searchTerm%' OR i.description LIKE '%$searchTerm%' GROUP BY i.itemID ORDER BY i.itemViewCount DESC LIMIT 100");
  $result_table = $query_result->fetch(); # Fetch the query result into an array

  var_dump($result_table); # For testing
  ?>

</body>

<?php include('baseFooter.php'); ?>
