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
            {title:"Titre", field:"group_name",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Statut", field:"active", formatter: status, headerFilter:true, headerFilterParams:{values:{1:"Actif", 0:"Suspendu", "":""}}}
        ],
        rowClick:function(e, row){
            // $('#full_name').text(row.getData().last_name +' '+ row.getData().first_name);
            // $('#last_name').val(row.getData().last_name);
            // $('#first_name').val(row.getData().first_name);
            // $('#sexe').val(row.getData().sexe);
            // $('#handicapped').val(row.getData().handicapped);
            // $('#address').val(row.getData().address);
            // $('#cin').val(row.getData().cin);
            // $('#cin_date').val(row.getData().cin_date);
            // $('#cin_place').val(row.getData().cin_place);
            // $('#birth').val(row.getData().birth);
            // $('#birth_place').val(row.getData().birth_place);
            // $('#job').val(row.getData().job);
            // $('#job_status').val(row.getData().job_status);
            // $('#phone').val(row.getData().phone);
            // $('#observation').val(row.getData().observation);
            // $('#nationality').val(row.getData().nationality);
            // $('#father').val(row.getData().father);
            // $('#father_status').val(row.getData().father_status);
            // $('#mother').val(row.getData().mother);
            // $('#mother_status').val(row.getData().mother_status);
            // $('#person_id').val(row.getData().person_id);
            // $('#parent_link').val(row.getData().parent_link);
            // $('#marital_status').val(row.getData().marital_status);
            // $('#passport').val(row.getData().passport);
            // $('#passport_date').val(row.getData().passport_date);
            // $('#passport_place').val(row.getData().passport_place);
            // $('#pdf_file').val(row.getData().pdf_file);

            // $('#otherJob').hide();
            // $('#otherParentLink').hide();

            // if(row.getData().job == 0){
            //     $('#otherJob').val(row.getData().profession_name);
            //     $('#job').val(0);
            //     $('#otherJob').show();
            // }

            // if(row.getData().parent_link != 'mere' && row.getData().parent_link != 'pere' && row.getData().parent_link != 'fille' && row.getData().parent_link != 'fils' && row.getData().parent_link != 0){
            //     $('#otherParentLink').val(row.getData().parent_link);
            //     $('#parent_link').val('autre');
            //     $('#otherParentLink').show();
            // }

            // $('.cin-container').hide();
            // $('.passport-container').hide();

            // if(row.getData().nationality == "Malgache")
            //     $('.cin-container').show();
            // else
            //     $('.passport-container').show();

            // $('#personDetails').modal();
        },
    });

    $(document).ready(function(e){
        var fokontany_id = $('#fokontany').val() || 0;

        users.setData('les_utilisateurs_fokontany', {fokontany_id:fokontany_id});
    });
});