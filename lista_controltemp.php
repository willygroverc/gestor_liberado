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
require_once("funciones.php");
if (valida("ControlTyH")=="bad") {header("location: pagina_error.php");}
//if (isset($RETORNAR)){header("location: lista_produccion.php?Naveg=Produccion");}
//if ($IMPRIMIR){header("location: ver_lista_controltemp.php");}
if (isset($_REQUEST['NuevReg']))
{  	require("conexion.php");
		$sql5="SELECT MAX(numero) AS num FROM controltemp";
		$result5=mysql_query($sql5);
		$row5=mysql_fetch_array($result5);
		$r=$row5['num']+1; 
	header("location: controltemp.php?varia1=$r"); }
include ("top.php");
?>
<?php 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero");
	print $help->ToHtml();
 ?>

<table width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699">
  <tr> 
    <td height="68" valign="top">
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="7" background="windowsvista-assets1/main-button-tile.jpg" height="30">CONTROL DE TEMPERATURA Y HUMEDAD RELATIVA</font></th>
        </tr>
        <tr align=\"center\"> 
		  <th class="menu" height="20" background="images/main-button-tileR1.jpg"><?php print $help->AddLink("num", "Nro"); ?></th>
	  	  <th class="menu" background="images/main-button-tileR1.jpg">FECHA</th>
	  	  <th class="menu" background="images/main-button-tileR1.jpg">TEMPERATURA &deg;C</th>
	  	  <th class="menu" background="images/main-button-tileR1.jpg">HUMEDAD %</th>
	  	  <th class="menu" background="images/main-button-tileR1.jpg">NOMBRE DEL RESPONSABLE</th>
          <?php if ($tipo=="A" or $tipo=="B") {?>
	  	  <th class="menu" background="images/main-button-tileR1.jpg">MODIFICAR</th>
  		  <?php } ?>
	  	  <th class="menu" background="images/main-button-tileR1.jpg">IMPRIMIR</th>
        </tr>
        <?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM controltemp";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM controltemp ORDER BY numero DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">&nbsp;$row[numero]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[fecha]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[temperatura]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[hr]</font></td>";
	$sql2 = "SELECT * FROM users WHERE login_usr='$row[nombresp]'";
	$result2 = mysql_query($sql2);
	$row2 = mysql_fetch_array($result2); 
	echo "<td><font size=\"1\">&nbsp;$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]</font></td>";
	if ($tipo=="A" or $tipo=="B")
	{echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"controltemp_last.php?numero=".$row['numero']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";}
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"ver_controltemp.php?variable=".$row['numero']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
	echo "</tr>";
}

?>
      </table></td>
  </tr>
</table>

 
&nbsp; 
<table width="75%" border="0" align="center">
  <tr>
    <td><div align="center"><font size="2"> <strong>Pagina(s) : &nbsp; 
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
        </strong></font> </div>
      <div align="center">&nbsp;</div></td>
  </tr>
</table>
<form action="" method="get"> 
   <div align="center">
  <input name="NuevReg" type="submit" value="NUEVO REGISTRO">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="ESTADISTICAS" type="button" id="ESTADISTICAS" value="ESTADISTICAS" onClick="openStat_4()">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input type="button" name="IMPRIMIR" value="IMPRIMIR TODO" onClick="pagina()">
    &nbsp;&nbsp;&nbsp;&nbsp; 
    <!--<input type="submit" name="RETORNAR" value="RETORNAR">-->
  </div>
</form>
<script language="JavaScript">
<!--
function pagina() {
	window.open("ver_lista_controltemp.php");
}
function openStat_4() {
	window.open("report_control_temp.php",'Estad�sticas', 'width=400,height=295,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
-->
</script>