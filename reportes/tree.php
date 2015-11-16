<div class='tb'>
<span class='btn' onclick='window.top.min(1)' title='Minimizar'>Min</span>
<span class='btn' onclick='window.top.res()' title='Restaurar'>Res</span>
</div>
<html>
<head>
	<title>JavaScript Tree Menu</title>
	<meta name="description" content="Free Cross Browser Javascript DHTML Tree Menu Navigation">
	<meta name="keywords" content="JavaScript tree menu, DHTML tree menu, client side tree menu, table of contents, site map, web authoring, scripting, freeware, download, shareware, free software, DHTML, Free Tree Menu, site, navigation, html, web, netscape, explorer, IE, opera, DOM, control, cross browser, support, frames, target, download">
	<meta name="robots" content="index,follow">
<style>
.btn {
  margin:2px 4px 2px 0px; padding:1px;
  font-size:10px; font-weight:bold;
  color:#000; background:#ccc;
  border:1px solid #999;
  width:26px; height:'16px';
  cursor:pointer;
}
.tb {
  text-align:right;
  margin:0; padding:0;
  background:#333333;
  width:'100%'; height:'22px';
}
.bdy {
  margin:4px; padding:6px;
  color:#000; background:#fff;
}
h1 {
  font-size:14px;
  color:#009;
}
a {
  color:#000; background:transparent;
}
a:hover {
  color:#009; background:#ccc;
}
pre {
  color:#009; background:transparent;
  font-size:12px;
  font-family:monospace;
}
	a, A:link, a:visited, a:active, A:hover
		{color: #FFFFFF; text-decoration: none; font-family: Tahoma, Verdana; font-size: 12px }
.Estilo3 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
	background-color:#FFFFFF
}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body bottommargin="0" topmargin="0" leftmargin="0" rightmargin="0" marginheight="0" marginwidth="0" bgcolor="#333333">
<script language="JavaScript" src="tree.js"></script>
<?php include("tree_items.php"); ?>
<script language="JavaScript" src="tree_tpl.js"></script>

<table cellpadding="5" cellspacing="0" cellpadding="10" border="0" width="100%">
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
<br>
</body>
</html>

