
@if($notifications['status'])
<div class="col-sm-12">
    <div class="row">
        <div class="box box-solid">
            <div class="box-header with-border">
            <i class="fa fa-bell"></i>
            <h3 class="box-title">{{trans('notifications.notifications')}}</h3>
            </div>

            <div class="box-body">
                <ul>
                    @foreach ( $notifications['list'] as $notify)

                        @if($notify->slag == 'receipt_notifications')
                            <li> 
                                {{trans('labels.you_have')}} <span class="badge bg-yellow">{{$notify->count}}</span> {{trans('notifications.receipt_notifications_msg')}}  
                                <a class="btn btn-xs btn-primary " href="{{ url($notify->link) }}" >{{trans('labels.receipt_notifications')}}</a>  
                            </li>
                        @elseif ($notify->slag == 'receipt_items_notifications')
                            <li> 
                                {{trans('labels.you_have')}} <span class="badge bg-yellow">{{$notify->count}}</span> {{trans('notifications.receipt_items_notifications_msg')}}  
                                <a class="btn btn-xs btn-primary " href="{{ url($notify->link) }}" >{{trans('labels.receipt_items_notifications')}}</a>  
                            </li>
                        @endif    

                    @endforeach
                   
                </ul>
            </div>

        </div>
    </div>
</div> 
@endif