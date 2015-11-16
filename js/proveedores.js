function guardar_nuevo_prov(){
new FormValidator('frm_prov', [{
    name: 'NombProv',
    display: 'NOMBRE',    
    rules: 'required|etq_HTML'
},{	
	name: 'DirecProv',
	display: 'DIRECCION',
	rules: 'required|etq_HTML'
},{	
	name: 'Fono1Prov',
	display: 'TELEFONO',
	rules: 'numeric'
},{	
	name: 'Fono2Prov',
	display: 'TLEFONO2',
	rules: 'numeric'
},{	
	name: 'EncProv',
	display: 'ENCARGADO',
	rules: 'required|etq_HTML'
},{	
	name: 'EmailProv',
	display: 'Email',
	rules: 'valid_email'
},{	
	name: 'nivelRiesgo',
	display: 'Email',
	rules: 'required|etq_HTML'
},{	
	name: 'descRiesgo',
	display: 'Descripcion de Riesgo',
	rules: 'required|etq_HTML'
},{	
	name: 'nivelCalidad',
	display: 'Email',
	rules: 'required|etq_HTML'
},{	
	name: 'descCalidad',
	display: 'Descripcion de Calidad',
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
			var NombProv=document.getElementById('NombProv');
			var DirecProv=document.getElementById('DirecProv');
			var Fono1Prov=document.getElementById('Fono1Prov');
			var Fono2Prov=document.getElementById('Fono2Prov');
			var EncProv=document.getElementById('EncProv');
			var EmailProv=document.getElementById('EmailProv');
			var ObsProv=document.getElementById('ObsProv');
			var nivelRiesgo=document.getElementById('nivelRiesgo');
			var descRiesgo=document.getElementById('descRiesgo');
			var nivelCalidad=document.getElementById('nivelCalidad');
			var descCalidad=document.getElementById('descCalidad');
			var servicio1=document.getElementById('servicio1');
			var servicio2=document.getElementById('servicio2');
			//alert(GarantAl.value);
			ajax=NuevoAjax();
			ajax.open("POST","abm/nuevo_prov.php",true);
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
						alert('La operacion se ha completado con exito.')
						document.forms[0].onsubmit();
						document.getElementById('error_box').innerHTML='La operacion se ha completado con exito!';
						//document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="succes_box" id="succes_box">El usuario se ha añadido correctamente</div>';
						NombProv.value='';
						DirecProv.value='';
						Fono1Prov.value='';
						Fono2Prov.value='';
						EncProv.value='';
						EncProv.value='';
						ObsProv.value='';
						if (confirm('Desea Agregar otro registro MAS?')){
							location.href="proveedor.php";
						}
						else{
							location.href="lista_proveed.php";
						}	
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("NombProv="+NombProv.value+"&DirecProv="+DirecProv.value+"&Fono1Prov="+Fono1Prov.value+"&Fono2Prov="+Fono2Prov.value+"&EncProv="+EncProv.value+"&EmailProv="+EmailProv.value+"&ObsProv="+ObsProv.value+"&nivelRiesgo="+nivelRiesgo.value+"&descRiesgo="+descRiesgo.value+"&nivelCalidad="+nivelCalidad.value+"&descCalidad="+descCalidad.value+"&servicio1="+servicio1.value+"&servicio2="+servicio2.value);
		}
	}
}
function cargacombo(opt){
	var servicio1=document.getElementById('servicio1').value;
	ajax=NuevoAjax();
	ajax.open("POST","lib/cmb_servicio2.php",true);
	ajax.onreadystatechange=function(){
	if(ajax.readyState==4){
			r=ajax.responseText;
			//alert(r);
			document.getElementById('div_proveedor').innerHTML=r;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("opt="+opt+"&servicio1="+servicio1);
}
function filtrar_servicio(){
	var servicio1=document.getElementById('servicio1').value;
	var IdProv=document.getElementById('IdProv').value;
	ajax1=NuevoAjax();
	ajax1.open("POST","lib/cmb_servicio.php",true);
	ajax1.onreadystatechange=function(){
	if(ajax1.readyState==4){
			r1=ajax1.responseText;
			//alert(r1);
			document.getElementById('div_proveedor').innerHTML=r1;
		}
	}
	ajax1.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax1.send("servicio1="+servicio1+"&IdProv="+IdProv);
}
function editar_prov(){
new FormValidator('frm_prov', [{
    name: 'NombProv',
    display: 'NOMBRE',    
    rules: 'required|etq_HTML'
},{	
	name: 'DirecProv',
	display: 'DIRECCION',
	rules: 'required|etq_HTML'
},{	
	name: 'Fono1Prov',
	display: 'TELEFONO',
	rules: 'numeric'
},{	
	name: 'Fono2Prov',
	display: 'TLEFONO2',
	rules: 'numeric'
},{	
	name: 'EncProv',
	display: 'ENCARGADO',
	rules: 'required|etq_HTML'
},{	
	name: 'EmailProv',
	display: 'Email',
	rules: 'valid_email'
},{	
	name: 'nivelRiesgo',
	display: 'Nivel de Riesgo',
	rules: 'required|etq_HTML'
},{	
	name: 'descRiesgo',
	display: 'Descripcion de Riesgo',
	rules: 'required|etq_HTML'
},{	
	name: 'nivelCalidad',
	display: 'Nivel de Calidad',
	rules: 'required|etq_HTML'
},{	
	name: 'descCalidad',
	display: 'Descripcion de Calidad',
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
	
		if (confirm('Desea actualizar los datos?')){
			var NombProv=document.getElementById('NombProv');
			var DirecProv=document.getElementById('DirecProv');
			var Fono1Prov=document.getElementById('Fono1Prov');
			var Fono2Prov=document.getElementById('Fono2Prov');
			var EncProv=document.getElementById('EncProv');
			var EmailProv=document.getElementById('EmailProv');
			var ObsProv=document.getElementById('ObsProv');
			var IdProv=document.getElementById('IdProv');
			var nivelRiesgo=document.getElementById('nivelRiesgo');
			var descRiesgo=document.getElementById('descRiesgo');
			var nivelCalidad=document.getElementById('nivelCalidad');
			var descCalidad=document.getElementById('descCalidad');
			var servicio1=document.getElementById('servicio1');
			var servicio2=document.getElementById('servicio2');
			//alert(GarantAl.value);
			ajax=NuevoAjax();
			ajax.open("POST","abm/editar_prov.php",true);
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
						alert('Datos guardados...')
						document.forms[0].onsubmit();
						document.getElementById('error_box').innerHTML='La operacion se ha completado con exito!';
						//document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="succes_box" id="succes_box">El usuario se ha añadido correctamente</div>';
						NombProv.value='';
						DirecProv.value='';
						Fono1Prov.value='';
						Fono2Prov.value='';
						EncProv.value='';
						EncProv.value='';
						ObsProv.value='';
						location.href="lista_proveed.php";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("NombProv="+NombProv.value+"&DirecProv="+DirecProv.value+"&Fono1Prov="+Fono1Prov.value+"&Fono2Prov="+Fono2Prov.value+"&EncProv="+EncProv.value+"&EmailProv="+EmailProv.value+"&ObsProv="+ObsProv.value+"&IdProv="+IdProv.value+"&nivelRiesgo="+nivelRiesgo.value+"&descRiesgo="+descRiesgo.value+"&nivelCalidad="+nivelCalidad.value+"&descCalidad="+descCalidad.value+"&servicio1="+servicio1.value+"&servicio2="+servicio2.value);
		}
	}
}
function elim_prov(){

	if (document.forms[0].onsubmit()==true){
	
		if (confirm('Desea eliminar los datos?')){
			
			//alert(GarantAl.value);
			ajax=NuevoAjax();
			ajax.open("POST","abm/del_prov.php",true);
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
						alert('Datos guardados...')
						document.forms[0].onsubmit();
						document.getElementById('error_box').innerHTML='La operacion se ha completado con exito!';
						//document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="succes_box" id="succes_box">El usuario se ha añadido correctamente</div>';
						NombProv.value='';
						DirecProv.value='';
						Fono1Prov.value='';
						Fono2Prov.value='';
						EncProv.value='';
						EncProv.value='';
						ObsProv.value='';
						location.href="lista_proveed.php";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("NombProv="+NombProv.value+"&DirecProv="+DirecProv.value+"&Fono1Prov="+Fono1Prov.value+"&Fono2Prov="+Fono2Prov.value+"&EncProv="+EncProv.value+"&EmailProv="+EmailProv.value+"&ObsProv="+ObsProv.value+"&IdProv="+IdProv.value);
		}
	}
}
function pag_lista(tipo, valor_pag){
	if (tipo==1) // IR A
		document.getElementById('pg').value=valor_pag;
	if (tipo==2) // SIGUIENTE
		document.getElementById('pg').value=parseInt(document.getElementById('pg').value)+1;
	if (tipo==3)  // ANTERIOR
		document.getElementById('pg').value=parseInt(document.getElementById('pg').value)-1;
	mostrar_contratos();
}
function filtrar_lista(){
	var pg=document.getElementById('pg').value;
	var tipo_busq=document.getElementById('menu').value;
	var txt_busq=document.getElementById('text').value;
	txt_busq = txt_busq.replace(/(^\s*)|(\s*$)/g,""); 
	var vars="tipo_busq="+tipo_busq+"&txt_busq="+txt_busq
	ajax=NuevoAjax();
	ajax.open("POST","lib/tbl_listae_prov.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			content=ajax.responseText;
			document.getElementById('tbl_ajax').innerHTML=content;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send(vars);
}
function retornar(opc){
	//history.back(0);
	if (opc==1){
		if (confirm('Desea salir? se perderan los cambios no guardados.'))
			location.href="lista_proveed.php";
	}
}