<?php 
include ("conexion.php");
session_start();
if(!empty($_SESSION["path_pistas"])) $path_pistas = $_SESSION["path_pistas"];
require_once('funciones.php');
$id_pista=SanitizeString($id_pista);
$sql13 = "SELECT * FROM registro_pistas WHERE id_pista='$id_pista'";
$result13 = mysql_db_query($db,$sql13,$link);
$row13 = mysql_fetch_array($result13);
$tabla = "pistas_fuentes_gral";
$condicion = "agrupar_pista = '$id_pista'";
if ($row13['restaurado']==0)
{	//$sql14 = "RESTORE TABLE $tabla FROM '$path_pistas'";
	//$result14 = mysql_db_query($db,$sql14,$link);
	$sql15 = "UPDATE registro_pistas SET restaurado=1 WHERE id_pista='$id_pista'";
	$result15 = mysql_db_query($db,$sql15,$link);
}
if ($RETORNAR){
	$sql16 = "SELECT * FROM registro_pistas WHERE id_pista='$id_pista'";
	$result16 = mysql_db_query($db,$sql16,$link);
	$row16 = mysql_fetch_array($result16);
	if ($row16[restaurado] == 1){
		$sql17 = "DROP TABLE $row16[nombre_pista]";
		$result17 = mysql_db_query($db,$sql17,$link);
		$sql18 = "UPDATE registro_pistas SET restaurado=0 WHERE id_pista='$id_pista'";
		$result18 = mysql_db_query($db,$sql18,$link);
	}
	header("location: pistas_fuentes2.php");
}
include ("top.php");
if ($BUSCAR){
	$op2=1;
	if ($op=="1"){
	if (strlen($DA) == 1){ $DA = "0".$DA; }
	if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
    $fec1 = $AA."-".$MA."-".$DA;   
	if (strlen($DE) == 1){ $DE = "0".$DE; }
	if (strlen($ME) == 1){ $ME = "0".$ME; }
	
	$fec2 = $AE."-".$ME."-".$DE; 
	$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE fecha_pista BETWEEN '$fec1' AND '$fec2' AND $condicion ORDER BY id_pista DESC";
	}
	if ($op=="2"){
	$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE accion='$proceso' AND $condicion ORDER BY id_pista DESC";
	}
	if ($op=="3"){
	$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE login_pista='$responsable' AND $condicion  ORDER BY id_pista DESC";
	}
	if ($op=="4"){
	$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE id_mod='$modulo' AND $condicion ORDER BY id_pista DESC";
	}
	if ($op=="5"){
	$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE id_arch='$archivo' AND $condicion ORDER BY id_pista DESC";
	}
	if ($op=="6"){
	$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE id_ver='$version' AND $condicion ORDER BY id_pista DESC";
	}
}
?>
<html>
<head>
<script language="JavaScript">
	var id_pista=<?php echo $id_pista;?>;
</script>
<script lenguaje="javascript" type="text/javascript">
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function cambio(numero){        
		 if (!foco_texto){
				 irapagina("pistas_fuentes3.php?op="+numero+"&id_pista="+id_pista);
		 } 
}
var foco_texto=false;
</script>
</head>
<body>
<script language="JavaScript" src="calendar.js"></script>
<?php 
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsDate   ( "DA", "MA", "AA", "Fecha de Inicio, $errorMsgJs[date]" );
$valid->addIsDate   ( "DE", "ME", "AE", "Fecha de Conclusion, $errorMsgJs[date]" );
$valid->addCompareDates   ( "DA", "MA", "AA","DE", "ME", "AE", "Fecha Del y Fecha Al, $errorMsgJs[compareDates]");
print $valid->toHtml ();
?>
<?php 
//pasar la consulta para la busqueda con paginacion
if ($op2==1){
	if ($op=="" || $op=="0"){
	$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE $condicion ORDER BY id_pista DESC";
	}
	if ($op=="1"){
		if ($fec1!="" && $fec2!=""){
		$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE $condicion AND fecha_pista BETWEEN '$fec1' AND '$fec2' ORDER BY id_pista DESC";
		}else{
		$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE $condicion ORDER BY id_pista DESC";
		}
	}
	if ($op=="2"){
		if ($proceso!=""){
		$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE accion='$proceso' AND $condicion ORDER BY id_pista DESC";
		}else{
		$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla  WHERE $condicion ORDER BY id_pista DESC";
		}
	}
	if ($op=="3"){
		if ($responsable!=""){
		$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE login_pista='$responsable' AND $condicion ORDER BY id_pista DESC";
		}else{
		$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE $condicion ORDER BY id_pista DESC";
		}
	}
	if ($op=="4"){
		if ($modulo!=""){
		$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE id_mod='$modulo' AND $condicion ORDER BY id_pista DESC";
		}else{
		$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE $condicion ORDER BY id_pista DESC";
		}
	}
	if ($op=="5"){
		if ($archivo!=""){
		$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE id_arch='$archivo' AND $condicion ORDER BY id_pista DESC";
		}else{
		$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE $condicion  ORDER BY id_pista DESC";
		}
	}
	if ($op=="6"){
		if ($version!=""){
		$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE id_ver='$version' AND $condicion ORDER BY id_pista DESC";
		}else{
		$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE $condicion ORDER BY id_pista DESC";
		}
	}
}
?>
<p>
<form action="pistas_fuentes3.php" method="post" name="form2" id="form2">
<input type="hidden" name="op" value="<?php echo $op; ?>">
<input type="hidden" name="id_pista" value="<?php echo $id_pista; ?>">
  <table width="90%" border="0" align="center" bgcolor="#006699">
    <tr align="center"> 
      <td width="30%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Busqueda 
          por :</strong></font> 
          <select name="menu" id="menu" onChange="cambio(this.options.selectedIndex)">
		    <option value=""></option>	
			<option value="fecha"<?php if ($op=="1") print selected ?>>Fecha</option>
            <option value="proceso" <?php if ($op=="2") print selected ?>>Proceso</option>
            <option value="responsable" <?php if ($op=="3") print selected ?>>Responsable</option>
            <option value="modulo" <?php if ($op=="4") print selected ?>>Modulo</option>
            <option value="archivo" <?php if ($op=="5") print selected ?>>Archivo</option>
            <option value="version" <?php if ($op=="6") print selected ?>>Version</option>
          </select>&nbsp;&nbsp;&nbsp;
      </div></td>
	  <?php 
	  if ($op=="1") {
	  ?>
			<td width="50%">
			<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Del: </strong></font> 
			<select name="DA" id="select">
  			<?php		  		
				if ($fec1){
  				$ano = substr($fec1,0,4);
				$mes = substr($fec1,5,2);
				$dia = substr($fec1,8,2);				
				}else{
				$fsist = date("Y-m-d");				
  				$ano = substr($fsist,0,4);
				$mes = substr($fsist,5,2);
				$dia = substr($fsist,8,2);				
				}
				for($i=1;$i<=31;$i++)
				{	if ( isset ($DA) ){ echo "<option value=\"$i\""; if($DA=="$i") echo "selected"; echo">$i</option>";	}
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
			</select>
			<select name="MA" id="select9">
                <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) ) {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
            </select>
            <select name="AA" id="select6">
            <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($AA) ) {echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
			</select>
			<font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
			<a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a>&nbsp;&nbsp;</font>
			<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Al: </strong></font> 
			<select name="DE" id="select7">
			<?php
				if ($fec2){
  				$ano = substr($fec2,0,4);
				$mes = substr($fec2,5,2);
				$dia = substr($fec2,8,2);				
				}else{
				$fsist=date("Y-m-d");
				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);
				}				
				for($i=1;$i<=31;$i++)
				{	if (isset($DE)) {echo "<option value=\"$i\""; if($DE=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
					?>
			</select>
			<select name="ME" id="select2">
			  <?php
					for($i=1;$i<=12;$i++)
					{	if (isset($ME)) {echo "<option value=\"$i\""; if($ME=="$i") echo "selected"; echo">$i</option>";}
						else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
					}
					?>
			</select>
			<select name="AE" id="select4">
			  <?php
					for($i=2003;$i<=2020;$i++)
					{	if (isset($AE)) {echo "<option value=\"$i\""; if( $AE=="$i" ) echo "selected"; echo">$i</option>";}
						else {echo "<option value=\"$i\""; if( $ano=="$i" ) echo "selected"; echo">$i</option>";}
					}
					?>
			</select>
		    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
			<a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font>		
			</center>
			<script language="JavaScript">
			 var form="form2";
			 var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
				cal.year_scroll = true;
				cal.time_comp = false;
			 var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
				cal1.year_scroll = true;
				cal1.time_comp = false;
			</script>		              
	    	</td>
	  <?php } ?>
	  <?php 
	  if ($op=="2") {
	  ?>
      		<td width="50%"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Proceso: </strong></font> 
			<select name="proceso">
			<option value=""></option>
			<option value="Backup General" <?php if ($proceso=="Backup General") echo "selected";?>>Backup General</option>
			<option value="Backup General por Fechas" <?php if ($proceso=="Backup General por Fechas") echo "selected";?>>Backup General por Fechas</option>
			<option value="Backup por Modulo" <?php if ($proceso=="Backup por Modulo") echo "selected";?>>Backup por Modulo</option>
			<option value="Backup por Modulo y Fechas" <?php if ($proceso=="Backup por Modulo y Fechas") echo "selected";?>>Backup por Modulo y Fechas</option>
			<option value="ctrabajo" <?php if ($proceso=="ctrabajo") echo "selected";?>>Copia de Trabajo</option>
			<option value="creacion_archivo" <?php if ($proceso=="creacion_archivo") echo "selected";?>>Creacion de archivo</option>
			<option value="creacion_modulo" <?php if ($proceso=="creacion_modulo") echo "selected";?>>Creacion de modulo</option>
			<option value="creacion_version" <?php if ($proceso=="creacion_version") echo "selected";?>>Creacion de version</option>
			<option value="descargado_ctrabajo" <?php if ($proceso=="descargado_ctrabajo") echo "selected";?>>Descargado de Copia de Trabajo</option>
			<option value="descargado_replica" <?php if ($proceso=="descargado_replica") echo "selected";?>>Descargado de Replica</option>
			<option value="eliminacion_archivo" <?php if ($proceso=="eliminacion_archivo") echo "selected";?>>Eliminacion de archivo</option>
			<option value="eliminacion_modulo" <?php if ($proceso=="eliminacion_modulo") echo "selected";?>>Eliminacion de modulo</option>
			<option value="eliminacion_version" <?php if ($proceso=="eliminacion_version") echo "selected";?>>Eliminacion de version</option>
			<option value="modificacion_modulo" <?php if ($proceso=="modificacion_modulo") echo "selected";?>>Modificacion de modulo</option>
			<option value="replica" <?php if ($proceso=="replica") echo "selected";?>>Replica</option>
			<option value="repositorio" <?php if ($proceso=="repositorio") echo "selected";?>>Repositorio</option>
			<option value="revision" <?php if ($proceso=="revision") echo "selected";?>>Revision</option>
			</select>
			</td>		
	  <?php } ?>
	  <?php 
	  if ($op=="3") {
	  ?>
      		
      <td width="50%"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Responsable: 
        </strong></font> <select name="responsable">
          <?php 
			  $sql6 = "SELECT DISTINCT(login_pista) FROM $tabla WHERE $condicion ORDER BY login_pista ASC";
			  $result6 = mysql_db_query($db,$sql6,$link);
			  while ($row6 = mysql_fetch_array($result6)) 
				{
					if ($responsable==$row6['login_pista']){
					echo "<option value=\"$row6[login_pista]\" selected>$row6[login_pista]</option>";
					}else{
					echo "<option value=\"$row6[login_pista]\">$row6[login_pista]</option>";
					}
				}
		  ?>
        </select></td>		
	  <?php } ?>
	  <?php 
	  if ($op=="4") {
	  ?>
      		<td width="50%"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Modulo: </strong></font> 
              <select name="modulo">
              <?php 
			  $sql7 = "SELECT DISTINCT(id_mod) FROM $tabla WHERE $condicion ORDER BY id_mod ASC";
			  $result7 = mysql_db_query($db,$sql7,$link);
			  while ($row7 = mysql_fetch_array($result7)) 
				{
					if ($modulo==$row7['id_mod']){
					echo "<option value=\"$row7[id_mod]\" selected>$row7[id_mod]</option>";
					}else{
					echo "<option value=\"$row7[id_mod]\">$row7[id_mod]</option>";
					}
	            }
			   ?>
			  </select>
			</td>		
	  <?php } ?>
	  <?php 
	  if ($op=="5") {
	  ?>
      		<td width="50%"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Archivo: </strong></font> 
              <select name="archivo">
              <?php 
			  $sql8 = "SELECT DISTINCT(id_arch) FROM $tabla WHERE $condicion ORDER BY id_arch ASC";
			  $result8 = mysql_db_query($db,$sql8,$link);
			  while ($row8 = mysql_fetch_array($result8)) 
				{
					if ($archivo==$row8['id_arch']){
					echo "<option value=\"$row8[id_arch]\" selected>$row8[id_arch]</option>";
					}else{
					echo "<option value=\"$row8[id_arch]\">$row8[id_arch]</option>";
					}
	            }
			   ?>
			  </select>
			</td>		
	  <?php } ?>
	  <?php 
	  if ($op=="6") {
	  ?>
      		<td width="50%"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Version: </strong></font> 
              <select name="version">
              <?php 
			  $sql10 = "SELECT DISTINCT(id_ver) FROM $tabla WHERE $condicion ORDER BY id_ver ASC";
			  $result10 = mysql_db_query($db,$sql10,$link);
			  while ($row10 = mysql_fetch_array($result10)) 
				{
					if ($version==$row10['id_ver']){
					echo "<option value=\"$row10[id_ver]\" selected>$row10[id_ver]</option>";
					}else{
					echo "<option value=\"$row10[id_ver]\">$row10[id_ver]</option>";
					}
	            }
			   ?>
			  </select>
			</td>		
	  <?php } ?>
	  <?php 
	  if ($op && $op!=="0"){
	  	echo "<td><input name=\"BUSCAR\" type=\"submit\" id=\"BUSCAR\" value=\"BUSCAR\"".$valid->onSubmit()."></td>";
		}
	  ?>
    </tr>
  </table>
</form>
<p>
<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top">
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="9">PISTAS DE AUDITORIA ANTERIORES</th>
        </tr>
        <tr align=\"center\"> 
          <th class="menu" width="50" align="center">Nro. DE PISTA</th>
		  <th class="menu" width="60" align="center">FECHA</th>
  		  <th class="menu" width="60" align="center">HORA</th>
  		  <th class="menu" width="200" align="center">PROCESO</th>
  		  <th class="menu" width="130" align="center">RESPONSABLE</th>
   		  <th class="menu" width="150" align="center">NOMBRE DEL MODULO</th>
   		  <th class="menu" width="130" align="center">NOMBRE DEL ARCHIVO</th>
   		  <th class="menu" width="150" align="center">NOMBRE DE LA VERSION</th>
   		  <th class="menu" width="250" align="center">OBSERVACIONES</th>
        </tr>
        <?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos = 20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$fechahoy=date("Y-m-d");
 	if (!$op2){//cuando se ingresa a la lista y no se ha realizado ninguna busqueda ni se ha cambiado de página
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM $tabla WHERE $condicion";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql0 = "SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM $tabla WHERE agrupar_pista='$id_pista' ORDER BY id_pista DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
	$result=mysql_db_query($db,$sql0,$link); 
	}else{//cuando ya se ha realizado alguna busqueda o se pasa de página sin realizar busquedas
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql_aux=$sql0;
	$sql0.=" LIMIT $_pagi_inicial,$_pagi_cuantos";
	$result=mysql_db_query($db,$sql0,$link); 
	$result_aux=mysql_db_query($db,$sql_aux,$link); 
	$pagi_totalReg=mysql_num_rows($result_aux);
	$_pagi_totalPags = ceil($pagi_totalReg / $_pagi_cuantos);
	}
	
while ($row=mysql_fetch_array($result)) {
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">&nbsp;$row[id_pista]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[fecha_pista2]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[hora_pista2]</font></td>";
	if ($row['accion']=="ctrabajo"){
		echo "<td><font size=\"1\">&nbsp;copia de trabajo</font></td>";
	}
	elseif ($row['accion']=="descargado_ctrabajo"){
		echo "<td><font size=\"1\">&nbsp;descargado de copia de trabajo</font></td>";
	}
	elseif ($row['accion']=="descargado_replica"){
		echo "<td><font size=\"1\">&nbsp;descargado de replica</font></td>";
	}
	else{
		echo "<td><font size=\"1\">&nbsp;$row[accion]</font></td>";
	}
	echo "<td><font size=\"1\">&nbsp;$row[login_pista]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[id_mod]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[id_arch]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[id_ver]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[observaciones]</font></td>";
}?>
      </table></td>
  </tr>
</table>
<br>
<form name="form1" method="post" action="pistas_fuentes3.php">
  <table width="75%" border="0" align="center">
    <tr> 
      <td><div align="center"> 
          <p><font size="2"><strong> Pagina(s) :&nbsp; 
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
	if ($op=="" || $op=="0"){
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&op2=1'>&laquo; Anterior</a>&nbsp;";
	}
	if ($op=="1"){
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&fec1=".$fec1."&fec2=".$fec2."&op2=1'>&laquo; Anterior</a>&nbsp;";
	}
	if ($op=="2"){
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&proceso=".$proceso."&op2=1'>&laquo; Anterior</a>&nbsp;";
	}
	if ($op=="3"){
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&responsable=".$responsable."&op2=1'>&laquo; Anterior</a>&nbsp;";
	}
	if ($op=="4"){
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&modulo=".$modulo."&op2=1'>&laquo; Anterior</a>&nbsp;";
	}
	if ($op=="5"){
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&archivo=".$archivo."&op2=1'>&laquo; Anterior</a>&nbsp;";
	}
	if ($op=="6"){
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&version=".$version."&op2=1'>&laquo; Anterior</a>&nbsp;";
	}
}
//Enlaces a numeros de página:
for ($_pagi_i = 1; $_pagi_i<=$_pagi_totalPags; $_pagi_i++){//Desde página 1 hasta ultima página ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el numero de página es la actual ($_pagi_actual). Se escribe el numero, pero sin enlace y en negrita.
        $_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
    }else{
		//Si es cualquier otro. Se escribe el enlace a dicho numero de página.
		if ($op=="" || $op=="0"){
		$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."&id_pista=".$id_pista."&op=".$op."&op2=1'>".$_pagi_i."</a>&nbsp;";
    	}
		if ($op=="1"){
		$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."&id_pista=".$id_pista."&op=".$op."&fec1=".$fec1."&fec2=".$fec2."&op2=1'>".$_pagi_i."</a>&nbsp;";
    	}
		if ($op=="2"){
		$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."&id_pista=".$id_pista."&op=".$op."&proceso=".$proceso."&op2=1'>".$_pagi_i."</a>&nbsp;";
    	}
		if ($op=="3"){
		$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."&id_pista=".$id_pista."&op=".$op."&responsable=".$responsable."&op2=1'>".$_pagi_i."</a>&nbsp;";
    	}
		if ($op=="4"){
		$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."&id_pista=".$id_pista."&op=".$op."&modulo=".$modulo."&op2=1'>".$_pagi_i."</a>&nbsp;";
    	}
		if ($op=="5"){
		$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."&id_pista=".$id_pista."&op=".$op."&archivo=".$archivo."&op2=1'>".$_pagi_i."</a>&nbsp;";
    	}
		if ($op=="6"){
		$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."&id_pista=".$id_pista."&op=".$op."&version=".$version."&op2=1'>".$_pagi_i."</a>&nbsp;";
    	}
	}
}

if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la ultima página. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual + 1;//será el numero de página al que enlazamos
	if ($op=="" || $op=="0"){
	$_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&op2=1'>Siguiente &raquo;</a>";
	}
	if ($op=="1"){
	$_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&fec1=".$fec1."&fec2=".$fec2."&op2=1'>Siguiente &raquo;</a>";
	}
	if ($op=="2"){
	$_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&proceso=".$proceso."&op2=1'>Siguiente &raquo;</a>";
	}
	if ($op=="3"){
	$_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&responsable=".$responsable."&op2=1'>Siguiente &raquo;</a>";
	}
	if ($op=="4"){
	$_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&modulo=".$modulo."&op2=1'>Siguiente &raquo;</a>";
	}
	if ($op=="5"){
	$_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&archivo=".$archivo."&op2=1'>Siguiente &raquo;</a>";
	}
	if ($op=="6"){
	$_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."&id_pista=".$id_pista."&op=".$op."&version=".$version."&op2=1'>Siguiente &raquo;</a>";
	}
}
print $_pagi_navegacion;
//Hasta acá hemos completado la "barra de navegacion"
?>
        </font></div></td>
  </tr>
</table>
</form>
<br>
<form name="form3" method="post" action="">
<input type="hidden" name="id_pista" value="<?php echo $id_pista; ?>">
  <table width="90%" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="46%"> <blockquote> 
          <div align="right">
            <input type="submit" name="RETORNAR" value="RETORNAR">
          </div>
        </blockquote></td>
      <td><blockquote>
          <p>
            <input type="submit" name="IMPRIMIR" value="IMPRIMIR" onClick="imprimir()">
          </p>
        </blockquote></td>
    </tr>
  </table>
    </form>
<?php include("top_.php");?> 
</body>
</html>
<script language="JavaScript">
function imprimir()
{	//window.open("pistas_print.php?id_pista="+id_pista);
	window.open("pistas_print.php?id_pista="+id_pista,'Estadìsticas', 'width=610,height=200,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
</script>