$('#delegate_id').change(function () {
    var id = $(this).val();
    if (id == '') {
        id = -1;
    }
    $('#source').find('option').remove().end();
    $.get('/bills/getInventoryByDelegate/' + id, function (res) {
        console.log(res);
        $('#source').append(new Option(_CHOOSE_INVENTORY, ''));
        res.forEach(element => {
            $('#source').append(new Option(element.name_ar, element.id));
        });

        var options_number = $('#source').find('option').length;
        if (options_number == 2) {
            var first_option = $('#source').find('option')[1];
            $('#source').val(first_option.value).change();
        }else{
            $('#source').change();
        }

    });

});