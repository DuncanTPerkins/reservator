<?php  session_start(); ?>
<!DOCTYPE html>
<html lang="">
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
    <title> Duncan Perkins' Resume</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="/css/login.css" />
    <link href='http://fonts.googleapis.com/css?family=Chelsea+Market' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>

                    <nav class="navbar navbar-default navbar-fixed-top" id="navbar" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">

                    <a class="navbar-brand" id="navbar-brand" href="php/gohome.php">
                        <div class="hidden-sm hidden-xs" id="navbar-brand-padding">&nbsp;</div>UTK Delta Zeta Meal Reservation</a>
                </div>
                <ul class="nav navbar-nav">
                                    <li><a href="mission.php">Mission Statement</a></li>
                                    <li class="active"><a href="#">Resume</a></li>

                </ul>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <?php
                            echo"<a href='#'>Welcome, " . $_SESSION['name'] . "</a>"; ?>
                        </li>
                        <li><a id="logout" href="php/logout.php">Log Out<div class="hidden-sm hidden-xs" id="navbar-right-padding">&nbsp;</div></a>
                        </li>

                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
        <!-- Navbar -->
    <table class="toptable">
    <tr>
    <td><h1 class="myname">Duncan Perkins</h1> <br> <a class="myaddress" href="mailto:perkinsdt@goldmail.etsu.edu?Subject=Howdy" target="_top">
<b>perkinsdt@goldmail.etsu.edu</b></a> </td>
    <td><img class="top" src="http://99designs.com/logo-design/store/9963/preview/5649868~6eacf665b4eca2a96d9d55598c977def62627c36-stocklarge" alt=""></td>
    </tr>
    </table>
    <hr class="topline">


    <table class="bottable">
    <tr>

     <td>
         <h1>Education</h1>


        </td>



    </tr>
        <tr> <td>
            <h2 class="twenty bandi"> ETSU



        </h2>
            </td>

            <td class="year bandi"> 2014-2015 </td>

        </tr>

        <tr>
        <td class="fifty">Undergraduate in Computing Science</td>



        </tr>


                <tr> <td>
            <h2 class="twenty bandi"> Pellissippi



        </h2>
            </td>

                    <td class="year"> <b><i>2012-2014</i></b> </td>

        </tr>

        <tr>
        <td class="fifty">N/A</td>



        </tr>

        <tr>
        <td>
         <h1>Experience</h1>


        </td>

            </tr>

        <tr> <td>
            <h2 class="twenty bandi"> My Github



        </h2>
            </td>

            <td class="year bandi"> N/A </td>

        </tr>

        <tr>
        <td class="fifty"><a href="https://github.com/weweboom">http://www.github.com/weweboom</a></td>



        </tr>

<tr>
            <td>
         <h1>Activities</h1>


        </td>


    </tr>
        <tr> <td>
            <h2 class="twenty bandi"> Basejumping



        </h2>
            </td>

            <td class="year bandi"> 2010-2014 </td>

        </tr>

        <tr>
        <td class="fifty">Casual Basejumping is a great way to relax</td>



        </tr>

            <tr> <td>
            <h2 class="twenty bandi"> Bass Guitar for Metallica



        </h2>
            </td>

            <td class="year bandi"> 1994-2014 </td>

        </tr>

        <tr>
        <td class="fifty">Performing as the main bassist for the band Metallica is my favorite weekend hobby.</td>



        </tr>
    </table>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<div>
<a href="http://validator.w3.org/check?uri=referer"
style="background-color: transparent">
<img style="border-style:none" width="88" height="31"
src="http://www.w3.org/Icons/valid-html401" alt="Valid HTML 4.01"></a>
&nbsp;&nbsp;
<a href="http://jigsaw.w3.org/css-validator/check/referer"
style="background-color: transparent">
<img style="border-style:none" width="88" height="31"
src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!"></a>
</div>
</body>
</html>
