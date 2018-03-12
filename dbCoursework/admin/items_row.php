<?php

$tableRow = '
<tr scope="row">

        <td>
            '.$row["title"].'
        </td>

        <td>
            '.$row["categoryID"].'
        </td>

        <td>
            '.$row["itemCondition"].'
        </td>

        <td>
            '.$row["startPrice"].'
        </td>

        <td>
        '.$row["reservePrice"].'
        </td>

        <td>
        '.$row["endDate"].'
        </td>

        <td>
        '.$row["itemViewCount"].'
        </td>

        <td>
        <a href="'.$siteroot.'browse/auctionRooms.php?itemID='.$row['itemID'].'">Delete item</a>
        </td>
        
</tr>
';

echo $tableRow;
?>
