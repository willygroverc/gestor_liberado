function guardar_dia_sig(){
new FormValidator('frm_sig', [{
    name: 'descripcion',
    display: 'DESCRIPCION',    
    rules: 'required|etq_HTML'
},{	
	name: 'fecha_inicio',
	display: 'FECHA INICIO',
	rules: 'required|etq_HTML'
},{	
	name: 'hora_inicio',
	display: '',
	rules: ''
},{	
	name: 'fecha_final',
	display: 'FECHA FIN',
	rules: 'required|etq_HTML'
},{	
	name: 'hora_final',
	display: '',
	rules: ''
},{	
	name: 'elegido',
	display: '',
	rules: ''
},{	
	name: 'observ',
	display: 'OBSERVACIONES',
	rules: 'required|etq_HTML'
}], function(errors, event) {
    var SELECTOR_ERRORS = $('.error_box'),
        SELECTOR_SUCCESS = $('.success_box');
        
    if (errors.length > 0) {
        SELECTOR_ERRORS.empty();
        
        for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
            SELECTOR_ERRORS.append(errors[i].message + '<br />');
        }
        
        SELECTOR_SUCCESS.css({ display: 'none' });
        SELECTOR_ERRORS.fadeIn(200);
    } else {
        SELECTOR_ERRORS.css({ display: 'none' });
        SELECTOR_SUCCESS.fadeIn(200);
    }
    
    if (event && event.preventDefault) {
        event.preventDefault();
    } else if (event) {
        event.returnValue = false;
    }
});
	var elegido_array=document.forms[0].elegido;
	for (var j=0; j<=elegido_array.length-1; j++){
		if (elegido_array[j].checked==true)
		var elegido=elegido_array[j].value;
	}
	if (document.forms[0].onsubmit()==true){
	
		if (confirm('Desea registrar los datos introducidos?')){
			var descripcion=document.getElementById('descripcion');
			var fecha_inicio=document.getElementById('fecha_inicio');
			var hora_inicio=document.getElementById('hora_inicio');
			var fecha_final=document.getElementById('fecha_final');
			var hora_final=document.getElementById('hora_final');
			var observ=document.getElementById('observ');
			var id_orden=document.getElementById('id_orden');
			ajax=NuevoAjax();
			ajax.open("POST","abm/guardar_rev_diaria.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					if (r==0){
						//alert('Los datos han sido registrados...');
						location.href="revisionds.php?id_orden="+id_orden.value+"";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("descripcion="+descripcion.value+"&fecha_inicio="+fecha_inicio.value+"&hora_inicio="+hora_inicio.value+"&fecha_final="+fecha_final.value+"&hora_final="+hora_final.value+"&elegido="+elegido+"&observ="+observ.value+"&id_orden="+id_orden.value);
		}
	}
}
function guardar_todo(){
new FormValidator('frm_sig', [{
    name: 'observaciones',
    display: 'OBERVACIONES',    
    rules: 'required|etq_HTML'
},{	
	name: 'nomb_rrevision',
	display: 'FECHA INICIO',
	rules: 'required|etq_HTML'
},{	
	name: 'nomb_rauditoria',
	display: '',
	rules: ''
},{	
	name: 'fecha_rr',
	display: 'FECHA FIN',
	rules: 'required|etq_HTML'
},{	
	name: 'fecha_ra',
	display: '',
	rules: ''
}], function(errors, event) {
    var SELECTOR_ERRORS = $('.error_box1'),
        SELECTOR_SUCCESS = $('.success_box1');
        
    if (errors.length > 0) {
        SELECTOR_ERRORS.empty();
        
        for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
            SELECTOR_ERRORS.append(errors[i].message + '<br />');
        }
        
        SELECTOR_SUCCESS.css({ display: 'none' });
        SELECTOR_ERRORS.fadeIn(200);
    } else {
        SELECTOR_ERRORS.css({ display: 'none' });
        SELECTOR_SUCCESS.fadeIn(200);
    }
    
    if (event && event.preventDefault) {
        event.preventDefault();
    } else if (event) {
        event.returnValue = false;
    }
});
	if (document.forms[0].onsubmit()==true){
	
		if (confirm('Desea registrar los datos introducidos?')){
			var observaciones=document.getElementById('observaciones');
			var nomb_rrevision=document.getElementById('nomb_rrevision');
			var nomb_rauditoria=document.getElementById('nomb_rauditoria');
			var fecha_rr=document.getElementById('fecha_rr');
			var fecha_ra=document.getElementById('fecha_ra');
			var id_orden=document.getElementById('id_orden');
			//alert(id_orden.value);
			ajax=NuevoAjax();
			ajax.open("POST","abm/guarda_revision.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					if (r==0){
						alert('Los datos han sido registrados...');
						location.href="lista_ordenrev1.php";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("observaciones="+observaciones.value+"&nomb_rrevision="+nomb_rrevision.value+"&nomb_rauditoria="+nomb_rauditoria.value+"&fecha_rr="+fecha_rr.value+"&fecha_ra="+fecha_ra.value+"&id_orden="+id_orden.value);
		}
	}
}
function retornar(){
			location.href="lista_ordenrev1.php";
}