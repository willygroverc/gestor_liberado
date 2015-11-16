function guardar_nuevo_usuario(){
new FormValidator('frm_usr', [{
    name: 'login_usr',
    display: 'LOGIN',    
    rules: 'required|etq_HTML'
},{	
	name: 'password_usr',
	display: 'PASSWORD',
	rules: 'required|min_length['+document.getElementById('pass_long').value+']'
},{	
	name: 'password_usr2',
	display: 'PASSWORD(Repetir)',
	rules: 'required|matches[password_usr]'
},{	
	name: 'tipo2_usr',
	display: '',
	rules: ''
},{	
	name: 'tipo_usr',
	display: '',
	rules: ''
},{	
	name: 'email',
	display: 'EMAIL',
	rules: 'valid_email'
},{	
	name: 'email_alter',
	display: 'EMAIL ALTERNATIVO',
	rules: 'valid_email'
},{	
	name: 'nom_usr',
	display: 'NOMBRES',
	rules: 'required'
},{	
	name: 'apa_usr',
	display: 'AP. PATERNO',
	rules: 'required'
},{	
	name: 'enti_usr',
	display: 'ENTIDAD',
	rules: 'alphanumeric'
},{	
	name: 'area_usr',
	display: '',
	rules: ''
},{	
	name: 'esp_usr',
	display: '',
	rules: ''
},{	
	name: 'cargo_usr',
	display: 'CARGO',
	rules: 'alphanumeric'
},{	
	name: 'telf_usr',
	display: 'TELEFONO',
	rules: 'integer'
},{	
	name: 'ext_usr',
	display: 'CELULAR',
	rules: 'integer|exact_length[8]'
},{	
	name: 'id_dat_tel_movil',
	display: '',
	rules: ''
},{	
	name: 'costo_usr',
	display: 'COSTO/SERVICIO',
	rules: 'numeric'
},{	
	name: 'agencia',
	display: '',
	rules: ''
},{	
	name: 'ciu_usr',
	display: '',
	rules: ''
},{	
	name: 'direc_usr',
	display: 'DIRECCION',
	rules: ''
	

/*}, {
    name: 'alphanumeric',
    rules: 'alpha_numeric'
}, {
    name: 'password',
    rules: 'required'
}, {
    name: 'password_confirm',
    display: 'password confirmation',
    rules: 'required|matches[password]'
}, {
    name: 'email',
    rules: 'valid_email'
}, {
    name: 'minlength',
    display: 'min length',
    rules: 'min_length[8]'
}, {
    name: 'tos_checkbox',
    display: 'terms of service',
    rules: 'required'*/
	
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
	
	var area=document.getElementById('area_usr');
	var agen=document.getElementById('agencia');
	
	if (area.value==0){
		document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar Area.</div>';
		return;
	}
	if (agen.value==0){
		document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar Agencia.</div>';
		return;
	}
	
	if (document.forms[0].onsubmit()==true){
		if (confirm('Desea agregar nuevo usuario?')){
			var login=document.getElementById('login_usr');
			var p1=document.getElementById('password_usr');
			var p2=document.getElementById('password_usr2');
			var tipo=document.getElementById('tipo_usr').checked;
			var tipo2=document.getElementById('tipo2_usr');
			var nom=document.getElementById('nom_usr');
			var apa=document.getElementById('apa_usr');
			var ama=document.getElementById('ama_usr');
			var email=document.getElementById('email');
			var email_alter=document.getElementById('email_alter');
			var enti=document.getElementById('enti_usr');
			//var area=document.getElementById('area_usr');
			var cargo=document.getElementById('cargo_usr');
			var telf=document.getElementById('telf_usr');
			var ext=document.getElementById('ext_usr');
			var ciu=document.getElementById('ciu_usr');
			var direc=document.getElementById('direc_usr');
			var esp=document.getElementById('esp_usr');
			//var agen=document.getElementById('agencia');
			var id_tel=document.getElementById('id_dat_tel_movil');
			var costo=document.getElementById('costo_usr');
		
			if (tipo==true)
				tipo='INTERNO';
			else
				tipo='EXTERNO';
				
			ajax=NuevoAjax();
			ajax.open("POST","abm/nuevo_usuario.php",true);
			ajax.onreadystatechange=function(){
			if(ajax.readyState==4){
				r=ajax.responseText;
				if (r==-1){
					document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">El LOGIN ingresado no esta disponible</div>';
				}
				if (r==-2){
					document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Ocurrio un error al ingresar nuevo usuario, por favor intente de nuevo. Si el problema persiste, contacte con el administrador.</div>';
				}
				if (r==0){
					alert('La operacion se ha completado con exito.')
					document.forms[0].onsubmit();
					document.getElementById('error_box').innerHTML='La operacion se ha completado con exito!';
					document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="succes_box" id="succes_box">El usuario se ha añadido correctamente</div>';
					 login.value='';
					 p1.value='';
					 p2.value='';
					 nom.value='';
					 apa.value='';
					 ama.value='';
					 email.value='';
					 email_alter.value='';
					 enti.value='';
					 area.value='';
					 cargo.value='';
					 telf.value='';
					 ext.value='';
					 ciu.value='';
					 direc.value='';
					 esp.value='';
					 agen.value='';
					 costo.value='';
					 costo.value='';
					if (confirm('Desea Agregar otro Usuario?')){
						location.href="usuarios.php";
					}
					else{
						location.href="usuarios_lista.php";
					}
						
				}
			  }
			}
		  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		  ajax.send("login="+login.value+"&password="+p1.value+"&tipo="+tipo+"&tipo2="+tipo2.value+"&nom="+nom.value+"&apa="+apa.value+"&ama="+ama.value+"&email="+email.value+"&email_alter="+email_alter.value+"&enti="+enti.value+"&area="+area.value+"&cargo="+cargo.value+"&telf="+telf.value+"&ext="+ext.value+"&ciu="+ciu.value+"&direc="+direc.value+"&esp="+esp.value+"&agen="+agen.value+"&id_tel="+id_tel.value+"&costo="+costo.value);
		}
	}
}

function guardar_area(){
	cmb_area=document.getElementById('cmb_area').value;
	cmb_area = cmb_area.replace(/(^\s*)|(\s*$)/g,"");
	if (cmb_area.length==0){
		alert('No ha llenado el campo Area.');
		document.getElementById('cmb_area').focus();
		return;
	}
	else{
		ajax=NuevoAjax();
		ajax.open("POST","lib/guardar_area.php",true);
		ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			r=ajax.responseText;
			if (r==0){
				alert('La operacion se ha completado con exito.');
				closePopup();
				act_combo_area();
			}
			if (r==-1){
				alert('Ocurrio un error al registrar Area, por favor intente de nuevo.');
			}
			return;
		  }
		}
	  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	  ajax.send("cmb_area="+cmb_area);
	}
}
function guardar_agencia(){
	cmb_agencia=document.getElementById('cmb_agencia').value;
	cmb_agencia = cmb_agencia.replace(/(^\s*)|(\s*$)/g,"");
	if (cmb_agencia.length==0){
		alert('No ha llenado el campo Agencia.');
		document.getElementById('cmb_agencia').focus();
		return;
	}
	else{
		ajax=NuevoAjax();
		ajax.open("POST","lib/guardar_agencia.php",true);
		ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			r=ajax.responseText;
			if (r==0){
				alert('La operacion se ha completado con exito.');
				closePopup(300);
				act_combo_agencia();
			}
			if (r==-1){
				alert('Ocurrio un error al registrar Agencia, por favor intente de nuevo.');
			}
			return;
		  }
		}
	  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	  ajax.send("cmb_agencia="+cmb_agencia);
	}
}
function act_combo_area(){
	ajax1=NuevoAjax();
	ajax1.open("POST","lib/cmb_area.php",true);
	ajax1.onreadystatechange=function(){
		if(ajax1.readyState==4){
			r1=ajax1.responseText;
			document.getElementById('ajax_area').innerHTML=r1;
			return;
		  }
		}
	  ajax1.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	  ajax1.send("flag=1");
}

function act_combo_agencia(){
	ajax1=NuevoAjax();
	ajax1.open("POST","lib/cmb_agencia.php",true);
	ajax1.onreadystatechange=function(){
		if(ajax1.readyState==4){
			r1=ajax1.responseText;
			document.getElementById('ajax_agencia').innerHTML=r1;
			return;
		  }
		}
	  ajax1.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	  ajax1.send("flag=1");
}

function retornar(opc){
	//history.back(0);
	if (opc==1){
		if (confirm('Desea salir? se perderan los cambios no guardados.'))
			location.href="usuarios_lista.php";
	}
}

function guardar_edicion(){
	new FormValidator('form1', [{
		name: 'login_usr',
		display: 'LOGIN',    
		rules: 'required'
	},{	
		name: 'password_usr',
		display: 'PASSWORD',
		rules: 'required'
	},{	
		name: 'password_usr2',
		display: 'PASSWORD(Repetir)',
		rules: 'required|matches[password_usr]'
	},{	
		name: 'tipo2_usr',
		display: '',
		rules: ''
	},{	
		name: 'tipo_usr',
		display: '',
		rules: ''
	},{	
		name: 'email_usr',
		display: 'EMAIL',
		rules: 'valid_email'
	},{	
		name: 'email_alter_usr',
		display: 'EMAIL ALTERNATIVO',
		rules: 'valid_email'
	},{	
		name: 'nom_usr',
		display: 'NOMBRES',
		rules: 'required'
	},{	
		name: 'apa_usr',
		display: 'AP. PATERNO',
		rules: 'required'
	},{	
		name: 'enti_usr',
		display: 'ENTIDAD',
		rules: 'alphanumeric'
	},{	
		name: 'area_usr',
		display: '',
		rules: ''
	},{	
		name: 'esp_usr',
		display: '',
		rules: ''
	},{	
		name: 'cargo_usr',
		display: 'CARGO',
		rules: 'alphanumeric'
	},{	
		name: 'telf_usr',
		display: 'TELEFONO',
		rules: 'integer'
	},{	
		name: 'ext_usr',
		display: 'CELULAR',
		rules: 'integer|exact_length[8]'
	},{	
		name: 'id_dat_tel_movil',
		display: '',
		rules: ''
	},{	
		name: 'costo_usr',
		display: 'COSTO/SERVICIO',
		rules: 'numeric'
	},{	
		name: 'agencia',
		display: '',
		rules: ''
	},{	
		name: 'ciu_usr',
		display: 'CIUDAD',
		rules: ''
	},{	
		name: 'direc_usr',
		display: 'DIRECCION',
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
	if (document.forms[0].onsubmit()==true){
	
		var login=document.getElementById('login_usr').value;
		var pass1=document.getElementById('password_usr').value;
		var pass2=document.getElementById('password_usr2').value;
		var email=document.getElementById('email_usr').value;
		var email_alter=document.getElementById('email_alter_usr').value;
		var tipo=document.getElementById('tipo2_usr').value;
		var cliente=document.getElementById('tipo_usr').checked;
		
		var nom=document.getElementById('nom_usr').value;
		var pat=document.getElementById('apa_usr').value;
		var mat=document.getElementById('ama_usr').value;
		var enti=document.getElementById('enti_usr').value;
		var area=document.getElementById('area_usr').value;
		var esp=document.getElementById('esp_usr').value;
		var cargo=document.getElementById('cargo_usr').value;
		var tel=document.getElementById('telf_usr').value;
		var cel=document.getElementById('ext_usr').value;
		var id_cel=document.getElementById('id_dat_tel_movil').value;
		
		var sueldo=document.getElementById('costo_usr').value;
		var agen=document.getElementById('agencia_usr').value;
		var ciu=document.getElementById('ciu_usr').value;
		var direc=document.getElementById('direc_usr').value;
		
		var sw_pass=document.getElementById('sw_pass').value;
		
		if (area==0){
			document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Debe seleccionar Area.</div>';
			return;
		}
		if (agen==0){
			alert('Seleccione Agencia por favor');
			return;
		}
		
		if (cliente==true)
				cliente='INTERNO';
			else
				cliente='EXTERNO';
				
			ajax=NuevoAjax();
			ajax.open("POST","abm/guardar_edicion_usuario.php",true);
			ajax.onreadystatechange=function(){
			if(ajax.readyState==4){
				r=ajax.responseText;
				if (r==-1){
					document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Ha introducido un password anteriormente usado, por favor elija otro.</div>';
				}
				if (r>0){
					document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">El password debe ser igual o mayor a '+r+' caracteres.</div>';
				}
				if (r==-2){
					document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">El password introducido no puede ser igual a su nombre o apellido.</div>';
				}
				if (r==-3){
					document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Ocurrio un error al guardar los cambios, intente de nuevo por favor.</div>';
				}
				if (r==0){
					alert('La operacion se ha completado con exito.');
					document.forms[0].onsubmit();
					document.getElementById('error_box').innerHTML='La operacion se ha completado con exito!';
					document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="succes_box" id="succes_box">Los cambios se han guardado correctamente</div>';
					location.href="usuarios_lista.php";
				}
			  }
			}
		  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		  ajax.send("login="+login+"&password="+pass1+"&tipo="+tipo+"&cliente="+cliente+"&nom="+nom+"&apa="+pat+"&ama="+mat+"&email="+email+"&email_alter="+email_alter+"&enti="+enti+"&area="+area+"&cargo="+cargo+"&tel="+tel+"&cel="+cel+"&ciu="+ciu+"&direc="+direc+"&esp="+esp+"&agen="+agen+"&id_cel="+id_cel+"&costo="+sueldo+"&sw_pass="+sw_pass);
	}
}

function habilitar_edicion_pass(){
	if (document.getElementById('sw_pass').value==0){
		document.getElementById('sw_pass').value=1;
		document.getElementById('password_usr').disabled=false;
		document.getElementById('password_usr2').disabled=false;
		document.getElementById('password_usr').value="";
		document.getElementById('password_usr2').value="";
		document.getElementById('password_usr').focus();
		document.getElementById('lbl_pass').innerHTML='Medidor de Fortaleza de Password&nbsp;<a href="javascript:habilitar_edicion_pass();">Salir de Edicion de Password</a>'+
		'<div id="passwordDescription"><br>Password no introducido</div><div id="passwordStrength"class="strength0">'+
		'</div>';	
	}
	else{
		document.getElementById('sw_pass').value=0;
		document.getElementById('password_usr').disabled=true;
		document.getElementById('password_usr2').disabled=true;
		document.getElementById('password_usr').value="************";
		document.getElementById('password_usr2').value="************";
		document.getElementById('lbl_pass').innerHTML='<a href="javascript:habilitar_edicion_pass();">Habilitar Modificacion de Password</a>';
	}
}

function filtrar_usuarios(){
	var usrbloq=document.getElementById('usrbloq').checked;
	var usrint=document.getElementById('usrint').checked;
	var usrext=document.getElementById('usrext').checked;
	var usrelim=document.getElementById('usrelim').checked;
	var agencia=document.getElementById('agencia').value;
	var area=document.getElementById('area_usr').value;
	var txt_busq=document.getElementById('txt_busq').value;
	txt_busq = txt_busq.replace(/(^\s*)|(\s*$)/g,""); 
	var pg=document.getElementById('pg').value;
	
	ajax=NuevoAjax();
	ajax.open("POST","lib/tbl_usuarios_lista.php",true);
	ajax.onreadystatechange=function(){
	if(ajax.readyState==4){
		r=ajax.responseText;
		document.getElementById('tbl_ajax').innerHTML=r
	  }
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("usrbloq="+usrbloq+"&usrint="+usrint+"&usrext="+usrext+"&usrelim="+usrelim+"&agencia="+agencia+"&area="+area+"&busq="+txt_busq+"&pg="+pg);
}

function usuario_parametros(login,flag,valor){
	var sw=0;
	if (flag==2){ 
		if (confirm('Desea Eliminar la cuenta del usuario '+login+'?. Esta operacion no se puede deshacer.'))
			sw=0;
		else
			sw=1;
	}
	if (flag==3 && valor==1){ 
		if (confirm('Desea bloquear la cuenta del usuario '+login+'?'))
			sw=0;
		else
			sw=1;
	}
	if (flag==3 && valor==0){ 
		if (confirm('Esta a punto de desbloquear la cuenta del usuario '+login+'. Desea continuar?'))
			sw=0;
		else
			sw=1;
	}

	if (sw==0){
		ajax=NuevoAjax();
		ajax.open("POST","abm/usuario_parametros.php",true);
		ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			r=ajax.responseText;
			
			if (r==0){
				alert('La operacion se ha completado con exito');
				filtrar_usuarios();
			}
			else
				alert('Ocurrio un error al actualizar registro de Usuario, por favor intente nuevamente. Si el problema persiste contacte con el Administrador');
			return;
		  }
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("login="+login+"&flag="+flag+"&valor="+valor);
	}
}

function pag_lista(tipo, valor_pag){
	if (tipo==1) // IR A
		document.getElementById('pg').value=valor_pag;
	if (tipo==2) // SIGUIENTE
		document.getElementById('pg').value=parseInt(document.getElementById('pg').value)+1;
	if (tipo==3)  // ANTERIOR
		document.getElementById('pg').value=parseInt(document.getElementById('pg').value)-1;
	filtrar_usuarios();
}

function guardar_opciones(login){
	var param1=document.getElementById('vista1').value;
	var param2=document.getElementById('vista2').value;
	ajax=NuevoAjax();
	ajax.open("POST","abm/usuario_parametros.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			r=ajax.responseText;
			if (r==0){
				alert('Los cambios se ha registrado correctamente.');
				location.href="lista.php";
			}
			if (r==-1){
				alert("Ocurrio un error al registrar los cambios, por favor intente de nuevo. Si el problema persiste contacte con el Administrador.");
				return;
			}	
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("login="+login+"&flag=4&param1="+param1+"&param2="+param2);
}