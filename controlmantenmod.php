<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($RETORNAR)){header("location: controlmantenprincipal.php");}
if (isset($guardar))
{  include ("conexion.php");
	$sql3 = "SELECT * FROM datfichatec WHERE CodActFijo='$CodActFijo'";
	$result3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($result3);
				
	$fecha_s="$AS-$MS-$DS";
	$fecha_r="$AR-$MR-$DR";
	$fecha_ret="$ARET-$MRET-$DRET";
	if($tm=="E"){
	$sql5="UPDATE pcontrol SET CodActFijo='$CodActFijo',AdicUSI='$row3[AdicUSI]',des_disp='$des_disp',fecha_s='$fecha_s',fecha_r='$fecha_r',login_usr='$login_usr',Observ='$Observ',EncProv='$EncProv',NombProv='$NombProv',obs_retorno='$obs_retorno', fecha_ret='$fecha_ret', enc_prov2='$enc_prov2', login_usr2='$login_usr2', tipo_mant='$tipo_mant'".
	"WHERE id_regPC='$IdReg'";}
	elseif($tm=="I")
	{$sql5="UPDATE pcontrol SET CodActFijo='$CodActFijo',AdicUSI='$row3[AdicUSI]',des_disp='$des_disp',fecha_s='$fecha_s',fecha_r='$fecha_r',login_usr='$login_usr',Observ='$Observ',obs_retorno='$obs_retorno', fecha_ret='$fecha_ret', login_usr2='$login_usr2', tipo_mant='$tipo_mant'".
	"WHERE id_regPC='$IdReg'";}
	mysql_query($sql5);
	header("location: controlmantenprincipal.php");
	
}
include("top.php"); 
$id_regPC=($_GET['IdRegPC']);
$sql = "SELECT *, DATE_FORMAT(fecha_s, '%d/%m/%Y') AS fecha_s, DATE_FORMAT(fecha_r, '%d/%m/%Y') AS fecha_r , DATE_FORMAT(fecha_ret, '%d/%m/%Y') AS fecha_ret
		FROM pcontrol WHERE id_regPC='$id_regPC'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result); 

?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "CodActFijo",  "No. Activo Fijo, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "des_disp",  "Descripcion, $errorMsgJs[expresion]" );
$valid->addLength ( "des_disp",  "Descripcion, $errorMsgJs[length]" );
$valid->addIsDate ( "DS", "MS", "AS", "Fecha de Salida, $errorMsgJs[date]" );
$valid->addIsDate ( "DR", "MR", "AR", "Fecha de Retorno, $errorMsgJs[date]" );
$valid->addCompareDates ( "DS", "MS", "AS", "DR", "MR", "AR", "$errorMsgJs[compareDates]" );
$valid->addLength ( "Observ",  "Observaciones, $errorMsgJs[length]" );
$valid->addIsNotEmpty ( "login_usr",  "Funcionario Responsable, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "NombProv",  "Empresa, $errorMsgJs[empty]" );
$valid->addIsAlpha ( "EncProv",  "Responsable de la Empresa, $errorMsgJs[expresion]" );
$valid->addLength( "obs_retorno",  "Observaciones de Retorno, $errorMsgJs[length]" );
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
<form name="form2" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
<input name="IdReg" type="hidden" value="<?php echo $id_regPC;?>">
<input name="tm" type="hidden" value="<?php echo $tm;?>">
  <br>
  <table width="95%" border="2" bgcolor="#CCCCCC" background="images/fondo.jpg" align="center" >
    <tr> 
      <td colspan="4" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Nro. 
        Codigo Adicional:</font><strong> 
        <select name="CodActFijo" id="select3">
          <?php 
				 $sql2 = "SELECT * FROM datfichatec";
			     $result2 = mysql_query($sql2);
			     while ($row2 = mysql_fetch_array($result2)) 
			     {	  
						$str0  = "SELECT NombAsig FROM asigcustficha WHERE IdFicha='$row2[IdFicha]'";
						$res0  = mysql_query(  $str0, $link);
						$fila0 = mysql_fetch_array($res0);
						$str  = "SELECT * FROM users WHERE login_usr='$fila0[NombAsig]'";
						$res  = mysql_query(  $str, $link);
						$fila = mysql_fetch_array($res);
					   if ( $row['CodActFijo'] == $row2['CodActFijo'] && $row2['AdicUSI']==$AdicUSI)				   
						{	if (isset($fila))
								echo "<option value=\"$row2[CodActFijo]\" selected> $row2[AdicUSI] [ $fila[nom_usr] $fila[apa_usr] $fila[ama_usr] ]</option>";
							else
								echo "<option value=\"$row2[CodActFijo]\" selected> $row2[AdicUSI] [ No asignado ]</option>";	
						}
					   else
						{	if ($fila)
								echo "<option value=\"$row2[CodActFijo]\"> $row2[AdicUSI] [ $fila[nom_usr] $fila[apa_usr] $fila[ama_usr] ]</option>";
							else
								echo "<option value=\"$row2[CodActFijo]\"> $row2[AdicUSI] [ No asiganado ] </option>";
	                    }				   
	               }				   
		 ?>
        </select>
        </strong></td>
    </tr>
    <td width="18%"> 
    <tr> 
          <tr>
      <th colspan="4" nowrap bgcolor="#006699"><font size="3" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>SALIDA</strong></font></th>
          </tr>
      <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Descripcion</font></div></td>
      <td width="19%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha 
          de Salida</font></div></td>
      <td width="18%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha 
          de Retorno</font></div></td>
	  <?php if($tm=="E"){?>
      <td width="27%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Funcionario 
          Responsable</font></div></td>
	  <?php }?>
    </tr>
    <tr> 
      <td><div align="center"> </strong></div></td>
    </tr>
    <tr> 
      <td colspan="1" align="center"><textarea name="des_disp"><?php echo $row['des_disp'];?></textarea></td>
      <td width="19%"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <select name="DS" id="select18">
            <?php
  				$a1=substr($row['fecha_s'],6,4);
				$m1=substr($row['fecha_s'],3,2);
				$d1=substr($row['fecha_s'],0,2);
				echo "<option value=\"$i\""; if(isset($dl) && $d1=="$i") echo "selected"; echo">".@$dl."</option>";
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1==$i) echo "selected"; echo">$i</option>";										
					}
			    ?>
          </select>
          </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <select name="MS" id="select19">
            <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1==$i) echo "selected"; echo">$i</option>";
					  }
			   ?>
          </select>
          <select name="AS" id="select20">
            <?php 
			for($i=2003;$i<=2020;$i++)
			{    $al = "".$i;
        	          echo "<option value=\"$i\""; if($a1==$i) echo "selected"; echo">$i</option>";
			}
				?>
          </select>
          <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong> 
          </font></strong></font></div></td>
      <td width="18%"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <select name="DR" id="select21">
            <?php
  				$a2=substr($row['fecha_r'],6,4);
				$m2=substr($row['fecha_r'],3,2);
				$d2=substr($row['fecha_r'],0,2);
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d2=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
          </select>
          </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <select name="MR" id="select22">
            <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m2=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
          </select>
          <select name="AR" id="select23">
            <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a2=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
          </select>
          <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong> 
          </font></div></td>
	<?php if($tm=="E"){?>
      <td width="27%"><div align="center"><strong> 
          <select name="login_usr" id="select24">
            <option value="0"></option>
            <?php 
			     $sql4 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			     $result4 = mysql_query($sql4);
			     while ($row4 = mysql_fetch_array($result4)) 
				   {
				   if ($row['login_usr']==$row4['login_usr'])
				 			echo "<option value=\"$row4[login_usr]\" selected>$row4[apa_usr] $row4[ama_usr] $row4[nom_usr]</option>";
				   else
							echo "<option value=\"$row4[login_usr]\">$row4[apa_usr] $row4[ama_usr] $row4[nom_usr]</option>";
	               }
			     ?>
          </select>
          </strong></div></td>
	<?php }?>
    </tr>
    <tr> 
	   <?php if($tm=="I"){?>
      <td width="27%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Funcionario 
          Responsable</font></div></td>
	  <?php }?>
      <td align="center" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Observacion</font></div></td>
      <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Tipo 
          de Mantenimiento</font></div></td>
	<?php if($tm=="E"){?>
	  <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Empresa</font></div></td>
      <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Responsable 
          de la empresa</font></div></td>
	<?php }?>
    </tr>
    <tr background="images/fondo.jpg"> 
	 <?php if($tm=="I"){?>
      <td width="27%"><div align="center"><strong> 
          <select name="login_usr" id="select24">
            <option value="0"></option>
            <?php 
			     $sql4 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			     $result4 = mysql_query($sql4);
			     while ($row4 = mysql_fetch_array($result4)) 
				   {
				   if ($row['login_usr']==$row4['login_usr'])
				 			echo "<option value=\"$row4[login_usr]\" selected>$row4[apa_usr] $row4[ama_usr] $row4[nom_usr]</option>";
				   else
							echo "<option value=\"$row4[login_usr]\">$row4[apa_usr] $row4[ama_usr] $row4[nom_usr]</option>";
	               }
			     ?>
          </select>
          </strong></div></td>
	<?php }?>
      <td align="center"><strong> 
        <textarea name="Observ"><?php echo $row['Observ'];?></textarea>
        </strong></td>
      <td> <div align="center"><strong>
          <select name="tipo_mant" id="select6">
            <option value="Preventivo" <?php if($row['tipo_mant']=="Preventivo") echo "selected"?>>Preventivo</option>
            <option value="Correctivo" <?php if($row['tipo_mant']=="Correctivo") echo "selected"?>>Correctivo</option>
            <option value="Adaptativo" <?php if($row['tipo_mant']=="Adaptativo") echo "selected"?>>Adaptativo</option>
          </select>
          </strong></div></td>
		  <?php if($tm=="E"){?>
		  <td><div align="center"><strong>
          <select name="NombProv" id="select">
            <option value="0"></option>
            <?php 
			     $sql3 = "SELECT * FROM Proveedor";
			     $result3 = mysql_query($sql3);
			     while ($row3 = mysql_fetch_array($result3)) 
				   {
				   if ($row['NombProv']==$row3['NombProv'])
				 			echo "<option value=\"$row3[NombProv]\" selected> $row3[NombProv]</option>";
				   else
							echo "<option value=\"$row3[NombProv]\"> $row3[NombProv] </option>";
	               }
			     ?>
          </select>
          </strong></div></td>
      <td> <div align="center"><strong> 
          <input name="EncProv" type="text" value="<?php echo $row['EncProv'];?>" maxlength="50">
          </strong></div></td>
	<?php }?>
    </tr>
	          <tr>
      <th colspan="4" nowrap bgcolor="#006699"><font size="3" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>RETORNO</strong></font></th>
          </tr>
	<tr> 
      <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Observacion</font></div></td>
      <td width="19%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha 
          de Retorno</font></div></td>
		 <?php if($tm=="E"){?>
      <td width="18%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Responsable 
          de la empresa</font></div></td>
		 <?php }?>
      <td width="27%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Funcionario 
          Responsable</font></div></td>
    </tr>
    <tr> 
      <td><div align="center"> </strong></div></td>
    </tr>
    <tr> 
	  <td colspan="1" align="center"><textarea name="obs_retorno" id="obs_retorno"><?php echo $row['obs_retorno'];?></textarea></td>
      <td width="19%"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <select name="DRET" id="select2">
            <?php
  				$a2=substr($row['fecha_ret'],6,4);
				$m2=substr($row['fecha_ret'],3,2);
				$d2=substr($row['fecha_ret'],0,2);
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d2=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
          </select>
          </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <select name="MRET" id="select4">
            <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m2=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
          </select>
          <select name="ARET" id="select5">
            <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a2=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
          </select>
          </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          </font></strong></font></div></td>
     <?php if($tm=="E"){?>
	  <td width="18%"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <strong>
          <input name="enc_prov2" type="text" id="enc_prov2" value="<?php echo $row['enc_prov2'];?>" maxlength="50">
          </strong></font></div></td>
	<?php }?>
      <td width="27%"><div align="center"><strong> 
          <select name="login_usr2" id="select24">
            <option value="0"></option>
            <?php 
			     $sql4 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			     $result4 = mysql_query($sql4);
			     while ($row4 = mysql_fetch_array($result4)) 
				   {
				   if ($row['login_usr2']==$row4['login_usr'])
				 			echo "<option value=\"$row4[login_usr]\" selected>$row4[apa_usr] $row4[ama_usr] $row4[nom_usr]</option>";
				   else
							echo "<option value=\"$row4[login_usr]\">$row4[apa_usr] $row4[ama_usr] $row4[nom_usr]</option>";
	               }
			     ?>
          </select>
          </strong></div></td>
    </tr>
    <tr> 
      <td colspan="4" align="center"> <strong><br>
        <input name="guardar" type="submit"  value="GUARDAR CAMBIOS" <?php print $valid->onSubmit() ?>>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input type="submit" name="RETORNAR" value="RETORNAR">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></td>
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
//-->
</script>