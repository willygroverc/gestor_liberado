<?php
///Descripcion=Archivo modificado para el acceso a los usuarios mediante roles
///Autor: Alvaro Rodriuguez
//Fecha: 30/08/2012
//__________________________________________________________________________________
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
require("conexion.php");
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

require_once("funciones.php");
if (valida("Telkey")=="bad") {header("location: pagina_error.php");}
if (isset($RETORNAR)){header("location: lista_produccion.php?Naveg=Produccion");}
//if ($IMPRIMIR){header("location: ver_lista_sistemas.php");}
if (isset($NSISTEMA)){
		$sql3="SELECT MAX(Idtelkey) AS ID FROM telkey";
		$result3=mysql_query($sql3);
		$row3=mysql_fetch_array($result3);
		$r=$row3[ID]+1; 
        header("location: telkey.php?varia1=$r");
}

include ("top.php");
echo "<p>";
echo "&nbsp;";
echo "</p>";
?>
<?php 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero");
	/*$help->AddHelp("tipo","Tipo de Cliente... A:admin, T:tecnico, C:cliente");
	$help->AddHelp("conf","Conformidad de ...");
	$help->AddHelp("solu","Solucion a las ordenes de trabajo ...");
	$help->AddHelp("incidencia","Incidencia se refiere a...");*/
	print $help->ToHtml();
 ?>
<table width="95%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699">
  <tr> 
    <td height="68" valign="top">
	<table width="100%" height="73" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="12" background="images/main-button-tileR2.jpg">LISTADO DE TELKEYS</th>
        </tr>
        
        <tr align=\"center\">
          <th width="5%" background="images/main-button-tileR1.jpg" class="menu"><?php print $help->AddLink("num", "Nro."); ?></th>
          <th background="images/main-button-tileR1.jpg" class="menu"><div align="center">NOMBRE RESPONSABLE</div></th>
          <th background="images/main-button-tileR1.jpg" class="menu"><div align="center">NOMBRE CUENTA</div></th>
          <th background="images/main-button-tileR1.jpg" class="menu">TIPO DE CUENTA</th>
          <th background="images/main-button-tileR1.jpg" class="menu">SISTEMA</th>
          <th background="images/main-button-tileR1.jpg" class="menu">FECHA DE ENTRADA </th> 
          <th height="21" background="images/main-button-tileR1.jpg" class="menu"><div align="center">FECHA DE RETIRO</div></th>
          <th background="images/main-button-tileR1.jpg" class="menu"><div align="center">NOMBRE REMMPLAZO</div></th>
          <th background="images/main-button-tileR1.jpg" class="menu"><div align="center">OBSERVACIONES</div></th>
          <th width="8%" background="images/main-button-tileR1.jpg" class="menu"><div align="center">MODIFICAR 
          </div></th>
          <th width="9%" background="images/main-button-tileR1.jpg" class="menu"><div align="center">IMPRIMIR</div></th>
        </tr>
        <?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM telkey";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

$sql = "SELECT * FROM telkey ORDER BY Idtelkey DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) {

  	echo "<tr align=\"center\">";
	echo "<td>&nbsp;$row[Idtelkey]</td>";
	echo "<td>&nbsp;$row[Responsable]</td>";
	echo "<td>&nbsp;$row[Cuenta]</td>";
	echo "<td>&nbsp;$row[Tipo]</td>";
	echo "<td>&nbsp;$row[Sistema]</td>";
	echo "<td>&nbsp;$row[Fechaen]</td>";
	echo "<td>&nbsp;$row[Fechare]</td>";
	echo "<td>&nbsp;$row[Reemplazo]</td>";	
	echo "<td>&nbsp;$row[Observaciones]</td>";  
	if ($tipo=="A" or $tipo=="B")
	{echo "<td>&nbsp;<a href=\"telkey_last.php?Idtelkey=".$row['Idtelkey']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></td>";}
	echo "<td>&nbsp;<a href=\"ver_telkey.php?variable=".$row['Idtelkey']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";
	echo "</tr>";

	echo "</tr>";
}

?>
      </table></td>
  </tr>
</table>
<br>
<table width="75%" border="0" align="center">
  <tr>
    <td><div align="center"><strong><font size="2">Pagina(s) :&nbsp; 
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
        &nbsp;</font></strong></div></td>
  </tr>
</table>
<br>
<form name="form1" method="post" action="">
    <input type="submit" name="NSISTEMA" value="NUEVO TELKEY">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <input name="IMPRIMIR" type="submit" id="IMPRIMIR" value="IMPRIMIR TODO" onClick="pagina()">
</form>

<script language="JavaScript">
<!--
function pagina() {
	window.open("ver_lista_telkey.php");
}
function openStat_5() {
	window.open("report_sistemas.php",'Estad�sticas', 'width=600,height=320,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
-->
</script>
