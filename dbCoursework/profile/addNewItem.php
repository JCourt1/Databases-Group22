<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>

<html>

<?php include("../dashboard/baseHead.php"); ?>


    <body>

        <?php include("../dashboard/baseHeader.php"); ?>
        <?php include("../dashboard/baseBody.php"); ?>


<div id="fullscreen_bg" class="fullscreen_bg"/>
<form class="form-signin">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 class="text-center">
                        Adding new Item</h3>
                    <form class="form form-signup" role="form">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span>
                            </span>
                            <input type="text" class="form-control" placeholder="Name" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            <input type="Text" class="form-control" placeholder="Amount" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                            <input type="Text" class="form-control" placeholder="Bill" />
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select class="form-control" name="parentCat2" id="parentCat2">
                    <option value="0" selected>Any</option>
                        <?php
                        $res = $conn->query("SELECT DISTINCT parentCategory FROM categories ORDER BY categoryID ASC");
                        while($data=$res->fetch()) {
                        ?>
                    <option value="<?php echo $data['parentCategory'];?>"><?php echo $data['parentCategory'];?></option>
                    <?php
                        }
                    ?>
                    </select>

                    <label for="subcategory">Subcategory:</label>
                    <select class="form-control" name="subCat2" id="subCat2">


                    </select>
                </div>
                <div class="form-group">
                   <label for="contain">Author</label>
                   <input class="form-control" type="text" />
                </div>
                <div class="form-group">
                    <label for="contain">Contains the words</label>
                    <input class="form-control" type="text" />
                </div>                    
                
                    
                </div>
                <a href="http://www.jquery2dotnet.com" class="btn btn-sm btn-primary btn-block" role="button">
                    Add Item</a> </form>
            </div>
        </div>
    </div>
</div>
</form>


</div> 

    </body>

        <?php include("../dashboard/baseFooter.php"); ?>

</html>



<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>-->
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

</script>
