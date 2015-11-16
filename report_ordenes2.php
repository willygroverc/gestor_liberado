<?php
//OBJETIVO: Se modifico el archivo para mejorar los datos estadisticos para los usuarios de tipo tecnico
//FECHA: 08/OCT/2013
//AUTOR: Alvaro Rodriguez Gallardo
//VERSION: 1.0
?>
<html>
<head>
<title>ESTADISTICAS DE ORDENES DE TRABAJO</title>
</head>
<BODY topmargin="0">
<?php
include ("conexion.php");
switch ($menu) {
	case "TECNICO":
		$condicion="users.login_usr='$nombre'";
		break;
	case "CLIENTE":
		$condicion="users.login_usr='$nombre'";
		break;
	case "AREA":
	$sql_ar="SELECT area_cod FROM area where area_nombre LIKE '%$nombre%'";
	$result_ar=mysql_query($sql_ar);
	$fila_ar=mysql_fetch_array($result_ar); 
	$ubic=$fila_ar['area_cod'];
		$condicion="users.area_usr='$fila_ar[area_cod]'";
		break;
	case "CIUDAD":
		$condicion="users.ciu_usr='$nombre'";
		break;
	case "ADICIONAL1":
	$sql0="SELECT * FROM datos_adicionales WHERE nombre_dadicional='$nombre'";
	$rs0=mysql_db_query($db,$sql0,$link);
	$row0=mysql_fetch_array($rs0);
	$id_dadicional=$row0['id_dadicional'];
	$condicion="users.adicional1='$id_dadicional'";
	break;
}
//==========ORDENES DE TRABAJO==========================

	
	//NO ESCALADAS
	$sql_noes="SELECT count(distinct id_orden) AS num FROM asignacion  WHERE escal NOT IN (select login_usr from users) AND asig='$nombre'";
	$result_noes=mysql_query($sql_noes);
	$fila_noes=mysql_fetch_array($result_noes);
	
if ( $menu=="ASIGNADO" ) 
{	
		$condicion="users.login_usr='$nombre'";	
		//NUMERO TOTAL DE ORDENES
		$numAsig=0;
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion GROUP BY id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT asig, id_orden FROM asignacion WHERE id_asig=$rowbo[maxi]";
			$row_as=mysql_fetch_array(mysql_db_query($db,$sql_as,$link));
			if($row_as[asig]==$nombre)
			{
				$sql = "SELECT id_orden,cod_usr FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden='$row_as[id_orden]' ORDER BY id_orden DESC";
				$rsTmp=mysql_fetch_array(mysql_db_query($db,$sql,$link));
				if($rsTmp[id_orden])
				{
					$total[$numAsig]=$rsTmp[id_orden];
					$numAsig++;
				}
			}
			
		}
		$row[0]=$numAsig;
		$row[numtot]=$numAsig;
		//NUMERO DE ORDENES ESCALADAS
		
		$numEscal=0;
		for ($i=0; $i<$numAsig; $i++) 
		{
			$sql="SELECT * FROM asignacion WHERE id_orden='$total[$i]' ORDER BY id_asig DESC";
			$rsTmp2 = mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if (($rsTmp2['id_orden']==$total[$i]) && ($rsTmp2['escal']<>'0')){$numEscal++;}
		}
		$row2['esc']=$numEscal;
		//NUMERO DE ORDENES NO ESCALADAS
		$noesc=$row[numtot]-$row2[esc];
		
		$totesc=$row2[esc]+$noesc;
		
		//NUMERO DE ORDENES CON SEGUIMIENTO ++++++++++++++++++++++++
		
		
		$seg=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql="SELECT * FROM seguimiento WHERE id_orden='$total[$i]' ORDER BY id_seg DESC";
			$rsTmp0 = mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp0['id_orden']==$total[$i]) {
			$seg++;}
		}
		$row3['seg']=$seg;	
		$conseg=$fila_seg['num'];
		//MUMERO DE ORDENES SIN SEGUIMIENTO ++++++++++++++++++++++++
		$noseg=$row[numtot]-$row3[seg];
		
		$totseg=$row3[seg]+$noseg;
		
		//NUMERO DE ORDENES CON SOLUCION
		$solu=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql4="SELECT id_orden FROM solucion WHERE id_orden='$total[$i]'";
			$row4 = mysql_fetch_array(mysql_db_query($db,$sql4,$link));
			if ($row4[id_orden]==$total[$i]) {
			$solu++;}
		}
		$row4[solu]=$solu;
		
		//NUMERO DE ORDENES SIN SOLUCION
		$nosolu=$row[numtot]-$row4[solu];
		
		$totsol=$row4[solu]+$nosolu;
		
		//NUMERO DE ORDENES CON CONFORMIDAD DEL CLIENTE
		$numConf = 0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
			$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp3[id_orden]==$total[$i]){
			$numConf++;}
		}
		$row5[conf]=$numConf;
 		
		//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
		$noconf=$row4[solu]-$row5[conf];
		
		$totconf=$row5[conf]+$noconf;
		
		//HERE ORDENES CON CONFORMIDAD DE LAS CUALES Xs TENGAN DISCONFORMIDAD
		$nd2 = 0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql = "SELECT * FROM conformidad WHERE id_orden='$total[$i]'";
			$rsTmp31 = mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp31[id_orden]==$total[$i]){if ( $rsTmp31[tipo_conf] == "2")$nd2++;
			}
		}
		$nrodisconformidad = $nd2;
		
		//HERE ORDENES CON CONFORMIDAD DE LAS CUALES X ESTAN REALMAMENTE CONFORMES
		
		$nroconformidad = $row5[conf] - $nrodisconformidad;
		
		//NUMERO DE ORDENES CON COSTO
		$numCost=0;
		for ($i=0; $i<$numAsig; $i++) 
		{
			$sql = "SELECT DISTINCT(id_orden) FROM costo WHERE id_orden='$total[$i]'";
			$rsTmp4=mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp4[id_orden]==$total[$i]){
			$numCost++;}
		}
		$row6[cost]=$numCost;
 				
 		//NUMERO DE ORDENES SIN COSTO
		$nocost=$row[numtot]-$row6[cost];
		
		$totcos=$row6[cost]+$nocost;
		
		//NUMERO DE ORDENES ANIDADAS
		$anid = 0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql = "SELECT id_orden FROM ordenes WHERE id_anidacion='$total[$i]' AND  id_anidacion<>'0'";
			$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp3[id_orden]){
			$anid++;}
		}
		$rowa[anid]=$anid;
		
		//NUMERO DE ORDENES NO ANIDADAS
		
		$noanid=$row5[conf]-$anid;
		
		$totanid=$rowa[anid]+ $noanid;		

		//Complejidad, criticidad, prioridad
			$nivel["complejidad"][1]=0;
			$nivel["complejidad"][2]=0;
			$nivel["complejidad"][3]=0;
			
			$nivel["criticidad"][1]=0;
			$nivel["criticidad"][2]=0;
			$nivel["criticidad"][3]=0;
			
			$nivel["prioridad"][1]=0;
			$nivel["prioridad"][2]=0;
			$nivel["prioridad"][3]=0;
			
			$nv3 = 0;
			$nv2 = 0;
			$nv1 = 0;
			$nvc3 = 0;
			$nvc2 = 0;
			$nvc1 = 0;
			
			$nvp3 = 0;
			$nvp2 = 0;
			$nvp1 = 0;
			
		for ($i = 0; $i<count($total); $i++)
		{	$sql = "SELECT MAX(id_asig) as id_asig FROM asignacion WHERE id_orden='$total[$i]'";
			$rs  = mysql_db_query($db,$sql,$link);	
			$tmp = mysql_fetch_array($rs);
			if ($tmp)
			{	$sqlb = "SELECT * FROM asignacion WHERE id_asig='$tmp[id_asig]'";	
				$rsb = mysql_db_query($db,$sqlb,$link);
				$tmpNivel= mysql_fetch_array($rsb);
				if ($tmpNivel["nivel_asig"] == 3) $nv3 ++;
				if ($tmpNivel["nivel_asig"] == 2) $nv2 ++;
				if ($tmpNivel["nivel_asig"] == 1) $nv1 ++;
				
				if ($tmpNivel["criticidad_asig"] == 3) $nvc3 ++;
				if ($tmpNivel["criticidad_asig"] == 2) $nvc2 ++;
				if ($tmpNivel["criticidad_asig"] == 1) $nvc1 ++;
				
				if ($tmpNivel["prioridad_asig"] == 3) $nvp3 ++;
				if ($tmpNivel["prioridad_asig"] == 2) $nvp2 ++;
				if ($tmpNivel["prioridad_asig"] == 1) $nvp1 ++;
			
			}
		}
		$nivel["complejidad"][1] = $nv1;
		$nivel["complejidad"][2] = $nv2;
		$nivel["complejidad"][3] = $nv3;
		
		$nivel["criticidad"][1]= $nvc1;
		$nivel["criticidad"][2]= $nvc2;
		$nivel["criticidad"][3]= $nvc3;

		$nivel["prioridad"][1]= $nvp1;
		$nivel["prioridad"][2]= $nvp2;
		$nivel["prioridad"][3]= $nvp3;
}
else {
		//NUMERO TOTAL DE ORDENES
		$sql = "SELECT id_orden FROM ordenes,users WHERE ordenes.cod_usr=users.login_usr AND ordenes.cod_usr<>'SISTEMA' AND $condicion";
		$rs1 = mysql_query($sql);
		$numAsig=0;
		while ($tmp=mysql_fetch_array($rs1))  {			
				$total[$numAsig]=$tmp['id_orden'];
				$numAsig++;
		}
		$row[0]=$numAsig;
		$row['numtot']=$numAsig;
		
		//
		// ASIGNADO
	$sql_tec="SELECT count(DISTINCT o.id_orden) AS num FROM `ordenes` AS o, asignacion AS a WHERE o.id_orden = a.id_orden AND a.asig='$nombre'";
	$result_tec=mysql_query($sql_tec);
	$fila_asig=mysql_fetch_array($result_tec);
		$ca = 0;
		for ($i = 0; $i < count($total); $i++)
		{	$sql1 = "SELECT MAX(id_asig) AS id_asig FROM asignacion WHERE id_orden='$total[$i]'";
			$res1 = mysql_db_query($db,$sql1,$link);
			$row1 = mysql_fetch_array($res1);
			if ($row1['id_asig']) 
			{	$ca ++;}
		}
		$row1['asig'] = $ca;
		$fila_as=$fila_asig['num'];
		$sql_cli="SELECT count(DISTINCT o.id_orden) AS num FROM ordenes AS o, asignacion AS a WHERE o.id_orden = a.id_orden AND o.cod_usr='$nombre'";
		$result_cli=mysql_query($sql_cli);
		$fila_cli=mysql_fetch_array($result_cli);
		$cli_asig=$fila_cli['num'];
		if($menu=="AREA") {
			$sql_areasig="SELECT count(DISTINCT o.id_orden) AS num FROM ordenes AS o, asignacion AS a WHERE o.id_orden = a.id_orden AND o.area='$ubic'";
			$result_areasig=mysql_query($sql_areasig);
			$fila_areasig=mysql_fetch_array($result_areasig);
			$areasig=$fila_areasig['num'];
		}
		
		//NUMERO DE ORDENES NO ASIGNADAS
		//NO ASIGNADO
		$sql_noas="SELECT count(distinct id_orden) AS num FROM ordenes WHERE id_orden NOT IN (select id_orden from asignacion) AND cod_usr='$nombre'";
		$result_noas=mysql_query($sql_noas);
		$fila_noas=mysql_fetch_array($result_noas);
		$noasig=$row['numtot']-$row1['asig'];
		$fila_noasi=$fila_noas['num'];
		if($menu=="AREA") {
			$sql_areanoas="SELECT count(distinct id_orden) AS num FROM ordenes WHERE id_orden NOT IN (select id_orden from asignacion) AND area='$ubic'";
			$result_areanoas=mysql_query($sql_areanoas);
			$fila_areanoas=mysql_fetch_array($result_areanoas);
			$fila_areanoasi=$fila_areanoas['num'];
		}
		//NUMERO DE ORDENES ESCALADAS
		//ESCALADAS
		$sql_es="SELECT count(distinct a.id_orden) AS num FROM `asignacion` AS a, users AS u WHERE u.login_usr=a.escal AND a.asig='$nombre'";
		$result_es=mysql_query($sql_es);
		$fila_es=mysql_fetch_array($result_es);
		$numEscal=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql="SELECT * FROM asignacion WHERE id_orden='$total[$i]' ORDER BY id_asig DESC";
			$rsTmp2 = mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if (($rsTmp2['id_orden']==$total[$i]) && ($rsTmp2['escal']<>'0')) {
			$numEscal++;}
		}
		$row2['esc']=$numEscal;	
		$fila_esc=$fila_es['num'];
		
		$sql_escli="SELECT count(distinct a.id_orden) AS num FROM `asignacion` AS a, ordenes As o, users AS u WHERE u.login_usr=a.escal AND o.cod_usr='$nombre' AND a.id_orden=o.id_orden";
		$result_escli=mysql_query($sql_escli);
		$fila_escli=mysql_fetch_array($result_escli);
		$escli=$fila_escli['num'];
		if($menu=="AREA") {
			$sql_areaesc="SELECT count(distinct a.id_orden) AS num FROM `asignacion` AS a, ordenes As o, users AS u WHERE u.login_usr=a.escal AND o.area='$ubic' AND a.id_orden=o.id_orden";
			$result_areaesc=mysql_query($sql_areaesc);
			$fila_areaesc=mysql_fetch_array($result_areaesc);
			$areaesc=$fila_areaesc['num'];
		}
		//NUMERO DE ORDENES NO ESCALADAS
		$sql_noes="SELECT count(distinct id_orden) AS num FROM `asignacion`  WHERE escal NOT IN (select login_usr from users) AND asig='$nombre'";
		$result_noes=mysql_query($sql_noes);
		$fila_noes=mysql_fetch_array($result_noes);
		$noesc=$row1['asig']-$row2['esc'];
		$noescala=$fila_noes['num'];
		$totesc=$row2['esc']+$noesc;
		
		$sql_noescli="SELECT count(distinct a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.escal NOT IN (select login_usr from users) AND o.id_orden=a.id_orden AND o.cod_usr='$nombre'";
		$result_noescli=mysql_query($sql_noescli);
		$fila_noescli=mysql_fetch_array($result_noescli);
		$noescli=$fila_noescli['num'];
		if($menu=="AREA") {
			$sql_areanoesc="SELECT count(distinct a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.escal NOT IN (select login_usr from users) AND o.id_orden=a.id_orden AND o.area='$ubic'";
			$result_areanoesc=mysql_query($sql_areanoesc);
			$fila_areanoesc=mysql_fetch_array($result_areanoesc);
			$areanoesc=$fila_areanoesc['num'];
		}
		//NUMERO DE ORDENES CON SEGUIMIENTO ++++++++++++++++++++++++
		$sql_conseg="SELECT count( DISTINCT a.id_orden ) AS num FROM asignacion AS a, seguimiento AS s WHERE a.id_orden = s.id_orden AND a.asig='$nombre'";
		$result_seg=mysql_query($sql_conseg);
		$fila_seg=mysql_fetch_array($result_seg);
		$seg=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql="SELECT * FROM seguimiento WHERE id_orden='$total[$i]' ORDER BY id_seg DESC";
			$rsTmp0 = mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp0['id_orden']==$total[$i]) {
			$seg++;}
		}
		$row3['seg']=$seg;	
		$conseg=$fila_seg['num'];
		
		$sql_consegcli="SELECT count( DISTINCT o.id_orden ) AS num FROM `ordenes` AS o, seguimiento AS s WHERE o.id_orden = s.id_orden AND o.cod_usr='$nombre'";
		$result_segcli=mysql_query($sql_consegcli);
		$fila_segcli=mysql_fetch_array($result_segcli);
		$consegcli=$fila_segcli['num'];
		
		if($menu=="AREA") {
			$sql_areaseg="SELECT count( DISTINCT o.id_orden ) AS num FROM `ordenes` AS o, seguimiento AS s WHERE o.id_orden = s.id_orden AND o.area='$ubic'";
			$result_areaseg=mysql_query($sql_areaseg);
			$fila_areaseg=mysql_fetch_array($result_areaseg);
			$areaseg=$fila_areaseg['num'];
		}
		//MUMERO DE ORDENES SIN SEGUIMIENTO ++++++++++++++++++++++++
		$sql_sinseg="select count(DISTINCT a.id_orden) AS num FROM asignacion AS a, seguimiento AS s WHERE a.asig='$nombre' AND a.id_orden NOT IN (select id_orden FROM seguimiento)";
		$resul_sinseg=mysql_query($sql_sinseg);
		$fila_nos=mysql_fetch_array($resul_sinseg);
		$noseg=$row['numtot']-$row3['seg'];
		$no_seg=$fila_nos['num'];
		$totseg=$row3['seg']+$noseg;
		
		$sql_sinsegcli="SELECT count( DISTINCT o.id_orden ) AS num FROM `ordenes` AS o WHERE o.id_orden NOT IN (SELECT id_orden FROM seguimiento) AND o.cod_usr='$nombre'";
		$resul_sinsegcli=mysql_query($sql_sinsegcli);
		$fila_noscli=mysql_fetch_array($resul_sinsegcli);
		$nosegcli=$fila_noscli['num'];
		
		if($menu=="AREA") {
			$sql_areanoseg="SELECT count( DISTINCT o.id_orden ) AS num FROM `ordenes` AS o WHERE o.id_orden NOT IN (SELECT id_orden FROM seguimiento) AND o.area='$ubic'";
			$result_areanoseg=mysql_query($sql_areanoseg);
			$fila_areanoseg=mysql_fetch_array($result_areanoseg);
			$areanoseg=$fila_areanoseg['num'];
		}
		//NUMERO DE ORDENES CON SOLUCION
		$sql_tecsol="SELECT count( DISTINCT o.id_orden ) AS num FROM `ordenes` AS o, solucion AS s WHERE o.id_orden = s.id_orden AND s.login_sol='$nombre'";
		$result_tecsol=mysql_query($sql_tecsol);
		$fila_tecsol=mysql_fetch_array($result_tecsol);
		$solu=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql4="SELECT id_orden FROM solucion WHERE id_orden='$total[$i]'";
			$row4 = mysql_fetch_array(mysql_db_query($db,$sql4,$link));
			if ($row4['id_orden']==$total[$i]) {
			$solu++;}
		}
		$row4['solu']=$solu;	
		$tecsol=$fila_tecsol['num'];
		
		$sql_clicsol="SELECT count( DISTINCT o.id_orden ) AS num FROM `ordenes` AS o, solucion AS s WHERE o.id_orden = s.id_orden AND o.cod_usr='$nombre'";
		$result_clisol=mysql_query($sql_clicsol);
		$fila_clisol=mysql_fetch_array($result_clisol);
		$clisol=$fila_clisol['num'];
		
		if($menu=="AREA") {
			$sql_areasol="SELECT count( DISTINCT o.id_orden ) AS num FROM `ordenes` AS o, solucion AS s WHERE o.id_orden = s.id_orden AND o.area='$ubic'";
			$result_areasol=mysql_query($sql_areasol);
			$fila_areasol=mysql_fetch_array($result_areasol);
			$areasol=$fila_areasol['num'];
		}
		//NUMERO DE ORDENES SIN SOLUCION
		$sql_sinsol="SELECT count(distinct a.id_orden) AS num FROM asignacion AS a WHERE a.asig='$nombre' AND a.id_orden NOT IN (SELECT id_orden FROM solucion)";
		$result_sinsol=mysql_query($sql_sinsol);
		$fila_sinsol=mysql_fetch_array($result_sinsol);
		$sinsoltec=$fila_sinsol['num'];
		$nosolu=$row['numtot']-$row4['solu'];
		
		$totsol=$row4['solu']+$nosolu;
		
		if($menu=="AREA") {
			$sql_areasinsol="SELECT count(distinct id_orden) AS num FROM `ordenes` WHERE id_orden NOT IN (select id_orden from solucion) AND area='$ubic'";
			$result_areasinsol=mysql_query($sql_areasinsol);
			$fila_areasinsol=mysql_fetch_array($result_areasinsol);
			$areasinsol=$fila_areasinsol['num'];
		}
		//NUMERO DE ORDNES CON CONFORMIDAD DEL CLIENTE
		$sql_conconf="SELECT count( DISTINCT o.id_orden ) AS num FROM ordenes AS o, conformidad AS c, solucion AS s WHERE o.id_orden = c.id_orden AND s.login_sol='$nombre' AND c.id_orden=s.id_orden";
		$result_conconf=mysql_query($sql_conconf);
		$fila_conconf=mysql_fetch_array($result_conconf);
		$conconf=$fila_conconf['num'];
		$numConf=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
			$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp3['id_orden']){
			$numConf++;}
		}
		$row5['conf']=$numConf;
		if($menu=="AREA") {
			$sql_areaconf="SELECT count( DISTINCT o.id_orden ) AS num FROM ordenes AS o, conformidad AS c WHERE o.id_orden = c.id_orden AND o.area='$ubic'";
			$result_areaconf=mysql_query($sql_areaconf);
			$fila_areaconf=mysql_fetch_array($result_areaconf);
			$areaconf=$fila_areaconf['num'];
		}
		//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
		$sql_sinconf="SELECT count(distinct id_orden) AS num FROM `solucion` WHERE id_orden NOT IN (select id_orden from conformidad) AND login_sol='$nombre'";
		$result_sinconf=mysql_query($sql_sinconf);
		$fila_sinconf=mysql_fetch_array($result_sinconf);
		$sincof=$fila_sinconf['num'];
		$noconf=$row4['solu']-$row5['conf'];
		$totconf=$row5['conf']+$noconf;
		
		if($menu=="AREA") {
			$sql_areanoconf="SELECT count(distinct s.id_orden) AS num FROM solucion AS s, ordenes AS o WHERE s.id_orden NOT IN (select id_orden from conformidad) AND s.id_orden=o.id_orden AND o.area='$ubic'";
			$result_areanoconf=mysql_query($sql_areanoconf);
			$fila_areanoconf=mysql_fetch_array($result_areanoconf);
			$areanoconf=$fila_areanoconf['num'];
		}
		//ORDENES CON CONFORMIDAD DE LAS CUALES  X ESTAN REALAMEnTE DISCONFORMEs
		$nd = 0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql = "SELECT * FROM conformidad WHERE id_orden='$total[$i]'";
			$rsTmp32 = mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp32[id_orden] == $total[$i])
			{	if ( $rsTmp32[tipo_conf] == "2") $nd++;
			}
		}		
		$nrodisconformidad = $nd;
		
		if($menu=="AREA") {
			$sql_areaconf2="SELECT count( DISTINCT c.id_orden ) AS num FROM conformidad AS c, ordenes AS o WHERE c.tipo_conf = '2' AND c.id_orden=o.id_orden AND o.area='$ubic'";
			$result_areaconf2=mysql_query($sql_areaconf2);
			$fila_areaconf2=mysql_fetch_array($result_areaconf2);
			$areaconf2=$fila_areaconf2['num'];
		}
		
		//ORDENES CON CONFORMIDAD DE LAS CUALES  X ESTAN REALAMNETE CONFORMEs
		$sql_conf1="SELECT count( DISTINCT c.id_orden ) AS num FROM solucion AS s, conformidad AS c WHERE s.login_sol='$nombre' AND c.id_orden=s.id_orden AND c.tipo_conf='1'";
		$result_conf1=mysql_query($sql_conf1);
		$fila_conf1=mysql_fetch_array($result_conf1);
		$num_conf1=$fila_conf1['num'];
		$nroconformidad = $row5['conf'] - $nrodisconformidad;
		
		if($menu=="AREA") {
			$sql_areaconf1="SELECT count( DISTINCT c.id_orden ) AS num FROM conformidad AS c, ordenes AS o WHERE c.tipo_conf = '1' AND c.id_orden=o.id_orden AND o.area='$ubic'";
			$result_areaconf1=mysql_query($sql_areaconf1);
			$fila_areaconf1=mysql_fetch_array($result_areaconf1);
			$areaconf1=$fila_areaconf1['num'];
		}
		//NUMERO DE ORDENES CON DISCONFORMIDAD
		$sql_conf2="SELECT count( DISTINCT c.id_orden ) AS num FROM solucion AS s, conformidad AS c WHERE s.login_sol='$nombre' AND c.id_orden=s.id_orden AND c.tipo_conf='2'";
		$result_conf2=mysql_query($sql_conf2);
		$fila_conf2=mysql_fetch_array($result_conf2);
		$num_disconf=$fila_conf2['num'];
		//NUMERO DE ORDENES CON COSTO
		$sql_concosto="SELECT count(c.id_orden) AS num from costo AS c, ordenes AS o, asignacion AS a WHERE o.id_orden=c.id_orden AND a.id_orden='$nombre' AND a.id_orden=c.id_orden";
		$result_conconsto=mysql_query($sql_concosto);
		$fila_costo=mysql_fetch_array($result_conconsto);
		$concosto=$fila_costo['num'];
		$numCost=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql = "SELECT DISTINCT(id_orden) FROM costo WHERE id_orden='$total[$i]'";
			$rsTmp4=mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp4[id_orden]==$total[$i]){
			$numCost++;}
		}
		$row6['cost']=$numCost;
		if($menu=="AREA") {
			$sql_areacost="SELECT count(c.id_orden) AS num from costo AS c, ordenes AS o WHERE o.id_orden=c.id_orden AND o.area='$ubic'";
			$result_areacost=mysql_query($sql_areacost);
			$fila_areacost=mysql_fetch_array($result_areacost);
			$areacost=$fila_areacost['num'];
		}
		//NUMERO DE ORDENES SIN COSTO
		$sql_sincosto="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a WHERE a.asig='$nombre' AND a.id_orden NOT IN (SELECT id_orden FROM costo)";
		$result_sincosto=mysql_query($sql_sincosto);
		$fila_sincosto=mysql_fetch_array($result_sincosto);
		$numsincos=$fila_sincosto['num'];
		$nocost=$row['numtot']-$row6['cost'];
		$totcos=$row6['cost']+$nocost;
		
		if($menu=="AREA") {
			$sql_areacosts="SELECT count(DISTINCT id_orden) AS num FROM ordenes WHERE id_orden NOT IN (SELECT id_orden FROM costo) AND area='$ubic'";
			$result_areacosts=mysql_query($sql_areacosts);
			$fila_areacosts=mysql_fetch_array($result_areacosts);
			$areacosts=$fila_areacosts['num'];
		}
		//NUMERO DE ORDENES ANIDADAS
		$sql_anitec="SELECT count(distinct o.id_orden) AS num FROM ordenes o, asignacion a WHERE o.id_anidacion <> '0' AND a.asig='$nombre' AND o.id_orden=a.id_orden";
		$result_anitec=mysql_query($sql_anitec);
		$fila_anitec=mysql_fetch_array($result_anitec);
		$numanitec=$fila_anitec['num'];
		$anid = 0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql = "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_anidacion='$total[$i]'";
			$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp3['id_orden']){
			$anid++;}
		}
		$rowa['anid']=$anid;
		
		if($menu=="AREA") {
			$sql_areani="SELECT count(distinct o.id_orden) AS num FROM ordenes o WHERE o.id_anidacion <> '0' AND o.area='$ubic'";
			$result_areani=mysql_query($sql_areani);
			$fila_areani=mysql_fetch_array($result_areani);
			$areani=$fila_areani['num'];
		}
		//NUMERO DE ORDENES NO ANIDADAS
		$sql_noani="SELECT count(distinct o.id_orden) AS num FROM ordenes o, asignacion a WHERE o.id_anidacion = '0' AND a.asig='$nombre' AND o.id_orden=a.id_orden";
		$result_noani=mysql_query($sql_noani);
		$fila_noani=mysql_fetch_array($result_noani);
		$fila_noanid=$fila_noani['num'];
		$noanid=$row5['conf']-$anid;
		$totanid=$rowa['anid']+$noanid;
		
		$sql_noanicli="SELECT count(distinct o.id_orden) AS num FROM ordenes o WHERE o.id_anidacion = '0' AND o.cod_usr='$nombre'";
		$result_noanicli=mysql_query($sql_noanicli);
		$fila_noanicli=mysql_fetch_array($result_noanicli);
		$noanicli=$fila_noanicli['num'];
		
		if($menu=="AREA") {
			$sql_noaniarea="SELECT count(distinct o.id_orden) AS num FROM ordenes o WHERE o.id_anidacion = '0' AND o.area='$ubic'";
			$result_noaniarea=mysql_query($sql_noaniarea);
			$fila_noaniarea=mysql_fetch_array($result_noaniarea);
			$noaniarea=$fila_noaniarea['num'];
		}
		//Complejidad, criticidad, prioridad
		//COMPLEJIDAD ALTA
		$sql_comp_tec="SELECT COUNT(DISTINCT a.id_orden) AS num FROM asignacion AS a WHERE a.nivel_asig='3' AND a.asig='$nombre'";
		$result_comp_tec=mysql_query($sql_comp_tec);
		$fila_comp_tec=mysql_fetch_array($result_comp_tec);
		$num_com_tec=$fila_comp_tec['num'];
		
		$sql_comp_cli="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.nivel_asig='1' AND o.id_orden=a.id_orden AND o.cod_usr='$nombre'";
		$result_comp_cli=mysql_query($sql_comp_cli);
		$fila_comp_cli=mysql_fetch_array($result_comp_cli);
		$comcli3=$fila_comp_cli['num'];
		
		if($menu=="AREA") {
			$sql_comp_area1="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.nivel_asig='3' AND o.id_orden=a.id_orden AND o.area='$ubic'";
			$result_comp_area1=mysql_query($sql_comp_area1);
			$fila_comp_area1=mysql_fetch_array($result_comp_area1);
			$comarea1=$fila_comp_area1['num'];
		}
		//COMPLEJIDAD MEDIA
		$sql_comp_tec2="SELECT COUNT(DISTINCT a.id_orden) AS num FROM asignacion AS a WHERE a.nivel_asig='2' AND asig='$nombre'";
		$result_comp_tec2=mysql_query($sql_comp_tec2);
		$fila_comp_tec2=mysql_fetch_array($result_comp_tec2);
		$num_com_tec2=$fila_comp_tec2['num'];
		
		$sql_comp_cli2="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.nivel_asig='2' AND o.id_orden=a.id_orden AND o.cod_usr='$nombre'";
		$result_comp_cli2=mysql_query($sql_comp_cli2);
		$fila_comp_cli2=mysql_fetch_array($result_comp_cli2);
		$comcli2=$fila_comp_cli2['num'];
		
		if($menu=="AREA") {
			$sql_comp_area2="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.nivel_asig='2' AND o.id_orden=a.id_orden AND o.area='$ubic'";
			$result_comp_area2=mysql_query($sql_comp_area2);
			$fila_comp_area2=mysql_fetch_array($result_comp_area2);
			$comarea2=$fila_comp_area2['num'];
		}
		//COMPLEJIDAD BAJA
		$sql_comp_tec1="SELECT COUNT(DISTINCT a.id_orden) AS num FROM asignacion AS a WHERE a.nivel_asig='1' AND asig='$nombre'";
		$result_comp_tec1=mysql_query($sql_comp_tec1);
		$fila_comp_tec1=mysql_fetch_array($result_comp_tec1);
		$num_com_tec1=$fila_comp_tec1['num'];
		
		$sql_comp_cli3="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.nivel_asig='3' AND o.id_orden=a.id_orden AND o.cod_usr='$nombre'";
		$result_comp_cli3=mysql_query($sql_comp_cli3);
		$fila_comp_cli3=mysql_fetch_array($result_comp_cli3);
		$comcli1=$fila_comp_cli3['num'];
		
		if($menu=="AREA") {
			$sql_comp_area3="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.nivel_asig='1' AND o.id_orden=a.id_orden AND o.area='$ubic'";
			$result_comp_area3=mysql_query($sql_comp_area3);
			$fila_comp_area3=mysql_fetch_array($result_comp_area3);
			$comarea3=$fila_comp_area3['num'];
		}
		//CRITICIDAD ALTA
		$sql_crit_tec1="SELECT COUNT(DISTINCT a.id_orden) AS num FROM asignacion AS a WHERE a.criticidad_asig='3' AND asig='$nombre'";
		$result_crit_tec1=mysql_query($sql_crit_tec1);
		$fila_crit_tec1=mysql_fetch_array($result_crit_tec1);
		$num_crit_tec1=$fila_crit_tec1['num'];
		
		$sql_crit_cli1="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.criticidad_asig='3' AND o.id_orden=a.id_orden AND o.cod_usr='$nombre'";
		$result_crit_cri1=mysql_query($sql_crit_cli1);
		$fila_crit_cri1=mysql_fetch_array($result_crit_cri1);
		$cricli1=$fila_crit_cri1['num'];
		
		if($menu=="AREA") {
			$sql_crit_area1="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.criticidad_asig='1' AND o.id_orden=a.id_orden AND o.area='$ubic'";
			$result_crit_area1=mysql_query($sql_crit_area1);
			$fila_crit_area1=mysql_fetch_array($result_crit_area1);
			$critarea1=$fila_crit_area1['num'];
		}
		//CRITICIDAD MEDIA
		$sql_crit_tec2="SELECT COUNT(DISTINCT a.id_orden) AS num FROM asignacion AS a WHERE a.criticidad_asig='2' AND asig='$nombre'";
		$result_crit_tec2=mysql_query($sql_crit_tec2);
		$fila_crit_tec2=mysql_fetch_array($result_crit_tec2);
		$num_crit_tec2=$fila_crit_tec2['num'];
		
		$sql_crit_cli2="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.criticidad_asig='2' AND o.id_orden=a.id_orden AND o.cod_usr='$nombre'";
		$result_crit_cri2=mysql_query($sql_crit_cli2);
		$fila_crit_cri2=mysql_fetch_array($result_crit_cri2);
		$cricli2=$fila_crit_cri2['num'];
		
		if($menu=="AREA") {
			$sql_crit_area2="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.criticidad_asig='2' AND o.id_orden=a.id_orden AND o.area='$ubic'";
			$result_crit_area2=mysql_query($sql_crit_area2);
			$fila_crit_area2=mysql_fetch_array($result_crit_area2);
			$critarea2=$fila_crit_area2['num'];
		}
		//CRITICIDAD BAJA
		$sql_crit_tec3="SELECT COUNT(DISTINCT a.id_orden) AS num FROM asignacion AS a WHERE a.criticidad_asig='1' AND asig='$nombre'";
		$result_crit_tec3=mysql_query($sql_crit_tec3);
		$fila_crit_tec3=mysql_fetch_array($result_crit_tec3);
		$num_crit_tec3=$fila_crit_tec3['num'];
		
		$sql_crit_cli3="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.criticidad_asig='1' AND o.id_orden=a.id_orden AND o.cod_usr='$nombre'";
		$result_crit_cri3=mysql_query($sql_crit_cli3);
		$fila_crit_cri3=mysql_fetch_array($result_crit_cri3);
		$cricli3=$fila_crit_cri3['num'];
		
		if($menu=="AREA") {
			$sql_crit_area3="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.criticidad_asig='3' AND o.id_orden=a.id_orden AND o.area='$ubic'";
			$result_crit_area3=mysql_query($sql_crit_area3);
			$fila_crit_area3=mysql_fetch_array($result_crit_area3);
			$critarea3=$fila_crit_area3['num'];
		}
		//PRIORIDAD ALTA
		$sql_pri_tec1="SELECT COUNT(DISTINCT a.id_orden) AS num FROM asignacion AS a WHERE a.prioridad_asig='3' AND asig='$nombre'";
		$result_pri_tec1=mysql_query($sql_pri_tec1);
		$fila_pri_tec1=mysql_fetch_array($result_pri_tec1);
		$num_pri_tec1=$fila_pri_tec1['num'];
		
		$sql_pri_pri3="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.prioridad_asig='3' AND o.id_orden=a.id_orden AND o.cod_usr='$nombre'";
		$result_pri_pri3=mysql_query($sql_pri_pri3);
		$fila_pri_pri3=mysql_fetch_array($result_pri_pri3);
		$num_pri_pri3=$fila_pri_pri3['num'];
		
		if($menu=="AREA") {
			$sql_pri_area1="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.prioridad_asig='1' AND o.id_orden=a.id_orden AND o.area='$ubic'";
			$result_pri_area1=mysql_query($sql_pri_area1);
			$fila_pri_area1=mysql_fetch_array($result_pri_area1);
			$pritarea1=$fila_pri_area1['num'];
		}
		//PRIORIDAD MEDIA
		$sql_pri_tec2="SELECT COUNT(DISTINCT a.id_orden) AS num FROM asignacion AS a WHERE a.prioridad_asig='2' AND asig='$nombre'";
		$result_pri_tec2=mysql_query($sql_pri_tec2);
		$fila_pri_tec2=mysql_fetch_array($result_pri_tec2);
		$num_pri_tec2=$fila_pri_tec2['num'];
		
		$sql_pri_pri2="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.prioridad_asig='2' AND o.id_orden=a.id_orden AND o.cod_usr='$nombre'";
		$result_pri_pri2=mysql_query($sql_pri_pri2);
		$fila_pri_pri2=mysql_fetch_array($result_pri_pri2);
		$num_pri_pri2=$fila_pri_pri2['num'];
		
		if($menu=="AREA") {
			$sql_pri_area2="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.prioridad_asig='2' AND o.id_orden=a.id_orden AND o.area='$ubic'";
			$result_pri_area2=mysql_query($sql_pri_area2);
			$fila_pri_area2=mysql_fetch_array($result_pri_area2);
			$pritarea2=$fila_pri_area2['num'];
		}
		//PRIORIDAD BAJA
		$sql_pri_tec3="SELECT COUNT(DISTINCT a.id_orden) AS num FROM asignacion AS a WHERE a.prioridad_asig='1' AND asig='$nombre'";
		$result_pri_tec3=mysql_query($sql_pri_tec3);
		$fila_pri_tec3=mysql_fetch_array($result_pri_tec3);
		$num_pri_tec3=$fila_pri_tec3['num'];
		
		$sql_pri_pri1="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.prioridad_asig='1' AND o.id_orden=a.id_orden AND o.cod_usr='$nombre'";
		$result_pri_pri1=mysql_query($sql_pri_pri1);
		$fila_pri_pri1=mysql_fetch_array($result_pri_pri1);
		$num_pri_pri1=$fila_pri_pri1['num'];
		
		if($menu=="AREA") {
			$sql_pri_area3="SELECT count(DISTINCT a.id_orden) AS num FROM asignacion AS a, ordenes AS o WHERE a.prioridad_asig='3' AND o.id_orden=a.id_orden AND o.area='$ubic'";
			$result_pri_area3=mysql_query($sql_pri_area3);
			$fila_pri_area3=mysql_fetch_array($result_pri_area3);
			$pritarea3=$fila_pri_area3['num'];
		}
			$nivel["complejidad"][1]=0;
			$nivel["complejidad"][2]=0;
			$nivel["complejidad"][3]=0;
			
			$nivel["criticidad"][1]=0;
			$nivel["criticidad"][2]=0;
			$nivel["criticidad"][3]=0;
			
			$nivel["prioridad"][1]=0;
			$nivel["prioridad"][2]=0;
			$nivel["prioridad"][3]=0;
			
			$nv3 = 0;
			$nv2 = 0;
			$nv1 = 0;
			$nvc3 = 0;
			$nvc2 = 0;
			$nvc1 = 0;
			
			$nvp3 = 0;
			$nvp2 = 0;
			$nvp1 = 0;
			
		for ($i = 0; $i<count($total); $i++)
		{	$sql = "SELECT MAX(id_asig) as id_asig FROM asignacion WHERE id_orden='$total[$i]'";
			$rs  = mysql_db_query($db,$sql,$link);	
			$tmp = mysql_fetch_array($rs);
			if ($tmp)
			{	$sqlb = "SELECT * FROM asignacion WHERE id_asig='$tmp[id_asig]'";	
				$rsb = mysql_db_query($db,$sqlb,$link);
				$tmpNivel= mysql_fetch_array($rsb);
				if ($tmpNivel["nivel_asig"] == 3) $nv3 ++;
				if ($tmpNivel["nivel_asig"] == 2) $nv2 ++;
				if ($tmpNivel["nivel_asig"] == 1) $nv1 ++;
				
				if ($tmpNivel["criticidad_asig"] == 3) $nvc3 ++;
				if ($tmpNivel["criticidad_asig"] == 2) $nvc2 ++;
				if ($tmpNivel["criticidad_asig"] == 1) $nvc1 ++;
				
				if ($tmpNivel["prioridad_asig"] == 3) $nvp3 ++;
				if ($tmpNivel["prioridad_asig"] == 2) $nvp2 ++;
				if ($tmpNivel["prioridad_asig"] == 1) $nvp1 ++;
			
			}
		}
		$nivel["complejidad"][1] = $nv1;
		$nivel["complejidad"][2] = $nv2;
		$nivel["complejidad"][3] = $nv3;
		
		$nivel["criticidad"][1]= $nvc1;
		$nivel["criticidad"][2]= $nvc2;
		$nivel["criticidad"][3]= $nvc3;

		$nivel["prioridad"][1]= $nvp1;
		$nivel["prioridad"][2]= $nvp2;
		$nivel["prioridad"][3]= $nvp3;	
	}
//niveles
		$nivel["total"]=$nivel["complejidad"][1]+$nivel["complejidad"][2]+$nivel["complejidad"][3];
		//array con indice 4.5.6 => porcentaje
		if ($nivel["total"]>0) {
			$nivel["complejidad"][4]=round($nivel["complejidad"][1]*100/$nivel["total"]);
			$nivel["complejidad"][5]=round($nivel["complejidad"][2]*100/$nivel["total"]);
			$nivel["complejidad"][6]=round($nivel["complejidad"][3]*100/$nivel["total"]);
			
			$nivel["criticidad"][4]=round($nivel["criticidad"][1]*100/$nivel["total"]);
			$nivel["criticidad"][5]=round($nivel["criticidad"][2]*100/$nivel["total"]);
			$nivel["criticidad"][6]=round($nivel["criticidad"][3]*100/$nivel["total"]);
			
			$nivel["prioridad"][4]=round($nivel["prioridad"][1]*100/$nivel["total"]);
			$nivel["prioridad"][5]=round($nivel["prioridad"][2]*100/$nivel["total"]);
			$nivel["prioridad"][6]=round($nivel["prioridad"][3]*100/$nivel["total"]);
		}
		else {
			$nivel["complejidad"][4]=0;
			$nivel["complejidad"][5]=0;
			$nivel["complejidad"][6]=0;
			
			$nivel["criticidad"][4]=0;
			$nivel["criticidad"][5]=0;
			$nivel["criticidad"][6]=0;
			
			$nivel["prioridad"][4]=0;
			$nivel["prioridad"][5]=0;
			$nivel["prioridad"][6]=0;
		}
		//print_r ($nivel);
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
?>
<?php 
if($row[0] > 0){$pasig=intval($row1[asig]*100/$row[0],10); $npasig=intval($noasig*100/$row[0],10);}
else{$pasig=0; $npasig=0;}

if($totesc > 0){$pesc=intval($row2[esc]*100/$totesc,10); $npesc=intval($noesc*100/$totesc,10);}
else{$pesc=0; $npesc=0;}
	
if($totseg > 0){$pseg=intval($row3[seg]*100/$totseg,10); $npseg=intval($noseg*100/$totseg,10);}
else{$pseg=0; $npseg=0;}
	
if($totsol > 0){$psolu=intval($row4[solu]*100/$totsol,10); $npsolu=intval($nosolu*100/$totsol,10);}
else{$psolu=0; $npsolu=0;}
	
if($totconf > 0){$pconf=intval($row5[conf]*100/$totconf,10); $npconf=intval($noconf*100/$totconf,10);}
else{$pconf=0; $npconf=0;}
	
if($row5[conf] > 0){$pconfc = intval($nroconformidad*100/$row5[conf],10); $npconfd = intval($nrodisconformidad*100/$row5[conf],10);}
else{$pconfc=0; $npconfd=0;}	
		
if($totcos > 0){$pcost=intval($row6[cost]*100/$totcos,10); $npcost=intval($nocost*100/$totcos,10);}
else{$pcost=0; $npcost=0;}
	
if($totanid > 0){$anid=intval($rowa[anid]*100/$totanid,10); $nanid=intval($noanid*100/$totanid,10);}
else{$anid=0; $nanid=0;}

if($row[0] > 0){$ptoto=intval($row[0]*100/$row[0],10);}
else{$ptoto=0;}
?>
<?php 
$padm=$row7[adm]*100/$totuser;
$padm=intval ( $padm ,10);

$pcli=$row8[cli]*100/$totuser;
$pcli=intval ( $pcli ,10);

$ptec=$row9[tec]*100/$totuser;
$ptec=intval ( $ptec ,10);

$ptotu=$totuser*100/$totuser;
$ptotu=intval ( $ptotu ,10);

?> 
<table width="60%" border="1" align="center"  background="images/fondo.jpg">
  <tr> 
    <td width="455"> 
      <table border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr align="center"> 
          <th colspan="4"><font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php 	if($menu=="CLIENTE" || $menu=="TECNICO"){print "ENVIADAS POR ".$menu.": ";}
				elseif($menu=="ASIGNADO"){print $menu." A : ";}
				else{print $menu.": ";}
		  		if ($menu=="CLIENTE" || $menu=="TECNICO" || $menu=="ASIGNADO" ){	
					$sql="SELECT login_usr, CONCAT(nom_usr, ' ', apa_usr, ' ', ama_usr) AS nombre FROM users ORDER BY apa_usr";
					$rs=mysql_db_query($db,$sql,$link);
					while ($tmp=mysql_fetch_array($rs)) {
					$lstTecnico[$tmp[login_usr]]=$tmp[nombre];
					}
					print $lstTecnico[$nombre];
				}
		  		else print $nombre;?> </font></th>
				
        </tr>
        <tr align="center"> 
          <th width="237" bgcolor="#006699"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">ORDENES 
            DE TRABAJO</font></th>
          <th width="97" bgcolor="#006699"><div align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">CANTIDAD</font></div></th>
          <th width="100" bgcolor="#006699"><div align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">%</font></div></th>
          <th width="145" bgcolor="#006699"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
        </tr>
        <?php if ($menu!="ASIGNADO") { ?>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Asignadas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('asignadas','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO')  echo $fila_as; elseif($menu=='CLIENTE') echo $cli_asig; elseif($menu=='AREA') echo $areasig; else echo $row1['asig'];?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_asig= $fila_as+$fila_noasi; $tec_asi=($fila_as*100/$total_asig); /*echo round($tec_asi);*/ } if($menu=='AREA') { $total_asig_area= $areasig+$fila_areanoasi; $tec_asi_area=($areasig*100/$total_asig_area); echo round($tec_asi_area); } else echo $pasig;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"> <?php if($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$tec_asi_area% SRC=images/barra.jpg>"; elseif($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_asi% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$pasig% SRC=images/barra.jpg>"; ?> 
          </td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;No 
              Asignadas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('noasignadas','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $fila_noasi; elseif($menu=='AREA') echo $fila_areanoasi; else echo $noasig;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_asig= $fila_as+$fila_noasi; $tec_noasi=($fila_noasi*100/$total_asig); echo round($tec_noasi); } elseif($menu=='AREA') {  $tec_noasi_area=($fila_areanoasi*100/$total_asig_area); echo round($tec_noasi_area); } else echo $npasig;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_noasi% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$tec_noasi_area% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$npasig% SRC=images/barra.jpg>"; ?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <?php } ?>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Escaladas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('escaladas','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $fila_esc; elseif($menu=='CLIENTE') echo $escli; elseif($menu=='AREA') echo $areaesc; else echo $row2['esc'];?></u></font></div></td>
          
		  <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_esc= $fila_esc+$noescala; $tec_asi_esc=($fila_esc*100/$total_esc); echo round($tec_asi_esc); } elseif($menu=='AREA') { $total_esc_area= $areaesc+$areanoesc; $tec_asi_esc_area=($areaesc*100/$total_esc_area); echo round($tec_asi_esc_area); } else echo $pesc;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_asi_esc% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$tec_asi_esc_area% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$pesc% SRC=images/barra.jpg>"; ?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;No 
              Escaladas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('noescaladas','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $noescala; elseif($menu=='CLIENTE') echo $noescli; elseif($menu=='AREA') echo $areanoesc; else echo $noesc;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $tec_asi_ne=($noescala*100/$total_esc); echo round($tec_asi_ne); } elseif($menu=='AREA') { $tec_asi_esc_area=($areanoesc*100/$total_esc_area); echo round($tec_asi_esc_area); } else echo $npesc;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_asi_ne% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$npesc% SRC=images/barra.jpg>"; if($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$tec_asi_esc_area% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <?php if ($menu!="ASIGNADO") { ?>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Con 
              Seguimiento</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('conseguimiento','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $conseg; elseif($menu=='CLIENTE') echo $consegcli; elseif($menu=='AREA') echo $areaseg; else echo $row3['seg'];?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_seg=$conseg+$no_seg; $tec_seg=($conseg*100/$total_seg); echo round($tec_seg); } elseif($menu=='AREA') { $total_esc_seg= $areaseg+$areanoseg; $tec_asi_seg_area=($areaesc*100/$total_esc_seg); echo round($tec_asi_seg_area); } else echo $pseg;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_seg% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$tec_asi_seg_area% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$pseg% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Seguimiento</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('sinseguimiento','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $no_seg; elseif($menu=='CLIENTE') echo $nosegcli; elseif($menu=='AREA') echo $areanoseg; else echo $noseg;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_seg=$conseg+$no_seg; $tec_seg_n=($no_seg*100/$total_seg); echo round($tec_seg_n); } elseif($menu=='AREA') { $area_no_seg=($areanoseg*100/$total_esc_seg); echo round($area_no_seg); } else echo $npseg;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_seg_n% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$area_no_seg% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$npseg% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <?php } ?>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Con 
              Solucion</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('consolucion','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $tecsol; elseif($menu=='CLIENTE') echo $clisol; elseif($menu=='AREA') echo $areasol; else echo $row4['solu'];?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_sol=$tecsol+$sinsoltec; $tec_sol=($tecsol*100/$total_sol); echo round($tec_sol); } elseif($menu=='AREA') { $total_sol_area=$areasol+$areasinsol; $tec_sol_area=($areasol*100/$total_sol_area); echo round($tec_sol_area); } else echo $psolu;?> 
              %</font></div></td>
			  
          <td nowrap width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_sol% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$tec_sol_area% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$psolu% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Solucion</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('sinsolucion','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $sinsoltec; elseif($menu=='AREA') echo $areasinsol; else echo $nosolu;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_sol=$tecsol+$sinsoltec; $tec_s_sol=($sinsoltec*100/$total_sol); echo round($tec_s_sol); } elseif($menu=='AREA') { $solnoarea=($areasinsol*100/$total_sol_area); echo round($solnoarea); } else echo $npsolu;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_s_sol% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$solnoarea% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$npsolu% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Con 
              Conformidad</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('conconformidad','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $conconf; elseif($menu=='AREA') echo $areaconf; else echo $row5['conf'];?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_conf=$conconf+$sincof; $tec_conf=($conconf*100/$total_conf); echo round($tec_conf); } elseif($menu=='AREA') { $total_conf_area=$areaconf+$areanoconf; $tec_conf_area=($areaconf*100/$total_conf_area); echo round($tec_conf_area); } else echo $pconf;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_conf% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$tec_conf_area% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$pconf% SRC=images/barra.jpg>";?></td>
        </tr>
		
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Conformidad</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('sinconformidad','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $sincof; elseif($menu=='AREA') echo $areanoconf; else echo $noconf;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $tec_conf_sin=($sincof*100/$total_conf); echo round($tec_conf_sin); } elseif($menu=='AREA') { $tec_conf_area=($areanoconf*100/$total_conf_area); echo round($tec_conf_area); } else echo $npconf;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_conf_sin% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$tec_conf_area% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$npconf% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
            </font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Conforme 
            </font></td>
          <td height="10" width="97" align="center"><div align="center" style="cursor:hand" onClick="procesos('conforme','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $num_conf1; elseif($menu=='AREA') echo $areaconf1; else echo $nroconformidad; ?></u></font></div></td>
          <td height="10" width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_calif=$num_conf1+$num_disconf; $tec_calif1=($num_conf1*100/$total_calif); echo round($tec_calif1); } elseif($menu=='AREA') { $total_areaconf1=$areaconf1+$areaconf2; $calif1_area=($areaconf1*100/$total_areaconf1); echo round($calif1_area); } else echo $pconfc; ?>%</font></td>
          <td height="10" width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_calif1% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$calif1_area% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$pconfc% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Disconforme</font></td>
          <td height="10" width="97" align="center"><div align="center" style="cursor:hand" onClick="procesos('disconforme','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $num_disconf; elseif($menu=='AREA') echo $areaconf2; else echo $nrodisconformidad; ?></u></font></div></td>
          <td height="10" width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $tec_calif2=($num_disconf*100/$total_calif); echo round($tec_calif2); } elseif($menu=='AREA') { $calif2_area=($areaconf2*100/$total_areaconf1); echo round($calif2_area); } else echo $npconfd;?>%</font></td>
          <td height="10" width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_calif2% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$calif2_area% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$npconfd% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Con 
              Costo</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('concosto','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $concosto;  elseif($menu=='AREA') echo $areacost; else echo $row6['cost'];?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_cc=$concosto+$numsincos; $tec_cc=($concosto*100/$total_cc); echo round($tec_cc); } elseif($menu=='AREA') { $total_cc_area=$areacost+$areacosts; $cc_area=($areacost*100/$total_cc_area); echo round($cc_area); } else echo $pcost;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_cc% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$cc_area% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$pcost% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Costo</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('sincosto','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $numsincos; elseif($menu=='AREA') echo $areacosts; else echo $nocost;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $tec_sc=($numsincos*100/$total_cc); echo round($tec_sc); } elseif($menu=='AREA') { $cc_area=($areacosts*100/$total_cc_area); echo round($cc_area); } else echo $npcost;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_sc% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$cc_area% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$npcost% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10">&nbsp;</td>
          <td height="10">&nbsp;</td>
          <td height="10">&nbsp;</td>
          <td height="10"></td>
        </tr>
		
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Anidadas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('anidadas','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $numanitec; elseif($menu=='AREA') echo $areani; else echo $rowa['anid'];?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_cani=$numanitec+$fila_noanid; $tec_cani=($numanitec*100/$total_cani); echo round($tec_cani); } elseif($menu=='AREA') { $total_aniarea=$areani+$noaniarea; $ani_area1=($numanitec*100/$total_aniarea); echo round($ani_area1); } else echo $anid;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_cani% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$ani_area1% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$anid% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Anidar</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('sinanidar','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $fila_noanid; elseif($menu=='CLIENTE') echo $noanicli; elseif($menu=='AREA') echo $noaniarea; else echo $noanid;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $tec_sani=($fila_noanid*100/$total_cani); echo round($tec_sani); } elseif($menu=='AREA') { $ani_area2=($noaniarea*100/$total_aniarea); echo round($ani_area2); } else echo $nanid;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_sani% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$ani_area2% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=$nanid% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10">&nbsp;</td>
          <td height="10">&nbsp;</td>
          <td height="10">&nbsp;</td>
          <td height="10"></td>
        </tr>
		
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Complejidad 
              Alta</font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('complejidadalta','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $num_com_tec; elseif($menu=='CLIENTE') echo $comcli3; elseif($menu=='AREA') echo $comarea1; else echo $nivel['complejidad'][3];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_comp=$num_com_tec+$num_com_tec2+$num_com_tec1; $tec_comp1=($numanitec*100/$total_comp); echo round($tec_comp1); } elseif($menu=='AREA') { $total_areacomp=$comarea1+$comarea2+$comarea3; $tec_comparea1=($comarea1*100/$total_areacomp); echo round($tec_comparea1); } else echo $nivel['complejidad'][6];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_comp1% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$tec_comparea1% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=".$nivel[complejidad][6]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Complejidad 
              Media</font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('complejidadmedia','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $num_com_tec2; elseif($menu=='CLIENTE') echo $comcli2; elseif($menu=='AREA') echo $comarea2; else echo $nivel['complejidad'][2];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $tec_comp2=($num_com_tec2*100/$total_comp); echo round($tec_comp2); } elseif($menu=='AREA') { $tec_comparea2=($comarea2*100/$total_areacomp); echo round($tec_comparea2); } else echo $nivel[complejidad][5];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_comp2% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$tec_comparea2% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=".$nivel[complejidad][5]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Complejidad 
              Baja </font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('complejidadbaja','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $num_com_tec1; elseif($menu=='CLIENTE') echo $comcli1; elseif($menu=='AREA') echo $comarea3; else echo $nivel['complejidad'][1];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $tec_comp3=($num_com_tec1*100/$total_comp); echo round($tec_comp3); } elseif($menu=='AREA') { $cpmarea3=($comarea3*100/$total_areacomp); echo round($cpmarea3); } else echo $nivel[complejidad][4];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_comp3% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$cpmarea3% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=".$nivel[complejidad][4]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td height="10" nowrap>&nbsp;</td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Criticidad 
              Alta</font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('criticidadalta','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $num_crit_tec1; elseif($menu=='CLIENTE') echo $cricli1; elseif($menu=='AREA') echo $critarea1; else echo $nivel['criticidad'][1];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_cri=$num_crit_tec1+$num_crit_tec2+$num_crit_tec3; $tec_cri1=($num_crit_tec1*100/$total_cri); echo round($tec_cri1); } elseif($menu=='AREA') { $total_cri_area=$critarea1+$critarea2+$critarea3; $area_cri1=($critarea1*100/$total_cri_area); echo round($area_cri1); } else echo $nivel[criticidad][4];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_cri1% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$area_cri1% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=".$nivel[criticidad][4]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Criticidad 
              Media</font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('criticidadmedia','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $num_crit_tec2; elseif($menu=='CLIENTE') echo $cricli2; elseif($menu=='AREA') echo $critarea2; else echo $nivel['criticidad'][2];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $tec_cri2=($num_crit_tec2*100/$total_cri); echo round($tec_cri2); } elseif($menu=='AREA') {  $area_cri2=($critarea2*100/$total_cri_area); echo round($area_cri2); } else echo $nivel[criticidad][5];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_cri2% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$area_cri2% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=".$nivel[criticidad][5]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Criticidad 
              Baja</font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('criticidadbaja','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $num_crit_tec3; elseif($menu=='CLIENTE') echo $cricli3; elseif($menu=='AREA') echo $critarea3; else echo $nivel['criticidad'][3]?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $tec_cri3=($num_crit_tec3*100/$total_cri); echo round($tec_cri3); } elseif($menu=='AREA') {  $area_cri3=($critarea3*100/$total_cri_area); echo round($area_cri3); } else echo $nivel[criticidad][6];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_cri3% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$area_cri3% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=".$nivel[criticidad][6]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10"></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Prioridad 
              Alta</font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('prioridadalta','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $num_pri_tec1; elseif($menu=='CLIENTE') echo $num_pri_pri3; elseif($menu=='AREA') echo $pritarea1; else echo $nivel[prioridad][1];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $total_pri=$num_pri_tec1+$num_pri_tec2+$num_pri_tec3; $tec_pri1=($num_crit_tec1*100/$total_pri); echo round($tec_pri1); } elseif($menu=='AREA') { $total_pri_area=$pritarea1+$pritarea2+$pritarea3; $pri_area1=($pritarea1*100/$total_pri_area); echo round($pri_area1); } else echo $nivel[prioridad][4];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_pri1% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$pri_area1% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=".$nivel[prioridad][4]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Prioridad 
              Media</font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('prioridadmedia','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $num_pri_tec2; elseif($menu=='CLIENTE') echo $num_pri_pri2; elseif($menu=='AREA') echo $pritarea2; else echo $nivel[prioridad][2];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $tec_pri2=($num_pri_tec2*100/$total_pri); echo round($tec_pri2); } elseif($menu=='AREA') { $pri_area2=($pritarea2*100/$total_pri_area); echo round($pri_area2); } else echo $nivel[prioridad][5];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_pri2% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$pri_area2% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=".$nivel[prioridad][5]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Prioridad 
              Baja </font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('prioridadbaja','<?php echo $nombre; ?>','<?php echo $menu; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php if($menu=='TECNICO') echo $num_pri_tec3; elseif($menu=='CLIENTE') echo $num_pri_pri1; elseif($menu=='AREA') echo $pritarea3; else echo $nivel[prioridad][3];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php if($menu=='TECNICO') { $tec_pri3=($num_pri_tec3*100/$total_pri); echo round($tec_pri3); } elseif($menu=='AREA') { $pri_area3=($pritarea3*100/$total_pri_area); echo round($pri_area3); } else echo $nivel[prioridad][6];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php if($menu=='TECNICO') echo "<IMG HEIGHT=15 WIDTH=$tec_pri3% SRC=images/barra.jpg>"; elseif($menu=='AREA') echo "<IMG HEIGHT=15 WIDTH=$pri_area3% SRC=images/barra.jpg>"; else echo "<IMG HEIGHT=15 WIDTH=".$nivel[prioridad][6]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <th width="237" nowrap bgcolor="#CCCCCC"><font size="2" face="Arial, Helvetica, sans-serif">Nro 
            TOTAL DE ORDENES</font></th>
          <td width="97" bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row[numtot];?></font></strong></div></td>
          <td width="100" nowrap bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">100%</font></strong></div></td>
          <td nowrap width="145" bgcolor="#006699"> 
            <?php if ($row[0]>0) echo "<IMG HEIGHT=15 WIDTH=100% SRC=images/barra.jpg>";?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<div align="center">
  <strong><font size="1" face="Arial, Helvetica, sans-serif">NOTA : </font></strong><font size="1" face="Arial, Helvetica, sans-serif">En 
  algunos casos, la suma estadistica puede presentar un error de 1% por motivos 
  de redondeo.</font></div>
</BODY>
</HTML>
 <script language="JavaScript" type="text/JavaScript">
function procesos(tipo,nombre,menu)
{
	window.open("report_ordenes2_pro.php?tipo="+tipo+"&nom="+nombre+"&menu="+menu, "", 'width=900,height=500,status=no,resizable=yes,top=150,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=yes');
}
</script>