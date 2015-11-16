function guardar_caracteristicas(){
new FormValidator('frm_carac', [{
   name: 'Capacid',
	display: 'Capacidad',
	rules: 'required|etq_HTML'
},{	
	name: 'Veloc',
	display: 'Velocidad',
	rules: 'required|etq_HTML'
},{	
	name: 'Marca',
	display: 'Marca',
	rules: 'required|etq_HTML'
},{	
	name: 'ModSerie',
	display: 'Modelo-Serie',
	rules: 'required|etq_HTML'
},{	
	name: 'Adicio',
	display: 'Cod. adicional',
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
	
	var variable2=document.getElementById('variable2');
	//alert(variable2.value);
	if (document.forms[0].onsubmit()==true){
	
		if (confirm('Desea registrar los datos introducidos?')){
			//var Accesorio=document.getElementById('Accesorio');
			var Capacid=document.getElementById('Capacid');
			var Veloc=document.getElementById('Veloc');
			var Marca=document.getElementById('Marca');
			var ModSerie=document.getElementById('ModSerie');
			var Adicio=document.getElementById('Adicio');
			ajax=NuevoAjax();
			ajax.open("POST","abm/nueva_caracteristica.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					//alert(r);
					if (r==-1){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">El COD. ACT FIJO ingresado no esta disponible</div>';
					}
					if (r==-2){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">El COD. ACT FIJO ya fue registrado, ingrese otro</div>';
					}
					if (r==0){
						//alert('Datos regitrados con exito...')
						location.href="caracteristica.php?variable2="+variable2.value+"";
					} else	{
						alert('Posiblemente intenta registrar un dato muy largo \n No se han registrados los datos \n');
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("variable2="+variable2.value+"&Capacid="+Capacid.value+"&Veloc="+Veloc.value+"&Marca="+Marca.value+"&ModSerie="+ModSerie.value+"&Adicio="+Adicio.value);
		}
	}
}
function retornar(opc){
	//history.back(0);
	if (opc==1){
		if (confirm('Desea salir? se perderan los cambios no guardados.'))
			location.href="lista_proveed.php";
	}
}
function guardar_continuar(){
	if (confirm('Concluir?'))
			location.href="caracteristica2.php?variable2="+variable2.value+"";
}