<?php 
include ("conexion.php");

$sql="SELECT id_mod, nombre_mod AS modu FROM modulo WHERE estado<>1 ORDER BY id_mod ASC";
$rs=mysql_db_query($db,$sql,$link);
while ($tmp=mysql_fetch_array($rs)) {
	$lstModulo[$tmp[id_mod]]=$tmp[modu];
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
				 irapagina("ver_archivos_pre.php?op="+numero);
		 } 
}
var foco_texto=false;
</script>
</head>
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
<tr>
    <td  bgcolor="#006699" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica"><b>EL 
      TIPO DE REPORTE QUE DESEA</b></font></td>
  </tr>
<tr><td align="center"><br>
	<input type="radio" name="opcion" value="G" onClick="cambio(this.value)" <?php if ($op == G) print "checked"; else print "checked"; ?>>
	<font face="Arial, Helvetica, sans-serif" size="2"><B>GENERAL</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
	<input type="radio" name="opcion" value="F" onClick="cambio(this.value)" <?php if ($op == F) print "checked";  ?>>
<font face="Arial, Helvetica, sans-serif" size="2"><B>POR FECHAS</B></font> <br>  
</td></tr>
<tr><form action="" method="POST" name="form2">
	<input type="hidden" name="op" value=<?php echo $op;?>>
	  <td height="121"> 
        <table border="1"><tr>
            <td height="111"> 
              <table width="100%" border="0">
		<tr>				
          <td width="34" height="40"></td>
				<td width="132"><font size="2" face="Arial, Helvetica"><B>Agrupar por:</B></font></td>
				<td width="781">
				<select name="menu" id="select" onChange=redirect(this.options.selectedIndex)>
				<option value="GENERAL" selected>GENERAL</option>
  				<option value="MODULO">MODULO</option>
				</select>				
				</td>		
			</tr>		
			<tr>
				  <td width="34" height="26"></td>
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
				 <?php }?> 								
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
				 <input type="submit" value="    VER    " name="enviar2" id="enviar2"  <?php=$valid->onSubmit()?>>
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
				window.open ( "ver_archivos_todos.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "&DA=" + form.DA.value + "&MA=" + form.MA.value + "&AA=" + form.AA.value + "&DE=" + form.DE.value + "&ME=" + form.ME.value + "&AE=" + form.AE.value + "");
				return false;	
			}
			
			</script>		
			
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

		if ($lstModulo){
		$i=0;
			foreach ($lstModulo as $k => $v){
			print "group[1][$i]=new Option(\"$v\",\"$k\")\n";
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
		if (form.menu.value=="GENERAL" )
		window.open ("ver_archivos_todos.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "");
		else 
		window.open ("ver_archivos_todos.php?menu=" + form.menu.value + "&nombre=" + form.nombre.value + "");		
		return false;	
	}
</script>
</body>
</html>