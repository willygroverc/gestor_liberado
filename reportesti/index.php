<?php include "rptinc/ewcommon.php"; ?>
<?php include "rptinc/ewcommon.php"; ?>
<?php include "rptinc/ewconfig.php"; ?>
<?php include "rptinc/advsecu.php"; ?>
<?php include "rptinc/phprptfn.php"; ?>
<?php
ob_end_clean();
require_once("../funciones.php"); 
if (valida("pmi")=="bad") {header("location: ../pagina_error.php");}
header("Location: Reporte_de_Tipificacionsmry.php");
exit();
?>
