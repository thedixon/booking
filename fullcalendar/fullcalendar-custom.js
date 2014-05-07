window.sbs = window.sbs || {};

// Custom functions 
sbs.fullCalendarCustom = function () { }

sbs.fullCalendarCustom.prototype.setupKnockout = function () {
    var calendarScope = this;

    viewModel = function () {
        var self = this;

        customCalendar.setupData(this);

        this.currentSport = ko.observable();
        this.sportEventName = ko.observable();
        this.timeTemplate = ko.observableArray();
        this.timeTemplate.fullDisplay = ko.observableArray();
        this.timeTemplate.showAll = ko.observable(false);

        this.timeTemplate.overLimit = ko.computed(function() {
            return self.timeTemplate.fullDisplay().length > timeFilterLimit;
        }, self.timeTemplate);

        this.timeTemplate.display = ko.computed(function () {
            if (this.showAll()) { return this.fullDisplay(); }
            return this.fullDisplay.slice(0, timeFilterLimit);
        }, self.timeTemplate);

        this.sportTemplate = function () {
            var sport = self.currentSport();

            return sport && sport.template ? sport.template + "Template" : "defaultTemplate";
        }
        
        // Simply pointers to the the top-level arrays.
        function makeLanes(start, amount, lanesTaken) {
            var laneArray = [];

            for (var i = start; i <= start + amount; i++) {
                laneArray.push({
                    isBooked: (i < lanesTaken)
                });
            }

            return laneArray;
        }

        function showPools(val) {
            var sportsEvents = customCalendar.getEvents('sports');

            var swimmingBookings = customCalendar.getEvents('swimmingBookings', self.swimmingPoolSelected());

            self.timeTemplate.fullDisplay.removeAll();

            for (var i = 0; i < sportsEvents.length; i++) {
                if (val == sportsEvents[i].name) {
                    self.currentSport(sportsEvents[i]);
                    break;
                }
            }

            var startTime = Number(self.currentSport().startTime);
            var endTime = Number(self.currentSport().endTime);
            var incrament = Number(self.currentSport().increment);

            for (var i = startTime; i <= endTime; i += incrament) {
                var description = self.currentSport().laneAmount + " Lanes Available";
                var active = true;
                var currentLanesTaken = 0;
                var laneColumns = [];

                sportsDate = new Date(y, m, d, i);

                if (self.currentSport().name == "Swimming") {
                    for (var o = 0; o < swimmingBookings.length; o++) {
                        var swimmingBooking = swimmingBookings[o];

                        if (+new Date(swimmingBooking.start) === +sportsDate) {
                            currentLanesTaken = swimmingBooking.lanesTaken;

                            var laneAmount = (self.currentSport().laneAmount - swimmingBooking.lanesTaken);
                            description = laneAmount + " Lanes Available";

                            if (laneAmount == 0 || swimmingBooking.bookingNotAllowed) {
                                active = false;
                            }

                            // Break if item is found.
                            break;
                        } else {
                            currentLanesTaken = 0;
                        }
                    }
                }

                var divideAmount = (self.currentSport().laneAmount / 2);
                for (var o = 0; o < 2; o++) {
                    laneColumns.push({
                        lanes: makeLanes(divideAmount * o, divideAmount, currentLanesTaken)
                    });
                }

                var endDate = new Date();
                endDate.setHours(sportsDate.getHours() + incrament);
                var startTime = self.getHourByDate(new Date().setHours(i));

                self.timeTemplate.fullDisplay.push({
                    startHour: startTime,
                    fullTime: startTime + " - " + self.getHourByDate(endDate),
                    increment: incrament,
                    description: description,
                    linkActive: active,
                    showDetails: ko.observable(false),
                    laneColumns: laneColumns,
                    eventType: "swimming"
                });
            }
        }

        this.swimmingPoolSelected = ko.observable(1);
        this.swimmingPoolSelected.subscribe(function () {
            showPools(self.sportEventName());
        });

        this.sportEventName.subscribe(function (val) {
            showPools(val);
        });

        this.showSwimmingDetails = function (event, override) {
            event.showDetails(!event.showDetails());
        }

        this.toggleShowAll = function (event) {
            if (event.timeTemplate) {
                event.timeTemplate.showAll(!event.timeTemplate.showAll());
            } else {
                event.showAll(!event.showAll());
            }
        };

        this.activitiesFiltered = ko.computed(function () {
            var venueId = this.venueId();

            var activityListReturn = [];

            var activityList = ko.utils.arrayFirst(this.venues(), function (item) {
                return item.id == venueId;
            }).activities;

            for (var i = 0; i < activityList.length; i++) {
                activityListReturn.push(ko.utils.arrayFirst(this.activities(), function (item) {
                    return item.id == activityList[i];
                }));
            }

            return activityListReturn;
        }, this);
       
        this.showDayView = ko.observable(true);
        this.showPoolView = ko.observable(false);
        this.viewType = ko.observable("day");
        this.displayType = ko.observable("events");
        this.date = ko.observable(new Date());

        this.dayNumber = ko.computed(function () {
            return this.date().getDate();
        }, this);

        this.month = ko.computed(function () {
            return shortMonthNames[this.date().getMonth()];
        }, this);

        this.day = ko.computed(function () {
            return dayNames[this.date().getDay()];
        }, this);

        this.previousDay = ko.computed(function () {
            var theDate = this.date();
            var newDate = new Date(theDate.getFullYear(), theDate.getMonth(), theDate.getDate());

            newDate.setDate(theDate.getDate() - 1);

            return newDate.getDate() + " " + shortMonthNames[newDate.getMonth()];
        }, this);

        this.goToPreviousDay = function () {
            var previousDay = this.date();
            previousDay.setDate(previousDay.getDate() - 1);
            this.date(previousDay);
        }

        this.nextDay = ko.computed(function () {
            var theDate = this.date();
            var newDate = new Date(theDate.getFullYear(), theDate.getMonth(), theDate.getDate());

            newDate.setDate(theDate.getDate() + 1);
            
            if (this.displayType() == "swimmingPool") {
                var futureDate = new Date();
                futureDate.setDate(futureDate.getDate() + swimmingDaysShown);

                var diffDays = Math.round(Math.abs((theDate.getTime() - futureDate.getTime()) / (oneDay)));
                if (diffDays == 0) {
                    return "";
                }
            }

            return newDate.getDate() + " " + shortMonthNames[newDate.getMonth()];
        }, this);

        this.goToNextDay = function () {
            var nextDay = this.date();
            nextDay.setDate(nextDay.getDate() + 1);
            this.date(nextDay);
        }

        this.getHourByDate = function (date) {
            var hours = new Date(date).getHours();

            var suffix = (hours >= 12) ? 'pm' : 'am';

            hours = (hours > 12) ? hours - 12 : hours;

            hours = (hours == '00') ? 12 : hours;

            return (!date.allDay ? hours + suffix : "All day");
        };

        this.getActivityName = function (event) {
            if (self.venues()[event.venueId]) {
                return self.venues()[event.venueId].name;
            }

            return "No venue";
        }

        this.toggleView = function (e, sender) {
            var element = $(sender.currentTarget);
            var viewType = element.data("view");

            if (viewType == "month") {
                this.showDayView(false);
                this.showPoolView(false);

                $('#calenderHolder').show();
                calendar.fullCalendar('changeView', viewType);
            } else {
                this.showDayView(true);

                $('#calenderHolder').hide();
            }

            this.viewType(viewType);
        }

        this.eventsCanBook = function () {
            var futureDate = new Date(currentDate.getYear(), currentDate.getMonth(), currentDate.getDate() + eventsNotAllowedToBookFor, 0, 0, 0);
            var diffDays = Math.round(Math.abs((futureDate.getTime() - self.date().getTime()) / (oneDay)));
            
            //console.log(diffDays);
            return false;
        };

        this.swimmingCanBook = function () {

        }

        this.changePoolType = function (val) {
            var bookings = customCalendar.getEvents("swimmingBookings");

            var filteredBookings = _.filter(bookings, function (booking) {
                return booking.poolId == val;
            });

            self.timeTemplate(filteredBookings);
        };

        this.isMonthView = ko.computed(function () {
            return this.viewType() == "month";
        }, this);


        this.formatToPrice = function (price) {
            return price.toFixed(2);
        };

        this.signIn = {
            email: { 
                value: ko.observable(''),
                showError: ko.observable(false)
            },
            password: {
                value: ko.observable(''),
                showError: ko.observable(false)
            },
            wrongDetails: ko.observable(false),
            goTo: function () {
                $('#tabs li:eq(4) a').tab('show');
                self.showDayView(false);
                self.viewType("day");
                $('#calenderHolder').hide();
            },
            doLogin: function () {
                if (self.signIn.email.value() == "") {
                    self.signIn.email.showError(true);
                }

                if (self.signIn.password.value() == "") {
                    self.signIn.password.showError(true);
                }
            }
        }

        this.signIn.email.value.subscribe(function (val) {
            self.signIn.email.showError(val != "");
        });

        this.signIn.password.value.subscribe(function (val) {
            self.signIn.password.showError(val != "");
        });

        this.myBookings = {
            sendToEmail: function (a,b) {
                var btn = $(b.currentTarget);

                btn.button('loading');

                setTimeout(function() {
                    btn.button('complete');

                    setTimeout(function () {
                        btn.addClass("disabled");
                    }, 10)
                }, 5000);
            }
        }

        customCalendar.setupActivityVM(this, calendarScope);
        customCalendar.setupBasketVM(this);
    };

    ko.punches.interpolationMarkup.enable();

    globalVM = new viewModel();

    ko.applyBindings(globalVM);
}



sbs.fullCalendarCustom.prototype.groupType = function (eventSources, type) {
    var newSource = [];
    var dateCounters = [];

    for (var i = 0; i < eventSources.length; i++) {
        var eventSource = eventSources[i];

        var eventDate = new Date(eventSource.start).toDateString();
        if (dateCounters[eventDate]) {
            var foundElement = _.find(newSource, function (data) {
                return new Date(data.start).toDateString() == new Date(dateCounters[eventDate].start).toDateString();
            });
    
            foundElement.count += 1;
            foundElement.title = foundElement.count + " <span class='hide-mobile'>" + (type == "Activity" ? "Activities" : type + "s") + "</span>";
        } else {
            dateCounters[eventDate] = eventSource;
            dateCounters[eventDate].count = 1;
            dateCounters[eventDate].title = "1 <span class='hide-mobile'>" + type + "</span>";
            newSource.push(dateCounters[eventDate]);
        }
    }

    return newSource;
}

sbs.fullCalendarCustom.prototype.getEvents = function (displayType, filter) {
    switch (displayType) {
        case "events":
            return this.calendarEvents;
            break;
        case "activities":
            return this.calendarActivities;
            break;
        case "sports":
            return this.sportsEvents;
            break;
        case "swimmingBookings":
            return _.filter(this.swimmingBookings, function (booking) {
                return booking.poolId == filter;
            });

            break;
    }
}

$(function () {
    $('#loader').show();

    customCalendar = new sbs.fullCalendarCustom();

    customCalendar.loadData().then(function () {
        
        customCalendar.setupKnockout();
        customCalendar.setupEvents();
        customCalendar.loadTemplates();

        currentEventSource = customCalendar.getEvents('events');
        currentEventSource = customCalendar.groupType(currentEventSource, "Event");

        

        calendar = $("#calendar");

        setTimeout(function () {
            $('.loader').removeClass("active").hide();
            $('#main').show();

            $("#calendar").fullCalendar({
                header: {
                    left: "1",
                    center: "title",
                    right: "1"
                },
                titleFormat: (calendarSmallDateFormat ? "MMMM" : "MMMM, yyyy"),
                timeFormat: '',
                defaultView: "month",
                selectable: true,
                selectHelper: true,
                eventClick: function (calEvent, jsEvent, view) {
                    globalVM.showDayView(true);
                    globalVM.date(calEvent.start);

                    $('#dayView').scrollView();

                },
                firstDay: 1,
                editable: true,
                eventSources: [
                    currentEventSource
                ]
            });

            $('#calenderHolder').hide();

            // These events need to go here, after the calendar is initialised.
            $('.previousCalendarMonth').on("click", function () {
                calendar.fullCalendar('prev');
            });

            $('.nextCalendarMonth').on("click", function () {
                calendar.fullCalendar('next');
            });
        }, 2000);

        

        // First load only
        if (globalVM.venueId() > 0) {
            History.pushState({ state: 1 }, "Activities", "?action=activities");
        }

        if (querystring("action") == "") {
            History.pushState({ state: 0 }, "Events", "?action=events");
        } else {
            if (querystring("action") == "myBookings") {
                globalVM.showDayView(false);
            }

            $('#tabs li[data-displaytype=' + querystring("action") + '] a').tab('show');
        }

        History.Adapter.bind(window, 'statechange', function () { // Note: We are using statechange instead of popstate
            var State = History.getState(); // Note: We are using History.getState() instead of event.state

            if (State.data.state == 3) {
                globalVM.basket.showPayment(false);
            } else if (State.data.state == 5) {
                globalVM.basket.showPayment(true);
            }

            $('#tabs li:eq(' + State.data.state + ') a').tab('show');
        });
    });
    
});
