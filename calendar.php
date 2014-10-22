<?php
session_start();
if(!session_is_registered(username)){
header("location:index.html");
}

echo $_SESSION["username"] . "<br>";
?>
<!DOCTYPE html>
<html lang="en">
<!-- google drive-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Reservations</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="/css/login.css" />
    <link href='http://fonts.googleapis.com/css?family=Chelsea+Market' rel='stylesheet' type='text/css'>

    <!--[if IE]>
        <script src="https://cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body  heightfull>
    <div class="container-fluid heightfull">
        <div class="row vertical-offset-50">          
                        
                        <div class="col-md-10 col-md-offset-1 vertical-offset-50 heightfull">
                            <div class="panel panel-default main-calendar-panel  heightfull">
                                <div class="panel-heading week-of-heading">
                                    Week of October 20-24, 2014
                                </div>
                                <div class="panel-body main-panel calendar-panel-body">
                                    <div class="col-md-2 calendar-padding">

                                        <div class="panel panel-default calendar-panel sidepanel">
                                            <div class="panel-heading sidepanel-heading">
                                            Welcome
                                            </div>
                                            <div class="panel-body calendar-body sidepanel-body">
                                                Just select the meal you want to reserve. Please reserve no later than 12 hours in advance. <br><br>-Thanks
                                                
                                                
                                                    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 calendar-padding">

                                        <div class="panel panel-default calendar-panel">
                                            <div class="panel-heading calendar-heading">
                                                
                                                Monday, October 20th
                                            </div>
                                            <div class="panel-body calendar-body">
                                                <div class="row lrow">
                                                    <div class="col-md-12 lunch">
                                                <span class="label label-primary">LUNCH:</span><br>
                                                        <div class="meal">
                                                        Pimento cheese and chicken salad sandwiches w/ chicken noodle soup
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row drow">
                                                    <div class="col-md-12 dinner">
                                                <span class="label label-primary">DINNER:</span><br>
                                                        <div class="meal">
                                                        Spaghetti with meatballs, green beans and rolls
                                                        </div>
                                                    </div>
                                                </div>
                                                    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 calendar-padding">

                                        <div class="panel panel-default calendar-panel">
                                            <div class="panel-heading calendar-heading">
                                                Tuesday, October 21st
                                            </div>
                                            <div class="panel-body calendar-body">
                                                <div class="row lrow">
                                                    <div class="col-md-12 lunch">
                                                <span class="label label-primary">LUNCH:</span><br>
                                                        <div class="meal">
                                                            Taco bar and white chicken chili
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row drow">
                                                    <div class="col-md-12 dinner">
                                                <span class="label label-primary">DINNER:</span><br>
                                                        <div class="meal">Liz’s Orange chicken with broccoli and chocolate bar cake
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 calendar-padding">

                                        <div class="panel panel-default calendar-panel">
                                            <div class="panel-heading calendar-heading">
                                                Wednesday, October 22nd
                                            </div>
                                            <div class="panel-body calendar-body">
                                                <div class="row lrow">
                                                    <div class="col-md-12 lunch">
                                                <span class="label label-primary">LUNCH:</span><br>
                                                        <div class="meal">Ham roll ups with pumpkin soup, tofu and pasta salad
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row drow">
                                                    <div class="col-md-12 dinner">
                                                <span class="label label-primary">DINNER:</span><br>
                                                        <div class="meal">Blackened Salmon with creamy cajun pasta and corn mague choux
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 calendar-padding">

                                        <div class="panel panel-default calendar-panel">
                                            <div class="panel-heading calendar-heading">
                                                Thursday, October 23rd
                                            </div>
                                            <div class="panel-body calendar-body">
                                                <div class="row lrow">
                                                    <div class="col-md-12 lunch">
                                                <span class="label label-primary">LUNCH:</span><br>
                                                        <div class="meal">Southwest chicken wrap and broccoli cheddar soup
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row drow">
                                                    <div class="col-md-12 dinner">
                                                <span class="label label-primary">DINNER:</span><br>
                                                        <div class="meal">Meatloaf with garlic mashed potatoes, candied carrots and banana pudding
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 calendar-padding">

                                        <div class="panel panel-default calendar-panel">
                                            <div class="panel-heading calendar-heading">
                                                Friday, October 24th
                                            </div>
                                            <div class="panel-body calendar-body">
                                                <div class="row lrow">
                                                    <div class="col-md-12 lunch">
                                                <span class="label label-primary">LUNCH:</span><br>
                                                        <div class="meal">Fried Friday: pickles, sweet potato fries and eggrolls
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row drow">
                                                    <div class="col-md-12 dinner">
                                                <span class="label label-primary">DINNER:</span><br>
                                                        <div class="meal">Fried Friday: pickles, sweet potato fries and eggrolls
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                             
                            
                    
                    </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>

</html>
