$(document).ready(function () {
	let numberPersonne = $("#myTab li").length;
	if (numberPersonne == 1) {
		var x = document.getElementById("household_head1");
		x.options[0] = null;
	}

	$('[id^=phone]').keypress(function (event) {

		if (event.keyCode == 32 || (event.which != 8 && isNaN(String.fromCharCode(event.which)))) {
			event.preventDefault(); // ne pas permettre la saisie de character lettre
		} else {
			let v_num = $(this).val();
			if (v_num.length <= 40) {
				ids = $(this).attr('id');
				if (v_num.includes(';')) {
					let tmp = v_num.split(';');
					if (tmp[tmp.length - 1].length <= 13) {
						verify(tmp[tmp.length - 1], ids, false);
					}
				} else {
					verify(v_num, ids, true)
				}
			} else {
				$(this).val(v_num.substring(0, 40));
			}
		}
	});
})

function controlFilsFille(id, idSexe) {
	$(id).change(function (e) {
		$(this).val() == "fils" || $(this).val() == "pere" ? $(idSexe).val(1) : $(this).val() == "fille" || $(this).val() == "mere" ? $(idSexe).val(0) : $(idSexe).val(2);

		var x = document.getElementById(idSexe.replace('#', ''));

		if ($(this).val() == "fils" || $(this).val() == "pere") {
			$(idSexe).val(1);
			x.options[2].disabled = true;
			x.options[1].disabled = false;
		} else if ($(this).val() == "fille" || $(this).val() == "mere") {
			$(idSexe).val(0);
			x.options[1].disabled = true;
			x.options[2].disabled = false;
		} else {
			$(idSexe).val(2);
			x.options[1].disabled = false;
			x.options[2].disabled = false;
		}

	});
}

function controlBirthAndCinDate(index) {

	$(".cin_date" + index + "Error").text("");

	var cin_date = $("#cin_date" + index).val();
	var birth = $("#birth" + index).val();

	var d_now = new Date(new Intl.DateTimeFormat('en-US').format(new Date()));

	if (age(birth, cin_date) < 16) {
		$(".cin_date" + index + "Error").text("Vérifier la date de la CIN. Une personne mineure ne peut pas avoir une CIN.");
	} else $(".cin_date" + index + "Error").text("");

	if (convertDate(cin_date).getTime() >= d_now.getTime()) {

		var month = d_now.getMonth() + 1;
		var day = d_now.getDate();
		var year = d_now.getFullYear();

		var str_date_now = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + year;

		$("#cin_date" + index).val(str_date_now);
		$(".cin_date" + index + "Error").text("La date de délivrance de la CIN ne doit pas être supérieure ou égale à la date actuelle.");
	}
}

function verify(interDate, classes, suite) {

	if (interDate.length <= 13) {
		if (interDate.length == 3) {
			if (interDate.slice(2) == '') {
				suite == true ? $('#' + classes).val(interDate.slice(0, -1)) : $('#' + classes).val($('#' + classes).val().slice(0, -1));
			} else
				suite == true ? $('#' + classes).val(interDate + ' ') : $('#' + classes).val($('#' + classes).val() + ' ');
		}
		if (interDate.length == 6) {
			if (interDate.slice(5) == '') {
				suite == true ? $('#' + classes).val(interDate.slice(0, -1)) : $('#' + classes).val($('#' + classes).val().slice(0, -1));
			} else
				suite == true ? $('#' + classes).val(interDate + ' ') : $('#' + classes).val($('#' + classes).val() + ' ');
		}

		if (interDate.length == 10) {
			if (interDate.slice(9) == '') {
				suite == true ? $('#' + classes).val(interDate.slice(0, -1)) : $('#' + classes).val($('#' + classes).val().slice(0, -1));
			} else
				suite == true ? $('#' + classes).val(interDate + ' ') : $('#' + classes).val($('#' + classes).val() + ' ');
		}
		if (interDate.length == 13) {
			if (interDate.slice(12) == ';') {
				suite == true ? $('#' + classes).val(interDate.slice(0, -1)) : $('#' + classes).val($('#' + classes).val().slice(0, -1));
			} else
				suite == true ? $('#' + classes).val(interDate + ';') : $('#' + classes).val($('#' + classes).val() + ';');
		}
	}
}

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
