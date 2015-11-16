<?php
if(isset($valida)){
	$destino = 'C:/Apache2.2/htdocs/gestor/phpconfig';
	if($direc=='')
		$origen = 'C:/php/php.ini';
	else
		$origen = $direc."/"."php.ini";
	if(copy($origen, $destino."/"."php.ini")){
		echo "Correcta";
	}
}
if(isset($validahttpd)){
	$destino = 'C:/Apache2.2/htdocs/gestor/httpdconf';
	if($direc1=='')
		$origen1 = 'C:/Apache2.2/conf/httpd.conf';
	else
		$origen1 = $direc1."/"."httpd.conf";
	if(copy($origen1, $destino."/"."httpd.conf")){
		echo "Correcta";
	}
}


if(isset($fullbackup)){
	function comprimir($ruta, $zip_salida, $handle = false, $recursivo = false){
	 if(!$handle){
	  $handle = new ZipArchive;
	  if ($handle->open($zip_salida, ZipArchive::CREATE) === false){
	   return false; 
	  }
	 }
	 if(is_dir($ruta)){
	  $ruta = dirname($ruta.'/arch.ext'); 
	  $handle->addEmptyDir($ruta); 
	  foreach(glob($ruta.'/*') as $url){ 
	   comprimir($url, $zip_salida, $handle, true); 
	  }
	 }else{
	  $handle->addFile($ruta);
	 }
	 if(!$recursivo){
	  $handle->close();
	 }
	 return true; 
	}
	$ruta = $path = getcwd();
	if(comprimir($ruta, 'fullbackup.zip'))
	 echo 'Ok';
	else
	 echo 'Error';
}
 //echo $path = getcwd();
?>
<html>
<head>
<title>Gestor TI - Full Backup</title> 
<style type="text/css"> 
#php {visibility:hidden} 
#apache {visibility:hidden} 
</style> 
<script type="text/javascript"> 
function toggle(chkbox, group) { 
    var visSetting = (chkbox.checked) ? "visible" : "hidden"; 
    document.getElementById(group).style.visibility = visSetting; 
} 
function swap(radBtn, group) { 
    var modemsVisSetting = (group == "modems") ? ((radBtn.checked) ? "" : "none") : "none"; 
    document.getElementById("modems").style.display = modemsVisSetting; 
} 
</script> 
</head>
<body>
<table border = "1" align = "center">
<tr>
	<th>
		PHP
	</th>
	<th>
		APACHE
	</th>
</tr>
<tr>
	<td>
		<p>El Path por defecto de PHP es: "C:/php"</p>
	</td>
	<td>
		<p>El Path por defecto de Apache es: "C:/Apache2.2/conf"</p>
	</td>
</tr>
<tr>
	<td>
		<input type="checkbox" name="monitor" onclick="toggle(this, 'php')" />Registrar PATH manual
		<br />
		<form name="form1" id="form1" action="" method="POST">
		<span id="php">
			<input type="text" name="direc" id="direc" /><br>
			<br />
		</span>
		<input type="submit" name="valida" value="COPIAR" />
		</form>
		
	</td>
	<td>
		<input type="checkbox" name="monitor" onclick="toggle(this, 'apache')" />Registrar PATH manual
		<br />
		<form name="form1" id="form1" action="" method="POST">
		<span id="apache">
			<input type="text" name="direc1" id="direc1" /><br>
			<br />
		</span>
		<input type="submit" name="validahttpd" value="COPIAR" />
		</form>
	</td>
</tr>
<tr>
	<td colspan = "2" align="center">
	<form name="form2" id="form2" action="" method="POST">
		<input type="submit" name="fullbackup" value="CREAR FULL BACKUP" />
	</form>
	</td>
</tr>
</table>

</body>
</html>