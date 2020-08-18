$(function () {
    var rowMenu = [
        {
            label: "<i class='iconify' data-icon='bi:house' data-inline='false'></i> Certificat de résidence",
            action: function (e, row) {
                //window.location.replace("certificate" + "?id_personne=" + row.getData().id_personne);
                window.open("certificate" + "?id_personne=" + row.getData().id_personne, '_blank');
            }
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de vie individuel",
            action: function (e, row) {
                window.open("certificate_life" + "?id_personne=" + row.getData().id_personne, '_blank');
            }
        },
        {
            separator: true,
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de prise en charge et de garde",
            action: function (e, row) {
                window.open("certificate_supported" + "?id_personne=" + row.getData().id_personne, '_blank');
            }
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de déménagement",
            action: function (e, row) {
                window.open("certificate_move" + "?id_personne=" + row.getData().id_personne, '_blank');
            }
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de célibat",
            action: function (e, row) {
                window.open("certificate_celibat" + "?id_personne=" + row.getData().id_personne, '_blank');
            }
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de bonne conduite - de bonne vie - moeurs",
            action: function (e, row) {
                window.open("certificate_behavior" + "?id_personne=" + row.getData().id_personne, '_blank');
            }
        },
    ];

    const rowContextMenu = [
        {
            label:"Reset Row Value",
            action:function(e, row){
                const cells = row.getCells();
                cells.forEach((cell) => {
                    cell.setValue("");
                })
            }
        },
    ];

    function customFormatter(cell, formatterParams){
        const button = document.createElement("input");
        button.type = "button";
        button.name = "add";
        button.value = "Créer un certificat";
        button.className="btn-sm btn-success btn-xs";

        button.textContent = "Créer un certificat";
        button.addEventListener('click', (event) => {
            event.stopImmediatePropagation();
            const myEvent = new Event('contextmenu');
            myEvent.pageX = event.pageX;
            myEvent.pageY = event.pageY;
            cell.getRow().getElement().dispatchEvent(myEvent);
        })
        return button;
    }
    var is_household_head = function (cell, formatterParams) {
        return (cell.getValue()) ? 'Oui' : 'Non';
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
            case 5: return "Paositra Money"; break;
        }
    };

    var context = function(cell, formatterParams) {
        var value = cell.getValue();
        var bank = '';

        switch (cell.getRow().getData().bank) {
            case 1: bank = "BNI"; break;
            case 2: bank = "BFV"; break;
            case 3: bank = "BOA"; break;
            case 4: bank = "Access Banque"; break;
            case 5: bank = "BMOI"; break;
            case 6: bank = "BGFI"; break;
            case 7: bank = "Sipem Banque"; break;
        };

        switch(value){
            case 1: 
            case 2: 
            case 3: return "Téléphone : " + cell.getRow().getData().phone; break;
            case 4: return "Banque : " + bank + ", n° de compte/IBAN : " + cell.getRow().getData().rib  ; break;
            case 5: return "Compte : " + cell.getRow().getData().paositra_account; break;
        }
    };

    var histories = new Tabulator('#historyMigration', {
        layout:"fitColumns",
		initialSort:[
			{column:"date_migration", dir:"desc"}
		],
        columns:[ //Define Table Columns
            {title:"Date", field:"date_migration"},
            {title:"Avant", field:"fokontany_name_start"},
            {title:"Après", field:"fokontany_name_end"}     
        ],
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

    var citizens = new Tabulator("#citizens", {
        layout: "fitColumns",
        ajaxURL: "citoyens_list",
        ajaxConfig: "GET",    
        columnVertAlign:"bottom", //align header contents to bottom of cell
        cellVertAlign:"middle", //vertically center cell contents
        initialSort: [
            { column: "nom", dir: "asc" }
        ],
        rowContextMenu: rowMenu, //add context menu to rows
        columns: [ //Define Table Columns
            { title: "Numéro carnet", field: "numero_carnet"},
            { title: "Adresse", field: "adresse_actuelle"},
            { title: "Nom", field: "nom"},
            { title: "Prénoms", field: "prenoms"},
            { title: "Numéro cin", field: "cin_personne"},
            { title: "Date de Naissance", field: "date_de_naissance"},
            { title: "Lieu de Naissance", field: "lieu_de_naissance"},
            { formatter: customFormatter, title: "Certificats" },
        ],
        rowClick:function(e, row){
            histories.setData('historique_migration', {id_person:row.getData().id_personne});
            histories_certificates.setData('historique_certificat', {id_person:row.getData().id_personne});
            citizenHousehold.setData('membres_menage', {numero_carnet:row.getData().numero_carnet});
            citizenAids.setData('aide_par_menage', {numero_carnet:row.getData().numero_carnet});

            $('.error_field').text('');
            $('#nom_complet').text(row.getData().nom + ' ' + row.getData().prenoms);
            $('#numero_carnet').val(row.getData().numero_carnet);
            $('#adresse_actuelle').val(row.getData().adresse_actuelle);
            $('#nom_info').val(row.getData().nom);
            $('#prenoms_info').val(row.getData().prenoms);
            $('#sexe').val(row.getData().sexe);
            $('#cin_personne_info').val(row.getData().cin_personne);
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
            $('#observation').val(row.getData().observation);

            if(row.getData().date_de_naissance){
                $('#date_de_naissance').val(splitDate(row.getData().date_de_naissance));
            }
            if(row.getData().cin_date){
                $('#date_delivrance_cin').val(splitDate(row.getData().cin_date));
                $('#lieu_delivrance_cin').val(row.getData().cin_place);
            }         
            if(row.getData().date_delivrance_cin){
                $('#date_delivrance_cin').val(splitDate(row.getData().date_delivrance_cin));
                $('#lieu_delivrance_cin').val(row.getData().lieu_delivrance_cin);
            }

            $('#certificat_residence').attr("href", "certificate?id_personne="+row.getData().id_personne).attr("target", "_blank");
            $('#certificat_move').attr("href", "certificate_move?id_personne="+row.getData().id_personne).attr("target", "_blank");
            $('#certificat_celibat').attr("href", "certificate_celibat?id_personne="+row.getData().id_personne).attr("target", "_blank");
            $('#certificat_life').attr("href", "certificate_life?id_personne="+row.getData().id_personne).attr("target", "_blank");
            $('#certificat_supported').attr("href", "certificate_supported?id_personne="+row.getData().id_personne).attr("target", "_blank");
            $('#certificat_behavior').attr("href", "certificate_behavior?id_personne="+row.getData().id_personne).attr("target", "_blank");

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

    var citizenHousehold = new Tabulator('#citizenHousehold', {
        layout:"fitColumns",
		initialSort:[
			{column:"chef_menage", dir:"desc"}
		],
        columns:[ //Define Table Columns
            {title:"Chef", field:"chef_menage", formatter: is_household_head},
            {title:"Nom", field:"nom"},
            {title:"Prénoms", field:"prenoms"},
            {title:"Numéro cin", field:"cin_personne"},
            {title:"Date de Naissance", field:"date_de_naissance"},
            {title:"Lieu de Naissance", field:"lieu_de_naissance"} ,  
        ],
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

    var citizenAids = new Tabulator('#citizenAids', {
        layout:"fitColumns",
		initialSort:[
			{column:"created_on", dir:"desc"}
		],
        columns:[ //Define Table Columns
            {title:"Aide reçue", field:"name"},
            {title:"Type", field: "type", width:100, formatter: types},
            {title:"Date", field:"created_on", width:100},
            {title:"Mode de virement", field: "payment_type", width:160, formatter: payment_types},
            {title:"Détails", field: "payment_type", formatter: context},
            {title:"Description", field:"description"} 
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

    var histories_certificates = new Tabulator('#historyCertificate', {
        layout:"fitColumns",
		initialSort:[
			{column:"date_migration", dir:"desc"}
		],
        columns:[ //Define Table Columns
            {title:"Date", field:"date_generation"},
            {title:"Motif", field:"motif"}    
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
    
    histories.setLocale("fr-fr");
    citizens.setLocale("fr-fr");
    citizenHousehold.setLocale("fr-fr");
    citizenAids.setLocale("fr-fr");
    histories_certificates.setLocale("fr-fr");

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

    $('.speed_access').on('keyup change', function(e){
        if($(this).val().length < 4) return false;

        var data = {
            nom:$('#nom').val(),
            prenoms:$('#prenoms').val(),
            cin_personne:$('#cin_personne').val()
        }

        citizens.setData('citoyens_list', data);
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
            if(res.success == 1){ 
                alert(res.msg);
                citizens.setData();
            }
        }, 'JSON');
    });

    $(document).on('click', '#pills-certificate-tab', function(e){
        $('#validEditPerson').show();
    });

    $(document).on('click', '#pills-aid-tab', function(e){
        $('#validEditPerson').hide();
    });

});