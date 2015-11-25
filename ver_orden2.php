<?php
include ("top_ver.php");
require_once('funciones.php');
$id_orden=SanitizeString($_REQUEST['id_orden']);
$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes,users WHERE id_orden='$id_orden' AND cod_usr=login_usr";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);

$sql1 = "SELECT *, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig FROM asignacion WHERE id_orden='$id_orden' ORDER BY id_asig DESC limit 1"; 
$result1=mysql_query($sql1);
$row1=mysql_fetch_array($result1);

$sql2 = "SELECT *, DATE_FORMAT(fecha_seg, '%d/%m/%Y') AS fecha_seg, DATE_FORMAT(fecha_rea, '%d/%m/%Y') AS fecha_rea FROM seguimiento WHERE id_orden='$id_orden'"; 
$result2=mysql_query($sql2);

$sql3 = "SELECT *, DATE_FORMAT(fecha_sol, '%d/%m/%Y') as fecha_sol, DATE_FORMAT(fecha_sol_e, '%d/%m/%Y') as fecha_sol_e FROM solucion WHERE id_orden='$id_orden'";
$result3=mysql_query($sql3);
$row3=mysql_fetch_array($result3);

$sql4 = "SELECT *, DATE_FORMAT(fecha_conf, '%d/%m/%Y') as fecha_conf FROM conformidad WHERE id_orden='$id_orden'"; 
$result4=mysql_query($sql4);
$row4=mysql_fetch_array($result4);

$sql5 = "SELECT * FROM costo WHERE id_orden='$id_orden'";
$result5=mysql_query($sql5);

$sql6 = "SELECT SUM(subtot_cos) AS total_cos FROM costo where id_orden='$id_orden'";
$result6=mysql_query($sql6);
$row6=mysql_fetch_array($result6); 

$sql8 = "SELECT * FROM titular WHERE ci_ruc='$row[ci_ruc]'";
$result8=mysql_query($sql8);
$row8=mysql_fetch_array($result8);
?>
<html>
<head>
<title>Orden de Trabajo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
        <div class="four columns">
          <strong>Fecha de Creación: </strong><?php echo $row['fecha']; ?>      
        </div>
        <div class="four columns">
          <strong>Hora de Creación: </strong><?php echo $row['time']; ?>        
        </div>
        <div class="four columns">
          <strong>N. </strong><?php echo $row['id_orden']; ?>       
        </div>
      </div>
      <br>
      <h6>Datos del Usuario</h6>
      <div class="row">
        <div class="eight columns">
          <strong>Registrado por: </strong>
          <?php 
            if ($row['login_usr']==""){echo "SISTEMA";}
            else {echo $row['nom_usr']." ".$row['apa_usr']." ".$row['ama_usr'];}
          ?>
        </div>
        <div class="four columns">
          <strong>Firma: </strong>
        </div>
      </div>
      <div class="row">
        <div class="eight columns">
          <strong>Asignado a: </strong>
          <?php 
            $sql7 = "SELECT * FROM users WHERE login_usr='$row1[asig]'";
            $result7=mysql_query($sql7);
            $row7=mysql_fetch_array($result7);
            echo $row7['nom_usr']." ".$row7['apa_usr']." ".$row7['ama_usr'];
          ?>
        </div>
        <div class="four columns">
          <strong>Firma: </strong>
        </div>
      </div>
      <br>
      <h6>Datos del Titular</h6>
      <div class="row">
        <div class="column">
          <strong>CI / RUC: </strong><?php echo $row['ci_ruc']; ?>
        </div>
      </div>
      <div class="row">
        <div class="eight columns">
          <strong>Nombre y Apellidos: </strong>
          <?php echo $row8['nombre']." ".$row8['apaterno']." ".$row8['amaterno']; if($row8['acasada']!=""){echo " de $row8[acasada]";} ?>
        </div>
        <div class="four columns">
          <strong>Firma: </strong>
        </div>
      </div>
      <div class="row">
        <div class="four columns">
          <strong>Email: </strong><?php echo $row8['email']; ?>
        </div>
        <div class="four columns">
          <strong>Dirección: </strong><?php echo $row8['direccion']; ?>
        </div>
        <div class="four columns">
          <strong>Teléfono: </strong><?php echo $row8['telf']; ?>
        </div>
      </div>
      <div class="row">
        <div class="four columns">
          <strong>Entidad: </strong><?php echo $row8['entidad']; ?>
        </div>
        <div class="four columns">
          <strong>Área: </strong><?php echo $row8['area']; ?>
        </div>
        <div class="four columns">
          <strong>Cargo: </strong><?php echo $row8['cargo']; ?>
        </div>
      </div>
      <br>
      <h6>Descripción de la Consulta</h6>
      <div class="row">
        <div class="column">
          <?php echo $row['desc_inc']; ?>
        </div>
      </div>
      <div class="row">
        <div class="column">
          <strong>Fecha Estimada de la Solución: </strong><?php echo $row1['fechaestsol_asig']; ?>
        </div>
      </div>
      <br>
      <h6>Seguimiento</h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <theader>
              <tr>
                <th>N.</th>
                <th>Realizado por</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Observaciones</th>
                <th>Fecha Reg.</th>
                <th>Hora</th>
              </tr>
            </theader>
            <tbody>
              <?php $c=1; while ($row2=mysql_fetch_array($result2)) { ?>
              <tr>
                <td><?php echo $c; ?></td>
                <td>
                  <?php 
                    $sql_se = "SELECT * FROM users WHERE login_usr='$row2[login_usr]'";
                    $result_se=mysql_query($sql_se);
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

