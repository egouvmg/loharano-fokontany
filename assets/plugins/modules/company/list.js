$(function(){
    var fokontany_id = $('#fokontany').val();

    function loadListPersons(){
        var fokontany_id = $('#fokontany').val();
        listPersons.setData('liste_par_fokontany', {fokontany_id:fokontany_id});
    }

    var handicapped = function(cell, formatterParams){
        var value = cell.getValue();

        switch(value){
            case 1:return "Oui"; break; 
            case 2:return "Non"; break; 
            case 0:return "Non"; break; 
        }
    };

    var sexe = function(cell, formatterParams){
        var value = cell.getValue();
        
        switch(value){
            case 1:return "Masculin"; break; 
            case 0:return "Féminin"; break; 
        }
    };

    var listPersons = new Tabulator("#example-table", {
        layout:"fitColumns", //fit columns to width of table (optional)
        ajaxURL:"liste_par_fokontany", //ajax URL
        ajaxParams:{fokontany_id:fokontany_id}, //ajax parameters
        ajaxConfig:"POST", //ajax HTTP request type   
        pagination:"local",
        paginationSize:25,
        paginationSizeSelector:[25, 50, 100, 200],
        langs:{
            "fr-fr":{ //French language definition
                "columns":{
                    "name":"Nom",
                    "progress":"Progression",
                    "gender":"Genre",
                    "rating":"Évaluation",
                    "col":"Couleur",
                    "dob":"Date de Naissance",
                },
                "pagination":{
                    "first":"Premier",
                    "first_title":"Première Page",
                    "last":"Dernier",
                    "last_title":"Dernière Page",
                    "prev":"Précédent",
                    "prev_title":"Page Précédente",
                    "next":"Suivant",
                    "next_title":"Page Suivante",
                },
            },
            "de-de":{ //German language definition
                "columns":{
                    "name":"Name",
                    "progress":"Fortschritt",
                    "gender":"Genre",
                    "rating":"Geschlecht",
                    "col":"Farbe",
                    "dob":"Geburtsdatum",
                },
                "pagination":{
                    "first":"Zuerst",
                    "first_title":"Zuerst Seite",
                    "last":"Last",
                    "last_title":"Letzte Seite",
                    "prev":"Zurück",
                    "prev_title":"Zurück Seite",
                    "next":"Nächster",
                    "next_title":"Nächster Seite",
                },
            },
        },
		initialSort:[
			{column:"pdf_file", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Référence registre", field:"reference", width:150,headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Fichier PDF", field:"pdf_file",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Nom", field:"last_name",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Prénom(s)", field:"first_name",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Sexe", field:"sexe", formatter: sexe, width:80, headerFilter:true, headerFilterParams:{values:{1:"Masculin", 0:"Féminin", "":""}}},
            {title:"Adresse", field:"address",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Numéro CIN", field:"cin",headerFilterPlaceholder:"...", headerFilter:"input", width:150},
            {title:"Handicapé(e)", field:"handicapped",formatter:handicapped, width:100, headerFilter:true, headerFilterParams:{values:{1:"Oui", 0:"Non", "":""}}},
            {title:"Profession", field:"profession_name",headerFilterPlaceholder:"..." , headerFilter:"input"}
        ],
        rowClick:function(e, row){
            $('#full_name').text(row.getData().last_name +' '+ row.getData().first_name);
            $('#last_name').val(row.getData().last_name);
            $('#first_name').val(row.getData().first_name);
            $('#sexe').val(row.getData().sexe);
            $('#handicapped').val(row.getData().handicapped);
            $('#address').val(row.getData().address);
            $('#cin').val(row.getData().cin);
            $('#cin_date').val(row.getData().cin_date);
            $('#cin_place').val(row.getData().cin_place);
            $('#birth').val(row.getData().birth);
            $('#birth_place').val(row.getData().birth_place);
            $('#job').val(row.getData().job);
            $('#phone').val(row.getData().phone);
            $('#job_status').val(row.getData().job_status);
            $('#observation').val(row.getData().observation);
            $('#nationality').val(row.getData().nationality);
            $('#father').val(row.getData().father);
            $('#father_status').val(row.getData().father_status);
            $('#mother').val(row.getData().mother);
            $('#mother_status').val(row.getData().mother_status);
            $('#person_id').val(row.getData().person_id);
            $('#parent_link').val(row.getData().parent_link);
            $('#marital_status').val(row.getData().marital_status);
            $('#passport').val(row.getData().passport);
            $('#passport_date').val(row.getData().passport_date);
            $('#passport_place').val(row.getData().passport_place);
            $('#pdf_file').val(row.getData().pdf_file);

            $('#otherJob').hide();
            $('#otherParentLink').hide();

            if(row.getData().job == 0){
                $('#otherJob').val(row.getData().profession_name);
                $('#job').val(0);
                $('#otherJob').show();
            }

            if(row.getData().parent_link != 'mere' && row.getData().parent_link != 'pere' && row.getData().parent_link != 'fille' && row.getData().parent_link != 'fils' && row.getData().parent_link != 0){
                $('#otherParentLink').val(row.getData().parent_link);
                $('#parent_link').val('autre');
                $('#otherParentLink').show();
            }

            $('.cin-container').hide();
            $('.passport-container').hide();

            if(row.getData().nationality == "Malgache")
                $('.cin-container').show();
            else
                $('.passport-container').show();

            $('#personDetails').modal();
        },
    });

    listPersons.setLocale("fr-fr");

	$('#nationality').on('change', function (event) {
		var nationality = this.value;

		$('.cin-container').hide();
		$('.passport-container').hide();

		if(nationality == "Malgache")
			$('.cin-container').show();
		else
			$('.passport-container').show();
	});

	$("#fokontany").change(function(e){
        $('#loadingData').show();
        $.get('fokontany_personnes', {fokontany_id : this.value}, function(res){
            if(res.success == 1){
                var difference = res.total_drf.t_people - res.total_drf.nbr_people;
                $('#treatyPeople').val(res.total_drf.nbr_people);      
                $('#treatPeople').val(difference);      
                loadListPersons();
            }else alert('Impossible de charger les données');
            $('#loadingData').hide();
        },'JSON')
        .fail(function () {
            alert('Une erreur est survenue. Contacter le responsable.');
        });
    });

	$('.cin').on('keypress', function (event) {
		if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
			event.preventDefault(); // ne pas permettre la saisie de character lettre
		} else {
			var foo = $('#cin').val().split(" ").join("");

			if (foo.length > 0) {
				foo = foo.match(new RegExp('.{1,3}', 'g')).join(" ");
			}
			$('#cin').val(foo);
		}
    });
    
    
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

    $(document).on('click', '#validEditPerson', function(e){
        e.preventDefault();
        
        $('#loadingSaveData').show();
        $('.error_field').text('');

        var cin = $("#cin").val();

        var cin_date = $('#cin_date').val();
		var cin_place = $('#cin_place').val();

		$('.cin_dateError').text('');
        $('.cin_placeError').text('');
        $('.cinError').text('');

        if(cin != ''){
            if(cin.length != 15){
                $('.cinError').text('Le numéro CIN ne doit pas contenir de lettres et doit être composé de  12 chiffres.');
                $('#loadingSaveData').hide();
				return false;
            }
			if(cin_date == ''){
                $('.cin_dateError').text('Préciser la date de délivrance de la CIN');
                $('#loadingSaveData').hide();
				return false;
			}
			if(cin_place == ''){
                $('.cin_placeErro').text('Préciser le lieu de délivrance de la CIN');
                $('#loadingSaveData').hide();
				return false;
			}
		}

        //Check date
		var dateformat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;

		if(!($("#birth").val()).match(dateformat)){
            $('.birthError').text('Mauvais format de la date');
            $('#loadingSaveData').hide();
			return false;
		}
		if($("#cin_date").val() != ''){
			if(!($("#cin_date").val()).match(dateformat)){
                $('.cin_dateError').text('Mauvais format de la date');
                $('#loadingSaveData').hide();
				return false;
			}
		}
        
        var data = $('#formEditPerson').serializeArray();

        $.post('verifier_personnne', data, function(res){
            if(res.required == 1){
                for (let index = 0; index < res.missing.length; index++) {
                    $('.'+res.missing[index]+'Error').text('Champs obligatoire');
                }
            }
            else if(res.success == 1){
                alert('Modification terminée. Rechargement de la liste');
                location.reload();
            }
            else if(res.error ==1) alert(res.msg);

            $('#loadingSaveData').hide();
        },'JSON')
        .fail(function () {
            alert('Une erreur est survenue. Contacter le responsable.');
        });
    });

    $(document).ready(function () {
    
        $('#phone').keypress(function (event) {
    
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
    });  

	$('#parent_link').change(function (e) {
		if ($(this).val() == 'autre')
			$('#otherParentLink').show();
		else $('#otherParentLink').hide();
	});

	$('#job').change(function (e) {
		if ($(this).val() == 0)
			$('#otherJob').show();
		else $('#otherJob').hide();
    });
    
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
});

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