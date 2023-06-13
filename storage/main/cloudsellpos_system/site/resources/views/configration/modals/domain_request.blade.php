<div id="DomainRequestModal" class="modal modal-primary fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{trans('labels.domain_request')}}</h4>
      </div>
      <div class="modal-body">
		    <p>{{trans('labels.enter_domain_you_want')}}</p>
        <p>
            <input id="domain" class="form-control" />
            <span class="domain-text hidden" style="color:#ed0512;"> {{trans('labels.please_enter_domain')}}</span>
        </p>
        <p>{{trans('labels.enter_your_message_here')}}</p>
        <p>
            <textarea id="CustomerMessage" class="form-control" style="height:150px"></textarea>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" id="SendDomainRequest"  class="btn btn-primary" > {{trans('labels.send_domain_request')}} <i class="fa fa-send "></i> </button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> {{trans('labels.close')}}</button>
      </div>
    </div>

  </div>
</div>

  