<?php
if (isset($_REQUEST['RETORNAR'])){
header("location:lista.php");
if ($op==2) {
header("location: listae.php"); }
 else
 {
	//
	if($tipificacion == 1)
	{
		header("location:lista_tipos.php?pg=$pg");
	}else
	{
		header("location:lista.php?pg=$pg");
	}
	//
 }
}

include("top.php");
require_once('funciones.php');
$id_orden=SanitizeString($_GET['id_orden']);
$sql = "SELECT *, DATE_FORMAT(fecha_sol, '%d/%m/%Y') AS fecha_sol, DATE_FORMAT(fecha_sol_e, '%d/%m/%Y') AS fecha_sol_e FROM solucion WHERE id_orden='$id_orden'";
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
          <th background="images/main-button-tileR2.jpg" height="25"><font color="#FFFFFF">SOLUCION</font></th>
        </tr>
		</table>
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
        <tr> 
          <td height="18" colspan="3" align="center"> <div align="justify"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Orden 
              Nro. : </strong><?php print $id_orden;?> </font></div></td>
        </tr>
        <tr> 
          <td height="18" colspan="3" align="center"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong> 
              Descripcion:</strong> 
              <?php
				
				$sqlTmp="SELECT desc_inc FROM ordenes WHERE id_orden='$id_orden'";
				$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
				print $ordenTmp['desc_inc'];
			?>
              </font></div></td>
        </tr>
        <tr> 
          <td colspan="3"><hr></td>
        </tr>
        <tr> 
          <td colspan="3"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Solucionado 
            por:</strong> 
            <?php 
		  		$sql5 = "SELECT * FROM users WHERE login_usr='$row[login_sol]'";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
 				echo $row5['nom_usr']."&nbsp;".$row5['apa_usr']."&nbsp;".$row5['ama_usr'];?>
            </font></td>
        </tr>
        <tr> 
          <td colspan="3"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Fecha 
            de Ejecucion de Solucion: </strong><?php echo $row['fecha_sol_e'];?></font></td>
        </tr>
        <tr> 
          <td colspan="3"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Fecha 
            de solucion:</strong> <?php echo $row['fecha_sol'];?>&nbsp;&nbsp; <strong>Hora:</strong> 
            <?php echo $row['hora_sol'];?></font></td>
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
          <td width="509"><div align="justify"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $row['detalles_sol'];?></font></div></td>
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
          <td colspan="2"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Medidas 
              Preventivas Recomendadas</strong> </font></div></td>
        </tr>
        <tr> 
          <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></div></td>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $row['medprev_sol'];?></font></td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
		          <?php 
		 echo "<tr><td width=\"5%\"></td>";
		if (!$row['nomb_archivo']){echo "<td width=\"95%\"><div align=\"center\"><font face=\"arial,helvetica\" size=\"2\"><strong>ARCHIVO ADJUNTO : </strong>Ninguno</font></div></td>";}
		else {
			$adj=explode("|",$row['nomb_archivo']);
			$adj_hash=explode("|",$row['hash_archivo']);
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
