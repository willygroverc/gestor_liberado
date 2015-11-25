<?php
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
$idadmy=($_GET['variable']);
$Tip=($_GET['Tipo']);
$sql="SELECT *,DATE_FORMAT(FechaAdAs,'%d / %m / %Y') as FechaAdAs FROM admyasegdatos WHERE IdAdmyAseg='$idadmy' AND Tipo='$Tip'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?>

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
        <h5>Proyectos - Lista de Administración y Aseguramiento</h5>
      </div>
      <br>
      <h6>Administración del Alcance</h6>
      <div class="row">
        <div class="column">
          <strong>Nombre del Proyecto: </strong><?php echo $row['NombProy']; ?>
        </div>
      </div>
      <div class="row">
        <div class="column">
          <strong>Nombre del Responsable: </strong>
          <?php
          $sql3="SELECT * FROM users WHERE login_usr='".$row['NombResp']."'";
          $result3=mysql_query($sql3);
          $row3=mysql_fetch_array($result3);
          echo $row3['nom_usr']." ".$row3['apa_usr']." ".$row3['ama_usr'];  
          ?>
        </div>
      </div>
      <?php 
      $sqlUsers="SELECT login_usr, nom_usr, apa_usr, ama_usr FROM users ORDER BY login_usr";
      $rsUsers=mysql_query($sqlUsers);
      while($tmpUsers=mysql_fetch_array($rsUsers)){
        $lstUsers[$tmpUsers['login_usr']]=$tmpUsers['nom_usr']." ".$tmpUsers['apa_usr']." ".$tmpUsers['ama_usr'];
      }
      if ($row['Tipo']=="ADMINISTRACION DE RECURSOS HUMANOS") { ?>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th rowspan="2">N.</th>
                <th rowspan="2">Actividad / Productos</th>
                <th rowspan="2">Responsables</th>
                <th rowspan="2">Cronogramas</th>
                <th colspan="3" class="center">Cumplimiento</th>
              </tr>
              <tr>
                <th class="center">Sí</th>
                <th class="center">No</th>
                <th class="center">Observaciones</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $sql6 = "SELECT * FROM admrhdet WHERE IdAdmyAseg='$idadmy' AND Tipo='$Tip'";
              $result6=mysql_query($sql6); 
              while ($row6=mysql_fetch_array($result6)) {
              ?>
              <tr>
                <td><?php echo $row6['num_det']; ?></td>
                <td><?php echo $row6['activprod'] ?></td>
                <td><?php echo $lstUsers[$row6['nombresp']]; ?></td>
                <td><?php echo $row6['cronograma']; ?></td>
                <td class="center">
                  <?php if (($row6['cumplimiento']=="SI")){
                    echo "&#10003;";
                  } else { echo "&nbsp;"; } ?>
                </td>
                <td class="center">
                  <?php if (($row6['cumplimiento']=="NO")){
                    echo "&#10003;";
                  } else { echo "&nbsp;"; } ?>
                </td>
                <td class="center"><?php echo $row6['observaciones']; ?></td>
              </tr>
              <?php } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php } //end if
      else { ?>
      <br>
      <h6>
        <?php if ($row['Tipo']=="ADMINISTRACION DEL ALCANCE"){echo "Alcance";}
        else {echo "Objetivos";} ?>
      </h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th>N.</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $sql2 = "SELECT * FROM admyasegalcance WHERE IdAdmyAseg='$idadmy' AND Tipo='$Tip'";
              $result2=mysql_query($sql2); 
              while ($row2=mysql_fetch_array($result2)) 
              { ?>
              <tr>
                <td><?php echo $row2['IdAlcance']; ?></td>
                <td><?php echo $row2['Alcance']; ?></td>
              </tr>
              <?php } // end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <h6>Actividades</h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th>N.</th>
                <th>Actividades</th>
                <th>Responsables</th>
                <th>
                  <?php if($row['Tipo']=="ADMINISTRACION DEL ALCANCE")
                  {echo "Seguimiento";}
                  if($row['Tipo']=="ADMINISTRACION DE LA COMUNICACION")
                  {echo "Seguimiento";}
                  if($row['Tipo']=="ASEGURAMIENTO DE LA CALIDAD")
                  {echo "Métricas";} ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php $sql3 = "SELECT * FROM admyasegactiv WHERE IdAdmyAseg='$idadmy' AND Tipo='$Tip'";
              $result3=mysql_query($sql3); 
              while ($row3=mysql_fetch_array($result3)){ ?>
              <tr>
                <td><?php echo $row3['IdActividad']; ?></td>
                <td><?php echo $row3['Actividad']; ?></td>
                <td>
                  <?php $sql5="SELECT * FROM users WHERE login_usr='".$row3['RespActividad']."'";
                  $result5=mysql_query($sql5);
                  $row5=mysql_fetch_array($result5);
                  echo @$row3['nom_usr']." ".@$row3['apa_usr']." ".@$row3['ama_usr'];
                  echo $row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr']; ?>
                </td>
                <td><?php echo $row3['Seguimiento']; ?></td>
              </tr>
              <?php } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php } //end else ?>
      <br><br>
      <div class="row">
        <div class="column">
          <strong>Documentación de Referencia: </strong><?php echo $row['DocuRef'];?>
        </div>
      </div>
      <div class="row">
        <div class="column">
          <strong>Documentación de Soporte: </strong><?php echo $row['DocuSoporte'];?>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="six columns">
          <strong>Firma: </strong>
        </div>
        <div class="six columns">
          <strong>Fecha: </strong>
        </div>
      </div>
      <br>
    </div> <!-- end print-area -->
  </div>
</body>
</html>