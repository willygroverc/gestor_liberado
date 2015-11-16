<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
/*function limpiarURL($str) {
	//Quitar tildes y ñ
	$tildes = array('á','é','í','ó','ú','ñ','Á','É','Í','Ó','Ú','Ñ');
	$vocales = array('a','e','i','o','u','n','A','E','I','O','U','N');
	$str = str_replace($tildes,$vocales,$str);
 
	//Quitar símbolos
	$simbolos = array(">","<","¿","¡","!","'","%","$","€","(",")","[","]","{","}","*","+","·","&lt; ","&gt;");
	$i = 0;
	while($simbolos[$i]){
	$str = str_replace($simbolos[$i], "", $str);
	$i++;
	}
 
	//Quitar espacios
	$str = str_replace("20","",$str);
	//Pasar a minúsculas
	$str = strtolower($str);
 
	return $str;
}
function obt_url(){
$url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
return $url;
}
$var=obt_url();
echo limpiarURL($var);*/
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require("conexion.php");
if (!(empty($nro)))
{	$sql9 = "SELECT * FROM planif_estrategica WHERE TipoPlanifica='$varia2' AND NumPlanif='$nro'";
	$res9 = mysql_query($sql9);
	$row9 = mysql_fetch_array($res9);
}
if (isset($_REQUEST['RETORNAR'])){header("location: lista_planifes.php");}
if (isset($_REQUEST['mas_acciones']))
{	
        $var2=$_REQUEST['var2'];
        $sql = "SELECT MAX(NumPlanif) AS Num FROM planif_estrategica WHERE TipoPlanifica='$var2'";

  	$result = mysql_query($sql);
  	$row = mysql_fetch_array($result);
	$numer = $row['Num']+1;
	if (!(empty($nro))) { $actividad = "0"; $numer = "$nro";}
	else  $actividad = "1";	
	header("location: actividades_pre.php?plan=$varia2&numer=$numer&actividad=$actividad&ObjNegocio=$ObjNegocio&nro=$nro&varia2=$varia2");
}
include("top.php");
$tip=  isset($_GET['varia2']);
if (!isset($tip)) $tip=$_POST["var2"];
if (isset($_GET['varia3']))
	$crear=($_GET['varia3']);
if (isset($_GET['variacua']))
	$numplan=($_GET['variacua']);
?> 
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTextNormal ( "ObjNegocio",  "Objetivo, $errorMsgJs[expresion]" );
$valid->addLength ( "ObjNegocio",  "Objetivo, $errorMsgJs[length]" );
$valid->addIsTextNormal ( "ObjTi",  "Objetivo TI, $errorMsgJs[expresion]" );
$valid->addLength ( "ObjTi",  "Objetivo TI, $errorMsgJs[length]" );
$valid->addIsTextNormal ( "Accion",  "Accion, $errorMsgJs[expresion]" );
$valid->addLength ( "Accion",  "Accion, $errorMsgJs[length]" );
$valid->addIsNotEmpty ( "RespPlanifica",  "Responsable, $errorMsgJs[empty]" );
$valid->addIsDate   ( "Dia", "Mes", "Ano", "Fecha, $errorMsgJs[date]" );
$valid->addIsNumber ( "costo",  "Costo estimado, $errorMsgJs[number]" );
print $valid->toHtml ();
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
<html>
<head>
<style>
.cl2 { FONT-SIZE:8PT;}
</style>	
</head>
<body>
<form name="form1" method="post" action="planif_estrategica.php" onKeyPress="return Form()">
  <input name="var2" type="hidden" value="<?php echo $tip;?>">
  <input name="varia2" type="hidden" value="<?php echo $varia2;?>">
  <input name="nro" type="hidden" value="<?php echo $nro;?>">
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <th colspan="8" background="images/main-button-tileR1.jpg"><font size="2" face="Arial, Helvetica, sans-serif">PLANIFICACION 
        ESTRATEGICA - <?php echo $tip; ?></font></th>
    </tr>
    <tr> 
      <td width="29"background="images/main-button-tileR1.jpg"> <div align="center"></div>
        <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nro,</font></div></td>
      <td width="236"background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBJETIVO 
          DE NEGOCIO</font></div></td>
      <td width="214"background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBJETIVOS 
          TI</font></div></td>
      <td width="101"background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NRO. OBJETIVOS</font></div></td>
	  <td width="99"background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NRO. ACCIONES</font></div></td>
      <td width="90"background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font></div></td>
      <td width="112"background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">COSTO($us)</font></div></td>
	  <td width="50"background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">IMPRIMIR</font></div></td>
    </tr>
    <?php
		$fechahoy=date("Y-m-d");
		$sql = "SELECT *, DATE_FORMAT(FechaPlanifica, '%d/%m/%Y') AS FechaPlanifica2, count(*) AS boris FROM planif_estrategica WHERE TipoPlanifica='$tip' GROUP BY NumPlanif ORDER BY NumPlanif ASC"; 
		$result=mysql_query($sql);
		$costo_abs=0;
		while($row=mysql_fetch_array($result)) 
  		{
			if ($row['FechaPlanifica'] >= $fechahoy ) { //VIGENTE
				$color="bgcolor=\"#00CC00\"";
			}
			else {
				$color="bgcolor=\"#FF6666\""; //VENCIDO
			}
		 ?>
    <tr align="center"> 
      <td <?php echo $color ?> >&nbsp;<?php echo $row['NumPlanif']?></td>
      <td>&nbsp;
        <?php
	  echo $row['ObjNegocio'];
	  ?>
      </td>
      <td>&nbsp;
      <?php
		  echo '<a href="actividades_pre.php?plan='.$tip.'&numer='.$row['NumPlanif'].'&actividad=1&ObjNegocio='.$row['ObjNegocio'].'&varia2='.$tip.'">VER OBJETIVOS</a>';
  		$sql5 = "SELECT count(*) AS numero FROM planif_estrategica WHERE NumPlanif='$row[NumPlanif]' AND TipoPlanifica='".$row['TipoPlanifica']."'";
		$result5 = mysql_query($sql5);
		$row5 = mysql_fetch_array($result5);
		echo '<td>&nbsp;'.$row5['numero'].'</td>';

	  ?>
      </td>
      <td>&nbsp; 
        <?php
	  $num_acciones=0;
	  $costo_tot=0;
	  $sql_acc="SELECT Accion,costo FROM planif_estrategica WHERE TipoPlanifica='$tip' AND NumPlanif='".$row['NumPlanif']."'";
	  $res_acc=mysql_query($sql_acc);
	  while($row_acc=mysql_fetch_array($res_acc)){
		if($row_acc['Accion']){
	  		$acc_aux=explode("|",$row_acc['Accion']);
			foreach($acc_aux as $valor)	if($valor) $num_acciones++;
			$cos_aux=explode("|",$row_acc['costo']);
			$costo_tot+=array_sum($cos_aux);
		}
	  }
	  echo $num_acciones;
	  ?>
      </td>
      <td>&nbsp;<?php echo $row['FechaPlanifica2']?></td>
      <td>&nbsp;<?php echo $costo_tot; $costo_abs+=$costo_tot;?></td>
	  <?php 
	  	echo '<td><font size="1"><a href="ver_planifxproy.php?variable1='.$tip.'&numer='.$row['NumPlanif'].'" target="_blank"><img src="images/imprimir.gif" border="0" alt="Imprimir"></a></font></td>';
	  ?>
      </tr>
    <?php 
		 }
		 ?>
  </table>	
	<?php 
	//costo total
	$sql7 = "SELECT SUM(costo) as total FROM planif_estrategica WHERE TipoPlanifica='$_REQUEST[varia2]'";
	$result7=mysql_query($sql7);
	$row7=mysql_fetch_array($result7);
	?>
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
	<tr>
	  <td><div align="left"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong>COSTO TOTAL: <?php echo "$"."us ".$costo_abs;?></strong></font></div></td>
  </table>
<br>
  <table width="65%" border="1" align="center">
  <tr> 
    <td width="16%" align="center">PLANIFICACION VENCIDA</td>
    <td width="7%" bgcolor="#FF6666">&nbsp;</td>
    <td width="16%">&nbsp;</td>
    <td width="16%" align="center">PLANIFICACION VIGENTE</td>
    <td width="7%" bgcolor="#00CC00">&nbsp;</td>
  </tr>
</table>
<br>
  <table width="60%" border="1" align="center" background="images/fondo.jpg" >
    <tr> 
      <td width="30%"background="images/main-button-tileR1.jpg" > <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBJETIVO 
          DE NEGOCIO</font></div></td>
    </tr>
    <tr> 
      <td width="30%"  > <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
          <textarea name="ObjNegocio" cols="50"><?php echo @$row9['ObjNegocio'];?></textarea>
          </font></div></td>
    </tr>
  </table>
  <table width="60%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="100%"><div align="center"> <br>
          <input type="submit" name="mas_acciones" value = "GUARDAR Y CONTINUAR"   <?php print $valid->onSubmit() ?>Z> 
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="RETORNAR" value="RETORNAR">
        </div></td>
    </tr>
  </table>
<tr>
    <td colspan="1"><blockquote>
</form>
</body>
</html>
 <script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
//-->
</script>
