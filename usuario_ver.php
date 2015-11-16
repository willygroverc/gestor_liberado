<?php
if ($RETORNAR){header("location: opt_admin.php");}
include("top.php");

$sql0 = "SELECT * FROM users WHERE login_usr='$login_usr'";
$result0=mysql_db_query($db,$sql0,$link);
$row0=mysql_fetch_array($result0);
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

<font color="#FF0000" face="Arial, Helvetica, sans-serif"><strong><?php echo $msg;?></strong></font>
<form action="<?php=$PHP_SELF?>" method="post" onKeyPress="return Form()">
  <table width="70%" border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
	  <td align="center" bgcolor="#006699"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>USUARIO</strong></font></td>
   </tr>

  <tr> 
    <td align="center"> 
   <table width="100%" border="0" cellpadding="3" cellspacing="0" >
          <tr> 
            <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">login(*) 
                </font></div></td>
            <td> <div align="left"> <font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
                <?php echo $row0[login_usr];?> </font></div></td>
            <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font color="#0000CC" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          </tr>
          <tr> 
            <td height="47"> <div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">password(*) 
                </font></div></td>
            <td height="47"> <div align="left"> <font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
                <input name="password_usr" type="password" id="password_usr2" value="<?php echo $row0[password_usr];?>" size="20" readonly="<?php echo $row0[password_usr];?>">
                </font></div></td>
            <td height="47"> <div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Tipo 
                :</font></div></td>
            <td height="47"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
              &nbsp;<?php echo $row0[tipo2_usr];?> </font></td>
            <td height="47" colspan="2" align="right"><div align="left"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;<font size="2">Email: 
                </font> </font><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
                &nbsp;<?php echo $row0[email];?> </font></div></td>
          </tr>
          <tr> 
            <td><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><div align="right"><font color="#0000FF"><font color="#0000CC"><font color="#000000"><font face="Arial, Helvetica, sans-serif"></font></font></font></font></div></td>
            <td colspan="2"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td colspan="2"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          </tr>
          <tr> 
            <td width="13%"><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cliente:</font> 
              </div></td>
            <td width="21%"><div align="center"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><?php echo $row0[tipo_usr];?> 
                </font> </div></td>
            <td><div align="center"></div></td>
            <td><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td colspan="2"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          </tr>
          <tr> 
            <td colspan="6"><strong><u><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Datos 
              del Cliente:</font></u></strong></td>
          </tr>
          <tr> 
            <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">NOMBRES:</font></div></td>
            <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
              &nbsp;<?php echo $row0[nom_usr];?> </font></td>
            <td width="16%"> <div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">AP.PATERNO:</font></div></td>
            <td width="18%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
              &nbsp;<?php echo $row0[apa_usr];?> </font></td>
            <td width="15%"> <div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">AP.MATERNO:</font></div></td>
            <td width="17%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
              &nbsp;<?php echo $row0[ama_usr];?> </font></td>
          </tr>
          <tr> 
            <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">ENTIDAD: 
                </font></div></td>
            <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
              &nbsp;<?php echo $row0[enti_usr];?> </font></td>
            <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">AREA:</font></div></td>
            <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
              &nbsp;<?php echo $row0[area_usr];?> </font></td>
            <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;ESPECIALIDAD:</font></div></td>
            <td><div align="left"><font color="#0000CC" size="2" face="Arial, Helvetica, sans-serif"> 
                &nbsp;<?php echo $row0[esp_usr];?> </font></div></td>
          </tr>
          <tr> 
            <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">CARGO:</font></div></td>
            <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php echo $row0[cargo_usr];?> </font></td>
            <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">TELEFONO:</font></div></td>
            <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
              &nbsp;<?php echo $row0[telf_usr];?> </font></td>
            <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">EXT:</font></div></td>
            <td><font color="#0000CC" size="2" face="Arial, Helvetica, sans-serif"> 
              &nbsp;<?php echo $row0[ext_usr];?> </font></td>
          </tr>
          <tr> 
            <td colspan="6"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          </tr>
          <tr> 
            <td colspan="6"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><u>Ubicacion 
              Fisica :</u></strong></font></td>
          </tr>
          <tr> 
            <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">CIUDAD:</font></div></td>
            <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
              <?php echo $row0[ciu_usr];?> </font></td>
            <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">DIRECCION:</font></div></td>
            <td ><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
              <?php echo $row0[direc_usr];?> </font></td>
            <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              </font></td>
            <td><font color="#0000CC" size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          </tr>
          <tr> 
            <td colspan="6"><div align="center"><br>
                <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
              </div></td>
          </tr>
          <tr align="center"> 
            <td colspan="6"> </td>
          </tr>
        </table>

</td> 
</tr> 
</table>
</form>
 