<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		23/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Se ha incrementado 4 campos: nivel de riesgo, descripcion de riesgo,
//				nivel de calidad, descricion de calidad
// Fecha: 		15/JUN/2014
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require("conexion.php");
require_once("funciones.php");
if (valida("Proveedores")=="bad") {header("location: pagina_error.php");}
if (isset($_REQUEST['RETORNAR'])){echo "<script type=\"text/javascript\">
           history.go(-2);
       </script>";}
if (isset($_REQUEST['Proveedor'])) {header("location: proveedor.php");}
if (isset($_REQUEST['accion']) && $accion=="elimina")
{	$sql = "DELETE FROM proveedor WHERE IdProv='$IdProv'";
	mysql_query($sql);
}

include ("top.php");
if (isset($_GET['IdProv']))
	$IdProv=($_GET['IdProv']);
?>
<script language="JavaScript">
<!--
function pagina() {
	window.open("ver_lista_prov.php");
}
function confirmLink(theLink, usuario)
{
    var is_confirmed = confirm("Desea Realmente Eliminar "+ ' :\n' + usuario);
    if (is_confirmed) {
        theLink.href += '&accion=elimina';
    }
    return is_confirmed;
} // end of the 'confirmLink()' function
//-->
</script>
<?php 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero de Orden de Mesa");
	$help->AddHelp("proveedor","Nombre del Proveedor");
	$help->AddHelp("tel1","Telefono 1");
	$help->AddHelp("tel2","Telefono 2");
	print $help->ToHtml();
 ?>
<form action="" method="get" name="form2" id="form2" >
 <input name="opc" type="hidden" value="<?php echo $opc;?>">
  <table width="80%" border="1" align="center" bgcolor="#006699">
    <tr> 
      <td width="60%" background="windowsvista-assets1/main-button-tile.jpg" height="30px"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Busqueda 
          por :</strong></font> 
          <select name="menu" id="menu">
              <option value="" <?php $menu=  isset($_REQUEST['menu']); if ($menu==""){echo "selected";}?>>GENERAL</option>		  
              <option value="prov" <?php $menu=  isset($_REQUEST['menu']); if ($menu=="prov"){echo "selected";}?>>NOM. PROVEEDOR</option>
          </select>
          &nbsp;&nbsp;&nbsp; 
          <input name="text" type="text" id="text" value="<?php echo @$text;?>">
          &nbsp;&nbsp;&nbsp; 
          <input name="BUSCAR" type="submit" id="BUSCAR" value="BUSCAR">
        </div></td>
	    </tr>
  </table>
</form>
<table width="95%"border="1" cellpadding="0" cellspacing="2" background="images/fondo.jpg">
	<tr> 
	  <th colspan="17" background="windowsvista-assets1/main-button-tile.jpg" height="30px">LISTA DE PROVEEDORES / CLIENTES</th>
	</tr>
	<tr align=\"center\"> 
	  <th class="menu" background="images/main-button-tileR1.jpg"><?php print $help->AddLink("num", "Nro"); ?></th>
	  <th class="menu" background="images/main-button-tileR1.jpg"><?php print $help->AddLink("proveedor", "NOM. PROVEEDOR"); ?></th>
	  <th class="menu" background="images/main-button-tileR1.jpg">DIRECCION</th>
	  <th class="menu" background="images/main-button-tileR1.jpg"><?php print $help->AddLink("tel1", "TEL. 1"); ?></th>
	  <th class="menu" background="images/main-button-tileR1.jpg"><?php print $help->AddLink("tel2", "TEL. 2"); ?></th>
	  <th class="menu" background="images/main-button-tileR1.jpg">ENCARGADO</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">E-MAIL</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">CLASIFICACION</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">SERVICIO</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">N. RIESGO</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">DESC RIESGO</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">N. CALIDAD</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">DESC. CALIDAD</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">OBSERVACION</th>
  	  <?php if ($tipo=="A") {?>
	  <th class="menu" background="images/main-button-tileR1.jpg">MODIFICAR</th>
  	  <th class="menu" background="images/main-button-tileR1.jpg">ELIMINAR</th> <?php }?>
	  <th class="menu" background="images/main-button-tileR1.jpg">IMPRIMIR</th>
	</tr>
        <?php
	$sql11 = "SELECT num_ord_pag FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

if(isset($menu) && $menu=="prov"){
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM proveedor WHERE NombProv LIKE '%$text%'";
}else{
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM proveedor";}
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
if(isset($menu) && $menu=="prov"){
	$sql = "SELECT * FROM proveedor WHERE NombProv LIKE '%$text%' ORDER BY IdProv DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
}else{
	$sql = "SELECT * FROM proveedor ORDER BY IdProv DESC LIMIT $_pagi_inicial,$_pagi_cuantos";}
$result=mysql_query($sql); 
while ($row=mysql_fetch_array($result)) {
  	echo "<tr align=\"center\">";
	echo "<td>&nbsp;$row[IdProv]</td>";
	echo "<td>&nbsp;$row[NombProv]</td>";
	echo "<td>&nbsp;$row[DirecProv]</td>";
	echo "<td>&nbsp;$row[Fono1Prov]</td>";
	echo "<td>&nbsp;$row[Fono2Prov]</td>";
	echo "<td>&nbsp;$row[EncProv]</td>";
	echo "<td>&nbsp;$row[EmailProv]</td>";
	$sqlT="SELECT servicio_nombre FROM t_servicio where servicio_cod='$row[nivel1]'";
	$resultT=mysql_query($sqlT);
	$filaT=mysql_fetch_array($resultT);
	echo "<td>&nbsp;$filaT[servicio_nombre]</td>";
	$sqlT2="SELECT servicio2 FROM t_servicio2 where id_serv2='$row[nivel2]'";
	$resultT2=mysql_query($sqlT2);
	$filaT2=mysql_fetch_array($resultT2);
	echo "<td>&nbsp;$filaT2[servicio2]</td>";
	echo "<td>&nbsp;$row[nivelRiesgo]</td>";
	echo "<td>&nbsp;$row[descRiesgo]</td>";
	echo "<td>&nbsp;$row[nivelCalidad]</td>";
	echo "<td>&nbsp;$row[descCalidad]</td>";
	echo "<td>&nbsp;$row[ObsProv]</td>";
	if ($tipo=="A") {
	echo '<td><a href="proveedor.php?IdProv='.$row['IdProv'].'"><img src="images/editar.gif" border="0" alt="Modificar"></a></td>';
	echo '<td><a href="lista_proveed.php?IdProv='.$row['IdProv'].'" onClick="return confirmLink(this,\''.$row['NombProv'].'\')"><img src="images/eliminar.gif" border="0" alt="Eliminar"></a></td>';}
	echo '<td><a href="ver_proveedor.php?variable='.$row['IdProv'].'" target="_blank"><img src="images/imprimir.gif" border="0" alt="Imprimir"></a></td>';
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
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
  <input name="IdProv" type="hidden" value="<?php echo $IdProv;?>"> 
    
  <table width="100%" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="37%" align="center"> <div align="right">
          <input type="submit" name="Proveedor" value="NUEVO PROVEEDOR">
        </div></td>
      <td width="30%"><div align="center"> 
          <input name="IMPRIMIR" type="submit" id="IMPRIMIR" value="IMPRIMIR PROVEEDORES" onClick="pagina()">
          &nbsp;&nbsp;&nbsp;</div></td>
      <td width="33%"> <!--<div align="left">
          <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
        </div>--></td>
    </tr>
  </table>
    </form>