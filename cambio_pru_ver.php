<?php include("datos_gral.php"); ?>
<html>
<head>
<style>
.cl2 { FONT-SIZE:8PT;}
</style>
<title>Gestor F1 - Pruebas</title>	
</head>
<body>

<form name="form1" method="post" onKeyPress="return Form()">
  <table width="95%" border="1" align="center">
    <tr> 
      <th><font face="Arial, Helvetica, sans-serif">PRUEBAS 
        <?php	$tp2=md5($orden);
	  		if($tp=="258db52a0b75ba2448af531309ad5eac_".$tp2)
			{	echo "USUARIAS"; 
				$tpo="1";
			 	$sql_ed="SELECT *, DATE_FORMAT(fecha_reg, '%d/%m/%Y') AS fecha_reg, DATE_FORMAT(fecha_pru, '%d/%m/%Y') AS fecha_pru FROM cambios_prueba WHERE id_orden='$orden' AND tipo_pru='1'";
			}
			elseif($tp=="7d428547b8723786029735cde7b75d7d_".$tp2)
			{
				echo "DE SISTEMAS"; 
				$tpo="2";
				$sql_ed="SELECT *, DATE_FORMAT(fecha_reg, '%d/%m/%Y') AS fecha_reg, DATE_FORMAT(fecha_pru, '%d/%m/%Y') AS fecha_pru FROM cambios_prueba WHERE id_orden='$orden' AND tipo_pru='2'";
			}
			elseif($tp=="f4b29b15eee509a8fa39344471561d29_".$tp2)
			{
				echo "DE SEGURIDAD"; 
				$tpo="3";
				$sql_ed="SELECT *, DATE_FORMAT(fecha_reg, '%d/%m/%Y') AS fecha_reg, DATE_FORMAT(fecha_pru, '%d/%m/%Y') AS fecha_pru FROM cambios_prueba WHERE id_orden='$orden' AND tipo_pru='3'";
			}
			$result_ed=mysql_db_query($db,$sql_ed,$link);
			$row_ed=mysql_fetch_array($result_ed);
	  ?>
        <input name="tpo" type="hidden" value="<?php echo $tpo;?>">
        </font> </th>
    </tr>
    <tr> 
      <td height="123"> <table width="100%" border="0">
          <tr> 
            <td width="2%">&nbsp;</td>
            <td width="22%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Orden 
              Nro.:</strong></font></td>
            <td width="24%"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $orden;?></font></td>
            <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Fecha 
              y Hora de Registro:</strong></font></td>
            <td width="23%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo "$row_ed[fecha_reg] $row_ed[hora_reg]";?></font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td width="2%" height="21">&nbsp;</td>
            <td width="22%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Descripcion:</strong></font></td>
            <td colspan="4"><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php $sqlTmp="SELECT desc_inc FROM ordenes WHERE id_orden=$orden";
				$ordenTmp=mysql_fetch_array(mysql_query($sqlTmp));
				print $ordenTmp['desc_inc'];
				?>
              &nbsp;</font></td>
          </tr>
          <tr> 
            <td height="21">&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>Fecha 
              de la Prueba:</strong></font></td>
            <td colspan="4"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "$row_ed[fecha_pru]";?></font></td>
          </tr>
          <tr> 
            <td height="21">&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>Responsable:</strong></font></td>
            <td width="37%"><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php
	  	$sql_a = "SELECT asig FROM asignacion WHERE id_orden='$orden' ORDER BY id_asig DESC limit 1";
		$result_a=mysql_query($sql_a);
		$row_a=mysql_fetch_array($result_a); 
		
		$sql_a1 = "SELECT asig FROM asignacion WHERE id_asig='$row_a[id_asig]'";
		$result_a1=mysql_db_query($db,$sql_a1,$link);
		$row_a1=mysql_fetch_array($result_a1);
		
		$sql4 = "SELECT nom_usr, apa_usr, ama_usr, cargo_usr FROM users WHERE login_usr='$row_a[asig]'";
		$result4=mysql_db_query($db,$sql4,$link);
		$row4=mysql_fetch_array($result4);
		echo $row4['nom_usr']." ".$row4['apa_usr']." ".$row4['ama_usr'];
	  ?>
              </font></td>
            <td width="11%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Cargo:</strong></font></td>
            <td width="28%" colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row4['cargo_usr']?></font></td>
          </tr>
          <tr> 
            <td height="21">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
          </tr>
        </table></td>
		</tr>
    <tr> 
      <td> <table width="100%" border="0">
          <tr> 
            <td width="2%"><font size="2">&nbsp;</font></td>
            <td width="26%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Objetivo 
              de la Prueba:</strong></font></td>
            <td width="72%"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row_ed['obj_pru'];?></font></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
	<tr>
	<td>
    <table width="100%" border="1">
	<tr> 
      <th colspan="11"><font size="2" face="Arial, Helvetica, sans-serif"> TIPOS 
        DE PRUEBA</font></th>
    </tr>
    <tr> 
      <th width="45"><font size="1,8" face="Arial, Helvetica, sans-serif"><strong>N&ordf;</strong></font></th>
      <th width="265"><font size="1" face="Arial, Helvetica, sans-serif"><strong>DESCRIPCION 
        DE LA PRUEBA</strong></font></th>
      <th width="165"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TIEMPO 
        ESTIMADO</strong></font></th>
      <th width="145"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TIEMPO 
        REAL</strong></font></th>
      <th width="22"><font size="1" face="Arial, Helvetica, sans-serif"><strong>SI</strong></font></th>
      <th width="20"><font size="1" face="Arial, Helvetica, sans-serif"><strong>NO</strong></font></th>
      <th width="209"><font size="1" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES</strong></font></th>
    </tr>
    <?php
		$sql = "SELECT * FROM cambios_prueba2 WHERE id_pru='$row_ed[id_pru]' ORDER BY num_pru ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
	?>
    <tr align="center"> 
      <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['num_pru']?></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['desc_pru']?></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['tiem_est']?></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['tiem_real']?></font></td>
      <?php if($row['calif']=="SI")
	    {echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/si1.gif\" width=\"10\" height=\"10\"></font></td>";
		 echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;</font></td>";}
		if($row['calif']=="NO")
		{echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;</font></td>";
		echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/si1.gif\" width=\"10\" height=\"10\"></font></td>";}
	  ?>
      <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['obs_pru']?></font></td>
    </tr>
	<?php } ?>
    <tr align="center"> 
      <td colspan="7">&nbsp;</td>
    </tr>
    <tr> 
      <td height="7" colspan="7"><font size="2"><strong>Total Tiempo Estimado: 
        </strong>
        <?php 
		$sql_tot="SELECT SUM(tiem_est) AS total_tiempo FROM cambios_prueba2 WHERE id_pru='$row_ed[id_pru]'";
		$result_tot=mysql_query($sql_tot);
		$row_tot=mysql_fetch_array($result_tot);
		if(!$row_tot['total_tiempo']){echo "0 minutos";}
		else{echo $row_tot['total_tiempo']." minutos";}
		?></font> 
        <font size="2"><strong><br>
        Total Tiempo Real: </strong> 
        <?php 
		$sql_tot="SELECT SUM(tiem_real) AS total_tiempo_r FROM cambios_prueba2 WHERE id_pru='$row_ed[id_pru]'";
		$result_tot=mysql_db_query($db,$sql_tot,$link);
		$row_tot=mysql_fetch_array($result_tot);
		if(!$row_tot['total_tiempo_r']){echo "0 minutos";}
		else{echo $row_tot['total_tiempo_r']." minutos";}
		?></font>
      </td>
    </tr>
  </table>
  </td>
  </tr>
    <tr>
	  <td>
        <table width="100%" border="0">
          <tr> 
            <td width="1%"><font size="2">&nbsp;</font></td>
            <td width="49%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Observaciones Generales del Responsable 
              : </strong></font></td>
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row_ed['obs_pru0'];?>&nbsp;</font></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><font size="2">&nbsp;</font></td>
            <td valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Observaciones Generales:</strong></font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row_ed['obs_pru1'];?>&nbsp;</font></td>
          </tr>
        </table></td>
    </tr>
  </table>
    <br>
  <br>
  <br>
  <br>
  <br>
  <table width="90%" border="0" align="center">
    <tr> 
      <td height="18"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Firma 
          Responsable: _______________________________</strong></font></div></td>
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Firma 
          Aprobacion: _______________________________ </strong></font></div></td>
    </tr>
  </table>
	  
	  
  <tr>
    <td colspan="1"><blockquote>
</form>
</body>
</html>
