function mostrar_reporte(){
	
	var agencia=document.getElementById('cmb_agencia');
	var area=document.getElementById('cmb_area');
	var nom_agencia=agencia.options[agencia.options.selectedIndex].text;
	var nom_area=area.options[area.options.selectedIndex].text;
	var filtro1=document.getElementById('filtro1');
	var nom_filtro1=filtro1.options[filtro1.options.selectedIndex].text;
	var id_nombre=document.getElementById('cmb_nombre');
	var nombre=id_nombre.options[id_nombre.options.selectedIndex].text;
	var fecha1=document.getElementById('fecha1').value;
	var fecha2=document.getElementById('fecha2').value;
	if (filtro1.value==3)
		var url='report_ordenes_asig.php';
	else
		var url='report_ordenes.php';

	//url=url+"?nom_agencia="+nom_agencia+"&id_area="+area.value+"&nom_area="+nom_area+"&filtro1="+filtro1.value+"&nom_filtro1="+nom_filtro1+"&id_nombre="+id_nombre.value+"&nombre="+nombre+"&fecha1="+fecha1+"&fecha2="+fecha2;
	url=url+"?id_agencia="+agencia.value+"&nom_agencia="+nom_agencia+"&id_area="+area.value+"&nom_area="+nom_area+"&filtro1="+filtro1.value+"&nom_filtro1="+nom_filtro1+"&id_nombre="+id_nombre.value+"&nombre="+nombre+"&fecha1="+fecha1+"&fecha2="+fecha2;
	
	window.open(url,'Estadisticas', 'status=no, scrollbars=1, width=580,height=750,status=no,resizable=no,top=290,left=210,dependent=yes,alwaysRaised=yes');
}

function act_usuarios(){
	var agencia=document.getElementById('cmb_agencia').value;
	var area=document.getElementById('cmb_area').value;
	//alert(area.value);
	var filtro=document.getElementById('filtro1').value;
	ajax1=NuevoAjax();
	ajax1.open("POST","lib/cmb_usuarios_reportes.php",true);
	ajax1.onreadystatechange=function(){
	if(ajax1.readyState==4){
		r1=ajax1.responseText;
		document.getElementById('ajax_cmb').innerHTML=r1;
		//mostrar_reporte();
	  }
	}
	ajax1.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax1.send("agencia="+agencia+"&area="+area+"&filtro="+filtro);
}