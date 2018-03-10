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
            £'.$row["bidAmount"].'
        </td>

        <td>
            '.$row["bidDate"].'
        </td>

        <td>
            '.$bidWinning.'
        </td>

        <td>
            <a href="'.$siteroot.'browse/auctionRooms.php?itemID='.$row['itemID'].'">View in auction room</a>
        </td>

        <td>
            <a href="'.$siteroot.'dashboard/removeBidMaster.php?bidID='.$row['bidID'].'">Remove Bid</a>
        </td>

</tr>
';

echo $tableRow;
?>
