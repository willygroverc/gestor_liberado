<?php
include ("conexion.php");
include("top_ver.php");
require_once('funciones.php');
include ("funciones.inc.php");
@session_start(); 

if (!(empty($res)))
{	$pat = XCampoc($res,"users","login_usr","apa_usr",$link);
	$mat = XCampoc($res,"users","login_usr","ama_usr ",$link);
	$nom = XCampoc($res,"users","login_usr ","nom_usr",$link);		
}	
$sql = "SELECT *, DATE_FORMAT(fecha_creado, '%d/%m/%Y') AS fecha_creado, DATE_FORMAT(fec_baja, '%d/%m/%Y') AS fec_baja, DATE_FORMAT(fecha_rev, '%d/%m/%Y') AS fecha_rev 
FROM datos_archivos WHERE id_arch=$id_arch";
$result = mysql_db_query($db,$sql,$link);
$row = mysql_fetch_array($result);
$nom_a = $row['nombre_arch'];
if(!empty($_SESSION["path"])) $path   = $_SESSION["path"];
if(!empty($_SESSION["path_trash"])) $path_trash  = $_SESSION["path_trash"];
$path_c = $path."/".$mod."/".$row['nombre_arch'];

if ($row['eliminado']==1)
{	$sql2 = "select * from modulo where id_mod=$row[id_mod]";
	$res2 = mysql_db_query($db,$sql2,$link);
	$row2 = mysql_fetch_array($res2);
	$ubc = "Eliminado";
	if ($row2['estado'] == 1)
	{	$sql3 = "SELECT * FROM modulos_eliminados WHERE id_mod=$row[id_mod]";
		$res3 = mysql_db_query($db,$sql3,$link);
		$row3 = mysql_fetch_array($res3);
		$dir  = $path_trash."/".$row3['nombre_mod_eli'];
		$ubc = "Eliminado";
		$op1   = ArchivoExistente($nom_a, $dir);
		if ( $op1 == 1)
		{	$path_c = $path_trash."/".$row3['nombre_mod_eli']."/".$nom_a;
			//echo "---Modulo existe".$path_c;
		}
		else	
		{	$sql2 = "SELECT MIN(id_eli) AS id_eli FROM archivos_eliminados WHERE  id_arch = $id_arch";
			$res2 =  mysql_db_query($db,$sql2,$link);
			$row2 = mysql_fetch_array($res2);
			$nom_a = XCampoc($row2['id_eli'],"archivos_eliminados","id_eli","nombre_arch_eli",$link);	
			$path_c = $path_trash."/".$nom_a;
			//echo "---Modulo".$path_c;	
		}
	}
	else
	{	$sql2 = "SELECT MIN(id_eli) AS id_eli FROM archivos_eliminados WHERE  id_arch = $id_arch";
		$res2 =  mysql_db_query($db,$sql2,$link);
		$row2 = mysql_fetch_array($res2);
		$nom_a = XCampoc($row2['id_eli'],"archivos_eliminados","id_eli","nombre_arch_eli",$link);
		$path_c = $path_trash."/".$nom_a;
		//echo "---".$path_c;
	}
}
?>
<html>
<head>
	<title> GesTor F1 - ARCHIVOS - ADM. FUENTES</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><u>
        ARCHIVOS</u></font> </strong></div></td>
  </tr>
</table>
<br>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="150" height="23"> <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><b>Nro DE ARCHIVO:</b></font></p>
    </td>
    <td width="497"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['id_arch'];?></font></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="151" height="23"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><strong>
        ARCHIVO:</strong></font></p>
    </td>
    <td width="496"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['nombre_arch']; ?></font></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="152" height="23"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><B>TAMANO ARCHIVO:</B></font></p>
    </td>
    <td width="495"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php if(!empty($size)) echo $size."(bytes)";?></font></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>

<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="152" height="23"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><B>MODULO:</B></font></p>
    </td>
    <td width="495"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php if(!empty($mod)) echo $mod;?></font></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>

<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="154" height="23"><p><font size="2" face="Arial, Helvetica, sans-serif"><B>UBICACION:</B></font></p></td> 
    
    <td width="139"> <font size="2" face="Arial, Helvetica, sans-serif">
      <?php echo $ubc; ?> </font></td>
    <td width="122"><font size="2" face="Arial, Helvetica, sans-serif"><B>&nbsp;
      RESPONSABLE:</B></font></td>
    <td width="232"><p> <font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $pat; echo $mat; echo $nom; ?></font></p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>	
</table>

<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="153" height="23"><p><font size="2" face="Arial, Helvetica, sans-serif"><B>FECHA DE CREACION:</B></font></p></td> 
    
    <td width="139"> <font size="2" face="Arial, Helvetica, sans-serif">
      <?php echo $row['fecha_creado'] ?> </font></td>
    <td width="249"><font size="2" face="Arial, Helvetica, sans-serif"><B>&nbsp;&nbsp;FECHA DE 
      ULTIMA ACTUALIZACION:</B></font></td>
    <td width="106"><p> <font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['fecha_rev'] ?></font></p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>

<?php 
if ($row['eliminado']==1)
{
?>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="158" height="23"><p><font size="2" face="Arial, Helvetica, sans-serif"><B>FECHA ELIMINACION:</B>
       </font></p>
    </td>
    <td width="489"><p><font size="2" face="Arial, Helvetica, sans-serif">
	<?php 
	echo $row['fec_baja'];
	?>&nbsp;</font></p> </td>
  </tr>
   <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>  
</table>
<?php
}
		$sql_has = "SELECT hash_archi FROM control_archivos WHERE id_arch='$id_arch'";
		$row_has = mysql_fetch_array(mysql_db_query($db,$sql_has,$link));
		
		$sql_hsh = "SELECT hash_archi FROM datos_archivos WHERE id_arch='$id_arch'";
		$row_hsh = mysql_fetch_array(mysql_db_query($db,$sql_hsh,$link));
	
		$sql_ash = "SELECT hash_archi FROM versiones WHERE id_arch='$id_arch'";
		$row_ash = mysql_fetch_array(mysql_db_query($db,$sql_ash,$link));
?>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="158" height="23"><p><font size="2" face="Arial, Helvetica, sans-serif"><B>HASH ORIGINAL:</B>
       </font></p>
    </td>
    <td width="489"><p><font size="2" face="Arial, Helvetica, sans-serif">
	<?php 
	echo $row_hsh['hash_archi'];
	?>&nbsp;</font></p> </td>
  </tr>
   <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>  
</table>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="157" height="23"> <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><b>HASH 
        MODIFICADO:</b></font></p></td>
    <td width="490"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row_has['hash_archi'];?></font></p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="157" height="23"> <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><b>HASH 
        DE REVISION:</b></font></p></td>
    <td width="490"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row_ash['hash_archi'];?></font></p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="256" height="45"><font size="2" face="Arial, Helvetica, sans-serif"><B>ARCHIVO 
      ORIGINAL MODIFICADO:</b></FONT></td>
    <td width="391"> 
      <?php 
		if ($row_ash['hash_archi'])
		{	if ($row_hsh['hash_archi'] == $row_ash['hash_archi'])		
			{	echo "<font face='Arial, Helvetica, sans-serif' size='2'><b>Si</b>&nbsp;<img src='images/no1.gif' width='10' height='10' border='1'>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";			
				echo "<font face='Arial, Helvetica, sans-serif' size='2'><b>No</b></font>&nbsp;<img src='images/si1.gif' width='10' height='10' border='1'>";		
			}
			else						
			{	echo "<font face='Arial, Helvetica, sans-serif' size='2'><b>Si</b>&nbsp;<img src='images/si1.gif' width='10' height='10' border='1'>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<font face='Arial, Helvetica, sans-serif' size='2'><b>No</b></font>&nbsp;<img src='images/no1.gif' width='10' height='10' border='1'>";									
			}
		}
		else
		{	echo "<font face='Arial, Helvetica, sans-serif' size='2'><b>Si</b>&nbsp;<img src='images/no1.gif' width='10' height='10' border='1'>";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";			
			echo "<font face='Arial, Helvetica, sans-serif' size='2'><b>No</b></font>&nbsp;<img src='images/si1.gif' width='10' height='10' border='1'>";		
		}
			
	?>
    </td>
  </tr>
</table>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
 <BR>
</table>
<?php 
$sqlver = "SELECT * FROM versiones WHERE id_arch=$id_arch";
$resultver = mysql_db_query($db,$sqlver,$link);
$rowver= mysql_fetch_array($resultver);
//if ( $op == "version" && $rowver)
if ( $op == "version")
{
?>
<table width="656" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="45%" height="53" > 
      <p align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">
       NRO. DE VERSIONES DEL ARCHIVO</font></strong></p>
    </td>
    
  </tr>
  
</table>
<table width="656" border="1" align="center" >
  <tr bgcolor="#CCCCCC"> 
    <th width="42" height="20" nowrap> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Nro. 
    VERSION</strong></font></div></th>
    <th width="79" nowrap><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>NOMBRE</strong></font></div></th>
    <th width="78" nowrap><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>MODIFICO 
        </strong></font></div></th>
    <th width="140" nowrap><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>DESC. 
        MODIFICACION </strong></font></div></th>
    <th width="67" nowrap><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>REVISION</strong></font></div></th>
    <th width="210" nowrap><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>DESC. 
        REVISION </strong></font></div></th>
  </tr>
  <?php
$sqlver = "SELECT * FROM versiones WHERE id_arch=$id_arch ORDER BY id_version DESC";
$resultver = mysql_db_query($db,$sqlver,$link);
while($rowver= mysql_fetch_array($resultver)) {
$sqlcon = "SELECT * FROM control_archivos WHERE id_arch='$rowver[id_arch]' AND id_control='$rowver[id_control]'";
$resultcon = mysql_db_query($db,$sqlcon,$link);
$rowcon=mysql_fetch_array($resultcon);
$sqlusb = "SELECT * FROM users WHERE login_usr='$rowcon[login_b]'";
$resultusb = mysql_db_query($db,$sqlusb,$link);
$rowusb=mysql_fetch_array($resultusb);
$sqlusr = "SELECT * FROM users WHERE login_usr='$rowcon[login_r]'";
$resultusr = mysql_db_query($db,$sqlusr,$link);
$rowusr=mysql_fetch_array($resultusr);
?>
  <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $rowver['id_version'];?></font></div></td>
    <td><div align="justify"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $rowver['nombre_arch']; ?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $rowusb['nom_usr']." ".$rowusb['apa_usr']." ".$rowusb['ama_usr']; ?></font></div></td>
    <td><div align="justify"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $rowcon['comentario']; ?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $rowusr['nom_usr']." ".$rowusr['apa_usr']." ".$rowusr['ama_usr']; ?></font></div></td>
    <td><div align="juestify"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $rowcon['coment_r']; ?></font></div></td>
  </tr>
  <?php } ?>
</table>
<?php
}?>
<br>
<br>
</body>
</html>
