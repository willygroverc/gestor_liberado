<?php 
include("conexion.php");
$cad = $dato;
if (isset($insertar))
{	
		session_start();
		$login=$_SESSION["login"];

		$fecas_ac="$Ano-$Mes-$Dia";
		if($selecciona=="nuevo")
		{
		$sql_i = "SELECT MAX(id_ac) AS num_pru FROM acciones WHERE id_acc=$num";
		$result_i = mysql_db_query($db,$sql_i,$link);
		$row_i = mysql_fetch_array($result_i);
		$id_ac=$row_i[num_pru]+1;
		
		$sql="INSERT INTO acciones (id_ac, serie_ac,valor_ac,fecas_ac,num_ac,id_acc,class_ac,id_accionistas) VALUES ('$id_ac','$serie_ac','$valor_ac','$fecas_ac','$num_ac','$num','$class_ac','$num')";
		$sql_bk="INSERT INTO acciones_bk (id_ac, serie_ac,valor_ac,fecas_ac,num_ac,id_acc,class_ac,id_accionistas) VALUES ('$id_ac','$serie_ac','$valor_ac','$fecas_ac','$num_ac','$num','$class_ac','$num')";
		}
		else
		{
			$sql="UPDATE acciones SET serie_ac='$serie_ac', valor_ac='$valor_ac', fecas_ac='$fecas_ac',num_ac='$num_ac', class_ac='$class_ac' WHERE id_acc='$num' AND id_ac='$selecciona'";
		}
		if(mysql_db_query($db,$sql,$link))
			mysql_db_query($db,$sql_bk,$link);
		
		$sql=str_replace("'","´",$sql);
		$sql_log="INSERT INTO accion_log (date_log, acc_log, usr_log, ip_log) VALUES ('".date("Y-m-d")." ".date("H:m:s")."', '$sql', '$login','".$_SERVER['REMOTE_ADDR']."')";
		mysql_db_query($db,$sql_log,$link);
}
if (isset($Terminar))
{
	header("location: accionistas.php");
}
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
				  <td width="10%"><div align="center"><a href="naccionista_mod.php?idcc=<?php echo $row_acc[id_acc] ?> &nom=<?php echo $row_acc[nom_acc] ?>&nac=<?php echo $row_acc[nac_acc] ?>&tel=<?php echo $row_acc[tel_acc] ?>&direc=<?php echo $row_acc[dom_acc] ?>&anio=<?php  $fecha = $row_acc[fecha_acc];
$partes = explode("-", $fecha);
echo $partes[0]; //2007
?>&mes=<?php  $fecha = $row_acc[fecha_acc];
$partes = explode("-", $fecha);
echo $partes[1]; //2007
?>&dia=<?php  $fecha = $row_acc[fecha_acc];
$partes = explode("-", $fecha);
echo $partes[2]; //2007
?>"><!--BORRAR ESTE ENLACE!!!--></div></td>
                </tr>
              </table></td>
          </tr>
    </table>
	<table width="75%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th colspan="7" background="images/main-button-tileR1.jpg">DETALLE DE ACIONES<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
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
    </tr>
    <?php
		$sql = "SELECT * FROM acciones_bk WHERE id_accionistas='$num' ORDER BY id_ac ASC";
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
      <td colspan="7" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
        <div align="center"></div></td>
    </tr>
    <tr> 
      <td height="28" colspan="11" nowrap> <div align="center"><br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="Terminar" value="RETORNAR">
        </div></td>
    </tr>
  </table>
        <input name="num" type="hidden" value="<?php=$num?>">
  
  </form>
  
<script language="JavaScript">
<!-- 
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}			

		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>

function irapagina_c(pagina){        
     	 	self.location = pagina;
 		 }
function cambia(numero)
{        

		var num="<?php echo $num;?>";
		if (numero == "nuevo") {irapagina_c("naccionista_det.php?num="+num);}
		else {irapagina_c("naccionista_det.php?np="+numero+"&num="+num);}
}
//-->
</script>
<?php include("top_.php");?>
