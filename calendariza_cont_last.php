<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
require("conexion.php");
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($RETORNAR)){header("location: lista_calen_cont.php");}
if (isset($reg_form)){  
	$fecha_del="$AA1-$MA1-$DA1";
	$fecha_al="$AA-$MA-$DA";
	$sql3="INSERT INTO ".
	"calen_contingencia (id_cmant,TipoPru,estado,fecha_al,fecha_del) ".
	"VALUES ('$var','$var1','Realizado','$fecha_al','$fecha_del')";
	mysql_query($sql3);
	header("location: lista_calen_cont.php");
}
else {
include("top.php"); 
require_once('funciones.php');
$IdRe=SanitizeString($_GET['id_cmant']);
$IdRe1=SanitizeString($_GET['TipoPru']);?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsDate ( "DA1", "MA1", "AA1", "Fecha Inicio: $errorMsgJs[date]" );
$valid->addIsDate ( "DA", "MA", "AA", "Fecha Final: $errorMsgJs[date]" );
$valid->addCompareDates ( "DA1", "MA1", "AA1", "DA", "MA", "AA", "$errorMsgJs[compareDates]" );
$valid->addFunction ( "compareYear", "" );
print $valid->toHtml();
?>
<script language="JavaScript">
<!--
function compareYear () {
	var form=document.form2;
	if (form.AA1.value != form.AA.value) {
		alert ("Los anos deben ser los mismos. \n \n Mensaje generado por GesTor F1.");
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
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <form name="form2" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $IdRe;?>">
	<input name="var1" type="hidden" value="<?php echo $IdRe1;?>">
	<tr> 
      <td height="173"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="7" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">CALENDARIZACION 
              DE CONTINGENCIA - REALIZACION</font></th>
          </tr>
          <tr> 
            <th width="60" nowrap bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></div></th>
            <th width="93" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Ord. 
              Trabajo </font></th>
            <th width="210" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Incidencia</font></th>
            <th width="87" nowrap bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Estado</font></div></th>
            <th width="175" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Fecha 
                Inicio</font></div></th>
            <th width="181" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
              final</font></th>
          </tr>
          <?php
			
		$sql = "SELECT *, DATE_FORMAT(fecha_del, '%d/%m/%Y') AS fecha_del, DATE_FORMAT(fecha_al, '%d/%m/%Y') AS fecha_al 
				FROM calen_contingencia WHERE id_cmant='$IdRe'";  //HERE
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
		 ?>
          <tr align="center"> 
            <td><div align="center">&nbsp; &nbsp;<?php echo $IdRe?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['TipoPru']?></div></td>
            <?php $sql4 = "SELECT * FROM ordenes WHERE id_orden='$row[TipoPru]'";
			$result4=mysql_query($sql4);
			$row4=mysql_fetch_array($result4);
			echo "<td><font size=\"1\">$row4[desc_inc]</td>";?>
            <td><div align="center">&nbsp;<?php echo $row['estado']?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['fecha_del'];?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['fecha_al'];?></div></td>
          </tr>
          <input name="var2" type="hidden" value="<?php echo $row['TipoPru'];?>">
          <tr> 
            <td colspan="7" height="7" nowrap><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font> 
              </div>
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td height="30" nowrap></td>
            <td height="30" colspan="2" nowrap></td>
            <td width="87" nowrap height="30"> <strong> <div align="center">Realizado 
              </div></td>
            <td width="175" nowrap height="30"> <div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="DA1" id="select">
                  <?php
				$hoy=$row['fecha_del'];
				$AS=substr($hoy,5,4);
				$MS=substr($hoy,3,2);
				$DS=substr($hoy,0,2);
				for($i=1;$i<=31;$i++)
				{echo "<option value=\"$i\"";if($DS=="$i")echo "selected";echo">$i</option>";}
				?>
                </select>
                <select name="MA1" id="select2">
                  <?php
				for($i=1;$i<=12;$i++)
				{echo "<option value=\"$i\"";if($MS=="$i")echo "selected";echo">$i</option>";}
				?>
                </select>
                <select name="AA1" id="select3">
                  <?php
				for($i=2003;$i<=2020;$i++)
				{
                echo "<option value=\"$i\"";if($AS=="$i")echo "selected";echo">$i</option>";
				}
				?>
                </select>
                <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong> 
                </font> </strong></div></td>
            <td width="181" nowrap><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="DA" id="select13">
                  <?php
				  $hoy=$row['fecha_al'];
				$AS=substr($hoy,5,4);
				$MS=substr($hoy,3,2);
				$DS=substr($hoy,0,2);
				for($i=1;$i<=31;$i++)
				{echo "<option value=\"$i\"";if($DS=="$i")echo "selected";echo">$i</option>";}
				?>
                </select>
                </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="MA" id="select14">
                  <?php
				for($i=1;$i<=12;$i++)
				{echo "<option value=\"$i\"";if($MS=="$i")echo "selected";echo">$i</option>";}
				?>
                </select>
                <select name="AA" id="select15">
                  <?php
				for($i=2003;$i<=2020;$i++)
				{echo "<option value=\"$i\"";if($AS=="$i")echo "selected";echo">$i</option>";}
				?>
                </select>
				<strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong> 
                </font></strong></div></td>
          </tr>
          <tr> 
            <td height="28" colspan="6" nowrap> <div align="left"><br>
              </div>
              <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="GUARDAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
 <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DA1'], document.forms[form].elements['MA1'], document.forms[form].elements['AA1']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>
<p> 
  <?php } ?>
</p>