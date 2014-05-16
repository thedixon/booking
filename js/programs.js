window.sbs = window.sbs || {};

// Custom functions 
sbs.fullCalendarCustom = function () { }

sbs.fullCalendarCustom.prototype.setupKnockout = function () {
    var calendarScope = this;

    viewModel = function () {
        var self = this;
        
        customCalendar.setupData(this);

        this.eventTypeId.subscribe(function () {
            changeDisplayType(this.displayType());
        }, this);

        this.venueId.subscribe(function () {
            if (calendar) {
                changeDisplayType(this.displayType());
            }
        }, this);

        this.activityId.subscribe(function () {
            if (calendar) {
                changeDisplayType(this.displayType());
            }
        }, this);

        this.customerId = ko.observable();
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

        self.showPools = function(val) {
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
                    eventType: "swimming",
                    HasBeenBooked: ko.observable(false)
                });
            }
        }

        this.swimmingPoolSelected = ko.observable(1);
        this.swimmingPoolSelected.subscribe(function () {
            self.showPools(self.sportEventName());
        });

        this.sportEventName.subscribe(function (val) {
            self.showPools(val);
        });

        this.showSwimmingDetails = function (event, override) {
            event.showDetails(!event.showDetails());
        }

        this.activitiesFiltered = ko.computed(function () {
            var venueId = this.venueId();

            var activityListReturn = [];

            var activityList = ko.utils.arrayFirst(this.venues(), function (item) {
                return item.id == venueId;
            }).activities;

            for (var i = 0; i < activityList.length; i++) {
                activityListReturn.push(ko.utils.arrayFirst(this.activities(), function (item) {
                    item.HasBeenBooked = ko.observable(false);

                    return item.id == activityList[i];
                }));
            }

            return activityListReturn;
        }, this);
       
        customCalendar.setupUtilityFunctions(this, calendarScope);
        customCalendar.setupDateVM(this);
        customCalendar.setupSignInVM(this);

        this.SelectableDays = [
            { text: "All", value: 0 },
            { text: "Monday", value: 1 },
            { text: "Tuesday", value: 2 },
            { text: "Wednesday", value: 3 },
            { text: "Thursday", value: 4 },
            { text: "Friday", value: 5 },
            { text: "Saturday", value: 6 },
            { text: "Sunday", value: 7 }
        ];

        this.SelectedDay = ko.observable(0);

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

                customCalendar.setupCalendar("programmes", "Event", 0);

                customCalendar.setupRouting("programmes", "Programme", 0);
            }, 2000);
        });
    });
    
});
