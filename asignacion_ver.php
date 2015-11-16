<?php
include("top.php"); 

$sql = "SELECT * FROM asignacion WHERE id_orden='$id_orden'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);
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
<form action="<?php echo $PHP_SELF ?>" method="post" name="form1" onKeyPress="return Form()">
  <table width="583" border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#F4F2EA" style="border-collapse:collapse;" background="images/fondo.jpg">
    <tr> 
      <td width="579"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
          <tr> 
            <th colspan="2" bgcolor="#006699"><font color="#FFFFFF">ASIGNACION</font></th>
          </tr>
          <tr> 
            <td width="50%" height="25" align="center"><strong>Nro: <font size="2"><strong> 
              <input name="num_ord" type="text" id="num_ord" value="<?php echo $id_orden;?>" size="11" readonly="">
              </strong></font></strong> </td>
            <td align="center">Fecha:<strong> <?php echo $row[fecha_asig];?> &nbsp;&nbsp;
              </strong>Hora:<strong> <?php echo $row[hora_asig];?></strong> 
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center">Nivel:
             <input name="nivel_asig" type="text" id="nivel_asig" value="<?php echo $row[nivel_asig];?>" size="11" readonly="">
              &nbsp;&nbsp;Criticidad:
             <input name="criticidad_asig" type="text" id="criticidad_asig" value="<?php echo $row[criticidad_asig];?>" size="11" readonly="">
             &nbsp;&nbsp;Prioridad:
              <input name="prioridad_asig" type="text" id="prioridad_asig" value="<?php echo $row[prioridad_asig];?>" size="11" readonly="">
              </td>
          </tr>
          <tr> 
            <td colspan="2" align="center">Asignado a: <br>
	             <input name="asig" type="text" id="asig" value="<?php echo $row[asig];?>" size="11" readonly="">              
			</td>
          </tr>
          <tr> 
            <td colspan="2" align="center"><strong>Fecha estimada de solucion 
              </strong><strong><?php echo $row[fechaestsol_asig];?></strong></font> 
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center">Diagnostico Inicial:<br>
     	      <input name="diagnos" type="text" id="diagnos" value="<?php echo $row[diagnos];?>" size="100" readonly="">              
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center">Escalamiento a: <br>
            <input name="asig" type="text" id="asig" value="<?php echo $row[escal];?>" size="11" readonly="">              
			</td>
          </tr>
          <tr> 
            <td colspan="2" align="center">Fecha estimada de solucion:<?php echo $row[date_esc]." ".$row[time_esc];?> 
            </td>
			  
          </tr>
          <tr valign="middle"> 
            <td height="44" colspan="2" align="center"> 
              <input name="reg_form" type="submit" id="reg_form22" value="GUARDAR"></td>
          </tr>
        </table>
    </tr>
  </table>
</form>
<?php include("top_.php");?>