<?php
include ("conexion.php");
include("top.php");
$sqlid="SELECT * FROM ordenes WHERE id_orden=$id_orden";
$resultid=mysql_db_query($db, $sqlid, $link);
$rowid=mysql_fetch_array($resultid);

if ($lista) header("location: lista_titulares.php");
ini_set("error_reporting", "E_ALL & ~E_NOTICE & ~E_WARNING");
if (isset($reg_form)) 
{	session_start();
	$login=$_SESSION["login"];
	$sql8="SELECT * FROM users WHERE login_usr='$login'";
	$result8=mysql_db_query($db,$sql8,$link);
	$row8=mysql_fetch_array($result8);
	$nombre="$row8[nom_usr] $row8[apa_usr] $row8[ama_usr]";
	$sql6="SELECT tmp_conf FROM control_parametros";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	$tiemp=0;
	$sql7="SELECT * FROM ordenes WHERE cod_usr='$login'";
	$result7=mysql_db_query($db,$sql7,$link);
	while($row7=mysql_fetch_array($result7))
	{	$sql3="SELECT id_orden FROM conformidad WHERE id_orden='$row7[id_orden]'";
		$result3=mysql_db_query($db,$sql3,$link);
		$row3=mysql_fetch_array($result3);
		if (!$row3[id_orden])
		{$a1=substr($row7[fecha],0,4); $m1=substr($row7[fecha],5,2); $d1=substr($row7[fecha],8,2);
		$hoy=date("Y-m-d");
		$a2=substr($hoy,0,4); $m2=substr($hoy,5,2); $d2=substr($hoy,8,2);
		$d3=$d2-$d1; $m3=$m2-$m1; $a3=$a2-$a1;
		if ($a3 >= "0") 
		{if ($m3 >= "0")
	 		{if ($d3 >= "0")
			    {$a3=$a3; $m3=$m3; $d3=$d3;}
			 elseif ($d3<"0") 
			 	{$m3=$m3-1; $d3=30+$d3;
				 if ($m3 < "0"){$a3=$a3-1; $m3=12+$m3;}}}
		else {$a3=$a3-1; $m3=12+$m3;
				if ($d3 >= "0"){
				 $a3=$a3; $m3=$m3; $d3=$d3;}}}
		else
	 			{$a3="0"; $m3="0"; $d3="0";}

		if ($a3<>"0") {$a3=$a3*360;} else {$a3="";}
		if ($m3<>"0") {$m3=$m3*30;} else {$m3="";}
		$d4=$d3+$a3+$m3;
		if ($d4 > $row6[tmp_conf]) {$tiemp=tiemp+1;}
}}
/*if ($tiemp>="1")
{$desc="El usuario ".$nombre." no puede insertar mas ordenes de trabajo, debido a que tiene una orden que en ".$row6[tmp_conf]." dias no recibio conformidad ";
$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, tipo, id_anidacion) ".
"VALUES('".date("Y-m-d")."','".date("H:i:s")."','SISTEMA','$desc','$tipo1','$id_orden')";
mysql_db_query($db,$sql,$link); 
$msg="USTED NO PUEDE INSERTAR MAS ORDENES DE TRABAJO, DEBIDO A QUE UNA DE ELLAS EXCEDIO\\n EN ".$row6[tmp_conf]." DIAS SIN CONFORMIDAD";}
else
{*/	$sql3="SELECT COUNT(id_orden) AS num1 FROM ordenes WHERE cod_usr='$login'";
	$result3=mysql_db_query($db,$sql3,$link);
	$row3=mysql_fetch_array($result3);
	$sql4="SELECT COUNT(id_orden) AS num2 FROM conformidad WHERE reg_conf='$login'";
	$result4=mysql_db_query($db,$sql4,$link);
	$row4=mysql_fetch_array($result4);
	$sql5="SELECT * FROM control_parametros";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
		
/*	if (($row3[num1]-$row4[num2])>=$row5[cant_ordenes])
	{
	$desc="El usuario ".$nombre." no puede insertar mas ordenes de trabajo, debido a que tiene ".$row5[cant_ordenes]." ordenes de trabajo sin conformidad ";
	$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, tipo, id_anidacion) ".
	"VALUES('".date("Y-m-d")."','".date("H:i:s")."','SISTEMA','$desc','$tipo1','$id_orden')"; 
	mysql_db_query($db,$sql,$link); 
	$msg="USTED NO PUEDE INSERTAR MAS ORDENES DE TRABAJO, DEBIDO A QUE EXCEDIO EN ".$row5[cant_ordenes]."\\nORDENES SIN CONFORMIDAD";
	}
	else
	{
	*/if (strlen($desc_inc)<=10) {$msg="LA DESCRIPCION DEL INCIDENTE DEBE SER MAYOR A 10 CARACTERES";}
	else{
			if (!isset($login)) {  header("location: lista.php");
			}
			$tipo1=$tipo0.$tipo1;
			if ($archivo_name=="")				
				{	//echo "g";
				$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, tipo,nomb_archivo,area,dominio,objetivo,ci_ruc, id_anidacion,hash_archivo,observaciones) ".
				"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$rowid['cod_usr']."','$desc_inc','$tipo1','','0','0','0','$rowid[ci_ruc]','$id_orden','','')"; 
				mysql_query($sql); 
				$systemData=$row5;
				if($systemData["conf_mail"]==1 || $systemData["conf_mail"]==3 || $systemData["conf_sms"]==1 || $systemData["conf_sms"]==3){
					//ENVIAR MSG
					$sql1="SELECT MAX(id_orden) AS id_or FROM ordenes"; 								
					$row1=mysql_fetch_array(mysql_db_query($db,$sql1,$link));
					if($row5["conf_sms"]==1 || $row5["conf_sms"]==3)
					{
								$sqlMovil="SELECT id_dat_tel_movil, direccion FROM dat_tel_movil";
								$movilRs=mysql_db_query($db, $sqlMovil, $link);
								while($tmp=mysql_fetch_array($movilRs)){
										$movilLst[$tmp[id_dat_tel_movil]]=$tmp[direccion];
								}
								$systemData[movilEmail]="591".$systemData[telefono_movil]."@".$movilLst[$systemData[id_dat_tel_movil]];												
								if (!mail($systemData[movilEmail],$systemData[mail],"Nro".$row1[id_or]."-Nuevo Requerimiento de Orden de Trabajo. $systemData[nombre]"))
								{$msg ="Precaucion, no se ha podido enviar la orden por correo electronico.\\n";}										
					}
					//Enviar mail al administrador de mesa de ayuda
					if($row5["conf_mail"]==1 || $row5["conf_mail"]==3)						
					{	$asunto = "Nro.$row1[id_or]. Nuevo Requerimiento de Trabajo de Mesa de Ayuda";	
						$mail = $systemData['mail'];
						$mensaje = "
Nuevo Requerimiento de Mesa de Ayuda: Nro. $row1[id_or]
Cliente/Tecnico: $nombre
Descripcion: $desc_inc
Para mayores detalles, consulte el Sistema GesTor F1.\n\n$systemData[nombre]";						
						$tunombre = $row5['nombre'];		
						$tuemail = $row5['mail_institucion'];						
						$headers  = "From: $tunombre <$tuemail>\n";
						$headers .= "\n";						
						if(!mail($mail,$asunto,$mensaje,$headers)){$msg ="Precaucion, no se ha podido enviar la orden por correo electronico.\\n";}																
					}									
				}
				?>
				<script language="JavaScript">
						self.location="lista.php?Naveg=Ordenes%20de%20Trabajo";
				</script>
				<?php
				header("location: lista.php?msg=$msg");
				}		
			elseif ($archivo_name<>"")
				{	$extension = explode(".",$archivo_name); 
					$num = count($extension)-1; 
					//if($extension[$num]=="gif" OR $extension[$num]=="jpg" OR $extension[$num]=="doc") 
						//{
							$tam_max=1048576*$row5[tam_archivo];
							if($archivo_size < $tam_max)
							{
								$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, tipo,nomb_archivo,area,dominio,objetivo,ci_ruc, id_anidacion,hash_archivo,observaciones) ".
				"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$rowid['cod_usr']."','$desc_inc','$tipo1','','0','0','0','$rowid[ci_ruc]','$id_orden','','')"; 
								mysql_query($sql); 
						
								$sql1="SELECT MAX(id_orden) AS id_or FROM ordenes"; 
								$result1=mysql_query($sql1);
								$row1=mysql_fetch_array($result1);
						
								$arch_nomb=$row1[id_or].".".$extension[$num];
								$sql2="UPDATE ordenes SET nomb_archivo='$arch_nomb' WHERE id_orden='$row1[id_or]'";
								mysql_db_query($db,$sql2,$link);	
								copy($archivo,"archivos adjuntos/".$arch_nomb);
								//Enviar mail y sms  al administrador de mesa de ayuda
								$systemData=$row5;
								if($systemData["conf_mail"]==2 || $systemData["conf_mail"]==3 || $systemData["conf_sms"]==2 || $systemData["conf_sms"]==3){
								//ENVIAR MSG
							if($row5["conf_sms"]==1 || $row5["conf_sms"]==3)
							{
											$sqlMovil="SELECT id_dat_tel_movil, direccion FROM dat_tel_movil";
											$movilRs=mysql_db_query($db, $sqlMovil, $link);
											while($tmp=mysql_fetch_array($movilRs)){
												$movilLst[$tmp[id_dat_tel_movil]]=$tmp[direccion];
											}
											$systemData['movilEmail']="591".$systemData[telefono_movil]."@".$movilLst[$systemData[id_dat_tel_movil]];												
											if (!mail($systemData['movilEmail'],$systemData[mail],"Nro".$row1[id_or]."-Nuevo Requerimiento de Orden de Trabajo. $systemData[nombre]"))
											{$msg ="Precaucion, no se ha podido enviar la orden por correo electronico.\\n";}										
							}
							//Enviar mail al administrador de mesa de ayuda
							if($row5["conf_mail"]==1 || $row5["conf_mail"]==3)						
							{	$asunto = "Nro.$row1[id_or]. Nuevo Requerimiento de Trabajo de Mesa de Ayuda";	
								$mail = $systemData[mail];
								$mensaje = "
Nuevo Requerimiento de Mesa de Ayuda: Nro. $row1[id_or]
Cliente/Tecnico: $nombre
Descripcion: $desc_inc
Para mayores detalles, consulte el Sistema GesTor F1.\n\n$systemData[nombre]";

								$tunombre = $row5['nombre'];		
								$tuemail = $row5['mail_institucion'];						
								$headers  = "From: $tunombre <$tuemail>\n";
								$headers .= "\n";						
								if(!mail($mail,$asunto,$mensaje,$headers)){$msg ="Precaucion, no se ha podido enviar la orden por correo electronico.\\n";}																
							}																																						
						}
									header("location: lista.php");
							}
							else{$msg="EL TAMANO DEL ARCHIVO ADJUNTO NO DEBE SER MAYOR A ".$row5[tam_archivo]." Mb";}
				}
		}
	}
/*  }
}*/
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
<link href="general.css" rel="stylesheet" type="text/css">

<title>Anidar Orden</title><form name="form1" method="post" enctype="multipart/form-data" onKeyPress="return Form()">
  <br>
<font color="#FF0000" face="Arial, Helvetica, sans-serif"><strong><?php //echo $msg; ?></strong></font>
  <table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" >
    <tr> 
      <td> 
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="4" bordercolor="#336799">
          <tr bgcolor="#336799"> 
            <th  background="images/main-button-tileR2.jpg" height="25px" colspan="2"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF">INGRESE SU CONSULTA O RECLAMO</font></th>
          </tr>
          <tr> 
            <td colspan="2" align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA : <?php echo date("d/m/Y");?></font></strong><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp; 
              HORA : <?php echo date("H:i:s");?></font></strong></td>
          </tr>
          <tr> 
            <td colspan="2" class="normal"><div align="left">
                <p align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Descripcion de la Incidencia :</font></strong> 
                  <br>
                  <strong><font size="2" face="Arial, Helvetica, sans-serif">Viene de la orden <?php echo $id_orden?></strong>
              </div>
              </td>
          </tr>
          <tr> 
            <td colspan="2"> <div align="center"><strong> 
                <textarea name="desc_inc" cols="80" rows="4" id="desc_inc"><?php echo $rowid[desc_inc]; ?></textarea>
                </strong> </div></td>
          </tr>
          <tr> 
           <!-- <td colspan="2"> <div align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">AREA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AREA 
                1  
                <input name="tipo0" type="radio" value="L" checked>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AREA 2
<input type="radio" name="tipo0" value="F" <?php //if ($tipo0=="F") print "checked"; ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AREA 3
                <input type="radio" name="tipo0" value="N" <?php //if ($tipo0=="N") print "checked"; ?>>
                &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;OTRO
				<input type="radio" name="tipo0" value="O" <?php //if ($tipo0=="O") print "checked"; ?>>
                &nbsp;&nbsp; 
                <input name="tipo1" type="text" value="<?php //print $tipo1 ?>" maxlength="30">
                <br>
                </font></strong></div></td>-->
          </tr><br>

          <tr> 
            <td width="7%" align="center"><br>
            </td>
            <?php 
			$sql5="SELECT * FROM control_parametros";
			$result5=mysql_db_query($db,$sql5,$link);
			$row5=mysql_fetch_array($result5);
			?>
			
          </tr>
          <tr> 
            <td colspan="2" align="center"> <div align="center"> 
               </td>
          </tr>
          <tr> 
            <td height="43" colspan="2" align="center"><br><input name="reg_form" type="submit" value="ENVIAR" onClick="return validateConsulta()"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<script language="JavaScript">
		<!-- 
		<?php
		 print "function msgFile () {\n
				alert (\"Atencion, solamente puede enviar archivos menor o igual a $row5[tam_archivo] Mb de tamano.\\n \\nMensaje generado por GesTor F1.\");\n
				}\n";
			if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
			
		} ?>
		function validateConsulta () {
			var form=document.form1;
			if (form.desc_inc.value.length < 10 || form.desc_inc.value.length > 500){
				alert ("Descripcion de la incidencia, debe ser mayor a 10 caracteres y menor a 500.\nSi la descripcion es demasiado extensa, adjunte en un archivo \n\nMensaje generado por GesTor F1.");
				return false;
			}
			return true;
		}
//-->
</script>
<?php include ("top_.php");?>