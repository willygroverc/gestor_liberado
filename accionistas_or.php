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
require("conexion.php");
if (valida("Accion")=="bad") {header("location: pagina_error.php");}
if (isset($RETORNAR)){echo "<script type=\"text/javascript\">
           history.go(-2);
       </script>";}
if (isset($NAccionista))	{ 
		    header("location: naccionista.php");
}
if (isset($ANS_prov))	{ 
		$sql5="SELECT MAX(id_servi) AS Id FROM nivservicio";
		$result5=mysql_query($sql5);
		$row5=mysql_fetch_array($result5);
		$r=$row5[Id]+1; 
		$r2="prov";
		$r3=md5($r2);
	        header("location: nivservicio.php?varia1=$r&varia2=$r3");
}
include ("top.php");
include_once ("help.class.php");
$help=new Help();
$help->AddHelp("num","Numero");
print $help->ToHtml();
if (isset($flag) && $flag==1) $flag=0;
else $flag=1;
?>
<table width="75%" border="0" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="2">
        <tr> 
          <th colspan="14" background="windowsvista-assets1/main-button-tile.jpg" height="30px">REGISTRO DE ACCIONES </th>
        </tr>
        <tr>
          <th class="menu" height="20" background="images/main-button-tileR1.jpg">ESTADO</th> 
          <th class="menu" height="20" background="images/main-button-tileR1.jpg"><a class="menu" href="accionistas.php?ord_tab=nom_acc&flag=<?phpecho $flag;?>">NOMBRE / RAZON SOCIAL</a></th>
  		  <th class="menu" height="20" background="images/main-button-tileR1.jpg"><a class="menu" href="accionistas.php?ord_tab=num&flag=<?phpecho $flag;?>">ACCIONES</a></th>
  		  <th class="menu" height="20" background="images/main-button-tileR1.jpg"><a class="menu" href="accionistas.php?ord_tab=num&flag=<?phpecho $flag;?>">% ACCIONARIO </a></th>
		  <th class="menu" height="20" background="images/main-button-tileR1.jpg"><a class="menu" href="accionistas.php?ord_tab=mont&flag=<?phpecho $flag;?>">MONTO TOTAL</a></th>
  		  <th class="menu" height="20" background="images/main-button-tileR1.jpg">MODIFICAR</th>
		  <th class="menu" height="20" background="images/main-button-tileR1.jpg">IMPRIMIR</th>
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
    $_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM accionistas";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
if(!isset($ord_tab)) $ali='DESC';
elseif($flag==1) $ali='DESC';
else $ali='ASC';

if(!isset($ord_tab)) $ord_tab='id_acc';
    $sql = "SELECT a.*, DATE_FORMAT(fecha_acc, '%d/%m/%Y') AS fecha_acc, SUM(b.num_ac) AS num, SUM(b.valor_ac) AS mont FROM accionistas a, acciones b WHERE a.id_acc=b.id_acc GROUP BY b.id_acc ORDER BY $ord_tab $ali LIMIT $_pagi_inicial,$_pagi_cuantos";
	//$sql = "SELECT a.*, DATE_FORMAT(fecha_acc, '%d/%m/%Y') AS fecha_acc FROM accionistas a WHERE a.id_acc='4' GROUP BY a.id_acc ORDER BY id_acc DESC LIMIT 0,30 ";
	//echo $sql; 
	}
else  
{
    $_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM accionistas";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
if(!$ord_tab) $ord_tab='id_acc';
    $sql = "SELECT a.*, DATE_FORMAT(fecha_acc, '%d/%m/%Y') AS fecha_acc, SUM(b.num_ac) AS num FROM accionistas a, acciones b WHERE a.id_acc=b.id_acc GROUP BY b.id_acc ORDER BY $ord_tab $ali LIMIT $_pagi_inicial,$_pagi_cuantos";
	
} 
//echo $sql;
$result=mysql_query($sql);
$sql_ac="SELECT SUM(num_ac) AS num FROM acciones";
$res_ac=mysql_query($sql_ac);
$row_ac=mysql_fetch_array($res_ac);
while ($row=mysql_fetch_array($result)) {
  	echo "<tr align=\"center\">";
	echo "<td>&nbsp;$row[estado]</td>";
	echo "<td>&nbsp;$row[nom_acc]</td>";
/*	$sql_acc="SELECT SUM(num_ac) AS num, SUM(valor_ac) AS mont FROM acciones WHERE id_acc='$row[id_acc]'";
	$res_acc=mysql_query($sql_acc);
	$row_acc=mysql_fetch_array($res_acc);*/
	echo "<td>&nbsp;".number_format($row['num'],0,'.',',')."</td>";
	if($row['num']==0 || $row_ac['num']==0){ $prom=0;}
	else $prom=round($row['num']/$row_ac['num']*100,2);
	echo "<td>&nbsp;$prom %</td>";
	//monto
	$sql_mont="SELECT SUM(valor_ac*num_ac) AS mont FROM acciones WHERE id_acc='$row[id_acc]'";
	$res_mont=mysql_query($sql_mont);
	$row_mont=mysql_fetch_array($res_mont);
	echo "<td>&nbsp;".number_format($row_mont['mont'],2,'.',',')."</td>";
	echo "<td><a href=\"naccionista_det.php?num=".$row['id_acc']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></td>";
	echo "<td><font size=\"1\"><a href=\"naccionista_print.php?num=$row[id_acc]\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
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
//La idea es pasar también en los enlaces las variables hayan llegado por url.
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

//La variable $_pagi_navegacion contendrá los enlaces a las páginas.
$_pagi_navegacion = '';

if ($_pagi_actual != 1){
	//Si no estamos en la página 1. Ponemos el enlace "anterior"
	$_pagi_url = $_pagi_actual - 1;//será el numero de página al que enlazamos
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."'>&laquo; Anterior</a>&nbsp;";
}
//Enlaces a numeros de página:
for ($_pagi_i = 1; $_pagi_i<=$_pagi_totalPags; $_pagi_i++){//Desde página 1 hasta ultima página ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el numero de página es la actual ($_pagi_actual). Se escribe el numero, pero sin enlace y en negrita.
        $_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
    }else{
		//Si es cualquier otro. Se escibe el enlace a dicho numero de página.
        $_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."'>".$_pagi_i."</a>&nbsp;";
    }
}

if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la ultima página. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual + 1;//será el numero de página al que enlazamos
    $_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."'>Siguiente &raquo;</a>";
}
print $_pagi_navegacion;
//Hasta acá hemos completado la "barra de navegacion"
?>
</font></strong> <font size="2"><strong>&nbsp;</strong></font></div></td>
  </tr>
</table>
<form action="" method="post">
  <div align="center">
    <input type="submit" name="NAccionista" value="NUEVO ACCIONISTA">
    &nbsp;&nbsp;&nbsp; 
    <input name="IMPRIMIR" type="button" id="IMPRIMIR" value="    IMPRIMIR    " onClick="openStat_1()">
    &nbsp;&nbsp;&nbsp; 
    <input type="submit" name="RETORNAR" value="    RETORNAR    ">
  </div>
</form> 
<script language="JavaScript">
<!--
<?php
if(isset($msg)) print "alert(\"$msg\\n\\nMensaje generado por GesTor F1.\");"?>
function openStat_1() {	
	window.open("accionistas_print.php?login=<?php echo $login;?>",'ACC');
}
-->
</script>