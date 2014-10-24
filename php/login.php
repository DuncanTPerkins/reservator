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

$sql="SELECT * FROM STUDENTS WHERE email='$username' and password='$password'";
$result=mysqli_query($conn, $sql);

// Mysql_num_row is counting table row
$count=mysqli_num_rows($result);

// If result matched $username and $password, table row must be 1 row
if($count==1){

    // Register $myusername, $mypassword and redirect to file "login_success.php"
    session_register("username");
    session_register("password");
    $row = mysqli_fetch_array($result, MYSQL_ASSOC);
    $name = $row[fname] . " " . $row[lname];
    session_register("name");
    header("location:../calendar2.php");
}
else {
session_destroy();
session_register('logfail');
$_SESSION['logfail'] = 1;
header("location:../index.php");
}
ob_end_flush();

?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirm Reservation</h4>
            </div>
            <div class="modal-body">
                You have been logged out.
            </div>

        </div>
    </div>
</div>
