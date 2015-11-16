<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		17/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require_once("funciones.php");
if (valida("Planificacion")=="bad") {header("location: pagina_error.php");}
if (isset($RETORNAR))
{
	echo "<script type=\"text/javascript\">
           history.go(-2);
       </script>";
}
if (isset($NUEVO)){ header("location: planifpru.php");}
include ("top.php");
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero de Orden de Mesa");
	print $help->ToHtml();
 ?>
<table width="90%" height="68" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top"><table width="100%" height="66" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="6" background="windowsvista-assets1/main-button-tile.jpg" height="30">LISTA DE PLANIFICACION DE PRUEBAS</font></th>
        </tr>
		<tr align=\"center\"> 
		<th width="7%" class="menu" background="images/main-button-tileR2.jpg"><?php print $help->AddLink("num", "N�ORD. DE MESA"); ?></th>
		<th width="20%" class="menu" background="images/main-button-tileR2.jpg">FECHA Y HORA</th>
		<th width="56%" class="menu" background="images/main-button-tileR2.jpg">INCIDENCIA</th>
		  <th width="12%" class="menu" background="images/main-button-tileR2.jpg">PLANIFICACION DE PRUEBAS</th>
        <?php if ($tipo=="A" or $tipo=="B") {?>
		  <th width="8%" class="menu" background="images/main-button-tileR2.jpg">MODIFICAR PLANIFICACION</th>
          <?php } ?>         
		<th width="9%" class="menu" background="images/main-button-tileR2.jpg">IMPRIMIR</th>
        </tr>
        <?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(distinct(id_orden)) AS pagi_totalReg FROM `asignacion` where area='CONTINGENCIA' ORDER BY id_orden";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
			
$sql6 = "SELECT * FROM `asignacion` where area='CONTINGENCIA' GROUP BY id_orden ORDER BY id_orden DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
$result6=mysql_query($sql6);
while ($row6=mysql_fetch_array($result6)) {

$sql= "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes WHERE id_orden='$row6[id_orden]' ";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);

$sql5= "SELECT * FROM resulpru WHERE ordayuda='$row[id_orden]' ";
$result5=mysql_query($sql5);
$row5=mysql_fetch_array($result5);

$sql4= "SELECT *, DATE_FORMAT(fecplanif, '%d/%m/%Y') AS fecplanif FROM planprueba WHERE ordAyuda='$row[id_orden]' ";
$result4=mysql_query($sql4);
$row4=mysql_fetch_array($result4);

  	echo '<tr align="center">';
	echo '<td><font size="1" face="Arial, Helvetica, sans-serif"><a href="ver_orden.php?id_orden='.$row['id_orden'].'" target="_blank">'.$row['id_orden'].'</a></font></td>';
	echo '<td><font size="1">'.$row['fecha'].' '.$row['time'].'</font></td>';
	echo '<td><font size="1">'.@$row['desc_inc'].'</td>';

	if (empty($row4['ordayuda']))
	{	echo "<td><font size=\"1\"><a href=\"planifpru.php?idplanpru=".$row['id_orden']."\">LLENAR</a></font></td>";}
	else
	{	echo "<td><font size=\"1\">$row4[fecplanif]</font></td>";}
 if ($tipo=="A" or $tipo=="B") 
{	if (!$row4['ordayuda'])
	{	echo "<td><font size=\"1\">NO MODIFICABLE</font></td>";}
	if ($row4['ordayuda'])
	{	echo "<td><font size=\"1\"><a href=\"planifpru_last1.php?idplanpru=".$row['id_orden']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";}}
	if ($row4['ordayuda'])
	{	echo "<td><font size=\"1\"><a href=\"ver_planifpru.php?variable=".$row['id_orden']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";}	
	if (!$row4['ordayuda'])
	{	echo "<td><font size=\"1\">IMPRIMIR</font></td>";}	

  echo "</tr>";
}
?>
      </table></td>
  </tr>
</table>

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
<br>
<form name="form1" method="post" action="">
  <div align="center">
    <input type="submit" name="RETORNAR" value="RETORNAR">
  </div>
</form>