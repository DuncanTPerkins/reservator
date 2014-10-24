<?php
ob_start();
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
  private $mon = "";
  private $tue = "";
  private $wed = "";
  private $thu = "";
  private $fri = "";
  private $mond = "";
  private $tued = "";
  private $wedd = "";
  private $thud = "";
  private $frid = "";



//connect
$conn= new mysqli($DBServer, $DBUser, $DBPass, $DBName);

// Check connection
if (mysqli_connect_errno()) {
    echo "Database connection failed: " . mysqli_connect_error();
}

$sql="SELECT * FROM MEALS WHERE email='$username' and password='$password'";
$result=mysqli_query($conn, $sql);

// Mysql_num_row is counting table row
$count=mysqli_num_rows($result);

}
?>
