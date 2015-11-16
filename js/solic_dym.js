function guardar_solic(){
new FormValidator('frm_solic', [{	
	name: 'Tiempo',
	display: 'Tiempo',
	rules: 'required|etq_HTML'
},{	
	name: 'Costo10',
	display: 'FECHA',
	rules: 'required|etq_HTML'
},{	
	name: 'Costo20',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'fecha_rec',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'horas',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'Viabilidad',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'Prioridad',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'fecha_ent',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'var1',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'Aceptac',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'fecha_asig',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'AsignA',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'Costo11',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'Tiempo1',
	display: 'TITULO',
	rules: 'required|etq_HTML'
},{	
	name: 'Costo21',
	display: 'TITULO',
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
			
		if (confirm('Se van a guardar los datos.')){
			var Tiempo=document.getElementById('Tiempo');
			var Costo10=document.getElementById('Costo10');
			var var1=document.getElementById('var1');
			var Costo20=document.getElementById('Costo20');
			var fecha_rec=document.getElementById('fecha_rec');
			var horas=document.getElementById('horas');
			var Viabilidad=document.getElementById('Viabilidad');
			var Prioridad=document.getElementById('Prioridad');
			var fecha_ent=document.getElementById('fecha_ent');
			var Aceptac=document.getElementById('Aceptac');
			var fecha_asig=document.getElementById('fecha_asig');
			var AsignA=document.getElementById('AsignA');
			var Tiempo1=document.getElementById('Tiempo1');
			var Costo11=document.getElementById('Costo11');
			var Costo21=document.getElementById('Costo21');
			ajax=NuevoAjax();
			ajax.open("POST","abm/nuevo_solic_dym.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					if (r==-1){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Los datos no se han registrado. Si el problema persiste pongase en contacto con el administrador</div>';
					}
					if (r==-2){
						document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Ocurrio un error al ingresar nuevo usuario, por favor intente de nuevo. Si el problema persiste, contacte con el administrador.</div>';
					}
					if (r==0){
						alert('Datos registrados...')
						//document.getElementById('success_box').innerHTML='La operacion se ha completado con exito!';
						location.href="llenadoUS_2.php?var="+var1.value+"";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("Tiempo="+Tiempo.value+"&Costo10="+Costo10.value+"&var1="+var1.value+"&Costo20="+Costo20.value+"&fecha_rec="+fecha_rec.value+"&horas="+horas.value+"&Viabilidad="+Viabilidad.value+"&Prioridad="+Prioridad.value+"&fecha_ent="+fecha_ent.value+"&Aceptac="+Aceptac.value+"&fecha_asig="+fecha_asig.value+"&AsignA="+AsignA.value+"&Tiempo1="+Tiempo1.value+"&Costo11="+Costo11.value+"&Costo21="+Costo21.value);
		}
	
}
function retornar(opc){
	//history.back(0);
	if (opc==1){
		if (confirm('Desea retornar? No se registraran los datos.'))
			location.href="gravamen.php?num="+aux.value+"";
	}
}