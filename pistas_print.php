<title></title>
<script language="JavaScript" src="calendar.js"></script>
<?php 
include ("conexion.php");
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsDate   ( "DA", "MA", "AA", "Fecha de Inicio, $errorMsgJs[date]" );
$valid->addIsDate   ( "DE", "ME", "AE", "Fecha de Conclusion, $errorMsgJs[date]" );
$valid->addCompareDates   ( "DA", "MA", "AA","DE", "ME", "AE", "Fecha Del y Fecha Al, $errorMsgJs[compareDates]");
print $valid->toHtml ();
?>
<form name="form1" method="post" action="">
  <table width="100%" height="175" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td  bgcolor="#006699" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica"><b>IMPRESION</b></font></td>
    </tr>
    <tr> 
      <td align="center"><br> 
        <table width="75%" border="0">
          <tr> 
            <td><div align="right"><font size="2" face="Arial, Helvetica"><B>BUSQUEDA POR: </font><font face="Arial, Helvetica, sans-serif">: </B></font></div></td>
            <td><select name="menu" id="select37" onChange="redirect(this.value)">
                <option value="">GENERAL</option>
                <option value="fecha"<?php if ($menu=="fecha") print selected ?>>Fecha</option>
                <option value="proceso" <?php if ($menu=="proceso") print selected ?>>Proceso</option>
                <option value="responsable" <?php if ($menu=="responsable") print selected ?>>Responsable</option>
                <option value="modulo" <?php if ($menu=="modulo") print selected ?>>Modulo</option>
                <option value="archivo" <?php if ($menu=="archivo") print selected ?>>Archivo</option>
                <option value="version" <?php if ($menu=="version") print selected ?>>Version</option>
              </select></td>
          </tr>
        </table>
        <br> </td>
    </tr>
    <tr> 
	  <?php if ($menu){?>
      <td> 
	  <table border="1" width="100%"><tr><td>
        <table border="0">
          <tr>
            <td width="707" align="right" valign="middle" > 
              <?php
	if ($menu=="fecha"){?>
              <font size="2" face="Arial, Helvetica"> <B>Del: </B></font>
              <select name="DA" id="select45">
                  <?php		  		
				if ($fec1){
  				$ano = substr($fec1,0,4);
				$mes = substr($fec1,5,2);
				$dia = substr($fec1,8,2);				
				}else{
				$fsist = date("Y-m-d");				
  				$ano = substr($fsist,0,4);
				$mes = substr($fsist,5,2);
				$dia = substr($fsist,8,2);				
				}
				for($i=1;$i<=31;$i++)
				{	if ( isset ($DA) ){ echo "<option value=\"$i\""; if($DA=="$i") echo "selected"; echo">$i</option>";	}
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
                </select>
                <select name="MA" id="select46">
                  <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) ) {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
                </select>
                <select name="AA" id="select47">
                  <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($AA) ) {echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
                </select>
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font> 
             
              <p><font size="2" face="Arial, Helvetica"><B>Al:</B></font> 
                <select name="DE" id="select48">
                  <?php
				if ($fec2){
  				$ano = substr($fec2,0,4);
				$mes = substr($fec2,5,2);
				$dia = substr($fec2,8,2);				
				}else{
				$fsist=date("Y-m-d");
				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);
				}				
				for($i=1;$i<=31;$i++)
				{	if (isset($DE)) {echo "<option value=\"$i\""; if($DE=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
					?>
                </select>
                <select name="ME" id="select49">
                  <?php
					for($i=1;$i<=12;$i++)
					{	if (isset($ME)) {echo "<option value=\"$i\""; if($ME=="$i") echo "selected"; echo">$i</option>";}
						else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
					}
					?>
                </select>
                <select name="AE" id="select50">
                  <?php
					for($i=2003;$i<=2020;$i++)
					{	if (isset($AE)) {echo "<option value=\"$i\""; if( $AE=="$i" ) echo "selected"; echo">$i</option>";}
						else {echo "<option value=\"$i\""; if( $ano=="$i" ) echo "selected"; echo">$i</option>";}
					}
					?>
                </select>
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font> 
                <script language="JavaScript">
			 var form="form1";
			 var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
				cal.year_scroll = true;
				cal.time_comp = false;
			 var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
				cal1.year_scroll = true;
				cal1.time_comp = false;
			</script></p>
                <?php }
	elseif($menu=="proceso"){?>
                <select name="cond">
                  <option value=""></option>
                  <option value="Backup General" <?php if ($proceso=="Backup General") echo "selected";?>>Backup 
                  General</option>
                  <option value="Backup General por Fechas" <?php if ($proceso=="Backup General por Fechas") echo "selected";?>>Backup 
                  General por Fechas</option>
                  <option value="Backup por Modulo" <?php if ($proceso=="Backup por Modulo") echo "selected";?>>Backup 
                  por Modulo</option>
                  <option value="Backup por Modulo y Fechas" <?php if ($proceso=="Backup por Modulo y Fechas") echo "selected";?>>Backup 
                  por Modulo y Fechas</option>
                  <option value="ctrabajo" <?php if ($proceso=="ctrabajo") echo "selected";?>>Copia 
                  de Trabajo</option>
                  <option value="creacion_archivo" <?php if ($proceso=="creacion_archivo") echo "selected";?>>Creacion 
                  de archivo</option>
                  <option value="creacion_modulo" <?php if ($proceso=="creacion_modulo") echo "selected";?>>Creacion 
                  de modulo</option>
                  <option value="creacion_version" <?php if ($proceso=="creacion_version") echo "selected";?>>Creacion 
                  de version</option>
                  <option value="descargado_ctrabajo" <?php if ($proceso=="descargado_ctrabajo") echo "selected";?>>Descargado 
                  de Copia de Trabajo</option>
                  <option value="descargado_replica" <?php if ($proceso=="descargado_replica") echo "selected";?>>Descargado 
                  de Replica</option>
                  <option value="eliminacion_archivo" <?php if ($proceso=="eliminacion_archivo") echo "selected";?>>Eliminacion 
                  de archivo</option>
                  <option value="eliminacion_modulo" <?php if ($proceso=="eliminacion_modulo") echo "selected";?>>Eliminacion 
                  de modulo</option>
                  <option value="eliminacion_version" <?php if ($proceso=="eliminacion_version") echo "selected";?>>Eliminacion 
                  de version</option>
                  <option value="modificacion_modulo" <?php if ($proceso=="modificacion_modulo") echo "selected";?>>Modificacion 
                  de modulo</option>
                  <option value="replica" <?php if ($proceso=="replica") echo "selected";?>>Replica</option>
                  <option value="repositorio" <?php if ($proceso=="repositorio") echo "selected";?>>Repositorio</option>
                  <option value="revision" <?php if ($proceso=="revision") echo "selected";?>>Revision</option>
                </select>
                <?php }
	elseif($menu=="responsable"){?>
                <select name="cond">
                  <?php 
			  $sql6 = "SELECT DISTINCT(login_pista) FROM pistas_fuentes_gral WHERE agrupar_pista='$id_pista' ORDER BY login_pista ASC";
			  $result6 = mysql_db_query($db,$sql6,$link);
			  while ($row6 = mysql_fetch_array($result6)) 
				{
					echo "<option value=\"$row6[login_pista]\" selected>$row6[login_pista]</option>";
					}
		  ?>
                </select>
                <?php }
	elseif($menu=="modulo"){?>
                <select name="cond">
                  <?php 
			  $sql7 = "SELECT DISTINCT(id_mod) FROM pistas_fuentes_gral WHERE agrupar_pista='$id_pista' ORDER BY id_mod ASC";
			  $result7 = mysql_db_query($db,$sql7,$link);
			  while ($row7 = mysql_fetch_array($result7)) 
				{
					echo "<option value=\"$row7[id_mod]\" selected>$row7[id_mod]</option>";
			    }
			   ?>
                </select>
                <?php }
	elseif($menu=="archivo"){
	?>
                <select name="cond">
                  <?php 
			  $sql8 = "SELECT DISTINCT(id_arch) FROM pistas_fuentes_gral WHERE agrupar_pista='$id_pista' ORDER BY id_arch ASC";
			  $result8 = mysql_db_query($db,$sql8,$link);
			  while ($row8 = mysql_fetch_array($result8)) 
				{
					if ($archivo==$row8['id_arch']){
					echo "<option value=\"$row8[id_arch]\" selected>$row8[id_arch]</option>";
					}else{
					echo "<option value=\"$row8[id_arch]\">$row8[id_arch]</option>";
					}
	            }
			   ?>
                </select>
                <?php
	}
	elseif($menu=="version"){?>
                <select name="cond">
                  <?php 
			  $sql10 = "SELECT DISTINCT(id_ver) FROM pistas_fuentes_gral WHERE agrupar_pista='$id_pista' ORDER BY id_ver ASC";
			  $result10 = mysql_db_query($db,$sql10,$link);
			  while ($row10 = mysql_fetch_array($result10)) 
				{
					if ($version==$row10['id_ver']){
					echo "<option value=\"$row10[id_ver]\" selected>$row10[id_ver]</option>";
					}else{
					echo "<option value=\"$row10[id_ver]\">$row10[id_ver]</option>";
					}
	            }
			   ?>
                </select>
                <?php }
	?>
             
        </td>
            <td width="40%"> <BR>
              <?php if($menu=='fecha'){?>
              <div align="left">
                <input name="VER" type="submit" id="VER3" value="   VER   " onclick="abrirfec()">
                <?php ;} 
				elseif(($menu != 'fecha') && ($menu !='general')) {?>
                <input name="VER" type="submit" id="VER3" value="   VER   " onclick="abrir()">
                <?php ;}?>
              </div><br></td>
          </tr>
        </table>
</td></tr></table>		
</td>
         <?php } elseif ((!$menu) || ($menu=='general')) {?>
		    <td align="center">
			<table border="1" width="100%" height="100%"><tr><td align="center">
			<br><input name="VER" type="submit" id="VER3" value="   VER   " onclick="general()">
        	<br>
			</td></tr></table>
			</td>
			<?php ;}?>
    </tr>
  </table>
</form>
  <script language="JavaScript">
var id= <?php echo $id_pista?>;        
function redirect(dir){
self.location="pistas_print.php&menu=";
}
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function redirect(opt){
		 	irapagina("pistas_print.php?id_pista="+id+"&menu="+opt);
		 }
function abrirfec(){
	window.open("pistas_fuentes_print.php?id_pista="+id+"&DA="+form1.DA.value+"&MA="+form1.MA.value+"&AA="+form1.AA.value+"&DE="+form1.DE.value+"&ME="+form1.ME.value+"&AE="+form1.AE.value+"&menu="+form1.menu.value);
}
function abrir(){
	window.open("pistas_fuentes_print.php?id_pista="+id+"&cond="+form1.cond.value+"&menu="+form1.menu.value);
}
function general(){
	window.open("pistas_fuentes_print.php?id_pista="+id+"&menu=general");
}
</script>