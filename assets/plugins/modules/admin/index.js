$(function () {

	function get_fokontany(common_id) {
		$('#loadingData').show();
		$.post("enfant_commune_avaliable", {
			id: common_id
		}, function (res) {
			if (res.success == 1) {
				$("#n_fokontany").html(res.childs);
				$('#loadingData').hide();
			} else if (res.error == 1)
				alert(res.msg);
		}, 'JSON');
	}


	function get_available_fokontany(fokontany_id) {
		$('#loadingData').show();
		$.post("fokontany_commune", {
			id: fokontany_id
		}, function (res) {
			if (res.success == 1) {
				get_fokontany(res.childs[0].id);
				$('#loadingData').hide();
			} else if (res.error == 1)
				alert(res.msg);
		}, 'JSON');
	}
	$("#n_province").change(function (e) {
		$('#loadingData').show();
		$.post("enfant_province", {
			id: $(this).val()
		}, function (res) {
			if (res.success == 1) {
				$("#n_region").html(res.childs);
				//Récupération districts
				$.post("enfant_region", {
					id: res.first_child
				}, function (res) {
					if (res.success == 1) {
						$("#n_district").html(res.childs);

						//Récupération communes
						$.post("enfant_district", {
							id: res.first_child
						}, function (res) {
							if (res.success == 1) {
								$("#n_common").html(res.childs);
								get_fokontany(res.first_child);
								$('#loadingData').hide();
							} else if (res.error == 1)
								alert(res.msg);
						}, 'JSON');
					} else if (res.error == 1)
						alert(res.msg);
				}, 'JSON');
			} else if (res.error == 1)
				alert(res.msg);
		}, 'JSON');
	});

	$("#n_region").change(function (e) {
		$('#loadingData').show();
		//Récupération districts
		$.post("enfant_region", {
			id: $(this).val()
		}, function (res) {
			if (res.success == 1) {
				$("#n_district").html(res.childs);

				//Récupération communes
				$.post("enfant_district", {
					id: res.first_child
				}, function (res) {
					if (res.success == 1) {
						$("#n_common").html(res.childs);
						get_fokontany(res.first_child);
						$('#loadingData').hide();
					} else if (res.error == 1)
						alert(res.msg);
				}, 'JSON');
			} else if (res.error == 1)
				alert(res.msg);
		}, 'JSON');

	});

	$("#n_district").change(function (e) {
		$('#loadingData').show();
		//Récupération communes
		$.post("enfant_district", {
			id: $(this).val()
		}, function (res) {
			if (res.success == 1) {
				$("#n_common").html(res.childs);
				get_fokontany(res.first_child);
				$('#loadingData').hide();
			} else if (res.error == 1)
				alert(res.msg);
		}, 'JSON');
	});

	$("#n_common").change(function (e) {
		$('#loadingData').show();
		//Récupération fokontany
		get_fokontany($(this).val());
		$('#loadingData').hide();
	});

	$('.firm-item').click(function (e) {
		$('#loadingData').show();

		var name = $(this).data('name');
		var data = {
			'company_id': $(this).data('index')
		};


		$('#pills-tabContent').html('');

		$('.companyName').text(name);

		var item = $(this);

		$.post('societe_enregistrement', data, function (res) {
				if (res.success) {
					$('#littleBack').hide();
					$('#pills-tabContent').show();
					$('#pills-tabContent-popup').html('');

					$('.firm-item').removeClass('active');
					item.addClass('active');

					$('#pills-tabContent').html(res.html);
				} else
					alert('Une erreur est survenue. Contacter le responsable.');
				$('#loadingData').hide();
			}, 'JSON')
			.fail(function () {
				alert('Une erreur est survenue. Contacter le responsable.');
			});
	});

	$(document).on('click', '.register-item', function (e) {
		$('#loadingData').show();
		$('#pills-tabContent').hide();
		var data = {
			'company_id': $(this).data('index'),
			'day_done': $(this).data('date')
		};

		var item = $(this);

		$.post('fokontany_date_enregistrement', data, function (res) {
				if (res.success) {
					$('#littleBack').show();
					$('#pills-tabContent-popup').html(res.html);
					$('#pills-tabContent-popup').show();
				} else
					alert('Une erreur est survenue. Contacter le responsable.');
				$('#loadingData').hide();
			}, 'JSON')
			.fail(function () {
				alert('Une erreur est survenue. Contacter le responsable.');
			});
	});

	$('#littleBack').click(function (e) {
		$(this).hide();
		$('#pills-tabContent').show();
		$('#pills-tabContent-popup').html('');
	});

	$('#showNewFirm').click(function (e) {
		e.preventDefault();
		$('.errorField').text('');
	});

	$('#validCompanyAccount').click(function (e) {
		e.preventDefault();
		$('.errorField').text('');
		$('#loadingDataCompany').show();

		var data = $('#accountCompanyOperator').serializeArray();

		$.get('nouveau_compte_societe', data, function (res) {
				if (res.success == 1) {
					alert(res.msg);
					$('#loadingDataCompany').hide();
					location.reload();
				} else if (res.error == 1) {
					if (res.missing_fields) {
						for (var i = res.missing_fields.length - 1; i >= 0; i--)
							$("#error_" + res.missing_fields[i]).text("Champs obligatoire");
					} else if (res.short_pwd) {
						console.log(res.short_pwd);
						for (var i = res.short_pwd.length - 1; i >= 0; i--)
							$("#error_" + res.short_pwd[i]).text("Le mot de passe doit être composé de 8 caractères minimum.");
					} else if (res.wrong_pwd) {
						for (var i = res.wrong_pwd.length - 1; i >= 0; i--)
							$("#error_" + res.wrong_pwd[i]).text("Veuillez confirmer le mot de passe.");
					} else if (res.exist)
						$('#error_n_company').text(res.exist);
					else alert(res.msg);
					$('#loadingDataCompany').hide();
				}
			}, 'JSON')
			.fail(function () {
				alert('Enregistrement impossible, connexion au serveur interrompue.');
			});
	});

	$('#addRegister').click(function (e) {
		e.preventDefault();
		var company_id = $('.firm-item.active').data('index');

		$.post('societe_registre', {
				company_id: company_id
			}, function (res) {
				if (res.success == 1) {
					$('#listCompanyRegister').html(res.companyregister);
					$('#newRegister').modal();
				} else alert(res.msg);
			}, 'JSON')
			.fail(function () {
				alert('Erreur sur le serveur. Impossible de répondre.');
			});

	});

	$('#companyAccountDetails').click(function (e) {
		e.preventDefault();

		var company_id = $('.firm-item.active').data('index');
		var company_name = $('.firm-item.active').data('name');

		$('#editCompanyTitle').text(company_name);

		$.post('compte_societe', {
				company_id: company_id
			}, function (res) {
				if (res.success == 1) {
					$('#editAccountCompanyOperator').html(res.form);
					$('#editFirm').modal();
				}
			}, 'JSON')
			.fail(function () {
				alert('Erreur sur le serveur. Impossible de répondre.');
			});
	});

	$(document).on('click', '#addFokontanyRegister', function (e) {
		var fokontany_id = $('#n_fokontany').val();
		var company_id = $('.firm-item.active').data('index');

		var data = {
			fokontany_id: fokontany_id,
			company_id: company_id
		}

		$.post('assigne_societe_fokontany', data, function (res) {
				if (res.success == 1) {
					get_available_fokontany(res.fokontany_id);
					$.post('societe_registre', {
							company_id: company_id
						}, function (res) {
							if (res.success == 1) {
								$('#listCompanyRegister').html(res.companyregister);
							} else alert(res.msg);
						}, 'JSON')
						.fail(function () {
							alert('Erreur sur le serveur. Impossible de répondre.');
						});
				} else alert(res.msg);
			}, 'JSON')
			.fail(function () {
				alert('Erreur sur le serveur. Impossible de répondres.');
			});
	});

	$(document).on('click', '#validEditCompanyAccount', function (e) {
		var data = $('#editAccountCompanyOperator').serializeArray();
		$('.errorField').text('');

		$.get('modifier_societe', data, function (res) {
				if (res.success == 1) {
					alert(res.msg);
					$('#loadingDataCompany').hide();
					location.reload();
				} else if (res.error == 1) {
					if (res.missing_fields) {
						for (var i = res.missing_fields.length - 1; i >= 0; i--)
							$("#error_" + res.missing_fields[i]).text("Champs obligatoire");
					} else if (res.short_pwd) {
						console.log(res.short_pwd);
						for (var i = res.short_pwd.length - 1; i >= 0; i--)
							$("#error_" + res.short_pwd[i]).text("Le mot de passe doit être composé de 8 caractères minimum.");
					} else if (res.wrong_pwd) {
						for (var i = res.wrong_pwd.length - 1; i >= 0; i--)
							$("#error_" + res.wrong_pwd[i]).text("Veuillez confirmer le mot de passe.");
					} else if (res.exist)
						$('#error_e_company').text(res.exist);
					else alert(res.msg);
					$('#loadingDataCompany').hide();
				}
			}, 'JSON')
			.fail(function () {
				alert('Erreur sur le serveur. Impossible de répondres.');
			});
	});

	$(document).on('click', '.delete-btn', function (e) {
		var fokontany_id = $(this).data('index');
		var company_id = $('.firm-item.active').data('index');

		var data = {
			fokontany_id: fokontany_id,
			company_id: company_id
		}

		$.get('supprimer_societe_fokontany', data, function (res) {
				if (res.success == 1) {
					alert(res.msg);
					get_available_fokontany(res.fokontany_id);
					$.post('societe_registre', {
							company_id: company_id
						}, function (res) {
							if (res.success == 1) {
								$('#listCompanyRegister').html(res.companyregister);
							} else alert(res.msg);
						}, 'JSON')
						.fail(function () {
							alert('Erreur sur le serveur. Impossible de répondre.');
						});
				} else alert(res.msg);
			}, 'JSON')
			.fail(function () {
				alert('Erreur sur le serveur. Impossible de répondres.');
			});

	});

	$(document).on('click', '#analyticsCompany', function (e) {
		e.preventDefault();

		var company_id = $('#firmContent li.active').data('index');

		$.post('suivi_saisie', {
				company_id : company_id 
			}, function (res) {
				if (res.success == 1) {
					$('#pills-tabContent-popup').hide();
					$('#pills-tabContent').html(res.tracking);
					$('#pills-tabContent').show();
				} else alert(res.msg);
			}, 'JSON')
			.fail(function () {
				alert('Erreur sur le serveur. Impossible de répondres.');
			});
	});
});
