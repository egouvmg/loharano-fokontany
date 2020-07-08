$(function () {
    var household_head = function (cell, formatterParams) {
		return cell.getRow().getData().nom + ' ' + cell.getRow().getData().prenoms;
    };

    var is_household_head = function (cell, formatterParams) {
        return (cell.getValue()) ? 'Oui' : 'Non';
    };

	var households = new Tabulator("#households", {
        layout:"fitColumns",
		ajaxURL: "liste_menages_fokontany",
		ajaxConfig: "GET",
		initialSort:[
			{column:"medal", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Numéro Carnet", field:"numero_carnet"},
            {title:"Adresse", field:"adresse_actuelle"},
            {title:"Chef ménage", width:300, field:"chef_menage", formatter: household_head}         
        ],
        rowClick:function(e, row){
            $('#autre_fokontany').val(row.getData().fokontany_id);
            $('#numero_canret').val(row.getData().numero_carnet);
            $('#adresse_actuelle').val(row.getData().adresse_actuelle);
            $('#nom_info').val(row.getData().nom + ' ' + row.getData().prenoms);

            $('#personDetails').modal();
        },
        pagination:"remote", //enable remote pagination
        paginationSize:10,
        paginationSizeSelector:[10, 20, 50, 100, 200],
        ajaxFiltering:true,
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
                    "page_size":"Taille de page",
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

    households.setLocale("fr-fr");

    $('.speed_access').on('keyup change', function(e){
        if($(this).val().length < 4) return false;

        var data = {
            nom:$('#nom').val(),
            prenoms:$('#prenoms').val(),
            cin_personne:$('#cin_personne').val()
        }

        households.setData('liste_menages_fokontany', data);
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
        if(mydate != 'undefined'){
            var from = mydate.split("/");
            return  from[2] +'-'+ from[1] +'-'+ from[0];
        }
        return '';
    }

    $('#validMigrate').click(function(e){
        e.preventDefault();
        $('.error_field').text('');

        var data = $('#formEditPerson').serializeArray();

        $.post('valider_migration_vers_menage', data, function(res){
            if(res.error == 1) alert(res.msg);
            if(res.success == 1){
                $('#confirmResponse').text(res.msg);
                $('#confirmationModal').modal();
            }
        }, 'JSON');
    });
});