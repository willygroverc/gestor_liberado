function guardar_mensual(){
new FormValidator('frm_mensual', [{
    name: 'FechaProceso',
    display: 'Fecha',    
    rules: 'required|etq_HTML'
},{	
	name: 'Actividad',
	display: 'Actividad',
	rules: 'required|etq_HTML'
},{	
	name: 'Observaciones',
	display: 'Observaciones',
	rules: 'required|etq_HTML'
},{	
	name: 'HoraDe',
	display: 'HORA DE',
	rules: 'required|etq_HTML'
},{	
	name: 'lista',
	display: 'NOMBRE',
	rules: 'required|etq_HTML'
},{	
	name: 'HoraA',
	display: 'HORA A',
	rules: 'required|etq_HTML'
},{	
	name: 'Dia',
	display: 'DIA',
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
			var HoraDe=document.getElementById('HoraDe');
			var HoraA=document.getElementById('HoraA');
			var Dia=document.getElementById('Dia');
			var lista=document.getElementById('lista');
			ajax=NuevoAjax();
			ajax.open("POST","abm/nueva_mensual.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					if (r=='0'){
						alert('Los datos han sido registrados...');
						location.href="lista_progtareas.php";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("FechaProceso="+FechaProceso.value+"&Actividad="+Actividad.value+"&Observaciones="+Observaciones.value+"&HoraDe="+HoraDe.value+"&HoraA="+HoraA.value+"&lista="+lista.value+"&Dia="+Dia.value);
		}
	}
}
function retornar(){
	//history.back(0);
		if (confirm('Desea salir? se perderan los cambios no guardados.'))
			location.href="lista_progtareas.php";
}