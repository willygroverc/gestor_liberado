<?php 
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include("top_ver.php");
$idficha=($_GET['variable']);
$sql6="SELECT * FROM ana_facti WHERE id_ficha='$idficha'";
$resul6=mysql_query($sql6);
$row6=mysql_fetch_array($resul6);
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
        <h5>Análisis de Factibilidad Económica</h5>
      </div>
      <div class="row">
        <div class="three columns">
          <strong>Num. de Proyecto: </strong><?php echo $row6['id_ficha']; ?>
        </div>
        <div class="three columns">
          <strong>Nom. de Proyecto: </strong><?php echo $row6['nomproy']; ?>
        </div>
        <div class="six columns">
          <strong>Responsable: </strong>
          <?php 
          $sql7="SELECT * FROM users WHERE login_usr='$row6[nomresp]'";
          $resul7=mysql_query($sql7);
          $row7=mysql_fetch_array($resul7);
          echo $row7['nom_usr']."&nbsp;".$row7['apa_usr']."&nbsp;".$row7['ama_usr']; ?>
        </div>
      </div>
      <br>
      <h6>Infraestructura</h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th rowspan="2">N.</th>
                <th rowspan="2">Recurso</th>
                <th rowspan="2">Descripción</th>
                <th rowspan="2">Rel. c/Proy</th>
                <th colspan="2" class="center">Costo mes</th>
                <th rowspan="2">%Dedic. Mes</th>
                <th rowspan="2">Duración vinc.</th>
                <th rowspan="2">Valor Total</th>
              </tr>
              <tr>
                <th class="center">Básico</th>
                <th class="center">Adicional</th>
              </tr>
            </thead>
            <tbody>
                <?php
                $sql="SELECT * FROM anfacecoplancost WHERE id_ficha='$idficha' AND tipo='Infraestructura'";
                $resul=mysql_query($sql);
                while($row=mysql_fetch_array($resul))
                { ?>
                <tr>
                  <td><?php echo $row['numero']; ?></td>
                  <td><?php echo $row['recurso']; ?></td>
                  <td><?php echo $row['descripcion']; ?></td>
                  <td><?php echo $row['relac_proy']; ?></td>
                  <td><?php echo $row['costo_bas_mes']; ?></td>
                  <td><?php echo $row['costo_ad_mes']; ?></td>
                  <td><?php echo $row['porcent_dedic_proy']; ?></td>
                  <td><?php echo $row['dur_vin']; ?></td>
                  <td><?php echo $row['valor_total']; ?></td>
                </tr>
                <?php } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <h6>Tecnología</h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th rowspan="2">N.</th>
                <th rowspan="2">Recurso</th>
                <th rowspan="2">Descripción</th>
                <th rowspan="2">Rel. c/Proy</th>
                <th colspan="2" class="center">Costo mes</th>
                <th rowspan="2">%Dedic. Mes</th>
                <th rowspan="2">Duración vinc.</th>
                <th rowspan="2">Valor Total</th>
              </tr>
              <tr>
                <th class="center">Básico</th>
                <th class="center">Adicional</th>
              </tr>
            </thead>
            <tbody>
                <?php
                $sql="SELECT * FROM anfacecoplancost WHERE id_ficha='$idficha' AND tipo='Tecnologia'";
                $resul=mysql_query($sql);
                while($row=mysql_fetch_array($resul))
                { ?>
                <tr>
                  <td><?php echo $row['numero']; ?></td>
                  <td><?php echo $row['recurso']; ?></td>
                  <td><?php echo $row['descripcion']; ?></td>
                  <td><?php echo $row['relac_proy']; ?></td>
                  <td><?php echo $row['costo_bas_mes']; ?></td>
                  <td><?php echo $row['costo_ad_mes']; ?></td>
                  <td><?php echo $row['porcent_dedic_proy']; ?></td>
                  <td><?php echo $row['dur_vin']; ?></td>
                  <td><?php echo $row['valor_total']; ?></td>
                </tr>
                <?php } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <h6>Aplicaciones</h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th rowspan="2">N.</th>
                <th rowspan="2">Recurso</th>
                <th rowspan="2">Descripción</th>
                <th rowspan="2">Rel. c/Proy</th>
                <th colspan="2" class="center">Costo mes</th>
                <th rowspan="2">%Dedic. Mes</th>
                <th rowspan="2">Duración vinc.</th>
                <th rowspan="2">Valor Total</th>
              </tr>
              <tr>
                <th class="center">Básico</th>
                <th class="center">Adicional</th>
              </tr>
            </thead>
            <tbody>
                <?php
                $sql="SELECT * FROM anfacecoplancost WHERE id_ficha='$idficha' AND tipo='Aplicaciones'";
                $resul=mysql_query($sql);
                while($row=mysql_fetch_array($resul))
                { ?>
                <tr>
                  <td><?php echo $row['numero']; ?></td>
                  <td><?php echo $row['recurso']; ?></td>
                  <td><?php echo $row['descripcion']; ?></td>
                  <td><?php echo $row['relac_proy']; ?></td>
                  <td><?php echo $row['costo_bas_mes']; ?></td>
                  <td><?php echo $row['costo_ad_mes']; ?></td>
                  <td><?php echo $row['porcent_dedic_proy']; ?></td>
                  <td><?php echo $row['dur_vin']; ?></td>
                  <td><?php echo $row['valor_total']; ?></td>
                </tr>
                <?php } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <h6>Datos</h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th rowspan="2">N.</th>
                <th rowspan="2">Recurso</th>
                <th rowspan="2">Descripción</th>
                <th rowspan="2">Rel. c/Proy</th>
                <th colspan="2" class="center">Costo mes</th>
                <th rowspan="2">%Dedic. Mes</th>
                <th rowspan="2">Duración vinc.</th>
                <th rowspan="2">Valor Total</th>
              </tr>
              <tr>
                <th class="center">Básico</th>
                <th class="center">Adicional</th>
              </tr>
            </thead>
            <tbody>
                <?php
                $sql="SELECT * FROM anfacecoplancost WHERE id_ficha='$idficha' AND tipo='Datos'";
                $resul=mysql_query($sql);
                while($row=mysql_fetch_array($resul))
                { ?>
                <tr>
                  <td><?php echo $row['numero']; ?></td>
                  <td><?php echo $row['recurso']; ?></td>
                  <td><?php echo $row['descripcion']; ?></td>
                  <td><?php echo $row['relac_proy']; ?></td>
                  <td><?php echo $row['costo_bas_mes']; ?></td>
                  <td><?php echo $row['costo_ad_mes']; ?></td>
                  <td><?php echo $row['porcent_dedic_proy']; ?></td>
                  <td><?php echo $row['dur_vin']; ?></td>
                  <td><?php echo $row['valor_total']; ?></td>
                </tr>
                <?php } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <h6>Gente</h6>
      <div class="row">
        <div class="column">
          <table class="u-full-width">
            <thead>
              <tr>
                <th rowspan="2">N.</th>
                <th rowspan="2">Recurso</th>
                <th rowspan="2">Descripción</th>
                <th rowspan="2">Rel. c/Proy</th>
                <th colspan="2" class="center">Costo mes</th>
                <th rowspan="2">%Dedic. Mes</th>
                <th rowspan="2">Duración vinc.</th>
                <th rowspan="2">Valor Total</th>
              </tr>
              <tr>
                <th class="center">Básico</th>
                <th class="center">Adicional</th>
              </tr>
            </thead>
            <tbody>
                <?php
                $sql="SELECT * FROM anfacecoplancost WHERE id_ficha='$idficha' AND tipo='Gente'";
                $resul=mysql_query($sql);
                while($row=mysql_fetch_array($resul))
                { ?>
                <tr>
                  <td><?php echo $row['numero']; ?></td>
                  <td><?php echo $row['recurso']; ?></td>
                  <td><?php echo $row['descripcion']; ?></td>
                  <td><?php echo $row['relac_proy']; ?></td>
                  <td><?php echo $row['costo_bas_mes']; ?></td>
                  <td><?php echo $row['costo_ad_mes']; ?></td>
                  <td><?php echo $row['porcent_dedic_proy']; ?></td>
                  <td><?php echo $row['dur_vin']; ?></td>
                  <td><?php echo $row['valor_total']; ?></td>
                </tr>
                <?php } //end while ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <h6 class="u-pull-right">Total: <?php echo $row6['total']; ?></h6>
    </div> <!-- end print-area -->
  </div>
</body>
</html>