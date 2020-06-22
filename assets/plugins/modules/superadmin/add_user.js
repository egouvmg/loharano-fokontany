$(function () {
	$('#saveOperator').click(function(e){
        e.preventDefault();
        
        loading();
        $('.error_field').text('');

        var data = $('#userForm').serializeArray();

        $.post('enregistrer_operateur', data, function(res){
            if(res.error === 1){
                if(res.missing_fields){
                    $.each( res.missing_fields, function( key, value ) {
                        $('.error_' + value[0]).text(value[1]);
                    });
                }
            }
            if(res.success === 1){
                $('#confirmResponse').text(res.msg);
                $('#confirmationModal').modal();
            }
            if(res.failed === 1)
                $('#failedMsg').text(res.msg);

            endLoading();
        }, 'JSON');
    });

    $(document).ready(function () {
        $('#phone').usPhoneFormat({
            format: 'xxx xx xxx xx',
        });
    });

    function loading(){
        $(this).prop('disabled', true);
        $('#loadingSave').show();
    }
    
    function endLoading(){
        $(this).prop('disabled', false);
        $('#loadingSave').hide();
    }
});