<?php
require_once('tcpdf/config/lang/spa.php');
require_once('tcpdf/tcpdf.php');
require('conexion.php');
@session_start();

$sql = "SELECT *,DATE_FORMAT(fecha,'%d / %m / %Y') as fecha FROM ordenes,users WHERE id_orden='$id_orden' AND cod_usr=login_usr";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);

$sql0 = "SELECT * FROM titular WHERE ci_ruc='$row[ci_ruc]'";
$result0=mysql_query($sql0);
$row0=mysql_fetch_array($result0);

$sql1 = "SELECT *, DATE_FORMAT(fecha_asig,'%d / %m / %Y') as fecha_asig,DATE_FORMAT(fechaestsol_asig,'%d / %m / %Y') as fechaestsol_asig,".
		"DATE_FORMAT(date_esc,'%d / %m / %Y') as date_esc,DATE_FORMAT(fechasol_esc,'%d / %m / %Y') as fechasol_esc FROM asignacion WHERE id_orden='$id_orden' ORDER BY id_asig DESC limit 1";
$result1=mysql_query($sql1);
$row1=mysql_fetch_array($result1);

$sql2 = "SELECT *,DATE_FORMAT(fecha_seg,'%d/%m/%Y') as fecha_seg, DATE_FORMAT(fecha_rea, '%d/%m/%Y') AS fecha_rea FROM seguimiento WHERE id_orden='$id_orden'";
$result2=mysql_query($sql2);

$sql3 = "SELECT *,DATE_FORMAT(fecha_sol,'%d / %m / %Y') as fecha_sol, DATE_FORMAT(fecha_sol_e,'%d / %m / %Y') as fecha_sol_e FROM solucion WHERE id_orden='$id_orden'";
$result3=mysql_query($sql3);
$row3=mysql_fetch_array($result3);

$sql4 = "SELECT *,DATE_FORMAT(fecha_conf,'%d / %m / %Y') as fecha_conf FROM conformidad WHERE id_orden='$id_orden'";
$result4=mysql_query($sql4);
$row4=mysql_fetch_array($result4);

$sql5 = "SELECT * FROM costo WHERE id_orden='$id_orden'";
$result5=mysql_query($sql5);

$sql6 = "SELECT SUM(subtot_cos) AS total_cos FROM costo where id_orden='$id_orden'";
$result6=mysql_query($sql6);
$row6=mysql_fetch_array($result6); 


	
$login=$_SESSION['login'];
$sql_us="SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$login'";
$result_us=mysql_query($sql_us);
$row_us=mysql_fetch_array($result_us);
$sql_cons="SELECT nombre , datos_gral FROM control_parametros";
$res_cons=mysql_query($sql_cons);
$row_cons=mysql_fetch_array($res_cons);
 if ($row_cons['datos_gral']==1){ 
	$html= '<table border="0" align="left">
			<tr> 
				<td colspan="2" align="left"><strong>DATOS GENERALES</strong></td>
			</tr>
			<tr> 
				<td width="20%">ENTIDAD :</td>
				<td width="80%"><strong>'.$row_cons['nombre'].'</strong></td>
			</tr>
			<tr> 
				<td width="20%">REALIZADO POR:</td>
				<td width="80%"><strong>'.$row_us['nom_usr'].' '.$row_us['apa_usr'].' '.$row_us['ama_usr'].'</strong></td>
			</tr>
			<tr>
				<td width="20%">IP ORIGEN :</td>
				<td width="80%"><strong>'.$_SERVER['REMOTE_ADDR'].'</strong></td>
			</tr>
			<tr> 
				<td width="20%">FECHA Y HORA :</td>
				<td width="80%"><strong>'.date("Y-m-d")."&nbsp;&nbsp;&nbsp;&nbsp;".date("H:i:s").'</strong></td>
			  </tr>
			</table><br><br>';
}
$html.='<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr> 
			<td align="center"> 
				<b><u><font ace="Arial, Helvetica, sans-serif">ORDEN DE TRABAJO</font></u></b>
			</td>
		</tr>
		</table>
		<br><br>
	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr> 
			<td width="53">Fecha: </td>
			<td width="126"><strong>'.$row['fecha'].'</strong></td>
			<td width="42">Hora: </td>
			<td width="81" ><strong>'.$row['time'].'</strong></td>
			<td width="236" align="right"><p>N:&nbsp;&nbsp;</p></td>
			<td width="97">
				<table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
					<tr> 
						<td align="center" class="tit_form"><strong>&nbsp;'.$row['id_orden'].'</strong></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br><br>
	
	<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr> 
		<td width="178" class="titulo2">Cliente: Interno';
       
		if ($row['tipo_usr']=="INTERNO"){
			$html.= '<img src="images/si1.gif" border="1">';
		}
		else{
			$html.= '<img src="images/no1.gif" border="1">';
		}
		
		$html.= '</td>
			<td width="453" class="titulo2">Externo';
		  
		if ($row['tipo_usr']=="EXTERNO"){
			$html.= '<img src="images/si1.gif" border="1">';
		}
		else{
			$html.= '<img src="images/no1.gif" border="1">';
		}
    $html.= '</td>
	</tr>';
	if($row['id_anidacion']){
		$html.= '<tr> 
				<td colspan="2">Viene de la orden :'.$row['id_anidacion'].'</td>
			</tr>';
	}
	$html.= '</table><br><br><br>
		<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr> 
				<td><u class="titulo">Datos del cliente:</u></td>
			</tr>
		</table><br><br>';
		
	$html.= '<table width="100%" border="0" align="center">
			<tr> 
				<td width="145" nowrap class="titulo2">Nombres y Apellidos: </td>
				<td width="490" height="1"><strong>';
	 
	if ($row['login_usr']=="")
		$html.= "SISTEMA";
	else 
		$html.= $row['nom_usr']." ".$row['apa_usr']." ".$row['ama_usr'];
	$html.= '</strong></td>';
  $html.= '	</tr>
			<tr> 
				<td height="1"></td>
				<td height="1" ></td>
			</tr>
		</table>';
$html.= '<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr> 
			<td width="59" class="titulo2">Entidad: </td>
			<td width="236" class="tit_form"><strong>'.$row['enti_usr'].'</strong></td>
			<td width="44" class="titulo2">Area: </td>
			<td width="298" class="tit_form"><strong>'.$row['area_usr'].'</strong></td>
		  </tr>
		  <tr> 
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
		  </tr>
		</table>
		<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr> 
			<td width="48" class="titulo2">Cargo:</td>
			<td width="167" class="tit_form"><strong>'.$row['cargo_usr'].'</strong></td>
			<td width="64" class="titulo2">Telefono:</td>
			<td width="217" class="tit_form"><strong>'.$row['telf_usr'].'</strong></td>
			<td width="26" class="titulo2">Ext:</td>
			<td width="100" class="tit_form"><strong>'.$row['ext_usr'].'</strong></td>
		  </tr>
		  <tr> 
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
		  </tr>
		</table>
		<br><br><br>
		<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr> 
			<td class="titulo"><u>Ubicacion Fisica:</u></td>
		  </tr>
		</table>
		<br>
		<table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr> 
			<td width="61" class="titulo2">Ciudad:</td>
			<td width="159" class="tit_form"><strong>'.$row['ciu_usr'].'</strong></td>
			<td width="66" class="titulo2">Direccion: </td>
			<td width="352" class="tit_form"><strong>'.$row['direc_usr'].'</strong></td>
		  </tr>
		  <tr> 
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
		  </tr>
		</table>';
if(isset($row0[0])){
	$html.= '<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr> 
				<td class="titulo"><u>Datos del Titular:</u></td>
				</tr>
		</table>
		<br>
		<table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr> 
			<td width="41" class="titulo2">CI/RUC:</td>
			<td width="100" class="tit_form"><strong>'.$row0['ci_ruc'].'</strong></td>
			<td width="135" class="titulo2">Nombres y Apellidos:</td>
			<td width="282" class="tit_form"><strong>'.$row0['nombre'] .' '.$row0['apaterno'].' '.$row0['amaterno']; 
			if($row0['acasada']!="")
				$html.= " de ".$row0['acasada'];
			$html.= '</strong></td>';
	$html.='  </tr>
		  <tr> 
			<td height="1" ></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1" ></td>
			<td height="1" bgcolor="#000000"></td>
		  </tr>
		</table>
		<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr> 
			<td width="48" class="titulo2">Email:</td>
			<td width="167" class="tit_form"><strong>'.$row0['email'].'</strong></td>
			<td width="64" class="titulo2">Direccion:</td>
			<td width="217" class="tit_form"><strong>'.$row0['direccion'].'</strong></td>
			<td width="26" class="titulo2">Telf:</td>
			<td width="100" class="tit_form"><strong>'.$row0['telf'].'</strong></td>
		  </tr>
		  <tr> 
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
		  </tr>
		</table>
		<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr> 
			<td width="48" class="titulo2">Entidad:</td>
			<td width="167" class="tit_form"><strong>'.$row0['entidad'].'</strong></td>
			<td width="64" class="titulo2">Area:</td>
			<td width="217" class="tit_form"><strong>'.$row0['area'].'</strong></td>
			<td width="26" class="titulo2">Cargo:</td>
			<td width="100" class="tit_form"><strong>'.$row0['cargo'].'</strong></td>
		  </tr>
		  <tr> 
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
		  </tr>
		</table>';
}
$html.= '<br><br>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
		<tr> 
			<td align="left">
				<p class="titulo"><u>Descripcion de la Incidencia:</u></p>
			</td>
		</tr>
	</table>
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;">
		<tr>
			<td class="tit_form">'.$row['desc_inc'].'</td></tr>';

$html.= '</table>';

if(isset($row1[0])){ 
	$html.= '<p>
		<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
			<tr align="justify"> 
				<td><u class="titulo">Diagnostico Inicial :</u></td>
			</tr>
		</table>
		<table width="636" border="1" align="center" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;">
			<tr>
				<td class=tit_form>'.$row1['diagnos'].'</td></tr>';
		
		$tmpComplejidad=array(1=>"1 - Baja", 2=>"2 - Media", 3=>"3 - Alta");
		$tmpPrioridad=array(3=>"3 - Baja", 2=>"2 - Media", 1=>"1 - Alta");

$html.= '</table><br><br><br>
		<table width="635" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr> 
			<td width="86" class="titulo2">Nivel (1-3): </td>
			<td width="86" class="tit_form"><strong>'.$tmpComplejidad[$row1['nivel_asig']].'</strong></td>
			<td width="119" class="titulo2">Criticidad (1-3): </td>
			<td width="111" class="tit_form"><strong>'.$tmpPrioridad[$row1['criticidad_asig']].'</strong></td>
			<td width="111" class="titulo2">Prioridad (1-3): </td>
			<td width="122" class="tit_form"><strong>'.$tmpPrioridad[$row1['prioridad_asig']].'</strong></td>
		</tr>
		<tr> 
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
		</tr>
		</table>
		<table width="635" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr> 
			<td width="86" class="titulo2">Asignado a: </td>
			<td width="274" class="tit_form"><strong>';
     
$sql10 = "SELECT * FROM users WHERE login_usr='".$row1['asig']."'";
$result10=mysql_query($sql10);
$row10=mysql_fetch_array($result10); 
$html.= $row10['nom_usr']." ".$row10['apa_usr']." ".$row10['ama_usr'];
$html.= '</strong></td>';
$html.= '		<td width="52" class="titulo2">Fecha: </td>
			<td width="101" class="tit_form"><strong>'.$row1['fecha_asig'].'</strong></td>
			<td width="42" class="titulo2"> Hora: </td>
			<td width="80" class="tit_form"><strong>'.$row1['hora_asig'].'</strong></td>
	  </tr>
	  <tr> 
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
		  </tr>
		</table>
		<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr> 
			<td width="205" class="titulo2">Fecha estimada de solucion: </td>
			<td width="157" class="tit_form"><strong>'.$row1['fechaestsol_asig'].'</strong></td>
			<td width="275">&nbsp;</td>
		  </tr>
		  <tr> 
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
		  </tr>
		</table>
		<table width="635" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr> 
			<td width="119" class="titulo2">Escalamiento a: </td>
			<td width="246" class="tit_form"><strong>'; 
			
$sql10 = "SELECT * FROM users WHERE login_usr='".$row1['escal']."'";
$result10=mysql_query($sql10);
$row10=mysql_fetch_array($result10); 
$html.= $row10['nom_usr']." ".$row10['apa_usr']." ".$row10['ama_usr'];
if ($row1['escal']=="0") {$html.= "Ninguno";}
$html.= '</strong></td>
			<td width="52" class="titulo2">Fecha: </td>
			<td width="98" class="tit_form"><strong>'.$row1['date_esc'].'</strong></td>
			<td width="42" class="titulo2"> Hora: </td>
			<td width="78" class="tit_form"><strong>'.$row1['time_esc'].'</strong></td>
		</tr>
		<tr> 
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
		</tr>
		</table>
		<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr> 
			<td width="205" class="titulo2">Fecha estimada de solucion: </td>
			<td width="157" class="tit_form"><strong>'.$row1['fechasol_esc'].'</strong></td>
			<td width="275">&nbsp;</td>
		</tr>
		<tr> 
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
		</tr>
		</table>
		
		<table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr> 
			<td width="106" class="titulo2">Registrado por: </td>
			<td width="327" class="tit_form"> &nbsp;&nbsp;Administrador de Mesa de Ayuda</td>
			<td width="46" class="titulo2">Firma:</td>
			<td width="159">&nbsp;</td>
		  </tr>
		  <tr> 
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
		  </tr>
		</table>';
}
$html.= '<table width="90%" border="0" align="center" cellpadding="0" cellspacing="2">';
$conta=1;
while ($row2=mysql_fetch_array($result2)) {
	if($conta==1) {
	$html.= '<tr align="justify">  
			<td height="20" class="titulo"> <u>Seguimiento:</u> </td> 
		</tr>
	</table>
	<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
		<tr align="center" bgcolor="#CCCCCC">
			<td width="6%" class="titulo2">Nro</td>
			<td width="23%" class="titulo2">Realizado por</td>
			<td width="9%" class="titulo2">Fecha de Realización</td>
			<td width="9%" class="titulo2">Estado</td>
			<td width="25%" class="titulo2">Observaciones</td>
			<td width="9%" class="titulo2">Fecha de Registro</td>
			<td width="9%" class="titulo2">Hora</td>
			<td width="10%" class="titulo2">Num Archivos Adjuntos</td>
		</tr>';
 }

$html.= '<tr align="center">
			<td class="tit_form">Seg<?php $html.= $conta;?></td>
			<td class="tit_form"><strong>';
      
$sql_se = "SELECT * FROM users WHERE login_usr='".$row2['login_usr']."'";
$result_se=mysql_query($sql_se);
$row_se=mysql_fetch_array($result_se); 
$html.= $row_se['nom_usr'].' '.$row_se['apa_usr'].' '.$row_se['ama_usr'];
$html.= '</strong></td>';
$html.= '		<td class="tit_form">'.$row2['fecha_rea'].'</td>
			<td class="tit_form">';
        	if ($row2['estado_seg']=="1")
				{$html.= "Cumplida en fecha";}
			if ($row2['estado_seg']=="2")
				{$html.= "Cumplida retrasada";}
			if ($row2['estado_seg']=="3")
				{$html.= "Pendiente en fecha";}
			if ($row2['estado_seg']=="4")
				{$html.= "Pendiente retrasada";}
			if ($row2['estado_seg']=="5")
				{$html.= "Desestimada";}
		
$html.= '  	</td>
			<td class="tit_form">&nbsp;';
$html.= $row2['obs_seg'];
$html.= '	   </td>
			<td class="tit_form">'.$row2['fecha_seg'].'</td>
			<td class="tit_form">'.$row2['hora_seg'].'</td>
			<td class="tit_form">';
				$vecarchivos = explode("|*|",$row2['archivos']);
				$arch2=count($vecarchivos);
				$cont = 0;
				for($i=0; $i<=$arch2;$i++){
					if(isset($vecarchivos[$i])) $cont++;	
				}
				if($cont <> 0){
					if($cont == 1)
						$html.= $cont." Archivo Adjunto";
					else 
						$html.= $cont." Archivos Adjuntos";
				}else{
					$html.= "Ninguno";
				}
$html.= '		</td></tr>';
$conta++; 
}  
$html.= '</table>';
if (isset($row3[0])){
	$html.= '<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
				<tr align="justify"> 
					<td class="titulo"><u>Detalles de la Solucion:</u></td>
				</tr>
			</table>
			<table width="636" border="1" align="center" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;">
				<tr>
					<td class=tit_form>'.$row3['detalles_sol'].'</td></tr>
			</table>
			<br>
			<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr> 
					<td width="200" class="titulo2">Fecha de EJECUCION DEsolucion: </td>
					<td width="138" align="center" class="tit_form"><strong>'.$row3['fecha_sol_e'].'</strong></td>
					<td  align="right" class="titulo2">&nbsp;</td>
				</tr>
				<tr> 
					<td height="2"></td>
					<td height="2" bgcolor="#000000"></td>
					<td height="2"></td>
				</tr>
				</table>
				<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr> 
					<td width="201" class="titulo2">Fecha de REGISTRO DE solucion: </td>
					<td width="137" align="center" class="tit_form"><strong>'.$row3['fecha_sol'].'</strong></td>
					<td width="125"  align="right" class="titulo2">Hora :</td>
					<td width="174" align="center" class="tit_form"><strong>'.$row3['hora_sol'].'</strong></td>
				  </tr>
				  <tr> 
					<td height="1"></td>
					<td height="1" bgcolor="#000000"></td>
					<td height="1"></td>
					<td height="1" bgcolor="#000000"></td>
				  </tr>
				</table>
				<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
				  <tr align="justify"> 
					<td height="15" class="titulo"><u>Medidas Preventivas Recomendadas</u></td>
				  </tr>
				</table>
				<table width="636" border="1" align="center" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;">
					<tr><td class=tit_form>'.$row3['medprev_sol'].'</td></tr>
				</table>';
}
$html.= '<br>';
if(isset($row4[0])){
	$html.= '<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
		  <tr align="justify"> 
			<td class="titulo"><u>Conformidad del Cliente</u></td>
		  </tr>
		</table>
		<br>
		<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr> 
			<td width="153" class="titulo2">Fecha de solucion: </td>
			<td width="163" align="center" class="tit_form"><strong>'.$row4['fecha_conf'].'</strong></td>
			<td width="160"  align="right" class="titulo2">Hora :</td>
			<td width="161" align="center" class="tit_form"><strong>'.$row4['hora_conf'].'</strong></td>
		  </tr>
		  <tr> 
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
		  </tr>
		  <tr> 
			<td width="153" class="titulo2">Tiempo de solucion: </td>
			<td width="163" align="center" class="tit_form"><strong>';
			if ($row4['tiemposol_conf']=="1") {$html.= "1 - Malo";}
			elseif ($row4['tiemposol_conf']=="2") {$html.= "2 - Bueno";}
			elseif ($row4['tiemposol_conf']=="3") {$html.= "3 - Excelente";}
			
			$html.= ' </strong></td>';
$html.= '		<td width="160"  align="right" class="titulo2">Calidad de atencion :</td>
			<td width="161" align="center" class="tit_form"><strong>';

			if ($row4['calidaten_conf']=="1") {$html.= "1 - Malo";}
			elseif ($row4['calidaten_conf']=="2") {$html.= "2 - Bueno";}
			elseif ($row4['calidaten_conf']=="3") {$html.= "3 - Excelente";}
			$html.= '</strong></td>
		  </tr>
		  <tr> 
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
			<td height="1"></td>
			<td height="1" bgcolor="#000000"></td>
		  </tr>
		</table>
		<br>
		<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
		  <tr align="justify"> 
			<td class="titulo"><u>Observaciones del Cliente</u></td>
		  </tr>
		</table>
		<table width="636" border="1" align="center" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;">
			<tr><td class=tit_form>'.$row4['obscli_conf'].'</td></tr>	
		</table>';
}
$html.= '<br>';
$conta=1;
while ($row5=mysql_fetch_array($result5)) {
	if($conta==1) {
		$html.= '<table width="90%" border="0" align="center" cellpadding="0" cellspacing="2" >
				<tr align="justify">  
					<td class="titulo"> <u>Costos del Servicio:</u> </td> 
				</tr>
			</table>
			<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" >
			  <tr align="center" bgcolor="#CCCCCC"> 
				<td width="5%"  class="titulo2" height="40">Nro</td>
				<td width="12%" class="titulo2" height="40">Responsable</td>
				<td width="39%" class="titulo2" height="40">Descripcion</td>
				<td width="6%" class="titulo2" height="40">Tiempo (Horas)</td>
				<td width="8%" class="titulo2" height="40">Costo x Hora</td>
				<td width="7%" class="titulo2" height="40">Subtotal</td>
				<td width="10%" class="titulo2" height="40">Costo x Hora Hombre</td>
				<td width="13%" class="titulo2" height="40">Costo Hora Hombre x Tiempo Servicio</td>
			  </tr>';
	}
	$sConsulta = "SELECT * FROM users where login_usr='$row5[responsable]'";
	$sRes = mysql_query($sConsulta);
	$sReg=mysql_fetch_array($sRes);
	$costo_tiempo = $sReg['costo_usr'] * $row5['tiemph_cos'];
	$costo_total = $costo_total + $costo_tiempo;

	$html.= ' <tr align="center"> 
			<td class="tit_form">Seg'.$conta.'</td>
			<td class="tit_form">'.$sReg['apa_usr'].' '.$sReg['ama_usr'].' '.$sReg['nom_usr'].'</td>
			<td class="tit_form">&nbsp;'.$row5['desc_cos'].'</td>
			<td class="tit_form">&nbsp;'.$row5['tiemph_cos'].'</td>
			<td class="tit_form" align="right">&nbsp;'.$row5['cosxh_cos'].'</td>
			<td align="right" class="tit_form">&nbsp;'.$row5['subtot_cos'].'</td>
			<td class="tit_form" align="right">&nbsp;'.$sReg['costo_usr'].'</td>
			<td align="right" class="tit_form">&nbsp;'.number_format($costo_tiempo,2).'</td>
		 </tr>';
	$conta++; 
}
if(isset($row6[0])){
	$html.= ' <tr> 
			<td colspan="4">&nbsp;</td>	    
			<td align="right" class="titulo2">Total Bs.</td>
			<td align="right" class="tit_form">'.$row6['total_cos'].'</td>
			<td>&nbsp;</td>
			<td align="right" class="tit_form">';
	if($costo_total <> 0)
		$html.= number_format($costo_total,2);
	$html.= '</td>
		</tr>
	</table>';
}

$html.= '<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
		<tr align="center"> 
			<td width="313" height="19"> <p class="titulo2"> &#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;<br>';
if ($row['login_usr']==""){$html.= "SISTEMA";}
else {$html.= $row['nom_usr']." ".$row['apa_usr']." ".$row['ama_usr'];}

$html.= '</p>
			</td>
			<td width="317" class="titulo2">&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;<br>
			VoBo
			</td>
		  </tr>
		   <tr>
			<td colspan="2"  class="titulo2" align="center"></td>
		  </tr>
		   <tr>
			<td colspan="2"  class="titulo2">&nbsp;</td>
		  </tr>
		</table>';
//$html.='</body></html>';
//echo $html;

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF("P", "mm", "A4", true, 'UTF-8', false);  
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Gestor F1');
$pdf->SetTitle('Orden de Trabajo');
$pdf->SetSubject('Orden de Trabajo_SUbject');
$pdf->SetKeywords('PDF, ordenes');


$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// monospace FONT
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//margenes
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//separador de paginas: AUTO
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//factor de escala de imagen
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//lenguajes
$pdf->setLanguageArray($l);
// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);
// add a page
$pdf->AddPage();

//$certificado = 'file://'.$_SERVER["DOCUMENT_ROOT"]."/gestor_demo/tcpdf/tcpdf.crt";
//$clave_privada = 'file://'.$_SERVER["DOCUMENT_ROOT"]."/gestor_demo/tcpdf/tcpdf.crt";
//$info = array('Name' => 'PDF','Location' => 'La Paz - BOLIVIA','Reason' => ' Gestor-F1',
//    'ContactInfo' => 'http://www.yanapti.com');
//$pdf->setSignature($certificado, $clave_privada, 'tcpdfdemo', '', 3, $info); 


$pdf->writeHTML($html, true, false, true, false, '');

//$pdf->lastPage();
//$numero_aleatorio=time()."-ZQT"; 
//$pdf->Rect(53,133,65,62,'FD','',array(210,210,210)); 
//$sello="Reporte PDF\n FIRMADO DIGITALMENTE\n ".'Documento autentico'."\n Fecha: ".date('d-m-Y')."\nHora: ".date('h:i:s'); 
//$sello.="\n Pulsa para comprobar firma"; 
//$pdf->Multicell (60, 0, utf8_encode($sello), 1, 'C', 1, 0, 55, 135, true, 0, false, true, 0, 'T',false);
//$pdf->SetFont('helvetica', '', 8); 
//$pdf->write1DBarcode($numero_aleatorio, 'C93', 55, 170, 60, 18, 0.4, array('border'=>true,'text'=>true,'stretchtext'=>0,'fitwidth'=>true), 'N'); 
//$pdf->setSignatureAppearance($x=53, $y=133, $w=65, $h=62);
//$pdf->SetXY(25,230);
//$pdf->Cell(0, 0, "Puedes comprobar la autencidad de este documento en: http://localhost/gestor_demo/".$numero_aleatorio.".pdf",'','','','','http://loscalhost/gestor_demo/'.$numero_aleatorio.'.pdf');


$pdf->Output("orden.pdf", 'I');
//echo $html;