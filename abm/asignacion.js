function validar_asignacion(){
	new FormValidator('frm_asig', [{
    name: 'txt_diagnos',
    display: 'Diagn&oacute;stico',    
    rules: 'required'
},{	
	name: 'fecha_sol',
	display: 'Fecha estimada de soluci&oacute;n',
	rules: 'required|fecha'
		
}], function(errors, event){
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
		var id_orden=document.getElementById('id_orden').value;
		var asig='';
		asig_nom="";
		for (var i = 0; i < document.getElementById('lista').options.length; i++ ){
			if(document.getElementById('lista').options[i].selected==true){
				asig = asig + '|' + document.getElementById('lista').options[i].value;
				asig_nom = asig_nom + '|' + document.getElementById('lista').options[i].text;
			}
			//alert(document.getElementById('lista').options[i].value);
		}
		if (asig.length==0){
			document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">No ha seleccionado T&eacute;cnico, puede seleccionar mas de uno.</div>';
			return;
		}
		if (document.getElementById('chkEscalar').checked==true){
			var id_escal=document.getElementById('escal').value;
			if (id_escal==0){
				document.getElementById('div_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">Ha especificado escalamiento pero no ha seleccionado usuario.</div>';
				return;	
			}
		}
		var comp=document.getElementById('nivel_asig').value;
		var crit=document.getElementById('criticidad_asig').value;
		var prio=document.getElementById('prioridad_asig').value;
		var diagnos=document.getElementById('txt_diagnos').value;
		var fecha_sol=document.getElementById('fecha_sol').value;
		var area_array=document.forms[0].area;
		for (var j=0; j<=area_array.length-1; j++){
			if (area_array[j].checked==true)
				var area=area_array[j].value;
		}
		var pru1=document.getElementById('pru1').checked;
		var pru2=document.getElementById('pru2').checked;
		var pru3=document.getElementById('pru3').checked;
		var sw_escal=document.getElementById('chkEscalar').checked;
		var vars="id_orden="+id_orden+"&comp="+comp+"&crit="+crit+"&prio="+prio+"&asig="+asig+"&asig_nom="+asig_nom+"&diagnos="+diagnos+"&fecha_sol="+fecha_sol+"&area="+area+"&pru1="+pru1+"&pru2="+pru2+"&pru3="+pru3+"&sw_escal="+sw_escal;
		if (sw_escal==true){
			var escal=document.getElementById('escal').value;
			var fecha_escal=document.getElementById('fecha_escal').value;
			vars=vars+"&escal="+escal+"&fecha_escal="+fecha_escal;
		}
		
		ajax=NuevoAjax();
		ajax.open("POST","abm/registrar_asignacion.php",true);
		ajax.onreadystatechange=function(){
			if(ajax.readyState==4){
				r=ajax.responseText;
				//alert(r);
				if (r==-1){
					document.getElementById('lbl_ajax').innerHTML='<div style="display: block;" class="error_box" id="error_box">El LOGIN ingresado no esta disponible</div>';
				}
				if (r==0){
						location.href='lista.php';
				}
			}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send(vars);
	}
}

function enabled1(){
	document.getElementById('pru1').disabled = 0;
	document.getElementById('pru2').disabled = 0;
	document.getElementById('pru3').disabled = 0;
}

function disabled1(){	
	document.getElementById('pru1').disabled = 1;
	document.getElementById('pru2').disabled = 1;
	document.getElementById('pru3').disabled = 1;
	document.getElementById('pru1').checked = 0;
	document.getElementById('pru2').checked = 0;
	document.getElementById('pru3').checked = 0;
}

function mostrar_escal(){
	if(document.getElementById('chkEscalar').checked==true){
		document.getElementById('escal').style.display='block';
		document.getElementById('div_fecha_escal').style.display='block';
	}
	else{
		document.getElementById('escal').style.display='none';
		document.getElementById('div_fecha_escal').style.display='none';
	}
}

function debug(){
	asig_nom="";
	for (var i = 0; i < document.getElementById('lista').options.length; i++ ){
		if(document.getElementById('lista').options[i].selected==true){
			asig_nom = asig_nom + '|' + document.getElementById('lista').options[i].text;
		}
	}
	//alert(asig_nom);
	alert(document.getElementById('prioridad_asig').value);
}