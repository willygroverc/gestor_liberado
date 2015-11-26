<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		23/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}
include("top_ver.php");
$idana=($_GET['variable']);
$sql="SELECT *,DATE_FORMAT(FechaAnalisis,'%d / %m / %Y') as FechaAnalisis FROM analisisriesgdatos WHERE IdAnalisis='$idana'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - PROYECTOS</title>
<link rel="stylesheet" href="css/skeleton.css">
<link rel="stylesheet" href="css/reports.css">
</head>
<body>
  <div class="container">
    <?php include("datos_gral.php"); ?>
    <div class="print-area">
      <div class="row center">
        <h5>Proyectos: Análisis de Riesgos</h5>
      </div>
      <div class="row">
        <div class="six columns">
          <strong>Nombre del Proyecto: </strong><?php echo $row['NombProy']; ?>
        </div>
        <div class="six columns">
          <strong>Nombre del Responsable: </strong>
          <?php
          $sql3="SELECT * FROM users WHERE login_usr='$row[NombResp]'";
          $result3=mysql_query($sql3);
          $row3=mysql_fetch_array($result3);
          echo $row3['nom_usr']."&nbsp;".$row3['apa_usr']."&nbsp;".$row3['ama_usr'];
          ?>
        </div>
      </div>
      <div class="row">
        <div class="six columns">
          <strong>Fecha de Análisis: </strong><?php echo $row['FechaAnalisis']; ?>
        </div>
        <div class="six columns">
          <strong>Documentación de Referencia: </strong><?php echo $row['DocuRef']; ?>
        </div>
      </div>
      <div class="row">
        <div class="column">
          <strong>Descripción del Impacto: </strong><?php echo $row['DescImpacto']; ?>
        </div>
      </div>
      <div class="row">
        <div class="column">
          <strong>Acciones Preventivas Recomendadas: </strong><?php echo $row['AccionPrev']; ?>
        </div>
      </div>
      <div class="row">
        <div class="column">
          <strong>Acciones de Contingencia Recomendadas: </strong><?php echo $row['AccionConting']; ?>
        </div>
      </div>
      <div class="row">
        <div class="column">
          <strong>Documentación de Soporte: </strong><?php echo $row['DocuSoporte']; ?>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th>N.</th>
                <th>Descripción del Riesgo</th>
                <th>Prob.</th>
                <th>Impacto</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql2="SELECT * FROM analisisriesgdesc WHERE IdAnalisis='".$row['IdAnalisis']."'";
              $result2=mysql_query($sql2);
              while($row2=mysql_fetch_array($result2))
              { ?>            
              <tr>
                <td><?php echo $row2['IdDescripcion']; ?></td>
                <td><?php echo $row2['Descripcion']; ?></td>
                <td><?php echo $row2['Probabilidad']; ?></td>
                <td><?php echo $row2['Impacto']; ?></td>
              </tr>
              <?php } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
    </div> <!-- end print-area -->
  </div>
</body>
</html>