<?php
include("conexion.php");

switch ($menu)
{
	case "TECNICO":
		$condicion=" AND c.login_usr='$nom' ";		
	case "CLIENTE":
		$condicion="AND c.login_usr='$nom'";
		break;
	case "AREA":
		$condicion="AND c.area_usr='$nom'";
		break;
	case "CIUDAD":
		$condicion="AND c.ciu_usr='$nom'";
		break;
	case "ADICIONAL1":
		$sql0="SELECT * FROM datos_adicionales WHERE nombre_dadicional='$nom'";
		$rs0=mysql_db_query($db,$sql0,$link);
		$row0=mysql_fetch_array($rs0);
		$id_dadicional=$row0['id_dadicional'];
		$condicion=" AND c.adicional1='$id_dadicional'";
		break;
}

//NUMERO DE ORDENES ASIGNADAS/*
if ($tipo=="asignadas") {
$nombre="ASIGNADAS";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
	$resultbo=mysql_db_query($db, $sqlbo, $link);
	while ($rowbo = mysql_fetch_array($resultbo)) 
	{
		$sql_as="SELECT id_orden FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
		$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
		if($row_as[id_orden])
		{
			$auxbo=$auxbo.",".$rowbo[id_orden];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	if($menu=='TECNICO')
	{	$sql="SELECT o.* AS num FROM ordenes AS o, asignacion AS a WHERE o.id_orden = a.id_orden AND a.asig='$nom' ORDER BY o.id_orden DESC";	}
	elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM ordenes AS o, asignacion AS a WHERE o.id_orden = a.id_orden AND o.cod_usr='$nom' ORDER BY o.id_orden DESC";
	} else {
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
}

//NUMERO DE ORDENES NO ASIGNADAS
if ($tipo=="noasignadas") {
$nombre="NO ASIGNADAS";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
	$resultbo=mysql_db_query($db, $sqlbo, $link);
	while ($rowbo = mysql_fetch_array($resultbo)) 
	{
		$sql_as="SELECT id_orden FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
		$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
		if($row_as['id_orden']=="")
		{
			$auxbo=$auxbo.",".$rowbo['id_orden'];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	if($menu=='TECNICO')
		$sql="SELECT ordenes.* FROM ordenes WHERE id_orden NOT IN (select id_orden from asignacion) AND cod_usr='$nom' ORDER BY id_orden DESC";
	elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM ordenes AS o WHERE o.id_orden NOT IN (select id_orden from asignacion) AND cod_usr='$nom' ORDER BY o.id_orden DESC";
	}
	else {
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
}

//NUMERO DE ORDENES ESCALADAS
if ($tipo=="escaladas") {
	$nombre="ESCALADAS";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi]";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				if($row_as[escal]<>'0')
				{
					$auxbo=$auxbo.",".$row_as[id_orden];
				}
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		
			$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
		
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden,escal FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				if($row_as[escal]<>'0'){$auxbo=$auxbo.",".$rowbo[id_orden];}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM `asignacion` AS a, users AS u, ordenes AS o WHERE a.id_orden=o.id_orden AND u.login_usr=a.escal AND a.asig='$nom' ORDER BY id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM `asignacion` AS a, ordenes As o, users AS u WHERE u.login_usr=a.escal AND o.cod_usr='$nom' AND a.id_orden=o.id_orden ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}
//NUMERO DE ORDENES NO ESCALADAS
if ($tipo=="noescaladas") {
	$nombre="NO ESCALADAS";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi]";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				if($row_as[escal]=='0')
				{
					$auxbo=$auxbo.",".$row_as[id_orden];
				}
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden,escal FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				if($row_as[escal]=='0'){$auxbo=$auxbo.",".$rowbo[id_orden];}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM asignacion AS a,ordenes AS o  WHERE a.escal NOT IN (select login_usr from users) AND a.asig='$nom' AND a.id_orden=o.id_orden ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM asignacion AS a, ordenes AS o WHERE a.escal NOT IN (select login_usr from users) AND o.id_orden=a.id_orden AND o.cod_usr='$nom' ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

//NUMERO DE ORDENES CON SEGUIMIENTO ++++++++++++++++++++++++
if ($tipo=="conseguimiento") {
	$nombre="CON SEGUIMIENTO";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
	$resultbo=mysql_db_query($db, $sqlbo, $link);
	while ($rowbo = mysql_fetch_array($resultbo)) 
	{
		$sql_as="SELECT id_orden FROM seguimiento WHERE id_orden='$rowbo[id_orden]' ORDER BY id_seg DESC limit 1";
		$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
		if($row_as[id_orden])
		{
			$auxbo=$auxbo.",".$rowbo[id_orden];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	if($menu=='TECNICO')
		$sql="SELECT DISTINCT(o.id_orden),o.fecha,o.time,o.cod_usr,o.desc_inc,o.tipo,o.nomb_archivo,o.area,o.dominio,o.objetivo,o.id_anidacion,o.origen,o.observaciones FROM asignacion AS a, seguimiento AS s, ordenes AS o WHERE o.id_orden=a.id_orden AND a.id_orden = s.id_orden AND a.asig='$nom' ORDER BY o.id_orden DESC";
	elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM `ordenes` AS o, seguimiento AS s WHERE o.id_orden = s.id_orden AND o.cod_usr='$nom' ORDER BY o.id_orden DESC";
	}
	else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
}

//MUMERO DE ORDENES SIN SEGUIMIENTO ++++++++++++++++++++++++
if ($tipo=="sinseguimiento") {
$nombre="SIN SEGUIMIENTO";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
	$resultbo=mysql_db_query($db, $sqlbo, $link);
	while ($rowbo = mysql_fetch_array($resultbo)) 
	{
		$sql_as="SELECT id_orden FROM seguimiento WHERE id_orden='$rowbo[id_orden]' ORDER BY id_seg DESC limit 1";
		$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
		if($row_as[id_orden]=="")
		{
			$auxbo=$auxbo.",".$rowbo[id_orden];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	if($menu=='TECNICO')
		$sql="select DISTINCT(o.id_orden),o.fecha,o.time,o.cod_usr,o.desc_inc,o.tipo,o.nomb_archivo,o.area,o.dominio,o.objetivo,o.id_anidacion,o.origen,o.observaciones FROM asignacion AS a, seguimiento AS s, ordenes AS o WHERE a.id_orden=o.id_orden AND a.asig='$nom' AND a.id_orden NOT IN (select id_orden FROM seguimiento) ORDER BY id_orden DESC";
	elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM `ordenes` AS o WHERE o.id_orden NOT IN (SELECT id_orden FROM seguimiento) AND o.cod_usr='$nom' ORDER BY o.id_orden DESC";
	}
	else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
}

//NUMERO DE ORDENES CON SOLUCION
if ($tipo=="consolucion") {
	$nombre="CON SOLUCION";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi]";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$sql_so="SELECT * FROM solucion WHERE id_orden='$row_as[id_orden]'";
				$row_so=mysql_fetch_array(mysql_db_query($db,$sql_so,$link));
				if($row_so[id_orden])
				{
					$auxbo=$auxbo.",".$row_so[id_orden];
				}
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden FROM solucion WHERE id_orden='$rowbo[id_orden]'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				$auxbo=$auxbo.",".$rowbo[id_orden];
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM `ordenes` AS o, solucion AS s WHERE o.id_orden = s.id_orden AND s.login_sol='$nom' ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM `ordenes` AS o, solucion AS s WHERE o.id_orden = s.id_orden AND o.cod_usr='$nom' ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

//NUMERO DE ORDENES SIN SOLUCION
if ($tipo=="sinsolucion") {
	$nombre="SIN SOLUCION";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi]";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$sql_so="SELECT * FROM solucion WHERE id_orden='$row_as[id_orden]'";
				$row_so=mysql_fetch_array(mysql_db_query($db,$sql_so,$link));
				if($row_so[id_orden]=="")
				{
					$auxbo=$auxbo.",".$row_as[id_orden];
				}
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				$sql_so="SELECT id_orden FROM solucion WHERE id_orden='$row_as[id_orden]'";
				$row_so=mysql_fetch_array(mysql_db_query($db,$sql_so,$link));
				if($row_so[id_orden]=="")
				{
					$auxbo=$auxbo.",".$row_as[id_orden];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM asignacion AS a, ordenes AS o WHERE a.id_orden=o.id_orden AND a.asig='$nom' AND a.id_orden NOT IN (SELECT id_orden FROM solucion) ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM ordenes AS o WHERE o.id_orden NOT IN (select id_orden from solucion) AND o.cod_usr='$nom' ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

//NUMERO DE ORDNES CON CONFORMIDAD DEL CLIENTE
if ($tipo=="conconformidad") {
	$nombre="CON CONFORMIDAD";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi]";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$sql_so="SELECT * FROM conformidad WHERE id_orden='$row_as[id_orden]'";
				$row_so=mysql_fetch_array(mysql_db_query($db,$sql_so,$link));
				if($row_so[id_orden])
				{
					$auxbo=$auxbo.",".$row_so[id_orden];
				}
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden FROM conformidad WHERE id_orden='$rowbo[id_orden]'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				$auxbo=$auxbo.",".$rowbo[id_orden];
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM ordenes AS o, conformidad AS c, solucion AS s WHERE o.id_orden = c.id_orden AND s.login_sol='$nom' AND c.id_orden=s.id_orden ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM ordenes AS o, conformidad AS c WHERE o.id_orden = c.id_orden AND o.cod_usr='$nom' ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
if ($tipo=="sinconformidad") {
	$nombre="SIN CONFORMIDAD";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi]";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$sql_so="SELECT * FROM solucion WHERE id_orden='$row_as[id_orden]'";
				$row_so=mysql_fetch_array(mysql_db_query($db,$sql_so,$link));
				if($row_so[id_orden])
				{
					$sql_co="SELECT * FROM conformidad WHERE id_orden='$row_so[id_orden]'";
					$row_co=mysql_fetch_array(mysql_db_query($db,$sql_co,$link));
					if($row_co[id_orden]=="")
					{
						$auxbo=$auxbo.",".$row_so[id_orden];
					}
				}
			}
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,','', $auxbo);}
		
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				$sql_so="SELECT id_orden FROM solucion WHERE id_orden='$row_as[id_orden]'";
				$row_so=mysql_fetch_array(mysql_db_query($db,$sql_so,$link));
				if($row_so[id_orden])
				{
					$sql_co="SELECT id_orden FROM conformidad WHERE id_orden='$row_so[id_orden]'";
					$row_co=mysql_fetch_array(mysql_db_query($db,$sql_co,$link));
					if($row_co[id_orden]=="")
					{
						$auxbo=$auxbo.",".$row_so[id_orden];
					}
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* AS num FROM solucion AS s,ordenes AS o WHERE o.id_orden=s.id_orden AND s.id_orden NOT IN (select id_orden from conformidad) AND s.login_sol='$nom' ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM solucion AS s, ordenes AS o WHERE s.id_orden NOT IN (select id_orden from conformidad) AND s.id_orden=o.id_orden AND o.cod_usr='$nom' ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}
// =================

//HERDE ORDENES CON CONFORMIDAD DE LAS CUALES XXX son Disconformes
if ($tipo=="disconforme") {
	$nombre="DISCONFORME";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi]";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$sql_so="SELECT * FROM conformidad WHERE id_orden='$row_as[id_orden]'";
				$row_so=mysql_fetch_array(mysql_db_query($db,$sql_so,$link));
				if($row_so[id_orden])
				{
					if($row_so[tipo_conf]=='2')
					{
						$auxbo=$auxbo.",".$row_as[id_orden];
					}
				}
			}
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden FROM conformidad WHERE id_orden='$rowbo[id_orden]' AND tipo_conf='2'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				$auxbo=$auxbo.",".$rowbo[id_orden];
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM solucion AS s, conformidad AS c,ordenes AS o WHERE o.id_orden=s.id_orden AND s.login_sol='$nom' AND c.id_orden=s.id_orden AND c.tipo_conf='2' ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM conformidad AS c, ordenes AS o WHERE c.tipo_conf='2' AND o.cod_usr='$nom' AND o.id_orden=c.id_orden ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

//HERDE ORDENES CON CONFORMIDAD DE LAS CULAES XXX realmente estan conformes
if ($tipo=="conforme") {
	$nombre="CONFORME";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi]";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$sql_so="SELECT * FROM conformidad WHERE id_orden='$row_as[id_orden]' AND tipo_conf='1'";
				$row_so=mysql_fetch_array(mysql_db_query($db,$sql_so,$link));
				if($row_so[id_orden])
				{
					$auxbo=$auxbo.",".$row_as[id_orden];
				}
			}
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
			$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
		
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden FROM conformidad WHERE id_orden='$rowbo[id_orden]' AND tipo_conf='1'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				$auxbo=$auxbo.",".$rowbo[id_orden];
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM solucion AS s, conformidad AS c,ordenes AS o WHERE o.id_orden=s.id_orden AND s.login_sol='$nom' AND c.id_orden=s.id_orden AND c.tipo_conf='1' ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM conformidad AS c, ordenes AS o WHERE c.tipo_conf='1' AND o.cod_usr='$nom' AND o.id_orden=c.id_orden ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

//NUMERO DE ORDENES CON COSTO
if ($tipo=="concosto") {
	$nombre="CON COSTO";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi]";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$sql_so="SELECT * FROM costo WHERE id_orden='$row_as[id_orden]'";
				$row_so=mysql_fetch_array(mysql_db_query($db,$sql_so,$link));
				if($row_so[id_orden])
				{
					echo $row_so[id_orden];
					$auxbo=$auxbo.",".$row_as[id_orden];
				}
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden FROM costo WHERE id_orden='$rowbo[id_orden]' GROUP BY id_orden";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				$auxbo=$auxbo.",".$rowbo[id_orden];
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* from costo AS c, ordenes AS o, asignacion AS a WHERE o.id_orden=c.id_orden AND a.id_orden='$nombre' AND a.id_orden=c.id_orden ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* from costo AS c, ordenes AS o WHERE o.id_orden=c.id_orden AND o.cod_usr='$nom' ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

//NUMERO DE ORDENES SIN COSTO
if ($tipo=="sincosto") {
	$nombre="SIN COSTO";
	if ($menu="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi]";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$sql_so="SELECT * FROM costo WHERE id_orden='$row_as[id_orden]'";
				$row_so=mysql_fetch_array(mysql_db_query($db,$sql_so,$link));
				if($row_so[id_orden]=="")
				{
					echo $row_so[id_orden];
					$auxbo=$auxbo.",".$row_as[id_orden];
				}
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM asignacion AS a, ordenes AS o WHERE a.id_orden=o.id_orden AND a.asig='$nom' AND a.id_orden NOT IN (SELECT id_orden FROM costo)";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM ordenes AS o WHERE o.id_orden NOT IN (SELECT id_orden FROM costo) AND o.cod_usr='$nom' ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden FROM costo WHERE id_orden='$rowbo[id_orden]' GROUP BY id_orden";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as['id_orden']=="")
			{
				$auxbo=$auxbo.",".$rowbo['id_orden'];
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM asignacion AS a, ordenes AS o WHERE a.id_orden=o.id_orden AND a.asig='$nom' AND a.id_orden NOT IN (SELECT id_orden FROM costo)";
		else
			$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
		
	}
}

//NUMERO DE ORDENES CON ANIDAMIENTO
if ($tipo=="anidadas") {
	$nombre="ANIDADAS";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi]";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$sql_so="SELECT * FROM conformidad WHERE id_orden='$row_as[id_orden]'";
				$row_so=mysql_fetch_array(mysql_db_query($db,$sql_so,$link));
				if($row_so[id_orden])
				{
					$sql_an="SELECT * FROM ordenes WHERE id_anidacion='$row_so[id_orden]'";
					$row_an=mysql_fetch_array(mysql_db_query($db,$sql_an,$link));
					if($row_an[id_orden])
					{
						$auxbo=$auxbo.",".$row_an[id_orden];
					}
				}
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND cod_usr='$nom'  ";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden FROM conformidad WHERE id_orden='$rowbo[id_orden]'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				$sql_an="SELECT * FROM ordenes WHERE id_anidacion='$row_as[id_orden]'";
				$row_an=mysql_fetch_array(mysql_db_query($db,$sql_an,$link));
				if($row_an[id_orden])
				{
					$auxbo=$auxbo.",".$row_an[id_orden];
				}
			}			
		}
		//echo $auxbo."<br>";
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM ordenes o, asignacion a WHERE o.id_anidacion <> '0' AND a.asig='$nom' AND o.id_orden=a.id_orden ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM ordenes o WHERE o.id_anidacion <> '0' AND o.cod_usr='$nom' ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
		//echo $sql;
	}
}

//NUMERO DE ORDENES SIN ANIDAMIENTO
if ($tipo=="sinanidar") {
	$nombre="SIN ANIDAR";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi]";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$sql_so="SELECT * FROM conformidad WHERE id_orden='$row_as[id_orden]'";
				$row_so=mysql_fetch_array(mysql_db_query($db,$sql_so,$link));
				if($row_so[id_orden])
				{
					$sql_an="SELECT * FROM ordenes WHERE id_anidacion='$row_so[id_orden]' AND id_anidacion=0";
					$row_an=mysql_fetch_array(mysql_db_query($db,$sql_an,$link));
					if(!$row_an[id_orden])
					{
						$auxbo=$auxbo.",".$row_so[id_orden];
					}
				}
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden FROM conformidad WHERE id_orden='$rowbo[id_orden]'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				$sql_an="SELECT * FROM ordenes WHERE id_anidacion='$row_as[id_orden]' AND id_anidacion<>0";
				$row_an=mysql_fetch_array(mysql_db_query($db,$sql_an,$link));
				if(!$row_an[id_orden])
				{
					$auxbo=$auxbo.",".$row_as[id_orden];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM ordenes o, asignacion a WHERE o.id_anidacion = '0' AND a.asig='$nom' AND o.id_orden=a.id_orden ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM ordenes o WHERE o.id_anidacion = '0' AND o.cod_usr='$nom' ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

//ORIGINADAS POR PROCESOS
if ($tipo=="originadasporprocesos") {
	$nombre="ORIGINADAS POR PROCESOS";
	if ($menu=="ASIGNADO")
	{
	$sql = "SELECT DATE_FORMAT(a.fecha,'%d/%m/%Y') AS fecha1, a.*
		 FROM ordenes AS a JOIN asignacion AS c 
		 ON a.id_orden=c.id_orden 
		 WHERE a.id_proceso<>'0' 
		 AND c.asig='$nom' 
		 AND a.cod_usr<>'SISTEMA' 
		 ORDER BY a.id_orden DESC";
	}
	else
	{
	$sql = "SELECT DATE_FORMAT(a.fecha,'%d/%m/%Y') AS fecha1, a.*
		 FROM ordenes AS a JOIN users AS c 
		 ON a.cod_usr=c.login_usr 
		 WHERE a.id_proceso<>'0' 
		 $condicion 
		 AND a.cod_usr<>'SISTEMA' 
		 ORDER BY a.id_orden DESC";
	}
}

// SIN ORIGEN EN UN PROCESO
if ($tipo=="sinorigenenunproceso") {
	$nombre="SIN ORIGEN EN UN PROCESO";
	if ($menu=="ASIGNADO")
	{
	$sql = "SELECT DATE_FORMAT(a.fecha,'%d/%m/%Y') AS fecha1, a.*
		 FROM ordenes AS a JOIN asignacion AS c 
		 ON a.id_orden=c.id_orden
		 WHERE a.id_proceso='0' 
		 AND c.asig='$nom'
		 AND a.cod_usr<>'SISTEMA' 
		 ORDER BY a.id_orden DESC";
	}
	else
	{
	$sql = "SELECT DATE_FORMAT(a.fecha,'%d/%m/%Y') AS fecha1, a.*
		 FROM ordenes AS a JOIN users AS c 
		 ON a.cod_usr=c.login_usr 
		 WHERE a.id_proceso='0' 
		 $condicion 
		 AND a.cod_usr<>'SISTEMA' 
		 ORDER BY a.id_orden DESC";
	}
}

//=============USUARIOS=================
//NUMERO DE ADMINISTRADORES
$sql7 = "SELECT count(tipo2_usr) AS adm FROM users WHERE tipo2_usr='A'";
$row7 = mysql_fetch_array(mysql_db_query($db,$sql7,$link));

//NUMERO DE CLIENTES
$sql8 = "SELECT count(tipo2_usr) AS cli FROM users WHERE tipo2_usr='C'";
$row8 = mysql_fetch_array(mysql_db_query($db,$sql8,$link));

//NUMERO DE TECNICOS
$sql9 = "SELECT count(tipo2_usr) AS tec FROM users WHERE tipo2_usr='T'";
$row9 = mysql_fetch_array(mysql_db_query($db,$sql9,$link));

//NUMERO TOTAL DE TECNICOS
$totuser=$row7[adm]+$row8[cli]+$row9[tec];

//Complejidad, criticidad, prioridad
		//Complejidad, criticidad, prioridad
	
if ($tipo=="complejidadalta")
{
	$nombre="COMPLEJIDAD ALTA";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi] AND nivel_asig='3'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$auxbo=$auxbo.",".$row_as[id_orden];
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden,nivel_asig FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				if($row_as[nivel_asig]=='3')
				{
					$auxbo=$auxbo.",".$rowbo[id_orden];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM asignacion AS a,ordenes AS o WHERE a.id_orden=o.id_orden AND a.nivel_asig='3' AND a.asig='$nom' ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM asignacion AS a, ordenes AS o WHERE a.nivel_asig='1' AND o.id_orden=a.id_orden AND o.cod_usr='$nom' GROUP by o.id_orden ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}	
}

if ($tipo=="complejidadmedia")
{
	$nombre="COMPLEJIDAD MEDIA";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi] AND nivel_asig='2'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$auxbo=$auxbo.",".$row_as[id_orden];
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden,nivel_asig FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				if($row_as[nivel_asig]=='2')
				{	
					$auxbo=$auxbo.",".$rowbo[id_orden];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM asignacion AS a,ordenes AS o WHERE a.id_orden=o.id_orden AND a.nivel_asig='2' AND a.asig='$nom' ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM asignacion AS a, ordenes AS o WHERE a.nivel_asig='2' AND o.id_orden=a.id_orden AND o.cod_usr='$nom' GROUP by o.id_orden ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

if ($tipo=="complejidadbaja")
{
	$nombre="COMPLEJIDAD BAJA";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi] AND nivel_asig='1'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$auxbo=$auxbo.",".$row_as[id_orden];
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden,nivel_asig FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				if($row_as[nivel_asig]=='1')
				{
					$auxbo=$auxbo.",".$rowbo[id_orden];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM asignacion AS a,ordenes AS o WHERE a.id_orden=o.id_orden AND a.nivel_asig='1' AND a.asig='$nom' ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM asignacion AS a, ordenes AS o WHERE a.nivel_asig='3' AND o.id_orden=a.id_orden AND o.cod_usr='$nom' GROUP by o.id_orden ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

if ($tipo=="criticidadalta")
{
	$nombre="CRITICIDAD ALTA";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi] AND criticidad_asig='1'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$auxbo=$auxbo.",".$row_as[id_orden];
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden,criticidad_asig FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				if($row_as[criticidad_asig]=='1')
				{
					$auxbo=$auxbo.",".$rowbo[id_orden];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM asignacion AS a,ordenes AS o WHERE a.id_orden=o.id_orden AND a.criticidad_asig='3' AND asig='$nom' ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM asignacion AS a, ordenes AS o WHERE a.criticidad_asig='3' AND o.id_orden=a.id_orden AND o.cod_usr='$nom' GROUP by o.id_orden ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

if ($tipo=="criticidadmedia")
{
	$nombre="CRITICIDAD MEDIA";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi] AND criticidad_asig='2'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$auxbo=$auxbo.",".$row_as[id_orden];
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden,criticidad_asig FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				if($row_as[criticidad_asig]=='2')
				{	
					$auxbo=$auxbo.",".$rowbo[id_orden];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM asignacion AS a,ordenes AS o WHERE a.id_orden=o.id_orden AND a.criticidad_asig='2' AND asig='$nom' ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM asignacion AS a, ordenes AS o WHERE a.criticidad_asig='2' AND o.id_orden=a.id_orden AND o.cod_usr='$nom' GROUP by o.id_orden ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

if ($tipo=="criticidadbaja")
{
	$nombre="CRITICIDAD BAJA";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi] AND criticidad_asig='3'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$auxbo=$auxbo.",".$row_as[id_orden];
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden,criticidad_asig FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				if($row_as[criticidad_asig]=='3')
				{
					$auxbo=$auxbo.",".$rowbo[id_orden];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM asignacion AS a,ordenes AS o WHERE a.id_orden=o.id_orden AND a.criticidad_asig='1' AND asig='$nom' ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM asignacion AS a, ordenes AS o WHERE a.criticidad_asig='1' AND o.id_orden=a.id_orden AND o.cod_usr='$nom' GROUP by o.id_orden ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

if ($tipo=="prioridadalta")
{
	$nombre="PRIORIDAD ALTA";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi] AND prioridad_asig='1'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$auxbo=$auxbo.",".$row_as[id_orden];
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";	
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden,prioridad_asig FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				if($row_as[prioridad_asig]=='1')
				{
					$auxbo=$auxbo.",".$rowbo[id_orden];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM asignacion AS a,ordenes AS o WHERE a.id_orden=o.id_orden AND a.prioridad_asig='3' AND asig='$nom' ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM asignacion AS a, ordenes AS o WHERE a.prioridad_asig='3' AND o.id_orden=a.id_orden AND o.cod_usr='$nom' GROUP by o.id_orden ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

if ($tipo=="prioridadmedia")
{
	$nombre="PRIORIDAD MEDIA";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi] AND prioridad_asig='2'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$auxbo=$auxbo.",".$row_as[id_orden];
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden,prioridad_asig FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				if($row_as[prioridad_asig]=='2')
				{
					$auxbo=$auxbo.",".$rowbo[id_orden];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM asignacion AS a,ordenes AS o WHERE a.id_orden=o.id_orden AND a.prioridad_asig='2' AND asig='$nom' ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM asignacion AS a, ordenes AS o WHERE a.prioridad_asig='2' AND o.id_orden=a.id_orden AND o.cod_usr='$nom' GROUP by o.id_orden ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}

if ($tipo=="prioridadbaja")
{
	$nombre="PRIORIDAD BAJA";
	if ($menu=="ASIGNADO")
	{
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT * FROM asignacion WHERE id_asig=$rowbo[maxi] AND prioridad_asig='3'";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nom)
			{
				$auxbo=$auxbo.",".$row_as[id_orden];
			}
			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
	}
	else
	{
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr='$nom' AND cod_usr<>'SISTEMA'";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden,prioridad_asig FROM asignacion WHERE id_orden='$rowbo[id_orden]' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[id_orden])
			{
				if($row_as[prioridad_asig]=='3')
				{
					$auxbo=$auxbo.",".$rowbo[id_orden];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		if($menu=='TECNICO')
			$sql="SELECT o.* FROM asignacion AS a,ordenes AS o WHERE a.id_orden=o.id_orden AND a.prioridad_asig='1' AND asig='$nom' ORDER BY o.id_orden DESC";
		elseif($menu=='CLIENTE') {
		$sql="SELECT DISTINCT(o.id_orden),o.* FROM asignacion AS a, ordenes AS o WHERE a.prioridad_asig='1' AND o.id_orden=a.id_orden AND o.cod_usr='$nom' GROUP by o.id_orden ORDER BY o.id_orden DESC";
		}
		else {	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";		}
	}
}
$query=mysql_db_query($db,$sql,$link);
$count=mysql_db_query($db,$sql,$link);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
<!--
body          {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
th            {font-family: Arial, Helvetica, sans-serif; font-size: small; font-weight: bolder; color: #FFFFFF; background-color: #006699}
.th2           {font-family: Arial, Helvetica, sans-serif; font-size: 10; font-weight: bolder; color: #FFFFFF; background-color: #006699}
td            {font-family: Arial, Helvetica, sans-serif; font-size: xx-small;}
form          {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
input         {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
select        {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
textarea	  {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
.menu 	  	  {font-family: Arial, Helvetica, sans-serif; font-size: xx-small; color: #FFFFFF; background-color: #006699}		
.menu2 	  	  {font-family: Arial, Helvetica, sans-serif; font-size: xx-small; color: #999999; background-color: #006699}		
.normal       {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}

-->
</style>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>GesTor F1 - TI</title>
</head>

<body>
<table width="80%" border="1" cellspacing="0" align="center">
  <tr> 
    <td width="20%"> <img src="images/imagen_ins.jpg"></td>
    <td colspan="4" width="80%"><img src="images/imagen.jpg"> </tr>
</table>
<br><br>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
		<tr align="center">
    <th colspan="12">ORDENES <?php 
	if($menu=="CLIENTE" || $menu=="TECNICO"){print "ENVIADAS POR ".$menu.": ";}
	elseif($menu=="ASIGNADO"){print $menu." A : ";}
	else{print $menu.": ";} 
	$sql="SELECT CONCAT(nom_usr, ' ', apa_usr, ' ', ama_usr) AS nombre FROM users WHERE login_usr='$nom' ORDER BY apa_usr";
	$rs=mysql_db_query($db,$sql,$link);
	$tmp=mysql_fetch_array($rs);
	echo $tmp[nombre]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo $nombre.": "; $i=0; while ($aux=mysql_fetch_array($count)) { $i++; } echo $i ?></th>
  </tr>
<tr>
          <td width="3%" class="menu" align="center">Nro</td>
		  <td width="3%" class="menu" align="center">ORIGEN</td>
          <td width="8%" class="menu" align="center">FECHA Y HORA</td>
          <td width="15%" class="menu" align="center">ENVIADO POR</td>
          <td width="2%" class="menu" align="center">TIPO</td>
	      <td width="25%" class="menu" align="center">DESCRIPCION DE LA INCIDENCIA</td>
  	      <td width="15%" class="menu" align="center">ASIGNACION</td>
		  <td width="8%" class="menu" align="center">AREA</td>
		  <td width="8%" class="menu" align="center">ENTIDAD</td>
   	      <td width="8%" class="menu" align="center">FECHA SOLUCION</td>
   	      <td width="7%" class="menu" align="center">IMPRIMIR</td>
		 </tr> 
		 <?php
		 while($datos=mysql_fetch_array($query))
		 {
		 ?>
		 <tr>
		 	<td align="center"><?php echo $datos['id_orden']; ?> </td>
			<td align="center"><?php if ($datos['id_anidacion']!="0") { echo $datos['id_anidacion']; } else { echo "<img src=images/eliminar.gif>"; }?> </td>
			<td align="center"><?php echo $datos['fecha']." ".$datos[time]; ?> </td>
			<?php
			$sql_user="SELECT nom_usr,apa_usr,ama_usr,tipo2_usr FROM users WHERE login_usr='$datos[cod_usr]'";
			$datos_usr=mysql_fetch_array(mysql_db_query($db,$sql_user,$link));
			?>
			<td align="center"><?php if(!empty($datos_usr['nom_usr'])) { echo $datos_usr['nom_usr']." ".$datos_usr['apa_usr']." ".$datos_usr['ama_usr']; } else { echo "SISTEMA"; }  ?> </td>
			<td align="center"><?php echo $datos_usr['tipo2_usr'];?></td>
			<td align="center"><?php echo $datos['desc_inc']; ?> </td>
			<?php
			$sql_aux = "SELECT id_orden, asig, fechaestsol_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion WHERE id_orden='$datos[id_orden]' ORDER BY id_asig DESC limit 1";
			$datos_aux=mysql_fetch_array(mysql_db_query($db,$sql_aux,$link));
			$sql_asig="SELECT nom_usr,apa_usr,ama_usr,area_usr,enti_usr FROM users WHERE login_usr='$datos_aux[asig]' ";
			$datos_asig=mysql_fetch_array(mysql_db_query($db,$sql_asig,$link));
			$sql_area="SELECT area_nombre FROM area WHERE area_cod='$datos_asig[area_usr]'";
			$fila_area=mysql_fetch_array(mysql_query($sql_area));
			
			?>
			<td align="center"><?php echo $datos_asig[nom_usr]." ".$datos_asig[apa_usr]." ".$datos_asig[ama_usr]; ?> </td>
			<td align="center"><?php echo $fila_area['area_nombre']; ?> </td>
			<td align="center"><?php echo $datos_asig[enti_usr]; ?> </td>
			<td align="center"><?php echo $datos_aux[fechaestsol_asig2]; ?> </td>
			<td align="center"><a href="ver_orden.php?id_orden=<?php echo $datos[id_orden]; ?>" target="_blank"><img src="images/imprimir.gif" border="0" alt="Imprimir"></a></td> 
		 </tr>
		 <?php
		 }
		 ?>				  
</table>
<div align="center">
<?php include("top_.php"); ?>
</div>
</body>
</html>

