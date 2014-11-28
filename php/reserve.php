<?php
$DBServer="localhost"; $DBUser="tjdpproj_user"; $DBPass="Bookerer1"; $DBName="tjdpproj_db";
//connect
$conn= new mysqli($DBServer, $DBUser, $DBPass, $DBName);
print_r($_POST);
// Check connection
if (mysqli_connect_errno()) {
    echo "Database connection failed: " . mysqli_connect_error();
}

$studentid = $_POST['studentid'];
$mealid = $_POST['mealid'];
$datetime = $_POST['datetime'];

if(mysqli_query($conn, "INSERT INTO RESERVATION(student, meal, date) VALUES('$studentid', '$mealid', '$datetime')")) {

 echo "success";
}

else {echo "Error: " . mysqli_error($conn);}
mysqli_close($conn);

?>
