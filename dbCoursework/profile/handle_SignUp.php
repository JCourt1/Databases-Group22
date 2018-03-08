
<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>
<?php
//establish the connection
try {
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                    "team22@ibe-database",
                    "ILoveCS17");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //store the variables that come from the form
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['psw'];
    $cpassword = $_POST['psw-repeat'];

}

catch (Exception $e) 
{
    die('Erreur : ' . $e->getMessage());
}

//validation check
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $regError = "Invalid email format. Please try again";

}elseif(!empty($password) )
{
    if (strlen($password) < '8') {
        $regError = "Your Password Must Contain At Least 8 Characters! Please try again.";
    }
    elseif(!is_string($username)){
        $regError = "The username is not in the proper form";
    }
    elseif(!preg_match("#[0-9]+#",$password)) {
        $regError = "Your Password Must Contain At Least 1 Number! Please try again.";
    }
    elseif(!preg_match("#[A-Z]+#",$password)) {
        $regError = "Your Password Must Contain At Least 1 Capital Letter! Please try again.";
    }
    elseif(!preg_match("#[a-z]+#",$password)) {
        $regError = "Your Password Must Contain At Least 1 Lowercase Letter! Please try again.";
    }
    elseif ($password != $cpassword) {
        $regError = "The 2 password fields must match. Please try again";
    }elseif(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password) === 0){
        $regError ="Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit";
    }elseif(strpos($password, ';') !== false){
        $regError = "The password contains invalid characters";
    }
}
// if(isset($regError)){
// echo "<script type= 'text/javascript'>alert('$regError');</script>";
// echo     '<script type="text/javascript">  window.location = "../dashboard/index.php"   </script>';
// }
// else{
    if(true){
    //update the database
    $password = sha1($password);
    $sql = "INSERT INTO users ( username, password,email)
    VALUES ('".$username."','".$password."','".$email."' )";
    //print the relevant message regarding the outcome of the insertion
    if ($conn->query($sql))
    {
        
        $query = $conn->prepare("SELECT userID, username FROM users WHERE username = ? AND password = ?");
        $query->execute([$_POST['username'], $password]);
        $row = $query->fetch();

        $uName = $row['username'];
        $id = $row['userID'];

        $_SESSION['user_ID'] = $id;
        $_SESSION['login_user'] = $uName;

        if (!isset($_SESSION['user_ID'])) {
                throw new Exception('Username is not set. Should not happen.');
        }
        $_SESSION['loggedin'] = true;
        echo "<script type= 'text/javascript'>alert('User created Successfully. You will redirected to the home page.');</script>";
        
        header("Location:".$siteroot."dashboard/dashboard.php");



    }
    else
    {
        echo "<script type= 'text/javascript'>alert('A problem occured. Please try again');</script>";
    }


    // //navigate to the main page
    // echo     '<script type="text/javascript">  window.location = "../dashboard/index.php"   </script>';
    // $conn = null;

}


?>

<html>
<?php include('../dashboard/baseHead.php'); ?>

<body>
    <?php include('../dashboard/baseHeader.php'); ?>
    <?php include('../dashboard/sideMenu.php'); ?>


</body>

<?php include('../dashboard/baseFooter.php'); ?>

</html>

<?php 

?>



