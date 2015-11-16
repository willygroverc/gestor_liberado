<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		17/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

require("conexion.php")?><title>YanapTi</title>
<script language="JavaScript" src="calendar.js"></script>
<form method="post" name="form2" id="form2">
<table background="images/fondo.jpg" width="98%"  align="center" border="1">
<tr>
  <td  bgcolor="#006699" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica"><b>IMPRIMIR TAREAS </b></font></td>
</tr>
<tr><td align="center"><p><br>
        <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>
        <input name="IdProgTarea" type="hidden" id="IdProgTarea" value="<?php echo $IdProgTarea?>">
        <font color="#000000">Busqueda por :</font></strong></font>
        <font color="#000000">
  <select name="menu" id="menu">
          <option value="general">General</option>
          <option value="realizado"<?php if (isset($menu) && $menu=="realizado") echo 'selected';?>>Realizado por</option>
          <option value="revisado"<?php if (isset($menu) && $menu=="revisado") echo 'selected';?>>Revisado por</option>
      </select>
&nbsp;&nbsp;
  <select name="selecta">
        <option value="%">General</option>
        <?php
			$sqltec="SELECT * from users WHERE tipo2_usr='T' ORDER BY apa_usr";
			$resultec= mysql_query($sqltec);
			while($rowtec= mysql_fetch_array($resultec)){
			?>
        <option value="<?php echo $rowtec['login_usr'];?>"<?php if (isset($selecta) && $selecta==$rowtec['login_usr']) echo 'selected'; ?>><?php echo $rowtec['apa_usr'].' '.$rowtec['ama_usr'].' '.$rowtec['nom_usr'];?></option>
        <?php
			}
			?>
  </select>
  <br>
  <br>
  <font size="2" face="Arial, Helvetica, sans-serif"><strong>Del:</strong></font></font>
        <font color="#000000">
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
        </select>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> &nbsp;<strong> Al:</strong>
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
        </select>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></font></font></p>
    <p>
      <input name="BUSCAR" type="button" onClick="enviar()" id="BUSCAR" value="  BUSCAR  ">
      <br><br>
    </p>
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
</script>		</td></tr>
</table>
</form>
<script language="javascript">
<!--
function enviar(){
	var IdProgTarea="<?php echo $IdProgTarea?>";
	var form=document.form2;
	var tarea="<?php echo $tarea?>";
	open("imprimir_tarea.php?IdProgTarea="+IdProgTarea+"&menu="+form.menu.value+"&selecta="+form.selecta.value+"&tarea="+tarea+"&DA="+form.DA.value+"&MA="+form.MA.value+"&AA="+form.AA.value+"&DE="+form.DE.value+"&ME="+form.ME.value+"&AE="+form.AE.value,"YanapTi",'width=1024,height=768,status=yes,resizable=yes,top=0,left=0,menubar=yes,dependent=yes,alwaysRaised=yes');
	close();
}
-->
</script>