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
<body>
  <div class="container">
    <?php include("datos_gral.php"); ?>
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
      <br>
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
      <br>
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
        <br>
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
      <br>
      <h6>Descripción de la Incidencia</h6>
      <div class="row">
        <div class="column">
          <p><?php echo $row['desc_inc']; ?></p>
        </div>
      </div>
      <?php if(isset($row1[0])){ ?>
        <br>
        <h6>Diagnóstico Inicial</h6>
        <div class="row">
          <div class="column">
            <p><?php echo $row1['diagnos']; ?></p>
          </div>
        </div>
        <?php
        $tmpComplejidad=array(1=>"1 - Baja", 2=>"2 - Media", 3=>"3 - Alta");
        $tmpPrioridad=array(3=>"3 - Baja", 2=>"2 - Media", 1=>"1 - Alta");
        ?>
        <div class="row">
          <div class="four columns"><strong>Nivel (1-3): </strong>
          <?php echo $tmpComplejidad[$row1['nivel_asig']];?></div>
          <div class="four columns"><strong>Criticidad (1-3): </strong>
          <?php echo $tmpPrioridad[$row1['criticidad_asig']];?></div>
          <div class="four columns"><strong>Prioridad (1-3): </strong>
          <?php echo $tmpPrioridad[$row1['prioridad_asig']];?></div>
        </div>
        <div class="row">
          <div class="six columns">
            <strong>Asignado a: </strong>
            <?php 
              $sql10 = "SELECT * FROM users WHERE login_usr='$row1[asig]'";
              $result10=mysql_db_query($db,$sql10,$link);
              $row10=mysql_fetch_array($result10); 
              echo $row10['nom_usr']." ".$row10['apa_usr']." ".$row10['ama_usr']
            ?>
          </div>
          <div class="three columns">
            <strong>Fecha: </strong><?php echo $row1['fecha_asig'];?>
          </div>
          <div class="three columns">
            <strong>Hora: </strong><?php echo $row1['hora_asig'];?>
          </div>
        </div>
        <div class="row">
          <div class="column">
            <strong>Fecha Estimada de Solución: </strong><?php echo $row1['fechaestsol_asig'];?>
          </div>
        </div>
        <div class="row">
          <div class="four columns">
            <strong>Escalamiento a:</strong>
            <?php 
              $sql10 = "SELECT * FROM users WHERE login_usr='$row1[escal]'";
              $result10=mysql_db_query($db,$sql10,$link);
              $row10=mysql_fetch_array($result10); 
              echo $row10['nom_usr']." ".$row10['apa_usr']." ".$row10['ama_usr'];
              if ($row1['escal']=="0") {echo "Ninguno";}
            ?>
          </div>
          <div class="four columns">
            <strong>Fecha: </strong><?php if ($row1['escal']=="0") {echo $row1['date_esc'];} ?>
          </div>
          <div class="four columns">
            <strong>Hora: </strong><?php if ($row1['escal']=="0") {echo $row1['time_esc'];} ?>
          </div>
        </div>
        <div class="row">
          <div class="column">
            <strong>Fecha Estimada de Solución: </strong><?php echo $row1['fechasol_esc'];?>
          </div>
        </div>
        <div class="row">
          <div class="six columns">
            <strong>Registrado por: </strong>Administrador de mesa de ayuda
          </div>
          <div class="six columns">
            <strong>Firma: </strong>
          </div>
        </div>
      <?php } ?>
      <br>
      <h6>Seguimiento</h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th>N.</th>
                <th>Realizado por</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Observaciones</th>
                <th>Fecha Reg</th>
                <th>Hora</th>
                <th>Adjuntos</th>
              </tr>
            </thead>
            <tbody>
              <?php $c=1; while ($row2=mysql_fetch_array($result2)) { ?>
              <tr>
                <td><?php echo $c;?></td>
                <td>
                  <?php 
                    $sql_se = "SELECT * FROM users WHERE login_usr='$row2[login_usr]'";
                    $result_se=mysql_db_query($db,$sql_se,$link);
                    $row_se=mysql_fetch_array($result_se); 
                    echo $row_se['nom_usr']." ".$row_se['apa_usr']." ".$row_se['ama_usr'];
                  ?>
                </td>
                <td><?php echo $row2['fecha_rea']; ?></td>
                <td>
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
                <td><?php echo $row2['obs_seg']; ?></td>
                <td><?php echo $row2['fecha_seg']; ?></td>
                <td><?php echo $row2['hora_seg'];?></td>
                <td>
                  <?php 
                    $vecarchivos = explode("|*|",$row2['archivos']);
                    $arch2=count($vecarchivos);
                    $cont = 0;
                    for($i=0;$i<$arch2;$i++)
                    {
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
              <?php $c++; } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <?php if (isset($row3[0])) { ?>
        <h6>Detalles de la Solución</h6>
        <div class="row">
          <div class="column">
            <?php echo $row3['detalles_sol']; ?>
          </div>
        </div>
        <div class="row">
          <div class="column">
            <strong>Fecha de Ejecución de Solución: </strong><?php echo $row3['fecha_sol_e']; ?>
          </div>
        </div>
        <div class="row">
          <div class="six columns">
            <strong>Fecha de Registro de Solución: </strong><?php echo $row3['fecha_sol']; ?>
          </div>
          <div class="six columns">
            <strong>Hora: </strong><?php echo $row3['hora_sol']; ?>
          </div>
        </div>
        <br>
        <h6>Medidas Preventivas Recomendadas</h6>
        <div class="row">
          <div class="column">
            <?php echo $row3['medprev_sol']; ?>
          </div>
        </div>
        <br>
      <?php } ?>
      <?php if(isset($row4[0])){ ?>
        <h6>Conformidad del Cliente</h6>
        <div class="row">
          <div class="six columns">
            <strong>Fecha de Solución: </strong><?php echo $row4['fecha_conf']; ?>
          </div>
          <div class="six columns">
            <strong>Hora: </strong><?php echo $row4['hora_conf'];?>
          </div>
        </div>
        <div class="row">
          <div class="six columns">
            <strong>Tiempo de Solución: </strong>
            <?php 
              if ($row4['tiemposol_conf']=="1") {echo "1 - Malo";}
              elseif ($row4['tiemposol_conf']=="2") {echo "2 - Bueno";}
              elseif ($row4['tiemposol_conf']=="3") {echo "3 - Excelente";}
            ?>
          </div>
          <div class="six columns">
            <strong>Calidad de Atención: </strong>
            <?php 
              if ($row4['calidaten_conf']=="1") {echo "1 - Malo";}
              elseif ($row4['calidaten_conf']=="2") {echo "2 - Bueno";}
              elseif ($row4['calidaten_conf']=="3") {echo "3 - Excelente";}
            ?>
          </div>
        </div>
        <br>
        <h6>Observaciones del Cliente</h6>
        <div class="row">
          <div class="column">
            <?php echo $row4['obscli_conf']; ?>
          </div>
        </div>
      <?php } ?>
      <?php if (mysql_num_rows($result5)) { ?>
        <br>
        <h6>Costos del Servicio</h6>
        <div class="row">
          <div class="column">
            <table class="u-full-width">
              <thead>
                <tr>
                  <th>N.</th>
                  <th>Responsable</th>
                  <th>Descripción</th>
                  <th>Tiempo (Hrs)</th>
                  <th>Costo x Hora</th>
                  <th>Subtotal</th>
                  <th>Costo Hrs/Hombre</th>
                  <th>Costo Hrs/Hombre x Tiempo</th>
                </tr>
              </thead>
              <tbody>
                <?php $c=1; while ($row5=mysql_fetch_array($result5)) { ?>
                  <tr>
                    <?php
                      $sConsulta = "SELECT * FROM users where login_usr='$row5[responsable]'";
                      $sRes = mysql_db_query($db,$sConsulta,$link);
                      $sReg=mysql_fetch_array($sRes);
                      $costo_tiempo = $sReg['costo_usr'] * $row5['tiemph_cos'];
                      $costo_total = isset($costo_total) + $costo_tiempo;
                    ?>
                    <td><?php echo $conta;?></td>
                    <td><?php echo $sReg['apa_usr']." ".$sReg['ama_usr']." ".$sReg['nom_usr']; ?></td>
                    <td><?php echo $row5['desc_cos']; ?></td>
                    <td><?php echo $row5['tiemph_cos']; ?></td>
                    <td><?php echo $row5['cosxh_cos']; ?></td>
                    <td><?php echo $row5['subtot_cos']; ?></td>
                    <td><?php echo $sReg['costo_usr'];?></td>
                    <td><?php echo number_format($costo_tiempo,2);?></td>
                  </tr>
                <?php $c++; } //end while ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php } //end if ?>
      <?php if(isset($row6[0])){ ?>
        <div class="row">
          <div class="six columns">
            <strong>Total Bs.: </strong><?php echo $row6['total_cos']; ?>
          </div>
          <div class="six columns">
            <strong>Tiempo total: </strong><?php if($costo_total <> 0)echo number_format($costo_total,2); ?>
          </div>
        </div>
      <?php } //end if ?>
      <br><br>
      <div class="row signature">
        <div class="two columns">&nbsp;</div>
        <div class="three columns center">
          <?php 
            if ($row['login_usr']==""){echo "SISTEMA";}
            else {echo $row['nom_usr']." ".$row['apa_usr']." ".$row['ama_usr'];}
          ?>
        </div>
        <div class="two columns">&nbsp;</div>
        <div class="three columns center">
          VoBo
        </div>
      </div>
    </div> <!-- end print-area -->
  </div>
</body>
</html>