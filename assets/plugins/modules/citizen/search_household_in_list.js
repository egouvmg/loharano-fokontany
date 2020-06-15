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

	$('#addToHousehold').click(function(e){
		e.preventDefault();

		var noteboook = $('#notebook').val();

		$.get('citoyen_carnet_fokontany', {noteboook : noteboook}, function(res){
			if(res.success == 1) window.location = res.link;
			else alert(res.msg);
		}, 'JSON')
		.fail(function () {
			alert('Une erreur est survenue. Contacter le responsable.');
			$('#loadingData').hide();
		});
	});
});
