<?php
session_start();
$DBServer="localhost" ; $DBUser="tjdpproj_user" ; $DBPass="Bookerer1" ; $DBName="tjdpproj_db" ; 

//connect 
$conn= new mysqli($DBServer, $DBUser, $DBPass, $DBName); 

// Check connection
if (mysqli_connect_errno()) {
    echo "Database connection failed: " . mysqli_connect_error();
}

$dbhost = "localhost"; // this will ususally be 'localhost', but can sometimes differ
$dbname = "database"; // the name of the database that you are going to use for this project
$dbuser = "username"; // the username that you created, or were given, to access your database
$dbpass = "password"; // the password that you created, or were given, to access your database
 
mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());
mysql_select_db($dbname) or die("MySQL Error: " . mysql_error());
?>