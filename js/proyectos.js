function filtrar_lista(){
	//var tipo_busq=document.getElementById('menu').value;
	var pg=document.getElementById('pg').value;
	ajax=NuevoAjax();
	ajax.open("POST","lib/tbl_listae_proy.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			r=ajax.responseText;
			document.getElementById('tbl_ajax').innerHTML=r;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("pg="+pg);
}
