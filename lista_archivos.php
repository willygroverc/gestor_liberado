<?php
//Descripcion: archivo modificado para corregir algunas funciones obsoletas de php4
//Fecha: 17/10/2013
//Autor: Alvaro Rodriguez
//Version: 1.0
session_start();
$login = $_SESSION["login"];
if (isset($retornar)){header("location: admi_fuentes.php?Naveg=Cambios >> Administracion de Fuentes");}
if (isset($nuevo)){  header("location:archivos.php");}
include ( "conexion.php" );
$sql03 = "SELECT * FROM users WHERE login_usr='$login'";
$result03 = mysql_db_query($db,$sql03,$link);
$row03 = mysql_fetch_array($result03);
$nombre_usr = $row03['nom_usr']." ".$row03['apa_usr']." ".$row03['ama_usr'];
include ( "funciones.inc.php" );	
if ($ejecutar=="eliminar")
{	if ( $estado==1)
		$msg="El archivo no se puede eliminar porque esta en proceso de modificacion"; 					
	else
	{		
		$nom_arch = XCampoc($id_arch,"datos_archivos","id_arch","nombre_arch",$link);
		$path = $_SESSION["path"];
		$fecha_hoy = date("Y-m-d");
		$fecha_hoy2 = date("d-m-Y");
		$hora_hoy  = date("H:i:s");
		$hora_hoy2 = date("H-i-s");
		$extension = explode(".",$nom_arch); 
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
		//$nombre_arch_eli=$nom_arch."-".$fecha_hoy2."-".$hora_hoy2;
		$path_c = $path."/".$mod."/".$nom_arch;
		$path_trash = $_SESSION["path_trash"];
		$path_t = $path_trash."/".$nombre_arch_eli;
		// preguntamos si esta eliminado
		$eliminado = XCampoc($id_arch,"datos_archivos","id_arch","eliminado",$link);
		if ($eliminado ==0 ){
			chmod($path_c, 0777);				
			copy($path_c, $path_t);		
			$sql1="INSERT INTO archivos_eliminados (id_arch,fecha_eli,hora_eli,nombre_arch_eli) VALUES ('$id_arch','$fecha_hoy','$hora_hoy','$nombre_arch_eli')";
			$result1=mysql_db_query($db,$sql1,$link);
		    $sql04="SELECT * FROM datos_archivos,modulo WHERE datos_archivos.id_arch='$id_arch' AND datos_archivos.id_mod=modulo.id_mod";
		    $result04=mysql_db_query($db,$sql04,$link);
		    $row04=mysql_fetch_array($result04);
			$sql01 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch)".
	   	             "VALUES ('$fecha_hoy','$hora_hoy','eliminacion_archivo','$nombre_usr','$row04[nombre_mod]','$row04[nombre_arch]')";
			$rst01 = mysql_db_query($db,$sql01,$link);
			unlink($path_c); 		
			$sql = "SELECT * FROM versiones WHERE id_arch=$id_arch ";  
			$res = mysql_db_query($db,$sql,$link);
			while ( $fila = mysql_fetch_array($res) )			// Borra las versiones 	
			{	$path_ver = $path."/".$mod."/".$fila['nombre_arch'];
				$extension_ver = explode(".",$fila['nombre_arch']); 
				if (count($extension_ver) == 2)
				{	$nombre_arch_eli_ver = $extension_ver[0]."-".$fecha_hoy2."-".$hora_hoy2.".".$extension_ver[1]; }
				else
				{	for ($i=0; $i<count($extension_ver)-1; $i++)
						if ( $i == count($extension_ver)-2)				
						$nombre_arch_eli_ver = $nombre_arch_eli_ver.$extension_ver[$i];
						else 
						$nombre_arch_eli_ver = $nombre_arch_eli_ver.$extension_ver[$i].".";
					$nombre_arch_eli_ver = $nombre_arch_eli_ver."-".$fecha_hoy2."-".$hora_hoy2.".".$extension_ver[count($extension_ver)-1];
				}
				$path_trash_ver = $path_trash."/".$nombre_arch_eli_ver;	
				copy($path_ver, $path_trash_ver);
				$sql3 = "INSERT INTO versiones_eliminadas (id_ver,fecha_eli,hora_eli,nombre_ver_eli)".
						"VALUES ('$fila[id_ver]','$fecha_hoy','$hora_hoy','$nombre_arch_eli_ver')";
				$result3=mysql_db_query($db,$sql3,$link);
				$sql02 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch,id_ver)".
		   	             "VALUES ('$fecha_hoy','$hora_hoy','eliminacion_version','$nombre_usr','$row04[nombre_mod]','$nom_arch','$fila[nombre_arch]')";
				$rst02 = mysql_db_query($db,$sql02,$link);
				unlink($path_ver); 
			}		 				
			$fecha_baja = date("Y-m-d");
			$sql = "UPDATE datos_archivos SET fec_baja='$fecha_baja',eliminado=1 WHERE id_arch='$id_arch'";
			$result = mysql_db_query($db,$sql,$link);
			unset ($nombre_arch_eli);
			unset ($extension);							
		}	
	}	
}

include("top.php");
if(!isset($orden))
{$orden = "id_arch";}
?>	
<table width="90%" align="center" background="images/fondo.jpg" border="1">
    <tr bgcolor="#006699"> 
      <td colspan="9" align="center" background="images/main-button-tileR1.jpg" height="22"><font size="3" color="#FFFFFF" face="VERADNA, Helvetica, sans-serif"><strong>
	  	LISTADO DE ARCHIVOS</strong></font>
	  </td>	 
    </tr>
	<tr>
		<td width="28" align="center" background="images/main-button-tileR2.jpg">		
			<a class="menu" href="lista_archivos.php?orden=id_arch">
			<font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">Nro.</font>
			<?php if($orden == "id_arch") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7>"; ?>
			</a>								
		</td>
		<td  align="center" background="images/main-button-tileR2.jpg">
			<a class="menu" href="lista_archivos.php?orden=nombre_arch">
			NOMBRE ARCHIVO
			<?php if($orden == "nombre_arch") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7>"; ?>
			</a>		
		</td>
		<td width="100" align="center" background="images/main-button-tileR2.jpg">
			<a  href="lista_archivos.php?orden=fecha_rev" class="menu">
			FEC. ULT. ACTUALIZACION
			<?php if($orden == "fecha_rev") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7>"; ?>
			</a>				
		
		</td>
		<td  align="center" background="images/main-button-tileR2.jpg" >
			<a class="menu" href="lista_archivos.php?orden=nombre_mod">
			<DIV align="center">MODULO</DIV>
			<?php if($orden=="nombre_mod") 
			echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7>";?>			
			</a>
		</td>
		<td width="92" align="center" background="images/main-button-tileR2.jpg" CLASS="menu">			
			UBICACION		
		</td>
		<td width="130" background="images/main-button-tileR2.jpg" align="center">
			<font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">RESPONSABLE</font>
		</td>		
		<td width="80" align="center" background="images/main-button-tileR2.jpg" CLASS="menu">
			<font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA DE BAJA</font>
		</td>						
		<td width="50" align="center" background="images/main-button-tileR2.jpg" CLASS="menu">
			<font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">	ELIMINAR</font>	
		</td>
		<td width="50" align="center" background="images/main-button-tileR2.jpg" CLASS="menu">
			<font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">IMPRIMIR</font>
		</td>				
	</tr>		
<?php 
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM datos_archivos";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
//=====end Pag.
$sql = "SELECT *, DATE_FORMAT(fecha_rev, '%d/%m/%Y') AS fecha_rev, DATE_FORMAT(fec_baja, '%d/%m/%Y') AS fec_baja, nombre_mod, d.estado as estado FROM datos_archivos as d, modulo as m
		WHERE d.id_mod = m.id_mod ORDER BY $orden DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
$res = mysql_db_query($db, $sql, $link);
while ( $fila = mysql_fetch_array($res) )
{	$str = "SELECT  MAX(id_control) as id_control FROM control_archivos WHERE id_arch='$fila[id_arch]'";
	$rsl = mysql_db_query($db, $str, $link);
	$fla = mysql_fetch_array($rsl);
	$responsable = "&nbsp;";
	$ubicacion = "&nbsp;";
	if ( $fila['estado'] == 0 )
	{	if ($fila['eliminado'] == 0) $ubicacion = "Repositorio";		
		else	$ubicacion = "&nbsp;";
	}
	else
	{	$ubi = XCampoc($fla['id_control'],"control_archivos","id_control","ubicacion",$link);
		if ( $ubi == "c" )
		{	$ubicacion = "Copia de Trabajo";
			$cod = XCampoc($fla['id_control'],"control_archivos","id_control","login_b",$link);
			$pat = XCampoc($cod,"users","login_usr","apa_usr",$link);
			$mat = XCampoc($cod,"users","login_usr","ama_usr ",$link);
			$nom = XCampoc($cod,"users","login_usr ","nom_usr",$link);		
			$responsable = $pat." ".$mat." ".$nom;
		}
		if ( $ubi == "b" ) $ubicacion = "Replica";
		if ( $ubi == "rev" ) 
		{	$ubicacion = "Revision";
			$sql2 = "SELECT MAX(id_asig) AS id_asig FROM asignacion_cvs WHERE id_arch=$fila[id_arch]";
			$res2 = mysql_db_query($db,$sql2, $link);
			$row2 = mysql_fetch_array($res2);
			$cod = XCampoc($row2['id_asig'],"asignacion_cvs","id_asig","login_resp",$link);
			$pat = XCampoc($cod,"users","login_usr","apa_usr",$link);
			$mat = XCampoc($cod,"users","login_usr","ama_usr ",$link);
			$nom = XCampoc($cod,"users","login_usr ","nom_usr",$link);		
			$responsable = $pat." ".$mat." ".$nom;			
		}
	}	
	echo "<tr align='center'><td>";
	//if ($login == "admin")
	echo "<a href=\"ver_archivos.php?id_arch=$fila[id_arch]&mod=$fila[nombre_mod]&op=version&ubc=$ubicacion&res=$cod\"  target='_blank'>$fila[id_arch]</a>";
	//else 
	//echo "$fila[id_arch]";
	echo "</td>";
	echo "<td>".$fila['nombre_arch']."</td>";
	if ($fila['fecha_rev']!="00/00/0000") echo "<td>$fila[fecha_rev]</td>";
	else echo "<td>&nbsp;</td>";			
	echo "<td>$fila[nombre_mod]</td>";
	echo "<td>$ubicacion</td>";	
	echo "<td>$responsable &nbsp;</td>";
	if ( $fila['eliminado'] == 1) 
	{	echo "<td>$fila[fec_baja]</td>";
		echo "<td>Eliminado</td>";
	}
	else 
	{	echo "<td>&nbsp;<img src=\"images/no3.gif\" border=\"0\"></td>";	
		if ( $fila['estado'] == 1 )
		echo "<td>&nbsp;<img src=\"images/no3.gif\" border=\"0\"></td>";
		else
		{	echo "<td><a href=\"?ejecutar=eliminar&id_arch=$fila[id_arch]&estado=$fila[estado]&mod=$fila[nombre_mod]\"onClick=\"return confirmLink(this,'$fila[nombre_arch]')\">";		
			echo "<img src=\"images/eliminar.gif\" border=\"0\" alt=\"Eliminar\"></a></td>";
		}	
	}
	echo "<td><a href=\"ver_archivos.php?id_arch=$fila[id_arch]&mod=$fila[nombre_mod]&ubc=$ubicacion&res=$cod\" target=\"_blank\">";
	echo "<img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Archivo\"></a></td></tr>";		
	unset($ubicacion);	
	unset($responsable);
	unset($cod);
}
?>
</tr>
</table>
<br>
<table width="85%" border="0" align="center">
  <tr> 
    <td> <div align="center"><strong><font size="2">Pagina(s) :&nbsp; 
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
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."'>&laquo; Anterior</a>&nbsp;";
}
//Enlaces a numeros de página:
for ($_pagi_i = 1; $_pagi_i<=$_pagi_totalPags; $_pagi_i++){//Desde página 1 hasta ultima página ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el numero de página es la actual ($_pagi_actual). Se escribe el numero, pero sin enlace y en negrita.
        $_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
    }else{
		//Si es cualquier otro. Se escibe el enlace a dicho numero de página.
        $_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."'>".$_pagi_i."</a>&nbsp;";
    }
}

if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la ultima página. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual + 1;//será el numero de página al que enlazamos
    $_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."'>Siguiente &raquo;</a>";
}
print $_pagi_navegacion;
//Hasta acá hemos completado la "barra de navegacion"
?>
        </font></strong> <font size="2"><strong>&nbsp;</strong></font></div></td>
  </tr>
</table>
<br>

<center>
<form action="lista_archivos.php" method="post" name="form1">
<input type="submit" value="NUEVO ARCHIVO" name="nuevo">&nbsp;&nbsp;&nbsp;
<input type="button" value="IMPRIMIR" name="imprimir" onClick="Mostrar()">&nbsp;&nbsp;&nbsp;
<input type="submit" value="RETORNAR" name="retornar">
</form>	
</center>
<?php 
include("top_.php");

?> 
<script language="JavaScript">
<!--
<?php if ($msg) 	
   	{	print "var msg=\"$msg\";\n";
		print "alert ( msg + \"\\n \\n\tMensaje generado por GesTor F1.\");\n";
	} 
?>
function confirmLink(theLink, archi)
{
    var is_confirmed = confirm("Desea realmente Eliminar el archivo"+ ' :\n' +"" + archi + "\n\nMensaje generado por GesTor F1");
    if (is_confirmed) {
        theLink.href += '&confirmado=1';
    }
    return is_confirmed;
} // end of the 'con firmLink()' function

function Mostrar() {
	window.open("ver_archivos_pre.php", 'Archivos','width=650,height=195,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
</script>				