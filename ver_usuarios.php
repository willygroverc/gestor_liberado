<?php 
include ("top_ver.php");
?>
<html>
<head>
<title> GesTor F1 - USUARIOS</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
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
		  $rs1=mysql_query($sql1);
		  $row1=mysql_fetch_array($rs1);
		  if ($row1['agencia']=="si") {
		  ?>
			<th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">AGENCIA</font></strong></th>
		  <?php } ?>
		  <th colspan="1"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
            CARGO</font></strong></th>
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">TELEFONO</font></strong></th>
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">DIRECCION</font></strong></th>
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">EMAIL</font></strong></th>
          <th width="70"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">FECHA DE CREACION</font></strong></th>
		  <?php if ($menu=="usuarios_eliminados"){?>
          <th width="70"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">FECHA DE ELIMINACION</font></strong></th>
          <?php } ?>
        </tr>
        <?php
		
		switch ($menu) {
			case "todo":
				$sql = "SELECT u.login_usr, u.tipo_usr, u.tipo2_usr, u.nom_usr, u.apa_usr, u.ama_usr, u.cargo_usr, da.nombre_dadicional as area, u.area_usr, u.bloquear, u.telf_usr, u.asig_usr, u.email, u.direc_usr, da1.nombre_dadicional as agencia,  DATE_FORMAT(u.fecha_creacion, '%d/%m/%Y') AS fecha_creacion 
				FROM users u LEFT JOIN datos_adicionales da ON u.area_usr=da.id_dadicional 
				LEFT JOIN datos_adicionales da1 ON u.adicional1=da1.id_dadicional WHERE tipo2_usr<>'B' ORDER BY login_usr ASC";
				break;
			case "usuarios_bloqueados":
				$sql = "SELECT u.login_usr, u.tipo_usr, u.tipo2_usr, u.nom_usr, u.apa_usr, u.ama_usr, u.cargo_usr, da.nombre_dadicional as area, u.area_usr, u.bloquear, u.telf_usr, u.asig_usr, u.email, u.direc_usr, u.adicional1, da1.nombre_dadicional as agencia, 
				DATE_FORMAT(u.fecha_creacion, '%d/%m/%Y') AS fecha_creacion 
				FROM users u LEFT JOIN datos_adicionales da ON u.area_usr=da.id_dadicional 
				LEFT JOIN datos_adicionales da1 ON u.adicional1=da1.id_dadicional WHERE bloquear=1 ORDER BY login_usr ASC"; 
				break;
			case "usuarios_eliminados":
				$sql = "SELECT u.login_usr, u.tipo_usr, u.tipo2_usr, u.nom_usr, u.apa_usr, u.ama_usr, u.cargo_usr, da.nombre_dadicional as area, u.area_usr, u.bloquear, u.telf_usr, u.asig_usr, u.email, u.direc_usr, u.adicional1, da1.nombre_dadicional as agencia, 
				DATE_FORMAT(u.fecha_creacion, '%d/%m/%Y') AS fecha_creacion 
				FROM users u LEFT JOIN datos_adicionales da ON u.area_usr=da.id_dadicional 
				LEFT JOIN datos_adicionales da1 ON u.adicional1=da1.id_dadicional WHERE bloquear=2 ORDER BY login_usr ASC"; 
				break;
			case "tipo_usuario":
				$sql = "SELECT u.login_usr, u.tipo_usr, u.tipo2_usr, u.nom_usr, u.apa_usr, u.ama_usr, u.cargo_usr, da.nombre_dadicional as area, u.area_usr, u.bloquear, u.telf_usr, u.asig_usr, u.email, u.direc_usr, u.adicional1, da1.nombre_dadicional as agencia, 
				DATE_FORMAT(u.fecha_creacion, '%d/%m/%Y') AS fecha_creacion 
				FROM users u LEFT JOIN datos_adicionales da ON u.area_usr=da.id_dadicional 
				LEFT JOIN datos_adicionales da1 ON u.adicional1=da1.id_dadicional WHERE tipo2_usr='$tipo_usuario' ORDER BY login_usr ASC";
				break;
			case "area":
				$sql = "SELECT u.login_usr, u.tipo_usr, u.tipo2_usr, u.nom_usr, u.apa_usr, u.ama_usr, u.cargo_usr, da.nombre_dadicional as area, u.area_usr, u.bloquear, u.telf_usr, u.asig_usr, u.email, u.direc_usr, u.adicional1, da1.nombre_dadicional as agencia, 
				DATE_FORMAT(u.fecha_creacion, '%d/%m/%Y') AS fecha_creacion 
				FROM users u LEFT JOIN datos_adicionales da ON u.area_usr=da.id_dadicional 
				LEFT JOIN datos_adicionales da1 ON u.adicional1=da1.id_dadicional WHERE area_usr='$area_usr' ORDER BY login_usr ASC";
				break;
			case "agencia":
				$sql = "SELECT u.login_usr, u.tipo_usr, u.tipo2_usr, u.nom_usr, u.apa_usr, u.ama_usr, u.cargo_usr, da.nombre_dadicional as area, u.area_usr, u.bloquear, u.telf_usr, u.asig_usr, u.email, u.direc_usr, u.adicional1, da1.nombre_dadicional as agencia, 
				DATE_FORMAT(u.fecha_creacion, '%d/%m/%Y') AS fecha_creacion 
				FROM users u LEFT JOIN datos_adicionales da ON u.area_usr=da.id_dadicional 
				LEFT JOIN datos_adicionales da1 ON u.adicional1=da1.id_dadicional WHERE da.nombre_dadicional='$agencia' ORDER BY login_usr ASC";
				break;
			default:
				$sql = "SELECT u.login_usr, u.tipo_usr, u.tipo2_usr, u.nom_usr, u.apa_usr, u.ama_usr, u.cargo_usr, da.nombre_dadicional as area, u.area_usr, u.bloquear, u.telf_usr, u.asig_usr, u.email, u.direc_usr, u.adicional1, da1.nombre_dadicional as agencia, 
				DATE_FORMAT(u.fecha_creacion, '%d/%m/%Y') AS fecha_creacion 
				FROM users u LEFT JOIN datos_adicionales da ON u.area_usr=da.id_dadicional 
				LEFT JOIN datos_adicionales da1 ON u.adicional1=da1.id_dadicional WHERE tipo2_usr<>'B' ORDER BY login_usr ASC";
				break;
		}
$result=mysql_query($sql); 
while ($row=mysql_fetch_array($result)) {

  	echo '<tr align="center">';
	echo '<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['login_usr'].'</font></td>';
	echo '<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['tipo2_usr'].'</font></td>';
	echo '<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['nom_usr'].' '.$row['apa_usr'].' '.$row['ama_usr'].'</font></td>';
	echo '<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['area'].'</font></td>';
	if ($row1['agencia']=="si") {
		echo '<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['agencia'].'</font></td>';
	} 
	echo '<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['cargo_usr'].'</font></td>';
	echo '<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['telf_usr'].'</font></td>';
	echo '<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['direc_usr'].'</font></td>';
	echo '<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['email'].'</font></td>';
	if ($menu=="usuarios_eliminados"){
	echo '<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['fecha_eliminacion'].'</font></td>';
	}
	echo '<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['fecha_creacion'].'</font></td>';
	echo '</tr>';
}?>
      </table></td>
  </tr>
</table>
</body>
</html>