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
var oneDay = 24 * 60 * 60 * 1000;
var sportsDate = new Date();

// Calendar options
var calendarSmallDateFormat = true;

// Filters for show/hide
var filterLimit = 1;
var timeFilterLimit = 6;

// Timer
var timerMinutes = 2;
var secondsUntilBasketWarning = 30;

// Further options
var swimmingDaysShown = 7;
var eventsNotAllowedToBookFor = 2;

window.sbs = window.sbs || {};

sbs.fullCalendarCustom.prototype.loadTemplates = function (templatesLoaded) {
    var loadTemplateCollection = function (file, success) {
        $.get('/templates/' + file + '.html', function (templates) {
            $('body').append('<div style="display:none">' + templates + '<\/div>');
            success();
        });
    };

    // Load all templates
    function load() {
        return $.Deferred(function () {
            var self = this;

            loadTemplateCollection('all', function () {
                self.resolve();
            });
        });
    }

    function done() {
        templatesLoaded(true);
    }

    return $.when(load())
            .done(done);
}

// Load data
sbs.fullCalendarCustom.prototype.setupData = function (vm) {
    vm.isTemplateLoaded = ko.observable(false);

    vm.venueId = ko.observable(querystring('venueId') ? querystring('venueId') : 0);
    vm.venues = ko.observableArray([
        {
            name: 'All Venues',
            id: 0,
            activities: [0]
        },
        {
            name: 'Aquatic Centre',
            id: 1,
            activities: [1, 2, 3]
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

    vm.activityId = ko.observable(querystring('activityId') ? querystring('activityId') : 0);
    vm.activities = ko.observableArray([
        { name: 'All Activities', id: 0 },
        { name: 'Swimming', id: 1 },
        { name: 'Group training', id: 2 },
        { name: 'Facility booking', id: 3 },
        { name: 'Venue tours', id: 4 },
        { name: 'Community area', id: 5 }
    ]);

    vm.eventTypeId = ko.observable(0);
    vm.eventTypes = ko.observableArray([
        { name: 'All Events', id: 0 },
        { name: 'Experience Sports', id: 1 },
        { name: 'Play @ Sports Hub', id: 2 },
        { name: 'Sports Development', id: 3 }
    ]);

    vm.poolTypeId = ko.observable(0);
    vm.poolTypes = ko.observableArray([
        { name: 'Main', id: 1 },
        { name: 'Training', id: 2 },
        { name: 'Diving', id: 3 }
    ]);
}

sbs.fullCalendarCustom.prototype.setupUtilityFunctions = function (vm, scope) {
    vm.showDayView = ko.observable(true);
    vm.showPoolView = ko.observable(false);
    vm.viewType = ko.observable("day");
    vm.displayType = ko.observable("events");

    vm.getActivityName = function (event) {
        if (vm.venues()[event.venueId]) {
            return vm.venues()[event.venueId].name;
        }

        return "No venue";
    }

    vm.toggleView = function (e, sender) {
        var element = $(sender.currentTarget);
        var viewType = element.data("view");

        if (viewType == "month") {
            vm.showDayView(false);
            vm.showPoolView(false);

            $('#calenderHolder').show();
            scope.fullCalendar('changeView', viewType);
        } else {
            vm.showDayView(true);

            $('#calenderHolder').hide();
        }

        this.viewType(viewType);
    }

    vm.eventsCanBook = function () {
        var newDate = vm.date();
        var futureDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate() + eventsNotAllowedToBookFor, 0, 0, 0);
        var todayDate = new Date(newDate.getFullYear(), newDate.getMonth(), newDate.getDate());
        var diffDays = ((todayDate - futureDate) / (oneDay)) + 2;

        return (diffDays >= eventsNotAllowedToBookFor);
    };

    vm.isMonthView = ko.computed(function () {
        return vm.viewType() == "month";
    }, vm);


    vm.formatToPrice = function (price) {
        return price.toFixed(2);
    };

    vm.toggleShowAll = function (event) {
        if (event.timeTemplate) {
            event.timeTemplate.showAll(!event.timeTemplate.showAll());
        } else {
            event.showAll(!event.showAll());
        }
    };
}

// Get events list
sbs.fullCalendarCustom.prototype.getEvents = function (displayType, filter, filter2) {
    switch (displayType) {
        case "events":
            if (filter > 0) {
                return _.filter(this.calendarEvents, function (event) {
                    return event.eventTypeId == filter;
                });
            }

            return this.calendarEvents;

            break;
        case "activities":
            if (filter > 0) {
                if (filter2 > 0) {
                    return _.filter(this.calendarActivities, function (event) {
                        (filter2 > 0 ? event.venueId == filter2 : true) &&
                        (filter > 0 ? event.activityId == filter : true);
                    });
                }

                return _.filter(this.calendarActivities, function (event) {
                    return event.activityId == filter;
                });
            }

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
        case "venue":
            return this.sportsActivities;
        case "sportsBookings":
            return _.filter(this.sportsBookings, function (booking) {
                return booking.sportId == filter;
            });

            break;
        case "sportsNights":
            return _.filter(this.sportsNightsEvents, function (booking) {
                return booking.sportId == filter;
            });
            break;
        case "paidActivities":
            return _.filter(this.paidActivitiesEvents, function (booking) {
                return booking.sportId == filter;
            });
            break;
    }
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

// Setup page events
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

    $('.poolDatePicker').datepicker("option", "maxDate", "+" + swimmingDaysShown + "d")

    $('#tabs a').click(function (e) {
        e.preventDefault();

        $(this).tab('show');
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        globalVM.basket.payment.clearScreens();

        changeDisplayType($(this).data("displaytype"))

        var reason = querystring("reason");
        var showReason = reason != "" && $(this).data("displaytype") == "basket";

        if (showReason) {
            // For payment success/failure
            globalVM.basket.payment.showFailureOrThankYou(reason);
        }

        if ($(this).data("state") == 6) {
            globalVM.showDayView(false);
        }

        History.pushState({ state: $(this).data("state") }, $(this).data("title"), "?action=" + $(this).data("displaytype")
                          + (showReason ? "&reason=" + reason : ""));
    })

    $('.btn').button();
}

sbs.fullCalendarCustom.prototype.setupDateVM = function (vm) {
    vm.date = ko.observable(new Date());

    vm.dayNumber = ko.computed(function () {
        return vm.date().getDate();
    }, vm);

    vm.month = ko.computed(function () {
        return shortMonthNames[this.date().getMonth()];
    }, vm);

    vm.day = ko.computed(function () {
        return dayNames[vm.date().getDay()];
    }, vm);

    vm.previousDay = ko.computed(function () {
        var theDate = this.date();
        var newDate = new Date(theDate.getFullYear(), theDate.getMonth(), theDate.getDate());

        newDate.setDate(theDate.getDate() - 1);

        return newDate.getDate() + " " + shortMonthNames[newDate.getMonth()];
    }, vm);

    vm.goToPreviousDay = function () {
        var previousDay = vm.date();
        previousDay.setDate(previousDay.getDate() - 1);
        vm.date(previousDay);
    }

    vm.nextDay = ko.computed(function () {
        var theDate = vm.date();
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
    }, vm);

    vm.goToNextDay = function () {
        var nextDay = this.date();
        nextDay.setDate(nextDay.getDate() + 1);
        this.date(nextDay);
    }

    vm.getHourByDate = function (date) {
        var hours = new Date(date).getHours();

        var suffix = (hours >= 12) ? 'pm' : 'am';

        hours = (hours > 12) ? hours - 12 : hours;

        hours = (hours == '00') ? 12 : hours;

        return (!date.allDay ? hours + suffix : "All day");
    };
}

sbs.fullCalendarCustom.prototype.setupSignInVM = function (vm) {
    vm.signIn = {
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
            vm.showDayView(false);
            vm.viewType("day");
            $('#calenderHolder').hide();
        },
        doLogin: function () {
            if (vm.signIn.email.value() == "") {
                vm.signIn.email.showError(true);
            }

            if (vm.signIn.password.value() == "") {
                vm.signIn.password.showError(true);
            }
        }
    }

    vm.signIn.email.value.subscribe(function (val) {
        vm.signIn.email.showError(val != "");
    });

    vm.signIn.password.value.subscribe(function (val) {
        vm.signIn.password.showError(val != "");
    });
}

sbs.fullCalendarCustom.prototype.setupActivityVM = function (vm, scope) {
    vm.activitiesInDay = ko.computed(function () {
        var displayType = this.displayType();
        var theDate = this.date();
        var activityId = this.activityId();
        var venueId = this.venueId();
        var events = scope.getEvents(displayType, activityId, venueId);
        var eventTypeId = this.eventTypeId();
        var filteredEvents;

        // Filter events by current date
        switch (displayType) {
            case "events":
                if (cachedEvents[theDate + "_" + eventTypeId]) {
                    return cachedEvents[theDate + "_" + eventTypeId];
                }

                filteredEvents = _.filter(events, function (event) {
                    event.HasBeenBooked = ko.observable(false);

                    return new Date(event.start).toDateString() == theDate.toDateString() &&
                        (eventTypeId > 0 ? event.eventTypeId == eventTypeId : true);
                });

                break;
            case "activities":
                if (cachedActivities[theDate + "_" + venueId + "_" + activityId]) {
                    return cachedActivities[theDate + "_" + venueId + "_" + activityId];
                }

                filteredEvents = _.filter(events, function (event) {
                    event.HasBeenBooked = ko.observable(false);

                    return new Date(event.start).toDateString() == theDate.toDateString() &&
                        (venueId > 0 ? event.venueId == venueId : true) &&
                        (activityId > 0 ? event.activityId == activityId : true);
                });

                break;
            case "venue":
                filteredEvents = _.filter(events, function (event) {
                    event.HasBeenBooked = ko.observable(false);

                    return new Date(event.start).toDateString() == theDate.toDateString() &&
                        (activityId > 0 ? event.sportId == activityId : true);
                });

                break;
            case "sportsNights": case "paidActivities":
                filteredEvents = _.filter(events, function (event) {
                    event.HasBeenBooked = ko.observable(false);

                    return true;
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
    }, vm);

    vm.moreInfo = ko.observable();
    vm.showMoreInfo = function () {
        vm.moreInfo(this);

        $('#moreInfoModal').modal('show');
    }
}

sbs.fullCalendarCustom.prototype.setupCalendar = function (displayType, displayTypeName) {
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

    function calculateMonths() {
        var startDate = new Date(globalVM.date().getFullYear(), globalVM.date().getMonth(), 0);
        var endDate = calendar.fullCalendar('getDate');
        var totalMonths = monthDiff(startDate, endDate);

        if(totalMonths == 0) {
            $('#previousCalendarMonthContainer').hide();
        } else {
            $('#previousCalendarMonthContainer').show();
        };
    }

    // These events need to go here, after the calendar is initialised.
    $('.previousCalendarMonth').on("click", function () {
        calendar.fullCalendar('prev');

        calculateMonths();
    });

    $('.nextCalendarMonth').on("click", function () {
        calendar.fullCalendar('next');

        calculateMonths();
    });
}

sbs.fullCalendarCustom.prototype.setupRouting = function (forwardAction, title, pushState) {
    var action = querystring("action");

    if (action == "") {
        History.pushState({ state: pushState }, title, "?action=" + forwardAction);
    } else {
        if (action == "myBookings") {
            globalVM.showDayView(false);
        } else if (action == "payment") {
            action = "basket";
        }

        $('#tabs li[data-displaytype=' + action + '] a').tab('show');
    }

    History.Adapter.bind(window, 'statechange', function () { // Note: We are using statechange instead of popstate
        var State = History.getState(); // Note: We are using History.getState() instead of event.state
        var stateToGoTo = State.data.state;

        if (State.data.state == 3) {
            globalVM.basket.showPayment(false);
        } else if (State.data.state == 5) {
            globalVM.basket.showPayment(true);
            stateToGoTo = 3;
        }

        $('#tabs li:eq(' + stateToGoTo + ') a').tab('show');
    });
}

function changeDisplayType(displayType) {
    calendar.fullCalendar('removeEventSource', currentEventSource);

    switch (displayType) {
        case "events":
            if (!globalVM.isMonthView()) {
                globalVM.showPoolView(false);
                globalVM.showDayView(true);
            }

            currentEventSource = customCalendar.groupType(customCalendar.getEvents("events", globalVM.eventTypeId()), "Event");

            calendar.fullCalendar('addEventSource', currentEventSource);
            break;
        case "activities":
            if (!globalVM.isMonthView()) {
                globalVM.showPoolView(false);
                globalVM.showDayView(true);
            }

            currentEventSource = customCalendar.groupType(customCalendar.getEvents("activities", globalVM.activityId(), globalVM.venueId()), "Activity");

            calendar.fullCalendar('addEventSource', currentEventSource);
            break;
        case "swimmingPool": case "venue":
            globalVM.showPoolView(true);
            globalVM.showDayView(true);
            globalVM.viewType('day');
            $('#calenderHolder').hide();

            if (displayType == "swimmingPool" && globalVM.sportEventName() != "Swimming") {
                globalVM.sportEventName('Swimming');
            }

            globalVM.date(new Date());

            break;
        case "basket":
            globalVM.showPoolView(false);
            globalVM.showDayView(false);
            $('#calenderHolder').hide();
    }

    globalVM.displayType(displayType);
}