<?php $siteroot = '/Databases-Group22/dbCoursework/';?>


<?php include "../dashboard/baseHead.php";?>


<body>

<?php include "../dashboard/baseHeader.php";?>
<?php include "../dashboard/sideMenu.php";?>


<div id="fullscreen_bg" class="fullscreen_bg"/>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 class="text-center"> Adding new Item</h3>

                    <form class="form form-signup" name="mainForm" method="post" onsubmit="return validateForm()" action='newItemConfirmationPage.php' role="form">
                        <!-- ITEM TITLE -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span>
                                </span>
                                <input required type="text" class="form-control" name="itemTitle" id="itemTitle" placeholder="Title" />
                            </div>
                        </div>
                        <!-- ITEM DESCRIPTION -->
                        <div class="form-group">

                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                <input required type="Text" class="form-control" name="itemDescription" id="itemDescription" placeholder="Description" />
                            </div>
                        </div>

                        <!-- Starting Price -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-gbp"></span></span>
                                <input required type="Text" class="form-control" name="startingPrice" id="startingPrice" placeholder="Starting Price" />
                            </div>
                        </div>
                        <!-- Reserve Price -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-gbp"></span></span>
                                <input required type="Text" class="form-control" name="reservePrice" id="reservePrice" placeholder="Reserve Price"  />
                            </div>
                        </div>
                        <!-- Photo -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-picture"></span></span>
                                <input required type="Text" class="form-control" name="photoLink" id="photoLink" placeholder="Photo" />
                            </div>
                        </div>
                        <!-- Condition -->
                        <div class="form-group">
                                <label for="Condition">Condition</label>

                            <select class="form-control" name="Condition" id="Condition">
                                <option value="New">New</option>
                                <option value="Used - Like New">Used - Like New</option>
                                <option value="Used">Used</option>
                            </select>
                        </div>
                        <!-- PARENT CATEGORY -->
                        <div class="form-group">
                            <label for="category">Category:</label>
                            <select class="form-control" name="parentCat2" id="parentCat2">
                                <?php
                                $res = $conn->query("SELECT DISTINCT parentCategory FROM categories ORDER BY categoryID ASC");
                                while ($data = $res->fetch()) {
                                ?>
                                <option value="<?php echo $data['parentCategory']; ?>"><?php echo $data['parentCategory']; ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <!-- CHILD CATEGORY -->
                            <label for="subcategory">Subcategory:</label>
                            <select class="form-control" name="subCat2" id="subCat2">


                            </select>
                        </div>
                        <!-- Auction End Date -->
                        <div class="form-group">
                        <label for="category">Auction End Date</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <input required type="date" id="expDate" name="expDate" class="form-control" placeholder="Auction End Date" />
                            </div>
                        </div>
                </div>
                        <button type="submit" class="btn btn-sm btn-primary btn-block" role="button"> Add Item</button>
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
$(document).ready(function(){

    $('#parentCat2').on("change",function () {
        var parentCategory = $(this).find('option:selected').val();
        $.ajax({
            url: "<?php echo $siteroot; ?>dashboard/subCategorySearch.php",
            type: "POST",
            data: "parentCategory="+parentCategory,
            success: function (response) {
                console.log(response);
                console.log(parentCategory);
                $("#subCat2").html(response);
            },
        });
    });

});
    //form validation
    function validateForm()
    {
    var itemTitle=document.forms["mainForm"]["itemTitle"].value;
    var itemDescription=document.forms["mainForm"]["itemDescription"].value;
    var startingPrice=document.forms["mainForm"]["startingPrice"].value;
    var reservePrice=document.forms["mainForm"]["reservePrice"].value;
    var photoLink=document.forms["mainForm"]["photoLink"].value;
    var subCat2=document.forms["mainForm"]["subCat2"].value;
    var expDate=document.forms["mainForm"]["expDate"].value;

        if ( !isAlphaNumeric(itemTitle) )
        {
            alert("The title field is not in the proper form");
            return false; //this tells the php if to proceed or not
        }
        else if (!isAlphaNumeric(itemDescription))
        {
            alert("The description field is not in the proper form");
            return false;
        }
        else if (subCat2=="")
        {
            alert("Please choose the subcategory");
            return false;
        }
        else if (!isNumeric(startingPrice))
        {
            alert("The starting price field is not a number");
            return false;
        }
        else if (!isNumeric(reservePrice))
        {
            alert("The reserve price field is not a number");
            return false;
        }
        else if (!is_url(photoLink))
        {
            alert("The url provided is not correct");
            return false;
        }
        else if (parseFloat(reservePrice)<parseFloat(startingPrice))
        {
            alert("Reserve price cannot be lower than starting price.");
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
            !((code>=32 && code<= 34)||(code>=39 && code<= 47) ||(code==63) )) // .,!/()?"space+
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




</script>
