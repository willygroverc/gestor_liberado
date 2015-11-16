<?php
if(isset($retornar))
{   //
	
		header("location: lista_reclamos.php?pg=$pg&Naveg=Ordenes%20de%20Trabajo");
	
	//
}
include("top.php");
?>
<table width="70%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
  <tr> 
  <?php
	include("conexion.php");
  	$sql="SELECT * FROM reclamos WHERE CReclamo='$id_orden'";
	$res=mysql_db_query($db,$sql,$link);
	$row=mysql_fetch_array($res);
  ?>
    <th colspan="7" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
      RECLAMO No. 
      <?php=$id_orden?>
      </font></th>
  </tr>
  <tr> 
    <td colspan="3">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php=$row[TGlosa]?>
	<br><br>
	</td>
  </tr>
  <tr> 
    <th colspan="8" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
      ARCHIVOS ADJUNTOS</font></th>
  </tr>
  <tr> 
    <th width="20%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Archivo</font></th>
  </tr>
<?php
$adj=explode("|",$row[TDocumentosAdjuntos]);
$adj_hash=explode("|",$row[hash_archivo]);
$adj_obs=explode("|",$row[observaciones]);
$i=0;
foreach($adj as $valor){
	echo "<tr><td align=\"center\"><a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor</a></td></tr>";
	$i++;
}
?>
</table>
<form name="form1" method="post" action="">
<input name="tipificacion" type="hidden" value="<?php=$tipificacion?>">
<input name="pg" type="hidden" value="<?php=$pg?>">

  <div align="center">
    <input name="retornar" type="submit" id="retornar" value="RETORNAR">
  </div>
</form>
<p>&nbsp;</p>
<?php
include("top_.php");
?>