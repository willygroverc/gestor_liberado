function pag_lista(tipo, valor_pag){
	if (tipo==1) // IR A
		document.getElementById('pg').value=valor_pag;
	if (tipo==2) // SIGUIENTE
		document.getElementById('pg').value=parseInt(document.getElementById('pg').value)+1;
	if (tipo==3)  // ANTERIOR
		document.getElementById('pg').value=parseInt(document.getElementById('pg').value)-1;
	filtrar_lista();
}
function filtrar_lista(){
	var pg=document.getElementById('pg').value;
	var tipo_busq=document.getElementById('menu').value;
	var txt_busq=document.getElementById('txt_busqueda').value;
	txt_busq = txt_busq.replace(/(^\s*)|(\s*$)/g,""); 
	var vars="pg="+pg+"&tipo_busq="+tipo_busq+"&txt_busq="+txt_busq
	ajax=NuevoAjax();
	ajax.open("POST","lib/tbl_listae_con.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			content=ajax.responseText;
			document.getElementById('tbl_ajax').innerHTML=content;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send(vars);
}