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

echo "<table style='width:100%'>";
echo "<tr>"; 
for($j=$day; $j<($day+5); $j++) { 
    echo "<th>" . $month . "-" . $j . "</th>";
    
}
echo "</tr>";

echo "<tr>";
while($day < $day1+5) {
$dayfield = $year . "-" . $month . "-" . $day; 
$result = mysqli_query($conn, "SELECT * FROM MEAL WHERE date = '" . $dayfield ."' ORDER BY meal_type");
    while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) { 
        echo "<td>" . $row['description'] . "</td>";
        echo "<br>";
    }
    echo "</tr>";
$day++;

}

echo "</table>";
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>

</html>
