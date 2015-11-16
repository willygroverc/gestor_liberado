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
if (isset($RETORNAR)){header("location: lista_mantenimiento.php");}
if (isset($guardar)) {
require('conexion.php');
$login=$_SESSION["login"];
if (!isset($login)) {
		header("location: index.php"); 
	}
  require("conexion.php");
  $FechRespAp="$AnoRespAp-$MesRespAp-$DiaRespAp";
  $FechUsRespAp="$AnoUsRespAp-$MesUsRespAp-$DiaUsRespAp";
  $FechComAp="$AnoComAp-$MesComAp-$DiaComAp";  
  $sql="UPDATE aprobus SET NombRespAp='$NombRespAp',FechRespAp='$FechRespAp',NomUsRespAp='$NomUsRespAp',FechUsRespAp='$FechUsRespAp',ComCambAp='$ComCambAp',FechComAp='$FechComAp',OrdAyuda='$var'".
  ",observ1='$observ1',observ2='$observ2',observ3='$observ3' WHERE OrdAyuda='$var'";
   $result=mysql_query($sql);
  header("location: lista_mantenimiento.php");
	} 
else {
include ("top.php");
require_once('funciones.php');
$OrdAyuda=SanitizeString($_GET['IdOrden']);
$sql33 = "SELECT * FROM aprobus WHERE OrdAyuda='$OrdAyuda'";
$result33=mysql_query($sql33);
$row33=mysql_fetch_array($result33);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "NombRespAp",  "Responsable de implantacion, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "NomUsRespAp",  "Usuario Responsable, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "ComCambAp",  "Comite de Cambios, $errorMsgJs[empty]" );
$valid->addIsDate ( "DiaRespAp", "MesRespAp", "AnoRespAp", "Fecha de Responsable de implantacion, $errorMsgJs[date]" );
$valid->addIsDate ( "DiaUsRespAp", "MesUsRespAp", "AnoUsRespAp", "Fecha de Usuario Responsable, $errorMsgJs[date]" );
$valid->addIsDate ( "DiaComAp", "MesComAp", "AnoComAp", "Fecha de Comite de Cambios, $errorMsgJs[date]" );
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
<table width="100%" height="23" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
  <tr>
    <td><div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Aprobaciones 
        (Responsables y Fecha):</font></strong></div></td>
  </tr>
</table>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr>
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $OrdAyuda;?>">
        <table width="98%" cellspacing="0" cellpadding="0">
          <tr>  
            <td> <p> <font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;N&deg; Orden de Ayuda : <?php echo $OrdAyuda ?></font></p>
              <table width="100%">
                <tr> 
                  <td width="30%" height="27"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Responsable 
                      de implantacion</font></div></td>
                  <td width="40%"> <div align="center"><strong> 
                      <select name="NombRespAp" id="select">
                        <option value="0"></option>
                        <?php 
			  
			  $sql8 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0";
			  $result8 = mysql_query($sql8);
			  while ($row8 = mysql_fetch_array($result8)) 
				{
				echo "<option value=\"$row8[login_usr]\"";
				if ($row8['login_usr']==$row33['NombRespAp']) echo "selected";
				echo " > $row8[apa_usr] $row8[ama_usr] $row8[nom_usr]</option>";
	            }
			   ?>
                      </select>
                      </strong> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <select name="DiaRespAp" id="select22">
                        <?php
  				$ano=substr($row33['FechRespAp'],0,4);
				$mes=substr($row33['FechRespAp'],5,2);
				$dia=substr($row33['FechRespAp'],8,2);
				for($i=1;$i<=31;$i++)
				{
	                echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";
				}
				?>
                      </select>
                      </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <select name="MesRespAp" id="select23">
                        <?php
				for($i=1;$i<=12;$i++)
				{
    	            echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
				}
				?>
                      </select>
                      </font></strong> </font> 
                      <select name="AnoRespAp" id="select24">
                        <?php
				for($i=2004;$i<=2020;$i++)
				{
        	        echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";
				}
				?>
                      </select>
                      <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
                      </strong></font> </div></td>
                  <td width="30%"><textarea name="observ1" cols="40" rows="2" id="observ1"><?php=$row33['observ1'];?></textarea></td>
                </tr>
              </table>
              <table width="100%">
                <tr> 
                  <td width="30%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Usuario 
                      Responsable (implantacion)</font></div></td>
                  <td width="40%"><div align="center"><strong> 
                      <select name="NomUsRespAp" id="select7">
                        <option value="0"></option>
                        <?php 
			  $sql8 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0";
			  $result8 = mysql_query($sql8);
			  while ($row8 = mysql_fetch_array($result8)) 
				{
				echo "<option value=\"$row8[login_usr]\"";
				if ($row8['login_usr']==$row33['NomUsRespAp']) echo "selected";
				echo " > $row8[apa_usr] $row8[ama_usr] $row8[nom_usr]</option>";
	            }
			   ?>
                      </select>
                      <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <select name="DiaUsRespAp" id="select19">
                        <?php
  				$ano=substr($row33['FechUsRespAp'],0,4);
				$mes=substr($row33['FechUsRespAp'],5,2);
				$dia=substr($row33['FechUsRespAp'],8,2);
				for($i=1;$i<=31;$i++)
				{
	                echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";
				}
				?>
                      </select>
                      </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <select name="MesUsRespAp" id="select20">
                        <?php
				for($i=1;$i<=12;$i++)
				{
    	            echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
				}
				?>
                      </select>
                      </font> 
                      <select name="AnoUsRespAp" id="select21">
                        <?php
				for($i=2004;$i<=2020;$i++)
				{
        	        echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";
				}
				?>
                      </select>
                      <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal2.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
                      </strong> </div></td>
                  <td width="30%"><textarea name="observ2" cols="40" rows="2" id="observ2"><?php=$row33['observ2'];?></textarea></td>
                </tr>
              </table>
              <table width="100%">
                <tr> 
                  <td width="30%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Comite 
                      de Cambios (implantacion en ambiente de produccion)</font></div></td>
                  <td width="40%"><div align="center"><strong> 
                      <select name="ComCambAp" id="select3">
                        <option value="0"></option>
                        <?php 
			  
			  $sql8 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0";
			  $result8 = mysql_query($sql8);
			  while ($row8 = mysql_fetch_array($result8)) 
				{
				echo "<option value=\"$row8[login_usr]\"";
				if ($row8['login_usr']==$row33['ComCambAp']) echo "selected";
				echo " > $row8[apa_usr] $row8[ama_usr] $row8[nom_usr]</option>";
	            }
			   ?>
                      </select>
                      <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <select name="DiaComAp" id="select15">
                        <?php
  				$ano=substr($row33['FechComAp'],0,4);
				$mes=substr($row33['FechComAp'],5,2);
				$dia=substr($row33['FechComAp'],8,2);
				for($i=1;$i<=31;$i++)
				{
	                echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";
				}
				?>
                      </select>
                      </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <select name="MesComAp" id="select16">
                        <?php
				for($i=1;$i<=12;$i++)
				{
    	            echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
				}
				?>
                      </select>
                      </font> 
                      <select name="AnoComAp" id="select17">
                        <?php
				for($i=2004;$i<=2020;$i++)
				{
        	        echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";
				}
				?>
                      </select>
                      <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal3.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
                      </strong></div></td>
                  <td width="30%"><textarea name="observ3" cols="40" rows="2" id="observ3"><?php=$row33['observ3'];?></textarea></td>
                </tr>
              </table>
              
            </td>
          </tr>
        </table>
        <p align="center"> 
          <input type="Submit" name="guardar" value="GUARDAR"  <?php print $valid->onSubmit() ?>>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="RETORNAR" value="RETORNAR">
        </p>
        </form>
     
    </td>
  </tr>
</table>
  <script language="JavaScript">
		<!-- 
		var form = "form1";
		 var cal1 = new calendar1(document.forms[form].elements['DiaRespAp'], document.forms[form].elements['MesRespAp'], document.forms[form].elements['AnoRespAp']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
		var cal2 = new calendar1(document.forms[form].elements['DiaUsRespAp'], document.forms[form].elements['MesUsRespAp'], document.forms[form].elements['AnoUsRespAp']);
		 	cal2.year_scroll = true;
			cal2.time_comp = false;
		var cal3 = new calendar1(document.forms[form].elements['DiaComAp'], document.forms[form].elements['MesComAp'], document.forms[form].elements['AnoComAp']);
		 	cal3.year_scroll = true;
			cal3.time_comp = false;
//-->
</script>
<p> 
  <?php } ?>
</p>