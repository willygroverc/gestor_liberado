<?php if (isset($_REQUEST['Terminar']))
header("location: caracteristica2.php?variable1=$_REQUEST[variable1]&variable2=$_REQUEST[variable2]");
?>
<?php
if (isset($_REQUEST['reg_form']))
{   include("conexion.php");
	require_once('funciones.php');
        $var1=$_REQUEST['var1'];
        $var2=$_REQUEST['var2'];
	$Accesorio=$_REQUEST['Accesorio'];
	$Capacid=$_REQUEST['Capacid'];
	$Veloc=$_REQUEST['Veloc'];
	$Marca=$_REQUEST['Marca'];
	$ModSerie=$_REQUEST['ModSerie'];
	$Adicio=$_REQUEST['Adicio'];
	$Costo=$_REQUEST['Costo'];
        
	$var1=SanitizeString($var1);
	$Accesorio=SanitizeString($Accesorio);
	$Capacid=SanitizeString($Capacid);
	$Veloc=SanitizeString($Veloc);
	$Marca=SanitizeString($Marca);
	$ModSerie=SanitizeString($ModSerie);
	$Adicio=SanitizeString($Adicio);
	$Costo=SanitizeString($Costo);
	$sql="INSERT INTO ".
	"caracfichtec (IdFicha,Accesorio,Capacid,Veloc,Marca,ModSerie,Adicio, Costo) ".
	"VALUES ('$var1','$Accesorio','$Capacid','$Veloc','$Marca','$ModSerie','$Adicio','$Costo')";
//print_r($sql);exit;
	mysql_db_query($db,$sql,$link);
	header("location: caracteristica.php?variable1=$var1&variable2=$var2");
}
else { 
include("top.php");
$IdFi=($_GET['variable1']);
$IdFi2=($_GET['variable2']);
$IdFi3=  isset($_GET['otros']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
if ($IdFi3!=1){
$valid->addIsNotEmpty ( "Accesorio",  "Accesorios, $errorMsgJs[empty]" );
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
function redirect(x){
	if (x==15 & form2.var3.value!=1){
		self.location="caracteristica.php?variable1="+form2.var1.value+"&variable2="+form2.var2.value+"&otros="+1;
	}
	if (x!=18 & form2.var3.value==1){
		self.location="caracteristica.php?variable1="+form2.var1.value+"&variable2="+form2.var2.value;
	}
}
-->
</script>
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
	<input name="var1" type="hidden" value="<?php echo $IdFi;?>">
	<input name="var2" type="hidden" value="<?php echo $IdFi2;?>">
	<input name="var3" type="hidden" value="<?php echo $IdFi3;?>">
	<tr> 
      <td height="190"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="7" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">CARACTERISTICAS 
              DEL EQUIPO (VELOCIDAD, HD, RAM) </font></th>
          </tr>
          <tr> 
            <th width="160" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Accesorios</font></th>
            <th width="92" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Capacidad</font></th>
            <th width="94" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Velocidad</font></th>
            <th width="90" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Marca</font></div></th>
            <th width="94" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Modelo 
                / Serie</font></div></th>
            <th width="90" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Adicional</font></th>
			<th width="90" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Costo (Bs)</font></th>
            </tr>
          <?php
			
		$sql = "SELECT * FROM caracfichtec WHERE IdFicha='$IdFi' ORDER BY IdFicha ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <td>&nbsp;<?php echo $row['Accesorio']?></td>
            <td>&nbsp;<?php echo $row['Capacid']?></td>
            <td>&nbsp;<?php echo $row['Veloc']?></div></td>
            <td>&nbsp;<?php echo $row['Marca']?></div></td>
            <td>&nbsp;<?php echo $row['ModSerie']?></div></td>
            <td>&nbsp;<?php echo $row['Adicio']?></td>
			<td>&nbsp;<?php echo $row['Costo']?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="7" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="160" nowrap height="7"><strong> 
              <select name=
			  <?php if ($IdFi3==1){
			  			echo "Acceso";
					} else {
						echo "Accesorio";
					};?> 
			   onChange="redirect(this.options.selectedIndex)">
                <option value="0"></option>
                <?php 
			  $sql = "SELECT * FROM accesorio ";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[NombAccesorio]\">$row[NombAccesorio]</option>";
	            }
			   ?>
                <option value="otros">Otros</option>
              </select>
              <?php if ($IdFi3==1){?>
              OTRO ACCESORIO: 
              <input type="text" name="Accesorio"><?php }?>
              </strong></td>
            <td width="92" nowrap height="7"><strong> 
              <input name="Capacid" type="text" id="obs_seg2" value="" size="15" maxlength="25">
              </strong> </td>
            <td width="94" nowrap height="7"><strong> 
              <input name="Veloc" type="text" id="estado_seg4" size="15" maxlength="25">
              </strong></td>
            <td width="90" nowrap height="7"> <div align="center"><strong> 
                <input name="Marca" type="text" id="estado_seg3" size="15" maxlength="40">
                </strong></div></td>
            <td width="94" nowrap height="7"><input name="ModSerie" type="text" size="15" maxlength="40">            </td>
            <td width="90" nowrap><input name="Adicio" type="text" size="15" maxlength="70"></td>
            <td width="90" nowrap><input name="Costo" type="text" size="7" maxlength="70">
            <label></label></td>
          </tr>
          <tr> 
            <td height="28" colspan="7" nowrap> <div align="center"> <br>
                <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR DATOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="variable1" type="hidden" id="variable1" value="<?php echo $_REQUEST['variable1']?>">
                <input name="variable2" type="hidden" id="variable2" value="<?php echo $_REQUEST['variable2']?>">
                <input type="submit" name="Terminar" value="GUARDAR Y CONTINUAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<p> 
  <?php }?>
</p>
<?php include("top_.php");?>
