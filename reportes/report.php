<?php
if(isset($VER)){
	$graph="reportes/a".$report.".php";
	if($ord=='1'){
		if (strlen($DA) == 1){ $DA = "0".$DA; }
		if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
			$fecha1 = $AA."-".$MA."-".$DA;   
		if (strlen($DE) == 1){ $DE = "0".$DE; }
		if (strlen($ME) == 1){ $ME = "0".$ME; }
			$fecha2 = $AE."-".$ME."-".$DE; 
	}
}
include("Includes/FusionCharts.php");
include("../conexion.php");
include("func_datos.php");
$show_values=1;
$show_lab=1;
$tam1=600;
$tam2=300;
$tam3=70;
$tam4=300;
?>
<script language="JavaScript" src="Charts/FusionCharts.js"></script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"lang="es" xml:lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ver Reportes</title>
<link href="css/mis_estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.Estilo2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}

-->
</style>
</head>
<script language="JavaScript" src="calendar.js"></script>
<script language="javascript" type="text/javascript">

function cambiaTexto(valor){
	//alert(valor);
	var indice=document.form1.report.options[document.form1.report.selectedIndex].value;
	var texto=new Array(<?php=$var?>);
	document.form1.Desc.value=texto[indice];
} 
var flag=true;
document.form1.DA.disabled=1;
document.form1.MA.disabled=1;
document.form1.AA.disabled=1;
document.form1.DE.disabled=1;
document.form1.ME.disabled=1;
document.form1.AE.disabled=1;
function activar2(form){
	if(flag){
		document.form1.DA.disabled=0;
		document.form1.MA.disabled=0;
		document.form1.AA.disabled=0;
		document.form1.DE.disabled=0;
		document.form1.ME.disabled=0;
		document.form1.AE.disabled=0;
		form.ord.value="1" 
		flag=false;	
	}else{
		document.form1.DA.disabled=1;
		document.form1.MA.disabled=1;
		document.form1.AA.disabled=1;
		document.form1.DE.disabled=1;
		document.form1.ME.disabled=1;
		document.form1.AE.disabled=1;
		form1.ord.value="0"
		flag=true;
	}
}
var peticion = false;
try {
       peticion = new XMLHttpRequest();
 } catch (trymicrosoft) {
       try {
             peticion = new ActiveXObject("Msxml2.XMLHTTP");
 } catch (othermicrosoft) {
       try {
             peticion = new ActiveXObject("Microsoft.XMLHTTP");
 } catch (failed) {
             peticion = false;
 }
 }
 }
  
 if (!peticion)
       alert("ERROR AL INICIALIZAR!");
 function cargarFragmento(fragment_url, element_id) {
       var element = document.getElementById(element_id);
       element.innerHTML = '<p><img src="Imagenes/ajax_loading.gif" /></p>';
       peticion.open("GET", 'reportes/'+fragment_url);
       peticion.onreadystatechange = function() {
       if (peticion.readyState == 4) {
             element.innerHTML = peticion.responseText;
 }
 }
 peticion.send(null);
 }
</script>
<?php
require_once ( "../ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "report",  "El tipo de reporte $errorMsgJs[empty]" );
echo $valid->toHtml ();
?>
<body bgcolor="#CCCCCC">
<table width="100%" border="0">
<tr> <td width="70%" colspan="2" height="550"><table border="2" width="100%" height="350">
  <tr align="center">
    <td valign="middle" width="610">&nbsp;<?php if(isset($VER)){ include($graph);}?></td>
    <td valign="middle" width="90">&nbsp;<?php if(isset($VER)){ include('reportes/i_a26.php');}?></td>
  </tr>
</table>
  </td>
</tr>
  <form action="" method="post" name="form1" id="form1" >
<tr>
  <td colspan="2" align="center">
<font face="Arial, Helvetica" size="2"><b>
Activar Fechas
<input type="checkbox" name="checkbox" onClick="activar2(this.form)" value="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Del:</b></font>&nbsp;
				<select name="DA" id="DA" class="Estilo3" disabled="true">
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
				<select name="MA" id="select9" class="Estilo3" disabled="true">
                <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) )  {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else  {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
					}
				}
				?>
               </select>
               <select name="AA" id="select6" class="Estilo3" disabled="true">
               <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($AA) ) {echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
               </select><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        	   <a href="javascript:cal.popup();"><img src="Image/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a>
			   </font>  &nbsp;&nbsp;<font face="Arial, Helvetica" size="2"><b>Al:</b></font>
               <select name="DE" id="select7" class="Estilo3" disabled="true">
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
                <select name="ME" id="select2" class="Estilo3" disabled="true">
                <?php
				for($i=1;$i<=12;$i++)
				{	if (isset($ME)) {echo "<option value=\"$i\""; if($ME=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
                </select>
                <select name="AE" id="select4" class="Estilo3" disabled="true">
                <?php
				for($i=2003;$i<=2020;$i++)
				{	if (isset($AE)) {echo "<option value=\"$i\""; if( $AE=="$i" ) echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if( $ano=="$i" ) echo "selected"; echo">$i</option>";}
				}
				?>
                </select><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        	   <a href="javascript:cal1.popup();"><img src="Image/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a>
			   </font>
<br><br>
<script language="JavaScript">
	 var form="form1";
	 var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		cal.year_scroll = true;
		cal.time_comp = false;
	var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
		cal1.year_scroll = true;
		cal1.time_comp = false;
</script>
</td></tr>
  <tr width="30%">
    <td>
      <div align="center">
        <select name="report" size="10" onChange="cambiaTexto(value)" class="Estilo1" >
<!--          <option value="0" selected="selected">Seleccione un Grafico</option>-->
          <?php
include("../conexion.php");
$var="'Seleccione un Grafico'";
$sql_me="SELECT * FROM pmi_sao";
$res_me=mysql_query($sql_me);
while($row_me=mysql_fetch_array($res_me)){
	echo "<option value=\"".$row_me['id_report']."\">".$row_me['nom']."</option>";
	$var.=",'".$row_me['desc']."'";
}
?>
        </select>
      </div>
	  <td>
        <p>
		 <select name="desc" size="10" class="Estilo1" cols="100">
<!--          <option value="0" selected="selected">Seleccione un Grafico</option>-->
				  <?php
		include("../conexion.php");
			$sqlusr="SELECT login_usr from users where bloquear<>'2'";
			$resultusr=mysql_query($sqlusr);
			while($filausr=mysql_fetch_array($resultusr)){
				 echo "<option value=\"".$filausr['login_usr']."\">".$filausr['login_usr']."</option>";
			}
		?>
				</select>
         
		  <input name="ord" value="0" type="hidden" />
        </p>
<tr><td colspan="2"><div align="center">
  <input type="submit" name="VER" value="            VER            "<?php echo $valid->onSubmit(); ?>/>
</div>
</form></tr>
</table>

</body>
</html>
