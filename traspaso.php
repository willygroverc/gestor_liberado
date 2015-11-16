<?php 
if ($GrupoOpciones1=="No") 
{
		header('location:naccionista.php?var=nuevo');
}
$cont_q=1;
$cont=1;
$cont1=0;
include("conexion.php");
$cad = $dato;
$num = $_POST['list1'];
if(!empty($_POST['list2']))
	$num1 = $_POST['list2'];
else
	$num1 = $id;	
$obs = $_POST['txtObservacion'];

@session_start();
if(!empty($obs)) {	$_SESSION["observacion"]=$obs;	}
if(!empty($num)) {	$_SESSION["num_1"]=$num;	}
if(!empty($num1)) {	$_SESSION["num_2"]=$num1;	}
//echo $sql_in;
//echo $_SESSION["observacion"];
session_start();
if(!empty($num))
{	$_SESSION['test'] = $num;	}
//echo $_SESSION['test'];
if(!empty($num1))
{	$_SESSION['test1'] = $num1;	}
//echo $_SESSION['test1'];
if ($update)
{
	$sql_acciones="SELECT estado FROM acciones WHERE id_acciones = '$cambio'";
	$res_acciones=mysql_db_query($db,$sql_acciones,$link);
	$row_acciones=mysql_fetch_array($res_acciones);
	if($row_acciones[estado]!=1)	{
		$sql_acciones="SELECT * FROM acciones WHERE id_acciones = '$cambio'";
		$res_acciones=mysql_db_query($db,$sql_acciones,$link);
		$row_acciones=mysql_fetch_array($res_acciones);
					
		$sql="UPDATE acciones SET id_accionistas = ".$_SESSION['test1']." WHERE id_acciones='$cambio' ";
		mysql_query($sql);
		
		$sql_in="INSERT INTO `transferencia`(`user_de`, `user_a`, `observaciones`,`id_acc`,`fecha`) VALUES ('".$_SESSION["num_1"]."','".$_SESSION["num_2"]."','".$_SESSION["observacion"]."','$cambio','".date("Y-m-d H:i:s")."' )";
		mysql_query($sql_in);
		echo "&nbsp;";
		echo "<script>alert('$sql_in');</script>";
	} else {
		if($row_acciones[estado]==1)
		{	
			echo "<script>alert('La accion no puede ser transferida porque esta en gravamen');</script>";
		}
	}
}
//echo $sql_in;
if (isset($Terminar))
{
	session_start();
  unset($_SESSION['test']); 
  unset($_SESSION['test1']);
  //session_destroy();
	header("location: accionistas.php");
	exit;
	
}
include("top.php");
$id_minuta=($_GET['id_minuta']);
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "serie_ac",  "Descripcion de la Prueba,  $errorMsgJs[empty]" );
$valid->addLength ( "desc_pru",  "Descripcion de la Prueba,  $errorMsgJs[length]" );
$valid->addFunction ( "validaTiempo2",  "" );
$valid->addIsNotEmpty ( "obs_pru",  "Observaciones,  $errorMsgJs[empty]" );
$valid->addLength ( "obs_pru",  "Observaciones,  $errorMsgJs[length]" );
print $valid->toHtml ();
?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/javascript" src="jquery.js"></script>
</head>

<body>
<style type="text/css">
</style>
  <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
  
	<table width="75%" border="1" align="center" background="images/fondo.jpg">
          <tr> 
            
      <th background="images/main-button-tileR1.jpg">DATOS DEL ACCIONISTA
	  </th>
          </tr>
          <tr> 
            <td height="52"><table width="100%" border="0">
                <tr> 
				<?php
				$sql_acc="SELECT * FROM accionistas WHERE id_acc = ".$_SESSION['test']."";
				$res_acc=mysql_db_query($db,$sql_acc,$link);
				$row_acc=mysql_fetch_array($res_acc);
				?>
                  <td width="2%">&nbsp;</td>
                  <td><font size="2"><strong>Nombre o Raz&oacute;n Social: </strong></font></td>
                  <td width="42%"><font size="2"><?php echo $row_acc[nom_acc];?></font></td>
                  <td width="17%"><font size="2"><strong>Fecha de Registro:</strong></font></td>
                  <td width="19%"><font size="2">&nbsp;<?php echo $row_acc[fecha_acc]?></font></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td width="20%"><font size="2"><strong>Nacionalidad:</strong></font></td>
                  <td><font size="2"><?php echo $row_acc[nac_acc]?>&nbsp;</font></td>
                  <td><font size="2"><strong>Telefono:</strong></font></td>
				  <td><font size="2">&nbsp;<?php echo $row_acc[tel_acc]?></font></td>
                </tr>
				<tr> 
                  <td>&nbsp;</td>
				  <td width="20%"><font size="2"><strong>Direcci&oacute;n:</strong></font></td>
                  <td><font size="2"><?php echo $row_acc[dom_acc]?>&nbsp;</font></td>
				  <td><font size="2"><strong>Estado: </strong><?php echo $row_acc[estado]?></font></td>
				  <td width="10%"><div align="center"><a href="naccionista_mod.php?idcc=<?php echo $row_acc[id_acc] ?> &nom=<?php echo $row_acc[nom_acc] ?>&nac=<?php echo $row_acc[nac_acc] ?>&tel=<?php echo $row_acc[tel_acc] ?>&direc=<?php echo $row_acc[dom_acc] ?>&anio=<?php  $fecha = $row_acc[fecha_acc];
$partes = explode("-", $fecha);
echo $partes[0]; //2007
?>&mes=<?php  $fecha = $row_acc[fecha_acc];
$partes = explode("-", $fecha);
echo $partes[1]; //2007
?>&dia=<?php  $fecha = $row_acc[fecha_acc];
$partes = explode("-", $fecha);
echo $partes[2]; //2007
?>"></div></td>
                </tr>
              </table></td>
          </tr>
    </table>
        <input name="num" type="hidden" value="<?php=$num?>">
  <table width="75%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th colspan="8" background="images/main-button-tileR1.jpg">DETALLE DE ACIONES<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
        </font></th>
    </tr>
    <tr> 
	  <th nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cambiar</font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">N&ordm; de Partida </font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nro. de Titulo y Serie de la Accion</font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Valor Nominal </font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Fecha de Asiento </font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Numero de <br>Acciones del Titulo</font></th>
	  <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Valor Total de Acciones<br>(en Bolivianos)</font></th>
	  <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Clase</font></th>
    </tr>
    <?php
		$sql = "SELECT * FROM acciones WHERE id_accionistas=".$_SESSION['test']." ORDER BY id_ac ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
			?>
			<tr align="center"> 
			  <td>
			  <input type="radio" name="cambio" value="<?php=$row[id_acciones]?>">
			  </td>
			  <td>&nbsp;<?php echo "$cont";$cont++;?></td>
			  <td>&nbsp;<?php echo $row[serie_ac]?></td>
			  <td>&nbsp;<?php echo number_format($row[valor_ac],2,'.',',');?></td>
			  <td>&nbsp;<?php echo $row[fecas_ac]?></td>
			  <td>&nbsp;<?php echo number_format($row[num_ac],0,'.',',')?></td>
			  <?php
			  $sb_total=$row[valor_ac]*$row[num_ac];
			  ?>
			  <td>&nbsp;<?php echo number_format($sb_total,2,'.',',')?></td>
			  <td>&nbsp;<?php echo $row[class_ac]?></td>
			</tr>
			<?php 
		 }
	if(!empty($np))
	{		
		$sql_ed = "SELECT * FROM acciones WHERE id_acc='$num' AND id_ac='$np'";
		$result_ed=mysql_db_query($db,$sql_ed,$link);
		$row_ed=mysql_fetch_array($result_ed);
	}
	?>
  </table>
</br>
<input name="update" type="submit" id="update" value="REALIZAR TRANSFERENCIA" <?php print $valid->onSubmit() ?>>
</br>
<table width="75%" border="1" align="center" background="images/fondo.jpg">
          <tr> 
            
      <th background="images/main-button-tileR1.jpg">DATOS DEL ACCIONISTA
	  </th>
          </tr>
          <tr> 
            <td height="52"><table width="100%" border="0">
                <tr> 
				<?php
				$sql_acc="SELECT * FROM accionistas WHERE id_acc = ".$_SESSION['test1']."";
				$res_acc=mysql_db_query($db,$sql_acc,$link);
				$row_acc=mysql_fetch_array($res_acc);
				?>
                  <td width="2%">&nbsp;</td>
                  <td><font size="2"><strong>Nombre o Raz&oacute;n Social: </strong></font></td>
                  <td width="42%"><font size="2"><?php echo $row_acc[nom_acc];?></font></td>
                  <td width="17%"><font size="2"><strong>Fecha de Registro:</strong></font></td>
                  <td width="19%"><font size="2">&nbsp;<?php echo $row_acc[fecha_acc]?></font></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td width="20%"><font size="2"><strong>Nacionalidad:</strong></font></td>
                  <td><font size="2"><?php echo $row_acc[nac_acc]?>&nbsp;</font></td>
                  <td><font size="2"><strong>Telefono:</strong></font></td>
				  <td><font size="2">&nbsp;<?php echo $row_acc[tel_acc]?></font></td>
                </tr>
				<tr> 
                  <td>&nbsp;</td>
				  <td width="20%"><font size="2"><strong>Direcci&oacute;n:</strong></font></td>
                  <td><font size="2"><?php echo $row_acc[dom_acc]?>&nbsp;</font></td>
				  <td><font size="2"><strong>Estado: </strong><?php echo $row_acc[estado]?></font></td>
				  <td width="10%"><div align="center"><a href="naccionista_mod.php?idcc=<?php echo $row_acc[id_acc] ?> &nom=<?php echo $row_acc[nom_acc] ?>&nac=<?php echo $row_acc[nac_acc] ?>&tel=<?php echo $row_acc[tel_acc] ?>&direc=<?php echo $row_acc[dom_acc] ?>&anio=<?php  $fecha = $row_acc[fecha_acc];
$partes = explode("-", $fecha);
echo $partes[0]; //2007
?>&mes=<?php  $fecha = $row_acc[fecha_acc];
$partes = explode("-", $fecha);
echo $partes[1]; //2007
?>&dia=<?php  $fecha = $row_acc[fecha_acc];
$partes = explode("-", $fecha);
echo $partes[2]; //2007
?>"></div></td>
                </tr>
              </table></td>
          </tr>
    </table>
        <input name="num" type="hidden" value="<?php=$num?>">
  <table width="75%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th colspan="8" background="images/main-button-tileR1.jpg">DETALLE DE ACIONES<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
        </font></th>
    </tr>
    <tr>
      <th nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">N&ordm; de Partida </font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nro. de Titulo y Serie de la Accion</font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Valor Nominal </font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Fecha de Asiento </font></th>
      <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Numero de <br>Acciones del Titulo</font></th>
	  <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Valor Total de Acciones<br>(en Bolivianos)</font></th>
	  <th nowrap background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Clase</font></th>
    </tr>
    <?php
		$sql = "SELECT * FROM acciones WHERE id_accionistas=".$_SESSION['test1']." ORDER BY id_ac ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		$cont1++;
	?>
    <tr align="center"> 
	  <td>&nbsp;<?php echo "$cont1";?></td>
      <td>&nbsp;<?php echo $row[serie_ac]?></td>
      <td>&nbsp;<?php echo number_format($row[valor_ac],2,'.',',');?></td>
	  <td>&nbsp;<?php echo $row[fecas_ac]?></td>
	  <td>&nbsp;<?php echo number_format($row[num_ac],0,'.',',')?></td>
	  <?php
	  $sb_total=$row[valor_ac]*$row[num_ac];
	  ?>
	  <td>&nbsp;<?php echo number_format($sb_total,2,'.',',')?></td>
 	  <td>&nbsp;<?php echo $row[class_ac]?></td>
    </tr>
    <?php 
		 }
	/*if(!empty($np))
	{		
		$sql_ed = "SELECT * FROM acciones WHERE id_acc='$num' AND id_ac='$np'";
		$result_ed=mysql_db_query($db,$sql_ed,$link);
		$row_ed=mysql_fetch_array($result_ed);
	}*/
	?>
    <tr> 
      <td height="28" colspan="11" nowrap> <div align="center"><br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="Terminar" value="TERMINAR">
        </div></td>
    </tr>
  </table>  
  </form>
<script type="text/javascript" src="jquery.js"></script>
</body>
<?php include("top_.php");?>
