// Basket ViewModel + Code

sbs.fullCalendarCustom.prototype.setupBasketVM = function (vm) {
    var self = vm;

    self.basket = {
        items: ko.observableArray(),
        total: ko.observable(0),
        timerOnHold: false,
        continuedToBasket: false,
        agreedToTerms: ko.observable(false),
        timerValue: ko.observable(),
        showTimer: ko.observable(false),
        showPayment: ko.observable(false),
        notAgreedToTerms: ko.observable(false)
    }

    self.basket.extendTime = function () {
        self.basket.timerOnHold = false;
        self.basket.continuedToBasket = false;

        $('#timerModal').modal('hide');

        self.basket.timerValue(new Date(0, 0, 0, 0, timerMinutes, 0, 0));
    }

    self.basket.navigateTo = function () {
        self.basket.notAgreedToTerms(false);

        self.basket.timerOnHold = false;
        self.basket.continuedToBasket = true;

        $('#tabs li:eq(3) a').tab('show');

        $('#timerModal').modal('hide');

        changeDisplayType("basket");
    }

    self.basket.remove = function () {
        self.basket.total(self.basket.total() - this.price);

        this.HasBeenBooked(false);

        self.basket.items.remove(this);

        if (self.basket.items().length == 0) {
            self.basket.clearTimer();
        }
    }

    self.basket.clearBasket = function () {
        for (var i = 0; i < self.basket.items.length; i++) {
            self.basket.items[i].HasBeenBooked(false);
        }

        self.basket.items.removeAll();
        self.basket.clearTimer();
        self.basket.total(0);
    }

    self.basket.clearTimer = function () {
        self.basket.showTimer(false);
        self.basket.continuedToBasket = false;
    }

    self.basket.countDisplay = ko.computed(function () {
        return self.basket.items().length > 0 ? " (" + self.basket.items().length + " items)" : "";
    });

    self.basket.add = function (item) {
        item.HasBeenBooked(true);

        self.basket.showTimer(true);

        self.basket.timerValue(new Date(0, 0, 0, 0, timerMinutes, 0, 0));
        var activity = ''

        if (item.eventType == "swimming") {
            item.price = 7.50; // Static for now.
            item.displayTitle = "Book Lane"
            activity = "Swimming"
        }

        var price = Number(item.price);

        self.basket.items.push({
            title: item.displayTitle,
            activityName: activity,
            price: price,
            HasBeenBooked: item.HasBeenBooked
        });

        self.basket.total(self.basket.total() + price);

        if (self.basket.items().length == 1) {
            // Move to basket, if not then just leave them.
            self.basket.navigateTo();

            self.basket.continuedToBasket = false;
        }
    }

    self.basket.confirm = function () {
        if (self.basket.agreedToTerms()) {
            History.pushState({ state: 5 }, "Payment", "?action=payment");

            self.basket.showPayment(true);

            self.basket.notAgreedToTerms(false);
        } else {
            self.basket.notAgreedToTerms(true);
        }
    }

    self.basket.payment = {
        showThankYou: ko.observable(false),
        showFailure: ko.observable(false),
        cardName: {
            value: ko.observable(''),
            showError: ko.observable(false)
        },
        cardNumber: {
            value: ko.observable(''),
            showError: ko.observable(false)
        },
        ccv: {
            value: ko.observable(''),
            showError: ko.observable(false)
        },
        cancel: function () {
            self.basket.showPayment(false);
            self.basket.notAgreedToTerms(false);
        },
        showFailureOrThankYou: function (reason) {
            self.basket.showPayment(false);

            if (reason == "success") {
                self.basket.payment.showThankYou(true);
            } else if (reason == "failure") {
                self.basket.payment.showFailure(true);
            }
        },
        clearScreens: function () {
            self.basket.payment.showThankYou(false);
            self.basket.payment.showFailure(false);
        },
        doPayment: function () {
            if (self.basket.payment.cardName.value() == "") {
                self.basket.payment.cardName.showError(true);
            }

            if (self.basket.payment.cardNumber.value() == "") {
                self.basket.payment.cardNumber.showError(true);
            }
           
            if (self.basket.payment.ccv.value() == "") {
                self.basket.payment.ccv.showError(true);
            }
        }
    }

    self.basket.payment.cardName.value.subscribe(function (val) {
        self.basket.payment.cardName.showError(val != "");
    });

    self.basket.payment.cardNumber.value.subscribe(function (val) {
        self.basket.payment.cardNumber.showError(val != "");
    });

    self.basket.payment.ccv.value.subscribe(function (val) {
        self.basket.payment.ccv.showError(val != "");
    });
}