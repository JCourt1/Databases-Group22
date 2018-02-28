<?php



function convertDate($data) {
    preg_match('#([0-9]{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])#', $data, $matches);
    $matches = preg_replace('#([0-9]{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])#', '$3/$2/$1', $matches[0]);

    return $matches;

}


function convertTime($data) {

    preg_match("#(0[0-9]|1[0-1]):([0-5][0-9]):([0-5][0-9])#", $data, $morningMatches);
    preg_match("#(1[2-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])#", $data, $afternoonMatches);

    $morning = preg_replace("#(0[0-9]|1[0-1]):([0-5][0-9]):([0-5][0-9])#", "$1:$2 AM", $morningMatches[0], -1,$count1);
    $afternoon = preg_replace("#(1[2-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])#", "$1:$2 PM", $afternoonMatches[0], -1,$count2);

    if ($count1>0) return $morning;
    else return $afternoon;
}

?>