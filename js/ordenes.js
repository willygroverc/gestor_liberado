// version:		1.0
// Autor:		Cesar Cuenca
// Fecha:		02/DIC/12
// Desc:		Funciones Ajax y Validacion de formularios.
//==========================================================

function validar_orden(){
	document.getElementById('guardar_orden').disabled='true';
	var a=document.getElementById('area').value
	var d=document.getElementById('dominio').value
	var o=document.getElementById('objetivo').value
	var desc=document.getElementById('desc_inc').value;
	var file=document.getElementById('archivo').value;
	desc = desc.replace(/(^\s*)|(\s*$)/g,"");
	var obs=document.getElementById('txtObs').value;
	obs = obs.replace(/(^\s*)|(\s*$)/g,"");
	ajax=NuevoAjax();
	ajax.open("POST","abm/registrar_orden.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			r=ajax.responseText;
			//alert(r);
			var pos=r.indexOf('|');
				var split = r.split('|');
				var s = split[0];
				var t = split[1];
                                //alert('****.'+ajax.responseText+'****.');
			if(r>=1){ // Retorna el Id de Orden
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="success_box">La operaci&oacute;nse ha completado con &eacute;xito.</div>';
				alert('Se ha registrado la orden.');
				//alert(t);
				if(s==1)
					location.href='asignacion.php?id_orden='+t;
				else
					location.href='lista.php';
			}
			if (r==-1){
                            
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">La descripci&oacute;n de incidencia debe contener por lo menos 10 caracteres.</div>';
				document.getElementById('guardar_orden').disabled=false;
				document.getElementById('guardar_orden').value='REGISTRAR ORDEN';
				document.getElementById('desc_inc').focus();
				return;
			}
			if (r==-2){
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Usted no puede registrar mas ordenes de trabajo, ha superado el tiempo para conformidad en una o mas ordenes anteriores.</div>';
				document.getElementById('guardar_orden').disabled='false';
				document.getElementById('desc_inc').focus();
				return;
			}
			if (r==-3){
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Usted no puede registrar mas ordenes de trabajo, debido a que ha superado el numero de ordenes sin conformidad permitidas.</div>';
				document.getElementById('guardar_orden').disabled='false';
				return;
			}
			if (r==-4){
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Ocurrio un error al registrar la orden, por favor intente nuevamente.<br>Si el problema persiste contacte con el Administrador.</div>';
				document.getElementById('guardar_orden').disabled='false';
				return;
			}
			if (r==-5){
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Se ha registrado la orden correctamente pero ocurrio un error al notificar por email al Administrador.<br>Si el problema persiste contacte con el Administrador.</div>';
				alert('Se ha registrado la orden correctamente pero no se ha podido notificar por correo al Administrador.');
				if(document.getElementById('flag').value==1)
					location.href='asignacion.php?id_orden='+tmp;
				else
					location.href='lista.php';
				return;
			}
		}
		else{
			document.getElementById('guardar_orden').disabled='true';
			document.getElementById('guardar_orden').value='Enviando...';
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("a="+a+"&d="+d+"&o="+o+"&desc="+desc+"&obs="+obs+"&file="+file);
	
	/*if (form.desc_inc.value.length < 10 || form.desc_inc.value.length > 500){
		document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe ingresar Descripcion de Incidencia.</div>';
		form.desc_inc.focus();
		return false;
	}
	return true;*/
}
function guardar_cliente(){
	var ci_ruc=document.getElementById('ci_ruc').value;
	var nombre1=document.getElementById('nombre1').value;
	var apaterno=document.getElementById('apaterno').value;
	var amaterno=document.getElementById('amaterno').value;
	var acasada=document.getElementById('acasada').value;
	var email=document.getElementById('email').value;
	var entidad=document.getElementById('entidad').value;
	var area1=document.getElementById('area1').value;
	var cargo=document.getElementById('cargo').value;
	var telf=document.getElementById('telf').value;
	var especialidad=document.getElementById('especialidad').value;
	var externo=document.getElementById('externo').value;
	var ciudad=document.getElementById('ciudad').value;
	var direccion=document.getElementById('direccion').value;
	ajax=NuevoAjax();
	ajax.open("POST","abm/registrar_titular.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			r=ajax.responseText;
			if(r==10){ 
				//document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="success_box">La operaci&oacute;nse ha completado con &eacute;xito.</div>';
				alert('Se ha registrado correctamente.');
				document.getElementById('guardar_cliente').disabled='true';
				return;
			}
			if (r==-10){
				alert('No se ha registrado.');
				return;
			}
			
		}
		
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("ci_ruc="+ci_ruc+"&nombre1="+nombre1+"&apaterno="+apaterno+"&amaterno="+amaterno+"&acasada="+acasada+"&email="+email+"&entidad="+entidad+"&area1="+area1+"&cargo="+cargo+"&telf="+telf+"&especialidad="+especialidad+"&externo="+externo+"&ciudad="+ciudad+"&direccion="+direccion);
}
function valida_msg(tam){
	alert ('Atencion, solamente puede enviar archivos menor o igual a '+tam+' Mb de tamano.\n \nMensaje generado por GesTor F1.');
}

function validar_subir_archivo(){
	if(document.frm_orden.archivo.value == ""){
		document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">No ha seleccionado ningun archivo para adjuntar.</div>';
		return false;
	}
	else{
		var obs=document.getElementById('txtObservacion').value;
		obs = obs.replace(/(^\s*)|(\s*$)/g,"");
		if(obs == ""){
			document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe llenar el campo de Observaciones antes de adjuntar un archivo.</div>';
			return false;
		}
		else 
			return true;
	}
}

function mostrar_adj(){
	if (document.getElementById('chk_adj').checked==false)
		document.getElementById('tbl_adj').style.display='none';
	else
		document.getElementById('tbl_adj').style.display='block';
}

/************** BUSQUEDA Y FILTROS **************/

function filtrar_usuario_lista(){
	document.getElementById('pg').value=1;
	var id_area = document.getElementById('area_usr').value;
	ajax=NuevoAjax();
	ajax.open("POST","lib/cmb_enviadoPor.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			content_env=ajax.responseText;
			document.getElementById('ajax_env').innerHTML=content_env;
			filtrar_lista();
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("id_area="+id_area);
}
function filtrar_lista(){
	var pg=document.getElementById('pg').value;
	if (tipo_usr=='A'){
		var area=document.getElementById('area_usr').value;
	}
	var tipo_busq=document.getElementById('cmb_filtro').value;
	var tipo_usr=document.getElementById('txt_tipo_usr').value;
	var txt_busq=document.getElementById('txt_busqueda').value;
	txt_busq = txt_busq.replace(/(^\s*)|(\s*$)/g,""); 
	var vars="tipo_busq="+tipo_busq+"&pg="+pg+"&txt_busq="+txt_busq
	if (tipo_usr=='A'){
		var id_area=document.getElementById('area_usr').value;
		var id_env=document.getElementById('cmb_enviadoPor').value;
		vars=vars+"&id_area="+id_area+"&id_env="+id_env;
	}
	if(tipo_usr=='T' || tipo_usr=='C'){
		var id_usuario=document.getElementById('cmb_usuarios').value;
		vars=vars+"&id_u="+id_usuario;
	}
	ajax=NuevoAjax();
	ajax.open("POST","lib/tbl_listae.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			content=ajax.responseText;
			document.getElementById('tbl_ajax').innerHTML=content;
			//ini();
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send(vars);
}

function filtrar_dominio(){
	var area=document.getElementById('area').value;
	ajax=NuevoAjax();
	ajax.open("POST","lib/cmb_dominio.php",true);
	ajax.onreadystatechange=function(){
	if(ajax.readyState==4){
			r=ajax.responseText;
			document.getElementById('div_dominio').innerHTML=r;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("area="+area);
}

function filtrar_objetivo(){
	var dominio=document.getElementById('dominio').value
	ajax=NuevoAjax();
	ajax.open("POST","lib/cmb_objetivo.php",true);
	ajax.onreadystatechange=function(){
	if(ajax.readyState==4){
			r=ajax.responseText;
			document.getElementById('div_objetivo').innerHTML=r;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("dominio="+dominio);
}

function adjuntar_fichero(){
	var extensiones_permitidas = new Array(".gif", ".jpg",".png", ".doc", ".pdf",".docx",".txt",".xls",".xlsx",".log");
	var msg = "";
	var obs=document.getElementById('txtObs').value;
	obs = obs.replace(/(^\s*)|(\s*$)/g,""); 
	var fichero=document.getElementById('txtFichero').value;
	fichero = fichero.replace(/(^\s*)|(\s*$)/g,"");
	var extension = (fichero.substring(fichero.lastIndexOf("."))).toLowerCase();
	var permitida = false;
    for (var i = 0; i < extensiones_permitidas.length; i++) {
         if (extensiones_permitidas[i] == extension) {
         permitida = true;
         break;
        }
    }
	if (!permitida) {
         document.getElementById('div_ajax').innerHTML = '<div style="display: block;" class="error_box" id="error_box"> Comprueba la extensi&oacute:n de lo fichero a subir. \nS&oacute;lo se pueden subir archivos con extensiones: ' + extensiones_permitidas.join()+'</div>';
		return; 
    }
	if (fichero.length==0){
		document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">No ha seleccionado fichero.</div>';
		return;
	}
	if(obs.length==0){
		document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe llenar el campo de Observaciones antes de adjuntar un archivo.</div>';
		document.getElementById('txtObs').focus();
		return;
	}
	xajax_agregarFila(xajax.getFormValues('adjunto'));
}

function pag_lista(tipo, valor_pag){
	if (tipo==1) // IR A
		document.getElementById('pg').value=valor_pag;
	if (tipo==2) // SIGUIENTE
		document.getElementById('pg').value=parseInt(document.getElementById('pg').value)+1;
	if (tipo==3)  // ANTERIOR
		document.getElementById('pg').value=parseInt(document.getElementById('pg').value)-1;
	filtrar_lista();
}
function chk_validar(){
	var num=document.getElementById('num_registros').value;
	var chk_cerrar=document.getElementById('chk_cerrar').checked;
	var i;
	for (i=1; i<=num; i++){
		var chk=document.getElementById('chk'+i);
		if (chk_cerrar){
			if (chk.disabled==false)
				chk.checked=true;
		}
		else{
			if (chk.disabled==false)
				chk.checked=false;
		}
	}
}

function cerrar_orden(){
	var vec='';
	for (var i=1; i<=document.getElementById('num_registros').value; i++){
		if (document.getElementById('chk'+i).checked){
			vec = vec + '|' + document.getElementById('chk'+i).value;
		}
	}
	if (vec.length==0){
		alert('Ninguna orden seleccionada, debe seleccionar al menos una orden antes de cerrar.');
		return;
	}
	else{
		if (confirm('Confirma cerrar las ordenes seleccionadas?')){
			ajax=NuevoAjax();
			ajax.open("POST","abm/cerrar_orden.php",true);
			ajax.onreadystatechange=function(){
			if(ajax.readyState==4){
					r=ajax.responseText;
					if (r==0){
						alert('La operacion se ha completado con exito');
						filtrar_lista();
					}	
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("vec="+vec);
		}
	}
}