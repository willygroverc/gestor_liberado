<?php 
	if (isset($_REQUEST['Enviar']))
	{
		header("location: select_forma.php?sel=$select&obs=$obs_seg&id_orden=$id_orden&lug=0");
	}
		
	if (isset($_REQUEST['RETORNAR']))
	{		header("location: lista.php");	}
include("top.php");

$sql_5="SELECT * FROM control_parametros";
		$result_5=mysql_query($sql_5);
		$row_5=mysql_fetch_array($result_5);

if (isset($_REQUEST['reg_form']))
{
	if($_REQUEST['estado_seg']=="1 (Cumplida en fecha)")
	{$es=1;}
	if($_REQUEST['estado_seg']=="2 (Cumplida retrasada)")
	{$es=2;}
	if($_REQUEST['estado_seg']=="3 (Pendiente en fecha)")
	{$es=3;}
	if($_REQUEST['estado_seg']=="4 (Pendiente retrasada)")
	{$es=4;}
	if($_REQUEST['estado_seg']=="5 (Desestimada)")
	{$es=5;}
	$id_orden=$_REQUEST['id_orden'];
        $obs_seg=$_REQUEST['obs_seg'];
    $sql3="INSERT INTO ".
	"seguimiento(id_orden,estado_seg,obs_seg,fecha_seg,hora_seg,login_usr,fecha_rea,usr_archivos,archivos,hash_archi,observ_arch,nomb_archivo)".
	"VALUES('$id_orden','$es','$obs_seg','".date("Y-m-d")."','".date("H:i:s")."','$login','".date("Y-m-d")."','0','0','0','0','0')";

    $NombreUsr=  isset($_REQUEST['NombreUsr']);
    mysql_query($sql3);
	$sqlx = "UPDATE datos_archivos SET replicar='1' WHERE nombre_arch='$NombreUsr'";
	$resultx=mysql_db_query($db,$sqlx,$link);
        //$archivo_name=  isset($_REQUEST['archivo_name']);
	if ($_FILES["archivo"]["name"]<>"")
	{
		$extension = explode(".",$_FILES["archivo"]["name"]); 
		$num = count($extension)-1; 
		
		$sql_6="SELECT max(id_seg) as max_segui FROM seguimiento";
		$result_6=mysql_db_query($db,$sql_6,$link);
		$row_6=mysql_fetch_array($result_6);
		
		$tam_max=1048576*$row_5['tam_archivo'];
		$arch_nomb=$row_6['max_segui'].".".$extension[$num];
		if($_FILES["archivo"]["size"] < $tam_max)
		{
			$sql_2="UPDATE seguimiento SET nomb_archivo='$arch_nomb' WHERE id_orden=$id_orden and id_seg=$row_6[max_segui]";
			mysql_query($sql_2);
			copy($_FILES["archivo"]["tmp_name"],"archivos_segui/".$arch_nomb);
		}
		else
			$msg="EL TAMAÑO DEL ARCHIVO ADJUNTO NO DEBE SER MAYOR A ".$row_5['tam_archivo']." Mb";
	}
	$lug=  isset($var2);
	$sqlaux="select * from control_parametros";
		$resultaux=mysql_db_query($db,$sqlaux,$link);
		$rowaux=mysql_fetch_array($resultaux);
		if ($rowaux['seguimiento']==1 or $rowaux['seguimiento']==4)
		{
		$sqlaux1="SELECT * FROM ordenes WHERE id_orden=$id_orden";
		$resultaux1=mysql_db_query($db,$sqlaux1,$link);
		$rowaux1=mysql_fetch_array($resultaux1);
		$sqlcliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='admin'";
		$ordencliente=mysql_db_query($db,$sqlcliente,$link);
		$rowcli=mysql_fetch_array($ordencliente);
		$clienteNombre=$rowcli['nom_usr'].' '.$rowcli['apa_usr'].' '.$rowcli['ama_usr'];
		$sqlcliente1="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowaux1[cod_usr]'";
		$ordencliente1=mysql_db_query($db,$sqlcliente1,$link);
		$rowcli1=mysql_fetch_array($ordencliente1);
		$clienteNombre1=$rowcli1['nom_usr'].' '.$rowcli1['apa_usr'].' '.$rowcli1['ama_usr'];
		//echo $clienteNombre;
		$sqlasig="select * from asignacion where id_orden=$id_orden";
		$resultasig=mysql_db_query($db,$sqlasig,$link);
		$rowasig=mysql_fetch_array($resultasig);
		$sqlasignombre="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowasig[asig]'";
		$asignombre=mysql_db_query($db,$sqlasignombre,$link);
		$rowasign=mysql_fetch_array($asignombre);
		$asignom=$rowasign['nom_usr'].' '.$rowasign['apa_usr'].' '.$rowasign['ama_usr'];
		//$sqlw="SELECT * FROM users WHERE login_usr='$row[login_usr]'";
                // cambiada a usuario porque $row[login_usr] no da ningun valor
                $sqlw="SELECT * FROM users WHERE login_usr='$rowasig[asig]'";
			 $resultw=mysql_db_query($db,$sqlw,$link);
		  	 $roww=mysql_fetch_array($resultw);
			 $usuario=$roww['nom_usr']." ".$roww['apa_usr']." ".$roww['ama_usr'];
		$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
		$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
		if (!(empty($rowcli['email'])))
		{
		$asunto = "Nro. $id_orden. Nuevo Seguimiento de Orden de Trabajo";	
		$mail = $rowcli['email'];
		//echo $rowcli[email];
                $estado_seg=  isset($_REQUEST['estado_seg']);
                $fecha_r=  isset($_REQUEST['fecha_r']);
		$mensaje = "
		<b>Mensaje Generado por el Gestor F1 </b><br>
		------------------------------------------------------------------ <br>
		<b>Nuevo Seguimiento de Orden de Trabajo: Nro. $id_orden registrado a horas ".date("H:i:s")." en fecha ".date("d-m-Y")." </b><br>
		------------------------------------------------------------------ <br>
		<b>Datos Generales</b> <br>
		------------------------------------------------------------------ <br>
		<b> Cliente/Tecnico: </b> $clienteNombre1<br>
		<b>Descripcion:</b> $rowaux1[desc_inc]<br>
		<b>Asignado a:</b> $asignom <br>
		<b>Fecha Estimada de Solucion:</b> $rowasig[fechaestsol_asig] <br>
		------------------------------------------------------------------ <br>
		<b>Datos de Seguimiento</b> <br>
		------------------------------------------------------------------ <br>
		<b>Realizado por:</b> $usuario <br>
		<b>Observaciones de Seguimiento:</b> $obs_seg <br>
		<b>Estado:</b> $estado_seg <br>
		<b>Fecha Realizacion:</b> $fecha_r <br><br>
		<b>Para mayores detalles, consulte el Sistema GesTor F1.</b> <br>
		$systemData[nombre]";
		$tunombre = $systemData['nombre'];		
		$tuemail  = $systemData['mail_institucion'];												
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: $tunombre <$tuemail>\r\n"; 
		if(!mail($mail,$asunto,$mensaje,$headers))
		{ 
		echo"<script language='javascript'>alert('Precaución, no se ha podido enviar la orden por correo electrónico al Cliente. \\n Mensaje generado por GesTor F1.');						</script>";
		}
		else{
		echo "<script language='javascript'>alert('Mensaje enviado exitosamente a ".$clienteNombre." \\n Mensaje generado por GesTor F1.');</script>";
		}
		}
		else {	
		echo"<script language='javascript'>alert('Precaución, no se ha podido enviar la orden por correo electrónico al Cliente. El Usuario no tiene registrado su cuenta de correo \\n Mensaje generado por GesTor F1.');</script>";
		}
		}
		if ($rowaux['seguimiento']==2 or $rowaux['seguimiento']==4)
		{
		$sqlaux1="SELECT * FROM ordenes WHERE id_orden=$id_orden";
		$resultaux1=mysql_db_query($db,$sqlaux1,$link);
		$rowaux1=mysql_fetch_array($resultaux1);
		$sqlcliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowaux1[cod_usr]'";
		$ordencliente=mysql_db_query($db,$sqlcliente,$link);
		$rowcli=mysql_fetch_array($ordencliente);
		$clienteNombre=$rowcli['nom_usr'].' '.$rowcli['apa_usr'].' '.$rowcli['ama_usr'];
		//echo $clienteNombre;
		$sqlasig="select * from asignacion where id_orden=$id_orden";
		$resultasig=mysql_db_query($db,$sqlasig,$link);
		$rowasig=mysql_fetch_array($resultasig);
		$sqlasignombre="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowasig[asig]'";
		$asignombre=mysql_db_query($db,$sqlasignombre,$link);
		$rowasign=mysql_fetch_array($asignombre);
		$asignom=$rowasign['nom_usr'].' '.$rowasign['apa_usr'].' '.$rowasign['ama_usr'];
		$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
		$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
		//$sqlw="SELECT * FROM users WHERE login_usr='$row[login_usr]'";
                // cambiada poorque no daba ningun valor
                $sqlw="SELECT * FROM users WHERE login_usr='$rowasig[asig]'";
		
			 $resultw=mysql_db_query($db,$sqlw,$link);
		  	 $roww=mysql_fetch_array($resultw);
			 $usuario=$roww['nom_usr']." ".$roww['apa_usr']." ".$roww['ama_usr'];
		if (!(empty($rowcli['email'])))
		{
		$asunto = "Nro. $id_orden. Nuevo Seguimiento de Orden de Trabajo";	
		$mail = $rowcli['email'];
		//echo $rowcli[email];
		$mensaje = "
		<b>Mensaje Generado por el Gestor F1 </b><br>
		------------------------------------------------------------------ <br>
		<b>Nuevo Seguimiento de Orden de Trabajo: Nro. $id_orden registrado a horas ".date("H:i:s")." en fecha ".date("d-m-Y")." </b><br>
		------------------------------------------------------------------ <br>
		<b>Datos Generales</b> <br>
		------------------------------------------------------------------ <br>
		<b>Cliente/Tecnico:</b> $clienteNombre<br>
		<b>Descripcion:</b> $rowaux1[desc_inc]<br>
		<b>Asignado a:</b> $asignom <br>
		<b>Fecha Estimada de Solucion:</b> $rowasig[fechaestsol_asig] <br>
		------------------------------------------------------------------ <br>
		<b>Datos de Seguimiento</b> <br>
		------------------------------------------------------------------ <br>
		<b>Realizado por:</b> $usuario <br>
		<b>Observaciones de Seguimiento:</b> $obs_seg <br>
		<b>Estado: $estado_seg</b> <br>
		<b>Fecha Realizacion:</b> $fecha_r <br><br>
		Para mayores detalles, consulte el Sistema GesTor F1. <br>
		$systemData[nombre]";
		$tunombre = $systemData['nombre'];		
		$tuemail  = $systemData['mail_institucion'];												
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: $tunombre <$tuemail>\r\n";
		if(!mail($mail,$asunto,$mensaje,$headers))
		{ 
		echo"<script language='javascript'>alert('Precaución, no se ha podido enviar la orden por correo electrónico al Cliente. \\n Mensaje generado por GesTor F1.');</script>";
		}
		else{
		echo "<script language='javascript'>alert('Mensaje enviado exitosamente a ".$clienteNombre." \\n Mensaje generado por GesTor F1.');</script>";
		}
		}
		else {	
		echo"<script language='javascript'>alert('Precaución, no se ha podido enviar la orden por correo electrónico al Cliente. El Usuario no tiene registrado su cuenta de correo \\n Mensaje generado por GesTor F1.');</script>";
		}
		}
		if ($rowaux['seguimiento']==3 or $rowaux['seguimiento']==4)
		{
		$sqlaux1="SELECT * FROM ordenes WHERE id_orden=$id_orden";
		$resultaux1=mysql_db_query($db,$sqlaux1,$link);
		$rowaux1=mysql_fetch_array($resultaux1);
		$sqlcliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowaux1[cod_usr]'";
		$ordencliente=mysql_db_query($db,$sqlcliente,$link);
		$rowcli=mysql_fetch_array($ordencliente);
		$clienteNombre=$rowcli['nom_usr'].' '.$rowcli['apa_usr'].' '.$rowcli['ama_usr'];
		//echo $clienteNombre;
		$sqlasig="select * from asignacion where id_orden=$id_orden";
		$resultasig=mysql_db_query($db,$sqlasig,$link);
		$rowasig=mysql_fetch_array($resultasig);
		
		$sqlasignombre="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowasig[asig]'";
		$asignombre=mysql_db_query($db,$sqlasignombre,$link);
		$rowasign=mysql_fetch_array($asignombre);
		$asignom=$rowasign['nom_usr'].' '.$rowasign['apa_usr'].' '.$rowasign['ama_usr'];
		$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
		$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
			//$sqlw="SELECT * FROM users WHERE login_usr='$row[login_usr]'";
                        // se cambio por que no deviuelve ningun valor
                        $sqlw="SELECT * FROM users WHERE login_usr='$rowasig[asig]'";
                        
			 $resultw=mysql_db_query($db,$sqlw,$link);
		  	 $roww=mysql_fetch_array($resultw);
			 $usuario=$roww['nom_usr']." ".$roww['apa_usr']." ".$roww['ama_usr'];
		if ($rowasig['asig']!="")
		{
		if (!(empty($rowasign['email'])) )
		{
		$asunto = "Nro. $id_orden. Nuevo Seguimiento de Orden de Trabajo";	
		$mail = $rowasign['email'];
		//echo $rowcli[email];
		$mensaje = "
		<b>Mensaje Generado por el Gestor F1 </b><br>
		------------------------------------------------------------------ <br>
		<b>Nuevo Seguimiento de Orden de Trabajo: Nro. $id_orden registrado a horas ".date("H:i:s")." en fecha ".date("d-m-Y")." </b><br>
		------------------------------------------------------------------ <br>
		<b>Datos Generales</b> <br>
		------------------------------------------------------------------ <br>
		<b>Cliente/Tecnico:</b> $clienteNombre<br>
		<b>Descripcion:</b> $rowaux1[desc_inc]<br>
		<b>Asignado a:</b> $asignom <br>
		<b>Fecha Estimada de Solucion:</b> $rowasig[fechaestsol_asig] <br>
		------------------------------------------------------------------ <br>
		<b>Datos de Seguimiento</b> <br>
		------------------------------------------------------------------ <br>
		<b>Realizado por:</b> $usuario <br>
		<b>Observaciones de Seguimiento:</b> $obs_seg <br>
		<b>Estado:</b> $estado_seg <br>
		<b>Fecha Realizacion:</b> $fecha_r <br><br>
		Para mayores detalles, consulte el Sistema GesTor F1. <br>
		$systemData[nombre]";
		$tunombre = $systemData['nombre'];		
		$tuemail  = $systemData['mail_institucion'];												
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: $tunombre <$tuemail>\r\n";
		if(!mail($mail,$asunto,$mensaje,$headers))
		{ 
		echo"<script language='javascript'>alert('Precaución, no se ha podido enviar la orden por correo electrónico al Cliente. \\n Mensaje generado por GesTor F1.');</script>";
		}
		else{
		echo "<script language='javascript'>alert('Mensaje enviado exitosamente a ".$asignom." \\n Mensaje generado por GesTor F1.');</script>";
		}
		}
		else {	
		echo"<script language='javascript'>alert('Precaución, no se ha podido enviar la orden por correo electrónico al Cliente. El Usuario no tiene registrado su cuenta de correo \\n Mensaje generado por GesTor F1.');</script>";
		}
		
		}
		else
		{	
		echo"<script language='javascript'>alert('Precaución, no se ha podido enviar la orden por correo electrónico al Tecnico. Por que la orden no ha sido asignada \\n Mensaje generado por GesTor F1.');</script>";
		}
		}
}
	
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
print $valid->toHtml ();
?>
<script language="JavaScript">

<?php 
		print "function msgFile () {\n
				alert (\"Atencion, solamente puede enviar archivos menor o igual a $row_5[tam_archivo] Mb de tamaño.\\n \\nMensaje generado por YanapTI.\");\n
				}\n";
		if ($msg) 
		{
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por YanapTI.\");\n";
		} ?>

function Form () 
{
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
function chequea(form) 
{
	var max=255;
	if (form.obs_seg.value.length > max) 
	{
		alert("No puede ingresar más de 255 caracteres.  Por favor sea mas breve. (" + form.obs_seg.value.length+")");
		return false;
   	}
	else 
		return true;
}
function rellenar(llenar) 
{
 	form.obs_seg.value = llenar;
}
function contador (campo, cuentacampo, limite) 
{
	if (campo.value.length > limite) 
		campo.value = campo.value.substring(0, limite);
	else 
		cuentacampo.value = limite - campo.value.length;
}
function contador_(campo) 
{
	if (campo.value == "%") 
	{
		alert("No puede ingresar solo el caracter %");
		return false;
	}
	return true;
}

</script>

<form name="form2" method="post" enctype="multipart/form-data" onsubmit="return chequea(this)" action="<?php=$_SERVER['PHP_SELF']?>" onKeyPress="return Form()" >
 <input name="var2" type="hidden" value="<?php echo $lug;?>">
 <input name="id" type="hidden" value="Ninguno">
  <input name="op" type="hidden" value="<?php echo $op;?>">
  <table width="760" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" background="images/fondo.jpg">
    <tr> 
      <td width="710"> 
        <table width="735" border="1" align="center" cellpadding="2" cellspacing="1">
          <tr> 	
            <th colspan="7">SEGUIMIENTO</th>
          </tr>
          <tr align="center"> 
            <td colspan="8"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Nro 
              :</strong></font> 
              <input name="id_orden" type="text" value="<?php echo $_REQUEST['id_orden'];?>" size="3" readonly="true"><br>
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Descripcion: 
              </strong>
              <?php $sqlTmp="SELECT desc_inc FROM ordenes WHERE id_orden=$_REQUEST[id_orden]";
				$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
				print $ordenTmp['desc_inc'];
				?>
              </font> 
              <hr></td>
          </tr>
          <tr align="center"> 
            <td width="28" class="menu">Nro</td>
            <td width="128" class="menu">REALIZADO POR</td>
            <td width="75" class="menu">ESTADO</td>
            <td width="183" class="menu">OBSERVACIONES</td>
            
            <td width="58" class="menu">ARCH. ADJ.</td>
            <td width="88" class="menu">FECHA</td>
            <td width="124" class="menu">HORA</td>
          </tr>
          <?php
		$sql = "SELECT *, DATE_FORMAT(fecha_seg, '%d/%m/%Y') AS fecha_seg FROM seguimiento WHERE id_orden='$_REQUEST[id_orden]' ORDER BY id_seg ASC, fecha_seg ASC, hora_seg ASC";

                $result=mysql_db_query($db,$sql,$link);
		$c=1;
		while($row=mysql_fetch_array($result)) 
  		{?>
          <tr align="center"> 
            <td nowrap>&nbsp;<?php echo $c++;?></td>
            <td nowrap>&nbsp;
			<?php 
			 $sql2="SELECT * FROM users WHERE login_usr='$row[login_usr]'";
			 $result2=mysql_db_query($db,$sql2,$link);
		  	 $row2=mysql_fetch_array($result2);
			 echo $row2['nom_usr']." ".$row2['apa_usr']." ".$row2['ama_usr'];
			?>			</td>
            <td nowrap>&nbsp; 
              <?php 
			if ($row['estado_seg']=="1")
			{echo "Cumplida en fecha";}
			if ($row['estado_seg']=="2")
			{echo "Cumplida retrasada";}
			if ($row['estado_seg']=="3")
			{echo "Pendiente en fecha";}
			if ($row['estado_seg']=="4")
			{echo "Pendiente retrasada";}
			if ($row['estado_seg']=="5")
			{echo "Desestimada";}
			?>            </td>
            <td align="center">&nbsp;<?php echo $row['obs_seg'];?></td>
			
			
			<?php 
				if (!$row['nomb_archivo'])
				{
					echo "<td>Ninguno</td>";
				}
				else 
				{
					echo"<td><a href=\"archivos_segui/".$row['nomb_archivo']."\" target=\"_blank\">$row[nomb_archivo]</a></td>";
				}
			?>
			
            <td nowrap><?php echo $row['fecha_seg'];?> </td>
            <td nowrap><?php echo $row['hora_seg'];?> </td>
          </tr>
          <?php
		 }

	  	  $sql = "SELECT * FROM solucion WHERE id_orden='$_REQUEST[id_orden]'";

                  $result=mysql_db_query($db,$sql,$link);
		  if ($row=mysql_fetch_array($result)){
			  echo "<tr align=\"center\"> <td colspan=\"7\"> <input type=\"submit\" name=\"RETORNAR\" value=\"RETORNAR\"> </td></tr>";
		  }
		  else {
		  ?>
          <tr align="center"> 
            <td height="25" colspan="8">&nbsp;</td>
          </tr>
        </table>
        <table width="733" border="1" cellpadding="2" cellspacing="1">
          <tr> 
            <td width="7%" class="menu">Nro.</td>
            <td width="24%" class="menu">ESTADO</td>
            <td width="40%" class="menu">OBSERVACIONES </td>
			<td width="9%" class="menu"><div align="center">FECHA</div></td>
            <td width="9%" class="menu"><div align="center">HORA</div></td>
          </tr>
          <tr> 
            <td height="40">Nuevo</td>
            <td><select name="estado_seg" id="estado_seg">
              <option>1 (Cumplida en fecha)</option>
              <option>2 (Cumplida retrasada)</option>
              <option>3 (Pendiente en fecha)</option>
              <option>4 (Pendiente retrasada)</option>
              <option>5 (Desestimada)</option>
            </select></td>
            
            <td><textarea name="obs_seg" cols="50" rows="5" id="obs_seg2" onKeyDown="contador(this.form.obs_seg,this.form.remLen,255);"	onKeyUp="contador(this.form.obs_seg,this.form.remLen,255);"><?php echo isset($obs)?></textarea>
			  <input type="text" name="remLen" size="3" maxlength="3" value="255" readonly>
			  <br>
</td>
			
			<td class="menu"><div align="center"><strong><?php echo date("d/m/Y");?></strong></div></td>
            <td class="menu"><div align="center"><strong><?php echo date("H:i:s");?></strong></div></td>
          </tr>
		  
		  <tr> 
		  </tr> 
		  <td colspan="6">
		    <div align="center">
	        Archivo Adjunto              </div></td>
          <tr> 
		  <td colspan="6">
		    <div align="center">
			  <input name="archivo" type="file" size="60" value="<?php print $archivo ?>" onClick="msgFile()">
            </div></td>
          <tr> 
            <td colspan="6"><div align="center"><br>
                <input name="reg_form" type="submit" value="GUARDAR"  <?php print $valid->onSubmit() ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<input type="submit" name="RETORNAR" value="RETORNAR">
</div></td>
          </tr>
		  <?php } ?>
        </table>
      
      </td>
    </tr>
	
  </table>
</form>  



<?php include("top_.php");?> 
