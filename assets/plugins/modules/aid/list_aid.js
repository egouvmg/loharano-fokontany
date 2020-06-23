$(function () {
    var household_head = function (cell, formatterParams) {
		return cell.getRow().getData().nom + ' ' + cell.getRow().getData().prenoms;
    };
    
	var households = new Tabulator("#households", {
        layout:"fitColumns",
		ajaxURL: "liste_menages_fokontany",
        ajaxConfig: "GET",
        selectable:1,
		initialSort:[
			{column:"numero_carnet", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Numéro Carnet", field:"numero_carnet", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Adresse", field:"adresse_actuelle", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Date d'arrivée", field:"date_arrivee", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Chef ménage", field:"chef_menage", formatter: household_head ,headerFilterPlaceholder:"..." , headerFilter:"input"}         
        ],
        rowClick:function(e, row){
            $('.household').text(row.getData().numero_carnet);
            $('#numero_carnet').val(row.getData().numero_carnet);

            aids.setData('aide_par_menage', {numero_carnet:row.getData().numero_carnet});
        },
        pagination:"local",
        paginationSize:15,
        paginationSizeSelector:[15, 30, 100, 200],
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

	var aids = new Tabulator("#aidsContent", {
        layout:"fitColumns",
		initialSort:[
			{column:"created_on", dir:"desc"}
		],
        columns:[ //Define Table Columns
            {title:"Aide reçue", field:"name",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Date", field:"created_on", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Description", field:"description", headerFilterPlaceholder:"..." , headerFilter:"input"}       
        ],
        rowClick:function(e, row){
        },
        pagination:"local",
        paginationSize:10,
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
            }
        }
    });

    $('#addAid').click(function(e){
        e.preventDefault();

        if($('#numero_carnet').val() == '') alert('Choisissez un ménage');
        else $('#aidModal').modal();
    });

    $('#validAid').click(function(e){
        e.preventDefault();
        
        $(this).prop('disabled', true);
        $('#loadingSave').show();

        var data = $('#aidForm').serializeArray();

        $.post('ajout_aide', data, function(res){
            if(res.error === 1){
                if(res.missing_fields){
                    $.each( res.missing_fields, function( key, value ) {
                        $('.error_' + value[0]).text(value[1]);
                    });
                }
            }

            if(res.success === 1){
                $('#aidModal').modal('hide');
            }
        
            $('#validAid').prop('disabled', false);
            $('#loadingSave').hide();

        }, 'JSON');
    });
});