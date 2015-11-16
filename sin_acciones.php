<?php
if ($terminar)
{ 
	header("location: accionistas.php");
}
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require_once("funciones.php");
require("conexion.php");
//if (valida("Accion")=="bad") {header("location: pagina_error.php");}
include ("top.php");

include_once ("help.class.php");
$help=new Help();
$help->AddHelp("num","Numero");
print $help->ToHtml();
if (isset($flag) && $flag==1) $flag=0;
else $flag=1;
?>
<form action="" method="post">
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
		  <!--<th class="menu" height="20" background="images/main-button-tileR1.jpg">TOTAL DE ACCIONES</th>-->
  		  <th class="menu" height="20" background="images/main-button-tileR1.jpg">HISTORICO DE ACCIONES</th>
		  <th class="menu" height="20" background="images/main-button-tileR1.jpg">MODIFICAR ACCIONES</th>
		  <!--<th class="menu" height="20" background="images/main-button-tileR1.jpg">TRASPASO A</th>
		  <th class="menu" height="20" background="images/main-button-tileR1.jpg">FECHA - HORA</th>
		  <th class="menu" height="20" background="images/main-button-tileR1.jpg">OBSERVACIONES</th>-->
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
    //$sql = "SELECT a.*, DATE_FORMAT(fecha_acc, '%d/%m/%Y') AS fecha_acc, SUM(b.num_ac) AS num, SUM(b.valor_ac) AS mont FROM accionistas a, acciones b WHERE a.id_acc=b.id_acc GROUP BY b.id_acc ORDER BY $ord_tab $ali LIMIT $_pagi_inicial,$_pagi_cuantos";
	$sql = "SELECT distinct  a.id_acc,a.`nom_acc`,a.`dom_acc`,a.`tel_acc`,a.`estado`, DATE_FORMAT(fecha_acc, '%d/%m/%Y') AS fecha_acc FROM accionistas a WHERE a.id_acc NOT IN (SELECT id_accionistas FROM acciones)";
	}
else  
{
    $_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM accionistas";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
if(!$ord_tab) $ord_tab='id_acc';
    $sql = "SELECT distinct  a.id_acc,a.`nom_acc`,a.`dom_acc`,a.`tel_acc`,a.`estado`, DATE_FORMAT(fecha_acc, '%d/%m/%Y') AS fecha_acc FROM accionistas a WHERE a.id_acc NOT IN (SELECT id_accionistas FROM acciones)";
	
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
	//echo "<td>&nbsp;0.00</td>";
	if($row['num']==0 || $row_ac['num']==0){ $prom=0;}
	else $prom=round($row['num']/$row_ac['num']*100,2);
	echo "<td>&nbsp;$prom %</td>";
	//monto
	$sql_mont="SELECT SUM(valor_ac*num_ac) AS mont FROM acciones WHERE id_accionistas='$row[id_acc]'";
	$res_mont=mysql_query($sql_mont);
	$row_mont=mysql_fetch_array($res_mont);
	echo "<td>&nbsp;".number_format($row_mont['mont'],2,'.',',')."</td>";
	//echo "<td><a href=\"acciones_tot.php?num=".$row['id_acc']."\"><img src=\"images/si1.gif\" border=\"0\" alt=\"ANTERIOR\"></a></td>";
	echo "<td><a href=\"his_acciones.php?num=".$row['id_acc']."\"><img src=\"images/page.gif\" border=\"0\" alt=\"ANTERIOR\"></a></td>";
	echo "<td><a href=\"naccionista_det.php?num=".$row['id_acc']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"MODIFICAR\"></a></td>";
	$sql_a="SELECT * FROM `transferencia` WHERE user_de = '$row[id_acc]'";
	$res_a=mysql_query($sql_a);
	$row_a=mysql_fetch_array($res_a);
	$sql_us="SELECT nom_acc FROM `accionistas` WHERE id_acc = '$row_a[user_de]'";
	$res_us=mysql_query($sql_us);
	$row_us=mysql_fetch_array($res_us);
	/*if(empty($row_a[user_de]))
		echo "<td>No realizo transferencias</td>";	
	else
		echo "<td>$row_us[nom_acc]</td>";

	if(empty($row_a[fecha]))
		echo "<td>No realizo transferencias</td>";	
	else
		echo "<td>$row_a[fecha]</td>";
	
	if(empty($row_a[observaciones]))
		echo "<td>No realizo transferencias</td>";	
	else
		echo "<td>$row_a[observaciones]</td>";*/
	echo "</tr>";
}
?>
      </table></td>
  </tr>
  <!--<tr>
	<td>
	</br>
		<center>
		<select name="accionista" />
			<option value="0">Seleccione</option>
		</select>
		</center>
    </td>
  </tr>-->
  <tr> 
      <td height="28" colspan="11" nowrap> <div align="center"><br>
	  
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="terminar" id="terminar" value="RETORNAR">
        </div></td>
    </tr>
</table>
 </form>
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
<!--
  <div align="center">
	<input type="submit" name="traspaso" value="TRASPASO DE ACCIONES">
    &nbsp;&nbsp;&nbsp; 
    <input type="submit" name="NAccionista" value="NUEVO ACCIONISTA">
    &nbsp;&nbsp;&nbsp; 
    <input name="IMPRIMIR" type="button" id="IMPRIMIR" value="    IMPRIMIR    " onClick="openStat_1()">
    &nbsp;&nbsp;&nbsp; 
    <input type="submit" name="PERSONAS SIN ACCIONES REGISTRADAS" value="sin_acciones">
  </div>
</form>--> 
<script language="JavaScript">
<!--
<?php
if(isset($msg)) print "alert(\"$msg\\n\\nMensaje generado por GesTor F1.\");"?>
function openStat_1() {	
	window.open("accionistas_print.php?login=<?php echo $login;?>",'ACC');
}
-->
</script>