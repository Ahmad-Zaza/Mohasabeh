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
    var currency_id = $(this).val();
    if (currency_id != 0) {
        $('input:radio[name=opposite][value=' + currency_id + ']')[0].checked = true;
    }
    var opposite = $("input[name='opposite']:checked").val();
    var amount = $('#amount').val();
    if (currency_id == opposite) {
        $('#ex_rate').val(1);
        $('#ex_rate').attr('readonly', true);
        $('#equalizer').val(amount);
    } else {
        $('#ex_rate').attr('readonly', false);
        $.get('/voucher/getOppositeEx_rate/' + currency_id+'/'+opposite, function (ex_rate) {
            $('#ex_rate').val(ex_rate);
            var exRate = $('#ex_rate').val();
            $.get('/voucher/calculateAmountAfterOpposite/' + amount + '/' + currency_id + '/' + opposite + '/' + exRate, function (amount_after_opposite) {
                $('#equalizer').val(amount_after_opposite);
            });
        })
    }

})


$('#form-group-opposite input[type=radio]').change(function () {

    var opposite = $(this).val();
    var amount = $('#amount').val();
    var currency_id = $('#currency_id').val();
    if (currency_id == opposite) {
        $('#ex_rate').val(1);
        $('#ex_rate').attr('readonly', true);
        var exRate = $('#ex_rate').val();
        $.get('/voucher/calculateAmountAfterOpposite/' + amount + '/' + currency_id + '/' + opposite + '/' + exRate, function (amount_after_opposite) {
            $('#equalizer').val(amount_after_opposite);
        });
    } else {
        $('#ex_rate').attr('readonly', false);
        $.get('/voucher/getOppositeEx_rate/' + currency_id+'/'+opposite, function (ex_rate) {
            $('#ex_rate').val(ex_rate);
            var exRate = $('#ex_rate').val();
            $.get('/voucher/calculateAmountAfterOpposite/' + amount + '/' + currency_id + '/' + opposite + '/' + exRate, function (amount_after_opposite) {
                $('#equalizer').val(amount_after_opposite);
            });
        });
    }
});


$('#amount').keyup(function () {
    var amount = $(this).val();
    var opposite = $("input[name='opposite']:checked").val();
    var currency_id = $('#currency_id').val();
    var exRate = $('#ex_rate').val();
    $.get('/voucher/calculateAmountAfterOpposite/' + amount + '/' + currency_id + '/' + opposite + '/' + exRate, function (amount_after_opposite) {
        $('#equalizer').val(amount_after_opposite);
    });
})

$('#amount').change(function () {
    var amount = $(this).val();
    var opposite = $("input[name='opposite']:checked").val();
    var currency_id = $('#currency_id').val();
    var exRate = $('#ex_rate').val();
    $.get('/voucher/calculateAmountAfterOpposite/' + amount + '/' + currency_id + '/' + opposite + '/' + exRate, function (amount_after_opposite) {
        $('#equalizer').val(amount_after_opposite);
    });
})

$('#ex_rate').change(function () {
    var exRate = $(this).val();
    var amount = $('#amount').val();
    var opposite = $("input[name='opposite']:checked").val();
    var currency_id = $('#currency_id').val();

    $.get('/voucher/calculateAmountAfterOpposite/' + amount + '/' + currency_id + '/' + opposite + '/' + exRate, function (amount_after_opposite) {
        $('#equalizer').val(amount_after_opposite);
    });
})

/*********** check Voucher number *************/
$('#voucher_number').change(function () {
    var voucher_number = $(this).val();
    if (voucher_number !== '') {
        let voucher_type = 5;
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