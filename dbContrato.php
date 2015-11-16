<html>
<head>
<title>test</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
include ("conexion.php");
$sql = "SELECT IdProv, NombProv FROM proveedor";
$result = mysql_db_query($db,$sql,$link);
while ($row = mysql_fetch_array($result)) {
	$lstProveedor[$row[NombProv]]=$row[IdProv];
	print $row[IdProv].$row[NombProv]."<br>";
}

$sql = "SELECT IdContra, PartCont FROM contratodatos";
$result = mysql_db_query($db,$sql,$link);
while ($row = mysql_fetch_array($result)) {
	//$lstProveedor[$row[NombProv]]=$row[IdProv];
	$sql = "UPDATE contratodatos SET PartCont=".$lstProveedor[$row[PartCont]]." WHERE IdContra=$row[IdContra]";
	$rs = mysql_db_query($db,$sql,$link);
print $sql."---".$row[PartCont]."<br>";
}

?>
</body>
</html>
