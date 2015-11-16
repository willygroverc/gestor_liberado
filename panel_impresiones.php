<?php
if (isset($retorna))
{ header("location: panel_control.php?Naveg=Gestion >> Reportes y Estadisticas");
}
include("top.php");
?>
<html>
<head>
	<meta name="description" content="Free Cross Browser Javascript DHTML Tree Menu Navigation">
	<meta name="keywords" content="JavaScript tree menu, DHTML tree menu, client side tree menu, table of contents, site map, web authoring, scripting, freeware, download, shareware, free software, DHTML, Free Tree Menu, site, navigation, html, web, netscape, explorer, IE, opera, DOM, control, cross browser, support, frames, target, download">
	<meta name="robots" content="index,follow">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<script language="JavaScript" src="tree1.js"></script>
<script language="JavaScript" src="tree_items1.js"></script>
<script language="JavaScript" src="tree_tpl1.js"></script>
<table width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#F4F2EA" >
    <tr> 
    <td><div align="center">
    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
          <tr> 
            
          <th>PANEL DE CONTROL - REPORTES</th>
          </tr>
          <tr align="center"> 
            <td>
<table cellpadding="10" cellspacing="0" border="0" width="50%">
<tr>
	<td>
	<script language="JavaScript">
	<!--//
		new tree (TREE_ITEMS, TREE_TPL);
	//-->
	</script>
	</td>
	</tr>
</table>
			</td>
          </tr>
      </table></td>
  </tr>
</table>
<form name="form1" action="" method="post">
<input name="retorna" type="submit" value="RETORNAR">
</form>
</body>
</html>
<?php
include("top_.php");
?>