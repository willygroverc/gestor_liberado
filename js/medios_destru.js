function guardar_inven(){
new FormValidator('frm_inv', [{
    name: 'var1',
    display: 'MARCA',    
    rules: 'required|etq_HTML'
},{	
	name: 'fecha_ant',
	display: 'CODIGO ADICIONAL',
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

	var var1=document.getElementById('var1');
	var fecha_ant=document.getElementById('fecha_ant');
	
	if (document.forms[0].onsubmit()==true){
	
		if (confirm('Registrar?')){
			var var1=document.getElementById('var1');
			var fecha_ant=document.getElementById('fecha_ant');
			ajax=NuevoAjax();
			ajax.open("POST","abm/nuevo_medio_des.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					if (r==-1){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">El COD. ACT FIJO ingresado no esta disponible</div>';
					}
					if (r==-2){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">El COD. ACT FIJO ya fue registrado, ingrese otro</div>';
					}
					if (r==0){
						alert('Datos registrados...');
						location.href="lista_controlinvent.php";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("var1="+var1.value+"&fecha_ant="+fecha_ant.value);
		}
	}
}
function retornar(opc){
	//history.back(0);
	if (opc==1){
		if (confirm('Desea salir? se perderan los cambios no guardados.'))
			location.href="lista_ficha.php";
	}
}
function filtrar_ficha(){
	var tipo_busq=document.getElementById('campo').value;
	var txt_busq=document.getElementById('txt_busqueda').value;
	var pg=document.getElementById('pg').value;
	ajax=NuevoAjax();
	ajax.open("POST","lib/tbl_listae_ficha.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			r=ajax.responseText;
			document.getElementById('tbl_ajax').innerHTML=r;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("pg="+pg+"&tipo_busq="+tipo_busq+"&txt_busq="+txt_busq);
}
function pag_ficha(tipo, valor_pag){
	if (tipo==1) // IR A
		document.getElementById('pg').value=valor_pag;
	if (tipo==2) // SIGUIENTE
		document.getElementById('pg').value=parseInt(document.getElementById('pg').value)+1;
	if (tipo==3)  // ANTERIOR
		document.getElementById('pg').value=parseInt(document.getElementById('pg').value)-1;
	filtrar_ficha();
}