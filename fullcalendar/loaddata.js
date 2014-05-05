sbs.fullCalendarCustom.prototype.loadData = function () {
    // Ultimately this will all be called in through AJAX.
    this.sportsEvents = [
        {
            id: 1,
            name: "Swimming",
            startTime: 9,
            endTime: 20,
            template: "swimming",
            increment: 1,
            laneAmount: 20,
            price: 5.50,
            prefix: "Lane"
        },
        {
            id: 2,
            name: "Basketball",
            startTime: 9,
            endTime: 20,
            template: "default",
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
            template: "default",
            increment: 1,
            price: 7,
            courts: 5
        },
        {
            id: 4,
            name: "Tennis",
            startTime: 9,
            endTime: 20,
            template: "default",
            increment: 1,
            price: 8,
            courts: 5
        },
        {
            id: 5,
            name: "Hockey",
            startTime: 9,
            endTime: 20,
            template: "default",
            increment: 1,
            price: 5.50,
            courts: 5
        }
    ]

    this.calendarEvents = [
        {
            title: "Short Event 1",
            displayTitle: "Short Event 1",
            start: new Date(y, m, d, 8, 30),
            end: new Date(y, m, d, 9, 30),
            allDay: false,
            eventTypeId: 1,
            placesLeft: 0,
            imageLocation: 'images/pool2.jpg',
            description: 'Testing event text just to show what it will look like once descriptions are entered.',
            price: 5
        },
        {
            title: "Short Event 1 (Duplicate - Swimming)",
            displayTitle: "Short Event 1 (Duplicate - Swimming)",
            start: new Date(y, m, d, 8, 30),
            end: new Date(y, m, d, 9, 30),
            allDay: false,
            eventTypeId: 1,
            placesLeft: 0,
            imageLocation: 'images/pool1.jpg',
            description: 'Testing event text just to show what it will look like once descriptions are entered.',
            price: 5
        },
        {
            title: "Short Event 2",
            displayTitle: "Short Event 2",
            start: new Date(y, m, d + 1, 14, 00),
            end: new Date(y, m, d + 1, 15, 00),
            allDay: false,
            eventTypeId: 2,
            placesLeft: 0,
            imageLocation: 'images/pool2.jpg',
            description: 'Testing event text just to show what it will look like once descriptions are entered.',
            price: 5
        },
        {
            title: "Lunch",
            displayTitle: "Lunch",
            start: new Date(y, m, d, 12, 0),
            end: new Date(y, m, d, 14, 0),
            allDay: false,
            eventTypeId: 3,
            placesLeft: 0,
            imageLocation: 'images/pool2.jpg',
            description: 'Testing event text just to show what it will look like once descriptions are entered.',
            price: 5
        },
        {
            title: "Click for Google",
            displayTitle: "Click for Google",
            start: new Date(y, m, d, 16, 0),
            end: new Date(y, m, d, 18, 30),
            allDay: false,
            url: "http://google.com/",
            eventTypeId: 3,
            placesLeft: 0,
            imageLocation: 'images/pool1.jpg',
            description: 'Testing event text just to show what it will look like once descriptions are entered.',
            price: 5
        }
    ]

    this.calendarActivities = [
        {
            title: "Short Activity 1",
            displayTitle: "Short Activity 1",
            start: new Date(y, m, d, 8, 30),
            end: new Date(y, m, d, 9, 30),
            allDay: false,
            venueId: 1,
            placesLeft: 10,
            imageLocation: '',
            description: '',
            price: 10
        },
        {
            title: "Short Activity 2",
            displayTitle: "Short Activity 2",
            start: new Date(y, m, d + 1, 14, 00),
            end: new Date(y, m, d + 1, 15, 00),
            allDay: false,
            placesLeft: 10,
            imageLocation: '',
            description: '',
            price: 10
        },
        {
            title: "Lunch",
            displayTitle: "Lunch",
            start: new Date(y, m, d, 12, 0),
            end: new Date(y, m, d, 14, 0),
            allDay: false,
            placesLeft: 10,
            imageLocation: '',
            description: '',
            price: 10
        },
        {
            title: "Click for Google",
            displayTitle: "Click for Google",
            start: new Date(y, m, d, 16, 0),
            end: new Date(y, m, d, 18, 30),
            allDay: false,
            url: "http://google.com/",
            placesLeft: 10,
            imageLocation: '',
            description: '',
            price: 10
        }
    ]

    this.sportsActivities = [
        {
            title: "Short Activity 1",
            displayTitle: "Short Activity 1",
            start: new Date(y, m, d, 8, 30),
            end: new Date(y, m, d, 9, 30),
            allDay: false,
            placesLeft: 10,
            imageLocation: '',
            description: '',
            price: 10
        },
        {
            title: "Short Activity 2",
            displayTitle: "Short Activity 2",
            start: new Date(y, m, d + 1, 14, 00),
            end: new Date(y, m, d + 1, 15, 00),
            allDay: false,
            sportId: 2,
            placesLeft: 10,
            imageLocation: '',
            description: '',
            price: 10
        },
        {
            title: "Lunch",
            displayTitle: "Lunch",
            start: new Date(y, m, d, 12, 0),
            end: new Date(y, m, d, 14, 0),
            allDay: false,
            placesLeft: 10,
            imageLocation: '',
            description: '',
            price: 10
        },
        {
            title: "Click for Google",
            displayTitle: "Click for Google",
            start: new Date(y, m, d, 16, 0),
            end: new Date(y, m, d, 18, 30),
            allDay: false,
            url: "http://google.com/",
            placesLeft: 10,
            imageLocation: '',
            description: '',
            price: 10
        }
    ]

    this.swimmingBookings = [
        {
            start: new Date(y, m, d, 9),
            lanesTaken: 4,
            //laneNumbersTaken: [1,3,5,6]
            poolId: 1
        },
        {
            start: new Date(y, m, d, 11),
            lanesTaken: 2,
            //laneNumbersTaken: [1, 3, 5, 6]
            poolId: 1
        },
        {
            start: new Date(y, m, d, 13),
            lanesTaken: 1,
            //laneNumbersTaken: [1],
            bookingNotAllowed: true,
            poolId: 2
        },
        {
            start: new Date(y, m, d, 14),
            lanesTaken: 12,
            poolId: 3
        }
    ]

    this.sportsBookings = [
        {
            start: new Date(y, m, d, 9),
            sportId: 2
        },
        {
            start: new Date(y, m, d, 11),
            sportId: 2
        },
        {
            start: new Date(y, m, d, 13),
            bookingNotAllowed: true,
            sportId: 3 
        },
        {
            start: new Date(y, m, d, 14),
            sportId: 4
        }
    ]
}