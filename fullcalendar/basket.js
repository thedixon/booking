// Basket ViewModel + Code

sbs.fullCalendarCustom.prototype.setupBasketVM = function (vm) {
    var self = vm;

    self.basket = {
        items: ko.observableArray(),
        total: ko.observable(0),
        timerOnHold: false,
        continuedToBasket: false,
        timerValue: ko.observable(),
        showTimer: ko.observable(false)
    }

    self.basket.extendTime = function () {
        self.basket.timerOnHold = false;
        self.basket.continuedToBasket = false;

        $('#timerModal').modal('hide');

        self.basket.timerValue(new Date(0, 0, 0, 0, timerMinutes, 0, 0));
    }

    self.basket.navigateTo = function () {
        self.basket.timerOnHold = false;
        self.basket.continuedToBasket = true;

        $('#tabs li:eq(3) a').tab('show');

        $('#timerModal').modal('hide');

        changeDisplayType("basket");
    }

    self.basket.remove = function () {
        self.basket.items.remove(this);

        if (self.basket.items().length == 0) {
            self.basket.clearTimer();
        }
    }

    self.basket.clearBasket = function () {
        self.basket.basket.removeAll();
        self.basket.clearTimer();
    }

    self.basket.clearTimer = function () {
        self.basket.showTimer(false);
        self.basket.continuedToBasket = false;
    }

    self.basket.countDisplay = ko.computed(function () {
        return self.basket.items().length > 0 ? " (" + self.basket.items().length + " items)" : "";
    });

    self.basket.add = function (item) {
        self.basket.showTimer(true);

        self.basket.timerValue(new Date(0, 0, 0, 0, timerMinutes, 0, 0));
        var activity = ''

        if (item.eventType == "swimming") {
            item.price = 7.50; // Static for now.
            item.displayTitle = "Book Lane"
            activity = "Swimming"
        }

        self.basket.items.push({
            title: item.displayTitle,
            activityName: activity,
            price: item.price
        });

        self.basket.total(self.basket.total() + item.price);

        if (self.basket.items().length == 1) {
            // Move to basket, if not then just leave them.
            self.basket.navigateTo();

            self.basket.continuedToBasket = false;
        }
    }
}