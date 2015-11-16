<?php
if ($RETORNAR){header("location: lista_mantenimiento.php");}
if (isset($GUARDAR1)){
  include("conexion.php");
  $Fecha1="$ano1-$mes1-$dia1";
  $Hora="$horas:$minutos";
  $Fecha2="$ano21-$mes21-$dia21";
  $Fecha3="$ano31-$mes31-$dia31";
  $sql = "INSERT INTO solicitud (OrdAyuda,Fecha,Hora,AsignA,Viabilidad,Tiempo,Tiempo1,CostoI,MonedaI,CostoII,MonedaII,Prioridad,FechEstEnt,Aceptac,FechAcep) ".
	     "VALUES ('$var','$Fecha1','$Hora','$AsignA','$Viabilidad','$Tiempo','$Tiempo1','$Costo10','$Costo11','$Costo20','$Costo21','$Prioridad','$Fecha2','$Aceptac','$Fecha3')";
	mysql_db_query($db,$sql,$link);
  header("location: llenadoUS_2.php?var=$var");
} 

include("top.php");
$OrdAyuda=($_GET['IdFicha']);
$sql = "SELECT *, DATE_FORMAT(Fecha, '%d/%m/%Y') AS Fecha FROM solicitud WHERE OrdAyuda='$OrdAyuda'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);
?>
</div>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsDate ( "dia1", "mes1", "ano1", "Fecha de Recepcion, $errorMsgJs[date]" );
$valid->addIsTime ( "horas", "minutos", "Hora de Recepcion, $errorMsgJs[time]" );
$valid->addIsNotEmpty ( "AsignA",  "Asignado a, $errorMsgJs[empty]" );
$valid->addIsNumber ( "Tiempo",  "Tiempo, $errorMsgJs[number]" );
$valid->addIsNumber ( "Costo10",  "Costo, $errorMsgJs[number]" ); //mantener un control para validar numeros  para validar el campo Otros Costos
$valid->addFunction ( "validateForm1",  "" );
$valid->addIsDate ( "dia21", "mes21", "ano21", "Fecha de Entrega, $errorMsgJs[date]" );
$valid->addIsDate ( "dia31", "mes31", "ano31", "Fecha de Asignacion, $errorMsgJs[date]" );
$valid->addCompareDates  ( "dia1", "mes1", "ano1", "dia21", "mes21", "ano21", "Fecha De Recepcion y Fecha de Entrega, $errorMsgJs[compareDates]" );
$valid->addCompareDates  ( "dia1", "mes1", "ano1", "dia31", "mes31", "ano31", "Fecha De Recepcion y Fecha de Asignacion, $errorMsgJs[compareDates]" );

$valid->addLength ( "OR16",  "Observaciones-Especificaciones, $errorMsgJs[length]" );
$valid->addLength( "OR26",  "Observaciones-Aprobacion Usuario, $errorMsgJs[length]" );
$valid->addLength ( "OR36",  "Observaciones-Analisis, $errorMsgJs[length]" );
$valid->addLength( "OR46",  "Observaciones-Diseno, $errorMsgJs[length]" );
$valid->addLength ( "OR56",  "Observaciones-Programacion, $errorMsgJs[length]" );
$valid->addLength ( "OR66",  "Observaciones-Pruebas, $errorMsgJs[length]" );
$valid->addLength ( "OR76",  "Observaciones-Documentacion, $errorMsgJs[length]" );
$valid->addLength ( "OR86",  "Observaciones-Pase a Produccion, $errorMsgJs[length]" );
$valid->addLength ( "OR96",  "Observaciones-Capacitacion, $errorMsgJs[length]" );
$valid->addLength ( "OR106",  "Observaciones-Implantacion, $errorMsgJs[length]" );
$valid->addLength ( "OR116",  "Observaciones-Explotacion, $errorMsgJs[length]" );
$valid->addLength ( "OR126",  "Observaciones-Satisfaccion Usuaria, $errorMsgJs[length]" );

print $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function validateForm1 () {
	var form=document.form1;
	if (form.Costo20.value.length > 0) {
		if (!isNumber(form.Costo20.value)) {
			alert ("Otros Costos, debe ser un valor numerico.\n \nMensaje generado por GesTor F1.");
			return false;
		}
	else return true;	
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
<form name="form1" method="post" action="">
<input name="var" type="hidden" value="<?php echo $OrdAyuda;?>">
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
    <tr> 
      <td background="windowsvista-assets1/main-button-tile.jpg" height="30"><div align="center"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>LLENADO 
          POR SISTEMAS</strong></font></div></td>
    </tr>
  </table>
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <td><table width="90%" align="center">
          <tr> 
            <td width="64%" height="32"><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
              y hora de recepcion :</font> <font size="2" face="Arial, Helvetica, sans-serif"><strong> 
              <select name="dia1" id="dia1" >
                <?php
				if(!$row[FechEstEnt])$row[FechEstEnt]=date("Y-m-d");				
  				$ano1=substr($row[FechEstEnt],0,4);
				$mes1=substr($row[FechEstEnt],5,2);
				$dia1=substr($row[FechEstEnt],8,2);
				for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($dia1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select>
              <select name="mes1" id="select2">
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($mes1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="ano1" id="select3">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($ano1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
              &nbsp;&nbsp;<input name="horas" type="text" value="08" size="1" maxlength="2" >
              <strong>:</strong> 
              <input name="minutos" type="text" value="05" size="1" maxlength="2">
              </font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong></font></td>
            <td width="36%"><font size="2" face="Arial, Helvetica, sans-serif">Orden 
              Mesa de Ayuda N&deg; : <?php echo $OrdAyuda?></font></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="64%"><font size="2" face="Arial, Helvetica, sans-serif">Asignado 
              a :</font><strong> 
              <select name="AsignA">
                <option value="0"></option>
                <?php 
			  $sql2 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  $result2 = mysql_db_query($db,$sql2,$link);
			  while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row[AsignA]==$row2[login_usr])
							echo "<option value=\"$row2[login_usr]\" selected> $row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
						else
							echo "<option value=\"$row2[login_usr]\"> $row2[apa_usr] $row2[ama_usr] $row2[nom_usr] </option>";
	            }
			   ?>
              </select>
              </strong></td>
            <td width="36%"><font size="2" face="Arial, Helvetica, sans-serif">Viabilidad 
              :</font><strong> <font size="2" face="Arial, Helvetica, sans-serif">SI</font> 
              <input type="radio" name="Viabilidad" value="SI" <?php if ($row[Viabilidad]=="SI") echo "checked";?>>
              &nbsp;<font size="2" face="Arial, Helvetica, sans-serif">NO</font> 
              <input type="radio" name="Viabilidad" value="NO" <?php if ($row[Viabilidad]=="NO") echo "checked";?>>
              </strong></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="35%"><font size="2" face="Arial, Helvetica, sans-serif">Tiempo&nbsp;&nbsp; 
              :</font><strong>&nbsp;&nbsp;&nbsp; 
              <input name="Tiempo" type="text" value="<?php echo $row[Tiempo]?>" size="4" maxlength="3">
              <select name="Tiempo1">
                <option value="HORAS" <?php if ($row[Tiempo1]=="HORAS") echo "selected";?>>HORAS</option>
                <option value="DIAS" <?php if ($row[Tiempo1]=="DIAS") echo "selected";?>>DIAS</option>
                <option value="SEMANAS" <?php if ($row[Tiempo]=="SEMANAS") echo "selected";?>>SEMANAS</option>
              </select>
              </strong></td>
            <td width="29%"><font size="2" face="Arial, Helvetica, sans-serif">Costo 
              :</font> <input name="Costo10" type="text" value="<?php echo $row[CostoI]?>" size="10" maxlength="5"> 
              <select name="Costo11">
                <option value="Bs" <?php if ($row[MonedaI]=="Bs") echo "selected";?>>Bs</option>
                <option value="Sus" <?php if ($row[MonedaI]=="Sus") echo "selected";?>>$us</option>
              </select> </td>
            <td width="36%"><font size="2" face="Arial, Helvetica, sans-serif">Otros 
              Costos:</font> <input name="Costo20" type="text" value="<?php echo $row[CostoII]?>" size="10" maxlength="5"> 
              <select name="Costo21">
                <option value="Bs" <?php if ($row[MonedaII]=="Bs") echo "selected";?>>Bs</option>
                <option value="Sus" <?php if ($row[MonedaII]=="Sus") echo "selected";?>>$us</option>
              </select></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="51%"><font size="2" face="Arial, Helvetica, sans-serif">Prioridad 
              :</font> <strong><font size="2" face="Arial, Helvetica, sans-serif">Alta</font></strong> 
              <input type="radio" name="Prioridad" value="1" <?php if ($row[Prioridad]=="1") echo "checked";?>> 
              &nbsp;&nbsp;&nbsp;&nbsp; <font size="2" face="Arial, Helvetica, sans-serif"><strong>Media</strong></font> 
              <input type="radio" name="Prioridad" value="2" <?php if ($row[Prioridad]=="2") echo "checked";?>> 
              <strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;Baja</font></strong> 
              <input type="radio" name="Prioridad" value="3" <?php if ($row[Prioridad]=="3") echo "checked";?>></td>
            <td width="49%"><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
              Estimada de Entrega :</font><strong> 
              <select name="dia21" id="dia21" >
                <?php
				if(!$row[FechEstEnt])$row[FechEstEnt]=date("Y-m-d");				
  				$ano21=substr($row[FechEstEnt],0,4);
				$mes21=substr($row[FechEstEnt],5,2);
				$dia21=substr($row[FechEstEnt],8,2);
				for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($dia21=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select>
              <select name="mes21" id="mes21">
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($mes21=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="ano21" id="ano21">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($ano21=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal21.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
              </strong></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="56%" height="27"><font size="2" face="Arial, Helvetica, sans-serif">Aceptacion 
              del usuario responsable :</font><strong> </strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>SI</strong> 
              </font> 
              <input type="radio" name="Aceptac" value="SI" <?php if ($row[Aceptac]=="SI") echo "checked";?>> 
              <font size="2" face="Arial, Helvetica, sans-serif"><strong>NO</strong></font> 
              <input type="radio" name="Aceptac" value="NO" <?php if ($row[Aceptac]=="NO") echo "checked";?>> 
            </td>
            <td width="44%"><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
              de Asignacion:</font><strong> </strong> <select name="dia31" id="dia31" >
                <?php
				if(!$row[FechAcep])$row[FechAcep]=date("Y-m-d");
  				$ano31=substr($row[FechAcep],0,4);
				$mes31=substr($row[FechAcep],5,2);
				$dia31=substr($row[FechAcep],8,2);
				for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($dia31=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select> 
              <select name="mes31" id="mes31">
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($mes31=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select> 
              <select name="ano31" id="ano31">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($ano31=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal31.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong> 
		<script language="JavaScript">
		<!-- 
		var form = "form1";
		var cal1 = new calendar1(document.forms[form].elements['dia1'], document.forms[form].elements['mes1'], document.forms[form].elements['ano1']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
		var cal21 = new calendar1(document.forms[form].elements['dia21'], document.forms[form].elements['mes21'], document.forms[form].elements['ano21']);
		 	cal21.year_scroll = true;
			cal21.time_comp = false;
		var cal31 = new calendar1(document.forms[form].elements['dia31'], document.forms[form].elements['mes31'], document.forms[form].elements['ano31']);
		 	cal31.year_scroll = true;
			cal31.time_comp = false;
		//-->
		</script>
			</td>
          </tr>
        </table></td>
    </tr>
	<tr>
	  <td><div align="center"><br>
          <input name="GUARDAR1" type="submit" id="GUARDAR1" value="GUARDAR Y CONTINUAR" <?php print $valid->onSubmit() ?>>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="RETORNAR" type="submit" id="RETORNAR" value="   RETORNAR   ">
          <br>
        </div></td>
	</tr>
  </table>
  </form>
<p> 
</p>
<?php include("top_.php");?>