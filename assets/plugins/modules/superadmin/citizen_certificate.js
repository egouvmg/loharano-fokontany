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

    function createPdf(){
        html2canvas($('#content'), {
            onrendered: function( canvas ) {
                var img1 = canvas.toDataURL('image/png');
                var doc = new jsPDF('p','px','a4');//'p', 'mm'
                var namepdf = "file.pdf";
                doc.addImage( img1, 'JPEG', 0, 0, 450, 316); // A5 sizes
                //doc.addImage( img1, 'PNG', 0, 296, 420, 296); // A5 sizes
                var today = new Date();
                var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
                namepdf =  ($("#origin_page").val()=="move"?"demenagement":$("#origin_page").val())+"_"+$("#name").text()+"_"+date;  
                namepdf = "certificat"+"_"+namepdf;
                doc.save(namepdf);
            }
        });

    }

    $(".remove").click(function(e){
        e.preventDefault();
        $(this).parents().eq(1).remove();
    });
});