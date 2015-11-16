<?php
if (isset($reg_form))
{

		$sql3="INSERT INTO ".
		"PCONTROL (id_regPC,n_activof,n_serie,des_disp,login_usr,fecha_s,fecha_r,Observ,empresa,resp_emp) ".
		"VALUES('$id_regPC','$n_activof','$n_serie',$des_disp,'$login_usr','".$AS."-".$MS."-".$DS."','".$AR."-".$MR."-".$DR."','$Observ','$empresa','$resp_emp')";

	
}


include("top.php");

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

<form action="<?php echo $PHP_SELF ?>" method="post" name="form1" onKeyPress="return Form()">
  <table width="583" border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#F4F2EA" style="border-collapse:collapse;" background="images/fondo.jpg">
    <tr> 
      <td width="579"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
          <tr> 
            <th width="100%" bgcolor="#006699"><font color="#FFFFFF">Control de 
              Mantenimiento Correctivo Fuera de las Instalaciones</font></th>
          </tr>
          <tr> 
            <td align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>No 
              Planilla<font size="2"><strong> 
              <input name="id_regPC" type="text" id="id_regPC3" value="<?php echo $id_regPC;?>" size="11" readonly="">
              </strong></font></strong> No Activo Fijo</font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">: 
              <strong><font size="2"><strong> 
              <input name="n_activof" type="text" size="11" >
              </strong></font></strong> &nbsp;&nbsp;No Serie: <strong><font size="2"><strong> 
              </strong></font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2"><strong> 
              <input name="n_serie" type="text" size="11" >
              </strong></font></strong></font><font size="2"><strong> </strong></font></strong> 
              &nbsp;&nbsp;</font></td>
          </tr>
          <tr> 
            <td align="center"><p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Descripcion:</font></p>
              <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <strong><font size="2"><strong> 
                <input name="des_disp" type="text" size="90" >
                </strong></font></strong> &nbsp;&nbsp;</font> </p></td>
          </tr>
          <tr> 
            <td align="center">Funcionario Responsable<br> <select name="login_usr" id="login_usr">
                <?php
				if($ver==0)	{
					echo "<option value=\"0\"></option>";
					$sql2 = "SELECT * FROM users WHERE tipo2_usr='T' OR tipo2_usr='A'";
			  		$result2=mysql_db_query($db,$sql2,$link);
			  		while ($row2=mysql_fetch_array($result2)) 
						{
						echo "<option value=\"$row2[login_usr]\">$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]</option>";
						}
				}
				else
				{
 					$sql0 = "SELECT * FROM users WHERE login_usr='$login_usr'";
			  		$result0=mysql_db_query($db,$sql0,$link);
					while($row0=mysql_fetch_array($result0))
						{
						echo "<option value=\"$row0[login_usr]\">$row0[nom_usr] $row0[apa_usr] $row0[ama_usr]</option>";
						}
				}
			   ?>
              </select></td>
          </tr>
		  
          <tr> 
            <td height="64" align="center">
<p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Responsable 
                de la empresa:</font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2"><strong> 
                <input name="empresa" type="text" size="40" >
                </strong></font></strong> </font></p>
              <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Empresa:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> 
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2"><strong> 
                <input name="resp_emp" type="text" size="50" >
                </strong></font></strong></font></strong> &nbsp;&nbsp;</font> 
              </p>
              </td>
          </tr>
          <tr> 
            <td align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha 
              de Salida: 
              <select name="DS" id="select8">
                <?php
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($DS=="$i")echo "selected";echo">$i</option>";
				}
				?>
              </select>
              <select name="MS" id="select9">
                <?php
				for($i=1;$i<=12;$i++)
				{
                echo "<option value=\"$i\">$i</option>";
				}
				?>
              </select>
              </font> <select name="AS" id="select">
                <?php
				for($i=2003;$i<=2020;$i++)
				{
                echo "<option value=\"$i\">$i</option>";
				}
				?>
              </select> </td>
          </tr>
          <tr> 
            <td align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha 
              de Retorno: 
              <select name="DR" id="select8">
                <?php
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\">$i</option>";
				}
				?>
              </select>
              <select name="MR" id="select9">
                <?php
				for($i=1;$i<=12;$i++)
				{
                echo "<option value=\"$i\">$i</option>";
				}
				?>
              </select>
              <select name="AR" id="select10">
                <?php
				for($i=2003;$i<=2020;$i++)
				{
                echo "<option value=\"$i\">$i</option>";
				}
				?>
              </select>
              </font></td>
          </tr>
          <tr> 
            <td align="center"><p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Observacion</font></p>
              <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <strong><font size="2"><strong> 
                <input name="Observ" type="text" size="90" >
                </strong></font></strong> &nbsp;&nbsp;</font> </p></td>
          </tr>
          <tr valign="middle"> 
            <td height="44" align="center"> <input name="reg_form" type="submit" value="GRABAR"></td>
          </tr>
        </table>
    </tr>
  </table>
</form>
<?php include("top_.php");?>
