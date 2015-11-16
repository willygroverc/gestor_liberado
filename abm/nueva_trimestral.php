<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
	
	$FechaProceso=SanitizeString($FechaProceso);
	$Actividad=SanitizeString($Actividad);
	$Observaciones=SanitizeString($Observaciones);
	$Hora1=SanitizeString($Hora1);
	$Min1=SanitizeString($Min1);
	$Hora2=SanitizeString($Hora2);
	$Min2=SanitizeString($Min2);
	$Mes=SanitizeString($Mes);
	$Dia=SanitizeString($Dia);
	$lista=SanitizeString($lista);
	if($Hora1=='1') $Hora1="0".$Hora1;
	if($Hora1=='2') $Hora1="0".$Hora1;
	if($Hora1=='3') $Hora1="0".$Hora1;
	if($Hora1=='4') $Hora1="0".$Hora1;
	if($Hora1=='5') $Hora1="0".$Hora1;
	if($Hora1=='6') $Hora1="0".$Hora1;
	if($Hora1=='7') $Hora1="0".$Hora1;
	if($Hora1=='8') $Hora1="0".$Hora1;
	if($Hora1=='9') $Hora1="0".$Hora1;
	
	if($Hora2=='1') $Hora2="0".$Hora2;
	if($Hora2=='2') $Hora2="0".$Hora2;
	if($Hora2=='3') $Hora2="0".$Hora2;
	if($Hora2=='4') $Hora2="0".$Hora2;
	if($Hora2=='5') $Hora2="0".$Hora2;
	if($Hora2=='6') $Hora2="0".$Hora2;
	if($Hora2=='7') $Hora2="0".$Hora2;
	if($Hora2=='8') $Hora2="0".$Hora2;
	if($Hora2=='9') $Hora2="0".$Hora2;
	
	if($Min1=='1') $Min1="0".$Min1;
	if($Min1=='2') $Min1="0".$Min1;
	if($Min1=='3') $Min1="0".$Min1;
	if($Min1=='4') $Min1="0".$Min1;
	if($Min1=='5') $Min1="0".$Min1;
	if($Min1=='6') $Min1="0".$Min1;
	if($Min1=='7') $Min1="0".$Min1;
	if($Min1=='8') $Min1="0".$Min1;
	if($Min1=='9') $Min1="0".$Min1;
	
	if($Min2=='1') $Min2="0".$Min2;
	if($Min2=='2') $Min2="0".$Min2;
	if($Min2=='3') $Min2="0".$Min2;
	if($Min2=='4') $Min2="0".$Min2;
	if($Min2=='5') $Min2="0".$Min2;
	if($Min2=='6') $Min2="0".$Min2;
	if($Min2=='7') $Min2="0".$Min2;
	if($Min2=='8') $Min2="0".$Min2;
	if($Min2=='9') $Min2="0".$Min2;
	$HoraDe="$Hora1:$Min1";
	$HoraA="$Hora2:$Min2";
	if($HoraDe<$HoraA) {
		$sql="INSERT INTO ".
			"progtareastrimestral (Actividad, HoraDe, HoraA, FechaDe, Observaciones,t_asig) ".
			"VALUES ('$Actividad','$HoraDe','$HoraA','$FechaProceso','$Observaciones','$lista')";
		if (mysql_query($sql))
				echo 0; // Insercion correcta
			else
				echo -2;
	} else {
		echo -1;
	}

?>