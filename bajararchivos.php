<?php 
include ("conexion.php");
include ("funciones.inc.php");
$c = 1;
$sql = "SELECT * FROM control_archivos WHERE ubicacion='c' AND login_b='$login' AND descargado=0";
$res = mysql_db_query($db,$sql,$link); 
while ( $fila = mysql_fetch_array($res)) 	 	
{	$nom_arch = XCampoc($fila['id_arch'],"datos_archivos","id_arch","nombre_arch",$link);
	$id_moda  = XCampoc($fila['id_arch'],"datos_archivos","id_arch","id_mod",$link);	
	if ( $id_mod == $id_moda )
	{	echo "&nbsp;<font face='arial' size='2'>$c"."."."</font>";
		echo "&nbsp&nbsp;<a href='bajando.php?arch=$nom_arch&id_arch=$fila[id_arch]&id_control=$fila[id_control]' onClick=\"return confirmLink(this,'$nom_arch')\"><font face='arial' size=2 color='#003399'>$nom_arch</font></a>";
		echo "<br>";
		$c++;
	}		
}
?>	 
<script language="JavaScript">
<!--
function confirmLink(theLink, archivo)
{
    var is_confirmed = confirm("Desea descargar el archivo:"+ ' \n' + archivo + '\n' + '\n' + "Mensaje generado por GesTor F1." );
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