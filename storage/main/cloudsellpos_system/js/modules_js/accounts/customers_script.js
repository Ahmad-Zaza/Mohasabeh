$(document).ready(function () {
    var options_number = $('#delegate_id').find('option').length;
    if (options_number == 2) {
        var first_option = $('#delegate_id').find('option')[1];
        $('#delegate_id').val(first_option.value).change();
    }
    $.get('/persons/getParentAccount/'+RECORD_ID,function(parent_id){
        $('#account_id').val(parent_id).select2();
    })
    $('#delegate_id').change(function () {
        var delegate_id = $(this).val();
        $.get('/delegate/getCustomers_account_id/' + delegate_id, function (res) {
            $('#account_id').val(res).select2();
        })
    });

    $('#account_id').change(function () {
        var customers_account_id = $(this).val();
        $.get('/delegate/getDelegate_id/' + customers_account_id, function (res) {
            $('#delegate_id').val(res).select2();
        })
    });

});
