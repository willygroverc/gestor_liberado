<?php
if (isset($_REQUEST['RETORNAR'])){header("location: lista_contratos.php");}

include("conexion.php");
$sql5="SELECT * FROM control_parametros";
$result5=mysql_db_query($db,$sql5,$link);
$row5=mysql_fetch_array($result5);

if (isset($_REQUEST['reg_form'])) {
	$number = isset($num);
	include("conexion.php");
	$sql5="SELECT * FROM control_parametros";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);

	$extension = explode(".",$archivo_name); 
	$num = count($extension)-1; 
	$tam_max=1048576*$row5['tam_archivo'];
	
	if($archivo_size < $tam_max){
		$sql2 = "SELECT file, observacion FROM contratodatos WHERE IdContra = $_GET[id_contrato]";
		$result2=mysql_db_query($db,$sql2,$link);
		$row2=mysql_fetch_array($result2);
		$files=explode("*",$row2['file']);
		$obs = explode("*",$row2['observacion']);
	
		if($files[0]=="") $numero=0;
		else $numero=count($files);
		$exten = explode(".",$archivo_name); 
		/*print_r($exten);
                exit;*/
                $long = count($exten)-1; 
		$arch_nomb = "min".$num."_".$numero.".".$exten[$long];
		
		if($files[0]=="") $cadena=$arch_nomb;
		else {
			array_push($files,$arch_nomb);
			$cadena=implode("*",$files);
		}
		
		if($obs[0]=="") $sCad = $txtObservacion;
		else {
			array_push($obs,$txtObservacion);
			$sCad=implode("*",$obs);
		}
		$sql="UPDATE contratodatos set file='$cadena', observacion ='$sCad' WHERE IdContra = $_GET[id_contrato]";
		echo "WWW:".$sql;
		exit;
		mysql_query($sql);
		copy($archivo,"Archivos Adjuntos/".$arch_nomb);
		//echo $sql;
		header("location: contrato_file.php?id_contrato=$_GET[id_contrato]");
	}else{
		unset($msg);
		$msg="EL TAMA�O DEL ARCHIVO ADJUNTO NO DEBE SER MAYOR A ".$row5['tam_archivo']." Mb";
	}
}
include("top.php");
?>

<body leftmargin="0" topmargin="0"><center>
<table width="50%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <th colspan="7" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
      ARCHIVOS ADJUNTOS</font></th>
  </tr>
  <tr> 
    <th width="20%" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
    <th width="80%" nowrap background="images/main-button-tileR1.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NOMBRE</font></th>
	<th width="80%" nowrap background="images/main-button-tileR1.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">OBSERVACIONES</font></th>
  </tr>
  <?php
		$cont=0;	
                //echo $_GET['id_contrato'];
		$sql2 = "SELECT file,observacion FROM contratodatos WHERE IdContra='$_GET[id_contrato]'";
		$result2=mysql_db_query($db,$sql2,$link);
		$row2=mysql_fetch_array($result2);
		$files=explode("*",$row2['file']);
		$obs = explode("*",$row2['observacion']);
		if($files[0]<>"" ){
			$c=1;
			$i = 0;
			foreach($files as $valor){
				echo "<tr><td align=\"center\">$c</td><td align=\"center\"><a href=\"Archivos Adjuntos/".$valor."\" target=\"_blank\">$valor</a></td><td align=\"center\">$obs[$i]</td></tr>";
				$c++; $i++;
			}
		}
		?>
</table>

<form name="form1" method="post" enctype="multipart/form-data">
<input type="hidden" name="id_agenda" value="<?php echo $id_agenda; ?>">
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" >
	<th background="images/main-button-tileR1.jpg">SUBIR ARCHIVO ADJUNTO</th>
    <tr> 
      <td> 
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
        <tr> 
          <td width="28%" align="center"><br> </td>
          <td width="72%" align="center"><font size="2" face="Arial, Helvetica, sans-serif">( 
              tipo : .gif &nbsp;&nbsp;.jpg&nbsp;&nbsp; .doc &nbsp;&nbsp;&nbsp;&nbsp;y 
              &nbsp;&nbsp;tamano maximo : <?php echo $row5['tam_archivo'];?> 
              Mb ) : </font> </div></td>
        </tr>
        <tr> 
          <td colspan="2" align="center"> <div align="center">
            <input name="archivo" type="file" size="60" value="<?php print $arch_adj;?>">
            <br>
            </div></td>
        </tr>
		
		<tr>
			<td align="right">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><strong>Observaciones : </strong></font></td>
			<td><textarea name="txtObservacion" cols="50" rows="4"></textarea></td>
		</tr>
		
        <tr> 
        <td height="43" colspan="2" align="center"><br><input name="reg_form" type="submit" value="ADJUNTAR" onClick="return validar()">
		      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input name="RETORNAR" type="submit" value="RETORNAR">
		  </td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>


<script language="JavaScript">
		<!-- 
		<?php 	if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
			
		} ?>
//-->

function validar()
{
	msg1 = "\nMensaje generado por GesTor F1.";
	sCad = "";
	if(document.form1.archivo.value == ""){sCad = sCad + "Primero debe adjuntar un archivo\n";}
	if(document.form1.txtObservacion.value == ""){sCad = sCad + "Debe llenar el campo de Observaciones\n";}
	if(sCad == ""){return true;}
	else{
		sCad = sCad + msg1;
		alert(sCad);
		return false;
	}
}

</script>

<?php include("top_.php");?>