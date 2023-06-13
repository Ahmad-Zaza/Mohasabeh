$(document).ready(function () {
    var options_number = $('#delegate_id').find('option').length;
    if (options_number == 2) {
        var first_option = $('#delegate_id').find('option')[1];
        $('#delegate_id').val(first_option.value).change();
    }

    var options_number = $('#source').find('option').length;
    if (options_number == 2) {
        var first_option = $('#source').find('option')[1];
        $('#source').val(first_option.value).change();
    }
});

$('#adaflljdolquantity').change(function () {
    var id = $(this).val();
    $('#adaflljdolitem_id').attr('data-qty', id);
});
$('#adaflljdolitem_id').change(function () {
    var id = $(this).val();
    $.get('/items/getPrice/' + id, function (res) {
        //console.log(res);
        $('#adaflljdolitem_id').attr('data-id', res.id);
    });

});

$(document).ready(function () {
    let inv = $('#source').val();
    if (inv) {
        $('#adaflljdolitem_id').find('option').remove().end();
        $.get('/inventory/items/' + inv, function (res) {
            $('#adaflljdolitem_id').append(new Option(_CHOOSE_ITEM, ''));
            res.forEach(element => {
                let item_curr_quantity = element.item_in - element.item_out;
                $('#adaflljdolitem_id').append(new Option(element.pCode + ' - ' + element.nameAr + ' - ( '+_CURRENT_BALANCE+' :' + item_curr_quantity + ' )', element.itemId));
            });
        });
    } else {
        $('#adaflljdolitem_id').find('option').remove().end();
        $.get('/bills/getItems', function (res) {
            $('#adaflljdolitem_id').append(new Option(_CHOOSE_ITEM, ''));
            res.forEach(element => {
                $('#adaflljdolitem_id').append(new Option(element.code + ' - ' + element.name_ar, element.id));

            });
        })
    }
})

$('#source').change(function () {
    var id = $(this).val();
    $('#adaflljdolitem_id').attr('data-inv', id);
    $('#adaflljdolitem_id').find('option').remove().end();
    $.get('/inventory/items/' + id, function (res) {
        console.log(res);
        $('#adaflljdolitem_id').append(new Option(_CHOOSE_ITEM, ''));
        res.forEach(element => {
            let item_curr_quantity = element.item_in - element.item_out;
            $('#adaflljdolitem_id').append(new Option(element.nameAr + ' - ( '+_CURRENT_BALANCE+' :' + item_curr_quantity + ' )', element.itemId));
        });
    });
});

$('#adaflljdolquantity').change(function () {
    let q = parseFloat($(this).val());
    let qty_after_fixed = Number(q);
    let roundedString = qty_after_fixed.toFixed(2);
    $(this).val(roundedString);
});