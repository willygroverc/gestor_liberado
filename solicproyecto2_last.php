<?php if (isset($_REQUEST['Terminar']))
header("location: lista_solicproyecto.php");
?>
<?php
if (isset($_REQUEST['reg_form']))
{   include("conexion.php");
        $var=$_REQUEST['var'];
        $EspecialidProy=$_REQUEST['EspecialidProy'];
        $IdGrupoProy=$_REQUEST['IdGrupoProy'];
        $ContraProy=$_REQUEST['ContraProy'];
        $InvolucProy=$_REQUEST['InvolucProy'];
	$sql6= "SELECT * FROM solicproygrupoproy WHERE Codigo='$var' AND EspecialidProy='$EspecialidProy'";

	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	
	if($_REQUEST['IdGrupoProy']=="Nueva")
	{	$sql1 = "SELECT MAX(IdGrupoProy) AS idgrupo FROM solicproygrupoproy WHERE Codigo='$var'";

		$result1=mysql_db_query($db,$sql1,$link);
		$row1=mysql_fetch_array($result1);
		$idgrup=$row1['idgrupo']+1;	
		require_once('funciones.php');
		$idgrup=_clean($idgrup);
		$var=_clean($var);
		$EspecialidProy=_clean($EspecialidProy);
		$InvolucProy=_clean($InvolucProy);
		$ContraProy=_clean($ContraProy);
		
		$idgrup=SanitizeString($idgrup);
		$var=SanitizeString($var);
		$EspecialidProy=SanitizeString($EspecialidProy);
		$InvolucProy=SanitizeString($InvolucProy);
		$ContraProy=SanitizeString($ContraProy);
		$sql="INSERT INTO ".
		"solicproygrupoproy (IdGrupoProy,Codigo,EspecialidProy,InvolucProy,ContraProy) ".
		"VALUES ('$idgrup','$var','$EspecialidProy','$InvolucProy','$ContraProy')";
     
		mysql_db_query($db,$sql,$link);
		header("location: solicproyecto2_last.php?Codigo=$var");}
	else {
	$sql="UPDATE solicproygrupoproy SET EspecialidProy='$EspecialidProy',InvolucProy='$InvolucProy',ContraProy='$ContraProy' ". 
		 "WHERE Codigo='$var' AND IdGrupoProy='$IdGrupoProy'";

	mysql_db_query($db,$sql,$link);
	header("location: solicproyecto2_last.php?Codigo=$var");
	}
}
else { 
include("top.php");
$Codigo=($_GET['Codigo']);
$Especialid=  isset($_GET['Especialid']);
		$sql0 = "SELECT * FROM solicproydatos WHERE Codigo='$Codigo'";
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
    <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onKeyPress="return Form()">
        <input name="var" type="hidden" value="<?php echo $_REQUEST['Codigo'];?>">
        <input name="var2" type="hidden" value="<?php echo $_GET['Especialid'];?>">
	<tr> 
      <td height="221"> 
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
            <th colspan="4" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">Grupo 
              para la implementacion del Proyecto</font></th>
          </tr>
          <tr> 
            <th width="67" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></th>
            <th width="275" nowrap bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Especialidad 
                del proyecto</font></div></th>
            <th width="254" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Equipo 
              involucrado en el Proyecto</font></th>
            <th width="241" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Contraparte 
                para Pruebas</font></div></th>
          </tr>
          <?php
			
		$sql = "SELECT * FROM solicproygrupoproy WHERE Codigo='$Codigo' ORDER BY IdGrupoProy ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> <?php echo "<td><a href=\"solicproyecto2_last.php?Codigo=$Codigo&Especialid=".$row['IdGrupoProy']."\">".$row['IdGrupoProy']."</a></td>";?> 
            <td align="center">&nbsp;<?php echo $row['EspecialidProy']?></div></td>
            <?php 
			$sql5 = "SELECT * FROM users WHERE login_usr='$row[InvolucProy]'";
	    	$result5 = mysql_db_query($db,$sql5,$link);
	    	$row5 = mysql_fetch_array($result5);
			echo "<td align=\"center\">&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
			$sql5 = "SELECT * FROM users WHERE login_usr='$row[ContraProy]'";
	    	$result5 = mysql_db_query($db,$sql5,$link);
	    	$row5 = mysql_fetch_array($result5);
			echo "<td align=\"center\">&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
			?>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="4" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <?php 	$sql3 = "SELECT * FROM solicproygrupoproy WHERE Codigo='$Codigo' AND IdGrupoProy='$Especialid'";
			  	$result3=mysql_db_query($db,$sql3,$link);
		      	$row3=mysql_fetch_array($result3)?>
            <td height="7" nowrap><div align="center"><strong> </strong><strong>
			<select name="IdGrupoProy">
                    <?php 
			     $sql2 = "SELECT * FROM solicproygrupoproy WHERE Codigo='$Codigo'";
			     $result2 = mysql_db_query($db,$sql2,$link);
			     while ($row2 = mysql_fetch_array($result2)) 
				{   if ($row2['IdGrupoProy']==$Especialid)
				{echo "<option value=\"$row2[IdGrupoProy]\"selected>$row2[IdGrupoProy]</option>";}
			  else
				{echo "<option value=\"$row2[IdGrupoProy]\">$row2[IdGrupoProy]</option>";}}
			   ?>
               <option value="Nueva">Nueva</option>
               </select>
                </strong> </div></td>
            <td height="7" nowrap><div align="center"><strong> 
                <input name="EspecialidProy" type="text" value="<?php echo $row3['EspecialidProy']?>" size="35" maxlength="35">
                </strong></div></td>
            <td width="254" nowrap height="7"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="InvolucProy">
                  <option value="0"></option>
                  <?php 
			  	$sql2 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  	$result2 = mysql_db_query($db,$sql2,$link);
			  	while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row3['InvolucProy']==$row2[login_usr])
					echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
				else
					echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
	            }
			   ?>
                </select>
                </font> </strong></div></td>
            <td height="7" nowrap> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="ContraProy">
                  <option value="0"></option>
                  <?php 
			  	$sql2 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  	$result2 = mysql_db_query($db,$sql2,$link);
			  	while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row3['ContraProy']==$row2['login_usr'])
					echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
				else
					echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
	            } ?>
                </select>
                </font> </strong></div></td>
          </tr>
          <tr> 
            <td height="28" colspan="4" nowrap> <div align="center"><br>
                <input name="reg_form" type="submit" id="reg_form3" value="GUARDAR CAMBIOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="TERMINAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
  <?php } ?>
<?php include("top_.php");?>
