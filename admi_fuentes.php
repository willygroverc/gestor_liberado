<?php 
if (isset($RETORNAR)){header("location: lista_ordenrev1.php");}

include("conexion.php");
$sql5="SELECT * FROM control_parametros";
$result5=mysql_db_query($db,$sql5,$link);
$row5=mysql_fetch_array($result5);

if (isset($reg_form)) {
	if($archivo != "" or !empty($archivo))
	{ 			require_once('funciones.php');
				$num=SanitizeString($num);
				$txtObservacion=SanitizeString($txtObservacion);
				$cadena=SanitizeString($cadena);
				$sql = "insert into problemas (probIdOrden) values($num,'$txtObservacion','$cadena')";
				mysql_db_query($db,$sql,$link);
			
			
			copy($archivo,"archivos adjuntos/".$arch_nomb);
			header("location: adjuntar_prob.php?num=$num");
	}else{
		$msg = "Primero debe elegir un archivo para ser adjuntado\\n";
	}
} 
include("top.php");
?>

<body leftmargin="0" topmargin="0"><center>
<table width="50%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <th colspan="7" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
      ARCHIVOS ADJUNTOS</font></th>
  </tr>
  <tr> 
    <th width="20%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
    <th width="80%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NOMBRE</font></th>
	<th width="80%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">OBSERVACIONES</font></th>
  </tr>
  <?php
		$cont=0;	
		$sql2 = "SELECT probArchivos FROM problemas WHERE probIdOrden='$num'";
		$result2=mysql_db_query($db,$sql2,$link);
		$row2=mysql_fetch_array($result2);
		$files=explode("*",$row2['probArchivos']);
		if($files[0]<>""){
			$c=1;
			foreach($files as $valor){
				echo "<tr><td align=\"center\">$c</td><td align=\"center\"><a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor</a></td><td align = 'center'>observaciones</td></tr>";
				$c++;
			}
		}
		?>
</table>

<form name="form1" method="post" enctype="multipart/form-data">
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" >
	<th>SUBIR ARCHIVO ADJUNTO</th>
    <tr> 
      <td> 
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
        <tr> 
          <td width="25%" align="center"><br> </td>
          <td width="75%" align="center"><font size="2" face="Arial, Helvetica, sans-serif">( 
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
		<?php
			$con = "select *from problemas where probIdOrden = $num";
			$rs = mysql_query($con, $link);
			$res = mysql_fetch_array($rs);
		?>
		<tr>
			<td align="right">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><strong>Observaciones : </strong></font></td>
			<td><textarea name="txtObservacion" cols="50" rows="4"><?php=$res['probDesc']?></textarea></td>
		</tr>
        <tr> 
          <td height="43" colspan="2" align="center"><br><input name="reg_form" type="submit" value="ADJUNTAR">
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
</script>

<?php include("top_.php");?>