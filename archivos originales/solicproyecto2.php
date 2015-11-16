<?php if (isset($Terminar))
header("location: lista_solicproyecto.php");
if (isset($reg_form))
{   include("conexion.php");
		$sql1 = "SELECT MAX(IdGrupoProy) AS idgrupo FROM solicproygrupoproy WHERE Codigo='$var'";
		$result1=mysql_db_query($db,$sql1,$link);
		$row1=mysql_fetch_array($result1);
		$idgrup=$row1['idgrupo']+1;
	require_once("funciones.php");
	$variable2=_clean($idgrup);
	$var=_clean($var);
	$EspecialidProy=_clean($EspecialidProy);
	$InvolucProy=_clean($InvolucProy);
	$ContraProy=_clean($ContraProy);
	
	$idgrup=SanitizeString($idgrup);
	$var=SanitizeString($var);
	$EspecialidProy=SanitizeString($EspecialidProy);
	$InvolucProy=SanitizeString($InvolucProy);
	$ContraProy=SanitizeString($ContraProy);
	$sql="INSERT INTO solicproygrupoproy (IdGrupoProy,Codigo,EspecialidProy,InvolucProy,ContraProy) ".
	"VALUES ('$idgrup','$var','$EspecialidProy','$InvolucProy','$ContraProy')";
	mysql_db_query($db,$sql,$link);
	header("location: solicproyecto2.php?Codigo=$var");
}
include("top.php");
		$Cod=($_GET['Codigo']);
		$sql0 = "SELECT * FROM solicproydatos WHERE Codigo='$Cod'";
		$result0=mysql_db_query($db,$sql0,$link);
		$row0=mysql_fetch_array($result0);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "EspecialidProy",  "Especialidad, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "InvolucProy",  "Equipo Involucrado, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "ContraProy",  "Contraparte, $errorMsgJs[empty]" );
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

  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <form name="form2" method="GET" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $Cod;?>">
	<tr> 
      <td> 
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td><div align="center"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>SOLICITUD 
                DE PROYECTOS</strong></font></div></td>
          </tr>
        </table>
        <table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="82%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;REQUERIMIENTO 
              : <?php echo $row0['Requerimiento'];?> </font></td>
            <td width="18%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;CODIGO 
              : <?php echo $row0['Codigo'];?></font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Descripcion 
              del Proyecto : <?php echo $row0['DescProyecto'];?> </font></td>
          </tr>
        </table>
        <table width="100%" border="1" align="center" cellpadding="1" cellspacing="2" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">Grupo 
              para la implementacion del Proyecto</font></th>
          </tr>
          <tr> 
            <th width="221" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Especialidad 
              del proyecto</font></th>
            <th width="304" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Equipo 
              involucrado en el Proyecto</font></th>
            <th width="320" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Contraparte 
                para Pruebas</font></div></th>
          </tr>
          <?php
			
		$sql = "SELECT * FROM solicproygrupoproy WHERE Codigo='$Codigo' ORDER BY IdGrupoProy ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <td align="center">&nbsp;<?php echo $row['EspecialidProy']?></td>
            <?php 
			$sql2 = "SELECT * FROM users WHERE login_usr='$row[InvolucProy]'";
			$result2 = mysql_db_query($db,$sql2,$link);
			$row2 = mysql_fetch_array($result2); 
			echo "<td align=\"center\"><font size=\"1\">&nbsp;$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]</font></td>";
			$sql2 = "SELECT * FROM users WHERE login_usr='$row[ContraProy]'";
			$result2 = mysql_db_query($db,$sql2,$link);
			$row2 = mysql_fetch_array($result2); 
			echo "<td align=\"center\"><font size=\"1\">&nbsp;$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]</font></td>";?>
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
                <input name="EspecialidProy" type="text" size="35" maxlength="35">
                </strong> </div></td>
            <td width="304" nowrap height="7"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="InvolucProy">
                  <option value="0"></option>
                  <?php 
			  $sql = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
			   ?>
                </select>
                </font> </strong></div></td>
            <td height="7" nowrap> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="ContraProy">
                  <option value="0"></option>
                  <?php 
			  $sql = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
			   ?>
                </select>
                </font> </strong></div></td>
          </tr>
          <tr> 
            <td height="28" colspan="5" nowrap> <div align="center"> <br>
                <input name="reg_form" type="submit" value="INSERTAR DATOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="TERMINAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<?php include("top_.php");?>
