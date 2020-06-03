$(function () {
	$('.firm-item').click(function (e) {
		$('#loadingData').show();
		var data = {
			'company_id': $(this).data('index'),
			'day_done': $(this).data('date')
		};
		
		var firm_item = $(this);

		$.post('recuperation_details_enregistrement', data, function (res) {
				if (res.success) {
					$('#pills-tabContent').html(res.html);

					$('.firm-item').removeClass('active');
					firm_item.addClass('active');

					$('#pills-info-tab').addClass('active');
					$('#pills-survey-tab').removeClass('active');
				} else
					alert('Une erreur est survenue. Contacter le responsable.');
				$('#loadingData').hide();
			}, 'JSON')
			.fail(function () {
				alert('Une erreur est survenue. Contacter le responsable.');
				$('#loadingData').hide();
			});
	});


});
