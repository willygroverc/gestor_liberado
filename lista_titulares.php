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
include ("top.php");
$tipo=$_SESSION["tipo"];
if (isset($titular)) {header("location: pagina_error.php");}
?>

<table width="95%"border="1" cellpadding="0" cellspacing="2" background="images/fondo.jpg">
	<tr> 
	  <th colspan="12" height="30px" background="windowsvista-assets1/main-button-tile.jpg">LISTA DE CLIENTES/TITULARES</th>
	</tr>
	<tr align=\"center\"> 
	  <th class="menu" background="images/main-button-tileR1.jpg" height="20">CI/RUC</th>
	  <th class="menu" background="images/main-button-tileR1.jpg" height="20">NOMBRES</th>
	  <th class="menu" background="images/main-button-tileR1.jpg" height="20">AP.PATERNO</th>
	  <th class="menu" background="images/main-button-tileR1.jpg" height="20">AP.MATERNO</th>
	  <th class="menu" background="images/main-button-tileR1.jpg" height="20">E-MAIL</th>
	  <th class="menu" background="images/main-button-tileR1.jpg" height="20">ENTIDAD</th>
	  <th class="menu" background="images/main-button-tileR1.jpg" height="20">AREA</th>
	  <th class="menu" background="images/main-button-tileR1.jpg" height="20">CARGO</th>
	  <th class="menu" background="images/main-button-tileR1.jpg" height="20">TELEFONO</th>
  	  <th class="menu" background="images/main-button-tileR1.jpg" height="20">FAX</th> 
	  <th class="menu" background="images/main-button-tileR1.jpg" height="20">DIRECCION</th>
	</tr>
        <?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM titular";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
$sql = "SELECT * FROM titular ORDER BY ci_ruc ASC LIMIT $_pagi_inicial,$_pagi_cuantos";
$result=mysql_query($sql); 
while ($row=mysql_fetch_array($result)) {
  	echo "<tr align=\"center\">";
	if ($tipo=="T" || $tipo=="C") 
		echo '<td>&nbsp;<a href="opt_clien.php?ci_ruc='.$row['ci_ruc'].'&buscar=buscar&desc_inc='.@$desc.'">'.$row['ci_ruc'].'</a></td>';
	else echo '<td>&nbsp;<a href="titular.php?ci_ruc='.$row['ci_ruc'].'&origen=titular">'.$row['ci_ruc'].'</a></td>';
	echo "<td>&nbsp;".$row['nombre']."</td>";
	echo "<td>&nbsp;".$row['apaterno']."</td>";
	echo "<td>&nbsp;".$row['amaterno']."</td>";
	echo "<td>&nbsp;".$row['email']."</td>";
	echo "<td>&nbsp;".$row['entidad']."</td>";
	echo "<td>&nbsp;".$row['area']."</td>";
	echo "<td>&nbsp;".$row['cargo']."</td>";
	echo "<td>&nbsp;".$row['telf']."</td>";
	echo "<td>&nbsp;".$row['externo']."</td>";
	echo "<td>&nbsp;".$row['direccion']."</td>";
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
<br>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
  <input name="IdProv" type="hidden" value="<?php echo $IdProv;?>"> 
    <table width="100%" cellspacing="0" cellpadding="0">
      <tr align="center">
<!--    <td width="39%" align="center"><input type="submit" name="titular" value="NUEVO CLIENTE/TITULAR"> &nbsp;</td>	-->
	<td width="30%"><input name="IMPRIMIR" type="button" value="IMPRIMIR CLIENTES/TITULARES" onClick="pagina()"> &nbsp;&nbsp;&nbsp;</td>
      </tr>
    </table>
    </form>
<script>
<!--
function pagina () {
	window.open ("ver_titulares.php");
}
-->
</script>