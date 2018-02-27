<?php echo'

    
                        <button type="btn" id="dropdownMenu1" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">Login <span class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-menu-right mt-1">
                          <li class="p-3">
                                <form class="form" role="form" action ="' . $siteroot . 'dashboard/handle_Login.php" method = "post">
                                    <div class="form-group">
                                        <input id="emailInput" placeholder="Username" name="username" class="form-control form-control-sm" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <input id="passwordInput" placeholder="Password" name="password" class="form-control form-control-sm" type="password" required="">
                                    </div>
                                    <div class="form-group">
                                        <button id="myButton" type="submit" class="btn btn-primary btn-block">Login</button>
                                    </div>
                                    <div class="form-group text-xs-center">
                                        <small><a href="#">Forgot password?</a></small>
                                    </div>
                                </form>
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




