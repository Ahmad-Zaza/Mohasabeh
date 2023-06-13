
var lastSel = $("#inventory_id option:selected");
$('#inventory_id').change(function () {
    if(confirm(_CHANGE_INVENTORY_CONFIRM_MESSAGE)){
        $("#table-adafmad tbody tr").remove();
        $("#table-adafmad tbody").append('<tr class="trNull"><td colspan="5" align="center">'+_TABLE_DATA_NOT_FOUND+'</td></tr>');
        $("#amount").val(0);
        $("#discount").val(0);
        $("#after_discount").val(0);
    }else{
        lastSel.prop("selected", true);
    }
 });
 