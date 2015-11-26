<?php
session_start();
//login user no existe en el sistema
if(isset($_SESSION['login_pmi']))
	$login_usr=$_SESSION['login_pmi'];

//echo "user:".$login_usr;
include("Includes/FusionCharts.php");
include("../conexion.php");
include("func_datos.php");
$show_values=0;
$show_lab=0;
$tam1=250;
$tam2=150;
$tam3=25;
$tam4=150;
if(isset($_REQUEST['cambiar'])){
	$cambiar=$_REQUEST['cambiar'];
	$sql_con="SELECT * FROM pmi_sao WHERE id_report='$cambiar'";
	$res_con=mysql_db_query($db,$sql_con,$link);
	$row_con=mysql_fetch_array($res_con);
	if($row_con['ind']==1) $ind=0;
	else $ind=1;
	$sql_con2="UPDATE pmi_sao SET ind='$ind' WHERE id_report='$cambiar'";
	mysql_db_query($db,$sql_con2,$link);
}
?>
<html>
<head><script language="JavaScript">
<!--
function ampliar(rep,fecha1,fecha2) {
	window.open("report_amp.php?rep="+rep+"&fecha1="+fecha1+"&fecha2="+fecha2,'Reporte', 'width=950,height=700,status=no,resizable=no,top=0,left=50,dependent=yes,alwaysRaised=yes');
}
-->
</script>
<title>PANEL DE MANDO</title><script language="JavaScript" src="Charts/FusionCharts.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 24px;
	color: #000000;
}
.Estilo2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #000000;
	background-color:#FFFFFF
}
.Estilo3 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
	background-color:#FFFFFF
}
.Estilo11 {color: #FFFFFF; font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
.Estilo14 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
-->
</style>
</head>

<body bgcolor="#CCCCCC" leftmargin="2" topmargin="2">
<br>
<div align="center" class="Estilo1">
      SAO - ACCIONES
    </div><br> 
<div align="center">
<table ssborder="0">
<tr>
<td colspan="6" align="center"><script language="JavaScript" src="calendar.js"></script>
<form action="" method="POST" name="form2">
<table align="center" border="1">
<TR align="center" style="Estilo1"><TD>
                    <strong>No. </A></strong>
                  </TD><TD>
                    <strong>Reporte</strong>
                  </TD><TD>
                    <strong>SAO</strong>
                  </TD></TR>
<?php 
$sql_sao="SELECT * FROM pmi_sao";
$res_sao=mysql_db_query($db,$sql_sao,$link);
while($row_sao=mysql_fetch_array($res_sao)){
	echo "<TR style=\"Estilo1\"><TD>";
	if($row_sao['ind']=='1') echo "<A href=\"sao_param_s.php?id_report=$row_sao[id_report]\">$row_sao[id_report]</a>";
	else echo $row_sao['id_report'];
	echo "</TD><TD>$row_sao[nom]</TD><TD><INPUT type=\"checkbox\" ";
	if($row_sao['ind']=='1') echo "checked";
	echo " name=\"check\" onchange=cambiar('$row_sao[id_report]')></TD></TR>";
}
?>
</table>
</form></td></tr>
<?php
if(isset($DA) && isset($MA)){
$sql_rol="SELECT * FROM pmi_rol WHERE login_usr='$login_usr'";
$result = mysql_db_query($db,"SHOW COLUMNS FROM pmi_rol",$link);
$x=0;
while($roww=mysql_fetch_array($result)){
	$rowww[$x]=$roww['Field'];
	$x++;
}
$res_rol=mysql_db_query($db,$sql_rol,$link);
$row_rol=mysql_fetch_row($res_rol);
$nume=mysql_num_fields($res_rol);
//echo $nume;
$flager=3;
for($k=2;$k<$nume;$k++){
	if($row_rol[$k]=='1'){
		if ($flager % 3 == 0) echo "<tr>";
		echo "<td><table><tr><td>";
		include("reportes/".$rowww[$k].".php");?>
		<input name="          AMPLIAR          " type="button" class="Estilo2" id="AMPLIAR" onClick="ampliar('<?php=$rowww[$k]?>','<?php=$fecha1?>','<?php=$fecha2?>')" value="                     AMPLIAR                     ">
		<?php
		echo "<td>";
		if ($row_pmi['ind']<>0){
			include("reportes/a_i1.php");
		}
		echo "</td></tr></table></td>";
		if (($flager-2) % 3 == 0) echo "<tr>";
		$flager++;
//		echo "campo: $rowww[$k] - valor:$row_rol[$k] <br>";
	}
}
}
?>
    <td valign="bottom" colspan="2">
</td>
  </tr>
</table>
</div>
</body>
</html>
<script language="JavaScript" type="text/javascript">
function cambiar(val){
	//alert(val);
	var pagina="sao_param.php?cambiar="+val;	
	self.location=pagina;
}
</script>