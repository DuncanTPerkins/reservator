<?php
session_start();
class week {
private $today = getdate();
$DBServer="localhost" ; $DBUser="tjdpproj_user" ; $DBPass="Bookerer1" ; $DBName="tjdpproj_db" ;
$today = getdate();
$year = $today[year];
$month = $today[mon];
$day = ($today[mday] - $today[wday]) + 1;
$day1 = $day;
$startingDay = new DateTime($year . "-" . $month . "-" . $day);
$startingDay->modify('+4 days');
$endingDay = $startingDay;
$startingDay = new DateTime($year . "-" . $month . "-" . $day);
$loopDay = $startingDay;
public $dates = array();

for($j=0; $j<5; $j++) {
$dates[$j] = $loopDay->format('l, F d');
$loopDay->modify('+1 day');
}

public $meals = array();


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
    while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
        $count=mysqli_num_rows($row);
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
function getWeeks() {
 return $dates;
}

function getMeals() {
 return $meals;
}
}
?>
