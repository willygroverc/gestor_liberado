<?php
include("conexion.php");
$sql="UPDATE controlinvent SET Tipo='CD SOFTWARE' WHERE Tipo='CD \nSOFTWARE'";
mysql_db_query($db,$sql,$link);

$sql="UPDATE controlinvent SET Tipo='DISCO FLEXIBLE' WHERE Tipo='DISCO \nFLEXIBLE'";
mysql_db_query($db,$sql,$link);

$sql="UPDATE controlinvent SET Tipo='DISCO DURO' WHERE Tipo='DISCO \nDURO'";
mysql_db_query($db,$sql,$link);

$sql="UPDATE controlinvent SET Tipo='LIBROS DERECHO' WHERE Tipo='LIBROS \nDERECHO'";
mysql_db_query($db,$sql,$link);

$sql="UPDATE controlinvent SET Tipo='CD BACKUP' WHERE Tipo='CD \nBACKUP'";
mysql_db_query($db,$sql,$link);
?>