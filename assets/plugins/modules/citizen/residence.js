$(function () {
    // http://tabulator.info/docs/4.6/menu
    //define row context menu contents
    var rowMenu = [
        {
            label: "<i class='iconify' data-icon='bi:house' data-inline='false'></i> Certificat de résidence",
            action: function (e, row) {
                //window.location.replace("certificate" + "?id_personne=" + row.getData().id_personne);
                window.open("certificate" + "?id_personne=" + row.getData().id_personne, '_blank');
            }
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de vie individuel",
            action: function (e, row) {
                window.open("certificate_life" + "?id_personne=" + row.getData().id_personne, '_blank');
            }
        },
        {
            separator: true,
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de prise en charge et de garde",
            action: function (e, row) {
                window.open("certificate_supported" + "?id_personne=" + row.getData().id_personne, '_blank');
            }
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de déménagement",
            action: function (e, row) {
                window.open("certificate_move" + "?id_personne=" + row.getData().id_personne, '_blank');
            }
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de célibat",
            action: function (e, row) {
                window.open("certificate_celibat" + "?id_personne=" + row.getData().id_personne, '_blank');
            }
        },
        {
            label: "<i class='iconify' data-icon='bi:people-fill' data-inline='false'></i> Certificat de bonne conduite - de bonne vie - moeurs",
            action: function (e, row) {
                window.open("certificate_behavior" + "?id_personne=" + row.getData().id_personne, '_blank');
            }
        },
    ]

// context menu for the row
const rowContextMenu = [
    {
        label:"Reset Row Value",
        action:function(e, row){
					const cells = row.getCells();
					cells.forEach((cell) => {
						cell.setValue("");
					})
        }
    },
]

// Custom formatter to create the button and
// dispatch a context menu event
function customFormatter(cell, formatterParams){
    const button = document.createElement("input");
    button.type = "button";
    button.name = "add";
    button.value = "Créer Certificats";
    button.className="btn btn-success btn-xs";

	button.textContent = "Créer Certificats";
	button.addEventListener('click', (event) => {
		event.stopImmediatePropagation();
		const myEvent = new Event('contextmenu');
		myEvent.pageX = event.pageX;
		myEvent.pageY = event.pageY;
		cell.getRow().getElement().dispatchEvent(myEvent);
	})
	return button;
}

    var citizens = new Tabulator("#citizens", {
        layout: "fitColumns",
        ajaxURL: "citoyens_list",
        ajaxConfig: "GET",
        initialSort: [
            { column: "medal", dir: "asc" }
        ],
        rowContextMenu: rowMenu, //add context menu to rows
        columns: [ //Define Table Columns
            { title: "Numéro Cranet", field: "numero_carnet", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Adresse", field: "adresse_actuelle", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Nom", field: "nom", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Prénoms", field: "prenoms", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Numéro cin", field: "cin_personne", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Date de Naissance", field: "date_de_naissance", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "Lieu de Naissance", field: "lieu_de_naissance", headerFilterPlaceholder: "...", headerFilter: "input" },
            { title: "id_personne", field: "id_personne", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "situation_matrimoniale", field: "situation_matrimoniale", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "parent_link", field: "parent_link", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "handicapped", field: "handicape", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "nationalite", field: "nationality", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "cin_date", field: "cin_date", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "cin_place", field: "cin_place", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "job", field: "job", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "job_status", field: "job_status", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { title: "phone", field: "phone", headerFilterPlaceholder: "...", headerFilter: "input", visible: false },
            { formatter: customFormatter, title: "Certificats" },
        ],
        rowClick: function (e, row) {
            //window.location.replace("certificate" + "?id_personne=" + row.getData().id_personne);
            //window.location.replace("certificat_residence" + "?personne=" + row.getData().id_personne);
            $('#full_name').text(row.getData().nom +' '+ row.getData().prenoms);
            $('#last_name').val(row.getData().nom);
            $('#first_name').val(row.getData().prenoms);
            $('#sexe').val(row.getData().sexe);
            $('#handicapped').val(row.getData().handicape===false?0:1);
            $('#address').val(row.getData().adresse_actuelle);
            $('#cin').val(row.getData().cin_personne);
            $('#cin_date').val(row.getData().cin_date);
            $('#cin_place').val(row.getData().cin_place);
            $('#birth').val(row.getData().date_de_naissance);
            $('#birth_place').val(row.getData().lieu_de_naissance);
            $('#job').val(row.getData().job);
            $('#job_status').val(row.getData().job_status);
            $('#phone').val(row.getData().phone);
            $('#observation').val(row.getData().observation);
            $('#nationality').val(row.getData().nationality);
            $('#father').val(row.getData().father);
            $('#father_status').val(row.getData().father_status);
            $('#mother').val(row.getData().mother);
            $('#mother_status').val(row.getData().mother_status);
            $('#person_id').val(row.getData().person_id);
            $('#parent_link').val(row.getData().parent_link);
            $('#marital_status').val(row.getData().situation_matrimoniale);
            $('#passport').val(row.getData().passport);
            $('#passport_date').val(row.getData().passport_date);
            $('#passport_place').val(row.getData().passport_place);
            $('#pdf_file').val(row.getData().pdf_file);
            $('#person_id').val(row.getData().id_personne);
            $('#numero_carnet').val(row.getData().numero_carnet);

            var  person_id= row.getData().id_personne;

            $('#otherJob').hide();
            $('#otherParentLink').hide();

            if(row.getData().job == 0){
                $('#otherJob').val(row.getData().profession_name);
                $('#job').val(0);
                $('#otherJob').show();
            }

            if(row.getData().parent_link != 'mere' && row.getData().parent_link != 'pere' && row.getData().parent_link != 'fille' && row.getData().parent_link != 'fils' && row.getData().parent_link != 0){
                $('#otherParentLink').val(row.getData().parent_link);
                $('#parent_link').val('autre');
                $('#otherParentLink').show();
            }

            $('.cin-container').hide();
            $('.passport-container').hide();

            if(row.getData().nationality == "Malgache")
                $('.cin-container').show();
            else
                $('.passport-container').show();


            // Setting href values
            $("#residence").attr("href","certificate?id_personne="+person_id);
            $("#life").attr("href","certificate_life?id_personne="+person_id);
            $("#support").attr("href","certificate_supported?id_personne="+person_id);
            $("#move").attr("href","certificate_move?id_personne="+person_id);
            $("#celibacy").attr("href","certificate_celibat?id_personne="+person_id);
            $("#behavior").attr("href","certificate_behavior?id_personne="+person_id);


            $('#personDetails').modal();
        },
        pagination:"local",
        paginationSize:10
        /*paginationSizeSelector:[25, 50, 100, 200],
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
        }*/
    });


    $('#validEditPerson').click(function(e){
        e.preventDefault();
        
        
        /*
        //loading();
        var data = $('#personDetails').serializeArray();

        $.post('save_citizen_from_certificat', data, function(res){
            if(res.error === 1){
                if(res.missing_fields){
                    $.each( res.missing_fields, function( key, value ) {
                        $('.error_' + value[0]).text(value[1]);
                    });
                }
            }
            if(res.success === 1){
                $('#confirmResponse').text(res.msg);
                $('#confirmationModal').modal();
            }
            if(res.failed === 1)
                $('#failedMsg').text(res.msg);

            //endLoading();
        }, 'JSON');
        */
        var data =  [];
        data.push({name: 'id_personne', value: $("#person_id").val()});
        data.push({name: 'numero_carnet', value: $("#numero_carnet").val()});
        data.push({name: 'lieu_de_naissance', value: $("#birth_place").val()});
        data.push({name: 'for_person', value: "true"});
        data.push({name: 'address', value: $("#address").val()});
        data.push({name: 'last_name', value: $("#last_name").val()});
        data.push({name: 'first_name', value: $("#first_name").val()});
        data.push({name: 'marital_status', value: $("#marital_status").val()});
        data.push({name: 'parent_link', value: $("#parent_link").val()});
        data.push({name: 'birth', value: $("#birth").val()});
        data.push({name: 'sexe', value: $("#sexe").val()});
        data.push({name: 'handicapped', value: $("#handicapped").val()});
        data.push({name: 'nationality', value: $("#nationality").val()});
        data.push({name: 'cin', value: $("#cin").val()});
        data.push({name: 'cin_date', value: $("#cin_date").val()});
        data.push({name: 'cin_place', value: $("#cin_place").val()});
        data.push({name: 'father', value: $("#father").val()});
        data.push({name: 'father_status', value: $("#father_status").val()});
        data.push({name: 'mother', value: $("#mother").val()});
        data.push({name: 'mother_status', value: $("#mother_status").val()});
        data.push({name: 'phone', value: $("#phone").val()});
        data.push({name: 'job', value: $("#job").val()});
        data.push({name: 'job_status', value: $("#job_status").val()});

        $.post('save_citizen_from_certificat', data, function(res){
            if(res.error === 1){
                if(res.missing_fields){
                    $.each( res.missing_fields, function( key, value ) {
                        $('.error_' + value[0]).text(value[1]);
                    });
                }
            }
            if(res.success === 1){
                $('#confirmResponse').text(res.msg);
                $('#confirmationModal').modal();
            }
            if(res.failed === 1)
                $('#failedMsg').text(res.msg);

        }, 'JSON');

    });

});