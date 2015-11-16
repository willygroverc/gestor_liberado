<?php
session_start();
if(isset($adjunt)){
	include("conexion.php");
	$sql5="SELECT * FROM control_parametros";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);

	$extension = explode(".",$archivo_name); 
	$num = count($extension)-1; 
	$tam_max=1048576*$row5[tam_archivo];

	if($archivo_size < $tam_max){
		$sql1="SELECT MAX(id_orden)+1 AS id_or FROM ordenes"; 
		$result1=mysql_db_query($db,$sql1,$link);
		$row1=mysql_fetch_array($result1);
		$var="ajuntos_bo_".$row1[nomb_archivo];
		$var_hash="ajuntos_bo_hash_".$row1[hash_archivo];//nuevo
		$adjuntos_bo=$_SESSION[$var];
		$adjuntos_bo_hash=$_SESSION[$var_hash]; //nuevo
		$num1=array();
		$num1_hash=array();//nuevo
		if($adjuntos_bo=="") $alfa=1;
		else {
			$num1=explode("|",$adjuntos_bo);
			$alfa=count($num1)+1;
		}
		if($adjuntos_bo_hash=="") $alfa_hash=1;//desde aqui
		else {
			$num1_hash=explode("|",$adjuntos_bo_hash);
			$alfa_hash=count($num1_hash)+1;
		}//hasta aqui
		$arch_nomb=$row1[id_or]."[".$alfa."].".$extension[$num];
		copy($archivo,"archivos adjuntos/".$arch_nomb);
		$hash_nomb = md5_file($archivo);//nuevo
		array_push($num1,$arch_nomb);
		array_push($num1_hash,$hash_nomb);//nuevo
		$num=implode("|",$num1);
		$num_hash=implode("|",$num1_hash);
		$_SESSION[$var]=$num;
		$_SESSION[$var_hash]=$num_hash;
	}else{
	unset($msg);
	$msg="EL TAMAÑO DEL ARCHIVO ADJUNTO NO DEBE SER MAYOR A ".$row5[tam_archivo]." Mb";
	}
}
if ($lista) header("location: lista_titulares.php");
ini_set("error_reporting", "E_ALL & ~E_NOTICE & ~E_WARNING");
if(isset($otro))
{
	include ("conexion.php");	
	$sql="INSERT INTO titular (ci_ruc,ciudad,nombre,apaterno,amaterno,acasada,email,entidad,area,especialidad,cargo,telf,externo,direccion) ".
	"VALUES('$ci_ruc','$ciudad','$nombre','$apaterno','$amaterno','$acasada','$email','$entidad','$area','$especialidad','$cargo','$telf','$externo','$direccion')"; 
	if (mysql_db_query($db,$sql,$link)){
		$msg="Se creo correctamente el usuario";
	} 
	else {
		$msg="Ocurrio un error al conectarse con la base de datos.";
		if (mysql_errno()==1062) {	$msg=$msg . "Ya se tiene un usuario con ese CI o RUC";}
	}
}

if(isset($buscar) || isset($otro))
{
	include ("conexion.php");	
	$sql="SELECT * from titular WHERE UPPER(ci_ruc) LIKE '$ci_ruc'";
	if ($result=mysql_db_query($db,$sql,$link)){
		$row_=mysql_fetch_array($result);
	} 
	else {
		$msg="Ocurrio un error al conectarse con la base de datos <br>";
	}

}

if (isset($reg_form)) 
{	session_start();
	$login=$_SESSION["login"];
	include ("conexion.php");	
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
{
	$desc="El usuario ".$nombre." no puede insertar mas ordenes de trabajo, debido a que tiene una orden que en ".$row6[tmp_conf]." dias no recibio conformidad ";
	$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc) ".
	"VALUES('".date("Y-m-d")."','".date("H:i:s")."','SISTEMA','$desc')"; 
	mysql_db_query($db,$sql,$link);?> 
	<script language="JavaScript">
		ventana_secundaria=window.open('pru2.php','secundaria','location=no,menubar=no,status=no,toolbar=no,scrollbars=0,resizable=no,width=350,height=170,left=150,top=150'); 
		ventana_secundaria.close(); 
	</script>
<?php 	$msg="USTED NO PUEDE INSERTAR MAS ORDENES DE TRABAJO, DEBIDO A QUE UNA DE ELLAS EXCEDIO\\n EN ".$row6[tmp_conf]." DIAS SIN CONFORMIDAD";
}
else
{	$sql3="SELECT COUNT(id_orden) AS num1 FROM ordenes WHERE cod_usr='$login'";
	$result3=mysql_db_query($db,$sql3,$link);
	$row3=mysql_fetch_array($result3);
	$sql4="SELECT COUNT(id_orden) AS num2 FROM conformidad WHERE reg_conf='$login'";
	$result4=mysql_db_query($db,$sql4,$link);
	$row4=mysql_fetch_array($result4);
	$sql5="SELECT * FROM control_parametros";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
		
	if (($row3[num1]-$row4[num2])>=$row5[cant_ordenes])
	{
	$desc="El usuario ".$nombre." no puede insertar mas ordenes de trabajo, debido a que tiene ".$row5[cant_ordenes]." ordenes de trabajo sin conformidad ";
	$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc) ".
	"VALUES('".date("Y-m-d")."','".date("H:i:s")."','SISTEMA','$desc')"; 
	mysql_db_query($db,$sql,$link); 
	?> 
		<script language="JavaScript">
			ventana_secundaria=window.open('pru2.php','secundaria','location=no,menubar=no,status=no,toolbar=no,scrollbars=0,resizable=no,width=350,height=170,left=150,top=150'); 
			ventana_secundaria.close(); 
		</script>
	<?php
	$msg="USTED NO PUEDE INSERTAR MAS ORDENES DE TRABAJO, DEBIDO A QUE EXCEDIO EN ".$row5[cant_ordenes]."\\nORDENES SIN CONFORMIDAD";
	}
	else
	{*/
	if (strlen($desc_inc)<=10) {$msg="LA DESCRIPCION DEL INCIDENTE DEBE SER MAYOR A 10 CARACTERES";}
	else{
			if (!isset($login)) {  header("location: index.php");}
			$tipo1=$tipo0.$tipo1;
			//echo "g";
/////////////////
		$sql1a="SELECT MAX(id_orden)+1 AS id_or FROM ordenes"; 
		$result1a=mysql_db_query($db,$sql1a,$link);
		$row1a=mysql_fetch_array($result1a);

		$var="ajuntos_bo_".$row1a[nomb_archivo];
		$adjuntos_bo=$_SESSION[$var];
		$var_hash="ajuntos_bo_hash_".$row1a[nomb_archivo];
		$adjuntos_bo_hash=$_SESSION[$var_hash];
/////////////////
				$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc,ci_ruc,origen, nomb_archivo, hash_archivo) ".
				"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$desc_inc','$ci_ruc','0','".$adjuntos_bo."','".$adjuntos_bo_hash."')"; 
				mysql_db_query($db,$sql,$link); 
				session_unregister($var);
				session_unregister($var_hash);//nuevo
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
								//echo $systemData[movilEmail];
								if (!mail($systemData[movilEmail],$systemData[mail],"Nro".$row1[id_or]."-Nuevo Requerimiento de Orden de Trabajo. $systemData[nombre]"))
								{$msg ="Precaucion, no se ha podido enviar la orden por SMS.";}										
					}
					//Enviar mail al administrador de mesa de ayuda
					if($row5["conf_mail"]==1 || $row5["conf_mail"]==3)						
					{	
						$tunombre = $row5[nombre];		
						$tuemail = $row5[mail_institucion];						
						$headers = "MIME-Version: 1.0\r\n"; 
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
						$headers .= "From: $tunombre <$tuemail>\r\n"; 
						$asunto = "Nro.$row1[id_or]. Nuevo Requerimiento de Trabajo de Mesa de Ayuda";	
						$mail = $systemData[mail];
						$mensaje = "
Nuevo Requerimiento de Mesa de Ayuda: Nro. $row1[id_or]
Cliente/Tecnico: $nombre
Descripcion: $desc_inc
Para mayores detalles, consulte el Sistema GesTor F1.";						
										
						if(!mail($mail,$asunto,$mensaje,$headers)){$msg ="Precaucion, no se ha podido enviar la orden por Correo Electronico.";}																
					}									
				}
				
				
				//Parámetros para asignación
				
				$id = mysql_insert_id($link);
				$sCon = "select *from users where login_usr='$login'";
				$sRes = mysql_query($sCon,$link);
				$sRow = mysql_fetch_array($sRes);
				
				if(($tipo == 'T') and ($sRow['asig_usr'] == 1))
				{
					header("location: asignacion.php?id_orden=$id");
				}
				else{
					header("location: lista.php?msg=$msg&vent=1");
				}
				
				
				//fin de ingreso de parámetros
				//header("location: lista.php?msg=$msg&vent=1");
				
				
				
				
//	}
//  }
}}
include ("top.php");
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNumber ( "ci_ruc",  "CI/RUC, $errorMsgJs[number]" );
$valid->addEmail ( "email",  "" );
$valid->addIsNotEmpty ( "archivo",  "Archivo Adjunto, $errorMsgJs[empty]" );
echo $valid->toHtml ();
if ($msg) {
	$row_ = $_POST;
	}
else {
	unset($desc_inc);
	unset($tipo1);
}

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
session_start();
$login_usr = $_SESSION["login"];
$SQL="SELECT visualizacion_1 FROM users WHERE login_usr='$login_usr'";
$result=mysql_db_query($db,$SQL,$link);
$row=mysql_fetch_array($result);
if(!$var){$var=0;};
?>
<form name="form1" method="post" enctype="multipart/form-data" onKeyPress="return Form()">
<input name="id_orden" type="hidden" value="<?php echo id_orden; ?>">
<?php if ($row[visualizacion_1]==0){?>
  <table width="95%" border="1" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th align="center" colspan="10">CLIENTE / TITULAR</th>
    </tr>
    <tr> 
      <td align="center" colspan="10">CI&nbsp;/&nbsp;RUC: 
        <input name="ci_ruc" type="text" value="<?php echo $row_[ci_ruc];?>" size="20" maxlength="20"> 
        &nbsp; <input name="buscar" type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;BUSCAR&nbsp;&nbsp;&nbsp;&nbsp;" onClick="return validateForm()"> 
        &nbsp; <input name="lista" type="submit" id="lista" value="&nbsp;&nbsp;&nbsp;VER LISTA&nbsp;&nbsp;&nbsp;"> 
      </td> </tr>
    <tr> 
      <td align="right">NOMBRES:</td>
      <td> <input name="nombre" type="text" value="<?php echo $row_[nombre];?>" size="20" maxlength="20"></td>
      <td width="12%" align="right">AP.PATERNO:</td>
      <td width="16%"><input name="apaterno" type="text" value="<?php echo $row_[apaterno];?>" size="20" maxlength="50"></td>
      <td width="12%" align="right"> AP.MATERNO:</td>
      <td width="12%"> <input name="amaterno" type="text" value="<?php echo $row_[amaterno];?>" size="20" maxlength="50"></td>
      <td width="17%"><div align="right">AP. CASADA:</div></td>
      <td width="15%"><input name="acasada" type="text" value="<?php echo $row_[acasada];?>" size="20"></td>
    </tr>
    <tr> 
      <td align="right">E-MAIL: </td>
      <td> <input name="email" type="text" value="<?php echo $row_[email];?>" size="20" maxlength="50"></td>
      <td align="right">ENTIDAD: </td>
      <td> <input name="entidad" type="text" value="<?php echo $row_[entidad];?>" size="20" maxlength="40"></td>
      <td align="right">AREA:</td>
      <td><input name="area" type="text" value="<?php echo $row_[area];?>" size="20" maxlength="40"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td align="right">CARGO:</td>
      <td><input name="cargo" type="text" value="<?php echo $row_[cargo];?>" size="20" maxlength="40"></td>
      <td align="right">TELEFONO:</td>
      <td><input name="telf" type="text" value="<?php echo $row_[telf];?>" size="20" maxlength="15"></td>
      <td align="right">FAX:</td>
      <td><input name="especialidad" type="text" value="<?php echo $row_[especialidad];?>" size="20" maxlength="15"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td align="right">EXT:</td>
      <td><input name="externo" type="text" value="<?php echo $row_[externo];?>" size="20" maxlength="15"></td>
      <td align="right">CIUDAD:</td>
      <td><input name="ciudad" type="text" value="<?php echo $row_[ciudad];?>" size="20" maxlength="15"></td>
      <td align="right"> DIRECCION:</td>
      <td><input name="direccion" type="text" value="<?php echo $row_[direccion];?>" size="20" maxlength="80"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="8" align="center"> <input name="otro" type="submit" value="GUARDAR" <?php print $valid->onSubmit() ?>> 
      </td>
    </tr>
  </table>
<br>
<font color="#FF0000" face="Arial, Helvetica, sans-serif"><strong><?php }?></strong></font>
  <table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" >
    <tr> 
      <td> 
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
          <tr bgcolor="#006699"> 
            <th colspan="2">INGRESE SU CONSULTA O RECLAMO</th>
          </tr>
          <tr> 
            <td colspan="2" align="center"><strong>FECHA : <?php echo date("d/m/Y");?></strong><strong>&nbsp;&nbsp; 
              HORA : <?php echo date("H:i:s");?></strong></td>
          </tr>
          <tr> 
            <td colspan="2" class="normal"><div align="center"><strong>Descripcion 
                de la Incidencia :</strong> </div></td>
          </tr>
          <tr> 
            <td colspan="2"> <div align="center"><strong> 
                <textarea name="desc_inc" cols="80" rows="4" id="desc_inc"><?php print $desc_inc; ?></textarea>
                </strong> </div></td>
          </tr>
          <br>
          <tr> 
            <td colspan="2"><div align="center"><br>
                <input name="reg_form" type="submit" value="   ENVIAR ORDEN   " onClick="return validateConsulta()">
                <br>
              </div></td>
          </tr>
          <!--
</form>
<form name="form2" method="post" enctype="multipart/form-data" onKeyPress="return Form()">
-->
          <?php
			$sql1="SELECT MAX(id_orden)+1 AS id_or FROM ordenes"; 
			$result1=mysql_db_query($db,$sql1,$link);
			$row1=mysql_fetch_array($result1);
			$var="ajuntos_bo_".$row1[nomb_archivo];
			$var_hash="ajuntos_bo_hash_".$row1[hash_archivo];//nuevo
			if($_SESSION[$var]){
				$adjuntos_bo=$_SESSION[$var];
				$adjuntos_bo_hash=$_SESSION[$var_hash];//nuevo
				$adjuntos_bo=explode("|",$adjuntos_bo);
				$adjuntos_bo_hash=explode("|",$adjuntos_bo_hash);
				?>
          <tr> 
            <td colspan="2"><div align="left"><strong><font size="2">Archivos 
                Adjuntos:</font></strong></div></td>
          </tr>
          <?php 	$i=0;
				foreach($adjuntos_bo as $valor){
					echo "<tr><td></td><td><a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor</a>&nbsp;MD5: $adjuntos_bo_hash[$i]</td></tr>";
					$i++;
				}
			}?>
          <tr> 
            <td width="7%" align="center"><br> </td>
            <?php 
	$sql5="SELECT * FROM control_parametros";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
			?>
            <td width="93%" align="center"><div align="left"><b><font size="2" face="Arial, Helvetica, sans-serif"><br>
                Enviar Archivo Adjunto <br>
                </font></b><font size="2" face="Arial, Helvetica, sans-serif">( 
                tipo : .gif &nbsp;&nbsp;.jpg&nbsp;&nbsp; .doc &nbsp;&nbsp;&nbsp;&nbsp;y 
                &nbsp;&nbsp;tamano maximo : <?php echo $row5[tam_archivo];?> Mb ) 
                : </font> </div></td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> <div align="center"> 
                <p> 
                  <input name="archivo" type="file" size="60" value="<?php print $archivo ?>" onClick="msgFile()">
                </p>
                <p align="left"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                  <input name="adjunt" type="submit" value="ADJUNTAR" <?php print $valid->onSubmit() ?>>
                </p>
              </div></td>
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
			ventana_secundaria=window.open('pru2.php','secundaria','location=no,menubar=no,status=no,toolbar=no,scrollbars=0,resizable=no,width=350,height=170,left=150,top=150'); 
			ventana_secundaria.close();
			return true;
		}
//-->
</script>
<?php include("top_.php");?> 