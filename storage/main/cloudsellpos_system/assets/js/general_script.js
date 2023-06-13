$(document).ready(function(){
    function toEnglishNumber(strNum) {
        var ar = '٠١٢٣٤٥٦٧٨٩'.split('');
        var en = '0123456789'.split('');
        strNum = strNum.replace(/[٠١٢٣٤٥٦٧٨٩]/g, x => en[ar.indexOf(x)]);
        //strNum = strNum.replace(/[^\d]/g, ''); if you want only english number
        return strNum;
    }

    //in Vouchers add ,edit forms
    $(document).on('keyup', '#form input[type=text]', function(e) {
        var val = toEnglishNumber($(this).val());
        $(this).val(val);
    });

    $(document).on('keyup', '#form textarea', function(e) {
        var val = toEnglishNumber($(this).val());
        $(this).val(val);
    });
    
 
    //check Dates fields in  Reports filter
    $("input[name=from_date]").change(function(){
        let from_date = $(this).val();
        let to_date = $("input[name=to_date]").val();
        if(to_date != '' && from_date > to_date){
            notify(_WARNING,_YOU_ENTER_FROM_DATE_BIGGER_THAN_TO_DATE,'warning');
        }
    });

    $("input[name=to_date]").change(function(){
        let to_date = $(this).val();
        let from_date = $("input[name=from_date]").val();
        if(from_date != '' && to_date < from_date){
            notify(_WARNING,_YOU_ENTER_TO_DATE_SMALLER_THAN_FROM_DATE,'warning');
        }
    });
});

function notify(heading,text,icon,show_hide_transition='fade',hide_after=7000,position='bottom-left',text_align='right'){
    $.toast({
        heading: heading,
        text: text,
        showHideTransition: show_hide_transition, //'slide','fade','plain'
        icon: icon, //info,warning,error,success 
        hideAfter:hide_after, // in milli seconds or false
        position: position,// bottom-left, bottom-right ,bottom-center,top-right,top-left,top-center,mid-center,
        textAlign:text_align, //right, left , center
    });
}