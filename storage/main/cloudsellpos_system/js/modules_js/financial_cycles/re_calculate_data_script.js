
$(document).ready(function(){
   
    $('#save_re_calculate_data_result').click(function(){
        var allVals = [];
        $('form#RecalculateDataForm :checked').each(function() {
            let val = $(this).val();
            allVals.push(val);
        });
        
        if(allVals.length > 0){
            let options = allVals.toString();
            swal({
                title: _ARE_YOU_CONFIRM,
                text: _RECALCULATE_DATA_MESSAGE,
                type: 'info',
                showCancelButton: true,
                allowOutsideClick: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: _YES,
                cancelButtonText: _NO,
                closeOnConfirm: false
            }, function() {
                $('#save_re_calculate_data_result i').removeClass('fa-save');
                $('#save_re_calculate_data_result i').addClass('fa-spinner fa-spin');
                $('#save_re_calculate_data_result').addClass('disabled');
                swal.close();
                $.get('/modules/financial_cycles/saveReCalculateDataResult/options/' + options, function(res) {
           
                    $('#save_re_calculate_data_result i').removeClass('fa-spinner fa-spin');
                    $('#save_re_calculate_data_result i').addClass('fa-save');
                    $('#save_re_calculate_data_result').removeClass('disabled');
                    let json_res = JSON.parse(res);
                    let text_msg = json_res.message;
                    if(json_res.status == 'error'){
                        notify(_ERROR,text_msg,'error');
                    }else{
                        notify(_SUCCESS,text_msg,'success');
                    }
                    window.location.href = '/';
                })
            });

        }else{
            notify(_WARNING,_PLEASE_CHOOSE_SOME_OPTIONS,'warning');
        }
    });


    $('#go_home_without_re_calculate_data').click(function(){
            swal({
                title: _ARE_YOU_CONFIRM,
                text: _GO_HOME_WITHOUT_RECALCULATE_DATA_MESSAGE,
                type: 'info',
                showCancelButton: true,
                allowOutsideClick: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: _YES,
                cancelButtonText: _NO,
                closeOnConfirm: false
            }, function() {
                $('#go_home_without_re_calculate_data i').removeClass('fa-ban');
                $('#go_home_without_re_calculate_data i').addClass('fa-spinner fa-spin');
                $('#go_home_without_re_calculate_data').addClass('disabled');
                swal.close();
                $.get('/modules/financial_cycles/IgnoreReCalculateData', function(res) {
           
                    $('#go_home_without_re_calculate_data i').removeClass('fa-spinner fa-spin');
                    $('#go_home_without_re_calculate_data i').addClass('fa-ban');
                    $('#go_home_without_re_calculate_data').removeClass('disabled');
                    let json_res = JSON.parse(res);
                    let text_msg = json_res.message;
                    if(json_res.status == 'error'){
                        notify(_ERROR,text_msg,'error');
                    }else{
                        notify(_SUCCESS,text_msg,'success');
                    }
                    window.location.href = '/';
                })
            });

        
    });


});