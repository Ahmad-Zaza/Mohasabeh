$(document).ready(function () {
    var options_number = $('#source').find('option').length;
    if (options_number == 2) {
        var first_option = $('#source').find('option')[1];
        $('#source').val(first_option.value).change();
    }

    $('#adaflljdolitem_id').find('option').remove().end();
    $.get('/bills/getItems', function (res) {
        $('#adaflljdolitem_id').append(new Option(_CHOOSE_ITEM, ''));
        res.forEach(element => {
            $('#adaflljdolitem_id').append(new Option(element.p_code + ' - ' + element.name_ar, element.id));
        });
    });
});

$('#adaflljdolitem_id').change(function () {
    var id = $(this).val();
    $.get('/items/getUnit/' + id, function (res) {
        $('#adaflljdolitem_unit').val(res);
    });
});

$('#adaflljdolquantity').change(function () {
    let q = parseFloat($(this).val());
    let qty_after_fixed = Number(q);
    let roundedString = qty_after_fixed.toFixed(2);
    $(this).val(roundedString);
});