<?php
$DBServer="localhost" ; $DBUser="tjdpproj_user" ; $DBPass="Bookerer1" ; $DBName="tjdpproj_db" ;

//connect
$conn=new mysqli($DBServer, $DBUser, $DBPass, $DBName);

// Check connection
if (mysqli_connect_errno()) {
    echo "Database connection failed: " . mysqli_connect_error();
}

$password = $_POST['password'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];


$sql = "INSERT INTO STUDENTS(pk_student_id, username, password, email, phone, fname, lname)
VALUES (NULL, '$email', '$password', '$email', '$phone', '$fname', '$lname')";

if (mysqli_query($conn, $sql)) {
    session_start();
    $_SESSION['username'] = $email;
    $_SESSION['name'] = $fname . " " . $lname;
    header("location:../calendar.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
