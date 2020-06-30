$(function () {

    var types = function (cell, formatterParams) {
        var value = cell.getValue();

        switch (value) {
            case "1": return "Vivres"; break;
            case "2": return "Cash"; break;
        }
    };
 
	var users = new Tabulator("#aids", {
        layout:"fitColumns",
		ajaxURL: "liste_aides",
		ajaxConfig: "GET",
		initialSort:[
			{column:"name", dir:"asc"}
		],          
        columns: [ //Define Table Columns
            { title: "Nom", field: "name", width:200, headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Type", field: "type", width:100, formatter: types, headerFilter:true, headerFilterParams:{values:{1:"Vivres", 2:"Cash", "":""}}},
            { title: "Description", field: "description", headerFilterPlaceholder: "...", headerFilter: "input" }
        ],
        pagination:"local",
        paginationSize:5,
        paginationSizeSelector:[5, 10, 20, 50, 100, 200],
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
        },
    });

    $("#validAid").click(function (e) {
        e.preventDefault();
        
        $('.error_field').text('');
        
        $(this).prop('disabled', true);
        $('#loadingSave').show();

        var data = $('#addAid').serializeArray();

        $.post('ajouter_aide', data, function(res){
            if(res.failed === 1){
                if(res.missing_fields){
                    $.each( res.missing_fields, function( key, value ) {
                        $('.error_' + value[0]).text(value[1]);
                    });
                }
            }

            if(res.success === 1){
                users.setData();
            }
            if(res.error === 1) alert(res.msg);
        
            $('#validAid').prop('disabled', false);
            $('#loadingSave').hide();
        }, 'JSON')
        .fail(function(){
            alert('Erreur sur serveur. Veuillez réessayer ultérieurement.');
        });

    });
});