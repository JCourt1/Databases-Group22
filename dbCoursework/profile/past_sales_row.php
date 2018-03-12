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
            '.$itemSold.'
        </td>

        <td>
            '.$buyerEmail.'
        </td>

        <td>
            £'.$endPrice.'
        </td>

        <td>
            '.$row["endDate"].'
        </td>

        <td>
            '.$feedbackHTML.'
        </td>

</tr>
';

echo $tableRow;
?>
