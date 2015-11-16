<?php if (isset($Terminar))
header("location: lista_soliccambios.php");
require_once('funciones.php');
$id_orden=SanitizeString($id_orden);
?>
<?php
if (isset($reg_form))
{   include("conexion.php");
	
	$sql1 = "SELECT MAX(IdGrupoProy) AS idgrupo FROM soliccambiogrupoproy WHERE Codigo='$id_orden'";
	$result1=mysql_db_query($db,$sql1,$link);
	$row1=mysql_fetch_array($result1);
	$idgrup=$row1['idgrupo']+1;
	
	$num=count($InvolucProy);
	for ($i=0;$i<$num;$i++)
	{	if($i==$num-1){$InvolucProy_r=$InvolucProy_r.$InvolucProy[$i];}
		else {$InvolucProy_r=$InvolucProy_r.$InvolucProy[$i]."|*|";}
	}
	
	$num=count($ContraProy);
	for ($i=0;$i<$num;$i++)
	{	if($i==$num-1){$ContraProy_r=$ContraProy_r.$ContraProy[$i];}
		else {$ContraProy_r=$ContraProy_r.$ContraProy[$i]."|*|";}
	}
	require_once('funciones.php');
	$idgrup=SanitizeString($idgrup);
	$id_orden=SanitizeString($id_orden);
	$EspecialidProy=SanitizeString($EspecialidProy);
	$InvolucProy_r=SanitizeString($InvolucProy_r);
	$ContraProy_r=SanitizeString($ContraProy_r);
	$sql="INSERT INTO soliccambiogrupoproy (IdGrupoProy,Codigo,EspecialidProy,InvolucProy,ContraProy) ".
	"VALUES ('$idgrup','$id_orden','$EspecialidProy','$InvolucProy_r','$ContraProy_r')";
	mysql_db_query($db,$sql,$link);
}
include("top.php");
$sql0 = "SELECT * FROM soliccambiodatos WHERE Codigo='$id_orden'";
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

  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="../images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="id_orden" type="hidden" value="<?php echo $id_orden;?>">
	<tr> 
      <td> 
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td><div align="center"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>SOLICITUD 
                DE CAMBIO EN PRODUCCION</strong></font></div></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="12%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<strong>Orden 
              Nro. :</strong> </font></td>
            <td width="88%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><?php echo $id_orden;?></font></td>
          </tr>
        </table>
		<table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="15%" valign="top"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<strong>Requerimiento 
              :</strong> </font></td>
            <td width="85%" valign="top"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">
              <?php 
			  $sql_req="SELECT desc_inc FROM ordenes WHERE id_orden='$id_orden'";
			  $row_req=mysql_fetch_array(mysql_db_query($db,$sql_req,$link));			  
			  echo $row_req['desc_inc'];?>
              </font></td>
          </tr>
        </table>
		 
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="21%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<strong>Descripcion 
              del Cambio :</strong> </font></td>
            <td width="79%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row0['DescProyecto'];?></font></td>
          </tr>
        </table>
        <table width="100%" border="1" align="center" cellpadding="1" cellspacing="2" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">Grupo 
              para la implementacion del Cambio</font></th>
          </tr>
          <tr> 
            <th width="221" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Especialidad 
              del Cambio</font></th>
            <th width="304" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Equipo 
              involucrado para el Cambio</font></th>
            <th width="320" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Contraparte 
                para Pruebas (Cliente)</font></div></th>
          </tr>
          <?php
			
		$sql = "SELECT * FROM soliccambiogrupoproy WHERE Codigo='$id_orden' ORDER BY IdGrupoProy ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <td align="center">&nbsp;<?php echo $row['EspecialidProy']?></td>
            <?php 
			echo "<td align=\"center\"><font size=\"1\">";
			$respon=explode("|*|",$row['InvolucProy']);
			$num_respon=count($respon);
			for($j=0;$j<$num_respon;$j++)
			{
				$sql2 = "SELECT * FROM users WHERE login_usr='$respon[$j]'";
				$result2 = mysql_db_query($db,$sql2,$link);
				$row2 = mysql_fetch_array($result2); 
				echo "- $row2[nom_usr] $row2[apa_usr] $row2[ama_usr]&nbsp;<br>";
			}
			echo "</font></td>";
			
			echo "<td align=\"center\"><font size=\"1\">";
			$respon=explode("|*|",$row['ContraProy']);
			$num_respon=count($respon);
			for($j=0;$j<$num_respon;$j++)
			{
				$sql2 = "SELECT * FROM users WHERE login_usr='$respon[$j]'";
				$result2 = mysql_db_query($db,$sql2,$link);
				$row2 = mysql_fetch_array($result2); 
				echo "- $row2[nom_usr] $row2[apa_usr] $row2[ama_usr]&nbsp;<br>";
			}
			echo "</font></td>";
		  ?>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="5" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td height="7" nowrap><div align="center"><strong> </strong><strong> 
                <textarea name="EspecialidProy" cols="35" rows="3" onKeyDown="textCounter(form2.EspecialidProy,form2.remLen,200);" onKeyUp="textCounter(form2.EspecialidProy,form2.remLen,200);"></textarea>
				<input name="remLen" type="hidden" value="200">
                </strong> </div></td>
            <td width="304" nowrap height="7"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">
                <select name="InvolucProy[]" size="5" multiple style="width:250px" <?php //if($tcampo=="t" OR !$tcampo){echo "disabled";}?>>
                 <?php	$i=1;
				 	$sql="SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";	
					$result=mysql_db_query($db,$sql,$link);
					while($row=mysql_fetch_array($result))
					{	
						if($i==1)
						{	echo "<option value=\"$row[login_usr]\" selected>$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>"; 
							$i++;
						}
						else
						{	echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";}
					}
				?>
                </select>
                </font> </strong></div></td>
            <td height="7" nowrap> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">
                <select name="ContraProy[]" size="5" multiple style="width:250px" <?php //if($tcampo=="t" OR !$tcampo){echo "disabled";}?>>
                <?php	$i=1;
				  	$sql="SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";	
					$result=mysql_db_query($db,$sql,$link);
					while($row=mysql_fetch_array($result))
					{	
						if($i==1)
						{	echo "<option value=\"$row[login_usr]\" selected>$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>"; 
							$i++;
						}
						else
						{	echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";}
					}
				?>
                </select>
               </font> </strong></div></td>
          </tr>
          <tr> 
            <td height="28" colspan="5" nowrap> <div align="center"><strong><font size="1">Nota 
                : Para Seleccionar mas de un Responsable, presione la tecla Ctrl 
                (Control).</font></strong><br>
                <br>
                <input name="reg_form" type="submit" value="INSERTAR DATOS">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="TERMINAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<?php include("top_.php");?>
<script language="JavaScript">
<!-- 
function textCounter(field, countfield, maxlimit) 
{
	if (field.value.length > maxlimit) 
	field.value = field.value.substring(0, maxlimit);
	else 
	countfield.value = maxlimit - field.value.length;
}
-->
</script>
