<?php 
include ("conexion.php");
$sql="SELECT login_usr, CONCAT(apa_usr,' ',ama_usr,' ',nom_usr) AS nombre FROM users WHERE tipo2_usr='T' ORDER BY apa_usr ASC";
$rs=mysql_db_query($db,$sql,$link);
while ($tmp=mysql_fetch_array($rs)) {
	$lstTecnico[$tmp['login_usr']]=$tmp['nombre'];
}

$sql="SELECT login_usr, CONCAT(apa_usr,' ',ama_usr,' ',nom_usr) AS nombre FROM users WHERE tipo2_usr='C' ORDER BY apa_usr ASC";
$rs=mysql_db_query($db,$sql,$link);
while ($tmp=mysql_fetch_array($rs)) {
	$lstCliente[$tmp['login_usr']]=$tmp['nombre'];
}

$sql="SELECT DISTINCT area_usr as area FROM users ORDER BY area_usr";
$rs=mysql_db_query($db,$sql,$link);
while ($tmp=mysql_fetch_array($rs)) {
	$lstArea[$tmp['area']]=$tmp['area'];
}

$sql="SELECT DISTINCT ciu_usr as ciudad FROM users ORDER BY ciu_usr";
$rs=mysql_db_query($db,$sql,$link);
while ($tmp=mysql_fetch_array($rs)) {
	$lstCiudad[$tmp['ciudad']]=$tmp['ciudad'];
}

$sql1="SELECT * FROM control_parametros";
$rs1=mysql_db_query($db,$sql1,$link);
$row1=mysql_fetch_array($rs1);
if ($row1['agencia']=="si") {
	$sql="SELECT DISTINCT nombre_dadicional as NomAdicional FROM datos_adicionales";
	$rs=mysql_db_query($db,$sql,$link);
	while ($tmp=mysql_fetch_array($rs)) {
		$lstNomAdicional[$tmp['NomAdicional']]=$tmp['NomAdicional'];
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
<body topmargin="0" onLoad="redirect(<?php echo $act ?>, <?php echo $name ?>)">
<script language="JavaScript" src="calendar.js"></script>
<?php
if ( isset($_REQUEST['op']) == "F"){ 
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
	<input type="radio" name="opcion" value="G" onClick="cambio(this.value)" <?php if (isset($_REQUEST['op']) == 'G' || isset($_REQUEST['option']) == "G") print "checked"; else print "checked"; ?>>
	<font face="Arial, Helvetica, sans-serif" size="2"><B>GENERAL</B></font>&nbsp;&nbsp;&nbsp;
	<input type="radio" name="opcion" value="F" onClick="cambio(this.value)" <?php if (isset($_REQUEST['op']) == 'F' || isset($_REQUEST['option']) == "F") print "checked";  ?>>
<font face="Arial, Helvetica, sans-serif" size="2"><B>POR FECHAS</B></font> &nbsp;&nbsp;&nbsp;
	<input type="radio" name="opcion" value="I" onClick="cambio(this.value)" <?php if (isset($_REQUEST['op']) == 'I' || isset($_REQUEST['option']) == "I") print "checked";  ?>>
<font face="Arial, Helvetica, sans-serif" size="2"><B>INCIDENTES</B></font>&nbsp;&nbsp;&nbsp;
	<input type="radio" name="opcion" value="P" onClick="cambio(this.value)" <?php if (isset($_REQUEST['op']) == 'P' || isset($_REQUEST['option']) == "P") print "checked";  ?>>
<font face="Arial, Helvetica, sans-serif" size="2"><B>PUBLICO/PRIVADO</B></font> <br> 
</td></tr>
<tr><form action="" method="POST" name="form2">
	<input type="hidden" name="op" value=<?php echo isset($_REQUEST['op']);?>>
	<input type="hidden" name="option" value=<?php echo isset($_REQUEST['option']);?>>
	<td height="84"> 
		<table border="1"><tr><td>
<?php
if(isset($_REQUEST['op'])!='I'){
?>		

		<table width="100%" border="0">
		<tr>				
          <td width="34" height="40"></td>
				<td width="132"><font size="2" face="Arial, Helvetica"><B>Agrupar por:</B></font></td>
				<td width="781">
				<select name="menu" id="select" onChange=redirect(this.options.selectedIndex,0)>
				<option value="GENERAL" <?php if(isset($_REQUEST['valmenu'])=="GENERAL"){echo "selected";}?> >GENERAL</option>
                <option value="TECNICO" <?php if(isset($_REQUEST['valmenu'])=="TECNICO"){echo "selected";}?> >ENVIADAS POR TECNICO</option>
                <option value="CLIENTE" <?php if(isset($_REQUEST['valmenu'])=="CLIENTE"){echo "selected";}?>>ENVIADAS POR CLIENTE</option>
                <option value="AREA" <?php if(isset($_REQUEST['valmenu'])=="AREA"){echo "selected";}?>>AREA</option>
                <option value="CIUDAD" <?php if(isset($_REQUEST['valmenu'])=="CIUDAD"){echo "selected";}?>>CIUDAD</option>
                <option value="ASIGNADO" <?php if(isset($_REQUEST['valmenu'])=="ASIGNADO"){echo "selected";}?>>ASIGNADO A</option>
                <option value="NOASIGNADO" <?php if(isset($_REQUEST['valmenu'])=="NOASIGNADO"){echo "selected";}?>>NO ASIGNADO</option>
                <option value="NOSOLUCION" <?php if(isset($_REQUEST['valmenu'])=="NOSOLUCION"){echo "selected";}?>>NO SOLUCIONADO</option>
				<?php 
				$sql1="SELECT * FROM control_parametros";
				$rs1=mysql_db_query($db,$sql1,$link);
				$row1=mysql_fetch_array($rs1);
				if ($row1['agencia']=="si") {
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
				<select name="nombre" id="nombre" >
					<?php
					 //foreach ($lstTecnico as $k => $v) {
						$v="GENERAL";
						print "<option value=\"$k\">$v</option>";
						//} 
					?>
				 </select>
				 &nbsp;&nbsp;&nbsp;&nbsp;
					<!--boton-->
				</td>		
			</tr>
			
			<!------------------>
			<tr id="nivel" >
				<td width="34" height="37"></td>
				<td width="132"><font size="2" face="Arial, Helvetica"><B>Nivel 1:</B></font></td>
				<td width="34">
					<select name="nivel1" onChange="tipo(this.value)">
						<option value="0">GENERAL</option>
						<?php 
							$sql = "select *from area ORDER BY area_nombre";
							$res = mysql_db_query($db,$sql,$link);
							while($row = mysql_fetch_array($res))
							{
								echo "<option value=\"$row[area_cod]\"";
								if ($row['area_cod']==isset($_REQUEST['menu2'])){echo"selected";}
								echo">$row[area_nombre]</option>";
							}
						?>
				 	</select>
				</td>
			</tr>
			<tr id="nivel" >
				<td width="34" height="37"></td>
				<td width="132"><font size="2" face="Arial, Helvetica"><B>Nivel 2:</B></font></td>
				<td width="34">
					<select name="nivel2" onChange="tipo1(<?php if (empty($menu2)){echo "0";} else {echo "$menu2";}?>,this.value)">
					  	<option value="0">  General  </option>
						<?php
							$sql1 = "SELECT * FROM dominio WHERE id_area='$menu2' ORDER BY dominio";
							$res1 = mysql_db_query($db,$sql1,$link);
							while($row1 = mysql_fetch_array($res1))
							{
								 echo "<option value=\"$row1[id_dominio]\"";
								 if ($row1[id_dominio]==$obco){echo"selected";}
								 echo ">$row1[dominio]</option>";
							} 
						?>
				    </select>
				</td>
			</tr>
			<tr id="nivel">
				<td width="34" height="37"></td>
				<td width="132"><font size="2" face="Arial, Helvetica"><B>Nivel 3:</B></font></td>
				<td width="34">
					<select name="nivel3" >
					  	<option value="0" >General</option>
						<?php
							$sql2 = "SELECT * FROM objetivos WHERE id_dominio='$obco'";
							$res2 = mysql_db_query($db,$sql2,$link);
							while($row2 = mysql_fetch_array($res2))
							{
								if($row2[id_objetivo] == $objetivo)
								{
									echo"<option value='$row2[id_objetivo]' selected>".$row2[objetivo]."</option>";	
								}
								else
								{
									echo"<option value='$row2[id_objetivo]'>".$row2[objetivo]."</option>";
								} 
							} 
						?>
				    </select>
				</td>
			</tr>

			<!------------------>
			<tr>
				<td colspan="2"></td>
				<td>
					 <?php if (isset($_REQUEST['op']) != "F" && isset($_REQUEST['option']) != "F" && isset($_REQUEST['op']) != "P"){?>
					 <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					 <input name="IMPRE" type="button" value="    VER    " onClick="OpenPrint()">
					 <?php }?>
				</td>
			</tr>
			<?php if (isset($_REQUEST['op']) == "F" || isset($_REQUEST['option']) == "F" || isset($_REQUEST['op']) == "P"){?>
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
		
function OpenPrint7() 
{	
		var form = document.form2;
		//
		area = document.form2.nivel1.value;
		dominio = document.form2.nivel2.value;
		objetivo = document.form2.nivel3.value;
		//
		
		if (form.menu.value=="GENERAL")
		{
			if(document.form2.nivel1.value == "0")
			{
				window.open ("report_ordenes3.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "&DA=" + form.DA.value + "&MA=" + form.MA.value + "&AA=" + form.AA.value + "&DE=" + form.DE.value + "&ME=" + form.ME.value + "&AE=" + form.AE.value + "&gen=1<?php if ($op=="P"){ echo "&op=P";}?>");
			}
			else{
				window.open ("report_ordenes3.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "&DA=" + form.DA.value + "&MA=" + form.MA.value + "&AA=" + form.AA.value + "&DE=" + form.DE.value + "&ME=" + form.ME.value + "&AE=" + form.AE.value + "&area="+area+"&dominio="+dominio+"&objetivo="+objetivo+"&gen=0<?php if ($op=="P"){ echo "&op=P";}?>");
			}
			return false;
		} 
		else
		{ 
			window.open ( "report_ordenes3.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "&DA=" + form.DA.value + "&MA=" + form.MA.value + "&AA=" + form.AA.value + "&DE=" + form.DE.value + "&ME=" + form.ME.value + "&AE=" + form.AE.value + "&area="+area+"&dominio="+dominio+"<?php if ($op=="P"){ echo "&op=P";}?>&objetivo="+objetivo);
		}
		close();
		return false;	
}
</script>		
			
<?php }else{?>

			<tr><td height="20"></td></tr>
			<?php }?>			
		</table><?php }else{?>
		<table width="100%" border="0">
          <tr>
            <td width="34" height="40"></td>
            <td width="132"><font size="2" face="Arial, Helvetica"><B>Imprimir</B></font></td>
            <td width="781"><input type="radio" name="opcion1" value="1" checked="checked" onClick="unhabilit()">
	<font face="Arial, Helvetica, sans-serif" size="2"><B>TODOS</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="opcion1" value="0" onClick="habilit()">
<font face="Arial, Helvetica, sans-serif" size="2"><B>POR FECHAS</B></font> &nbsp;</td>
          </tr>

          <!------------------>

          <!------------------>

          <tr>
            <td height="33">&nbsp;</td>
            <td colspan="2"><div align="center"><font face="Arial, Helvetica" size="2"><b>Del:</b></font>&nbsp;
              <select name="DA" id="select3" disabled="disabled">
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
              <select name="MA" id="select8" disabled="disabled">
                <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) )  {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else  {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
					}
				}
				?>
              </select>
              <select name="AA" id="select10" disabled="disabled">
                <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($AA) ) {echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
              </select>
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <a href="javascript:cal3.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> </font> &nbsp;&nbsp;<font face="Arial, Helvetica" size="2"><b>Al:</b></font>
              <select name="DE" id="select11" disabled="disabled">
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
              <select name="ME" id="select12" disabled="disabled">
                <?php
				for($i=1;$i<=12;$i++)
				{	if (isset($ME)) {echo "<option value=\"$i\""; if($ME=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
              </select>
              <select name="AE" id="select13" disabled="disabled">
                <?php
				for($i=2003;$i<=2020;$i++)
				{	if (isset($AE)) {echo "<option value=\"$i\""; if( $AE=="$i" ) echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if( $ano=="$i" ) echo "selected"; echo">$i</option>";}
				}
				?>
              </select>
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <a href="javascript:cal4.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> </font> &nbsp;&nbsp;&nbsp;&nbsp;
               <br>
              <br> 
              <input type="submit" value="    VER    " name="enviar22" id="enviar22"  onClick="OpenPrint7()">            
            </div></td><div>
          </tr><br><br>
          <script language="JavaScript">
	 var form="form2";
	 function unhabilit()
{  	document.form2.AA.disabled=1;
	document.form2.MA.disabled=1;
	document.form2.DA.disabled=1;
  	document.form2.AE.disabled=1;
	document.form2.ME.disabled=1;
	document.form2.DE.disabled=1;
}
	 function habilit()
{  	document.form2.AA.disabled=0;
	document.form2.MA.disabled=0;
	document.form2.DA.disabled=0;
  	document.form2.AE.disabled=0;
	document.form2.ME.disabled=0;
	document.form2.DE.disabled=0;
}

	 var cal3 = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		cal3.year_scroll = true;
		cal3.time_comp = false;
	var cal4 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
		cal4.year_scroll = true;
		cal4.time_comp = false;
		
function OpenPrint7() 
{	
		var form = document.form2;
		
		if (document.form2.opcion1[0].checked)
		{
			window.open ("report_ordenesi.php");
		} 
		else
		{ 
			window.open ( "report_ordenesi.php?DA=" + form.DA.value + "&MA=" + form.MA.value + "&AA=" + form.AA.value + "&DE=" + form.DE.value + "&ME=" + form.ME.value + "&AE=" + form.AE.value + "&fecha=true");
		}
		close();
		return false;	
}
        </script>
        </table>
		
		<?php }?>
		</td>
		</tr>
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
function redirect(x,y)
{			xmenu = document.form2.menu.options.selectedIndex;
			xnombre = document.form2.nombre.options.selectedIndex;
			for (m=temp.options.length-1;m>0;m--)
			temp.options[m]=null
			for (i=0;i<group[x].length;i++){
			temp.options[i]=new Option(group[x][i].text,group[x][i].value)
			}
			if(y == 0) temp.options[0].selected=true
			else temp.options[y].selected=true
			
}					

//OpenPrint()
function OpenPrint () 
{
		var form=document.form2;
		area = document.form2.nivel1.value;
		dominio = document.form2.nivel2.value;
		objetivo = document.form2.nivel3.value;

		if (form.menu.value=="GENERAL") 
		{	
			if(document.form2.nivel1.value == "0"){window.open ("report_ordenesg.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "&gen=1");}
			else{
				window.open ("report_ordenesg.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "&area="+area+"&dominio="+dominio+"&objetivo="+objetivo+"&gen=0");
			}
			return false;
		}
		else 
		{
			window.open ("report_ordenesg.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "&area="+area+"&dominio="+dominio+"&objetivo="+objetivo+"");
		}
		close();		
		return false;	
}
	

</script>

<script language="javascript1.2">
//
// Funciones adicionales 
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function tipo(men){
			act = document.form2.menu.options.selectedIndex;
			nom = document.form2.nombre.options.selectedIndex;
			gral = document.form2.op.value;
			if(gral == ""){gral = document.form2.option.value;}
			des = document.form2.nivel1.value;
			valmenu = document.form2.menu.value;
			valnombre = document.form2.nombre.value;
		 	irapagina("orden_estadistica2.php?menu2="+men+"&valmenu="+valmenu+"&valnombre="+valnombre+"&option="+gral + "&act="+ act + "&name=" + nom);
			return false;
		 }
function tipo1(men,va1){
			act = document.form2.menu.options.selectedIndex;
			nom = document.form2.nombre.options.selectedIndex;
			gral = document.form2.op.value;
			if(gral == ""){gral = document.form2.option.value;}
			des = document.form2.nivel1.value;
			valmenu = document.form2.menu.value;
			valnombre = document.form2.nombre.value;
		 	irapagina("orden_estadistica2.php?menu2="+men+"&obco="+va1+"&valmenu="+valmenu+"&valnombre="+valnombre+"&option="+gral+"&act="+act + "&name=" + nom);
			return false;
			
		 }
//Fin
</script>

</body>
</html>
