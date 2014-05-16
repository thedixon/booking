<!DOCTYPE html>
<html>
<head>
    <link href='./fullcalendar/fullcalendar.css' rel='stylesheet' />
    <link href='./fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    <link href='./css/ui-lightness/jquery-ui-1.10.4.custom.min.css' rel='stylesheet' />
    <link href="./css/bootstrap.css" rel="stylesheet">
    <link href='./fullcalendar/fullcalendar-custom.css' rel='stylesheet' />

    <script src='./lib/jquery.min.js'></script>
    <script src='./lib/jquery-ui.custom.min.js'></script>
    <script src="./lib/bootstrap.js"></script>
    <script src='./lib/history.js'></script>
    <script src='./lib/history.adapter.js'></script>
    <script src='./lib/knockout-3.1.0.js'></script>
    <script src='./lib/knockout.punches.js'></script>
    <script src='./lib/underscore.js'></script>
    <script src='./fullcalendar/fullcalendar.js'></script>
    <script src='./js/custom-functions.js'></script>
    <script src='./js/sports.js'></script>
    <script src='./js/shared.js'></script>
    <script src='./js/basket.js'></script>
    <script src='./js/loaddata.js'></script>

    <title></title>
</head>

<body>
    <?php include('/includes/header.php'); ?>

    <?php include('/includes/modals.php'); ?>

    <div id="main" style="display: none">
        <div id="venueContainer" class="container">
            <div id="tabs">
                <ul class="nav nav-tabs">
                    <li class="active" data-displaytype="sportsNights">
                        <a href="#sportsNights" data-toggle="tab" data-displaytype="sportsNights" data-state="0" data-title="Sports Nights">Sports nights</a>
                    </li>
                    <li data-displaytype="paidActivities">
                        <a href="#paidActivities" data-toggle="tab" data-displaytype="paidActivities" data-state="1" data-title="Paid Activities">Paid activities</a>
                    </li>
                    <li class="pull-right" data-displaytype="basket"><a href="#basket" data-toggle="tab" data-displaytype="basket" data-state="3" data-title="Basket">
                        <i class="glyphicon glyphicon-shopping-cart"></i>  Bookings {{ basket.countDisplay }}</a>
                    </li>
                </ul>
                <div class="tab-content top-buffer-large">
                    <div class="tab-pane active" id="sportsNights">
                        <div class="alert alert-warning">
                            <div class="row">
                                <div class="col-md-4 text-left">
                                    <strong>Select sport</strong>
                                    <select id="sportSelect" data-bind="options: activitiesFiltered, optionsText: 'name', optionsValue: 'id', value: activityId" class="form-control"></select>
                                </div>
                                <div class="col-md-2 col-md-offset-4 text-left">
                                    <strong>Date</strong>
                                    <input type="text" class="form-control datepicker" data-bind="enable: !isMonthView(), value: date().toDateString()">
                                </div>
                                <div class="col-md-2 text-left">
                                    <strong>View</strong><br />
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default active" data-view="day" data-bind="click: toggleView, css: { 'active': viewType() == 'day' }">Day</button>
                                        <button type="button" class="btn btn-default" data-view="month" data-bind="click: toggleView, css: { 'active': viewType() == 'month' }">Month</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="paidActivities">
                        <div class="alert alert-warning">
                            <div class="row">
                                <div class="col-md-4 text-left">
                                    <strong>Select sport</strong>
                                    <select id="Select1" data-bind="options: activitiesFiltered, optionsText: 'name', optionsValue: 'id', value: activityId" class="form-control"></select>
                                </div>
                                <div class="col-md-2 col-md-offset-4 text-left">
                                    <strong>Date</strong>
                                    <input type="text" class="form-control datepicker" data-bind="enable: !isMonthView(), value: date().toDateString()">
                                </div>
                                <div class="col-md-2 text-left">
                                    <strong>View</strong><br />
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default active" data-view="day" data-bind="click: toggleView, css: { 'active': viewType() == 'day' }">Day</button>
                                        <button type="button" class="btn btn-default" data-view="month" data-bind="click: toggleView, css: { 'active': viewType() == 'month' }">Month</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php include('includes/basket.php'); ?>
                    
                    <div class="tab-pane" id="signIn" data-bind="with: signIn">
                        <div class="container">
                            <div class="col-md-5">
                               <div class="page-header">
                                   <h3>Sports Hub Account Required</h3>
                               </div>

                                <h4>Sign in with your Sports Hub Account</h4>

                                <form class="top-buffer-large" role="form">
                                  <div class="form-group" data-bind="css: { 'has-error': email.showError }">
                                    <label for="loginEmailAddress">Email address</label>
                                    <input type="email" class="form-control" id="loginEmailAddress" placeholder="Enter email" data-bind="value: email.value, valueUpdate: 'afterkeypress'">
                                  </div>
                                  <div class="form-group" data-bind="css: { 'has-error': password.showError }">
                                    <label for="loginPassword">Password</label>
                                    <input type="password" class="form-control" id="loginPassword" placeholder="Password" data-bind="value: password.value, valueUpdate: 'afterkeypress'">
                                  </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-default" data-bind="click: doLogin">Sign In</button>
                                        </div>

                                        <div class="col-md-6 text-right">
                                            <a href="#">Forgot password?</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-5 col-md-offset-2">
                                <div class="page-header no-border">
                                    &#160;
                                </div>

                                To be able to make bookings on the Sports Hub Portal you have to be registered user. If you already have an account sign in above. If you don't have an account you can register an account:
                            
                                <h4><a href="#">Register an acount here.</a></h4>
                            </div>
                        </div>

                        <div class="container" data-bind="if: wrongDetails">
                            <div class="bg-danger">
                                <i class="glyphicon glyphicon-exclamation-sign"></i> <h4>Wrong username or password.</h4>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="myBookings">
                        <div class="container">
                            <div class="page-header">
                                <h3>My Bookings</h3>
                            </div>

                            Cras justo odio, dapibus ac facilisis in, egestas eget quam. Maecenas faucibus mollis interdum. Aenean lacinia bibendum nulla sed consectetur.

                             <div class="page-header">
                                <h3>Classes and Facility bookings</h3>
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="images/basketball.jpg" class="img-responsive img-rounded" />
                                    </div>

                                    <div class="col-md-7">
                                        <h4>Basketball - Facility booking</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                Sports Hall - Hall 3
                                            </div>

                                            <div class="col-md-4 col-md-offset-1">
                                                1 hour
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                17 April 2014 at 5 pm
                                            </div>

                                            <div class="col-md-4 col-md-offset-1">
                                                Max 10 attendees
                                            </div>
                                        </div>

                                        <p class="top-buffer-large">
                                            <button class="btn btn-info">Download ticket</button> 
                                            <button class="btn btn-info" data-loading-text="Sending..." data-complete-text="Ticket sent!" data-bind="click: myBookings.sendToEmail">Send ticket to my email</button>
                                        </p>
                                    </div>
                                </div>

                                 <div class="row top-buffer-large">
                                     <div class="col-md-2">
                                         <img src="images/wateryoga.jpg" class="img-responsive img-rounded" />
                                     </div>

                                     <div class="col-md-7">
                                         <h4>Water yoga</h4>
                                         <div class="row">
                                            <div class="col-md-4">
                                                Aquatics center - Main pool
                                            </div>

                                            <div class="col-md-4 col-md-offset-1">
                                                1 hour
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                17 April 2014 at 5 pm
                                            </div>

                                            <div class="col-md-4 col-md-offset-1">
                                                2 spots
                                            </div>
                                        </div>

                                        <p class="top-buffer-large">
                                            <button class="btn btn-info">Download ticket</button> 
                                            <button class="btn btn-info" data-loading-text="Sending..." data-complete-text="Ticket sent!" data-bind="click: myBookings.sendToEmail">Send ticket to my email</button>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="page-header">
                                <h3>Valid entry tickets</h3>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <img src="images/pool1.jpg" class="img-responsive img-rounded" />
                                </div>

                                <div class="col-md-7">
                                    <h4>Aquatic Centre Entry Ticket</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Aquatic Centre
                                        </div>

                                        <div class="col-md-4 col-md-offset-1">
                                           Valid to 30 September 2013
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            Single entry for 2 persons
                                        </div>

                                        <div class="col-md-4 col-md-offset-1">
                                        
                                        </div>
                                    </div>

                                    <p class="top-buffer-large">
                                        <button class="btn btn-info">Download ticket</button> 
                                        <button class="btn btn-info" data-loading-text="Sending..." data-complete-text="Ticket sent!" data-bind="click: myBookings.sendToEmail">Send ticket to my email</button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="navbar navbar-fixed-bottom" data-bind="visible: basket.showTimer">
            <div class="text-center" >
                <h4>Time left to book: <span data-bind="timer: basket.timerValue"></span></h4>
            </div>
        </div>

        <div class="container bottom-buffer-large">
            <div id="calenderHolder">
                <div id='calendar'></div>
            </div>

            <div data-bind="if: showDayView">
                <div class="container top-buffer-large">
                    <div class="float-left box col-md-1 text-center">
                        <h2>{{ dayNumber }}</h2>
                        {{ month }}
                    </div>
                    <div class="col-md-3 text-left">
                        <h2>{{ day }}</h2>
                    </div>

                    <div class="col-md-4" data-bind="visible: !isMonthView()">
                        <div class="center-block">
                            <h3>
                                <a href="#" data-bind="click: goToPreviousDay, if: previousDay().length > 0"><i class="glyphicon glyphicon-chevron-left"></i>  {{ previousDay }}</a> 
                                &#160 &#160 &#160 &#160  
                                <a href="#" data-bind="click: goToNextDay, visible: nextDay().length > 0">{{ nextDay }} <i class="glyphicon glyphicon-chevron-right"></i></a>
                            </h3>
                        </div>
                    </div>
                </div>

                <div id="dayView" class="text-left top-buffer-large">
                    <div class="panel panel-default" data-bind="visible: activitiesInDay().length == 0 && !showPoolView()">
                        <div class="panel-body">
                            <div class="text-center">
                                <h4>No events available</h4>
                                (change date or check the monthly overview for upcoming events)
                            </div>
                        </div>
                    </div>

                    <div data-bind="foreach: activitiesInDay">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="text-right">
                                    <i class="glyphicon glyphicon-time"></i> {{ $root.getHourByDate($data[0].start) }}
                                </div>
                            </div>
                            <div class="panel-body">
                                <div data-bind="foreach: $data.display">
                                    <div class="row" data-bind="css: { 'bottom-buffer-line': $index() % 2 == 1 }">
                                        <div class="col-md-9">
                                            <div class="pull-left col-md-2" data-bind="if: $root.displayType() == 'events'">
                                                <img data-bind="attr: { src: imageLocation }" class="img-responsive img-rounded" alt="" />
                                            </div>

                                            <h4>{{ displayTitle }}</h4>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <i class="glyphicon glyphicon-map-marker"></i> {{ $root.getActivityName(start) }}
                                                </div>

                                                <div class="col-md-3">
                                                    <i class="glyphicon glyphicon-user"></i> {{ placesLeft }} Available Slots
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 text-right">
                                            <button class="btn btn-info" 
                                                data-bind="click: $root.basket.add, enable: $root.eventsCanBook">Book (free)</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer text-center" data-bind="visible: overLimit">
                                <a data-bind="text: showAll() ? 'Show Less' : 'Show More', click: $root.toggleShowAll" href="#"></a>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>

            <div data-bind="if: showPoolView">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div data-bind="template: { if: isTemplateLoaded, name: sportTemplate, foreach: timeTemplate.display }">
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="text-center" data-bind="visible: timeTemplate.overLimit">
                            <a data-bind="text: timeTemplate.showAll() ? 'Show Less' : 'Show More', click: $root.toggleShowAll" href="#"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include('/includes/footer.php'); ?>
</body>
</html>
