<?php if (isset($_REQUEST['Terminar'])) {header("location: lista_admyaseg.php");}
if (isset($_REQUEST['MODIFICAR2']))
{   include('conexion.php');
	if ($_REQUEST['IdActividad']=="Nueva")
		{
                $var=$_REQUEST['var'];
                $var2=$_REQUEST['var2'];
                $Fa=$_REQUEST['Fa'];
		$Actividad=$_REQUEST['Actividad'];
		$RespActividad=$_REQUEST['RespActividad'];
		$Seguimiento=$_REQUEST['Seguimiento'];
                $sql8="SELECT MAX(IdActividad) AS IdAl FROM admyasegactiv WHERE IdAdmyAseg='$var' AND Tipo='$var2'";
	 	$result8=mysql_db_query($db,$sql8,$link);
		$row8=mysql_fetch_array($result8);	
		$Fa=$row8['IdAl']+1;
		require_once("funciones.php");
		$Fa=_clean($Fa);
		$Actividad=_clean($Actividad);
		$RespActividad=_clean($RespActividad);
		$Seguimiento=_clean($Seguimiento);
		$var=_clean($var);
		$var2=_clean($var2);
		
		$Fa=SanitizeString($Fa);
		$Actividad=SanitizeString($Actividad);
		$RespActividad=SanitizeString($RespActividad);
		$Seguimiento=SanitizeString($Seguimiento);
		$var=SanitizeString($var);
		$var2=SanitizeString($var2);
		
		$sql7="INSERT INTO admyasegactiv (IdActividad,Actividad,RespActividad,Seguimiento,IdAdmyAseg,Tipo) ".
		"VALUES ('$Fa','$Actividad','$RespActividad','$Seguimiento','$var','$var2')";
		mysql_db_query($db,$sql7,$link);
		header("location: AdmyAsegAlcance_last.php?variable1=$var&variable2=$var2");}
	else
		{
		require_once('funciones.php');
                $var=$_REQUEST['var'];
                $var2=$_REQUEST['var2'];
                $IdActividad=$_REQUEST['IdActividad'];
                $Actividad=$_REQUEST['Actividad'];
		$RespActividad=$_REQUEST['RespActividad'];
		$Seguimiento=$_REQUEST['Seguimiento'];
                
		$Actividad=_clean($Actividad);
		$RespActividad=_clean($RespActividad);
		$Seguimiento=_clean($Seguimiento);
		
		$Actividad=SanitizeString($Actividad);
		$RespActividad=SanitizeString($RespActividad);
		$Seguimiento=SanitizeString($Seguimiento);
		$sql="UPDATE admyasegactiv ".
		"SET Actividad='$Actividad',RespActividad='$RespActividad',Seguimiento='$Seguimiento' ".
		"WHERE IdAdmyAseg='$var' AND Tipo='$var2' AND IdActividad='$IdActividad'";
		mysql_db_query($db,$sql,$link);
		header("location: AdmyAsegAlcance_last.php?variable1=$var&variable2=$var2");}
}
elseif (isset($_REQUEST['MODIFICAR1']))
{		include("conexion.php");
		require_once('funciones.php');
                $var=$_REQUEST['var'];
                $var2=$_REQUEST['var2'];
                $Fa=$_REQUEST['Fa'];
		$Alcance=$_REQUEST['Alcance'];
		//$RespActividad=$_REQUEST['RespActividad'];
		//$Seguimiento=$_REQUEST['Seguimiento'];
                
		$var=_clean($var);		
		$var=SanitizeString($var);
		if ($_REQUEST['IdAlcance']=="Nueva")
		{$sql8="SELECT MAX(IdAlcance) AS IdAl FROM admyasegalcance WHERE IdAdmyAseg='$var' AND Tipo='$var2'";
	 	$result8=mysql_db_query($db,$sql8,$link);
		$row8=mysql_fetch_array($result8);	
		$Fa=$row8['IdAl']+1;
		$sql7="INSERT INTO ".
	 	"admyasegalcance (IdAlcance,Alcance,IdAdmyAseg,Tipo) ".
		"VALUES ('$Fa','$Alcance','$var','$var2')";
		mysql_db_query($db,$sql7,$link);
		header("location: AdmyAsegAlcance_last.php?variable1=$var&variable2=$var2");}
	else
	   {
		require_once('funciones.php');
		$Alcance=_clean($Alcance);
		$var=_clean($var);
		$var=_clean($var);
		
		
		$Alcance=SanitizeString($Alcance);
		$var=SanitizeString($var);
		$var=SanitizeString($var);
                $IdAlcance=$_REQUEST['IdAlcance'];
		$sql="UPDATE admyasegalcance SET Alcance='$Alcance' ".
		"WHERE IdAdmyAseg='$var' AND Tipo='$var2' AND IdAlcance='$IdAlcance'";
		mysql_db_query($db,$sql,$link);
		header("location: AdmyAsegAlcance_last.php?variable1=$var&variable2=$var2");}}
include("top.php");
$IdAlcance=  isset($_GET['IdAlcance']);
$IdActividad=  isset($_GET['IdActividad']);
$IdAdm=($_GET['variable1']);
$Tip=($_GET['variable2']);

  $sql6 = "SELECT * FROM admyasegalcance WHERE IdAdmyAseg ='$IdAdm' AND IdAlcance='$IdAlcance' AND Tipo='$Tip'";
  $result6 = mysql_db_query($db,$sql6,$link);
  $row6 = mysql_fetch_array($result6);
  
  $sql5 = "SELECT * FROM admyasegactiv WHERE IdAdmyAseg ='$IdAdm' AND IdActividad='$IdActividad' AND Tipo='$Tip'";
  $result5 = mysql_db_query($db,$sql5,$link);
  $row5 = mysql_fetch_array($result5);  
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addExists ( "Actividad",  "Actividades, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "RespActividad",  "Responsables, $errorMsgJs[empty]" );
$valid->addExists ( "Seguimiento",  "Seguimiento/Metricas, $errorMsgJs[empty]" );
print $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function validateForm1 (){
var form=document.form1;
if ( ! doesExist ( form.Alcance.value ) ) {
      alert ( "Alcance/Objetivo, no puede ser vacio.\n \nMensaje generado por GesTor F1." );
      form.Alcance.focus();
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
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
  <table width="90%" border="2" cellpadding="2" cellspacing="2" background="images/fondo.jpg">
    <tr> 
     <td colspan="3"> 
	  <table width="100%">
          <tr> 
            <?php  $sql4 = "SELECT * FROM admyasegdatos WHERE IdAdmyAseg='$IdAdm' AND Tipo='$Tip'";
				$result4=mysql_db_query($db,$sql4,$link);
				$row4=mysql_fetch_array($result4); ?>
			<input name="var" type="hidden" value="<?php echo $IdAdm;?>">
            <input name="var2" type="hidden" value="<?php echo $Tip;?>">
            <input name="IdAlcance" type="hidden" value="<?php echo $IdAlcance;?>">
            <input name="IdActividad" type="hidden" value="<?php echo $IdActividad;?>">
            <td width="77%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Tipo 
              de formulario :&nbsp;<font color="#000000"><?php echo $Tip?></font></font></td>
            <td width="23%"><font size="2" face="Arial, Helvetica, sans-serif">Numero 
              de Formulario : <?php echo $IdAdm?></font></td>
          </tr>
          <tr> 
            <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif"><font color="#000000">&nbsp;&nbsp;Nombre 
              del proyecto : </font><font size="2" face="Arial, Helvetica, sans-serif"><font color="#000000"><?php echo $row4['NombProy']?></font></font></font></td>
          </tr>
        </table></td>
    </tr>
    <tr align="center"> 
      <td width="77" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></td>
      <td width="394" colspan="2" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Alcance 
        / Objetivo</font></td>
    </tr>
    <?php
			
		$sql = "SELECT * FROM admyasegalcance WHERE IdAdmyAseg='$IdAdm' AND Tipo='$Tip'";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
    	<tr> 
	  	<?php echo "<td>&nbsp;<a href=\"AdmyAsegAlcance_last.php?variable1=$IdAdm&variable2=$Tip&IdAlcance=".$row['IdAlcance']."\">".$row['IdAlcance']."</a></font></td>";?>
      	<td>&nbsp;<?php echo $row['Alcance']?></td>
    	</tr>
    	<?php }?>
    <tr> 
      <td colspan="4" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
        <div align="center"></div></td>
    </tr>
    <tr> 
      <td nowrap> <div align="center"> 
          <select name="IdAlcance">
            <?php 
			     $sql2 = "SELECT * FROM admyasegalcance WHERE IdAdmyAseg='$IdAdm' AND Tipo='$Tip'";
			     $result2 = mysql_db_query($db,$sql2,$link);
			     while ($row2 = mysql_fetch_array($result2)) 
				{   if ($row2['IdAlcance']==$IdAlcance)
				{echo "<option value=\"$row2[IdAlcance]\"selected>$row2[IdAlcance]</option>";}
			  else
				{echo "<option value=\"$row2[IdAlcance]\">$row2[IdAlcance]</option>";}}
			   ?>
            <option value="Nueva">Nueva</option>
          </select>
        </div></td>
      <td colspan="2" nowrap><div align="center"><strong> <font size="2" face="Arial, Helvetica, sans-serif"> 
          <input name="Alcance" type="text" value="<?php echo $row6['Alcance'];?>" size="110" maxlength="100">
          </font> </strong> <strong> </strong> </div>
        <div align="center"><strong> </strong></div></td>
    </tr>
    <tr> 
      <td colspan="4" nowrap> <div align="center"><br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input name="MODIFICAR1" type="submit" id="MODIFICAR13" value="MODIFICAR ALCANCE" onClick="return validateForm1();">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        </div></td>
    </tr>
  </table>

  <table width="90%" border="2" cellpadding="0" cellspacing="1" background="images/fondo.jpg">
    <tr> 
            <th width="67" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></th>
            <th width="300" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Actividades</font></th>
            <th width="87" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Responsables</font></th>
            
      <th width="240" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Seguimiento 
        / Metricas</font></th>
          </tr>
          <?php
			
		$sql3 = "SELECT * FROM admyasegactiv WHERE IdAdmyAseg='$IdAdm' AND Tipo='$Tip'";
		$result3=mysql_db_query($db,$sql3,$link);
		while($row3=mysql_fetch_array($result3)) 
  		{
		 ?>
          <tr> <?php echo "<td>&nbsp;<a href=\"AdmyAsegAlcance_last.php?variable1=$IdAdm&variable2=$Tip&IdActividad=".$row3['IdActividad']."\">".$row3['IdActividad']."</a></font></td>";?>
            <td>&nbsp;<?php echo $row3['Actividad']?></td>
            <?php 	$sql7 = "SELECT * FROM users WHERE login_usr='$row3[RespActividad]'";
		    	$result7 = mysql_db_query($db,$sql7,$link);
		    	$row7 = mysql_fetch_array($result7);
				echo "<td>&nbsp;$row7[nom_usr] $row7[apa_usr] $row7[ama_usr]</td>";?>
            <td>&nbsp;<?php echo $row3['Seguimiento']?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="4" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="67" nowrap> <div align="center"> 
                <select name="IdActividad">
                  <?php 
			     $sql2 = "SELECT * FROM admyasegactiv WHERE IdAdmyAseg='$IdAdm' AND Tipo='$Tip'";
			     $result2 = mysql_db_query($db,$sql2,$link);
			     while ($row2 = mysql_fetch_array($result2)) 
				{   if ($row2['IdActividad']==$IdActividad)
				{echo "<option value=\"$row2[IdActividad]\"selected>$row2[IdActividad]</option>";}
			  else
				{echo "<option value=\"$row2[IdActividad]\">$row2[IdActividad]</option>";}}
			   ?>
                  <option value="Nueva">Nueva</option>
                </select>
              </div></td>
            <td nowrap><div align="center"><strong> <font size="2" face="Arial, Helvetica, sans-serif"> 
                
          <input name="Actividad" type="text" value="<?php echo $row5['Actividad'];?>" size="50" maxlength="50">
                </font> </strong> <strong> </strong> </div>
              <div align="center"><strong> </strong></div></td>
            <td nowrap><div align="center"><strong> <font size="2" face="Arial, Helvetica, sans-serif"> 
          <select name="RespActividad" >
            <?php
				
					echo "<option value=\"0\"></option>";
					$sql2 = "SELECT * FROM users WHERE tipo2_usr='T' OR tipo2_usr='A' ORDER BY apa_usr ASC";
			  		$result2=mysql_db_query($db,$sql2,$link);
			  		while ($row2=mysql_fetch_array($result2)) {
						if ($row5['RespActividad']==$row2['login_usr'])
							echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
						else
							echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
					}
			   ?>
          </select>
          </font> </strong></div></td>
            <td nowrap><div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                
          <input name="Seguimiento" type="text" value="<?php echo $row5['Seguimiento'];?>" size="30" maxlength="45">
                </font> </div></td>
          </tr>
          <tr> 
            
      <td colspan="4" nowrap> 
        <div align="center"><br>
                <input name="MODIFICAR2" type="submit" id="MODIFICAR23" value="MODIFICAR ACTIVIDAD" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="SALIR">
              </div></td>
          </tr>
        </table>
        
      </form>
<?php include("top_.php");?>
