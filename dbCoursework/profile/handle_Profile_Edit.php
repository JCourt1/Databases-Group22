
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
    $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_dbv3;charset=utf8",
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
$psw=$_POST['psw'];
$psw_confirm=$_POST['psw-confirm'];



//validate all the input fields
if(!ctype_alpha ($firstName) &&  !$firstName=='' || strpos($firstName, ';')  ){
    $regError = "The first name provided is not in the right form. Please try again.";
}elseif(!ctype_alpha ($firstName) &&  !$firstName=='' || strpos($firstName, ';')  ){
    $regError = "The last name provided is not in the right form. Please try again.";
}elseif( (!isValidUKNumber($phone) || strpos($phone, ';')) &&  !$phone=="" ){
    $regError = "The phone number is not in the right form. Please try again.";
}elseif((ctype_alpha(str_replace(' ', '', $company)) === false  || strpos($company, ';')) &&  !$company=='' ){
    $regError = "The company name is not in the right form. Please try again";
}elseif(!(filter_var($picture, FILTER_VALIDATE_URL) || strpos($picture, ';')) &&  !$picture=='' ){
    $regError = "The url provided is not valid. Please try again.";
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, ';') ){
    $regError = "The email provided is not valid. Please try again.";
}elseif((ctype_alpha(str_replace(' ', '', $street)) === false || strpos($street, ';')) &&  !$street=='' ){
    $regError = "The street provided is not valid. Please try again.";
}elseif(( !preg_match('/^\d+[A-Za-z]?$/', $buildingNumber) || strpos($buildingNumber, ';')) &&  !$buildingNumber=='' ){
    $regError = "The building number provided is not valid. Please try again.";
}elseif((ctype_alpha(str_replace(' ', '', $city)) === false || strpos($city, ';')) &&  !$city==''){
    $regError = "The city provided is not valid. Please try again.";
}elseif((ctype_alpha(str_replace(' ', '', $county)) === false || strpos($county, ';')) &&  !$county==''){
    $regError = "The county provided is not valid. Please try again.";
}elseif(!is_string($username)){
    $regError = "The username is not in the right form. Please try again.";
}elseif($psw!= $psw_confirm ){
    $regError = "The 2 password fields do not match";
}elseif((isPasswordValid($psw)!=null || strpos($psw, ';')) && ($psw!='') ){
    $regError = isPasswordValid($psw);
    if ($regError==null){
        $regError="password contains invalid characters";
    }
}

//function to check if the UK number is valid
function isValidUKNumber($input){
$pattern = "/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/";
$match = preg_match($pattern,$input);
return $match;
}
//function to validate the password
function isPasswordValid($password){
    $regError=null;
    if (strlen($password) <= '8') {
        $regError = "Your Password Must Contain At Least 8 Characters! Please try again.";
    }
    elseif(!is_string($password)){
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
    elseif(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password) === 0){
        $regError ="Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit";
    }elseif(strpos($password, ';') !== false){
        $regError = "The password contains invalid characters";
    }
    return $regError;
}


//if an error is occured
if(isset($regError)){
echo "<script type= 'text/javascript'>alert('$regError');</script>";
//navigate to the main page
echo     '<script type="text/javascript">  window.location = "profile_details.php"   </script>';
}
else{
    //update the database
    $query = $conn->prepare("UPDATE users
                            SET username = :username, email = :email
                            WHERE userID = :user_ID");
    $query2 = $conn->prepare("UPDATE clients
                            SET firstName=:firstName, lastName=:lastName, phoneNumber=:phone, companyName=:company, profilePic=:picture,
                            streetName=:street, buildingNumber=:buildingNumber, cityName=:city, countyName=:county, postCode=:postCode
                            WHERE userID= :user_ID;");

     $query2->bindValue(':firstName',$firstName);
     $query2->bindValue(':lastName',$lastName);
     $query2->bindValue(':phone',$phone);
     $query2->bindValue(':company',$company);
     $query2->bindValue(':picture',$picture);
     $query->bindValue(':email',$email);
     $query2->bindValue(':street',$street);
     $query2->bindValue(':buildingNumber',$buildingNumber);
     $query2->bindValue(':city',$city);
     $query2->bindValue(':county',$county);
     $query2->bindValue(':postCode',$postCode);
     $query->bindValue(':username',$username);
     $query->bindValue(':user_ID',$_SESSION['user_ID']);
     $query2->bindValue(':user_ID',$_SESSION['user_ID']);


     //if the user typed a new password, update the database with the new password
     if (isset($psw) && !$psw=='' ){
        $psw= sha1($psw);
        $query3 = $conn->prepare("UPDATE users SET password=:psw WHERE userID=:user_id " );
        $query3->bindValue(':psw',$psw);
        $query3->bindValue(':user_id',$_SESSION['user_ID']);
        $query3->execute();

     }


    try {
        $query->execute();
        $query2->execute();
        //print the relevant message regarding the outcome of the insertion
        echo "<script type= 'text/javascript'>alert('User details updated Successfully. You will be redirected to the home page.');</script>";
    } catch (Exception $e) {
        echo $e->getMessage();
        echo "<script type= 'text/javascript'>alert('An error occured while updating user details.');</script>";
    }
    //navigate to the main page
    echo   '<script type="text/javascript">  window.location = "../dashboard/dashboard.php"   </script>';
}
?>
