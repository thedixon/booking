// Get events list
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
        case "venue":
            return this.sportsActivities;
        case "sportsBookings":
            return _.filter(this.sportsBookings, function (booking) {
                return booking.sportId == filter;
            });

            break;
    }
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

sbs.fullCalendarCustom.prototype.setupActivityVM = function (vm, scope) {
    vm.activitiesInDay = ko.computed(function () {
        var displayType = this.displayType();
        var theDate = this.date();
        var activityId = this.activityId();
        var events = scope.getEvents(displayType, activityId);
        var venueId = this.venueId();
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
            case "venue":
                filteredEvents = _.filter(events, function (event) {
                    return new Date(event.start).toDateString() == theDate.toDateString() &&
                        (activityId > 0 ? event.sportId == activityId : true);
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