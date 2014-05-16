<div class="tab-pane" id="basket" data-bind="with: basket">
    <div class="container bottom-buffer-large">
        <!-- ko if: items().length == 0 && !payment.showThankYou() && !payment.showFailure() -->
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <h4>Sorry!</h4>
                    You have no items added to your basket. Please go back and add some.
                </div>
            </div>
        <!-- /ko -->

        <!-- ko if: items().length > 0 -->
            <!-- ko if: !showPayment() && !payment.showThankYou() && !payment.showFailure() -->
            <div class="col-md-5">
                <div class="page-header">
                    <h3>Booking Detail</h3>
                </div>
                <div data-bind="foreach: items">
                    <div class="bottom-border-line">
                        <div class="row">
                            <div class="col-md-9">
                                <strong>Item {{ $index() + 1 }}</strong>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-info btn-sm" data-bind="click: $root.basket.remove">Remove</button>
                            </div>
                        </div>
                    </div>
                    <div class="bottom-buffer-large">
                        <div class="row top-buffer ">
                            <div class="col-md-3">Type</div>
                            <div class="col-md-9 text-right">{{ title }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">Activity</div>
                            <div class="col-md-9 text-right">{{ activityName }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">Price</div>
                            <div class="col-md-9 text-right">{{ $root.formatToPrice(price) }} SGD</div>
                        </div>
                    </div>
                </div>
                                
                <h4 class="bottom-border-line top-border-line">Maximum participants</h4>

                <div class="row bottom-border-line">
                    <div class="col-md-3"><h3>Charge</h3></div>
                    <div class="col-md-9 text-right"><h3>{{ $root.formatToPrice(total()) }} SGD</h3></div>
                </div>

                <div class="top-buffer-large">
                    If you only want to book this activity, agree to the terms and confirm your booking.
                </div>

                <div class="row top-buffer-large">
                    <div class="col-md-12">
                        <input type="checkbox" data-bind="checked: agreedToTerms" /> Agree to the <a href="#">terms and conditions</a>
                    </div>
                </div>

                <div class="top-buffer-large" data-bind="if: notAgreedToTerms">
                    <p class="bg-danger">
                        <i class="glyphicon glyphicon-exclamation-sign"></i> You must agree to the terms and conditions before continuing.
                    </p>
                </div>

                <div class="row top-buffer-large">
                    <div class="col-md-4">
                        <button class="btn btn-success" data-bind="click: confirm">Confirm Booking</button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-info" data-bind="click: cancel">Cancel</button>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-md-offset-2">
                <div class="page-header no-border">
                    &#160;
                </div>
                <div class="row">
                    If you would like to add more bookings before you confirm you can add
                    it to your booking cart and continue browsing for more activities.
                </div>

                <div class="row top-buffer-large">
                    <h4>Promotion code</h4>
                    If you have a promotion code enter it in the input field below

                    <div class="row top-buffer-large">
                        <div class="col-md-2">
                            Code
                        </div>
                        <div class="col-md-5">
                            <input class="form-control" type="text" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-info">Check Code</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /ko -->

            <!-- ko if: showPayment -->
                <div class="page-header">
                    <h3>Payment Information</h3>
                </div>
                                
                <div class="col-md-5" data-bind="with: payment">
                <form role="form">
                        <div class="form-group">
                            <label for="paymentCardType">Select credit card type</label>
                            <select id="paymentCardType" class="form-control">
                                <option>Credit card type</option>
                                <option>VISA Debit</option>
                            </select>
                        </div>
                        <div class="form-group" data-bind="css: { 'has-error': cardName.showError }">
                            <label for="paymentCardName">Name on the card</label>
                            <input id="paymentCardName" type="text" class="form-control" data-bind="value: cardName.value, valueUpdate: 'afterkeypress'" />
                        </div>
                        <div class="form-group" data-bind="css: { 'has-error': cardNumber.showError }">
                            <label for="paymentCardNumber">Credit card number</label>
                            <input id="paymentCardNumber" type="text" class="form-control" data-bind="value: cardNumber.value, valueUpdate: 'afterkeypress'" />
                        </div>
                        <div class="form-group">
                            <label for="paymentExpirationDateMonth">Expiration date</label>
                            <div class="row">
                                <div class="col-md-5">
                                    <select id="paymentExpirationDateMonth" class="form-control">
                                        <option>01</option>
                                    </select>
                                </div>
                                <div class="col-md-5 col-md-offset-2">
                                    <select id="paymentExpirationDateYear" class="form-control">
                                        <option>2014</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" data-bind="css: { 'has-error': ccv.showError }">
                            <label for="paymentCCV">CCV</label>
                            <input id="paymentCCV" type="text" class="form-control" data-bind="value: ccv.value, valueUpdate: 'afterkeypress'" />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <button type="submit" class="btn btn-default"  data-bind="click: doPayment">Submit Payment</button>
                            </div>

                            <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-default" data-bind="click: $parent.cancel">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            <!-- /ko -->
        <!-- /ko -->

        <!-- ko if: payment.showThankYou -->
            <div class="page-header">
                <h3>Payment was successful!</h3>
            </div>
                                
            <div class="col-md-5">
                We have confirmed the following bookings in our system:

                <div class="top-buffer-large">
                    <div class="panel panel-default grey-bg">
                        <div class="panel-body">
                            <div class="bottom-border-line-grey">
                                <h4>Basketball facility booking</h4>
                                Sports hall 3
                                <div class="row">
                                    <div class="col-md-7">
                                        17 April 2014 5 pm - 6 pm
                                    </div>
                                    <div class="col-md-5 text-right">
                                        Charge: <strong>X SGD</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="bottom-border-line-grey">
                                <h4>Basketball facility booking</h4>
                                Sports hall 3
                                <div class="row">
                                    <div class="col-md-7">
                                        17 April 2014 5 pm - 6 pm
                                    </div>
                                    <div class="col-md-5 text-right">
                                        Charge: <strong>X SGD</strong>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4>Basketball facility booking</h4>
                                Sports hall 3
                                <div class="row">
                                    <div class="col-md-7">
                                        17 April 2014 5 pm - 6 pm
                                    </div>
                                    <div class="col-md-5 text-right">
                                        Charge: <strong>X SGD</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-header no-border">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Total charge: </h3> 
                        </div>

                        <div class="col-md-6 text-right">
                            <h3 class="">X SGD</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-md-offset-2">
                <h4>Tickets</h4>
                Tickets will be sent to your registerd email. You can also view your booking and print out tickets under the my bookings sections.

                <div class="top-buffer-large">
                    <button class="btn btn-info">View my bookings</button>
                </div>
            </div>
        <!-- /ko -->

        <!-- ko if: payment.showFailure -->
            <div class="page-header">
                <h3>Payment failed</h3>
            </div>

            We were unable to process the payment with the credit card you provided.
                               
            <div class="top-buffer-large">
                <h4>The following error occured:</h4>
                Aenean lacinia bibendum nulla sed consectetur. Maecenas sed diam eget risus varius blandit sit amet non magna.
            </div>
                                
            <div class="top-buffer-large">
                <button class="btn btn-info">Try again</button>
            </div>
        <!-- /ko -->
                        
    </div>
</div>