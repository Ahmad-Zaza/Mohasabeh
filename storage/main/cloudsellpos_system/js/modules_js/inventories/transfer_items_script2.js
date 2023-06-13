$('#btn-add-table-adaflljdol').click(function () {

    var item_id = 0;
    inv = $('#adaflljdolitem_id').attr('data-inv');
    if (typeof inv === 'undefined') {
        inv = $('#source').val();
    }
    item_id = $('#adaflljdolitem_id').attr('data-id');
    qty = $('#adaflljdolitem_id').attr('data-qty');
    $.get('/inventory' + inv + '/item' + item_id + '/check/qty' + qty, function (res) {
        if (res) {
            notify(_WARNING,res,'warning');
        }
    });

    $('#adaflljdolitem_id').focus();
})