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
    <script src='./lib/jquery.cookie.js'></script>
    <script src="./lib/bootstrap.js"></script>
    <script src='./lib/history.js'></script>
    <script src='./lib/history.adapter.js'></script>
    <script src='./lib/knockout-3.1.0.js'></script>
    <script src='./lib/knockout.punches.js'></script>
    <script src='./lib/underscore.js'></script>
    <script src='./fullcalendar/fullcalendar.js'></script>
    <script src='./js/custom-functions.js'></script>
    <script src='./js/main.js'></script>
    <script src='./js/shared.js'></script>
    <script src='./js/basket.js'></script>
    <script src='./js/loaddata.js'></script>

    <title></title>
</head>

<body>
    <?php include('/includes/header.php'); ?>

    <?php include('/includes/modals.php'); ?>

    <div id="main" style="display: none">
        <div class="container">
            <div id="tabs">
                <ul class="nav nav-tabs">
                    <li class="active" data-displaytype="events">
                        <a href="#events" data-toggle="tab" data-displaytype="events" data-state="0" data-title="Events">Events</a>
                    </li>
                    <li data-displaytype="activities">
                        <a href="#activities" data-toggle="tab" data-displaytype="activities" data-state="1" data-title="Activities">Activities</a>
                    </li>
                    <li data-displaytype="swimmingPool">
                        <a href="#swimmingPool" data-toggle="tab" data-displaytype="swimmingPool" data-state="2" data-title="Swimming Pool">Swimming Pool</a>
                    </li>
                    <li class="pull-right" data-displaytype="basket"><a href="#basket" data-toggle="tab" data-displaytype="basket" data-state="3" data-title="Basket">
                        <i class="glyphicon glyphicon-shopping-cart"></i>  Bookings {{ basket.countDisplay }}</a>
                    </li>
                    <li style="display: none" data-displaytype="signIn">
                        <a href="#signIn" data-displaytype="signIn" data-state="4" data-title="Sign In">Sign In</a>
                    </li>
                    <li style="display: none" data-displaytype="myBookings">
                        <a href="#myBookings" data-displaytype="myBookings" data-state="6" data-title="My Bookings">My Bookings</a>
                    </li>
                </ul>
                <div class="tab-content top-buffer-large">
                    <div class="tab-pane active" id="events">
                        <div class="alert alert-warning">
                            <div class="row">
                                <div class="col-md-4 text-left">
                                    <strong>Event Type</strong>
                                    <select data-bind="options: eventTypes, optionsText: 'name', optionsValue: 'id', value: eventTypeId" class="form-control"></select>
                                </div>
                                <div class="col-md-2 text-left">
                                    <strong>Date</strong>
                                    <input type="text" class="form-control datepicker" data-bind="enable: !isMonthView(), value: date().toDateString()">
                                </div>
                                <div class="col-md-2 col-md-offset-4 text-left">
                                    <strong>View</strong><br />
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default active" data-view="day" data-bind="click: toggleView, css: { 'active': viewType() == 'day' }">Day</button>
                                        <button type="button" class="btn btn-default" data-view="month" data-bind="click: toggleView, css: { 'active': viewType() == 'month' }">Month</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="activities">
                        <div class="alert alert-warning">
                            <div class="row">
                                <div class="col-md-4 text-left">
                                    <strong>Venue</strong>
                                    <select data-bind="options: venues, optionsText: 'name', optionsValue: 'id', value: venueId" class="form-control"></select>
                                </div>
                                <div class="col-md-4 text-left">
                                    <strong>Activity</strong>
                                    <select data-bind="options: activitiesFiltered, optionsText: 'name', optionsValue: 'id', value: activityId" class="form-control"></select>
                                </div>
                                <div class="col-md-2 text-left">
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
                    <div class="tab-pane" id="swimmingPool">
                        <div class="alert alert-warning">
                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <strong class="select-pool">Select Pool</strong>
                                    <select data-bind="options: poolTypes, optionsText: 'name', optionsValue: 'id', value: swimmingPoolSelected" class="form-control"></select>
                                </div>

                                <div class="col-md-2 text-left">
                                    <strong>Date</strong>
                                    <input type="text" class="form-control datepicker poolDatePicker" data-bind="enable: !isMonthView(), value: date().toDateString()">
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

                            <div data-bind="foreach: myBookings.items">
                                <div class="page-header">
                                    <h3>{{title}}</h3>
                                    <!-- ko foreach: bookings -->
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img data-bind="attr: { 'src': imageLocation }" class="img-responsive img-rounded" />
                                            </div>

                                            <div class="col-md-7">
                                            <h4>{{ description }}</h4>
                                            <div class="row">
                                                <div class="col-md-4">
                                                   {{ location }}
                                                </div>

                                                <div  data-bind="if: $data.time">
                                                    <div class="col-md-4 col-md-offset-1">
                                                        {{ time }}
                                                    </div>
                                                </div>

                                                <div data-bind="if: $data.valid">
                                                    <div class="col-md-4 col-md-offset-1">
                                                        {{ valid }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div data-bind="if: $data.date">
                                                    <div class="col-md-4">
                                                        {{ date }}
                                                    </div>
                                                </div>

                                                <div data-bind="if: $data.attendees">
                                                    <div class="col-md-4 col-md-offset-1">
                                                        {{ attendees }}
                                                    </div>
                                                </div>

                                                <div data-bind="if: $data.entry">
                                                    <div class="col-md-4">
                                                        {{ entry }}
                                                    </div>
                                                </div>
                                            </div>

                                            <p class="top-buffer-large">
                                                <button class="btn btn-info">Download ticket</button> 
                                                <button class="btn btn-info" data-loading-text="Sending..." data-complete-text="Ticket sent!" data-bind="click: myBookings.sendToEmail">Send ticket to my email</button>
                                            </p>
                                        </div>
                                    </div>
                                    <!-- /ko -->
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
                                            <div class="pull-left col-md-2" data-bind="if: $root.displayType() == 'events' && imageLocation.length > 0">
                                                <img data-bind="attr: { src: imageLocation }" class="img-responsive img-rounded" alt="" />
                                            </div>

                                            <h4>{{ displayTitle }}</h4>

                                            <!-- ko if: $root.displayType() == 'activities' -->
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <i class="glyphicon glyphicon-map-marker"></i> {{ $root.getActivityName(start) }}
                                                </div>

                                                <div class="col-md-3">
                                                    <i class="glyphicon glyphicon-user"></i> {{ placesLeft }} Available Slots
                                                </div>
                                            </div>
                                            <!-- /ko -->

                                            <!-- ko if: $root.displayType() == 'events' -->
                                            <div class="row">
                                                <div class="pull-left">
                                                    {{ shortDescription }}
                                                </div>
                                            </div>
                                            <!-- /ko -->
                                        </div>

                                        <div class="col-md-3 text-right">
                                            <button class="btn btn-info more-info" data-bind="click: $root.showMoreInfo">More Info</button>
                                            <button class="btn btn-info" 
                                                data-bind="text: $root.displayType() == 'activities' ? 'Book' : 'Buy Tickets',
                                                           enable: !HasBeenBooked() && $root.eventsCanBook(), click: $root.basket.add">Book</button>
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
