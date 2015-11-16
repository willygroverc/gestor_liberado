<?php
include ("top_ver.php");
$id_admrh=($_GET['id_admrh']);
 
 $sql3 = "SELECT * FROM admrhumanos WHERE id_admrh='$id_admrh'";
  $result3 = mysql_db_query($db,$sql3,$link);
  $row3 = mysql_fetch_array($result3);

$sql0 = "SELECT * FROM admrhdet WHERE id_admrh='$id_admrh' ORDER BY id_admrh ASC";
$result0=mysql_db_query($db,$sql0,$link);
$row0=mysql_fetch_array($result0);
  
	 
				
?>
<html>
<head>
<title>Administraciòn de Recursos Humanos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF">
<p><?php
include("datos_gral.php");
?>
<table width="83%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="752" align="center"><p><u><font size="4" face="Verdana, Arial, Helvetica, sans-serif"><strong>ADMINISTRACION DE RECURSOS 
        HUMANOS </strong></font></u></p>
      <p>&nbsp;</p></td>
  </tr>
  <tr> 
    <td> </td>
  </tr>
</table>

<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<table width="83%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="225"><font size="2" face="Arial, Helvetica, sans-serif"> <strong>NOMBRE DEL PROYECTO:</strong></font></td>
    <td width="569"><font size="2"><strong><?php echo $row3[nomproy];?></strong></font></td>
  </tr>
</table>
<table width="83%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="225"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE DEL RESPONSABLE:</strong></font> </td>
    <td width="569"><font size="2"><strong><?php 
		$sql4 = "SELECT * FROM users WHERE login_usr='$row3[nomresp]'";
				 $result4=mysql_db_query($db,$sql4,$link);
				 $row4=mysql_fetch_array($result4); 
		$nombre4="$row4[nom_usr] $row4[apa_usr] $row4[ama_usr]";
	
	echo $nombre4;?></strong></font></td>
  </tr>
</table>

<br>
<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
    <th  rowspan="2"  align="center" nowrap ><font size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
    <th  rowspan="2"  align="center" nowrap ><font  size="2" face="Arial, Helvetica, sans-serif">ACTIVIDADES/PRODUCTOS</font></th>
    <th  rowspan="2"  align="center" nowrap ><p><font  size="2" face="Arial, Helvetica, sans-serif">NOMBRE 
        RESPONSABLES </font></p>
    </th>
    <th   rowspan="2"  align="center"><p><font  size="2" face="Arial, Helvetica, sans-serif">CRONOGRAMA</font></p></th>
    <th  align="center" colspan="3" nowrap > <div align="center"><font  size="2" face="Arial, Helvetica, sans-serif">CUMPLIMIENTO</font></div></th>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <th  align="center"  nowrap ><font  size="2" face="Arial, Helvetica, sans-serif">SI</font></th>
    <th align="center"  nowrap ><font  size="2" face="Arial, Helvetica, sans-serif">NO</font></th>
    <th  align="center"   nowrap ><font  size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></th>
  </tr>
          <?php
			
		$sql = "SELECT * FROM admrhdet WHERE id_admrh='$id_admrh' ORDER BY id_admrh ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
			  
		 ?>
		
  <tr align="center"> 
    <td><?php echo $row[num_det]?></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif"> 
      <div align="center">&nbsp;<?php echo $row[activprod]?></div>
      </font></td>
    <td><?php 
	$sql2 = "SELECT * FROM users WHERE login_usr='$row[nombresp]'";
				 $result2=mysql_db_query($db,$sql2,$link);
				 $row2=mysql_fetch_array($result2); 
		$nombre2="$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]";
	
	
	echo $nombre2 ?></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif"> 
      <div align="center">&nbsp;<?php echo $row[cronograma]?>&nbsp;</div>
      </font></td>
            <?php if  ($row[cumplimiento]=="SI") {echo "<td align=\"center\"><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";
											 echo "<td align=\"center\"><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}
										 
			  elseif ($row[cumplimiento]=="NO"){echo "<td align=\"center\"><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";
		   							       	  echo "<td align=\"center\"><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
											  
			?>
            <td><div align="center">&nbsp;<?php echo $row[observaciones]?></div></td>
  </tr>
  <?php 
		 }
		 ?>
</table>

<tr> 
    <td colspan="4"><p>&nbsp;</p>
    <table width="83%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr> 
        <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>DOCUMENTACION DE REFERENCIA</strong></font><strong><font size="2"> : </font></strong></td>
        <td><font size="2" face="Arial, Helvetica, sans-serif"> <strong><?php echo $row3[docref];?></strong> 
          </font></td>
      </tr>
      <tr> 
        <td width="250"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DOCUMENTACION DE SOPORTE : </strong></font></td>
        <td><font size="2" face="Arial, Helvetica, sans-serif"><strong><?php echo $row3[docsop];?></strong></font></td>
      </tr>
    </table>
    <br>
    <table width="83%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr> 
        <td width="36%" height="73"> <p><font size="2" face="Arial, Helvetica, sans-serif"><strong>FIRMA:</strong><br>
            </font></p>
        <p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;</p></td>
        <td align="center" width="64%"> <p><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA:</strong></font></p>
          <p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row3[fecha];?></font></p></td>
      </tr>
    </table>
    <br> </td>
</tr>
</body>
</html>
