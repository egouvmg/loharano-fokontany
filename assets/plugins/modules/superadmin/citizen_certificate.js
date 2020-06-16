$(function () {

    var status = function(cell, formatterParams){
        var value = cell.getValue();
        
        switch(value){
            case 1:return "Actif"; break; 
            case 0:return "Suspendu"; break; 
        }
    };
    
    $("#pdf").click(function(){
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
                  
    });

    function update_or_save(){
        $.post("save_citizen", data, function(){
           var data =  [];

           var 

        } );
    }
});