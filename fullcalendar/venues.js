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

        this.venueId.subscribe(function (val) {
            
            if (val == 0) {
                if ($('.fc-view').length > 0) {
                    $('#calenderHolder').hide();
                }

                this.viewType("day");
            }

            filterView();
        }, this);

        this.venues = ko.observableArray([
            {
                name: 'Facility Booking',
                id: 0,
                activities: [2,3,4]
            },
            {
                name: 'Group Training',
                id: 1,
                activities: [0,2,3]
            }
        ]);

        this.activityId.subscribe(function () {
            filterView();
        }, this);

        this.activities = ko.observableArray([
            { name: 'All Activities', id: 0 },
            { name: 'Basketball', id: 2 },
            { name: 'Football', id: 3 },
            { name: 'Tennis', id: 4 },
            { name: 'Hockey', id: 5 }
        ]);

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
        
        this.showSwimmingDetails = function (event, override) {
            event.showDetails(!event.showDetails());
        }

        this.viewType = ko.observable("day");
        this.displayType = ko.observable("venue");
        this.showDayView = ko.observable(true);
        this.showPoolView = ko.observable(false);

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
       
        function showSportsBookings(sportId) {
            var sportsEvents = customCalendar.getEvents('sports');
            var sportsBookings = customCalendar.getEvents('sportsBookings', sportId);
            var eventType;

            self.timeTemplate.fullDisplay.removeAll();

            for (var i = 0; i < sportsEvents.length; i++) {
                if (sportId == sportsEvents[i].id) {
                    self.currentSport(sportsEvents[i]);
                    break;
                }
            }

            var startTime = Number(self.currentSport().startTime);
            var endTime = Number(self.currentSport().endTime);
            var incrament = Number(self.currentSport().increment);

            for (var i = startTime; i <= endTime; i += incrament) {
                var description = self.currentSport().courts + " " + self.currentSport().prefix + (self.currentSport().courts > 1 ? "s" : "") + " Available";
                var active = true;

                sportsDate = new Date(y, m, d, i);

                var endDate = new Date();
                endDate.setHours(sportsDate.getHours() + incrament);
                var startTime = self.getHourByDate(new Date().setHours(i));

                for (var o = 0; o < sportsBookings.length; o++) {
                    var sportsBooking = sportsBookings[o];

                    if (+sportsBooking.start === +sportsDate) {
                        var courtAmount = (self.currentSport.courts - sportsBooking.courtsTaken);
                        description = courtAmount + " " + self.currentSport().prefix + (courtAmount > 1 ? "s" : "") + "  Available";

                        if (courtAmount == 0 || sportsBooking.bookingNotAllowed) {
                            active = false;
                        }

                        break;
                    }
                }

                self.timeTemplate.fullDisplay.push({
                    startHour: startTime,
                    fullTime: startTime + " - " + self.getHourByDate(endDate),
                    increment: incrament,
                    description: description,
                    linkActive: active,
                    showDetails: ko.observable(false),
                    eventType: self.currentSport().name.toLowerCase(),
                    HasBeenBooked: ko.observable(false)
                })
            }
        }
        
        customCalendar.setupDateVM(this);

        customCalendar.setupUtilityFunctions(this, calendarScope);

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

$(function () {
    customCalendar = new sbs.fullCalendarCustom();

    customCalendar.loadData().then(function () {
        customCalendar.setupKnockout();

        customCalendar.loadTemplates(globalVM.isTemplateLoaded).then(function () {
            customCalendar.setupEvents();

            setTimeout(function () {
                $('.loader').removeClass("active").hide();
                $('#main').show();

                customCalendar.setupCalendar("venues", "Venue");

                customCalendar.setupRouting("venue", "Venue", 0);

                
            }, 2000);
        });
    });
    
});
