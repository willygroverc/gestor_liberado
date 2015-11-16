<?php
session_start();
include ("conexion.php");
if (empty($_REQUEST['a'])) { $_REQUEST['a']="";} else { $_REQUEST['a']=$_REQUEST['a'];}
if (empty($_REQUEST['cod'])) { $_REQUEST['cod']="";} else { $_REQUEST['cod']=$_REQUEST['cod'];}
if (empty($_REQUEST['mod'])) { $_REQUEST['mod']="";} else { $_REQUEST['mod']=$_REQUEST['mod'];}
$a=  $_REQUEST['a'];
$cod=  $_REQUEST['cod'];
if ($_REQUEST['a'])
{       $cod=$_REQUEST['cod'];
	$sql="SELECT dominio,descripcion,id_area FROM dominio WHERE id_dominio='$cod'";
	$datos=mysql_db_query($db,$sql,$link);
	$dominio=mysql_fetch_array($datos);
}
if (isset($_REQUEST['cmdvolver'])) { header("location:lista_dominio.php?Naveg=Par�metros >> Segundo Nivel&pg=$pg&cod=$a"); }
if (isset($_REQUEST['cmdvolver1'])) { header("location:lista_dominio.php?Naveg=Par�metros >> Segundo Nivel&pg=$pg&cod=$cod"); }
if (isset($_REQUEST['cmdsave']))
{
	if ($a)
	{   $domi=$_REQUEST['domi'];
		$sqlver="select id_dominio from dominio where dominio='$domi' and id_dominio <> $cod";
                //print_r($sqlver);exit;
		$consul=mysql_db_query ($db,$sqlver,$link);
		if ( $row=mysql_fetch_array($consul))
		{
			$msg="El elemento de Nivel 2 ingresado ya existe";
		}
		else
		{   $desc_dom=$_REQUEST['desc_dom'];
			$sql_update="UPDATE dominio SET dominio='$domi',descripcion='$desc_dom' WHERE id_dominio='$cod'";
			mysql_db_query($db,$sql_update,$link);
			header('location:lista_dominio.php?cod='.$a."&pg=$pg");
			//
		}
	}
	else
	{	$domi=$_REQUEST['domi'];
                $desc_dom=$_REQUEST['desc_dom'];
                $txtarea=$_REQUEST['txtarea'];
		$fecha = date("Y-m-d");
		$sqlver="select id_dominio from dominio where dominio='$domi'";
		$consul=mysql_db_query ($db,$sqlver,$link);
		if ( $row=mysql_fetch_array($consul))
		{
			$msg="El elemento de Nivel 2 ingresado ya existe";
		}
		else
		{
			$login=$_SESSION['login'];
			$sql="INSERT INTO dominio (dominio,id_area,fec_creacion,login_creador,descripcion, creado) values ('$domi','$txtarea','$fecha','$login','$desc_dom','0') ";
			if(mysql_db_query($db,$sql,$link)){$msg="El elemento de Nivel 2 ha sido creado exitosamente.";}
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
    <th colspan="5"><div align="center"><strong>SEGUNDO NIVEL
        <?php                   $a=$_REQUEST['a'];
                                $cod=$_REQUEST['cod'];
				if($a) $sql="SELECT area_nombre FROM area WHERE area_cod='$a'";
				else $sql="SELECT area_nombre FROM area WHERE area_cod='$cod'";
				$datos=mysql_db_query($db,$sql,$link);
				$row=mysql_fetch_array($datos);
				
			?>
        </strong></div></th>
  </tr>
  <tr> 
    <td colspan="5"> <div align="center"class="normal"><strong>Area:</strong> 
        <?php=$row['area_nombre'];?>
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
	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}
	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM dominio WHERE id_area='$cod'";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);
	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql="SELECT * FROM dominio WHERE id_area='$cod' LIMIT $_pagi_inicial,$_pagi_cuantos";
	$datos=mysql_db_query($db,$sql,$link);
	while ($dominio=mysql_fetch_array($datos)) {
	?>
  <tr> 
    <td><div align="center"><?php echo $i; ?> </div></td>
    <td><div align="center"><?php echo $dominio['dominio']; ?></div></td>
    <td><div align="center"><?php echo $dominio['descripcion']; ?></div></td>
  </tr>
  <?php
	$i++;
	}
	?>
</table>
<!--Edici�n de dominios--->
	<?php
		$sCon = "select *from dominio where id_dominio=$cod";
		$sRes = mysql_db_query($db,$sCon,$link);
		$sdom = mysql_fetch_array($sRes);
	?>
<!--Fin--->
<br>
<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" name="form1">

<table width="55%" border="1" cellpadding="3" cellspacing="3" background="images/fondo.jpg">
    <tr> 
	  <th align="center">NUEVO NIVEL</td> <input name="txtarea" type="hidden" id="txtarea" value="<?php echo $cod?>"></tr>
     
   <tr><td>
<table width="93%" align="center" cellpadding="4" cellspacing="4">
          <tr align="center"> 
            <td width="28%" align="right" class="normal" ><strong>Nombre Nivel 2: </strong></td>
            <td width="72%" align="left"> <input name="domi" type="text" size="30" maxlength="30" cols="50" rows="5" <?php if(isset($_REQUEST['mod'])==1){?> value="<?php=$sdom['dominio']?>" <?php } ?> > 
            </td>
          </tr>
          <tr> 
            <td width="28%" align="right" class="normal"><strong>Descripcion:</strong></td>
            <td width="72%" align="left"><textarea name="desc_dom" cols="50" rows="5" maxlength="250"><?php if($_REQUEST['mod']==1){ echo $sdom['descripcion'];}?></textarea></td>
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