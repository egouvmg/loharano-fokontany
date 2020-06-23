$(function () {

    var status = function (cell, formatterParams) {
        var value = cell.getValue();

        switch (value) {
            case 1: return "Actif"; break;
            case 0: return "Suspendu"; break;
        }
    };
 
	var users = new Tabulator("#users", {
        layout:"fitColumns",
		initialSort:[
			{column:"medal", dir:"asc"}
		],          
        columns: [ //Define Table Columns
            { title: "Numéro cin", field: "cin_personne", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Nom", field: "nom", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Prénoms", field: "prenoms", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Date de Naissance", field: "date_de_naissance", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Lieu de Naissance", field: "lieu_de_naissance", headerFilterPlaceholder: "...", headerFilter: "input" }
        ],
        pagination:"local",
        paginationSize:20,
        paginationSizeSelector:[20, 50, 100, 200],
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
        rowClick: function (e, row) {
            row.getData().last_name;
            /*
            var pdf = new jsPDF();
            pdf.text(20, 20, 'FOKONTANY :....................................................');
            pdf.text(20, 30, 'Lf :...........................................................');
            pdf.text(20, 30, 'Lf :...........................................................');
            pdf.text(20, 30, 'Atoa/Rtoa :....................................................');

            pdf.addPage();
            pdf.text(20, 20, 'Do you like that?');
            
            pdf.save('Test.pdf');
            */

            window.location.replace("certificate" + "?cin=" + row.getData().cin_personne);
        },
    });

    $("#pdf").click(function () {
        var pdf = new jsPDF('landscape', 'cm', 'a5');
        var specialElementHandlers = {
            '#editor': function (element, renderer) {
                return true;
            }
        };
        var margins = { top: 90, bottom: 60, left: 90, width: 1748 };//{top: 90, bottom: 60, left: 90, width: 900};
        pdf.addHTML($('#content').get(0), margins, function () {
            pdf.save('test.pdf');
        });

    });

    $(document).ready(function (e) {
        var fokontany_id = $('#fokontany').val() || 0;

        users.setData('recuperer_liste_citoyen', { fokontany_id: fokontany_id });
    });

    $('#fokontany').change(function (e) {
        users.setData('recuperer_liste_citoyen', { fokontany_id: $(this).val() });
    });
});