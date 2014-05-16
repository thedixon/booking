<div class="modal fade" id="pleaseWaitDialog" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>{{ pleaseWaitText }}</h4>
                </div>
                <div class="modal-body">
                    <div class="progress progress-striped active">
                        <div class="progress-bar" role="progressbar" style="width: 100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="timerModal" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>
                        Your time is almost up! Please check out your basket now or extend your time,
                        otherwise the contents of your basket will be cleared.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" data-bind="click: basket.extendTime">Extend Time</button>
                    <button type="button" class="btn btn-primary" data-bind="click: basket.navigateTo">Go to Basket</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="moreInfoModal">
      <div class="modal-dialog">
        <div class="modal-content" data-bind="with: moreInfo">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ displayTitle }}</h4>
            </div>
            <div class="modal-body">
              <div class="row" >
                  <div class="col-md-3" data-bind="if: imageLocation">
                      <img data-bind="attr: { src: imageLocation }" class="img-responsive img-rounded" />
                  </div>
                  <div class="col-md-9">
                      {{ longDescription }}
                  </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
    </div>