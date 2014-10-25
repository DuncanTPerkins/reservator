<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Starter Template for Bootstrap 3.2.0</title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <style>
        body {
            padding-top: 50px;
        }
        .starter-template {
            padding: 40px 15px;
            text-align: center;
        }
    </style>

    <!--[if IE]>
        <script src="https://cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Reservations</a>
            </div>

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Calendar</a>
                    </li>
                    <li><a href="#contact">Settings</a>
                    </li>
                </ul>
            </div>
            <!--.nav-collapse -->
        </div>
    </nav>
    <?php $DBServer="localhost" ; $DBUser="tjdpproj_user" ; $DBPass="Bookerer1" ; $DBName="tjdpproj_db" ;

//connect
$conn= new mysqli($DBServer, $DBUser, $DBPass, $DBName);

// Check connection
if (mysqli_connect_errno()) {
    echo "Database connection failed: " . mysqli_connect_error();
}


$today = getdate();
$year = $today[year];
$month = $today[mon];
$day = ($today[mday] - $today[wday]) + 1;
$day1 = $day;
$lunches = array();
$dinners = array();
$ll = 0;
$dl = 0;
echo "<table style='width:100%'>";
echo "<tr>";
$startingDay = new DateTime($year . "-" . $month . "-" . $day);
$startingDay->modify('+4 days');
$endingDay = $startingDay;
$startingDay = new DateTime($year . "-" . $month . "-" . $day);
$loopDay = $startingDay;

for($j=0; $j<5; $j++) {
    echo "<th>" . $loopDay->format('l, F d') . "</th>";
    $loopDay->modify('+1 day');
}


echo "</tr>";

echo "<tr>";
while($day < $day1+5) {
$dayfield = $year . "-" . $month . "-" . $day;
$result = mysqli_query($conn, "SELECT * FROM MEAL WHERE date = '" . $dayfield ."' ORDER BY meal_type");
    while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
        if($row['meal_type'] == 0) {
            array_push($lunches, $row['description']);
            $ll++;
        }
        if($row['meal_type'] == 1) {
            array_push($dinners, $row['description']);
            $dl++;
        }
    }


$day++;
}
    echo "<tr>";
    for($k = 0; $k < $ll; $k++) {
     echo "<td>" . $lunches[$k] . "</td>";
    }
    echo "</tr>";

        echo "<tr>";
    for($l = 0; $l < $dl; $l++) {
     echo "<td>" . $dinners[$l] . "</td>";
    }
    echo "</tr>";

echo "</table>";
mysqli_close($conn);
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>

</html>
