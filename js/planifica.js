function guardar_planif(){
new FormValidator('frm_planif', [{
    name: 'fecplanif',
    display: 'fecha planificacion',    
    rules: 'required|etq_HTML'
},{	
	name: 'fecelab',
	display: 'FECHA ELABORACION',
	rules: 'required|etq_HTML'
},{	
	name: 'objprue',
	display: 'OBJETIVO PRUEBA',
	rules: 'required|etq_HTML'
},{	
	name: 'tipcontin',
	display: '',
	rules: ''
},{	
	name: 'condicion',
	display: '',
	rules: ''
},{	
	name: 'fecrelac',
	display: '',
	rules: ''
},{	
	name: 'varios',
	display: '',
	rules: ''
},{	
	name: 'rechard',
	display: '',
	rules: ''
},{	
	name: 'recsoft',
	display: '',
	rules: ''
},{	
	name: 'recresp',
	display: '',
	rules: ''
},{	
	name: 'facilidad',
	display: 'facilidad',
	rules: ''
},{	
	name: 'costo',
	display: 'COSTO',
	rules: 'integer'
},{	
	name: 'moneda',
	display: 'MONEDA',
	rules: 'required|etq_HTML'
},{	
	name: 'jefeus',
	display: 'JEFE',
	rules: 'required|etq_HTML'
},{	
	name: 'var1',
	display: '',
	rules: ''
},{	
	name: 'var2',
	display: '',
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

	var jefeus=document.getElementById('jefeus');
	if (document.forms[0].onsubmit()==true){
		if (confirm('Desea registrar los datos introducidos?')){
			var fecplanif=document.getElementById('fecplanif');
			var fecelab=document.getElementById('fecelab');
			var objprue=document.getElementById('objprue');
			var tipcontin=document.getElementById('tipcontin');
			var condicion=document.getElementById('condicion');
			var fecrelac=document.getElementById('fecrelac');
			var varios=document.getElementById('varios');
			var rechard=document.getElementById('rechard');
			var recsoft=document.getElementById('recsoft');
			var recresp=document.getElementById('recresp');
			var facilidad=document.getElementById('facilidad');
			var costo=document.getElementById('costo');
			var moneda=document.getElementById('moneda');
			var var1=document.getElementById('var1');
			var var2=document.getElementById('var2');
			ajax=NuevoAjax();
			ajax.open("POST","abm/nueva_planif.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					if (r==0){
						alert('Los datos han sido registrados...');
						location.href="resprelac.php?varia1="+var1.value+"&varia2="+var2.value+"";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("fecplanif="+fecplanif.value+"&fecelab="+fecelab.value+"&objprue="+objprue.value+"&tipcontin="+tipcontin.value+"&condicion="+condicion.value+"&fecrelac="+fecrelac.value+"&varios="+varios.value+"&rechard="+rechard.value+"&recsoft="+recsoft.value+"&recresp="+recresp.value+"&facilidad="+facilidad.value+"&costo="+costo.value+"&moneda="+moneda.value+"&jefeus="+jefeus.value+"&var1="+var1.value+"&var2="+var2.value);
		}
	}
}
function guardar_planif_last(){
new FormValidator('frm_planif_last', [{
    name: 'fecplanif',
    display: 'fecha planificacion',    
    rules: 'required|etq_HTML'
},{	
	name: 'fecelab',
	display: 'FECHA ELABORACION',
	rules: 'required|etq_HTML'
},{	
	name: 'objprue',
	display: 'OBJETIVO PRUEBA',
	rules: 'required|etq_HTML'
},{	
	name: 'tipcontin',
	display: '',
	rules: ''
},{	
	name: 'condicion',
	display: '',
	rules: ''
},{	
	name: 'fecrelac',
	display: '',
	rules: ''
},{	
	name: 'varios',
	display: '',
	rules: ''
},{	
	name: 'rechard',
	display: '',
	rules: ''
},{	
	name: 'recsoft',
	display: '',
	rules: ''
},{	
	name: 'recresp',
	display: '',
	rules: ''
},{	
	name: 'facilidad',
	display: 'facilidad',
	rules: ''
},{	
	name: 'costo',
	display: 'COSTO',
	rules: 'integer'
},{	
	name: 'moneda',
	display: 'MONEDA',
	rules: 'required|etq_HTML'
},{	
	name: 'jefeus',
	display: 'JEFE',
	rules: 'required|etq_HTML'
},{	
	name: 'var1',
	display: '',
	rules: ''
},{	
	name: 'var2',
	display: '',
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

	var jefeus=document.getElementById('jefeus');
	if (document.forms[0].onsubmit()==true){
		if (confirm('Desea registrar los datos introducidos?')){
			var fecplanif=document.getElementById('fecplanif');
			var fecelab=document.getElementById('fecelab');
			var objprue=document.getElementById('objprue');
			var tipcontin=document.getElementById('tipcontin');
			var condicion=document.getElementById('condicion');
			var fecrelac=document.getElementById('fecrelac');
			var varios=document.getElementById('varios');
			var rechard=document.getElementById('rechard');
			var recsoft=document.getElementById('recsoft');
			var recresp=document.getElementById('recresp');
			var facilidad=document.getElementById('facilidad');
			var costo=document.getElementById('costo');
			var moneda=document.getElementById('moneda');
			var var1=document.getElementById('var1');
			var var2=document.getElementById('var2');
			ajax=NuevoAjax();
			ajax.open("POST","abm/nueva_planif_modi.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					//alert(r);
					if (r==-1){
						alert('No se han registrado los datos, contacte a soporte.');
					}
					if (r==0){
						alert('Los datos han sido registrados...');
						location.href="lista_planifpru1.php";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("fecplanif="+fecplanif.value+"&fecelab="+fecelab.value+"&objprue="+objprue.value+"&tipcontin="+tipcontin.value+"&condicion="+condicion.value+"&fecrelac="+fecrelac.value+"&varios="+varios.value+"&rechard="+rechard.value+"&recsoft="+recsoft.value+"&recresp="+recresp.value+"&facilidad="+facilidad.value+"&costo="+costo.value+"&moneda="+moneda.value+"&jefeus="+jefeus.value+"&var1="+var1.value+"&var2="+var2.value);
		}
	}
}
function resp_modi(opc){
			//alert(opc);
			location.href="resprelac_last.php?idplanpru="+opc+"";
}
function retornar(opc){
	//history.back(0);
	if (opc==1){
		if (confirm('Desea salir? se perderan los cambios no guardados.'))
			location.href="lista_planifpru1.php";
	}
}