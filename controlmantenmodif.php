<?php if ($SALIR)
header("location: lista1_ficha.php");
?>
<?php
if (isset($reg_form))
{   include ("conexion.php");
	$fecha_s="$AS-$MS-$DS";
	$fecha_r="$AR-$MR-$DR";
	$sql2= "SELECT AdicUSI FROM caracfichtec WHERE caracfichtec.CodActFijo=pcontrol.CodActFijo";
	$result2=mysql_db_query($db,$sql2,$link);
	$AdicUSI=$result2;
	
	
	$sql3="INSERT INTO ".
	"PCONTROL (CodActFijo,AdicUSI,des_disp,fecha_s,fecha_r,login_usr,Observ,EncProv,NombProv) ".
	"VALUES ('$CodActFijo','$AdicUSI','$des_disp','$fecha_s','$fecha_r','$login_usr','$Observ','$EncProv','$NombProv')";
	mysql_db_query($db,$sql3,$link);
	header("location: controlmanten.php?varia1=$var");
} else
{include("top.php"); 
$id_regPC=($_GET['varia1']);
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
<input name="var" type="hidden" value="<?php echo $id_regPC;?>">
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#EAEAEA"  background="images/fondo.jpg">
   
	<tr> 
        
      <td width="7%" height="140"> 
        <table border="2" align="center" cellpadding="2" cellspacing="4">
          <tr> 
            <th colspan="9" nowrap bgcolor="#006699"><font size="3" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>CONTROL 
              DE MANTENIMIENTO EXTERNO</strong></font></th>
          </tr>
          <tr> 
            <th width="3%" nowrap bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">N&deg; 
              Activo Fijo</font></th>
            <th width="5%" nowrap bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Nro 
              Codigo Adicional</font></th>
            <th width="20%" nowrap bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Descripcion</font></th>
            <th width="79" nowrap bgcolor="#006699"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">_Fecha 
                de Salida</font></div></th>
            <th width="74" nowrap bgcolor="#006699"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Fecha 
                de Retorno</font></div></th>
            <th width="118" nowrap bgcolor="#006699"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Funcionario 
                Responsable</font></div></th>
            <th width="56" nowrap bgcolor="#006699"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Observacion</font></div></th>
            <th width="39" nowrap bgcolor="#006699"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Empresa</font></div></th>
            <th width="125" nowrap bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Responsable 
              de la empresa</font></th>
          </tr>
          <?php
		$sql = "SELECT * FROM pcontrol WHERE id_regPC>='$id_regPC' ORDER BY id_regPC ASC";
		$result=mysql_db_query($db,$sql,$link);
		$c=1;
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <td height="26">&nbsp;<?php echo $row[CodActFijo]?></td>
            <td><div align="right">&nbsp;<?php echo $AdicUSI?></div></td>
            <td><div align="right">&nbsp;<?php echo $row[des_disp]?></div></td>
            <td><div align="right">&nbsp;<?php echo $row[fecha_s]?></div></td>
            <td><div align="right">&nbsp;<?php echo $row[fecha_r]?></div></td>
            <td><div align="right">&nbsp;<?php echo $row[login_usr]?></div></td>
            <td><div align="right">&nbsp;<?php echo $row[Observ]?></div></td>
            <td><div align="right">&nbsp;<?php echo $row[EncProv]?></div></td>
            <td><div align="right">&nbsp;<?php echo $row[NombProv]?></div></td>
          </tr>
          <?php
		 }
		 ?>
          <tr> 
            <td colspan="9" height="18" nowrap> 
              <div align="center"></div>
              </td>
          </tr>
        </table></td>
    </tr>

  </table>
  <br>
  <table width="95%" border="2" bgcolor="#CCCCCC" background="images/fondo.jpg" align="center" >
    <tr> 
      <td colspan="4" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">No 
        Activo Fijo</font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">:</font><strong> 
        <select name="CodActFijo" id="select3">
          <option value="0"></option>
          <?php 
			  $sql0 = "SELECT * FROM datfichatec";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				
				echo "<option value=\"$row0[CodActFijo]\">$row0[CodActFijo]</option>";
				
                }
			   ?>
        </select>
        </strong></td>
    </tr>
    <td width="25%"> 
    <tr> 
      <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Descripcion</font></div></td>
      <td width="24%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha 
          de Salida</font></div></td>
      <td width="23%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha 
          de Retorno</font></div></td>
      <td width="28%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Funcionario 
          Responsable</font></div></td>
    </tr>
    <tr> 
      <td><div align="center"> 
          <textarea name="des_disp" cols="23" id="textarea4"></textarea>
        </div></td>
      <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <select name="DS" id="select18">
            <?php
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($DS=="$i")echo "selected";echo">$i</option>";
				}
				?>
          </select>
          </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <select name="MS" id="select19">
            <?php
				for($i=1;$i<=12;$i++)
				{
                echo "<option value=\"$i\">$i</option>";
				}
				?>
          </select>
          <select name="AS" id="select20">
            <?php
				for($i=2004;$i<=2020;$i++)
				{
                echo "<option value=\"$i\">$i</option>";
				}
				?>
          </select>
          </font></strong></font></div></td>
      <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <select name="DR" id="select21">
            <?php
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($DS=="$i")echo "selected";echo">$i</option>";
				}
				?>
          </select>
          </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          <select name="MR" id="select22">
            <?php
				for($i=1;$i<=12;$i++)
				{
                echo "<option value=\"$i\">$i</option>";
				}
				?>
          </select>
          <select name="AR" id="select23">
            <?php
				for($i=2004;$i<=2020;$i++)
				{
                echo "<option value=\"$i\">$i</option>";
				}
				?>
          </select>
          </font></div></td>
      <td><div align="center"><strong> 
          <select name="login_usr" id="select24">
            <option value="0"></option>
            <?php 
			  $sql0 = "SELECT * FROM users WHERE tipo2_usr='T'";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				
				echo "<option value=\"$row0[login_usr]\">$row0[nom_usr] $row0[apa_usr] $row0[ama_usr]</option>";
				
                }
			   ?>
          </select>
          </strong></div></td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#006699"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Observacion</font></div></td>
      <td colspan="2" bgcolor="#006699"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Empresa</font></div></td>
      <td bgcolor="#006699"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Responsable 
          de la empresa</font></div></td>
    </tr>
    <tr> 
      <td align="center"><div align="center"><strong> 
          <textarea name="Observ" cols="20" id="textarea5" ></textarea>
          </strong></div></td>
      <td colspan="2"><div align="center"><strong> 
          <select name="NombProv" id="select25">
            <option value="0"></option>
            <?php 
			  $sql0 = "SELECT * FROM proveedor";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				echo "<option value=\"$row0[NombProv]\">$row0[NombProv]</option>";
				
                }
			   ?>
          </select>
          </strong></div></td>
      <td><div align="center"><strong> 
          <input type="text" name="EncProv">
          </strong></div></td>
    </tr>
    <tr> 
      <td colspan="4" align="center"><strong> 
        <input name="reg_form" type="submit" id="reg_form4" value="ANADIR">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input type="submit" name="SALIR" value="SALIR">
        </strong></td>
    </tr>
  </table>
  </form>
 
<?php } ?>
<strong> </strong> 
<?php include("top_.php");?>