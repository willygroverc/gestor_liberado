<?php
// Objetivo:	Optimización de consulta SQL, para listado de ordenes de trabajo
//				Modificación de metodo de envio de datos (a POST)
//				Mejora en Filtro de Busqueda -Area-Usuario
//				Validacion para Inyeccion SQL.
// Autor:		Alvaro Rodriguez
// Fecha:		08/ENE/2013
// Desc:		
//________________________________________________________________________________
// Version:		2.0
// Autor:		Alvaro ROdriguez
// Objetivo:	Se ha corrgido el vista de los caracteres especiales y 
// 				se ha cambiado el formato de fecha.
//_________________________________________________________________________________
header('Content-Type: text/html; charset=iso-8859-1');
//header('content-type text/html charset=iso-8859-1');
@session_start();
require('../conexion.php');
require ('../funciones.php');
//if(!empty($_POST['tipo_busq']))	{
$tipo_busq = $_POST['tipo_busq'];


$txt_busq=_clean($_POST['txt_busq']);
$txt_busq=SanitizeString($txt_busq);
$pg = $_POST['pg'];
$fechahoy = date('Y-m-d');
//echo $txt_busq;
//echo $tipo_busq;
include_once ("../help.class.php");
$sql = "SELECT IdProv, NombProv FROM proveedor";
		$rs = mysql_db_query($db,$sql,$link);
		while ($tmp = mysql_fetch_array($rs)) {
			$lstProveedor[$tmp['IdProv']]=$tmp['NombProv'];
	}

if(strlen($txt_busq)==0 || strlen($tipo_busq)==0)
{	$sql_cont="SELECT *, DATE_FORMAT(FechAl, '%d/%m/%Y') AS FechAl2 FROM contratodatos ORDER BY IdContra DESC";	}
else
{	if($tipo_busq=="cod")
		$sql_cont="SELECT *, DATE_FORMAT(FechAl, '%d/%m/%Y') AS FechAl2 FROM contratodatos WHERE CodLegalContra LIKE '%$txt_busq%' ORDER BY IdContra DESC";
	if($tipo_busq=="emp")
		$sql_cont="SELECT *, DATE_FORMAT(FechAl, '%d/%m/%Y') AS FechAl2 FROM contratodatos WHERE EmpContra LIKE '%$txt_busq%' ORDER BY IdContra DESC";
	if($tipo_busq=="ncc")
		$sql_cont="SELECT *, DATE_FORMAT(FechAl, '%d/%m/%Y') AS FechAl2 FROM contratodatos WHERE IdContra LIKE '%$txt_busq%' ORDER BY IdContra DESC";
	if($tipo_busq=="tipo")
		$sql_cont="SELECT *, DATE_FORMAT(FechAl, '%d/%m/%Y') AS FechAl2 FROM contratodatos WHERE TipoContra LIKE '%$txt_busq%' ORDER BY IdContra DESC";
}

$recordset=mysql_query($sql_cont);
	$num_paginas=mysql_num_rows($recordset);
	$num_paginas=($num_paginas/20)+1;
	settype($num_paginas,'integer');
	$pagina_fin=20*$pg;
	$pagina_ini=($pagina_fin-20);
	$sql_cont.=" LIMIT $pagina_ini, 20";
	$recordset=mysql_query($sql_cont);
$recordset_con=mysql_query($sql_cont);
echo '<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
		<thead>
			<tr><th colspan="17" align="center" background="images/main-button-tileR2.jpg" height="30">LISTA DE CONTRATOS</th></tr>';
		echo '<tr align="center">  
				<th width="25" class="menu" background="images/main-button-tileR2.jpg">Nro CONT</th>
				<th width="90" class="menu" height="25" background="images/main-button-tileR2.jpg">TIPO DE CONTRATO</th>
				<th width="15" class="menu" background="images/main-button-tileR2.jpg">CODIGO LEGAL </th>
				<th width="10" class="menu" background="images/main-button-tileR2.jpg">EMPRESA CONTRATADA</th>
				<th width="10" class="menu" background="images/main-button-tileR2.jpg">FECHA VENC.</th>
				<th width="10" class="menu" background="images/main-button-tileR2.jpg">MODIFICAR CONTRATO</th>
				<th width="15" class="menu" background="images/main-button-tileR2.jpg">VISTA IMPRESION</th>';
		echo '	<th width="10" class="menu" background="images/main-button-tileR2.jpg">EN EJECUCION</th>
				<th width="60" background="images/main-button-tileR2.jpg">CERRAR CONTRATO</th>
				<th width="17" class="menu" background="images/main-button-tileR2.jpg">AREA</th>
				<th width="17" class="menu" background="images/main-button-tileR2.jpg">ADJUNTAR ARCHIVOS</th>
			</tr>
		</thead><tbody>';

$cont_sol=0;
$cont_ven=0;
$cont_nosol=0;
if (mysql_num_rows($recordset_con)!=0){
	echo '<input type="hidden" value="'.mysql_num_rows($recordset_con).'" id="num_registros">';
	for ($i=1;$i<=mysql_num_rows($recordset_con);$i++){
		$row=mysql_fetch_array($recordset_con);
		
		$fechahoy = date('Y-m-d');
		if ($fechahoy < $row['FechAl'] AND $row['Cierre']=="0"){ $color="bgcolor=\"#00CC66\""; }   // VIGENTE
	elseif ($row['FechAl']<$fechahoy AND $row['Ejecucion']=="0" AND $row['Cierre']=="0") {$color="bgcolor=\"#FF6666\"";} // VENCIDO
	elseif ($row['FechAl']<$fechahoy AND $row['Ejecucion']=="1" AND $row['Cierre']=="0") {$color="bgcolor=\"#FFFF00\"";} //VENCIDO PERO EN EJECUCION
	elseif ($row['Cierre']=="1") {$color="bgcolor=\"#A5BBF5\"";} //EN CIERRE
	echo "<tr align=\"center\">";
	echo "<td ".$color.">&nbsp;$row[IdContra]</td>";
	echo "<td>&nbsp;$row[TipoContra]</td>";
	echo "<td>&nbsp;$row[CodLegalContra]</td>";
	echo "<td>&nbsp;".$lstProveedor[$row['PartCont']]."</td>";
	echo "<td>&nbsp;$row[FechAl2]</td>";
	if ($tipo=="A" or $tipo=="B")	
	{echo "<td><a href=\"contrato1_last.php?IdContra=".$row['IdContra']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></td>";}
	echo "<td><a href=\"ver_fichaleg.php?IdContra=".$row['IdContra']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";
	if ($row['Cierre']=="0")
	{	if ($row['FechAl'] >= $fechahoy)
		{echo "<td>VIGENTE</td>";
		 	if ($tipo=="A" or $tipo=="B") {echo "<td><a href=\"cerrar_contrato.php?IdContra=".$row['IdContra']."\">CERRAR</a></td>";
			 echo "<td>&nbsp;$row[area]</td>";
			 if ($row['file']==""){
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
				}
			else {
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}
			 
			 }
		 	else{echo "<td>SIN CIERRE</td>";
			 echo "<td>&nbsp;$row[area]</td>";
			 if ($row['file']==""){
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
		}
		else {
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}
			 }
			 
		 }
		else
		{	if ($row['Ejecucion']=="0")
				{if ($tipo=="A" or $tipo=="B")
					{echo "<td><a href=\"lista_contratos.php?IdContra=".$row['IdContra']."&Ejec=1\">EJECUTAR</a></td>";
					 echo "<td><a href=\"cerrar_contrato.php?IdContra=".$row['IdContra']."\">CERRAR</a></td>";
					 echo "<td>&nbsp;$row[area]</td>";
					 if ($row['file']==""){
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
		}
		else {
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}
					 
					 }
					 
				else{echo "<td><font color=\"#666666\">SIN EJECUCION</font></td>";
					 echo "<td>SIN CIERRE</td>";
					 echo "<td>&nbsp;$row[area]</td>";
					 if ($row['file']==""){
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
		}
		else {
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}
					 }}
			elseif ($row['Ejecucion']=="1")
				{if ($tipo=="A" or $tipo=="B")
					{echo "<td><a href=\"lista_contratos.php?IdContra=".$row['IdContra']."&Ejec=0\">QUITAR EJECUCION</a></td>";
					 echo "<td><a href=\"cerrar_contrato.php?IdContra=".$row['IdContra']."\">CERRAR</a></td>";
					 echo "<td>&nbsp;$row[area]</td>";
					 if ($row['file']==""){
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
		}
		else {
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}
					 }
				else{echo "<td>EN EJECUCION</td>";
					 echo "<td>SIN CIERRE</td>";
					 echo "<td>&nbsp;$row[area]</td>";
					 if ($row['file']==""){
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
		}
		else {
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}
					 }}
		}
	}
	elseif ($row['Cierre']=="1") {
		if ($row['FechAl'] >= $fechahoy)
		{echo "<td>SIN EJECUCION</td>";
		 	if ($tipo=="A" or $tipo=="B") {echo "<td><a href=\"lista_contratos.php?IdContra=".$row['IdContra']."&Cierre=0\">REESTABLECER CONTRATO</a></td>";
			}
		 	else{echo "<td>CERRADO</td>";}
		 }
		else
		{	if ($row['Ejecucion']=="0" OR $row['Ejecucion']=="1")
				if ($tipo=="A" or $tipo=="B")
					{echo "<td><font color=\"#666666\">SIN EJECUTAR</font></td>";
					 echo "<td><a href=\"lista_contratos.php?IdContra=".$row['IdContra']."&Cierre=0\">REESTABLECER CONTRATO</a></td>";
					  echo "<td>&nbsp;$row[area]</td>";
					  if ($row['file']==""){
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
		}
		else {
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}
					  }
				else{echo "<td><font color=\"#666666\">SIN EJECUCION</font></td>";
					 echo "<td><font color=\"#666666\">CERRADO</font></td>";
					  echo "<td>&nbsp;$row[area]</td>";
					  if ($row['file']==""){
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTAR</a></td>";
		}
		else {
			echo "<td><a href=\"contrato_file.php?id_contrato=$row[IdContra]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}
					  }
		}
	}
		
   }
	echo '</tbody></table><br><br>';
}
else{
	echo '<tbody><tr><td colspan="16" align="center"><h3>SIN RESULTADOS</h3></td></tr></tbody></table><br><br>';
}

/*PAGINACION*/
echo '<center><b><font size="2">Pagina(s): </br>';


if ($pg>20){
	echo '<a href="javascript:pag_lista(3,0);">Anterior,&nbsp</a>';
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
		echo '<a href="javascript:pag_lista(1,'.$i.');">'.$i.'</a>';
	}	
	if ($i!=$num_paginas)
		echo ',';
}
if ($i>20){
	echo '<a href="javascript:pag_lista(2,0)">&nbsp;Siguiente</a>';
}
/*FIN PAGINACION*/
echo "</br></br>";
//echo '<input type="button" value="NUEVO CONTRATO" onClick="window.location.href=\'contrato1.php\' ">';
echo '<button type="button" onClick="window.location.href=\'contrato1.php\'; window.location.href = \'#\'" target="_blank">NUEVO CONTRATO</button>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<button type="button" onclick="window.open(\'ver_contratos_resumen.php\'); window.location.href = \'#\'" target="_blank">RESUMEN GLOBAL</button>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
//echo '<input type="button" value="ESTADISTICAS"  onClick=" window.location.href=\'report_contratos.php\' ">';
echo '<button type="button" onclick="window.open(\'report_contratos.php\'); window.location.href = \'#\'" target="_blank">ESTADISTICAS</button>';
echo '</font></b></center><br>';
  echo '
  	<table width="85%" border="1" align="center">
  <tr> 
    <td width="16%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">CONTRATOS 
        VENCIDOS O CADUCADOS</font></div></td>
    <td width="6%" bgcolor="#FF6666">&nbsp;</td>
    <td width="6%">&nbsp;</td>
    <td width="16%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">CONTRATOS 
        VENCIDOS <strong>PERO</strong> EN EJECUCION</font></div></td>
    <td width="6%" bgcolor="#FFFF00">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="12%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">CONTRATOS 
        EN VIGENCIA</font></div></td>
    <td width="6%" bgcolor="#00CC66">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="11%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">CONTRATO 
        CERRADO </font></div></td>
    <td width="7%" bgcolor="#A5BBF5">&nbsp;</td>
  </tr>
</table>';
?>