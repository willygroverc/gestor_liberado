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

require("conexion.php");
?>
<html>
<head>
<title>Roles</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/skeleton.css">
<link rel="stylesheet" href="css/reports.css">
</head>
<body>
  <div class="container">
    <?php include("datos_gral.php"); ?>
    <div class="print-area">
      <div class="row center">
        <h5>Roles</h5>
      </div>
      <div class="row">
        <div class="six columns">
          <strong>Login: </strong><?php echo $_REQUEST['id']; ?>
        </div>
        <div class="six columns">
          <strong>Usuario: </strong>
          <?php 
          $sql_us="SELECT CONCAT(nom_usr,' ', apa_usr,' ', ama_usr) AS nombre FROM users WHERE login_usr='$_REQUEST[id]'";
          $res_us=mysql_query($sql_us);
          $row_us=mysql_fetch_array($res_us);
          echo $row_us['nombre'];
          ?>
        </div>
      </div>
      <br>
      <h6>Gestión - PRODAT</h6>
      <?php 
      $sql_rol="SELECT * FROM roles WHERE login_usr='$_REQUEST[id]'";
      $res_rol=mysql_query($sql_rol);
      $row_rol=mysql_fetch_array($res_rol);
      ?>
      <div class="row">
        <div class="four columns">
          Contratos-PROACT           
          <?php if ($row_rol['Clasificacion']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Clasificación          
          <?php if ($row_rol['Clasificacion']=="r") {echo "&#x2713;";} ?>
        </div>
        <div class="four columns">
          Proyectos        
          <?php if ($row_rol['Proyectos']=="r") {echo "&#x2713;";} ?>
        </div>
      </div>
      <div class="row">
        <div class="four columns">
          Actas          
          <?php if ($row_rol['Actas']=="r") {echo "&#x2713;";} ?>
        </div>
        <div class="four columns">
          Proveedores          
          <?php if ($row_rol['Proveedores']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Vacaciones         
          <?php if ($row_rol['Vacaciones']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
      </div>
      <div class="row">
        <div class="four columns">
          Planificación Estratégica        
          <?php if ($row_rol['PlanifEstrat']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Riesgos          
          <?php if ($row_rol['Riesgo']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          ANS          
          <?php if ($row_rol['Ans']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
      </div>
      <br>
      <h6>Soporte Técnico - PROAST</h6>
      <div class="row">
        <div class="four columns">
          Fichas Técnicas       
          <?php if ($row_rol['FichasTecnicas']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Cronograma          
          <?php if ($row_rol['Cronograma']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Mantenimiento Fuera          
          <?php if ($row_rol['MantFuera']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
      </div>
      <br>
      <h6>D&M - PROADM</h6>
      <div class="row">
        <div class="four columns">
          D&M    
          <?php if ($row_rol['DyM']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
      </div>
      <br>
      <h6>Producción - PROAPD</h6>
      <div class="row">
        <div class="four columns">
          Propietarios y Responsables      
          <?php if ($row_rol['PropyResp']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Ubicación de Respaldos          
          <?php if ($row_rol['UbicacRespal']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Control de Temperatura y Humedad         
          <?php if ($row_rol['ControlTyH']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
      </div>
      <div class="row">
        <div class="four columns">
          Calendarización       
          <?php if ($row_rol['Calendariza']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Control de Inventarios          
          <?php if ($row_rol['ControlInvent']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
      </div>
      <br>
      <h6>Problemas - PROAPI</h6>
      <div class="row">
        <div class="four columns">
          Producción     
          <?php if ($row_rol['Produccion']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          D&M          
          <?php if ($row_rol['DesaMante']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
      </div>
      <br>
      <h6>Contingencia - PROAPC</h6>
      <div class="row">
        <div class="four columns">
          Planificación      
          <?php if ($row_rol['Planificacion']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Evaluación          
          <?php if ($row_rol['Evaluacion']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Ejecución          
          <?php if ($row_rol['Ejecucion']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
      </div>
      <div class="row">
        <div class="four columns">
          Cronograma      
          <?php if ($row_rol['Calen_cont']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
      </div>
      <br>
      <h6>Seguridad - PROASI</h6>
      <div class="row">
        <div class="four columns">
          Usuarios      
          <?php if ($row_rol['Usuarios']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Backup BD         
          <?php if ($row_rol['PistasAudi']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
      </div>
      <br>
      <h6>Cambios - PROACP</h6>
      <div class="row">
        <div class="four columns">
          Repositorio      
          <?php if ($row_rol['Repositorio']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Archivos          
          <?php if ($row_rol['Archivos']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Copia de Trabajo          
          <?php if ($row_rol['Copia_trabajo']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
      </div>
      <div class="row">
        <div class="four columns">
          Backups      
          <?php if ($row_rol['Backups']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Réplica          
          <?php if ($row_rol['Replica']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Pistas de Auditoría          
          <?php if ($row_rol['Pistas_fuentes']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
      </div>
      <div class="row">
        <div class="four columns">
          Revisión      
          <?php if ($row_rol['Revision']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Maestro de Cambios          
          <?php if ($row_rol['Maestro']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
        <div class="four columns">
          Módulos          
          <?php if ($row_rol['Modulos']=="r") {echo "&nbsp;&#x2713;";} ?>
        </div>
      </div>
    </div> <!-- end print-area -->
  </div>


  <?php 
		  $sql1="SELECT * FROM control_parametros";
		  $rs1=mysql_query($sql1);
		  $row1=mysql_fetch_array($rs1);
		  if ($row1['agencia']=="si") {
	  }
	?>
</body>
</html>
