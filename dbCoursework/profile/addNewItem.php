<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>

<html>

<?php include("../dashboard/baseHead.php"); ?>


<body>

<?php include("../dashboard/baseHeader.php"); ?>
<?php include("../dashboard/baseBody.php"); ?>


<div id="fullscreen_bg" class="fullscreen_bg"/>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 class="text-center"> Adding new Item</h3>

                    <form class="form form-signup" method="post" action='<?php echo $siteroot; ?>profile/confirmationPage.php' role="form"> 
                        <!-- ITEM TITLE -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span>
                                </span>
                                <input type="text" class="form-control" name="itemTitle" id="itemTitle" placeholder="Title" />
                            </div>
                        </div>
                        <!-- ITEM DESCRIPTION -->
                        <div class="form-group">
                    
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                <input type="Text" class="form-control" name="itemDescription" id="itemDescription" placeholder="Description" />
                            </div>
                        </div>
                    
                        <!-- Starting Price -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-gbp"></span></span>
                                <input type="Text" class="form-control" name="startingPrice" id="startingPrice" placeholder="Starting Price" />
                            </div>
                        </div>
                        <!-- Reserved Price -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-gbp"></span></span>
                                <input type="Text" class="form-control" name="reservedPrice" id="reservedPrice" placeholder="Reserved Price" />
                            </div>
                        </div>                        
                        <!-- Photo -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-picture"></span></span>
                                <input type="Text" class="form-control" name="photoLink" id="photoLink" placeholder="Photo" />
                            </div>
                        </div>                        
                        <!-- Condition -->
                        <div class="form-group">
                                <label for="Condition">Condition</label>
                        
                            <select class="form-control" name="Condition" id="Condition">
                                <option>New</option>
                                <option>Used</option>
                                <option>Used - Like New</option>
                            </select>
                        </div>                       
                        <!-- PARENT CATEGORY -->
                        <div class="form-group">
                            <label for="category">Category:</label>
                            <select class="form-control" name="parentCat2" id="parentCat2">
                            <option value="0" selected>Any</option>
                            <?php
                            $res = $conn->query("SELECT DISTINCT parentCategory FROM categories ORDER BY categoryID ASC");
                            while($data=$res->fetch()) {
                            ?>
                                <option value="<?php echo $data['parentCategory'];?>"><?php echo $data['parentCategory'];?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <!-- CHILD CATEGORY -->
                            <label for="subcategory">Subcategory:</label>
                            <!--  -->
                            <select class="form-control" name="subCat2" id="subCat2">


                            </select>
                        </div>
                        <!-- Auction End Date -->
                        <div class="form-group">
                        <label for="category">Auction End Date</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <input type="date" id="expDate" name="expDate" class="form-control" placeholder="Auction End Date" />
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

<?php include("../dashboard/baseFooter.php"); ?>

</html>



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

</script>

