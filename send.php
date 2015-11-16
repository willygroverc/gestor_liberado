<?php
switch($menu){
case orden:
	$item="orden_estadistica.php";
	break;
case contratos:
	$item="report_contratos.php";
	break;
case solicitud:	
	$item="report_solicproyectos.php";
	break;
case propietarios:
	$item="report_sistemas.php";
	break;
case control:
	$item="report_control_temp.php";
	break;
}
?>
<body onLoad="ver()">
<script language="JavaScript" type="text/JavaScript">
function ver()
{
var items="<?php echo $item;?>"
cerrar(); 
open(items,'Limberg','toolbar=no,status=no,menubar=no,location=no,directories=no,resizable=no,scrollbars=no,width=650,height=254,left=150,top=150');

}
function cerrar() { 
    var ventana = window.self; 
    ventana.opener = window.self; 
    ventana.close(); 
   } 
</script>