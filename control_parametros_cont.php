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
if (isset($_REQUEST['RETORNAR'])){header("location: menu_parametros.php?Naveg=Seguridad >> Menu de Parametros");}
if (isset($_REQUEST['GUARDATOS'])) 
{	
  	include ("conexion.php");
   	$sql = "SELECT * FROM control_parametros";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
        $tmp_alert=$_REQUEST['tmp_alert'];
	if ($row['id_parametro']=="")
	{$sql = "INSERT INTO control_parametros (tmp_alert) ".
	"VALUES ('$tmp_alert')";
        //print_r($sql);exit;
	mysql_query($sql);
	header("location: menu_parametros.php?Naveg=Menu Parametros");
	
	}	   
   	else
	{$sql = "UPDATE control_parametros SET tmp_alert='$tmp_alert'";   
        //print_r($sql);exit;
    if (mysql_query($sql)){header("location: menu_parametros.php?Naveg=Menu Parametros");}
	else {$msg="OCURRIO UN ERROR EN MIENTRAS SE ACTUALIZABA LOS DATOS";}}
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
      <th background="images/main-button-tileR1.jpg" height="22"><font size="2" face="Arial, Helvetica, sans-serif">PARAMETROS DE GESTION 
        - CONTRATOS</font></th>
    </tr>
    <tr> 
      <td height="66"> 
        <table width="100%">
          <tr> 
            <th height="26" colspan="2" background="images/main-button-tileR2.jpg"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Parametros 
                de Alerta:</font></div></th>
          </tr>
          <tr> 
            <td width="57%" height="26"> <div align="right"><font size="2" face="Arial, Helvetica, sans-serif"> 
                Tiempo de alerta de caducidad de los contratos:&nbsp;&nbsp;&nbsp;<br>
                </font></div></td>
            <td width="43%"> <select name="tmp_alert" id="tmp_alert">
                <option value="2" <?php if($row['tmp_alert']=="2") echo "selected"?>>2 Dias</option>
                <option value="4" <?php if($row['tmp_alert']=="4") echo "selected"?>>4 Dias</option>
                <option value="6" <?php if($row['tmp_alert']=="6") echo "selected"?>>6 Dias</option>
				<option value="8" <?php if($row['tmp_alert']=="8") echo "selected"?>>8 Dias</option>
				<option value="10" <?php if($row['tmp_alert']=="10") echo "selected"?>>10 Dias</option>
              </select> </td>
          </tr>
          <tr> 
            <td height="26" colspan="2">&nbsp;</td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td height="26"><div align="center"> 
                <input type="submit" name="GUARDATOS" value="GUARDAR">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
              </div>
              </td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>