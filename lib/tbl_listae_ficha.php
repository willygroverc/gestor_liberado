<?php
header('Content-Type: text/html; charset=iso-8859-1');
@session_start();
$tipo=$_SESSION["tipo"];
require('../conexion.php');
require ('../funciones.php');
//PARA LIMPIAR LOS CAMPOS EJECUTAR SEGUN LAS FUNCIONES: _clean y SanitizeString
$tipo_busq = $_POST['tipo_busq'];
if(!empty($_POST['txt_busq']))	{
	$txt_busq = $_POST['txt_busq'];
}
if(!empty($_POST['pg']))	{
	$pg=$_POST['pg'];
}
$cond="";
if(empty($txt_busq) || empty($tipo_busq))
{	$sql_ficha="SELECT *, DATE_FORMAT(FechPruFunc, '%d/%m/%Y') AS FechPruFunc FROM datfichatec WHERE Elim<>'1' ORDER BY IdFicha DESC ";	}
else
{
	if($tipo_busq=="TpRegFicha")
		$sql_ficha="SELECT *, DATE_FORMAT(FechPruFunc, '%d/%m/%Y') AS FechPruFunc FROM datfichatec WHERE TpRegFicha like '%$txt_busq%' AND Elim<>'1' ORDER BY IdFicha DESC";
	if($tipo_busq=="CodActFijo")
		$sql_ficha="SELECT *, DATE_FORMAT(FechPruFunc, '%d/%m/%Y') AS FechPruFunc FROM datfichatec WHERE CodActFijo like '%$txt_busq%' AND Elim<>'1' ORDER BY IdFicha DESC";
	if($tipo_busq=="Modelo")
		$sql_ficha="SELECT *, DATE_FORMAT(FechPruFunc, '%d/%m/%Y') AS FechPruFunc FROM datfichatec WHERE Modelo like '%$txt_busq%' AND Elim<>'1' ORDER BY IdFicha DESC";
	if($tipo_busq=="AdicUSI")
		$sql_ficha="SELECT *, DATE_FORMAT(FechPruFunc, '%d/%m/%Y') AS FechPruFunc FROM datfichatec WHERE AdicUSI like '%$txt_busq%' AND Elim<>'1' ORDER BY IdFicha DESC";	
	
}
//echo $sql_ficha;
$recordset=mysql_query($sql_ficha);
	$num_paginas=mysql_num_rows($recordset);
	$num_paginas=($num_paginas/20)+1;
	settype($num_paginas,'integer');
	$pagina_fin=20*$pg;
	$pagina_ini=($pagina_fin-20);
	$sql_ficha.=" LIMIT $pagina_ini, 20";
	$recordset_ficha=mysql_query($sql_ficha);

//$recordset_ficha=mysql_query($sql_ficha);
//echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="tbl_ordenes" name="tbl_ordenes">
echo '<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
		<thead>
			<tr><th height="30" colspan="17" align="center" background="images/main-button-tileR2.jpg">REGISTRO DE FICHAS TECNICAS</th></tr>';
		echo '<tr align="center">  
				<th width="25" height="30" class="menu" background="images/main-button-tileR2.jpg">N� FICHA</th>
				<th width="90" class="menu" background="images/main-button-tileR2.jpg">FECHA REALIZACION</th>
				<th width="15" class="menu" background="images/main-button-tileR2.jpg">TIPO REGISTRO</th>
				<th width="10" class="menu" background="images/main-button-tileR2.jpg">CODIGO ACTIVO FIJO</th>
				<th width="10" class="menu" background="images/main-button-tileR2.jpg">CODIGO ADICIONAL</th>
				<th width="10" class="menu" background="images/main-button-tileR2.jpg">MODELO</th>
				<th width="10" class="menu" background="images/main-button-tileR2.jpg">ASIGNADO A</th>
				<th width="10" class="menu" background="images/main-button-tileR2.jpg">FECHA RECEPCION</th>
				<th width="15" class="menu" background="images/main-button-tileR2.jpg">FECHA DEVOLUCION</th>';
		echo '	<th width="10" class="menu" background="images/main-button-tileR2.jpg">MODIFICAR FICHA</th>
				<th width="60" class="menu" background="images/main-button-tileR2.jpg">MANTENIMIENTO</th>
				<th width="17" class="menu" background="images/main-button-tileR2.jpg">CRONOGRAMA</th>
				<th width="17" class="menu" background="images/main-button-tileR2.jpg">FICHA TECNICA</th>
				<th width="17" class="menu" background="images/main-button-tileR2.jpg">CUSTODIO</th>';
		echo '	<th width="15" class="menu" background="images/main-button-tileR2.jpg">DAR DE BAJA</th>
			</tr>
		</thead><tbody>';

if(!empty($recordset_ficha))
{
	if (mysql_num_rows($recordset_ficha)!=0){
		echo '<input type="hidden" value="'.mysql_num_rows($recordset_ficha).'" id="num_registros">';
		for ($i=1;$i<=mysql_num_rows($recordset_ficha);$i++){
			$fila_ficha=mysql_fetch_array($recordset_ficha);
			echo '<tr align="center">';
			if(!empty($fila_ficha['fechaestsol_asig']))	{
				$fecha_limite=date($fila_ficha['fechaestsol_asig']);
			}
			echo "<td><font size=\"1\">&nbsp;$fila_ficha[IdFicha]</font></td>";
			echo "<td><font size=\"1\">&nbsp;$fila_ficha[FechPruFunc]</font></td>";
			echo "<td><font size=\"1\">&nbsp;$fila_ficha[TpRegFicha]</font></td>";
			echo "<td><font size=\"1\">&nbsp;$fila_ficha[CodActFijo]</font></td>";
			echo "<td><font size=\"1\">&nbsp;$fila_ficha[AdicUSI]</font></td>";
			echo "<td><font size=\"1\">&nbsp;$fila_ficha[Modelo]</font></td>";
			$sql2 = "SELECT MAX(IdCust) AS ID FROM asigcustficha WHERE IdFicha='$fila_ficha[IdFicha]'";
		$result2 = mysql_db_query($db,$sql2,$link);
		$row2 = mysql_fetch_array($result2);
		$sql3 = "SELECT *, DATE_FORMAT(Fecha, '%d/%m/%Y') AS Fecha FROM asigcustficha WHERE IdCust='$row2[ID]'"; //HERE
		$result3 = mysql_db_query($db,$sql3,$link);
		$row3 = mysql_fetch_array($result3);
		if (($row3['Tipo']=="Asignado" AND $row3['Tipo1']=="Devuelto")OR(!$row3['Tipo'] AND !$row3['Tipo1']))
		{	echo "<td><font size=\"1\">&nbsp;Disponible</font></td>";	
			echo "<td><font size=\"1\">&nbsp;<a href=\"fichatec_recep.php?IdFicha=".$fila_ficha['IdFicha']."\"><img src=\"images/usuario.gif\" border=\"0\" alt=\"Asignar\"></a></font></td>";
			echo "<td><font size=\"1\">&nbsp;DEVOLUCION</font></td>";}
		else if ($row3['Tipo']=="Asignado" AND $row3['Tipo1']=="")
		{	
			$sql7="SELECT * FROM users WHERE login_usr='$row3[NombAsig]'";
			$result7=mysql_db_query($db,$sql7,$link);
			$row7=mysql_fetch_array($result7);	
			echo "<td><font size=\"1\">&nbsp;$row7[nom_usr] $row7[apa_usr] $row7[ama_usr]</font></td>";	
			echo "<td><font size=\"1\">&nbsp;$row3[Fecha]</font></td>"; //HERE
			echo "<td><font size=\"1\">&nbsp;<a href=\"fichatec_devol.php?IdFicha=".$fila_ficha['IdFicha']."&IdCust=".$row2['ID']."\"><img src=\"images/mano.gif\" border=\"0\" alt=\"Devolucion\"></a></font></td>";}
			if ($tipo=="A" or $tipo=="B")
			{echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"ficha_tecnica_last.php?IdFicha=".$fila_ficha['IdFicha']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";}
			$sql5="SELECT MAX(id_regPC) AS Id FROM pcontrol";
			$result5=mysql_db_query($db,$sql5,$link);
			$row5=mysql_fetch_array($result5);
			$r=$row5['Id']+1; 
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"controlmanten.php?CodActFijo=".$fila_ficha['CodActFijo']."&varia1=".$r."\"><img src=\"images/dispositivo.gif\" border=\"0\" alt=\"Realizar Mantenimiento Fuera\"></a></font></td>";
			$sql6="SELECT MAX(id_cmant) AS Id FROM calenmantplanif";
			$result6=mysql_db_query($db,$sql6,$link);
			$row6=mysql_fetch_array($result6);
			$rr=$row6['Id']+1; 
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"calendarizacion.php?CodActFijo=".$fila_ficha['CodActFijo']."&varia=".$rr."&varia1=".$rr."\"><img src=\"images/cal.gif\" border=\"0\" alt=\"Realizar Cronograma\"></a></font></td>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"ver_fichatecnica.php?IdFicha=".$fila_ficha['IdFicha']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Ficha Tecnica\"></a></font></td>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"ver_fichatecnica_custodio.php?IdFicha=".$fila_ficha['IdFicha']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Custodio\"></a></font></td>";
	//////
		echo "<td onclick=\"eliminar_ficha('$fila_ficha[IdFicha]')\">&nbsp;<a href=\"#\"><img src=\"images/eliminar.gif\" border=\"0\" alt=\"Eliminar Ficha\"></a></font></td>";
			echo '</tr>';
		}
		echo '</tbody></table><br><br>';
	}
	else{
		echo '<tbody><tr><td colspan="16" align="center"><h3>NO SE HAN ENCONTRADO RESULTADOS</h3></td></tr></tbody></table><br><br>';
	}
}
/*PAGINACION*/
echo '<center><b><font size="2">Pagina(s): </br>';
if ($pg>20){
	echo '<a href="javascript:pag_ficha(3,0);">Anterior,&nbsp</a>';
	$pagina_ini=$pg-20+1;
	$pagina_fin=$pg;
}
else{
	$pagina_ini=1;
	$pagina_fin=$num_paginas;
}

for ($i=$pagina_ini;$i<=$pagina_fin;$i++){
	if ($i==$pg)
		echo $i;
	else{
		echo '<a href="javascript:pag_ficha(1,'.$i.');">'.$i.'</a>';
	}	
	if ($i!=$num_paginas)
		echo ',';
}
if ($i>20){
	echo '<a href="javascript:pag_ficha(2,0)">&nbsp;Siguiente</a>';
}
/*FIN PAGINACION*/
echo "</br>";
echo "<input name=\"nueva\" type=\"submit\" id=\"nueva\" value=\"NUEVA FICHA\" onclick=\"location.href = 'ficha_tecnica.php'\">";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input name=\"imprimir\" type=\"submit\" id=\"imprimir\" value=\"IMPRIMIR\" onclick=\"openStat_2()\">";
echo "</br>"."</br>";


echo '</font></b></center><br>';

?>