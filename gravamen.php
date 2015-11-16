<?php 
include("conexion.php");
$cad = $dato;
if(isset($RETORNAR)) header("location: accionistas.php");
include("top.php");
$id_minuta=($_GET['id_minuta']);
?>  
<script language="JavaScript" src="calendar.js"></script>
<style type="text/css">
</style>
  <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<table width="75%" border="1" align="center" background="images/fondo.jpg">
          <tr> 
            
      <th background="images/main-button-tileR1.jpg">DATOS DEL ACCIONISTA
	  </th>
          </tr>
          <tr> 
            <td height="52"><table width="100%" border="0">
                <tr> 
				<?php
				$sql_acc="SELECT * FROM accionistas WHERE id_acc = '$num'";
				$res_acc=mysql_db_query($db,$sql_acc,$link);
				$row_acc=mysql_fetch_array($res_acc);
				?>
                  <td width="2%">&nbsp;</td>
                  <td><font size="2"><strong>Nombre o Raz&oacute;n Social: </strong></font></td>
                  <td width="42%"><font size="2"><?php echo $row_acc[nom_acc];?></font></td>
                  <td width="17%"><font size="2"><strong>Fecha de Registro:</strong></font></td>
                  <td width="19%"><font size="2">&nbsp;<?php echo $row_acc[fecha_acc]?></font></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td width="20%"><font size="2"><strong>Nacionalidad:</strong></font></td>
                  <td><font size="2"><?php echo $row_acc[nac_acc]?>&nbsp;</font></td>
                  <td><font size="2"><strong>Telefono:</strong></font></td>
				  <td><font size="2">&nbsp;<?php echo $row_acc[tel_acc]?></font></td>
                </tr>
				<tr> 
                  <td>&nbsp;</td>
				  <td width="20%"><font size="2"><strong>Direcci&oacute;n:</strong></font></td>
                  <td><font size="2"><?php echo $row_acc[dom_acc]?>&nbsp;</font></td>
				  <td><font size="2"><strong>Estado: </strong><?php echo $row_acc[estado]?></font></td>
				  <td width="10%"></td>
                </tr>
              </table></td>
          </tr>
    </table>
        <input name="num" type="hidden" value="<?php=$num?>">
  <table width="75%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th colspan="9" background="images/main-button-tileR1.jpg">DETALLE DE ACIONES<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
        </font></th>
    </tr>
    <tr> 
      <th nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">N&ordm; de Partida </font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nro. de Titulo y Serie de la Accion</font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Valor Nominal </font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Fecha de Asiento </font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Numero de <br>Acciones del Titulo</font></th>
	  <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Valor Total de Acciones<br>(en Bolivianos)</font></th>
	  <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Clase</font></th>
	  <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Gravamen</font></th>
	  <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Historico de gravamen</font></th>
    </tr>
    <?php
		$sql = "SELECT * FROM acciones WHERE id_accionistas='$num' ORDER BY id_ac ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
			
	?>
    <tr align="center"> 
      <td>&nbsp;<?php echo "$row[id_ac]";?></td>
      <td>&nbsp;<?php echo $row[serie_ac]?></td>
      <td>&nbsp;<?php echo number_format($row[valor_ac],2,'.',',');?></td>
	  <td>&nbsp;<?php echo $row[fecas_ac]?></td>
	  <td>&nbsp;<?php echo number_format($row[num_ac],0,'.',',')?></td>
	  <?php
	  $sb_total=$row[valor_ac]*$row[num_ac];
	  ?>
	  <td>&nbsp;<?php echo number_format($sb_total,2,'.',',')?></td>
	  <td>&nbsp;<?php echo $row[class_ac]?></td>
	  <td>&nbsp;<?php 
		if($row[estado]=="1")
			echo "<a href=\"gravamen_reg.php?aux=$num&num=".$row['id_acciones']."\"><img src=\"images/ok.gif\"></a>";	
		else
			echo "<a href=\"gravamen_reg.php?aux=$num&num=".$row['id_acciones']."\"><img src=\"images/gravamen.gif\"></a>";
	  ?></td>
	  <td>&nbsp;<?php echo "<a href=\"his_gravamen.php?aux=$num&num=".$row['id_acciones']."\"><img src=\"images/archivodes.gif\"></a>";	?></td>
	</tr>
    <?php 
		 }
	if(!empty($np))
	{		
		$sql_ed = "SELECT * FROM acciones WHERE id_acc='$num' AND id_ac='$np'";
		$result_ed=mysql_db_query($db,$sql_ed,$link);
		$row_ed=mysql_fetch_array($result_ed);
	}
	?>

    <tr> 
      <td colspan="9" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
        <div align="center"></div></td>
    </tr>
    <tr> 
      <td height="28" colspan="11" nowrap> <div align="center">
	  <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
        </div></td>
    </tr>
  </table>     
  </form>
  
<?php include("top_.php");?>
