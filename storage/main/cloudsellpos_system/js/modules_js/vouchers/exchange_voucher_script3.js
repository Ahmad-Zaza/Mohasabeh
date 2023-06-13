$(document).ready(function () {
    $.post('/currencies/getDefaultCurrency', function (res) {
        $('#currency_id').val(res).change();
    })
})