<?php
//include("datos_gral.php");
?>
<html>
<head>
<title>GesTor F1 - ORDENES DE TRABAJO</title>
<style>
.leter { FONT-FAMILY:ARIAL; font-size:11Px;}
</style>
</head>
</html>
<?php 
include ("conexion.php");
?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">ORDENES DE TRABAJO</font></u></b></div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" >
  <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="4" cellspacing="0">
        <tr align=\"center\" bgcolor="#CCCCCC"> 
          <th width="4%" height="21"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong>Nro.</strong></font></th>
		  <th width="10%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><B>NIVEL 1</B></font></th>
		  <th width="8%"><font face="Arial, Helvetica, sans-serif" color="#000000" size="2"><B>NIVEL 2</B></font></th>           		   
          <th width="10%"><font face="Arial, Helvetica, sans-serif" color="#000000" size="2"><B>NIVEL 3</B></font></th>
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
		$menu = $_GET['menu'];
		//*****************************************
		if(isset($_REQUEST['area']) == "0"){
		
		}
		//*****************************************
		/*echo $menu;	
		echo $nombre;
		echo $area;
		echo $dominio;*/
		switch ($menu) {
		   	case "GENERAL":	
				if($_REQUEST['gen'] == "1")
				{
					$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes WHERE cod_usr <> 'SISTEMA' ORDER BY id_orden DESC";
				}
				else{
					$_REQUEST['area'] = $_REQUEST['area'];
					if($_REQUEST['dominio'] == "0"){ $_REQUEST['dominio'] = "%";}
					else{ $_REQUEST['dominio'] = $_REQUEST['dominio'];}
					if($_REQUEST['objetivo'] == "0"){ $_REQUEST['objetivo'] = "%";}
					else{ $_REQUEST['objetivo'] = $_REQUEST['objetivo'];}
					//
					$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes WHERE cod_usr <> 'SISTEMA' and 
					area like '$area' and dominio like '$dominio' and objetivo like '$objetivo' ORDER BY id_orden DESC";
				}
				break;
			case "TECNICO":
				if(isset($_REQUEST['area']) == "0"){ $_REQUEST['area'] = "%";}
				else{ $_REQUEST['area'] = $_REQUEST['area'];}
				if(isset($_REQUEST['dominio']) == "0"){ $_REQUEST['dominio'] = "%";}
				else{ $_REQUEST['dominio'] = $_REQUEST['dominio'];}
				if(isset($_REQUEST['objetivo']) == "0"){ $_REQUEST['objetivo'] = "%";}
				else{ $_REQUEST['objetivo'] = $_REQUEST['objetivo'];}
				
				//$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes WHERE cod_usr='$nombre' AND area='$area' AND dominio = '$dominio' AND objetivo='$objetivo' ORDER BY id_orden DESC ";
				$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes WHERE cod_usr='$_REQUEST[nombre]' ORDER BY id_orden DESC ";
				break;
			case "AREA":
				if(isset($_REQUEST['area']) == "0"){ $_REQUEST['area'] = "%";}
				else{ $_REQUEST['area'] = $_REQUEST['area'];}
				if(isset($_REQUEST['dominio']) == "0"){ $_REQUEST['dominio'] = "%";}
				else{ $_REQUEST['dominio'] = $_REQUEST['dominio'];}
				if(isset($_REQUEST['objetivo']) == "0"){ $_REQUEST['objetivo'] = "%";}
				else{ $_REQUEST['objetivo'] = $_REQUEST['objetivo'];}
				
				echo "<font size=2 face='verdana'><b>Area:&nbsp;".$_REQUEST['nombre']."</b></font>";	
				$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha,  area_usr FROM ordenes, users WHERE ordenes.cod_usr=users.login_usr AND users.area_usr='$_REQUEST[nombre]' ORDER BY id_orden DESC ";			
				break;
			case "ASIGNADO":
				if(isset($_REQUEST['area']) == "0"){ $_REQUEST['area'] = "%";}
				else{ $_REQUEST['area'] = $_REQUEST['area'];}
				if(isset($_REQUEST['dominio']) == "0"){ $_REQUEST['dominio'] = "%";}
				else{ $_REQUEST['dominio'] = $_REQUEST['dominio'];}
				if(isset($_REQUEST['objetivo']) == "0"){ $_REQUEST['objetivo'] = "%";}
				else{ $_REQUEST['objetivo'] = $_REQUEST['objetivo'];}
							
				$condicion="users.login_usr='$_REQUEST[nombre]'";					
				$sql = "SELECT DISTINCT(asignacion.id_orden), MAX(id_asig) FROM asignacion,ordenes WHERE asig='$_REQUEST[nombre]' and ordenes.id_orden=asignacion.id_orden GROUP BY asignacion.id_orden";
				$rs1=mysql_db_query($db,$sql,$link);				
				$n=0;
				$numAsig=0; 
				while ($tmp=mysql_fetch_array($rs1))  {			
					$sql = "SELECT id_orden,id_asig, asig, diagnos , DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig	FROM asignacion WHERE id_orden=$tmp[id_orden] ORDER BY id_asig DESC";
					$rsTmp=mysql_fetch_array(mysql_db_query($db,$sql,$link));
					if ($rsTmp["asig"]==$_REQUEST['nombre']) {
						$total[$numAsig]=$rsTmp['id_orden'];						
						$str = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes WHERE id_orden = '$rsTmp[id_orden]'";
						$re  = mysql_db_query($db,$str,$link);
						$datos = mysql_fetch_array($re);
						echo "<tr align=\"center\">";
						echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$rsTmp[id_orden]</font></td>";
						$area = area($datos['area']);
						echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$area</td>";
						$dominio = dominio($datos['dominio']);
						echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$dominio</font></td>";
						$sql5 = "SELECT * FROM users WHERE login_usr='$datos[cod_usr]'";
						$result5 = mysql_db_query($db,$sql5,$link);
						$row5 = mysql_fetch_array($result5);
						$objetivo = objetivo($datos['objetivo']);
						echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$objetivo</font></td>";
						echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$datos[fecha] $datos[time]</font></td>";				
						echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</font></td>";		
						echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$datos[desc_inc]</font></td>";
						$sql6 = "SELECT * FROM users WHERE login_usr='$_REQUEST[nombre]'";
						$res6 = mysql_db_query($db,$sql6,$link);
						$row6 = mysql_fetch_array($res6);			
						echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row6[nom_usr] $row6[apa_usr] $row6[ama_usr]</font></td>";
						echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$rsTmp[fechaestsol_asig]</font></td>";							
						echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$rsTmp[diagnos]</font></td>";									
					$numAsig++;					
					}
				}
				$resto = $numAsig - $n;
				echo "<font size=2 face='verdana'><b> Asignados:&nbsp;".$resto."</b></font>";
				//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=2 face='verdana'><b>Escalados:&nbsp;&nbsp;".$n."</b></font>";
				exit;				
				break;
			case "CLIENTE":
				if(isset($_REQUEST['area']) == "0"){ $_REQUEST['area'] = "%";}
				else{ $_REQUEST['area'] = $_REQUEST['area'];}
				if(isset($_REQUEST['dominio']) == "0"){ $_REQUEST['dominio'] = "%";}
				else{ $_REQUEST['dominio'] = $_REQUEST['dominio'];}
				if(isset($_REQUEST['objetivo']) == "0"){ $_REQUEST['objetivo'] = "%";}
				else{ $_REQUEST['objetivo'] = $_REQUEST['objetivo'];}
				/*$sql = "SELECT id_orden, ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha, login_usr, tipo2_usr FROM ordenes, users 
				WHERE ordenes.cod_usr= users.login_usr AND users.login_usr='$nombre' AND users.tipo2_usr='C' and 
				area like '$area' and dominio like '$dominio' and objetivo like '$objetivo' ORDER BY id_orden DESC ";*/
				$sql = "SELECT id_orden, ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha, login_usr, tipo2_usr FROM ordenes, users 
					WHERE ordenes.cod_usr= users.login_usr AND users.login_usr='$_REQUEST[nombre]' AND users.tipo2_usr='C' ORDER BY id_orden DESC ";
				break;
			case "CIUDAD":
				if(isset($_REQUEST['area']) == "0"){ $_REQUEST['area'] = "%";}
				else{ $_REQUEST['area'] = $_REQUEST['area'];}
				if(isset($_REQUEST['dominio']) == "0"){ $_REQUEST['dominio'] = "%";}
				else{ $_REQUEST['dominio'] = $_REQUEST['dominio'];}
				if(isset($_REQUEST['objetivo']) == "0"){ $_REQUEST['objetivo'] = "%";}
				else{ $_REQUEST['objetivo'] = $_REQUEST['objetivo'];}
				
				echo "<font size=2 face='verdana'><b>Ciudad:&nbsp;".$_REQUEST['nombre']."</b></font>";
				$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha,  ciu_usr FROM ordenes, users 
WHERE ordenes.cod_usr=users.login_usr AND users.ciu_usr ='$_REQUEST[nombre]' ORDER BY id_orden DESC";				
				break;
			case "ADICIONAL1":
				$sqls = "SELECT  id_dadicional  FROM datos_adicionales WHERE nombre_dadicional='$_REQUEST[nombre]'";
				$ress  = mysql_db_query($db,$sqls,$link);
				$rows = mysql_fetch_array($ress); 
				echo "<font size=2 face='verdana'><b>AGENCIA:&nbsp;".$_REQUEST[nombre]."</b></font>";
				$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha, login_usr, adicional1  FROM ordenes, users 
				WHERE ordenes.cod_usr=users.login_usr AND users.adicional1 ='$rows[id_dadicional]' ORDER BY id_orden DESC";				
				break; 										
			case "ASIGN":
				$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes, asignacion WHERE cod_usr<>'SISTEMA' AND ordenes.id_orden=asignacion.id_orden GROUP BY id_orden ORDER BY id_orden DESC";
				break; 
			case "SOLUCION":
				$condicion = "cod_usr<>'SISTEMA'";													
				$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes, solucion WHERE $condicion AND ordenes.id_orden=solucion.id_orden ORDER BY id_orden DESC";
				break; 
			case "NOSOLUCION":
				$sql = "SELECT ordenes.*, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha, ci_ruc FROM ordenes, users WHERE cod_usr<>'SISTEMA' AND ordenes.cod_usr=users.login_usr ORDER BY id_orden DESC ";
				$res = mysql_db_query($db, $sql, $link); 
				while ($fila = mysql_fetch_array($res))
				{	$sql2 = "SELECT * FROM solucion WHERE id_orden='$gen[$i]'";	
					$res2 = mysql_db_query($db, $sql2, $link); 	
					$row2 = mysql_fetch_array($res2);
					if (empty($row2[id_orden]))
					{	echo "<tr><td class='leter'>$fila[id_orden]</td>";
						if ($fila[id_anidacion]==0){echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;NINGUNO</td>";}
						else{echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$fila[id_anidacion]</td>";}
						echo "<td class='leter'>$fila[fecha] $fila[time]</td>";
						
						$sqls = "SELECT * FROM users WHERE login_usr='$fila[cod_usr]'";
						$results = mysql_db_query($db,$sqls,$link);
						$rows = mysql_fetch_array($results);						
						echo "<td class='leter'> $rows[apa_usr] $rows[ama_usr] $rows[nom_usr]</td>";
						echo "<td class='leter'>$rows[tipo2_usr]</td>";
						echo "<td class='leter'>$fila[ci_ruc] &nbsp;</td>";
						$aux = "SELECT asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion WHERE id_asig='$fila[id_asig]'";
						$resaux = mysql_db_query($db,$aux,$link);
						$rs = mysql_fetch_array($resaux);		
						echo "<td class='leter'>$fila[desc_inc]</td>";
						$sql6 = "SELECT * FROM users WHERE login_usr='$rs[asig]'";
						$res6 = mysql_db_query($db,$sql6,$link);
						$row6 = mysql_fetch_array($res6);			
						echo "<td class='leter'>&nbsp;$row6[nom_usr] $row6[apa_usr] $row6[ama_usr] &nbsp;</td>";						
						echo "<td class='leter'>$rs[fechaestsol_asig2] &nbsp;</td>";
					}		
				}
				break;
				exit;
			case "NOASIGN":
				$sql = "SELECT ordenes.*, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha, ci_ruc FROM ordenes, users WHERE cod_usr<>'SISTEMA' AND ordenes.cod_usr=users.login_usr ORDER BY id_orden DESC ";
				$res = mysql_db_query($db, $sql, $link); 
				while ($fila = mysql_fetch_array($res))
				{	$sql2 = "SELECT MAX(id_asig) as id_asig FROM asignacion WHERE id_orden='$fila[id_orden]'";	
					$res2 = mysql_db_query($db, $sql2, $link); 	
					$row2 = mysql_fetch_array($res2);					
					if (empty($row2[id_asig]))
					{	echo "<tr><td class='leter'>$fila[id_orden]</td>";
						if ($fila[id_anidacion]==0){echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;NINGUNO</td>";}
						else{echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$fila[id_anidacion]</td>";}
						echo "<td class='leter'>$fila[fecha] $fila[time]</td>";
						$sqls = "SELECT * FROM users WHERE login_usr='$fila[cod_usr]'";
						$results = mysql_db_query($db,$sqls,$link);
						$rows = mysql_fetch_array($results);						
						echo "<td class='leter'> $rows[apa_usr] $rows[ama_usr] $rows[nom_usr]</td>";
						echo "<td class='leter'>$rows[tipo2_usr]</td>";
						echo "<td class='leter'>$fila[ci_ruc] &nbsp;</td>";						
						echo "<td class='leter'>$fila[desc_inc]</td>";
						echo "<td class='leter'>&nbsp;</td>";						
						echo "<td class='leter'>&nbsp;</td>";
					}		
				}
				exit;
				break;
			case "NOCONFORMIDAD":
				$sql = "SELECT ordenes.*, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha, ci_ruc FROM ordenes, users WHERE cod_usr<>'SISTEMA' AND ordenes.cod_usr=users.login_usr ORDER BY id_orden DESC ";
				$res = mysql_db_query($db, $sql, $link); 
				while ($fila = mysql_fetch_array($res))
				{	$sql2 = "SELECT * FROM conformidad WHERE id_orden='$fila[id_orden]'";	
					$res2 = mysql_db_query($db, $sql2, $link); 	
					$row2 = mysql_fetch_array($res2);
					if (empty($row2[id_orden]))	
					{	echo "<tr><td class='leter'>$fila[id_orden]</td>";
						if ($fila[id_anidacion]==0){echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;NINGUNO</td>";}
						else{echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$fila[id_anidacion]</td>";}
						echo "<td class='leter'>$fila[fecha] $fila[time]</td>";
						$sqls = "SELECT * FROM users WHERE login_usr='$fila[cod_usr]'";
						$results = mysql_db_query($db,$sqls,$link);
						$rows = mysql_fetch_array($results);						
						echo "<td class='leter'> $rows[apa_usr] $rows[ama_usr] $rows[nom_usr]</td>";
						echo "<td class='leter'>$rows[tipo2_usr]</td>";
						echo "<td class='leter'>$fila[ci_ruc] &nbsp;</td>";
						$aux = "SELECT asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion WHERE id_asig='$fila[id_asig]'";
						$resaux = mysql_db_query($db,$aux,$link);
						$rs = mysql_fetch_array($resaux);		
						echo "<td class='leter'>$fila[desc_inc]</td>";
						$sql6 = "SELECT * FROM users WHERE login_usr='$rs[asig]'";
						$res6 = mysql_db_query($db,$sql6,$link);
						$row6 = mysql_fetch_array($res6);			
						echo "<td class='leter'>&nbsp;$row6[nom_usr] $row6[apa_usr] $row6[ama_usr] &nbsp;</td>";						
						echo "<td class='leter'>$rs[fechaestsol_asig2] &nbsp;</td>";
					}					
				} 											
				break;
				exit;
								
			case "CONFORMIDAD":
				//$condicion = "cod_usr<>'SISTEMA'";
			 	$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes, conformidad WHERE ordenes.cod_usr <> 'SISTEMA' AND ordenes.id_orden=conformidad.id_orden ORDER BY id_orden DESC";
				//break; 							
		}
	//echo "***".$sql;
		
		$result=mysql_db_query($db,$sql,$link); 
		while ( $row=mysql_fetch_array($result)) {	
		echo "<tr align=\"center\">";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; $row[id_orden]</font></td>";
		//echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;NINGUNO</td>";
		//echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$rows[tipo2_usr]</font></td>";
		//**********Nuevo
		
		//Area 
		$area = area($row['area']);
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$area</font></td>";
		//Dominio
		$dominio = dominio($row['dominio']);
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$dominio</font></td>";
		//Objetivo de control
		$objetivo = objetivo($row['objetivo']);
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$objetivo</font></td>";
		
		//**********
		//
		//echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[ci_ruc]</font></td>";	
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
		//echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".$lstProveedor[$row[Proveedor]]."</font></td>";	
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
	return (isset($nom_obj));
}
?>
 