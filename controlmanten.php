<?php 
if(isset($retorna)) {
if ($CodActFijo=="" OR !$CodActFijo){header("location: controlmantenprincipal.php");}
else{header("location: lista_ficha.php");}
}
if (isset($reg_form))
{   include ("conexion.php");
	$fecha_s="$AS-$MS-$DS";
	$fecha_r="$AR-$MR-$DR";
	$sql2= "SELECT * FROM datfichatec WHERE CodActFijo='$CodAct'";
	$result2=mysql_db_query($db,$sql2,$link);
	$row2 = mysql_fetch_array($result2);
	//echo "--<".$AdicUSI;
	if($tm=="E"){
		$sql3="INSERT INTO ".
		"pcontrol (CodActFijo,AdicUSI,des_disp,fecha_s,fecha_r,login_usr,Observ,EncProv,NombProv,obs_retorno,login_usr2,enc_prov2,fecha_ret,tipo_mant,tipo_mant2) ".
		"VALUES ('$row2[CodActFijo]','$row2[AdicUSI]','$des_disp','$fecha_s','$fecha_r','$login_usr','$Observ','$EncProv','$NombProv','','','','0000-00-00','$tipo_mant','E')";
		mysql_query($sql3);
	}
	else
	{	$sql3="INSERT INTO ".
		"pcontrol (CodActFijo,AdicUSI,des_disp,fecha_s,fecha_r,login_usr,Observ,EncProv,NombProv,obs_retorno,login_usr2,enc_prov2,fecha_ret,tipo_mant,tipo_mant2) ".
		"VALUES ('$row2[CodActFijo]','$row2[AdicUSI]','$des_disp','$fecha_s','$fecha_r','$login_usr','$Observ','$EncProv','$NombProv','','','','0000-00-00','$tipo_mant','I')";
		mysql_query($sql3);
	}
	header("location: controlmanten.php?varia1=$var&CodActFijo=$CodActFijo&tm=$tm");
} else	
{include("top.php"); 
require_once('funciones.php');
$id_regPC=SanitizeString($_GET['varia1']);
if(isset($_GET['CodActFijo']))
	$CodActFijo=SanitizeString($_GET['CodActFijo']);
else
	$CodActFijo="";

?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "CodAct",  "Codigo Activo Fijo USI, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "des_disp",  "Descripcion, $errorMsgJs[expresion]" );
$valid->addLength ( "des_disp",  "Descripcion, $errorMsgJs[length]" );
$valid->addIsDate ( "DS", "MS", "AS", "Fecha de Salida, $errorMsgJs[date]" );
$valid->addIsDate ( "DR", "MR", "AR", "Fecha de Retorno, $errorMsgJs[date]" );
$valid->addCompareDates ( "DS", "MS", "AS", "DR", "MR", "AR", "$errorMsgJs[compareDates]" );
$valid->addIsNotEmpty ( "login_usr",  "Funcionario Responsable, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "Observ",  "Observaciones, $errorMsgJs[expresion]" );
$valid->addLength ( "Observ",  "Observaciones, $errorMsgJs[length]" );

if($tm=="E"){
$valid->addIsNotEmpty ( "NombProv",  "Empresa, $errorMsgJs[empty]" );
$valid->addIsAlpha ( "EncProv",  "Responsable de la Empresa, $errorMsgJs[expresion]" );
}
print $valid->toHtml();
?>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
<input name="var" type="hidden" value="<?php echo $id_regPC;?>">
<input name="var2" type="hidden" value="<?php echo $AdicUS;?>">
<input name="CodActFijo" type="hidden" value="<?php echo $CodActFijo;?>">
<input name="tm" type="hidden" value="<?php echo $tm;?>">
  <table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#EAEAEA"  background="images/fondo.jpg">
   
	<tr> 
        
      <td width="7%"> 
        <table border="2" align="center" cellpadding="2" cellspacing="4">
          <tr> 
            <th colspan="11" nowrap background="images/main-button-tileR11.jpg" height="25"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>CONTROL 
              DE MANTENIMIENTO - ENTREGA</strong></font></th>
          </tr>
          <tr align="center"> 
            <th width="3%" nowrap background="images/main-button-tileR1.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Mant.</font></th>
        	<th width="3%" nowrap background="images/main-button-tileR1.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">N&deg; 
              Activo Fijo</font></th>
            <th width="5%" nowrap background="images/main-button-tileR1.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">No 
              Cod. Adicional</font></th>
            <th width="20%" nowrap background="images/main-button-tileR1.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Descripcion</font></th>
            <th width="60" nowrap background="images/main-button-tileR1.jpg"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Fecha 
                de Salida</font></div></th>
            <th width="60" nowrap background="images/main-button-tileR1.jpg"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Fecha 
                de Retorno</font></div></th>
            <th width="118" nowrap background="images/main-button-tileR1.jpg"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Funcionario 
                Responsable</font></div></th>
            <th width="70" nowrap background="images/main-button-tileR1.jpg"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Tipo 
                de Mantenimiento</font></div></th>
            <th width="130" nowrap background="images/main-button-tileR1.jpg"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Observacion</font></div></th>
            <th width="39" nowrap background="images/main-button-tileR1.jpg"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Empresa</font></div></th>
            <th width="125" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Responsable 
              de la empresa</font></th>
          </tr>
          <?php
		  
		$sql = "SELECT *, DATE_FORMAT(fecha_s, '%d/%m/%Y') AS fecha_s, DATE_FORMAT(fecha_r, '%d/%m/%Y') AS fecha_r FROM pcontrol WHERE id_regPC>='$id_regPC' ORDER BY id_regPC ASC";
		$result=mysql_db_query($db,$sql,$link);
		$c=1;
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <td height="26"><div align="center">&nbsp;<?php 
			if($row['tipo_mant2']=="I"){echo "INTERNO";}
			elseif($row['tipo_mant2']=="E"){echo "EXTERNO";}
			?></div></td>
			<td height="26"><div align="center">&nbsp;<?php echo $row['CodActFijo']?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['AdicUSI']?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['des_disp']?>	</div></td>
            <td><div align="center">&nbsp;<?php echo $row['fecha_s']?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['fecha_r']?></div></td>
			<?php 
			$sql7="SELECT * FROM users WHERE login_usr='$row[login_usr]'"; 
			$result7=mysql_query($sql7);
			$row7=mysql_fetch_array($result7);	
			echo "<td><font size=\"1\">&nbsp;$row7[nom_usr] $row7[apa_usr] $row7[ama_usr]</font></td>";?>
			<td><div align="center">&nbsp;<?php echo $row['tipo_mant']?></div></td>
			<td><div align="center">&nbsp;<?php echo $row['Observ']?></div></td>
            <td><div align="center">&nbsp;<?php 
			if($row['tipo_mant2']=="I"){echo "NO APLICA";}
			else{echo $row['NombProv'];}?></div></td>
            <td><div align="center">&nbsp;<?php 
			if($row['tipo_mant2']=="I"){echo "NO APLICA";}
			else{echo $row['EncProv'];}?></div></td>
			
          </tr>
          <?php
		 }
		 ?>
   
        </table></td>
    </tr>

  </table>
  <br>
  <table width="95%" border="2" bgcolor="#CCCCCC" background="images/fondo.jpg" align="center" >
    <tr>
      <td colspan="4" align="center"><font size="2" face="Arial, Helvetica, sans-serif">Mantenimiento: 
        <input type="radio" name="interno" value="I" onClick="cambio2(this.value,'<?php echo $varia1;?>','<?php echo $CodActFijo;?>')" <?php if($tm=="I" OR !$tm){echo "checked";}?>>
        Interno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="externo" value="E" onClick="cambio2(this.value,'<?php echo $varia1;?>','<?php echo $CodActFijo;?>')" <?php if($tm=="E"){echo "checked";}?>>
        Externo</font></td>
    </tr>
    <tr> 
      <td colspan="4" align="center"><font size="2" face="Arial, Helvetica, sans-serif">Nro. 
        Codigo Adicional:<strong> 
        <select name="CodAct" id="select3">
          <option value="0"></option>
          <?php 
			  $sql0 = "SELECT * FROM datfichatec WHERE Elim<>1";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
		      {
				$str0  = "SELECT NombAsig FROM asigcustficha WHERE IdFicha='$row0[IdFicha]'";
				$res0  = mysql_db_query( $db, $str0, $link);
				$fila0 = mysql_fetch_array($res0);
				
				$str  = "SELECT * FROM users WHERE login_usr='$fila0[NombAsig]'";
				$res  = mysql_db_query( $db, $str, $link);
				$fila = mysql_fetch_array($res);	
				//echo 
				if ($row0['CodActFijo'] == $CodActFijo)				
				{   if ($fila)					   	
					  echo "<option value=\"$row0[CodActFijo]\"selected>$row0[AdicUSI]  [$fila[nom_usr] $fila[apa_usr] $fila[ama_usr] ]</option>";														
					else
				 	  echo "<option value=\"$row0[CodActFijo]\"selected>$row0[AdicUSI]  [No asignado]</option>";					
				}	  
			    else
				{	if ( $fila )
					echo "<option value=\"$row0[CodActFijo]\">$row0[AdicUSI]  [$fila[nom_usr] $fila[apa_usr] $fila[ama_usr] ]</option>";
					else 
					echo "<option value=\"$row0[CodActFijo]\">$row0[AdicUSI]  [No asignado]</option>";
                }
			   }
			   ?>
        </select>
        </strong></font></td>
    </tr>
    <td width="25%"> 
    <tr> 
      <td background="images/main-button-tileR11.jpg" height="25"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Descripcion</font></div></td>
      <td width="24%" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha 
          de Salida</font></div></td>
      <td width="23%" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha Estimada 
          de Retorno</font></div></td>
     <?php if($tm=="E"){?>
	  <td width="28%" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Funcionario 
          Responsable</font></div></td>
	  </tr>
	<?php }?>
    
    <tr> 
      <td><div align="center"> 
          <textarea name="des_disp" cols="28" id="textarea4"></textarea>
        </div></td>
      <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <?php 
			  $fsist=date("Y-m-d");
			  
			   ?>
          <select name="DS" id="select18">
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
          <select name="MS" id="select19">
            <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
          </select>
          <select name="AS" id="select20">
            <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
          </select>
          </font><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          </font></strong></font></strong></font></div></td>
      <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <?php 
			  $fsist=date("Y-m-d");
			  
			   ?>
          <select name="DR" id="select">
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
          </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <select name="MR" id="select2">
            <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m2=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
          </select>
          <select name="AR" id="select4">
            <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a2=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
          </select>
          <strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></div></td>
       <?php if($tm=="E"){?>
	  <td><div align="center"><strong> 
          <select name="login_usr" id="select24">
            <option value="0"></option>
            <?php 
			  $sql0 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				echo "<option value=\"$row0[login_usr]\">$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
				}
			   ?>
          </select>
          </strong></div></td>
    </tr>
	<?php }?>
    <tr> 
      <?php if($tm=="I" OR !$tm){?>
	   <td width="28%" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Funcionario 
          Responsable</font></div></td>
	  <?php }?>
	  <td align="center" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Observacion</font></div></td>
      <td background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Tipo 
          de Mantenimiento</font></div></td>
		  <?php if($tm=="E"){?>
		 <td background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Empresa</font></div></td>
      <td background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Responsable 
          de la empresa</font></div></td>
		  <?php }?>
    </tr>
    <tr> 
      <?php if($tm=="I" OR !$tm){?>
	  <td><div align="center"><strong> 
          <select name="login_usr" id="select24">
            <option value="0"></option>
            <?php 
			  $sql0 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				echo "<option value=\"$row0[login_usr]\">$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
				}
			   ?>
          </select>
          </strong></div></td>
    <?php }?>
	  
	  <td align="center"><div align="center"><strong> 
          <textarea name="Observ" cols="28" id="textarea5"></textarea>
          </strong></div></td>
      <td><div align="center"><strong> 
          <select name="tipo_mant" id="select25">
            <option value="Preventivo">Preventivo</option>
            <option value="Correctivo">Correctivo</option>
            <option value="Adaptativo">Adaptativo</option>
          </select>
          </strong></div></td>
		  <?php if($tm=="E"){?>
		   <td><div align="center"><strong> 
          <select name="NombProv" id="select25">
            <option value="0"></option>
            <?php 
			  $sql0 = "SELECT * FROM proveedor ORDER BY NombProv ASC";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				echo "<option value=\"$row0[NombProv]\">$row0[NombProv]</option>";
				
                }
			   ?>
          </select>
          </strong></div></td>
      <td><div align="center"><strong> 
          <input name="EncProv" type="text" size="30" maxlength="50">
          </strong></div></td>
		<?php }?>
    </tr>
    <tr> 
      <td colspan="4" align="center"><strong><br>
        <input name="reg_form" type="submit" id="reg_form4" value="ANADIR" <?php print $valid->onSubmit() ?>>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input name="retorna" type="submit" id="RETORNAR" value="RETORNAR">
        
        </strong></td>
    </tr>
  </table>
  </form>
 <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DS'], document.forms[form].elements['MS'], document.forms[form].elements['AS']);			
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DR'], document.forms[form].elements['MR'], document.forms[form].elements['AR']);			
		 	cal.year_scroll = true;
			cal.time_comp = false;

function irapagina_c(pagina){         
 		 if (pagina!="") {self.location = pagina;}
}
function cambio2(numero,numid,numact){        
		if (!foco_texto){irapagina_c("controlmanten.php?tm="+numero+"&varia1="+numid+"&CodActFijo="+numact);} 
}
var foco_texto=false;
</script>

<?php } ?>
<strong> </strong> 
<?php include("top_.php");?>