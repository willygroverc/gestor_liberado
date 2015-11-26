<?php
include("Includes/FusionCharts.php");
include("../conexion.php");
include("func_datos.php");
$val_area=$_REQUEST['val_area'];
$show_values=0;
$show_lab=0;
$tam1=250;
$tam2=150;
$tam3=25;
$tam4=150;
if(isset($DA) && isset($MA)){
if (strlen($DA) == 1){ $DA = "0".$DA; }
if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
	$fecha1 = $AA."-".$MA."-".$DA;   
if (strlen($DE) == 1){ $DE = "0".$DE; }
if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fecha2 = $AE."-".$ME."-".$DE; 
}
//echo $val_area;
?>
<html>
<head>
<script language="JavaScript">
<!--
function ampliar(rep,fecha1,fecha2) {	
	window.open("report_amp.php?rep="+rep+"&fecha1="+fecha1+"&fecha2="+fecha2,'Reporte', 'width=950,height=700,status=no,resizable=no,top=0,left=50,dependent=yes,alwaysRaised=yes');
}
-->
</script>
<title>PANEL DE MANDO</title>
<script language="JavaScript" src="Charts/FusionCharts.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
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
<div align="center" class="Estilo1">PANEL DE MANDO  INTEGRAL </div><br> 
<div align="center">
<table ssborder="0">
<tr>
<td colspan="6" align="center">

<script language="JavaScript" src="calendar.js"></script>
<form action="" method="POST" name="form2">
<font face="Arial, Helvetica" size="2"><b>Del:</b></font>&nbsp;
				<select name="DA" id="select" class="Estilo3">
  				<?php		  		
				$fsist=date("Y-m-d");				
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);
				for($i=1;$i<=31;$i++)
				{	if ( isset ($DA) ){echo "<option value=\"$i\""; if($DA=="$i") echo "selected"; echo">$i</option>";}						
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
				</select>
				<select name="MA" id="select9" class="Estilo3">
                <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) )  {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else  {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
					}
				}
				?>
               </select>
               <select name="AA" id="select6" class="Estilo3">
               <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($AA) ) {echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
               </select><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        	   <a href="javascript:cal.popup();"><img src="Image/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a>
			   </font>  &nbsp;&nbsp;<font face="Arial, Helvetica" size="2"><b>Al:</b></font>
               <select name="DE" id="select7" class="Estilo3">
                <?php
				$fsist=date("Y-m-d");
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);				
				for($i=1;$i<=31;$i++)
				{	if (isset($DE)) {echo "<option value=\"$i\""; if($DE=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
                </select>
                <select name="ME" id="select2" class="Estilo3">
                <?php
				for($i=1;$i<=12;$i++)
				{	if (isset($ME)) {echo "<option value=\"$i\""; if($ME=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
                </select>
                <select name="AE" id="select4" class="Estilo3">
                <?php
				for($i=2003;$i<=2020;$i++)
				{	if (isset($AE)) {echo "<option value=\"$i\""; if( $AE=="$i" ) echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if( $ano=="$i" ) echo "selected"; echo">$i</option>";}
				}
				?>
                </select><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        	   <a href="javascript:cal1.popup();"><img src="Image/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a>
			   <b>Area:</b>&nbsp;</font>
			   <select name="val_area">
			   		<option value="0">GENERAL</option>
			   <?php
			   	$sql="SELECT * FROM area ORDER BY area_nombre ASC";
					$datos=mysql_query($sql);
			   ?>
			   <?php
                           
			    while($area=mysql_fetch_array($datos)){?>
	    				<option value="<?php=$area['area_cod'];?>" <?php if($val_area==$area['area_cod']) echo "selected"?>><?php echo $area['area_nombre']; ?></option>
				<?php
				 }?>
			   </select>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" value="    VER    " name="enviar2" id="enviar2" class="Estilo3">
<script language="JavaScript">
	 var form="form2";
	 var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		cal.year_scroll = true;
		cal.time_comp = false;
	var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
		cal1.year_scroll = true;
		cal1.time_comp = false;
</script>
	</form></td></tr>
<?php
if(isset($DA) && isset($MA)){
$sql_pmi="SELECT * FROM pmi_sao WHERE id_report IN (1,2,3,4,6,7,8)";
$res_pmi=mysql_db_query($db,$sql_pmi,$link);
$flager=3;
while($row_pmi=mysql_fetch_array($res_pmi)){
if ($flager % 3 == 0) echo "<tr>";
echo "<td><table><tr><td>";
include("reportes/".$row_pmi['nom_arch'].".php");?>
<input name="          AMPLIAR          " type="button" class="Estilo2" id="AMPLIAR" onClick="ampliar('<?php=$row_pmi['nom_arch']?>','<?php=$fecha1?>','<?php=$fecha2?>')" value="                     AMPLIAR                     ">
<?php
echo "<td>";
if ($row_pmi['ind']<>0){
	include("reportes/a_i1.php");
}
echo "</td></tr></table></td>";
if (($flager-2) % 3 == 0) echo "<tr>";
$flager++;
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