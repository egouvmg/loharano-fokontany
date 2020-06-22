$(function () {
	var citizens = new Tabulator("#households", {
        layout:"fitColumns",
		ajaxURL: "liste_menages_fokontany",
		ajaxConfig: "GET",
		selectable:1,
		initialSort:[
			{column:"medal", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Numéro Carnet", field:"numero_carnet", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Adresse", field:"adresse_actuelle", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Date d'arrivée", field:"date_arrivee", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Nom chef ménage", field:"nom", headerFilterPlaceholder:"..." , headerFilter:"input"},       
            {title:"Prénom(s) chef ménage", field:"prenoms", headerFilterPlaceholder:"..." , headerFilter:"input"}    
        ],
        rowClick:function(e, row){
			$('#tmpNotebook').text(row.getData().numero_carnet);
			$('#notebook').val(row.getData().numero_carnet);
			$('#tmpAddress').text(row.getData().adresse_actuelle);
			$('#tmpHead').text(row.getData().nom + ' ' +row.getData().prenoms);

			$('#confirmationModal').modal();
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

	$('#last_name').on('keyup', function () {
		var foo = $('#last_name').val();

		foo = foo.toUpperCase();

		$('#last_name').val(foo);
	});

	$('#first_name').on('keyup', function () {
		var foo = $('#first_name').val();

		if (typeof foo === 'string')
			foo = foo.charAt(0).toUpperCase() + foo.slice(1);

		$('#first_name').val(foo);
	});
	
	$('#last_name').on('keypress', function(e){
		citizens.setData('liste_menages_fokontany', {last_name:$(this).val()});
	});
	
	$('#first_name').on('keypress', function(e){
		citizens.setData('liste_menages_fokontany', {first_name:$(this).val()});
	});
	
	$('#birth').change(function(e){
		citizens.setData('liste_menages_fokontany', {birth:$(this).val()});
	});
	
	$('#birth_place').on('keypress', function(e){
		citizens.setData('liste_menages_fokontany', {birth_place:$(this).val()});
	});
	
	$('#father').on('keypress', function(e){
		citizens.setData('liste_menages_fokontany', {father:$(this).val()});
	});
	
	$('#mother').on('keypress', function(e){
		citizens.setData('liste_menages_fokontany', {mother:$(this).val()});
	});
});
