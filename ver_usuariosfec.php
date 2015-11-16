<?php
include("datos_gral.php");
?>
<html>
<head>
<title> GesTor F1 - USUARIOS</title>
</head>
</html>
<?php include ("conexion.php");?>

<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">LISTA DE USUARIOS</font></u></b></div></td>
  </tr>
</table>
<br>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" >
  <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="4" cellspacing="0">
        <tr align=\"center\" bgcolor="#CCCCCC"> 
          <th height="14"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">LOGIN</font></strong></th>
          <th><strong><font face="Arial, Helvetica, sans-serif" color="#000000" size="2">TIPO</font></strong></th>
          <th><strong><font face="Arial, Helvetica, sans-serif" color="#000000" size="2">NOMBRES 
            Y APELLIDOS</font></strong></th>
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">AREA</font></strong></th>
          <?php 
		  $sql1="SELECT * FROM control_parametros";
		  $rs1=mysql_db_query($db,$sql1,$link);
		  $row1=mysql_fetch_array($rs1);
		  if ($row1[agencia] == "si") {
		  ?>
		  <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">AGENCIA</font></strong></th>
		  <?php } ?>
		  <th colspan="1"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
            CARGO</font></strong></th>
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">TELEFONO</font></strong></th>
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">DIRECCION</font></strong></th>
          <?php if ($menu_fecha=='ult_acceso'){?>
		  <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ult. Acceso</font></strong></th>
		  <?php }?>
          <?php if ($menu_fecha=='creacion'){?>
		  <th width="70"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">FECHA DE CREACION</font></strong></th>
		  <?php }?>
          <?php if ($menu_fecha=='eliminacion'){?>
		  <th width="70"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">FECHA DE CREACION</font></strong></th>
		  <th width="70"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">FECHA DE ELIMINACION</font></strong></th>
		  <?php }?>
        </tr>
        <?php
		 if (strlen($DA) == 1){ $DA = "0".$DA; }
		 if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
         $fec1 = $AA."-".$MA."-".$DA;   
		 if (strlen($DE) == 1){ $DE = "0".$DE; }
		 if (strlen($ME) == 1){ $ME = "0".$ME; }
		 $fec2 = $AE."-".$ME."-".$DE; 
		if ($menu_fecha=="ult_acceso"){		
		$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y	') AS fecha FROM users, registro 
				WHERE users.login_usr=registro.login_usr AND (fecha BETWEEN '#$fec1 00:00:00#' AND '#$fec2 23:59:59#') ";
		}
		if ($menu_fecha=="creacion"){		
		$sql = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacion FROM users
				WHERE fecha_creacion BETWEEN '$fec1' AND '$fec2' ORDER BY fecha_creacion ASC";
		}
		if ($menu_fecha=="eliminacion"){		
		$sql = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacion, DATE_FORMAT(fecha_eliminacion, '%d/%m/%Y') AS fecha_eliminacion FROM users 
				WHERE fecha_eliminacion BETWEEN '$fec1' AND '$fec2' ORDER BY fecha_eliminacion ASC";
		}
		$result = mysql_db_query($db,$sql,$link); 
		while ($row=mysql_fetch_array($result)) {
		echo "<tr align=\"center\">";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[login_usr]</font></td>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[tipo2_usr]</font></td>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[nom_usr] $row[apa_usr] $row[ama_usr]</font></td>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[area_usr]</font></td>";
	if ($row1[agencia]=="si") {
		$sql2="SELECT  *  FROM datos_adicionales WHERE id_dadicional='$row[adicional1]'";
		$rs2=mysql_db_query($db,$sql2,$link);
		$row2=mysql_fetch_array($rs2);
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row2[nombre_dadicional]</font></td>";
	} 
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[cargo_usr]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[telf_usr]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[direc_usr]</font></td>";
	if ($menu_fecha=='ult_acceso'){		
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[fecha]</font></td>";
	}
	if ($menu_fecha=='creacion'){		
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[fecha_creacion]</font></td>";
	}
	if ($menu_fecha=='eliminacion'){		
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[fecha_creacion]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[fecha_eliminacion]</font></td>";
	}
	echo "</tr>";
}?>
      </table></td>
  </tr>
</table>