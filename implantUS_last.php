<?php 
if (isset($RETORNAR)){header("location: lista_mantenimiento.php");}
if (isset($guardar)) {
session_start();
$login=$_SESSION["login"];
if (!isset($login)) {
		header("location: index.php"); 
	}
  include("conexion.php");
  $FechCordConf="$AnoCordConf-$MesCordConf-$DiaCordConf";
  $FechUsConf="$AnoUsConf-$MesUsConf-$DiaUsConf";
  $sql = "UPDATE implantus SET NomCordCamb='$NomCordCamb',FechCordConf='$FechCordConf',ResuCordConf='$ResuCordConf',NomUsConf='$NomUsConf',FechUsConf='$FechUsConf',ResuUsConf='$ResuUsConf'".
  ",observ1='$observ1',observ2='$observ2' WHERE OrdAyuda=$var";
  $result=mysql_db_query($db,$sql,$link);
  header("location: lista_mantenimiento.php");
	} 
else {
include ("top.php");
require_once('funciones.php');
$OrdAyuda=SanitizeString($_GET['IdOrden']);
$sql33 = "SELECT * FROM implantus WHERE OrdAyuda='$OrdAyuda'";
$result33=mysql_db_query($db,$sql33,$link);
$row33=mysql_fetch_array($result33);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "NomCordCamb",  "Coordinador de Cambios, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "NomUsConf",  "Usuario Solicitante, $errorMsgJs[empty]" );
$valid->addIsDate ( "DiaCordConf", "MesCordConf", "AnoCordConf", "Fecha de Coordinador de Cambios, $errorMsgJs[date]" );
$valid->addIsDate ( "DiaUsConf", "MesUsConf", "AnoUsConf", "Fecha de Usuario Solicitante, $errorMsgJs[date]" );
$valid->addFunction ( "VerificarRadio",  "" );
print $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function VerificarRadio (){
	var form=document.form1;
	if ((form.ResuCordConf[0].checked || form.ResuCordConf[1].checked || form.ResuCordConf[2].checked) && (form.ResuUsConf[0].checked || form.ResuUsConf[1].checked || form.ResuUsConf[2].checked)) return true;
	else {
		alert ("Debe seleccionar Conformidad del Coordinador y el Solicitante. \n \nMensaje generado por GesTor F1. ")
		return false;
	} 
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
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <p>&nbsp;</p>
  <tr>
   
    <td> 
      <form name="form1" method="post" action="" onKeyPress="return Form()">
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr>
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>
                <input name="var" type="hidden" value="<?php echo $OrdAyuda;?>">
                30 dias despues de la Implantacion</strong></font></div></td>
          </tr>
        </table>
        <br>
        N&deg; Orden de Ayuda : <?php echo $OrdAyuda ?><br>
        <br>
        <table width="100%">
          <tr> 
            <td width="20%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Coordinador 
              de Cambios</font></td>
            <td width="50%"> <strong> 
              <select name="NomCordCamb" id="select">
                <option value="0"></option>
                <?php 
			  $link = mysql_connect($host,$user,$pass) or die ("Error durante la conexion a la base de datos"); 
			  $sql8 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0 ORDER BY apa_usr ASC";
			  $result8 = mysql_db_query($db,$sql8,$link);
			  while ($row8 = mysql_fetch_array($result8)) 
				{
				echo "<option value=\"$row8[login_usr]\"";
				if ($row8[login_usr]==$row33[NomCordCamb]) echo "selected";
				echo ">$row8[apa_usr] $row8[ama_usr] $row8[nom_usr]</option>";
	            }
			   ?>
              </select>
              </strong> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="DiaCordConf" id="select22">
                <?php
  				$ano=substr($row33[FechCordConf],0,4);
				$mes=substr($row33[FechCordConf],5,2);
				$dia=substr($row33[FechCordConf],8,2);
				for($i=1;$i<=31;$i++)
				{
	                echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select>
              </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="MesCordConf" id="select23">
                <?php
				for($i=1;$i<=12;$i++)
				{
    	            echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select>
              </font> 
              <select name="AnoCordConf" id="select24">
                <?php
				for($i=2003;$i<=2020;$i++)
				{
        	        echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select>
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
              </strong></font> </td>
            <td width="30%"><textarea name="observ1" cols="40" rows="2" id="observ1"><?php=$row33['observ1']?></textarea></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="44%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Conformidad 
              de los resultados con la solicitud</font></td>
            <td width="56%"><font size="2" face="Arial, Helvetica, sans-serif">Si 
              <input type="radio" name="ResuCordConf" value="SI" <?php if ($row33[ResuCordConf]=="SI") echo "checked";?> >
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Parcial 
              <input type="radio" name="ResuCordConf" value="PARCIAL" <?php if ($row33[ResuCordConf]=="PARCIAL") echo "checked";?>>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No 
              <input type="radio" name="ResuCordConf" value="NO" <?php if ($row33[ResuCordConf]=="NO") echo "checked";?>>
              </font> </td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="20%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Usuario 
              Solicitante</font></td>
            <td width="50%"><strong> 
              <select name="NomUsConf" id="select2">
                <option value="0"></option>
                <?php 
			  $link = mysql_connect($host,$user,$pass) or die ("Error durante la conexion a la base de datos"); 
			  $sql8 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0 ORDER BY apa_usr ASC";
			  $result8 = mysql_db_query($db,$sql8,$link);
			  while ($row8 = mysql_fetch_array($result8)) 
				{
				echo "<option value=\"$row8[login_usr]\"";
				if ($row8[login_usr]==$row33[NomUsConf]) echo "selected";
				echo ">$row8[apa_usr] $row8[ama_usr] $row8[nom_usr]</option>";
	            }
			   ?>
              </select>
              </strong> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="DiaUsConf" id="select3">
                <?php
  				$ano=substr($row33[FechUsConf],0,4);
				$mes=substr($row33[FechUsConf],5,2);
				$dia=substr($row33[FechUsConf],8,2);
				for($i=1;$i<=31;$i++)
				{
	                echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select>
              </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="MesUsConf" id="select4">
                <?php
				for($i=1;$i<=12;$i++)
				{
    	            echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select>
              </font> 
              <select name="AnoUsConf" id="select5">
                <?php
				for($i=2003;$i<=2020;$i++)
				{
        	        echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select>
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal2.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
              </strong></font> </td>
            <td width="30%"><textarea name="observ2" cols="40" rows="2" id="observ2"><?php=$row33['observ2']?></textarea></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="44%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Conformidad 
              de los resultados con la solicitud</font></td>
            <td width="56%"><font size="2" face="Arial, Helvetica, sans-serif">Si 
              <input type="radio" name="ResuUsConf" value="SI" <?php if ($row33[ResuUsConf]=="SI") echo "checked";?>>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Parcial 
              <input type="radio" name="ResuUsConf" value="PARCIAL"  <?php if ($row33[ResuUsConf]=="PARCIAL") echo "checked";?>>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No 
              <input type="radio" name="ResuUsConf" value="NO" <?php if ($row33[ResuUsConf]=="NO") echo "checked";?>>
              </font> </td>
          </tr>
        </table>
        <br>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td><div align="center"> 
                <input type="Submit" name="guardar" value="GUARDAR" <?php print $valid->onSubmit() ?>>
				 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="RETORNAR" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        <br>
      </form>
      
    </td>
  </tr>
</table>
<p>
  <script language="JavaScript">
		<!-- 
		var form = "form1";
		 var cal1 = new calendar1(document.forms[form].elements['DiaCordConf'], document.forms[form].elements['MesCordConf'], document.forms[form].elements['AnoCordConf']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
		var cal2 = new calendar1(document.forms[form].elements['DiaUsConf'], document.forms[form].elements['MesUsConf'], document.forms[form].elements['AnoUsConf']);
		 	cal2.year_scroll = true;
			cal2.time_comp = false;
//-->
</script>
  <?php } ?>
</p>
<?php include("top_.php");?>