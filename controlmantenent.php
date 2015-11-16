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
{  require ("conexion.php");
	$sql3 = "SELECT * FROM datfichatec WHERE CodActFijo='$CodActFijo'";
	$result3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($result3);	
	$fecha_ret="$AR-$MR-$DR";
	if($tm=="E"){$sql5="UPDATE pcontrol SET login_usr2='$login_usr2',enc_prov2='$enc_prov2',obs_retorno='$obs_retorno',fecha_ret='$fecha_ret' WHERE id_regPC='$IdReg'";	}
	elseif($tm=="I"){$sql5="UPDATE pcontrol SET login_usr2='$login_usr2',obs_retorno='$obs_retorno',fecha_ret='$fecha_ret' WHERE id_regPC='$IdReg'";	}
	mysql_query($sql5);
	header("location: controlmantenprincipal.php");
}
include("top.php"); 
$id_regPC=($_GET['IdRegPC']);
$sql = "SELECT *, DATE_FORMAT(fecha_s, '%d/%m/%Y') AS fecha_s, DATE_FORMAT(fecha_r, '%d/%m/%Y') AS fecha_r 
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
$valid->addIsNotEmpty ( "login_usr2",  "Funcionario Responsable, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "obs_retorno",  "Observaciones de Retorno, $errorMsgJs[expresion]" );
$valid->addLength( "obs_retorno",  "Observaciones de Retorno, $errorMsgJs[length]" );
$valid->addIsNotEmpty ( "NombProv",  "Empresa, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "enc_prov2",  "Responsable de la Empresa, $errorMsgJs[empty]" );

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
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#EAEAEA"  background="images/fondo.jpg">
   
	<tr> 
        
      <td width="7%" height="119"> 
        <table border="2" align="center" cellpadding="2" cellspacing="4">
          <tr> 
            <th colspan="9" nowrap bgcolor="#006699"><font size="3" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>CONTROL 
              DE MANTENIMIENTO - RETORNO</strong></font></th>
          </tr>
          <tr> 
            <th width="3%" nowrap bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">N&deg; 
              Activo Fijo</font></th>
            <th width="5%" nowrap bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Nro. 
              Cod. Adicional</font></th>
            <th width="20%" nowrap bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Descripcion</font></th>
            <th nowrap bgcolor="#006699"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Fecha 
                de Salida</font></div></th>
            <th nowrap bgcolor="#006699"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Fecha 
                de Retorno</font></div></th>
            <th nowrap bgcolor="#006699"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Funcionario 
                Responsable</font></div></th>
            <th nowrap bgcolor="#006699"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Observacion</font></div></th>
            <?php if($tm=="E"){?>
			<th width="100" nowrap bgcolor="#006699"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Empresa</font></div></th>
            <th width="125" nowrap bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Responsable 
			de la empresa</font></th>
			<?php }?>
          </tr>
          <tr> 
            <td height="26"><div align="center">&nbsp;<?php echo $row['CodActFijo']?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['AdicUSI'];?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['des_disp'];?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['fecha_s'];?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['fecha_r'];?></div></td>
			<?php  $str1 = "SELECT * FROM users WHERE login_usr='$row[login_usr]'";
				$res1 = mysql_query($str1);
				$datos = mysql_fetch_array($res1);
	   		?>
            <td><div align="center">&nbsp;<?php echo "$datos[nom_usr] $datos[apa_usr] $datos[ama_usr]";?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['Observ'];?></div></td>
			<?php if($tm=="E"){?>
            <td><div align="center">&nbsp;<?php echo $row['NombProv'];?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['EncProv'];?></div></td>
			<?php }?>
          </tr>
          <tr> 
            <td colspan="9" height="25" nowrap> 
              <div align="center"></div></td>
          </tr>
        </table></td>
    </tr>

  </table>
  <br>
  <table width="95%" border="2" bgcolor="#CCCCCC" background="images/fondo.jpg" align="center" >
    <tr> 
      <td colspan="4" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Nro. 
        Codigo Adicional:</font><strong> 
        <select disabled name="CodActFijo" id="select3">
          <?php 
				 $sql2 = "SELECT * FROM datfichatec";
			     $result2 = mysql_query($sql2);
			     while ($row2 = mysql_fetch_array($result2)) 
			     {	  
						$str  = "SELECT * FROM users WHERE login_usr='$row2[CodUsr]'";
						$res  = mysql_query(  $str);
						$fila = mysql_fetch_array($res);
					   if ( $row['CodActFijo'] == $row2['CodActFijo'] && $row2['AdicUSI']==$AdicUSI)				   
						{	if ($fila)
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
      <td height="74" colspan="1" align="center"><textarea name="des_disp" cols="30" rows="3" readonly><?php echo $row['des_disp']?></textarea></td>
      <td width="19%"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
         <?php echo $row['fecha_s'];?>
          <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"></font></strong></font></strong> 
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
          <select name="login_usr2" id="select24">
            <option value="0"></option>
            <?php 
			     $sql4 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			     $result4 = mysql_query($sql4);
			     while ($row4 = mysql_fetch_array($result4)) 
				   {
				   	echo "<option value=\"$row4[login_usr]\"";
					if($row4['login_usr']==$row['login_usr2']){echo "selected";}
					echo ">$row4[apa_usr] $row4[ama_usr] $row4[nom_usr]</option>";
	               }
			     ?>
          </select>
          </strong></div></td>
		  <?php }?>
    </tr>
    <tr> 
	<?php if($tm=="I" OR !$tm){?>
	   <td width="28%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Funcionario 
          Responsable</font></div></td>
	  <?php }?>
      <td align="center" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Observacion</font></div></td>
	  <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Tipo 
          de Mantenimiento</font></div></td>
      <?php if($tm=="E"){?>
	  <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Empresa</font></div></td>
      <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Responsable de la empresa</font></div></td>
	 <?php }?> 
    </tr>
    <tr background="images/fondo.jpg"> 
	 <?php if((isset ($tm) && $tm=="I") OR !isset($tm)){?>
	  <td><div align="center"><strong> 
          <select name="login_usr2" id="select24">
            <option value="0"></option>
            <?php 
			  $sql0 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  $result0=mysql_query($sql0);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				echo "<option value=\"$row0[login_usr]\"";
				if($row0['login_usr']==$row['login_usr2']){echo "selected";}
				echo ">$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
				}
			   ?>
          </select>
          </strong></div></td>
    <?php }?>
      <td align="center"><strong> 
        <textarea name="obs_retorno" cols="30" rows="3" id="obs_retorno"><?php echo $row['obs_retorno']?></textarea>
        </strong></td>
		 <td><div align="center"><?php echo $row['tipo_mant'];?></div></td>
		<?php if(isset($tm) && $tm=="E"){?>
      <td> <div align="center"><strong><?php echo "$row[NombProv]";?></strong></div></td>
		  
      <td> <div align="center"><strong> 
          <input name="enc_prov2" type="text" id="enc_prov2" value="<?php echo $row['EncProv']?>" maxlength="50">
          </strong></div></td><?php }?>
    </tr>
    <tr> 
      <td colspan="4" align="center"> <strong><br>
        <input name="guardar" type="submit"  value="GUARDAR" <?php print $valid->onSubmit() ?>>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input type="submit" name="RETORNAR" value="RETORNAR">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></td>
    </tr>
  </table>
  </form>
  <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal1 = new calendar1(document.forms[form].elements['DR'], document.forms[form].elements['MR'], document.forms[form].elements['AR']);			
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
//-->
</script>