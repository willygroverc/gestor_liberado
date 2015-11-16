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
if (valida("MantFuera")=="bad") {header("location: pagina_error.php");}
if (isset($_REQUEST['RETORNAR'])){header("location: lista1_ficha.php?Naveg=Soporte Tecnico");}
if (isset($_REQUEST['NAcuerdo']))
	{   require("conexion.php");
		$sql5="SELECT MAX(id_regPC) AS Id FROM pcontrol";
		$result5=mysql_query($sql5);
		$row5=mysql_fetch_array($result5);
		$r=$row5['Id']+1; 
        header("location: controlmanten.php?varia1=$r"); 
	}
if((isset($varia3) && $varia3=="creacion")){
	include("conexion.php");
	$sql2 = "SELECT * FROM pcontrol WHERE id_regPC='$variacua'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	
	$accion_obj ="(Objetivo: $row2[des_disp])";
	$sql3 = "INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, tipo,origen) ".
			"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$accion_obj','L','2.1')"; 
			mysql_query($sql3);
	$sql5 = "SELECT MAX(id_orden) AS Ord FROM ordenes";
	$result5 = mysql_query($sql5);
	$row5 = mysql_fetch_array($result5);
	$sql6="INSERT INTO ".
	"asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,fechaestsol_asig,reg_asig,diagnos,escal,date_esc,time_esc,fechasol_esc,area) ".
	"VALUES('$row5[Ord]','2','2','2','$row2[login_usr]','".date("Y-m-d")."','".date("H:i:s")."','$row2[fecha_s]','$login','Mantenimiento Externo','0','".date("Y-m-d")."','".date("H:i:s")."','$row2[fecha_r]','Mesa')";
	mysql_query($sql6);
	$sql4="UPDATE pcontrol SET orden='$row5[Ord]' WHERE id_regPC='$variacua'"; 
	mysql_query($sql4);
}
include ("top.php");
?>
<table width="95%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699">
  <tr> 
    <td height="68" valign="top">
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg">
        <tr> 
          <th colspan="10" background="windowsvista-assets1/main-button-tile.jpg" height="30">CONTROL DE MANTENIMIENTO DE HARDWARE</font></th>
        </tr>
        <tr align=\"center\"> 
		  <th class="menu" width="2%" background="images/main-button-tileR1.jpg" height="20">Nro</th>
  		  <th class="menu" width="2%" background="images/main-button-tileR1.jpg" height="20">MANTENIMIENTO</th>
		  <th class="menu" width="9%" background="images/main-button-tileR1.jpg" height="20">Nro DE ACTIVO FIJO</th>
  		  <th class="menu" width="9%" background="images/main-button-tileR1.jpg" height="20">Nro COD. ADICIONAL</th>
		  <th class="menu" width="15%" background="images/main-button-tileR1.jpg" height="20">ASIGNADO A</th>
  		  <th class="menu" width="25%" background="images/main-button-tileR1.jpg" height="20">DESCRIPCION</th>
  		  <th width="15%" class="menu" background="images/main-button-tileR1.jpg" height="20">EMPRESA</th>
   		  <th width="6%" class="menu" background="images/main-button-tileR1.jpg" height="20">ENTREGA</th>
           <?php if (($tipo=="A") or ($tipo=="B")) {?>
  		  <th class="menu" background="images/main-button-tileR1.jpg" width="6%">MODIFICAR</th>
  		 <?php }?>
  		  <th class="menu" background="images/main-button-tileR1.jpg" width="6%">IMPRIMIR</th>
        </tr>
        <?php
	$sql11 = "SELECT num_ord_pag FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM pcontrol";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
$sql = "SELECT a.* FROM pcontrol a, datfichatec b WHERE a.AdicUSI=b.AdicUSI AND b.Elim<>1 ORDER BY id_regPC DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
$result=mysql_query($sql); 
while ($row=mysql_fetch_array($result)) {
	echo "<tr align=\"center\">";
	echo "<td ";
	$tmp=explode("-", $row['fecha_r']);
	$fecHoy = date("Y-m-d");
	if ( mktime(0,0,0,$tmp[1], $tmp[2], $tmp[0]) <= mktime() ) 
	{	if ($fecHoy==$row['fecha_r']) echo "bgcolor=\"#00FF00\"";
		elseif($row['fecha_ret']<>"0000-00-00") echo "bgcolor=\"#FFCC00\"";
		else echo "bgcolor=\"#FF0000\"";
	}	
	else
	echo "bgcolor=\"#00FF00\"";
	echo "><font size=\"1\">&nbsp;$row[id_regPC]</font></td>";
	if($row['tipo_mant2']=="I"){echo "<td><font size=\"1\">&nbsp;INTERNO</font></td>";}
	elseif($row['tipo_mant2']=="E"){echo "<td><font size=\"1\">&nbsp;EXTERNO</font></td>";}
	else{echo "<td><font size=\"1\">&nbsp;EXTERNO</font></td>";}
	echo "<td><font size=\"1\">&nbsp;$row[CodActFijo]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[AdicUSI]</td>";
	$str = "SELECT * FROM datfichatec WHERE AdicUSI='$row[AdicUSI]'";
	$res = mysql_query($str);
	$fila = mysql_fetch_array($res);	 
	$str1 = "SELECT * FROM users WHERE login_usr='$fila[CodUsr]'";
	$res1 = mysql_query($str1);
	$datos = mysql_fetch_array($res1);
	if ($datos)
   		 echo "<td><font size=\"1\">$datos[nom_usr] $datos[apa_usr] $datos[ama_usr]</td>";
	else
		 echo "<td><font size=\"1\">Ninguno</td>";
	echo "<td><font size=\"1\">&nbsp;$row[des_disp]</font></td>";
	if($row['tipo_mant2']=="I"){echo "<td><font size=\"1\">&nbsp;NO APLICA</font></td>";}
	else{echo "<td><font size=\"1\">&nbsp;$row[NombProv]</font></td>";}
	if($row['fecha_ret']!="0000-00-00"){echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<img src=\"images/ok.gif\" border=\"0\" alt=\"Entregado\"></font></td>";}
	else {echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"controlmantenent.php?IdRegPC=".$row['id_regPC']."&AdicUSI=".$row['AdicUSI']."&tm=$row[tipo_mant2]\"><img src=\"images/mano.gif\" border=\"0\" alt=\"Entrega\"></a></font></td>";}
	if (($tipo=="A") or ($tipo=="B"))
	{echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"controlmantenmod.php?IdRegPC=".$row['id_regPC']."&AdicUSI=".$row['AdicUSI']."&tm=$row[tipo_mant2]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";}
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"ver_controlman.php?variable=".$row['id_regPC']."&tm=$row[tipo_mant2]\"target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
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
<br>
<table width="35%" border="1">
  <tr align="center"> 
    <td width="80" >VENCIDOS</td>
    <td width="20" bgcolor="#FF6666">&nbsp;</td>
    <td width="11">&nbsp;</td>
    <td width="80">VIGENTES</td>
    <td width="20" bgcolor="#00CC66">&nbsp;</td>
    <td width="11">&nbsp;</td>
    <td width="80">ENTREGADOS</td>
    <td width="20" bgcolor="#FFCC00">&nbsp;</td>
  </tr>
</table>
<form action="" method="get">
  <div align="center">
    <input type="submit" name="NAcuerdo" value="NUEVO CONTROL">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input type="button" name="IMPRIMIR" value="   IMPRIMIR   " onClick="mant_imp()">
  </div>
</form> 
<script language="JavaScript">
<!--
function pagina() {
	window.open("ver_lista_controlm.php");
}
function mant_imp() {
	//window.open("ver_lista_controlm.php");
	window.open("manten_imp.php", "Impresion_Mantenimiento", 'width=500,height=190,status=no,resizable=no,top=250,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=no');
}
-->
</script>