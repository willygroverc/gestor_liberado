<?php include ("top_ver.php");?>
<html>
<head>
<title> GesTor F1 - FICHA TECNICA</title>
<link rel="stylesheet" href="css/skeleton.css">
<link rel="stylesheet" href="css/reports.css">
</head>
<body>
  <div class="container">
    <?php include("datos_gral.php"); ?>
    <div class="print-area">
      <div class="row center">
        <h5>Titulares</h5>
      </div>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th>CI / RUC</th>
                <th>Nombres</th>
                <th>Ap. Paterno</th>
                <th>Ap. Materno</th>
                <th>Ap. de Casada</th>
                <th>Email</th>
                <th>Entidad</th>
                <th>Área</th>
                <th>Cargo</th>
                <th>Teléfono</th>
                <th>Fax</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM titular ORDER BY ci_ruc ASC";
              $result = mysql_db_query($db,$sql,$link); 
              while ($row = mysql_fetch_array($result)) {
              ?>
              <tr>
                <td><?php echo $row['ci_ruc']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['apaterno']; ?></td>
                <td><?php echo $row['amaterno']; ?></td>
                <td><?php echo $row['acasada']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['entidad']; ?></td>
                <td><?php echo $row['area']; ?></td>
                <td><?php echo $row['cargo']; ?></td>
                <td><?php echo $row['telf']; ?></td>
                <td><?php echo $row['externo']; ?></td>
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