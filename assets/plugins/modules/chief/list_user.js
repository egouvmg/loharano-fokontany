$(function () {

    var status = function(cell, formatterParams){
        var value = cell.getValue();
        
        switch(value){
            case 1:return "Actif"; break; 
            case 0:return "Suspendu"; break; 
        }
    };

	var users = new Tabulator("#users", {
        layout:"fitColumns",
		initialSort:[
			{column:"medal", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Nom", field:"first_name", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Email", field:"email",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Téléphone(s)", field:"phone",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Adresse", field:"address",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Fokontany", field:"fokontany_name",headerFilterPlaceholder:"..." , headerFilter:"input"}
        ],
        rowClick:function(e, row){
        },
    });

    $(document).ready(function(e){
        users.setData('utilisateurs_fokontany', {fokontany_id: $('#fokontany').val()});
    });

    $('#fokontany').change(function(){
        users.setData('les_utilisateurs_fokontany', {fokontany_id: $(this).val()});
    });
});