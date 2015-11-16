<?php
include("datos_gral.php");
?>
<html>
<head>
<link rel=stylesheet href="general.css" type="text/css">
<title>Alarmas</title>
<style type="text/css">
<!--
.style1 {font-family: arial, Courier, mono}
-->
</style>
</head>
<body>
<?php
include ("conexion.php");
$sql_tmp   = "SELECT *, DATE_FORMAT(fec_creacion, '%d/%m/%Y') AS fec_creacion FROM alarmas_riesgos WHERE id_alarma='$alarma'";
$row_tmp   = mysql_fetch_array(mysql_db_query($db, $sql_tmp, $link));
$sql4  = "SELECT id_riesgo, descripcion FROM riesgo_tipos WHERE id_riesgo='$row_tmp[tipo_alarma]'";
$row4  = mysql_fetch_array(mysql_db_query($db, $sql4, $link));
$sql5  = "SELECT id_riesgo, desc_riesgo  FROM riesgo_pregunta WHERE id_riesgo='$row_tmp[alarma]'";
$row5  = mysql_fetch_array(mysql_db_query($db, $sql5, $link));

?></p>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><u>
       PROGRAMACION  DE ALARMAS</u></font> </strong></div></td>
  </tr>
</table>
<br>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="150" height="23"> <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><b>TIPO 
        DE ALARMA :</b></font></p>
    </td>
    <td width="497"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row4[descripcion];?></font></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="151" height="23"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><strong> 
        ALARMA :</strong></font></p>
    </td>
    <td width="496"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row5[desc_riesgo]; ?></font></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="151" height="23"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><strong> 
        FECHA DE CREACION :</strong></font></p>
    </td>
    <td width="496"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row_tmp[fec_creacion]; ?></font></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="151" height="23"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><strong> 
        CREADO POR :</strong></font></p></td>
    <td width="496"><p><font size="2" face="Arial, Helvetica, sans-serif">
	<?php
		$sql_tmp0  = "SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$row_tmp[login_creador]'";
		$row_tmp0  = mysql_fetch_array(mysql_db_query($db, $sql_tmp0, $link));
		echo $row_tmp0[nom_usr]." ".$row_tmp0[apa_usr]." ".$row_tmp0[ama_usr];
	?></font></p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>


<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="150" height="43" valign="top"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><B>USUARIOS:</B></font></p></td>
    <td width="300" valign="top"> 
      <table border="1" cellspacing="0" width="100%">
        <tr class="titulo2" align="center">
          <th bgcolor="#CCCCCC"><span class="style1">Nombre USUARIO</span></th>
          <th bgcolor="#CCCCCC">AREA</th>
        </tr>
        <?php
			$sql2 = "SELECT * FROM alarma_usuarios WHERE id_alarma='$alarma'";
			$res2 = mysql_db_query($db,$sql2,$link);
			while ($row2 = mysql_fetch_array($res2)){			
				echo "<tr class='tit_form'>";
				$sql_tmp2  = "SELECT nom_usr,apa_usr,ama_usr, area_usr  FROM users WHERE login_usr='$row2[usuario]'";
				$row_tmp2  = mysql_fetch_array(mysql_db_query($db, $sql_tmp2, $link));
			
			?>
        <td><?php echo $row_tmp2[nom_usr]." ".$row_tmp2[apa_usr]." ".$row_tmp2[ama_usr];?></td>
        <td>&nbsp;<?php echo $row_tmp2[area_usr];?></td>
        <?php 
			echo "<tr>";
			}?>
      </table></td>
    <td width="197" valign="top"> 
      <table border="1" cellspacing="0" width="100%">
        	<tr  align="center"> 
          		<th bgcolor="#CCCCCC" class="titulo2">MENSAJE USUARIO</th>
        	</tr>
			<tr>
        		<td class='tit_form'><?php echo $row_tmp[mensaje_u];?></td>
        	</tr>
   	  </table>
    </td>
  </tr>
</table>
<br>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="149" height="23" valign="top"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><B>PROVEEDORES:</B></font></p></td>
    <td width="301" valign="top"> 
      <table border="1" cellspacing="0" width="100%">
        <tr class="titulo2" align="center">
          <td bgcolor="#CCCCCC">Nombre Provedor</td>
        </tr>
        <?php
			$sql3 = "SELECT * FROM alarma_proveedores WHERE id_alarma='$alarma'";
			$res3 = mysql_db_query($db,$sql3,$link);
			while ($row3 = mysql_fetch_array($res3)){			
				echo "<tr class='tit_form'>";
				$sql_tmp3  = "SELECT NombProv FROM proveedor WHERE IdProv='$row3[id_proveedor]'";
				$row_tmp3  = mysql_fetch_array(mysql_db_query($db, $sql_tmp3, $link));
			
			?>
        <td><?php echo $row_tmp3[NombProv];?></td>
        <?php 
			echo "</tr>";
			}?>
      </table></td>
    <td width="197"><table border="1" cellspacing="0" width="100%">
        <tr  align="center"> 
          <th bgcolor="#CCCCCC" class="titulo2">MENSAJE proveedor</th>
        </tr>
        <tr> 
          <td class='tit_form'><?php echo $row_tmp[mensaje_p];?></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="148" height="23" valign="top"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><B>ENTIDADES:</B></font></p></td>
    <td width="302" valign="top"> 
      <table border="1" cellspacing="0" width="100%">
        <tr class="titulo2" align="center">
          <th bgcolor="#CCCCCC">Nombre EntidaD</th>
        </tr>
        <?php
			echo "<tr class='tit_form'>";
			$sql4 = "SELECT * FROM alarma_entidad WHERE id_alarma='$alarma'";
			$res4 = mysql_db_query($db,$sql4,$link);
			while ($row4 = mysql_fetch_array($res4)){			
				$sql_tmp4  = "SELECT desc_dep FROM procesos_parametros WHERE id_dep='$row4[id_entidad]'";
				$row_tmp4  = mysql_fetch_array(mysql_db_query($db, $sql_tmp4, $link));			
			?>
        <td class='tit_form'><?php echo $row_tmp4[desc_dep];?></td>
        <?php 
			echo "</tr>";
			}
			?>
      </table></td>
    <td width="197"><table border="1" cellspacing="0" width="100%">
        <tr  align="center"> 
          <th bgcolor="#CCCCCC" class="titulo2">MENSAJE ENTIDAD</th>
        </tr>
        <tr> 
          <td class='tit_form'><?php echo $row_tmp[mensaje_e];?></td>
        </tr>
      </table></td>
  </tr>
</table>


</body>
</html>
