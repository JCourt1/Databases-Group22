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
            <form class="form-horizontal" method="post" action="handle_deletion.php" accept-charset="UTF-8">
            <button type="submit" name="delete" value="'.$row["itemID"].'" ><span class="glyphicon glyphicon-trash"></span></button>
                
            </form>
        </td>
        
</tr>
';

echo $tableRow;
?>
