<?php 
if (isset($retornar)){header("location: admi_fuentes.php?Naveg=Cambios >> Administracion de Fuentes");}
if (isset($NueMod))
{header("location: registro_modulo.php");
}
if ($ejecutar=="eliminar"){
	include("conexion.php");
	$sql10 = "SELECT * FROM datos_archivos WHERE id_mod='$id_mod'";
	$result10 = mysql_db_query($db,$sql10,$link);
	while ($row10 = mysql_fetch_array($result10)){
		$sql11 = "SELECT * FROM control_archivos WHERE id_arch='$row10[id_arch]'";
		$result11 = mysql_db_query($db,$sql11,$link);
		$row11 = mysql_fetch_array($result11);
		if (!(empty($row11['ubicacion'])))
		if ($row11['ubicacion']!="r"){$noeliminar="1";}
	}
	if ($noeliminar=="1"){
	$msg = "El modulo no se puede eliminar, debido a que existen archivos en proceso de modificacion.";
	}else{		
		session_start();
		$login=$_SESSION["login"];
		$sql01="SELECT * FROM users WHERE login_usr='$login'";
		$result01=mysql_db_query($db,$sql01,$link);
		$row01=mysql_fetch_array($result01);
		$nombre_usr=$row01['nom_usr']." ".$row01['apa_usr']." ".$row01['ama_usr'];
		$path=$_SESSION["path"];
		$path_trash=$_SESSION["path_trash"];
		$path_replica=$_SESSION["path_replica"];
		$fecha_hoy=date("Y-m-d");
		$fecha_hoy2=date("d-m-Y");
		$hora_hoy=date("H:i:s");
		$hora_hoy2=date("H-i-s");
		$sql1 = "SELECT * FROM modulo WHERE id_mod='$id_mod'";
		$result1=mysql_db_query($db,$sql1,$link);
		$row1=mysql_fetch_array($result1);
		$nombre_mod_eli=$row1['nombre_mod']."-".$fecha_hoy2."-".$hora_hoy2;
		if (mkdir($path_trash."/".$nombre_mod_eli,0777)){
				$sql3="INSERT INTO modulos_eliminados (id_mod,fecha_eli,hora_eli,nombre_mod_eli) VALUES ('$id_mod','$fecha_hoy','$hora_hoy','$nombre_mod_eli')";
				$result3=mysql_db_query($db,$sql3,$link);
				$sql0 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod)".
						"VALUES ('$fecha_hoy','$hora_hoy','eliminacion_modulo','$nombre_usr','$row1[nombre_mod]')";
				$rst0=mysql_db_query($db,$sql0,$link);
		}
		//copia de los archivos del modulo a la carpeta en trash
		$path_carpeta=$path."/$row1[nombre_mod]/";
		chmod($path_carpeta,0777);
		$dir1 = opendir($path_carpeta);
		while ($elemento = readdir($dir1))
		{ 
			if ($elemento!="." && $elemento!=".."){
			$extension = explode(".",$elemento); 
			if (count($extension) == 2)
			{	$nombre_arch_eli = $extension[0]."-".$fecha_hoy2."-".$hora_hoy2.".".$extension[1]; }
			else
			{	for ($i=0; $i<count($extension)-1; $i++)
					if ( $i == count($extension)-2)				
					$nombre_arch_eli = $nombre_arch_eli.$extension[$i];
					else 
					$nombre_arch_eli = $nombre_arch_eli.$extension[$i].".";
					$nombre_arch_eli = $nombre_arch_eli."-".$fecha_hoy2."-".$hora_hoy2.".".$extension[count($extension)-1];
			}
			copy($path_carpeta.$elemento,$path_trash."/$nombre_mod_eli/$elemento");
			$sql4="SELECT * FROM datos_archivos WHERE nombre_arch='$elemento' AND id_mod='$id_mod'";
			$result4=mysql_db_query($db,$sql4,$link);
			if ($row4=mysql_fetch_array($result4)){ //eliminacion de los archivos
				$sql5="UPDATE datos_archivos SET eliminado=1,fec_baja='$fecha_hoy' WHERE id_arch='$row4[id_arch]'";
				$result5=mysql_db_query($db,$sql5,$link);
				$sql6="INSERT INTO archivos_eliminados (id_arch,fecha_eli,hora_eli,nombre_arch_eli) VALUES ('$row4[id_arch]','$fecha_hoy','$hora_hoy','$elemento')";
				$result6=mysql_db_query($db,$sql6,$link);
				$sql0 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch)".
						"VALUES ('$fecha_hoy','$hora_hoy','eliminacion_archivo','$nombre_usr','$row1[nombre_mod]','$row4[nombre_arch]')";
				$rst0=mysql_db_query($db,$sql0,$link);
				unlink($path_carpeta.$elemento);
			}else{ //eliminacion de las versiones
				$sql7="SELECT * FROM versiones WHERE nombre_arch='$elemento'";
				$result7=mysql_db_query($db,$sql7,$link);
				while ($row7=mysql_fetch_array($result7)){
					$sql8="SELECT * FROM datos_archivos WHERE id_mod='$id_mod' AND id_arch='$row7[id_arch]'";
					$result8=mysql_db_query($db,$sql8,$link);
					$row8=mysql_fetch_array($result8);
					if ($row8[id_arch]){
						$sql9 = "INSERT INTO versiones_eliminadas (id_ver,fecha_eli,hora_eli,nombre_ver_eli)".
								"VALUES ('$row7[id_ver]','$fecha_hoy','$hora_hoy','$row7[nombre_arch]')";
						$result9 = mysql_db_query($db,$sql9,$link);
						$sql0 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch,id_ver)".
								"VALUES ('$fecha_hoy','$hora_hoy','eliminacion_version','$nombre_usr','$row1[nombre_mod]','$row8[nombre_arch]','$elemento')";
						$rst0 = mysql_db_query($db,$sql0,$link);
						unlink($path_carpeta.$elemento);
					}
				}
			}}
		}
		closedir($dir1); 
		rmdir($path."/$row1[nombre_mod]");
		//eliminacion de la carpeta y sus archivos en repositorio
		$path_carpeta_rep=$path_replica."/$row1[nombre_mod]/";
		chmod($path_carpeta_rep,0777);
		$dir1 = opendir($path_carpeta_rep);
		while ($elemento = readdir($dir1))
		{ 
			if ($elemento!="." && $elemento!=".."){
			unlink($path_carpeta_rep.$elemento);
			}
		}
		closedir($dir1); 
		rmdir($path_replica."/$row1[nombre_mod]");
		//actualiza el estado del modulo
		$fecha_baja=date("Y-m-d");
		$sql="UPDATE modulo SET fecha_baja='$fecha_baja',estado=1 WHERE id_mod='$id_mod'";
		$result=mysql_db_query($db,$sql,$link);
		header("location: modulos.php");
	}
}
include("top.php");
?>
<script language="JavaScript">
<!--
function confirmLink(theLink, modulo)
{
    var is_confirmed = confirm("Desea Realmente Eliminar el Modulo"+ ' :\n' + modulo + '\n' + '\n' + "Mensaje generado por GesTor F1." );
    if (is_confirmed) {
        theLink.href += '&confirmado=1';
    }
    return is_confirmed;
} // end of the 'confirmLink()' function
//-->
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
</script>

	<table width="80%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
    <tr><th colspan="8" background="images/main-button-tileR1.jpg">LISTA DE MODULOS</th></tr>     
    <tr align="center">      
		
    <th width="4%" class="menu" background="images/main-button-tileR1.jpg">Nro.</th>
		<th width="15%" class="menu" background="images/main-button-tileR1.jpg">NOMBRE</th>
		<th width="22%" class="menu" background="images/main-button-tileR1.jpg">DESCRIPCION</th>
		<th width="12%" class="menu" background="images/main-button-tileR1.jpg">FECHA DE CREACION</th>
		<th width="11%" class="menu" background="images/main-button-tileR1.jpg">FECHA DE BAJA</th>
		<th width="6%" class="menu" background="images/main-button-tileR1.jpg">MODIFICAR</th>
		<th width="6%" class="menu" background="images/main-button-tileR1.jpg">IMPRIMIR</th>
		<th width="6%" class="menu" background="images/main-button-tileR1.jpg">ELIMINAR</th>
	</tr>	  
         <?php 
 	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM modulo";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
 
$sql = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacion, DATE_FORMAT(fecha_baja, '%d/%m/%Y') AS fecha_baja FROM modulo ORDER BY id_mod DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
$result=mysql_db_query($db,$sql,$link);
while ($row=mysql_fetch_array($result)) 
{
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">&nbsp;$row[id_mod]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[nombre_mod]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[desc_mod]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[fecha_creacion]</font></td>";
	if ($row['estado']==1){
		echo "<td><font size=\"1\">&nbsp;$row[fecha_baja]</font></td>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></font></td>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"ver_modulo.php?id_modu=".$row[id_mod]."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
		echo "<td>Eliminado</td>";
	}else{
		echo"<td>&nbsp;<img src=\"images/no3.gif\" border=\"0\"></td>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"modulos_last.php?id_modu=".$row['id_mod']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"ver_modulo.php?id_modu=".$row['id_mod']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
		echo "<td nowrap><a href=\"?ejecutar=eliminar&id_mod=$row[id_mod]\" onClick=\"return confirmLink(this,'$row[nombre_mod]')\"><img src=\"images/eliminar.gif\" border=\"0\" alt=\"Eliminar\"></a>&nbsp;</td>";
	}
}
?>
</table>
<br>
<form name="form1" method="post" action="">
  <table width="75%" border="0" align="center">
    <tr> 
      <td><div align="center"> 
          <p><font size="2"><strong> Pagina(s) :&nbsp; 
            <?php
//La idea es pasar también en los enlaces las variables hayan llegado por url.
$_pagi_enlace = $_SERVER['PHP_SELF'];
$_pagi_query_string = "?";
if(isset($_GET)){
	//Si ya se han pasado variables por url, escribimos el query string concatenando
	//los elementos del array $_GET excepto la variable $_GET['pg'] si es que existe.
	$_pagi_variables = $_GET;
	foreach($_pagi_variables as $_pagi_clave => $_pagi_valor){
		if($_pagi_clave != 'pg'){
			$_pagi_query_string .= $_pagi_clave."=".$_pagi_valor."&";
		}
	}
}

//Anadimos el query string a la url.
$_pagi_enlace .= $_pagi_query_string;

//La variable $_pagi_navegacion contendrá los enlaces a las páginas.
$_pagi_navegacion = '';

if ($_pagi_actual != 1){
	//Si no estamos en la página 1. Ponemos el enlace "anterior"
	$_pagi_url = $_pagi_actual - 1;//será el numero de página al que enlazamos
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."'>&laquo; Anterior</a>&nbsp;";
}
//Enlaces a numeros de página:
for ($_pagi_i = 1; $_pagi_i<=$_pagi_totalPags; $_pagi_i++){//Desde página 1 hasta ultima página ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el numero de página es la actual ($_pagi_actual). Se escribe el numero, pero sin enlace y en negrita.
        $_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
    }else{
		//Si es cualquier otro. Se escibe el enlace a dicho numero de página.
        $_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."&id_pista=".$id_pista."'>".$_pagi_i."</a>&nbsp;";
    }
}

if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la ultima página. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual + 1;//será el numero de página al que enlazamos
    $_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."'>Siguiente &raquo;</a>";
}
print $_pagi_navegacion;
//Hasta acá hemos completado la "barra de navegacion"
?>
        </font><font size="2"><strong>&nbsp;</strong></font></div></td>
  </tr>
</table>
</form>
<br>
<form name="form1" method="post" action="">
<table align="center">
  	<tr>
  		<td><div align="center"><input name="NueMod" type="submit" id="NueMod" value="NUEVO MODULO">&nbsp;&nbsp;&nbsp;
  		<input name="imprimir" type="button" id="imprimir" value="IMPRIMIR" onClick="pagina()">&nbsp;&nbsp;&nbsp;
  		<input name="retornar" type="submit" id="retornar" value="RETORNAR"></div></td>
	</tr>
</table>
</form>
<?php include("top_.php");?>
<script language="JavaScript">
<!--
function pagina() {
	window.open("ver_modulos.php");
}
-->
</script>
<script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
</script>