$.fn.scrollView = function () {
    return this.each(function () {
        $('html, body').animate({
            scrollTop: $(this).offset().top
        }, 1000);
    });
}

function querystring(key) {
    var re = new RegExp('(?:\\?|&)' + key + '=(.*?)(?=&|$)', 'gi');
    var r = [], m;
    while ((m = re.exec(document.location.search)) != null) r.push(m[1]);
    return r;
}

var timer;

ko.bindingHandlers.timer = {
    update: function (element, valueAccessor) {
        if (globalVM.basket.showTimer()) {
            timer = setInterval(function () {
                if (!globalVM.basket.timerOnHold) {
                    var date = valueAccessor()();
                    date.setSeconds(date.getSeconds() - 1);

                    $(element).text(date.getMinutes() + " minutes " + date.getSeconds() + " seconds");

                    if (date.getMinutes() < 1 && date.getSeconds() <= secondsUntilBasketWarning && !globalVM.continuedToBasket) {
                        globalVM.basket.timerOnHold = true;

                        $('#timerModal').modal('show');
                    }

                    if (date.getMinutes() <= 0 && date.getSeconds() <= 0) {
                        globalVM.basket.clear();
                        clearInterval(timer);
                    }
                }
            }, 1000);
        } else {
            clearInterval(timer);
        }
    }
};