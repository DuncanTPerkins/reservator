<?php session_start();

    //send the user to the login page if they aren't logged in
    if(!session_is_registered(username)){ header( "location:index.php");
    }

    //connect to the database
    $DBServer="localhost"; $DBUser="tjdpproj_user"; $DBPass="Bookerer1"; $DBName="tjdpproj_db";
    $conn= new mysqli($DBServer, $DBUser, $DBPass, $DBName);

    // Check connection
    if (mysqli_connect_errno()) {
    echo "Database connection failed: " . mysqli_connect_error();
    }

    //Get the student ID from the session variables passed to us from either login.php or register.php
    $studentid = $_SESSION['studentid'];

    //return array of month, day, month year, week year, etc
    $today = getdate();

    //break the array up for ease of use
    $year = $today[year];
    $month = $today[mon];
    $day = $today[mday];

    //if today is a weekday
    if($today[wday] < 6) {

        //day equals the first day of the week (Monday)
        $day = ($today[mday] - $today[wday]) + 1;

        //create a new datetime object for the Monday of this week
        $dayBegin = new DateTime($year. "-" . $month . "-" . $day);
    }

    //if it's the weekend
    else {

        if($today[wday] == 6) {
            //it's Saturday
            //create a Datetime object for next Monday
            $dayBegin = new DateTime($year. "-" . $month . "-" . $day);
            $dayBegin->modify('+2 days');
        }

        if($today[wday] == 7) {
            //It's Sunday
            //create a Datetime object for next Monday
            $dayBegin = new DateTime($year. "-" . $month . "-" . $day);
            $dayBegin->modify('+1 day');
        }
    }

    //create a Datetime object for this Friday
    $dayEnd = clone $dayBegin;
    $dayEnd->modify('+11 days');

    //create a clone of the Datetime object for Monday,
    //to be used for day headers
    $loopDay = clone $dayBegin;


    //Fill an array with Datetime objects for each day of the week,
    //to be used as day headers
    for($j=0; $j<=11; $j++) {
        $dates[$j] = $loopDay->format('l, F d');
        $loopDay->modify('+1 day');
    }

    //set this back to Monday so that we can use it
    //to reset dayBegin
    $loopDay = clone $dayBegin;

    //initialize the arrays
    for($w = 0; $w<=22; $w++) {
        //Whether or not a meal is already reserved
        $class[$w] = "nonmeal";

        //Meal descriptions
        $meals[$w] = "Nothing Yet!";

        //Whether or not a meal needs a checkmark
        $checks[$w] = "";

        //date of each meal
        $datetime ="";
    }


    //check which meals have already been reserved by the student
    //while the current day is less than Friday
    $i=0;
    while($dayBegin->format('U') <= $dayEnd->format('U')) {

        //parse a string out of the Datetime object
        $dayfield = $dayBegin->format('Y-m-d');

        //Get all mealIDs' for Meal Reservations placed by the current student for the date we are currently looping through
        $result2 = mysqli_query($conn, "SELECT meal FROM RESERVATION WHERE student = '$studentid' and date = '$dayfield'");


        //while we aren't on the last row returned from the database query
        while($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC)) {

            //take the found mealID and put it into the array
            $mealloop[$i] = $row2['meal'];
            //index variable
            $i++;
        }

    //Move the day we are checking against ahead by one
    $dayBegin->modify('+1 day');
    }

    //reset dayBegin to Monday for looping through
    $dayBegin = clone $loopDay;

    //index for looping through the meals
    $k = 0;

    //while we're not at Friday yet
    while($dayBegin->format('U') < $dayEnd->format('U')) {

        //parse string out of the day we're currently looping through
        $dayfield = $dayBegin->format('Y-m-d');
        $datetime[$k] = $dayfield;
        $datetime[$k+1] = $dayfield;
        //Select rows from the Meal table that are on the current looped day, order them by whether they're lunch or dinner
        $result = mysqli_query($conn, "SELECT * FROM MEAL WHERE date = '" . $dayfield ."' ORDER BY meal_type");

        //integer of the number of rows that were returned from the above query
        $count=mysqli_num_rows($result);

        //while there are still rows remaining that we haven't gone through
        while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {

            //if 2 meals for the current day were found
            if($count == 2) {

                //if the current meal we're looping through is a lunch
                if($row['meal_type'] == 0) {

                    //Set the current array index to the current meal's description from the database
                    $meals[$k] = $row['description'];

                    //Set the current array index to the current meal's mealID from the database
                    $mealid[$k] = $row['pk_meal_id'];

                    //Make the current meal clickable by default
                    $class[$k] = "meal";

                    //if the current mealID is found in the array of already reserved meals,
                    //make this meal unclickable to avoid database errors, and add a checkmark
                    //to the current meal so the user knows they've already reserved it
                    for($i = 0; $i<sizeof($mealloop); $i++) {
                        if($row['pk_meal_id'] == $mealloop[$i]) {
                            $class[$k] = "nonmeal";
                            $checks[$k] = '<span class="glyphicon glyphicon-ok"></span>';
                        }
                    }
                }

                //if the current meal we're looping through is a dinner
                if($row['meal_type'] == 1) {

                    //Set the next array index to the current meal's description from the database
                    $meals[$k+1] = $row['description'];

                    //Set the next array index to the current meal's mealID from the database
                    $mealid[$k+1] = $row['pk_meal_id'];

                    //Make the current meal clickable by default
                    $class[$k+1] = "meal";

                    //if the current mealID is found in the array of already reserved meals,
                    //make this meal unclickable to avoid database errors, and add a checkmark
                    //to the current meal so the user knows they've already reserved it
                    for($i = 0; $i<sizeof($mealloop); $i++) {
                        if($row['pk_meal_id'] == $mealloop[$i]) {
                            $class[$k+1] = "nonmeal";
                            $checks[$k+1] = '<span class="glyphicon glyphicon-ok"></span>';
                        }
                    }
                }
            }

            //if 1 meal for the current day was found
            if($count == 1) {

                //if it's a lunch
                if($row['meal_type'] == 0) {

                    //set the current array index to the meal description from the database
                    $meals[$k] = $row['description'];

                    //set the current array index to the mealID from the database
                    $mealid[$k] = $row['pk_meal_id'];

                    //set the descripton for Dinner to "Nothing Yet!" since we only found 1 meal for today
                    $meals[$k+1] = "Nothing Yet!";

                    //set the meal to clickable by default
                    $class[$k] = "meal";

                    //set the meal to unclickable and give it a checkmark
                    //if the mealID was found to already have been reserved
                    //by the logged in student
                    for($i = 0; $i<sizeof($mealloop); $i++) {
                        if($row['pk_meal_id'] == $mealloop[$i]) {
                            $class[$k] = "nonmeal";
                            $checks[$k] = '<span class="glyphicon glyphicon-ok"></span>';
                        }
                    }
                }

                //if it's a dinner
                if($row['meal_type'] == 1) {

                    //set the next array index to the meal description from the database
                    $meals[$k+1] = $row['description'];

                    //set the next array index to the mealID from the database
                    $mealid[$k+1] = $row['pk_meal_id'];

                    //set the current array index to "Nothing Yet!" since we only found 1 meal for today
                    $meals[$k] = "Nothing Yet!";

                    //set the meal to clickable by default
                    $class[$k+1] = "meal";

                    //set the meal to unclickable and give it a checkmark
                    //if the mealID was found to already have been reserved
                    //by the logged in student
                    for($i = 0; $i<sizeof($mealloop); $i++) {
                        if($row['pk_meal_id'] == $mealloop[$i]) {
                            $class[$k+1] = "nonmeal";
                            $checks[$k+1] = '<span class="glyphicon glyphicon-ok"></span>';
                        }
                    }
                }
            }
        }

        //increment the index by 2 (2 meals per day, we want to loop through 1 day at a time)
        $k = $k + 2;

        //Increment the current looped date
        $dayBegin->modify('+1 day');
    }

    for($i=0;$i<=22;$i++) {
        $result = mysqli_query($conn, "SELECT * FROM RESERVATION WHERE MEAL = '" . $mealid[$i] ."'");

        //integer of the number of rows that were returned from the above query
        $count=mysqli_num_rows($result);

        $reservenum[$i] = $count;
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

            $(".meal").click(function(event) {
                $("#mealid").val(event.target.id);
                var description = $(this).html();
                var badstring = '<span class="label label-primary label-edit">';
                var badindex = description.indexOf(badstring);
                var newstring = description.substr(0, badindex-1);
                newstring = newstring.trim();
                $("#fieldentry").val(newstring);
                $("#changeDesc").modal('show');
                alert(this.attr("date"));
                //take the value from the meal description for this meal, and put it into the modal
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

            $(".label-edit").click(function () {
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
                                    <div class="row lrow" >
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[0]; ?>" date="<?php echo $datetime[0]; ?>">
                                                <?php echo $meals[0]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>
                                                <span class="label label-primary label-list"><?php echo $reservenum[0]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow" >
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[1]; ?>"  date="<?php echo $datetime[1]; ?>">
                                                <?php echo $meals[1]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>
                                                <span class="label label-primary label-list"><?php echo $reservenum[1]; ?></span>
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
                                            <div class="meal" id="<?php echo $mealid[2]; ?>" date="<?php echo $datetime[2]; ?>">
                                                <?php echo $meals[2]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[2]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow" >
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[3]; ?>">
                                                <?php echo $meals[3]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[3]; ?></span>
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
                                    <div class="row lrow" >
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[4]; ?>">
                                                <?php echo $meals[4]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[4]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow" >
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[5]; ?>">
                                                <?php echo $meals[5]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[5]; ?></span>
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
                                    <div class="row lrow" >
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[6]; ?>">
                                                <?php echo $meals[6]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[6]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow" >
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[7]; ?>">
                                                <?php echo $meals[7]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[7]; ?></span>
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
                                    <div class="row lrow" >
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal friday-lunch" id="<?php echo $mealid[8]; ?>">
                                                <?php echo $meals[8]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>
                                                <span class="label label-primary label-list"><?php echo $reservenum[8]; ?></span>
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
                            echo $dates[7] . " - " . $dates[11] . ", " . $year; ?>
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

                                    <?php echo $dates[7]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow" >
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[14]; ?>">
                                                <?php echo $meals[14]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[14]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow" >
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[15]; ?>">
                                                <?php echo $meals[15]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[15]; ?></span>
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
                                    <?php echo $dates[8]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow" >
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[16]; ?>">
                                                <?php echo $meals[16]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[16]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow" >
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[17]; ?>">
                                                <?php echo $meals[17]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[17]; ?></span>
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
                                    <?php echo $dates[9]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow" >
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[18]; ?>">
                                                <?php echo $meals[18]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[18]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow" >
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[19]; ?>">
                                                <?php echo $meals[19]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[19]; ?></span>
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
                                    <?php echo $dates[10]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow" >
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[20]; ?>">
                                                <?php echo $meals[20]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[20]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row drow" >
                                        <div class="col-md-12 dinner">
                                            <span class="label label-primary">DINNER:</span>
                                            <br>
                                            <div class="meal" id="<?php echo $mealid[21]; ?>">
                                                <?php echo $meals[21]; ?>

                                                <span class="label label-primary label-edit">EDIT</span>  <span class="label label-primary label-list"><?php echo $reservenum[21]; ?></span>
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
                                    <?php echo $dates[11]; ?>
                                </div>
                                <div class="panel-body calendar-body">
                                    <div class="row lrow" >
                                        <div class="col-md-12 lunch">
                                            <span class="label label-primary">LUNCH:</span>
                                            <br>
                                            <div class="meal friday-lunch" id="<?php echo $mealid[22]; ?>">
                                                <?php echo $meals[22]; ?>
                                                <span class="label label-primary label-edit">EDIT</span>
                                                <span class="label label-primary label-list"><?php echo $reservenum[22]; ?></span>
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


        <div class="modal fade" id="changeDesc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Edit Meal Description</h4>
                </div>
                <div class="modal-body">
                <form action="php/insert.php" method="POST">
            <input value="<?php $today = getdate(); $year = $today[year]; $month = $today[mon]; $day = $today[mday]; echo $year . "-" . $month . "-" . $day; ?>" name="datetime" style="display: none;">
            <input value="0" id="mealid" name="mealid" style="display: none;">
            <input value="" id="date" name="date" style="display: none;">
                    <textarea id="fieldentry" name="description" rows="4" cols="80"></textarea>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary formsubmit">Ok</button>
          </form>

                </div>
            </div>
        </div>
    </div>

</body>

</html>
