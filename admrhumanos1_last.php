<?php if (isset($_REQUEST['Terminar']))
header("location: lista_admyaseg.php");
?>
<?php
if (isset($_REQUEST['INSERTAR']))
{   include("conexion.php");
            $activprod=$_REQUEST['activprod'];
            $nombresp=$_REQUEST['nombresp'];
            $cronograma=$_REQUEST['cronograma'];
            $cumplimiento=$_REQUEST['cumplimiento'];
            $observaciones=$_REQUEST['observaciones'];
            $var=$_REQUEST['var'];
            $IdActividad=$_REQUEST['IdActividad'];
            //$num_det=$_REQUEST['num_det'];
		if ($IdActividad=="Nueva")
		{
		$sql5 = "SELECT MAX(num_det) AS num FROM admrhdet WHERE IdAdmyAseg='$var'";
		$result5=mysql_db_query($db,$sql5,$link);
		$row5=mysql_fetch_array($result5); 
		$num_det=$row5['num']+1;	
		if ($cumplimiento=="") {$cumplimiento="NO";}
		$sql="INSERT INTO ".
		"admrhdet (activprod,nombresp,cronograma,cumplimiento,observaciones,IdAdmyAseg,num_det,Tipo) ".
		"VALUES ('$activprod','$nombresp','$cronograma','$cumplimiento','$observaciones','$var','$num_det','ADMINISTRACION DE RECURSOS HUMANOS')";
		mysql_db_query($db,$sql,$link);
		header("location: admrhumanos1_last.php?variable1=$var");}
	else 
		{
                
                $sql="UPDATE ".
		"admrhdet SET activprod='$activprod',nombresp='$nombresp',cronograma='$cronograma',cumplimiento='$cumplimiento',observaciones='$observaciones' ".
		"WHERE IdAdmyAseg='$var' AND num_det='$IdActividad'";
		mysql_db_query($db,$sql,$link);
	
		header("location: admrhumanos1_last.php?variable1=$var");}
}
else { 
include("top.php");
if(!empty($_REQUEST['num_det'])){
    $num_det= $_REQUEST['num_det'];
} else {
    $num_det= 0;
}

//$num_det=($_GET['num_det']);
$IdAdm=($_GET['variable1']);
  $sql3 = "SELECT * FROM admrhdet WHERE IdAdmyAseg ='$IdAdm' AND num_det='$num_det'";
  $result3 = mysql_db_query($db,$sql3,$link);
  $row3 = mysql_fetch_array($result3);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "activprod",  "Actividades/Productos, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "nombresp",  "Nombre Responsables, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "cronograma",  "Cronograma, $errorMsgJs[expresion]" );
$valid->addLength ( "observaciones",  "Observaciones, $errorMsgJs[length]" );
$valid->addFunction ( "checkCumplimiento",  "" );
echo $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function checkCumplimiento () {
	var form=document.form2;
	if (form.cumplimiento[0].checked || form.cumplimiento[1].checked) {
		return true;
	}
	else {
		alert ("Cumplimiento, debe seleccionar una opcion. \n \nMensaje generado por GesTor F1.")
		return false;
	}
}
-->
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
<table width="95%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
    <input name="var" type="hidden" value="<?php echo $IdAdm;?>">
    <input name="var2" type="hidden" value="<?php echo $num_det;?>">	
    <tr> 
      <td> <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="9" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">ADMINISTRACION 
              DE RECURSOS HUMANOS</font></th>
          </tr>
          <tr align="center"> 
            <th width="93" rowspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Codigo</font></div></th>
            <th width="156" rowspan="2" bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Actividades 
                / Productos</font></div></th>
            <th width="171" rowspan="2" bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Nombre 
                Responsables </font></div></th>
            <th width="144" rowspan="2" bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Cronograma</font></div></th>
            <th colspan="3" bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Cumplimiento</font></div></th>
          </tr>
          <tr align="center"> 
            <th width="59" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SI</font></div></th>
            <th width="54" bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NO</font></div></th>
            <th width="200" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Observaciones</font></div></th>
          </tr>
          <?php
			
		$sql = "SELECT * FROM admrhdet WHERE IdAdmyAseg ='$IdAdm' ORDER BY num_det ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
			  
		 ?>
          <tr align="center"> <?php echo "<td><a href=\"admrhumanos1_last.php?variable1=$IdAdm&num_det=".$row['num_det']."\">".$row['num_det']."</a></font></td>";?> 
            <td><div align="center">&nbsp;<?php echo $row['activprod']?></div></td>
            <td><div align="center">&nbsp;<?php 
				$cons1="SELECT * FROM users WHERE login_usr='$row[nombresp]'";
				$resp1=mysql_db_query($db,$cons1,$link);
				$fila1=mysql_fetch_array($resp1);
				echo $fila1['nom_usr']."&nbsp;".$fila1['apa_usr']."&nbsp;".$fila1['ama_usr'];?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['cronograma']?></div></td>
            <?php if  ($row['cumplimiento']=="SI") {echo "<td align=\"center\"><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";
											 echo "<td align=\"center\"><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}
										 
			  elseif ($row['cumplimiento']=="NO"){echo "<td align=\"center\"><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";
		   							       	  echo "<td align=\"center\"><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
			  else {echo "<td>&nbsp;</td>";
 		       	   echo "<td>&nbsp;</td>";}
											  
			?>
            <td><div align="center">&nbsp;<?php echo $row['observaciones']?></div></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="9" height="20" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td nowrap><div align="center">&nbsp; 
                <select name="IdActividad">
                  <?php 
			     $sql2 = "SELECT * FROM admrhdet WHERE IdAdmyAseg='$IdAdm'";
			     $result2 = mysql_db_query($db,$sql2,$link);
			     while ($row2 = mysql_fetch_array($result2))
				{ if ($row2['num_det']==$num_det)
					{echo "<option value=\"$row2[num_det]\"selected>$row2[num_det]</option>";}
			  	else
					{echo "<option value=\"$row2[num_det]\">$row2[num_det]</option>";}}
			   ?>
                  <option value="Nueva">Nueva</option>
                </select>
              </div></td>
            <td height="7" nowrap><font size="2" face="Arial, Helvetica, sans-serif"> 
              <input name="activprod" type="text" value="<?php echo $row3['activprod'];?>" size="30" maxlength="30">
              </font></td>
            <td align="center" width="171" nowrap><font size="2" face="Arial, Helvetica, sans-serif"> 
              <select name="nombresp" >
                <?php
				
					echo "<option value=\"0\"></option>";
					$sql2 = "SELECT * FROM users WHERE tipo2_usr='T' OR tipo2_usr='A' ORDER BY apa_usr ASC";
			  		$result2=mysql_db_query($db,$sql2,$link);
			  		while ($row2=mysql_fetch_array($result2)) {
						if ($row3['nombresp']==$row2['login_usr'])
							echo "<option value=\"$row2[login_usr]\" selected> $row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
						else
							echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
					}
			   ?>
              </select>
              </font></td>
            <td width="144" nowrap height="7"><div align="center"><strong> <font size="2" face="Arial, Helvetica, sans-serif"> 
                <input name="cronograma" type="text" value="<?php echo $row3['cronograma'];?>">
                </font> </strong></div></td>
            <td height="7" colspan="2" nowrap>&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;SI 
              &nbsp; 
              <input type="radio" name="cumplimiento" value="SI" <?php if ($row3['cumplimiento']=="SI") echo "checked";?>>
              &nbsp;&nbsp;NO 
              <input type="radio" name="cumplimiento" value="NO" <?php if ($row3['cumplimiento']=="NO") echo "checked";?>>
              </font> <div align="center"> </div></td>
            <td height="7" nowrap><font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="observaciones"><?php echo $row3['observaciones'];?></textarea>
              </font></td>
          </tr>
          <tr> 
            <td height="28" colspan="9" nowrap> <div align="center"><br>
                <input name="INSERTAR" type="submit" id="INSERTAR" value="MODIFICAR / INSERTAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="TERMINAR">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </form>
</table>
<p> 
  <?php 
  }?>
</p>
<?php include("top_.php");?>
