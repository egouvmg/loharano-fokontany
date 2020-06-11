$(function () {
	$('#saveOperator').click(function (e) {
        e.preventDefault();

        $('#loadingSave').show();
        var data = $('#addCitizen').serializeArray(); 

		$.post('enregistrement_citoyen', data, function (res) {
            $('#loadingSave').hide();
        }, 'JSON')
        .fail(function () {
            alert('Une erreur est survenue. Contacter le responsable.');
            $('#loadingSave').hide();
        });
    });
    
    $('#job').change(function(e){
        e.preventDefault();
        console.log($(this).val());
        
        if($(this).val() == -1)
            $('#job_other').show();
        else $('#job_other').hide();
    });
});
