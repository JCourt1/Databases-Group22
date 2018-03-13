


<div id="id01" class="modal">
 <!-- <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span> -->
  <form class="modal-content" name="mainForm" method="POST" onsubmit="return validateForm()" action="../profile/handle_SignUp.php">
    <div class="container">
      <h1>Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>
      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required>

      <label for="usename"><b>Username</b></label>
      <input type="text" placeholder="Username" name="username" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>

      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

      <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
      </label>

      <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" class="signupbtn">Sign Up</button>
      </div>
    </div>
  </form>
</div>

<?php 
$sql = "SELECT username FROM users";

$statement = $conn->prepare($sql);
$statement->execute();
$usernames = $statement->fetchAll();
// while ($results=$statement->fetch())
// {
// 	$usernames[] = $results;
// }
?>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

    //form validation
    function validateForm()
    {
    var email=document.forms["mainForm"]["email"].value;
    var username=document.forms["mainForm"]["username"].value;
    var psw=document.forms["mainForm"]["psw"].value;
    var psw_repeat=document.forms["mainForm"]["psw-repeat"].value;
    var usernames = <?php echo json_encode($usernames); ?>;

        for (i=0; i<usernames.length;i++)
        {
            if(usernames[i]['username']==username)
            {
                alert("This username is already in use. Please choose another one.");
                return false;
            }
        }

        if ( !validateEmail(email) )
        {
            alert("The provided e-mail is not valid");
            return false; //this tells the php if to proceed or not
        }
        else if (!isAlphaNumeric(username))
        {
            alert("The username must have only letters and numbers without spaces.");
            return false;
        }
        else if (psw!=psw_repeat)
        {
            alert("Passowords do not match. Please try again.");
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


    // function to check if the input is alphanumeric
    function isAlphaNumeric(str) {
        var code, i, len;

        for (i = 0, len = str.length; i < len; i++)
        {
        code = str.charCodeAt(i);
        if (!(code > 47 && code < 58) && // numeric (0-9)
            !(code > 64 && code < 91) && // upper alpha (A-Z)
            !(code > 96 && code < 123))
        { // lower alpha (a-z)
        return false;
        }
        }
        return true;
    };
</script>