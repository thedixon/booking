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
            if (calendar) {
                changeDisplayType(this.displayType());
            }
        }, this);

        this.activityId.subscribe(function () {
            if (calendar) {
                changeDisplayType(this.displayType());
            }
        }, this);

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

        this.activitiesFiltered = ko.computed(function () {
            return this.sportsEvents;
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

        customCalendar.setupUtilityFunctions(this, calendarScope);
        customCalendar.setupDateVM(this);
        customCalendar.setupSignInVM(this);

        this.myBookings = {
            items: customCalendar.myBookingEvents,
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
    $('#pleaseWaitDialog').modal('show');

    customCalendar = new sbs.fullCalendarCustom();

    customCalendar.loadData().then(function () {
        customCalendar.setupKnockout();

        customCalendar.loadTemplates(globalVM.isTemplateLoaded).then(function () {
            customCalendar.setupEvents();

            setTimeout(function () {
                $('#pleaseWaitDialog').modal('hide');
                $('#main').show();

                customCalendar.setupCalendar("events", "Event");

                customCalendar.setupRouting("tours", "Tours", 0);
            }, 2000);
        });
    });
});
