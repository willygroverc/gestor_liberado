<?php
require_once( "ValidatorJs.php" );
$valid = new Validator ( "frmLector" );
$valid->addExists ( "porAgencia",  "Pagina enConstruccion, $errorMsgJs[empty]" );
$valid->toHtml();
require_once("funciones.php");
include("conexion.php");

if($varia3=="creacion"){
	session_start();
	$login=$_SESSION["login"];
	$sql2 = "SELECT * FROM calenmantplanif WHERE id_cmant='$variacua'";
	$result2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($result2);
	
	$sql_xx="SELECT * FROM datfichatec WHERE AdicUSI='$row2[AdicUSI]'";
	$result_xx=mysql_db_query($db,$sql_xx,$link);
	$row_xx=mysql_fetch_array($result_xx);
	
	$accion_obj ="(Objetivo: $row2[AdicUSI] - $row_xx[TpRegFicha])";
	$sql3 = "INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, tipo,origen) ".
			"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$accion_obj','L','2.3')"; 
	mysql_db_query($db,$sql3,$link);
	$sql5 = "SELECT MAX(id_orden) AS Ord FROM ordenes";
	$result5 = mysql_db_query($db,$sql5,$link);
	$row5 = mysql_fetch_array($result5);
	$sql4="UPDATE calenmantplanif SET orden='$row5[Ord]' WHERE id_cmant='$variacua'"; 
	mysql_db_query($db,$sql4,$link);
}

include ( "funciones.inc.php" );
if (valida("Cronograma")=="bad") {header("location: pagina_error.php");}
if ($RETORNAR){header("location: lista1_ficha.php?Naveg=Soporte Tecnico");}
if ($NueCalend)
{ 	
	$sql5="SELECT MAX(id_cmant) AS Id FROM calenmantplanif";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
	$r=$row5[Id]+1; 
	header("location: calendarizacion.php?varia=$r&varia1=$r");
}
if ($porAgencia)
{ 	include("conexion.php");
	$sql5="SELECT MAX(id_cmant) AS Id FROM calenmantplanif";
	$result5 = mysql_db_query($db,$sql5,$link);
	$row5 = mysql_fetch_array($result5);
	$r = $row5[Id]+1; 
	header("location: calendarizacion_agencia.php?varia=$r&varia1=$r");
}
include ("top.php");
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
<form name="form2" method="post" action="" onKeyPress="return Form()">
  <table width="80%" align="center" bgcolor="#006699">
    <tr> 
      <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Busqueda 
          de calendarizacion por :</strong></font> 
          <select name="campo">
            <option value="AdicUSI">CODIGO ADICIONAL</option>
          </select>
          &nbsp;&nbsp;&nbsp; 
          <input name="busqueda" type="text" size="40" value="<?php echo $busqueda;?>">
          &nbsp;&nbsp;&nbsp;&nbsp; 
          <input name="BUSCAR" type="submit" id="BUSCAR" value="BUSCAR">
        </div></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="69" valign="top"> <table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="10">CRONOGRAMA DE MANTENIMIENTO</th>
        </tr>
        <tr align=\"center\"> 
          <th width="3%" class="menu">Nro</th>
          <th width="10%" class="menu">CODIGO ADICIONAL</th>
          <th width="13%" class="menu">ASIGNADO A</th>
          <th width="7%" class="menu">ESTADO</th>
          <th width="10%" class="menu">FECHA INICIO</th>
          <th width="10%" class="menu">FECHA FINAL</th>
		  <th width="16%" class="menu">GARANTIA - MANTENIMIENTO:</th>
		  <th width="12%" class="menu">SEGUIMIENTO</th>
          <th width="10%" class="menu" wdith="2%">IMPRIMIR</th>
		  <th width="9%" class="menu">ORDEN DE TRABAJO</th>
        </tr>
        <?php
$fechahoy=date("Y-m-d");
if ($BUSCAR){$sql3 = "SELECT * FROM calenmantplanif a, datfichatec b WHERE a.AdicUSI=b.AdicUSI AND b.Elim<>1 AND a.$campo LIKE '%$busqueda%' GROUP BY a.AdicUSI ASC";}
else {$sql3 = "SELECT a.* FROM calenmantplanif a, datfichatec b WHERE a.AdicUSI=b.AdicUSI AND b.Elim<>1 GROUP BY a.AdicUSI ASC";}
$result3=mysql_db_query($db,$sql3,$link);
while($row3=mysql_fetch_array($result3)){
	$a=0;
	$sql = "SELECT *,DATE_FORMAT(fecha_del, '%d/%m/%Y') AS fecha_del, DATE_FORMAT(fecha_al, '%d/%m/%Y') AS fecha_al 
			FROM calenmantplanif WHERE AdicUSI='$row3[AdicUSI]'";
	$result=mysql_db_query($db,$sql,$link); 
	while ($row=mysql_fetch_array($result)) {
		$sql2 = "SELECT * FROM calenmantplanif WHERE id_cmant='$row[id_cmant]' AND estado='Realizado' ";
		$result2=mysql_db_query($db,$sql2,$link);
		$row2=mysql_fetch_array($result2); 	
		if (!$row2[estado])
		{	
			if ($row[fecha_al] >= $fechahoy)   // VIGENTE
			{$color="bgcolor=\"#00CC00\"";}
			else if ($row[fecha_al] < $fechahoy) // VENCIDO
			{$color="bgcolor=\"#FF6666\"";}
			echo "<tr align=\"center\">";
			echo "<td ".$color."><font size=\"1\">$row[id_cmant]</font></td>";
			echo "<td><font size=\"1\"><a href=\"calendarizacion_resumen.php?AdicUSI=".$row[AdicUSI]."\">".$row[AdicUSI]."</a></font></td>";
			$codu2 = XCampo($row[AdicUSI],"datfichatec","AdicUSI","Idficha",$link);
			$temp="SELECT NombAsig FROM asigcustficha WHERE Idficha='$codu2'";
			$temp=mysql_db_query($db,$temp,$link);
			$temp=mysql_num_rows($temp);
			$temp="SELECT NombAsig FROM asigcustficha WHERE Idficha='$codu2' LIMIT 1,$temp";
//			$boris=$temp;
			$temp=mysql_db_query($db,$temp,$link);
			$temp=mysql_fetch_array($temp);
			$codu=$temp[NombAsig];
//			$codu = XCampo($codu2,"asigcustficha","IdFicha","NombAsig",$link);
			$nom = XCampo($codu,"users","login_usr","nom_usr",$link);
			$pat = XCampo($codu,"users","login_usr","apa_usr",$link);
			$mat = XCampo($codu,"users","login_usr","ama_usr",$link);
			if ( !empty($nom) )	
				$datos = $nom." ".$pat." ".$mat;
			else
				$datos = "No asignado";
			echo "<td><font size=\"1\">$datos</td>";
			echo "<td><font size=\"1\">$row[estado]</td>";
			echo "<td><font size=\"1\">$row[fecha_del]</font></td>";
			echo "<td><font size=\"1\">$row[fecha_al]</font></td>";
			$f_sist=date("Y-m-d");
			$sqlcont="SELECT *, DATE_FORMAT(fecha_al, '%d/%m/%Y') AS FechAl2a  FROM contyman WHERE IdContra='$row[AdicUSI]'";
			$resultcont=mysql_db_query($db,$sqlcont,$link);
			$rowcont=mysql_fetch_array($resultcont);
			if($rowcont){
			echo "<td><table border='0'>";
				if($rowcont[cont_manten]){
						$sqlf="SELECT * FROM contyman WHERE '$f_sist' BETWEEN '$rowcont[fecha_del]' AND '$rowcont[fecha_al]' AND IdContra='$row[AdicUSI]'";
						$resultf=mysql_db_query($db,$sqlf,$link);
						$rowf=mysql_fetch_array($resultf);
						if($rowf[fecha_al]){$colorA="bgcolor=\"#00CCFF\"";}
						else{$colorA="bgcolor=\"#0066CC\"";}
							echo "<tr>
									<td $colorA><div align='right'>Mantenimiento :</div></td>
									<td><a href=\"contrato_garantia_last.php?IdContra=".$row[AdicUSI]."\">&nbsp;$rowcont[FechAl2a]</a></td>
								  </tr>";
				}
				if($rowcont[cont_garantia]){
				$sqlau="SELECT *, DATE_FORMAT(GarantAl, '%d/%m/%Y') AS fecha2 FROM datfichatec WHERE AdicUSI='$row[AdicUSI]'";
				$resultau=mysql_db_query($db,$sqlau,$link);
				$rowau=mysql_fetch_array($resultau);
				$sqlf="SELECT * FROM datfichatec WHERE '$f_sist' BETWEEN '$rowau[GarantDe]' AND '$rowau[GarantAl]' AND AdicUSI='$row[AdicUSI]'";
				$resultf=mysql_db_query($db,$sqlf,$link);
				$rowf=mysql_fetch_array($resultf);
					if($rowf[GarantAl]){$colorB="bgcolor=\"#CCCCCC\"";}
					else{$colorB="bgcolor=\"#666666\"";}
				echo "<tr>
					<td $colorB><div align='right'>Garantia :</div></td>
					<td><a href=\"contrato_garantia_last.php?IdContra=".$row[AdicUSI]."\">&nbsp;$rowau[fecha2]</a></td>
				  </tr>";}
				if(!$rowcont[cont_garantia] && !$rowcont[cont_manten]){echo "<td><a href=\"contrato_garantia_last.php?IdContra=".$row[AdicUSI]."\">NINGUNO</a></td>";}
				echo "</table></td>";
			}else{
				echo "<td><a href=\"contrato_garantia.php?IdContra=".$row[AdicUSI]."\">NINGUNO</a></td>";}
			echo "<td><font size=\"1\"><a href=\"calendarizacion_last.php?id_cmant=".$row[id_cmant]."&AdicUSI=".$row[AdicUSI]."\">REALIZACION</a></font></td>";
			echo "<td><font size=\"1\"><a href=\"ver_calenresumen.php?AdicUSI=".$row[AdicUSI]."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
			////////
			if ($row[orden]=="0") echo "<td><a href=\"lista_calen.php?varia3=creacion&variacua=".$row[id_cmant]."\">CREAR ORDEN DE TRABAJO</a></td>";
			else echo "<td><a href=\"ver_orden.php?id_orden=$row[orden]\" target=\"_blank\">$row[orden]</a></td>";
			////////
			echo "</tr>";
			$a=$a+1;}
		}
		if($a=="0")
		{	$color="bgcolor=\"#FFFF00\"";	
			$sql4 = "SELECT MAX(id_cmant) AS ID FROM calenmantplanif WHERE AdicUSI='$row3[AdicUSI]'";
			$result4=mysql_db_query($db,$sql4,$link);
			$row4=mysql_fetch_array($result4);
			$sql5 = "SELECT *, DATE_FORMAT(fecha_del, '%d/%m/%Y') AS fecha_del, DATE_FORMAT(fecha_al, '%d/%m/%Y') AS fecha_al  FROM calenmantplanif WHERE AdicUSI='$row3[AdicUSI]' AND id_cmant='$row4[ID]'";
			$result5=mysql_db_query($db,$sql5,$link);
			while ($row5=mysql_fetch_array($result5)){ 	
			echo "<tr align=\"center\">";
			echo "<td ".$color."><font size=\"1\">$row5[id_cmant]</font></td>";
			$codu2 = XCampo($row[AdicUSI],"datfichatec","AdicUSI","Idficha",$link);
			$codu = XCampo($codu2,"asigcustficha","IdFicha","NombAsig",$link);
			$nom = XCampo($codu,"users","login_usr","nom_usr",$link);
			$pat = XCampo($codu,"users","login_usr","apa_usr",$link);
			$mat = XCampo($codu,"users","login_usr","ama_usr",$link);
			if ( !empty($nom) )	
				$datos = $nom." ".$pat." ".$mat;
			else
				$datos = "No asignado";	
			echo "<td><font size=\"1\"><a href=\"calendarizacion_resumen.php?AdicUSI=".$row5[AdicUSI]."\">$row5[AdicUSI]</a></font></td>";
			echo "<td><font size=\"1\">$datos</td>";
			echo "<td><font size=\"1\">$row5[estado]</td>";
			echo "<td><font size=\"1\">$row5[fecha_del]</font></td>";
			echo "<td><font size=\"1\">$row5[fecha_al]</font></td>";
			$sqlcont="SELECT *, DATE_FORMAT(fecha_al, '%d/%m/%Y') AS FechAl2a  FROM contyman WHERE IdContra='$row5[AdicUSI]'";
			$resultcont=mysql_db_query($db,$sqlcont,$link);
			$rowcont=mysql_fetch_array($resultcont);
			if($rowcont){
				if($rowcont[tipo]=='Garantia'){$colorA="bgcolor=\"#FF9999\"";}
				elseif($rowcont[tipo]=='Mantenimiento'){$colorA="bgcolor=\"#00FFFF\"";}
				echo "<td ".$colorA."><a href=\"contrato_garantia_last.php?IdContra=".$row5[AdicUSI]."\">&nbsp;$rowcont[FechAl2a]</a></td>";
			}else{
				echo "<td><a href=\"contrato_garantia.php?IdContra=".$row5[AdicUSI]."\">NINGUNO</a></td>";}
			echo "<td><font size=\"1\">LLENADO</font></td>";
			echo "<td><font size=\"1\"><a href=\"ver_calenresumen.php?AdicUSI=".$row5[AdicUSI]."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";			
			////////
			if ($row5[orden]=="0") echo "<td><a href=\"lista_calen.php?varia3=creacion&variacua=".$row5[id_cmant]."\">CREAR ORDEN DE TRABAJO</a></td>";
			else echo "<td><font size=\"1\"><a href=\"ver_orden.php?id_orden=$row5[orden]\" target=\"_blank\">$row5[orden]</a></font></td>";
			////////
			echo "</tr>";}}
}
?>
      </table></td>
  </tr>
</table>
<form name="form1" method="get" action="">
  <div align="center">
    <input name="NueCalend" type="submit" value="NUEVA PLANIFICACION">
    <?php echo "\t\t";
		$sql1="SELECT * FROM control_parametros";
		$rs1=mysql_db_query($db,$sql1,$link);
		$row1=mysql_fetch_array($rs1);
		  if ($row1[agencia]=="si") {   
	?> 	
    <input name="porAgencia" type="submit" value="PLANIFICACION POR AGENCIA">
    <?php  }echo "\t\t";
   ?>    
    <input type="submit" name="IMPRIMIR" value="IMPRIMIR REPORTE" onClick="open_calen()">	
    <?php echo "\t\t";?> 
	<br><br> 
    <input type="submit" name="RETORNAR" value="RETORNAR">
  </div>
</form>
<div align="center">
  <p><font size="1" face="Arial, Helvetica, sans-serif">CODIFICACION PARA LA COLUMNA No.: </font></p>
</div>
<table width="80%" border="1" align="center">
  <tr> 
    <td width="15%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">PLANIFICACION 
        VENCIDA </font></div></td>
    <td width="7%" bgcolor="#FF6666">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="18%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">PLANIFICACION 
        VIGENTE</font></div></td>
    <td width="8%" bgcolor="#00CC00">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="23%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">REALIZACION 
        Y PLANIFICACION CULMINADA</font></div></td>
    <td width="6%" bgcolor="#FFFF00">&nbsp;</td>
  </tr>
</table>
<div align="center">
  <p><font size="1" face="Arial, Helvetica, sans-serif">CODIFICACION PARA LA COLUMNA DE CONTRATO AL:</font></p>
</div>
<table width="80%" border="1" align="center">
  <tr> 
    <td width="20%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">EQUIPO 
        CON CONTRATO DE MANTENIMIENTO VIGENTE</font></div></td>
    <td width="6%" bgcolor="#00CCFF">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="20%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">EQUIPO 
        CON CONTRATO DE MANTENIMIENTO VENCIDO</font></div></td>
    <td width="6%" bgcolor="#0066CC">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="15%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">EQUIPO 
        CON GARANTIA VIGENTE</font></div></td>
    <td width="6%" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="2%">&nbsp;</td>
        <td width="15%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">EQUIPO 
        CON GARANTIA VENCIDA</font></div></td>
        <td width="6%" bgcolor="#666666">&nbsp;</td>
  </tr>
</table>
<?php include("top_.php");?> 
<script language="JavaScript">
<!--
function open_calen() {	
	
	window.open("calen_opcion.php",'Calendarización', 'width=610,height=140,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
	
}
function pagina() {
	window.open("ver_calendarizacion.php");
}
-->
</script>