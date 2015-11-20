<?php 
include ("top_ver.php");
//header('Content-Type: text/html; charset=iso-8859-1');
header('Content-Type: text/html; charset=UTF-8');
require_once('funciones.php');
$id_orden=SanitizeString($_REQUEST['id_orden']);
require_once('class.ezpdf.php');
$pdf =& new Cezpdf('a4');
$pdf->selectFont('fonts/Courier-Bold.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);

$pdf->ezText(isset($txttit), 12);

$sql = "SELECT *,DATE_FORMAT(fecha,'%d / %m / %Y') as fecha FROM ordenes,users WHERE id_orden='$id_orden' AND cod_usr=login_usr";

$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);

$sql0 = "SELECT * FROM titular WHERE ci_ruc='$row[ci_ruc]'";
$result0=mysql_db_query($db,$sql0,$link);
$row0=mysql_fetch_array($result0);
//no existe el campo date_esc en la tabla de la bdd del gestor
//$sql1 = "SELECT *, DATE_FORMAT(fecha_asig,'%d / %m / %Y') as fecha_asig,DATE_FORMAT(fechaestsol_asig,'%d / %m / %Y') as fechaestsol_asig,".
//		"DATE_FORMAT(date_esc,'%d / %m / %Y') as date_esc,DATE_FORMAT(fechasol_esc,'%d / %m / %Y') as fechasol_esc FROM asignacion WHERE id_orden='$id_orden' ORDER BY id_asig DESC limit 1";
$sql1="SELECT *, DATE_FORMAT(fecha_asig,'%d / %m / %Y') as fecha_asig,DATE_FORMAT(fechaestsol_asig,'%d / %m / %Y') as fechaestsol_asig,DATE_FORMAT(fechasol_esc,'%d / %m / %Y') as fechasol_esc FROM asignacion WHERE id_orden='$id_orden' ORDER BY id_asig DESC limit 1";
$result1=mysql_db_query($db,$sql1,$link);
$row1=mysql_fetch_array($result1);

$sql2 = "SELECT *,DATE_FORMAT(fecha_seg,'%d/%m/%Y') as fecha_seg, DATE_FORMAT(fecha_rea, '%d/%m/%Y') AS fecha_rea FROM seguimiento WHERE id_orden='$id_orden'";
$result2=mysql_db_query($db,$sql2,$link);

$sql3 = "SELECT *,DATE_FORMAT(fecha_sol,'%d / %m / %Y') as fecha_sol, DATE_FORMAT(fecha_sol_e,'%d / %m / %Y') as fecha_sol_e FROM solucion WHERE id_orden='$id_orden'";
$result3=mysql_db_query($db,$sql3,$link);
$row3=mysql_fetch_array($result3);

$sql4 = "SELECT *,DATE_FORMAT(fecha_conf,'%d / %m / %Y') as fecha_conf FROM conformidad WHERE id_orden='$id_orden'";
$result4=mysql_db_query($db,$sql4,$link);
$row4=mysql_fetch_array($result4);

$sql5 = "SELECT * FROM costo WHERE id_orden='$id_orden'";
$result5=mysql_db_query($db,$sql5,$link);

$sql6 = "SELECT SUM(subtot_cos) AS total_cos FROM costo where id_orden='$id_orden'";
$result6=mysql_db_query($db,$sql6,$link);
$row6=mysql_fetch_array($result6); 

?>
<html>
<head>
<title>Orden de Trabajo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="general.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/skeleton.css">
<link rel="stylesheet" type="text/css" href="css/reports.css">
</head>

<body bgcolor="#FFFFFF">
  <div class="container">
    <p><?php
    include("datos_gral.php");
    ?>
    <div class="print-area">
      <div class="row center">
        <h5>Orden de Trabajo</h5>
      </div>
      <div class="row">
        <div class="three columns">
          <strong>Fecha: </strong><?php echo $row['fecha'];?>
        </div>
        <div class="two columns">
          <strong>Hora: </strong><?php echo $row['time'];?>
        </div>
        <div class="seven columns right">
          <strong>N: </strong><span class="r-box"><?php echo $row['id_orden'];?></span>
        </div>
      </div>
      <div class="row">
        <div class="one columns">
          <strong>Cliente: </strong>
        </div>
        <div class="two columns">
          Interno <?php if($row['tipo_usr']=="INTERNO"){ echo "&#x2713;";} ?>
        </div>
        <div class="two columns">
          Externo <?php if($row['tipo_usr']=="EXTERNO"){ echo "&#x2713;";} ?>
        </div>
      </div>
      <hr>
      <h6>Datos del Cliente</h6>
      <div class="row">
        <div class="column">
          <strong>Nombres y Apellidos: </strong>
          <?php 
          if ($row['login_usr']==""){echo "SISTEMA";}
          else {echo $row['nom_usr']." ".$row['apa_usr']." ".$row['ama_usr'];}
          ?>
        </div>
      </div>
      <div class="row">
        <div class="four columns">
          <strong>Entidad: </strong><?php echo $row['enti_usr'];?>          
        </div>
        <div class="four columns">
          <strong>Área: </strong><?php echo $row['area_usr'];?>          
        </div>
      </div>
      <div class="row">
        <div class="four columns">
          <strong>Cargo: </strong><?php echo $row['cargo_usr'];?>
        </div>
        <div class="four columns">
          <strong>Teléfono: </strong><?php echo $row['telf_usr'];?>
        </div>
        <div class="four columns">
          <strong>Ext: </strong><?php echo $row['ext_usr'];?>
        </div>
      </div>
      <hr>
      <h6>Ubicación Física</h6>
      <div class="row">
        <div class="four columns">
          <strong>Ciudad: </strong><?php echo $row['ciu_usr'];?>
        </div>
        <div class="eight columns">
          <strong>Dirección: </strong><?php echo $row['direc_usr'];?>
        </div>
      </div>
      <?php if(isset($row0[0])){ ?>
        <hr>
        <h6>Datos del Titular</h6>
        <div class="row">
          <div class="four columns">
            <strong>CI/RUC: </strong><?php echo $row0['ci_ruc'];?>
          </div>
          <div class="eight columns">
            <strong>Nombres y Apellidos: </strong>
            <?php echo $row0['nombre'] ." ".$row0['apaterno']." ".$row0['amaterno']; if($row0['acasada']!=""){echo " de $row0[acasada]";}?>
          </div>
        </div>
        <div class="row">
          <div class="four columns">
            <strong>Email: </strong><?php echo $row0['email'];?>
          </div>
          <div class="four columns">
            <strong>Dirección: </strong><?php echo $row0['direccion'];?>
          </div>
          <div class="four columns">
            <strong>Teléfono: </strong><?php echo $row0['telf'];?>
          </div>
        </div>
        <div class="row">
          <div class="four columns">
            <strong>Entidad: </strong><?php echo $row0['entidad'];?>
          </div>
          <div class="four columns">
            <strong>Área: </strong><?php echo $row0['area'];?>
          </div>
          <div class="four columns">
            <strong>Cargo: </strong><?php echo $row0['cargo'];?>
          </div>
        </div>
      <?php } ?>
      <hr>
      <h6>Descripción de la Incidencia</h6>
      <div class="row">
        <div class="column">
          <p><?php echo $row['desc_inc']; ?></p>
        </div>
      </div>
    </div> <!-- end print-area -->





<br>

<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr> 
    <td>
      <div align="justify"><p class="titulo"><u>Descripcion de la Incidencia:</u></p></div>
    </td>
  </tr>
</table>
<table width="636" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
<?php 
echo "<tr><td class=tit_form>".$row['desc_inc']."</td></tr>";
/*	$carac=strlen($row[desc_inc]);
	$co=0;
do {
	echo "<tr><td><font face=\"Courier New, Courier, mono\">&nbsp;".substr($row[desc_inc], $co, 62). "</font></td></tr>";	
    $carac=$carac-62;  
    $co=$co+62;
} while ($carac>0); */ ?>
</table>
<!--table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="61" class="titulo2">Area:</td>
    <td width="140" class="tit_form">Area 1:  
      <?php 
	/*if ($row[tipo]=="L")
		{
		echo "<img src=\"images/si1.gif\" border=\"1\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\" border=\"1\">";
		}*/
	?>
    </td>
    <td width="118" class="tit_form">Area 2:  
      <?php 
	/*if ($row[tipo]=="F")
		{
		echo "<img src=\"images/si1.gif\" border=\"1\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\" border=\"1\">";
		}*/
	?>
    </td>
    <td width="137" class="tit_form">Area 3:  
      <?php 
	/*if ($row[tipo]=="N")
		{
		echo "<img src=\"images/si1.gif\" border=\"1\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\" border=\"1\">";
		}*/
	?>
    </td>
    <td width="37" class="tit_form">Otro:</td>
    <td width="145"> <strong> 
      <?php 
	/*if ($row[tipo]!="L" && $row[tipo]!="F" && $row[tipo]!="N")
		{
		echo $row[tipo];
		}*/
	?>
      </strong></td>
  </tr>
  <tr> 
    <td height="1" colspan="4"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table-->
<?php if(isset($row1[0])){ ?>
<p><table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr align="justify"> 
    <td><u class="titulo">Diagnostico Inicial :</u></td>
  </tr>
</table>
<table width="636" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
<?php 
echo "<tr><td class=tit_form>".$row1['diagnos']."</td></tr>";
/*	$carac=strlen($row1[diagnos]);
	$co=0;
do {
	echo "<tr><td><font face=\"Courier New, Courier, mono\">&nbsp;".substr($row1[diagnos], $co, 62). "</font></td></tr>";	
    $carac=$carac-62;  
    $co=$co+62;
} while ($carac>0);  */
$tmpComplejidad=array(1=>"1 - Baja", 2=>"2 - Media", 3=>"3 - Alta");
$tmpPrioridad=array(3=>"3 - Baja", 2=>"2 - Media", 1=>"1 - Alta");
?>
</table>
<br>
<table width="635" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="86" class="titulo2">Nivel (1-3): </td>
    <td width="86" class="tit_form"><strong><?php echo $tmpComplejidad[$row1['nivel_asig']];?></strong></td>
    <td width="119" class="titulo2">Criticidad (1-3): </td>
    <td width="111" class="tit_form"><strong><?php echo $tmpPrioridad[$row1['criticidad_asig']];?></strong></td>
    <td width="111" class="titulo2">Prioridad (1-3): </td>
    <td width="122" class="tit_form"><strong><?php echo $tmpPrioridad[$row1['prioridad_asig']];?></strong></td>
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
    <td width="274" class="tit_form"><strong> 
      <?php 
	$sql10 = "SELECT * FROM users WHERE login_usr='$row1[asig]'";
	$result10=mysql_db_query($db,$sql10,$link);
	$row10=mysql_fetch_array($result10); 
	echo $row10['nom_usr']." ".$row10['apa_usr']." ".$row10['ama_usr'];?>
      </strong></td>
    <td width="52" class="titulo2">Fecha: </td>
    <td width="101" class="tit_form"><strong><?php echo $row1['fecha_asig'];?></strong></td>
    <td width="42" class="titulo2"> Hora: </td>
    <td width="80" class="tit_form"><strong><?php echo $row1['hora_asig'];?></strong></td>
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
    <td width="157" class="tit_form"><strong><?php echo $row1['fechaestsol_asig'];?></strong></td>
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
    <td width="246" class="tit_form"><strong> 
      <?php 
	$sql10 = "SELECT * FROM users WHERE login_usr='$row1[escal]'";
	$result10=mysql_db_query($db,$sql10,$link);
	$row10=mysql_fetch_array($result10); 
	echo $row10['nom_usr']." ".$row10['apa_usr']." ".$row10['ama_usr'];
	if ($row1['escal']=="0") {echo "Ninguno";}?>
      </strong></td>
    <td width="52" class="titulo2">Fecha: </td>
    <td width="98" class="tit_form"><strong><?php echo $row1['date_esc'];?></strong></td>
    <td width="42" class="titulo2"> Hora: </td>
    <td width="78" class="tit_form"><strong><?php echo $row1['time_esc'];?></strong></td>
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
    <td width="157" class="tit_form"><strong><?php echo $row1['fechasol_esc'];?></strong></td>
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
</table>
<?php } ?>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="2">
<?php 
    $conta=1;
	while ($row2=mysql_fetch_array($result2)) {
		if($conta==1) {
?>
  <tr align="justify">  
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
  </tr>
  <?php 
	}
	?>
  <tr align="center">
    <td class="tit_form">Seg<?php echo $conta;?></td>
    <td class="tit_form"><strong>
      <?php 
	$sql_se = "SELECT * FROM users WHERE login_usr='$row2[login_usr]'";
	$result_se=mysql_db_query($db,$sql_se,$link);
	$row_se=mysql_fetch_array($result_se); 
	echo $row_se['nom_usr']." ".$row_se['apa_usr']." ".$row_se['ama_usr'];?>
    </strong></td>
    <td class="tit_form"><?php echo $row2['fecha_rea'];?></td>
    <td class="tit_form"><?php //echo $row2[estado_seg];?>
        <?php 
			if ($row2['estado_seg']=="1")
			{echo "Cumplida en fecha";}
			if ($row2['estado_seg']=="2")
			{echo "Cumplida retrasada";}
			if ($row2['estado_seg']=="3")
			{echo "Pendiente en fecha";}
			if ($row2['estado_seg']=="4")
			{echo "Pendiente retrasada";}
			if ($row2['estado_seg']=="5")
			{echo "Desestimada";}
		 ?>
    </td>
    <td class="tit_form">&nbsp;
        <?php 
			//echo "<p align='justify'>".$row2[obs_seg]."</p>"; 
			echo $row2['obs_seg'];			
		?>
    </td>
    <td class="tit_form"><?php echo $row2['fecha_seg'];?></td>
    <td class="tit_form"><?php echo $row2['hora_seg'];?></td>
	<td class="tit_form">
		<?php 
			$vecarchivos = explode("|*|",$row2['archivos']);
			$arch2=count($vecarchivos);
			//echo $arch2;//1
                        $cont = 0;
			for($i=0;$i<$arch2;$i++)
			{
                            //$cont++;
                            //echo $vecarchivos[$i];
                             if($vecarchivos[$i]<>""){ $cont++;}	
			}
			if($cont <> 0)
			{
				if($cont == 1)echo $cont." Archivo Adjunto";
				else echo $cont." Archivos Adjuntos";
			}else{
				echo "Ninguno";
			}
		?>
	</td>
  </tr>
  <?php $conta++; 
}  
?>
</table>
<?php if (isset($row3[0])) { ?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr align="justify"> 
    <td class="titulo"><u>Detalles de la Solucion:</u></td>
  </tr>
</table>
<table width="636" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
  <?php 
echo "<tr><td class=tit_form>".$row3['detalles_sol']."</td></tr>";
/*	$carac=strlen($row3[detalles_sol]);
	$co=0;
do {
	echo "<tr><td><font face=\"Courier New, Courier, mono\">&nbsp;".substr($row3[detalles_sol], $co, 62). "</font></td></tr>";	
    $carac=$carac-62;  
    $co=$co+62;
} while ($carac>0);  */?>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="200" class="titulo2">Fecha de EJECUCION DEsolucion: </td>
    <td width="138" align="center" class="tit_form"><strong><?php echo $row3['fecha_sol_e'];?></strong></td>
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
    <td width="137" align="center" class="tit_form"><strong><?php echo $row3['fecha_sol'];?></strong></td>
    <td width="125"  align="right" class="titulo2">Hora :</td>
    <td width="174" align="center" class="tit_form"><strong><?php echo $row3['hora_sol'];?></strong></td>
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
<table width="636" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
  <?php 
echo "<tr><td class=tit_form>".$row3['medprev_sol']."</td></tr>";	
/*	$carac=strlen($row3[medprev_sol]);
	$co=0;
do {
	echo "<tr><td><font face=\"Courier New, Courier, mono\">&nbsp;".substr($row3[medprev_sol], $co, 62). "</font></td></tr>";	
    $carac=$carac-62;  
    $co=$co+62;
} while ($carac>0);  */?>
</table>
<?php  } ?>

<br>
<?php if(isset($row4[0])){ ?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr align="justify"> 
    <td class="titulo"><u>Conformidad del Cliente</u></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="153" class="titulo2">Fecha de solucion: </td>
    <td width="163" align="center" class="tit_form"><strong><?php echo $row4['fecha_conf'];?></strong></td>
    <td width="160"  align="right" class="titulo2">Hora :</td>
	<td width="161" align="center" class="tit_form"><strong><?php echo $row4['hora_conf'];?></strong></td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>

  <tr> 
    <td width="153" class="titulo2">Tiempo de solucion: </td>
    <td width="163" align="center" class="tit_form"><strong> 
      <?php 
	if ($row4['tiemposol_conf']=="1") {echo "1 - Malo";}
	elseif ($row4['tiemposol_conf']=="2") {echo "2 - Bueno";}
	elseif ($row4['tiemposol_conf']=="3") {echo "3 - Excelente";}
	?>
      </strong></td>
    <td width="160"  align="right" class="titulo2">Calidad de atencion :</td>
	<td width="161" align="center" class="tit_form"><strong> 
      <?php 
	if ($row4['calidaten_conf']=="1") {echo "1 - Malo";}
	elseif ($row4['calidaten_conf']=="2") {echo "2 - Bueno";}
	elseif ($row4['calidaten_conf']=="3") {echo "3 - Excelente";}
	?>
      </strong></td>
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
<table width="636" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
<?php 
echo "<tr><td class=tit_form>".$row4['obscli_conf']."</td></tr>";
/*	$carac=strlen($row4[obscli_conf]);
	$co=0;
do {
	echo "<tr><td><font face=\"Courier New, Courier, mono\">&nbsp;".substr($row4[obscli_conf], $co, 62). "</font></td></tr>";	
    $carac=$carac-62;  
    $co=$co+62;
} while ($carac>0); */?>
</table>
<?php  } ?>
<br>
<?php 
    $conta=1;
	while ($row5=mysql_fetch_array($result5)) {
			if($conta==1) {		?>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="2" >
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
  </tr>
  <?php } ?>
    <?php
		$sConsulta = "SELECT * FROM users where login_usr='$row5[responsable]'";
		$sRes = mysql_db_query($db,$sConsulta,$link);
		$sReg=mysql_fetch_array($sRes);
		$costo_tiempo = $sReg['costo_usr'] * $row5['tiemph_cos'];
		
                $costo_total = isset($costo_total) + $costo_tiempo;
	?>  
	 <tr align="center"> 
        <td class="tit_form">Seg<?php echo $conta;?></td>
		<td class="tit_form"><?php echo $sReg['apa_usr']." ".$sReg['ama_usr']." ".$sReg['nom_usr'] ?></td>
	    <td class="tit_form">&nbsp;<?php echo $row5['desc_cos'];?></td>
        <td class="tit_form">&nbsp;<?php echo $row5['tiemph_cos'];?></td>
	    <td class="tit_form" align="right">&nbsp;<?php echo $row5['cosxh_cos'];?></td>
        <td align="right" class="tit_form">&nbsp;<?php echo $row5['subtot_cos'];?></td>
	    <td class="tit_form" align="right">&nbsp;<?php echo $sReg['costo_usr'];?></td>
        <td align="right" class="tit_form">&nbsp;<?php echo number_format($costo_tiempo,2);?></td>
	 </tr>
<?php $conta++; } ?>
<?php if(isset($row6[0])){ ?>
	 <tr> 
    	<td colspan="4">&nbsp;</td>
	    
    <td align="right" class="titulo2">Total 
      Bs.</td>
    	
    <td align="right" class="tit_form"><?php echo $row6['total_cos'];?></td>
	<td>&nbsp;</td>
	<td align="right" class="tit_form"><?php if($costo_total <> 0)echo number_format($costo_total,2);?></td>
	
	 </tr>

</table>
<?php }?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr align="center"> 
    <td width="313" height="19"> <p class="titulo2"> &#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;<br>
        <?php 
	if ($row['login_usr']==""){echo "SISTEMA";}
	else {echo $row['nom_usr']." ".$row['apa_usr']." ".$row['ama_usr'];}
	?>
      </p>
    </td>
    <td width="317" class="titulo2">&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;<br>
	<?php /*
	$sql10 = "SELECT * FROM users WHERE login_usr='$row1[asig]'";
	$result10=mysql_db_query($db,$sql10,$link);
	$row10=mysql_fetch_array($result10);
	if ($row[nom_usr]." ".$row[apa_usr]." ".$row[ama_usr] != $row10[nom_usr]." ".$row10[apa_usr]." ".$row10[ama_usr])
	echo $row10[nom_usr]." ".$row10[apa_usr]." ".$row10[ama_usr];*/?>VoBo
    </td>
  </tr>
   <tr>
    <td colspan="2"  class="titulo2" align="center"><?php /*if ($row[nom_usr]." ".$row[apa_usr]." ".$row[ama_usr] != $row10[nom_usr]." ".$row10[apa_usr]." ".$row10[ama_usr])
	echo $row10[nom_usr]." ".$row10[apa_usr]." ".$row10[ama_usr];*/?></td>
  </tr>
   <tr>
    <td colspan="2"  class="titulo2">&nbsp;</td>
  </tr>
</table>
  </div>
</body>
</html>