<?php
session_start();
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
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);

$sql="SELECT * FROM STUDENTS WHERE email='$username' and password='$password'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $username and $password, table row must be 1 row

if($count==1){

// Register $myusername, $mypassword and redirect to file "login_success.php"
session_register("username");
session_register("password");
header("location:login_success.php");
}
else {
echo "Wrong Username or Password";
}


?>