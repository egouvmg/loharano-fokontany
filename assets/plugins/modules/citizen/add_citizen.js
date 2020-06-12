$(function () {
	$('#saveOperator').click(function (e) {
        e.preventDefault();

        loading();
        $('.error_field').text('');

        var data = $('#addCitizen').serializeArray(); 

		$.post('enregistrement_citoyen', data, function (res) {
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
            
            endLoading();
        }, 'JSON')
        .fail(function() {
            alert('Une erreur est survenue. Contacter le responsable.');
            endLoading();
        });
    });
    
    $('#job').change(function(e){
        e.preventDefault();
        
        if($(this).val() == -1)
            $('#job_other').show();
        else $('#job_other').hide();
    });
    
    $('#nationality').change(function(e){
        e.preventDefault();
        
        if($(this).val() == 1){
            $('.passport-section').hide();
            $('.cin-section').show();
        }
        else{
            $('.passport-section').show();
            $('.cin-section').hide();
        }
    });

	$('#last_name').on('keyup', function () {
		var foo = $('#last_name').val();

		foo = foo.toUpperCase();

		$('#last_name').val(foo);
	});

	$('#first_name').on('keyup', function () {
		var foo = $('#first_name').val();

		if (typeof foo === 'string')
			foo = foo.charAt(0).toUpperCase() + foo.slice(1);

		$('#first_name').val(foo);
    });
    
	$('#cin').on('keypress', function (event) {
        if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
            event.preventDefault(); // ne pas permettre la saisie de character lettre
        } else {
            var foo = $('#cin').val().split(" ").join("");

            if (foo.length > 0)
                foo = foo.match(new RegExp('.{1,3}', 'g')).join(" ");

            $('#cin').val(foo);
        }
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
