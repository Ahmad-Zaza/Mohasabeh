$(document).ready(function(){
    $.get('/persons/getParentAccount/'+RECORD_ID,function(parent_id){
            $('#account_id').val(parent_id).select2();
        })
});