function guardar_nuevo_acc(){
new FormValidator('frm_det', [{
    name: 'serie_ac',
    display: 'SERIE',    
    rules: 'required|etq_HTML'
},{	
	name: 'val_nom',
	display: 'VALOR NOMINAL',
	rules: 'required|etq_HTML'
},{	
	name: 'fecha_acc',
	display: 'FECHA',
	rules: 'required|etq_HTML'
},{	
	name: 'accion_tit',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'valor',
	display: 'VALOR',
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
	//var valor=document.getElementById('accion_tit');
	//alert(valor.value);
	/*if (estado1.value==0){
		document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar Estado.</div>';
		return;
	}*/
	
	if (document.forms[0].onsubmit()==true){
		if (confirm('Desea registrar los datos introducidos?')){
			var serie_ac=document.getElementById('serie_ac');
			//alert(serie_ac.value);
			var val_nom=document.getElementById('val_nom');
			var fecha_acc=document.getElementById('fecha_acc');
			var accion_tit=document.getElementById('accion_tit');
			var valor=document.getElementById('valor');
			ajax=NuevoAjax();
			ajax.open("POST","abm/nuevo_accionista_det.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					if (r==-1){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">No se registraron sus datos...</div>';
					}
					if (r==-2){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Ocurrio un error al ingresar nuevo usuario, por favor intente de nuevo. Si el problema persiste, contacte con el administrador.</div>';
					}
					if (r==0){
						alert('La operacion se ha completado con exito.')
						document.forms[0].onsubmit();
						document.getElementById('error_box').innerHTML='La operacion se ha completado con exito!';
						serie_ac.value='';
						val_nom.value='';
						fecha_acc.value='';
						accion_tit.value='';
						valor.value='';
						/*if (confirm('Desea Agregar mas accionistas?')){
							location.href="naccionista.php";
						}
						else{
							location.href="accionistas.php";
						}*/
						location.href="naccionista_det.php";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("serie_ac="+serie_ac.value+"&val_nom="+val_nom.value+"&fecha_acc="+fecha_acc.value+"&accion_tit="+accion_tit.value+"&valor="+valor.value);
		}
	}
}
function retornar(opc){
	//history.back(0);
	if (opc==1){
		if (confirm('Desea salir? se perderan los cambios no guardados.'))
			location.href="naccionista_det.php";
	}
}