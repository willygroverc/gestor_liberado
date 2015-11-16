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
if(isset($PARAMETROS)){
	header("location: parametros_dym.php");
}
require_once("funciones.php");
$tipo=$_SESSION['tipo'];
if (valida("DyM")=="bad") {header("location: pagina_error.php");}
include ("top.php");
?>
<script language="JavaScript">
<!--
function confirmLink(theLink, usuario)
{
    var is_confirmed = confirm("Ya no podra editar el registro : "+ usuario);
    if (is_confirmed) {
        theLink.href += '&accion=elimina';
    }
    return is_confirmed;
}
function confirmLink2(theLink, usuario)
{
    var is_confirmed = confirm("Ya no podra imprimir el registro : "+ usuario);
    if (is_confirmed) {
        theLink.href += '&accion=elimina';
    }
    return is_confirmed;
} // end of the 'confirmLink()' function
//-->
</script>
<?php 
if (isset($_GET['idprod'])) $idprod=($_GET['idprod']);
if (isset($_GET['impri'])) $impri=($_GET['impri']);
if ((isset($accion) && $accion=="elimina") && $impri==1){
	$sqla="UPDATE solicitud SET estado='1' WHERE OrdAyuda='$idprod'";
	mysql_query($sqla);
	$sqlb="UPDATE aprobus SET estado='1' WHERE OrdAyuda='$idprod'";
	mysql_query($sqlb);
	$sqlc="UPDATE implantus SET estado='1' WHERE OrdAyuda='$idprod'";
	mysql_query($sqlc);
}
if ((isset($accion) && $accion=="elimina") && $impri==0){

	$sqla="UPDATE solicitud SET estado='0' WHERE OrdAyuda='$idprod'";
	mysql_query($sqla);
	$sqlb="UPDATE aprobus SET estado='0' WHERE OrdAyuda='$idprod'";
	mysql_query($sqlb);
	$sqlc="UPDATE implantus SET estado='0' WHERE OrdAyuda='$idprod'";
	mysql_query($sqlc);
	
}

	include_once ("help.class.php");
	$help = new Help();
	$help->AddHelp("num","Numero de Orden de Mesa");
	print $help->ToHtml();
 ?>

<table width="95%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top">
		<table width="100%" height="66" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="9" background="windowsvista-assets1/main-button-tile.jpg" height="30">DESARROLLO Y MANTENIMIENTO</font></th>
        </tr>
        <tr align=\"center\"> 
		  <th class="menu" rowspan="2" width="5%" background="images/main-button-tileR2.jpg"><?php print $help->AddLink("num", "Nro ORD MESA"); ?></th>
		  <th class="menu" rowspan="2" background="images/main-button-tileR2.jpg">FECHA Y HORA</th>
  		  <th class="menu" rowspan="2" background="images/main-button-tileR2.jpg">INCIDENCIA</th>
  		  <th class="menu" colspan="3" background="images/main-button-tileR2.jpg">FORMULARIO DE CONTROL</th>
  		  <th class="menu" rowspan="2" width="8%" background="images/main-button-tileR2.jpg">ESTADO</th>
   		  <th class="menu" rowspan="2" width="9%" background="images/main-button-tileR2.jpg">VISTA DE IMPRESION</th>
        </tr>
        <tr align=\"center\"> 
          <th class="menu" background="images/main-button-tileR2.jpg">DATOS DE SOLICITUD</th>
  		  <th class="menu" background="images/main-button-tileR2.jpg">APROBACION</th>
  		  <th class="menu" background="images/main-button-tileR2.jpg">IMPLANTACION</th>
        </tr>
<?php
    $sql11 = "SELECT num_ord_pag FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1; $j=1;}
	else{$_pagi_actual = $_GET['pg']; $j=1;}

	$sql = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";
	$rs1=mysql_query($sql);
	$numAsig=0;
	while ($tmp=mysql_fetch_array($rs1))  
	{$sql10 = "SELECT area,asig FROM asignacion WHERE id_asig='$tmp[id_asig]'";
 	 $rsTmp=mysql_fetch_array(mysql_query($sql10));
	 if ($rsTmp['area']=="DyM")
	 {$numAsig++;}
	 }
	
    $_pagi_totalPags = ceil($numAsig / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

	$i=$_pagi_inicial+$j;
	$ii=$_pagi_inicial+$_pagi_cuantos;

	$uu=0;			

	$sql6 = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";
	$result6=mysql_query($sql6);
	while ($row6=mysql_fetch_array($result6)) 
	{
    $sql7 = "SELECT * FROM asignacion WHERE id_asig='$row6[id_asig]'";
    $result7=mysql_query($sql7);
    $row7=mysql_fetch_array($result7);
	if ($row7['area']=='DyM')
    {$uu=$uu+1;
    if ($i<=$ii and $uu>=$i){
	$sql1 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes WHERE id_orden='$row7[id_orden]'";
	$result1=mysql_query($sql1);
	$row1=mysql_fetch_array($result1);
	
	$sql2= "SELECT * FROM solicitud WHERE OrdAyuda='$row7[id_orden]'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	
	$sql3= "SELECT * FROM aprobus WHERE OrdAyuda='$row7[id_orden]'";
	$result3=mysql_query($sql3);
	$row3=mysql_fetch_array($result3);
	
	$sql4= "SELECT * FROM implantus WHERE OrdAyuda='$row7[id_orden]'";
	$result4=mysql_query($sql4);
	$row4=mysql_fetch_array($result4);
	
  	echo "<tr align=\"center\">";
	echo "<td><a href=\"ver_orden.php?id_orden=".$row1['id_orden']."\" target=\"_blank\">".$row1['id_orden']."</a></td>";
	echo "<td>$row1[fecha] $row1[time]</td>";
	echo "<td>$row1[desc_inc]</td>";
	if (!empty($row2['OrdAyuda']))
	{	if ($row2['estado']=="0")	
		{echo "<td><a href=\"llenadoUS_last.php?IdOrden=".$row1['id_orden']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Editable\"></a></td>";}
		elseif ($row2['estado']=="1")	
		{echo "<td><a href=ver_llenadou.php?IdOrden=".$row1['id_orden']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\"></a></td>";} //cambio tresssssssssssssssss
	}
	else
	{	echo "<td><a href=\"llenadoUS.php?IdFicha=".$row1['id_orden']."\"><img src=\"images/no3.gif\" border=\"0\" alt=\"Llenar\"></a></td>";
		echo "<td><img src=\"images/no2.gif\" border=\"0\"></td>";
		echo "<td><img src=\"images/no2.gif\" border=\"0\"></td>";
	}
	if (!empty($row3['OrdAyuda']))
	{	if ($row3['estado']=="0")	
		{echo "<td><a href=\"aprobUS_last.php?IdOrden=".$row1['id_orden']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Editable\"></a></td>";}
		elseif ($row3['estado']=="1")	
		{echo "<td><a href=ver_aprobus.php?NomResAp=".$row3['NombRespAp']."&FechResAp=".$row3['FechRespAp']."&NomUsRespAp=".$row3['NomUsRespAp']."&FechUsRespAp=".$row3['FechUsRespAp']."&ComCambAp=".$row3['ComCambAp']."&FechComAp=".$row3['FechComAp']." \" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\"></a></td>";}//cambiodossssssssssssss
	}
	elseif (!empty($row2['OrdAyuda']))
	{	echo "<td><a href=\"aprobUS.php?IdFicha=".$row1['id_orden']."\"><img src=\"images/no3.gif\" border=\"0\" alt=\"Llenar\"></a></td>";
		echo "<td><img src=\"images/no2.gif\" border=\"0\"></td>";
	}
	
	
	if (!empty($row4['OrdAyuda']))
	{	if ($row4['estado']=="0")	
		{echo "<td><a href=\"implantUS_last.php?IdOrden=".$row1['id_orden']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Editable\"></a></td>";}
		elseif ($row4['estado']=="1")	
		{echo "<td><a href=ver_implantus.php?IdOrden=$row1[id_orden]&NomCordCamb=".$row4['NomCordCamb']."&FechCordConf=".$row4['FechCordConf']."&ResuCordConf=".$row4[ResuCordConf]."&NomUsConf=".$row4[NomUsConf]."&FechUsConf=".$row4['FechUsConf']."&ResuUsConf=".$row4['ResuUsConf']." \" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\"></a></td>";}   //cambiooooooooooo
	}
	elseif (!empty($row3['OrdAyuda']))
	{	echo "<td><font size=\"1\"><a href=\"implantUS.php?IdFicha=".$row1['id_orden']."\"><img src=\"images/no3.gif\" border=\"0\" alt=\"Llenar\"></a></font></td>";}
	
	if ((!empty($row2['OrdAyuda'])) OR (!empty($row3['OrdAyuda'])) OR (!empty($row4['OrdAyuda'])))
	{	if ($row2['estado'] == "0" OR $row3['estado']=="0" OR $row4['estado']=="0")
		{echo "<td><a href=\"lista_mantenimiento.php?idprod=".$row1['id_orden']."&impri=1\" onClick=\"return confirmLink(this,'$row1[id_orden]')\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Editable\"></a></td>";}
		if ($row2['estado'] == "1" OR $row3['estado']=="1" OR $row4['estado']=="1")
		{echo "<td><a href=\"lista_mantenimiento.php?idprod=".$row1['id_orden']."&impri=0\" onClick=\"return confirmLink2(this,'$row1[id_orden]')\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Editable\"></a></td>";}
	}		
	else
	{  echo "<td><img src=\"images/editar.gif\" border=\"0\" alt=\"Editable\"></td>";}
	
	if ($row2['estado'] == "1" AND $row3['estado']=="1" AND $row4['estado']=="1")// hhhhhhhhhhhhh
	{ echo "<td><font size=\"1\"><a href=\"ver_llenadous.php?IdOrden=".$row1['id_orden']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";} 
	else	
	{ echo "<td><font size=\"1\"><img src=\"images/eliminar.gif\" border=\"0\" alt=\"No se puede imprimir\"></font></td>";}
		
	echo "</tr>";
	$i=$i+1;
}}}
?>
      </table></td>
  </tr>
</table>
<br>
<table width="85%" border="0" align="center">
  <tr> 
    <td> <div align="center"><strong><font size="2">Pagina(s) :&nbsp; 
        <?php
//La idea es pasar tambi�n en los enlaces las variables hayan llegado por url.
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

//La variable $_pagi_navegacion contendr� los enlaces a las p�ginas.
$_pagi_navegacion = '';

if ($_pagi_actual != 1){
	//Si no estamos en la p�gina 1. Ponemos el enlace "anterior"
	$_pagi_url = $_pagi_actual - 1;//ser� el numero de p�gina al que enlazamos
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."'>&laquo; Anterior</a>&nbsp;";
}
//Enlaces a numeros de p�gina:
for ($_pagi_i = 1; $_pagi_i<=$_pagi_totalPags; $_pagi_i++){//Desde p�gina 1 hasta ultima p�gina ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el numero de p�gina es la actual ($_pagi_actual). Se escribe el numero, pero sin enlace y en negrita.
        $_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
    }else{
		//Si es cualquier otro. Se escibe el enlace a dicho numero de p�gina.
        $_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."'>".$_pagi_i."</a>&nbsp;";
    }
}

if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la ultima p�gina. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual + 1;//ser� el numero de p�gina al que enlazamos
    $_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."'>Siguiente &raquo;</a>";
}
print $_pagi_navegacion;
//Hasta ac� hemos completado la "barra de navegacion"
?>
        </font></strong> <font size="2"><strong>&nbsp;</strong></font></div></td>
  </tr>
</table>