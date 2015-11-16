<?php 
if (isset($Terminar))  {
	if($viene=="agenda_last")
		header("location: agenda_last.php?id_agenda=$var&verif=1");
	else 
		header("location: agenda.php?id_agenda=$var&verif=1");	
}
include("conexion.php");
if (isset($reg_form))
{   
	if ($id_tem=="NUEVA")
	{	$sql34 = "SELECT MAX(id_tema) AS ntem FROM temas WHERE id_agenda='$var'";
		$result34=mysql_db_query($db,$sql34,$link);
		$row34=mysql_fetch_array($result34) ;
		$cont=$row34['ntem']+1;
	require_once('funciones.php');
	$var=_clean($var);
	$tema=_clean($tema);
	$responsable=_clean($responsable);
	$duracion=_clean($duracion);
	$cont=_clean($cont);
	
	$var=SanitizeString($var);
	$tema=SanitizeString($tema);
	$responsable=SanitizeString($responsable);
	$duracion=SanitizeString($duracion);
	$cont=SanitizeString($cont);
	$sql1="INSERT INTO ".
	"temas (id_agenda,tema,responsable,duracion,id_tema) ".
	"VALUES ('$var','$tema','$responsable','$duracion','$cont') ";
	mysql_db_query($db,$sql1,$link);
	header("location: tema.php?id_agenda=$var");
	}
	else
	{$sql1="UPDATE temas SET tema='$tema',responsable='$responsable',duracion='$duracion'".
		"WHERE id_agenda='$var' AND id_tema='$id_tem'";
	  mysql_db_query($db,$sql1,$link);
	 header("location: tema.php?id_agenda=$var");
	}
}
else { 
include("top.php");
$id_agenda=($_GET['id_agenda']);
$id_tema=($_GET['id_tema']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "tema",  "Tema, $errorMsgJs[empty]" );
$valid->addLength ( "tema",  "Tema, $errorMsgJs[length]" );
$valid->addIsNotEmpty ( "responsable",  "Responsable, $errorMsgJs[empty]" );
$valid->addIsNumber( "duracion",  "Duracion, $errorMsgJs[number]" );
print $valid->toHtml ();
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

  <table width="59%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_agenda;?>">
	<input name="var2" type="hidden" value="<?php echo $id_tema;?>">
	<input name="viene" type="hidden" value="<?php echo $viene;?>">

	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="8" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              TEMAS PROPUESTOS</font></th>
          </tr>
          <tr> 
            <th width="44" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="275" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">TEMA</font></th>
            <th width="125" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">RESPONSABLE</font></th>
            <th width="118" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">DURACION(min)</font></th>
          </tr>
          <?php
	    $cont=0;			
		$sql = "SELECT * FROM temas WHERE id_agenda='$id_agenda' ";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		?>
          <tr> 
            <?php echo "<td><a href=\"tema.php?id_agenda=$id_agenda&id_tema=".$row[id_tema]."&viene=$viene\">".$row[id_tema]."</a></td>";?> 
            <td><?php echo $row[tema]?></td>
            <?php
			$sql5 = "SELECT * FROM users WHERE login_usr='$row[responsable]'";
		    $result5 = mysql_db_query($db,$sql5,$link);
		    $row5 = mysql_fetch_array($result5);
			if ($row5){
				echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
			}
			else {
				echo "<td>&nbsp;$row[responsable]</td>";
			}
			?>
			<td>&nbsp;<?php echo $row[duracion]?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="8" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr>
		  <?php $sql3 = "SELECT * FROM temas WHERE id_tema='$id_tema' AND id_agenda='$id_agenda'";
		  	 $result3 = mysql_db_query($db,$sql3,$link);
	      	 $row3 = mysql_fetch_array($result3)?>

            <td width="44" height="7" nowrap> 
              <select name="id_tem">
			   <option value="NUEVA">NUEVA</option>
				<?php 
				 $sql2 = "SELECT * FROM temas WHERE id_agenda='$id_agenda'";
			     $result2 = mysql_db_query($db,$sql2,$link);
			     while ($row2 = mysql_fetch_array($result2)) 
				{   if ($row2[id_tema]==$id_tema)
				{echo "<option value=\"$row2[id_tema]\" selected>$row2[id_tema]</option>";}
			  else
				{echo "<option value=\"$row2[id_tema]\">$row2[id_tema]</option>";}}
			   ?>
               </select>
            </td>

   			<td width="275" nowrap><div align="center"><strong>
                <textarea name="tema" cols="40"><?php echo $row3['tema']?></textarea>
                </strong></div></td>
            <td width="125" nowrap><div align="center"><strong> 
                <select name="responsable" id="select">
                  <option value="0"></option>
                  <?php 
			  $sql0 = "SELECT * FROM users WHERE tipo2_usr<>'B' ORDER BY apa_usr ASC";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
						if ($row3[responsable]==$row0[login_usr])
							echo "<option value=\"$row0[login_usr]\" selected>$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
						else
							echo "<option value=\"$row0[login_usr]\">$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
				
                }
				
				echo "<option value=\"0\"></option>";
				echo "<option value=\"0\">INVITADOS EXTERNOS</option>";
				echo "<option value=\"0\"></option>";
				
				$sqlx = "SELECT * FROM invitados WHERE id_agenda='$id_agenda' and tipo='Externo' ";
				$resultx=mysql_db_query($db,$sqlx,$link);
				while($rowx=mysql_fetch_array($resultx)) 
				{
						if ($row3[responsable]==$rowx[nombre])
							echo "<option value=\"$rowx[nombre]\" selected>$rowx[nombre]</option>";
						else
							echo "<option value=\"$rowx[nombre]\">$rowx[nombre]</option>";
				
                }
			   ?>
                </select>
                </strong></div></td>
            <td width="118" nowrap height="7"><div align="center"><strong> 
                <input name="duracion" type="text" size="3" maxlength="4" value="<?php echo $row3['duracion']?>">
                <font size="2" face="Arial, Helvetica, sans-serif">Min.</font></strong> </div></td>
          </tr>
          <tr> 
            <td height="28" colspan="8" nowrap> <div align="center"> 
                <input name="reg_form" type="submit" value="INSERTAR / MODIFICAR DATOS" <?php print $valid->onSubmit() ?>>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<p> 
  <?php } ?>
</p>
<?php include("top_.php");?>
