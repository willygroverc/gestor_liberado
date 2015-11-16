function guardar_imp(){
new FormValidator('frm_imp', [{	
	name: 'NomCordCamb',
	display: 'Responsable de implantacion',
	rules: 'required|etq_HTML'
},{	
	name: 'NomUsConf',
	display: 'Usuario Responsable',
	rules: 'required|etq_HTML'
},{	
	name: 'fecha_cam',
	display: 'Comite de Cambios',
	rules: 'required|etq_HTML'
},{	
	name: 'fecha_solic',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'var1',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'ResuCordConf',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'ResuUsConf',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'observ1',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'observ2',
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
		var NomCordCamb=document.getElementById('NomCordCamb');
		if(NomCordCamb.value==0)
		{		
			document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar Coordinador de Cambios.</div>';
			return;
		}
		var NomUsConf=document.getElementById('NomUsConf');
		if(NomUsConf.value==0)
		{		
			document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar Usuario Solicitante.</div>';
			return;
		}
		if (confirm('desea guardar los datos?')){
			var fecha_cam=document.getElementById('fecha_cam');
			var fecha_solic=document.getElementById('fecha_solic');
			var var1=document.getElementById('var1');
			var ResuCordConf=document.getElementById('ResuCordConf');
			var ResuUsConf=document.getElementById('ResuUsConf');
			var observ1=document.getElementById('observ1');
			var observ2=document.getElementById('observ2');
			//alert(ResuCordConf.value);
			ajax=NuevoAjax();
			ajax.open("POST","abm/nuevo_imp_dym.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					if (r==-1){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Los datos no se han registrado. Si el problema persiste pongase en contacto con el administrador</div>';
					}
					if (r==-2){
						alert('Primero debe registrar la solucion!');
					}
					if (r==0){
						alert('Datos registrados...')
						location.href="lista_mantenimiento.php";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("NomCordCamb="+NomCordCamb.value+"&NomUsConf="+NomUsConf.value+"&fecha_cam="+fecha_cam.value+"&fecha_solic="+fecha_solic.value+"&var1="+var1.value+"&ResuCordConf="+ResuCordConf.value+"&ResuUsConf="+ResuUsConf.value+"&observ1="+observ1.value+"&observ2="+observ2.value);
		}
	
}
function retornar(opc){
	//history.back(0);
	if (opc==1){
		if (confirm('Desea retornar? No se registraran los datos.'))
			location.href="lista_mantenimiento.php";
	}
}