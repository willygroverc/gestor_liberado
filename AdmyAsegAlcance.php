<?php if (isset($_REQUEST['Terminar']))
header("location: lista_admyaseg.php");
?>
<?php
if (isset($_REQUEST['Insertar2']))/// INSERTAR ACTIVIDAD
{   include("conexion.php");
        $var=$_REQUEST['var'];
        $var2=$_REQUEST['var2'];
        $IdActiv=$_REQUEST['IdActiv'];
	$Actividad=$_REQUEST['Actividad'];
	$RespActividad=$_REQUEST['RespActividad'];
	$Seguimiento=$_REQUEST['Seguimiento'];
        
	$sql2 = "SELECT MAX(IdActividad) AS ID FROM admyasegactiv WHERE IdAdmyAseg='$var' AND Tipo='$var2'";

	$result2=mysql_db_query($db,$sql2,$link);
  	$row2=mysql_fetch_array($result2);
	$IdActiv=$row2['ID']+1;
	require_once('funciones.php');
	$IdActiv=_clean($IdActiv);
	$Actividad=_clean($Actividad);
	$RespActividad=_clean($RespActividad);
	$Seguimiento=_clean($Seguimiento);
	$var=_clean($var);
	$var2=_clean($var2);
  
	$IdActiv=Sanitizestring($IdActiv);
	$Actividad=Sanitizestring($Actividad);
	$RespActividad=Sanitizestring($RespActividad);
	$Seguimiento=Sanitizestring($Seguimiento);
	$var=Sanitizestring($var);
	$var2=Sanitizestring($var2);
	$sql="INSERT INTO admyasegactiv (IdActividad,Actividad,RespActividad,Seguimiento,IdAdmyAseg,Tipo) ".
	"VALUES ('$IdActiv','$Actividad','$RespActividad','$Seguimiento','$var','$var2')";

	mysql_db_query($db,$sql,$link);
	header("location: AdmyAsegAlcance.php?variable1=$var&variable2=$var2");
}
elseif (isset($_REQUEST['Insertar1']))
{   include("conexion.php");
	require_once('funciones.php');
        $var=$_REQUEST['var'];
        $var2=$_REQUEST['var2'];
        $IdAlc=$_REQUEST['IdAlc'];
	$Alcance=$_REQUEST['Alcance'];
        
	$IdAlc=_clean($IdAlc);
	$Alcance=_clean($Alcance);
	$var=_clean($var);
	$var2=_clean($var2);
	
	$IdAlc=Sanitizestring($IdAlc);
	$Alcance=Sanitizestring($Alcance);
	$var=Sanitizestring($var);
	$var2=Sanitizestring($var2);
	$sql2 = "SELECT MAX(IdAlcance) AS ID FROM admyasegalcance WHERE IdAdmyAseg='$var' AND Tipo='$var2'";

	$result2=mysql_db_query($db,$sql2,$link);
  	$row2=mysql_fetch_array($result2);
	$IdAlc=$row2['ID']+1;
	$sql="INSERT INTO admyasegalcance (IdAlcance,Alcance,IdAdmyAseg,Tipo) ".
	"VALUES ('$IdAlc','$Alcance','$var','$var2')";

	mysql_db_query($db,$sql,$link);
	header("location: AdmyAsegAlcance.php?variable1=$var&variable2=$var2");
}
else { 
include("top.php");
$IdAdm=($_GET['variable1']);
$Tip=($_GET['variable2']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addExists ( "Actividad",  "Actividades, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "RespActividad",  "Responsables, $errorMsgJs[empty]" );
$valid->addExists ( "Seguimiento",  "Seguimiento/Metricas, $errorMsgJs[empty]" );
print $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function validateForm1 (){
var form=document.form2;
if ( ! doesExist ( form.obs_seg2.value ) ) {
      alert ( "Alcance/Objetivo, no puede ser vacio.\n \nMensaje generado por GesTor F1." );
      form.obs_seg2.focus();
      return ( false );
    }
return true;
	}  
//-->
</script> 
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<table width="85%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="AdmyAsegAlcance.php" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $IdAdm;?>">
	<input name="var2" type="hidden" value="<?php echo $Tip;?>">
	<tr> 
      <td height="300"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <?php  $sql4 = "SELECT * FROM admyasegdatos WHERE IdAdmyAseg='$IdAdm' AND Tipo='$Tip'";
				$result4=mysql_db_query($db,$sql4,$link);
				$row4=mysql_fetch_array($result4); ?>
			<td height="58" colspan="2"> 
              <table width="100%">
                <tr>
                  <td width="77%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Tipo 
                    de formulario :&nbsp;<font color="#000000"><?php echo $Tip?></font></font></td>
                  <td width="23%"><font size="2" face="Arial, Helvetica, sans-serif">Numero 
                    de Formulario : <?php echo $IdAdm?></font></td>
                </tr>
              </table>
              <table width="100%">
                <tr>
                  <td height="20"><font size="2" face="Arial, Helvetica, sans-serif"><font color="#000000">&nbsp;&nbsp;Nombre 
                    del proyecto : </font><font size="2" face="Arial, Helvetica, sans-serif"><font color="#000000"><?php echo $row4['NombProy']?></font></font></font></td>
                </tr>
              </table>
              
            </td>
          </tr>
          <tr> 
            <th width="55" nowrap background="images/main-button-tileR1.jpg" height="20"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></th>
            <th width="780" nowrap background="images/main-button-tileR1.jpg" height="20"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Alcance 
              / Objetivo</font></th>
          </tr>
          <?php
			
		$sql = "SELECT * FROM admyasegalcance WHERE IdAdmyAseg='$IdAdm' AND Tipo='$Tip'";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <td>&nbsp;<?php echo $row['IdAlcance']?></td>
            <td>&nbsp;<?php echo $row['Alcance']?>&nbsp;</td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="2" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="55" height="7" nowrap background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nuevo</font></div></td>
            <td height="7" nowrap><div align="center"><strong> 
                <input name="Alcance" type="text" id="obs_seg2" value="" size="130" maxlength="100">
                </strong> <strong> </strong> </div>
              <div align="center"><strong> </strong></div></td>
          </tr>
          <tr> 
            <td height="49" colspan="2" nowrap> 
              <div align="center"><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="Insertar1" type="submit" id="reg_form3" value="INSERTAR ALCANCE" onClick="return validateForm1();">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              </div></td>
          </tr>
        </table>
        
        <br>
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th width="61" nowrap background="images/main-button-tileR1.jpg" height="20"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></th>
            <th width="321" nowrap background="images/main-button-tileR1.jpg" height="20"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Actividades</font></th>
            <th width="261" nowrap background="images/main-button-tileR1.jpg" height="20"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Responsables</font></th>
            <th width="183" nowrap background="images/main-button-tileR1.jpg" height="20"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Seguimiento 
              / Metricas</font></th>
          </tr>
          <?php
			
		$sql3 = "SELECT * FROM admyasegactiv WHERE IdAdmyAseg='$IdAdm' AND Tipo='$Tip'";
		$result3=mysql_db_query($db,$sql3,$link);
		while($row3=mysql_fetch_array($result3)) 
  		{
		 ?>
          <tr> 
            <td>&nbsp;<?php echo $row3['IdActividad']?></td>
            <td>&nbsp;<?php echo $row3['Actividad']?></td>
            <?php 	$sql5 = "SELECT * FROM users WHERE login_usr='$row3[RespActividad]'";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";?>
			<td>&nbsp;<?php echo $row3['Seguimiento']?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="4" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="61" height="7" nowrap bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nuevo</font></div></td>
            <td height="7" nowrap><div align="center"><strong> 
                <input name="Actividad" type="text" id="Alcance" value="" size="50" maxlength="50">
                </strong> <strong> </strong> </div>
              <div align="center"><strong> </strong></div></td>
            <td height="7" nowrap><div align="center"><strong> 
                <select name="RespActividad" id="select2">
                          <option value="0"></option>
                          <?php 
			  $sql = "SELECT * FROM users WHERE tipo2_usr='T' OR tipo2_usr='A' ORDER BY apa_usr ASC";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
			   ?>
                </select>
                </strong></div></td>
            <td height="7" nowrap><div align="center">
                <input name="Seguimiento" type="text" size="30" maxlength="45">
              </div></td>
          </tr>
          <tr> 
            <td height="28" colspan="4" nowrap> <div align="center"><br>
                <input name="Insertar2" type="submit" id="Insertar1" value="INSERTAR ACTIVIDAD" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="SALIR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<p>&nbsp;</p><p> 
  <?php } ?>
</p>
<?php require("top_.php");?>
