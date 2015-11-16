<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250" />
<title>GestorF1-Normas</title>
<script language="Javascript" type="text/javascript">
    document.oncontextmenu = function(){return false}
    </script>
</head>
<?php
@session_start();
if (!isset($login)) {
	header("location: index.php"); 
}
if(!empty($_GET['variable']))
	$var=$_GET['variable'];
if (!empty($var)){
	include("../../../conexion.php");
	$sql="INSERT INTO t_pnp (id_vis,login,pnp,cant) VALUES('1','admin','tbl_1','1')";
	echo $sql;
	mysql_query($sql);
} 
?>

<frameset rows="*" cols="244,*" framespacing="0" frameborder="no" border="0">
  <frame src="pagina/izq.php" name="leftFrame" scrolling="Yes" noresize="noresize" id="leftFrame" title="leftFrame" />
  <frame src="pagina/centro.html" name="mainFrame" id="mainFrame" title="mainFrame" />
</frameset>
<noframes><body>
</body>
</noframes></html>
