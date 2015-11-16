<?php
include ("conexion.php");

if ( $tipo == "1") $tabla = "progtareasdiaria1";
else if ( $tipo == "2") $tabla = "progtareassemanal1";
else if ( $tipo == "3") $tabla = "progtareasmensual1";
else if ( $tipo == "4") $tabla = "progtareastrimestral1";
else if ( $tipo == "5") $tabla = "progtareassemestral1";
else if ( $tipo == "6") $tabla = "progtareasanual1";

$sql="SELECT login_usr, CONCAT(apa_usr,' ',ama_usr,' ',nom_usr) AS nombre, IdProgTarea 
	FROM users, $tabla WHERE users.login_usr=$tabla.RealizadoPor AND IdProgTarea='$IdProgTarea' ORDER BY apa_usr ASC";
$rs=mysql_db_query($db,$sql,$link);
$nf = mysql_num_rows($rs);
if ($nf > 0)
{	while ($tmp=mysql_fetch_array($rs)) {
		$lstTecnico[$tmp[login_usr]]=$tmp[nombre];
	}
}
else { $lstTecnico[ninguno] = "         ";}
?>
<html>
<head>
<title>GesTor F1 - Programacion de Tareas</title>
<script lenguaje="javascript" type="text/javascript">
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function cambio(numero,IdProgTarea2,tipo2){        
		 if (!foco_texto){
				 irapagina("ver_lista_tareas.php?op="+numero+"&IdProgTarea="+IdProgTarea2+"&tipo="+tipo2);
		 } 
}
var foco_texto=false;
</script>

</head>
<body>
<script language="JavaScript" src="calendar.js"></script>
<?php
$tipoDesc=array(
	1=>"PROGRAMACION DE TAREAS DIARIAS",
	2=>"PROGRAMACION DE TAREAS SEMANALES",
	3=>"PROGRAMACION DE TAREAS MENSUALES",
	4=>"PROGRAMACION DE TAREAS TRIMESTRALES",
	5=>"PROGRAMACION DE TAREAS SEMESTRALES",
	6=>"PROGRAMACION DE TAREAS ANUALES"
	);
	
if ($op == "F")	
{	require_once ( "ValidatorJs.php" );
	$valid = new Validator ( "form1" );
	$valid->addIsDate   ( "DiaD", "MesD", "AnoD", "Fecha de Inicio, $errorMsgJs[date]" );
	$valid->addIsDate   ( "DiaA", "MesA", "AnoA", "Fecha de Conclusion, $errorMsgJs[date]" );
	$valid->addCompareDates   ( "DiaD", "MesD", "AnoD","DiaA", "MesA", "AnoA", "Fecha de y Fecha a, $errorMsgJs[compareDates]");
	$valid->addFunction("openPrint7","");
	echo $valid->toHtml ();
}

//print $tipo." ".$IdProgTarea." ".$op;
?>
<form name="form1" method="post" action="">

  <table width="98%"  border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr>
      <th bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">&nbsp;
        <?php=$tipoDesc[$tipo]?>
      </font></th>
    </tr>
    <tr>	
      <td align="center"><font size="2" face="Arial, Helvetica, sans-serif">
	<input type="radio" name="opc" value="1" onClick="cambio(this.value, <?php echo $IdProgTarea;?>, <?php echo $tipo;?>)" <?php if ($op == 1) print "checked"; else print "checked"; ?>>
        <font face="Arial, Helvetica, sans-serif" size="2"><B>GENERAL</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input type="radio" name="opc" value="F" onClick="cambio(this.value,  <?php echo $IdProgTarea;?>, <?php echo $tipo;?>)" <?php if ($op == F) print "checked";  ?>> 
        <font face="Arial, Helvetica, sans-serif" size="2"><B>POR FECHAS</B></font> 
      </td>
    </tr>
    <tr align="center">
      <td>
	  <table border="1" width="100%"><tr><td>
	  <table width="100%">
          <tr>
		  	<td width="11" align="left">&nbsp;</td>
			<td width="123" align="left"><font face="Arial, Helvetica, sans-serif" size="2"><b>Agrupar por:</b></font></td>
			<td width="759" >
				<select name="menu" id="select" onChange=redirect(this.options.selectedIndex)>
				<option value="GENERAL" selected>GENERAL</option>
                <option value="RELIZADOPOR">REALIZADOR</option>                
				</select>							 
			</td>
		</tr>
	  	<tr>
			<td></td>
			<td align="left"><font face="Arial, Helvetica, sans-serif" size="2"><b>Nombre:</b></font></td>
			<td> 
				<select name="nombre" id="nombre">
					<?php 
						$v="GENERAL";
						print "<option value=\"$k\">$v</option>";						 
					?>
				 </select>			
			<?php if ($op != "F" ){?>
			<input name="VER2" type="button" id="VER2" value="     VER     " onClick="OpenPrint()">	
			<?php }?>
			</td>
		</tr>
		<?php if ($op == "F") {?>
		<tr>
		<td></td>
		<td colspan="2" align="left">			
	  <font size="2" face="Arial, Helvetica, sans-serif"><b> Del:</b></font> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
      <?php $fsist=date("Y-m-d"); ?>
      <select name="DiaD" id="select4">
        <?php		$fsist=date("Y-m-d");
					$a1=substr($fsist,0,4);
					$m1=substr($fsist,5,2);
					$d1=substr($fsist,8,2);
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
      </select>
      <select name="MesD" id="select5">
        <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
      </select>
      <select name="AnoD" id="select6">
        <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
      </select>
      <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong>&nbsp;&nbsp;</font></strong><font size="2" face="Arial, Helvetica, sans-serif"><b>Al:</b> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
      <select name="DiaA" id="select7">
        <?php
					$a2=substr($fsist,0,4);
					$m2=substr($fsist,5,2);
					$d2=substr($fsist,8,2);				
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d2=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
      </select>
      <select name="MesA" id="select8">
        <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m2=="$i") echo "selected"; echo">$i</option>";
					  }
			      ?>
      </select>
      <select name="AnoA" id="select9">
        <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a2=="$i") echo "selected"; echo">$i</option>";
				      }
	    			?>
      </select>
      <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font>
	<input name="VER" type="button" id="VER" value="     VER     " onClick="openPrint7()">	  
    </td>
	</tr>
	<?php } else{?>
	<tr><td colspan="3" height="15"></td></tr>
	<?php }?>
	</table></td></tr>	
	</table>
  </table>
</form>
<?php if ($op == "F"){?>
 <script language="JavaScript">
		<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['DiaD'], document.forms[form].elements['MesD'], document.forms[form].elements['AnoD']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DiaA'], document.forms[form].elements['MesA'], document.forms[form].elements['AnoA']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		function openPrint7() {
			var opcion = "F";
			var IdProgTarea=<?php=$IdProgTarea?>;
			var tipo=<?php=$tipo?>;
			var menu = document.form1.menu.value;
			var nombre = document.form1.nombre.value; 			
			var fecha1=document.form1.AnoD.value+"-"+document.form1.MesD.value+"-"+document.form1.DiaD.value;
			var fecha2=document.form1.AnoA.value+"-"+document.form1.MesA.value+"-"+document.form1.DiaA.value;
			if(tipo==2) window.open("ver_lista_tareassemanal.php?IdProgTarea="+IdProgTarea+"&opcion="+opcion+"&menu="+menu+"&nombre="+nombre+"&fecha1="+fecha1+"&fecha2="+fecha2);
			else if(tipo==3) window.open("ver_lista_tareasmensual.php?IdProgTarea="+IdProgTarea+"&opcion="+opcion+"&menu="+menu+"&nombre="+nombre+"&fecha1="+fecha1+"&fecha2="+fecha2);
			else if(tipo==4) window.open("ver_lista_tareastrimestral.php?IdProgTarea="+IdProgTarea+"&opcion="+opcion+"&menu="+menu+"&nombre="+nombre+"&fecha1="+fecha1+"&fecha2="+fecha2);
			else if(tipo==5) window.open("ver_lista_tareassemestral.php?IdProgTarea="+IdProgTarea+"&opcion="+opcion+"&menu="+menu+"&nombre="+nombre+"&fecha1="+fecha1+"&fecha2="+fecha2);
			else if(tipo==6) window.open("ver_lista_tareasanual.php?IdProgTarea="+IdProgTarea+"&opcion="+opcion+"&menu="+menu+"&nombre="+nombre+"&fecha1="+fecha1+"&fecha2="+fecha2);
			else 
			window.open("ver_lista_tareasdiaria.php?IdProgTarea="+IdProgTarea+"&opcion="+opcion+"&menu="+menu+"&nombre="+nombre+"&AA="+document.form1.AnoD.value+"&MA="+document.form1.MesD.value+"&DA="+document.form1.DiaD.value+"&AE="+document.form1.AnoA.value+"&ME="+document.form1.MesA.value+"&DE="+document.form1.DiaA.value);
			//else window.open("ver_lista_tareasdiaria.php?IdProgTarea="+IdProgTarea+"&general="+general+"&fecha1="+fecha1+"&fecha2="+fecha2);			
		}
//-->
</script>
<?php }?>
</body>
</html>
<script language="JavaScript">
<!--
/*
Double Combo Script Credit
By JavaScript Kit (www.javascriptkit.com)
Over 200+ free JavaScripts here!
*/
 var form="form1";
var groups=document.form1.menu.options.length
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

?>
var temp=document.form1.nombre;
function redirect(x){
for (m=temp.options.length-1;m>0;m--) 
temp.options[m]=null
for (i=0;i<group[x].length;i++){
temp.options[i]=new Option(group[x][i].text,group[x][i].value)
}
temp.options[0].selected=true
}	
 //var form="form1";				
function OpenPrint(){
	var IdProgTarea=<?php=$IdProgTarea?>;
	var tipo=<?php=$tipo?>;
	var menu = document.form1.menu.value;
	var nombre = document.form1.nombre.value; 
	var sw = 0;
	if(tipo==2) window.open("ver_lista_tareassemanal.php?IdProgTarea="+IdProgTarea+"&menu="+menu+"&nombre="+nombre);
	else if(tipo==3) window.open("ver_lista_tareasmensual.php?IdProgTarea="+IdProgTarea+"&menu="+menu+"&nombre="+nombre);
	else if(tipo==4) window.open("ver_lista_tareastrimestral.php?IdProgTarea="+IdProgTarea+"&menu="+menu+"&nombre="+nombre);
	else if(tipo==5) window.open("ver_lista_tareassemestral.php?IdProgTarea="+IdProgTarea+"&menu="+menu+"&nombre="+nombre);
	else if(tipo==6) window.open("ver_lista_tareasanual.php?IdProgTarea="+IdProgTarea+"&menu="+menu+"&nombre="+nombre);
	else 
	//window.open("ver_lista_tareasdiaria.php?IdProgTarea="+IdProgTarea+"&general="+general+"&nombre="+nombre+"&AA="+document.form1.AnoD.value+"&MA="+document.form1.MesD.value+"&DA="+document.form1.DiaD.value+"&AE="+document.form1.AnoA.value+"&ME="+document.form1.MesA.value+"&DE="+document.form1.DiaA.value);
	window.open("ver_lista_tareasdiaria_1.php?IdProgTarea="+IdProgTarea+"&menu="+menu+"&nombre="+nombre);
	
}

-->
</script>
