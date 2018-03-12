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
            £'.$currentBid["bidAmount"].'
        </td>

        <td>
            £'.$row["reservePrice"].'
        </td>

        <td>
            '.$row["endDate"].'
        </td>

        <td>
            <a href="'.$siteroot.'browse/auctionRooms.php?itemID='.$row['itemID'].'">View in auction room</a>
        </td>

        <td>
            '.$row["itemViewCount"].'
        </td>

</tr>
';

echo $tableRow;
?>
