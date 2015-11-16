<?php if ($Salir)
if ($var2<>"")
{header("location: lista_ficha.php");}
else
{header("location: lista_calen.php");}
?>
<?php
if($RETORNAR) header("location: lista_ficha.php");
include ("funciones.inc.php");
if (isset($reg_form))
{	include("conexion.php");
	$fecha_del="$AD-$MD-$DD";
	$fecha_al="$AA-$MA-$DA";
	$sql4 = "SELECT * FROM datfichatec WHERE AdicUSI='$AdicUSI'";
	$result4=mysql_db_query($db,$sql4,$link);
	$row4=mysql_fetch_array($result4);
	$sql5 = "SELECT * FROM datfichatec WHERE AdicUSI='$AdicUSI2'";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
	$de=$row4[IdFicha];
	$al=$row5[IdFicha];
	for($i=$de;$i<=$al;$i++)
	{
	$sql6 = "SELECT * FROM datfichatec WHERE IdFicha='$i'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	$sql3="INSERT INTO ".
	"calenmantplanif  (id_cmant,AdicUSI,estado,fecha_del,fecha_al) ".
	"VALUES ('$var1','$row6[AdicUSI]','Planificado','$fecha_del','$fecha_al')";
	mysql_db_query($db,$sql3,$link);
	$var1=$var1+1;
	}
	header("location: calendarizacion.php?varia=$var&varia1=$var1&AdicUSI=$var2&usr2=$usr2");
}
else
{

include ("top.php");
$cod=($_GET['varia']);
$cod1=($_GET['varia1']);
$AdicUS=($_GET['AdicUSI']);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "AdicUSI",  "Codigo Adicional USI De, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "AdicUSI2",  "Codigo Adicional USI Al, $errorMsgJs[empty]" );
$valid->addIsDate ( "DD", "MD", "AD", "Fecha de: $errorMsgJs[date]" );
$valid->addIsDate ( "DA", "MA", "AA", "Fecha a: $errorMsgJs[date]" );
$valid->addCompareDates ( "DD", "MD", "AD", "DA", "MA", "AA", "$errorMsgJs[compareDates]" );
$valid->addFunction ( "compareAdicUsi",  "" );
$valid->addFunction ( "compareYear",  "" );
print $valid->toHtml();
			  $sql = "SELECT IdFicha, AdicUSI FROM datfichatec";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{	
					$listAdicUSI[$row[AdicUSI]]=$row[IdFicha];
				}
?>
<script language="JavaScript">
<!--
function compareAdicUsi () {
	var form=document.form2;
	var id = new Array();
	<?php 
		foreach ($listAdicUSI as $key => $value) {
			print "id[\"$key\"]=$value;\n";
		}
	 ?>
	if (id[form.AdicUSI2.value] < id[form.AdicUSI.value]) {
		alert ("Codigo Adicional USI De debe ser menor o igual a Codigo Adicional USI A. \n \n Mensaje generado por GesTor F1.");
		return false;
	}
	return true;
}
function compareYear () {
	var form=document.form2;
	if (form.AD.value != form.AA.value) {
		alert ("Los anos deben ser los mismos. \n \n Mensaje generado por GesTor F1.");
		return false;
	}	
	return true;
}
-->
</script>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<table width="95%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="get" action="<?php echo $PHP_SELF ?> " onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $cod;?>">
	<input name="var2" type="hidden" value="<?php echo $AdicUS;?>">
	<input name="var1" type="hidden" value="<?php echo $cod1;?>">
	<input  type= "hidden" name="usr2"  value=<?php echo $usr;?>>
	<tr> 
      <td>
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4">
           <tr bgcolor="#006699"> 
            <td colspan="15"> <div align="center"><font size="3" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong> 
                CALENDARIZACION DE MANTENIMIENTO </strong></font></div></td>
          </tr>
          <tr bgcolor="#006699"> 
            <th colspan="2" height="42"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Codigo Adicional</font></div></th>
            <th width="66" rowspan="2" height="10"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Estado</font></th>
            <th colspan="3"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cuatrimestre1</font></th>
            <th colspan="3"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cuatrimestre2</font></th>
            <th colspan="3"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cuatrimestre3</font></th>
			<th colspan="3"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cuatrimestre4</font></th>
          </tr>
          <tr bgcolor="#006699"> 
            <th width="142"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">DE</font></th>
            <th width="142"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">AL</font></th>
            <th width="33"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Ene</font></th>
            <th width="35"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Feb</font></th>
            <th width="33"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Mar</font></th>
            <th width="34"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Abr</font></th>
            <th width="33"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">May</font></th>
            <th width="33"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Jun</font></th>
            <th width="34"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Jul</font></th>
            <th width="35"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Ago</font></th>
            <th width="37"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Sept</font></th>
            <th width="33"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Oct</font></th>
            <th width="33"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nov</font></th>
            <th width="35"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Dic</font></th>
          </tr>
          <?php
		$sql = "SELECT * FROM calenmantplanif where id_cmant>='$cod'";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <?php
				$anod=substr($row[fecha_del],0,4);
				$mesd=substr($row[fecha_del],5,2);
				$diad=substr($row[fecha_del],8,2);
	
				$anoa=substr($row[fecha_al],0,4);
				$mesa=substr($row[fecha_al],5,2);
				$diaa=substr($row[fecha_al],8,2);?>
          <?php if($mesd==$mesa) 
			$fechac="$diad-$diaa";
		 ?>
          <tr align="center"> 
            <td colspan="2">&nbsp;
			<?php
			$sql2="SELECT IdFicha, login_usr, CONCAT(nom_usr, ' ', apa_usr, ' ', ama_usr) AS nombre FROM asigcustficha, users WHERE asigcustficha.NombAsig=users.login_usr AND tipo1 IS NULL";
			$rs=mysql_db_query($db,$sql2,$link);
			while ($tmp=mysql_fetch_array($rs)) 
			{	$lstTecnico[$tmp[IdFicha]]=$tmp[nombre];}
			  $str = "SELECT * FROM datfichatec";
			  $res = mysql_db_query($db,$str,$link);
			  while ($row9 = mysql_fetch_array($res)) 
			  {	
			  	$usr = $lstTecnico[$row9[IdFicha]];
				if (!isset($usr)) $usr="No asignado";
				if ( $row[AdicUSI]==$row9[AdicUSI])
				{	echo $row[AdicUSI]." [".$usr."]";}
	            }
			?>
			</td>
            <td width="66">&nbsp;<?php echo $row[estado];?></td>
            <td width="33">&nbsp; 
              <?php if($mesd=="01"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa"; }}?>
            </td>
            <td width="35">&nbsp; 
              <?php if($mesd=="02"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="33">&nbsp; 
              <?php if($mesd=="03"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="34">&nbsp; 
              <?php if($mesd=="04"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="33">&nbsp; 
              <?php if($mesd=="05"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="33">&nbsp; 
              <?php if($mesd=="06"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="34">&nbsp; 
              <?php if($mesd=="07"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="35">&nbsp; 
              <?php if($mesd=="08"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="37">&nbsp; 
              <?php if($mesd=="09"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="33">&nbsp; 
              <?php if($mesd=="10"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="33">&nbsp; 
              <?php if($mesd=="11"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="35">&nbsp; 
              <?php if($mesd=="12"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
          </tr>
          <?php } ?>
          <tr> 
            <td align="center"  nowrap><strong> 
              <select name="AdicUSI">
                <option value="0"> </option>
                <?php 
			$sql2="SELECT IdFicha, login_usr, CONCAT(apa_usr, ' ', ama_usr, ' ', nom_usr) AS nombre FROM asigcustficha, users WHERE asigcustficha.NombAsig=users.login_usr AND tipo1 IS NULL";
			$rs=mysql_db_query($db,$sql2,$link);
			while ($tmp=mysql_fetch_array($rs)) 
			{	$lstTecnico[$tmp[IdFicha]]=$tmp[nombre];}
				
			$sql2="SELECT IdFicha, login_usr, CONCAT(apa_usr, ' ', ama_usr, ' ', nom_usr) AS nombre FROM asigcustficha, users WHERE asigcustficha.NombAsig=users.login_usr AND tipo1 IS NULL";
			$rs=mysql_db_query($db,$sql2,$link);
			while ($tmp=mysql_fetch_array($rs)) 
			{	$lstTecnico[$tmp[IdFicha]] = $tmp[nombre];}
				
			  $sql = "SELECT * FROM datfichatec where Elim=0";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
			  {
				$usr = $lstTecnico[$row[IdFicha]];
				if (!isset($usr)) $usr = "No asignado"; 			
				if ($row[CodActFijo]==$CodActFijo)
				 			echo "<option value=\"$row[AdicUSI]\" selected>$row[AdicUSI] [".$usr."]</option>";
				   else
							echo "<option value=\"$row[AdicUSI]\">$row[AdicUSI] [".$usr."]</option>";
	          }
			  ?>
              </select>
              </strong></td>
            <td align="center"  nowrap><strong> 
              <select name="AdicUSI2">
               <option value=0></option>
                <?php
				 
			  $sql = "SELECT * FROM datfichatec where Elim=0";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
			  {	
			  	$usr = $lstTecnico[$row[IdFicha]];
				if (!isset($usr)) $usr = "No asignado";
				if ($row[CodActFijo]==$CodActFijo)
				 			echo "<option value=\"$row[AdicUSI]\" selected>$row[AdicUSI] [".$usr."]</option>";
				   else
							echo "<option value=\"$row[AdicUSI]\">$row[AdicUSI] [".$usr."]</option>";
	            }
			  ?>
              </select>
              </strong></td>
            <td width="66" nowrap align="center">Planificado</td>
            <td colspan="6" nowrap align="center">del: <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <?php 
			  $fsist=date("Y-m-d");
			  
			   ?>
              <select name="DD" id="select18">
                <?php
  				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select>
              </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="MD" id="select19">
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="AD" id="select20">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong> 
              </font></strong></font></strong></td>
            <td height="7" colspan="6" nowrap align="center"><p>al: <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="DA" id="select">
                  <?php
  				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
                </select>
                </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="MA" id="select2">
                  <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                </select>
                <select name="AA" id="select3">
                  <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>
                <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong> 
                </font></strong></font></strong></p></td>
          </tr>
          <tr> 
            <td colspan="15" nowrap> <div align="center"><br>
                <table width="75%" border="0">
                  <tr> 
                    <td align="center"><input name="reg_form" type="submit" id="reg_form3" value="ANADIR" <?php print $valid->onSubmit() ?>></td>
                    <td align="center"><input name="CodActFijo" type="hidden" value="<?php=$CodActFijo;?>"> 
                      <?php if(!isset($CodActFijo)){?>
                      <input type="submit" name="Salir" value="RETORNAR"><?php }else{?>
					<input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
					<?php }?>
					</td>
                  </tr>
                </table>
              </div></td>
          </tr>
        </table>
      </td>
    </tr></form>
  </table>
 <script language="JavaScript">
<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DD'], document.forms[form].elements['MD'], document.forms[form].elements['AD']);			
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);			
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>  
 <p>
  <?php } ?>
</p>
<?php include("top_.php");?>