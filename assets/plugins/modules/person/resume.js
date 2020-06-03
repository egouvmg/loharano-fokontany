$(function(){
	$("#confirmationData").click(function(e){
		e.preventDefault();
		$('#loadingData').show();
		$.get("sauvegarde_final", function(res){
			if(res.success == 1){
				$('#confirmationModal').modal();
			}
			else if(res.error == 1){
				$('#confirmationModalError').modal();
			}
			$('#loadingData').hide();
		}, 'JSON');
	});
});