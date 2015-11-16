<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require ("conexion.php");
include ("funciones.inc.php");	
if (isset($Retornar))
{ header("location: lista_calen.php");
}
else 
{ include ("top.php");

$AdicUSI=($_GET['AdicUSI']);

	 //New code
			$sqla = "select *from datfichatec where AdicUSI = '$AdicUSI'";
			$resa = mysql_query($sqla);
			$rowa = mysql_fetch_array($resa);
			
			$sqlb = "select *from asigcustficha where IdFicha = '$rowa[IdFicha]'";
			$resb = mysql_query($sqlb);
			if(mysql_num_rows($resb) >= 1)
			{
				while($rowb = mysql_fetch_array($resb))
				{
					$sel = "select *from users where login_usr='$rowb[NombAsig]' and bloquear = 0";
					$rel = mysql_query($sel);
					$rol = mysql_fetch_array($rel);
				}
				$valor = $rol['login_usr'];
			}else{
				$valor = '';
			}
			
			$sqlc = "select *from users where login_usr = '$valor'";
			$resc = mysql_query($sqlc);
			$rowc = mysql_fetch_array($resc);
			
			
			$datos = $rowc['nom_usr']." ".$rowc['apa_usr']." ".$rowc['ama_usr'];
			if(mysql_num_rows($resc) == 0)
			{
				$datos = 'No Asignado';
			}
			
			if ( !empty($datos) )	
				$datos;
			else
				$datos;
			//End new code

?>
<input name="var" type="hidden" value="<?php echo $AdicUSI;?>">
<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="17" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF">CALENDARIZACION 
            INDIVIDUAL</font></th>
        </tr>
        <tr align="left"> 
          <th colspan="17" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="2" >
		  	<b>&nbsp;ASIGNADO A: </b>
			<font size="2" face="Verdana, Helvetica" color="#FFFFFF">
			<?php echo $datos ?>
			</font>
			</font></th>
        </tr>
		
        <tr align=\"center\"> 
          <th width="48" height="13" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">Nro. 
            </font></th>
          <th width="128" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">CODIGO 
            ADICIONAL</font></th>
          <th width="85" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">ESTADO</font></th>
          <th width="88" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">FECHA 
            INICIO</font></th>
          <th width="85" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA 
            FINAL</font></th>
          <th width="114" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">SEGUIMIENTO</font></th>
          <th width="298" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></th>
        </tr>
        <?php
$sql = "SELECT *, DATE_FORMAT(fecha_del, '%d/%m/%Y') AS fecha_del, DATE_FORMAT(fecha_al, '%d/%m/%Y') AS fecha_al 
		FROM calenmantplanif  WHERE AdicUSI='$AdicUSI' ORDER BY id_cmant ASC";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) {

	$sql2 = "SELECT * FROM calenmantplanif WHERE id_cmant='$row[id_cmant]' AND estado='Realizado' ";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);   
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">$row[id_cmant]</font></td>";
	//echo $row[AdicUSI]." ".$nom." ".$pat." ".$mat; 			
	
	
	echo "<td><font size=\"1\">$row[AdicUSI]</font></td>";
	echo "<td><font size=\"1\">$row[estado]</td>";
	echo "<td><font size=\"1\">$row[fecha_del]</font></td>";
	echo "<td><font size=\"1\">$row[fecha_al]</font></td>";
	if (!$row2['estado'])
	{	echo "<td><font size=\"1\">REALIZACION POR LLENAR</a></font></td>";}
	else
	{	echo "<td><font size=\"1\">LLENADO</font></td>";}
	echo "<td><font size=\"1\">&nbsp;$row[Observ]</font></td>";
	echo "</tr>";
}

?>
      </table></td>
  </tr>
</table>
  
  
<form name="form1" method="post" action="">
  <input name="Retornar" type="submit" id="reg_form3" value="RETORNAR">
</form>

 <?php } ?>