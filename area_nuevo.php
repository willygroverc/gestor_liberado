<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
require('conexion.php');
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

if (isset($_REQUEST['cod'])){
	$sql="SELECT * FROM area WHERE area_cod='$_REQUEST[cod]'";
	$datos=mysql_query($sql);	
	$area=mysql_fetch_array($datos);
}
if (isset($_REQUEST['cmdvolver'])) { header("location: area.php?pg=$pg"); }
if (isset($_REQUEST['cmdsave']))
{
	if (isset($_REQUEST['cod']))
	{
		$sqlver="SELECT area_cod FROM area WHERE area_nombre='$_REQUEST[txtnomarea]' and area_cod <> $_REQUEST[cod]";
		//echo "<br>valor de la consulta : : ".$sqlver;
		$consul=mysql_query($sqlver);
		if ($row=mysql_fetch_array($consul))
		{
			$msg="El elemento de Nivel 1 ya existe";
		}
		else
		{ //
			$sql_update="UPDATE area SET area_nombre='$_REQUEST[txtnomarea]',area_desc='$_REQUEST[txtdesarea]' WHERE area_cod='$_REQUEST[cod]'";
			mysql_query($sql_update);
			header("location: area.php?pg=$pg&Naveg=Parametros%20Tipos>>Nivel 1");
		  //
		}
	}
	else
	{
		$sqlver="SELECT area_cod FROM area WHERE area_nombre='$_REQUEST[txtnomarea]'";
		$consul=mysql_query($sqlver);
		if ($row=mysql_fetch_array($consul))
		{
			$msg="El elemento de Nivel 1 ya existe";
		}
		else
		{
			$sql_insert="INSERT INTO area (area_nombre,area_desc) VALUES ('$_REQUEST[txtnomarea]','$_REQUEST[txtdesarea]')";
			mysql_query($sql_insert);	
			header("location: area.php?pg=$pg&Naveg=Parametros Tipos >> Areas");
		}
	}
}
include('top.php');
include ("menu_tipo.php");
require_once ( "ValidatorJs.php");   //llamamos a la funcion ValidatorJs.php
$valid = new Validator ( "form1");
$valid->addExists ( "txtnomarea",  "Nombre de Area, $errorMsgJs[empty]" );
$valid->addExists ( "txtdesarea",  "Descripci�n de Area, $errorMsgJs[empty]" );
echo $valid->toHtml();
?>
<html>
<head>
<title>Nueva Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<div align="center">
  <table width="75%" border="1" background="images/fondo.jpg">
    <tr>
      <th background="images/main-button-tileR1.jpg" height="22">NUEVO NIVEL</th>
    <th background="images/main-button-tileR1.jpg" height="22"><?php if (isset($error) && $error==1) { echo "El Area ya existe"; } ?></th>
    <tr> 
      <td height="248"> <div align="center"> 
          <form name="form1" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <table width="75%" border="0">
              <tr> 
                <td width="50%"><div align="right" class="normal"><strong>Nombre 
                    del Nivel 1</strong></div></td>
                    <td width="50%"><input name="txtnomarea" type="text" id="txtnomarea" size="20" maxlength="20" <?php if (isset($_REQUEST['cod'])!='') { echo "value='$area[area_nombre]'"; } ?> ></td>
              </tr>
              <tr> 
                <td><div align="right" class="normal"><strong>Descripci&oacute;n</strong></div></td>
                <td><textarea name="txtdesarea" cols="50" rows="5" id="txtdesarea" ><?php if (isset($_REQUEST['cod'])!='') { echo $area['area_desc']; } ?></textarea></td>
              </tr>
            </table>
            <table width="75%" border="0">
              <tr> 
                <td width="46%"><div align="right"> </div></td>
                <td width="9%">&nbsp;</td>
                <td width="45%">&nbsp;</td>
              </tr>
              <tr> 
                <td><div align="right">
                  <input name="pg" type="hidden" id="pg" value="<?php echo $pg?>">
                  <input name="cmdsave" type="submit" id="cmdsave2" value="GUARDAR" <?php echo $valid->onSubmit(); ?> >
                  </div></td>
                <td>&nbsp;</td>
                <td><input name="cmdvolver" type="submit" id="cmdvolver2" value="RETORNAR"></td>
              </tr>
            </table>
          </form>
        </div></td>
    </tr>
  </table>
</div>
</body>
</html>
<script language="JavaScript">
		<!-- 
		<?php if (isset($msg)) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GestorF1.\");\n";
		} ?>
		-->
</script>