<?php 
include ("conexion.php");
$sql="SELECT login_usr, CONCAT(apa_usr,' ',ama_usr,' ',nom_usr) AS nombre FROM users WHERE tipo2_usr='T' ORDER BY apa_usr ASC";
$rs=mysql_db_query($db,$sql,$link);
while ($tmp=mysql_fetch_array($rs)) {
	$lstTecnico[$tmp[login_usr]]=$tmp[nombre];
}

$sql="SELECT login_usr, CONCAT(apa_usr,' ',ama_usr,' ',nom_usr) AS nombre FROM users WHERE tipo2_usr='C' ORDER BY apa_usr ASC";
$rs=mysql_db_query($db,$sql,$link);
while ($tmp=mysql_fetch_array($rs)) {
	$lstCliente[$tmp[login_usr]]=$tmp[nombre];
}

$sql="SELECT DISTINCT area_usr as area FROM users ORDER BY area_usr";
$rs=mysql_db_query($db,$sql,$link);
while ($tmp=mysql_fetch_array($rs)) {
	$lstArea[$tmp[area]]=$tmp[area];
}

$sql="SELECT DISTINCT ciu_usr as ciudad FROM users ORDER BY ciu_usr";
$rs=mysql_db_query($db,$sql,$link);
while ($tmp=mysql_fetch_array($rs)) {
	$lstCiudad[$tmp[ciudad]]=$tmp[ciudad];
}

$sql1="SELECT * FROM control_parametros";
$rs1=mysql_db_query($db,$sql1,$link);
$row1=mysql_fetch_array($rs1);
if ($row1[agencia]=="si") {
	$sql="SELECT DISTINCT nombre_dadicional as NomAdicional FROM datos_adicionales";
	$rs=mysql_db_query($db,$sql,$link);
	while ($tmp=mysql_fetch_array($rs)) {
		$lstNomAdicional[$tmp[NomAdicional]]=$tmp[NomAdicional];
	}
}
?>

<html>
<head>
<script lenguaje="javascript" type="text/javascript">
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function cambio(numero){        
		 if (!foco_texto){
				 irapagina("orden_estadistica2.php?op="+numero);
		 } 
}
var foco_texto=false;
</script>
</head>
<title>GesTor F1 - Impresiones</title></head>
<body topmargin="0" >
<script language="JavaScript" src="calendar.js"></script>
<?php
if ( $op == "F"){ 
	require_once ( "ValidatorJs.php" );
	$valid = new Validator ( "form2" );
	$valid->addIsDate   ( "DA", "MA", "AA", "Fecha de Inicio, $errorMsgJs[date]" );
	$valid->addIsDate   ( "DE", "ME", "AE", "Fecha de Conclusion, $errorMsgJs[date]" );
	$valid->addCompareDates   ( "DA", "MA", "AA","DE", "ME", "AE", "Fecha Del y Fecha Al, $errorMsgJs[compareDates]");
	$valid->addFunction("OpenPrint7","");
	print $valid->toHtml ();
}
?>

<table background="images/fondo.jpg" width="98%"  align="center" border="1">
<tr><td  bgcolor="#006699" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica"><b>IMPRESION</b></font></td></tr>
<tr><td align="center"><br>
	<input type="radio" name="opcion" value="G" onClick="cambio(this.value)" <?php if ($op == G) print "checked"; else print "checked"; ?>>
	<font face="Arial, Helvetica, sans-serif" size="2"><B>GENERAL</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
	<input type="radio" name="opcion" value="F" onClick="cambio(this.value)" <?php if ($op == F) print "checked";  ?>>
<font face="Arial, Helvetica, sans-serif" size="2"><B>POR FECHAS</B></font> <br>  
</td></tr>
<tr><form action="" method="POST" name="form2">
	<input type="hidden" name="op" value=<?php echo $op;?>>
	<td height="84"> 
		<table border="1"><tr><td>
		<table width="100%" border="0">
		<tr>				
          <td width="34" height="40"></td>
				<td width="132"><font size="2" face="Arial, Helvetica"><B>Agrupar por:</B></font></td>
				<td width="781">
				<select name="menu" id="select" onChange=redirect(this.options.selectedIndex)>
				<option value="GENERAL" selected>GENERAL</option>
                <option value="TECNICO" >ENVIADAS POR TECNICO</option>
                <option value="CLIENTE">ENVIADAS POR CLIENTE</option>
                <option value="AREA">AREA</option>
                <option value="CIUDAD">CIUDAD</option>
                <option value="ASIGNADO">ASIGNADO A</option>
				<?php 
				$sql1="SELECT * FROM control_parametros";
				$rs1=mysql_db_query($db,$sql1,$link);
				$row1=mysql_fetch_array($rs1);
				if ($row1[agencia]=="si") {
				?>                
				<option value="ADICIONAL1">AGENCIA</option>
				<?php }?>                
				</select>				
				</td>		
			</tr>		
			<tr>
				<td width="34"></td>
				<td width="132"><font size="2" face="Arial, Helvetica"><B>Nombre:</B></font></td>
				<td width="781">
				<select name="nombre" id="nombre">
					<?php //foreach ($lstTecnico as $k => $v) {
						$v="GENERAL";
						print "<option value=\"$k\">$v</option>";
						//} 
					?>
				 </select>
				 &nbsp;&nbsp;&nbsp;&nbsp;
				 <?php if ($op != "F"){?>
				 <input name="IMPRE" type="button" value="    VER    " onClick="OpenPrint()">
				 <?php }?><br> 								
				</td>		
			</tr>
			<?php if ($op == "F"){?>
			<tr>
				  <td height="33">&nbsp;</td>
				<td colspan="2"><font face="Arial, Helvetica" size="2"><b>Del:</b></font>&nbsp;
				<select name="DA" id="select">
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
				<select name="MA" id="select9">
                <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) )  {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else  {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
					}
				}
				?>
               </select>
               <select name="AA" id="select6">
               <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($AA) ) {echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
               </select><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        	   <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a>
			   </font>  &nbsp;&nbsp;<font face="Arial, Helvetica" size="2"><b>Al:</b></font>
               <select name="DE" id="select7">
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
                <select name="ME" id="select2">
                <?php
				for($i=1;$i<=12;$i++)
				{	if (isset($ME)) {echo "<option value=\"$i\""; if($ME=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
                </select>
                <select name="AE" id="select4">
                <?php
				for($i=2003;$i<=2020;$i++)
				{	if (isset($AE)) {echo "<option value=\"$i\""; if( $AE=="$i" ) echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if( $ano=="$i" ) echo "selected"; echo">$i</option>";}
				}
				?>
                </select><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        	   <a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a>
			   </font>
				&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="submit" value="    VER    " name="enviar2" id="enviar2"  onClick="OpenPrint7()">
				</td>
			</tr>
			<script language="JavaScript">
			 var form="form2";
			 var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
				cal.year_scroll = true;
				cal.time_comp = false;
			var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
				cal1.year_scroll = true;
				cal1.time_comp = false;
			
			function OpenPrint7() {	
				var form = document.form2;
				if (form.menu.value=="GENERAL") 
				window.open ("report_ordenes3.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "&DA=" + form.DA.value + "&MA=" + form.MA.value + "&AA=" + form.AA.value + "&DE=" + form.DE.value + "&ME=" + form.ME.value + "&AE=" + form.AE.value + "");
				else window.open ( "report_ordenes3.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "&DA=" + form.DA.value + "&MA=" + form.MA.value + "&AA=" + form.AA.value + "&DE=" + form.DE.value + "&ME=" + form.ME.value + "&AE=" + form.AE.value + "");
				close();
				return false;	
			}
			
			</script>		
			
			<?php }else{?>
			<tr><td height="20"></td></tr>
			<?php }?>			
		</table>
		</td></tr>
		</table>
		
	</td></form>
</tr>
</table>
<script language="JavaScript">
<!--
/*
Double Combo Script Credit
By JavaScript Kit (www.javascriptkit.com)
Over 200+ free JavaScripts here!
*/

var groups=document.form2.menu.options.length
var group=new Array(groups)
for (i=0; i<groups; i++)
group[i]=new Array()
<?php
	$i = 0;
	$v="GENERAL";
	print "group[0][$i]=new Option(\"$v\",\"$k\")\n";

	$i=0;
	foreach ($lstTecnico as $k => $v){
		print "group[1][$i]=new Option(\"$v\",\"$k\")\n";
		$i++;
	}
	$i=0;
	if (sizeof($lstCliente)>0){
		foreach ($lstCliente as $k => $v){
			print "group[2][$i]= new Option(\"$v\",\"$k\")\n";
			$i++;
		}
	}
	$i=0;
	foreach ($lstArea as $k => $v){
		print "group[3][$i]=new Option(\"$v\",\"$k\")\n";
		$i++;
	}
	$i=0;
	foreach ($lstCiudad as $k => $v){
		print "group[4][$i]=new Option(\"$v\",\"$k\")\n";
		$i++;
	}
	$i=0;
	foreach ($lstTecnico as $k => $v){
		print "group[5][$i]=new Option(\"$v\",\"$k\")\n";
		$i++;
	}
	if ($lstNomAdicional){
		$i=0;
		foreach ($lstNomAdicional as $k => $v){
			print "group[6][$i]=new Option(\"$v\",\"$k\")\n";
			$i++;
		}
	}
?>
var temp=document.form2.nombre;
function redirect(x){
for (m=temp.options.length-1;m>0;m--)
temp.options[m]=null
for (i=0;i<group[x].length;i++){
temp.options[i]=new Option(group[x][i].text,group[x][i].value)
}
temp.options[0].selected=true
}					
	function OpenPrint () {
		var form=document.form2;
		if (form.menu.value=="GENERAL") 
		window.open ("report_ordenesg.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "");
		else 
		window.open ("report_ordenesg.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "");
		close();		
		return false;	
	}
</script>

</body>
</html>