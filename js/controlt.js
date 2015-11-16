function guardar_resp(){
new FormValidator('frm_respaldos', [{
    name: 'codigo',
    display: 'CODIGO',    
    rules: 'required|etq_HTML'
},{	
	name: 'fecha_ctrl',
	display: 'FECHA',
	rules: 'required|etq_HTML'
},{	
	name: 'contenido',
	display: 'CONTENIDO',
	rules: 'required|etq_HTML'
},{	
	name: 'Sistema',
	display: '',
	rules: ''
},{	
	name: 'Negocio',
	display: '',
	rules: ''
},{	
	name: 'SE1',
	display: '',
	rules: ''
},{	
	name: 'SE2',
	display: '',
	rules: ''
},{	
	name: 'var1',
	display: 'ID',
	rules: 'required|etq_HTML'
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

	var codigo=document.getElementById('codigo');
	if (codigo.value==0){
		document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar Codigo.</div>';
		return;
	}
	var Sistema=document.getElementById('Sistema');
	var Negocio=document.getElementById('Negocio');
	var SE1=document.getElementById('SE1');
	var SE2=document.getElementById('SE2');
	if (Sistema.checked==true){
			Sistema.value=1;	
	} else {
			Sistema.value=0;
	}
	if (Negocio.checked==true){
			Negocio.value=1;	
	} else {
			Negocio.value=0;
	}
	
	if (SE1.checked==true){
			SE1.value=1;	
	} else {
			SE1.value=0;
	}
	
	if (SE2.checked==true){
			SE2.value=1;	
	} else {
			SE2.value=0;
	}
	if (document.forms[0].onsubmit()==true){
	
		if (confirm('Desea registrar los datos introducidos?')){
			var fecha_ctrl=document.getElementById('fecha_ctrl');
			var contenido=document.getElementById('contenido');
			var observ=document.getElementById('observ');
			var var1=document.getElementById('var1');
			
			ajax=NuevoAjax();
			ajax.open("POST","abm/nuevo_respaldo.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					if (r==0){
						alert('Los datos han sido registrados...');
						location.href="lista_ubicacionr.php";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("codigo="+codigo.value+"&fecha_ctrl="+fecha_ctrl.value+"&contenido="+contenido.value+"&Sistema="+Sistema.value+"&Negocio="+Negocio.value+"&SE1="+SE1.value+"&SE2="+SE2.value+"&observ="+observ.value+"&var1="+var1.value);
		}
	}
}
function retornar(opc){
	//history.back(0);
	if (opc==1){
		if (confirm('Desea salir? se perderan los cambios no guardados.'))
			location.href="lista_ubicacionr.php";
	}
}