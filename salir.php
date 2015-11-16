<?php
//cierra la base de datos
session_start();
include("conexion.php");
unset($_SESSION["login"]); 
$_SESSION = array();
session_destroy();
header("location:index.php");
?>