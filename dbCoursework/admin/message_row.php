<?php

$tableRow = '
<tr scope="row">

        <td>
            '.$row["username"].'
        </td>

        <td>
            '.$row["email"].'
        </td>

        <td>
            '.$companyName.'
        </td>

        <td>
            '.$row["messagedate"].'
        </td>
        <td height="100" width="100" >
        '.$row["message"].'
        </td>

        <td>
        <form class="form-horizontal" method="post" action="handle_message_resolution.php" accept-charset="UTF-8">
        <button type="submit" name="delete" value="'.$row["communicationID"].'" ><span class="glyphicon glyphicon-check"></span></button>

        </form>
        </td>


</tr>
';

echo $tableRow;
?>
