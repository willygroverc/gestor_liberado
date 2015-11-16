<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
require("conexion.php");
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require_once("funciones.php");
if (valida("Hash")=="bad") {header("location: pagina_error.php");}
if(isset($_REQUEST['CALCULAR'])){
	if($_FILES['archivo']['name']<>''){
		$lim=$_FILES['archivo']['name'];
               //echo 'Nombre archivo: '.$_FILES['archivo']['name'].'<br>';
               //echo 'tipo archivo: '.$_FILES['archivo']['type'].'<br>';
               //echo 'tamano archivo: '.$_FILES['archivo']['size'].'<br>';
               //echo 'archivo: '.$_FILES['archivo']['tmp_name'].'<br>';
                $arch=  realpath($_FILES['archivo']['tmp_name']);
		//echo $arch;//$hash=  md5_file('"'.$_FILES['archivo']['name'].'"','"'.$_FILES['archivo']['tmp_name'].'"');
		$hash=  md5_file("$arch");
		
	}else{
	$msg="Debe seleccionar un Archivo";
	}
}
include("top.php");?>
<form name="form1" method="post" action="" enctype="multipart/form-data">
  <table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" >
    <tr> 
      <td bgcolor="#006699" align="center" background="windowsvista-assets1/main-button-tile.jpg" height="30"> <font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong> 
        CALCULADORA HASH</strong></font></td>
  </tr>
  <tr> 
    <td> <table width="93%" align="center">
        <tr> 
            <td align="right" height="30"> <div align="center"><br>
                &nbsp;<br>
                <font size="2" face="ARIAL, Helvetica, sans-serif"><b>Archivo:&nbsp;&nbsp;&nbsp;</b></font> 
                <input name="archivo" type="file" id="archivo" value="Seleccione un Archivo" size="60">
                <font size="2" face="ARIAL">&nbsp; </font>&nbsp; <br>
                <br><br><input name="CALCULAR" type="submit" id="CALCULAR" value="CALCULAR">
              </div></td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
<?php if(isset($_REQUEST['CALCULAR'])){?>
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" >
<tr>
<td>
<table width="100%" align="center" background="images/fondo.jpg">
  <tr> 
    <td width="201" height="40" align="center"> <div align="right"><strong><font size="2" face="Arial, Helvetica, sans-serif">El 
        hash del Archivo es:</font> </strong><BR>
      </div>
    <td width="275"><strong><font size="3" face="Arial, Helvetica, sans-serif"><?php echo $hash;?>&nbsp;</font></strong></tr>
  <tr> 
    <td height="40" colspan="2" align="center"><form name="form2" method="post" action="">
        <input type="button" name="imp" value="IMPRIMIR" onClick="imprime('<?php echo $hash;?>','<?php echo $lim;?>')">
      </form></td>
  </tr>
</table>
</td>
</tr>
</table>
<?php } ?>
<script language="JavaScript">
		<!-- 
		<?php 
		if (isset($msg)) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
function imprime(hs,lim)
{
	window.open("imp_hash.php?hs="+hs+"&arc="+lim);
	//alert(hs);
	//alert(lim);
}
</script>