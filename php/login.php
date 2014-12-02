
    <!--
            Name:       Duncan Perkins
            Course:     CSCI 1710-003
            Assignment: Personal Project
            Due Date: 12/2/2014
            Purpose:    The purpose of this web page is to serve as a reservation system for the kitchen of a sorority
        -->
<?php
ob_start();
$DBServer="localhost" ; $DBUser="tjdpproj_user" ; $DBPass="Bookerer1" ; $DBName="tjdpproj_db" ;

//connect
$conn= new mysqli($DBServer, $DBUser, $DBPass, $DBName);

// Check connection
if (mysqli_connect_errno()) {
    echo "Database connection failed: " . mysqli_connect_error();
}

//user and pass from index.html
$username = $_POST['username'];
$password = $_POST['password'];

//security concerns
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

if(isset($_POST['radiolog'])) {
    $radiovalue = $_POST['radiolog'];
}
if($radiovalue=="student") {
$sql="SELECT * FROM STUDENTS WHERE email='$username' and password='$password'";
$result=mysqli_query($conn, $sql);

// Mysql_num_row is counting table row
$count=mysqli_num_rows($result);



// If result matched $username and $password, table row must be 1 row
if($count==1){
    $row = mysqli_fetch_array($result, MYSQL_ASSOC);
    $studentid = $row[pk_student_id];
    // Register $myusername, $mypassword and redirect to file "login_success.php"
    session_register("username");
    session_register("password");
    session_register("studentid");
    $name = $row[fname] . " " . $row[lname];
    session_register("name");
    header("location:../calendar.php");
}
else {
session_destroy();
session_register('logfail');
$_SESSION['logfail'] = 1;
header("location:../index.php");
}
ob_end_flush();

}

if($radiovalue=="staff") {
$staffsql = "SELECT * FROM STAFF WHERE username='$username' and password='$password'";
$staffresult=mysqli_query($conn, $staffsql);

// Mysql_num_row is counting table row
$count=mysqli_num_rows($staffresult);

// If result matched $username and $password, table row must be 1 row
if($count==1){
    $row = mysqli_fetch_array($staffresult, MYSQL_ASSOC);
    $staffid = $row[pk_staff_id];
    // Register $myusername, $mypassword and redirect to file "login_success.php"
    session_register("username");
    session_register("password");
    session_register("staffid");
    $name = $row[fname] . " " . $row[lname];
    session_register("name");
    header("location:../staff.php");
}

else {
session_destroy();
session_register('logfail');
$_SESSION['logfail'] = 1;
header("location:../index.php");
}
ob_end_flush();

}

?>

