<?php

session_start();

if(!session_is_registered(username)) {
    header("location:index.php");
}

$today = getdate();

$DBServer="localhost";
$DBUser="tjdpproj_user";
$DBPass="Bookerer1";
$DBName="tjdpproj_db";

$year = $today[year];
$month = $today[mon];

$day = ($today[mday] - $today[wday]) + 1;
$day1 = $day;
$startingDay = new DateTime($year . "-" . $month . "-" . $day);
$startingDay->modify('+4 days');
$endingDay = $startingDay;
$startingDay = new DateTime($year . "-" . $month . "-" . $day);
$loopDay = $startingDay;

$dates = array();

for($j=0; $j<10; $j++) {
    $dates[$j] = $loopDay->format('l, F d');
    $loopDay->modify('+1 day');
}

//connect
$conn= new mysqli($DBServer, $DBUser, $DBPass, $DBName);

// Check connection
if (mysqli_connect_errno()) {
    echo "Database connection failed: " . mysqli_connect_error();
}

$k = 0;

while($day < $day1+10) {

    $dayfield = $year . "-" . $month . "-" . $day;

    $result = mysqli_query($conn, "SELECT * FROM MEAL WHERE date = '" . $dayfield ."' ORDER BY meal_type");

    $count=mysqli_num_rows($result);
        while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
            if($count == 2) {
                //meal_type 0 = lunch
                if($row['meal_type'] == 0) {
                    $meals[$k] = $row['description'];
                }
                //meal_type 0 = dinner
                if($row['meal_type'] == 1) {
                    $meals[$k+1] = $row['description'];
                }
            }

        if($count == 1) {
            //meal_type 0 = lunch
            if($row['meal_type'] == 0) {
                $meals[$k] = $row['description'];
                $meals[$k+1] = "";
             }
            //meal_type 0 = dinner
            if($row['meal_type'] == 1) {
                $meals[$k+1] = $row['description'];
                $meals[$k] = "";
            }
        }

        if($count == 0) {
            $meals[$k] = "";
            $meals[$k+1] = "";
        }
    }

    $k += 2;
    $day++;
}

?>

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
    <link href="http://fonts.googleapis.com/css?family=Chelsea+Market" rel="stylesheet" type="text/css">
    <!--[if IE]>
        <script src="https://cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script>
        $calendaritem = $(".meal,.label-primary");

        $(document).ready(function () {

            //               alert(window.innerWidth);

            changeLayout();
            //              $("#myModal").modal('show');

            $(".label-edit").hover(function () { //hover in
                $(this).css("background-color", "#fcbbb3");
                //                    $(this).next().next().css("border-color", "#fcbbb3");
                $(this).css("cursor", "pointer");

            }, function () { //hover out
                $(this).css("background-color", "#ed9e95");
                //                    $(this).prev().prev().css("border-color", "#ed9e95");
            });

            $(".label-list").hover(function () { //hover in
                $(this).css("background-color", "#fcbbb3");
                //                    $(this).next().next().css("border-color", "#fcbbb3");
                $(this).css("cursor", "pointer");

            }, function () { //hover out
                $(this).css("background-color", "#ed9e95");
                //                    $(this).prev().prev().css("border-color", "#ed9e95");
            });

            $(".label-list").click(function () {
                $("#myModal").modal('show');
            });

            $("#right-arrow, #right-arrow-label").click(function () {
                //                    $("#current-week-row").toggle('slide', 'left', 500);
                $("#current-week-row").hide();
                $("#next-week-row").show();
            });

            $("#left-arrow, #left-arrow-label").click(function () {
                //                    $("#next-week-row").toggle('slide', 'right', 500);
                $("#next-week-row").hide();
                $("#current-week-row").show();
            });

            $("#next-week-row").hide();

            $(window).resize(function () {
                changeLayout();
            });

            $(document).keydown(function (e) {
                switch (e.which) {
                case 37: // left
                    $("#next-week-row").hide();
                    $("#current-week-row").show();
                    break;

                case 39: // right
                    $("#current-week-row").hide();
                    $("#next-week-row").show();
                    break;

                default:
                    return; // exit this handler for other keys
                }
                e.preventDefault(); // prevent the default action (scroll / move caret)
            });

        });

        function changeLayout() {

            if (window.innerWidth < 768) {
                $("#right-arrow-label").hide();
                $("#left-arrow-label").hide();
            } else {
                $("#right-arrow-label").show();
                $("#left-arrow-label").show();
            }
            if (window.innerWidth < 326) {
                $('#navbar-brand').css("font-size", "15px");
            } else {
                $("#navbar-brand").css("font-size", "18px");
            }


            if (window.innerWidth < 300) {
                $('.calendar-heading').css("font-size", "12px");
            } else {
                $(".calendar-heading").css("font-size", "14px");
            }

            //               if (window.innerWidth < 385) {
            //                    $('.week-of-heading').css("font-size", "8px");
            //               } else if (window.innerWidth < 620) {
            //                    $('.week-of-heading').css("font-size", "10px");
            //               } else if (window.innerWidth < 1210) {
            //                    $('.week-of-heading').css("font-size", "14px",
            //                         "padding-top", "15px");
            //               } else {
            //                    $(".week-of-heading").css("font-size", "20px");
            //               }
        }
    </script>
</head>

<body heightfull>

    <div class="container-fluid heightfull">
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
        <div class="row vertical-offset-100" id="current-week-row">
            <!-- row container with 100px vertical offset -->
            <div class="col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1 vertical-offset-50 heightfull">
                <div class="panel panel-default main-calendar-panel  heightfull">

                    <div class="panel-heading week-of-heading">

                              Week of <?php
                            echo $dates[0] . " - " . $dates[4] . ", " . $year; ?>
                        <div id="right-arrow-label">Next Week</div><span class="glyphicon glyphicon-arrow-right right" id="right-arrow"></span>
                    </div>
                    <div class="panel-body main-panel calendar-panel-body">
                        <div class="col-md-4 col-sm-4 col-lg-4 hidden-xs calendar-padding">

                            <div class="panel panel-default calendar-panel sidepanel">
                                <div class="panel-heading sidepanel-heading">
                                    Current Week
                                </div>
                                <div class="panel-body calendar-body sidepanel-body">
                                    Here you can edit meals for the current week.

                                    <br>
                                    <br>-Thanks



                                </div>
                            </div>
                        </div>
                        <!-- Welcome -->
                        <div class="col-md-4 col-sm-4 col-lg-4 calendar-padding">

                            <div class="panel panel-default calendar-panel">
                                <div class="panel-heading calendar-heading">

                                    <?php echo $dates[0]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow">
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[0]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>
                                                <span class="label label-primary label-list">LIST</span>
                                                <!--                                                            <span class="glyphicon glyphicon-ok"></span>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow">
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[1]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>
                                                <span class="label label-primary label-list">LIST</span>
                                                <!--                                                           <span class="glyphicon glyphicon-ok"></span>-->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Monday -->
                        <div class="col-md-4 col-sm-4 col-lg-4 calendar-padding">

                            <div class="panel panel-default calendar-panel">
                                <div class="panel-heading calendar-heading">
                                    <?php echo $dates[1]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow">
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[2]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow">
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[3]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tuesday -->
                        <div class="col-md-4 col-sm-4 col-lg-4 calendar-padding">

                            <div class="panel panel-default calendar-panel">
                                <div class="panel-heading calendar-heading">
                                    <?php echo $dates[2]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow">
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[4]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow">
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[5]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Wednesday -->
                        <div class="col-md-4 col-sm-4 col-lg-4 calendar-padding">

                            <div class="panel panel-default calendar-panel">
                                <div class="panel-heading calendar-heading">
                                    <?php echo $dates[3]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow">
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[6]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow">
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[7]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Thursday -->
                        <div class="col-md-4 col-sm-4 col-lg-4 calendar-padding">

                            <div class="panel panel-default calendar-panel">
                                <div class="panel-heading calendar-heading">
                                    <?php echo $dates[4]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow">
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal friday-lunch">
                                                <?php echo $meals[8]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>
                                                <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Friday -->



                    </div>
                </div>
            </div>
            <!--- Calendar -->
        </div>
        <div class="row" id="next-week-row">
            <!-- row container with 100px vertical offset -->
            <div class="col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1 vertical-offset-100 heightfull">
                <div class="panel panel-default main-calendar-panel  heightfull">

                    <div class="panel-heading week-of-heading">

                              Week of <?php
                            echo $dates[5] . " - " . $dates[9] . ", " . $year; ?>
                        <span class="glyphicon glyphicon-arrow-left left" id="left-arrow"></span>
                        <div id="left-arrow-label">Current Week</div>
                    </div>
                    <div class="panel-body main-panel calendar-panel-body">
                        <div class="col-md-4 col-sm-4 col-lg-4 hidden-xs calendar-padding">

                            <div class="panel panel-default calendar-panel sidepanel">
                                <div class="panel-heading sidepanel-heading">
                                    Next Week
                                </div>
                                <div class="panel-body calendar-body sidepanel-body">
                                    Here you can edit the meals for next week.

                                    <br>
                                    <br>-Thanks



                                </div>
                            </div>
                        </div>
                        <!-- Welcome -->
                        <div class="col-md-4 col-sm-4 col-lg-4 calendar-padding">

                            <div class="panel panel-default calendar-panel">
                                <div class="panel-heading calendar-heading">

                                    <?php echo $dates[5]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow">
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[9]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow">
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[10]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Monday -->
                        <div class="col-md-4 col-sm-4 col-lg-4 calendar-padding">

                            <div class="panel panel-default calendar-panel">
                                <div class="panel-heading calendar-heading">
                                    <?php echo $dates[6]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow">
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[11]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow">
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[12]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tuesday -->
                        <div class="col-md-4 col-sm-4 col-lg-4 calendar-padding">

                            <div class="panel panel-default calendar-panel">
                                <div class="panel-heading calendar-heading">
                                    <?php echo $dates[7]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow">
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[13]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow">
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[14]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Wednesday -->
                        <div class="col-md-4 col-sm-4 col-lg-4 calendar-padding">

                            <div class="panel panel-default calendar-panel">
                                <div class="panel-heading calendar-heading">
                                    <?php echo $dates[8]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow">
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[15]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow">
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal">
                                                <?php echo $meals[16]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Thursday -->
                        <div class="col-md-4 col-sm-4 col-lg-4 calendar-padding">

                            <div class="panel panel-default calendar-panel">
                                <div class="panel-heading calendar-heading">
                                    <?php echo $dates[9]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow">
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal friday-lunch">
                                                <?php echo $meals[17]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>
                                                <span class="label label-primary label-list">LIST</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Friday -->



                    </div>
                </div>
            </div>
            <!--- Calendar -->
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">List of Reservations for Wednesday, September 3rd</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>E-Mail</th>
                            <th>Phone Number</th>
                        </tr>
                        <tr>
                            <td>Placeholder</td>
                            <td>Placeholder</td>
                            <td>Placeholder</td>
                            <td>Placeholder</td>
                        </tr>
                        <tr>
                            <td>Placeholder</td>
                            <td>Placeholder</td>
                            <td>Placeholder</td>
                            <td>Placeholder</td>
                        </tr>
                        <tr>
                            <td>Placeholder</td>
                            <td>Placeholder</td>
                            <td>Placeholder</td>
                            <td>Placeholder</td>
                        </tr>
                        <tr>
                            <td>Placeholder</td>
                            <td>Placeholder</td>
                            <td>Placeholder</td>
                            <td>Placeholder</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
