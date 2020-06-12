$(function () {
	var citizens = new Tabulator("#citizens", {
        layout:"fitColumns",
		initialSort:[
			{column:"medal", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Adresse", field:"address", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Numéro cin", field:"cin_personne", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Nom", field:"nom",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Prénoms", field:"prenoms",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Date de Naissance", field:"date_de_naissance", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Lieu de Naissance", field:"lieu_de_naissance", headerFilterPlaceholder:"..." , headerFilter:"input"}            
        ],
        rowClick:function(e, row){
        },
    });

    $(document).ready(function(e){
        var fokontany_id = $('#fokontany').val() || 0;

        citizens.setData('citoyens_list', {fokontany_id:fokontany_id});
    });
});