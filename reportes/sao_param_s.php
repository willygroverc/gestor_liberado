<?php
if(isset($_REQUEST['RETORNAR'])) header("location: sao_param.php");
session_start();
if(isset($_SESSION['login_pmi']))
	$login_usr=$_SESSION['login_pmi'];
if(isset($_REQUEST['id_report'])) $id_report=$_REQUEST['id_report']; else $id_report=0;
//include("Includes/FusionCharts.php");
include("../conexion.php");
//include("func_datos.php");
if(isset($_REQUEST['GUARDAR'])){
	$nivel=$_REQUEST['nivel'];
	$accion=$_REQUEST['accion'];
	//tabla pmi_sao no tiene columnas nivel ni aaacion****************
	$sql="UPDATE pmi_sao SET nivel='$nivel' , accion='$accion' WHERE id_report='$id_report'";
	//echo $sql;
	//exit;
	mysql_db_query($db,$sql,$link);
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
OPTION.niv5{background-color:#008000}
OPTION.niv4{background-color:#8BBA00}
OPTION.niv3{background-color:#F6BD0F}
OPTION.niv2{background-color:#FF8000}
OPTION.niv1{background-color:#FF0000}
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
<TR align="center"><TD>
                    <strong>No. </A></strong>
                  </TD><TD>
                    <strong>Reporte</strong>
                  </TD><TD>
                    <strong>Nivel de Alerta</strong>
                  </TD><TD>
		    <strong>Accion</strong>
                  </TD>
</TR>
<?php 
$sql_sao="SELECT * FROM pmi_sao WHERE id_report='$id_report'";
//echo $sql_sao;
$res_sao=mysql_db_query($db,$sql_sao,$link);
$row_sao=mysql_fetch_array($res_sao);
echo "<TR><TD>$row_sao[id_report]</TD><TD>$row_sao[nom]</TD>
<TD align=\"center\"><SELECT name=\"nivel\"><option value=5 class=\"niv1\" ";
	if(isset($row_sao['nivel']) && $row_sao['nivel']=='5') echo "selected";
	echo ">5</option><option value=4 class=\"niv2\" ";
	if(isset($row_sao['nivel']) && $row_sao['nivel']=='4') echo "selected";
	echo ">4</option><option value=3 class=\"niv3\" ";
	if(isset($row_sao['nivel']) && $row_sao['nivel']=='3') echo "selected";
	echo ">3</option><option value=2 class=\"niv4\" ";
	if(isset($row_sao['nivel']) && $row_sao['nivel']=='2') echo "selected";
	echo ">2</option><option value=1 class=\"niv5\" ";
	if(isset($row_sao['nivel']) && $row_sao['nivel']=='1') echo "selected";	
	echo ">1</option></SELECT></TD><TD>"; 
	echo "<SELECT name=\"accion\">
	<option value=1>Enviar correo al SA</option>
	<option value=2>Bloquear cuenta</option>
	</SELECT></TD></TR>";
?>
</table><INPUT type="hidden" name="id_report" value="<?php echo $id_report;?>">
<br>
<INPUT type="submit" name="GUARDAR" value="GUARDAR"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<INPUT type="submit" name="RETORNAR" value="RETORNAR">
</form></td></tr>
    <td valign="bottom" colspan="2">
</td>
  </tr>
</table>
</div>
</body>
</html>
