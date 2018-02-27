
<?php
// Establishing Connection with Server by passing server_name, user_id and password as a parameter

require_once 'config.php';

session_start();// Starting Session

$user_check= $_SESSION['login_user'];


// SQL Query To Fetch Complete Information Of User
$ses_sql= $conn->query("select username from users where username='$user_check'");
$row = $ses_sql->fetch();

$login_session =$row['username'];

if(!isset($login_session)){
$conn = null; // Closing Connection

header('Location: index.php'); // Redirecting To Home Page
}
?>