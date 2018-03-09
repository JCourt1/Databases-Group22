
<html>
<?php include('../dashboard/baseHead.php'); ?>

<body>
    <?php include('../dashboard/baseHeader.php'); ?>
    <?php include('../dashboard/sideMenu.php'); ?>

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

$userID=$_SESSION['user_ID'];

$res=$conn->query("SELECT * from users WHERE userID = $userID");
$data=$res->fetch();

?>


<div class="container col-md-offset-2" >
<h1>Edit Profile</h1>
<hr>
    <div class="row" >

      
      <!-- edit form column -->
      <div class="col-md-9 col-md-offset-2 personal-info">
        <h3>Personal info</h3>
        
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <label class="col-lg-3 control-label">First name:</label>
            <div class="col-lg-8">
              <input class="form-control" name="firstName" value="<?php if(isset($data['firstName'])){echo $data['firstName'];};  ?>" placeholder="Please enter your first name" type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Last name:</label>
            <div class="col-lg-8">
              <input class="form-control" name="LastName" value="<?php if(isset($data['lastName'])){echo $data['lastName'];};?>" placeholder="Please enter your last name" type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Phone number:</label>
            <div class="col-lg-8">
              <input class="form-control" name="phone" value="<?php if(isset($data['phoneNumber'])){echo $data['phoneNumber'];};?>" placeholder="Please enter your phone number" type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Company:</label>
            <div class="col-lg-8">
              <input class="form-control" name="company" value="<?php if(isset($data['companyName'])){echo $data['companyName'];};?>" placeholder="Please enter your company name"  type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Profile Picture:</label>
            <div class="col-lg-8">
              <input class="form-control" name="picture" value="<?php if(isset($data['profilePic'])){echo $data['profilePic'];};?>"  placeholder="Please enter your profile picture link"  type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input class="form-control" name="email" value="<?php echo $data['email'];  ?>" type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Street:</label>
            <div class="col-lg-8">
              <input class="form-control" name="street" value="<?php if(isset($data['streetName'])){echo $data['streetName'];};?>"  placeholder="Please enter your address" type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Building Number:</label>
            <div class="col-lg-8">
              <input class="form-control" name="buildingNumber" value="<?php if(isset($data['buildingNumber'])){echo $data['buildingNumber'];};?>"  placeholder="Please enter your building number" type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">City:</label>
            <div class="col-lg-8">
              <input class="form-control" name="city" value="<?php if(isset($data['cityName'])){echo $data['cityName'];};?>" type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Country:</label>
            <div class="col-lg-8">
              <input class="form-control" name="country" value="<?php if(isset($data['countryName'])){echo $data['countryName'];};?>" type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Post code:</label>
            <div class="col-lg-8">
              <input class="form-control" name="postCode" value="<?php if(isset($data['postCode'])){echo $data['postCode'];};?>" type="text">
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-md-3 control-label">Username:</label>
            <div class="col-md-8">
              <input class="form-control" name="username" value="<?php echo $data['username'];  ?>" type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Password:</label>
            <div class="col-md-8">
              <input class="form-control" name="psw" placeholder="Enter your new password" type="password">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Confirm password:</label>
            <div class="col-md-8">
              <input class="form-control" name="psw-confirm" placeholder="Confirm your new password"  type="password">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input class="btn btn-primary" value="Save Changes" type="button">
              <span></span>
              <input class="btn btn-default" value="Cancel" type="reset">
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
<hr>

</body>

<?php include('../dashboard/baseFooter.php'); ?>

</html>





