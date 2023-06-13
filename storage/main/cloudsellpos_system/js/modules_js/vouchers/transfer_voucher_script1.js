
$(document).ready(function () {
    var options_number = $('#delegate_id').find('option').length;
    if (options_number == 2) {
        var first_option = $('#delegate_id').find('option')[1];
        $('#delegate_id').val(first_option.value).change();
    }

    var options_number2 = $('#credit').find('option').length;
    if (options_number2 == 2) {
        var first_option = $('#credit').find('option')[1];
        $('#credit').val(first_option.value).change();
    }
});

$('#currency_id').change(function () {
    var currencyId = $(this).val();
    var amount = $('#amount').val();
    var account_id = $('#credit').val();
    let action = $('#form').attr('action');
    var id = action.split('/').pop();
    let bool = $.isNumeric(id);
    var editedId = 0;
    if(bool){
        editedId = id;  
    }
    if (amount != 0 || amount != null) {
        $.get('/voucherTransfer/checkBox/' + currencyId + '/' + amount + '/' + account_id+'/'+editedId, function (res) {
            console.log(res);
            if (res.res) {
                notify(_ERROR,_CREDIT_ACCOUNT_BALANCE+' ( '+res.account_name+' ) '+_NOT_ENOUGH_CURRENT_BALANCE_IS+' : ' + res.sum,'error');
            }

        });

    }
});


$('#amount').change(function () {
    var amount = $(this).val();
    var currencyId = $('#currency_id').val();
    var account_id = $('#credit').val();

    let action = $('#form').attr('action');
    var id = action.split('/').pop();
    let bool = $.isNumeric(id);
    var editedId = 0;
    if(bool){
        editedId = id;  
    }
    $.get('/voucherTransfer/checkBox/' + currencyId + '/' + amount + '/' + account_id+'/'+editedId, function (res) {
        console.log(res);

        if (res.res) {
            notify(_ERROR,_CREDIT_ACCOUNT_BALANCE+' ( '+res.account_name+' ) '+_NOT_ENOUGH_CURRENT_BALANCE_IS+' : ' + res.sum,'error');
        }

    });

})

/*********** check Voucher number *************/
$('#voucher_number').change(function () {
    var voucher_number = $(this).val();
    if (voucher_number !== '') {
        let voucher_type = 3;
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