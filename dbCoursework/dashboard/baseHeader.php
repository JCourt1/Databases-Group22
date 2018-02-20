
<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>

<nav class="navbar navbar-inverse navbar-fixed-top">

<div class="container-fluid">

    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand sitename" a href="<?php echo $siteroot; ?>dashboard/index.php" >Ebay</a>
    </div>

    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
        </ul>

        <!-- SEARCH BAR -->
        <form class="navbar-form" method='post' action='<?php echo $siteroot; ?>/dashboard/search_result_page.php' name='searchBar'>
            <div class="input-group add-on">
                <input class="form-control" placeholder="Search" name="searchTerm" id="searchTerm" type="text">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit" value="Search for item"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>

        </form>

        <!-- ADVANCED FILTERS, opens the modal when clicked -->
        <div>
            <button type="button" class="btn btn-default"  data-toggle="modal" data-target="#modalSearch" >
                <i class="glyphicon glyphicon-filter"  data-target="#modalSearch"></i>
            </button>
        </div>


    </div>


</div>





</nav>

<!-- ADVANCED FILTERS MODAL -->
<div class="modal fade" id="modalSearch" tabindex="-1" role="dialog" aria-labelledby="modalSearch" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalSearchLabel">Advanced Search</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="form-group">
                <!-- PARENT CATEGORY -->
                <label for="category">Category:</label>
                <select class="form-control" name="parentCat" id="parentCat">
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
                <!-- SUB CATEGORY -->
                <label for="subcategory">Subcategory:</label>
                <select class="form-control" name="subCat" id="subCat">


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
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Search</button>
      </div>
    </div>
  </div>
</div>


<!-- Ajax handles the selection of the subcategory -->
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>-->
<script type="text/javascript">
$(document).ready(function(){

    $('#parentCat').on("change",function () {
        var parentCategory = $(this).find('option:selected').val();
        $.ajax({
            url: "<?php echo $siteroot; ?>dashboard/subCategorySearch.php",
            type: "POST",
            data: "parentCategory="+parentCategory,
            success: function (response) {
                console.log(response);
                console.log(parentCategory);
                $("#subCat").html(response);
            },
        });
    });

});

</script>
