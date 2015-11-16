<?php
//$data="<chart caption='ORDENES DE TRABAJO' shownames='1' showvalues='1' decimals='0' numberPrefix='Dias '>";
////desde aqui
//include("../../conexion.php");
//NUMERO TOTAL DE ORDENES

$sql = "SELECT COUNT(id_orden) AS numtot FROM ordenes WHERE cod_usr<>'SISTEMA'";
$row = mysql_fetch_array(mysql_db_query($db,$sql,$link));
//==========ORDENES DE TRABAJO==========================-

$sql9 = "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA'";
$rs19 = mysql_db_query($db,$sql9,$link);
$numConf=0;
$anid = 0;
$sql = "SELECT COUNT(*) AS num FROM conformidad c, ordenes o WHERE cod_usr<>'SISTEMA' AND c.id_orden=o.id_orden AND id_anidacion = '0'";
$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
$prom=$rsTmp3['num'];
?>