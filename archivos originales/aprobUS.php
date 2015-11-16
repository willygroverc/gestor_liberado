<?php 
if (isset($RETORNAR)){header("location: lista_mantenimiento.php");}
if (isset($guardar)) {
  include("conexion.php");
  $FechRespAp="$AnoRespAp-$MesRespAp-$DiaRespAp";
  $FechUsRespAp="$AnoUsRespAp-$MesUsRespAp-$DiaUsRespAp";
  $FechComAp="$AnoComAp-$MesComAp-$DiaComAp";  
  $sql = "INSERT INTO aprobus (NombRespAp,FechRespAp,NomUsRespAp,FechUsRespAp,ComCambAp,FechComAp,OrdAyuda,observ1,observ2,observ3) ".
  "VALUES ('$NombRespAp','$FechRespAp','$NomUsRespAp','$FechUsRespAp','$ComCambAp','$FechComAp','$var','$observ1','$observ2','$observ3')";
  $result=mysql_db_query($db,$sql,$link);
  header("location: lista_mantenimiento.php");
	} 
else {
include ("top.php");
$OrdAyuda=($_GET['IdFicha']);?>
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
<table width="99%" height="23" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
  <tr>
    <td><div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Aprobaciones 
        (Responsables y Fecha):</font></strong></div></td>
  </tr>
</table>
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr>
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $OrdAyuda;?>">
        <table width="98%" cellspacing="0" cellpadding="0">
          <tr>
            <td> <p> &nbsp;&nbsp;N&deg; Orden de Ayuda : <?php echo $OrdAyuda ?></p>
              <table width="100%">
                <tr> 
                  <td width="30%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Responsable 
                      de implantacion</font></div></td>
                  <td width="40%"> <div align="center">
                      <select name="NombRespAp">
                        <option value="0"></option>
                        <?php 
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\"> $row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
			   ?>
                      </select>
                      <strong> 
                      <select name="DiaRespAp" id="select">
                        <?php
				  	$a=date("Y-m-d");
				   	$a1=substr($a,0,4);
					$m1=substr($a,5,2);
					$d1=substr($a,8,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
                      </select>
                      <select name="MesRespAp" id="select2">
                        <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                      </select>
                      <select name="AnoRespAp" id="select3">
                        <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                      </select>
                      <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong></font> 
                      </strong> </div></td>
                  <td width="30%"><div align="center">
                      <textarea name="observ1" cols="40" rows="2" id="observ1"></textarea>
                    </div></td>
                </tr>
              </table>
              <table width="100%">
                <tr> 
                  <td width="30%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Usuario 
                      Responsable (implantacion)</font></div></td>
                  <td width="40%"> <div align="center">
                      <select name="NomUsRespAp">
                        <option value="0"></option>
                        <?php 
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\"> $row[apa_usr] $row[ama_usr] $row[nom_usr] </option>";
	            }
			   ?>
                      </select>
                      <strong> 
                      <select name="DiaUsRespAp" id="select4">
                        <?php
				  	$a=date("Y-m-d");
				   	$a1=substr($a,0,4);
					$m1=substr($a,5,2);
					$d1=substr($a,8,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
                      </select>
                      <select name="MesUsRespAp" id="select5">
                        <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                      </select>
                      <select name="AnoUsRespAp" id="select11">
                        <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                      </select>
                      <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal2.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong></font> 
                      </strong> </div></td>
                  <td width="30%"><div align="center">
                      <textarea name="observ2" cols="40" rows="2" id="observ2"></textarea>
                    </div></td>
                </tr>
              </table>
              <table width="100%">
                <tr> 
                  <td width="30%" height="75"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Comite 
                      de Cambios (implantacion en ambiente de produccion)</font></div></td>
                  <td width="40%"><div align="center"><strong> 
                      <select name="ComCambAp">
                        <option value="0"></option>
                        <?php 
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\"> $row[apa_usr] $row[ama_usr]  $row[nom_usr]</option>";
	            }
			   ?>
                      </select>
                      <select name="DiaComAp" id="select12">
                        <?php
				  	$a=date("Y-m-d");
				   	$a1=substr($a,0,4);
					$m1=substr($a,5,2);
					$d1=substr($a,8,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
                      </select>
                      <select name="MesComAp" id="select13">
                        <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                      </select>
                      <select name="AnoComAp" id="select14">
                        <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                      </select>
                      <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal3.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong></font> 
                      </strong></div></td>
                  <td width="30%"><div align="center">
                      <textarea name="observ3" cols="40" rows="2" id="observ3"></textarea>
                    </div></td>
                </tr>
              </table>
              
            </td>
          </tr>
        </table>
        <p align="center"> 
          <input type="Submit" name="guardar" value="GUARDAR" <?php print $valid->onSubmit() ?>>
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
<?php include("top_.php");?>