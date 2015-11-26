<?php
require("conexion.php");
@session_start();
$login=$_SESSION['login'];

$sql_us="SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$login'";
$result_us=mysql_query($sql_us);
$row_us=mysql_fetch_array($result_us);

$sql_cons="SELECT nombre , datos_gral FROM control_parametros";
$res_cons=mysql_query($sql_cons);
$row_cons=mysql_fetch_array($res_cons);
 if ($row_cons['datos_gral']==1){ 
?>
<div class="row">
  <div class="column datos-generales">
    <h6>Datos Generales</h6>
    <ul>
      <li><strong>Entidad: </strong><?php echo $row_cons['nombre'];?></li>
      <li><strong>Realizado por: </strong><?php echo $row_us['nom_usr'].'-'.$row_us['apa_usr'].' '.$row_us['ama_usr'];?></li>
      <li><strong>IP de origien: </strong><?php echo $_SERVER['REMOTE_ADDR'];?></li>
      <li><strong>Fecha y hora: </strong><?php echo date("Y-m-d")."&nbsp;&nbsp;".date("H:i:s");?></li>
    </ul>
    <button onClick="window.print()">Imprimir</button>
  </div>
</div>
<div class="row logo">
  <div class="column">
    <img src="images/imagen_ins.jpg">
  </div>
</div>
<?php
}
?>