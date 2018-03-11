
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
//take the user id from the session variable
$userID=$_SESSION['user_ID'];
//make the query and get all the user's details. Store them in the data variable
$res=$conn->query("SELECT * from users WHERE userID = $userID");
$data=$res->fetch();

?>


<div class="container col-md-offset-2" >
<h1>Edit Profile</h1>
<hr>
    <div class="row" >

      <div class="col-md-9 col-md-offset-2 personal-info">
        <h3>Personal info</h3>
        <!-- start of the  form  -->
        <form class="form-horizontal" method='POST' name="mainForm" onsubmit="return validateForm()" action="handle_Profile_Edit.php" role="form">
          <!-- First name field  -->
          <div class="form-group">
            <label class="col-lg-3 control-label">First name:</label>
            <div class="col-lg-6">
              <input class="form-control" name="firstName" value="<?php if(isset($data['firstName'])){echo $data['firstName'];};  ?>" placeholder="Please enter your first name" type="text">
            </div>
          </div>
          <!-- Last name field  -->
          <div class="form-group">
            <label class="col-lg-3 control-label">Last name:</label>
            <div class="col-lg-6">
              <input class="form-control" name="lastName" value="<?php if(isset($data['lastName'])){echo $data['lastName'];};?>" placeholder="Please enter your last name" type="text">
            </div>
          </div>
          <!-- Phone number field  -->
          <div class="form-group">
            <label class="col-lg-3 control-label">Phone number:</label>
            <div class="col-lg-6">
              <input class="form-control" name="phone" value="<?php if(isset($data['phoneNumber'])){echo $data['phoneNumber'];};?>" placeholder="Please enter your phone number" type="text">
            </div>
          </div>
          <!-- Company name field  -->
          <div class="form-group">
            <label class="col-lg-3 control-label">Company:</label>
            <div class="col-lg-6">
              <input class="form-control" name="company" value="<?php if(isset($data['companyName'])){echo $data['companyName'];};?>" placeholder="Please enter your company name"  type="text">
            </div>
          </div>
          <!-- Profile picture field  -->
          <div class="form-group">
            <label class="col-lg-3 control-label">Profile Picture:</label>
            <div class="col-lg-6">
              <input class="form-control" name="picture" value="<?php if(isset($data['profilePic'])){echo $data['profilePic'];};?>"  placeholder="Please enter your profile picture link"  type="text">
            </div>
          </div>
          <!-- email field  -->
          <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-6">
              <input class="form-control" name="email" value="<?php echo $data['email'];  ?>" type="text">
            </div>
          </div>
          <!-- Building number field  -->
          <div class="form-group">
            <label class="col-lg-3 control-label">Building Number:</label>
            <div class="col-lg-6">
              <input class="form-control" name="buildingNumber" value="<?php if(isset($data['buildingNumber'])){echo $data['buildingNumber'];};?>"  placeholder="Please enter your building number" type="numb">
            </div>
          </div>
          <!-- Street field  -->
          <div class="form-group">
            <label class="col-lg-3 control-label">Street:</label>
            <div class="col-lg-6">
              <input class="form-control" name="street" value="<?php if(isset($data['streetName'])){echo $data['streetName'];};?>"  placeholder="Please enter your address" type="text">
            </div>
          </div>
          <!-- city field  -->
          <div class="form-group">
            <label class="col-lg-3 control-label">City:</label>
            <div class="col-lg-6">
              <input class="form-control" name="city" value="<?php if(isset($data['cityName'])){echo $data['cityName'];};?>" type="text">
            </div>
          </div>
          <!-- Country field  -->
          <div class="form-group">
            <label class="col-lg-3 control-label">County:</label>
            <div class="col-lg-6">
              <input class="form-control" name="county" value="<?php if(isset($data['countyName'])){echo $data['countyName'];};?>" type="text">
            </div>
          </div>
          <!-- Post code field  -->
          <div class="form-group">
            <label class="col-lg-3 control-label">Post code:</label>
            <div class="col-lg-6">
              <input class="form-control" name="postCode" value="<?php if(isset($data['postCode'])){echo $data['postCode'];};?>" type="text">
            </div>
          </div>
          <!-- username field  -->
          <div class="form-group">
            <label class="col-md-3 control-label">Username:</label>
            <div class="col-md-6">
              <input class="form-control" name="username" value="<?php echo $data['username'];  ?>" type="text">
            </div>
          </div>
          <!-- Password field  -->
          <div class="form-group">
            <label class="col-md-3 control-label">Password:</label>
            <div class="col-md-6">
              <input class="form-control" name="psw" placeholder="Enter your new password" type="password">
            </div>
          </div>
          <!-- password confirmation field  -->
          <div class="form-group">
            <label class="col-md-3 control-label">Confirm password:</label>
            <div class="col-md-6">
              <input class="form-control" name="psw-confirm" placeholder="Confirm your new password"  type="password">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input class="btn btn-primary" value="Save Changes" type="submit">
              <span></span>
              <input class="btn btn-default" formaction='../dashboard/dashboard.php' value="Cancel" type="submit">
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
<hr>

</body>

<?php include('../dashboard/baseFooter.php'); ?>

<script type="text/javascript">

    //form validation
    function validateForm()
    {
    var firstName=document.forms["mainForm"]["firstName"].value;
    var lastName=document.forms["mainForm"]["lastName"].value;
    var phone=document.forms["mainForm"]["phone"].value;
    var company=document.forms["mainForm"]["company"].value;
    var picture=document.forms["mainForm"]["picture"].value;
    var email=document.forms["mainForm"]["email"].value;
    var street=document.forms["mainForm"]["street"].value;
    var buildingNumber=document.forms["mainForm"]["buildingNumber"].value;
    var city=document.forms["mainForm"]["city"].value;
    var county=document.forms["mainForm"]["county"].value;
    var postCode=document.forms["mainForm"]["postCode"].value;
    var username=document.forms["mainForm"]["username"].value;
    var psw=document.forms["mainForm"]["psw"].value;
    var psw_confirm=document.forms["mainForm"]["psw-confirm"].value;

        if ( !/^[a-zA-Z]*$/g.test(firstName) )
        {
            alert("The first name must only have letters.");
            return false; //this tells the php if to proceed or not
        }
        else if ( !/^[a-zA-Z]*$/g.test(lastName))
        {
            alert("The last name must only have letters.");
            return false;
        }
        else if (!(phone.length==11 && (/^\d+$/).test(phone)) && !(phone===null|| phone===''))
        {
            console.log(phone);
            console.log("pasdasdhone");
            alert("The phone number is not in the right form.");
            return false;
        }
        else if (!letterNumberSpace(company))
        {
            alert("The company name is not in the right form.");
            return false;
        }
        else if (!is_url(picture)&& !(picture==''))
        {
            alert("The url for the profile picture is not in the right form.");
            return false;
        }
        else if (!validateEmail(email))
        {
            alert("The the e-mail you provided in not in the right form.");
            return false;
        }
        else if (!letterNumberSpace(street))
        {
            alert("The the street you provided in not in the right form.");
            return false;
        }
        else if (!/^\d+[A-Z]?$/.test(buildingNumber) && !buildingNumber=='')
        {
            alert("The building number is not in the right form.");
            return false;
        }
        else if ( !/^[a-zA-Z\s]*$/g.test(city))// letters only with spaces
        {
            alert("The field for city is not in the right form");
            return false;
        }
        else if ( !/^[a-zA-Z\s]*$/g.test(county)) // letters only with spaces
        {
            alert("The field for county is not in the right form");
            return false;
        }
        else if ( !is_valid_postcode(postCode) && !postCode=='')
        {
            alert("The postcode is not valid");
            return false;
        }
        else if ( !isAlphaNumeric(username))
        {
            alert("The username is not in the right form");
            return false;
        }
        else if ( (psw!=psw_confirm) )
        {
            alert("Passowords do not match. Please try again.");
            return false;
        }
    }


    //function to check is the number is integer
    function isInt(value) {
      return !isNaN(value) && parseInt(Number(value)) == value &&  !isNaN(parseInt(value, 10));
    }

    // function to check if the input is a sentence
    function isAlphaNumeric(str) {
        var code, i, len;

        for (i = 0, len = str.length; i < len; i++)
        {
        code = str.charCodeAt(i);
        if (!(code > 47 && code < 58) && // numeric (0-9)
            !(code > 64 && code < 91) && // upper alpha (A-Z)
            !(code > 96 && code < 123)&&
            !((code==32)||(code==46)||(code==45)||(code==63)))
        { // lower alpha (a-z)
        return false;
        }
        }
        return true;
    };
    // function to check the company name
    function letterNumberSpace(str) {
    var code, i, len;

    for (i = 0, len = str.length; i < len; i++)
    {
    code = str.charCodeAt(i);
    if (!(code > 47 && code < 58) && // numeric (0-9)
        !(code > 64 && code < 91) && // upper alpha (A-Z)
        !(code > 96 && code < 123)&& // lower alpha (a-z)
        !(code==32))
    { 
    return false;
    }
    }
    return true;
    };
    //function to check if the input is numeric
    function isNumeric(n)
        {
        return !isNaN(parseFloat(n)) && isFinite(n);
        }

    //function to check if the input is in url form
    function is_url(str)
    {
    regexp =  /^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;
            if (regexp.test(str))
            {
            return true;
            }
            else
            {
            return false;
            }
    }
    //email validation
    function validateEmail() {
    var x = document.forms["mainForm"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        return false;
    }
    else{
      return true;
    }
    }
    function is_valid_postcode(postcode) {
    postcode = postcode.replace(/\s/g, "");
    var regex = /[A-Z]{1,2}[0-9]{1,2} ?[0-9][A-Z]{2}/i;
    return regex.test(postcode);
    }

</script>
