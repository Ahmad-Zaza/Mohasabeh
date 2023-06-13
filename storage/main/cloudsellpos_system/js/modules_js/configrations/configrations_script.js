
$(document).ready(function(){
    $('#SendDomainRequest').click(function(){
        var msg = $('#CustomerMessage').val();
        var domain = $('#domain').val();
        domain = domain.trim();
        if(domain != ''){ 
            $(".domain-text").addClass('hidden');
            $('#domain').css('border-color','#d2d6de');      
            $('#SendDomainRequest i').removeClass('fa-send');
            $('#SendDomainRequest i').addClass('fa-spinner fa-spin');
            $('#SendDomainRequest').attr('disabled',true);
            $.get('/mohasabeh_configration/sendDomainRequest/'+domain+'/'+msg, function(res) {
                let json_res = JSON.parse(res);
                console.log(res);
                $('#SendDomainRequest i').removeClass('fa-spinner fa-spin');
                $('#SendDomainRequest i').addClass('fa-send');
                $('#CustomerMessage').val('');
                $('#domain').val('');
                if (json_res.status == 'error') {
                    notify(_ERROR,json_res.message,'error');
                }else{
                    notify(_SUCCESS,json_res.message,'success');
                } 
                $('#SendDomainRequest').attr('disabled',false);
                $('#DomainRequestModal').modal('hide');
            });
        }else{
            $(".domain-text").removeClass('hidden');
            $('#domain').css('border-color','#a94442');
        }
        
    });
    
    $('#MailTeamRequest').click(function(){
        var msg = $('#CustomerMessageToMailTeam').val();
        msg = msg.trim();
        if(msg != ''){
            $(".message-text").addClass('hidden');
            $('#CustomerMessageToMailTeam').css('border-color','#d2d6de');

            $('#MailTeamRequest i').removeClass('fa-envelope');
            $('#MailTeamRequest i').addClass('fa-spinner fa-spin');
    
            $.get('/mohasabeh_configration/mailMohasabehTeam/'+msg, function(res) {
                let json_res = JSON.parse(res);
                $('#MailTeamRequest i').removeClass('fa-spinner fa-spin');
                $('#MailTeamRequest i').addClass('fa-envelope');
                $('#CustomerMessageToMailTeam').val('');
                if (json_res.status == 'error') {
                    notify(_ERROR,json_res.message,'error');
                }else{
                    notify(_SUCCESS,json_res.message,'success');
                } 
                $('#MailTeamRequest').attr('disabled',false);
                $('#MailMohasabehTeamModal').modal('hide');
            });
        }else{
            $(".message-text").removeClass('hidden');
            $('#CustomerMessageToMailTeam').css('border-color','#a94442');
        }
       

       
    });

    $('#SendRenewalRequest').click(function(){

        var msg = $('#CustomerRenwalMessage').val();
        var renewal_period = $('#renewal_period').val();
        msg = msg.trim();
        if(msg != ''){
            $(".message-text").addClass('hidden');
            $('#CustomerRenwalMessage').css('border-color','#d2d6de');

            $('#SendRenewalRequest i').removeClass('fa-send');
            $('#SendRenewalRequest i').addClass('fa-spinner fa-spin');
            $.get('/mohasabeh_configration/renewal_request/'+renewal_period+'/'+msg, function(res) {
                let json_res = JSON.parse(res);
                $('#SendRenewalRequest i').removeClass('fa-spinner fa-spin');
                $('#SendRenewalRequest i').addClass('fa-send');
                $('#renewal_period').val('15_free_days');
                $('#CustomerRenwalMessage').val('');
                if (json_res.status == 'error') {
                    notify(_ERROR,json_res.message,'error');
                }else{
                    notify(_SUCCESS,json_res.message,'success');
                } 
                $('#SendRenewalRequest').attr('disabled',false);
                $('#RenewalRequestModal').modal('hide');
            });
        }else{
            $(".message-text").removeClass('hidden');
            $('#CustomerRenwalMessage').css('border-color','#a94442');
        }
    });
    /***** validation input ******/
    $("input#domain").keyup(function() {
        var input = $(this);
        var text = input.val().replace(/[^0-9a-z]/g, ""); //allow  just numbers with +
        if(/_|\s/.test(text)) {
            text = text.replace(/_|\s/g, "");
            // logic to notify user of replacement
        }
        input.val(text);
    });
});