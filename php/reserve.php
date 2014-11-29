<?php
$DBServer="localhost"; $DBUser="tjdpproj_user"; $DBPass="Bookerer1"; $DBName="tjdpproj_db";
//connect
$conn= new mysqli($DBServer, $DBUser, $DBPass, $DBName);
// Check connection
if (mysqli_connect_errno()) {
    echo "Database connection failed: " . mysqli_connect_error();
}

$studentid = $_POST['studentid'];
$mealid = $_POST['mealid'];

$result = mysqli_query($conn, "SELECT date FROM MEAL WHERE pk_meal_id = '$mealid'");
$row = mysqli_fetch_array($result, MYSQL_ASSOC);
print_r($row);
$datetime = $row['date'];


if(mysqli_query($conn, "INSERT INTO RESERVATION(student, meal, date) VALUES('$studentid', '$mealid', '$datetime')")) {
header( "location:../calendar.php");

}

else {echo "Error: " . mysqli_error($conn);}
mysqli_close($conn);

?>
