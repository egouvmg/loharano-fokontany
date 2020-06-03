$(function () {
	function submitForm(mode) {
		var form = $("#addPersons");

		var data = form.serializeArray();

		$('.error_field').text("");
		$('#loadingData').show();

		$.post("ajouter_individu", data, function (res) {
			if (res.invalid_field == 1) {
				for (var i = res.fields.length - 1; i >= 0; i--) {
					$("." + res.fields[i] + "Error").text("Champs obligatoire");
				}
			} else if (res.success == 1 && mode != 'editNumber') {
				form.submit();
			} else if (res.success == 1 && mode == 'editNumber') {
				form.submit();
				var size = $('#household_size_tab_content').val();
				data = {'size' : size, mode : 'editNumber'};

				$.post('sychrPersonNumber', {data : data}, function(res){
					if (res.error == 0) {
						location.reload();
					}
				}, 'JSON');
			}
			else if (res.error == 1) {
				alert(res.msg);
			}else if (res.error == 0){
				alert(res.msg);
			}
			$('#loadingData').hide();
		}, 'JSON');
	}

	$('.date_type').on('keypress keyup', function (e) {
		var charCode = (e.which) ? e.which : e.keyCode;
		if (charCode == 8) return false;
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

		var index = $('.tab-pane.active').data('index');
		var foo = $(this).val();

		if (foo.length >= 10) {
			return false;
		}

		var foo_tab = foo.split('/');

		if (foo_tab.length == 1 && foo_tab[0].length == 2) {
			if (foo_tab[0] > 31 || foo_tab[0] < 1)
				return false;
			foo = foo_tab[0] + '/';
			$(this).val(foo);
		}
		if (foo_tab.length == 2 && foo_tab[1].length == 2) {
			if (foo_tab[1] > 12 || foo < 1)
				return false;
			foo = foo_tab[0] + '/' + foo_tab[1] + '/';
			$(this).val(foo);
		}

		if (foo_tab.length == 3 && foo_tab[2]) {
			foo = foo_tab[0] + '/' + foo_tab[1] + '/' + foo_tab[2];
			$(this).val(foo);
		}
	});

	$('.cin').on('keypress', function (event) {
		var index = $('.tab-pane.active').data('index');
		var nationality = $('#nationality' + index).val();

		if(nationality == "Malgache" || nationality == 0){
			if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
				event.preventDefault(); // ne pas permettre la saisie de character lettre
			} else {
				var foo = $('#cin' + index).val().split(" ").join("");

				if (foo.length > 0)
					foo = foo.match(new RegExp('.{1,3}', 'g')).join(" ");

				$('#cin' + index).val(foo);
			}
		}
	});

	$('.nationality').on('change', function (event) {
		var index = $('.tab-pane.active').data('index');
		var nationality = this.value;

		$('.cin-container-'+index).hide();
		$('.passport-container-'+index).hide();

		if(nationality == "Malgache" || nationality == '0' )
			$('.cin-container-'+index).show();
		else
			$('.passport-container-'+index).show();
	});

	$('.cin').on('keyup', function (event) {
		var index = $('.tab-pane.active').data('index');
		var cin = $('#cin' + index).val();
		var nationality = $('#nationality' + index).val();

		var length = (nationality == "Malgache" || nationality == 0) ? 15 : 20;

		cin = cin.substring(0, length);

		$('#cin'+index).val(cin);
	});

	$('.last_name').on('keyup', function () {

		var index = $('.tab-pane.active').data('index');
		var foo = $('#last_name' + index).val();

		foo = foo.toUpperCase();

		$('#last_name' + index).val(foo);
	});

	$('.first_name').on('keyup', function () {

		var index = $('.tab-pane.active').data('index');
		var foo = $('#first_name' + index).val();

		if (typeof foo === 'string')
			foo = foo.charAt(0).toUpperCase() + foo.slice(1);

		$('#first_name' + index).val(foo);
	});

	$("#persNext").click(function (e) {
		var index = $('.tab-pane.active').data('index');
		var number = $('.tab-pane.active').data('number');

		$('.error_field').text('');

		$('#loadingData').show();

		var job = ($("#job"+index).val() != 0) ? $("#job"+index).val() : $('#otherJob'+index).val();
		var cin = $("#cin"+index).val();

        var cin_date = $('#cin_date'+index).val();
		var cin_place = $('#cin_place'+index).val();

		$('.cin_date'+index+'Error').text('');
		$('.cin_place'+index+'Error').text('');
		if(cin != ''){
			if(cin_date == ''){
				$('.cin_date'+index+'Error').text('Préciser la date de délivrance de la CIN');
				$('#loadingData').hide();
				return false;
			}
			if(cin_place == ''){
				$('.cin_place'+index+'Error').text('Préciser le lieu de délivrance de la CIN');
				$('#loadingData').hide();
				return false;
			}
		}
		
		if($("#birth" + index).val() == ''){
			$('.birth'+index+'Error').text('Champs obligatoire.');
			$('#loadingData').hide();
			return false;
		}
		if($("#birth_place" + index).val() == ''){
			$('.birth_place'+index+'Error').text('Champs obligatoire.');
			$('#loadingData').hide();
			return false;
		}

		$(".last_name" + index + "Error").text("");
		$(".birth" + index + "Error").text("");
		$(".first_name" + index + "Error").text("");
		$(".parent_link" + index + "Error").text("");
		$(".job" + index + "Error").text("");
		$(".cin" + index + "Error").text("");
		$(".birth_place" + index + "Error").text("");
		$(".cin_date" + index + "Error").text("");

		//Check date
		var dateformat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;

		if(!($("#birth" + index).val()).match(dateformat)){
			$('.birth'+index+'Error').text('Mauvais format de la date');
			return false;
		}
		if($("#cin_date" + index).val() != ''){
			if(!($("#cin_date" + index).val()).match(dateformat)){
				$('.cin_date'+index+'Error').text('Mauvais format de la date');
				return false;
			}
		}

		var last_name = $("#last_name" + index).val();
		var birth = $("#birth" + index).val();
		var first_name = $("#first_name" + index).val();
		var parent_link = ($("#parent_link" + index).val() != 'autre') ? $("#parent_link" + index).val() : $('#otherParentLink' + index).val();
		var job = ($("#job" + index).val() != 0) ? $("#job" + index).val() : $('#otherJob' + index).val();
		var cin = $("#cin" + index).val();
		var birth_place = $("#birth_place" + index).val();
		var cin_date = $("#cin_date" + index).val();
		var cin_place = $("#cin_place" + index).val();

		var data = {
			'last_name': last_name,
			'birth': birth,
			'first_name': first_name,
			'job': job,
			'cin': cin,
			'birth_place': birth_place,
			'cin_date': cin_date,
			'cin_place': cin_place
		};

		$.get('verifier_champs', data, function (res) {
			date_cin_mineur = false;
			is_date_sup_now = false;
			var date_now = new Date(new Intl.DateTimeFormat('en-US').format(new Date()));
			if (birth && cin_date) {
				if (age(birth, cin_date) < 16) {
					date_cin_mineur = true;
				}
			}
			if (parseInt(convertDate(cin_date).getTime()) >= parseInt(date_now.getTime())) {
				is_date_sup_now = true;
			}
			else if (res.error == 1 || date_cin_mineur || is_date_sup_now) {
				if (res.all_empty == 1) {
					$(".last_name" + index + "Error").text("Champs obligatoire");
					$(".birth" + index + "Error").text("Champs obligatoire");
					$(".first_name" + index + "Error").text("Champs obligatoire");
				} else if (res.name_empty == 1) {
					$(".last_name" + index + "Error").text("Champs obligatoire");
					$(".first_name" + index + "Error").text("Champs obligatoire");
				} else if (res.birth_empty == 1) {
					$(".birth" + index + "Error").text("Champs obligatoire");
				} else if (res.birth_place_empty == 1) {
					$(".birth_place" + index + "Error").text("Champs obligatoire");
				} else if (res.pl_empty == 1) {
					$(".parent_link" + index + "Error").text("Champs obligatoire");
				} else if (res.job_empty == 1) {
					$(".job" + index + "Error").text("Champs obligatoire");
				} else if (res.cin_empty == 1) {
					$(".cin" + index + "Error").text("Le numéro CIN ne doit pas contenir de lettres et doit être composé de  12 chiffres.");
				} else if (date_cin_mineur) {
					$(".cin_date" + index + "Error").text("Vérifier la date de la CIN. Une personne mineure ne peut pas avoir une CIN.");
				} else if (is_date_sup_now) {
					$(".cin_date" + index + "Error").text("La date de délivrance de la CIN ne doit pas être supérieure ou égale à la date actuelle.");
				}else if(res.cin_must){
					$(".cin" + index + "Error").text("Si les champs Date et/ou Lieu CIN sont indiqués, le numéro CIN est obligatoire.");
				}else if(res.cin_date_must){
					$(".cin_date" + index + "Error").text("Si les champs Numéro et/ou Lieu CIN sont indiqués, la date CIN est obligatoire.");
				}else if(res.cin_place_must){
					$(".cin_place" + index + "Error").text("Si les champs Numéro et/ou Date CIN sont indiqués, le lieu CIN est obligatoire.");
				}
				$('#loadingData').hide();
			} else {
				if (index == number) {
					submitForm();
				}else{
					if ((number - index) == 1) {
						$("#persNext strong").text('Valider les entrées');
					}

					$('#pers' + index).removeClass('active show');
					$('#pers' + (index + 1)).addClass('active show');
					$('#pers' + index + "-tab").removeClass('active show');
					$('#pers' + (index + 1) + "-tab").addClass('active show');

					$("html").scrollTop(0);

					$('#loadingData').hide();
				}
			}
		}, 'JSON');
	});

	$(document).on('click',"#persPrec",function (e) {
		var index = $('.tab-pane.active').data('index');
		if (index <= 1) return true;

		$('#persNext strong').text('Personne suivante');

		$('#pers' + index).removeClass('active show');
		$('#pers' + (index - 1)).addClass('active show');
		$('#pers' + index + "-tab").removeClass('active show');
		$('#pers' + (index - 1) + "-tab").addClass('active show');
	});

	$('.household_head').change(function (e) {
		var index = $('.tab-pane.active').data('index');
		var number = $('.tab-pane.active').data('number');

		if ($(this).val() == 1) {
			for (var i = 1; i <= number; i++)
				if (i != index) $('#household_head' + i).prop('disabled', 'disabled');
		} else $('.household_head').removeAttr('disabled');
	});

	$('.parent_link').change(function (e) {
		var index = $('.tab-pane.active').data('index');
		if ($(this).val() == 'autre')
			$('#otherParentLink' + index).show();
		else $('#otherParentLink' + index).hide();
	});

	$('.job').change(function (e) {
		var index = $('.tab-pane.active').data('index');
		if ($(this).val() == 0)
			$('#otherJob' + index).show();
		else $('#otherJob' + index).hide();
	});

	$('#houseSizeAdd').click(function(e){
		var cfrm = confirm("Voulez-vous vraiment ajouter une autre personne?");

		if(cfrm){
			$('#changeData').show();
			var number = parseInt($('#household_size_tab_content').text());
			number += 1;

			$.post('changer_nombre_personnes', {number: number, operation : 1}, function(res){
				if(res.success == 1){
					$('.tab-pane').attr('data-number', number);
					$('#household_size_tab_content').text(number);
					
					$('#myTab').append(res.tabs_nav);
					$('#myTabContent').append(res.tabs_content);
				}
				else if(res.error == 1) alert(res.msg);

				$('#changeData').hide();
			},'JSON')
			.fail(function () {
				alert('Une erreur est survenue. Contacter le responsable.');
				$('#changeData').hide();
			});
		}
	});

	$('#houseSizeRemove').click(function(e){
		var number = parseInt($('#household_size_tab_content').text());
		var index = $('.tab-pane.active').data('index');
		var cfrm = confirm("Voulez-vous vraiment supprimer la personne n°"+ number +"?");

		if(cfrm){
			$('#changeData').show();
			number -= 1;

			$.post('changer_nombre_personnes', {number: number, operation : -1}, function(res){
				if(res.success == 1){
					if(index == res.index_remove){
						$('#pers' + number).addClass('active show');
						$('#pers' + number + "-tab").addClass('active show');
					}
					$('.tab-pane').attr('data-number', number);
					$('#household_size_tab_content').text(number);
					$('#itemPerson'+res.index_remove).remove();
					$('#pers'+res.index_remove).remove();
				}
				else if(res.error == 1) alert(res.msg);
				$('#changeData').hide();
			},'JSON')
			.fail(function () {
				alert('Une erreur est survenue. Contacter le responsable.');
				$('#changeData').hide();
			});
		}
	});
});


function age(d1, d2) {
	var diff = convertDate(d2).getTime() - convertDate(d1).getTime();
	return Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25));
}

function convertDate(d) {
	var day = parseInt(d.substring(0, 2));
	var month = parseInt(d.substring(3, 5));
	var year = parseInt(d.substr(-4));
	var str_date = (month < 10 ? '0' : '') + month + '/' + (day < 10 ? '0' : '') + day + '/' + year;

	var date_Obj = new Date(str_date);

	return date_Obj;
}
