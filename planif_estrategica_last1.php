<?php
include("conexion.php");
if(isset($guardar)){
	$sql_up="UPDATE planif_estrategica SET ObjNegocio='$ObjNegocio' WHERE TipoPlanifica='$tip' AND NumPlanif='$numer'";
	mysql_db_query($db,$sql_up,$link);
	header("location: actividades_pre_last.php?tip=$tip&numer=$numer&ObjNegocio=$ObjNegocio");
}
include("top.php");
$sql3 = "SELECT * FROM planif_estrategica WHERE TipoPlanifica='$varia2' AND NumPlanif='$varia3' LIMIT 1";
$result3 = mysql_db_query($db,$sql3,$link);
$row3 = mysql_fetch_array($result3);
?>
<form name="form1" method="post" action="">
  <input name="tip" type="hidden" id="tip" value="<?php=$varia2?>">
  <input name="numer" type="hidden" id="numer" value="<?php=$varia3?>">
  <table width="60%" border="1" align="center" background="images/fondo.jpg" >
  <tr> 
    <td width="30%" bgcolor="#006699" > <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBJETIVO 
        DE NEGOCIO</font></div></td>
  </tr>
  <tr> 
    <td width="30%"  > <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
          <textarea name="ObjNegocio" cols="70"><?php echo $row3[ObjNegocio];?></textarea>
        </font></div></td>
  </tr>
</table>
  <div align="center"><br>
    <input name="guardar" type="submit" id="guardar" value="GUARDAR Y CONTINUAR">
  </div>
</form>
<?php
include("top_.php");
?>