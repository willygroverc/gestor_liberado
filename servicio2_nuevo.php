<?php
session_start();
include ("conexion.php");
if ($a)
{
	$sql="SELECT * FROM t_servicio2 WHERE id_serv2='$cod'";
	$datos=mysql_query($sql);
	$servicio=mysql_fetch_array($datos);
}
if (isset($cmdvolver)) { header("location:lista_servicio2.php?Naveg=Parámetros >> Segundo Nivel&pg=$pg&cod=$a"); }
if (isset($cmdvolver1)) { header("location:lista_servicio2.php?Naveg=Parámetros >> Segundo Nivel&pg=$pg&cod=$cod"); }
if (isset($cmdsave))
{
	if (isset($a))
	{
		$sqlver="select id_serv2 from t_servicio2 where servicio2='$domi' and id_serv2  <> $cod";
		$consul=mysql_db_query ($db,$sqlver,$link);
		if ( $row=mysql_fetch_array($consul))
		{
			$msg="El elemento de Nivel 2 ingresado ya existe";
		}
		else
		{   //
			$sql_update="UPDATE t_servicio2 SET servicio2='$domi',servicio2_desc='$desc_dom' WHERE id_serv2 ='$cod'";
			mysql_db_query($db,$sql_update,$link);
			header('location:lista_dominio.php?cod='.$a."&pg=$pg");
			//
		}
	}
	else
	{	
		$fecha = date("Y-m-d");
		$sqlver="select id_dominio from dominio where dominio='$domi'";
		$consul=mysql_db_query ($db,$sqlver,$link);
		if ( $row=mysql_fetch_array($consul))
		{
			$msg="El elemento de Nivel 2 ingresado ya existe";
		}
		else
		{
			$login=$_SESSION[login];
			$sql="INSERT INTO t_servicio2 (servicio2,servicio_cod,fecha,servicio2_desc) values ('$domi','$txtarea','$fecha','$desc_dom') ";
			if(mysql_query($sql)){$msg="El elemento de Nivel 2 ha sido creado exitosamente.";}
		}
	}
}
include ("top.php");
require_once ( "ValidatorJs.php");
$valid = new Validator ( "form1");
$valid->addExists ( "domi",  "Nombre del elemento de Nivel 2, $errorMsgJs[empty]" );
$valid->addExists ( "desc_dom",  "Descripcion de elemento de Nivel 2, $errorMsgJs[empty]" );
echo $valid->toHtml();
?>
<html>
<head>
<title>Nuevo elemento de Nivel 2</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="75%" border="1" background="images/fondo.jpg">
  <tr> 
    <th colspan="5"><div align="center"><strong>REGISTRO DE SERVICIOS
        <?php
				if($a) $sql="SELECT servicio_nombre FROM t_servicio WHERE servicio_cod='$a'";
				else $sql="SELECT servicio_nombre FROM t_servicio WHERE servicio_cod='$cod'";
				$datos=mysql_query($sql);
				$row=mysql_fetch_array($datos);
				
			?>
        </strong></div></th>
  </tr>
  <tr> 
    <td colspan="5"> <div align="center"class="normal"><strong>Servicio:</strong> 
        <?php=$row['servicio_nombre'];?>
      </div></td>
  </tr>
  <tr bgcolor="#006699"> 
    <td width="7%"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">Nro.</font></div></td>
    <td width="27%"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">NOMBRE</font></div></td>
    <td width="35%"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></div></td>
  </tr>
  <?php
	$i=1;
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);
	if(empty($row11[num_ord_pag])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11[num_ord_pag] ;}
	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM t_servicio2 WHERE servicio_cod='$cod'";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);
	$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql="SELECT * FROM t_servicio2 WHERE servicio_cod='$cod' LIMIT $_pagi_inicial,$_pagi_cuantos";
	$datos=mysql_query($sql);
	while ($servicio2=mysql_fetch_array($datos)) {
	?>
  <tr> 
    <td><div align="center"><?php echo $i; ?> </div></td>
    <td><div align="center"><?php echo $servicio2['servicio2']; ?></div></td>
    <td><div align="center"><?php echo $servicio2['servicio2_desc']; ?></div></td>
  </tr>
  <?php
	$i++;
	}
	?>
</table>
<!--Edición de dominios--->
	<?php
		$sCon = "select *from dominio where id_dominio=$cod";
		$sRes = mysql_db_query($db,$sCon,$link);
		$sdom = mysql_fetch_array($sRes);
	?>
<!--Fin--->
<br>
<form method="post" action="<?php $PHP_SELF ?>" name="form1">

<table width="55%" border="1" cellpadding="3" cellspacing="3" background="images/fondo.jpg">
    <tr> 
	  <th align="center">NUEVO NIVEL</td> <input name="txtarea" type="hidden" id="txtarea" value="<?php echo $cod?>"></tr>
     
   <tr><td>
<table width="93%" align="center" cellpadding="4" cellspacing="4">
          <tr align="center"> 
            <td width="28%" align="right" class="normal" ><strong>Nombre Nivel 2: </strong></td>
            <td width="72%" align="left"> <input name="domi" type="text" size="30" maxlength="150" cols="50" rows="5" <?php if($mod==1){?> value="<?php=$sdom[dominio]?>" <?php } ?> > 
            </td>
          </tr>
          <tr> 
            <td width="28%" align="right" class="normal"><strong>Descripcion:</strong></td>
            <td width="72%" align="left"><textarea name="desc_dom" cols="50" rows="5" maxlength="250"><?php if($mod==1){ echo $sdom[descripcion];}?></textarea></td>
          </tr>
          <tr>
            <td height="10" colspan="2" align="center"><input name="cmdsave" type="submit" id="cmdsave" value="GUARDAR" <?php echo $valid->onSubmit(); ?>> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <?php if(isset($a)){?>
              <input name="cmdvolver" type="submit" id="cmdvolver" value="RETORNAR"> 
              <?php }else{?>
              <input name="cmdvolver1" type="submit" id="cmdvolver1" value="RETORNAR"> 
              <?php }?>
            </td>
          </tr>
        </table>
</td></tr>
</table>
</form>
</body>
</html>
<?php include("top_.php");?>
<script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GestorF1.\");\n";
		} ?>
		-->
</script>