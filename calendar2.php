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

for($j=0; $j<5; $j++) {
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
while($day < $day1+5) {
$dayfield = $year . "-" . $month . "-" . $day;
$result = mysqli_query($conn, "SELECT * FROM MEAL WHERE date = '" . $dayfield ."' ORDER BY meal_type");
$count=count($result);
    while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
        if($count == 2) {
        if($row['meal_type'] == 0) {
            $meals[$k] = $row['description'];
        }
        if($row['meal_type'] == 1) {
            $meals[$k+1] = $row['description'];
        }
        }

        if($count == 1) {
         if($row['meal_type'] == 0) {
            $meals[$k] = $row['description'];
            $meals[$k+1] = "";
         }
            if($row['meal_type'] == 1) {
            $meals[$k+1] = $row['description'];
            $meals[$k] = "";
         }
        }

        if($count == 0) {
            $meals[$k] = "";
            $meals[$k+1] = "";
        }
        $k = $k + 2;
    }

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
     <script>
          $calendaritem = $(".meal,.label-primary");

          $(document).ready(function () {
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

               $(".meal").click(function(){
                    $("#myModal").modal('show');
               });
          });
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
                              Week of October 20-24, 2014
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
                                                       <div class="meal">
                                                            Pimento cheese and chicken salad sandwiches w/ chicken noodle soup
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="row drow">
                                                  <div class="col-md-12 dinner">
                                                       <span class="label label-primary">DINNER:</span>
                                                       <br>
                                                       <div class="meal">
                                                            Spaghetti with meatballs, green beans and rolls
                                                           <span class="glyphicon glyphicon-ok"></span>
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
                                             Tuesday, October 21st
                                        </div>
                                        <div class="panel-body calendar-body">
                                             <div class="row lrow">
                                                  <div class="col-md-12 lunch">
                                                       <span class="label label-primary">LUNCH:</span>
                                                       <br>
                                                       <div class="meal">
                                                            Taco bar and white chicken chili
                                                           <span class="glyphicon glyphicon-ok"></span>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="row drow">
                                                  <div class="col-md-12 dinner">
                                                       <span class="label label-primary">DINNER:</span>
                                                       <br>
                                                       <div class="meal">Liz’s Orange chicken with broccoli and chocolate bar cake
                                                            <span class="glyphicon glyphicon-ok"></span>
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
                                             Wednesday, October 22nd
                                        </div>
                                        <div class="panel-body calendar-body">
                                             <div class="row lrow">
                                                  <div class="col-md-12 lunch">
                                                       <span class="label label-primary">LUNCH:</span>
                                                       <br>
                                                       <div class="meal">Ham roll ups with pumpkin soup, tofu and pasta salad
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="row drow">
                                                  <div class="col-md-12 dinner">
                                                       <span class="label label-primary">DINNER:</span>
                                                       <br>
                                                       <div class="meal">Blackened Salmon with creamy cajun pasta and corn mague choux
                                                           <span class="glyphicon glyphicon-ok"></span>
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
                                             Thursday, October 23rd
                                        </div>
                                        <div class="panel-body calendar-body">
                                             <div class="row lrow">
                                                  <div class="col-md-12 lunch">
                                                       <span class="label label-primary">LUNCH:</span>
                                                       <br>
                                                       <div class="meal">Southwest chicken wrap and broccoli cheddar soup
                                                           <span class="glyphicon glyphicon-ok"></span>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="row drow">
                                                  <div class="col-md-12 dinner">
                                                       <span class="label label-primary">DINNER:</span>
                                                       <br>
                                                       <div class="meal">Meatloaf with garlic mashed potatoes, candied carrots and banana pudding
                                                            <span class="glyphicon glyphicon-ok"></span>
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
                                             Friday, October 24th
                                        </div>
                                        <div class="panel-body calendar-body">
                                             <div class="row lrow">
                                                  <div class="col-md-12 lunch">
                                                       <span class="label label-primary">LUNCH:</span>
                                                       <br>
                                                      <div class="meal friday-lunch">Fried Friday: pickles, sweet potato fries and eggrolls
                                                            <span class="glyphicon glyphicon-ok glyph-friday"></span>
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
        <button type="button" class="btn btn-primary">Yes</button>
      </div>
    </div>
  </div>
</div>
</body>

</html>
