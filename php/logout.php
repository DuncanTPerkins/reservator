
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
session_destroy();
session_start();
$_SESSION['loggedout'] = 1;
header("location:../index.php");
?>
