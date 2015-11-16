<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		06/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require_once("funciones.php");
if (valida("Clasificacion")=="bad") {header("location: pagina_error.php");}
if (isset($_REQUEST['RETORNAR'])){echo "<script type=\"text/javascript\">
           history.go(-2);
       </script>";}
if (isset($_REQUEST['NuevReg'])) {  require("conexion.php");
 		$sql5="SELECT MAX(id_infAST) AS Id FROM informacionast";
		$result5=mysql_query($sql5);
		$row5=mysql_fetch_array($result5);
		$r=$row5['Id']+1; 
		header("location: astfin.php?varia1=$r"); 
}
include ("top.php");
include_once ("help.class.php");
$help=new Help();
$help->AddHelp("num","Numero");
$help->AddHelp("tiempo","Tiempo de Retencion");
print $help->ToHtml();
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
<table width="85%" border="1" cellpadding="0" cellspacing="2" background="images/fondo.jpg">
        <tr> 
    <th colspan="7" background="windowsvista-assets1/main-button-tile.jpg" height="30px">CLASIFICACION DE LA INFORMACION MANEJADA</th>
        </tr>
        <tr align="center"> 
          <th width="5%" class="menu" background="images/main-button-tileR1.jpg"><?php print $help->AddLink("num", "Nro"); ?></th>
		   <th width="18%" class="menu" background="images/main-button-tileR1.jpg">TECNICO</th>
    <th width="25%" class="menu" background="images/main-button-tileR1.jpg">DESCRIPCION</th>
			 <th width="16%" class="menu" background="images/main-button-tileR1.jpg"><?php print $help->AddLink("tiempo", "TIEMPO DE RETEN."); ?></th>
			  <th width="13%" class="menu" background="images/main-button-tileR1.jpg">CONTROL</th>
	           <?php if ($tipo=="A" or $tipo=="B") {?>
			   <th width="8%" class="menu" background="images/main-button-tileR1.jpg">MODIFICAR</th>
             <?php }?>
			    <th width="9%" class="menu" background="images/main-button-tileR1.jpg">IMPRIMIR</th>
		</tr>
        <?php
	$sql11 = "SELECT num_ord_pag FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM informacionast";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

$sql = "SELECT * FROM informacionast ORDER BY id_infAST DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
$tiempo_ret=$row['tiempo_ret'].' '.$row['clas_tiempo'];
  	echo '<tr align="center">';
	echo '<td><font size="1">&nbsp;'.$row['id_infAST'].'</font></td>';
	$sql2 = "SELECT * FROM users WHERE login_usr='".$row['tecnico']."'";
	$result2 = mysql_query($sql2);
	$row2 = mysql_fetch_array($result2); 
	echo '<td align="center"><font size="1">&nbsp;'.$row2['nom_usr'].' '.$row2['apa_usr'].' '.$row2['ama_usr'].'</font></td>';
	echo '<td><font size="1">&nbsp;'.$row['des_infAST'].'</font></td>';
	echo '<td><font size="1">&nbsp;'.$tiempo_ret.'</td>';
	echo '<td><font size="1">&nbsp;'.$row['control'].'</font></td>';
	if ($tipo=="A" or $tipo=="B")
	{echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"astmod.php?id_infAST=".$row['id_infAST']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";}
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"ver_asfin.php?variable=".$row['id_infAST']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
	echo "</tr>";
}
?>
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
<form action="" method="get" onKeyPress="return Form()"> 
   <div align="center">
  <input name="NuevReg" type="submit" value="NUEVO REGISTRO">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input name="IMPRIMIR" type="button" id="IMPRIMIR" value="IMPRIMIR" onClick="openStat_1()">
  </div>
</form>
<script language="JavaScript">
<!--
<?php
if(isset($msg)) print "alert(\"$msg\\n\\nMensaje generado por GesTor F1.\");"?>
function openStat_1() {	
	window.open('impresion_ast.php','AST', 'width=600,height=160,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
-->
</script>