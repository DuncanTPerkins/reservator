<?php session_start();
if($_SESSION['staffid']) {
    header("location:../staff.php");
}

else if($_SESSION['studentid']) {
    header("location:../calendar.php");
}

else {
 header("location:../index.php");
}
?>
