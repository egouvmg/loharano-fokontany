$(function () {

	var listFokontanyTreaty = new Tabulator("#fokontanyTreaty-table", {
		layout: "fitColumns", //fit columns to width of table (optional)
		pagination: "local",
		paginationSize: 25,
		paginationSizeSelector: [25],
		langs: {
			"fr-fr": { //French language definition
				"columns": {
					"fokotany": "Fokontany",
					"common": "Commune",
					"district": "District",
					"region": "Région",
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
				title: "Fokontany",
				field: "fokontany_name",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			},
			{
				title: "Commune",
				field: "common_name",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			},
			{
				title: "District",
				field: "district_name",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			},
			{
				title: "Région",
				field: "region_name",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			}
		],
	});

	var listFokontanyNeedTreat = new Tabulator("#fokontanyProcess-table", {
		layout: "fitColumns", //fit columns to width of table (optional) 
		pagination: "local",
		paginationSize: 25,
		paginationSizeSelector: [25, 50, 100, 200],
		langs: {
			"fr-fr": { //French language definition
				"columns": {
					"fokotany": "Fokontany",
					"common": "Commune",
					"district": "District",
					"region": "Région",
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
				title: "Fokontany",
				field: "fokontany_name",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			},
			{
				title: "Commune",
				field: "common_name",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			},
			{
				title: "District",
				field: "district_name",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			},
			{
				title: "Région",
				field: "region_name",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			}
		],
	});

	var listPersonsTreaty = new Tabulator("#personTreaty-table", {
		layout: "fitColumns", //fit columns to width of table (optional)  
		pagination: "local",
		paginationSize: 25,
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
				title: "Référence registre",
				field: "reference",
				width: 150,
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
				title: "Adresse",
				field: "address",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			}
		],
	});

	var listPersonsTreatyDaily = new Tabulator("#personTreatyDaily-table", {
		layout: "fitColumns", //fit columns to width of table (optional)
		pagination: "local",
		paginationSize: 25,
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
		initialSort:[
			{column:"pdf_file", dir:"asc"}
		],
		columns: [ //Define Table Columns
			{
				title: "Fichier PDF",
				field: "pdf_file",
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
				title: "Adresse",
				field: "address",
				headerFilterPlaceholder: "...",
				headerFilter: "input"
			}
		],
	});

	listPersonsTreaty.setLocale("fr-fr");
	listFokontanyTreaty.setLocale("fr-fr");
	listFokontanyNeedTreat.setLocale("fr-fr");
	listPersonsTreatyDaily.setLocale("fr-fr");

	function laodListPersonsTreaty() {
		listPersonsTreaty.setData('all_peopleTreaty');
	}

	function loadListFokontanyTreaty() {
		listFokontanyTreaty.setData('all_fokontanyTreaty');
	}

	function loadListFokontanyNeedTreat() {
		listFokontanyNeedTreat.setData('all_fokontanyNeedTreat');
	}

	$('#fokontanyTreaty').click(function (e) {
		loadListFokontanyTreaty();
		$("#listFokontanyTreaty").modal();
	});

	$('#fokontanyAffectedNeedTreat').click(function (e) {
		loadListFokontanyNeedTreat();
		$("#listFokontanyAffectedNeedTreat").modal();

	});

	$('#peopleTreaty').click(function (e) {
		laodListPersonsTreaty();
		$("#listPeopleTreaty").modal();
	});

	$(document).on('click', '.person-treaty', function (e) {
		e.preventDefault();

		var day = $(this).data('day');
		var company_id = $('#firmContent li.active').data('index');

		listPersonsTreatyDaily.setData('personnes_traitees_par_jour', {day:day, company_id:company_id});
		$("#listPeopleTreatyDaily").modal();
	});

});
