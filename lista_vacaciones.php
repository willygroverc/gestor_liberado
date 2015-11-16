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
require_once("funciones.php");
if (valida("Vacaciones")=="bad") {header("location: pagina_error.php");}
if (isset($_REQUEST['RETORNAR'])){echo "<script type=\"text/javascript\">
           history.go(-2);
       </script>";}
if (isset($_REQUEST['NueCalend']))
{ 	require("conexion.php");
	$sql5="SELECT MAX(id_vacac) AS Id FROM vacaciones";
	$result5=mysql_query($sql5);
	$row5=mysql_fetch_array($result5);
	$r=$row5['Id']+1; 
	header("location: vacaciones.php?varia=$r&varia1=$r");
}
include ("top.php");
?> 
<table width="85%"border="0" cellpadding="0" cellspacing="0" bordercolor="#006699">
  <tr> 
    <td height="68" valign="top">
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="7" background="images/main-button-tileR1.jpg" height="20">LISTA DE FECHAS DE AUSENCIA PROGRAMADA</th>
        </tr>
        <tr align="center"> 
		  <th class="menu" background="images/main-button-tileR1.jpg" height="20">NOMBRE</th>
	  	  <th class="menu" background="images/main-button-tileR1.jpg">ESTADO</th>
	  	  <th class="menu" background="images/main-button-tileR1.jpg">FECHA INICIO</th>
	  	  <th class="menu" background="images/main-button-tileR1.jpg">FECHA FINAL</th>
	  	  <th class="menu" background="images/main-button-tileR1.jpg">SEGUIMIENTO</th>
	  	  <th class="menu" background="images/main-button-tileR1.jpg">IMPRIMIR</th>
<?php if(isset($tipo) && $tipo=="A"){?> <th class="menu">MODIFICAR</th><?php }?>
        </tr>
        <?php
    $sql11 = "SELECT num_ord_pag FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$sqlin1="SELECT max(id_vacac) AS maxi FROM vacaciones WHERE estado='Realizado' GROUP BY nombre";
	$resin1=mysql_query($sqlin1);
	$lst='NULL';
	while($rowin1=mysql_fetch_array($resin1)){
		$lst=$lst.", '".$rowin1['maxi']."'";
	}
	$lst=str_replace('NULL,',' ', $lst);
	
	$sqlin="SELECT * FROM vacaciones WHERE estado='Realizado' AND id_vacac NOT IN ($lst)";
	$resin=mysql_query($sqlin);
	$lista='NULL';
	while($rowin=mysql_fetch_array($resin)){
		$lista=$lista.", '".$rowin['id_vacac']."'";
	}
	$lista=str_replace('NULL,',' ', $lista);

	$_pagi_sqlConta = "select count(*) as pagi_totalReg from vacaciones where id_vacac NOT IN ($lista)";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
	$fechahoy=date("Y-m-d");
	$sql = "SELECT *, DATE_FORMAT(fecha_del, '%d/%m/%Y') AS fecha_del2, DATE_FORMAT(fecha_al, '%d/%m/%Y') AS fecha_al2 FROM vacaciones"; 
	$result=mysql_query($sql);
	while ($row=mysql_fetch_array($result)){
		$sql2 = "SELECT * FROM vacaciones WHERE id_vacac='".$row['id_vacac']."' AND estado='Realizado'";
		$result2=mysql_query($sql2);
		$row2=mysql_fetch_array($result2);	
		if (!$row2['estado'])
		{	if ($row['fecha_al'] >= $fechahoy)   // VIGENTE
			{$color="bgcolor=\"#00CC00\"";}
			else if ($row['fecha_al'] < $fechahoy) // VENCIDO
			{$color="bgcolor=\"#FF6666\"";}
			echo "<tr align=\"center\">";
			  $sql5 = "SELECT * FROM users WHERE login_usr='".$row['Nombre']."'";
			  $result5 = mysql_query($sql5);
			  $row5 = mysql_fetch_array($result5);
			echo "<td ".$color."><font size=\"1\"><a href=\"vacaciones_resumen.php?Nombre=".$row['Nombre']."\">".$row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr']."</a></font></td>";
			echo '<td><font size="1">'.$row['estado'].'</td>';
			echo '<td><font size="1">'.$row['fecha_del2'].'</font></td>';
			echo '<td><font size="1">'.$row['fecha_al2'].'</font></td>';	
			echo '<td><font size="1"><a href="vacaciones_last.php?id_vacac='.$row['id_vacac'].'&Nombre='.$row['Nombre'].'">REALIZACION</a></font></td>';
			echo '<td><font size="1"><a href="ver_vacacionresumen.php?Nombre='.$row['Nombre'].'" target="_blank"><img src="images/imprimir.gif" border="0" alt="Imprimir"></a></font></td>';
			if(isset($tipo)&& $tipo=="A") 
				echo "<td><font size=\"1\"><a href=\"modif_vacaciones.php?id_vacac=".$row['id_vacac']."&Nombre=".$row['Nombre']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
			echo "</tr>";
		}else{
			$color="bgcolor=\"#FFFF00\"";	
			echo "<tr align=\"center\">";
			  $sql6 = "SELECT * FROM users WHERE login_usr='".$row['Nombre']."'";
			  $result6 = mysql_query($sql6);
			  $row6 = mysql_fetch_array($result6);
			echo "<td ".$color."><font size=\"1\"><a href=\"vacaciones_resumen.php?Nombre=".$row['Nombre']."\">".$row6['nom_usr']." ".$row6['apa_usr']." ".$row6['ama_usr']."</a></font></td>";
			echo '<td><font size="1">'.$row['estado'].'</td>';
			echo '<td><font size="1">'.$row['fecha_del'].'</font></td>';
			echo '<td><font size="1">'.$row['fecha_al'].'</font></td>';	
			echo '<td><font size="1">LLENADO</font></td>';
			echo '<td><font size="1"><a href="ver_vacacionresumen.php?Nombre='.$row['Nombre'].'" target="_blank"><img src="images/imprimir.gif" border="0" alt="Imprimir"></a></font></td>';			
			if(isset ($tipo) && $tipo=="A") 
				echo "<td><font size=\"1\"><img src=\"images/eliminar.gif\" border=\"0\" alt=\"No se puede Modificar\"></font></td>";
			echo "</tr>";}
		}
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
<form name="form1" method="get" action="">
  <div align="center">
    <input name="NueCalend" type="submit" value="PLANIFICAR AUSENCIA PROGRAMADA">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="IMPRIMIR" value="IMPRIMIR REPORTE" onClick="pagina()">
  </div>
</form>
<table width="80%" border="1" align="center">
  <tr> 
    <td width="16%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">PLANIFICACION 
        VENCIDA </font></div></td>
    <td width="8%" bgcolor="#FF6666">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="17%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">PLANIFICACION 
        VIGENTE</font></div></td>
    <td width="8%" bgcolor="#00CC00">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="23%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">REALIZACION 
        Y PLANIFICACION REALIZADA</font></div></td>
    <td width="7%" bgcolor="#FFFF00">&nbsp;</td>
  </tr>
</table>
<script language="JavaScript">
<!--
function pagina() {
	window.open("ver_vacaciones.php");
}
-->
</script>