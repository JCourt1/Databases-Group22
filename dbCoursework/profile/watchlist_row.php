<?php

$tableRow = '
<tr scope="row">

        <td>
            '.$row["title"].'
        </td>

        <td>
            '.$category["categoryName"].'
        </td>

        <td>
            '.$row["endDate"].'
        </td>

        <td>
            <a href="'.$siteroot.'browse/auctionRooms.php?itemID='.$row['itemID'].'">View in auction room</a>
        </td>

        <td>
            <a href="'.$siteroot.'dashboard/removeWatchlistItemMaster.php?itemID='.$row['itemID'].'">Remove Item</a>
        </td>

</tr>
';

echo $tableRow;
?>
