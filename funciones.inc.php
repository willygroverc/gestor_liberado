<?php
// Version: 	1.0
// Objetivo: 	Actualizar funciones ambiguas php NO recomendadas para version 5.3 o posterior
// Autor:		Cesar Cuenca
// Fecha:		16/NOV/12	
//______________________________________________________________________________________________
# ==== Funciones Generales 

// Toma una cadena, la descopone por palabras y lo devuelve en un vector
function DesconponerCadena( $cadena )   
{	$lon = strlen( $cadena ); 
	$cadena = $cadena." ";
	$c = 0;
	for ( $i = 0; $i <= $lon; $i++ )
	{	if ( $cadena[$i] == " ")
		{	if (!empty($str))	
			{	$vec[$c] = trim($str);								
				$c ++;
			}			 
			$str = "";			
		}
		else
		 	$str = trim($str).$cadena[$i];			
	}	
	return $vec;
}
// Toma dos vectores y compara sus elementos. $vobs es la cad. q introdujo

function ComparaCadenas( $vec, $vobs ) 
{  	$sw = 0;
	for ( $i = 0; $i< count ( $vobs ); $i++ )
	{  for ( $j = 0; $j< count ( $vec); $j++ )
			if (!strcasecmp ($vobs[$i], $vec[$j])) 
				$sw = 1;         	
	}	
	return $sw;
}

//Reemplaza U,N,S,E,Z por su significado

function BuscarSignificado( $ubicacion )	
{  $vec = explode ( ",", $ubicacion );
	for ( $i = 0; $i< count ( $vec ); $i++ )
	{	$c = 0;	
		switch ($vec[$i]) {
		case "U":
			$vec[$i] = "Sistema";
			break; 
		case "N":
			$vec[$i] = "Negocio";
			break; 
		case "S":
			$vec[$i] = "Externo1";
			break; 
		case "E":
			$vec[$i] = "Externo2";
			break; 
		case "Z":
			$vec[$i] = "Niguno";
			break; 						
		default:
			break;
		}	
	}
	return $vec;
}

//retorna el valor de $campo1 correspondiente a $x
	
function XCampo($x,$tabla,$campo,$campo1,$enlace)	
{	$aux = "";
	$result = mysql_query ("select $campo,$campo1 from $tabla where $campo='$x'",$enlace);
	if ($row = mysql_fetch_array($result)) $aux=$row[1];
	$aux = trim($aux);
	return $aux;
}

function XCampoc($x,$tabla,$campo,$campo1,$enlace)	
{	include ( "conexion.php" );
	$aux = "";
	$result = mysql_query ("select $campo,$campo1 from $tabla where $campo='$x'");
	if ($row = mysql_fetch_array($result)) $aux=$row[1];
	$aux = trim($aux);
	return $aux;
}

// verifica si existe en el modulo X, no exitan un arc. con el mismo nombre con el que tiene el quie se insertara
function ArchivoExistente($archivo, $direc)
{ 	$op = 0;
	$dir = opendir($direc);
	while ($elemento = readdir($dir))
	{ 	if ($elemento == $archivo)
   		$op = 1;
	}
	closedir($dir); 
	return $op;
}


function OpenFile($archivo, $direc )
{	$dir = opendir($direc);
	while ($elemento = readdir($dir))
	{ 	if ($elemento == $archivo)
   		{return $elemento;}
		break;
	}
		
}

// Toma el codigo del ultimo archivo insertado
function ObtieneCodigo($db, $link, $tabla, $campo)
{	$sql9 = "SELECT MAX($campo) AS $campo FROM $tabla";
	$res9  = mysql_query($sql9);
	while ( $row9 = mysql_fetch_array( $res9 ) )
	{ $cod = $row9[$campo]; }
	return($cod);	
}

// copia todo, archivos y carpertas

function deldir($dir) 
{  $dh = opendir($dir);
	while ($file = readdir($dh)) 
	{   if($file != "." && $file != "..")
		{   $fullpath = $dir."/".$file;
			if(!is_dir($fullpath)) 
			{ unlink($fullpath);}
			else { deldir($fullpath); }
		}
	}
	closedir($dh);
	if(rmdir($dir)) { return true; }
	else {  return false; }
}		
//COPIA LOS ARCHIVOS DE UN DIRECTORIO A OTRO CON LA OPCION DE ELIMNAR O NO

function CopiaDir($dir, $dir_copia, $eliminar) 
{ 	$sw = 0;
	$dh = opendir($dir);
	while ($file = readdir($dh)) 
	{   if($file != "." && $file != ".." && $file != "backups" && $file != "replica" && $file != "trash")
		{   $path_com = $dir."/".$file;			
			if(!is_dir($path_com)) 
			{	copy( $path_com, $dir_copia."/".$file );				 
				if ($eliminar == "1")
				{ unlink($path_com); }	
			}
			else 
			{	$dir_copia_c = $dir_copia."/$file";				
				mkdir( $dir_copia_c, 0777 );	
				CopiaDir($path_com, $dir_copia_c, $eliminar);
				$sw = 1; 
			}
		}		
	}
	closedir($dh);	
	if ( $eliminar == "1" && $sw != 1 )
	{ rmdir($dir); }	
}		
//ELIMINA LOS DATOS DE UNA TABLA
function BorrarDatos($tabla, $db, $link)
{	$sql = "DELETE FROM $tabla";
	mysql_query ($sql);
}

// verifica si algun archivo esta  esta en proceso de cambio
function EnProceso($db, $link)
{	$cont = 0;
	$sql = "SELECT id_arch, estado  FROM datos_archivos";
	$res = mysql_query($sql);
	while ( $row = mysql_fetch_array($res))
	{	if ( $row['estado'] == 1 )
			$cont ++;
	}
	if ($cont > 0)return 1;
	else return 0;	
}


//***********************************************************************
function DatosUsuarioAsignado( $cod ) 
{	require ("conexion.php");
	$str  = "SELECT *, CONCAT(apa_usr,' ',ama_usr,' ',nom_usr) AS usuario  FROM users 
			WHERE login_usr = '$cod' ";
	$res  = mysql_query($str);		
	$fila = mysql_fetch_array($res);
	if ($fila)		
		$asignado = "[".$fila['adicional1']."]"; 
	else
		$asignado = "[No Asignado]";
	return $asignado;
}

function DatosUsuarioAsignadoAgencia( $cod, $agencia ) 
{	require ("conexion.php");
	$str  = "SELECT *, CONCAT(apa_usr,' ',ama_usr,' ',nom_usr) AS usuario  FROM users 
			WHERE login_usr = '$cod' and adicional1=$agencia";
	$res  = mysql_query($str);		
	$fila = mysql_fetch_array($res);
	if ($fila)		
		$asignado = "[".$fila['adicional1']."]";
	else
		$asignado = "ninguno";
	return $asignado;
}

function DatosUsuariosTodos( $codusr ) //ojo
{	include( "conexion.php" ); 
	$str  = "SELECT * FROM users WHERE login_usr='$codusr'";			
	$res  = mysql_query($str);
	$fila = mysql_fetch_array($res);	
	$sql  = "SELECT * FROM datos_adicionales WHERE id_dadicional='".$fila['adicional1']."'";
	$res2 = mysql_query($sql);
	$fil2 = mysql_fetch_array( $res2 );
	if ($fil2) $age = $fil2['nombre_dadicional'];
	else  $age = " ";
	if ( $fila )			
		$datos = " [".$fila['nom_usr']." ".$fila['apa_usr']." ".$fila['ama_usr']."]";			
	else
		$datos = " [No asignado]";		
	return $datos;
}


function DatosUsuariosAgencia($codusr, $i)
{	include( "conexion.php" );
	$str  = "SELECT * FROM users WHERE login_usr='$codusr' AND adicional1=$i";			
	$res  = mysql_query($str);
	$fila = mysql_fetch_array($res);	
	$sql  = "SELECT * FROM datos_adicionales WHERE codigo='$fila[adicional1]' ";
	$res2 = mysql_query($sql);
	$fil2 = mysql_fetch_array( $res2 );
	if ($fil2) $age = $fil2['nombre_dadicional'];		
	else	$age = " ";
	if ( $fila )			
		$datos = $fila['nom_usr']." ".$fila['apa_usr']." ".$fila['ama_usr']." ".$age;			
	else
		$datos = "Ninguno";		
	return $datos;	
}


function DatosAgencia($codusr, $i)
{	include( "conexion.php" );
	$str  = "SELECT * FROM users WHERE login_usr='$codusr'";			
	$res  = mysql_query($str);
	$fila = mysql_fetch_array($res);
	if ($fila)	
	{	if ($i == $fila['adicional1'])	
		{	$sql  = "SELECT * FROM datos_adicionales WHERE id_dadicional='".$fila['adicional1']."' ";
			$res2 = mysql_query($sql);
			$fil2 = mysql_fetch_array( $res2 );
			if ($fil2){	
				$age = $fil2['nombre_dadicional'];
				$datos = $fila['nom_usr']." ".$fila['apa_usr']." ".$fila['ama_usr']." ".$age;
			}
			else $datos = "Ninguno";					
		}
		else $datos = "Ninguno";
	}
	else $datos = "Ninguno";	
	return $datos;	
}

function IdeInicial($AdicUSI)
{	require ("conexion.php");
	$sql4    = "SELECT * FROM datfichatec WHERE AdicUSI='$AdicUSI'";
	$result4 = mysql_query($sql4);		
	$row4    = mysql_fetch_array($result4);
	$de      = $row4['IdFicha'];
	return($de);
}

function IdeFinal($AdicUSI2)
{	require ("conexion.php");
	$sql5    = "SELECT * FROM datfichatec WHERE AdicUSI='$AdicUSI2'";
	$result5 = mysql_query($sql5);
	$row5    = mysql_fetch_array($result5);
	$al      = $row5['IdFicha'];
	return($al);	
}

// Separa el nombre del archivo de su phat completo
//Func. para USR externos, obtiene un array todas las ordenes enviadas y asignadas al usuario en cuestion
function CuentaRegistros($login)
{	include ('conexion.php');
	$c = 0;
	$sql = "SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' ORDER BY id_orden DESC";
	$res = mysql_query($sql); 
	while ( $fila = mysql_fetch_array($res) )
	{	
		if ($fila['cod_usr']==$login)
		{ 	
			$gen_reg[$c] = $fila['id_orden'];
			$c++; 
		}	
		else
		{	
			$sql2 = "SELECT MAX(id_asig) as id_asig FROM asignacion WHERE id_orden='".$fila['id_orden']."'";
			$res2 = mysql_query($sql2); 	
			$row2 = mysql_fetch_array($res2);
			if ($row2['id_asig'])
			{	$sql3 = "SELECT * FROM asignacion WHERE id_asig='".$row2['id_asig']."'";
				$res3 = mysql_query($sql3); 	
				$row3 = mysql_fetch_array($res3);	
				if ($row3['asig']==$login) 	
				{	$gen_reg[$c] = $fila['id_orden'];
					$c++;
				}
			}
		}		
	}
return $gen_reg;		
}
//CUENTA LOS Reg. Asignados
function CuentaRegistrosASIG($login, $gen)
{	require ("conexion.php");
	$c = 0;
	for ($i=0; $i< count($gen); $i++)
	{	$sql2 = "SELECT MAX(id_asig) as id_asig FROM asignacion WHERE id_orden='$gen[$i]'";	
		$res2 = mysql_db_query($db, $sql2, $link); 	
		$row2 = mysql_fetch_array($res2);
		if (isset($row2['id_asig']))
		{	$asig_reg[$c] = $gen[$i];
			$c++;}
	}
return $asig_reg;		
}
//CUENTA LOS Reg. NOasignados
function CuentaRegistrosNOASIG($login)
{	require ("conexion.php");
	$c=0;
	$sql = "SELECT * FROM ordenes WHERE cod_usr='$login' ORDER BY id_orden DESC ";
	$res = mysql_query($sql); 
	while ( $fila = mysql_fetch_array($res) )
	{	$sql2 = "SELECT MAX(id_asig) as id_asig FROM asignacion WHERE id_orden='".$fila['id_orden']."'";	
		$res2 = mysql_query($sql2); 	
		$row2 = mysql_fetch_array($res2);
		if (empty($row2['id_asig']))
		{	$nasig_reg[$c] = $fila['id_orden'];
			$c++;
		}
	}
	return $nasig_reg;
}

//CUENTA LOS SOLUCIONADOS
function CuentaRegistrosSOL($login, $gen)
{	require ("conexion.php");
	$c = 0;
	for ($i=0; $i < count($gen); $i++)
	{	$sql2 = "SELECT * FROM solucion WHERE id_orden='$gen[$i]' ORDER BY id_orden DESC";	
		$res2 = mysql_query($sql2); 	
		$row2 = mysql_fetch_array($res2);
		if (isset($row2['id_orden']))
		{	$sol_reg[$c] = $gen[$i];
			$c++;
		}			
	}
	return $sol_reg;
}

//CUENTA NO SOLUCIONADOS
function CuentaRegistrosNS($login, $gen)
{	require ("conexion.php");
	$c = 0;
	for ($i=0; $i < count($gen); $i++)
	{	$sql2 = "SELECT * FROM solucion WHERE id_orden='$gen[$i]'";	
		$res2 = mysql_query($sql2);
		$row2 = mysql_fetch_array($res2);
		if (empty($row2['id_orden']))
		{	$nsol_reg[$c] = $gen[$i];
			$c++;
		}			
	}
	return $nsol_reg;
}

//cuenta REGISTROS CON CONFORMIDAD
function CuentaRegistrosCC($login)
{	require ("conexion.php");
	$c = 0;
	$sql = "SELECT * FROM ordenes ORDER BY id_orden DESC";
	$res = mysql_query($sql); 
	while ( $fila = mysql_fetch_array($res) ){	
		$sql2 = "SELECT * FROM conformidad WHERE id_orden='".$fila['id_orden']."'";
		$res2 = mysql_query($sql2); 	
		$row2 = mysql_fetch_array($res2);
		if (isset($row2['id_orden']))
		{	if ( $row2['reg_conf'] == $login)	
			{	$cc_reg[$c] = $fila['id_orden'];
				$c++;
			}
			else
			{	if ($fila['cod_usr'] == $login)				
				{	$cc_reg[$c] = $fila['id_orden'];
					$c++;
				}
			}
		}			
	}
	return @$cc_reg;
}
//***cuenta REGISTRO SINCONFORMIDAD
function CuentaRegistrosSC2($login)
{	require ("conexion.php");
	$c = 0;
	$sql = "SELECT * FROM ordenes ORDER BY id_orden DESC";
	$res = mysql_query($sql); 
	while ( $fila = mysql_fetch_array($res) ){	
		$sql2 = "SELECT * FROM conformidad WHERE id_orden='".$fila['id_orden']."'";	
		$res2 = mysql_query($sql2); 	
		$row2 = mysql_fetch_array($res2);
		if (empty($row2['id_orden']))	
		{	if ($fila['cod_usr'] == $login)				
			{	$sc_reg[$c] = $fila['id_orden'];
				$c++;
			}
		  	//if ($row2[reg_conf] == $login)						
		}	
	}
	return $sc_reg;
}
function CuentaRegistrosSC($login, $gen)
{	require ("conexion.php");
	$c = 0;
	for ($i=0; $i < count($gen); $i++)
	{	$sql2 = "SELECT * FROM conformidad WHERE id_orden='$gen[$i]'";	
		$res2 = mysql_query($sql2); 	
		$row2 = mysql_fetch_array($res2);
		if (empty($row2['id_orden']))
		{	$nsol_reg[$c] = $gen[$i];
			$c++;
		}			
	}
	return $nsol_reg;
}

//obtiene datos del envio para lista2.php
function DatosEnvio($id_orden)
{	require ("conexion.php");
	$sql = "SELECT * , DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes WHERE id_orden=$id_orden";
	$res = mysql_query($sql); 	
	$row = mysql_fetch_array($res);	
	$sql5 = "SELECT * FROM users WHERE login_usr='".$row['cod_usr']."'";
	$result5 = mysql_query($sql5);
	$row5 = mysql_fetch_array($result5);
	$fecha = $row['fecha']." ".$row['time'];
	$nom_usr =$row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr'];
	$tipo_us = $row5['tipo2_usr'];
	$ci = $row['ci_ruc'];
	$incidencia = $row['desc_inc'];
	$anidacion= $row['id_anidacion'];
	$datos = "$fecha*$nom_usr*$tipo_us*$ci*$incidencia*$anidacion";
	return $datos;
}
//obtiene nombre y fecha est sol de una orden espedifica,
function Asignacion($id_orden)
{	include("conexion.php");
	$sw = 0;
	$sql2 = "SELECT MAX(id_asig) as id_asig FROM asignacion WHERE id_orden='$id_orden'";	
	$res2 = mysql_query($sql2); 	
	$row2 = mysql_fetch_array($res2);
	$usr="";
	$fec="";
	if (isset($row2['id_asig']))
	{	$sql3 = "SELECT *, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig FROM asignacion WHERE id_asig = '".$row2['id_asig']."'";
		$res3 = mysql_query($sql3); 	
		$row3 = mysql_fetch_array($res3);
		$sql5 = "SELECT * FROM users WHERE login_usr='".$row3['asig']."'";
		$result5 = mysql_query($sql5);
		$row5 = mysql_fetch_array($result5);		
		$usr  = $row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr'];
		$fec  = $row3['fechaestsol_asig'];
		$sw = 1;		
	}
	$asig = $usr."*".$fec."*".$sw;
	return $asig;
}

//obyiene numero de seguimiento
function NroSeguimientos($id_orden) 
{	require ("conexion.php");
	$sql2 = "SELECT count(*) AS num FROM seguimiento WHERE id_orden='$id_orden'";
	$result2 =mysql_query($sql2);
	$row2 = mysql_fetch_array($result2);
	return  $row2['num'];
}
function Solucionados($id_orden) 
{	include("conexion.php");
	$sql3 = "SELECT * FROM solucion where id_orden='$id_orden'";
	$result3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($result3);
	return $row3;
} 

function UsuarioOrden($id_orden)
{	include("conexion.php");
	$sql = "SELECT * FROM ordenes where id_orden='$id_orden'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	return $row['cod_usr'];
} 

function Conformidad($id_orden) 
{	include("conexion.php");
		$sql4 = "SELECT * FROM conformidad where id_orden='$id_orden'";
		$result4 = mysql_query($sql4);
		$row4 = mysql_fetch_array($result4);
	return $row4;
}

// LISTA TODOS LOS REGISTROS NO SOLUCIONADOS (usado para listans.php)
function CuentaRegistrosNS_G($tipo1, $login)
{	include ('conexion.php');
	$gen_reg = array();
	if($tipo1 == "T")  $sql = "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' ORDER BY id_orden DESC";
	if ($tipo1 == "A" or $tipo == "B") $sql = "SELECT id_orden FROM ordenes ORDER BY id_orden DESC";
	if ($tipo1 == "C")  $sql = "SELECT id_orden FROM ordenes WHERE cod_usr='$login' ORDER BY id_orden DESC";
	$c = 0;

	$res = mysql_query($sql); 
	while ( $fila = mysql_fetch_array($res) )
	{	$sql2 = "SELECT id_orden FROM solucion WHERE id_orden = '".$fila['id_orden']."'";	
		$res2 = mysql_query($sql2); 	
		$row2 = mysql_fetch_array($res2);
		if (!$row2['id_orden'])
		{	$gen_reg[$c] = $fila['id_orden'];	
			$c++; 
		}
	}	
	return $gen_reg;
}

//  Reg. asignados (listans.php)
function CuentaRegistrosASIG_GS($gen, $login, $auxbo)
{	require ("conexion.php");
	$asig_reg = array();
	$c = 0;
	for ($i=0; $i< count($gen); $i++)
	{	$sql2 = "SELECT MAX(id_asig) as id_asig FROM asignacion WHERE id_orden='$gen[$i]' AND asig LIKE '$login' and id_asig IN ( $auxbo )";	
		$res2 = mysql_query($sql2); 	
		$row2 = mysql_fetch_array($res2);
		if (isset($row2['id_asig']))
		{	$asig_reg[$c] = $gen[$i];
			$c++;
		}
	}
	return $asig_reg;
}

//  Reg. Enviados por: (listans.php)

function CuentaRegistrosEnviado_por($gen, $login)
{	require ("conexion.php");
	$asign_reg = array();
	$c = 0;
	for ($i=0; $i< count($gen); $i++)
	{	$sql2 = "SELECT id_orden FROM ordenes WHERE id_orden='$gen[$i]' AND cod_usr LIKE '$login'";
		$res2 = mysql_query($sql2); 	
		$row2 = mysql_fetch_array($res2);
		if ($row2['id_orden'])
		{	$asign_reg[$c] = $gen[$i];
			$c++;
		}
	}
	return $asign_reg;	
}

function Nro_orden($gen,$numero)
{	require ("conexion.php");
	$asign_reg = array();
	$c = 0;
	for ($i=0; $i< count($gen); $i++)
	{	$sql2 = "SELECT id_orden FROM ordenes WHERE id_orden='$gen[$i]'";
		$res2 = mysql_query($sql2); 	
		$row2 = mysql_fetch_array($res2);
		if ($row2['id_orden']==$numero)
		{	$asign_reg[$c] = $gen[$i];
			$c++;
		}
	}
	return $asign_reg;	
}

function por_consulta($gen,$numero)
{	require ("conexion.php");
	$asign_reg = array();
	$c = 0;
	for ($i=0; $i< 1; $i++)
	{	$sql2 = "SELECT id_orden FROM `ordenes` WHERE desc_inc like '%$numero%'";
		$res2 = mysql_query($sql2); 	
		$row2 = mysql_fetch_array($res2);
		if ($row2['id_orden'])
		{	$asign_reg[$c] = $gen[$i];
			$c++;
		}
	}
	return $asign_reg;	
}

//  Reg. NO asignados (listans.php)
function CuentaRegistrosNOASIG_GS($gen)
{	require ("conexion.php");
	$asign_reg = array();
	$c = 0;
	for ($i=0; $i< count($gen); $i++)
	{	$sql2 = "SELECT MAX(id_asig) as id_asig FROM asignacion WHERE id_orden='$gen[$i]'";	
		$res2 = mysql_query($sql2); 	
		$row2 = mysql_fetch_array($res2);
		if (!$row2['id_asig'])
		{	$asign_reg[$c] = $gen[$i];
			$c++;
		}
	}
	return $asign_reg;	
}
?>
