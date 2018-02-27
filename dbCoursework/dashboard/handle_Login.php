<?php






try {
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                    "team22@ibe-database",
                    "ILoveCS17");
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$password = mysqli_real_escape_string($conn, $_POST['password']);
$username = $_POST['username'];


$query = "SELECT userID, username FROM User " .
 "WHERE username = '$username' AND " .
 "password = SHA('$password')";

$data = mysqli_query($conn, $query);
if (mysqli_num_rows($data) == 1) {
 $row = mysqli_fetch_array($data);
 setcookie('userID', $row['userID']);
 setcookie('username', $row['username']);
 $indexURL = 'http://' . $_SERVER['HTTP_HOST'] .
 dirname($_SERVER['PHP_SELF']) . '/dashboard.php';
 header('Location: ' . $indexURL);
} else {
 echo 'Invalid username or password, try again';
    $indexURL = 'http://' . $_SERVER['HTTP_HOST'] .
     dirname($_SERVER['PHP_SELF']) . '/dashboard.php';
     header('Location: ' . $indexURL);
}











?>

