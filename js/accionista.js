function guardar_nuevo_acc(){
new FormValidator('frm_acc', [{
    name: 'nom_acc',
    display: 'NOMBRE',    
    rules: 'required|etq_HTML'
},{	
	name: 'nac_acc',
	display: 'NACIONALIDAD',
	rules: 'required|etq_HTML'
},{	
	name: 'fecha_acc',
	display: 'FECHA',
	rules: 'required|etq_HTML'
},{	
	name: 'dom_acc',
	display: 'DOMICILIO',
	rules: 'required|etq_HTML'
},{	
	name: 'tel_acc',
	display: 'TELEFONO',
	rules: 'integer|exact_length[8]'
},{	
	name: 'estado',
	display: '',
	rules: ''
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
	var estado1=document.getElementById('estado');
	//alert(estado1.value);
	if (estado1.value==0){
		document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar Estado.</div>';
		return;
	}
	
	if (document.forms[0].onsubmit()==true){
	
		if (confirm('Desea registrar los datos introducidos?')){
			var nom_acc=document.getElementById('nom_acc');
			var fecha_acc=document.getElementById('fecha_acc');
			var nac_acc=document.getElementById('nac_acc');
			var dom_acc=document.getElementById('dom_acc');
			var tel_acc=document.getElementById('tel_acc');
			ajax=NuevoAjax();
			ajax.open("POST","abm/nuevo_accionista.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					//alert(r);
					if (r==-1){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Los datos no se han registrado. Si el problema persiste pongase en contacto con el administrador</div>';
					}
					if (r==-2){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Ocurrio un error al ingresar nuevo usuario, por favor intente de nuevo. Si el problema persiste, contacte con el administrador.</div>';
					}
					if (r==0){
						alert('La operacion se ha completado con exito.')
						document.forms[0].onsubmit();
						document.getElementById('error_box').innerHTML='La operacion se ha completado con exito!';
						nom_acc.value='';
						nac_acc.value='';
						dom_acc.value='';
						tel_acc.value='';
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
			ajax.send("nom_acc="+nom_acc.value+"&fecha_acc="+fecha_acc.value+"&nac_acc="+nac_acc.value+"&dom_acc="+dom_acc.value+"&tel_acc="+tel_acc.value+"&estado1="+estado1.value);
		}
	}
}
function retornar(opc){
	//history.back(0);
	if (opc==1){
		if (confirm('Desea retornar? se perderan los cambios no guardados.'))
			location.href="naccionista_det.php";
	}
}