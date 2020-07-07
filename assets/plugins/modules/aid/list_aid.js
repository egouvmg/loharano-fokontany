$(function () {
    var household_head = function (cell, formatterParams) {
		return cell.getRow().getData().nom + ' ' + cell.getRow().getData().prenoms;
    };

    var types = function (cell, formatterParams) {
        var value = cell.getValue();

        switch (value) {
            case "1": return "Vivres"; break;
            case "2": return "Cash"; break;
        }
    };

    var payment_types = function (cell, formatterParams) {
        var value = cell.getValue();

        switch (value) {
            case 1: return "M'Vola"; break;
            case 2: return "Orange Money"; break;
            case 3: return "Airtel Money"; break;
            case 4: return "Virement bancaire"; break;
            case 5: return "Compte Paositra Money"; break;
        }
    };

    var banks = function (cell, formatterParams) {
        var value = cell.getValue();

        switch (value) {
            case 1: return "BNI"; break;
            case 2: return "BFV"; break;
            case 3: return "BOA"; break;
            case 4: return "Access Banque"; break;
            case 5: return "BMOI"; break;
            case 6: return "BGFI"; break;
            case 7: return "Sipem Banque"; break;
        }
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
        paginationSize:7,
        paginationSizeSelector:[7, 15, 30, 100, 200],
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
                "ajax": {
                    "loading": "Chargement",
                    "error": "Erreur"
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

	var aids = new Tabulator("#aidsContent", {
        layout:"fitColumns",
		initialSort:[
			{column:"created_on", dir:"desc"}
		],
        columns:[ //Define Table Columns
            {title:"Aide reçue", field:"name",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Type", field: "type", width:100, formatter: types, headerFilter:true, headerFilterParams:{values:{1:"Vivres", 2:"Cash", "":""}}},
            {title:"Date", field:"created_on", width:100, headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Mode de virement", field: "payment_type", width:160, formatter: payment_types, headerFilter:true, headerFilterParams:{values:{1:"Vivres", 2:"Cash", "":""}}},
            {title:"Téléphone", field:"phone", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Banque", field:"bank", width:100, formatter: banks, headerFilter:true, headerFilterParams:{values:{1:"Vivres", 2:"Cash", "":""}}},
            {title:"N° de compte", field:"rib", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"N° de compte Paositra Money", field:"paositra_account", headerFilterPlaceholder:"..." , headerFilter:"input"},
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
                "ajax": {
                    "loading": "Chargement",
                    "error": "Erreur"
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
    aids.setLocale("fr-fr");

    $('#addAid').click(function(e){
        e.preventDefault();

        $('#aidType').hide();
        $('#aidMobileMoney').hide();
        $('#aidBank').hide();
        $('#aidPaositra').hide();

        if($('#numero_carnet').val() == '') alert('Choisissez un ménage');
        else{
            var aid_id = $('#aid').val();

            $.get('typa_aide', {aid_id:aid_id}, function(res){
                if(res.success == 1){
                    $('#type').val(res.type_name);
                    $('#description').val(res.description);

                    if(res.type == 2){
                        $('#aidType').show();
                        $('#aidMobileMoney').show();
                    }
                }
                if(res.error == 1){
                    alert(res.msg);
                }
                $('#aidModal').modal();
            }, 'JSON')
            .fail(function(){
                alert('Erreur sur le serveur. Veuillez réessayer ultérieurement.');
            });
        }
    });

    $('#validAid').click(function(e){
        e.preventDefault();
        
        $('.error_field').text('');

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
                alert(res.msg);
                $('#aidModal').modal('hide');
                aids.setData();
            }
        
            $('#validAid').prop('disabled', false);
            $('#loadingSave').hide();

        }, 'JSON');
    });
    
    $(document).on('change', '#payment_type', function(e){
        e.preventDefault();

        if($(this).val() < 4){
            $('#aidMobileMoney').show();
            $('#aidBank').hide();
            $('#aidPaositra').hide();
        }
        else if($(this).val() == 4){
            $('#aidMobileMoney').hide();
            $('#aidBank').show();
            $('#aidPaositra').hide();
        }
        else if($(this).val() == 5){
            $('#aidMobileMoney').hide();
            $('#aidBank').hide();
            $('#aidPaositra').show();
        }
    });

    $(document).on('change', '#aid', function(e){
        e.preventDefault();

        $('#aidType').hide();
        $('#aidMobileMoney').hide();
        $('#aidBank').hide();

        var aid_id = $(this).val();

        $.get('typa_aide', {aid_id:aid_id}, function(res){
            if(res.success == 1){
                $('#type').val(res.type_name);
                $('#description').val(res.description);

                if(res.type == 2){
                    $('#aidType').show();
                    $('#aidMobileMoney').show();
                }
            }
            if(res.error == 1){
                alert(res.msg);
            }
            $('#aidModal').modal();
        }, 'JSON')
        .fail(function(){
            alert('Erreur sur le serveur. Veuillez réessayer ultérieurement.');
        });
    });

    $(document).ready(function () {
        $('#phone').usPhoneFormat({
            format: 'xxx'
        });
    });
});