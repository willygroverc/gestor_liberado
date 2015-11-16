<?php
include ("../conexion.php");
require_once("../dompdf/dompdf_config.inc.php");
session_start();
$login_usr = $_SESSION["login"];

$html= '<html>
		<head>
		<title>ESTADISTICAS DE ORDENES DE TRABAJO</title>
		</head>
		<BODY topmargin="0">';

switch ($menu) {
	case "TECNICO":
		$condicion="users.login_usr='$login_usr'";
		break;
	case "CLIENTE":
		$condicion="users.login_usr='$nombre'";
		break;
	case "AREA":
		$condicion="users.area_usr='$nombre'";
		break;
	case "CIUDAD":
		$condicion="users.ciu_usr='$nombre'";
		break;
	case "ADICIONAL1":
	$sql0="SELECT * FROM datos_adicionales WHERE nombre_dadicional='$nombre'";
	$rs0=mysql_query($db,$sql0,$link);
	$row0=mysql_fetch_array($rs0);
	$id_dadicional=$row0[id_dadicional];
	$condicion="users.adicional1='$id_dadicional'";
	break;
}
//==========ORDENES DE TRABAJO==========================

$sql_tip="SELECT * FROM users WHERE login_usr='$nombre'";
$rs_tip=mysql_db_query($db,$sql_tip,$link);
$row_tip=mysql_fetch_array($rs_tip);
if($row_tip[tipo2_usr]=="A"){}
else{$condicion2="cod_usr<>'SISTEMA' AND";}

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
				$sql = "SELECT id_orden,cod_usr FROM ordenes WHERE $condicion2 id_orden='$row_as[id_orden]' ORDER BY id_orden DESC";
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
			if (($rsTmp2[id_orden]==$total[$i]) && ($rsTmp2[escal]<>'0')){$numEscal++;}
		}
		$row2[esc]=$numEscal;
		
		//NUMERO DE ORDENES NO ESCALADAS
		$noesc=$row[numtot]-$row2[esc];
		
		$totesc=$row2[esc]+$noesc;
		
		//NUMERO DE ORDENES CON SEGUIMIENTO ++++++++++++++++++++++++
		
		$seg=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql="SELECT * FROM seguimiento WHERE id_orden='$total[$i]' ORDER BY id_seg DESC";
			$rsTmp0 = mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp0[id_orden]==$total[$i]) {
			$seg++;}
		}
		$row3[seg]=$seg;	
		
		//MUMERO DE ORDENES SIN SEGUIMIENTO ++++++++++++++++++++++++
		$noseg=$row[numtot]-$row3[seg];
		
		$totseg=$row3[seg]+$noseg;
		
		//NUMERO DE ORDENES 

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
		$sql = "SELECT id_orden FROM ordenes,users WHERE ordenes.cod_usr=users.login_usr AND users.login_usr='$login_usr' AND ordenes.cod_usr<>'SISTEMA'";
		$rs1 = mysql_db_query($db,$sql,$link);
		$numAsig=0;
		while ($tmp=mysql_fetch_array($rs1))  {			
				$total[$numAsig]=$tmp[id_orden];
				$numAsig++;
		}
		$row[0]=$numAsig;
		$row[numtot]=$numAsig;
		
		//NUMERO DE ORDENES ASIGNADAS
		$ca = 0;
		for ($i = 0; $i < count($total); $i++)
		{	$sql1 = "SELECT MAX(id_asig) AS id_asig FROM asignacion WHERE id_orden='$total[$i]'";
			$res1 = mysql_db_query($db,$sql1,$link);
			$row1 = mysql_fetch_array($res1);
			if ($row1[id_asig]) 
			{	$ca ++;}
		}
		$row1[asig] = $ca;
		
		//NUMERO DE ORDENES NO ASIGNADAS
		$noasig=$row[numtot]-$row1[asig];
		
		//NUMERO DE ORDENES ESCALADAS
		$numEscal=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql="SELECT * FROM asignacion WHERE id_orden='$total[$i]' ORDER BY id_asig DESC";
			$rsTmp2 = mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if (($rsTmp2[id_orden]==$total[$i]) && ($rsTmp2[escal]<>'0')) {
			$numEscal++;}
		}
		$row2[esc]=$numEscal;	
		
		//NUMERO DE ORDENES NO ESCALADAS
		$noesc=$row1[asig]-$row2[esc];
		$totesc=$row2[esc]+$noesc;
		
		//NUMERO DE ORDENES CON SEGUIMIENTO ++++++++++++++++++++++++
		$seg=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql="SELECT * FROM seguimiento WHERE id_orden='$total[$i]' ORDER BY id_seg DESC";
			$rsTmp0 = mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp0[id_orden]==$total[$i]) {
			$seg++;}
		}
		$row3[seg]=$seg;	
		
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
		
		//NUMERO DE ORDNES CON CONFORMIDAD DEL CLIENTE
		$numConf=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
			$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp3[id_orden]){
			$numConf++;}
		}
		$row5[conf]=$numConf;
		
		//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
		$noconf=$row4[solu]-$row5[conf];
		
		$totconf=$row5[conf]+$noconf;
		
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
		
		//ORDENES CON CONFORMIDAD DE LAS CUALES  X ESTAN REALAMNETE CONFORMEs
		$nroconformidad = $row5[conf] - $nrodisconformidad;

		//NUMERO DE ORDENES CON COSTO
		$numCost=0;
		for ($i=0; $i<$numAsig; $i++) {
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
			$sql = "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_anidacion='$total[$i]'";
			$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp3[id_orden]){
			$anid++;}
		}
		$rowa[anid]=$anid;
	
		//NUMERO DE ORDENES NO ANIDADAS
		$noanid=$row5[conf]-$anid;
		
		$totanid=$rowa[anid]+$noanid;
		
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

$padm=$row7[adm]*100/$totuser;
$padm=intval ( $padm ,10);

$pcli=$row8[cli]*100/$totuser;
$pcli=intval ( $pcli ,10);

$ptec=$row9[tec]*100/$totuser;
$ptec=intval ( $ptec ,10);

$ptotu=$totuser*100/$totuser;
$ptotu=intval ( $ptotu ,10);


$html.='<table width="60%" border="1" align="center"  background="../images/fondo.jpg">
		<tr> 
			<td width="455"> 
			<table border="1" cellpadding="0" cellspacing="0" width="100%">
				<tr align="center"> 
				<th colspan="4"><font size="2" face="Arial, Helvetica, sans-serif">';
   	if($menu=="CLIENTE" || $menu=="TECNICO"){
		$file= "ENVIADAS POR ".$menu."_";
		$html.= "ENVIADAS POR ".$menu.": ";
		
	}
	elseif($menu=="ASIGNADO"){
		$file= $menu." A_";
		$html.= $menu." A : ";
	}
	else{
		$file=$menu.'_';
		$html.= $menu.": ";
	}
	if ($menu=="CLIENTE" || $menu=="TECNICO" || $menu=="ASIGNADO" ){	
		$sql="SELECT login_usr, CONCAT(nom_usr, ' ', apa_usr, ' ', ama_usr) AS nombre FROM users ORDER BY apa_usr";
		$rs=mysql_db_query($db,$sql,$link);
		while ($tmp=mysql_fetch_array($rs)) {
			$lstTecnico[$tmp[login_usr]]=$tmp[nombre];
		}
		$file.=$lstTecnico[$nombre];
		$html.=$lstTecnico[$nombre];
	}
	else {
		$file.=$nombre;
		$html.= $nombre;
	}
		
$html.= '</font></th>
        </tr>
        <tr align="center"> 
          <th width="237" bgcolor="#006699"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">ORDENES 
            DE TRABAJO</font></th>
          <th width="97" bgcolor="#006699"><div align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">CANTIDAD</font></div></th>
          <th width="100" bgcolor="#006699"><div align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">%</font></div></th>
          <th width="145" bgcolor="#006699"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
        </tr>';
        if ($menu!="ASIGNADO") { 
        $html.=' <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Asignadas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand">
		  <font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$row1[asig].'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$pasig.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$pasig.'% SRC=../images/barra.jpg> 
          </td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;No 
              Asignadas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$noasig.'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$npasig.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$npasig.'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>';
        }
        $html.=' <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Escaladas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$row2[esc].'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$pesc.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$pesc.'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;No 
              Escaladas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$noesc.'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$npesc.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$npesc.'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>';
        if ($menu!="ASIGNADO") {
        $html.='<tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Con 
              Seguimiento</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$row3[seg].'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$pseg.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$pseg.'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Seguimiento</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$noseg.'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$npseg.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$npseg.'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>';
        }
        $html.='<tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Con 
              Solucion</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$row4[solu].'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$psolu.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$psolu.'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Solucion</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$nosolu.'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$npsolu.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$npsolu.'% SRC=../images/barra.jpg></td>
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
          <td width="97"> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$row5[conf].'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$pconf.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$pconf.'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Conformidad</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$noconf.'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$npconf.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$npconf.'% SRC=../images/barra.jpg></td>
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
          <td height="10" width="97" align="center"><div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$nroconformidad.'</u></font></div></td>
          <td height="10" width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$pconfc.'%</font></td>
          <td height="10" width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$pconfc.'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Disconforme</font></td>
          <td height="10" width="97" align="center"><div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$nrodisconformidad.'</u></font></div></td>
          <td height="10" width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$npconfd.'%</font></td>
          <td height="10" width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$npconfd.'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Con Costo</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$row6[cost].'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$pcost.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$pcost.'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Costo</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$nocost.'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$npcost.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$npcost.'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td height="10">&nbsp;</td>
          <td height="10">&nbsp;</td>
          <td height="10">&nbsp;</td>
          <td height="10"></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Anidadas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$rowa[anid].'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$anid.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$anid.'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Anidar</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$noanid.'</u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$nanid.'%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$nanid.'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td height="10">&nbsp;</td>
          <td height="10">&nbsp;</td>
          <td height="10">&nbsp;</td>
          <td height="10"></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Complejidad Alta</font></div></td>
          <td> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$nivel[complejidad][3].'</u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$nivel[complejidad][6].'%</font></div></td>
          <td nowrap bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$nivel[complejidad][6].'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Complejidad Media</font></div></td>
          <td> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$nivel[complejidad][2].'</u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$nivel[complejidad][5].'%</font></div></td>
          <td nowrap bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$nivel[complejidad][5].'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Complejidad Baja </font></div></td>
          <td> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$nivel[complejidad][1].'</u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$nivel[complejidad][4].'%</font></div></td>
          <td nowrap bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$nivel[complejidad][4].'% SRC=../images/barra.jpg></td>
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
          <td> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$nivel[criticidad][1].'</u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$nivel[criticidad][4].'%</font></div></td>
          <td nowrap bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$nivel[criticidad][4].'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Criticidad Media</font></div></td>
          <td> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$nivel[criticidad][2].'</u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$nivel[criticidad][5].'%</font></div></td>
          <td nowrap bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$nivel[criticidad][5].'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Criticidad Baja</font></div></td>
          <td> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$nivel[criticidad][3].'</u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$nivel[criticidad][6].'%</font></div></td>
          <td nowrap bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$nivel[criticidad][6].'% SRC=../images/barra.jpg></td>
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
          <td> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$nivel[prioridad][1].'</u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$nivel[prioridad][4].'%</font></div></td>
          <td nowrap bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$nivel[prioridad][4].'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Prioridad Media</font></div></td>
          <td> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$nivel[prioridad][2].'</u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$nivel[prioridad][5].'%</font></div></td>
          <td nowrap bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$nivel[prioridad][5].'% SRC=../images/barra.jpg></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Prioridad Baja </font></div></td>
          <td> <div align="center" style="cursor:hand"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u>'.$nivel[prioridad][3].'</u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$nivel[prioridad][6].'%</font></div></td>
          <td nowrap bgcolor="#006699"><IMG HEIGHT=15 WIDTH='.$nivel[prioridad][6].'% SRC=../images/barra.jpg>"</td>
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
          <td width="97" bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row[numtot].'</font></strong></div></td>
          <td width="100" nowrap bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">100%</font></strong></div></td>
          <td nowrap width="145" bgcolor="#006699">';
        if ($row[0]>0) 
			$html.='<IMG HEIGHT=15 WIDTH=100% SRC=../images/barra.jpg>';
        $html.='</td>
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
</HTML>';
  $fecha=date('d-M-Y');
  $file.='_'.$fecha.'.pdf';
  $html=stripslashes($html);
  $old_limit = ini_set("memory_limit", "32M");
  $dompdf = new DOMPDF();
  $dompdf->load_html($html);
  $dompdf->set_paper("letter", "portrait");
  $dompdf->render();
  $dompdf->stream($file);
  //echo $html;
  exit(0);


?>