<?php
session_start();
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
$sql1 = mysqli_query($conn, "SELECT * FROM STUDENTS WHERE '$email' = email");
$rows = mysqli_num_rows($sql1);
if($rows!=0) {
    $_SESSION['nouse'] = 1;
    header("location:../register.php");
}

else {
$sql2 = "INSERT INTO STUDENTS(pk_student_id, username, password, email, phone, fname, lname)
VALUES (NULL, '$email', '$password', '$email', '$phone', '$fname', '$lname')";

if (mysqli_query($conn, $sql2)) {
    $_SESSION['username'] = $email;
    $_SESSION['name'] = $fname . " " . $lname;
    header("location:../calendar.php");
} else {
    echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
