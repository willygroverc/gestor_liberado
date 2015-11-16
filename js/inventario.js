function guardar_inventario(){
new FormValidator('frm_inv', [{
    name: 'codigo_usu',
    display: 'CODIGO',    
    rules: 'required|etq_HTML'
},{	
	name: 'tipo_medio',
	display: 'TIPO MEDIO',
	rules: 'required|etq_HTML'
},{	
	name: 'tipo_dato',
	display: 'TIPO DATO',
	rules: 'required|etq_HTML'
},{	
	name: 'nro_cds',
	display: 'NUMERO DE CD',
	rules: 'required|etq_HTML'
},{	
	name: 'nro_corre',
	display: '',
	rules: 'required'
},{	
	name: 'Observ',
	display: 'OBSERVACIONES',
	rules: 'required|etq_HTML'
},{	
	name: 'Codigo',
	display: 'Codigo',
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

	if (document.forms[0].onsubmit()==true){
	
		if (confirm('Desea registrar los datos introducidos?')){
			var codigo_usu=document.getElementById('codigo_usu');
			var tipo_medio=document.getElementById('tipo_medio');
			var tipo_dato=document.getElementById('tipo_dato');
			var nro_cds=document.getElementById('nro_cds');
			var nro_corre=document.getElementById('nro_corre');
			var Observ=document.getElementById('Observ');
			var Codigo=document.getElementById('Codigo');
			ajax=NuevoAjax();
			ajax.open("POST","abm/nuevo_inventario.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					if (r==0){
						alert('Los datos han sido registrados...');
						location.href="lista_controlinvent.php";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("codigo_usu="+codigo_usu.value+"&tipo_medio="+tipo_medio.value+"&tipo_dato="+tipo_dato.value+"&nro_cds="+nro_cds.value+"&nro_corre="+nro_corre.value+"&Observ="+Observ.value+"&Codigo="+Codigo.value);
		}
	}
}
function retornar(opc){
	//history.back(0);
	if (opc==1){
		if (confirm('Desea salir? se perderan los cambios no guardados.'))
			location.href="lista_controlinvent.php";
	}
}