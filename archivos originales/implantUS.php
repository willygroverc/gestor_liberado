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
  require("conexion.php");
  $FechCordConf="$AnoCordConf-$MesCordConf-$DiaCordConf";
  $FechUsConf="$AnoUsConf-$MesUsConf-$DiaUsConf";
  $sql = "INSERT INTO implantus (NomCordCamb,FechCordConf,ResuCordConf,NomUsConf,FechUsConf,ResuUsConf,OrdAyuda,observ1,observ2) ".
  "VALUES ('$NomCordCamb','$FechCordConf','$ResuCordConf','$NomUsConf','$FechUsConf','$ResuUsConf','$var','$observ1','$observ2')";
  
  $sql1 = "SELECT * FROM solucion WHERE id_orden='$var'";
  $result1=mysql_query($sql1);
  $row1=mysql_fetch_array($result1);

	if (!$row1['id_orden'])
		{
		$msg="REGISTRAR LA SOLUCION DE LA ORDEN DE TRABAJO";
		}
		else
		{
		$result=mysql_query($sql);
	    header("location: lista_mantenimiento.php");
		}
} 
//else {
include ("top.php");
$OrdAyuda=($_GET['IdFicha']);

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
<table width="94%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <p>&nbsp;</p>
  <tr>
   
    <td> 
      <form name="form1" method="post" action="" onKeyPress="return Form()">
	  <input name="var" type="hidden" value="<?php echo $OrdAyuda;?>">
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr>
            <td background="images/main-button-tileR1.jpg" height="20"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>30 
                dias despues de la Implantacion</strong></font></div></td>
          </tr>
        </table>
        <br>
        N&deg; Orden de Ayuda : <?php echo $OrdAyuda ?><br>
        <br>
        <table width="100%">
          <tr> 
            <td width="30%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Coordinador 
              de Cambios</font></td>
            <td width="40%"> <select name="NomCordCamb">
                <option value="0"></option>
                <?php 
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0 ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
			   ?>
              </select> <strong> 
              <select name="DiaCordConf" id="select12">
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
              <select name="MesCordConf" id="select13">
                <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="AnoCordConf" id="select14">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong></font> 
              </strong> </td>
            <td width="30%"><textarea name="observ1" cols="40" rows="2" id="observ1"></textarea></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="44%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Conformidad 
              de los resultados con la solicitud</font></td>
            <td width="56%">Si 
              <input type="radio" name="ResuCordConf" value="SI"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              Parcial 
              <input type="radio" name="ResuCordConf" value="PARCIAL"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No 
              <input type="radio" name="ResuCordConf" value="NO"> </td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="30%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Usuario 
              Solicitante</font></td>
            <td width="40%"> <select name="NomUsConf">
                <option value="0"></option>
                <?php 
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0 ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
			   ?>
              </select> <strong> 
              <select name="DiaUsConf" id="select">
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
              <select name="MesUsConf" id="select2">
                <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="AnoUsConf" id="select3">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal2.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong></font> 
              </strong> </td>
            <td width="30%"><textarea name="observ2" cols="40" rows="2" id="observ2"></textarea></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="44%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Conformidad 
              de los resultados con la solicitud</font></td>
            <td width="56%">Si 
              <input type="radio" name="ResuUsConf" value="SI"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              Parcial 
              <input type="radio" name="ResuUsConf" value="PARCIAL"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No 
              <input type="radio" name="ResuUsConf" value="NO"> </td>
          </tr>
        </table>
        <br>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td><div align="center"> 
                <input type="Submit" name="guardar" value="GUARDAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        <br>
      </form>
      
    </td>
  </tr>
</table>
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
<script language="JavaScript">
		<!-- 
		<?php if (isset($msg)) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
</script>
<p> 