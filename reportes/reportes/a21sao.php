<?php
//$data="<chart caption='ORDENES DE TRABAJO' shownames='1' showvalues='1' decimals='0' numberPrefix='Dias '>";
////desde aqui

//NUMERO TOTAL DE ORDENES

$sql = "SELECT COUNT(id_orden) AS numtot FROM ordenes WHERE cod_usr<>'SISTEMA'";
$row = mysql_fetch_array(mysql_db_query($db,$sql,$link));
//==========ORDENES DE TRABAJO==========================-
	
$sql9 = "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA'";
$rs19 = mysql_db_query($db,$sql9,$link);
$numAsig = 0;
while ($tmp = mysql_fetch_array($rs19))  {			
	$total[$numAsig] = $tmp[id_orden];
	$numAsig++;
}
//NUMERO DE ORDNES CON CONFORMIDAD DEL CLIENTE 
$numConf=0;
for ($i=0; $i<$numAsig; $i++) {
	$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
	$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
	if ($rsTmp3[id_orden]==$total[$i]){
	$numConf++;}
}
$row5[conf]=$numConf;
//NUMERO DE ORDNES CON disCONFORMIDAD DEL CLIENTE  DE LAS CULAES  EXISTE CONFOR.
$nfd = 0;
for ($i=0; $i<$numAsig; $i++) {
	$sql = "SELECT * FROM conformidad WHERE id_orden='$total[$i]'";
	$rsTmp3f=mysql_fetch_array(mysql_db_query($db,$sql,$link));
	if ($rsTmp3f[id_orden]==$total[$i]){
		if ($rsTmp3f[tipo_conf] == "2")
		{$nfd ++;}
	}
}
$disconformidad=$nfd;

//NUMERO DE ORDENES con CONFORMIDAD DEL CLIENTE real
$conformidad = $row5[conf] - $disconformidad;

//ENVIO DE DATOS
$dat1 = $conformidad;
$dat2 = $disconformidad;
//hasta aqui
/*$data.="<set label='Conformidad' value='$dat1'/><set label='Disconformidad' value='$dat2'/>";
$data.="</chart>";*/
$prom=$dat2;
?>