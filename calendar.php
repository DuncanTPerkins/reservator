<?php session_start(); if(!session_is_registered(username)){ header( "location:index.php");
}
$today = getdate();
$DBServer="localhost"; $DBUser="tjdpproj_user"; $DBPass="Bookerer1"; $DBName="tjdpproj_db";
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
$mealloop = array("");
$studentid = $_SESSION['studentid'];
for($j=0; $j<5; $j++) {
$dates[$j] = $loopDay->format('l, F d');
$loopDay->modify('+1 day');
}

for($w = 0; $w<9; $w++) {
}

for($w = 0; $w<9; $w++) {
 $class[$w] = "nonmeal";
 $meals[$w] = "Nothing Yet!";
$checks[$w] = "";
}



//connect
$conn= new mysqli($DBServer, $DBUser, $DBPass, $DBName);

// Check connection
if (mysqli_connect_errno()) {
    echo "Database connection failed: " . mysqli_connect_error();
}
$day2 = $day;
while($day < $day1+5) {
$dayfield = $year . "-" . $month . "-" . $day;
$result2 = mysqli_query($conn, "SELECT meal FROM RESERVATION WHERE student = '$studentid' and date = '$dayfield'");
    $i=0;
    while($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC)) {
        $mealloop[$i] = $row2['meal'];
        $i++;
    }
    $day++;
}
$k = 0;
while($day1 < $day2+5) {
$dayfield = $year . "-" . $month . "-" . $day1;
$result = mysqli_query($conn, "SELECT * FROM MEAL WHERE date = '" . $dayfield ."' ORDER BY meal_type");
$count=mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
        print_r($mealloop);
        if($count == 2) {
        if($row['meal_type'] == 0) {
            $meals[$k] = $row['description'];
            $mealid[$k] = $row['pk_meal_id'];
            //echo "row " . $row['pk_meal_id'] . " mealloop " . $mealloop[$k];
            for($i = 0; $i<sizeof($mealloop); $i++) {
            if($row['pk_meal_id'] == $mealloop[$i]) {
            $class[$k] = "nomeal";
            $checks[$k] = '<span class="glyphicon glyphicon-ok"></span>';
            }
            else {
                $class[$k] = "meal";
            }
            }


        }
        if($row['meal_type'] == 1) {
            $meals[$k+1] = $row['description'];
            $mealid[$k+1] = $row['pk_meal_id'];
            for($i = 0; $i<sizeof($mealloop); $i++) {
            if($row['pk_meal_id'] == $mealloop[$i]) {
            $class[$k+1] = "nomeal";
            $checks[$k+1] = '<span class="glyphicon glyphicon-ok"></span>';
            }
            else {
                $class[$k+1] = "meal";
            }
            }


        }
        }

        if($count == 1) {
         if($row['meal_type'] == 0) {
            $meals[$k] = $row['description'];
            $meals[$k+1] = "Nothing Yet!";
            $mealid[$k] = $row['pk_meal_id'];
            for($i = 0; $i<sizeof($mealloop); $i++) {
            if($row['pk_meal_id'] == $mealloop[$i]) {
            $class[$k] = "nomeal";
            $checks[$k] = '<span class="glyphicon glyphicon-ok"></span>';
            }
            else {
                $class[$k] = "meal";
            }
            }

         }
            if($row['meal_type'] == 1) {
            $meals[$k+1] = $row['description'];
            $meals[$k] = "Nothing Yet!";
            $mealid[$k+1] = $row['pk_meal_id'];
             for($i = 0; $i<sizeof($mealloop); $i++) {
            if($row['pk_meal_id'] == $mealloop[$i]) {
            $class[$k+1] = "nomeal";
            $checks[$k+1] = '<span class="glyphicon glyphicon-ok"></span>';
            }
            else {
                $class[$k+1] = "meal";
            }
            }


         }
        }



    }
$k = $k + 2;
$day1++;
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
     <script>
          $calendaritem = $(".meal,.nonmeal,.label-primary");

          $(document).ready(function () {
            var $student_id = <?php echo $_SESSION['studentid']; ?>;
            var $datetime = <?php $today = getdate(); $year = $today[year]; $month = $today[mon]; $day = $today[mday]; echo '"' . $year . "-" . $month . "-" . $day . '"'; ?>;
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
