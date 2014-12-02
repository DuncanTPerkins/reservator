<?php session_start() ?>
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

</head>
        <body>
                    <nav class="navbar navbar-default navbar-fixed-top" id="navbar" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">

                    <a class="navbar-brand" id="navbar-brand" href="#">
                        <div class="hidden-sm hidden-xs" id="navbar-brand-padding">&nbsp;</div>UTK Delta Zeta Meal Reservation</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <?php echo"<a href='#'>Welcome, " . $_SESSION['name'] . "</a>"; ?>
                        </li>
                        <li><a id="logout" href="php/logout.php">Log Out<div class="hidden-sm hidden-xs" id="navbar-right-padding">&nbsp;</div></a>
                        </li>

                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
        <!-- Navbar -->
            <div class="container">
                <div class="row vertical-offset-50">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-default" id="main-login-panel">
                            <div class="panel-heading" id="welcome">
                                Mission Statement
                            </div>
                            <div class="panel-body main-panel">

                                <div class="col-md-6">
                                    <h3>This site's purpose is to deliver a hassle-free and stylish experience that a student can use to reserve their meals that is as simple and as easy to understand as possible. </h3>

                                </div>
                                                                <div class="col-md-6">

                                        <img src="images/duncanco.png" alt="" style="width:400px">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
     <!-- Modal -->
<div class="modal fade" id="loggedout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<div class="modal fade" id="logfail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Invalid!</h4>
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
