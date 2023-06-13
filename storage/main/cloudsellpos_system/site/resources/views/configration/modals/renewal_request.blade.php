<div id="RenewalRequestModal" class="modal modal-primary fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> {{trans('labels.renewal_request')}}</h4>
      </div>
      <div class="modal-body">
		<p> {{trans('labels.please_choose_period_you_want')}}</p>
        <p>
            <select id="renewal_period" class="form-control" >
              <option value="15_free_days">{{trans('labels.15_free_days')}}</option>
              <option value="one_year">{{trans('labels.one_year')}}</option>
              <option value="five_year">{{trans('labels.five_year')}}</option>
            </select>
        </p>
        <p>{{trans('labels.enter_your_message_here')}}</p>
        <p>
            <textarea id="CustomerRenwalMessage" class="form-control" style="height:150px"></textarea>
            <span class="message-text  hidden" style="color:#ed0512;"> {{trans('labels.please_enter_message')}}</span>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" id="SendRenewalRequest"  class="btn btn-primary" >{{trans('labels.send')}} <i class="fa fa-send "></i> </button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> {{trans('labels.close')}}</button>
      </div>
    </div>

  </div>
</div>

