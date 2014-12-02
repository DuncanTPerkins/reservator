
<?php session_start();
/*

    <!--
            Name:       Duncan Perkins
            Course:     CSCI 1710-003
            Assignment: Personal Project
            Due Date: 12/2/2014
            Purpose:    The purpose of this web page is to serve as a reservation system for the kitchen of a sorority
        -->
        */
    //connect to the database
    $DBServer="localhost"; $DBUser="tjdpproj_user"; $DBPass="Bookerer1"; $DBName="tjdpproj_db";
    $conn= new mysqli($DBServer, $DBUser, $DBPass, $DBName);

    // Check connection
    if (mysqli_connect_errno()) {
    echo "Database connection failed: " . mysqli_connect_error();
    }
$description = $_POST['description'];
$mealid = $_POST['mealid'];
$datetime = $_POST['datetime'];
$mealtype = $_POST ['meal_type'];

if($mealid=="") {
$sql="INSERT INTO MEAL(pk_meal_id, description, meal_type, date)
VALUES (NULL, '$description', '$mealtype', '$datetime')";
if (mysqli_query($conn, $sql)) {
    header("location:../staff.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
else {
 $sql = "UPDATE MEAL SET description='$description', meal_type='$mealtype', date='$datetime' WHERE pk_meal_id = '$mealid'";
 if (mysqli_query($conn, $sql)) {
    header("location:../staff.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>
