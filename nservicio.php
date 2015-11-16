<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

if (isset($_REQUEST['Terminar'])) 
	header
	("location: actividades_pre_last.php?tip=$varia2&varia2=$varia2&numer=$NumPlanif&ObjNegocio=$objnegocioaux&actividad=1");	
  $login=$_SESSION["login"];

require_once("funciones.php");
require("conexion.php");
if (valida("Ans")=="bad") {header("location: pagina_error.php");}
if (isset($_REQUEST['RETORNAR'])){echo "<script type=\"text/javascript\">
           history.go(-2);
       </script>";}
if (isset($_REQUEST['NAcuerdo']))	{ 
		$sql5="SELECT MAX(id_servi) AS Id FROM nivservicio";
		$result5=mysql_query($sql5);
		$row5=mysql_fetch_array($result5);
		$r=$row5['Id']+1; 
	    $r2="tec";
		$r3=md5($r2);
		    header("location: nivservicio.php?varia1=$r&varia2=$r3");
}
if (isset($_REQUEST['ANS_prov']))	{ 
		$sql5="SELECT MAX(id_servi) AS Id FROM nivservicio";
		$result5=mysql_query($sql5);
		$row5=mysql_fetch_array($result5);
		$r=$row5['Id']+1; 
		$r2="prov";
		$r3=md5($r2);
	        header("location: nivservicio.php?varia1=$r&varia2=$r3");
}
include ("top.php");
include_once ("help.class.php");
$help=new Help();
$help->AddHelp("num","Numero");
print $help->ToHtml();
?>
<table width="95%" border="0" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="2">
        <tr> 
          <th colspan="7" background="windowsvista-assets1/main-button-tile.jpg" height="30px">ACUERDO DE NIVEL DE SERVICIO</th>
        </tr>
        <tr> 
          <th width="5%" class="menu" background="windowsvista-assets1/main-button-tile.jpg" height="30px"><?php print $help->AddLink("num", "Nro"); ?></th>
		  <th width="12%" class="menu" background="windowsvista-assets1/main-button-tile.jpg" height="30px">TECNICO / PROVEEDOR</th>
  		  <th width="22%" class="menu" background="windowsvista-assets1/main-button-tile.jpg" height="30px">DESCRIPCION</th>
  		  <th width="12%" class="menu" background="windowsvista-assets1/main-button-tile.jpg" height="30px">CLIENTE</th>
  		  <th width="10%" class="menu" background="windowsvista-assets1/main-button-tile.jpg" height="30px">VIGENCIA</th>
           <?php if ($tipo=="A" || $tipo=="B") {?>
  		  <th width="8%" class="menu" background="windowsvista-assets1/main-button-tile.jpg" height="30px">MODIFICAR</th>
 		   <?php }?>
  		  <th width="8%" class="menu" background="windowsvista-assets1/main-button-tile.jpg" height="30px">IMPRIMIR</th>
        </tr>
        <?php
	$sql11 = "SELECT num_ord_pag FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}
	
if ($tipo=="A" || $tipo=="B")
{
    $_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM nivservicio";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

    $sql = "SELECT *, DATE_FORMAT(vigencia, '%d/%m/%Y') AS vigencia FROM nivservicio ORDER BY id_servi DESC LIMIT $_pagi_inicial,$_pagi_cuantos";}
else  
{
    $_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM nivservicio WHERE tecnico='$login'";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

    $sql = "SELECT *, DATE_FORMAT(vigencia, '%d/%m/%Y') AS vigencia FROM nivservicio WHERE tecnico='$login' ORDER BY id_servi DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
} 
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
  	echo "<tr align=\"center\">";
	echo "<td>&nbsp;".$row['id_servi']."</td>";
		$sql5 = "SELECT * FROM users WHERE login_usr='".$row['tecnico']."'";
	    $result5 = mysql_query($sql5);
	    $row5 = mysql_fetch_array($result5);
	if (!empty($row5))
	{echo '<td>&nbsp;'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';
	 $r2="tec";
	 $r3=md5($r2);}
	else
	{$sql5 = "SELECT * FROM proveedor WHERE IdProv='".$row['tecnico']."'";
	 $result5 = mysql_query($sql5);
	 $row5 = mysql_fetch_array($result5);
	 echo "<td>&nbsp;".$row5['NombProv']."</td>";
	 $r2="prov";
	 $r3=md5($r2);}
	echo "<td>&nbsp;".$row['desc_ser']."</td>";
	echo "<td>&nbsp;".$row['clie_ser']."</td>";
	echo "<td>&nbsp;".$row['vigencia']."</td>";
	if ($tipo=="A" || $tipo=="B")
{	echo "<td><a href=\"nivservicio_mod.php?IdServi=".$row['id_servi']."&varia2=".$r3."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></td>";}
	echo "<td><a href=\"ver_nivservicio.php?variable=".$row['id_servi']."&varia2=".$r3."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";
	echo "</tr>";
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
<form action="" method="post">
  <div align="center">
    <input type="submit" name="NAcuerdo" value="NUEVO ACUERDO - TECNICO">
    &nbsp;&nbsp;&nbsp; 
    <?php if ($tipo=="A" || $tipo=="B") {?>
	<input type="submit" name="ANS_prov" value="NUEVO ACUERDO - PROVEEDOR">
    &nbsp;&nbsp;&nbsp; 
	<?php } ?>
    <input name="IMPRIMIR" type="button" id="IMPRIMIR" value="    IMPRIMIR    " onClick="openStat_1()">
    
  </div>
</form> 
<script language="JavaScript">
<!--
<?php
if(isset($msg)) print "alert(\"$msg\\n\\nMensaje generado por GesTor F1.\");"?>
function openStat_1() {	
	window.open("impresion_ans.php",'ANS', 'width=580,height=160,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
-->
</script>