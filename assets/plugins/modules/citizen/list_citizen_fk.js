$(function () {
	var citizens = new Tabulator("#citizens", {
        layout:"fitColumns",
		ajaxURL: "citoyens_list",
		ajaxConfig: "GET",
		initialSort:[
			{column:"medal", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Numéro Cranet", field:"numero_carnet", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Adresse", field:"adresse_actuelle", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Nom", field:"nom",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Prénoms", field:"prenoms",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Numéro cin", field:"cin_peronne", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Date de Naissance", field:"date_de_naissance", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Lieu de Naissance", field:"lieu_de_naissance", headerFilterPlaceholder:"..." , headerFilter:"input"}            
        ],
        rowClick:function(e, row){
        },
    });
});