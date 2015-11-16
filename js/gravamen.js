function guardar_gravamen(){
new FormValidator('frm_gra', [{
    name: 'observaciones',
    display: 'OBSERVACIONES',    
    rules: 'min_length[10]'
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
	var aux=document.getElementById('aux');
	if (document.forms[0].onsubmit()==true){
	var gravamen1=document.getElementById('gravamen1');
	//alert(gravamen1.checked);
	var gravamen2=document.getElementById('gravamen2');
	//alert(gravamen2.checked);
	if (gravamen1.checked==false && gravamen2.checked==false){
			document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar si en gravamen o no.</div>';	
	return;
	}
	/*var radio=2;*/
	if (gravamen1.checked==true){
			var radio = 1;	
	}
	else
	{
		if (gravamen2.checked==true){
				var radio = 2;	
		}
	}
		if (confirm('Desea registrar los datos introducidos?')){
			var observaciones=document.getElementById('observaciones');
			var id_acciones=document.getElementById('id_acciones');
			ajax=NuevoAjax();
			ajax.open("POST","abm/nuevo_gravamen.php",true);
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
						//document.getElementById('success_box').innerHTML='La operacion se ha completado con exito!';
						location.href="gravamen.php?num="+aux.value+"";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("observaciones="+observaciones.value+"&id_acciones="+id_acciones.value+"&radio="+radio);
		}
	}
}
function retornar(opc){
	//history.back(0);
	if (opc==1){
		if (confirm('Desea retornar? No se registraran los datos.'))
			location.href="gravamen.php?num="+aux.value+"";
	}
}