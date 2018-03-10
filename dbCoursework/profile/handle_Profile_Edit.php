
<html>
<?php include('../dashboard/baseHead.php'); ?>

<body>
    <?php include('../dashboard/baseHeader.php'); ?>
    <?php include('../dashboard/sideMenu.php'); ?>

</body>

<?php include('../dashboard/baseFooter.php'); ?>

</html>




<?php 
$siteroot = '/Databases-Group22/dbCoursework/'; 
//establish the connection
try {
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
                    "team22@ibe-database",
                    "ILoveCS17");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

//store the variables that come from the form
$firstName=$_POST['firstName'];
$lastName=$_POST['lastName'];
$phone=$_POST['phone'];
$company=$_POST['company'];
$picture=$_POST['picture'];
$email=$_POST['email'];
$street=$_POST['street'];
$buildingNumber=$_POST['buildingNumber'];
$city=$_POST['city'];
$county=$_POST['county'];
$postCode=$_POST['postCode'];
$username=$_POST['username'];
$psw_confirm=$_POST['psw_confirm'];

if(!ctype_alpha ($firstName) &&  !$firstName=='' || strpos($firstName, ';')  ){
    $regError = "The first name provided is not in the right form. Please try again.";
}elseif(!ctype_alpha ($firstName) &&  !$firstName=='' || strpos($firstName, ';')  ){
    $regError = "The last name provided is not in the right form. Please try again.";
}elseif(!isValidUKNumber($phone) || strpos($phone, ';') &&  !$phone=='' ){
    $regError = "The phone number is not in the right form. Please try again.";
}elseif(ctype_alpha(str_replace(' ', '', $company)) === false  || strpos($company, ';') &&  !$company=='' ){
    $regError = "The company name is not in the right form. Please try again";
}elseif(filter_var($picture, FILTER_VALIDATE_URL) || strpos($picture, ';') &&  !$company=='' ){
    $regError = "The url provided for the picture is not valid. Please try again.";
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, ';')  ){
    $regError = "The email provided for the picture is not valid. Please try again.";
}elseif(ctype_alpha(str_replace(' ', '', $street)) === false || strpos($street, ';')  ){
    $regError = "The street provided for the picture is not valid. Please try again.";
}elseif( !is_int($buildingNumber) || strpos($buildingNumber, ';')  ){
    $regError = "The building number provided for the picture is not valid. Please try again.";
}


function isValidUKNumber($input){
$pattern = "/^(\0\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/";
$match = preg_match($pattern,$input);
return $match;
}


/*
//validation check
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $regError = "Invalid email format. Please try again";
}elseif(!empty($password) ) 
{
    if (strlen($password) <= '8') {
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
} */
//if no error occured
if(isset($regError)){
echo "<script type= 'text/javascript'>alert('$regError');</script>";
//navigate to the main page
echo     '<script type="text/javascript">  window.location = "profile_details.php"   </script>';
}
else{
    //update the database
    $sql = "INSERT INTO users ( username, password,email)
    VALUES ('".$username."','".$password."','".$email."' )";
    //make an sql query and take the user ID from the DB
    if ($conn->query($sql))
    {
        //print the relevant message regarding the outcome of the insertion
        echo "<script type= 'text/javascript'>alert('User details updated Successfully. You will be redirected to the home page.');</script>";
    }
    else
    {
        echo "<script type= 'text/javascript'>alert('An error occured while updating user details.');</script>";
    }
    //navigate to the main page
    echo   '<script type="text/javascript">  window.location = "../dashboard/index.php"   </script>';
}
?>




