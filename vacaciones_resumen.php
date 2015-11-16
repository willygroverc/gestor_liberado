<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		12/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($_REQUEST['Retornar'])){ header("location: lista_vacaciones.php");}
else 
{ include ("top.php");
$Nombre=($_GET['Nombre']);
?>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>

<input name="var" type="hidden" value="<?php echo $Nombre;?>">
<table border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="15" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF">CALENDARIZACION 
            DE AUSENCIA PROGRAMADA - INDIVIDUAL</font></th>
        </tr>
        <tr align=\"center\"> 
          <th width="248" height="13" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NOMBRE</font></th>
          <th width="139" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">ESTADO</font></th>
  		  <th width="113" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">AUSENCIA</font></th>

          <th width="124" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">FECHA 
            INICIO</font></th>
          <th width="113" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA 
            FINAL</font></th>
          <th width="114" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">SEGUIMIENTO</font></th>
        </tr>
        <?php
$sql = "SELECT *, DATE_FORMAT(fecha_del, '%d/%m/%Y') AS fecha_del, DATE_FORMAT(fecha_al, '%d/%m/%Y') AS fecha_al FROM vacaciones  WHERE Nombre='$Nombre' ORDER BY id_vacac ASC";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) {

	$sql2 = "SELECT * FROM vacaciones WHERE id_vacac='$row[id_vacac]' AND estado='Realizado' ";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2); 
  
  
  	echo "<tr align=\"center\">";
		$sql6 = "SELECT * FROM users WHERE login_usr='$row[Nombre]'";
	  	$result6 = mysql_query($sql6);
		$row6 = mysql_fetch_array($result6);
	echo "<td><font size=\"1\">".$row6['nom_usr']." ".$row6['apa_usr']." ".$row6['ama_usr']."</a></font></td>";
	echo '<td><font size="1">'.$row['estado'].'</td>';
	echo '<td><font size="1">'.$row['ausencia'].'</font></td>';
	echo '<td><font size="1">'.$row['fecha_del'].'</font></td>';
	echo '<td><font size="1">'.$row['fecha_al'].'</font></td>';

	if (!isset($row2['estado']))
	{	echo "<td><font size=\"1\">REALIZACION POR LLENAR</a></font></td>";}
	else
	{	echo "<td><font size=\"1\">LLENADO</font></td>";}
	
	echo "</tr>";
}

?>
      </table></td>
  </tr>
</table>
  
  
<form name="form1" method="post" action="" onKeyPress="return Form()">
  <input name="Retornar" type="submit" id="reg_form3" value="RETORNAR">
</form>

 <?php } ?>