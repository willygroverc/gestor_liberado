<?php
require ("conexion.php");
$sql="SELECT login_usr, CONCAT(nom_usr, ' ', apa_usr, ' ', ama_usr) AS nombre FROM users WHERE tipo2_usr='T' ORDER BY apa_usr";
$rs=mysql_query($sql);
while ($tmp=mysql_fetch_array($rs)) {
	$lstTecnico[$tmp['login_usr']]=$tmp['nombre'];
}

$sql="SELECT DISTINCT area_usr as area FROM users ORDER BY area_usr";
$rs=mysql_query($sql);
while ($tmp=mysql_fetch_array($rs)) {
	$lstArea[$tmp['area']]=$tmp['area'];
}
?>
<html>
<head>
	<title>IMPRESION</title>
<script lenguaje="javascript" type="text/javascript">
function irapagina2(pagina2){         
 		 if (pagina2!="") {
     	 	self.location = pagina2;
 		 }
}
function cambio2(numero2){        
		 if (!foco_texto2){
				 irapagina2("impresion_seleccionar.php?opc="+numero2);
		 } 
}
var foco_texto2=false;

function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function cambio(numero){        
		 if (!foco_texto){
				 irapagina("impresion_seleccionar.php?op="+numero);
		 } 
}
var foco_texto=false;
</script>

</head>
<body background="images/fondo.jpg" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<script language="JavaScript" src="calendar.js"></script>
<table width="100%" background="images/fondo.jpg">
          <tr> <td colspan="4" bgcolor="#006699">             
			<div align="center"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">ELIJA 
                EL TIPO DE IMPRESION QUE DESEA</font><font size="3" face="Arial, Helvetica, sans-serif"><br>
            </font></strong></div></td></tr>          
</table>		  
<center>
    	 
		<font face="Arial, Helvetica, sans-serif" size="2"><B>GENERAL</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
		<input type="radio" name="opcion" value="F" onClick="cambio2(this.value)" <?php if (isset($opc) && $opc == 'F') print "checked";  ?>>
		<font face="Arial, Helvetica, sans-serif" size="2"><B>POR FECHAS</B></font> <br>  
 
</center>

<?php 
if (isset($opc) && $opc == "F")
{	require_once ( "ValidatorJs.php" );
	$valid = new Validator ( "form1" );
	$valid->addIsDate   ( "DA", "MA", "AA", "Fecha de Inicio, $errorMsgJs[date]" );
	$valid->addIsDate   ( "DE", "ME", "AE", "Fecha de Conclusion, $errorMsgJs[date]" );
	$valid->addCompareDates   ( "DA", "MA", "AA","DE", "ME", "AE", "Fecha Del y Fecha Al, $errorMsgJs[compareDates]");
	$valid->addFunction("OpenPrint2","");
	print $valid->toHtml ();
}
?>
<?php
//if ($enviar || $op || $op=="0")
/*if ($op != "F")
{	
		echo "<table width='100%'>";
        echo "<tr> <td colspan='4' bgcolor='#006699'>";             
	    echo "<div align='center'><strong><font color='#FFFFFF' size='3' face='Arial, Helvetica, sans-serif'>ELIJA ";
        echo "EL TIPO DE IMPRESION QUE DESEA</font><font size='3' face='Arial, Helvetica, sans-serif'><br>";
        echo "</font></strong></div></td></tr>";
		echo "</table>";
		echo "<center>";
      	echo "<FORM>";
		if ($uno == "1" || $op || $op=="0")
		echo "<input  type='radio' value='1' name='uno' checked >";
		else
		echo "<input  type='radio' value='1' name='uno'>";
		echo "<font size=2 face=arial><b>GENERAL</b></font>&nbsp;&nbsp;";
		if ( $uno == "2" )		
		echo "<INPUT  type='radio' value='2' name='uno' checked >";
		else 
		echo "<INPUT  type='radio' value='2' name='uno'>";
        echo "<font size=2 face=arial><B>POR FECHAS&nbsp;&nbsp; </B></font>";
        echo "<input type=submit value='ELEGIR OPCION' name='enviar'>";
        echo "</input> ";
        echo "</FORM>";
		echo "</center>";
}*/
//if ( $uno == "1" || $op || $op=="0")

if (@$opc != "F" )
{
?>
<form action="impresion_seleccionar.php" method="POST" name="form3" target="_blank">
  <table width="100%" border="1" align="center"><tr><td>
  <table width="100%" border="1" align="center">
    <tr>
      <td>
	    <table width="100%">
          <tr>
		  <td>&nbsp;</td>
		  </tr>
		  <tr> 
            <td align="right"><font size="2" face="Arial, Helvetica, sans-serif"><b>Agrupar por:</b></font> 
			<select name="menu" id="menu" onChange="cambio(this.options.selectedIndex)">
                <option value="todo" <?php if (isset($op) && $op=="0") echo 'selected' ?>>TODO</option>
                <option value="usuarios_bloqueados" <?php if (isset($op) && $op=="1") echo 'selected';?>>USUARIOS BLOQUEADOS</option>
                <option value="usuarios_eliminados" <?php if (isset($op) && $op=="2") echo 'selected';?>>USUARIOS ELIMINADOS</option>
                <option value="tipo_usuario" <?php if (isset($op) && $op=="3") echo 'selected' ?>>TIPO DE USUARIO</option>
                <option value="area" <?php if (isset($op) && $op=="4") echo 'selected';?>>AREA</option>
                <option value="agencia" <?php if (isset($op) && $op=="5") echo 'selected';?>>AGENCIA</option>
            </select>
			</td>
			<?php if (isset($op) && $op=="3"){ ?>
            <td>
			<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Tipo:</b></font>
			<select name="tipo_usuario">
			<option value="A">ADMINISTRADOR</option>
			<option value="T">TECNICO</option>
			<option value="C">CLIENTE</option>
			</select>
                  </td>
			<?php }?>
			<?php if (isset($op) && $op=="4"){ ?>
            <td>
			<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<b>Area:</b></font>
			<select name="area">
	          <?php 
			  $sql1 = "SELECT DISTINCT(area_usr) FROM users ORDER BY area_usr ASC";
			  $result1 = mysql_query($sql1);
			  while ($row1 = mysql_fetch_array($result1)){
					echo '<option value="'.$row1['area_usr'].'">'.$row1['area_usr'].'</option>';
				}
		  	  ?>
        	</select>			
			</td>
			<?php }?>
			<?php if (isset($op) && $op=="5"){ ?>
            <td>
			<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Agencia:</b></font>
			<select name="agencia">
	          <?php 
			  $sql1 = "SELECT DISTINCT(nombre_dadicional) FROM datos_adicionales WHERE tipo_dadicional='agencia' ORDER BY nombre_dadicional ASC";
			  $result1 = mysql_query($sql1);
			  while ($row1 = mysql_fetch_array($result1)){
					echo '<option value="'.$row1['nombre_dadicional'].'">'.$row1['nombre_dadicional'].'</option>';
				}
		  	  ?>
        	</select>			
			</td>
			<?php }?>
			<td align="left">
			
			<input name="IMPRE" type="button" value="IMPRIMIR" onClick="OpenPrint(this)">
			&nbsp;&nbsp;
            </td>
          </tr>
          <tr>
		  <td>&nbsp;</td>
		  </tr>
        </table>
	  </td>
    </tr>
  </table>
  </td></tr></table>
  <p>&nbsp;</p>
</form>
<script language="JavaScript">
<!--
	function OpenPrint () {
		var form=document.form3;
		if (form.menu.value=="todo" || form.menu.value=="usuarios_bloqueados" || form.menu.value=="usuarios_eliminados"){
			window.open ( "ver_usuarios.php?menu=" + form.menu.value);
		}
		if (form.menu.value=="tipo_usuario"){
			window.open ( "ver_usuarios.php?menu=" + form.menu.value + "&tipo_usuario=" + form.tipo_usuario.value);
		}
		if (form.menu.value=="agencia"){
			window.open ( "ver_usuarios.php?menu=" + form.menu.value + "&agencia=" + form.agencia.value);
		}
		if (form.menu.value=="area"){
			window.open ( "ver_usuarios.php?menu=" + form.menu.value + "&area_usr=" + form.area.value);
		}
	}
-->
</script>
<?php 
}
	if (isset($_REQUEST['opc']) == "F")
	{ //echo
	?>
		<FORM name="form1"  action="impresion_seleccionar.php"  method="post">
		<table border="1" width="100%"><tr><td>
		<table border="1" width="100%"><tr><td>
		<table align=center height="70">
		<tr>
		<td>&nbsp;&nbsp;&nbsp;<font face="Arial, Helvetica, sans-serif" size="2"><b>Agrupar Por:</b></font>
		<select name="menu_fecha" id="menu_fecha">
		<option value="ult_acceso">Fecha de ultimo acceso</option>
		<option value="creacion">Fecha de creacion del usuario</option>
		<option value="eliminacion">Fecha de eliminacion del usuario</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>
	&nbsp;&nbsp;&nbsp;<font face="Arial, Helvetica, sans-serif" size="2"><b>Del: </c></font>
	<select name="DA" id="select">
	  <?php		  		
					$fsist=date("Y-m-d");				
					$ano=substr($fsist,0,4);
					$mes=substr($fsist,5,2);
					$dia=substr($fsist,8,2);
					echo "dia".$dia;
						for($i=1;$i<=31;$i++)
						{	if ( isset ($DA) )						
							{echo "<option value=\"$i\""; if($DA=="$i") echo "selected"; echo">$i</option>";}
							else
							{echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
						}
					?>
	</select>
	<select name="MA" id="select9">
					<?php
					for($i=1;$i<=12;$i++)
					{	if ( isset($MA) )
						{echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
						else
						{echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
					}
					?>
				  </select>
			<select name="AA" id="select6">
			  <?php
					for( $i=2003;$i<=2020;$i++ ) 
					{	if ( isset($AA) )
						{echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
						else
						{echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
					}
					?>
			</select> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
			<a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong> 
			&nbsp;&nbsp;<font face="Arial, Helvetica, sans-serif" size="2"><b>Al: </c></font>							  
							  <select name="DE" id="select7">
					<?php
					$fsist=date("Y-m-d");
					
					$ano=substr($fsist,0,4);
					$mes=substr($fsist,5,2);
					$dia=substr($fsist,8,2);				
	
					for($i=1;$i<=31;$i++)
					{	if (isset($DE))
						{echo "<option value=\"$i\""; if($DE=="$i") echo "selected"; echo">$i</option>";}
						else
						{echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
					}
					?>
				  </select>
			<select name="ME" id="select2">
			  <?php
					for($i=1;$i<=12;$i++)
					{	if (isset($ME))
						{echo "<option value=\"$i\""; if($ME=="$i") echo "selected"; echo">$i</option>";}
						else
						{echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
					}
					?>
			</select> 
			<select name="AE" id="select4">
			  <?php
					for($i=2003;$i<=2020;$i++)
					{	
						if (isset($AE))
						{echo "<option value=\"$i\""; if( $AE=="$i" ) echo "selected"; echo">$i</option>";}
						else
						{echo "<option value=\"$i\""; if( $ano=="$i" ) echo "selected"; echo">$i</option>";}
					}
					?>
			</select>
			<strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
			<a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong> 
			<input type="button" value="   VER   "  name="enviar2" id="enviar2"  <?php=$valid->onSubmit()?>>
			</center>&nbsp;<BR>
			</td></tr></table>
			</td></tr></table>
			</td></tr></table>
			</FORM>
			<script language="JavaScript">
			 var form="form1";
			 var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
				cal.year_scroll = true;
				cal.time_comp = false;
			var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
				cal1.year_scroll = true;
				cal1.time_comp = false;
			
			function OpenPrint2 () {	
				var form = document.form1;
				window.open ( "ver_usuariosfec.php?menu_fecha="+form.menu_fecha.value+"&DA=" + form.DA.value + "&MA=" + form.MA.value + "&AA=" + form.AA.value + "&DE=" + form.DE.value + "&ME=" + form.ME.value + "&AE=" + form.AE.value + "");
				return false;	
			}
			</script>
<?php	
}
?>
<?php 

?>
</body>
</html>