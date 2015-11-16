<?php
// Version:		1.0
// Tipo:		Perfectivo, Correctivo;
// Objetivo:	Control acceso directo No autorizado.
//				Modificacion funciones php obsoletas para version 5.3
// Fecha:		22/NOV/2012 
//____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C')
		header('location:pagina_inicio.php');
}
else
	header('location:login.php');
	
require ("conexion.php");
	if (strlen($DA) == 1){ $DA = "0".$DA; }
	if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
    $fec1 = $AA."-".$MA."-".$DA;   
	if (strlen($DE) == 1){ $DE = "0".$DE; }
	if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fec2 = $AE."-".$ME."-".$DE; 

if ($menu != "GENERAL" ) { header("location: report_ordenesf2.php?menu=$menu&nombre=$nombre&fec1=$fec1&fec2=$fec2");
}?>
<html>
<head>
<title>ESTADÍSTICAS DE ORDENES DE TRABAJO</title>
</head>
<body topmargin="0">
<?php

//==========ORDENES DE TRABAJO==========================-
		$condicion = "fecha BETWEEN '$fec1' AND '$fec2' AND cod_usr<>'SISTEMA'";
		$sql9 = "SELECT id_orden FROM ordenes WHERE $condicion";
		$rs19 = mysql_query($sql9);
		$numAsig = 0;
		while ($tmp = mysql_fetch_array($rs19))  {			
				$total[$numAsig] = $tmp['id_orden'];
				$numAsig++;
		}

//NUMERO TOTAL DE ORDENES

	$sql = "SELECT COUNT(id_orden) AS numtot FROM ordenes WHERE $condicion";
	$row = mysql_fetch_array(mysql_query($sql));

//NUMERO DE ORDENES ASIGNADAS  

	$condicion2 = "fecha_asig BETWEEN '$fec1' AND '$fec2'";
	$sql1 = "SELECT DISTINCT(asignacion.id_orden), MAX(asignacion.id_asig) FROM ordenes, asignacion 
	WHERE ordenes.id_orden=asignacion.id_orden AND $condicion AND ordenes.cod_usr<>'SISTEMA' GROUP BY asignacion.id_orden";
	$row1['asig'] = mysql_num_rows(mysql_query($sql1));

//NUMERO DE ORDENES NO ASIGNADAS
	$noasig = $row['numtot']-$row1['asig'];

//NUMERO DE ORDENES ESCALADAS
	$sql1_1 = "SELECT DISTINCT(asignacion.id_orden), MAX(asignacion.id_asig) FROM ordenes, asignacion 
	WHERE ordenes.id_orden=asignacion.id_orden AND $condicion AND ordenes.cod_usr<>'SISTEMA' AND asignacion.escal<>'0'
	GROUP BY asignacion.id_orden";
	$row1_1['escal'] = mysql_num_rows(mysql_query($sql1_1));
	
	$row2['esc']=$row1_1['escal'];
	
//NUMERO DE ORDENES NO ESCALADAS
	$noesc=$row1['asig']-$row2['esc'];

	$totesc=$row2['esc']+$noesc;

//NUMERO DE ORDENES CON SEGUIMIENTO ++++++++++++++++++++++++   fecha_se////===============SEGUI
		$seg=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql="SELECT * FROM seguimiento WHERE id_orden='$total[$i]' ORDER BY id_seg DESC";
			$rsTmp0 = mysql_fetch_array(mysql_query($sql));
			if ($rsTmp0['id_orden']==$total[$i]) {
			$seg++;}
		}
		$row3['seg']=$seg;	

//MUMERO DE ORDENES SIN SEGUIMIENTO ++++++++++++++++++++++++

	$noseg=$row['numtot']-$row3['seg'];
	
	$totseg=$row3['seg']+$noseg;

//NUMERO DE ORDENES CON SOLUCION  fecha_sol
	$solu=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql4 = "SELECT id_orden FROM solucion WHERE id_orden='$total[$i]'";  //=============HERE VIC
		$row4 = mysql_fetch_array(mysql_query($sql4));
		if ($row4['id_orden']==$total[$i]) {
		$solu++;}
	}
	$row4['solu']=$solu;		
	
//NUMERO DE ORDENES SIN SOLUCION
	$nosolu=$row1['asig']-$row4['solu'];
	
	$totsol=$row4['solu']+$nosolu;

//NUMERO DE ORDNES CON CONFORMIDAD DEL CLIENTE fecha_conf
	$numConf=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
		$rsTmp3=mysql_fetch_array(mysql_query($sql));
		if ($rsTmp3['id_orden']==$total[$i]){
		$numConf++;}
	}
	$row5['conf']=$numConf;
	
		//NUMERO DE ORDENES ANIDADAS
		$anid = 0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql = "SELECT id_orden FROM ordenes WHERE id_orden='$total[$i]' AND  id_anidacion <>'0'";
			$rsTmp3=mysql_fetch_array(mysql_query($sql));
			if ($rsTmp3['id_orden']==$total[$i]){
			$anid++;}
		}
		$rowa['anid']=$anid;
		
		//NUMERO DE ORDENES NO ANIDADAS
		$noanid=$row5['conf']-$anid;	
		$totanid=$rowa['anid']+$noanid;
		
//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
$noconf=$row4['solu']-$row5['conf'];

$totconf=$row5['conf']+$noconf;

//NUMERO DE ORDNES CON disCONFORMIDAD DEL CLIENTE  DE LAS CULAES  EXISTE CONFOR.
	$nfd = 0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql = "SELECT * FROM conformidad WHERE id_orden='$total[$i]'";
		$rsTmp3f=mysql_fetch_array(mysql_query($sql));
		if ($rsTmp3f['id_orden']==$total[$i]){
			if ($rsTmp3f['tipo_conf'] == "2")
			{$nfd ++;}
		}
	}
	$disconformidad=$nfd;
	//echo "excho".$disconformidad;
//NUMERO DE ORDENES con CONFORMIDAD DEL CLIENTE real
	$conformidad = $row5['conf'] - $disconformidad;

//NUMERO DE ORDENES CON COSTO
		$numCost=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql = "SELECT DISTINCT(id_orden) FROM costo WHERE id_orden='$total[$i]'";
			$rsTmp4=mysql_fetch_array(mysql_query($sql));
			if ($rsTmp4['id_orden']==$total[$i]){
			$numCost++;}
		}
		$row6['cost']=$numCost;
//NUMERO DE ORDENES SIN COSTO
$nocost=$row['numtot']-$row6['cost'];

$totcos=$row6['cost']+$nocost;

//=============USUARIOS=================
//NUMERO DE ADMINISTRADORES
$sql7 = "SELECT count(tipo2_usr) AS adm FROM users WHERE tipo2_usr='A'";
$row7 = mysql_fetch_array(mysql_query($sql7));

//NUMERO DE CLIENTES
$sql8 = "SELECT count(tipo2_usr) AS cli FROM users WHERE tipo2_usr='C'";
$row8 = mysql_fetch_array(mysql_query($sql8));

//NUMERO DE TECNICOS
$sql9 = "SELECT count(tipo2_usr) AS tec FROM users WHERE tipo2_usr='T'";
$row9 = mysql_fetch_array(mysql_query($sql9));

//NUMERO TOTAL DE TECNICOS
$totuser=$row7['adm']+$row8['cli']+$row9['tec'];

//Complejidad, criticidad, prioridad
$rs=mysql_query($sql);
	$nivel["complejidad"][1]=0;
	$nivel["complejidad"][2]=0;
	$nivel["complejidad"][3]=0;
	
	$nivel["criticidad"][1]=0;
	$nivel["criticidad"][2]=0;
	$nivel["criticidad"][3]=0;
	
	$nivel["prioridad"][1]=0;
	$nivel["prioridad"][2]=0;
	$nivel["prioridad"][3]=0;
//$sql = "SELECT DISTINCT(id_orden) FROM asignacion WHERE $condicion2";

for ($i=0; $i<$numAsig; $i++){
	$sql="SELECT nivel_asig, criticidad_asig, prioridad_asig FROM asignacion WHERE id_orden='$total[$i]' ORDER BY id_asig DESC limit 1";
	$tmpNivel = mysql_fetch_array(mysql_query($sql));
	@$nivel["complejidad"][$tmpNivel["nivel_asig"]]++;
	@$nivel["criticidad"][$tmpNivel["criticidad_asig"]]++;
	@$nivel["prioridad"][$tmpNivel["prioridad_asig"]]++;
}
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
?>
<?php 
if ($totuser==0) $totuser=1;

if($row[0] > 0){$pasig=intval($row1['asig']*100/$row[0],10); $npasig=intval($noasig*100/$row[0],10);}
else{$pasig=0; $npasig=0;}

if($totesc > 0){$pesc=intval($row2['esc']*100/$totesc,10); $npesc=intval($noesc*100/$totesc,10);}
else{$pesc=0; $npesc=0;}

if($totseg > 0){$pseg=intval($row3['seg']*100/$row[0],10); $npseg=intval($noseg*100/$row[0],10);}
else{$pseg=0; $npseg=0;}

if($totanid > 0){$anid=intval($rowa['anid']*100/$totanid,10); $nanid=intval($noanid*100/$totanid,10);}
else{$anid=0; $nanid=0;}

/*$proc=intval($rowproc[anid]*100/$row[0],10); 
$nproc=intval($rownproc[anid]*100/$row[0],10);*/

if($totsol > 0){$psolu=intval($row4['solu']*100/$totsol,10); $npsolu=intval($nosolu*100/$totsol,10);}
else{$psolu=0; $npsolu=0;}

if($totconf > 0){$pconf=intval($row5['conf']*100/$totconf,10); $npconf=intval($noconf*100/$totconf,10);}
else{$pconf=0; $npconf=0;}

if($row5['conf'] > 0){$pconf_cf = intval($conformidad*100/$row5['conf'],10); $npconf_df = intval($disconformidad*100/$row5['conf'],10);}
else{$pconf_cf = 0; $npconf_df = 0;}

if($totcos > 0){$pcost=intval($row6['cost']*100/$totcos,10); $npcost=intval($nocost*100/$totcos,10);}
else{$pcost=0; $npcost=0;}

if($row[0] > 0){$ptoto=intval($row[0]*100/$row[0],10);}
else{$ptoto=0;}
?>

<?php 
$padm=$row7['adm']*100/$totuser;
$padm=intval ( $padm ,10);

$pcli=$row8['cli']*100/$totuser;
$pcli=intval ( $pcli ,10);

$ptec=$row9['tec']*100/$totuser;
$ptec=intval ( $ptec ,10);

$ptotu=$totuser*100/$totuser;
$ptotu=intval ( $ptotu ,10);

?> 
<table width="100%" border="1" align="center"  background="images/fondo.jpg">
  <tr> 
    <td> 
      <table border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr align="center"> 
          <th colspan="4"><font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php  
			print "Del: ".$DA."/".$MA."/".$AA."&nbsp;&nbsp;&nbsp;Al: ".$DE."/".$ME."/".$AE; ;  
			?>
            </font></th>
        </tr>
        <tr align="center"> 
          <th width="237" bgcolor="#006699"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">ORDENES 
            DE TRABAJO</font></th>
          <th width="97" bgcolor="#006699"><div align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">CANTIDAD</font></div></th>
          <th width="100" bgcolor="#006699"> <div align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">%</font></div></th>
          <th width="145" bgcolor="#006699"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Asignadas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('asignadas','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $row1['asig'];?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $pasig;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$pasig% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;No 
              Asignadas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('noasignadas','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $noasig;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $npasig;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$npasig% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Escaladas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('escaladas','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $row2['esc'];?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $pesc;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$pesc% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;No 
              Escaladas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('noescaladas','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $noesc;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $npesc;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$npesc% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Con 
              Seguimiento</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('conseguimiento','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $row3['seg'];?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $pseg;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$pseg% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Seguimiento</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('sinseguimiento','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $noseg;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $npseg;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$npseg% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Con 
              Solucion</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('consolucion','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $row4['solu'];?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $psolu;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$psolu% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Solucion</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('sinsolucion','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $nosolu;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $npsolu;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$npsolu% SRC=images/barra.jpg>";?></td>
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
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('conconformidad','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $row5['conf'];?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $pconf;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$pconf% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Conformidad</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('sinconformidad','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $noconf;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $npconf;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$npconf% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp; 
              </font></div></td>
          <td width="97"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              </font></div></td>
          <td nowrap width="145" >&nbsp;</td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp; 
              Conformidad</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('conforme','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $conformidad;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $pconf_cf;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$pconf_cf% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp; 
              Disconformidad</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('disconforme','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $disconformidad;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $npconf_df;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$npconf_df% SRC=images/barra.jpg>";?></td>
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
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('concosto','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $row6['cost'];?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $pcost;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$pcost% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Costo</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('sincosto','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $nocost;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $npcost;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$npcost% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10">&nbsp;</td>
          <td height="10">&nbsp;</td>
          <td height="10">&nbsp;</td>
          <td height="10"></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Anidadas</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('anidadas','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $rowa['anid'];?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $anid;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$anid% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin 
              Anidar</font></div></td>
          <td width="97"> <div align="center" style="cursor:hand" onClick="procesos('sinanidar','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $noanid;?></u></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $nanid;?> 
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$nanid% SRC=images/barra.jpg>";?></td>
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
          <td> <div align="center" style="cursor:hand" onClick="procesos('complejidadalta','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $nivel['complejidad'][3];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $nivel['complejidad'][6];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=".$nivel['complejidad'][6]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Complejidad 
              Media</font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('complejidadmedia','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $nivel['complejidad'][2];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $nivel['complejidad'][5];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=".$nivel['complejidad'][5]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Complejidad 
              Baja</font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('complejidadbaja','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $nivel['complejidad'][1];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $nivel['complejidad'][4];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=".$nivel['complejidad'][4]."% SRC=images/barra.jpg>";?></td>
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
          <td> <div align="center" style="cursor:hand" onClick="procesos('criticidadalta','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $nivel['criticidad'][1];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $nivel['criticidad'][4];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=".$nivel['criticidad'][4]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Criticidad 
              Media</font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('criticidadmedia','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $nivel['criticidad'][2];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $nivel['criticidad'][5];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=".$nivel['criticidad'][5]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Criticidad 
              Baja</font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('criticidadbaja','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $nivel['criticidad'][3]?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $nivel['criticidad'][6];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=".$nivel['criticidad'][6]."% SRC=images/barra.jpg>";?></td>
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
          <td> <div align="center" style="cursor:hand" onClick="procesos('prioridadalta','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $nivel['prioridad'][1];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $nivel['prioridad'][4];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=".$nivel['prioridad'][4]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Prioridad 
              Media</font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('prioridadmedia','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $nivel['prioridad'][2];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $nivel['prioridad'][5];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=".$nivel['prioridad'][5]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Prioridad 
              Baja </font></div></td>
          <td> <div align="center" style="cursor:hand" onClick="procesos('prioridadbaja','<?php echo @$nombre; ?>','<?php echo $menu; ?>','<?php echo $DA; ?>','<?php echo $MA; ?>','<?php echo $AA; ?>','<?php echo $DE; ?>','<?php echo $ME; ?>','<?php echo $AE; ?>')"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $nivel['prioridad'][3];?></u></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $nivel['prioridad'][6];?> 
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=".$nivel['prioridad'][6]."% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <th nowrap bgcolor="#CCCCCC"><font size="2" face="Arial, Helvetica, sans-serif">Nro 
            TOTAL DE ORDENES</font></th>
          <td bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['numtot'];?></font></strong></div></td>
          <td nowrap bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">100%</font></strong></div></td>
          <td nowrap bgcolor="#CCCCCC"><?php echo "<IMG HEIGHT=15 WIDTH=100% SRC=images/barra.jpg>";?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<div align="center">
  <strong><font size="1" face="Arial, Helvetica, sans-serif">NOTA : </font></strong><font size="1" face="Arial, Helvetica, sans-serif">En 
  algunos casos, la suma estadistica tiene un error de 1% por motivos de redondeo.</font></div>
  </body>
  </html>
<script language="JavaScript" type="text/JavaScript">
function procesos(tipo,nombre,menu,DA,MA,AA,DE,ME,AE)
{
	window.open("report_ordenesf_pro.php?tipo="+tipo+"&nom="+nombre+"&menu="+menu+"&DA="+DA+"&MA="+MA+"&AA="+AA+"&DE="+DE+"&ME="+ME+"&AE="+AE, "", 'width=900,height=500,status=no,resizable=yes,top=150,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=yes');
}
</script>