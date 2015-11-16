<?php
//Promedio
function datos($strQuery,$titulo){
include("../conexion.php");
   $strXML = "<chart caption='$titulo' labelDisplay='ROTATE' slantLabels='0' showBorder='1' formatNumberScale='0'>";
   $result = mysql_db_query($db,$strQuery,$link) or die(mysql_error());
   $prom=0;
   $flag=0;
   if ($result) {
      while($ors = mysql_fetch_array($result)) {
         $strXML .= "<set label='" . $ors['nom'] . "' value='" . $ors['num'] . "' />";
		 $prom+=$ors['num'];
		 $flag++;
      }
   }
   mysql_close($link);
   if($flag>0)$prom=round($prom/$flag,2); else $prom=0;
   $strXML .= "</chart>";
   return array($strXML, $prom);
}

//Porcentaje del total
function solo_datos($strQuery){
include("../conexion.php");
   $result = mysql_db_query($db,$strQuery,$link) or die(mysql_error());
   $prom=0;
   $flag=0;
   if ($result) {
      while($ors = mysql_fetch_array($result)) {
		 $prom+=$ors['num'];
		 $flag++;
      }
   }
   mysql_close($link);
   if($flag>0)$prom=round($prom/$flag,2); else $prom=0;
   return $prom;
}

function datos_link($strQuery,$titulo){
include("../conexion.php");
$porc=0;
   $strXML = "<chart caption='$titulo' labelDisplay='ROTATE' slantLabels='0' showBorder='1' formatNumberScale='0'>";
   $result = mysql_db_query($db,$strQuery,$link) or die(mysql_error());
   $prom=0;
   $flag=0;
   if ($result) {
      while($ors = mysql_fetch_array($result)) {
         $strXML .= "<set label='" . $ors['nom'] . "' value='" . $ors['num'] . "' link='".$ors['id']."'/>";
		 $prom+=$ors['num'];
		 $flag++;
		 if($flag=='1') $porc+=$ors['num'];
      }
   }
   mysql_close($link);
   if($flag>0) $prom=round($porc/$prom*100,2); else $prom=0;
   $strXML .= "</chart>";
   return array($strXML, $prom);
}
function datos_link2($strQuery){
include("../conexion.php");
$porc=0;
$result = mysql_db_query($db,$strQuery,$link) or die(mysql_error());
$prom=0;
$flag=0;
if ($result) {
	while($ors = mysql_fetch_array($result)) {
		$prom+=$ors['num'];
		$flag++;
		if($flag=='1') $porc+=$ors['num'];
	}
}
mysql_close($link);
if($flag>0) $prom=round($porc/$prom*100,2); else $prom=0;
return $prom;
}
?>