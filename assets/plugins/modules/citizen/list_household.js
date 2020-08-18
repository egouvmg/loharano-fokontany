$(function () {
    var household_head = function (cell, formatterParams) {
		return cell.getRow().getData().nom + ' ' + cell.getRow().getData().prenoms;
    };

    var is_household_head = function (cell, formatterParams) {
        return (cell.getValue()) ? 'Oui' : 'Non';
    };

    var types = function (cell, formatterParams) {
        var value = cell.getValue();

        switch (value) {
            case "1": return "Vivres"; break;
            case "2": return "Cash"; break;
        }
    };

    var payment_types = function (cell, formatterParams) {
        var value = cell.getValue();

        switch (value) {
            case 1: return "M'Vola"; break;
            case 2: return "Orange Money"; break;
            case 3: return "Airtel Money"; break;
            case 4: return "Virement bancaire"; break;
        }
    };

    var context = function(cell, formatterParams) {
        var value = cell.getValue();
        var bank = '';

        switch (cell.getRow().getData().bank) {
            case 1: bank = "BNI"; break;
            case 2: bank = "BFV"; break;
            case 3: bank = "BOA"; break;
            case 4: bank = "Access Banque"; break;
            case 5: bank = "BMOI"; break;
            case 6: bank = "BGFI"; break;
            case 7: bank = "Sipem Banque"; break;
        };

        switch(value){
            case 1: 
            case 2: 
            case 3: return "Téléphone : " + cell.getRow().getData().phone; break;
            case 4: return "Banque : " + bank + ", n° de compte/IBAN : " + cell.getRow().getData().rib  ; break;
            case 5: return "Compte : " + cell.getRow().getData().paositra_account; break;
        }
    };

    function customFormatter(cell, formatterParams){
        const button = document.createElement("input");
        button.type = "button";
        button.name = "add";
        button.value = "Aides sociales reçues";
        button.className="btn-sm btn-success btn-xs";

        button.textContent = "Aides sociales reçues";
        return button;
    }
    
	var households = new Tabulator("#households", {
        layout:"fitColumns",
        selectable: 1,
		ajaxURL: "liste_menages_fokontany",
        columnVertAlign:"bottom", //align header contents to bottom of cell
        cellVertAlign:"middle", //vertically center cell contents
        ajaxConfig: "GET",
        ajaxSorting:true,
		initialSort:[
			{column:"full_name", dir:"asc"}
		],
        columns:[ //Define Table Columns
            {title:"Chef ménage", width:300, field:"full_name"}, 
            {title:"Numéro Carnet", field:"numero_carnet"},
            {title:"Adresse", field:"adresse_actuelle"},  
            {formatter: customFormatter, title: "Aides Sociales",
            cellClick:function(e, cell){
                $('#nom_complet_chef').text(cell.getRow().getData().nom + ' ' + cell.getRow().getData().prenoms);
                citizenAids.setData('aide_par_menage', {numero_carnet:cell.getRow().getData().numero_carnet});
                $('#aidDetails').modal();
            }}
        ],
        rowClick:function(e, row){
            $('#numero_carnet_hidden').val(row.getData().numero_carnet);
            citizens.setData('membres_menage', {numero_carnet:row.getData().numero_carnet});
        },
        pagination:"remote", //enable remote pagination
        paginationSize:10,
        paginationSizeSelector:[10, 20, 50],
        ajaxFiltering:true,
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
                "ajax": {
                    "loading": "Chargement",
                    "error": "Erreur"
                },
                "pagination":{
                    "page_size":"Taille de page",
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

    var citizenAids = new Tabulator('#citizenAids', {
        layout:"fitColumns",
		initialSort:[
			{column:"created_on", dir:"desc"}
		],
        columns:[ //Define Table Columns 
            {title:"Aide reçue", field:"name"},
            {title:"Type", field: "type", width:100, formatter: types},
            {title:"Date", field:"created_on", width:100},
            {title:"Mode de virement", field: "payment_type", width:160, formatter: payment_types},
            {title:"Détails", field: "payment_type", formatter: context},
            {title:"Description", field:"description"} 
        ],
        pagination:"local",
        paginationSize:5,
        paginationSizeSelector:[5, 10, 20, 50, 100, 200],
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
                "ajax": {
                    "loading": "Chargement",
                    "error": "Erreur"
                },
                "pagination":{
                    "page_size":"Taille de page",
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
                "ajax": {
                    "loading": "Chargement",
                    "error": "Erreur"
                },
                "pagination":{
                    "page_size":"Taille de page",
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
			{column:"chef_menage", dir:"desc"}
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
            histories_certificates.setData('historique_certificat', {id_person:id_peron});
            
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
            $('#date_de_naissance').val(splitDate(row.getData().date_de_naissance));
            
            if(row.getData().cin_date){
                $('#date_delivrance_cin').val(splitDate(row.getData().cin_date));
                $('#lieu_delivrance_cin').val(row.getData().cin_place);
            }         
            if(row.getData().date_delivrance_cin){
                $('#date_delivrance_cin').val(splitDate(row.getData().date_delivrance_cin));
                $('#lieu_delivrance_cin').val(row.getData().lieu_delivrance_cin);
            }

            $('#certificat_residence').attr("href", "certificate?id_personne="+id_peron).attr("target", "_blank");
            $('#certificat_move').attr("href", "certificate_move?id_personne="+id_peron).attr("target", "_blank");
            $('#certificat_celibat').attr("href", "certificate_celibat?id_personne="+id_peron).attr("target", "_blank");
            $('#certificat_life').attr("href", "certificate_life?id_personne="+id_peron).attr("target", "_blank");
            $('#certificat_supported').attr("href", "certificate_supported?id_personne="+id_peron).attr("target", "_blank");
            $('#certificat_behavior').attr("href", "certificate_behavior?id_personne="+id_peron).attr("target", "_blank");

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
                "ajax": {
                    "loading": "Chargement",
                    "error": "Erreur"
                },
                "pagination":{
                    "page_size":"Taille de page",
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

    var histories_certificates = new Tabulator('#historyCertificate', {
        layout:"fitColumns",
		initialSort:[
			{column:"date_migration", dir:"desc"}
		],
        columns:[ //Define Table Columns
            {title:"Date", field:"date_generation"},
            {title:"Motif", field:"motif"}    
        ],
        pagination:"local",
        paginationSize:5,
        paginationSizeSelector:[5, 10, 20, 50, 100, 200],
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
                "ajax": {
                    "loading": "Chargement",
                    "error": "Erreur"
                },
                "pagination":{
                    "page_size":"Taille de page",
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

    households.setLocale("fr-fr");
    histories.setLocale("fr-fr");
    citizens.setLocale("fr-fr");
    citizenAids.setLocale("fr-fr");
    histories_certificates.setLocale("fr-fr");

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
    
    var timer = '';

    $('.speed_access').on('keyup', function(e){
        if($(this).val().length < 4) return false;

        var data = {
            nom:$('#nom').val(),
            prenoms:$('#prenoms').val(),
            cin_personne:$('#cin_personne').val()
        }

        clearTimeout(timer);
        timer = setTimeout(function() {
            households.setData('liste_menages_fokontany', data);
        }, 1000);
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
            if(res.success == 1){
                alert(res.msg);
                citizens.setData();
            }
        }, 'JSON');
    });

    var pdf = null;
    line = 0;
    index_page = 0;
    let a = document.createElement("a");
    $('#carnet_id').click(function(e){
        pdf = null;
        pdf = new jsPDF('p','px','a4');
        line = 20;
        e.preventDefault();
        data={};
        data["numero_carnet"]= $('#numero_carnet_hidden').val();

        if($('#numero_carnet_hidden').val() == ''){
            /*$('.toast-container').css({
                'cssText': 'bottom: 220px !important'
            });*/
            notify('error',"Message d'erreur!",'Veuillez choisir un ménage avant de créer un Carnet Fokontany');
            return false;
        }

        $.get('membres_menage', data, function(res){
            createCarnet(res);
        }, 'JSON');
        index_page = 0;
    });

    $('#add_citizen').click(function(e){
        e.preventDefault();

        if($('#numero_carnet_hidden').val() == ''){
            notify('error',"Message d'erreur!",'Veuillez choisir un ménage avant de procéder à l\'ajout de citoyen.');
            return false;
        }

        $.get('ajout_dans_menage', {numero_carnet:$('#numero_carnet_hidden').val()}, function(res){
            if(res.success == 1) window.location = 'ajouter_dans_menage';
            if(res.error == 1) alert(res.msg);
        }, 'JSON');
    });
    
 //   var pdf = new jsPDF('p','px','a4');
 //   line = 20;

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

        //*******************************Vertical Line***********************/
        //pdf.setDrawColor(255, 0, 0);
        pdf.setLineWidth(1);
        pdf.line(220, 0, 220, 630);
        //*******************************Vertical Line***********************/
        
        pdf.setFontType("italic");
        pdf.setFontStyle("bold");
        addText("REPOBLIKAN'I MADAGASIKARA", 100, null, 'center');
        addText("Fitiavana - Tanindrazana - Fandrosoana", 100, null, 'center');
        pdf.setFontSize(16);
        
        addText("KARINE", 100, 100, 'center');//addText("KARINE", 300, 200, 'center')
        pdf.rect(20, 70, 160, 50);
        
        //******************************Adding QR Code*****************************/
        pdf.setFontType("normal");
        pdf.setFontStyle("normal");

        var qr = new QRious({
            //background: 'green',
            backgroundAlpha: 0.8,
            //foreground: 'blue',
            //foregroundAlpha: 0.8,
            level: 'H',
            padding: 25,
            size: 500,
            value: window.location.origin+"/index_qrcode?numero_carnet="+$('#numero_carnet_hidden').val()
          });

          var imgData = qr.toDataURL('image/jpeg');



        //var imgData = 'data:image/jpeg;base64,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';
        pdf.addImage(imgData, 'JPG', 50, 155, 100, 100);
        //pdf.output('datauri');
        //******************************End Adding QR Code*************************/
        pdf.setFontType("italic");
        pdf.setFontStyle("bold");
        
        addText("FOKONTANY", 100, 280, 'center');
        addText(membres_menage[0].libelle_fokontany, 100, 300, 'center');

        //pdf.setLineDash([1, 1.5, 1, 1.5, 1, 1.5, 3, 2, 3, 2, 3, 2]);
        pdf.line(0 , 310, 510, 310);
        //******************************End Couverture*************************/
        
        //******************************Liste membres ménages**************** */
        //pdf.addPage();
        line = 20;
        pdf.setFontSize(12);
        pdf.setFont("helvetica");
        pdf.setFontType("normal");
        
        pdf.setFontType("italic");
        pdf.setFontStyle("bold");
        addText("REPOBLIKAN'I MADAGASIKARA", 320, null, 'center');
        addText("Fitiavana - Tanindrazana - Fandrosoana", 320, null, 'center');
        
        pdf.setFontStyle("normal");
        pdf.setFontType("normal");
        addText("", 230, null, null);
        addText("Faritra : " + membres_menage[0].region_name, 230, null, null);
        addText("Distrika : " + membres_menage[0].district_name, 230, null, null);
        addText("Kaominina : " + membres_menage[0].common_name, 230, null, null);
        addText("Fokontany : " + membres_menage[0].libelle_fokontany, 230, null, null);
        addText("", 320, null, null);
        
        pdf.setFontStyle("bold");
        addText("KARA-POKONOLONA", 230, null, null);
        pdf.setFontStyle("normal");
        addText("N° ", membres_menage[0].numero_carnet, 230, null);
        addText("Lot " + membres_menage[0].adresse_actuelle, 230, null, null);
        addText("Ankohonana:", 230, null, null);
        addImageToPdf();
        $.each(membres_menage, function(index, membre){
            index += 1;
            pdf.text(230, line, index + " " +membre.nom + " " + membre.prenoms);
            line += 10;
        });
        //******************************End Liste membres ménages************* */
        
        //******************************Liste membres ménages 3 par page *****/
        pdf.setFontSize(12);
        //pdf.addPage();
        line = 320;
        row = 10;
        $.each(membres_menage, function(index, membre){
            addText("Anarana : " + (membre.nom==null?"":membre.nom), null, null, null);
            addText("Fanampiny : " + (membre.prenoms==null?"":membre.prenoms), null, null, null);
            addText("Teraka tamin'ny : " + (membre.date_de_naissance==null?"":membre.date_de_naissance), null, null, null);
            addText("Zanak'i : " + (membre.father==null?"":membre.father), null, null, null);
            addText("Sy : " + (membre.mother==null?"":membre.mother), null, null, null);
            addText("CIN N° : " + (membre.cin_personne==null?"":membre.cin_personne), null, null, null);
            addText("Natao ny : " + (membre.lieu_delivrance_cin==null?"":membre.lieu_delivrance_cin), null, null, null);
            addText("Asa : " + (!membre.job?"                   ":membre.job) +"   FKT : " + membre.libelle_fokontany, null, null, null);
            
            if((index + 1)%3 === 0){
                index_page++;
                if((index_page)%2 !== 0){
                    row = 230;
                    line = 308;
                }
                else{
                  pdf.addPage();
                  pdf.setLineWidth(1);
                  pdf.line(220, 0, 220, 630);      
                  pdf.line(0 , 345, 510, 345);
                  
                  line = 10;
                  row = 10;
               }
            }

            line += 12;
        });
        //******************************End Liste membres ménages 3 par page **/
        var namepdf = "file.pdf";
        var today = new Date();
        var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
        namepdf =  "Karine_pokontany"+'_'+membres_menage[0].numero_carnet+'_'+date; 
        pdf.setProperties({
            title: namepdf
        });

        //data = pdf.output("dataurlstring");      
        //var blobPDF = new Blob([pdf.output('blob', {'filename':namepdf})], { type : 'application/pdf'});
        var blobPDF = new Blob([pdf.output('blob')], { type : 'application/pdf'});
        var blobUrl = window.URL.createObjectURL(blobPDF);
        
        
        //pdfAttachment : Files; //declare the file
        var pdfAttachment = null;
        newName = 'new_file_name'      
        /* pdfAttachment = new File([pdf.output('blob')], newName, {
              type: pdf.output('blob').type,
              lastModified: pdf.output('blob').lastModified,
            });

       */
        a.href = blobUrl;
        a.download = namepdf;
        document.body.appendChild(a);
       
        //document.getElementById("pdf").src = data;
        //var pdf = $('#pdf').attr('src',data);
        pdfActu = $('#pdf');

        var pdfclone=pdfActu.clone(true);
        pdfclone.attr('src',blobUrl+"#toolbar=0&page=1");
        //pdfclone.attr('src',data);
        pdfActu.replaceWith(pdfclone)
        //document.querySelector("#pdf").src = data;
        //$("#pdf").src = data;
        //$('#report').html("<iframe src='#{data}'></iframe>");
        $('#myModal').modal();
        $('#download').remove();
        //pdf.save(namepdf);
    }
    $('#print').click(function(e){
        a.click();
    }); 
    
    $('#myModal').ready(function() {
        setTimeout(function() {
           $('#pdf').contents().find('#download').remove();
        }, 100);
     });
    /*
     $( "#myModal" ).on('shown.bs.modal', function(){
        setTimeout(function() {
            var iframe = document.getElementById("pdf");
            var content = iframe.contentDocument;
            var elmnt = content.getElementById("toolbar");
            //var elmnt = iframe.getElementById("download");
            //var elmnt = iframe.contentWindow.document.getElementsByTagName("cr-icon-button")[1];
            elmnt.style.display = "none";
            $('#pdf').contents().find('#download').remove();
         }, 100);
    });
    */
    function addText(texte, x, y, alignemnt){
      pdf.text(texte==null?'':texte, x==null?row:x, y==null?line:y, null, null, alignemnt);
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