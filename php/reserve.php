<?php session_start();
/*
            Name:       Duncan Perkins
            Course:     CSCI 1710-003
            Assignment: Personal Project
            Due Date: 12/2/2014
            Purpose:    The purpose of this web page is to serve as a reservation system for the kitchen of a sorority
        */
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
$datetime = $row['date'];


if(mysqli_query($conn, "INSERT INTO RESERVATION(student, meal, date) VALUES('$studentid', '$mealid', '$datetime')")) {
header( "location:../calendar.php");

}

else {echo "Error: " . mysqli_error($conn);}
mysqli_close($conn);

?>
