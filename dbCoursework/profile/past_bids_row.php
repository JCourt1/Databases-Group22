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
            '.$auctionWon.'
        </td>

        <td>
            '.$finalPrice.'
        </td>

        <td>
            '.$row["endDate"].'
        </td>

        <td>
            '.$sellerEmail.'
        </td>

</tr>
';

echo $tableRow;
?>
