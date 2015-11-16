// version:		1.0
// Autor:		Cesar Cuenca
// Fecha:		15/NOV/12
// Desc:		Funciones Ajax y Validacion de formularios.
//==========================================================
function validar_usuario(){
	new FormValidator('frm_login', [{
    name: 'login',
    display: 'login',    
    rules: 'required|etq_HTML'
},{	
	name: 'password',
    display: 'password',    
    rules: 'required'

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
	document.getElementById('submit').disabled=true;
	document.getElementById('submit').value='VERIFICANDO...';
	var max=document.getElementById('max').value;
	var login=document.getElementById('login').value;
	var password=document.getElementById('password').value;
	ajax=NuevoAjax();
	ajax.open("POST","auten.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			r=ajax.responseText;
		
			if (r>0){
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Password incorrecto. Le quedan '+(max-parseInt(r))+' intentos, antes de que su cuenta quede bloqueada</div>';
				document.getElementById('password').focus();
			}
			if (r==-1){
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">El login ingresado es incorrecto</div>';
				document.getElementById('login').focus();
			}
			if (r==-2){
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Su cuenta se encuentra bloqueada por razones Administrativas.</div>';
				document.getElementById('password').focus();
			}
			if (r==-3){
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Ha sobrepasado el numero de intentos permitidos, esta cuenta ha sido bloqueada</div>';
			}
			if (r==-4){
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Su cuenta se encuentra bloqueada por no actualizar password asignado por el Administrador</div>';
			}
			if (r==-5){
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Su cuenta se encuentra bloqueada por caducidad de password</div>';	
			}
			if (r==0){
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="success_box">Correcto</div>';
				location.href="pagina_inicio.php";
				return;
			}
			document.getElementById('submit').value='INGRESAR';
			document.getElementById('submit').disabled=false;
			return;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("login="+login+"&password="+password);
  }
}

function recuperar_pass(){
	//window.open('popup/recuperar_pass.php');
	 window.open('popup/recuperar_pass.php','','height=390,width=610,toolbar=0,top=300, left=350');
//,'height=300, width:400, resizable=no, statusbar=no, toolbar=no, location=no, menubar=no'	
}

function recuperar_pass_envio(){
	new FormValidator('frm_rec_pass', [{
		name: 'email_alter',
		display: 'Email',
		rules: 'required|etq_HTML|valid_email'
		
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
	
	if(document.forms[0].onsubmit()==true){
		var defaultReal=document.getElementById('defaultReal').value;
		var defaultRealHash=document.getElementById('defaultRealHash').value;
		ajax_captcha=NuevoAjax();
		ajax_captcha.open("POST","../lib/validar_captcha.php",true)
		ajax_captcha.onreadystatechange=function(){
			if (ajax_captcha.readyState==4){
				r=ajax_captcha.responseText;
				if(r==0){
					var ea=document.getElementById('email_alter').value;
					ajax=NuevoAjax();
					ajax.open("POST","../ABM/validar_email_alter.php",true);
					ajax.onreadystatechange=function(){
						if(ajax.readyState==4){
							rr=ajax.responseText;
							if (rr==-2){
								document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">El email proporcionado no se encuentra registrado.</div>';
								document.getElementById('email_alter').focus();
								return;
							}
							if (rr==-1){
								document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Ocurrio un error al enviar el password a su correo, intente de nuevo por favor<br>Asegurese de que su conexión de red este habilitada. Si el problema persiste contacte con el Administrador.</div>';
								return;
							}
							if (rr==0){
								document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="success_box" id="succes_box">Se ha enviado una nueva contraseña a su correo electr&oacute;nico.</div>';
								//window.close();	
								return;
							}
						}
					}
					ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					ajax.send("ea="+ea);
				}
				else{
					document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box">El c&oacute;digo introducido no coincide con el texto de la imagen.</div>';
					document.getElementById('defaultReal').focus();
				}
			}
		}
	ajax_captcha.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax_captcha.send('defaultReal='+defaultReal+"&defaultRealHash="+defaultRealHash);
	}
	else{
		document.getElementById('email_alter').focus();
		return;
	}
}

function verificar_captcha(){
	var defaultReal=document.getElementById('defaultReal').value;
	var defaultRealHash=document.getElementById('defaultRealHash').value;
	ajax_captcha=NuevoAjax();
	ajax_captcha.open("POST","../lib/validar_captcha.php",true)
	ajax_captcha.onreadystatechange=function(){
		if (ajax_captcha.readyState==4){
			r=ajax_captcha.responseText;
			//return;
		}
	}
	ajax_captcha.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax_captcha.send('defaultReal='+defaultReal+"&defaultRealHash="+defaultRealHash);
}