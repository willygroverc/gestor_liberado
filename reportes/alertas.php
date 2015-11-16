<?php
include ('../conexion.php');
if(isset($GUARDAR)){
	$sql_ins="UPDATE pmi_sao SET ind_1='$ind_1', ind_1b='$ind_1b', ind_2='$ind_2', ind_2b='$ind_2b', ind_3='$ind_3', ind_3b='$ind_3b', ind_4='$ind_4', ind_4b='$ind_4b', ind_5='$ind_5', ind_5b='$ind_5b', ind='$ord' WHERE id_report='$id'";
	if(mysql_db_query($db,$sql_ins,$link)){
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
pagina="report.php?VER=ok&report=<?php=$id?>"
window.opener.location.href=pagina
window.close();
//-->
</SCRIPT>
<?php
} else echo mysql_error();}
?>
<script language="JavaScript" type="text/javascript">
<!--
var flag=true
function cambia_color(){
	if(flag){
		cel1.style.backgroundColor="#008000"
		cel2.style.backgroundColor="#8BBA00"
		cel3.style.backgroundColor="#F6BD0F"
		cel4.style.backgroundColor="#FF8000"
		cel5.style.backgroundColor="#FF0000"
		flag=false;
		window.document.form1.ord.value="2" 
	}else{
		cel1.style.backgroundColor="#FF0000"
		cel2.style.backgroundColor="#FF8000"
		cel3.style.backgroundColor="#F6BD0F"
		cel4.style.backgroundColor="#8BBA00"
		cel5.style.backgroundColor="#008000"
		flag=true;	
		window.document.form1.ord.value="1"
	}
} 
-->
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PMI-SOA: Alertas</title>
<style type="text/css">
<!--
.Estilo3 {font-family: Arial, Helvetica, sans-serif}
.Estilo4 {color: #FFFFFF; font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
.Estilo5 {font-family: Geneva, Arial, Helvetica, sans-serif}
.Estilo7 {font-size: 12px; }
.Estilo9 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
</head>

<body>
<span class="Estilo9">* Ingrese los valores en orden Ascendente</span><br>
<br>
<table width="200" border="0">
  <tr>
    <td>
	
<form id="form1" name="form1" method="post" action="">
<div align="center">
  <?php
$sql_alert="SELECT * FROM pmi_sao WHERE id_report='$id'";
$res_alert=mysql_db_query($db,$sql_alert,$link);
$row_alert=mysql_fetch_array($res_alert);
?>
  <table width="200" border="1">
    <tr bgcolor="#666666">
      <td><div align="center" class="Estilo4">Nivel</div></td>
        <td><div align="center" class="Estilo4">Desde</div></td>
        <td><div align="center" class="Estilo4">Hasta</div></td>
      </tr>
    <tr id='cel1' bgcolor="#FF0000">
      <td><span class="Estilo3">1</span></td>
        <td>
          <input name="ind_1" type="text" id="ind_1" value="<?php echo $row_alert['ind_1'];?>" size="3" maxlength="3" />    </td>
        <td><input name="ind_1b" type="text" id="ind_1b" value="<?php echo $row_alert['ind_1b'];?>" size="3" maxlength="3" onchange="val1(this.value)" /></td>
      </tr>
    <tr id='cel2' bgcolor="#FF8000">
      <td><span class="Estilo3">2</span></td>
        <td><input name="ind_2" type="text" id="ind_2" value="<?php echo $row_alert['ind_2'];?>" size="3" maxlength="3"  /></td>
        <td><input name="ind_2b" type="text" id="ind_2b" value="<?php echo $row_alert['ind_2b'];?>" size="3" maxlength="3" onchange="val2(this.value)"/></td>
      </tr>
    <tr id='cel3' bgcolor="#F6BD0F">
      <td><p class="Estilo3">3</p>    </td>
        <td><input name="ind_3" type="text" id="ind_3" value="<?php echo $row_alert['ind_3'];?>" size="3" maxlength="3"  /></td>
        <td><input name="ind_3b" type="text" id="ind_3b" value="<?php echo $row_alert['ind_3b'];?>" size="3" maxlength="3" onchange="val3(this.value)"/></td>
      </tr>
    <tr id='cel4' bgcolor="#8BBA00">
      <td><span class="Estilo3">4</span></td>
        <td><input name="ind_4" type="text" id="ind_4" value="<?php echo $row_alert['ind_4'];?>" size="3" maxlength="3" /></td>
        <td><input name="ind_4b" type="text" id="ind_4b" value="<?php echo $row_alert['ind_4b'];?>" size="3" maxlength="3" onchange="val4(this.value)"/></td>
      </tr>
    <tr id='cel5' bgcolor="#008000">
      <td><span class="Estilo3">5</span></td>
        <td><input name="ind_5" type="text" id="ind_5" value="<?php echo $row_alert['ind_5'];?>" size="3" maxlength="3"  /></td>
        <td><input name="ind_5b" type="text" id="ind_5b" value="<?php echo $row_alert['ind_5b'];?>" size="3" maxlength="3" /></td>
      </tr>
  </table>
</div>
<p align="center"><input name="id" type="hidden" value="<?php echo $id;?>" />
<input name="ord" value="1" type="hidden" />
    <input type="submit" name="GUARDAR" value="GUARDAR" />
    </p>
</form>	</td>
    <td>
<form name=fcolor>
<input type=button value="Invertir" onClick="cambia_color()">
</form></td>
  </tr>
  <tr>
    <td colspan="2"><table border="0">
      <tr>
        <td width="20%" bgcolor="#008000"><div align="center" class="Estilo7"><span class="Estilo5">Bajo</span></div></td>
        <td width="20%" bgcolor="#8BBA00"><div align="center" class="Estilo7"><span class="Estilo5">Normal</span></div></td>
        <td width="20%" bgcolor="#F6BD0F"><div align="center" class="Estilo7"><span class="Estilo5">Alto</span></div></td>
        <td width="20%" bgcolor="#FF8000"><div align="center" class="Estilo7"><span class="Estilo5">Critico</span></div></td>
        <td width="20%" bgcolor="#FF0000"><div align="center" class="Estilo7"><span class="Estilo5">Muy Critico</span></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<script language="JavaScript" type="text/javascript">
<!--
function val1(valor){
	document.form1.ind_2.value=valor;
}
function val2(valor){
	document.form1.ind_3.value=valor;
}
function val3(valor){
	document.form1.ind_4.value=valor;
}
function val4(valor){
	document.form1.ind_5.value=valor;
}
-->
</script>
</body>
</html>
