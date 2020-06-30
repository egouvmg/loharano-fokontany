$(function () {
    $("#province").change(function (e) {
        $('#loadingLocation').show();
        $.post("enfant_province", {
            id: $(this).val()
        }, function (res) {
            if (res.success == 1) {
                $("#region").html(res.childs);
                //Récupération districts
                $.post("enfant_region", {
                    id: res.first_child
                }, function (res) {
                    if (res.success == 1) {
                        $("#district").html(res.childs);

                        //Récupération communes
                        $.post("enfant_district", {
                            id: res.first_child
                        }, function (res) {
                            if (res.success == 1) {
                                $("#common").html(res.childs);
                                $.post("enfant_commune",{
                                    id : res.first_child
                                }, function (res) {
                                    if (res.success == 1) {						
                                        $("#borough").html(res.childs);
                                        $('#loadingLocation').hide();
                                        users.setData('les_chefs_arrondissement', {borough_id: $("#borough").val()});
                                    } else if (res.error == 1){
                                        alert(res.msg);
                                        $("#borough").html(res.childs);
                                    }
                                }, 'JSON');
                            } else if (res.error == 1)
                                alert(res.msg);
                        }, 'JSON');
                    } else if (res.error == 1)
                        alert(res.msg);
                }, 'JSON');
            } else if (res.error == 1)
                alert(res.msg);
        }, 'JSON');
    });

    $("#region").change(function (e) {
        $('#loadingLocation').show();
        //Récupération districts
        $.post("enfant_region", {
            id: $(this).val()
        }, function (res) {
            if (res.success == 1) {
                $("#district").html(res.childs);

                //Récupération communes
                $.post("enfant_district", {
                    id: res.first_child
                }, function (res) {
                    if (res.success == 1) {
                        $("#common").html(res.childs);

                        $.post("enfant_commune",{
                            id : res.first_child
                        }, function (res) {
                            if (res.success == 1) {						
                                $("#borough").html(res.childs);
                                $('#loadingLocation').hide();
                                users.setData('les_chefs_arrondissement', {borough_id: $("#borough").val()});
                            } else if (res.error == 1){
                                alert(res.msg);
                                $("#borough").html(res.childs);
                            }
                        }, 'JSON');
                    } else if (res.error == 1)
                        alert(res.msg);
                }, 'JSON');
            } else if (res.error == 1)
                alert(res.msg);
        }, 'JSON');

    });

    $("#district").change(function (e) {
        $('#loadingLocation').show();
        //Récupération communes
        $.post("enfant_district", {
            id: $(this).val()
        }, function (res) {
            if (res.success == 1) {
                $("#common").html(res.childs);
                $.post("enfant_commune",{
                    id : res.first_child
                }, function (res) {
                    if (res.success == 1) {						
                        $("#borough").html(res.childs);
                        $('#loadingLocation').hide();
                        users.setData('les_chefs_arrondissement', {borough_id: $("#borough").val()});
                    } else if (res.error == 1){
                        alert(res.msg);
                        $("#borough").html(res.childs);
                    }
                }, 'JSON');
            } else if (res.error == 1)
                alert(res.msg);
        }, 'JSON');
    });

    $("#common").change(function (e) {
        $('#loadingLocation').show();
        //Récupération fokontany
        $.post("enfant_commune",{
            id : $(this).val()
        }, function (res) {
            if (res.success == 1) {						
                $("#borough").html(res.childs);
                $('#loadingLocation').hide();
                users.setData('les_chefs_arrondissement', {borough_id: $("#borough").val()});
            } else if (res.error == 1){
                alert(res.msg);
                $("#borough").html(res.childs);
            }
        }, 'JSON');
    });

    $("#borough").change(function (e) {
        $('#loadingLocation').show();
        users.setData('les_chefs_arrondissement', {borough_id: $(this).val()});
        $('#loadingLocation').hide();
    });

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
			{column:"first_name", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Nom", field:"first_name", headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Email", field:"email",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Téléphones", field:"phone",headerFilterPlaceholder:"..." , headerFilter:"input"},
            {title:"Adresse", field:"address",headerFilterPlaceholder:"..." , headerFilter:"input"}
        ],
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
        },
        rowClick:function(e, row){
            $('#first_name').val(row.getData().first_name);
            $('#email').val(row.getData().email);
            $('#currentEmail').val(row.getData().email);
            $('#phone').val(row.getData().phone);
            $('#address').val(row.getData().address);
            $('#password').val(row.getData().current_pwd);
            $('#old_pwd').val(row.getData().current_pwd);

            $('#editModal').modal();
        },
    });
    
    $(document).ready(function () {
        $('#phone').usPhoneFormat({
            format: 'xxx xx xxx xx',
        });

        var borough_id = $('#borough').val() || 0;

        users.setData('les_chefs_arrondissement', {borough_id:borough_id});
    });
    
	$('#editOperator').click(function(e){
        e.preventDefault();
        
        loading();
        $('.error_field').text('');

        var data = $('#editForm').serializeArray();

        $.post('changer_operateur', data, function(res){
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

            endLoading();
        }, 'JSON');
    });

    function loading(){
        $(this).prop('disabled', true);
        $('#loadingSave').show();
    }
    
    function endLoading(){
        $(this).prop('disabled', false);
        $('#loadingSave').hide();
    }
});