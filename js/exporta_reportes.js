function pdf_ordenes(){ 
	var men=document.getElementById('menu').value;
	if(men=="nro_de_orden")
		var url="reportes_pdf/pdf_ordenes.php?menu="+men+"&selecta=0";
	else{
		var url="reportes_pdf/pdf_ordenes.php?menu="+men+"&selecta=general";
	}
	window.open(url,'Ordenes de Trabajo','width=400,height=200,toolbar=no, location=yes,directories=no,status=no,menubar=no,scrollbars=yes,copyhistory=yes, resizable=yes');
}

function pdf_estadisticas(){
	var form=document.form2;
	if (form.menu.value=="GENERAL") 
		window.open ( "reportes_pdf/pdf_estadisticas.php", "Estadisticas", 'width=590,height=710,status=no,resizable=no,top=0,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=yes');
	else window.open ( "reportes_pdf/pdf_ordenes2.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "", "Estadisticas", 'width=590,height=670,status=no,resizable=no,top=0,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=yes' );
	close();
		return false;
}

function pdf_estadisticas_fechas () {	
	var form = document.form2;
	if (form.menu.value=="GENERAL") 
		window.open ("reportes_pdf/pdf_ordenesf.php?DA=" + form.DA.value + "&MA=" + form.MA.value + "&AA=" + form.AA.value + "&DE=" + form.DE.value + "&ME=" + form.ME.value + "&AE=" + form.AE.value + "&menu=" + form.menu.value + "","ESTADICAS",'width=590,height=655,status=no,resizable=no,top=0,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=yes');
	else 
		window.open ( "reportes_pdf/pdf_ordenesf.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "&DA=" + form.DA.value + "&MA=" + form.MA.value + "&AA=" + form.AA.value + "&DE=" + form.DE.value + "&ME=" + form.ME.value + "&AE=" + form.AE.value + "&menu=" + form.menu.value + "","ESTADICAS",'width=590,height=655,status=no,resizable=no,top=0,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=yes');
	close();
	return false;	
}