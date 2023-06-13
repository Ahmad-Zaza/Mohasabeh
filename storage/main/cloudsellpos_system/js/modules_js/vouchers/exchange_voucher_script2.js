$('#debit').change(function () {
    var id = $(this).val();
    $.get('/getDelegateNameByPersonId/' + id, function (res) {
        console.log(res);
        $('#delegate_id').val(res.id);
    });
});