<?php
function FechaEmision($fec_emision)
{	$fec_tmp = explode("/",$fec_emision);
	$dt = $fec_tmp[0]; 
	$mt = $fec_tmp[1]; 
	$at = $fec_tmp[2]; 
	if ( substr($dt,0,1) == "0") $dt = substr($dt,1,1);			
	if ( substr($mt,0,1) == "0") $mt = substr($mt,1,1);		
	$f_emi = mktime(0,0,0,$mt,$dt,$at);
	return($f_emi);
}
function FechaActual()
{	$today = date("n-j-Y");
	$today2 = explode("-",$today);
	$f_hoy = mktime(0,0,0,$today2[0],$today2[1],$today2[2]); //echo $today2[0].$today2[1].$today2[2];
	return($f_hoy);
}
function FechaCumplimientoMes($dia)
{	$fec_num2 = date("d/m/Y");
	$fec2 = explode("/", $fec_num2); 
	$fec_cumpli2 = $dia."/".$fec2[1]."/".$fec2[2];  // Para mostrar los datos en formato DD/MM/AA				
	return($fec_cumpli2);
}
function FechaSinCeros($fecha)  // para los item [x][4] de la matriz
{	$fec = explode("/", $fecha); 		
	$dia = $fec[0];
	$mes = $fec[1];
	$ano = $fec[2];
	if ( substr($fec[0],0,1) == "0" ) $dia = substr($fec[0],1,1); 
	if ( substr($fec[1],0,1) == "0" ) $mes = substr($fec[1],1,1); 
	$fecha2 = $dia."/".$mes."/".$ano;
	return($fecha2);
}
function mTime($separador,$fec_cumpli)   //$fec_cumpli en formato d/m/y
{	$f = explode ($separador,$fec_cumpli);
	$fec = mktime(0,0,0,$f[1],$f[0],$f[2]);
	return($fec);
}
function FechaCumpliTrimestral( $fecha_ini, $f_mes, $f_dia, $nro_meses)
{		$fecha = getdate();
		$fec = explode ("-", $fecha_ini); //echo "---".$fecha_ini;
		$mes = $fec[1];
		$dia = $fec[2];
		$ano = $fec[0];
		
		if (substr($fec[1],0,1) == "0" ) $mes = substr($fec[1],1,1); 
		if (substr($fec[2],0,1) == "0" ) $dia = substr($fec[2],1,1); 
		
		$anterior = mktime(0,0,0, $mes, $dia, $ano);
		$actual = mktime(0,0,0, $fecha[mon], $fecha[mday], $fecha[year]);
		while ( $anterior < $actual)	
		{	$fec_ant = date("n-j-Y", mktime(0,0,0, $mes + $nro_meses,$dia, $ano));						
			$ant = explode ("-",$fec_ant);		
			$mes = $ant[0];
			$dia = $ant[1];
			$ano = $ant[2];			
			$anterior = mktime(0,0,0, $mes, $dia, $ano);		
		}		
		$fec_ini= date("n-j-Y", mktime(0,0,0, $mes-$nro_meses, $dia, $ano));
		$ant = explode ("-",$fec_ini);		
		$mes = $ant[0]; 
		$dia = $ant[1];
		$ano = $ant[2];
		$fec_cumpli  = date("j/n/Y", mktime(0,0,0, $mes + ($f_mes-1), $dia + $f_dia, $ano));
		//$fec_cumpli2 = date("Y-m-d", mktime(0,0,0, $mes + ($row_tarea[Mes]-1), $dia + $row_tarea[Dia], $ano));
		return($fec_cumpli);
}
function FechaAvisoTrimestral($fec_cumpli, $dia)
{	$f = explode ("/",$fec_cumpli );
	$fec = mktime(0,0,0,$f[1],$f[0]-$dia,$f[2]);
	return($fec);
}
function FechaFormato($fec_cumpli)
{	$f = explode("/",$fec_cumpli);
	$dia = $f[0];
	$mes = $f[1];
	if (strlen($f[0]) == 1) $dia = "0".$f[0];
	if (strlen($f[1]) == 1) $mes = "0".$f[1];
	$fec_c = $dia."/".$mes."/".$f[2];
	return($fec_c);
}

//-------------------------------------------------
function Meses()
{
include("conexion.php");
$fecha_hoy=date('Y-m-d');
$fec_dia = date("n-j-Y");
$fec_hoy = explode("-",$fec_dia);
//================== TaREAS MENSUALES =======================
$tar_men = array();
$i = 0;
$j = 0;
$c = 1;  
$sql = "SELECT *, DATE_FORMAT(fec_cumpli, '%d/%m/%Y') AS fec_cumpli,  DATE_FORMAT(fec_emision, '%d/%m/%Y') AS fec_emision, DATE_FORMAT(fec_emision2, '%d/%m/%Y') AS fec_emision2 FROM recordatorios WHERE tipo_tarea=2";
$res = mysql_db_query($db,$sql,$link);
while (  $row = mysql_fetch_array($res) ) 
{	if ($row[IdProgTarea] != 0)
	{	$sql_tarea  = "SELECT IdProgTarea, Actividad, Dia FROM progtareasmensual WHERE IdProgTarea = '$row[IdProgTarea]'";	
		$row_tarea  = mysql_fetch_array(mysql_db_query($db,$sql_tarea,$link));
		$fec_cumpli = explode("/", $row[fec_cumpli]);
		$dia = $fec_cumpli[0];
		$mes = $fec_cumpli[1];
		$ano = $fec_cumpli[2];		
		//$fec_cumpli2 = FechaCumplimientoMes($row_tarea[Dia]); :P				
		if ( substr($fec_cumpli[2],0,1) == "0" ) $dia = substr($fec_cumpli[2],1,1); 
		if ( substr($fec_cumpli[1],0,1) == "0" ) $mes = substr($fec_cumpli[1],1,1); 

		if ( $row[tipo_emision] != 3 )
		{	$fec_aviso  = mktime(0,0,0,$mes,$dia-($row[tipo_emision]-1),$ano);
			$fec_actual = mktime(0,0,0,$fec_hoy[0],$fec_hoy[1],$fec_hoy[2]);
			if ($fec_aviso <= $fec_actual)
			{	$fec_cumpli = FechaSinCeros($row[fec_cumpli]);
				$tar_men[$i][0] = $row_tarea[Actividad];
				$tar_men[$i][1] = $row[fec_cumpli];
				$fec_avi = date("n-j-Y",mktime(0,0,0,$mes,$dia-($row[tipo_emision]-1),$ano));
				$tar_men[$i][2] = $fec_avi;
				$tar_men[$i][3] = $fec_cumpli; //echo $tar_men[$i][3];
				$i ++; 
				$c ++; 
			}	
		}		
		else
		{   $fecha = getdate();
			$mes= $fecha[mon];
			$dia= $fecha[mday];
			$ano= $fecha[year];			
			$f_emi  = FechaEmision($row[fec_emision]);
			$f_emi2 = FechaEmision($row[fec_emision2]);
			$f_hoy  = FechaActual();			
			$fecha_cm = mktime(0,0,0,$mes,$row_tarea[Dia],$ano);				
			$fec2 = explode("/", $row[fec_emision]); 		
			$fec_avi = date("n-j-Y",mktime(0,0,0,$fec2[1],$fec2[0],$fec2[2]));														 				

			if (($fecha_cm >= $f_emi2) and ($f_hoy >= $f_emi and $f_hoy<=$f_emi2))			
			{	$tar_men[$i][0] = $row_tarea[Actividad];
				$tar_men[$i][1] = $row[fec_cumpli];
				$tar_men[$i][2] = $fec_avi;
				$tar_men[$i][3] = $row[fec_emision2];								
				$i ++;	
			}
			unset($today);	
		}
	}//end if Individuales	
	else
	{	$fec_num = date("j-n-Y");	
		$fec = explode("-", $fec_num); 			
		$sql_tarea = "SELECT * FROM progtareasmensual";	
		$res_tarea = mysql_db_query($db,$sql_tarea,$link);							
	 	while ($row_tarea = mysql_fetch_array($res_tarea))
		{  	if ( $row[tipo_emision] != 3 )			// General con 1 o 2 dias antes
			{   $fec_cumpli  = $row_tarea[Dia]."/".$fec[1]."/".$fec[2]; 
				$f_cumpli = mktime(0,0,0,$fec[1], $row_tarea[Dia], $fec[2]);
				$fec_cumpli2 = FechaCumplimientoMes($row_tarea[Dia]);
								
				if ($row[tipo_emision] == 1) $dd = $row_tarea[Dia];	
				else $dd = $row_tarea[Dia]-1;
				
				$fec_avi = date("n-j-Y",mktime(0,0,0,$fec[1], $dd, $fec[2]));
				$fec_aviso = mktime(0,0,0,$fec[1], $dd, $fec[2]);
				
				$fec_hoy  = FechaActual();
				if ($fec_hoy>=$fec_aviso)
				{	$tar_men[$i][0] = $row_tarea[Actividad];
					$tar_men[$i][1] = $fec_cumpli2;
					$tar_men[$i][2] = $fec_avi; 		//echo $tar_men[$i][2]."<br>";
					$tar_men[$i][3] = $fec_cumpli;
					$i ++;											 			
				}	
			}
			else  // Por fechas especificas de general
			{ 	$fecha = getdate();
				$mes= $fecha[mon];
				$dia= $fecha[mday];
				$ano= $fecha[year];				
				$f_emi  = FechaEmision($row[fec_emision]);
				$f_emi2 = FechaEmision($row[fec_emision2]);
				$f_hoy  = FechaActual();											
				$fec_cumpli2 = FechaCumplimientoMes($row_tarea[Dia]);
				$fec_cumpli  = FechaSinCeros($fec_cumpli2);					
				$fec2 = explode("/", $row[fec_emision]); 		
				$fec_avi = date("n-j-Y",mktime(0,0,0,$fec2[1],$fec2[0],$fec2[2]));														 				
				$fecha_cm = mktime(0,0,0,$mes,$row_tarea[Dia],$ano);				
				if (($fecha_cm >= $f_emi2) and ($f_hoy >= $f_emi and $f_hoy<=$f_emi2))
				{	$tar_men[$i][0] = $row_tarea[Actividad];
					$tar_men[$i][1] = $fec_cumpli2;	
					$tar_men[$i][2] = $fec_avi;
					$tar_men[$i][3] = $fec_cumpli;					
					$i ++;							 							
				}	
			} // END por fechas especificas de General
		}
	}
}
// ==================End tareas mensuales =========================
;
 if (count($tar_men) > 0) $op = 1;
 else $op = 0;
return ($op);
}

function Trimestrales()
{
include("conexion.php");
$mat_tri = array();
$i = 0;
$sql = "SELECT *, DATE_FORMAT(fec_cumpli, '%d/%m/%Y') AS fec_cumpli,  DATE_FORMAT(fec_emision, '%d/%m/%Y') AS fec_emision, DATE_FORMAT(fec_emision2, '%d/%m/%Y') AS fec_emision2 FROM recordatorios WHERE tipo_tarea=3";
$res = mysql_db_query($db,$sql,$link);
while (  $row = mysql_fetch_array($res) ) 
{	$fec_hoy = FechaActual();
	if ($row[IdProgTarea] != 0 )   // No es general 
	{	$sql_tarea  = "SELECT IdProgTarea, Actividad, Dia, FechaDe, Mes FROM progtareastrimestral WHERE IdProgTarea = '$row[IdProgTarea]'";	
		$row_tarea  = mysql_fetch_array(mysql_db_query($db,$sql_tarea,$link));	
		if ($row[tipo_emision] == 1)    //General con el ultimo dia
		{	$fec_cumpli  = FechaCumpliTrimestral($row_tarea[FechaDe], $row_tarea[Mes], $row_tarea[Dia],3);
			$fec_cumpli2 = FechaFormato($fec_cumpli);
			$fec_cum =  mTime("/",$fec_cumpli);
			$fec_avi = FechaAvisoTrimestral($fec_cumpli, 0);			
			if ($fec_avi == $fec_hoy) 		
			{	$mat_tri[$i][0] = $row_tarea[Actividad];
				$mat_tri[$i][1] = $fec_cumpli2;	
				$mat_tri[$i][2] = $fec_avi;
				$mat_tri[$i][3] = $fec_cumpli;					
				$i ++;							 							
			}	
		}
		if ($row[tipo_emision] == 2)  // Con 2 dias de anticipacion
		{	$fec_cumpli  = FechaCumpliTrimestral($row_tarea[FechaDe], $row_tarea[Mes], $row_tarea[Dia],3 );
			$fec_cumpli2 = FechaFormato($fec_cumpli);
			$fec_cum =  mTime("/",$fec_cumpli);
			$fec_avi = FechaAvisoTrimestral($fec_cumpli, 1);
			
			if ($fec_hoy >= $fec_avi and $fec_hoy <= $fec_cum )  
			{	$mat_tri[$i][0] = $row_tarea[Actividad];
				$mat_tri[$i][1] = $fec_cumpli2;	
				$mat_tri[$i][2] = $fec_avi;   //aviso esta como numero
				$mat_tri[$i][3] = $fec_cumpli;					
				$i ++;			
			}
		}
		if ($row[tipo_emision] == 3)  // Por fechas especificas  
		{		
			$f_emi  = FechaEmision($row[fec_emision]);
			$f_emi2 = FechaEmision($row[fec_emision2]);
			$fec_cumpli  = FechaCumpliTrimestral($row_tarea[FechaDe], $row_tarea[Mes], $row_tarea[Dia],3);
			$fec_cumpli2 = FechaFormato($fec_cumpli);
			$fec_cum =  mTime("/",$fec_cumpli); 
			if (($fec_hoy >= $f_emi and $fec_hoy <= $f_emi2) and  ($fec_hoy <= $fec_cum))     //19/12/2005  21/12/2005    23/05/2005 
			{	$mat_tri[$i][0] = $row_tarea[Actividad]; 
				$mat_tri[$i][1] = $fec_cumpli2;	
				$mat_tri[$i][2] = $f_emi;  //aviso esta como numero
				$mat_tri[$i][3] = $fec_cumpli;					
				$i ++;			
			}
		}
	}	
	else  // Es general
	{	$sql_tarea  = "SELECT IdProgTarea, Actividad, Dia, FechaDe, Mes FROM progtareastrimestral";	
		$res_tarea  = mysql_db_query($db,$sql_tarea,$link);				
		while ($row_tarea = mysql_fetch_array($res_tarea))
		{	
			if ($row[tipo_emision] == 1)    //General con el ultimo dia
			{	$fec_cumpli  = FechaCumpliTrimestral($row_tarea[FechaDe], $row_tarea[Mes], $row_tarea[Dia],3);
				$fec_cumpli2 = FechaFormato($fec_cumpli);
				$fec_cum =  mTime("/",$fec_cumpli);
				$fec_avi = FechaAvisoTrimestral($fec_cumpli, 0);	
				if ($fec_avi == $fec_hoy) 		
				{	$mat_tri[$i][0] = $row_tarea[Actividad];
					$mat_tri[$i][1] = $fec_cumpli2;	
					$mat_tri[$i][2] = $fec_avi;
					$mat_tri[$i][3] = $fec_cumpli;					
					$i ++;							 							
				}	
			}
			if ($row[tipo_emision] == 2)  // Con 2 dias de anticipacion
			{	$fec_cumpli  = FechaCumpliTrimestral($row_tarea[FechaDe], $row_tarea[Mes], $row_tarea[Dia],3 );
				$fec_cumpli2 = FechaFormato($fec_cumpli);
				$fec_cum =  mTime("/",$fec_cumpli);
				$fec_avi = FechaAvisoTrimestral($fec_cumpli, 1);
				if ($fec_hoy >= $fec_avi and $fec_hoy <= $fec_cum )  
				{	$mat_tri[$i][0] = $row_tarea[Actividad];
					$mat_tri[$i][1] = $fec_cumpli2;	
					$mat_tri[$i][2] = $fec_avi;   //aviso esta como numero
					$mat_tri[$i][3] = $fec_cumpli;					
					$i ++;			
				}
			}
			if ($row[tipo_emision] == 3)  // Por fechas especificas  
			{	//echo "hola";
				$f_emi  = FechaEmision($row[fec_emision]);
				$f_emi2 = FechaEmision($row[fec_emision2]);
				$fec_cumpli  = FechaCumpliTrimestral($row_tarea[FechaDe], $row_tarea[Mes], $row_tarea[Dia],3);
				$fec_cumpli2 = FechaFormato($fec_cumpli);
				$fec_cum =  mTime("/",$fec_cumpli);
				//echo ":)".$fec_cumpli;	
				if (($fec_hoy >= $f_emi and $fec_hoy <= $f_emi2) and  ($fec_hoy <= $fec_cum))     //19/12/2005  21/12/2005    23/05/2005 
				{	$mat_tri[$i][0] = $row_tarea[Actividad]; 
					$mat_tri[$i][1] = $fec_cumpli2;	
					$mat_tri[$i][2] = $f_emi;  //aviso esta como numero
					$mat_tri[$i][3] = $fec_cumpli;					
					$i ++;			
				}
			}
		}			
	}
}
// ==============================End tareas Trimestrasles
 if (count($mat_tri) > 0) $op = 1;
 else $op = 0;
 return ($op);
}

function Semestrales()
{
include("conexion.php");
$mat_sem = array();
$i = 0;
$sql = "SELECT *, DATE_FORMAT(fec_cumpli, '%d/%m/%Y') AS fec_cumpli,  DATE_FORMAT(fec_emision, '%d/%m/%Y') AS fec_emision, DATE_FORMAT(fec_emision2, '%d/%m/%Y') AS fec_emision2 FROM recordatorios WHERE tipo_tarea=4";
$res = mysql_db_query($db,$sql,$link);
while (  $row = mysql_fetch_array($res) ) 
{	$fec_hoy = FechaActual();
	if ($row[IdProgTarea] != 0 )   // No es general 
	{	$sql_tarea  = "SELECT IdProgTarea, Actividad, Dia, FechaDe, Mes FROM progtareassemestral WHERE IdProgTarea = '$row[IdProgTarea]'";	
		$row_tarea  = mysql_fetch_array(mysql_db_query($db,$sql_tarea,$link));	
		if ($row[tipo_emision] == 1)    //General con el ultimo dia
		{	$fec_cumpli  = FechaCumpliTrimestral($row_tarea[FechaDe], $row_tarea[Mes], $row_tarea[Dia], 6);
			$fec_cumpli2 = FechaFormato($fec_cumpli);
			$fec_cum =  mTime("/",$fec_cumpli);
			$fec_avi = FechaAvisoTrimestral($fec_cumpli, 0);			
			if ($fec_avi == $fec_hoy) 		
			{	$mat_sem[$i][0] = $row_tarea[Actividad];
				$mat_sem[$i][1] = $fec_cumpli2;	
				$mat_sem[$i][2] = $fec_avi;
				$mat_sem[$i][3] = $fec_cumpli;					
				$i ++;							 							
			}	
		}
		if ($row[tipo_emision] == 2)  // Con 2 dias de anticipacion
		{	$fec_cumpli  = FechaCumpliTrimestral($row_tarea[FechaDe], $row_tarea[Mes], $row_tarea[Dia],6 );
			$fec_cumpli2 = FechaFormato($fec_cumpli);
			$fec_cum =  mTime("/",$fec_cumpli);
			$fec_avi = FechaAvisoTrimestral($fec_cumpli, 1);
			
			if ($fec_hoy >= $fec_avi and $fec_hoy <= $fec_cum )  
			{	$mat_sem[$i][0] = $row_tarea[Actividad];
				$mat_sem[$i][1] = $fec_cumpli2;	
				$mat_sem[$i][2] = $fec_avi;   //aviso esta como numero
				$mat_sem[$i][3] = $fec_cumpli;					
				$i ++;			
			}
		}
		if ($row[tipo_emision] == 3)  // Por fechas especificas  
		{		
			$f_emi  = FechaEmision($row[fec_emision]);
			$f_emi2 = FechaEmision($row[fec_emision2]);
			$fec_cumpli  = FechaCumpliTrimestral($row_tarea[FechaDe], $row_tarea[Mes], $row_tarea[Dia],6);
			$fec_cumpli2 = FechaFormato($fec_cumpli);
			$fec_cum =  mTime("/",$fec_cumpli); 
			if (($fec_hoy >= $f_emi and $fec_hoy <= $f_emi2) and  ($fec_hoy <= $fec_cum))     //19/12/2005  21/12/2005    23/05/2005 
			{	$mat_sem[$i][0] = $row_tarea[Actividad]; 
				$mat_sem[$i][1] = $fec_cumpli2;	
				$mat_sem[$i][2] = $f_emi;  //aviso esta como numero
				$mat_sem[$i][3] = $fec_cumpli;					
				$i ++;			
			}
		}
	}	
	else  // Es general
	{	$sql_tarea  = "SELECT IdProgTarea, Actividad, Dia, FechaDe, Mes FROM progtareassemestral";	
		$res_tarea  = mysql_db_query($db,$sql_tarea,$link); //echo ":P";				
		while ($row_tarea = mysql_fetch_array($res_tarea))
		{	
			if ($row[tipo_emision] == 1)    //General con el ultimo dia
			{	$fec_cumpli  = FechaCumpliTrimestral($row_tarea[FechaDe], $row_tarea[Mes], $row_tarea[Dia],6);
				$fec_cumpli2 = FechaFormato($fec_cumpli);
				$fec_cum =  mTime("/",$fec_cumpli);
				$fec_avi = FechaAvisoTrimestral($fec_cumpli, 0);	
				if ($fec_avi == $fec_hoy) 		
				{	$mat_sem[$i][0] = $row_tarea[Actividad];
					$mat_sem[$i][1] = $fec_cumpli2;	
					$mat_sem[$i][2] = $fec_avi;
					$mat_sem[$i][3] = $fec_cumpli;					
					$i ++;							 							
				}	
			}
			if ($row[tipo_emision] == 2)  // Con 2 dias de anticipacion
			{	$fec_cumpli  = FechaCumpliTrimestral($row_tarea[FechaDe], $row_tarea[Mes], $row_tarea[Dia],6 );
				$fec_cumpli2 = FechaFormato($fec_cumpli);
				$fec_cum =  mTime("/",$fec_cumpli);
				$fec_avi = FechaAvisoTrimestral($fec_cumpli, 1);
				if ($fec_hoy >= $fec_avi and $fec_hoy <= $fec_cum )  
				{	$mat_sem[$i][0] = $row_tarea[Actividad];
					$mat_sem[$i][1] = $fec_cumpli2;	
					$mat_sem[$i][2] = $fec_avi;   //aviso esta como numero
					$mat_sem[$i][3] = $fec_cumpli;					
					$i ++;			
				}
			}
			if ($row[tipo_emision] == 3)  // Por fechas especificas  
			{	//echo "hola";
				$f_emi  = FechaEmision($row[fec_emision]);
				$f_emi2 = FechaEmision($row[fec_emision2]);
				$fec_cumpli  = FechaCumpliTrimestral($row_tarea[FechaDe], $row_tarea[Mes], $row_tarea[Dia],6);
				$fec_cumpli2 = FechaFormato($fec_cumpli);
				$fec_cum =  mTime("/",$fec_cumpli);
				if (($fec_hoy >= $f_emi and $fec_hoy <= $f_emi2) and  ($fec_hoy <= $fec_cum))     //19/12/2005  21/12/2005    23/05/2005 
				{	$mat_sem[$i][0] = $row_tarea[Actividad]; 
					$mat_sem[$i][1] = $fec_cumpli2;	
					$mat_sem[$i][2] = $f_emi;  //aviso esta como numero
					$mat_sem[$i][3] = $fec_cumpli;					
					$i ++;			
				}
			}
		}			
	}
}
// =======================End Semestrales =============
 if (count($mat_sem) > 0) $op = 1;
 else $op = 0;
 return ($op);
}

function Anuales()
{
include("conexion.php");
$mat_anu = array();
$i = 0;
$sql = "SELECT *, DATE_FORMAT(fec_cumpli, '%d/%m/%Y') AS fec_cumpli,  DATE_FORMAT(fec_emision, '%d/%m/%Y') AS fec_emision, DATE_FORMAT(fec_emision2, '%d/%m/%Y') AS fec_emision2 FROM recordatorios WHERE tipo_tarea=5";
$res = mysql_db_query($db,$sql,$link);
while (  $row = mysql_fetch_array($res) ) 
{	$fec_hoy = FechaActual();
	
	if ($row[IdProgTarea] != 0 )  // No es general
	{	
		$sql_tarea  = "SELECT IdProgTarea, Actividad,FechaDe, DATE_FORMAT(Dia, '%d/%m/%Y') AS Dia FROM progtareasanual  WHERE IdProgTarea = '$row[IdProgTarea]'";	
		$row_tarea  = mysql_fetch_array(mysql_db_query($db,$sql_tarea,$link));	
		$fec_cumpli = FechaSinCeros($row_tarea[Dia]); //echo $fec_cumpli."<br>";			
			
		if ($row[tipo_emision] == 1)
		{	$fec_avi = FechaAvisoTrimestral($fec_cumpli, 0); 					
			if ($fec_avi == $fec_hoy) 		
			{	$mat_anu[$i][0] = $row_tarea[Actividad];
				$mat_anu[$i][1] = $row_tarea[Dia];	
				$mat_anu[$i][2] = $fec_avi;
				$mat_anu[$i][3] = $fec_cumpli;					
				$i ++;							 							
			}				
		}
				
		if ($row[tipo_emision] == 2)
		{	$fec_avi = FechaAvisoTrimestral($fec_cumpli, 1);
			$fec_cum =  mTime("/",$fec_cumpli);  					
			if ($fec_hoy >= $fec_avi and $fec_hoy <= $fec_cum )		
			{	$mat_anu[$i][0] = $row_tarea[Actividad];
				$mat_anu[$i][1] = $row_tarea[Dia];	
				$mat_anu[$i][2] = $fec_avi;
				$mat_anu[$i][3] = $fec_cumpli;					
				$i ++;							 							
			}				
		}			
		
		if ($row[tipo_emision] == 3)
		{	
			$fec_cum =  mTime("/",$fec_cumpli); 
			$f_emi   = FechaEmision($row[fec_emision]);
			$f_emi2  = FechaEmision($row[fec_emision2]); 
							
			if (($fec_hoy >= $f_emi and $fec_hoy <= $f_emi2) and  ($fec_hoy <= $fec_cum)) 		
			{	$mat_anu[$i][0] = $row_tarea[Actividad];
				$mat_anu[$i][1] = $row_tarea[Dia];	
				$mat_anu[$i][2] = $fec_avi;  //sin nada
				$mat_anu[$i][3] = $fec_cumpli;					
				$i ++;							 							
			}				
		}		
	}
	else  // Es general
	{	$sql_tarea  = "SELECT IdProgTarea, Actividad,FechaDe, DATE_FORMAT(Dia, '%d/%m/%Y') AS Dia FROM progtareasanual";	
		$res_tarea  = mysql_db_query($db,$sql_tarea,$link); 				
		while ($row_tarea = mysql_fetch_array($res_tarea))
		{	$fec_cumpli = FechaSinCeros($row_tarea[Dia]); //echo $fec_cumpli."<br>";			
			
			if ($row[tipo_emision] == 1)
			{	$fec_avi = FechaAvisoTrimestral($fec_cumpli, 0); 					
				if ($fec_avi == $fec_hoy) 		
				{	$mat_anu[$i][0] = $row_tarea[Actividad];
					$mat_anu[$i][1] = $row_tarea[Dia];	
					$mat_anu[$i][2] = $fec_avi;
					$mat_anu[$i][3] = $fec_cumpli;					
					$i ++;							 							
				}				
			}
				
			if ($row[tipo_emision] == 2)
			{	$fec_avi = FechaAvisoTrimestral($fec_cumpli, 1);
				$fec_cum =  mTime("/",$fec_cumpli);  					
				if ($fec_hoy >= $fec_avi and $fec_hoy <= $fec_cum )		
				{	$mat_anu[$i][0] = $row_tarea[Actividad];
					$mat_anu[$i][1] = $row_tarea[Dia];	
					$mat_anu[$i][2] = $fec_avi;
					$mat_anu[$i][3] = $fec_cumpli;					
					$i ++;							 							
				}				
			}
			
			if ($row[tipo_emision] == 3)
			{	
				$fec_cum =  mTime("/",$fec_cumpli); 
				$f_emi   = FechaEmision($row[fec_emision]);
				$f_emi2  = FechaEmision($row[fec_emision2]); 
									
				if (($fec_hoy >= $f_emi and $fec_hoy <= $f_emi2) and  ($fec_hoy <= $fec_cum)) 		
				{	$mat_anu[$i][0] = $row_tarea[Actividad];
					$mat_anu[$i][1] = $row_tarea[Dia];	
					$mat_anu[$i][2] = $fec_avi;  //sin nada
					$mat_anu[$i][3] = $fec_cumpli;					
					$i ++;							 							
				}				
			}					
								
		} // en while	
	
	}
}

 if (count($mat_sem) > 0) $op = 1;
 else $op = 0;
 return ($op);

}

?>