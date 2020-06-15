$(function () {
	$('#saveLocalityHousehold').click(function(e){
        e.preventDefault();
        
        loading();
        $('.error_field').text('');

        var data = $('#localityHousehold').serializeArray();

        $.post('verifier_localite_menage', data, function(res){
            if(res.error === 1){
                if(res.missing_fields){
                    $.each( res.missing_fields, function( key, value ) {
                        $('.error_' + value[0]).text(value[1]);
                    });
                }
            }
            if(res.success === 1){
                window.location = res.link;
            }
            if(res.failed === 1)
                $('#failedMsg').text(res.msg);

            endLoading();
        }, 'JSON');
    });

    $("#household_size").keypress(function (e) {
		var iKeyCode = (e.which) ? e.which : e.keyCode
		if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
			return false;
		return true;
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
