$('#btn-add-table-adaflljdol').click(function () {
    let action = $('#form').attr('action');
    var id = action.split('/').reverse()[0];

    var item_id = 0;
    inv = $('#adaflljdolitem_id').attr('data-inv');
    if (typeof inv === 'undefined') {
        inv = $('#source').val();
    }
    item_id = $('#adaflljdolitem_id').attr('data-id');
    qty = $('#adaflljdolitem_id').attr('data-qty');
    $.get('/inventory' + inv + '/item' + item_id + '/check/edit/qty' + qty + '/transfer' + id, function (res) {
        if (res) {
            notify(_WARNING,res,'warning');
        }
    });

    $('#adaflljdolitem_id').focus();
});

var lastSel = $("#source option:selected");
$('#source').change(function () {
    if(confirm(_CHANGE_INVENTORY_CONFIRM_MESSAGE)){
        $("#table-adaflljdol tbody tr").remove();
        $("#table-adaflljdol tbody").append('<tr class="trNull"><td colspan="5" align="center">'+_TABLE_DATA_NOT_FOUND+'</td></tr>');
    }else{
        lastSel.prop("selected", true);
    }
 });