/*********** check Voucher number *************/
$('#voucher_number').change(function () {
    var voucher_number = $(this).val();
    if (voucher_number !== '') {
        let voucher_type = 4;
        let action = $('#form').attr('action');
        var id = action.split('/').pop();
        if (!$.isNumeric(id)) {
            id = 0;
        }
        $.get('/vouchers/check_voucher_number_unique/num' + voucher_number + '/id' + id + '/type' + voucher_type + '', function (found) {
            if (found == 1) { // voucher_number already used
                $('#form-group-voucher_number').addClass('has-error');
                $('#form-group-voucher_number .text-danger').html("<i class='fa fa-info-circle'></i> "+_VOUCHER_NUMBER_IS_USED);
            } else {
                $('#form-group-voucher_number').removeClass('has-error');
                $('#form-group-voucher_number .text-danger').html('');
            }
        });
    } else {
        $('#form-group-voucher_number').removeClass('has-error');
        $('#form-group-voucher_number .text-danger').html('');
    }
});



$('#narration').change(function(){
    $(this).val($(this).val().trim());
});