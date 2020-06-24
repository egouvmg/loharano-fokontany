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
            {title:"Numéro Carnet", field:"numero_carnet", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Adresse", field:"adresse_actuelle", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Date d'arrivée", field:"date_arrivee", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Chef ménage", field:"chef_menage", formatter: household_head ,headerFilterPlaceholder:"..." , headerFilter:"input"}         
        ],
        rowClick:function(e, row){
            citizens.setData('membres_menage', {numero_carnet:row.getData().numero_carnet});
        },
        pagination:"local",
        paginationSize:25,
        /*paginationSizeSelector:[25, 50, 100, 200],
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
        }*/
    });

	var citizens = new Tabulator("#householdContent", {
        layout:"fitColumns",
		initialSort:[
			{column:"chef_menage", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Chef", field:"chef_menage", formatter: is_household_head},
            {title:"Nom", field:"nom",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Prénoms", field:"prenoms",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Numéro cin", field:"cin_personne", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Date de Naissance", field:"date_de_naissance", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Lieu de Naissance", field:"lieu_de_naissance", headerFilterPlaceholder:"..." , headerFilter:"input"} ,
            { title: "id_personne", field: "person_id", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "situation_matrimoniale", field: "situation_matrimoniale", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "parent_link", field: "parent_link", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "handicapped", field: "handicape", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "nationalite", field: "nationalite", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "cin_date", field: "date_delivrance_cin", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "cin_place", field: "lieu_delivrance_cin", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "job", field: "job", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "job_status", field: "job_status", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "phone", field: "phone", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },           
            { title: "numero_carnet", field: "numero_carnet", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "sexe", field: "sexe", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },          
            { title: "father_status", field: "father_status", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "job_id", field: "job_id", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "job_status", field: "job_status", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "mother_status", field: "mother_status", headerFilterPlaceholder: "...", headerFilter: "input", visible: false }           
        ],
        rowClick:function(e, row){
            $('#full_name').text(row.getData().nom +' '+ row.getData().prenoms);
            $('#last_name').val(row.getData().nom);
            $('#first_name').val(row.getData().prenoms);
            $('#sexe').val(row.getData().sexe);
            $('#handicapped').val(row.getData().handicape===false?0:1);
            $('#address').val(row.getData().adresse_actuelle);
            $('#cin').val(row.getData().cin_personne);
            $('#cin_date').val(row.getData().date_delivrance_cin);
            $('#cin_place').val(row.getData().lieu_delivrance_cin);
            $('#birth').val(row.getData().date_de_naissance);
            $('#birth_place').val(row.getData().lieu_de_naissance);
            $('#job').val(row.getData().job_id);
            $('#job_status').val(row.getData().job_status);
            $('#phone').val(row.getData().phone);
            $('#observation').val(row.getData().observation);
            $('#nationality').val(row.getData().nationalite);
            $('#father').val(row.getData().father);
            $('#father_status').val(row.getData().father_status);
            $('#mother').val(row.getData().mother);
            $('#mother_status').val(row.getData().mother_status);
            $('#person_id').val(row.getData().person_id);
            $('#parent_link').val(row.getData().parent_link);
            $('#marital_status').val(row.getData().situation_matrimoniale);
            $('#passport').val(row.getData().passport);
            $('#passport_date').val(row.getData().passport_date);
            $('#passport_place').val(row.getData().passport_place);
            $('#pdf_file').val(row.getData().pdf_file);
            $('#numero_carnet').val(row.getData().numero_carnet);
            $('#marital_status').val(row.getData().situation_matrimoniale);
            $('#father_status').val(row.getData().father_status);
            $('#mother_status').val(row.getData().mother_status);
            $('#job_status').val(row.getData().job_status);

            var  person_id= row.getData().person_id;
            
            // Setting href values
            $("#residence").attr("href","certificate?id_personne="+person_id);
            $("#life").attr("href","certificate_life?id_personne="+person_id);
            $("#support").attr("href","certificate_supported?id_personne="+person_id);
            $("#move").attr("href","certificate_move?id_personne="+person_id);
            $("#celibacy").attr("href","certificate_celibat?id_personne="+person_id);
            $("#behavior").attr("href","certificate_behavior?id_personne="+person_id);

            $('#personDetails').modal();

        },
        pagination:"local",
        paginationSize:25,
        /*paginationSizeSelector:[25, 50, 100, 200],
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
        }*/
    });

    $('#validEditPerson').click(function(e){
        e.preventDefault();
        
        
        /*
        //loading();
        var data = $('#personDetails').serializeArray();

        $.post('save_citizen_from_certificat', data, function(res){
            if(res.error === 1){
                if(res.missing_fields){
                    $.each( res.missing_fields, function( key, value ) {
                        $('.error_' + value[0]).text(value[1]);
                    });
                }
            }
            if(res.success === 1){
                $('#confirmResponse').text(res.msg);
                $('#confirmationModal').modal();
            }
            if(res.failed === 1)
                $('#failedMsg').text(res.msg);

            //endLoading();
        }, 'JSON');
        */
        var data =  [];
        data.push({name: 'id_personne', value: $("#person_id").val()});
        data.push({name: 'numero_carnet', value: $("#numero_carnet").val()});
        data.push({name: 'lieu_de_naissance', value: $("#birth_place").val()});
        data.push({name: 'for_person', value: "true"});
        data.push({name: 'address', value: $("#address").val()});
        data.push({name: 'last_name', value: $("#last_name").val()});
        data.push({name: 'first_name', value: $("#first_name").val()});
        data.push({name: 'marital_status', value: $("#marital_status").val()});
        data.push({name: 'parent_link', value: $("#parent_link").val()});
        data.push({name: 'birth', value: $("#birth").val()});
        data.push({name: 'sexe', value: $("#sexe").val()});
        data.push({name: 'handicapped', value: $("#handicapped").val()});
        data.push({name: 'nationality', value: $("#nationality").val()});
        data.push({name: 'cin', value: $("#cin").val()});
        data.push({name: 'cin_date', value: $("#cin_date").val()});
        data.push({name: 'cin_place', value: $("#cin_place").val()});
        data.push({name: 'father', value: $("#father").val()});
        data.push({name: 'father_status', value: $("#father_status").val()});
        data.push({name: 'mother', value: $("#mother").val()});
        data.push({name: 'mother_status', value: $("#mother_status").val()});
        data.push({name: 'phone', value: $("#phone").val()});
        data.push({name: 'job', value: $("#job").val()});
        data.push({name: 'job_status', value: $("#job_status").val()});

        $.post('save_citizen_from_certificat', data, function(res){
            if(res.error === 1){
                if(res.missing_fields){
                    $.each( res.missing_fields, function( key, value ) {
                        $('.error_' + value[0]).text(value[1]);
                    });
                }
            }
            if(res.success === 1){
                $('#confirmResponse').text(res.msg);
                $('#confirmationModal').modal();
            }
            if(res.failed === 1)
                $('#failedMsg').text(res.msg);

        }, 'JSON');

    });
});