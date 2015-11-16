<?php 
include("conexion.php");
$cad = $dato;
include("top.php");
$id_minuta=($_GET['id_minuta']);
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "serie_ac",  "Descripcion de la Prueba,  $errorMsgJs[empty]" );
$valid->addLength ( "desc_pru",  "Descripcion de la Prueba,  $errorMsgJs[length]" );
$valid->addFunction ( "validaTiempo2",  "" );
//$valid->addIsNotEmpty ( "tiem_est",  "Tiempo Estimado, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "obs_pru",  "Observaciones,  $errorMsgJs[empty]" );
$valid->addLength ( "obs_pru",  "Observaciones,  $errorMsgJs[length]" );
print $valid->toHtml ();
?>  
<script language="JavaScript" src="calendar.js"></script>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
	background-color:#FFFFFF
}
-->
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
				$sql_acc="SELECT * FROM accionistas WHERE id_acc = '$aux'";
				//echo $sql_acc."<br>";
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
	<table width="75%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th colspan="11" background="images/main-button-tileR1.jpg">DETALLE DE ACIONES<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
        </font></th>
    </tr>
    <tr> 
      <th nowrap background="images/main-button-tileR2.jpg" width="8%"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">N&ordm; cambio estado </font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nro. de Titulo y Serie de la Accion</font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Valor Nominal </font></th>
      <th nowrap background="images/main-button-tileR2.jpg" width="13%"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Fecha de Asiento </font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Numero de <br>Acciones del Titulo</font></th>
	  <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Valor Total de Acciones<br>(en Bolivianos)</font></th>
	  <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Clase</font></th>
	  <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA - HORA</font></th>
	  <th nowrap background="images/main-button-tileR2.jpg" width="30%"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">OBSERVACIONES</font></th>
    </tr>
    <?php
		//$sql = "Select * from acciones_bk where (acciones_bk.id_acciones not in (select transferencia.id_acc from transferencia)) AND id_accionistas='$num'";
		$cuenta=0;
		$sql = "Select * from acciones AS a , gravamenes AS b where a.id_acciones=b.id_acciones AND a.id_acciones='$num'";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		$cuenta++;
		?>
		<tr align="center"> 
		  <td>&nbsp;<?php echo "$cuenta";?></td>
		  <td>&nbsp;<?php echo $row[serie_ac]?></td>
		  <td>&nbsp;<?php echo number_format($row[valor_ac],2,'.',',');?></td>
		  <td>&nbsp;<?php echo $row[fecas_ac]?></td>
		  <td>&nbsp;<?php echo number_format($row[num_ac],0,'.',',')?></td>
		  <?php
		  $sb_total=$row[valor_ac]*$row[num_ac];
		  ?>
		  <td>&nbsp;<?php echo number_format($sb_total,2,'.',',')?></td>
		  <td>&nbsp;<?php echo $row[class_ac]?></td>
		  <?php
		    $sql_us="SELECT * FROM `transferencia` WHERE id_acc = '$row[id_acciones]'";
		  //echo "<br>";
		  //echo $sql_us;
		$res_us=mysql_query($sql_us);
		$row_us=mysql_fetch_array($res_us);
		//echo "<script>alert('$row[id_acciones]');</script>";
		  ?>
		  <td>&nbsp;<?php echo "$row[fecha]";?></td>
		  <td>&nbsp;<?php echo "$row[observaciones]";?></td>
		</tr>
		<?php 
		 }
	?>

    <tr> 
      <td colspan="11" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
        <div align="center"></div></td>
    </tr>
    <tr> 
      <td height="28" colspan="11" nowrap> <div align="center"><br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <a href="javascript:history.back(1)"><< Atras</a>
        </div></td>
    </tr>
  </table>
        <input name="num" type="hidden" value="<?php=$num?>">
  
  </form>
<?php include("top_.php");?>
