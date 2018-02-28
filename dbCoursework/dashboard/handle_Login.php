
<?php

session_start();// Starting Session

try {
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                    "team22@ibe-database",
                    "ILoveCS17");
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


$password = sha1($_POST['password']);


$query = $conn->prepare("SELECT userID, username FROM users WHERE username = ? AND password = ?");


$query->execute([$_POST['username'], $password]);



if ($query->rowCount()) {


 $row = $query->fetch();

 $temp = $row['username'];
 $_SESSION['login_user'] = $temp;

    if (!isset($temp)) {
            throw new Exception('Username is not set. Should not happen.');
    }

 $_SESSION['loggedin'] = true;


 $dashboard = 'http://' . $_SERVER['HTTP_HOST'] .
 dirname($_SERVER['PHP_SELF']) . '/dashboard.php';
 header('Location: ' . $dashboard);
} else {
 echo 'Invalid username or password, try again';
    $failed = 'http://' . $_SERVER['HTTP_HOST'] .
     dirname($_SERVER['PHP_SELF']) . '/test.php';



     header('Location: ' . $failed);
}


?>

