
$('#delegate_id').change(function () {
    var delegate_id = $(this).val();
    if(delegate_id == ''){
        delegate_id = 0;
    }
    $('#inventory_id').find('option').remove().end()
    $.get('/delegate/inventories/' + delegate_id, function (res) {
        $('#inventory_id').append(new Option(_CHOOSE_INVENTORY, '')); 
        res.forEach(element => {
            $('#inventory_id').append(new Option(element.name_ar, element.id));
        });
        if (res.length == 1) {
            var first_option = $('#inventory_id').find('option')[1];
            $('#inventory_id').val(first_option.value).change();
            $('#adafmaditem_id').attr('data-inv', first_option.value);
        }else{
            $('#inventory_id').val('').change();
        }
    });
});
