<div id="MailMohasabehTeamModal" class="modal modal-primary fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{trans('labels.mail_mohasabeh_team')}}</h4>
      </div>
      <div class="modal-body">
        <p> {{trans('labels.enter_your_message_here')}}</p>
        <p>
            <textarea id="CustomerMessageToMailTeam" class="form-control" style="height:150px"></textarea>
            <span class="message-text  hidden" style="color:#ed0512;"> {{trans('labels.please_enter_message')}}</span>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" id="MailTeamRequest"  class="btn btn-primary" >{{trans('labels.send')}} <i class="fa fa-envelope "></i> </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('labels.close')}}</button>
      </div>
    </div>

  </div>
</div>
