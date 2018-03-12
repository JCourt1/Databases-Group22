<?php $siteroot = '/Databases-Group22/dbCoursework/';?>


<?php include "../dashboard/baseHead.php";?>


<body>

<?php include "../dashboard/baseHeader.php";?>
<?php include "../dashboard/sideMenu.php";?>


<div id="fullscreen_bg" class="fullscreen_bg"/>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 class="text-center"> Contact the Administrator</h3>

                    <form class="form form-signup" name="mainForm" method="post" onsubmit="return validateForm()" action='sendMessageAdmin.php' role="form">
                        <!-- ITEM TITLE -->
                        <div class="form-group" >
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span>
                                </span>
                                <input required type="text" class="form-control" name="Subject" id="Subject" placeholder="Subject of message" />
                            </div>
                        </div>
                        <!-- ITEM DESCRIPTION -->
                        <div class="form-group">

                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                <textarea  placeholder="Message" class="form-control"  required type="Text"   name="Message" id="Message" rows="20"></textarea>
                            </div>
                        </div>

                </div>
                        <button type="submit" class="btn btn-sm btn-primary btn-block" role="button">Send Message</button>
                    </form>
            </div>
        </div>
    </div>
</div>


</div>

</body>

<?php include "../dashboard/baseFooter.php";?>




<!-- This script dynamically updates the subcatecory field when the parent category has been filled. It sends the data to the file:subCategorySearch.php -->
<script type="text/javascript">

    //form validation
    function validateForm()
    {
    var subject=document.forms["mainForm"]["Subject"].value;
    var message=document.forms["mainForm"]["Message"].value;
  

        if ( !isAlphaNumeric(subject) )
        {
            alert("The subject field is not in the proper form");
            return false; //this tells the php if to proceed or not
        }
        else if (!isAlphaNumeric(message))
        {
            alert("The message field is not in the proper form");
            return false;
        }
       
    }

    // function to check if the input is a sentence
    function isAlphaNumeric(str) {
        var code, i, len;

        for (i = 0, len = str.length; i < len; i++)
        {
        code = str.charCodeAt(i);
        if (!(code > 47 && code < 58) && // numeric (0-9)
            !(code > 64 && code < 91) && // upper alpha (A-Z)
            !(code > 96 && code < 123)&& // lower alpha (a-z)
            !((code>=32 && code<= 34)||(code>=40 && code<= 46) ||(code==63)|| (code==156) || (code==36) )) // .,!()?"space+£$
        {
        return false;
        }
        }
        return true;
    }





</script>
