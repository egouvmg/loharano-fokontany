$(function () {
    var household_head = function (cell, formatterParams) {
		return cell.getRow().getData().nom + ' ' + cell.getRow().getData().prenoms;
    };

    var is_household_head = function (cell, formatterParams) {
        return (cell.getValue()) ? 'Oui' : 'Non';
    };
    
	var households = new Tabulator("#households", {
        layout:"fitColumns",
        selectable: 1,
		ajaxURL: "liste_menages_fokontany",
		ajaxConfig: "GET",
		initialSort:[
			{column:"medal", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Numéro Carnet", field:"numero_carnet"},
            {title:"Adresse", field:"adresse_actuelle"},
            {title:"Chef ménage", width:300, field:"chef_menage", formatter: household_head}         
        ],
        rowClick:function(e, row){
            $('#numero_carnet_hidden').val(row.getData().numero_carnet);
            citizens.setData('membres_menage', {numero_carnet:row.getData().numero_carnet});
        },
        pagination:"local",
        paginationSize:10,
        paginationSizeSelector:[10, 20, 50, 100, 200],
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

    var histories = new Tabulator('#historyMigration', {
        layout:"fitColumns",
        selectable: 1,
		initialSort:[
			{column:"date_migration", dir:"desc"}
		],
        columns:[ //Define Table Columns
            {title:"Date", field:"date_migration"},
            {title:"Avant", field:"fokontany_name_start"},
            {title:"Après", field:"fokontany_name_end"}     
        ],
        pagination:"local",
        paginationSize:10,
        paginationSizeSelector:[10, 20, 50, 100, 200],
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

	var citizens = new Tabulator("#citizens", {
        layout:"fitColumns",
        selectable: 1,
		initialSort:[
			{column:"chef_menage", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Chef", field:"chef_menage", formatter: is_household_head},
            {title:"Nom", field:"nom"},
            {title:"Prénoms", field:"prenoms"},
            {title:"Numéro cin", field:"cin_personne"},
            {title:"Date de Naissance", field:"date_de_naissance"},
            {title:"Lieu de Naissance", field:"lieu_de_naissance"} ,
            { title: "id_personne", field: "person_id", visible: false },
            { title: "situation_matrimoniale", field: "situation_matrimoniale", visible: false },
            { title: "parent_link", field: "parent_link", visible: false },
            { title: "handicapped", field: "handicape", visible: false },
            { title: "nationalite", field: "nationalite", visible: false },
            { title: "cin_date", field: "date_delivrance_cin", visible: false },
            { title: "cin_place", field: "lieu_delivrance_cin", visible: false },
            { title: "job", field: "job", visible: false },
            { title: "job_status", field: "job_status", visible: false },
            { title: "phone", field: "phone", visible: false },           
            { title: "numero_carnet", field: "numero_carnet", visible: false },
            { title: "sexe", field: "sexe", visible: false },          
            { title: "father_status", field: "father_status", visible: false },
            { title: "job_id", field: "job_id", visible: false },
            { title: "job_status", field: "job_status", visible: false },
            { title: "mother_status", field: "mother_status", visible: false },           
            { title: "observation", field: "observation", visible: false }
           ],
        rowClick:function(e, row){
            var id_peron = (row.getData().id_personne) ? row.getData().id_personne: row.getData().person_id;

            histories.setData('historique_migration', {id_person:id_peron});
            
            $('.error_field').text('');
            $('#id_personne').val(id_peron);
            $('#nom_complet').text(row.getData().nom + ' ' + row.getData().prenoms);
            $('#numero_carnet').val(row.getData().numero_carnet);
            $('#adresse_actuelle').val(row.getData().adresse_actuelle);
            $('#nom_info').val(row.getData().nom);
            $('#prenoms_info').val(row.getData().prenoms);
            $('#sexe').val(row.getData().sexe);
            $('#cin_personne_info').val(row.getData().cin_personne);
            $('#lieu_de_naissance').val(row.getData().lieu_de_naissance);
            $('#father').val(row.getData().father);
            $('#father_status').val(row.getData().father_status);
            $('#mother').val(row.getData().mother);
            $('#mother_status').val(row.getData().mother_status);
            $('#phone').val(row.getData().phone);
            $('#job').val(row.getData().job);
            $('#job_status').val(row.getData().job_status);
            $('#situation_matrimoniale').val(row.getData().situation_matrimoniale);
            $('#observation').val(row.getData().observation);

            if(row.getData().date_de_naissance){
                $('#date_de_naissance').val(splitDate(row.getData().date_de_naissance));
            }
            if(row.getData().cin_date){
                $('#date_delivrance_cin').val(splitDate(row.getData().cin_date));
                $('#lieu_delivrance_cin').val(row.getData().cin_place);
            }         
            if(row.getData().date_delivrance_cin){
                $('#date_delivrance_cin').val(splitDate(row.getData().date_delivrance_cin));
                $('#lieu_delivrance_cin').val(splitDate(row.getData().lieu_delivrance_cin));
            }

            $('#certificat_residence').attr("href", "certificate?id_personne="+id_peron);
            $('#certificat_move').attr("href", "certificate_move?id_personne="+id_peron);
            $('#certificat_celibat').attr("href", "certificate_celibat?id_personne="+id_peron);
            $('#certificat_life').attr("href", "certificate_life?id_personne="+id_peron);
            $('#certificat_supported').attr("href", "certificate_supported?id_personne="+id_peron);
            $('#certificat_behavior').attr("href", "certificate_behavior?id_personne="+id_peron);

            $('#personDetails').modal();
        },
        pagination:"local",
        paginationSize:15,
        paginationSizeSelector:[15, 30, 50, 100, 200],
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

	$('#nom').on('keyup', function () {
		var foo = $(this).val();

		foo = foo.toUpperCase();

		$(this).val(foo);
	});

	$('#prenoms').on('keyup', function () {
		var foo = $(this).val();

		if (typeof foo === 'string')
			foo = foo.charAt(0).toUpperCase() + foo.slice(1);

        $(this).val(foo);
    });
    
	$('.cin_personne').on('keypress', function (event) {
        if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
            event.preventDefault(); // ne pas permettre la saisie de character lettre
        } else {
            var foo = $(this).val().split(" ").join("");

            if (foo.length > 0)
                foo = foo.match(new RegExp('.{1,3}', 'g')).join(" ");

            $(this).val(foo);
        }
	});

    $('.speed_access').on('keyup change', function(e){
        var data = $('#speedForm').serializeArray();

        $.get('recherche_rapide', data, function(res){
            if(res.success == 1){
                citizens.setData(res.citizens);
                households.setData(res.households);

                if(res.citizens.length == 0) $('#createHousehold').show();
                else $('#createHousehold').hide();
            }
            else alert(res.msg);
        }, 'JSON');
    });

    $(document).ready(function () {
        $('#phone').usPhoneFormat({
            format: 'xxx xx xxx xx',
        });
    });

    function splitDate(mydate){
        if(mydate != 'undefined'){
            var from = mydate.split("/");
            return  from[2] +'-'+ from[1] +'-'+ from[0];
        }
        return '';
    }

    $('#validEditPerson').click(function(e){
        e.preventDefault();
        $('.error_field').text('');

        var data = $('#formEditPerson').serializeArray();

        $.post('modifier_citoyen', data, function(res){
            if(res.failed == 1){
                $.each( res.missing_fields, function( key, value ) {
                    $('.'+value[0]+'Error').text(value[1]);
                });
            }
            if(res.error == 1) alert(res.msg);
            if(res.success == 1) alert(res.msg);
        }, 'JSON');
    });

    $('#carnet_id').click(function(e){
        e.preventDefault();
        data={};
        data["numero_carnet"]= $('#numero_carnet_hidden').val();//"0054312006190002"

        $.get('membres_menage', data, function(res){
            createCarnet(res);
        }, 'JSON');
    });
    
    var pdf = new jsPDF('l','px','a4');
    line = 20;

    function createCarnet(membres_menage){
        var specialElementHandlers = {
             '#editor': function (element, renderer) {
                 return true;
             }
         };
        var margins = {top: 90, bottom: 60, left: 90, width: 1748};//{top: 90, bottom: 60, left: 90, width: 900};
        var config = {pagesplit: false, background: '#fff', margin: {top: 0, right: 10, bottom: 0, left: 50}};

        //******************************Couverture*************************** */
        
        pdf.setFontSize(12);
        pdf.setFont("helvetica");
        pdf.setFontType("normal");
        
        pdf.setFontType("italic");
        pdf.setFontStyle("bold");
        addText("REPOBLIKAN'I MADAGASIKARA", 300, null, 'center');
        addText("Fitiavana - Tanindrazana - Fandrosoana", 300, null, 'center');
        pdf.setFontSize(16);
        
        addText("KARINE", 300, 200, 'center');
        
        
        addText("FOKONTANY", 300, 400, 'center');
        addText(membres_menage[0].libelle_fokontany, 300, 420, 'center');
        
        //******************************End Couverture*************************/
        
        //******************************Liste membres ménages**************** */
        pdf.addPage();
        pdf.setFontSize(12);
        pdf.setFont("helvetica");
        pdf.setFontType("normal");
        
        pdf.setFontType("italic");
        pdf.setFontStyle("bold");
        addText("REPOBLIKAN'I MADAGASIKARA", 300, null, 'center');
        addText("Fitiavana - Tanindrazana - Fandrosoana", 300, null, 'center');
        
        pdf.setFontStyle("normal");
        pdf.setFontType("normal");
        addText("Faritra : " + membres_menage[0].region_name, null, null, null);
        addText("Distrika : " + membres_menage[0].district_name, null, null, null);
        addText("Kaominina : " + membres_menage[0].common_name, null, null, null);
        addText("Fokontany : " + membres_menage[0].libelle_fokontany, null, null, null);
        addText("", null, null, null);
        
        pdf.setFontStyle("bold");
        addText("KARA-POKONOLONA", null, null, null);
        pdf.setFontStyle("normal");
        addText("N° ", membres_menage[0].numero_carnet, null, null);
        addText("Lot " + membres_menage[0].adresse_actuelle, null, null, null);
        addText("Ankohonana:", null, null, null);
        addImageToPdf();
        $.each(membres_menage, function(index, membre){
            index += 1;
            pdf.text(10, line, index + " " +membre.nom + " " + membre.prenoms);
            line += 10;
        });
        //******************************End Liste membres ménages************* */
        
        //******************************Liste membres ménages 3 par page *****/
        pdf.setFontSize(12);
        pdf.addPage();
        line = 20;
        $.each(membres_menage, function(index, membre){
            addText("Anarana : " + membre.nom, null, null, null);
            addText("Fanampiny : " + membre.prenoms, null, null, null);
            addText("Teraka tamin'ny : " + membre.date_de_naissance, null, null, null);
            addText("Zanak'i : " + membre.father, null, null, null);
            addText("Sy : " + membre.mother, null, null, null);
            addText("CIN N° : " + membre.cin_personne, null, null, null);
            addText("Natao ny : " + membre.lieu_delivrance_cin, null, null, null);
            addText("Asa : " + (!membre.job?"                   ":membre.job) +"   FKT : " + membre.libelle_fokontany, null, null, null);
            
            if((index + 1)%3 === 0){
                pdf.addPage();
                line = 8;
            }

            line += 12;
        });
        //******************************End Liste membres ménages 3 par page **/

        pdf.save('test.pdf');
    }

    function addText(texte, x, y, alignemnt){
      pdf.text(texte, x==null?10:x, y==null?line:y, null, null, alignemnt);
      line += 12;  
    }
    
    function addImageToPdf(){
        var img = new Image();
        img.src = "assets/ecusson.png";
        img.addEventListener('load', function(){
            pdf.addImage(img, 'png', 10, 50);
        });
    }

});