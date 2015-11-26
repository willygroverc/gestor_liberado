<?php 
include ('top_ver.php');
require ('funciones.php');
$login_usr=_clean($_GET['login_usr']);
$login_usr=SanitizeString($login_usr);


$sql = "SELECT u.login_usr, u.tipo_usr, u.tipo2_usr, u.nom_usr, u.apa_usr, u.ama_usr, u.cargo_usr, da.nombre_dadicional as area, u.area_usr, u.bloquear, u.telf_usr, u.asig_usr, u.email, u.direc_usr, da1.nombre_dadicional as agencia, u.enti_usr, u.esp_usr, u.ext_usr, u.ciu_usr, DATE_FORMAT(u.fecha_creacion, '%d/%m/%Y') AS fecha_creacion, DATE_FORMAT(fecha_eliminacion, '%d/%m/%Y') AS fecha_eliminacion FROM users u LEFT JOIN datos_adicionales da ON u.area_usr=da.id_dadicional LEFT JOIN datos_adicionales da1 ON u.adicional1=da1.id_dadicional WHERE login_usr='$login_usr'";
$result=mysql_query($sql);
if (mysql_num_rows($result)==0)
	echo '<script>history.back(1);</script>';
else
	$row=mysql_fetch_array($result);
?>
<html>
<head>
<title>Usuario</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/skeleton.css">
<link rel="stylesheet" href="css/reports.css">
</head>

<body>
  <div class="container">
    <?php include("datos_gral.php"); ?>
    <div class="print-area">
      <div class="row center">
        <h5>Usuario</h5>
      </div>
      <div class="row">
        <div class="four columns">
          <strong>Login: </strong><?php echo $row['login_usr']; ?>
        </div>
        <div class="four columns">
          <strong>Tipo: </strong>
          <?php if ($row['tipo2_usr']=="A") echo "Administrador";?>
          <?php if ($row['tipo2_usr']=="C") echo "Cliente";?>
          <?php if ($row['tipo2_usr']=="T") echo "Tecnico";?>
        </div>
        <div class="four columns">
          <strong>Email: </strong><?php echo $row['email']; ?>
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
      <div class="row">
        <div class="six columns">
          <strong>Fecha de Creación: </strong><?php echo $row['fecha_creacion']; ?>
        </div>
        <?php if ($row['bloquear']==2) { ?>
        <div class="six columns">
          <strong>Fecha de Eliminación: </strong><?php echo $row['fecha_eliminacion']; ?>
        </div>
        <?php } //end if ?>
      </div>
      <br>
      <h6>Datos del Cliente</h6>
      <div class="row">
        <div class="four columns">
          <strong>Nombres: </strong><?php echo $row['nom_usr']; ?>
        </div>
        <div class="four columns">
          <strong>Apellido Paterno: </strong><?php echo $row['apa_usr']; ?>
        </div>
        <div class="four columns">
          <strong>Apellido Materno: </strong><?php echo $row['ama_usr']; ?>
        </div>
      </div>
      <div class="row">
        <div class="four columns">
          <strong>Entidad: </strong><?php echo $row['enti_usr']; ?>
        </div>
        <div class="four columns">
          <strong>Área: </strong><?php echo $row['area']; ?>
        </div>
        <div class="four columns">
          <strong>Especialidad: </strong><?php echo $row['esp_usr']; ?>
        </div>
      </div>
      <div class="row">
        <div class="four columns">
          <strong>Cargo: </strong><?php echo $row['cargo_usr']; ?>
        </div>
        <div class="four columns">
          <strong>Teléfono: </strong><?php echo $row['telf_usr']; ?>
        </div>
        <div class="four columns">
          <strong>Ext: </strong><?php echo $row['ext_usr']; ?>
        </div>
      </div>
      <?php 
      $sql1="SELECT * FROM control_parametros";
      $rs1=mysql_query($sql1);
      $row1=mysql_fetch_array($rs1);
      if ($row1['agencia']=="si") {
      ?>
      <div class="row">
        <div class="column">
          <strong>Agencia: </strong><?php echo $row['agencia']; ?>
        </div>
      </div>
      <?php } //end if ?>
      <br>
      <h6>Ubicación Física</h6>
      <div class="row">
        <div class="four columns">
          <strong>Ciudad: </strong><?php echo $row['ciu_usr']; ?>
        </div>
        <div class="eight columns">
          <strong>Dirección: </strong><?php echo $row['direc_usr']; ?>
        </div>
      </div>
    </div> <!-- end print-area -->
  </div>
</body>
</html>