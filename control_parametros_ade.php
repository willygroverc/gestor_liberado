<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
require ("conexion.php");
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

if (isset($_REQUEST['RETORNAR'])){header("location: menu_parametros.php");}
if (isset($_REQUEST['GUARDATOS'])){	
   	$sql = "SELECT * FROM control_parametros";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if ($row['id_parametro']=="")
	{	
		$sql = "INSERT INTO control_parametros (tam_archivo_f) ".
		"VALUES ('$_REQUEST[tam_archivo_f]')";
		mysql_query($sql);
		header("location: menu_parametros.php?Naveg=Seguridad >> Menu Parametros");
	
	}	   
   	else{	
		$sql = "UPDATE control_parametros SET tam_archivo_f='$_REQUEST[tam_archivo_f]'";   
      	if (mysql_query($sql)){header("location: menu_parametros.php");}
		else {$msg="OCURRIO UN ERROR EN MIENTRAS SE ACTUALIZABA LOS DATOS";}
	}
}

include ("top.php"); 
$sql = "SELECT * FROM control_parametros";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?> 
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onKeyPress="return Form()">
  <table width="65%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th background="images/main-button-tileR1.jpg" height="22"><font size="2" face="Arial, Helvetica, sans-serif">PARAMETROS DE ADMINISTRADOR 
        DE FUENTES</font></th>
    </tr>
    <tr> 
      <td height="119"> 
        <table width="100%">
          <tr> 
            <td height="21"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<strong>Parametros 
              de Archivos :</strong></font></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td width="75%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Tamano 
                del Archivo para Admin. de Fuentes</font> </div></td>
            <td width="25%"> <select name="tam_archivo_f" id="select21">
                <?php for($i=1;$i<=7;$i++)
					  {
    	              	echo "<option value=\"$i\""; if($row['tam_archivo_f']=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select> &nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><strong>Mb. 
              </strong></font></td>
          </tr>
        </table>
		<table width="100%">
          <tr> 
            <td height="56"><div align="center"><br>
                <input type="submit" name="GUARDATOS" value="GUARDAR">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
              </div>
              </td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<script language="JavaScript">
		<!-- 
		<?php 
		if (isset($msg)) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
</script>