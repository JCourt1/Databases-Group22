<?php

$conn -> query("UPDATE bids SET needsNotification = 1 WHERE bidID IN 

(SELECT bidID, buyerID, max(bidAmount) as highestBid FROM ibe_db.bids WHERE itemID = $itemID AND highestBid < $bid GROUP BY buyerID;)
");

?>