<?php if (isset($_REQUEST['Terminar']))
header("location: lista_analisisriesgos.php");
?>
<?php
include("conexion.php");
if (isset($_REQUEST['INSERTAR']))
{   $var=$_REQUEST['var'];
    $Descripcion=$_REQUEST['Descripcion'];
    $Probabilidad=$_REQUEST['Probabilidad'];
    $Impacto=$_REQUEST['Impacto'];
	if ($_REQUEST['IdDescripcion']=="Nueva")
		{$sql8="SELECT MAX(IdDescripcion) AS IdDes FROM analisisriesgdesc WHERE IdAnalisis='$var'";
     
	 	$result8=mysql_db_query($db,$sql8,$link);
		$row8=mysql_fetch_array($result8);	
		$Fa=$row8['IdDes']+1;
		require_once('funciones.php');
		$Fa=_clean($Fa);
		$Descripcion=_clean($Descripcion);
		$Probabilidad=_clean($Probabilidad);
		$Impacto=_clean($Impacto);
		$var=_clean($var);
		
		$Fa=SanitizeString($Fa);
		$Descripcion=SanitizeString($Descripcion);
		$Probabilidad=SanitizeString($Probabilidad);
		$Impacto=SanitizeString($Impacto);
		$var=SanitizeString($var);
		$sql7="INSERT INTO analisisriesgdesc (IdDescripcion,Descripcion,Probabilidad,Impacto,IdAnalisis) ".
			  "VALUES ('$Fa','$Descripcion','$Probabilidad','$Impacto','$var')";
		mysql_db_query($db,$sql7,$link);
		header("location: AnalisisRiesgoDesc_last.php?variable1=$var");}
	else
		{
                $IdDescripcion=$_REQUEST['IdDescripcion'];
                $sql="UPDATE analisisriesgdesc SET Descripcion='$Descripcion',Probabilidad='$Probabilidad',".
		"Impacto='$Impacto' WHERE IdAnalisis='$var' AND IdDescripcion='$IdDescripcion'";
		mysql_db_query($db,$sql,$link);
		header("location: AnalisisRiesgoDesc_last.php?variable1=$var");}
}
else { 
include("top.php");
if(!empty($_GET['variable2'])){
    $IdDescrip=($_GET['variable2']);
} else {
    $IdDescrip=0;
}

$IdAnalis=($_GET['variable1']);
//$IdDescrip=($_GET['variable2']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "Descripcion",  "Descripcion, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty( "Probabilidad",  "Probabilidad, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "Impacto",  "Impacto, $errorMsgJs[expresion]" );
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
<form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
  <table width="90%" border="1" background="images/fondo.jpg">
    <tr> 
      <td colspan="7"> 
	  <table width="100%">
          <tr> 
            <?php  $sql4 = "SELECT * FROM analisisriesgdatos WHERE IdAnalisis='$IdAnalis'";
						$result4=mysql_db_query($db,$sql4,$link);
						$row4=mysql_fetch_array($result4); ?>
            <td width="77%" height="20"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Nombre 
              del proyecto : <?php echo $row4['NombProy']?> 
              <input name="var" type="hidden" value="<?php echo $IdAnalis;?>">
              <input name="var2" type="hidden" value="<?php echo $IdDescrip;?>">
              </font></td>
            <td width="23%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Numero 
              de Formulario : <?php echo $IdAnalis?></font></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <th colspan="7" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">ANALISIS 
        DE RIESGOS</font></th>
    </tr>
    <tr align="center"> 
      <th width="46" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></th>
      <th width="308" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Descripcion</font></th>
      <th width="222" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Probabilidad</font></th>
      <th colspan="2" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Impacto</font></th>
    </tr>
    <?php
			
		$sql = "SELECT * FROM analisisriesgdesc WHERE IdAnalisis='$IdAnalis' ORDER BY IdDescripcion";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
    <tr> <?php echo "<td><a href=\"AnalisisRiesgoDesc_last.php?variable1=$IdAnalis&variable2=".$row['IdDescripcion']."\">".$row['IdDescripcion']."</a></font></td>";?>&nbsp; 
      <td align="center">&nbsp;<?php echo $row['Descripcion']?></td>
      <td><div align="center">&nbsp;<?php echo $row['Probabilidad']?></div></td>
      <td width="222"><div align="center">&nbsp;<?php echo $row['Impacto']?></div></td>
    </tr>
    <?php 
		 }
		 ?>
    <tr> 
      <td colspan="7" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
        <div align="center"></div></td>
    </tr>
    <tr> 
      <td height="7" nowrap><div align="center"> 
          <select name="IdDescripcion">
            <?php 
				 $sql3 = "SELECT * FROM analisisriesgdesc WHERE IdAnalisis='$IdAnalis' AND IdDescripcion='$IdDescrip'";
			     $result3 = mysql_db_query($db,$sql3,$link);
			     $row3 = mysql_fetch_array($result3);  
				  
			     $sql2 = "SELECT * FROM analisisriesgdesc WHERE IdAnalisis='$IdAnalis'";
			     $result2 = mysql_db_query($db,$sql2,$link);
			     while ($row2 = mysql_fetch_array($result2)) 
				{   if ($row2['IdDescripcion']==$IdDescrip)
				{echo "<option value=\"$row2[IdDescripcion]\"selected>$row2[IdDescripcion]</option>";}
			  else
				{echo "<option value=\"$row2[IdDescripcion]\">$row2[IdDescripcion]</option>";}}
			   ?>
            <option value="Nueva">Nueva</option>
          </select>
        </div></td>
      <td height="7" nowrap><textarea name="Descripcion" cols="52"><?php echo $row3['Descripcion']?></textarea></td>
      <td align="center" width="222" nowrap><input name="Probabilidad" type="text" value="<?php echo $row3['Probabilidad']?>" size="37" maxlength="60"></td>
      <td height="7" colspan="2" nowrap> <div align="center"><strong> 
          <input name="Impacto" type="text" value="<?php echo $row3['Impacto']?>" size="37" maxlength="60">
          </strong></div></td>
    </tr>
    <tr> 
      <td height="49" colspan="7" nowrap> <div align="center"><br>
          <input name="INSERTAR" type="submit" id="INSERTAR2" value="MODIFICAR DATOS"  <?php print $valid->onSubmit() ?>>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="Terminar" value="TERMINAR">
        </div></td>
    </tr>
  </table>
</form>
  <?php } include("top_.php");?>
