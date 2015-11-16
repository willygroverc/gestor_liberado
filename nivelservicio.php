<?php include("top.php");?>
<?php
if (isset($reg_form))
{
	$sql3="INSERT INTO ".
	"ACUERDO (id_reA,descripcion,,tiempo,horario,vigencia) ".
	"VALUES('$id_reA','$descripcion','$tiempo','$horario','$vigencia')";
	mysql_db_query($db,$sql3,$link);
	
}
if($elimina==1)
{
	$sqld="DELETE FROM ACUERDO WHERE id_reA=$id_reA";
	mysql_db_query($db,$sqld,$link);
}
$elimina=0;
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
  <table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#EAEAEA"  background="images/fondo.jpg">  
    <form name="form2" method="post" action="<?php=$PHP_SELF ?> " onKeyPress="return Form()">
	<tr> 
      <td>
        <table border="2" align="center" cellpadding="2" cellspacing="4">
            <tr bgcolor="#006699"> 
              <th colspan="5"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">ACUERDO 
                DE NIVEL DE SERVICIO</font></th>
            </tr>
            <tr align="center"> 
              <td colspan="5"><strong>&nbsp;Nro A. N. de R. : 
                <input name="id_reA" type="text" value="<?php echo $id_reA;?>" size="11" readonly="">
                </strong></td>
            </tr>
            <tr bgcolor="#006699"> 
              <th width="32" nowrap><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">No</font></th>
              
            <th nowrap width="286"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Descripcion</font></th>
              <th nowrap width="76"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Responsabilidad/Pre     Requisitos</font></th>
              <th nowrap width="70"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Tiempo</font></div></th>
			  <th nowrap width="70"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Horario</font></div></th>
              <th width="55" nowrap> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Vigencia</font></div></th>
            </tr>
            <?php
		//$sql = "SELECT * FROM form,clientes,problema,asignacion where cod_cli_form=cod_cli AND num_form=num_form_prob AND num_form=num_form_asig ORDER BY fecha_form DESC, time_form DESC";
		//$sql2 = "SELECT SUM(vigencia) AS total_cos FROM acuerdo where id_reA='$id_reA'";
		//$result2=mysql_db_query($db,$sql2,$link);
		//$row2=mysql_fetch_array($result2); 
	
		$sql = "SELECT * FROM acuerdo where id_reA='$id_reA' ORDER BY id_reA ASC";
		$result=mysql_db_query($db,$sql,$link);
		$c=1;
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
            <tr> 
              <td>&nbsp;<?php echo "Rec".$c++?></td>
              <td>&nbsp;<?php echo $row[descripcion]?></td>
              <td><div align="right">&nbsp;<?php echo $row[tiempo_acu]?></div></td>
              <td><div align="right">&nbsp;<?php echo $row[horario]?></div></td>
              <td><div align="right">&nbsp;<?php echo $row[vigencia]?></div></td>
            </tr>
            <?php
		 }
		 ?>
            <tr> 
              <td colspan="3" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
              <td width="70" nowrap height="7"> <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Total 
                  Bs.</font></div></td>
			
              <td width="70" nowrap height="7"> <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Total 
                  Bs.</font></div></td>
				  
			  <td width="70" nowrap height="7"> <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Total 
                  Bs.</font></div></td>
				 		
             <td width="55" bgcolor="#006699" nowrap height="7"> <div align="right"><strong><font color="#FFFFFF"><?php echo $row2[total_cos];?></strong></strong></div></td>
            

			</tr>
            <tr> 
              <td width="32" bgcolor="#006699" nowrap height="7"><strong><font size="1" color="#FFFFFF" face="Arial, Helvetica, sans-serif" >Nuevo</font></strong></td>
              <td width="286" nowrap height="7"> <input name="descripcion" type="text" id="obs_seg2" value="" size="55"> 
              </td>
              <td width="76" nowrap height="7"><strong> 
                <input name="tiempo_acu" type="text" id="estado_seg4" size="10">
                </strong></td>
              <td width="70" nowrap height="7"> <div align="center"><strong> 
                  <input name="horario" type="text" id="estado_seg3" size="10">
                  </strong></div></td>
              <td width="55" nowrap height="7">&nbsp; </td>
            </tr>
            <tr> 
              <td colspan="5" nowrap> <div align="center"> 
                  <input name="reg_form" type="submit" id="reg_form" value="ANADIR">
                </div></td>
            </tr>
          </table>
      </td>
    </tr></form>
  </table>
<br>
<?php include("top_.php");?>