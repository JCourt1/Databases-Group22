<?php echo'

    <ul class="nav navbar-nav navbar-right">
                			<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                			<li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in"></span> Login</a>
                				<div class="dropdown-menu" style="padding: 15px; padding-bottom: 10px;">
                				<form class="form-horizontal"  method="post" action="test.php" accept-charset="UTF-8">
                				  <input id="sp_uname" class="form-control login" type="text" name="sp_uname" placeholder="Username.." />
                				  <input id="sp_pass" class="form-control login" type="password" name="sp_pass" placeholder="Password.."/>
                				  <input class="btn btn-primary" type="submit" name="submit" value="login" />
                				</form>
                				</div>
                			</li>
                </ul>
    
';?>


<script type="text/javascript">
    $(function() {
      // Setup drop down menu
      $('.dropdown-toggle').dropdown();

      // Fix input element click problem
      $('.dropdown input, .dropdown label').click(function(e) {
        e.stopPropagation();
      });
    });

</script>


<script type="text/javascript">
    $(document).ready(function() {
       $("#myButton").click(function() {
           $("#myForm").submit();
       });
    });
</script>




