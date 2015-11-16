<?php 
@session_start();
if (isset($_SESSION['login']))
	header('location: pagina_inicio.php');
else
	header('location: login.php');
exit(0);
?>

