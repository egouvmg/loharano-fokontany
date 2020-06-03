$(function(){
	function get_fokontany(common_id){
		$('#loadingData').show();
		$('#fokontanyList').html('');
		$.post('nombre_fokotany_registre', {common_id : common_id}, function(res){
			if(res.success == 1)
				$('#fokontanyList').html(res.html);

			$('#loadingData').hide();
		}, 'JSON');
	}

	function reload_table(){
		$('#loadingData').show();
		$('#fokontanyList').html('');

		$.post("enfant_province", {id : $('#province').val()}, function(res){
			if(res.success == 1){
				$("#region").html(res.childs);
				//Récupération districts
				$.post("enfant_region", {id : res.first_child}, function(res){
					if(res.success == 1){
						$("#district").html(res.childs);

						//Récupération communes
						$.post("enfant_district", {id : res.first_child}, function(res){
							if(res.success == 1){
								$("#common").html(res.childs);
								get_fokontany(res.first_child);
								$('#loadingData').hide();
							}
							else if(res.error == 1)
								alert(res.msg);
						}, 'JSON');		
					}
					else if(res.error == 1)
						alert(res.msg);
				}, 'JSON');
			}
			else if(res.error == 1)
				alert(res.msg);
		}, 'JSON');
	}

	$("#province").change(function(e){
		$('#loadingData').show();
		$('#fokontanyList').html('');
		$.post("enfant_province", {id : $(this).val()}, function(res){
			if(res.success == 1){
				$("#region").html(res.childs);
				//Récupération districts
				$.post("enfant_region", {id : res.first_child}, function(res){
					if(res.success == 1){
						$("#district").html(res.childs);

						//Récupération communes
						$.post("enfant_district", {id : res.first_child}, function(res){
							if(res.success == 1){
								$("#common").html(res.childs);
								get_fokontany(res.first_child);
								$('#loadingData').hide();
							}
							else if(res.error == 1)
								alert(res.msg);
						}, 'JSON');		
					}
					else if(res.error == 1)
						alert(res.msg);
				}, 'JSON');
			}
			else if(res.error == 1)
				alert(res.msg);
		}, 'JSON');
	});

	$("#region").change(function(e){
		$('#loadingData').show();
		$('#fokontanyList').html('');
		//Récupération districts
		$.post("enfant_region", {id : $(this).val()}, function(res){
			if(res.success == 1){
				$("#district").html(res.childs);

				//Récupération communes
				$.post("enfant_district", {id : res.first_child}, function(res){
					if(res.success == 1){
						$("#common").html(res.childs);
						get_fokontany(res.first_child);
						$('#loadingData').hide();	
					}
					else if(res.error == 1)
						alert(res.msg);
				}, 'JSON');		
			}
			else if(res.error == 1)
				alert(res.msg);
		}, 'JSON');

	});

	$("#district").change(function(e){
		$('#loadingData').show();
		$('#fokontanyList').html('');
		//Récupération communes
		$.post("enfant_district", {id : $(this).val()}, function(res){
			if(res.success == 1){
				$("#common").html(res.childs);
				get_fokontany(res.first_child);
				$('#loadingData').hide();
			}
			else if(res.error == 1)
				alert(res.msg);
		}, 'JSON');		
	});

	$("#common").change(function(e){
		$('#loadingData').show();
		$('#fokontanyList').html('');
		//Récupération fokontany
		get_fokontany($(this).val());
		$('#loadingData').hide();	
	});

	/*
	 * New register
	 */
	 $("#n_province").change(function(e){
		$.post("enfant_province", {id : $(this).val()}, function(res){
			if(res.success == 1){
				$("#n_region").html(res.childs);
				//Récupération districts
				$.post("enfant_region", {id : res.first_child}, function(res){
					if(res.success == 1){
						$("#n_district").html(res.childs);

						//Récupération communes
						$.post("enfant_district", {id : res.first_child}, function(res){
							if(res.success == 1){
								$("#n_common").html(res.childs);

								//Récupération fokontany
								$.post("enfant_commune", {id : res.first_child}, function(res){
									if(res.success == 1){
										$("#n_fokontany").html(res.childs);		
									}
									else if(res.error == 1)
										alert(res.msg);
								}, 'JSON');		
							}
							else if(res.error == 1)
								alert(res.msg);
						}, 'JSON');		
					}
					else if(res.error == 1)
						alert(res.msg);
				}, 'JSON');
			}
			else if(res.error == 1)
				alert(res.msg);
		}, 'JSON');
	});

	$("#n_region").change(function(e){
		//Récupération districts
		$.post("enfant_region", {id : $(this).val()}, function(res){
			if(res.success == 1){
				$("#n_district").html(res.childs);

				//Récupération communes
				$.post("enfant_district", {id : res.first_child}, function(res){
					if(res.success == 1){
						$("#n_common").html(res.childs);

						//Récupération fokontany
						$.post("enfant_commune", {id : res.first_child}, function(res){
							if(res.success == 1){
								$("#n_fokontany").html(res.childs);		
							}
							else if(res.error == 1)
								alert(res.msg);
						}, 'JSON');		
					}
					else if(res.error == 1)
						alert(res.msg);
				}, 'JSON');		
			}
			else if(res.error == 1)
				alert(res.msg);
		}, 'JSON');

	});

	$("#n_district").change(function(e){
		//Récupération communes
		$.post("enfant_district", {id : $(this).val()}, function(res){
			if(res.success == 1){
				$("#n_common").html(res.childs);

				//Récupération fokontany
				$.post("enfant_commune", {id : res.first_child}, function(res){
					if(res.success == 1){
						$("#n_fokontany").html(res.childs);		
					}
					else if(res.error == 1)
						alert(res.msg);
				}, 'JSON');		
			}
			else if(res.error == 1)
				alert(res.msg);
		}, 'JSON');		
	});

	$("#n_common").change(function(e){
		//Récupération fokontany
		$.post("enfant_commune", {id : $(this).val()}, function(res){
			if(res.success == 1){
				$("#n_fokontany").html(res.childs);		
			}
			else if(res.error == 1)
				alert(res.msg);
		}, 'JSON');		
	});

	$('.input-number').on('keyup', function(e) {
		$(this).val($(this).val().replace(/[^0-9]/g, '')); 
	});

	$('#validRegister').click(function(e){
		e.preventDefault();

		var n_province = $('#n_province').val();
		var n_region = $('#n_region').val();
		var n_district = $('#n_district').val();
		var n_common = $('#n_common').val();
		var n_fokontany = $('#n_fokontany').val();
		var n_people = $('#n_people').val();
		var n_register = $('#n_register').val();

		if((n_people <= 0)){
			$('#errorPeople').text('Champs obligatoire');
			return true;
		}
		if((n_register <= 0)){
			$('#errorRegister').text('Champs obligatoire');
			return true;
		}

		var data = {
			province : n_province,
			region : n_region,
			district : n_district,
			common : n_common,
			fokontany : n_fokontany,
			people : n_people,
			register : n_register
		}

		$.get('enregistrement_fokotany_registre', data, function(res){
			if(res.success == 1){
				alert(res.msg);
				$('#newRegisterAdmin').modal('hide');
				$('#n_people').val('');
				$('#n_register').val('');

				reload_table();
			}
			else if(res.error == 1)
				alert(res.msg);
		}, 'JSON');
	});

	/*
	 * Edit register
	 */ 

	$(document).on('click','.edit-fk', function(e){
		e.preventDefault();

		var fokontay_name = $(this).data('name');
		var fokontany_id = $(this).data('index');
		var people = $(this).data('people');
		var nbr_register = $(this).data('register');

		$('#e_fokontany').val(fokontay_name);
		$('#e_register').val(nbr_register);
		$('#e_people').val(people);

		$('#current_id').val(fokontany_id);
		$('#current_register').val(nbr_register);
		$('#current_people').val(people);
	});

	$('#validEditRegister').click(function(e){
		e.preventDefault();

		var e_register = $('#e_register').val();
		var e_people = $('#e_people').val();

		if((e_people <= 0)){
			$('#errorPeople').text('Champs obligatoire');
			return true;
		}
		if((e_register <= 0)){
			$('#errorRegister').text('Champs obligatoire');
			return true;
		}

		var current_id = $('#current_id').val();
		var current_register = $('#current_register').val();
		var current_people = $('#current_people').val();


		var data = {
			fokontany : current_id,
			people : (e_people - current_people),
			register : (e_register - current_register),
			n_people : e_people,
			n_register : e_people
		}

		$.get('modification_fokotany_registre', data, function(res){
			if(res.success == 1){
				alert(res.msg);
				$('#editRegisterAdmin').modal('hide');
				$('#n_people').val('');
				$('#n_register').val('');

				reload_table();
			}
			else if(res.error == 1)
				alert(res.msg);
		}, 'JSON');
	});
});