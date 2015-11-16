<?php if (isset($RETORNAR)){header("location: lista_ordenrev1.php");}

include("conexion.php");
require_once('funciones.php');
$num=SanitizeString($num);
$sql5="SELECT * FROM control_parametros";
$result5=mysql_db_query($db,$sql5,$link);
$row5=mysql_fetch_array($result5);

if (isset($reg_form)) {
	if($archivo != "" or !empty($archivo))
	{ 
		$sql = "select *from problemas where probIdOrden = '$num'";
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		$numRow = mysql_num_rows($res);
		if($numRow == 0)$numero = 0;
		else $numero = $numRow;
		$file = $archivo_name; 
		$separar = explode('.',$file);
		$ext = $separar[1];
		$exten = explode(".",$archivo_name); 
		$long = count($exten)-1; 
		$arch_nomb = "prob".$num."_".$numero.".".$exten[$long];
		if($ext!='php') {
			$sql = "insert into problemas (probIdOrden,probDesc, probArchivos) values($num,'$txtObservacion','$arch_nomb')";
			mysql_db_query($db,$sql,$link);
		}
		copy($archivo,"archivos adjuntos/".$arch_nomb);
		header("location: adjuntar_prob.php?num=$num");
	}else{$msg = "Primero debe elegir un archivo para ser adjuntado\\n";}
}
include("top.php");

?>

<body leftmargin="0" topmargin="0"><center>
  <table width="60%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th colspan="8" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
        ARCHIVOS ADJUNTOS</font></th>
    </tr>
    <tr> 
      <th width="13%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
      <th width="35%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NOMBRE</font></th>
      <th width="52%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">OBSERVACIONES</font></th>
    </tr>
    <?php
		$cont=1;	
		$sql2 = "SELECT * FROM problemas WHERE probIdOrden='$num' order by probArchivos";
		$result2=mysql_db_query($db,$sql2,$link);
		while($row2=mysql_fetch_array($result2))
		{
		//$files=explode("*",$row2['probArchivos']);
		//if($files[0]<>""){
			
			//foreach($files as $valor){
				echo "<tr align=\"center\">";
				echo "<td>".$cont++."</td>";
				echo "<td align=\"center\"><a href=\"archivos adjuntos/$row2[probArchivos]\" target=\"_blank\">$row2[probArchivos]</a></td>";
				echo "<td>$row2[probDesc]&nbsp;</td>";
				echo "</tr>";
			
			//}
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
          <td width="26%" align="center"><br> </td>
          <td width="74%" align="center"><font size="2" face="Arial, Helvetica, sans-serif">( 
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