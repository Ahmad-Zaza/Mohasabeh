
$(document).ready(function () {
   $("#receipt_confirm").click(function(){
        var id = $(this).data('id');
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
            $('#receipt_confirm i').removeClass('fa-check-circle');
            $('#receipt_confirm i').addClass('fa-spinner fa-spin');
            $('#receipt_confirm').addClass('disabled');
            swal.close();
            $.get('/voucherTransfer/confirm_receipt_amount/'+id, function(res) {
                let json_res = JSON.parse(res);
                console.log(res);
                $('#receipt_confirm i').removeClass('fa-spinner fa-spin');
                $('#receipt_confirm i').addClass('fa-check-circle');
                $('#receipt_confirm').removeClass('disabled');
                if (json_res.status == 'error') {
                    notify(_ERROR,json_res.massege,'error');
                } else {
                    location.href = "";
                }

            })
        });
        
});
});
