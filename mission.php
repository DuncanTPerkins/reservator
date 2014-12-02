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

                    <a class="navbar-brand" id="navbar-brand" href="php/gohome.php">
                        <div class="hidden-sm hidden-xs" id="navbar-brand-padding">&nbsp;</div>UTK Delta Zeta Meal Reservation</a>
                </div>
                <ul class="nav navbar-nav">
                                    <li class="active"><a href="mission.php">Mission Statement</a></li>
                                    <li class><a href="lab7.php">Resume</a></li>

                </ul>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <?php
                            echo"<a href='#'>Welcome, " . $_SESSION['name'] . "</a>"; ?>
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
            <div class="container" style="margin: 30px;">
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


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>

</html>
