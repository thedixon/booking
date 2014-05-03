// Variables for cache
var calendar;
var customCalendar;
var currentEventSource;
var datePicker;
var viewModel;
var globalVM;
var dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var shortMonthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
var currentDate = new Date();
var d = currentDate.getDate();
var m = currentDate.getMonth();
var y = currentDate.getFullYear();
var cachedEvents = [];
var cachedActivities = [];

// Calendar options
var calendarSmallDateFormat = true;

// Filters for show/hide
var filterLimit = 1;
var timeFilterLimit = 6;

// Timer
var timerMinutes = 2;
var secondsUntilBasketWarning = 30;

window.sbs = window.sbs || {};

// Custom functions 
sbs.fullCalendarCustom = function () { }

sbs.fullCalendarCustom.prototype.setupKnockout = function () {
    var calendarScope = this;

    viewModel = function () {
        var self = this;

        this.venueId = ko.observable(querystring('venueId') ? querystring('venueId') : 0);
        this.venues = ko.observableArray([
            {
                name: 'All Venues',
                id: 0,
                activities: [0]
            },
            {
                name: 'Aquatic Centre',
                id: 1,
                activities: [1,2,3]
            },
            {
                name: 'Sports Halls',
                id: 2,
                activities: [4, 5]
            },
            {
                name: 'Waterfront',
                id: 3,
                activities: [5]
            },
            {
                name: 'Sports Museum Library',
                id: 4,
                activities: [1]
            }
        ]);

        this.activityId = ko.observable(querystring('activityId') ? querystring('activityId') : 0);
        this.activities = ko.observableArray([
            { name: 'All Activities', id: 0 },
            { name: 'Swimming', id: 1 },
            { name: 'Group training', id: 2 },
            { name: 'Facility booking', id: 3 },
            { name: 'Venue tours', id: 4 },
            { name: 'Community area', id: 5 }
        ]);

        this.eventTypeId = ko.observable(0);
        this.eventTypes = ko.observableArray([
            { name: 'All Events', id: 0 },
            { name: 'Experience Sports', id: 1 },
            { name: 'Play @ Sports Hub', id: 2 },
            { name: 'Sports Development', id: 3 }
        ]);

        this.poolTypeId = ko.observable(0);
        this.poolTypes = ko.observableArray([
            { name: 'Main', id: 1 },
            { name: 'Training', id: 2 },
            { name: 'Diving', id: 3 }
        ]);

        this.currentSport;
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
            return self.currentSport.template ? self.currentSport.template + "Template" : "defaultTemplate";
        }
        
        // Simply pointers to the the top-level arrays.
        var sportsEvents = customCalendar.getEvents('sports');
        var swimmingBookings = customCalendar.getEvents('swimmingBookings');

        var sportsDate = new Date();
        
        function makeLanes(start, amount, lanesTaken) {
            var laneArray = [];

            for (var i = start; i <= start + amount; i++) {
                laneArray.push({
                    isBooked: (i < lanesTaken)
                });
            }

            return laneArray;
        }

        this.sportEventName.subscribe(function (val) {
            self.timeTemplate.fullDisplay.removeAll();

            for (var i = 0; i < sportsEvents.length; i++) {
                if (val == sportsEvents[i].name) {
                    self.currentSport = sportsEvents[i];
                    break;
                }
            }

            for (var i = self.currentSport.startTime; i <= self.currentSport.endTime; i += self.currentSport.increment) {
                var description = self.currentSport.laneAmount + " Lanes Available";
                var active = true;
                var currentLanesTaken = 0;
                var laneColumns = [];

                sportsDate = new Date(y, m, d, i);

                if (self.currentSport.name == "Swimming") {
                    for (var o = 0; o < swimmingBookings.length; o++) {
                        var swimmingBooking = swimmingBookings[o];

                        if (+swimmingBooking.start === +sportsDate) {
                            currentLanesTaken = swimmingBooking.lanesTaken;

                            var laneAmount = (self.currentSport.laneAmount - swimmingBooking.lanesTaken);
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

                var divideAmount = (self.currentSport.laneAmount / 2);
                for (var o = 0; o < 2; o++) {
                    
                    laneColumns.push({
                        lanes: makeLanes(divideAmount * o, divideAmount, currentLanesTaken)
                    });
                }

                var endDate = new Date();
                endDate.setHours(sportsDate.getHours() + self.currentSport.increment);
                var startTime = self.getHourByDate(new Date().setHours(i));

                self.timeTemplate.fullDisplay.push({
                    startHour: startTime, 
                    fullTime: startTime + " - " + self.getHourByDate(endDate),
                    increment: self.currentSport.increment,
                    description: description,
                    linkActive: active,
                    showDetails: ko.observable(false),
                    laneColumns: laneColumns,
                    eventType: "swimming"
                })
            }
    
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

        this.activitiesFiltered = ko.computed(function() {
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

                $('#calenderHolder').show();
                calendar.fullCalendar('changeView', viewType);
            } else {
                this.showDayView(true);

                $('#calenderHolder').hide();
            }

            this.viewType(viewType);
        }

        this.activitiesInDay = ko.computed(function () {
            var displayType = this.displayType();
            var theDate = this.date();
            var events = calendarScope.getEvents(displayType);
            var venueId = this.venueId();
            var activityId = this.activityId();
            var eventTypeId = this.eventTypeId();
            var filteredEvents;

            // Filter events by current date
            switch (displayType) {
                case "events":
                    if (cachedEvents[theDate + "_" + eventTypeId]) {
                        return cachedEvents[theDate + "_" + eventTypeId];
                    }

                    filteredEvents = _.filter(events, function (event) {
                        return new Date(event.start).toDateString() == theDate.toDateString() &&
                            (eventTypeId > 0 ? event.eventTypeId == eventTypeId : true);
                    });
                    break;
                case "activities":
                    if (cachedActivities[theDate + "_" + venueId + "_" + activityId]) {
                        return cachedActivities[theDate + "_" + venueId + "_" + activityId];
                    }

                    filteredEvents = _.filter(events, function (event) {
                        return new Date(event.start).toDateString() == theDate.toDateString() &&
                            (venueId > 0 ? event.venueId == venueId : true) &&
                            (activityId > 0 ? event.activityId == activityId : true);
                    });

                    break;
            }

            // Group the filtered events by time.
            var groupedEvents = _.groupBy(filteredEvents, function (event) {
                var thisDate = new Date(event.start);
                return thisDate.getHours();
            });

            for (key in groupedEvents) {
                var groupedEvent = groupedEvents[key];

                groupedEvent.fullDisplay = groupedEvent;
                groupedEvent.showAll = ko.observable(false);
                groupedEvent.overLimit = groupedEvent.fullDisplay.length > filterLimit;
                groupedEvent.display = ko.computed(function () {
                    if (this.showAll()) { return this.fullDisplay; }
                    return this.fullDisplay.slice(0, filterLimit);
                }, groupedEvent);
            }

            var makeArray = _.toArray(groupedEvents);

            switch (displayType) {
                case "events":
                    cachedEvents[theDate + "_" + eventTypeId] = makeArray;

                    break;
                case "activities":
                    cachedActivities[theDate + "_" + venueId + "_" + activityId] = makeArray;
                    break;
            }

            return makeArray;
        }, this);

        this.changePoolType = function () {

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

        customCalendar.setupBasketVM(this);
    };

    ko.punches.interpolationMarkup.enable();

    globalVM = new viewModel();

    ko.applyBindings(globalVM);
}

function changeDisplayType(displayType) {
    calendar.fullCalendar('removeEventSource', currentEventSource);

    switch (displayType) {
        case "events":
            globalVM.showPoolView(false);
            globalVM.showDayView(true);

            currentEventSource = customCalendar.groupType(customCalendar.getEvents("events"), "Event");

            calendar.fullCalendar('addEventSource', currentEventSource);
            break;
        case "activities":
            globalVM.showPoolView(false);
            globalVM.showDayView(true);

            currentEventSource = customCalendar.groupType(customCalendar.getEvents("activities"), "Activity");

            calendar.fullCalendar('addEventSource', currentEventSource);
            break;
        case "swimmingPool":
            globalVM.showPoolView(true);
            globalVM.showDayView(true);
            globalVM.viewType('day');
            $('#calenderHolder').hide();

            if (globalVM.sportEventName() != "Swimming") {
                globalVM.sportEventName('Swimming');
            }

            break;
        case "basket":
            globalVM.showPoolView(false);
            globalVM.showDayView(false);
            $('#calenderHolder').hide();
    }

    globalVM.displayType(displayType);
}

sbs.fullCalendarCustom.prototype.setupEvents = function () {
    $(".datepicker").datepicker({
        minDate: 0,
        onSelect: function (e) {
            globalVM.date(new Date(e));

            if (globalVM.isMonthView()) {
                calendar.fullCalendar('gotoDate', new Date(e));
            }
        }
    });

    $('#tabs a').click(function (e) {
        e.preventDefault();

        $(this).tab('show');
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        changeDisplayType($(this).data("displaytype"));

        History.pushState({ state: $(this).data("state") }, $(this).data("title"), "?action=" + $(this).data("displaytype"));
    })

    $('.btn').button();
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

sbs.fullCalendarCustom.prototype.getEvents = function (displayType) {
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
            return this.swimmingBookings;
            break;
    }
}

$(function () {
    customCalendar = new sbs.fullCalendarCustom();

    customCalendar.loadData();
    customCalendar.setupKnockout();
    customCalendar.setupEvents();

    currentEventSource = customCalendar.getEvents('events');
    currentEventSource = customCalendar.groupType(currentEventSource, "Event");
    
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

    calendar = $("#calendar");

    $('#calenderHolder').hide();

    // These events need to go here, after the calendar is initialised.
    $('.previousCalendarMonth').on("click", function () {
        calendar.fullCalendar('prev');
    });

    $('.nextCalendarMonth').on("click", function () {
        calendar.fullCalendar('next');
    });

    

    if (querystring("action") == "") {
        History.pushState({ state: 0 }, "Events", "?action=events");
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

    // First load only
    if (globalVM.venueId() > 0) {
        History.pushState({ state: 1 }, "Activities", "?action=activities");
    }
});
