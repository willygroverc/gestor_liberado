<?php
include ("conexion.php");
if ($id_objetivo != '')
{
	$sql="SELECT * FROM objetivos WHERE id_objetivo='$id_objetivo'";
	$datos=mysql_db_query($db,$sql,$link);	
	$obj=mysql_fetch_array($datos);
}
if (isset($cmdvolver)) { header("location: lista_objetivo.php?Naveg=Parametros Tipos >> objetivos&pg=$pg"); }
if (isset($cmdsave)) {
	if ($id_objetivo!='')
	{
		$sql_update="UPDATE objetivos SET objetivo='$txtnomobj', descripcion='$txtdesobj' WHERE id_objetivo='$id_objetivo'";
		mysql_db_query($db,$sql_update,$link);
		header("location: lista_objetivo.php?pg=$pg&Naveg=Parametros Tipos >> Nivel 3");
	}
	else
	{
		$sqlver="SELECT id_objetivo FROM objetivos WHERE objetivo='$txtnomobj'";
		$consul=mysql_db_query($db,$sqlver,$link);
		if ($row=mysql_fetch_array($consul))
		{
			$msg="El Nivel 3 ya existe";
		}
		else
		{
			$sql_insert="INSERT INTO objetivos (objetivo,descripcion) VALUES ('$txtnomobj','$txtdesobj')";
			mysql_db_query($db,$sql_insert,$link);	
			header("location: lista_objetivo.php?pg=$pg&Naveg=Parametros Tipos >> Nivel 3");
		}
	}
}
include('top.php');
include ("menu_tipo.php");
require_once ( "ValidatorJs.php");   //llamamos a la funcion ValidatorJs.php
$valid = new Validator ( "form1");
$valid->addExists ( "txtnomobj",  "Nivel 3, $errorMsgJs[empty]" );
$valid->addExists ( "txtdesobj",  "Descripción de Nivel 3, $errorMsgJs[empty]" );
echo $valid->toHtml();
?>
<html>
<head>
<title>Nuevo Objetivo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<div align="center">
  <table width="75%" border="1" background="images/fondo.jpg">
    <tr>
      <th>NUEVO NIVEL 3</th>
    <th><?php if ($error==1) { echo "El Nivel 3 ya existe"; } ?></th>
    <tr> 
      <td height="248"> <div align="center"> 
          <form name="form1" method="post" action="<?php $PHP_SELF ?>">
            <table width="75%" border="0">
              <tr> 
                <td width="50%"><div align="right" class="normal"><strong>Nombre 
                    de Nivel 3</strong></div></td>
                <td width="50%"><input name="txtnomobj" type="text" size="20" maxlength="20" <?php if ($id_objetivo!='') { echo "value='$obj[objetivo]'"; } if ($id_objetivo!='') { echo "readonly=true"; }?> ></td>
              </tr>
              <tr> 
                <td><div align="right" class="normal"><strong>Descripci&oacute;n</strong></div></td>
                <td><textarea name="txtdesobj" cols="50" rows="5"><?php if ($id_objetivo!='') { echo $obj[descripcion]; } ?></textarea></td>
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
  <?php include('top_.php'); ?>
</div>
</body>
</html>
<script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GestorF1.\");\n";
		} ?>
		-->
</script>