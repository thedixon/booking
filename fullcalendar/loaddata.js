sbs.fullCalendarCustom.prototype.loadData = function () {
    var self = this;

    var baseUrl = "./json/";

    return $.whenAll([
        $.getJSON(baseUrl + "mainEvents.json", function (data) {
            self.calendarEvents = data;
        }),

        $.getJSON(baseUrl + "sportsEvents.json", function (data) {
            self.sportsEvents = data;
        }),

        $.getJSON(baseUrl + "sportsBookings.json", function (data) {
            self.sportsBookings = data;
        }),

        $.getJSON(baseUrl + "swimmingBookings.json", function (data) {
            self.swimmingBookings = data;
        }),

        $.getJSON(baseUrl + "sportsActivities.json", function (data) {
            self.sportsActivities = data;
        }),

        $.getJSON(baseUrl + "mainActivities.json", function (data) {
            self.calendarActivities = data;
        }),

        //$.get(baseUrl + "paidActivities.json", function (data) {
        //    self.paidActivitiesEvents = JSON.parse(data);
        //}),

        //$.get(baseUrl + "sportsNights.json", function (data) {
        //    self.sportsNightsEvents = JSON.parse(data);
        //})
    ]);
}