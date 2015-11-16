<?php if (isset($Terminar)) header("location: lista_progtareas2.php");
include("conexion.php");
require_once('funciones.php');
if($IdProgTarea <> "")
{
	$sCon = "select *from progtareassemestral WHERE IdProgTarea=$IdProgTarea";
	//echo "<br>sql  : ".$sCon;
	$rCon = mysql_db_query($db,$sCon,$link);
	$resul = mysql_fetch_array($rCon);
	$cadbd = $resul[sm_asig];
	$varcad = explode("|", $cadbd);
	$numcad = count($varcad) - 1;
	//echo "<br>num cad : ".$numcad;
}
	

if (isset($INSERTAR))
{   include("conexion.php");
	
	$dim = $nomAsig;
	$numero = count($dim)-1;
	
	$cadena = $dim[0];
	for($i=1; $i<=$numero; $i++)
	{
			$cadena = $cadena."|".$dim[$i];
	}	
	$cadena = $cadena."|";
	$variable = explode("|",$cadena);
	$num = count($variable)-1;
	
	
	
	if($numero == -1){$cadena = 0;}
	
	$FechaProceso="$AnoP-$MesP-$DiaP";
	$HoraDe="$Hora1:$Min1";
	$HoraA="$Hora2:$Min2";
	if($action=="editar")
	{
		$Actividad=SanitizeString($Actividad);
		$HoraDe=SanitizeString($HoraDe);
		$HoraA=SanitizeString($HoraA);
		$FechaProceso=SanitizeString($FechaProceso);
		$Observaciones=SanitizeString($Observaciones);
		$cadena=SanitizeString($cadena);
		$sql="UPDATE progtareassemestral SET Actividad='$Actividad', HoraDe='$HoraDe', HoraA='$HoraA', FechaDe='$FechaProceso', Observaciones='$Observaciones', Dia='$Dia', Mes=$Mes, sm_asig='$cadena' WHERE IdProgTarea=$IdProgTarea";
	}
	else
	{	$Actividad=SanitizeString($Actividad);
		$HoraDe=SanitizeString($HoraDe);
		$HoraA=SanitizeString($HoraA);
		$FechaProceso=SanitizeString($FechaProceso);
		$Observaciones=SanitizeString($Observaciones);
		$cadena=SanitizeString($cadena);
		$sql="INSERT INTO ".
		"progtareassemestral (Actividad, HoraDe, HoraA, FechaDe, Observaciones, Dia, Mes, sm_asig) ".
		"VALUES ('$Actividad','$HoraDe','$HoraA','$FechaProceso','$Observaciones', '$Dia', $Mes, '$cadena')";
	}	
	mysql_db_query($db,$sql,$link);
	if(mysql_affected_rows()!=1) $errorMsg="Precaucion, no se han registrado los datos. Por favor, intentelo nuevamente. \\n\\nMensaje generado por GesTor F1.";
	header("location: lista_progtareas2.php");
}
include("top.php");
if($_GET["do"]=="editar"){
	$sql="SELECT * FROM progtareassemestral WHERE IdProgTarea=".$_GET["IdProgTarea"];
	$wTarea=mysql_fetch_array(mysql_db_query($db, $sql));
}
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsDate   ( "DiaP", "MesP", "AnoP", "Fecha, $errorMsgJs[date]" );
$valid->addIsTextNormal ( "Actividad",  "Actividad, $errorMsgJs[expresion]" );
$valid->addLength ( "Actividad",  "Actividad, $errorMsgJs[length]" );
$valid->addLength ( "Observaciones",  "Observaciones, $errorMsgJs[length]" );
$valid->addFunction ("compareHora", "");
print $valid->toHtml ();
?>  
<script language="JavaScript">
<!--
function compareHora () {
var form=document.form2;
var msg="Hora De debe ser menor o igual a Hora A.";
var h1=Math.abs(form.Hora1.value);
var h2=Math.abs(form.Hora2.value);
var m1=Math.abs(form.Min1.value);
var m2=Math.abs(form.Min2.value);
if (h1 > h2) {
	alert (msg + "\n \nMensaje generado por GesTor F1.");
	return false;	
}
if ( (h1 == h2) && (m1 > m2) ) {
	alert (msg + "\n \nMensaje generado por GesTor F1.");
	return false;	
}
return true;
}
-->
</script> 
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
  <form name="form2" method="post" action="prog_tareassemestralp.php" onKeyPress="return Form()">
	<input name="IdProgTarea" type="hidden" id="IdProgTarea" value="<?php if(!empty($IdProgTarea)) echo $IdProgTarea;?>">
    <input name="action" type="hidden" id="action" value="<?php=$_GET["do"]?>">
    <table width="70%" border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
      <tr>
        <th colspan="10" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">PROGRAMACION DE TAREAS - SEMESTRALES<br>
                    <?php if($_GET["do"]=="editar") print "Editando: Nro. $IdProgTarea";
				else print "Registro Nuevo"; ?>
        </font></th>
      </tr>
      <tr>
        <th height="60" colspan="10" background="images/main-button-tileR2.jpg">
          <p><font size="2" face="Arial, Helvetica, sans-serif">Fecha: </font> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <select name="DiaP" >
              <?php if($_GET["do"]=="editar"){					
							$a1=substr($wTarea["FechaDe"],0,4);
							$m1=substr($wTarea["FechaDe"],5,2);
							$d1=substr($wTarea["FechaDe"],8,2);
						}
						else {
							$fsist=date("Y-m-d");
							$a1=substr($fsist,0,4);
							$m1=substr($fsist,5,2);
							$d1=substr($fsist,8,2);
						}
					for($i=1;$i<=31;$i++)
					{echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";}
			    ?>
            </select>
            </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <select name="MesP">
              <?php for($i=1;$i<=12;$i++)
					  {echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   ?>
            </select>
            <select name="AnoP">
              <?php for($i=2003;$i<=2020;$i++)
				      {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				?>
            </select>
            <font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong></strong></font></strong></font></font></strong></font></strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font></strong></font></strong></p></th>
      </tr>
      <tr align="center">
        <th rowspan="2" background="images/main-button-tileR2.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Actividad</font></th>
        <th colspan="2" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Hora</font></th>
        <th width="282" rowspan="2" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Mes</font></th>
        <th width="282" rowspan="2" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Dia</font></th>
        <th width="282" colspan="5" rowspan="2" background="images/main-button-tileR2.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Observaciones</font></th>
      </tr>
      <tr align="center">
        <th width="150" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">De</font></th>
        <th width="150" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">A</font></th>
      </tr>
      <tr>
        <td width="91" height="7" nowrap>
          <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>
            <textarea name="Actividad" cols="30" rows="4" id="textarea3"><?php if(!empty($wTarea['Actividad'])) $wTarea["Actividad"]?></textarea>
        </strong></font></div></td>
        <td height="3" nowrap><div align="center"><strong>
            <select name="Hora1">
              <?php 
			  for($i=1;$i<=24;$i++)
				{ echo "<option value=\"$i\"";
				if($i==substr($wTarea["HoraDe"],0,2)) print "selected";
				print ">$i</option>"; }
			   ?>
            </select>
        -
        <select name="Min1">
          <?php for($i=0; $i<=60; $i=$i+5){
					print "<option value=\"$i\"";
					if($i==substr($wTarea["HoraDe"],3,2)) print "selected";
					print ">$i</option>";
				} ?>
        </select>
        </strong></div></td>
        <td height="7" nowrap><div align="center"><strong>
            <select name="Hora2">
              <?php 
			  for($i=1;$i<=24;$i++)
				{echo "<option value=\"$i\"";
				if($i==substr($wTarea["HoraA"],0,2)) print "selected";
				print">$i</option>";}
			   ?>
            </select>
        -
        <select name="Min2">
          <?php for($i=0; $i<=60; $i=$i+5){
					print "<option value=\"$i\"";
					if($i==substr($wTarea["HoraA"],3,2)) print "selected";
					print ">$i</option>";
				} ?>
        </select>
        </strong></div></td>
        <td align="center" nowrap><strong>
        <select name="Mes" id="Mes">
          <?php for($tmp=1; $tmp<=6; $tmp++){
					print "<option value=\"$tmp\"";
					if($tmp==$wTarea["Mes"]) print "selected";
					print ">$tmp</option>";
			}
			?>
        </select>
</strong></td>
        <td align="center" nowrap><strong>
          <select name="Dia" id="Dia">
			<?php for($tmp=1; $tmp<=31; $tmp++){
					print "<option value=\"$tmp\"";
					if($tmp==$wTarea["Dia"]) print "selected";
					print ">$tmp</option>";
			}
			?>
		</select>
        </strong></td>
        <td height="7" colspan="5" nowrap>
          <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>
            <textarea name="Observaciones" cols="30" rows="4" id="textarea4"><?php if(!empty($wTarea['Observaciones'])) $wTarea["Observaciones"]; ?></textarea>
        </strong></font> </strong></div></td>
      </tr>
<tr>
 	<td colspan="8" align="center" valign="middle">
	  <table>
	  <tr>
	  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Asignar a : </font></strong></td>
	  <td>
			 <?php 
			  $sql = "select CONCAT(apa_usr, ' ', ama_usr, ' ', nom_usr) as nombre, roles.login_usr as login, tipo2_usr from roles,users where users.login_usr = roles.login_usr and calendariza = 'r' and tipo2_usr = 'T' and bloquear = 0";
			  $resultado = mysql_query($sql,$link);
			 ?>
	  		<select  name="nomAsig[]" id="lista" size="6" style="width:250px" multiple="multiple">
			  <?php 
				 $total_reg=1;
				 $sql0 = "SELECT * FROM users WHERE bloquear=0 AND (tipo2_usr='T' OR tipo2_usr='A') ORDER BY apa_usr ASC";
			     $result0=mysql_db_query($db,$sql0,$link);
				 while ($row0=mysql_fetch_array($result0)) 
				 {
				?>
					<option value="<?php=$row0['login_usr']?>" <?php for($j=0;$j<=$numcad;$j++){ if($row0['login_usr']==$varcad[$j]){echo "selected";}   }?>>
              <?php 

				$nombre = $row0['apa_usr']." ".$row0['ama_usr']." ".$row0['nom_usr'];
				echo $nombre;
				$total_reg++;
				?>
              </option>
              <?php
				}
				
			   ?>
            </select>
			</td>
		</tr>
		</table>
	  </td>
 </tr>
	
      <tr>
        <td height="28" colspan="10" nowrap>
          <div align="center"><br>
              <input name="INSERTAR" type="submit" id="INSERTAR2" value="INSERTAR" <?php print $valid->onSubmit() ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="Terminar" value="RETORNAR">
        </div></td>
      </tr>
    </table>
  </form>
  <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DiaP'], document.forms[form].elements['MesP'], document.forms[form].elements['AnoP']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		<?php if($errorMsg) print "alert(\"$errorMsg\");"; ?>
//-->
</script>
<?php include("top_.php");?>