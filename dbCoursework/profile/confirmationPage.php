<?php $siteroot = '/Databases-Group22/dbCoursework/'; ?>
<html>
<?php include('../dashboard/baseHead.php'); ?>

<body>

    <?php include('../dashboard/baseHeader.php'); ?>

    <?php include('../dashboard/sideMenu.php'); ?>


    <div id="fullscreen_bg" class="fullscreen_bg"/>
    <div class="container">
        <div class="row">
            <?php
                if (empty($_POST['itemTitle'])){
                    echo 'item title is not filled';
                }
            var_dump($_POST) ?>
        </div>
    </div>
    </div>


    </div>    

</body>

<?php include('../dashboard/baseFooter.php'); ?>


</html>
