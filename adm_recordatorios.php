<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
require ("conexion.php");
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
$id=$_REQUEST['id'];
if (isset($_REQUEST['Terminar'])) header("location: menu_parametros.php");
include ("top.php");
if (isset($_REQUEST['ejecutar']) && $_REQUEST['ejecutar']=="eliminar")
{	$sql = "DELETE FROM recordatorios WHERE id_record='$id'";
        //print_r($sql);exit;
	mysql_query( $sql);
}
//$tipo_emision= $_REQUEST['tipo_emision'];
if (isset($_REQUEST['GUARDAR']))
{	$fecha_creacion = date("Y-m-d");
        $tipo_emision= $_REQUEST['tipo_emision'];
	if ($tipo_emision=="3")
	{	if ( strlen($_REQUEST['DA']) < 2 ){ $_REQUEST['DA'] = "0".$_REQUEST['DA']; } 
		if ( strlen($_REQUEST['MA']) < 2 ){ $_REQUEST['MA'] = "0".$_REQUEST['MA'];}	
		if ( strlen($_REQUEST['DE']) < 2 ){ $_REQUEST['DE'] = "0".$_REQUEST['DE']; } 
		if ( strlen($_REQUEST['ME']) < 2 ){ $_REQUEST['ME'] = "0".$_REQUEST['ME'];}	
		$fecha1 = $_REQUEST['AA']."-".$_REQUEST['MA']."-".$_REQUEST['DA'];
		$fecha2 = $_REQUEST['AE']."-".$_REQUEST['ME']."-".$_REQUEST['DE'];
	}
	else
	{	$fecha1 = "";
		$fecha2 = "";	
	}
	$sql_msg = "INSERT INTO recordatorios (tipo_tarea, IdProgTarea,mensaje,tipo_emision,fec_emision,fec_emision2,fec_creacion,login_creador) 
	 VALUES('$_REQUEST[tipo_tarea]','$_REQUEST[tarea]','$_REQUEST[mensaje]','$tipo_emision', '$fecha1', '$fecha2','$fecha_creacion','$login')";
	//print_r($sql_msg);exit; 
        mysql_query($sql_msg);
}

?>
<html>
<head>
<title>Recordatsorios</title>
<link rel=stylesheet href="general.css" type="text/css">
<script lenguaje="javascript" type="text/javascript">
function irapagina(pagina){         
 		 if (pagina!="") {	
     	 	self.location = pagina;
 		 }
}
function cambio2(numero){        
		 if (!foco_texto){
				 irapagina("adm_recordatorios.php?Naveg=Seguridad >> Recordatorios&op="+numero);
		 } 
}

function cambio(numero){        	
	if (numero == 2) 
	{	form1.DA.disabled = 0;  
		form1.MA.disabled = 0;  
		form1.AA.disabled = 0;  
		form1.DE.disabled = 0;  
		form1.ME.disabled = 0;  
		form1.AE.disabled = 0;  
	}	
	else
	{	form1.DA.disabled = 1;  
		form1.MA.disabled = 1;  
		form1.AA.disabled = 1;  
		form1.DE.disabled = 1;  
		form1.ME.disabled = 1;  
		form1.AE.disabled = 1;  	
	} 
}
var foco_texto=false;
function detectKey() {
	if (event.ctrlKey) {
	event.ctrlkey=0;
	return false; 
	} 
	if (event.altKey) {
	event.altKey=0;
	return false;
	}
	if(window.event && window.event.keyCode == 116){
	window.event.keyCode = 0;
	return false;
	}
	document.onkeydown = detectKey;
}
</script>
</head>
<body onLoad="detectKey()">
<?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM recordatorios";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
//=====end Pag.

?>
<script language="JavaScript" src="calendar.js"></script>
<table width="90%" align="center" background="images/fondo.jpg" border="1" cellspacing="0">
<th colspan="7" background="images/main-button-tileR1.jpg" height="22">RECORDATORIOS</th>
<tr class="tit_form" bgcolor="#006699" align="center">
	<td width="3%" background="images/main-button-tileR2.jpg"><font color="#FFFFFF">Nro.</font></td>
	<td width="29%" background="images/main-button-tileR2.jpg"><font color="#FFFFFF">Tarea</font></td>
	<td width="24%" background="images/main-button-tileR2.jpg"><font color="#FFFFFF">descripcion</font></td>	
	<td width="7%" background="images/main-button-tileR2.jpg"><font color="#FFFFFF">Tipo tarea</font></td>
	<td width="16%" background="images/main-button-tileR2.jpg"><font color="#FFFFFF">Dia cumplimiento tarea periodo actual</font></td>	
	<td width="15%" background="images/main-button-tileR2.jpg"><font color="#FFFFFF">Emision Mensaje</font></td>
	<td width="6%" background="images/main-button-tileR2.jpg"><font color="#FFFFFF">Eliminar</font></td>
</tr>
<?php  $sql = "SELECT *, DATE_FORMAT(fec_emision, '%d/%m/%Y') AS fec_emision,  DATE_FORMAT(fec_emision2, '%d/%m/%Y') AS fec_emision2 FROM recordatorios ORDER BY id_record DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
	$res = mysql_query($sql);
	while ( $row = mysql_fetch_array($res) )
	{
	 //if ($row[tipo_tarea] == 0) $tipo_tarea = "General";
	 $fecha = getdate();
	 if ($row['tipo_tarea'] == 1) 
	 {	$tipo_tarea = "Semanal";
	 	$sql_tarea  = "SELECT * FROM progtareassemanal WHERE IdProgTarea = '$row[IdProgTarea]'";
		$row_tarea  = mysql_fetch_array(mysql_query($sql_tarea));
		$fec_cumpli = $row_tarea['Dia'];
		
		$fec_dia = date("l-m-Y");		
		$fec_num = date("j-n-Y");		
		$fec_datos = explode ("-", $fec_dia);		
		if ($fec_datos[0] == "Wednesday")
		{
			//okey
		}
		//isset($dia_en);		
		if ($row_tarea['Dia'] == "Domingo")  { $dia_en = "Sunday"; }
		if ($row_tarea['Dia'] == "Lunes")    { $dia_en = "Monday"; }
		if ($row_tarea['Dia'] == "Martes")   { $dia_en = "Tuesday"; }
		if ($row_tarea['Dia'] == "Miercoles"){ $dia_en = "Wednesday"; }
		if ($row_tarea['Dia'] == "Jueves")   { $dia_en = "Thursday"; }
		if ($row_tarea['Dia'] == "Viernes")  { $dia_en = "Friday"; }
		if ($row_tarea['Dia'] == "Sabado")   { $dia_en = "Saturday"; }
		
		if ($fec_datos[0] == isset($dia_en))
		{	if ($row['tipo_emision'] == 1){ }
				
		}
		$fec_dia = date("l-m-d", mktime(0,0,0, 7, 31, 2005));
		//**echo $fec_dia;
	 }
	 if ($row['tipo_tarea'] == 2) 
	 {	$tipo_tarea  = "Mensual";
		$sql_tarea   = "SELECT * FROM progtareasmensual WHERE IdProgTarea = '$row[IdProgTarea]'";	 
	 	$row_tarea   = mysql_fetch_array(mysql_query($sql_tarea));
		$fec_cumpli  = $row_tarea['Dia']."/".$fecha['mon']."/".$fecha['year'];
		$fec_cumpli2 = date("Y-m-d", mktime(0,0,0, $fecha['mon'], $row_tarea['Dia'], $fecha['year']));
		$sql_update  = "UPDATE recordatorios SET fec_cumpli = '$fec_cumpli2' WHERE id_record='$row[id_record]'";
		mysql_query($sql_update);
	 }
	 if ($row['tipo_tarea'] == 3) 
	 {		 
	 	$tipo_tarea = "Trimestral";
		if ($row['IdProgTarea'] != 0)
		{	$sql_tarea  = "SELECT * FROM progtareastrimestral WHERE IdProgTarea = '$row[IdProgTarea]'";
			$row_tarea  = mysql_fetch_array(mysql_query($sql_tarea));
			$fec = explode ("-", $row_tarea['FechaDe']);
			if (substr($fec[1],0,1) == "0" ) $mes = substr($fec[1],1,1); 
			else $mes = $fec[1];
			if (substr($fec[2],0,1) == "0" ) $dia = substr($fec[2],1,1); 
			else $dia = $fec[2];
			$ano =  $fec[0];
			$anterior = mktime(0,0,0, $mes, $dia, $ano);
			$actual = mktime(0,0,0, $fecha['mon'], $fecha['mday'], $fecha['year']);
			while ( $anterior < $actual)	
			{	$fec_ant = date("n-j-Y", mktime(0,0,0, $mes + 3,$dia, $ano));						
				$ant = explode ("-",$fec_ant);		
				$mes = $ant[0];
				$dia = $ant[1];
				$ano = $ant[2];			
				$anterior = mktime(0,0,0, $mes, $dia, $ano);		
			}		
			 $fec_ini= date("n-j-Y", mktime(0,0,0, $mes-3, $dia, $ano));
			 $ant = explode ("-",$fec_ini);		
			 $mes = $ant[0];
			 $dia = $ant[1];
			 $ano = $ant[2];
			 $fec_cumpli  = date("j/n/Y", mktime(0,0,0, $mes + ($row_tarea['Mes']-1), $dia + $row_tarea['Dia'], $ano));
			 $fec_cumpli2 = date("Y-m-d", mktime(0,0,0, $mes + ($row_tarea['Mes']-1), $dia + $row_tarea['Dia'], $ano));
			 $sql_update  = "UPDATE recordatorios SET fec_cumpli = '$fec_cumpli2'  WHERE id_record='$row[id_record]'";
			 mysql_query($sql_update);				 		 		
	 	}		
	 }
	 	 
	 if ($row['tipo_tarea'] == 4) 
	 {	$tipo_tarea = "Semestral";
	 	if ($row['IdProgTarea'] != 0)
	 	{	$sql_tarea  = "SELECT * FROM progtareassemestral WHERE IdProgTarea = '$row[IdProgTarea]'";
	 		$row_tarea  = mysql_fetch_array(mysql_query($sql_tarea));
			$fec = explode ("-", $row_tarea['FechaDe']);
			if (substr($fec[1],0,1) == "0" ) $mes = substr($fec[1],1,1); 
			else $mes = $fec[1];
			if (substr($fec[2],0,1) == "0" ) $dia = substr($fec[2],1,1); 
			else $dia = $fec[2];
			$ano = $fec[0];
			$anterior = mktime(0,0,0, $mes, $dia, $ano);
			$actual = mktime(0,0,0, $fecha['mon'], $fecha['mday'], $fecha['year']);
			while ( $anterior < $actual)	
			{	$fec_ant = date("n-j-Y", mktime(0,0,0, $mes + 6, $dia, $ano));						
				$ant = explode ("-",$fec_ant);		
				$mes = $ant[0];
				$dia = $ant[1];
				$ano = $ant[2];			
				$anterior = mktime(0,0,0, $mes, $dia, $ano);		
			}					
			$fec_ini= date("n-j-Y", mktime(0,0,0, $mes-6, $dia, $ano));			
			$ant = explode ("-",$fec_ini);		
			$mes = $ant[0];
			$dia = $ant[1];
			$ano = $ant[2];		 			
		    $fec_cumpli  = date("j/n/Y", mktime(0,0,0, $mes + ($row_tarea['Mes']-1), $dia + $row_tarea['Dia'], $ano));
			$fec_cumpli2 = date("Y-m-d", mktime(0,0,0, $mes + ($row_tarea['Mes']-1), $dia + $row_tarea['Dia'], $ano));
			$sql_update  = "UPDATE recordatorios SET fec_cumpli = '$fec_cumpli2'  WHERE id_record='$row[id_record]'";
			mysql_query($sql_update);		
	 	}	 	 
	 }
	 
	 if ($row['tipo_tarea'] == 5) 
	 {	$tipo_tarea = "Anual";
	 	if ($row['IdProgTarea'] != 0) 
		{	$sql_tarea = "SELECT * FROM progtareasanual WHERE IdProgTarea = '$row[IdProgTarea]'";	
			$row_tarea  = mysql_fetch_array(mysql_query($sql_tarea));
			$fec = explode("-",$row_tarea['Dia']);
			$fec_cumpli = $fec[2]."/".$fec[1]."/".$fec[0]; 
			$sql_update = "UPDATE recordatorios SET fec_cumpli = '$row_tarea[Dia]' WHERE id_record='$row[id_record]'";
			mysql_query($sql_update);				
		}	
	 }
	 
	  if ($row['IdProgTarea'] == 0) { $row_tarea['Actividad'] = "General"; $fec_cumpli = "General";}
	 			
	 if ($row['fec_emision']  == "00/00/0000") $row['fec_emision']  = "";
	 if ($row['fec_emision2'] == "00/00/0000") $row['fec_emision2'] = "";
	 
	 if ($row['tipo_emision'] == 1) $tipo_emision = "El ultimo dia";
	 if ($row['tipo_emision'] == 2) $tipo_emision = "Dos dias antes";
	 if ($row['tipo_emision'] == 3) $tipo_emision = $row['fec_emision']." - ".$row['fec_emision2'];
?>
<tr class="tit_form" align="center" >
	<td width="3%"><?php echo  $row['id_record'];?></td>
	<td width="29%"><?php echo $row_tarea['Actividad'];?></td>
	<td width="24%"><?php echo $row['mensaje'];?> &nbsp;</td>
	<td width="7%"><?php echo  $tipo_tarea;?></td>
	<td width="16%"><?php echo $fec_cumpli;?>&nbsp; </td>
	<td width="15%"><?php echo $tipo_emision;?></td>
	<td width="6%"><?php echo "<a href=\"?ejecutar=eliminar&id=$row[id_record]\"onClick=\"return confirmLink(this,'$row[id_record]')\"> <img src=\"images/eliminar.gif\" border=\"0\" alt=\"Eliminar\"></a>"; ?></td>
</tr>
<?php }?>
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
<form name="form1" method="post">
<table width="822" background="images/fondo.jpg" align="center" border="1" cellspacing="0">
<tr class="titulo2" align="center" bgcolor="#006699">
	<td width="127" class="titulo2" background="images/main-button-tileR1.jpg" height="22"><font color="#FFFFFF">TAREA</font></td>
	<td width="217" class="titulo2" background="images/main-button-tileR1.jpg" height="22"><font color="#FFFFFF">Descripcion</font></td>
	<td width="464" class="titulo2" background="images/main-button-tileR1.jpg" height="22"><font color="#FFFFFF">Fecha de emision</font></td>	
</tr>	
<tr align="center">
	<td width="127">		
	<select name="tipo_tarea" onChange="cambio2(this.options.selectedIndex)">
            <option value="1" <?php if (isset($op)=="0") print 'selected' ?>>Semanales  
            <option value="2" <?php if (isset($op)=="1") print 'selected' ?>>Mensuales
            <option value="3" <?php if (isset($op)=="2") print 'selected' ?>>Trimestrales
            <option value="4"  <?php if (isset($op)=="3") print 'selected' ?>>Semestrales
            <option value="5" <?php if (isset($op)=="4") print 'selected' ?>>Anuales
	</select><br><br>
	<?php 
		$sql = "SELECT IdProgTarea, Actividad FROM progtareassemanal";
		if (isset($op)){
			if ($op == 1) $sql = "SELECT IdProgTarea, Actividad FROM progtareasmensual";
			if ($op == 2) $sql = "SELECT IdProgTarea, Actividad FROM progtareastrimestral";
			if ($op == 3) $sql = "SELECT IdProgTarea, Actividad FROM progtareassemestral";
			if ($op == 4) $sql = "SELECT IdProgTarea, Actividad FROM progtareasanual"; 		
		}
		$res = mysql_query($sql);			
	?>   	 <select name="tarea">
      <option value="0">General
      <?php while ($row = mysql_fetch_array($res)){?>
      <option value="<?php echo $row['IdProgTarea'];?>">
      <?php if (strlen($row['Actividad']) < 30) echo $row['Actividad']; else echo substr($row['Actividad'],0,30)."...";?>
      <?php }?>
        </select> </td>	
	<td>	
      <textarea name="mensaje" cols="32" rows="4"></textarea>	</td>
	<td>	
	<select name="tipo_emision" onChange="cambio(this.options.selectedIndex)">
	<option value="1" >El ultimo dia
	<option value="2">Dos dias antes 
	<option value="3">Una fecha especifica	
	</select><br><br>
	<?php //if ($op == 3) {?>
	Del:</b></font> 
              <select name="DA" id="select" class="tit_form" disabled>
  			<?php		  		
				$fsist = date("Y-m-d");				
  				$ano = substr($fsist,0,4);
				$mes = substr($fsist,5,2);
				$dia = substr($fsist,8,2);				
				for($i=1;$i<=31;$i++)
				{	if ( isset ($DA) ){ echo "<option value=\"$i\""; if($DA=="$i") echo "selected"; echo">$i</option>";	}
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
			</select>
			<select name="MA" id="select9" disabled class="tit_form">
                <?php				
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) ) {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}				
				?>
      </select>
            <select name="AA" id="select6" disabled class="tit_form">
              <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($AA) ) {echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
            </select>		
            <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a>&nbsp;&nbsp;</font>
        Al:
        <select name="DE" id="select7" disabled class="tit_form">
        <?php
			$fsist=date("Y-m-d");
  			$ano=substr($fsist,0,4);
			$mes=substr($fsist,5,2);
			$dia=substr($fsist,8,2);				
			for($i=1;$i<=31;$i++)
			{	if (isset($DE)) {echo "<option value=\"$i\""; if($DE=="$i") echo "selected"; echo">$i</option>";}
				else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
			}
				?>
      </select>
        <select name="ME" id="select2" disabled class="tit_form">
          <?php
				for($i=1;$i<=12;$i++)
				{	if (isset($ME)) {echo "<option value=\"$i\""; if($ME=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
        </select>
        <select name="AE" id="select4" disabled class="tit_form">
          <?php
				for($i=2003;$i<=2020;$i++)
				{	if (isset($AE)) {echo "<option value=\"$i\""; if( $AE=="$i" ) echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if( $ano=="$i" ) echo "selected"; echo">$i</option>";}
				}
				?>
        </select>
       <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font>		
	<?php //}else { echo "<br>";}?>		
	</td>	
</tr>
</table>
<br>
<table width="285" align="center">
<tr>
	<td width="88"><input type="submit" name="GUARDAR" value="  GUARDAR  "></td>
	<td width="93">&nbsp;</td>
	<td width="88"><input type="submit" name="Terminar" value="RETORNAR"></td>
</tr>
</table>
</form>
</body>
</html>
<script language="JavaScript">
		var form="form1";
		var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		 	cal.year_scroll = true;
			cal.time_comp  = false;
		var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;		
			
function confirmLink(theLink, archi)
{
    var is_confirmed = confirm("Desea realmente eliminar el recordtorio"+ ' :\n\t Nro. ' +"" + archi + "\n\nMensaje generado por GesTor F1");
    if (is_confirmed) {
        theLink.href += '&confirmado=1&Naveg=Seguridad >> Recordatorios';
    }
    return is_confirmed;
} // end of the 'con firmLink()' function
			
</script>