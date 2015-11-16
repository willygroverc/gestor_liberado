function guardar_nueva_ficha(){
new FormValidator('frm_ficha', [{
    name: 'Marca',
    display: 'MARCA',    
    rules: 'required|etq_HTML'
},{	
	name: 'AdicUSI',
	display: 'CODIGO ADICIONAL',
	rules: 'required|etq_HTML'
},{	
	name: 'Modelo',
	display: 'MODELO',
	rules: 'required|etq_HTML'
},{	
	name: 'CodActFijo',
	display: 'CODIGO ACTIVO FIJO',
	rules: 'required|etq_HTML'
},{	
	name: 'RealizFicha',
	display: '',
	rules: 'required|etq_HTML'
},{	
	name: 'Proveedor',
	display: '',
	rules: 'required|etq_HTML'
},{	
	name: 'FechAlta',
	display: 'FECHA ALTA',
	rules: 'required|etq_HTML'
},{	
	name: 'GarantDe',
	display: 'GARANTIA DE',
	rules: 'required|etq_HTML'
},{	
	name: 'GarantAl',
	display: 'GARANTIA AL',
	rules: 'required|etq_HTML'
},{	
	name: 'NumSerie',
	display: 'Nro DE SERIE',
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

	var rea_ficha=document.getElementById('RealizFicha');
	var provee=document.getElementById('Proveedor');
	/*alert(provee.value);*/
	/*alert(rea_ficha.value);*/
	if (rea_ficha.value==0){
		document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar Realizacion de ficha.</div>';
		return;
	}
	if (provee.value==0){
		document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar PROVEEDOR.</div>';
		return;
	}
	
	if (document.forms[0].onsubmit()==true){
	
		if (confirm('Desea registrar los datos introducidos?')){
			var marca=document.getElementById('Marca');
			var AdicUSI1=document.getElementById('AdicUSI');
			var Modelo=document.getElementById('Modelo');
			var CodActFijo1=document.getElementById('CodActFijo');
			var NumSerie=document.getElementById('NumSerie');
			var FechAlta=document.getElementById('FechAlta');
			var GarantDe=document.getElementById('GarantDe');
			var GarantAl=document.getElementById('GarantAl');
			//alert(GarantAl.value);
			ajax=NuevoAjax();
			ajax.open("POST","abm/nueva_ficha.php",true);
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
						alert('Los datos han sido registrados...');
						//document.getElementById('success_box').innerHTML='La operacion se ha completado con exito!';
						//location.href="caracteristica.php?variable2="+TpRegFicha.value+"";
						location.href="caracteristica.php?variable="+TpRegFicha.value+"";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("RealizFicha="+RealizFicha.value+"&marca="+marca.value+"&AdicUSI1="+AdicUSI1.value+"&Modelo1="+Modelo.value+"&CodActFijo1="+CodActFijo1.value+"&NumSerie1="+NumSerie.value+"&FechAlta="+FechAlta.value+"&GarantDe="+GarantDe.value+"&GarantAl="+GarantAl.value);
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