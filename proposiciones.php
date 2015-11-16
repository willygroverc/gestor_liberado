<?php
if ($adjuntar)
{
		if($id_minuta == "")
		{
			$id_minuta = $idmin;
		}else{
			$idmin = $id_minuta;
		}
		session_start();
		include("conexion.php");
		$sql5="SELECT * FROM control_parametros";
		$result5=mysql_db_query($db,$sql5,$link);
		$row5=mysql_fetch_array($result5);
		$extension = explode(".",$archivo_name); 
		$num = count($extension)-1; 
		$tam_max=1048576*$row5[tam_archivo];
		if($archivo_size < $tam_max)
		{
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
			header("location: proposiciones.php?id_minuta=$id_minuta&prop=$prop&nombre=$nombre");
			
		}else{
			unset($msg);
			$msg="EL TAMAÑO DEL ARCHIVO ADJUNTO NO DEBE SER MAYOR A ".$row5[tam_archivo]." Mb";
			header("location: proposiciones.php?id_minuta=$id_minuta&msg=$msg&prop=$prop&nombre=$nombre");
		}
}



include("conexion.php");
$cad = $dato;
if ( $insertado == "1" )
{	$fila = explode(":",$dato);		
	$enfecha  = explode("/", $fila[1]);
	$en_fecha = "$enfecha[0]-$enfecha[1]-$enfecha[2]";
	$fechad = explode("/", $fila[2]);
	$fecha = "$fechad[0]-$fechad[1]-$fechad[2]";
	$horad = explode ("/", $fila[5]);
	$hora = "$horad[0]:$horad[1]";
	$sql="INSERT INTO ".
	"minuta (codigo,elab_por,en_fecha,tipo_min,fecha,hora,lugar,id_minuta,num_codigo,comentario)".
	"VALUES ('$fila[0]','$fila[3]','$en_fecha','$fila[4]','$fecha','$hora','$fila[6]','$id_minuta','$num_cod','$fila[7]')";
	mysql_db_query($db,$sql,$link);												
	$insertado = "2";
}
if ( $insertado == "0" )
{	$fila = explode(":",$dato);
	$enfecha  = explode("/", $fila[1]);
	$en_fecha = "$enfecha[0]-$enfecha[1]-$enfecha[2]";
	$fechad = explode("/", $fila[2]);
	$fecha = "$fechad[0]-$fechad[1]-$fechad[2]";
	$horad = explode ("/", $fila[5]);
	$hora = "$horad[0]:$horad[1]";	
	$sql = "UPDATE minuta SET codigo='$fila[0]',elab_por='$fila[3]',en_fecha='$en_fecha',tipo_min='$fila[4]',
			fecha='$fecha', hora='$hora',lugar='$fila[6]', comentario='$fila[7]' WHERE id_minuta='$id_minuta'";
	mysql_db_query($db,$sql,$link);
	$insertado = "2";
}
if ($Terminar){ header("location: minuta.php?cad=$cad&id_minuta=$id_minuta&verif=$verif&insertado=$insertado");}
if ($reg_form)
{	
	session_start();
	include("conexion.php");
	
	$sql1a="SELECT MAX(id_orden)+1 AS id_or FROM ordenes"; 
	$result1a=mysql_db_query($db,$sql1a,$link);
	$row1a=mysql_fetch_array($result1a);
	$var="ajuntos_bo_".$row1a[nomb_archivo];
	$adjuntos_bo=$_SESSION[$var];
	$var_hash="ajuntos_bo_hash_".$row1a[hash_archivo];
	$adjuntos_bo_hash=$_SESSION[$var_hash];
	
	if($adjuntos_bo){ 
		$sql1="UPDATE asistentes SET prop='$prop', adjunto= '".$adjuntos_bo."', hash_archivo = '".$adjuntos_bo_hash."' WHERE nombre='$nombre' AND id_minuta='$id_minuta'";
		copy($archivo,"archivos proposiciones/".$archivo_name);
	}else{
		$sql1="UPDATE asistentes SET prop='$prop' WHERE nombre='$nombre' AND id_minuta='$id_minuta'";
	}
	mysql_db_query($db,$sql1,$link);
	$_SESSION[$var] = NULL;
	$_SESSION[$var_hash] = NULL;
	header("location: proposiciones.php?id_minuta=$id_minuta&verif=2&dato=$dato&insertado=$insertado");
}
include("top.php");
$id_minuta=($_GET['id_minuta']);

require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "nombre",  "Nombre, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "prop",  "Proposicion, $errorMsgJs[empty]" );
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

<table width="58%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
<form action="<?php echo $PHP_SELF ?>" method="post" enctype="multipart/form-data" name="form2" onKeyPress="return Form()">
	<input name="id_minuta" type="hidden" value="<?php echo $id_minuta;?>">
	<input name="verif" type="hidden" value="<?php if ($_GET[verif]) {echo $_GET[verif];}else{echo "1";};?>">
	<input name="dato" type="hidden" value="<?php echo $dato; ?>">
	<input name="num_cod" type="hidden" value="<?php echo $num_cod; ?>">
	<input name="insertado" type="hidden" value="<?php echo $insertado; ?>">
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="4" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">PROPOSICIONES</font></th>
          </tr>
          <tr> 
            <th width="10%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="45%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NOMBRE</font></th>
			<th width="45%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">PROPOSICION</font></th>
			<th width="45%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ARCHIVO ADJUNTO</font></th>
          </tr>
          <?php
		
		$cont=0;	
		$sql = "SELECT * FROM asistentes WHERE id_minuta='$id_minuta' AND prop IS NOT NULL";
		$result=mysql_db_query($db,$sql,$link);
		$desc=array();
		while($row=mysql_fetch_array($result)) 
  		{
			  $cont=$cont+1;
			  ?>
			  <tr> 
				<td align="center">&nbsp;<?php echo $cont?></td>
				<?php 	$sql5 = "SELECT * FROM users WHERE login_usr='$row[nombre]'";
					$result5 = mysql_db_query($db,$sql5,$link);
					$row5 = mysql_fetch_array($result5);
					if (!$row5[login_usr])
					{echo "<td align=\"center\">&nbsp;$row[nombre]</td>";}
					else
					{echo "<td align=\"center\">&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";}?>
				<td align="center">&nbsp;<?php echo $row[prop]?></td>
				<?php array_push($desc,"'".$row[nombre]."'");?>
			<td align="center">
			<table>
				<?php
					if($row[adjunto] <> "") 
					{	echo "<tr><td align = center><a href='adjuntosa.php?id_minuta=$id_minuta&nom=".$row[nombre]."&cont=$cont&pag=prop'>VER	
						ARCHIVOS</a></td></tr>";
					}
			    ?>
			</table>
			</td>
			  </tr>
			  <?php 
		 }
		 ?>
          <tr> 
            <td colspan="3" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="23" nowrap height="7"><strong> </strong></td>
            <td width="190" nowrap><div align="center"><strong> 
                <select name="nombre" id="select8">
                  <option value="0"></option>
                  <?php 
				  $lista=implode(", ",$desc);
				  if(strlen($lista)>0) $sql0 = "SELECT * FROM asistentes WHERE id_minuta='$id_minuta' AND nombre NOT IN ($lista)";
				  else $sql0 = "SELECT * FROM asistentes WHERE id_minuta='$id_minuta'";
				  $result0=mysql_db_query($db,$sql0,$link);
				  while ($row0=mysql_fetch_array($result0)) 
					{
						if($row0[tipo]=='Nuevo_ext' || $row0[tipo]=='Externo')
						{
							if($nombre == $row0[nombre])
							{
								echo "<option value=\"$row0[nombre]\" selected>$row0[nombre] </option>";
							}else{
								echo "<option value=\"$row0[nombre]\">$row0[nombre] </option>";
							}
						}
						else{
							$sql_usr="SELECT CONCAT(nom_usr,' ',apa_usr,' ',ama_usr) AS nombre FROM users WHERE login_usr='$row0[nombre]'";
							$res_usr=mysql_db_query($db,$sql_usr,$link);
							$row_usr=mysql_fetch_array($res_usr);
							if($nombre == $row0[nombre])
							{	
								echo "<option value=\"$row0[nombre]\" selected>$row_usr[nombre] </option>";
							}
							else{
								echo "<option value=\"$row0[nombre]\">$row_usr[nombre] </option>";
							}
						}
			   		}
			 ?>
                </select>
                </strong></div></td>
            <td width="198" nowrap height="7"><div align="center"><strong>
                <textarea name="prop" cols="40" rows="2" id="prop"><?php=$prop?></textarea>
                </strong> </div></td>
		  <!--------------->
		  <td align="center">
				<table>
				<!---------------------------------------------------------------------------------------------->
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
			    <!---------------------------------------------------------------------------------------------->
					<tr> 
						<td colspan="2"><div align="left"><strong><font size="2">Archivos Adjuntos:</font></strong></div></td>
				    </tr>
					<?php 	$i=0;
							foreach($adjuntos_bo as $valor){
							echo "<tr><td><a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor</a>&nbsp;MD5: 	
							$adjuntos_bo_hash[$i]</td></tr>";
							$i++;
							}
					}
					
					?>
					<tr> 
						<?php 	$sql5="SELECT * FROM control_parametros";
							$result5=mysql_db_query($db,$sql5,$link);
							$row5=mysql_fetch_array($result5);
						?>
						<td width="93%" align="center"><div align="left"><b><font size="2" face="Arial, Helvetica, sans-serif"><br>
						Enviar Archivo Adjunto <br> </font></b><font size="2" face="Arial, Helvetica, sans-serif">( 
						tipo : .gif &nbsp;&nbsp;.jpg&nbsp;&nbsp; .doc &nbsp;&nbsp;&nbsp;&nbsp;y &nbsp;&nbsp;tamano maximo : 
						<?php echo $row5[tam_archivo];?> Mb ) : </font> </div>
						</td>
				    </tr>
					<tr>
						<td align="center"><input name="archivo" type="file" id="archivo"></td>
					</tr>
					<tr>
						<td align="center">
							<input type="submit" name="adjuntar" value="ADJUNTAR" onClick="return validar();">
							<input type="hidden" name="cancelar" value="BORRAR ADJ" >
						</td>
					</tr>
				</table>
            </td>	
		  <!--------------->
          </tr>
          <tr> 
            <td height="28" colspan="4" nowrap> <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR DATOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr>
</form>
</table>
<script language="javascript1.2">
		<?php
		 print "function msgFile () {\n
				alert (\"Atencion, solamente puede enviar archivos menor o igual a $row5[tam_archivo] Mb de tamano.\\n \\nMensaje generado por GesTor F1.\");\n
				}\n";
			if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
			
		} ?>



function validar()
{
	if(document.form2.archivo.value == "")
	{
		mens = "Primero debe adjuntar un archivo\n";
		mens = mens + "\nMensaje generado por GesTor F1.";
		alert(mens);
		return false;
	}
	else{ return true;}
	
}		
</script>
<?php include("top_.php");?>
