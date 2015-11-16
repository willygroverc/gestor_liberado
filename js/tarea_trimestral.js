function guardar_trimestral(){
new FormValidator('frm_trimestral', [{
    name: 'FechaProceso',
    display: 'Fecha',    
    rules: 'required|etq_HTML'
},{	
	name: 'Actividad',
	display: 'Actividad',
	rules: 'required|etq_HTML'
},{	
	name: 'Hora1',
	display: 'HORA',
	rules: 'required|etq_HTML'
},{	
	name: 'Hora2',
	display: 'HORA',
	rules: 'required|etq_HTML'
},{	
	name: 'Min1',
	display: 'MINUTOS',
	rules: 'required|etq_HTML'
},{	
	name: 'Min2',
	display: 'MINUTOS',
	rules: 'required|etq_HTML'
},{	
	name: 'Mes',
	display: 'MES',
	rules: 'required|etq_HTML'
},{	
	name: 'Dia',
	display: 'DIA',
	rules: 'required|etq_HTML'
},{	
	name: 'lista',
	display: 'NOMBRE',
	rules: 'required|etq_HTML'
},{	
	name: 'Observaciones',
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
	//var lista=document.getElementById('lista');
	//alert(lista.value);
	if (document.forms[0].onsubmit()==true){
	
		if (confirm('Desea registrar los datos introducidos?')){
			var FechaProceso=document.getElementById('FechaProceso');
			var Actividad=document.getElementById('Actividad');
			var Observaciones=document.getElementById('Observaciones');
			var Hora1=document.getElementById('Hora1');
			var Hora2=document.getElementById('Hora2');
			var Min1=document.getElementById('Min1');
			var Min2=document.getElementById('Min2');
			var Mes=document.getElementById('Mes');
			var Dia=document.getElementById('Dia');
			var lista=document.getElementById('lista');
			ajax=NuevoAjax();
			ajax.open("POST","abm/nueva_trimestral.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					if (r==-1){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">"Hora DE:" no puede ser mayor a "HORA A:"</div>';
					}
					if (r=='0'){
						alert('Los datos han sido registrados...');
						location.href="lista_progtareas2.php";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("FechaProceso="+FechaProceso.value+"&Actividad="+Actividad.value+"&Observaciones="+Observaciones.value+"&Hora1="+Hora1.value+"&Min1="+Min1.value+"&Hora2="+Hora2.value+"&Min2="+Min2.value+"&Mes="+Mes.value+"&Dia="+Dia.value+"&lista="+lista.value);
		}
	}
}
function retornar(){
	//history.back(0);
		if (confirm('Desea salir? se perderan los cambios no guardados.'))
			location.href="lista_progtareas2.php";
}