$(function () {
    var household_head = function (cell, formatterParams) {
		return cell.getRow().getData().nom + ' ' + cell.getRow().getData().prenoms;
    };
    
	var citizens = new Tabulator("#households", {
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
        },
    });
});