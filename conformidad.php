<?php
/////DESCRIPCION: ESTE ARCHIVO HA SIDO  MODIFICADO PARA SANEAR LA ENTRADA DE DE DATOS PARA ARAQUES XSS  DE TIPO ALERT
/////AUTOR: ALVARO RODRIGUEZ
/////FECHA: 12'09'2012
if (isset($retornar))
{	//
	if($tipificacion == 1)
	{
		 header("location: lista_tipos.php?pg=$pg"); 
	}else
	{
		 header("location: lista.php?pg=$pg"); 
	}//
}
ini_set("error_reporting", "E_ALL & ~E_NOTICE & ~E_WARNING");
if (isset($reg_form))
{
	session_start();
	$login=$_SESSION["login"];
	if (!isset($login)) {
		header("location: index.php"); 
	}
	$obscli_conf = strip_tags($obscli_conf);
	include ("conexion.php");
	$sql3="INSERT INTO ".
	"conformidad (id_orden,fecha_conf,hora_conf,tiemposol_conf,calidaten_conf,obscli_conf,reg_conf, tipo_conf)".
	"VALUES('$id_orden','".date("Y-m-d")."','".date("H:i:s")."','$tiemposol_conf','$calidaten_conf','$obscli_conf', '$login',  '$tipo_conf')";
	if (mysql_db_query($db,$sql3,$link))
	{
	    if($tipificacion == 1)
		{
			header("location: lista_tipos.php?pg=$pg"); 
		}else
		{
			header("location: lista.php?pg=$pg"); 
		}
	}		
	else {
		$msg="OCURRIO UN ERROR MIENTRAS CONECTABA<br> ".mysql_error() ;
		if (mysql_errno()==1062)
			$msg= "YA SE HA EMITIDO LA CONFORMIDAD PARA ESTE REGISTRO";
	}
}
//desde
if (isset($anidar))
{
	session_start();
	$login=$_SESSION["login"];
	if (!isset($login)) {
		header("location: index.php"); 
	}
	include ("conexion.php");
	$sql3="INSERT INTO ".
	"conformidad (id_orden,fecha_conf,hora_conf,tiemposol_conf,calidaten_conf,obscli_conf,reg_conf, tipo_conf)".
	"VALUES('$id_orden','".date("Y-m-d")."','".date("H:i:s")."','$tiemposol_conf','$calidaten_conf','$obscli_conf', '$login',  '$tipo_conf')";
	if (mysql_db_query($db,$sql3,$link)) {
	    header("location: lista.php"); 
	}		
	else {
		$msg="OCURRIO UN ERROR MIENTRAS CONECTABA<br> ".mysql_error() ;
		if (mysql_errno()==1062)
			$msg= "YA SE HA EMITIDO LA CONFORMIDAD PARA ESTE REGISTRO";
	}
	
	//header("location: anidar_orden.php?id_orden=$id_orden");
	$sqlTmp="SELECT desc_inc FROM ordenes WHERE id_orden=$id_orden";
	$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
	$obs = $ordenTmp[desc_inc];
	
	if($tipificacion == 1)
	{
		header("location: anidar_orden.php?id_orden=$id_orden&obs=$obs&tipificacion=1&pg=$pg");
	}else{
		header("location: anidar_orden.php?id_orden=$id_orden&obs=$obs&pg=$pg");
	}
}
//hasta
include ("conexion.php");
$sqlSystem = "SELECT nombre, mail, web, conformidad, web,mail_institucion FROM control_parametros";
$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
if (isset($reg_form2) && ($systemData[conformidad]==2 || $systemData[conformidad]==3))
{
	$sqlTmp="SELECT cod_usr, desc_inc, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha, time FROM ordenes WHERE id_orden=$id_orden";
	$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
	if($ordenTmp[cod_usr]!="SISTEMA") {
		$sqlCliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$ordenTmp[cod_usr]'";
		$ordenCliente=mysql_fetch_array(mysql_db_query($db, $sqlCliente, $link));
		$clienteNombre=$ordenCliente[nom_usr].' '.$ordenCliente[apa_usr].' '.$ordenCliente[ama_usr];
		}
	else {
		$msg="Esta orden ha sido generado por el SISTEMA y no puede ser notificado por correo electronico.\n\nMensaje generado por GesTor F1.";//$clienteNombre="SISTEMA";
		header("location: lista.php?msg=$msg"); 
		exit;
		}
	//******************************************
		if ( !(empty($ordenCliente[email])))
		{
			$asunto = "Nro. $id_orden. Solicitud de Conformidad de Orden de Mesa de Ayuda";	
			$mail = $ordenCliente[email];
			$mensaje = "
	Solicitud de Conformidad de Orden de Mesa de Ayuda: Nro. $id_orden <br>
	Fecha de envio: $ordenTmp[fecha] $ordenTmp[time] <br>
	Descripcion: $ordenTmp[desc_inc] <br>
	Por favor, ingrese su conformidad.<br>
Para mayores detalles, consulte el Sistema GesTor F1. $systemData[nombre]";
			$tunombre = $systemData[nombre];		
			$tuemail  = $systemData[mail_institucion];												
			$headers = "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			$headers .= "From: $tunombre <$tuemail>\r\n"; 						

			if(!mail($mail,$asunto,$mensaje,$headers))
			{ $msg ="Precaucion, no se ha podido enviar la orden por correo electronico al Cliente.";}																
				
		}//end isset si correo no es vacio
		else {	$msg ="Precaucion, no se ha podido enviar la orden por correo electronico al Cliente. El Usuario no tiene registrado su cuenta de correo";  }
	
	//**************************************************	
		header("location: lista.php?msg=$msg"); 
		exit;
	}	
//}
include("top.php");
$sql4="SELECT * FROM conformidad WHERE id_orden='$id_orden'";
$result4=mysql_db_query($db,$sql4,$link);
$row=mysql_fetch_array($result4);
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
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "obscli_conf",  "Observaciones del cliente, $errorMsgJs[empty]" );
echo $valid->toHtml ();
?>
<form action="<?php echo $PHP_SELF ?>" method="post" name="form1" onKeyPress="return Form()">
<input name="tipificacion" type="hidden" value="<?php=$tipificacion?>">
<input name="pg" type="hidden" value="<?php=$pg?>">

 <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
   <tr bgcolor="#0000CC"> 
    	<th background="images/main-button-tileR1.jpg" height="20"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF">CONFORMIDAD Y OBSERVACIONES DEL CLIENTE</font></th>
   </tr>
   <tr> 
      <td><table width="90%" border="0" align="center" cellpadding="0" cellspacing="4">
          <tr align="center"> 
            <td colspan="2"><strong> <font size="2" face="Arial, Helvetica, sans-serif">Nro 
              Orden de Trabajo : 
              <input name="id_orden" type="text" id="num_form26" value="<?php echo $id_orden;?>" size="11" readonly="">
              <br>
              Descripcion: </font></strong> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php $sqlTmp="SELECT desc_inc FROM ordenes WHERE id_orden=$_GET[id_orden]";
				$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
				print $ordenTmp[desc_inc];
				?>
              </font> <hr> </td>
          </tr>
          <tr> 
            <td height="64" colspan="2"> <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr align="center" bgcolor="#006699">
                  <th colspan="6" background="images/main-button-tileR1.jpg" height="20">SEGUIMIENTO</th>
                <tr align="center" bgcolor="#006699"> 
                  <td width="25" class="menu" background="images/main-button-tileR1.jpg">Nro</td>
                  <td width="160" class="menu" background="images/main-button-tileR1.jpg">REALIZADO POR</td>
                  <td width="103" class="menu" background="images/main-button-tileR1.jpg">ESTADO</td>
                  <td width="300" class="menu" background="images/main-button-tileR1.jpg">OBSERVACIONES</td>
                  <td width="79" class="menu" background="images/main-button-tileR1.jpg">FECHA</td>
                  <td width="65" class="menu" background="images/main-button-tileR1.jpg">HORA</td>
                </tr>
                <?php 
		    $sql="SELECT *, DATE_FORMAT(fecha_seg, '%d/%m/%Y') AS fecha_seg FROM seguimiento WHERE id_orden='$id_orden' ORDER BY fecha_seg ASC, hora_seg ASC";
		    $result=mysql_db_query($db,$sql,$link);
			$c=1;
			while($row=mysql_fetch_array($result)) 
	  		{?>
                <tr align="center"> 
                  <td width="25"><?php echo $c++;?></td>
                  <td width="160"> 
                    <?php 
			$sql2="SELECT * FROM users WHERE login_usr='$row[login_usr]'";
			$result2=mysql_db_query($db,$sql2,$link);
		  	$row2=mysql_fetch_array($result2);
			echo $row2[nom_usr]." ".$row2[apa_usr]." ".$row2[ama_usr];
			?>
                  </td>
                  <td width="103"> 
                    <?php 
			if ($row[estado_seg]=="1")
			{echo "Cumplida en fecha";}
			if ($row[estado_seg]=="2")
			{echo "Cumplida retrasada";}
			if ($row[estado_seg]=="3")
			{echo "Pendiente en fecha";}
			if ($row[estado_seg]=="4")
			{echo "Pendiente retrasada";}
			if ($row[estado_seg]=="5")
			{echo "Desestimada";}
			?>
                  </td>
                  <td width="300"><?php echo $row[obs_seg];?></td>
                  <td width="79"><?php echo $row[fecha_seg];?> </td>
                  <td width="65"><?php echo $row[hora_seg];?> </td>
                  <?php }?>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="83" colspan="2"> <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr align="center" bgcolor="#006699"> 
                  <th colspan="7" background="images/main-button-tileR1.jpg">SOLUCION</th>
                <tr align="center" bgcolor="#006699"> 
                  <td width="4%" class="menu" background="images/main-button-tileR1.jpg">FECHA DE EJECUCION</td>
                  <td width="4%" class="menu" background="images/main-button-tileR1.jpg">FECHA Y HORA DE REGISTRO</td>
                  <td width="17%" class="menu" background="images/main-button-tileR1.jpg">SOLUCIONADO POR</td>
                  <td width="40%" class="menu" background="images/main-button-tileR1.jpg">DETALLES DE LA SOLUCION</td>
                  <td width="35%" class="menu" background="images/main-button-tileR1.jpg">MEDIDAS PREVENTIVAS RECOMENDADAS</td>
                </tr>
                <?php 
		    	$sql="SELECT *, DATE_FORMAT(fecha_sol, '%d/%m/%Y') AS fecha_sol, DATE_FORMAT(fecha_sol_e, '%d/%m/%Y') AS fecha_sol_e FROM solucion WHERE id_orden='$id_orden' ORDER BY fecha_sol ASC, hora_sol ASC";
		    	$result=mysql_db_query($db,$sql,$link);
				while($row=mysql_fetch_array($result)) 
	  			{?>
                <tr align="center"> 
                  <td><?php echo $row[fecha_sol_e];?></td>
                  <td><?php echo $row[fecha_sol]." ".$row[hora_sol];?></td>
                  <td> 
                    <?php 
				$sql2="SELECT * FROM users WHERE login_usr='$row[login_sol]'";
				$result2=mysql_db_query($db,$sql2,$link);
		  		$row2=mysql_fetch_array($result2);
				echo $row2[nom_usr]." ".$row2[apa_usr]." ".$row2[ama_usr];
				?>
                  </td>
                  <td><?php echo $row[detalles_sol];?></td>
                  <td><?php echo $row[medprev_sol];?></td>
                </tr>
                <tr align="left"> 
                  <td colspan="5" align="left"> <br> 
                    <?php 
						if (!$row[nomb_archivo]){echo "<div align=\"left\"><font face=\"arial,helvetica\" size=\"2\"><strong>ARCHIVO ADJUNTO : </strong>Ninguno</font></div>";}
						else {echo"<div align=\"left\"><font face=\"arial,helvetica\" size=\"2\"><strong>Archivo Adjunto : </strong><a href=\"archivos adjuntos/".$row[nomb_archivo]."\" target=\"_blank\">$row[nomb_archivo]</a></font></div>";}
	        	    ?>
                  </td>
                </tr>
                <?php }?>
              </table>
              <br> </td>
          </tr>
          <tr>
            <td> <table width="100%" border="1">
                <tr align="center" bgcolor="#006699">
                  <th width="691" colspan="2" background="images/main-button-tileR1.jpg">CONFORMIDAD DEL CLIENTE</th>
                </tr>
              </table>
          <tr> 
            <td height="207"> <table width="100%" border="0">
                <tr> 
                  <td width="223" height="34"><strong>FECHA : <?php echo date("d/m/Y");?> 
                    </strong></td>
                  <td width="235"><strong>HORA : <?php echo date("H:i:s");?> </strong></td>
                  <td width="228"></td>
                </tr>
                <tr> 
                  <td><font size="1" face="Arial, Helvetica"> Tiempo de solucion:</font> 
                    <select name="tiemposol_conf" id="select7">
                      <option value="1">1 (Malo)</option>
                      <option value="2" selected>2 (Bueno) </option>
                      <option value="3">3 (Excelente)</option>
                    </select> </td>
                  <td>Calidad de atencion: <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <select name="calidaten_conf" id="select8">
                      <option value="1">1 (Malo)</option>
                      <option value="2" selected>2 (Bueno)</option>
                      <option value="3">3 (Excelente)</option>
                    </select>
                    </font></td>
                  <td><font size="1" face="Arial, Helvetica, sans-serif">Tipo 
                    de conformidad:</font> 
					<select name="tipo_conf" id="select8">
                      <option value="1" selected>1 (Conforme)</option>
                      <option value="2">2 (Disconforme)</option>
                    </select> </td>
                </tr>
                <tr> 
                  <td colspan="3"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif"><br>
                      Observaciones del Cliente</font></strong></div></td>
                </tr>
                <tr> 
                  <td colspan="3"> <div align="center"><strong> 
                      <textarea name="obscli_conf" cols="80" rows="4" id="textarea3"><?php echo $row[obscli_conf];?></textarea>
                      </strong> </div></td>
                </tr>
                <tr align="center"> 
                  <td height="26" colspan="3"> <input name="reg_form" type="submit" value="GUARDAR" <?php echo $valid->onSubmit(); ?>>
                      <input name="anidar" type="submit" value="ANIDAR ORDEN" <?php echo $valid->onSubmit(); ?>> 
                    <?php if(($tipo=="A" || $tipo=="B") && ($systemData[conformidad]==2 || $systemData[conformidad]==3)){ ?>
                    <input name="reg_form2" type="submit" value="ENVIAR MAIL"> 
                    <?php } ?>
                    <input name="retornar" type="submit" id="retornar2" value="RETORNAR"> 
                  </td>
                </tr>
              </table>
          <tr>
            <td height="19"></table></td>
    </tr>
  </table>
</form>
<script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>;
</script>
<?php include("top_.php");?>