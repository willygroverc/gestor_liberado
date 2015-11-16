<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		07/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require("conexion.php");
$sql="SELECT login_usr, CONCAT(apa_usr,' ',ama_usr,' ',nom_usr) AS nombre FROM users WHERE tipo2_usr='T' OR tipo2_usr='C' ORDER BY apa_usr ASC";
$rs=mysql_query($sql);
while ($tmp=mysql_fetch_array($rs)) {
	$lstTecnico[$tmp['login_usr']]=$tmp['nombre'];
}
?>
<html>
<head>
<title>Impresion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<script lenguaje="javascript" type="text/javascript">
<!--
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function cambio(numero){        
		 if (!foco_texto){
				 irapagina("agenda_impresion_pre.php?op="+numero);
		 } 
}
var foco_texto=false;
-->
</script>
<script language="JavaScript" src="calendar.js"></script>
<body>
<table background="images/fondo.jpg" width="98%"  align="center" border="1">
  <tr>
    <td  bgcolor="#006699" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica"><b>IMPRESION</b></font></td>
  </tr>
  <tr>
    <td align="center"><br> <input type="radio" name="opcion" value="G" onClick="cambio(this.value)" <?php if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'G') print "checked"; else print "checked"; ?>> 
      <font face="Arial, Helvetica, sans-serif" size="2"><B>GENERAL</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <input type="radio" name="opcion" value="F" onClick="cambio(this.value)" <?php if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'F') print "checked";  ?>> 
      <font face="Arial, Helvetica, sans-serif" size="2"><B>POR FECHAS</B></font> 
      <br> </td>
  </tr>
  <tr>
    <form action="" method="POST" name="form2">
        <input type="hidden" name="op" value=<?php echo isset($_REQUEST['op']);?>>
      <td height="84"> <table border="1">
          <tr>
            <td> <table width="100%" border="0">
                <tr> 
                  <td width="34" height="40"></td>
                  <td width="132"><font size="2" face="Arial, Helvetica"><B>Tipo:</B></font></td>
                  <td width="781"> <select name="menu" id="select3" onChange=redirect(this.options.selectedIndex)>
                      <option value="agendas" selected>Lista de Agenda</option>
                      <option value="propo">Proposiciones por Usuarios</optio>
                      <option value="agendas" selected>Lista de Agenda</option>
                    </select> </td>
                </tr>
                <tr> 
                  <td width="34"></td>
                  <td width="132"><font size="2" face="Arial, Helvetica"><B>Nombre:</B></font></td>
                  <td width="781"> <select name="nombre" id="nombre">
                    <?php //	foreach ($lstTecnico as $k => $v) {
							print "<option value=\"GENERAL\">GENERAL</option>";
					//	} 
					?>
                    </select> &nbsp;&nbsp;&nbsp;&nbsp; 
                    
                    <input name="IMPRE" type="button" value="    VER    " onClick="OpenPrint()"> 
                    
                    <br> </td>
                </tr>
                <?php if (isset($_REQUEST['op']) && $_REQUEST['op'] == "F"){?>
                <tr> 
                  <td height="33">&nbsp;</td>
                  <td colspan="2"><font face="Arial, Helvetica" size="2"><b>Del:</b></font>&nbsp; 
                    <select name="DA" id="select3">
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
                    </select> <select name="MA" id="select5">
                      <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) )  {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else  {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
					}
				}
				?>
                    </select> <select name="AA" id="select8">
                      <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($AA) ) {echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
                    </select>
                    <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
                    </font> &nbsp;&nbsp;<font face="Arial, Helvetica" size="2"><b>Al:</b></font> 
                    <select name="DE" id="select10">
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
                    </select> <select name="ME" id="select11">
                      <?php
				for($i=1;$i<=12;$i++)
				{	if (isset($ME)) {echo "<option value=\"$i\""; if($ME=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
                    </select> <select name="AE" id="select12">
                      <?php
				for($i=2003;$i<=2020;$i++)
				{	if (isset($AE)) {echo "<option value=\"$i\""; if( $AE=="$i" ) echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if( $ano=="$i" ) echo "selected"; echo">$i</option>";}
				}
				?>
                    </select>
                    <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
                    </font> &nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" value="    VER    " name="enviar2" id="enviar22"  onClick="OpenPrint7()"> 
                  </td>
                </tr>
                <script language="JavaScript">
			<!--
			 var form="form2";
			 var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
				cal.year_scroll = true;
				cal.time_comp = false;
			var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
				cal1.year_scroll = true;
				cal1.time_comp = false;
			-->
			</script>
                <?php }else{?>
                <tr>
                  <td height="20"></td>
                </tr>
                <?php }?>
              </table></td>
          </tr>
        </table></td>
    </form>
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
	if (form.menu.value=="agendas") window.open('agenda_impresion.php', 'Estadisticas', 'width=600,height=450,status=no,resizable=no,top=150,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=yes');
	if (form.menu.value=="propo") window.open('agenda_impresion_asis.php?elab_por='+form.nombre.value, 'Estadisticas', 'width=600,height=450,status=no,resizable=no,top=150,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=yes');
	close();
	return false;	
}

function OpenPrint7 () {	
	var form = document.form2;
	if (form.menu.value=="agendas") window.open ("agenda_impresionf.php?DA=" + form.DA.value + "&MA=" + form.MA.value + "&AA=" + form.AA.value + "&DE=" + form.DE.value + "&ME=" + form.ME.value + "&AE=" + form.AE.value);
	if (form.menu.value=="propo") window.open ( "agenda_impresion_asisf.php?elab_por=" + form.nombre.value +"&DA=" + form.DA.value + "&MA=" + form.MA.value + "&AA=" + form.AA.value + "&DE=" + form.DE.value + "&ME=" + form.ME.value + "&AE=" + form.AE.value);
	close();
	return false;	
}
-->
</script>
</body>
</html>
