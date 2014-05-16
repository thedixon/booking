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
                    <div class="tab-pane" id="basket" data-bind="with: basket">
                        <div class="container bottom-buffer-large">
                            <!-- ko if: items().length == 0 && !payment.showThankYou() && !payment.showFailure() -->
                                <div class="panel panel-default">
                                    <div class="panel-body text-center">
                                        <h4>Sorry!</h4>
                                        You have no items added to your basket. Please go back and add some.
                                    </div>
                                </div>
                            <!-- /ko -->

                            <!-- ko if: items().length > 0 -->
                                <!-- ko if: !showPayment() && !payment.showThankYou() && !payment.showFailure() -->
                                <div class="col-md-5">
                                    <div class="page-header">
                                        <h3>Booking Detail</h3>
                                    </div>
                                    <div data-bind="foreach: items">
                                        <div class="bottom-border-line">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <strong>Item {{ $index() + 1 }}</strong>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-info btn-sm" data-bind="click: remove">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bottom-buffer-large">
                                            <div class="row top-buffer ">
                                                <div class="col-md-3">Type</div>
                                                <div class="col-md-9 text-right">{{ title }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Activity</div>
                                                <div class="col-md-9 text-right">{{ activityName }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Price</div>
                                                <div class="col-md-9 text-right">{{ $root.formatToPrice(price) }} SGD</div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <h4 class="bottom-border-line top-border-line">Maximum participants</h4>

                                    <div class="row bottom-border-line">
                                        <div class="col-md-3"><h3>Charge</h3></div>
                                        <div class="col-md-9 text-right"><h3>{{ $root.formatToPrice(total()) }} SGD</h3></div>
                                    </div>

                                    <div class="top-buffer-large">
                                        If you only want to book this activity, agree to the terms and confirm your booking.
                                    </div>

                                    <div class="row top-buffer-large">
                                        <div class="col-md-12">
                                            <input type="checkbox" data-bind="checked: agreedToTerms" /> Agree to the <a href="#">terms and conditions</a>
                                        </div>
                                    </div>

                                    <div class="top-buffer-large" data-bind="if: notAgreedToTerms">
                                        <p class="bg-danger">
                                            <i class="glyphicon glyphicon-exclamation-sign"></i> You must agree to the terms and conditions before continuing.
                                        </p>
                                    </div>

                                    <div class="row top-buffer-large">
                                        <div class="col-md-4">
                                            <button class="btn btn-success" data-bind="click: confirm">Confirm Booking</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-info" data-bind="click: clearBasket">Cancel</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5 col-md-offset-2">
                                    <div class="page-header no-border">
                                        &#160;
                                    </div>
                                    <div class="row">
                                        If you would like to add more bookings before you confirm you can add
                                        it to your booking cart and continue browsing for more activities.
                                    </div>

                                    <div class="row top-buffer-large">
                                        <h4>Promotion code</h4>
                                        If you have a promotion code enter it in the input field below

                                        <div class="row top-buffer-large">
                                            <div class="col-md-2">
                                                Code
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" />
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-info" data-bind="click: checkCode">Check Code</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /ko -->

                                <!-- ko if: showPayment -->
                                    <div class="page-header">
                                        <h3>Payment Information</h3>
                                    </div>
                                
                                    <div class="col-md-5" data-bind="with: payment">
                                    <form role="form">
                                          <div class="form-group">
                                             <label for="paymentCardType">Select credit card type</label>
                                             <select id="paymentCardType" class="form-control">
                                                 <option>Credit card type</option>
                                                 <option>VISA Debit</option>
                                             </select>
                                          </div>
                                          <div class="form-group" data-bind="css: { 'has-error': cardName.showError }">
                                             <label for="paymentCardName">Name on the card</label>
                                             <input id="paymentCardName" type="text" class="form-control" data-bind="value: cardName.value, valueUpdate: 'afterkeypress'" />
                                          </div>
                                          <div class="form-group" data-bind="css: { 'has-error': cardNumber.showError }">
                                             <label for="paymentCardNumber">Credit card number</label>
                                             <input id="paymentCardNumber" type="text" class="form-control" data-bind="value: cardNumber.value, valueUpdate: 'afterkeypress'" />
                                          </div>
                                          <div class="form-group">
                                             <label for="paymentExpirationDateMonth">Expiration date</label>
                                             <div class="row">
                                                 <div class="col-md-5">
                                                      <select id="paymentExpirationDateMonth" class="form-control">
                                                          <option>01</option>
                                                      </select>
                                                  </div>
                                                  <div class="col-md-5 col-md-offset-2">
                                                      <select id="paymentExpirationDateYear" class="form-control">
                                                          <option>2014</option>
                                                      </select>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="form-group" data-bind="css: { 'has-error': ccv.showError }">
                                             <label for="paymentCCV">CCV</label>
                                             <input id="paymentCCV" type="text" class="form-control" data-bind="value: ccv.value, valueUpdate: 'afterkeypress'" />
                                          </div>
                                          <div class="row">
                                             <div class="col-md-6">
                                                <button type="submit" class="btn btn-default"  data-bind="click: doPayment">Submit Payment</button>
                                             </div>

                                              <div class="col-md-6 text-right">
                                                <button type="submit" class="btn btn-default" data-bind="click: cancel">Cancel</button>
                                             </div>
                                           </div>
                                        </form>
                                    </div>
                                <!-- /ko -->
                            <!-- /ko -->

                            <!-- ko if: payment.showThankYou -->
                                <div class="page-header">
                                    <h3>Payment was successful!</h3>
                                </div>
                                
                                <div class="col-md-5">
                                    We have confirmed the following bookings in our system:

                                    <div class="top-buffer-large">
                                        <div class="panel panel-default grey-bg">
                                          <div class="panel-body">
                                              <div class="bottom-border-line-grey">
                                                  <h4>Basketball facility booking</h4>
                                                  Sports hall 3
                                                  <div class="row">
                                                      <div class="col-md-7">
                                                          17 April 2014 5 pm - 6 pm
                                                      </div>
                                                      <div class="col-md-5 text-right">
                                                          Charge: <strong>X SGD</strong>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="bottom-border-line-grey">
                                                  <h4>Basketball facility booking</h4>
                                                  Sports hall 3
                                                  <div class="row">
                                                      <div class="col-md-7">
                                                          17 April 2014 5 pm - 6 pm
                                                      </div>
                                                      <div class="col-md-5 text-right">
                                                          Charge: <strong>X SGD</strong>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div>
                                                  <h4>Basketball facility booking</h4>
                                                  Sports hall 3
                                                  <div class="row">
                                                      <div class="col-md-7">
                                                          17 April 2014 5 pm - 6 pm
                                                      </div>
                                                      <div class="col-md-5 text-right">
                                                          Charge: <strong>X SGD</strong>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="page-header no-border">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3>Total charge: </h3> 
                                            </div>

                                            <div class="col-md-6 text-right">
                                                <h3 class="">X SGD</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5 col-md-offset-2">
                                    <h4>Tickets</h4>
                                    Tickets will be sent to your registered email. You can also view your booking and print out tickets under the my bookings sections.

                                    <div class="top-buffer-large">
                                        <button class="btn btn-info">View my bookings</button>
                                    </div>
                                </div>
                            <!-- /ko -->

                            <!-- ko if: payment.showFailure -->
                                <div class="page-header">
                                    <h3>Payment failed</h3>
                                </div>

                                We were unable to process the payment with the credit card you provided.
                               
                                <div class="top-buffer-large">
                                    <h4>The following error occured:</h4>
                                    Aenean lacinia bibendum nulla sed consectetur. Maecenas sed diam eget risus varius blandit sit amet non magna.
                                </div>
                                
                                <div class="top-buffer-large">
                                    <button class="btn btn-info">Try again</button>
                                </div>
                            <!-- /ko -->
                        
                        </div>
                    </div>
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