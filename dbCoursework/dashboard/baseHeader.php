
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
        <form class="navbar-form" method='post' action='search_result_page.php' name='searchBar'>
            <div class="input-group add-on">
                <input class="form-control" placeholder="Search" name="searchTerm" id="searchTerm" type="text">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit" value="Search for item"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>

        </form>


        <div>
            <button type="button" class="btn btn-default"  data-toggle="modal" data-target="#modalSearch" >
                <i class="glyphicon glyphicon-filter"  data-target="#modalSearch"></i>
            </button>
        </div>


    </div>


</div>





</nav>

<div class="modal fade" id="modalSearch" tabindex="-1" role="dialog" aria-labelledby="modalSearch" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalSearchLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="form-control-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="form-control-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>
