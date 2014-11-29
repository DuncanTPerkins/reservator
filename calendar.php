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
    $dayEnd->modify('+5 days');

    //create a clone of the Datetime object for Monday,
    //to be used for day headers
    $loopDay = clone $dayBegin;


    //Fill an array with Datetime objects for each day of the week,
    //to be used as day headers
    for($j=0; $j<5; $j++) {
        $dates[$j] = $loopDay->format('l, F d');
        $loopDay->modify('+1 day');
    }

    //set this back to Monday so that we can use it
    //to reset dayBegin
    $loopDay = clone $dayBegin;

    //initialize the arrays
    for($w = 0; $w<9; $w++) {
        //Whether or not a meal is already reserved
        $class[$w] = "nonmeal";

        //Meal descriptions
        $meals[$w] = "Nothing Yet!";

        //Whether or not a meal needs a checkmark
        $checks[$w] = "";
    }


    //check which meals have already been reserved by the student
    //while the current day is less than Friday
    while($dayBegin->format('U') <= $dayEnd->format('U')) {

        //parse a string out of the Datetime object
        $dayfield = $dayBegin->format('Y-m-d');

        //Get all mealIDs' for Meal Reservations placed by the current student for the date we are currently looping through
        $result2 = mysqli_query($conn, "SELECT meal FROM RESERVATION WHERE student = '$studentid' and date = '$dayfield'");
        $i=0;

        //while we aren't on the last row returned from the database query
        while($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC)) {

            //take the found mealID and put it into the array
            $mealloop[$i] = $row2['meal'];
            echo $row2['meal'];
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <title>UTK Delta Zeta Meal Reservations</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
     <link rel="stylesheet" type="text/css" href="/css/login.css" />
     <link href="http://fonts.googleapis.com/css?family=Chelsea+Market" rel="stylesheet" type="text/css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
     <script>
          $calendaritem = $(".meal,.nonmeal,.label-primary");

          $(document).ready(function () {
            var $student_id = <?php echo $_SESSION['studentid']; ?>;
            var $newmealid = 0;
               changeLayout();

               $(".meal").hover(function () { //hover in
                    $(this).css("border-color", "#fcbbb3");
                    $(this).prev().prev().css("background-color", "#fcbbb3");
                    $(this).css("cursor", "pointer");

               }, function () { //hover out
                    $(this).css("border-color", "#ed9e95");
                    $(this).prev().prev().css("background-color", "#ed9e95");
               });

               $(".label-primary").hover(function () { //hover in
                    $(this).css("background-color", "#fcbbb3");
                    $(this).next().next().css("border-color", "#fcbbb3");
                    $(this).css("cursor", "pointer");

               }, function () { //hover out
                    $(this).css("background-color", "#ed9e95");
                    $(this).prev().prev().css("border-color", "#ed9e95");
               });
/*
              $(".formsubmit").click(function() {
                  $.post("php/reserve.php",{studentid: "$studentid", mealid: "$mealid", datetime: "$datetime"})
                  .done(function(data) { alert(data); })
              });
*/
               $(".meal").click(function(event){
                    $newmealid = event.target.id;
                   $("input[id='mealid']").val($newmealid);
                    $("#myModal").modal('show');

               });

               $(window).resize(function(){
                    changeLayout();
               });
          });

          function changeLayout(){

               if (window.innerWidth < 326) {
                    $('#navbar-brand').css("font-size", "15px");
               }
               else {
                    $("#navbar-brand").css("font-size", "18px");
               }
//               if (window.innerWidth < 300) {
//                    $('.calendar-heading').css("font-size", "12px");
//               }
//               else {
//                    $(".calendar-heading").css("font-size", "14px");
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
          <div class="row vertical-offset-100"> <!-- row container with 100px vertical offset -->
              <div class="col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1 vertical-offset-50 heightfull">
                    <div class="panel panel-default main-calendar-panel  heightfull">

                         <div class="panel-heading week-of-heading">
                              Week of <?php
                            echo $dates[0] . " - " . $dates[4] . ", " . $year; ?>
                         </div>
                         <div class="panel-body main-panel calendar-panel-body">
                             <div class="col-md-4 col-sm-4 col-lg-4 hidden-xs calendar-padding">

                                   <div class="panel panel-default calendar-panel sidepanel">
                                        <div class="panel-heading sidepanel-heading">
                                             Welcome
                                        </div>
                                        <div class="panel-body calendar-body sidepanel-body">
                                             Just select the meal you want to reserve. Please reserve no later than 12 hours in advance.

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
                                                       <div class="<?php echo $class[0] . '"' . " id='$mealid[0]'>"?>
                                                            <?php echo $meals[0]; ?>
                                                            <?php echo $checks[0]; ?>
                                                            </div>

                                                       </div>
                                                  </div>

                                             <div class="row drow">
                                                  <div class="col-md-12 dinner">
                                                       <span class="label label-primary">DINNER:</span>
                                                       <br>
                                                       <div class="<?php echo $class[1] . '"' . " id='$mealid[1]'>"?>
                                                            <?php echo $meals[1]; ?>
                                                            <?php echo $checks[1]; ?>
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
                                                       <div class="<?php echo $class[2] . '"' . " id='$mealid[2]'>"?>
                                                            <?php echo $meals[2]; ?>
                                                            <?php echo $checks[2]; ?>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="row drow">
                                                  <div class="col-md-12 dinner">
                                                       <span class="label label-primary">DINNER:</span>
                                                       <br>
                                                       <div class="<?php echo $class[3] . '"' . " id='$mealid[3]'>"?>
                                                         <?php echo $meals[3]; ?>

                                                            <?php echo $checks[3]; ?>
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
                                                       <div class="<?php echo $class[4] . '"' . " id='$mealid[4]'>"?>
                                                           <?php echo $meals[4]; ?>

                                                            <?php echo $checks[4]; ?>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="row drow">
                                                  <div class="col-md-12 dinner">
                                                       <span class="label label-primary">DINNER:</span>
                                                       <br>
                                                       <div class="<?php echo $class[5] . '"' . " id='$mealid[5]'>"?>
                                                          <?php echo $meals[5]; ?>

                                                            <?php echo $checks[5]; ?>
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
                                                       <div class="<?php echo $class[6] . '"' . " id='$mealid[6]'>"?>
                                                           <?php echo $meals[6]; ?>

                                                            <?php echo $checks[6]; ?>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="row drow">
                                                  <div class="col-md-12 dinner">
                                                       <span class="label label-primary">DINNER:</span>
                                                       <br>
                                                       <div class="<?php echo $class[7] . '"' . " id='$mealid[7]'>"?>
                                                           <?php echo $meals[7]; ?>

                                                            <?php echo $checks[7]; ?>
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
                                                       <div class="friday-lunch <?php echo $class[8] . '"' . " id='$mealid[8]' >"?>
                                                           <?php echo $meals[8]; ?>

                                                            <?php echo $checks[8]; ?>
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
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirm Reservation</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to reserve this meal?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          <form action="php/reserve.php" method="POST">
            <input value="<?php echo $_SESSION['studentid']; ?>" name="studentid" style="display: none;">
            <input value="<?php $today = getdate(); $year = $today[year]; $month = $today[mon]; $day = $today[mday]; echo $year . "-" . $month . "-" . $day; ?>" name="datetime" style="display: none;">
            <input value="0" id="mealid" name="mealid" style="display: none;">
        <button type="submit" class="btn btn-primary formsubmit">Yes</button>
          </form>
      </div>
    </div>
  </div>
</div>
</body>

</html>
