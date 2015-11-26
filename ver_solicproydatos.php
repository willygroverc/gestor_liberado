<?php
@session_start();
if (isset($_SESSION['login'])){
	if (isset($_SESSION['tipo']) && $_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}
include("top_ver.php");
require_once('funciones.php');
$codigo=SanitizeString($_GET['variable']);
$sql="SELECT *, DATE_FORMAT(FechSolic, '%d/%m/%Y') AS FechSolic, DATE_FORMAT(FechaPlanif, '%d/%m/%Y') AS FechaPlanif 
	 FROM solicproydatos WHERE Codigo='$codigo'";
$resul=mysql_query($sql);
$row=mysql_fetch_array($resul); 

$sql_pepe="SELECT nombre FROM control_parametros";
$res_hola=mysql_query($sql_pepe);
$row_martin=mysql_fetch_array($res_hola);
?>

<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - SOLICITUD DE PROYECTOS</title>
<link rel="stylesheet" href="css/skeleton.css">
<link rel="stylesheet" href="css/reports.css">
</head>
<body>
  <div class="container">
    <?php include("datos_gral.php"); ?>
    <div class="print-area">
      <div class="row center">
        <h5>Solicitud de Proyectos</h5>
      </div>
      <div class="row">
        <div class="four columns">
          <strong>Código de Solicitud: </strong><?php echo $row['Codigo']; ?>
        </div>
      </div>
      <div class="row">
        <div class="column">
          <strong>Requerimiento: </strong><?php echo $row['Requerimiento']; ?>
        </div>
      </div>
      <div class="row">
        <div class="six columns">
          <strong>Líder del Proyecto: </strong>
          <?php 
          $sql2="SELECT * FROM users WHERE login_usr='".$row['LiderProyecto']."'";
          $resul2=mysql_query($sql2);
          $row2=mysql_fetch_array($resul2);
          echo $row2['nom_usr']."&nbsp;".$row2['apa_usr']."&nbsp;".$row2['ama_usr']; 
          ?>
        </div>
        <div class="six columns">
          <strong>Líder del Proyecto US: </strong>
          <?php
          $sql3="SELECT * FROM users WHERE login_usr='$row[LiderProyUS]'";
          $resul3=mysql_query($sql3);
          $row3=mysql_fetch_array($resul3);
          echo $row3['nom_usr']."&nbsp;".$row3['apa_usr']."&nbsp;".$row3['ama_usr']; 
          ?>
        </div>
      </div>
      <div class="row">
        <div class="column">
          <strong>Descripción del Proyecto: </strong><?php echo $row['DescProyecto']; ?>
        </div>
      </div>
      <div class="row">
        <div class="column">
          <strong>Propósito del Proyecto: </strong><?php echo $row['PropProyecto']; ?>
        </div>
      </div>
      <div class="row">
        <div class="six columns">
          <strong>Fecha de Solicitud: </strong><?php echo $row['FechSolic']; ?>
        </div>
        <div class="six columns">
          <strong>Criticidad: </strong><?php echo $row['Criticidad']; ?>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th>Resposablilidad</th>
                <th>Nombre</th>
                <th>Fecha de Asignación</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $sql5 = "SELECT * FROM solicproyresponsab WHERE Codigo='$codigo'";
              $resul5 = mysql_query($sql5);
              while ($row5 = mysql_fetch_array($resul5)) { 
              ?>
              <tr>
                <td><?php echo $row5['Responsabilid']; ?></td>
                <?php 
                $sql4="SELECT * FROM users WHERE login_usr='$row5[Nombre]'";
                $resul4=mysql_query($sql4);
                $row4=mysql_fetch_array($resul4);
                ?>
                <td><?php echo $row4['nom_usr']."&nbsp;".$row4['apa_usr']."&nbsp;".$row4['ama_usr']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($row5['FechDesignac'])); ?></td>
              </tr>
              <?php } // end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <h6>Grupo para la Implementación del Proyecto</h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th>Especialidad del Proyecto</th>
                <th>Equipo Involucrado en el Proyecto</th>
                <th>Contraparte para Pruebas</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $consul1="SELECT * FROM solicproygrupoproy WHERE Codigo='$codigo'";
              $resultado1=mysql_query($consul1);
              while ($fila1=mysql_fetch_array($resultado1)) {
              ?>
              <tr>
                <td><?php echo $fila1['EspecialidProy']; ?></td>
                <?php
                $consul2="SELECT * FROM users WHERE login_usr='$fila1[InvolucProy]'";
                $resultado2=mysql_query($consul2);
                $fila2=mysql_fetch_array($resultado2);
                ?>
                <td><?php echo $fila2['nom_usr'].' '.$fila2['apa_usr'].' '.$fila2['ama_usr']; ?></td>
                <?php
                $consul3="SELECT * FROM users WHERE login_usr='".$fila1['ContraProy']."'";
                $resultado3=mysql_query($consul3);
                $fila3=mysql_fetch_array($resultado3);
                ?>
                <td><?php echo $fila3['nom_usr'].' '.$fila3['apa_usr'].' '.$fila3['ama_usr']; ?></td>
              </tr>
              <?php } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <h6>Fase de Planificación</h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th rowspan="2">N.</th>
                <th rowspan="2">Actividades</th>
                <th rowspan="2">Planificación (Análisis de Factibilidad)</th>
                <th colspan="3" class="center">Aprobación</th>
              </tr>
              <tr>
                <th class="center">Sí</th>
                <th class="center">No</th>
                <th class="center">Observaciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $cons="SELECT * FROM solicproyplanif WHERE Codigo='$codigo'";
              $result=mysql_query($cons);
              $ass=array();
              $i=1;
              while ($f1=mysql_fetch_array($result))
              { $ass[$f1['Responsabilid']]=$i;
              ?>
              <tr>
                <td><?php echo $ass[$f1['Responsabilid']]; ?></td>
                <?php $i++; ?>
                <td><?php echo $f1['Responsabilid']; ?></td>
                <td><?php echo $f1['Actividades']; ?></td>
                <td class="center">&nbsp;
                <?php if ($f1['Aprobacion']=="SI") {
                  echo "&#10003;";
                ?>
                </td>
                <td class="center">&nbsp;
                <?php } else {
                  echo "&#10003;";
                } ?>
                </td>
                <td class="center"><?php echo $f1['Observac']; ?></td>
              </tr>              
              <?php } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <h6>Fase de Ejecución</h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th rowspan="2">N.</th>
                <th rowspan="2">Resposabilidad</th>
                <th rowspan="2">Actividades Planificadas</th>
                <th colspan="3" class="center">Aprobación</th>
              </tr>
              <tr>
                <th class="center">Sí</th>
                <th class="center">No</th>
                <th class="center">Observaciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $cons1="SELECT * FROM solicproyejecucion WHERE Codigo='$codigo'";
              $result1=mysql_query($cons1);
              while ($f2=mysql_fetch_array($result1)) {
              ?>
              <tr>
                <td><?php echo isset($ass[$f2['Responsabilid']]); ?></td>
                <td><?php echo $f2['Responsabilid']; ?></td>
                <td><?php echo $f2['Actividades']; ?></td>
                <td class="center">&nbsp;
                <?php if ($f2['Aprobacion']=="SI") {
                  echo "&#10003;";
                ?>
                </td>
                <td class="center">&nbsp;
                <?php } else {
                  echo "&#10003;";
                } ?>
                </td>
                <td class="center"><?php echo $f2['Observac']; ?></td>
              </tr>              
              <?php } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <h6>Fase de Control</h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th rowspan="2">N.</th>
                <th rowspan="2">Resposabilidad</th>
                <th rowspan="2">Actividades Planificadas</th>
                <th colspan="3" class="center">Aprobación</th>
              </tr>
              <tr>
                <th class="center">Sí</th>
                <th class="center">No</th>
                <th class="center">Observaciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $cons2="SELECT * FROM solicproycontrol WHERE Codigo='$codigo'";
              $result2=mysql_query($cons2);
              while ($f3=mysql_fetch_array($result2)) {
              ?>
              <tr>
                <td><?php echo isset($ass[$f3['Responsabilid']]); ?></td>
                <td><?php echo $f3['Responsabilid']; ?></td>
                <td><?php echo $f3['Actividades']; ?></td>
                <td class="center">&nbsp;
                <?php if ($f3['Aprobacion']=="SI") {
                  echo "&#10003;";
                ?>
                </td>
                <td class="center">&nbsp;
                <?php } else {
                  echo "&#10003;";
                } ?>
                </td>
                <td class="center"><?php echo $f3['Observac']; ?></td>
              </tr>              
              <?php } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <h6>Fase de Cierre</h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th rowspan="2">N.</th>
                <th rowspan="2">Resposabilidad</th>
                <th rowspan="2">Actividades Planificadas</th>
                <th colspan="3" class="center">Aprobación</th>
              </tr>
              <tr>
                <th class="center">Sí</th>
                <th class="center">No</th>
                <th class="center">Observaciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $cons3="SELECT * FROM solicproycontrol WHERE Codigo='$codigo'";
              $result3=mysql_query($cons3);
              while ($f4=mysql_fetch_array($result3)) {
              ?>
              <tr>
                <td><?php echo isset($ass[$f4['Responsabilid']]); ?></td>
                <td><?php echo $f4['Responsabilid']; ?></td>
                <td><?php echo $f4['Actividades']; ?></td>
                <td class="center">&nbsp;
                <?php if ($f4['Aprobacion']=="SI") {
                  echo "&#10003;";
                ?>
                </td>
                <td class="center">&nbsp;
                <?php } else {
                  echo "&#10003;";
                } ?>
                </td>
                <td class="center"><?php echo $f4['Observac']; ?></td>
              </tr>              
              <?php } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="six columns">
          <strong>Aprobación: </strong>
          <?php 
          $sq2="SELECT * FROM users WHERE login_usr='".$row['NombAprob']."'";
          $resu2=mysql_query($sq2);
          $ro2=mysql_fetch_array($resu2);
          echo $ro2['nom_usr']."&nbsp;".$ro2['apa_usr']."&nbsp;".$ro2['ama_usr']; ?>
        </div>
        <div class="six columns">
          <strong>Fecha: </strong>
          <?php if($row['FechaPlanif']!="00/00/0000") echo $row['FechaPlanif']; ?>
        </div>
      </div>
      <div class="row">
        <div class="six columns">
          <strong>Comisión de Sistemas: </strong>
          <?php 
          $sq3="SELECT * FROM users WHERE login_usr='$row[NombComisSist]'";
          $resu3=mysql_query($sq3);
          $ro3=mysql_fetch_array($resu3);
          echo $ro3['nom_usr']."&nbsp;".$ro3['apa_usr']."&nbsp;".$ro3['ama_usr']; ?>
        </div>
      </div>
    </div> <!-- end print-area -->
  </div>
</body>
</html>