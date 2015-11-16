<HTML><HEAD>
<LINK href="img/noticias.css" type=text/css rel=stylesheet>
<BODY background="img/fo.jpg">
<?php 
include ("conexion.php");
include ("funciones.inc.php");
$c = 1;
$sql = "SELECT * FROM asignacion_cvs WHERE login_resp='$login' AND estado=1 AND descargado=0";
$res = mysql_db_query($db,$sql,$link); 
while ( $fila = mysql_fetch_array($res))
{		
	$sql2 = "SELECT MAX(id_arch) as id_arch FROM datos_archivos WHERE id_arch='$fila[id_arch]' AND id_mod='$id_mod'";
	$res2 = mysql_db_query($db,$sql2,$link); 
	$row2 = mysql_fetch_array($res2);
	$sql1 = "SELECT * FROM datos_archivos WHERE id_arch='$row2[id_arch]'";
	$res1 = mysql_db_query($db,$sql1,$link); 
	$row1 = mysql_fetch_array($res1);
	if ($row1[id_arch]){
	echo "&nbsp;<font face='arial' size='2'>$c"."."."</font>";
	echo "&nbsp&nbsp;<a href='bajando2.php?id=$fila[id_arch]&login=$login' onClick=\"return confirmLink(this,'$row1[nombre_arch]')\"><font face='arial' size=2 color='#003399'>$row1[nombre_arch]</font></a>";
	echo "<br>";
	$c++;
	}
}
 ?>	 
</BODY>
</HTML>
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