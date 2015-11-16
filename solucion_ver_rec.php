<?php

if ($RETORNAR){
if ($op==2)
header("location: listae.php");
 else
 {
	//
	if($tipificacion == 1)
	{
		header("location: lista_tipos.php?pg=$pg");
	}else
	{
		header("location: lista_reclamos.php?pg=$pg");
	}
	//
 }
}

include("top.php");
$sql = "SELECT * FROM solucion_reclamos WHERE CReclamo='$id_orden'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result); 
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

<table width="56%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" background="images/fondo.jpg">
  <tr> 
    <td height="360">
	<table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
        <tr> 
          <th background="images/main-button-tileR1.jpg" height="23"><font color="#FFFFFF">SOLUCION RECLAMO </font></th>
        </tr>
	  </table>
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
	    <!--DWLayoutTable-->
        <tr> 
          <td height="18" colspan="3" align="center"> <div align="justify"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Reclamo              Nro. : </strong><?php print $id_orden;?> </font></div></td>
        </tr>
        <tr> 
          <td height="18" colspan="3" align="center"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong> 
              Descripcion:</strong> 
              <?php $sqlTmp="SELECT * FROM reclamos WHERE CReclamo=$_GET[id_orden]";
				$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
				print $ordenTmp[TGlosa];
			?>
              </font></div></td>
        </tr>
        <tr> 
          <td colspan="3"><hr></td>
        </tr>
        <tr> 
          <td colspan="3"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Fecha 
            de Ejecucion de Solucion: </strong><?php echo $row[TFechaSolucion];?></font></td>
        </tr>
        <tr> 
          <td colspan="3"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Codigo de Solucion del Reclamo:</strong> <?php 
		  switch ($row[TResultado]) {
    	case "1":
        echo "A Favor del Cliente";
        break;
    	case "2":
        echo "A Favor de la Entidad";
        break;
		}
		  
		  ?>&nbsp;&nbsp;</font></td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Detalles 
              de la Solucion :</strong></font></div></td>
        </tr>
        <tr> 
          <td width="22"><div align="center"></div></td>
          <td width="509"><div align="justify"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $row[TGlosaRespuesta];?></font></div></td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
        <?php
			    
		?>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
        
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
		          <?php 
		 echo "<tr><td width=\"5%\"></td>";
		if (!$row[nomb_archivo]){echo "<td width=\"95%\"><div align=\"center\"><font face=\"arial,helvetica\" size=\"2\"><strong>ARCHIVO ADJUNTO : </strong>Ninguno</font></div></td>";}
		else {
			$adj=explode("|",$row[nomb_archivo]);
			$adj_hash=explode("|",$row[hash_archivo]);
			echo "<td width=\"95%\"><div align=\"center\"><font face=\"arial,helvetica\" size=\"2\"><strong>Archivos Adjunto : </strong><br>";
			$i=0;
			foreach($adj as $valor){
				echo"<a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor</a> MD5: $adj_hash[$i]<br>";
				$i++;
				}
			echo "</font></div></td>";
//			echo"<td width=\"95%\"><div align=\"center\"><font face=\"arial,helvetica\" size=\"2\"><strong>Archivo Adjunto : </strong><a href=\"archivos adjuntos/".$row[nomb_archivo]."\" target=\"_blank\">$row[nomb_archivo]</a></font></div></td>";
		}
	    echo "</tr>";
		 ?>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>

<form name="form1" method="post" action="" onKeyPress="return Form()">
 <input name="op" type="hidden" value="<?php echo $op;?>">
 <input name="tipificacion" type="hidden" value="<?php=$tipificacion?>">
 <input name="pg" type="hidden" value="<?php=$pg?>">

  <div align="center">
    <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
  </div>
</form>


<?php include("top_.php");?>
