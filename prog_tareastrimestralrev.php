<?php if (isset($Terminar)) 
header("location: lista_progtareas2.php");
include("top.php");
require_once('funciones.php');
if (isset($INSERTAR))
{   
	if($action=="revisar"){
		$sql="UPDATE progtareastrimestral1 SET RevisadoPor='$_SESSION[login]', RevisadoPorFecha='".date("Y-m-d H:i:s")."', Aprobacion='$Aprobacion', RevisadoPorObs='$Observaciones', Revisado=1 WHERE IdProgTarea1=$IdProgTarea1";
		mysql_db_query($db, $sql);
	}
	else {
		$sql="INSERT INTO progtareastrimestral1 (IdProgTarea, FechaProceso, RealizadoPor, Realizacion, RealizadoPorObs) VALUES ($IdProgTarea, '".date("Y-m-d H:i:s")."', '$_SESSION[login]', '$Aprobacion', '$Observaciones')";
		mysql_db_query($db, $sql);
	}
	if(mysql_affected_rows()!=1) //$errorMsg="Precaucion, no se ha registrado los datos. Por favor, intentelo nuevamente. \\n\\nMensaje generado por GesTor F1.";
}

$sql="SELECT login_usr, CONCAT(apa_usr, ' ', ama_usr, ' ', nom_usr) AS Nombre FROM users";
$rs=mysql_db_query($db, $sql);
while($tmp=mysql_fetch_array($rs)){
	$lstUsuario[$tmp['login_usr']]=$tmp['Nombre'];
}

?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addLength ( "Observaciones",  "Observaciones, $errorMsgJs[length]" );
print $valid->toHtml ();
?>
<script language="JavaScript" src="calendar.js"></script>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<table width="95%" border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
  <tr>
    <th colspan="7" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">PROGRAMACION DE TAREAS - TRIMESTRALES</font></th>
  </tr>
  <tr align="center">
    <th width="54" rowspan="2" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></th>
    <th width="120" rowspan="2" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha de Programacion</font></th>
    <th colspan="2" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Hora</font></th>
    <th width="260" rowspan="2" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Dia</font></th>
    <th width="260" rowspan="2" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Actividad</font></th>
    <th width="162" rowspan="2" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Observaciones</font></th>
  </tr>
  <tr align="center">
    <th width="120" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">De</font></th>
    <th width="120" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">A</font></th>
  </tr>
  <?php
		$IdProgTarea=SanitizeString($IdProgTarea);
		$sql = "SELECT *, DATE_FORMAT(FechaDe, '%d/%m/%Y') AS FechaDe FROM progtareastrimestral WHERE IdProgTarea='$IdProgTarea'";
		$result=mysql_db_query($db,$sql,$link);
		$row=mysql_fetch_array($result);
  		 ?>
  <tr align="center">
  	<td><?php=$row['IdProgTarea']?></td>
      <td><?php=$row['FechaDe']?></td>
      <td><div align="center">&nbsp;<?php echo $row['HoraDe']?></div></td>
      <td><div align="center">&nbsp;<?php echo $row['HoraA']?></div></td>
      <td><div align="center">&nbsp;<?php echo $row['Dia']?></div></td>	  
      <td><div align="center">&nbsp;<?php echo $row['Actividad']?></div></td>
      <td><div align="center">&nbsp;<?php echo $row['Observaciones']?></div></td>
  </tr>
</table>
<br><form action="" method="get" name="form3" id="form3" >
<table width="80%" border="1" align="center" bgcolor="#006699">
  <tr>
    <td width="60%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>
      </strong></font>
        <table width="90%" border="0">
          <tr>
            <td width="74%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>
                <input name="IdProgTarea" type="hidden" id="IdProgTarea" value="<?php echo $IdProgTarea?>">
  Busqueda por :</strong></font>
                  <select name="menu" id="menu">
                    <option value="general">General</option>
                    <option value="realizado"<?php if ($menu=="realizado") print selected?>>Realizado por</option>
                    <option value="revisado"<?php if ($menu=="revisado") print selected?>>Revisado por</option>
                  </select>
&nbsp;&nbsp;
  <select name="selecta">
      <option value="%">General</option>
      <?php
			$sqltec="SELECT * from users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr";
			$resultec= mysql_db_query($db,$sqltec,$link);
			while($rowtec= mysql_fetch_array($resultec)){
			?>
      <option value="<?php echo $rowtec['login_usr']?>"<?php if ($selecta==$rowtec['login_usr']) print selected ?>><?php echo "$rowtec[apa_usr]"." $rowtec[ama_usr]"." $rowtec[nom_usr]"?></option>
      <?php
			}
			?>
  </select>
  <br><br>
  <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Del:</strong></font>
  <select name="DA" id="select">
      <?php		  		
				$fsist=date("Y-m-d");				
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);
				for($i=1;$i<=31;$i++)
				{	if ( isset ($DA) ){echo "<option value=\"$i\""; if($DA=="$i") echo "selected"; echo">$i</option>";}						
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
  </select>
  <select name="MA" id="select9">
      <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) )  {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else  {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
					}
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
  <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> &nbsp;<font color="#FFFFFF"><strong> Al:</strong></font>
  <select name="DE" id="select7">
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
  <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></font></div></td>
  <script language="JavaScript">
<!--
	var form="form3";
	var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		cal.year_scroll = true;
		cal.time_comp = false;
	var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
		cal1.year_scroll = true;
		cal1.time_comp = false;
	-->
</script>		
            <td width="26%"><div align="center">
              <input name="BUSCAR" type="submit" id="BUSCAR" value="BUSCAR">
            </div></td>
          </tr>
        </table>
        <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>
      </strong></font>        </div></td>
  </tr>
</table>
</form>
<table width="80%"  border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
  <tr align="center">
    <th colspan="8"><font size="3">REALIZACION/REVISION</font></th>
  </tr>
  <tr align="center">
    <th><font size="2">Nro.</font></th>
    <th><font size="2">Realizado por </font></th>
    <th><font size="2">Fecha/Hora</font></th>
    <th><font size="2">Realizacion</font></th>
    <th><font size="2">Revisado Por </font></th>
    <th><font size="2">Fecha/Hora</font></th>
    <th><font size="2">Aprobacion</font></th>
    <th><font size="2">Revision</font></th>
  </tr>
<?php	
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

if(isset($menu)){	
	if (strlen($DA) == 1){ $DA = "0".$DA; }
	if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
    $fec1 = $AA."-".$MA."-".$DA;   
	if (strlen($DE) == 1){ $DE = "0".$DE; }
	if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fec2 = $AE."-".$ME."-".$DE." 23:59:59";
	}
switch (isset($menu)){
case "realizado":
	$cond = "AND RealizadoPor LIKE '$selecta' AND FechaProceso BETWEEN '$fec1' AND '$fec2'";
	break;
case "revisado":
	$cond = "AND RevisadoPor LIKE '$selecta' AND RevisadoPorFecha BETWEEN '$fec1' AND '$fec2'";
	break;
default:
	$cond = "";
	break;
}
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM progtareastrimestral1 WHERE IdProgTarea='$IdProgTarea' $cond";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
		$sql = "SELECT *, DATE_FORMAT(FechaProceso, '%d/%m/%Y %H:%i:%s') AS FechaProceso, DATE_FORMAT(RevisadoPorFecha, '%d/%m/%Y %H:%i:%s') AS RevisadoPorFecha FROM progtareastrimestral1 WHERE IdProgTarea='$IdProgTarea' $cond ORDER BY IdProgTarea1 DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
		$rs=mysql_db_query($db,$sql,$link);
		print mysql_error();
		while($tmp=mysql_fetch_array($rs)){
			print "<tr>";
			print "<td align=\"center\">$tmp[IdProgTarea1]</td>";
			print "<td align=\"center\">".$lstUsuario[$tmp['RealizadoPor']]."</td>";
			print "<td align=\"center\">$tmp[FechaProceso]</td>";
			print "<td align=\"center\">$tmp[Realizacion]</td>";
			print "<td align=\"center\">&nbsp;".$lstUsuario[$tmp['RevisadoPor']]."</td>";
			if($tmp['RevisadoPorFecha']=="00/00/0000 00:00:00") print "<td>&nbsp;</td>";
			else print "<td align=\"center\">$tmp[RevisadoPorFecha]</td>";
			print "<td align=\"center\">&nbsp;$tmp[Aprobacion]</td>";
			if($tmp["Revisado"]==1) print "<td align=\"center\"><img src=\"images/ok.gif\" border=\"0\"></td>";
			else {
				if($_SESSION['tipo']=="A"  || $tmp['RealizadoPor']!=$_SESSION['login']) print "<td align=\"center\"><a href=\"prog_tareastrimestralrev.php?do=revisar&IdProgTarea=$IdProgTarea&IdProgTarea1=$tmp[IdProgTarea1]\"><img src=\"images/no3.gif\" border=\"0\"></a></td>";
				else print "<td align=\"center\"><img src=\"images/no2.gif\" border=\"0\"></td>";				
			}
			print "</tr>";
		}
  		 ?>  
</table>

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
<div align="center"><br>
  <input name="IMPRIMIR" type="button" onClick="enviar()" id="IMPRIMIR" value="  IMPRIMIR  ">
</div>
<form action="prog_tareastrimestralrev.php" method="get" name="form2" id="form2" onKeyPress="return Form()">
	<input name="IdProgTarea" type="hidden" value="<?php echo $IdProgTarea;?>">
	<input name="IdProgTarea1" type="hidden" id="IdProgTarea1" value="<?php=$_GET['IdProgTarea1']?>">
	<input name="action" type="hidden" id="action" value="<?php echo $do;?>">
	<input name="pg" type="hidden" id="pg" value="<?php echo $pg;?>"> 
	<?php if($do =="revisar"){?>
	<table width="80%"  border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr align="center">
      <th colspan="4"><font size="3">REVISION Nro. 
      <?php=$IdProgTarea1?></font></th>
    </tr>
    <tr align="center">
      <th><font size="2">Revisado por </font></th>
      <th><font size="2">Aprobacion</font></th>
      <th><font size="2">Observaciones</font></th>
    </tr>
    <tr align="center">
      <td><?php=$lstUsuario[$_SESSION[login]]?></td>
      <td> <font size="2" face="Arial, Helvetica, sans-serif">
        <input name="Aprobacion" type="radio" value="SI" checked <?php if ($row3[Aprobacion]=="SI") echo "checked";?>>
      SI</font> <font size="2" face="Arial, Helvetica, sans-serif"><br>
&nbsp;
      <input type="radio" name="Aprobacion" value="NO" <?php if ($row3[Aprobacion]=="NO") echo "checked";?>>
      NO</font> <font size="2" face="Arial, Helvetica, sans-serif"><br>
&nbsp;
      <input type="radio" name="Aprobacion" value="NA" <?php if ($row3[Aprobacion]=="NA") echo "checked";?>>
      NA</font> </td>
      <td><font size="2" face="Arial, Helvetica, sans-serif">
        <textarea name="Observaciones" cols="15" id="Observaciones"><?php echo $row3[Observac]?></textarea>
      </font></td>
    </tr>
    <tr align="center">
      <td height="50" colspan="4">
        <input name="INSERTAR" type="submit" id="INSERTAR" value="INSERTAR REVISION"<?php print $valid->onSubmit() ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="submit" name="Terminar" value="RETORNAR"></td>
    </tr>
  </table>
	<?php } else {?>
  <table width="80%"  border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr align="center">
      <th colspan="4"><font size="3">REALIZACION</font></th>
    </tr>
    <tr align="center">
      <th><font size="2">Realizado por </font></th>
      <th><font size="2">Realizacion</font></th>
      <th><font size="2">Observaciones</font></th>
    </tr>
    <tr align="center">
      <td><?php=$lstUsuario[$_SESSION['login']]?></td>
      <td> <font size="2" face="Arial, Helvetica, sans-serif">
        <input name="Aprobacion" type="radio" value="SI" checked <?php if ($row3[Aprobacion]=="SI") echo "checked";?>>
      SI</font> <font size="2" face="Arial, Helvetica, sans-serif"><br>
&nbsp;
      <input type="radio" name="Aprobacion" value="NO" <?php if ($row3[Aprobacion]=="NO") echo "checked";?>>
      NO</font> <font size="2" face="Arial, Helvetica, sans-serif"><br>
&nbsp;
      <input type="radio" name="Aprobacion" value="NA" <?php if ($row3[Aprobacion]=="NA") echo "checked";?>>
      NA</font> </td>
      <td><font size="2" face="Arial, Helvetica, sans-serif">
        <textarea name="Observaciones" cols="15" id="Observaciones"><?php echo $row3[Observac]?></textarea>
      </font></td>
    </tr>
    <tr align="center">
      <td height="50" colspan="4">
        <input name="INSERTAR" type="submit" id="INSERTAR" value="INSERTAR REALIZACION"<?php print $valid->onSubmit() ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="submit" name="Terminar" value="RETORNAR"></td>
    </tr>
  </table>
  <?php }?>
</form>
<script language="JavaScript">
		<!-- 
		<?php if($errorMsg) print "alert(\"$errorMsg\");";
		?>
function enviar(){
	var IdProgTarea="<?php echo $IdProgTarea?>";
	open("report_tarea.php?IdProgTarea="+IdProgTarea+"&tarea=trimestral","TAREAS",'width=590,height=200,status=no,resizable=no,toolbars=no,top=0,left=250,dependent=yes,alwaysRaised=yes')
}
//-->
</script>
<?php include("top_.php");?>