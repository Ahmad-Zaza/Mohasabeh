
$(document).ready(function(){
    $('form#TempStopsettingForm').submit(function( event ) {

          let data = $('form#TempStopsettingForm').serializeArray();
          let data_json = JSON.stringify(data);
          $(this).find('button[type=submit] i').removeClass('fa-save');
          $(this).find('button[type=submit] i').addClass('disabled fa-spinner fa-spin');
          $(this).find('button[type=submit]').addClass('disabled');

          $.get('/modules/system_settings/temp_stop/edit/' + data_json, function(res) {
           
            $(this).find('button[type=submit] i').removeClass('fa-refresh fa-spin');
            $(this).find('button[type=submit] i').addClass('fa-save');
            $(this).find('button[type=submit]').removeClass('disabled');
            let json_res = JSON.parse(res);
            let text_msg = json_res.massege;
            if(json_res.status == 'error'){
                notify(_ERROR,text_msg,'error');
            }else{
                notify(_SUCCESS,text_msg,'success');
            }
            window.location.href = '';
        })
        
        event.preventDefault();
    });
  

    
    $('form#imagesSettingForm').submit(function( event ) {

        let data = $('form#imagesSettingForm').serializeArray();
        let data_json = JSON.stringify(data);
        $(this).find('button[type=submit] i').removeClass('fa-save');
        $(this).find('button[type=submit] i').addClass('disabled fa-spinner fa-spin');
        $(this).find('button[type=submit]').addClass('disabled');

        $.get('/modules/system_settings/images_settings/edit/' + data_json, function(res) {
         
          $(this).find('button[type=submit] i').removeClass('fa-refresh fa-spin');
          $(this).find('button[type=submit] i').addClass('fa-save');
          $(this).find('button[type=submit]').removeClass('disabled');
          let json_res = JSON.parse(res);
          let text_msg = json_res.massege;
          if(json_res.status == 'error'){
              notify(_ERROR,text_msg,'error');
          }else{
              notify(_SUCCESS,text_msg,'success');
          }
          window.location.href = '';
      })
      
      event.preventDefault();
    });

    $('form#BillsSettingForm').submit(function( event ) {

        let data = $('form#BillsSettingForm').serializeArray();
        let data_json = JSON.stringify(data);
        $(this).find('button[type=submit] i').removeClass('fa-save');
        $(this).find('button[type=submit] i').addClass('disabled fa-spinner fa-spin');
        $(this).find('button[type=submit]').addClass('disabled');

        $.get('/modules/system_settings/bills_settings/edit/' + data_json, function(res) {
         
          $(this).find('button[type=submit] i').removeClass('fa-refresh fa-spin');
          $(this).find('button[type=submit] i').addClass('fa-save');
          $(this).find('button[type=submit]').removeClass('disabled');
          let json_res = JSON.parse(res);
          let text_msg = json_res.massege;
          if(json_res.status == 'error'){
              notify(_ERROR,text_msg,'error');
          }else{
              notify(_SUCCESS,text_msg,'success');
          }
          window.location.href = '';
      })
      
      event.preventDefault();
    });

    $('#lockURL').click(function( event ) {

        swal({
            title: _ARE_YOU_CONFIRM,
            text: _LOCK_SYSTEM_URL_MESSAGE,
            type: 'info',
            showCancelButton: true,
            allowOutsideClick: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: _YES,
            cancelButtonText: _NO,
            closeOnConfirm: false
        }, function() {
            $('#lockURL i').removeClass('fa-lock');
            $('#lockURL i').addClass('fa-spinner fa-spin');
            $('#lockURL').addClass('disabled');
            swal.close();
            $.get('/modules/system_settings/lock_url/lock', function(res) {

                $('#lockURL i').removeClass('fa-refresh fa-spin');
                $('#lockURL i').addClass('fa-lock');
                $('#lockURL').removeClass('disabled');
      
                let json_res = JSON.parse(res);
                let text_msg = json_res.massege;
                if(json_res.status == 'error'){
                    notify(_ERROR,text_msg,'error');
                }else{
                    notify(_SUCCESS,text_msg,'success');
                    $('.lock_url_btn_div').addClass('hidden');
                    $('.success_locked_message').removeClass('hidden');
                    let unlock_req = json_res.unlock_req;
                    $('.success_locked_message code').html(unlock_req);
                }
            })
        });
  });
});