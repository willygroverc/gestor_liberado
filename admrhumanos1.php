<?php if (isset($_REQUEST['Terminar']))
header("location: lista_admyaseg.php");
?>
<?php
if (isset($_REQUEST['INSERTAR']))
{   include("conexion.php");
                $var=$_REQUEST['var'];
                $var2=$_REQUEST['var2'];
                $activprod=$_REQUEST['activprod'];
                $nombresp=$_REQUEST['nombresp'];
                $cronograma=$_REQUEST['cronograma'];
                $cumplimiento=$_REQUEST['cumplimiento'];
		$sql2 = "SELECT MAX(IdActividad) AS ID FROM admyasegactiv WHERE IdAdmyAseg='$var' AND Tipo='$var2'";

		$result2=mysql_db_query($db,$sql2,$link);
  		$row2=mysql_fetch_array($result2);
		$num_det=$row2['ID']+1;
		
		$sql5 = "SELECT MAX(num_det) AS num FROM admrhdet WHERE IdAdmyAseg='$var'";

		$result5=mysql_db_query($db,$sql5,$link);
		$row5=mysql_fetch_array($result5); 
		$num_det=$row5['num']+1;	
	if ($cumplimiento=="") {$cumplimiento="NO";}
	$sql="INSERT INTO ".
	"admrhdet (activprod,nombresp,cronograma,IdAdmyAseg,num_det,Tipo) ".
	"VALUES ('$activprod','$nombresp','$cronograma','$var','$num_det','$var2')";
	mysql_db_query($db,$sql,$link);

	header("location: admrhumanos1.php?variable1=$var&variable2=$var2");
}
else { 
include("top.php");
$IdAdm=($_GET['variable1']);
$Tip=($_GET['variable2']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "activprod",  "Actividades/Productos, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "nombresp",  "Nombre Responsables, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "cronograma",  "Cronograma, $errorMsgJs[expresion]" );
echo $valid->toHtml ();
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
<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
    <input name="var" type="hidden" value="<?php echo $IdAdm;?>">
	<input name="var2" type="hidden" value="<?php echo $Tip;?>">
    <tr> 
      <td height="180"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <td colspan="7"> <table width="100%">
                <tr> 
                  <?php  $sql4 = "SELECT * FROM admyasegdatos WHERE IdAdmyAseg='$IdAdm' AND Tipo='$Tip'";
				$result4=mysql_db_query($db,$sql4,$link);
				$row4=mysql_fetch_array($result4); ?>
                  <td width="77%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Tipo 
                    de formulario :&nbsp;<?php echo $Tip?></font></td>
                  <td width="23%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Numero 
                    de Formulario : <?php echo $IdAdm?></font></td>
                </tr>
              </table>
              <table width="100%">
                <tr> 
                  <td height="20"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Nombre 
                    del proyecto : <?php echo $row4['NombProy']?></font></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <th colspan="7" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">ADMINISTRACION 
              DE RECURSOS HUMANOS</font></th>
          </tr>
          <tr align="center"> 
            <th width="71" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro. 
              Activ. </font></th>
            <th width="201" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Actividades 
              / Productos</font></th>
            <th width="252" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Nombre 
              Responsables</font></th>
            <th colspan="2" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Cronograma</font></th>
          </tr>
          <?php
			
		$sql = "SELECT * FROM admrhdet WHERE IdAdmyAseg='$IdAdm' AND Tipo='$Tip'";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <td align="center">&nbsp;<?php echo $row['num_det']?></td>
            <td align="center">&nbsp;<?php echo $row['activprod']?></td>
            <td><div align="center">&nbsp;<?php 
				$cons1="SELECT * FROM users WHERE login_usr='$row[nombresp]'";
				$resp1=mysql_db_query($db,$cons1,$link);
				$fila1=mysql_fetch_array($resp1);
				echo $fila1['nom_usr']."&nbsp;".$fila1['apa_usr']."&nbsp;".$fila1['ama_usr'];
				?></div></td>
            <td width="225"><div align="center">&nbsp;<?php echo $row['cronograma']?></div></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="7" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td height="7" nowrap bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nuevo</font></div></td>
            <td height="7" nowrap><input name="activprod" type="text" size="30" maxlength="30"></td>
            <td align="center" width="252" nowrap>
                <select name="nombresp">
                  <option value="0"></option>
                  <?php 
			  		$sql3 = "SELECT * FROM users WHERE tipo2_usr='T' OR tipo2_usr='A' ORDER BY apa_usr ASC";
			  		$result3 = mysql_db_query($db,$sql3,$link);
			  		while ($row3 = mysql_fetch_array($result3)) 
					{
					echo "<option value=\"$row3[login_usr]\">$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";
	            	}
			   		?>
                </select>
              </p>
              </td>
            <td height="7" colspan="2" nowrap> <div align="center"><strong> 
                <input type="text" name="cronograma">
                </strong></div></td>
          </tr>
          <tr> 
            <td height="49" colspan="7" nowrap> 
              <div align="center"><br>
                <input name="INSERTAR" type="submit" id="INSERTAR" value="INSERTAR DATOS" <?php print $valid->onSubmit() ?>>
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
