<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		06/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require("conexion.php");
?>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<html>
<head><title> GesTor F1 - GESTION-PRODAT - CLASIFICACION DE LA INFORMACION MANEJADA </title></head>
<?php 
@$ficha=($_GET['ficha']);
@$nomb=($_GET['var']);?>
<center>
<form name="form1" method="get" action="" target="_blank">
<input name="var2" type="hidden" value="<?php echo $ficha?>">
  <table width="70%" border="1">
    <tr>
      <td>
	    <table width="100%" background="images/fondo.jpg">
          <tr> 
      <td background="images/main-button-tileR1.jpg" height="20">
<div align="center"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">ELIJA 
                EL TIPO DE IMPRESION QUE DESEA</font><font size="3" face="Arial, Helvetica, sans-serif"><br>
          </font></strong></div></td>
    </tr>
    <tr> 
      <td> <div align="center"><br>
          <select name="menu1" onChange="MM_jumpMenu('parent',this,1)">
            <?php if ($nomb=="0"){
            echo "<option value=\"impresion_ast.php?var=0&num=1&ficha=".$ficha."\" selected>TODO</option>";
            } else {
            echo "<option value=\"impresion_ast.php?var=0&num=1&ficha=".$ficha."\">TODO</option>";
            }?>
            <?php if ($nomb=="1"){
            echo "<option value=\"impresion_ast.php?var=1&num=1&ficha=".$ficha."\" selected>POR USUARIO</option>";
            } else {
            echo "<option value=\"impresion_ast.php?var=1&num=1&ficha=".$ficha."\">POR USUARIO</option>";
             }?>
          </select>
          <?php if ($nomb=="1"){?>
          <select name="usuar">
            <?php
			  $sql = "SELECT * FROM users ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";}
			   ?>
          </select>
                  <?php } ?></div></td>
                  
    </tr>
    <tr> 
      <td><div align="center"><br>
                  <input name="IMPRE" type="button" value="   VER   " onClick="OpenPrint()">
        </div></td>
    </tr>
  </table>
	  </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</center>
</html>
<script language="JavaScript">
<!--
	function OpenPrint () {
		var form=document.form1;
		if (form.usuar) var usuario=form.usuar.value;
		else var usuario = "";
		window.open ("ver_ast11.php?im=" + usuario);
	}
-->
</script>