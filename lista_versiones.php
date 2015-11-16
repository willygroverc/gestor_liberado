<?php 
include ("conexion.php");
if ( $retornar ){header("location: lista_archivos.php");}
include("top.php");
?>
<html>
<head>
<title>GesTor F1</title>
</head>
<body>
<table width="75%" align="center" background="images/fondo.jpg" border="1">
    <tr bgcolor="#006699"> 
      <td colspan="6" align="center"><font size="3" color="#FFFFFF" face="VERADNA, Helvetica, sans-serif"><strong>
	  	HISTORIAL DE VERSIONES:<?php echo "\t<b>$arch</b>"; ?>
		</strong></font>
	  </td>	 
    </tr>	
	<tr>
		<td  align="center" bgcolor="#006699" class="menu">
		Nro. VERSION
		</td>
		<td  align="center" bgcolor="#006699" CLASS="MENU">
		NOMBRE
		</td>
		<td  align="center" bgcolor="#006699" class="menu">
		FECHA CREACION
		</td>
		<td  align="center" bgcolor="#006699" class="menu">
		MODULO
		</td>
	</tr>
<?php 
$sql = "SELECT *, DATE_FORMAT(fecha_ver, '%d/%m/%Y') AS fecha_ver FROM versiones WHERE id_arch='$id_arch'";	
$res = mysql_db_query( $db, $sql, $link );
while ( $fila = mysql_fetch_array($res) )
{	echo "<tr>";
	echo "<td align='center'>$fila[id_version]</td>";	
	echo "<td align='center'>$fila[nombre_arch]</td>";
	if ($fila[fecha_ver]!= "00/00/0000") 
	echo "<td align='center'>$fila[fecha_ver]</td>";
	else {echo "<td align='center'>&nbsp;</td>";}		
	echo "<td align='center'>$mod</td>";
	echo "</tr>";
}
?>	
</table>
<center>
<form action="lista_versiones.php" method="post" name="form1">
<input type="button" value="Imprimir" name="imprimir" onClick="Mostrar()"><?php echo "\t";?>
<input type="submit" value="Retornar" name="retornar">
</form>	
</center>
<?php 
include("top_.php");
$op = "version";
?>
<script language="JavaScript">
function Mostrar(){
var id, mod, op
id = "<?php echo $id_arch; ?>";
mod = "<?php echo $mod; ?>";
op ="<?php echo $op; ?>";
	window.open ( "ver_archivos.php?id_arch=" + id + "&mod=" + mod + "&op=" + op+ "");
}

</script>	
</body>
</html>
