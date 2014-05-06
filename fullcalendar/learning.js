window.sbs = window.sbs || {};

// Custom functions 
sbs.fullCalendarCustom = function () { }

sbs.fullCalendarCustom.prototype.setupKnockout = function () {
    var calendarScope = this;

    viewModel = function () {
        var self = this;

        function filterView() {
            var venueId = self.venueId();
            var sportId = self.activityId();

            if (venueId == 0 && sportId > 0) {
                // Facility
                self.showDayView(false);
                self.showPoolView(true);

                showSportsBookings(sportId);
            } else {
                // Group
                self.showDayView(true);
                self.showPoolView(false);
            }
        }

        customCalendar.setupData(this);

        this.sportsEvents = [
        {
            id: 2,
            name: "Basketball",
            startTime: 9,
            endTime: 20,
            template: "basketball",
            increment: 1,
            price: 5.50,
            prefix: "Court",
            courts: 5
        },
        {
            id: 3,
            name: "Football",
            startTime: 9,
            endTime: 20,
            template: "football",
            increment: 1,
            price: 7,
            courts: 5
        },
        {
            id: 4,
            name: "Tennis",
            startTime: 9,
            endTime: 20,
            template: "tennis",
            increment: 1,
            price: 8,
            courts: 5
        },
        {
            id: 5,
            name: "Hockey",
            startTime: 9,
            endTime: 20,
            template: "hockey",
            increment: 1,
            price: 5.50,
            courts: 5
        }
        ]

        this.venueId.subscribe(function (val) {
            
            if (val == 0) {
                if ($('.fc-view').length > 0) {
                    $('#calenderHolder').hide();
                }

                this.viewType("day");
            }

            filterView();
        }, this);

        this.activityId.subscribe(function () {
            filterView();
        }, this);

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

        this.showDayView = ko.observable(true);
        this.showPoolView = ko.observable(false);

        this.activitiesFiltered = ko.computed(function () {
            return this.sportsEvents;
        }, this);
       
        function showSportsBookings(sportId) {
            var sportsBookings = customCalendar.getEvents('sportsBookings', sportId);
            var eventType;

            self.timeTemplate.fullDisplay.removeAll();

            for (var i = 0; i < sportsEvents.length; i++) {
                if (sportId == sportsEvents[i].id) {
                    self.currentSport = sportsEvents[i];
                    break;
                }
            }

            for (var i = self.currentSport.startTime; i <= self.currentSport.endTime; i += self.currentSport.increment) {
                var description = self.currentSport.courts + " " + self.currentSport.prefix + (self.currentSport.courts > 1 ? "s" : "") + " Available";
                var active = true;

                sportsDate = new Date(y, m, d, i);

                var endDate = new Date();
                endDate.setHours(sportsDate.getHours() + self.currentSport.increment);
                var startTime = self.getHourByDate(new Date().setHours(i));

                for (var o = 0; o < sportsBookings.length; o++) {
                    var sportsBooking = sportsBookings[o];

                    if (+sportsBooking.start === +sportsDate) {
                        var courtAmount = (self.currentSport.courts - sportsBooking.courtsTaken);
                        description = courtAmount + " " + self.currentSport.prefix + (courtAmount > 1 ? "s" : "") + "  Available";

                        if (courtAmount == 0 || sportsBooking.bookingNotAllowed) {
                            active = false;
                        }

                        break;
                    }
                }

                self.timeTemplate.fullDisplay.push({
                    startHour: startTime,
                    fullTime: startTime + " - " + self.getHourByDate(endDate),
                    increment: self.currentSport.increment,
                    description: description,
                    linkActive: active,
                    showDetails: ko.observable(false),
                    eventType: self.currentSport.name.toLowerCase()
                })
            }
        }
        
        
        this.viewType = ko.observable("day");
        this.displayType = ko.observable("sportsNights");
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
