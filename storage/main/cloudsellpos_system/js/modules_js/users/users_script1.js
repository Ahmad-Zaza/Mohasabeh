$(function() {
    let role = $('#id_cms_privileges').val();
    if(role==3){ //sales manager
        $('#form-group-inventories').css('display','none');
        $('#form-group-suppliers').css('display','block');
        $('#form-group-customers_account_id').css('display','block');
        $('#customers_account_id').attr('required',true);
    }else if(role==4){ //delegate
        $('#form-group-inventories').css('display','block');
        $('#form-group-suppliers').css('display','block');
        $('#form-group-customers_account_id').css('display','block');
        $('#customers_account_id').attr('required',true);
    }else if(role==6){ //factory delegate
        $('#form-group-inventories').css('display','block');
        $('#form-group-suppliers').css('display','none');
        $('#form-group-customers_account_id').css('display','block');
        $('#customers_account_id').attr('required',false);
    }else{
        $('#form-group-inventories').css('display','none');
        $('#form-group-suppliers').css('display','none');
        $('#form-group-customers_account_id').css('display','none');
        $('#customers_account_id').attr('required',false);
    }
    
    $('#id_cms_privileges').change(function(){
        let role = $(this).val();
        if(role!=4 && role!=3 && role!=6){
            $('#form-group-inventories').css('display','none');
            $('#form-group-suppliers').css('display','none');
            $('#form-group-customers_account_id').css('display','none');
            $('#customers_account_id').attr('required',false);
        }else if(role==3){ //sales manager
            $('#form-group-inventories').css('display','none');
            $('#form-group-suppliers').css('display','block');
            $('#form-group-customers_account_id').css('display','block');
            $('#customers_account_id').attr('required',true);
        }else if(role==4){ // delegate
            $('#form-group-inventories').css('display','block');
            $('#form-group-suppliers').css('display','block');
            $('#form-group-customers_account_id').css('display','block');
            $('#customers_account_id').attr('required',true);
        }else if(role==6){ // factory delegate
            $('#form-group-inventories').css('display','block');
            $('#form-group-suppliers').css('display','none');
            $('#form-group-customers_account_id').css('display','none');
            $('#customers_account_id').attr('required',false);
        }
        
    });
    $('#password').keyup(function(){
        let pass = $('#password').val(); 
        if(pass.length < 8 ){
            $('#form-group-password div .text-danger').css('color','#a94442');
            $('#form-group-password div .text-danger').html(_NUM_PASSWORD_CHARACTERS_LEAST_THAN_DEFAULT);
            $('#btn-save-data').attr('disabled',true);
            $('#btn-save-more').attr('disabled',true);
            
        }else{
            $('#form-group-password div .text-danger').html(_NUM_PASSWORD_CHARACTERS_CORRECT); 
            $('#form-group-password div .text-danger').css('color','#00a65a');
            $('#btn-save-data').attr('disabled',false);
            $('#btn-save-more').attr('disabled',false);
        }  
    });

    $('#password_confirmation').keyup(function(){
        let pass = $('#password').val(); 
        let repass = $(this).val(); 
        if(pass !== repass){
            $('#form-group-password_confirmation div .text-danger').css('color','#a94442');
            $('#form-group-password_confirmation div .text-danger').html(_PASSWORD_ISNOT_SIMILAR);
            $('#btn-save-data').attr('disabled',true);
            $('#btn-save-more').attr('disabled',true);
        }else{
            $('#form-group-password_confirmation div .text-danger').html(_PASSWORD_IS_SIMILAR); 
            $('#form-group-password_confirmation div .text-danger').css('color','#00a65a');
            $('#btn-save-data').attr('disabled',false);
            $('#btn-save-more').attr('disabled',false);
        }  
    });

    
    

    const password = document.querySelector('#password');
    password.insertAdjacentHTML('beforebegin', "<i class='fa fa-eye-slash show-password-eye' id='togglePassword'></i>");
    
    const togglePassword = document.querySelector('#togglePassword');
    togglePassword.addEventListener('click', function () {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // toggle the icon
        if(this.classList.contains('fa-eye-slash')){
            $('#togglePassword').removeClass('fa-eye-slash');
            $('#togglePassword').addClass('fa-eye');
        }else{
            $('#togglePassword').removeClass('fa-eye');
            $('#togglePassword').addClass('fa-eye-slash');
        }
    });

    const password_confirmation = document.querySelector('#password_confirmation');
    password_confirmation.insertAdjacentHTML('beforebegin', "<i class='fa fa-eye-slash show-password-eye' id='togglePasswordConfirmation'></i>");
    
    const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
    togglePasswordConfirmation.addEventListener('click', function () {
        // toggle the type attribute
        const type = password_confirmation.getAttribute('type') === 'password' ? 'text' : 'password';
        password_confirmation.setAttribute('type', type);
        
        // toggle the icon
        if(this.classList.contains('fa-eye-slash')){
            $('#togglePasswordConfirmation').removeClass('fa-eye-slash');
            $('#togglePasswordConfirmation').addClass('fa-eye');
        }else{
            $('#togglePasswordConfirmation').removeClass('fa-eye');
            $('#togglePasswordConfirmation').addClass('fa-eye-slash');
        }
    });

});