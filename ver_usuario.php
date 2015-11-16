<?php 
include ('top_ver.php');
require ('funciones.php');
$login_usr=_clean($_GET['login_usr']);
$login_usr=SanitizeString($login_usr);


$sql = "SELECT u.login_usr, u.tipo_usr, u.tipo2_usr, u.nom_usr, u.apa_usr, u.ama_usr, u.cargo_usr, da.nombre_dadicional as area, u.area_usr, u.bloquear, u.telf_usr, u.asig_usr, u.email, u.direc_usr, da1.nombre_dadicional as agencia, u.enti_usr, u.esp_usr, u.ext_usr, u.ciu_usr, DATE_FORMAT(u.fecha_creacion, '%d/%m/%Y') AS fecha_creacion, DATE_FORMAT(fecha_eliminacion, '%d/%m/%Y') AS fecha_eliminacion FROM users u LEFT JOIN datos_adicionales da ON u.area_usr=da.id_dadicional LEFT JOIN datos_adicionales da1 ON u.adicional1=da1.id_dadicional WHERE login_usr='$login_usr'";
$result=mysql_query($sql);
if (mysql_num_rows($result)==0)
	echo '<script>history.back(1);</script>';
else
	$row=mysql_fetch_array($result);
?>
<html>
<head>
<title>Usuario</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<p>
<?php
include("datos_gral.php");
?>
<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" >
   <tr> 
	  <td><div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">USUARIO</font></u></b></div></td>
   </tr>
  <tr> 
    <td align="center">&nbsp; </td> 
</tr> 
</table>
<table width="80%" align="center" border="0">
  <tr> 
    <td></td>
	<td></td>
    <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font color="#0000CC" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Login 
      :</font></td>
    <td><strong><?php echo $row['login_usr'];?></strong></td>
    <td height="20"> 
      <div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Tipo 
        :</font></div></td>
    <td height="20"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
      <?php if ($row['tipo2_usr']=="A") echo "Administrador";?>
      <?php if ($row['tipo2_usr']=="C") echo "Cliente";?>
      <?php if ($row['tipo2_usr']=="T") echo "Tecnico";?>
      </font></strong></td>
    <td align="right" height="20"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;<font size="2">Email 
      : </font> </font></td>
    <td height="20"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
      <?php echo $row['email'];?> </font></strong></td>
  </tr>
  <tr> 
    <td height="3"></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td bgcolor="#000000"></td>

  </tr>
  <tr> 
    <td><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"><font color="#0000FF"><font color="#0000CC"><font color="#000000"><font face="Arial, Helvetica, sans-serif"></font></font></font></font></div></td>
    <td colspan="2"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td colspan="2"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td width="16%"><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cliente 
        :</font> </div></td>
    <td width="17%"><div align="center"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Interno 
        <?php 
			if ($row['tipo_usr']=="INTERNO")
			{echo "<img src=\"images/si1.gif\" border=\"1\">";}
			else
			{echo "<img src=\"images/no1.gif\" border=\"1\">";}
			?>
        </font> </div></td>
    <td><div align="center"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Externo 
        <?php 
			if ($row['tipo_usr']=="EXTERNO")
			{echo "<img src=\"images/si1.gif\" border=\"1\">";}
			else
			{echo "<img src=\"images/no1.gif\" border=\"1\">";}
			?>
        </font></div></td>
    <td><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td colspan="2"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"><font color="#0000FF"><font color="#0000CC"><font color="#000000"><font face="Arial, Helvetica, sans-serif"></font></font></font></font></div></td>
    <td colspan="2"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td colspan="2"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><div align="left"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Fecha 
        de creacion:</font> </div></td>
    <td><div align="left"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['fecha_creacion'];?></font> </div></td>
    <?php if ($row['bloquear']==2) {?>
	<td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Fecha 
        de eliminacion:</font> </div></td>
    <td><div align="left"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['fecha_eliminacion'];?></font> </div></td>
    <?php } ?>
  </tr>
  <tr> 
    <td height="3"></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <?php if ($row['bloquear']==2) {?>
	<td bgcolor="#000000"></td>
    <?php } ?>
    <td></td>
    <td></td>

  </tr>
  
  <tr>
  	<td height="15"></td>
  </tr>
  <tr> 
    <td colspan="6" class="normal"><strong>Datos del Cliente:</strong></td>
  </tr>
  </tr>
  <tr>
  	<td height="12"></td>
  </tr>
  <tr> 
    <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Nombres 
        :</font></div></td>
    <td><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
      <?php echo $row['nom_usr'];?> </font></strong></td>
    <td width="19%"> <div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ape. 
        paterno :</font></div></td>
    <td width="15%"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
      <?php echo $row['apa_usr'];?> </font></strong></td>
    <td width="14%"> <div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ape. 
        materno :</font></div></td>
    <td width="19%"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
      <?php echo $row['ama_usr'];?> </font></strong></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td bgcolor="#000000"></td>
  </tr>
    <tr>
  	<td height="12"></td>
  </tr>
  <tr> 
    <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Entidad: </font></div></td>
    <td><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
      <?php echo $row['enti_usr'];?> </font></strong></td>
    <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Area:</font></div></td>
    <td><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
      <?php echo $row['area'];?> </font></strong></td>
    <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;Especialidad:</font></div></td>
    <td><div align="left"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
        <?php echo $row['esp_usr'];?> </font></strong></div></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td bgcolor="#000000"></td>
  </tr>
    <tr>
  	<td height="12"></td>
  </tr>
  <tr> 
    <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cargo 
        : </font></div></td>
    <td><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
      <?php echo $row['cargo_usr'];?> </font></strong></td>
    <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Telefono 
        : </font></div></td>
    <td><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
      <?php echo $row['telf_usr'];?> </font></strong></td>
    <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ext 
        : </font></div></td>
    <td><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
      <?php echo $row['ext_usr'];?> </font></strong></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td bgcolor="#000000"></td>
  </tr>
    <tr>
  	<td height="12"></td>
  </tr>
          <?php 
		  $sql1="SELECT * FROM control_parametros";
		  $rs1=mysql_query($sql1);
		  $row1=mysql_fetch_array($rs1);
		  if ($row1['agencia']=="si") {
		  ?>
		  <tr> 
            <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Agencia :</font></div></td>
            <td><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">
            <?php echo $row['agencia'];	?>			
          </tr>
		  <?php 
		  }
		  ?>
  <tr> 
    <td height="2"></td>
    <?php if ($row1['agencia']=="si") {echo "<td bgcolor=\"#000000\"></td>";}?>
  </tr>
  <tr> 
    <td colspan="6"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td colspan="6" class="normal"><strong>Ubicacion Fisica :</strong></td>
  </tr>
  </tr>
  <tr>
  	<td height="9"></td>
  </tr>
  <tr> 
  <tr> 
    <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ciudad: </font></div></td>
    <td><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
      <?php echo $row['ciu_usr'];?> </font></strong></td>
    <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Direccion: </font></div></td>
    <td ><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
      <?php echo $row['direc_usr'];?> </font></strong></td>
    <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
      </font></td>
    <td><font color="#0000CC" size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td></td>
  </tr>
</table>
</body>
</html>