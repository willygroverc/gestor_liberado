function validar_cambio_pass(){
	new FormValidator('frm_pass', [{
		name: 'pass_actual',
		display: 'password_actual',    
		rules: 'required'
	},{	
		name: 'password1',
		display: 'password_nuevo',
		rules: 'required|min_length['+document.getElementById('pass_long').value+']'
	},{	
		name: 'password2',
		display: 'password(confirmacion)',
		rules: 'required|matches[password1]'
		
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
	if(document.forms[0].onsubmit()){
		var pass=document.getElementById('pass_actual').value;
		var pass_nuevo=document.getElementById('password1').value;
		
		ajax=NuevoAjax();
		ajax.open("POST","ABM/cambiar_pass.php",true);
		ajax.onreadystatechange=function(){
			if(ajax.readyState==4){
				r=ajax.responseText;
				if (r==0){
					document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="success_box">La accion se ha completado con éxito.</div>';
					alert('La operación se ha comletado con exito');
					location.href="pagina_inicio.php";
					return;
				}
				if (r==-1){
					document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box">La contraseña actual ingresada es incorrecta.</div>';
					return;
				}
				if (r==-2){
					document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box">Ocurrio un error al modificar el password, intente de nuevo por favor.</div>';
					return;
				}
				if (r==-3){
					document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box">Ha introducido un password anteriormente usado, elija otro password por favor.</div>';
					return;
				}
				if(r==-4){
					document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="success_box">La accion se ha completado con éxito.</div>';
					alert('La operación se ha comletado con exito');
					location.href="pagina_inicio.php";
					return;
				}
			}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("pass="+pass+"&pass_nuevo="+pass_nuevo);
		//document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="success_box">La operacion se ha completado con exito</div>';
		//location.href="pagina_inicio.php";
	}
}

function pass_seguro(password){
	var desc = new Array();
	desc[0] = "Muy Debil";
	desc[1] = "Debil";
	desc[2] = "Mejor";
	desc[3] = "Medio";
	desc[4] = "Fuerte";
	desc[5] = "Muy Fuerte";

	var score   = 0;

	//if password bigger than 6 give 1 point
	if (password.length > 6) score++;

	//if password has both lower and uppercase characters give 1 point	
	if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;

	//if password has at least one number give 1 point
	if (password.match(/\d+/)) score++;

	//if password has at least one special caracther give 1 point
	if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;

	//if password bigger than 12 give another 1 point
	if (password.length > 12) score++;

	 document.getElementById("passwordDescription").innerHTML = desc[score];
	 document.getElementById("passwordStrength").className = "strength" + score;
}