$(function () {

	var handicapped = function (cell, formatterParams) {
		var value = cell.getValue();

		switch (value) {
			case 1:
				return "Oui";
				break;
			case 2:
				return "Non";
				break;
			case 0:
				return "Non";
				break;
		}
	};

	var sexe = function (cell, formatterParams) {
		var value = cell.getValue();

		switch (value) {
			case 1:
				return "Masculin";
				break;
			case 0:
				return "Féminin";
				break;
		}
	};

	var listDuplicatePersons = new Tabulator("#listPerson", {
		layout: "fitDataFill", //fit columns to width of table (optional)
		ajaxURL: "personnes_dupliquees", //ajax URL
		ajaxConfig: "POST", //ajax HTTP request type   
		pagination: "local",
		paginationSize: 25,
		selectable: 1,
		paginationSizeSelector: [25, 50, 100, 200],
		langs: {
			"fr-fr": { //French language definition
				"columns": {
					"name": "Nom",
					"progress": "Progression",
					"gender": "Genre",
					"rating": "Évaluation",
					"col": "Couleur",
					"dob": "Date de Naissance",
				},
				"pagination": {
					"first": "Premier",
					"first_title": "Première Page",
					"last": "Dernier",
					"last_title": "Dernière Page",
					"prev": "Précédent",
					"prev_title": "Page Précédente",
					"next": "Suivant",
					"next_title": "Page Suivante",
				},
			},
			"de-de": { //German language definition
				"columns": {
					"name": "Name",
					"progress": "Fortschritt",
					"gender": "Genre",
					"rating": "Geschlecht",
					"col": "Farbe",
					"dob": "Geburtsdatum",
				},
				"pagination": {
					"first": "Zuerst",
					"first_title": "Zuerst Seite",
					"last": "Last",
					"last_title": "Letzte Seite",
					"prev": "Zurück",
					"prev_title": "Zurück Seite",
					"next": "Nächster",
					"next_title": "Nächster Seite",
				},
			},
		},
		columns: [ //Define Table Columns
			{
				title: "Itération",
				field: "count",
				width: 80,
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			},
			{
				title: "Nom",
				field: "last_name",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			},
			{
				title: "Prénom(s)",
				field: "first_name",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			},
			{
				title: "Date de naissance",
				field: "birth",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			},
			{
				title: "Lieu de naissance",
				field: "birth_place",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			},
			{
				title: "Mère",
				field: "mother",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			}
		],
		rowClick: function (e, row) {
			$('#loadingData').show();
			listPersons.setData('meme_personnes', {criteria : row.getData().criteria});
            $('#loadingData').hide();
		},
	});

    var listPersons = new Tabulator("#listSamePerson", {
        layout:"fitDataFill", //fit columns to width of table (optional)
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
            },
            "de-de":{ //German language definition
                "columns":{
                    "name":"Name",
                    "progress":"Fortschritt",
                    "gender":"Genre",
                    "rating":"Geschlecht",
                    "col":"Farbe",
                    "dob":"Geburtsdatum",
                },
                "pagination":{
                    "first":"Zuerst",
                    "first_title":"Zuerst Seite",
                    "last":"Last",
                    "last_title":"Letzte Seite",
                    "prev":"Zurück",
                    "prev_title":"Zurück Seite",
                    "next":"Nächster",
                    "next_title":"Nächster Seite",
                },
            },
        },
		initialSort:[
			{column:"pdf_file", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Référence registre", field:"register_reference",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Fichier PDF", field:"pdf_file",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Taille ménage", field:"household_size",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Nom", field:"last_name",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Prénom(s)", field:"first_name",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Sexe", field:"sexe", formatter: sexe, width:80, editor:"select", editorParams:{values:{1:"Male", 0:"Female"}}, headerFilter:true, headerFilterParams:{values:{1:"Masculin", 0:"Féminin", "":""}}},
            {title:"Adresse", field:"address",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Numéro CIN", field:"cin",headerFilterPlaceholder:"...", headerFilter:"input", width:150},
            {title:"Handicapé(e)", field:"handicapped",formatter:handicapped, width:100, editor:"select", editorParams:{values:{1:"Oui", 0:"Non"}}, headerFilter:true, headerFilterParams:{values:{1:"Oui", 0:"Non", "":""}}},
            {title:"Profession", field:"profession_name",headerFilterPlaceholder:"..." , headerFilter:"input"}
        ],
        rowClick:function(e, row){
			$('#full_name').text(row.getData().last_name + ' ' + row.getData().first_name);
			$('#last_name').val(row.getData().last_name);
			$('#first_name').val(row.getData().first_name);
			$('#sexe').val(row.getData().sexe);
			$('#handicapped').val(row.getData().handicapped);
			$('#address').val(row.getData().address);
			$('#cin').val(row.getData().cin);
			$('#cin_date').val(row.getData().cin_date);
			$('#cin_place').val(row.getData().cin_place);
			$('#birth').val(row.getData().birth);
			$('#birth_place').val(row.getData().birth_place);
			$('#job').val(row.getData().job);
			$('#job_status').val(row.getData().job_status);
			$('#observation').val(row.getData().observation);
			$('#nationality').val(row.getData().nationality);
			$('#father').val(row.getData().father);
			$('#father_status').val(row.getData().father_status);
			$('#mother').val(row.getData().mother);
			$('#mother_status').val(row.getData().father_status);
			$('#person_id').val(row.getData().person_id);
			$('#passport').val(row.getData().passport);
			$('#passport_date').val(row.getData().passport_date);
			$('#passport_place').val(row.getData().passport_place);

			$('.cin-container').hide();
			$('.passport-container').hide();

			if (row.getData().nationality == "Malgache")
				$('.cin-container').show();
			else
				$('.passport-container').show();

			$('#personDetails').modal();
        },
    });

    listPersons.setLocale("fr-fr");

	listDuplicatePersons.setLocale("fr-fr");

	function laodListDuplicatePersons() {
		listDuplicatePersons.setData('liste_duplicate_persons');
	}

	$('#nav-duplicate-person-tab').click(function (e) {
		laodListDuplicatePersons();
	});

});
