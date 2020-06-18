$(function () {
    // http://tabulator.info/docs/4.6/menu
    //define row context menu contents
    var rowMenu = [
        {
            label: "<i class='iconify' data-icon='bi:house' data-inline='false'></i> Certificat de résidence",
            action: function (e, row) {
                window.location.replace("certificate" + "?id_personne=" + row.getData().id_personne);
            }
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de vie individuel",
            action: function (e, row) {
                window.location.replace("certificate_life" + "?id_personne=" + row.getData().id_personne);
            }
        },
        {
            separator: true,
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de prise en charge et de garde",
            action: function (e, row) {
                window.location.replace("certificate_supported" + "?id_personne=" + row.getData().id_personne);
            }
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de déménagement",
            action: function (e, row) {
                window.location.replace("certificate_move" + "?id_personne=" + row.getData().id_personne);
            }
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de célibat",
            action: function (e, row) {
                window.location.replace("certificate_celibat" + "?id_personne=" + row.getData().id_personne);
            }
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de bonne conduite - de bonne vie - moeurs",
            action: function (e, row) {
                window.location.replace("certificate_behavior" + "?id_personne=" + row.getData().id_personne);
            }
        },
    ]

    var citizens = new Tabulator("#citizens", {
        layout: "fitColumns",
        ajaxURL: "citoyens_list",
        ajaxConfig: "GET",
        initialSort: [
            { column: "medal", dir: "asc" }
        ],
        rowContextMenu: rowMenu, //add context menu to rows
        columns: [ //Define Table Columns
            { title: "Numéro Cranet", field: "numero_carnet", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Adresse", field: "adresse_actuelle", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Nom", field: "nom", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Prénoms", field: "prenoms", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Numéro cin", field: "cin_personne", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Date de Naissance", field: "date_de_naissance", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Lieu de Naissance", field: "lieu_de_naissance", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "id_personne", field: "id_personne", headerFilterPlaceholder: "...", headerFilter: "input", visible: false }
        ],
        rowClick: function (e, row) {
            window.location.replace("certificate" + "?id_personne=" + row.getData().id_personne);
            //window.location.replace("certificat_residence" + "?personne=" + row.getData().id_personne);
        },
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
            }
        }
    });
});