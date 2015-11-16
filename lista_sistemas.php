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
if (valida("PropyResp")=="bad") {header("location: pagina_error.php");}
//if (isset($RETORNAR)){header("location: lista_produccion.php?Naveg=Produccion");}
//if ($IMPRIMIR){header("location: ver_lista_sistemas.php");}
if (isset($_REQUEST['NSISTEMA'])){
		require("conexion.php");
		$sql3="SELECT MAX(Id_Sistema) AS ID FROM sistemas";
		$result3=mysql_query($sql3);
		$row3=mysql_fetch_array($result3);
		$r=$row3['ID']+1; 
        header("location: sistema.php?varia1=$r");
}

include ("top.php");
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
          <th colspan="8" background="images/main-button-tileR1.jpg" height="22">LISTADO DE PROPIETARIOS Y RESPONSABLES DE SISTEMAS</th>
        </tr>
        <tr align="center"> 
          <th rowspan="2" class="menu" width="5%" background="images/main-button-tileR2.jpg"><?php print $help->AddLink("num", "Nro."); ?></th>
          <th rowspan="2" class="menu" background="images/main-button-tileR2.jpg"><div align="center">SISTEMA</div></th>
          <th rowspan="2" class="menu" background="images/main-button-tileR2.jpg"><div align="center">TIPO</div></th>
          <th class="menu" background="images/main-button-tileR1.jpg"><div align="center">UNIDAD DE SISTEMAS</div></th>
          <th  class="menu" colspan="2" background="images/main-button-tileR1.jpg"><div align="center">DUENO</div></th>
          <?php if ($tipo=="A" or $tipo=="B") {?>
          <th rowspan="2" class="menu" width="8%" background="images/main-button-tileR2.jpg"><div align="center">MODIFICAR 
            </div></th>
          <?php }?>
          <th rowspan="2" class="menu" width="9%" background="images/main-button-tileR2.jpg"><div align="center">IMPRIMIR</div></th>
        </tr>
        <tr align=\"center\"> 
          <th height="21" class="menu" background="images/main-button-tileR1.jpg"><div align="center">TITULAR</div></th>
          <th class="menu" background="images/main-button-tileR1.jpg"><div align="center">AREA</div></th>
          <th class="menu" background="images/main-button-tileR1.jpg"><div align="center">TITULAR</div></th>
        </tr>
        <?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM sistemas";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

$sql = "SELECT * FROM sistemas ORDER BY Id_Sistema DESC LIMIT $_pagi_inicial,$_pagi_cuantos";

$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) {

  	echo "<tr align=\"center\">";
	echo "<td>&nbsp;$row[Id_Sistema]</td>";
	echo "<td>&nbsp;$row[Descripcion]</td>";
	echo "<td>&nbsp;$row[Id_Tipo]</td>";
		  $sql5 = "SELECT * FROM users WHERE login_usr='$row[Titular1]'";
		  $result5 = mysql_query($sql5);
		  $row5 = mysql_fetch_array($result5);
	echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
	echo "<td>&nbsp;$row[Area]</td>";
		  $sql5 = "SELECT * FROM users WHERE login_usr='$row[Titular2]'";
		  $result5 = mysql_query($sql5);
		  $row5 = mysql_fetch_array($result5);
	echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
	if ($tipo=="A" or $tipo=="B")
	{echo "<td>&nbsp;<a href=\"sistema_last.php?IdSistema=".$row['Id_Sistema']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></td>";}
	echo "<td>&nbsp;<a href=\"ver_sistema.php?variable=".$row['Id_Sistema']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";
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
    <input type="submit" name="NSISTEMA" value="NUEVO SISTEMA">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input name="ESTADISTICAS" type="submit" id="ESTADISTICAS" value="ESTADISTICAS" onClick="openStat_5()">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <input name="IMPRIMIR" type="submit" id="IMPRIMIR" value="IMPRIMIR TODO" onClick="pagina()">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <!--<input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">-->
</form>
<script language="JavaScript">
<!--
function pagina() {
	window.open("ver_lista_sistemas.php");
}
function openStat_5() {
	window.open("report_sistemas.php",'Estad�sticas', 'width=600,height=320,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
-->
</script>
