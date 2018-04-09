
<?php $siteroot = '/dbCoursework';

require_once $_SERVER['DOCUMENT_ROOT']."$siteroot/config.php";

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

            <li><a class='blueTop' style='color: #bbc4cb;' href="listed_items.php">Home page</a></li>
            <li><a class='whiteTop' style='color: #b3b7b2;' href="../profile/logout.php">Log out</a>
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


    </div>




</div>





</nav>






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
                           $(classID).toggleClass("highzindex");

                           setTimeout(function(){
                               $(classID).find(".alert-element").removeClass("is-active");
                               $(classID).removeClass("highzindex");
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
