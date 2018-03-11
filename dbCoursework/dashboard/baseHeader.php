
<?php $siteroot = '/Databases-Group22/dbCoursework/';

require_once $_SERVER['DOCUMENT_ROOT']."$siteroot/config.php";


//try {
//        $conn = new PDO("mysql:host=ibe-database.mysql.database.azure.com;dbname=ibe_db;charset=utf8",
//                        "team22@ibe-database",
//                        "ILoveCS17");
//    }
//    catch (Exception $e) {
//        die('Erreur : ' . $e->getMessage());
//    }




?>




<nav class="navbar navbar-inverse navbar-fixed-top">

<div class="container-fluid">

    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

    </div>

    <div id="navbar" class="navbar-collapse collapse">

        <?php

        //if the user has logged in
        if (isset($_SESSION['login_user'])) { ?>
            <ul class="nav navbar-nav navbar-left">
            <li><a class='lightblueTop' style='color: #95b796;' href="#">Currently logged in as: <?php echo $_SESSION['login_user'];?></a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">

                <?php if ($_SESSION['notificationsCount'] > 0) { ?>

                <?php if ($_SESSION['notificationsBoxRead'] == FALSE) { $_SESSION['notificationsBoxRead'] = TRUE;?>


                    <li class="dropdown notificationsBox">

                    <?php } else { ?>
                        <li class="dropdown readNotificationsBox">
                                        <?php } ?>

                        <a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in"></span> Notifications</a>
                        <div class="dropdown-menu" style="padding: 15px; padding-bottom: 10px;">

                            <?php foreach ($_SESSION['notifications'] as $notification) { ?>
                                <p> <?php echo $notification['message'];?></p>
                            <?php } ?>

                        </div>
                    </li>

                <?php } ?>



            <li><a class='blueTop' style='color: #bbc4cb;' href="<?php echo $siteroot ?>dashboard/dashboard.php">Dashboard</a></li>
            <li><a class='whiteTop' style='color: #b3b7b2;' href="../profile/logout.php">Log out</a></li>
            </ul>
        <!-- else  if the user hasn't yet logged in -->
        <?php } else { ?>

                    <ul class="nav navbar-nav navbar-right">
                        <?php require "../profile/register.php"?>
                        <li>
                            <button class="custom-class" style="border:0px solid black; background-color: transparent;" onclick="document.getElementById('id01').style.display='block'">

                            <a class="btn" href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
                            </button>

                        </li>
                        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in"></span> Login</a>
                            <div class="dropdown-menu" style="padding: 15px; padding-bottom: 10px;">
                            <form class="form-horizontal" method="post" action="../login/handle_Login.php" accept-charset="UTF-8">
                              <input id="sp_uname" class="form-control login" type="text" name="username" placeholder="Username.." />
                              <input id="sp_pass" class="form-control login" type="password" name="password" placeholder="Password.."/>
                              <input class="btn btn-primary" type="submit" name="submit" value="login" />
                            </form>
                            </div>
                        </li>
                    </ul>

        <?php } ?>

        <div class="centeredNav">

        <a class="navbar-brand sitename" a href="<?php echo $siteroot; ?>dashboard/dashboard.php" style="font-weight: bold;">ibé</a>
        <!-- SEARCH BAR -->
        <form class="navbar-form" method='get' action='<?php echo $siteroot; ?>search/search_results_page.php' name='searchBar'>
            <div class="input-group add-on">
                <input class="form-control" placeholder="Search" name="searchTerm" id="searchTerm" type="text">
                <div class="input-group-btn">
                    <button class="btn btn-default" name="searchBarSubmit" type="submit" value="Search for item"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>

            <!-- ADVANCED FILTERS, opens the modal when clicked -->
            <div class="navbar-collapse nav navbar-nav">
                <button type="button" class="btn btn-default"  data-toggle="modal" data-target="#modalSearch" >
                    <i class="glyphicon glyphicon-filter"  data-target="#modalSearch"></i>
                </button>
            </div>

        </form>

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
          <!-- START OF FORM -->
        <form class="" role="form" method="get" action="<?php echo $siteroot?>search/search_results_page.php">
            <!-- SEARCH TERMS -->
            <div class="form-group">
                <label for="searchTerm">Search for:</label>
                <input id="searchTerm" name="searchTerm" placeholder="Name or description" class="form-control">
            </div>
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
                    <option value='0' selected>Any</option>


                </select>
             </div>
             <!-- ITEM CONDITION -->
             <div class="form-group">
                 <label for="condition">Condition:</label>
                 <select id="itemCondition" name="itemCondition" class="form-control">
                     <option value="0" selected>Any</option>
                     <option value="New">New</option>
                     <option value="Used - Like New">Used - Like New</option>
                     <option value="Used">Used</option>
                 </select>
             </div>
             <!-- MIN PRICE -->
             <div class="form-group">
                 <label for="minPrice">Minimum price:</label>
                 <input id="minPrice" name="minPrice" placeholder="" class="form-control">
             </div>
             <!-- MAX PRICE -->
             <div class="form-group">
                 <label for="maxPrice">Maximum price:</label>
                 <input id="maxPrice" name="maxPrice" placeholder="" class="form-control">
             </div>
             <!--<div class="form-group">
                 <label for="sort">Sort by:</label>
                 <select id="sort" name="sort" class="form-control">
                     <option value="0" selected>Items ending sooner</option>
                     <option value="1">Items ending later</option>
                     <option value="2">Price (Low to High)</option>
                     <option value="3">Price (High to Low)</option>
                     <option value="4">Popularity</option>
                 </select>
             </div>-->
             <!-- SEARCH BUTTON -->
             <div class="form-group">
                 <label for="submit"></label>
                 <button id="submit" name="filteredSubmit" value="1" type="hidden" class="btn btn-primary">Search</button>
             </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="liveNotifications">
    <p>Hello</p>
</div>


<section class="section-alert sa1">
<div class="alert-element">
      <div class="icon"><i class="glyphicon glyphicon-console"></i></div>
      <div class="text"><span></span></div>
</div>
</section>

<section class="section-alert sa2">
<div class="alert-element">
      <div class="icon"><i class="glyphicon glyphicon-console"></i></div>
      <div class="text"><span></span></div>
</div>
</section>

<section class="section-alert sa3">
<div class="alert-element">
      <div class="icon"><i class="glyphicon glyphicon-console"></i></div>
      <div class="text"><span></span></div>
</div>
</section>

<section class="section-alert sa4">
<div class="alert-element">
      <div class="icon"><i class="glyphicon glyphicon-console"></i></div>
      <div class="text"><span></span></div>
</div>
</section>


<script>

    $('.liveNotifications').click(function(){
      $('.alert-element').toggleClass('is-active');
    });


</script>



<!-- This script dynamically updates the subcategory field when the parent category has been filled. It sends the data to the file:subCategorySearch.php -->
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
                response = "<option value='0' selected >Any</option>" + response;
                $("#subCat").html(response);
            },
        });
    });

});

</script>




<?php

if (isset($_SESSION['user_ID']) AND !is_null($_SESSION['user_ID'])) {

    $notiScript = '<script>

    $(function () {


       setInterval(function() {
           $.ajax({

               url: "'.$siteroot.'notifications/checkForNotifications.php",
               type: "POST",
               success: function(response) {

                   console.log("No notifications to report.");

                   if (response.length != 0) {

                       var count = 0;

                       $.each(response, function(index, row) {

                           var num = (count + 1) % 4;
                           var classID = ".sa" + num;
                           for (i = num; i < 5; i++) {
                               if (! $(classID).hasClass("is-active")) {

                               } else {
                                   classID = ".sa" + i;
                                   break;
                               }
                           }



                           var t = row.messagedate.split(/[- :]/);
                            var date = t[2] + "/" + t[1] + "/" + t[0];
                            var time = t[3] + ":" + t[4] + ":" + t[5];

                           $(classID).find("span").delay(1000).html("<b>" + time +"</b>:  " + row.message);

                          if (row.isBuyer) {

                          } else {
                              $(classID).find(".icon").css("background", "#a72e77");
                          }

                           $(classID).find(".alert-element").toggleClass("is-active");

                           setTimeout(function(){
                               $(classID).find(".alert-element").removeClass("is-active");
                           },10000);
                            console.log(row.message);

                            count ++;

                        });


                   }


           }, error: function (request, status, error) {
                   alert(request.responseText);
               },

               dataType: "json"});
        }, 5000);
    });

    </script>';

        echo $notiScript;

    } ?>
