function guardar_sistema(){
new FormValidator('frm_sistema', [{
    name: 'Descripcion',
    display: 'Descripcion',    
    rules: 'required|etq_HTML'
},{	
	name: 'Id_Tipo',
	display: 'Tipo',
	rules: 'required|etq_HTML'
},{	
	name: 'Titular1',
	display: 'Titular',
	rules: 'required|etq_HTML'
},{	
	name: 'Suplente1',
	display: 'Suplente',
	rules: 'required|etq_HTML'
},{	
	name: 'Area',
	display: 'Area',
	rules: 'required|etq_HTML'
},{	
	name: 'Titular2',
	display: 'TITULAR',
	rules: 'required|etq_HTML'
},{	
	name: 'Suplente2',
	display: 'Suplente',
	rules: 'required|etq_HTML'
},{	
	name: 'var1',
	display: '',
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

	var Id_Tipo=document.getElementById('Id_Tipo');
	var Titular1=document.getElementById('Titular1');
	var Suplente1=document.getElementById('Suplente1');
	var Area=document.getElementById('Area');
	var Titular2=document.getElementById('Titular2');
	var Suplente2=document.getElementById('Suplente2');
	if (document.forms[0].onsubmit()==true){
	
		if (confirm('Desea registrar los datos introducidos?')){
			var Descripcion=document.getElementById('Descripcion');
			ajax=NuevoAjax();
			ajax.open("POST","abm/nuevo_sistema.php",true);
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
						alert('Los datos han sido registrados...');
						location.href="lista_sistemas.php";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("Descripcion="+Descripcion.value+"&Id_Tipo="+Id_Tipo.value+"&Titular1="+Titular1.value+"&Suplente1="+Suplente1.value+"&Area="+Area.value+"&Titular2="+Titular2.value+"&Suplente2="+Suplente2.value+"&var1="+var1.value);
		}
	}
}
function retornar(){
	//history.back(0);
		if (confirm('Desea salir? se perderan los cambios no guardados.'))
			location.href="lista_sistemas.php";
}