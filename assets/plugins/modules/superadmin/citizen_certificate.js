$(function () {

    var status = function(cell, formatterParams){
        var value = cell.getValue();
        
        switch(value){
            case 1:return "Actif"; break; 
            case 0:return "Suspendu"; break; 
        }
    };
    
    $("#pdf").click(function(){
        update_or_save();
    });

    function update_or_save(){
        var data =  [];
        data.push({name: 'nom', value:$("#Teraka").val()});
        data.push({name: 'prenoms', value: $("#Teraka").val()});
        data.push({name: 'date_de_naissance', value: $("#Teraka").val()});
        data.push({name: 'lieu_de_naissance', value: $("#tao").val()});
        data.push({name: 'cin', value: $("#cin").val()});
        data.push({name: 'date_cin', value: $("#date_cin").val()});
        data.push({name: 'lieu_cin', value: $("#lieu_cin").val()});
        data.push({name: 'nationality_id', value: $("#Zom").val()});
        data.push({name: 'situation_matrimoniale', value: $("#Teraka").val()});
        data.push({name: 'phone', value: $("#Teraka").val()});
        data.push({name: 'father', value: $("#Zanak").val()});
        data.push({name: 'father_status', value: $("#Teraka").val()});
        data.push({name: 'mother', value: $("#sy").val()});
        data.push({name: 'mother_status', value: $("#Teraka").val()});
        data.push({name: 'job_id', value: $("#Teraka").val()});
        data.push({name: 'job_other', value: $("#Teraka").val()});
        data.push({name: 'job_status', value: $("#Teraka").val()});
        data.push({name: 'id_personne', value: $("#id_personne").val()});
        data.push({name: 'origin_page', value: $("#origin_page").val()});
        data.push({name: 'fokontany_id', value: $("#fokontany_id").val()});
        data.push({name: 'motif', value: $("#motif").val()});
        data.push({name: 'fanisana', value: $("#fanisana").val()});

        origin_page = $("#origin_page").val();

        scaler = 0;
        scaler = origin_page!=="behavior"?3:0.7;
        
        $.post("save_citizen_from_certificat", data, function(){

            createPdf();
          /*      
           var pdf = new jsPDF('l','px','a5');
           var specialElementHandlers = {
                '#editor': function (element, renderer) {
                    return true;
                }
            };
           var margins = {top: 90, bottom: 60, left: 90, width: 1748};//{top: 90, bottom: 60, left: 90, width: 900};
           var config = {pagesplit: false, background: '#fff', margin: {top: 0, right: 10, bottom: 0, left: 50}};
            pdf.addHTML($('#content'),0,0, config,function() {
            pdf.save('test.pdf');
           });
           */
        });
    }
//https://stackoverflow.com/questions/36472094/how-to-set-image-to-fit-width-of-the-page-using-jspdf
    function createPdf(){
        const input = $('#content');
        const divHeight = input.height();
        const divWidth = input.width();
        const ratio = divHeight / divWidth;
        html2canvas($('#content').get(0),{scale:3}).then (function( canvas ) {//
                var img1 = canvas.toDataURL('image/png');
                var doc = new jsPDF('p','px','a4');//'p', 'mm'
                var namepdf = "file.pdf";
                /*
                var context = canvas.getContext("2d");
                context.scale(2,2);
                context["imageSmoothingEnabled"] = false;
                context["mozImageSmoothingEnabled"] = false
                context["oImageSmoothingEnabled"] = false
                context["webkitImageSmoothingEnabled"] = false
                context["msImageSmoothingEnabled"] = false
                */
               const width = doc.internal.pageSize.getWidth();
               let height = doc.internal.pageSize.getHeight();
               height = ratio * width;

                doc.addImage( img1, 'JPEG', 0, 20, width - 20, height);
                //doc.addImage( img1, 'PNG', 0, 296, 420, 296); // A5 sizes
                var today = new Date();
                var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
                namepdf =  ($("#origin_page").val()=="move"?"demenagement":($("#origin_page").val()=="support"?"PriseEnCharge":($("#origin_page").val()=="behavior"?"BonneConduite":($("#origin_page").val()=="celibacy"?"Celibat":($("#origin_page")).val()))))+"_"+$("#name").text()+"_"+date;  
                namepdf = "Certificat"+"_"+namepdf;
                doc.save(namepdf);
            }
);

    }

    $(".remove").click(function(e){
        e.preventDefault();
        $(this).parents().eq(1).remove();
    });

    $('.date_type').on('keypress keyup', function (e) {
		var charCode = (e.which) ? e.which : e.keyCode;
		if (charCode == 8) return false;
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

		var index = $('.tab-pane.active').data('index');
		var foo = $(this).val();

		if (foo.length >= 10) {
			return false;
		}

		var foo_tab = foo.split('/');

		if (foo_tab.length == 1 && foo_tab[0].length == 2) {
			if (foo_tab[0] > 31 || foo_tab[0] < 1)
				return false;
			foo = foo_tab[0] + '/';
			$(this).val(foo);
		}
		if (foo_tab.length == 2 && foo_tab[1].length == 2) {
			if (foo_tab[1] > 12 || foo < 1)
				return false;
			foo = foo_tab[0] + '/' + foo_tab[1] + '/';
			$(this).val(foo);
		}

		if (foo_tab.length == 3 && foo_tab[2]) {
			foo = foo_tab[0] + '/' + foo_tab[1] + '/' + foo_tab[2];
			$(this).val(foo);
		}
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
});