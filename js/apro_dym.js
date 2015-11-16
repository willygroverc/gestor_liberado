function guardar_apro(){
new FormValidator('frm_apro', [{	
	name: 'NombRespAp',
	display: 'Responsable de implantacion',
	rules: 'required|etq_HTML'
},{	
	name: 'NomUsRespAp',
	display: 'Usuario Responsable',
	rules: 'required|etq_HTML'
},{	
	name: 'ComCambAp',
	display: 'Comite de Cambios',
	rules: 'required|etq_HTML'
},{	
	name: 'observ1',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'observ2',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'observ3',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'fecha_imp',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'fecha_resp',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'fecha_cab',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'var1',
	display: 'TITULO',
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
		var NombRespAp=document.getElementById('NombRespAp');
		if(NombRespAp.value==0)
		{		
			document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar Responsable de implantacion.</div>';
			return;
		}
		var NomUsRespAp=document.getElementById('NomUsRespAp');
		if(NomUsRespAp.value==0)
		{		
			document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar Usuario Responsable.</div>';
			return;
		}
		var ComCambAp=document.getElementById('ComCambAp');
		if(ComCambAp.value==0)
		{		
			document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar Comite de Cambios.</div>';
			return;
		}
		if (confirm('desea guardar los datos?')){
			var observ1=document.getElementById('observ1');
			var observ2=document.getElementById('observ2');
			var observ3=document.getElementById('observ3');
			var fecha_imp=document.getElementById('fecha_imp');
			var fecha_resp=document.getElementById('fecha_resp');
			var fecha_cab=document.getElementById('fecha_cab');
			
			ajax=NuevoAjax();
			ajax.open("POST","abm/nuevo_apro_dym.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					if (r==-1){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Los datos no se han registrado. Si el problema persiste pongase en contacto con el administrador</div>';
					}
					if (r==-2){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Ocurrio un error al ingresar nuevo usuario, por favor intente de nuevo. Si el problema persiste, contacte con el administrador.</div>';
					}
					if (r==0){
						alert('Datos registrados...')
						//document.getElementById('success_box').innerHTML='La operacion se ha completado con exito!';
						location.href="lista_mantenimiento.php";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("NombRespAp="+NombRespAp.value+"&NomUsRespAp="+NomUsRespAp.value+"&ComCambAp="+ComCambAp.value+"&observ1="+observ1.value+"&observ2="+observ2.value+"&observ3="+observ3.value+"&fecha_imp="+fecha_imp.value+"&fecha_resp="+fecha_resp.value+"&fecha_cab="+fecha_cab.value+"&var1="+var1.value);
		}
	
}
function retornar(){
	//history.back(0);
		if (confirm('Desea retornar? No se registraran los datos.'))
			location.href="lista_mantenimiento.php";
	
}