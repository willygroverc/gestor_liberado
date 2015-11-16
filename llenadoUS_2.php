<?php
if (isset($TERMINAR)) header("location: lista_mantenimiento.php");
if (isset($GUARDAR)){
  include("conexion.php");
	$FeProIni="$ano1-$mes1-$dia1";
	$FeProTer="$ano2-$mes2-$dia2";
	$FeRealIni="$ano3-$mes3-$dia3";
	$FeRealTer="$ano4-$mes4-$dia4";
  	$sql1 = "INSERT INTO cronograma (TareCrono,FeProIni,FeProTer,FeRealIni,FeRealTer,RubricaR,Observ,OrdAyuda,estado) ".
  	 	  "VALUES ('$TareCrono','$FeProIni','$FeProTer','$FeRealIni','$FeRealTer','$RubricaR','$Observ','$var','0')";
	mysql_db_query($db,$sql1,$link);
}
include ("top.php");

///////
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "RubricaR",  "Nombre Responsable, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "TareCrono",  "Tarea / Fase, $errorMsgJs[empty]" );
print $valid->toHtml ();
///////
?>
<script language="JavaScript" src="calendar.js"></script>
<form name="form1" method="post" action="">
  <input name="var" type="hidden" value="<?php echo $var;?>">
<table border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <td colspan="8" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="3"><strong>CRONOGRAMA</strong></font></div></td>
  </tr>
  <tr> 
    <td width="3%" rowspan="2" bgcolor="#006699">&nbsp;</td>
    <td width="18%" rowspan="2" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tarea 
        / Fase</font></strong></div></td>
    <td height="23" colspan="2" bgcolor="#006699"> <div align="center"> 
        <p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Fechas 
          Program.</strong></font></p>
      </div></td>
    <td colspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Fechas 
        Reales</strong></font></div></td>
    <td width="15%" rowspan="2" bgcolor="#006699"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Nombre</font></strong></font></div>
      <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Responsable</strong></font></div></td>
    <td width="29%" rowspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Observaciones</strong></font></div></td>
  </tr>
  <tr> 
    <td width="9%" height="25" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Inicio</strong></font></div></td>
    <td width="9%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Termino 
        </strong></font></div></td>
    <td width="7%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Inicio</strong></font></div></td>
    <td width="10%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Termino</strong></font></div></td>
  </tr>
  <?php  
//modificado desde aqui------------>
		$cronos=array();
		$c=0;
		$sql = "SELECT * FROM cronograma WHERE OrdAyuda='$var'";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{ 	$c++;
			array_push($cronos,$row['TareCrono']);
		?>
  <tr align="center"> 
    <td nowrap>&nbsp;<?php echo $c;?></td>
    <td nowrap>&nbsp; 
      <?php=$row['TareCrono']?>
    </td>
    <td nowrap>&nbsp; 
      <?php=$row['FeProIni']?>
    </td>
    <td align="center">&nbsp; 
      <?php=$row['FeProTer']?>
    </td>
    <td nowrap> 
      <?php=$row['FeRealIni']?>
    </td>
    <td nowrap> 
      <?php=$row['FeRealTer']?>
    </td>
    <td nowrap> 
      <?php
			 $sql2="SELECT * FROM users WHERE login_usr='$row[RubricaR]'";
			 $result2=mysql_db_query($db,$sql2,$link);
		  	 $row2=mysql_fetch_array($result2);
			 echo $row2['nom_usr']." ".$row2['apa_usr']." ".$row2['ama_usr'];
			?>&nbsp;
    </td>
    <td nowrap> 
      <?php=$row['Observ']?>&nbsp;
    </td>
  </tr>
  <?php
		 }
		  ?>
</table>
<br>
<table border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <td colspan="9" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="3"><strong>NUEVO</strong></font></div></td>
  </tr>
  <tr> 
    <td width="6%" rowspan="2" bgcolor="#006699">&nbsp;</td>
    <td width="12%" rowspan="2" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tarea 
        / Fase</font></strong></div></td>
    <td height="23" colspan="2" bgcolor="#006699"> <div align="center"> 
        <p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Fechas 
          Program.</strong></font></p>
      </div></td>
    <td colspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Fechas 
        Reales</strong></font></div></td>
  </tr>
  <tr> 
    <td width="20%" height="25" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Inicio</strong></font></div></td>
    <td width="21%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Termino 
        </strong></font></div></td>
    <td width="20%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Inicio</strong></font></div></td>
    <td width="21%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Termino</strong></font></div></td>
  </tr>
  <tr align="center"> 
    <td nowrap>&nbsp;Nuevo</td>
    <?php 
	  $sql_et="SELECT * FROM parametros_dym WHERE id_etapa=1";
	$res_et=mysql_db_query($db,$sql_et,$link);
	$row_et=mysql_fetch_array($res_et);?>
    <td nowrap>&nbsp; <select name="TareCrono" id="select13">
	<?php 
		for($i=1;$i<13;$i++){
			$etapa="etapa_".$i;
			if(!in_array($row_et[$etapa],$cronos))
			echo "<option value=\"$row_et[$etapa]\">$di $row_et[$etapa]</option>";
		}
	?>
      </select> </td>
    <td nowrap>&nbsp; <select name="dia1" id="select14">
        <?php		  		
				$fsist=date("Y-m-d");				
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);
				for($i=1;$i<=31;$i++)
				{	if ( isset ($dia1) ){echo "<option value=\"$i\""; if($dia1=="$i") echo "selected"; echo">$i</option>";}						
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
      </select> <select name="mes1" id="select15">
        <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($mes1) )  {echo "<option value=\"$i\""; if($mes1=="$i") echo "selected"; echo">$i</option>";}
					else  {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
					}
				}
				?>
      </select> <select name="ano1" id="select16">
        <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($ano1) ) {echo "<option value=\"$i\""; if($ano1=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
      </select> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font> 
    </td>
    <td align="center">&nbsp; <select name="dia2" id="select17">
        <?php		  		
				$fsist=date("Y-m-d");				
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);
				for($i=1;$i<=31;$i++)
				{	if ( isset ($dia2) ){echo "<option value=\"$i\""; if($dia2=="$i") echo "selected"; echo">$i</option>";}						
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
      </select> <select name="mes2" id="select18">
        <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($mes2) )  {echo "<option value=\"$i\""; if($mes2=="$i") echo "selected"; echo">$i</option>";}
					else  {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
					}
				}
				?>
      </select> <select name="ano2" id="select19">
        <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($ano2) ) {echo "<option value=\"$i\""; if($ano2=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
      </select> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <a href="javascript:cal2.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font> 
    </td>
    <td nowrap> <select name="dia3" id="select20">
        <?php		  		
				$fsist=date("Y-m-d");				
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);
				for($i=1;$i<=31;$i++)
				{	if ( isset ($dia3) ){echo "<option value=\"$i\""; if($dia3=="$i") echo "selected"; echo">$i</option>";}						
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
      </select> <select name="mes3" id="select21">
        <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($mes3) )  {echo "<option value=\"$i\""; if($mes3=="$i") echo "selected"; echo">$i</option>";}
					else  {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
					}
				}
				?>
      </select> <select name="ano3" id="select22">
        <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($ano3) ) {echo "<option value=\"$i\""; if($ano3=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
      </select> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <a href="javascript:cal3.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font> 
    </td>
    <td nowrap> <select name="dia4" id="select23">
        <?php		  		
				$fsist=date("Y-m-d");				
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);
				for($i=1;$i<=31;$i++)
				{	if ( isset ($dia4) ){echo "<option value=\"$i\""; if($dia4=="$i") echo "selected"; echo">$i</option>";}						
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
      </select> <select name="mes4" id="select24">
        <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($mes4) )  {echo "<option value=\"$i\""; if($mes4=="$i") echo "selected"; echo">$i</option>";}
					else  {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
					}
				}
				?>
      </select> <select name="ano4" id="select25">
        <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($ano4) ) {echo "<option value=\"$i\""; if($ano4=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
      </select> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <a href="javascript:cal4.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font> 
      <script language="JavaScript">
		<!-- 
		var form = "form1";
		 var cal1 = new calendar1(document.forms[form].elements['dia1'], document.forms[form].elements['mes1'], document.forms[form].elements['ano1']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
		var cal2 = new calendar1(document.forms[form].elements['dia2'], document.forms[form].elements['mes2'], document.forms[form].elements['ano2']);
		 	cal2.year_scroll = true;
			cal2.time_comp = false;
		var cal3 = new calendar1(document.forms[form].elements['dia3'], document.forms[form].elements['mes3'], document.forms[form].elements['ano3']);
		 	cal3.year_scroll = true;
			cal3.time_comp = false;
		var cal4 = new calendar1(document.forms[form].elements['dia4'], document.forms[form].elements['mes4'], document.forms[form].elements['ano4']);
		 	cal4.year_scroll = true;
			cal4.time_comp = false;
//-->
</script> </td>
  </tr>
  <tr> 
    <td colspan="3" bgcolor="#006699"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Nombre</font></strong></font></div>
      <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Responsable</strong></font></div></td>
    <td colspan="3" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Observaciones</strong></font></div></td>
  </tr>
  <tr> 
    <td colspan="3"> <div align="center"><strong> 
        <select name="RubricaR" id="RubricaR">
          <option value="0"></option>
          <?php 
			  $sql2 = "SELECT * FROM users WHERE tipo2_usr='T' OR tipo2_usr='A' ORDER BY apa_usr ASC";
			  $result2 = mysql_db_query($db,$sql2,$link);
			  while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row4['RubricaR']==$row2['login_usr'])
					echo "<option value=\"$row2[login_usr]\" selected> $row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
				else
					echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
	            }
			   ?>
        </select>
        </strong> </div></td>
    <td colspan="3"> <div align="center"> 
        <textarea name="Observ" cols="80" id="Observ"><?php if(!empty($row4['Observ'])) {echo $row4['Observ'];}?></textarea>
      </div></td>
  </tr>
</table>
  <p align="center"> 
    <input name="GUARDAR" type="submit" id="GUARDAR2" value="INSERTAR" <?php print $valid->onSubmit() ?>>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input name="TERMINAR" type="submit" id="TERMINAR" value="TERMINAR">
  </p>
</form>
<?php include ("top_.php");?>
