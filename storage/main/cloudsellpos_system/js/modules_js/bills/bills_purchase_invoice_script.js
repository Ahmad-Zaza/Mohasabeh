$(document).ready(function () {
    var options_number = $('#delegate_id').find('option').length;
    if (options_number == 2) {
        var first_option = $('#delegate_id').find('option')[1];
        $('#delegate_id').val(first_option.value).change();
    }

    var options_number = $('#inventory_id').find('option').length;
    if (options_number == 2) {
        var first_option = $('#inventory_id').find('option')[1];
        $('#inventory_id').val(first_option.value);
        $('#adafmaditem_id').attr('data-inv', first_option.value);
    }
});

$('#adafmaditem_id').change(function () {
    var id = $(this).val();
    let suplier = $('#credit').val();
    if (suplier == '') {
        suplier = 0;
    }
    let curr_id = $('#currency_id').val();
    if (curr_id == '') {
        curr_id = 0;
    }
    $.get('/items/getPurchasePrice/currency' + curr_id + '/item' + id + '/suplier' + suplier, function (res) {
        console.log(res);
        $('#adafmadunit_price').val(res.price)
    });
})

$(document).ready(function () {
    //document.getElementById('adafmaditem_id').options.length = 0;
    $('#adafmaditem_id').find('option').remove().end()
    $.get('/bills/getItems', function (res) {
        $('#adafmaditem_id').append(new Option(_CHOOSE_ITEM, '')); 
        res.forEach(element => {
            $('#adafmaditem_id').append(new Option(element.p_code + ' - ' + element.name_ar, element.id));
        });
    })
})


$(document).ready(function () {

    $.post('/currencies/getDefaultCurrency', function (res) {
        var currency = $('#currency_id').val();
        $('#currency_id').attr('data-major_curr', res);
        if (currency == 0) {
            $('#currency_id').val(res).change();
        }
        if (currency == res) {
            $('#ex_rate').val('1.00');
            $('#ex_rate').attr('readonly', true);
        }
    })
})

$('#btn-add-table-adafmad').click(function () {

    var credit = $('#credit').val();
    var is_cash = document.querySelector('input[name=is_cash]:checked').value;
    if (credit == '' && is_cash == 0) {
        notify(_WARNING,_YOU_MUST_CHOOSE_SUPPLIER,'warning');
    }

    $('#adafmaditem_id').focus();

})

$('#discount').change(function () {
    var discount = $(this).val();
    if(discount < 0){
        notify(_WARNING,_DISCOUNT_MUST_BY_Positive,'warning');
        discount = -1*discount;
        $(this).val(discount);
    }
    var amount = $('#amount').val();
    $('#after_discount').val(amount - discount);
})

$('#currency_id').change(function () {
    var currency_id = $(this).val();
    let major_curr = $(this).data('major_curr');

    if(currency_id == ''){
        $('#ex_rate').val('0');
    }else if (currency_id == major_curr) {
        $('#ex_rate').val('1.00');
        $('#ex_rate').attr('readonly', true);
    } else {
        $('#ex_rate').attr('readonly', false);
        $('#ex_rate').attr('data-currency', currency_id);
        $("#form-group-currency_id div").css("cursor", "wait");
        $("#form-group-currency_id span.select2").css("pointer-events", "none");
        $.get('/currency/getEx_rate/' + currency_id, function (res1) {
            $('#ex_rate').val(res1.ex_rate);
            $("#form-group-currency_id div").css("cursor", "initial");
            $("#form-group-currency_id span.select2").css("pointer-events", "initial");
        })
    }
});

/*********** check bill number *************/
$('#bill_number').change(function () {
    var bill_number = $(this).val();
    if (bill_number !== '') {
        let bill_type = 1;
        let action = $('#form').attr('action');
        var id = action.split('/').pop();
        if (!$.isNumeric(id)) {
            id = 0;
        }
        $.get('/bills/check_bill_number_unique/num' + bill_number + '/id' + id + '/type' + bill_type + '', function (found) {
            if (found == 1) { // bill_number already used
                $('#form-group-bill_number').addClass('has-error');
                $('#form-group-bill_number .text-danger').html("<i class='fa fa-info-circle'></i> "+_BILL_NUMBER_IS_USED);
                } else {
                $('#form-group-bill_number').removeClass('has-error');
                $('#form-group-bill_number .text-danger').html('');
            }
        });
    } else {
        $('#form-group-bill_number').removeClass('has-error');
        $('#form-group-bill_number .text-danger').html('');
    }
});

$('#date').change(function () {
    var choosen_date = new Date($(this).val());
    // Get today's date
    var todaysDate = new Date();
    // call setHours to take the time out of the comparison
    if(choosen_date.setHours(0,0,0,0) > todaysDate.setHours(0,0,0,0)) {
        $('#form-group-date div.text-danger').html(_CHOOSEN_DATE_IS_GREATER_THAN_CURRENT_DATE);
    }else{
        $('#form-group-date div.text-danger').html('');
    }
});

$('#adafmadquantity').change(function () {
    let q = parseFloat($(this).val());
    let qty_after_fixed = Number(q);
    let roundedString = qty_after_fixed.toFixed(2);
    $(this).val(roundedString);
});