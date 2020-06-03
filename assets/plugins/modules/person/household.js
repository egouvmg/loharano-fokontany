$(function () {

	$("#addPerson").submit(function (e) {
		e.preventDefault();

		$('#loadingData').show();

		var data = $(this).serializeArray();
		$(".error_field").text("");

		$.get("valider_taille_menage", data, function (res) {
			if (res.invalid_field == 1) {
				for (var i = res.fields.length - 1; i >= 0; i--) {
					$("#" + res.fields[i] + "Error").text("Champs obligatoire");
				}
				$('#loadingData').hide();
			} else if (res.success == 1) {
				location.href = res.next_step;
			}
		}, 'JSON');
	});

	$("#household_size").keypress(function (e) {
		var iKeyCode = (e.which) ? e.which : e.keyCode
		if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
			return false;
		return true;
	});

});
//initialisation
selectAllByFotonkany('#fokontany');
function selectAllByFotonkany(id){
	$.post("fokontany_commune", {id : $(id).val()}, function(res1){
		if(res1.success == 1){
			$('#common').val(res1.childs[0].name);
			$.post("commune_district", {id : res1.childs[0].id}, function(res2){
				if(res2.success == 1){
					$('#district').val(res2.childs[0].name);
					$.post("district_region", {id : res2.childs[0].id}, function(res3){
						if (res3.success == 1) {
							$("#region").val(res3.childs[0].name);
							$.post("region_province", {id : res3.childs[0].id}, function(res4){
								if(res4.success == 1){
									$("#province").val(res4.childs[0].name);
								}else if (res4.error == 1) {
									alert(res3.msg);
								}
							}, 'JSON');
						}else if (res3.error == 1) {
							alert(res3.msg);
						}
					}, 'JSON');
				}else if (res2.error == 1) {
					alert(res2.msg);
				}
			}, 'JSON');
		}else if(res1.error == 1){
			alert(res1.msg);
		}
	}, 'JSON')
}
