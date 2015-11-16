<?php
if($RETORNAR){header("location: lista_calen.php");}
include("conexion.php");
$sqlcont="SELECT * FROM contyman WHERE IdContra='$IdContra'";
/*echo "<br>sql cont : ".$sqlcont;
echo "<br>idtabla es : ".$idTabla;
echo "<br>idContra es : ".$IdContra;*/
$resultcont=mysql_db_query($db,$sqlcont,$link);
$rowcont=mysql_fetch_array($resultcont);
if($GUARDAR){
$FechDe="$AnoD-$MesD-$DiaD";
$FechAl="$AnoA-$MesA-$DiaA";

if($cont_manten == '')
{
	$cont_manten = '0';
}
if($cont_garantia == '')
{
	$cont_garantia = '0';
}

$sql="UPDATE contyman SET fecha_del='$FechDe', fecha_al='$FechAl', obs='$obs', cont_manten='$cont_manten', cont_garantia='$cont_garantia' WHERE IdContra='$IdContra'";
mysql_db_query($db,$sql,$link);
header("location: lista_calen.php");
}
if(!$rowcont[cont_manten]){$fdel=date("Y-m-d"); $fal=date("Y-m-d");}
elseif($rowcont[cont_manten]==1){
$fdel=$rowcont[fecha_del];
$fal=$rowcont[fecha_al];}
//echo "<br>cont manten : ".$rowcont[cont_manten];
if(!$valor){if($rowcont[cont_manten]==1){$valor='true';}else{$valor='false';}}
if(!$valor2){if($rowcont[cont_garantia]==1){$valor2='true';}else{$valor2='false';}}
include("top.php");
?>
<script language="JavaScript" src="calendar.js"></script>
<table width="62%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <td bgcolor="#006699"><div align="center"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="3"><strong>CONTRATO 
        / GARANTIA</strong></font></div></td>
  </tr>
  <tr> 
    <td align="center">
<form name="form1" method="post" action="">
        <table width="99%" border="0" align="center">
          <tr> 
            <td align="right"><strong>CONTRATO No. 
              <input name="IdContra" type="text" id="IdContra" value="<?php echo $IdContra?>" size="10" maxlength="10" readonly="yes">
              </strong></td>
            <td align="right"><strong>TIPO :</strong></td>
            <td> <p> 
                <input name="cont_garantia" type="checkbox" id="cont_garantia" value=1 <?php if ($valor2=="true" || $valor2==1) echo 'checked';?>>
                Garantia <br>
                <input name="cont_manten" type="checkbox" id="cont_manten" value=1 <?php if ($rowcont[cont_manten]=="true" || $rowcont[cont_manten]==1) echo 'checked';?>>            
            Mantenimiento Preventivo</p></td>
          </tr>
          <tr> 
            <td align="right">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr> 
            <td align="right"><strong>FECHA DE:</strong></td>
            <td align="left"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
<select name="DiaD" id="select19" <?php if($valor=="false" || !$valor) echo 'disabled';?>>
                <?php
				if ($GyC) {
					$a1=$AnoD;
					$m1=$MesD;
					$d1=$DiaD;
				}
				else{
					$a1=substr($fdel,0,4);
					$m1=substr($fdel,5,2);
					$d1=substr($fdel,8,2);
				}
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select>
              <select name="MesD" id="select20" <?php if($valor=="false" || !$valor) echo 'disabled';?>>
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="AnoD" id="select21" <?php if($valor=="false" || !$valor) echo 'disabled';?>>
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
            <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><?php if($valor=="true") echo "<img src='images/cal.gif' width='16' height='16' border='0' alt='Haga click para seleccionar una fecha'>";?></a></font></strong></font></strong></font></strong></td>
            <td align="left"><strong>AL:<font size="2" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font><font size="2" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
              <select name="DiaA" id="select" <?php if($valor=="false" || !$valor) echo 'disabled';?>>
                <?php
				if ($GyC) {
					$a2=$AnoA;
					$m2=$MesA;
					$d2=$DiaA;
				}
				else{
					$a2=substr($fal,0,4);
					$m2=substr($fal,5,2);
					$d2=substr($fal,8,2);
				}
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d2=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select>
              <select name="MesA" id="select2" <?php if($valor=="false" || !$valor) echo 'disabled';?>>
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m2=="$i") echo "selected"; echo">$i</option>";
					  }
			      ?>
              </select>
              <select name="AnoA" id="select3" <?php if($valor=="false" || !$valor) echo 'disabled';?>>
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a2=="$i") echo "selected"; echo">$i</option>";
				      }
	    			?>
              </select>
              </font></strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();">
              <?php if($valor=="true") echo "<img src='images/cal.gif' width='16' height='16' border='0' alt='Haga click para seleccionar una fecha'>";?>
              </a></font></strong></font></strong></font></strong></font></strong></font></strong></font></strong></td>
          </tr>
          <tr> 
            <td align="right">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr> 
            <td align="right"><strong>OBSERVACIONES:</strong></td>
            <td colspan="2" align="left"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
              <textarea name="obs" cols="50" rows="4" <?php if($valor=="false" || !$valor) echo 'disabled';?> id="obs"><?php echo $rowcont[obs];?></textarea>
              </font></strong></td>
          </tr>
        </table>
		<br>
        
        <input name="GUARDAR" type="submit" id="GUARDAR" value="GUARDAR">
		&nbsp;&nbsp;&nbsp;
        <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
</form>
    </td>
  </tr>
</table>
<?php include("top_.php");?>
<script language="JavaScript">
		<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['DiaD'], document.forms[form].elements['MesD'], document.forms[form].elements['AnoD']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DiaA'], document.forms[form].elements['MesA'], document.forms[form].elements['AnoA']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		<?php
			if ($errorMsg) print "alert (\"$errorMsg\");";
		?>
		function abrir(valor){
			var idcontra="<?php echo $IdContra;?>"
			var obs="<?php echo $obs;?>"
			var dir="contrato_garantia_last.php?valor="+valor+"&valor2="+document.form1.cont_garantia.checked+"&IdContra="+idcontra;
			self.location=dir;
		}
//-->
</script>