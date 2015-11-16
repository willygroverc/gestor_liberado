<?php
include("datos_gral.php");
include ("conexion.php");
?>
<html>
<head>
<title> GesTor F1 - TIPIFICACI�N</title>
<style>
.leter { FONT-FAMILY:ARIAL; font-size:11Px;}
</style>
</head>
</html>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">ORDENES DE TRABAJO - INCIDENTES</font></u></b></div></td>
  </tr>
</table>
<br>
<?php
if(isset($_REQUEST['fecha'])=='true'){
		 if (strlen($DA) == 1){ $DA = "0".$DA; }
		 if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
         $fecha1 = $AA."-".$MA."-".$DA;   
		 if (strlen($DE) == 1){ $DE = "0".$DE; }
		 if (strlen($ME) == 1){ $ME = "0".$ME; }
		 $fecha2 = $AE."-".$ME."-".$DE; 
$sql_num="SELECT count(*) AS num FROM ordenes AS a, objetivos AS b WHERE a.dominio=b.id_dominio AND a.objetivo=b.id_objetivo AND b.objetivo LIKE '%Incidente%' AND fecha BETWEEN '$fecha1' AND '$fecha2'";
}else{
$sql_num="SELECT count(*) AS num FROM ordenes AS a, objetivos AS b WHERE a.dominio=b.id_dominio AND a.objetivo=b.id_objetivo AND b.objetivo LIKE '%Incidente%'";}
$row_num=mysql_fetch_array(mysql_db_query($db,$sql_num,$link));
echo "<font face=\"Arial, Helvetica, sans-serif\" color=\"#000000\" size=\"2\"><B>Numero de Incidentes : </B>".$row_num['num']."</font>";
?>
<br><br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" >
  <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="4" cellspacing="0">
        <tr align=\"center\" bgcolor="#CCCCCC"> 
          <th width="4%" height="21"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong>Nro.</strong></font></th>
		  <th width="10%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><B>NIVEL 1</B></font></th>
		  <th width="8%"><font face="Arial, Helvetica, sans-serif" color="#000000" size="2"><B>NIVEL 2</B></font></th>           		   
          <th width="10%"><font face="Arial, Helvetica, sans-serif" color="#000000" size="2"><B>NIVEL 3</B></font></th>
  		  <th width="10%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><B>COMPLEJIDAD</B></font></th>
		  <th width="8%"><font face="Arial, Helvetica, sans-serif" color="#000000" size="2"><B>CRITICIDAD</B></font></th>           		   
          <th width="10%"><font face="Arial, Helvetica, sans-serif" color="#000000" size="2"><B>PRIORIDAD</B></font></th>
          <th width="10%"><font face="Arial, Helvetica, sans-serif" color="#000000" size="2"><B>FECHA Y HORA</B></font></th>
          <th width="13%"><font face="Arial, Helvetica, sans-serif" color="#000000" size="2"><B>ENVIADO POR </B></font></th> 
		  <th width="28%"><font face="Arial, Helvetica, sans-serif" color="#000000" size="2"><B>INCIDENCIA</B></font></th>		  
		  <th width="18%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><B>ASIGNACION</B></font></th>		  
		 <?php if (isset($_REQUEST['menu'])=="ASIGNADO"){ ?>		 				  		  
          <th width="14%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><B>FECHA EST. SOLUCION</B></font></th>
          <th width="5%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><B>DIAGNOSTICO</B></font></th>		  
         <?php }else {?>
          <th width="14%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><B>FECHA EST. DE SOLUCION</B></font></th>		
		 <?php }?>
		</tr>
        <?php
if(isset($fecha)=='true'){
		$sql="SELECT a.*, c.nivel_asig, criticidad_asig, prioridad_asig FROM ordenes AS a, objetivos AS b, asignacion AS c WHERE a.dominio=b.id_dominio AND a.id_orden=c.id_orden AND a.objetivo=b.id_objetivo AND b.objetivo LIKE '%Incidente%' AND fecha BETWEEN '$fecha1' AND '$fecha2' ORDER BY fecha DESC, area ASC, dominio ASC";
}else{
		$sql="SELECT a.*, c.nivel_asig, criticidad_asig, prioridad_asig FROM ordenes AS a, objetivos AS b, asignacion AS c WHERE a.dominio=b.id_dominio AND a.id_orden=c.id_orden AND a.objetivo=b.id_objetivo AND b.objetivo LIKE '%Incidente%' ORDER BY area ASC, dominio ASC";}
		$result=mysql_db_query($db,$sql,$link); 
		while ( $row=mysql_fetch_array($result)) {	
		
		echo "<tr align=\"center\">";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; $row[id_orden]</font></td>";
		
		//Area 
		$area = area($row['area']);
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$area</font></td>";
		//Dominio
		$dominio = dominio($row['dominio']);
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$dominio</font></td>";
		//Objetivo de control
		$objetivo = objetivo($row['objetivo']);
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$objetivo</font></td>";
		
		//Complejidad
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;	$row[nivel_asig]</font></td>";
		//Criticidad
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[criticidad_asig]</font></td>";
		//Prioridad
		$objetivo = objetivo($row['objetivo']);
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[prioridad_asig]</font></td>";
		
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[fecha] $row[time]</font></td>";
		$sqls = "SELECT * FROM users WHERE login_usr='$row[cod_usr]'";
		$results = mysql_db_query($db,$sqls,$link);
		$rows = mysql_fetch_array($results);
		if (!$rows['login_usr']){ echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[cod_usr]</font></td>";}
		else{echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$rows[nom_usr] $rows[apa_usr] $rows[ama_usr]</font></td>";}
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[desc_inc]</font></td>";
		$sql1 = "SELECT id_orden, MAX(id_asig) as id_asig FROM asignacion WHERE id_orden='$row[id_orden]' GROUP BY id_orden";
		$result1 = mysql_db_query($db,$sql1,$link);
		$row1 = mysql_fetch_array($result1);
		$id_asig = $row1['id_asig']; 
		$aux = "SELECT asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion WHERE id_asig='$row1[id_asig]'";
		$resaux = mysql_db_query($db,$aux,$link);
		$rs = mysql_fetch_array($resaux);		
		$sql6 = "SELECT * FROM users WHERE login_usr='$rs[asig]'";
		$res6 = mysql_db_query($db,$sql6,$link);
		$row6 = mysql_fetch_array($res6);			
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row6[nom_usr] $row6[apa_usr] $row6[ama_usr]</font></td>";		
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$rs[fechaestsol_asig2]</font></td>";	
		echo "</tr>";
}
?>

  </table></td>
  </tr>
</table>
<?php
function area($id)
{
	include("conexion.php");
	if($id <> 0)
	{
		$sql = "select *from area where area_cod = '$id'";
		$res = mysql_db_query($db,$sql,$link);
		$row = mysql_fetch_array($res);
		$nom_area = $row['area_nombre'];
	}
	return ($nom_area);
}

function dominio($id)
{
	include("conexion.php");
	if($id <> 0)
	{
		$sql = "select *from dominio where id_dominio = '$id'";
		$res = mysql_db_query($db,$sql,$link);
		$row = mysql_fetch_array($res);
		$nom_dom = $row['dominio'];
	}
	return ($nom_dom);
}

function objetivo($id)
{
	include("conexion.php");
	if($id <> 0)
	{
		$sql = "select *from objetivos where id_objetivo = '$id'";
		$res = mysql_db_query($db,$sql,$link);
		$row = mysql_fetch_array($res);
		$nom_obj = $row['objetivo'];
	}
	return ($nom_obj);
}
?>
 