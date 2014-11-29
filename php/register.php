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
if (!$sql1) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
$rows = mysqli_num_rows($sql1);
$sql2 = "INSERT INTO STUDENTS(pk_student_id, username, password, email, phone, fname, lname)
VALUES (NULL, '$email', '$password', '$email', '$phone', '$fname', '$lname')";


if(!$sql1||$rows==0) {
if (mysqli_query($conn, $sql2)) {
    $sql3 = mysqli_query($conn, "SELECT * FROM STUDENTS WHERE '$email' = email");
    $result = mysqli_fetch_array($sql3, MYSQLI_ASSOC);
    $_SESSION['username'] = $email;
    $_SESSION['name'] = $fname . " " . $lname;
    $_SESSION['studentid'] = $result['pk_student_id'];
    header("location:../calendar.php");
} else {
    echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
    }
}
else {
    $_SESSION['nouse'] = "go";
    header("location:../register.php");
}



mysqli_close($conn);
?>
