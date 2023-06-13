
$(document).ready(function () {
    $("#receipt_items_confirm").click(function(){
        var id = $(this).data('id');
        var allVals = [];
        $('#receipt_items_confirm_form :checked').each(function() {
            let val = $(this).val();
            if(val != 'on'){
                allVals.push(val);
            }
        });
        var disabled_checkbox_count = $('#receipt_items_confirm_form :disabled').length;
        if(allVals.length == 0 || allVals.length == disabled_checkbox_count){
            notify(_WARNING,_PLEASE_CHECK_RECEIPT_ITEMS,'warning');
        }else{
            var items_track_ids =allVals.toString();
            swal({
                title: _ARE_YOU_CONFIRM,
                text: _RECEIPT_NOTIFICATION_MESSAGE,
                type: 'info',
                showCancelButton: true,
                allowOutsideClick: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: _YES,
                cancelButtonText: _NO,
                closeOnConfirm: false
            }, function() {
                $('#receipt_items_confirm i').removeClass('fa-check-circle');
                $('#receipt_items_confirm i').addClass('fa-spinner fa-spin');
                $('#receipt_items_confirm').addClass('disabled');
                swal.close();
                $.get('/TransferTracking/confirm_receipt_items/'+id+'/'+items_track_ids, function(res) {
                    let json_res = JSON.parse(res);
                    console.log(res);
                    $('#receipt_items_confirm i').removeClass('fa-spinner fa-spin');
                    $('#receipt_items_confirm i').addClass('fa-check-circle');
                    $('#receipt_items_confirm').removeClass('disabled');
                    if (json_res.status == 'error') {
                        notify(_ERROR,json_res.massege,'error');
                    } else {
                        location.href = "";
                    }
    
                })
            });
        }
        
    });

    $("#transfer_tracking_not").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            let note=$(this).val();
            note = note.trim();
            if(note == ''){
                notify(_WARNING,_PLEASE_ENTER_NOTE,'warning');
                $(this).val('');
            }else{
                let id = $(this).data('transfer_tracking_id');
                let user_id = $(this).data('user_id');
                $('#loading i').addClass('fa-spinner fa-spin');
                $.get('/TransferTracking/addNote/id'+id+'/user'+user_id+'/note'+note, function(res) {
                    let json_res = JSON.parse(res);
                    $('#loading i').removeClass('fa-spinner fa-spin');
                    if (json_res.status == 'error') {
                        notify(_ERROR,json_res.massege,'error');
                    } else {
                        location.href = "";
                    }
    
                });
            }
        }
    });
});
