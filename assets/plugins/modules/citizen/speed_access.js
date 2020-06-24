$(function () {
	var citizens = new Tabulator("#citizens", {
        layout:"fitColumns",
		initialSort:[
			{column:"nom", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Numéro Cranet", field:"numero_carnet", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Adresse", field:"adresse_actuelle", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Nom", field:"nom",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Prénoms", field:"prenoms",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Date de Naissance", field:"date_de_naissance", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Lieu de Naissance", field:"lieu_de_naissance", headerFilterPlaceholder:"..." , headerFilter:"input"}, 
            {title:"Numéro cin", field:"cin_personne", headerFilterPlaceholder:"..." , headerFilter:"input"},          
        ],
        rowClick:function(e, row){
            $('.error_field').text('');
            $('#nom_complet').text(row.getData().nom + ' ' + row.getData().prenoms);
            $('#numero_carnet').val(row.getData().numero_carnet);
            $('#adresse_actuelle').val(row.getData().adresse_actuelle);
            $('#nom_info').val(row.getData().nom);
            $('#prenoms_info').val(row.getData().prenoms);
            $('#sexe').val(row.getData().sexe);
            $('#cin_personne_info').val(row.getData().cin_personne);
            $('#date_delivrance_cin').val(splitDate(row.getData().cin_date));
            $('#lieu_delivrance_cin').val(row.getData().cin_place);
            $('#date_de_naissance').val(splitDate(row.getData().date_de_naissance));
            $('#lieu_de_naissance').val(row.getData().lieu_de_naissance);
            $('#father').val(row.getData().father);
            $('#father_status').val(row.getData().father_status);
            $('#mother').val(row.getData().mother);
            $('#mother_status').val(row.getData().mother_status);
            $('#phone').val(row.getData().phone);
            $('#job').val(row.getData().job);
            $('#job_status').val(row.getData().job_status);
            $('#situation_matrimoniale').val(row.getData().situation_matrimoniale);
            $('#id_personne').val(row.getData().id_personne);

            $('#certificat_residence').attr("href", "certificate?id_personne="+row.getData().id_personne);
            $('#certificat_move').attr("href", "certificate_move?id_personne="+row.getData().id_personne);
            $('#certificat_celibat').attr("href", "certificate_celibat?id_personne="+row.getData().id_personne);
            $('#certificat_life').attr("href", "certificate_life?id_personne="+row.getData().id_personne);
            $('#certificat_supported').attr("href", "certificate_supported?id_personne="+row.getData().id_personne);
            $('#certificat_behavior').attr("href", "certificate_behavior?id_personne="+row.getData().id_personne);

            $('#personDetails').modal();
        },
        pagination:"local",
        paginationSize:10,
        paginationSizeSelector:[10, 20, 50, 100, 200],
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
            }
        }
    });

    $('.speed_access').on('keyup change', function(e){
        var data = $('#speedForm').serializeArray();

        $.get('recherche_rapide', data, function(res){
            $('#citizens').show();
            if(res.success == 1){
                citizens.setData(res.data);

                if(res.data.length == 0) $('#createHousehold').show();
                else $('#createHousehold').hide();
            }
            else alert(res.msg);
        }, 'JSON');
    });

	$('#nom').on('keyup', function () {
		var foo = $(this).val();

		foo = foo.toUpperCase();

		$(this).val(foo);
	});

	$('#prenoms').on('keyup', function () {
		var foo = $(this).val();

		if (typeof foo === 'string')
			foo = foo.charAt(0).toUpperCase() + foo.slice(1);

        $(this).val(foo);
    });
    
	$('.cin_personne').on('keypress', function (event) {
        if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
            event.preventDefault(); // ne pas permettre la saisie de character lettre
        } else {
            var foo = $(this).val().split(" ").join("");

            if (foo.length > 0)
                foo = foo.match(new RegExp('.{1,3}', 'g')).join(" ");

            $(this).val(foo);
        }
	});

    $(document).ready(function () {
        $('#phone').usPhoneFormat({
            format: 'xxx xx xxx xx',
        });
    });

    function splitDate(mydate){
        console.log(mydate);
        if(mydate != ''){
            var from = mydate.split("/");
            return  from[2] +'-'+ from[1] +'-'+ from[0];
        }
        return '';
    }

    $('#validEditPerson').click(function(e){
        e.preventDefault();
        $('.error_field').text('');

        var data = $('#formEditPerson').serializeArray();

        $.post('modifier_citoyen', data, function(res){
            if(res.failed == 1){
                $.each( res.missing_fields, function( key, value ) {
                    $('.'+value[0]+'Error').text(value[1]);
                });
            }
            if(res.error == 1) alert(res.msg);
            if(res.success == 1) alert(res.msg);
        }, 'JSON');
    });
});