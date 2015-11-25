<title>GesTor PCN - Riesgos</title>
<meta content="Autor:" name="Limberg Illanes Murillo">
<style type="text/css">
<!--
.mio {
	height: 20px;
	width: 30px;
}
.mio2 {
	height: 20px;
	width: 40px;
}
-->
</style>
  <?php 	include("conexion.php");
  
  if(isset($_REQUEST['codigo']))
	$codigo=$_REQUEST['codigo'];
   
  if(isset($_REQUEST['campo']))
	$campo=$_REQUEST['campo'];	
 
  if(isset($_REQUEST['orden']))
	$orden=$_REQUEST['orden'];	
	if(isset($_REQUEST['variable1']))
		$variable1=$_REQUEST['variable1'];
	else
		$variable1="";
	
  		if(isset($cons)){ 
			$cons=str_replace("*",", ",$cons);
			$sql = "SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y %H:%i:%s') as fecha1 FROM riesgo_respuesta WHERE id_riesgo_0 IN ($cons) LIMIT 1";}
  		else $sql = "SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y %H:%i:%s') as fecha1 FROM riesgo_respuesta WHERE id_riesgo_0='$variable1' LIMIT 1";
		$result=mysql_fetch_array(mysql_db_query($db,$sql,$link));
  ?>
  
<table width="70%" border="1" align="center" cellpadding="0" cellspacing="2">
  <tr> 
    <th height="21" colspan="4"><strong><font size="2" face="Arial, Helvetica, sans-serif">RESULTADOS 
      DE EVALUACION</font></strong></th>
  </tr>
  <tr align="center"> 
    <td height="21" colspan="4"> <table width="100%" border="0">
        <tr> 
          <td width="12%" height="21" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif">TITULO:</font></strong> </td>
          <td width="31%"> 
            <?php
			  if(isset($cons)){ 
				$sql_titu="SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y') as fecha1 FROM riesgo_respuesta WHERE id_riesgo_0 IN ($cons) GROUP BY id_riesgo_0";
				$res_titu=mysql_db_query($db,$sql_titu,$link);
				while($row_titu=mysql_fetch_array($res_titu)){
					echo "- ".$row_titu['titulo']."<br>";
				}
				}else{echo $result['titulo'];}
			  ?>
          </td>
          <td width="25%" valign="top"> <div align="right"><strong><font size="2" face="Arial, Helvetica, sans-serif">DESCRIPCION 
              :</font></strong></div></td>
          <td width="32%" valign="top"> 
            <?php if(isset($cons)){echo "CONSOLIDADO";}else{echo $result['descripcion'];}?>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr align="center"> 
    <td colspan="4"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;FECHA:</font></strong> 
      <?php echo $result['fecha1']?>
    </td>
  </tr>
  <tr align="center"> 
    <td width="74" class="menu"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NRO</strong></font></td>
    <td width="323" class="menu"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DESCRIPCION</strong></font></td>
    <td width="100" class="menu"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SUMA</strong></font></td>
    <td width="178" class="menu"><strong><font size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></td>
  </tr>
  <?php
  		if(isset($cons)) $sql = "SELECT * FROM riesgo_respuesta WHERE id_riesgo_0 IN ($cons) ORDER BY val DESC";
		else $sql = "SELECT * FROM riesgo_respuesta WHERE id_riesgo_0='$variable1' ORDER BY val DESC";
		$result=mysql_db_query($db,$sql,$link);
		$titulox="";
		while($row=mysql_fetch_array($result)) {
			
			$sql2 = "SELECT * FROM riesgo_pregunta WHERE id_riesgo='$row[id_riesgo]'";
			$result2=mysql_db_query($db,$sql2,$link);
			$row2=mysql_fetch_array($result2);
			$desc=$row2['desc_riesgo'];
			if(isset($cons)) $titulox=" - ".$row['titulo'];
			echo "<tr align=\"center\">";
			echo " <td width=\"59\">".$row['id_riesgo']."</td>";
			echo " <td width=\"408\">".$desc.$titulox."</td>";
			echo " <td width=\"68\">$row[val]</td>";
			echo " <td width=\"68\">&nbsp;$row[obs]</td>";
			echo "</tr>";
       	}
	 ?>
</table>
<table width="70%" border="0" align="center">
  <tr> 
    <td width="12%" height="34"><strong><font size="2" face="Arial, Helvetica, sans-serif">Promedio 
      : </font></strong></td>
    <td width="88%"><font size="2" face="Arial, Helvetica, sans-serif"> 
      <?php
	  if(isset($cons)) $sql8 = "SELECT COUNT(*) AS num,SUM(val)AS suma FROM riesgo_respuesta WHERE id_riesgo_0 IN ($cons)";
	  else $sql8 = "SELECT COUNT(*) AS num,SUM(val)AS suma FROM riesgo_respuesta WHERE id_riesgo_0='$variable1'";
	  $result8 = mysql_db_query($db,$sql8,$link);
	  $row8 = mysql_fetch_array($result8);
	  $prom=round($row8['suma']/$row8['num'],2);
	  echo "&nbsp;$prom";
	  ?>
      </font></td>
  </tr>
</table>
