<?php
session_start();
session_destroy();
session_start();
$_SESSION['loggedout'] = 1;
header("location:../index.php");
?>
