<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body>
<?php $Codigo=($_GET['varia']);?>
<form name="form1" method="post" action="">
<input name="var" type="hidden" value="<?php echo $Codigo;?>">
  <table width="80%" border="1" align="center">
    <tr>
      <td><div align="center"><font size="3" face="Arial, Helvetica, sans-serif"><strong>TIPO 
          DE IMPRESION</strong></font></div></td>
    </tr>
  </table>
  <table width="80%" border="1" align="center">
    <tr>
      <td>Si desea IMPRIMIR todos los usuarios marque todos, caso contrario </td>
    </tr>
    
    <tr>
      <td><div align="center">
          <select name="menu2" onChange="MM_jumpMenu('parent',this,1)">
            <option>NINGUNO</option>
			<option value="nivservicio_impresion.php?varia=hol">TODO</option>
            <option value="nivservicio_impresion.php?varia=hola">POR USUARIO</option>
          </select>
          <?php if ($Codigo=="hola") { ?>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <select name="imprimir">
           <option value="0"></option>
               <?php
			  include ("conexion.php");
			  $sql8 = "SELECT * FROM users WHERE tipo2_usr='T'";
			  $result8 = mysql_db_query($db,$sql8,$link);
			  while ($row8 = mysql_fetch_array($result8)) 
				{echo "<option value=\"$row8[login_usr]\">$row8[nom_usr] $row8[apa_usr] $row8[ama_usr]</option>";}
				   ?>
		  </select>
		  <?php } ?>
        </div></td>
    </tr>
  </table>
  </form>
</body>
</html>
