<?php
include ("top_ver.php");

$sql = "SELECT * FROM reclamos WHERE CReclamo='$id_orden'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);

$sql7 = "SELECT * FROM ordenes where sarc='$id_orden' and fecha>='2009-01-01'";
$result7=mysql_db_query($db,$sql7,$link);
$row7=mysql_fetch_array($result7);

$sql0 = "SELECT * FROM titular WHERE ci_ruc='$row[ci_ruc]'";
$result0=mysql_db_query($db,$sql0,$link);
$row0=mysql_fetch_array($result0);

$sql1 = "SELECT *, DATE_FORMAT(fecha_asig,'%d / %m / %Y') as fecha_asig,DATE_FORMAT(fechaestsol_asig,'%d / %m / %Y') as fechaestsol_asig,".
		"DATE_FORMAT(date_esc,'%d / %m / %Y') as date_esc,DATE_FORMAT(fechasol_esc,'%d / %m / %Y') as fechasol_esc FROM asignacion WHERE id_orden='".$row7[id_orden]."' ORDER BY id_asig DESC limit 1";
$result1=mysql_db_query($db,$sql1,$link);
$row1=mysql_fetch_array($result1);

$sql2 = "SELECT *,DATE_FORMAT(fecha_seg,'%d/%m/%Y') as fecha_seg, DATE_FORMAT(fecha_rea, '%d/%m/%Y') AS fecha_rea FROM seguimiento WHERE id_orden='$id_orden'";
$result2=mysql_db_query($db,$sql2,$link);

$sql3 = "SELECT * FROM solucion_reclamos WHERE CReclamo='$id_orden'";
$result3=mysql_db_query($db,$sql3,$link);
$row3=mysql_fetch_array($result3);

$sql4 = "SELECT *,DATE_FORMAT(fecha_conf,'%d / %m / %Y') as fecha_conf FROM conformidad WHERE id_orden='$id_orden'";
$result4=mysql_db_query($db,$sql4,$link);
$row4=mysql_fetch_array($result4);

$sql5 = "SELECT * FROM costo WHERE id_orden='$id_orden'";
$result5=mysql_db_query($db,$sql5,$link);

$sql6 = "SELECT * FROM users";
$result6=mysql_db_query($db,$sql6,$link);
$row6=mysql_fetch_array($result6); 

$sql8 = "SELECT *,DATE_FORMAT(fecha,'%d / %m / %Y') as fecha FROM ordenes,users WHERE sarc='$id_orden' AND cod_usr=login_usr";
$result8=mysql_db_query($db,$sql8,$link);
$row8=mysql_fetch_array($result8);
 
?>
<html>
<head>
<title>Orden de Trabajo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="general.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF">
<p><?php
include("datos_gral.php");
?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> 
      <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">PUNTO DE RECLAMO - INFOCRED </font></u></b></div>
    </td>
  </tr>
</table>
<br>
<table width="635" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="53" class="titulo2">Fecha: </td>
    <td width="126" class="tit_form"><strong><?php echo $row[TFechaReclamo];?></strong></td>
    <td width="236"><div align="right"><p class="titulo2">N:</p> </div></td>
    <td width="97"><table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
        <tr> 
          <td align="center" class="tit_form"><strong>&nbsp;<?php echo $row[CReclamo];?></strong></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><u class="titulo">Datos del cliente:</u></td>
  </tr>
</table>
<br>
<table width="635" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="145" nowrap class="titulo2">Nombres y Apellidos: </td>
    <td width="490" nowrap class="tit_form"><strong><?php echo $row[TNombre]." ".$row[TApellido]; ?></strong></td>
  </tr>
  <tr> 
    <td height="1" ></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td height="0"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="32" height="18" valign="middle" class="titulo2">CI:</td>
    <td width="197" valign="middle" class="tit_form"><strong><?php echo $row[CIDReclamante];?></strong></td>
    <td width="26" class="titulo2">EIF:</td>
    <td width="100" class="tit_form"><strong><?php echo $row[TPersonaDeContacto];?></strong></td>
  </tr>
</table>
<br>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr> 
    <td>
      <div align="justify">
        <p class="titulo"><u>Descripcion del reclamo:</u></p>
      </div>
    </td>
  </tr>
</table>
<table width="636" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
<?php 
echo "<tr><td class=tit_form>".$row[TGlosa]."</td></tr>";
/*	$carac=strlen($row[desc_inc]);
	$co=0;
do {
	echo "<tr><td><font face=\"Courier New, Courier, mono\">&nbsp;".substr($row[desc_inc], $co, 62). "</font></td></tr>";	
    $carac=$carac-62;  
    $co=$co+62;
} while ($carac>0); */ ?>
</table>
<!--table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="61" class="titulo2">Area:</td>
    <td width="140" class="tit_form">Area 1:  
      <?php 
	/*if ($row[tipo]=="L")
		{
		echo "<img src=\"images/si1.gif\" border=\"1\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\" border=\"1\">";
		}*/
	?>
    </td>
    <td width="118" class="tit_form">Area 2:  
      <?php 
	/*if ($row[tipo]=="F")
		{
		echo "<img src=\"images/si1.gif\" border=\"1\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\" border=\"1\">";
		}*/
	?>
    </td>
    <td width="137" class="tit_form">Area 3:  
      <?php 
	/*if ($row[tipo]=="N")
		{
		echo "<img src=\"images/si1.gif\" border=\"1\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\" border=\"1\">";
		}*/
	?>
    </td>
    <td width="37" class="tit_form">Otro:</td>
    <td width="145"> <strong> 
      <?php 
	/*if ($row[tipo]!="L" && $row[tipo]!="F" && $row[tipo]!="N")
		{
		echo $row[tipo];
		}*/
	?>
      </strong></td>
  </tr>
  <tr> 
    <td height="1" colspan="4"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table-->
<?php if(isset($row3[CReclamo])){ ?>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="2">
<br>
<?php //if (isset($row3[0])) { ?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr align="justify"> 
    <td class="titulo"><u>Detalles de la Solucion:</u></td>
  </tr>
</table>
<table width="636" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
  <?php 
echo "<tr><td class=tit_form>".$row3[TGlosaRespuesta]."</td></tr>";
/*	$carac=strlen($row3[detalles_sol]);
	$co=0;
do {
	echo "<tr><td><font face=\"Courier New, Courier, mono\">&nbsp;".substr($row3[detalles_sol], $co, 62). "</font></td></tr>";	
    $carac=$carac-62;  
    $co=$co+62;
} while ($carac>0);  */?>
</table>
<br>

<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="201" class="titulo2">Fecha de REGISTRO DE solucion: </td>
    <td width="137" align="center" class="tit_form"><strong><?php echo $row3[TFechaSolucion];?></strong></td>
    <td width="125"  align="right" class="titulo2">Codigo de solucion  :</td>
    <?php 
	switch ($row3[TResultado]){
    	case "1":
        echo "<td class=\"tit_form\" align=\"center\"><strong> A Favor del Cliente</strong></td>";
        break;
    	case "2":
       echo "<td class=\"tit_form\" align=\"center\"><strong> A Favor de la Empresa</strong></td>";
        break;
   }?>
  </tr>
  <?php } ?>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table>
<br>

<br>
<br>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr align="center"> 
    <td width="313" height="19"> <p class="titulo2"> &#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;<br>
        <?php 
	if ($row8[login_usr]==""){echo "SISTEMA";}
	else {echo $row8[nom_usr]." ".$row8[apa_usr]." ".$row8[ama_usr];}
	?>
      </p>
    </td>
	<?php if(isset($row3[CReclamo])){ ?>
    <td width="317" class="titulo2">&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;<br>
	<?php 
	$sql10 = "SELECT * FROM users WHERE login_usr='$row1[asig]'";
	$result10=mysql_db_query($db,$sql10,$link);
	$row10=mysql_fetch_array($result10); 
	echo $row10[nom_usr]." ".$row10[apa_usr]." ".$row10[ama_usr];?>
    </td>
	<?php } ?>
  </tr>
</table>
<br>
<br>
<center>
    <p class="titulo3">&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;<br>
    VoBo</p>
    <p class="titulo3">&nbsp;</p>
    <p align="left" class="titulo3"><?php
	$sqlaux = "SELECT * FROM ordenes where sarc='$id_orden' and fecha>='2009-01-01'";
	$resultaux=mysql_db_query($db,$sqlaux,$link);
	$rowaux=mysql_fetch_array($resultaux);
	echo "Nro. Orden de Trabajo: ".$rowaux[id_orden];
	?></p>
</center>
</body>
</html>