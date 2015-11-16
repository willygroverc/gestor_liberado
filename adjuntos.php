<?php
if(isset($retornar)){
	if($pag == 'minlast') header("location: minuta_last.php?id_minuta=$id_minuta");
	else header("location: minuta.php?id_minuta=$id_minuta");
}
include("top.php");
?>
<table width="50%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
  <tr> 
  <?php
	include("conexion.php");
		$sql = "select *from asistentes where nombre = '$nom' and id_minuta = '$id_minuta'";
		$res = mysql_db_query($db,$sql,$link);
		$row = mysql_fetch_array($res);
  ?>
    <th colspan="7" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
      PROPOSICION  No. 
      <?php=$cont?>
      </font></th>
  </tr>
  <tr> 
    <td colspan="2">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php=$row[prop]?>
	<br><br>
	</td>
  </tr>
  <tr> 
    <th colspan="7" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
      ARCHIVOS ADJUNTOS</font></th>
  </tr>
  <tr> 
    <th width="34%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Archivo</font></th>
    <th width="66%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">MD5</font></th>
  </tr>
<?php
		$adjuntos_bo = explode("|",$row[adjunto]);
		$adjuntos_bo_hash = explode("|",$row[hash_archivo]);
		$i=0;
		foreach($adjuntos_bo as $valor){
		 echo "<tr><td align = center><a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor</a></td>
		 <td>&nbsp;&nbsp;MD5: $adjuntos_bo_hash[$i]</td></tr>";
		 $i++;
		}
?>
</table>
<form name="form1" method="post" action="">
  <div align="center">
    <input name="retornar" type="submit" id="retornar" value="RETORNAR">
  </div>
</form>
<p>&nbsp;</p>
<?php
include("top_.php");
?>