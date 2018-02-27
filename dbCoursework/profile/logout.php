<?php

$siteroot = '/Databases-Group22/dbCoursework';




session_start();
session_destroy();

$index = $siteroot . '/dashboard/index.php';
 header('Location: ' . $index);

?>