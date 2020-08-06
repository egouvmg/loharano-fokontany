$(function () {
    var is_household_head = function (cell, formatterParams) {
        return (cell.getValue()) ? 'Oui' : 'Non';
    };

    var type = function (cell, formatterParams) {
        var value = cell.getValue();

        switch (value) {
            case "1": return "Vivres"; break;
            case "2": return "Cash"; break;
        }
    };

    $('#fokontany').change(function(e){
        e.preventDefault();

        aids.setData('statitique_aide_par_fokontany', { fokontany_id: $(this).val() });
        $('#programName').text('...');
    });

    var aids = new Tabulator("#aids", {
        layout: "fitColumns",
        initialSort: [
            { column: "adresse_actuelle", dir: "asc" }
        ],
        columns: [ //Define Table Columns
            { title: "Programme", field: "name", headerFilterPlaceholder: "...", headerFilter: "input"},
            { title: "Date début", field: "date_start", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Type", field: "type", formatter: type, headerFilterPlaceholder: "...", headerFilter:"select", headerFilterParams:{values:{1:"Vivres", 2:"Cash", "":""}}},
            { title: "Nombre de distributions", field: "nbr_aid", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Description", field: "description", headerFilterPlaceholder: "...", headerFilter: "input" }
        ],
        rowClick: function (e, row) {
            $('#programName').text(row.getData().name);  
            household.setData('menage_avec_aide', { fokontany_id: row.getData().fokontany_id, aid_id : row.getData().aid_id});
        },
        pagination:"local",
        paginationSize:5,
        paginationSizeSelector:[5, 10, 20, 50],
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

    var household = new Tabulator("#household", {
        layout:"fitColumns",
        selectable: 1,
        columnVertAlign:"bottom", //align header contents to bottom of cell
        cellVertAlign:"middle", //vertically center cell contents
		ajaxConfig: "GET",
		initialSort:[
			{column:"numero_carnet", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Chef ménage", field:"chief_name", headerFilterPlaceholder: "...", headerFilter: "input"},
            {title:"Adresse", field:"adresse_actuelle", headerFilterPlaceholder: "...", headerFilter: "input"},
            {title:"Date de réception", width:300, field:"created_on", headerFilterPlaceholder: "...", headerFilter: "input"}
        ],
        rowClick:function(e, row){
            $('#notebookNumber').text(row.getData().chief_name);
            $('#householdDetails').modal();
            citizenHousehold.setData('membres_menage', {numero_carnet:row.getData().numero_carnet});
        },
        pagination:"remote",
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

    aids.setLocale("fr-fr");
    household.setLocale("fr-fr");
    citizenHousehold.setLocale("fr-fr");

    $(document).ready(function (e) {
        var fokontany_id = $('#fokontany').val() || 0;

        aids.setData('statitique_aide_par_fokontany', { fokontany_id: fokontany_id });
    });
});
