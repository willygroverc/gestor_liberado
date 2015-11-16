<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
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
<head><title> GesTor F1 - GESTION-PRODAT - ACUERDO DE NIVEL DE SERVICIO </title></head>
<?php
if (isset($_GET['ficha']))
	$ficha=($_GET['ficha']);
if (isset($_GET['var']))
	$nomb=($_GET['var']);
?>
<center>
<form name="form1" method="get" action="" target="_blank">
<input name="var2" type="hidden" value="<?php echo $ficha?>">
    <table width="100%" border="1">
      <tr>
        <td height="125"> 
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
            echo "<option value=\"impresion_ans.php?var=0&num=1\" selected>GENERAL</option>";
            $tipoimp="TODO";
			} else {
            echo "<option value=\"impresion_ans.php?var=0&num=1\">GENERAL</option>";
            }?>
            <?php if ($nomb=="1"){
            echo "<option value=\"impresion_ans.php?var=1&num=1\" selected>TECNICOS</option>";
            $tipoimp="TECNICO";
			} else {
            echo "<option value=\"impresion_ans.php?var=1&num=1\">TECNICOS</option>";
             }?>
			 <?php if ($nomb=="2"){
            echo "<option value=\"impresion_ans.php?var=2&num=1\" selected>PROVEEDORES</option>";
            $tipoimp="PROVEEDORES";
			} else {
            echo "<option value=\"impresion_ans.php?var=2&num=1\">PROVEEDORES</option>";
             }?>
			<?php if ($nomb=="3"){
            echo "<option value=\"impresion_ans.php?var=3&num=1\" selected>POR TECNICO</option>";
            $tipoimp="USUARIOS";
			} else {
            echo "<option value=\"impresion_ans.php?var=3&num=1\">POR TECNICO</option>";
             }?>
			 <?php if ($nomb=="4"){
            echo "<option value=\"impresion_ans.php?var=4&num=1\" selected>POR PROVEEDOR</option>";
            $tipoimp="PROVEEDOR";
			} else {
            echo "<option value=\"impresion_ans.php?var=4&num=1\">POR PROVEEDOR</option>";
             }?>
          </select>
          <?php if (isset($nomb) && $nomb=="3"){?>
          <select name="usuar">
            <?php
			  include("conexion.php");
			  $sql = "SELECT * FROM users ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';}
			   ?>
          </select>
          <?php } 
		  if (isset($nomb) && $nomb=="4") {?>
          <select name="usuar">
            <?php
			  include("conexion.php");
			  $sql = "SELECT * FROM proveedor";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{echo '<option value="'.$row['IdProv'].'">'.$row['NombProv'].'</option>';}
			   ?>
          </select>
		  <?php }?></div></td>        
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
	var tipoimp="<?php echo @$tipoimp;?>";
</script>
<script language="JavaScript">
<!--
	function OpenPrint () {
		var form=document.form1;
		if (form.usuar) var usuario=form.usuar.value;
		else var usuario = "";
		window.open ("ver_nservicio.php?im=" + usuario + "&im2=" + tipoimp);
	}
-->
</script>