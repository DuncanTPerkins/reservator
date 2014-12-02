<?php session_start();
/*
            Name:       Duncan Perkins
            Course:     CSCI 1710-003
            Assignment: Personal Project
            Due Date: 12/2/2014
            Purpose:    The purpose of this web page is to serve as a reservation system for the kitchen of a sorority
        */
?>
<!DOCTYPE html>
<html lang="en">
<!-- google drive-->

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

    <script type="text/javascript">
    </script>
<?php
if($_SESSION['nouse'] == "go") {
?>
    <script>
 $(document).ready(function () {
                    $("#myModal").modal('show');
          });
        </script>
    <?php
}
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

                        <div class="col-md-12">

                            <div class="panel panel-default custom-panel">
                                <div class="panel-heading">
                                    <h4>Register</h4>
                                </div>
                                <div class="panel-body">
                                    <form name="login" method="post" action="php/register.php" accept-charset="UTF-8" role="form" class="form-signin">
                                        <fieldset>
                                            <label class="panel-login">
                                            </label>
                                            <div class="col-md-6">
                                                <input class="form-control" placeholder="First Name" id="fname" name="fname" type="text">
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" placeholder="Last Name" id="lname" name="lname" type="text">
                                            </div>
                                            <div class="col-md-12">
                                            <input name="phone" class="form-control" placeholder="Phone Number" id="username" type="text">
                                            <input name="email" class="form-control" placeholder="E-mail" id="email" type="text">

                                            <input class="form-control" name="password" placeholder="Password" id="password" type="password">
                                            <input class="form-control" placeholder="Confirm Password" id="password2" type="password">

                                            <div class="col-md-12 col-s-6 button-container">
                                                <input class="btn btn-lg btn-success btn-block" type="submit" id="register" value="Register »">
                                            </div></div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                   Sorry, that email is already in use, please try another one.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <div>
<a href="http://validator.w3.org/check?uri=referer"
style="background-color: transparent">
<img style="border-style:none" width="88" height="31"
src="http://www.w3.org/Icons/valid-html401" alt="Valid HTML 4.01"></a>
&nbsp;&nbsp;
<a href="http://jigsaw.w3.org/css-validator/check/referer"
style="background-color: transparent">
<img style="border-style:none" width="88" height="31"
src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!"></a>
</div>
</body>

</html>
