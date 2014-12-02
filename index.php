<?php session_start();
if(session_is_registered(username)){ header( "location:calendar.php");}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>UTK Delta Zeta Meal Reservations</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="/css/login.css" />
    <link href='http://fonts.googleapis.com/css?family=Chelsea+Market' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!--[if IE]>
        <script src="https://cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <?php if($_SESSION['loggedout'] == 1) {
    session_destroy();
    ?>
    <script type="text/javascript">

         $(document).ready(function() {
        $("#loggedout").modal('show');
         });
</script>

    <?php }
?>

        <?php if($_SESSION['logfail'] == 1) {
    session_destroy();
    ?>
    <script type="text/javascript">

         $(document).ready(function() {
        $("#logfail").modal('show');
         });
</script>

    <?php }
?>
</head>
        <body>
            <div class="container">
                <div class="row vertical-offset-50">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-default" id="main-login-panel">
                            <div class="panel-heading" id="welcome">
                                UTK Delta Zeta Meal Reservation Site
                            </div>
                            <div class="panel-body main-panel">

                                <div class="col-md-6">

                                    <div class="panel panel-default custom-panel">
                                        <div class="panel-heading">
                                            <div class="row-fluid user-row">
                                                <img src="/images/deltazetalogowhitebg.jpg" class="img-responsive"
                                                     id="deltazetalogo" alt="UTK Reservations" />
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form name="login" method="post" action="php/login.php" accept-charset="UTF-8" role="form" class="form-signin">
                                                <fieldset>
                                                    <label class="panel-login">
                                                       <!-- <div class="login_result"></div> -->
                                                    </label>
                                                            <input type="radio" name="radiolog" value="student" >Student
                                                            <input type="radio" name="radiolog" value="staff">Staff
                                                        <input name="username" class="form-control" placeholder="E-mail" id="username"
                                                           type="text">

                                                    <input class="form-control" name="password" placeholder="Password" id="password"
                                                           type="password">
                                                    <div class="checkbox">
                                                    </div>
                                                    <div class="col-md-6 col-s-6 button-container">
                                                    <input class="btn btn-lg btn-success btn-block" name="login" type="submit"
                                                           id="login" value="Log in »">
                                                    </div>
                                                    <div class="col-md-6 col-s-6 button-container">
                                                    <input class="btn btn-lg btn-success btn-block noselect"
                                                           id="register" value="Register »" onclick="window.location = '/register.php';">
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-body custom-panel">
                                            <img src="/images/girls.png" alt="" class="img-responsive img-rounded">
                                            <div class="panel-body">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome to the
                                                meal reservation site for the UTK chapter of Delta Zeta. Login to
                                                the form to begin making reservations!
                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Questions/Comments? E-mail Liz
                                                Buckner at lizbuckner@comcast.net</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
     <!-- Modal -->
<div class="modal fade" id="loggedout" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Goodbye!</h4>
      </div>
      <div class="modal-body">
        You Have Been Logged Out.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="logfail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Invalid!</h4>
      </div>
      <div class="modal-body">
        Invalid Username or Password. Please try again.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>

</html>
