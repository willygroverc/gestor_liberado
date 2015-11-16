<?php
//SE AGREGO CAMPOS EN LA BDD PARA DETERMINAR LOS RESPONSABLES DE ESTE NIVEL, RESP1,RESP2 Y RESP3 Y SUS RESPECTIVOS 
//TIEMPOS DE RESPUESTA DE CADA RESPONSABLE
//TIEMPO1,TIEMPO2
session_start();
include ("conexion.php");
if (empty($_REQUEST['a'])) { $_REQUEST['a']="";} else { $_REQUEST['a']=$_REQUEST['a'];}
if (empty($_REQUEST['d'])) { $_REQUEST['d']="";} else { $_REQUEST['d']=$_REQUEST['d'];}
if (empty($_REQUEST['pg'])) { $_REQUEST['pg']="";} else { $_REQUEST['pg']=$_REQUEST['pg'];}
if (empty($_REQUEST['cod'])) { $_REQUEST['cod']="";} else { $_REQUEST['cod']=$_REQUEST['cod'];}
if (empty($msg)) { $msg="";} else { $msg=$msg;}
$a=$_REQUEST['a'];
$d=$_REQUEST['d'];
$pg=$_REQUEST['pg'];
$cod=$_REQUEST['cod'];
if ($cod)
{
	$sql_objetivo="SELECT * FROM objetivos WHERE id_objetivo='$cod'";
	$datos=mysql_db_query($db,$sql_objetivo,$link);	
	$obj=mysql_fetch_array($datos);
}
if (isset($_REQUEST['cmdvolver'])) { header("location:lista_objetivo.php?Naveg=Par�metros >> Nivel 1&d=$d&a=$a"); }
if (isset($_REQUEST['cmdsave'])) {
	$login=$_SESSION['login'];
	$fecha=date("Y-m-d");
        $resp1=$_REQUEST['resp1'];
        $tiempo1=$_REQUEST['tiempo1'];
        $resp2=$_REQUEST['resp2'];
        $tiempo2=$_REQUEST['tiempo2'];
        $resp3=$_REQUEST['resp3'];
        $tiemposol=$_REQUEST['tiemposol'];
	if ($cod)
	{       $txtnomobj=$_REQUEST['txtnomobj'];
		$sqlver="SELECT id_objetivo FROM objetivos WHERE objetivo='$txtnomobj' and id_objetivo <> $cod";
		$consul=mysql_db_query($db,$sqlver,$link);
		if ($row=mysql_fetch_array($consul))
		{
			$msg="El Nivel 3 ingresado ya existe";
		}
		else
		{
                    if ($resp1==$resp2){
                        $msg="El responsable 1 no puede ser igual al responsable 2 los datos no hay sido guardados";
                    }
                    elseif ($resp2==$resp3){
                        $msg="El responsable 2 no puede ser igual al responsable 3 los datos no hay sido guardados";
                    }
                    elseif ($resp1==$resp3){
                        $msg="El responsable 1 no puede ser igual al responsable 3 los datos no hay sido guardados";
                    }//elseif{$resp1==$resp2}
                    else {
                        $sql_update="UPDATE objetivos SET objetivo='$txtnomobj',resp1='$resp1',tiempo1='$tiempo1',resp2='$resp2',tiempo2='$tiempo2',resp3='$resp3',tiempoestimado='$tiemposol' WHERE id_objetivo='$cod'";
                //print_r($sql_update);exit;
		mysql_db_query($db,$sql_update,$link);	
		header("location:lista_objetivo.php?a=".$a."&d=".$d."&pg=$pg");
                    }
		}
	}
	else
	{       //if (empty($_REQUEST['txtdominio'])) { $_REQUEST['txtdominio']="";} else { $_REQUEST['txtdominio']=$_REQUEST['txtdominio'];}
                $txtdominio=$_REQUEST['txtdominio'];
                $txtnomobj=$_REQUEST['txtnomobj'];
		$sqlver="SELECT id_objetivo FROM objetivos WHERE objetivo='$txtnomobj' AND id_dominio='$txtdominio'";
		$consul=mysql_db_query($db,$sqlver,$link);
		if ($row=mysql_fetch_array($consul))
		{
			$msg="El Nivel 3 ingresado ya existe en el Nivel 2";
		}
		else
		{
                        $txtdominio=$_REQUEST['txtdominio'];
                        $txtnomobj=$_REQUEST['txtnomobj'];
			$sql_insert="INSERT INTO objetivos(id_dominio,objetivo,fec_creacion,login_creador,resp1,tiempo1,resp2,tiempo2,resp3,tiempoestimado) VALUES('$txtdominio','$txtnomobj','$fecha','$login','$resp1','$tiempo1','$resp2','$tiempo2','$resp3','$tiemposol')";
			//print_r($sql_insert);exit;
                        if(mysql_db_query($db,$sql_insert,$link))
			{$msg="Nivel 3 ha sido creado exitosamente.";}
		}
	}
}
include('top.php');
require_once ( "ValidatorJs.php");
$valid = new Validator ( "form1");
$valid->addExists ( "txtnomobj",  "Nombre de Nivel 1, $errorMsgJs[empty]" );
$valid->addExists ( "resp1",  "Responsable 1, $errorMsgJs[empty]" );
$valid->addExists ( "resp2",  "Responsable 2, $errorMsgJs[empty]" );
echo $valid->toHtml();

$sql = "SELECT * FROM tiempo_resp'";
$result=mysql_db_query($db,$sql,$link);
$rowz=mysql_fetch_array($result);  ?>


<html>
<head>
<title>Nuevo Nivel 3</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<div align="center">
  <table width="75%" border="1" background="images/fondo.jpg">
    <tr> 
      <th colspan="4" background="images/main-button-tileR1.jpg" height="22"><div align="center"><strong>TERCER NIVEL</strong></div></th>
    </tr>
    <tr> 
      <td width="25%"><div align="right" class="normal"><strong>Nivel 1:</strong></div></td>
      <td width="25%"> <font size=3 face=Arial, class="normal" face="Arial, Helvetica, sans-serif">
        <?php
				if($a){
				$sql="SELECT area_nombre FROM area WHERE area_cod='$a'";
				$datos=mysql_db_query($db,$sql,$link);
				$row=mysql_fetch_array($datos);
				echo $row['area_nombre'];				
				}else{
				$sql="SELECT area_nombre FROM area WHERE area_cod='$cod'";
				$datos=mysql_db_query($db,$sql,$link);
				$row=mysql_fetch_array($datos);
				echo $row['area_nombre'];}
			?>
        </font></td>
      <td width="21%"><div align="right" class="normal"><strong>Nivel 2:</strong></div></td>
      <td width="29%"><font size=3 class="normal" face="Arial, Helvetica, sans-serif">
        <?php
				$sql="SELECT dominio FROM dominio WHERE id_area='$a' AND id_dominio='$d'";
				$datos=mysql_db_query($db,$sql,$link);
				$row=mysql_fetch_array($datos);
				echo $row['dominio'];				
				?>
        </font> </td>
    </tr>
  </table>
  <table width="75%" border="1" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
      <td width="9%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>Nro.</strong></font></div></td>
      <td width="35%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>NOMBRE</strong></font></div></td>
    <td width="35%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>RESPONSABLE1</strong></font></div></td>
    <td width="5%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>TIEMPO1</strong></font></div></td>
    <td width="35%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>RESPONSABLE2</strong></font></div></td>
    <td width="5%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>TIEMPO2</strong></font></div></td>
    <td width="35%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>RESPONSABLE3</strong></font></div></td>
    <td width="35%" background="images/main-button-tileR1.jpg" height="22"><div align="center" class="normal"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>TIEMPO ESTIMADO DE SOLUCION</strong></font></div></td>    
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
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM objetivos WHERE id_dominio='$d'";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);
	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql_objetivo="SELECT * FROM objetivos WHERE id_dominio='$d' LIMIT $_pagi_inicial,$_pagi_cuantos";
	$datos_obj=mysql_db_query($db,$sql_objetivo,$link);
	while($objetivo=mysql_fetch_array($datos_obj)) {
	?>
    <tr> 
      <td width="9%"><div align="center"><?php echo $i; ?></div></td>
      <td width="35%"><div align="left">&nbsp;<?php echo $objetivo['objetivo']; ?></div></td>
      <td width="35%"><div align="left">&nbsp;<?php echo $objetivo['resp1']; ?></div></td>
      <td width="5%"><div align="left">&nbsp;<?php echo $objetivo['tiempo1']; ?></div></td>
      <td width="35%"><div align="left">&nbsp;<?php echo $objetivo['resp2']; ?></div></td>
      <td width="5%"><div align="left">&nbsp;<?php echo $objetivo['tiempo2']; ?></div></td>
      <td width="35%"><div align="left">&nbsp;<?php echo $objetivo['resp3']; ?></div></td>
      <td width="35%"><div align="left">&nbsp;<?php echo $objetivo['tiempoestimado']; ?></div></td>
    </tr>
    <?php
	$i++;
	}
	?>
  </table>
<br>
  <table width="75%" border="1" background="images/fondo.jpg">
      <th background="images/main-button-tileR1.jpg" height="22">NUEVO NIVEL</th>
    <tr> 
      <td> 
          <form name="form1" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
          <div align="center">
            <table width="75%" border="0">
              <tr> 
                <td width="50%"><div align="right" class="normal"><strong> 
                    <input name="txtarea" type="hidden" value="<?php echo $a?>">
                    <input name="txtdominio" type="hidden" value="<?php echo $d?>">
                    Nombre Nivel 3</strong></div></td>
                <td width="50%"><textarea name="txtnomobj" cols="45" rows="2" id="txtnomobj"><?php if ($cod!='') { echo $obj['objetivo']; } ?></textarea></td>
              </tr>
               <tr>
                <td width="63%">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;TIEMPO ESTIMADO DE SOLUCION(en dias):</font> 
                <select name="tiemposol">
                <option value="1" <?php if ($rowz['tiempo']=="1") echo "selected";?>>1</option>
		<option value="2" <?php if ($rowz['tiempo']=="2") echo "selected";?>>2</option>
                <option value="3" <?php if ($rowz['tiempo']=="3") echo "selected";?>>3</option>
                <option value="4" <?php if ($rowz['tiempo']=="4") echo "selected";?>>4</option>
                <option value="5" <?php if ($rowz['tiempo']=="5") echo "selected";?>>5</option>
              </select></td>
              </tr>
              <tr>                    
                <td><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABLE 1 : &nbsp; 
                   <select name="resp1" id="resp1">
                    <option value=""></option>
                    <?php 
			$sql3 = "SELECT login_usr, nom_usr, apa_usr, ama_usr FROM users WHERE (tipo2_usr='A' OR tipo2_usr='T') AND bloquear=0 ORDER BY apa_usr";
			$result3 = mysql_db_query($db,$sql3,$link);
			while ($row3 = mysql_fetch_array($result3)) 
			   {
                            if ($row3['login_usr']<>null)
			 	echo '<option value="'.$row3['login_usr'].'" selected>'.$row3['apa_usr'].' '.$row3['ama_usr'].' '.$row3['nom_usr'].'</option>';
                            else
				echo '<option value="'.$row3['login_usr'].'">'.$row3['apa_usr'].' '.$row3['ama_usr'].' '.$row3['nom_usr'].'</option>';
                            }
                    ?>
                   </select>
                </font></td>
              </tr>
              
              <tr>
                <td width="63%">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;TIEMPO 1(en dias):</font> 
                <select name="tiempo1">
                <option value="1" <?php if ($rowz['tiempo']=="1") echo "selected";?>>1</option>
		<option value="2" <?php if ($rowz['tiempo']=="2") echo "selected";?>>2</option>
                <option value="3" <?php if ($rowz['tiempo']=="3") echo "selected";?>>3</option>
                <option value="4" <?php if ($rowz['tiempo']=="4") echo "selected";?>>4</option>
                <option value="5" <?php if ($rowz['tiempo']=="5") echo "selected";?>>5</option>
              </select></td>
              </tr>
              
              <tr>                    
                <td><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABLE 2 : &nbsp; 
                   <select name="resp2" id="resp2">
                    <option value=""></option>
                    <?php 
			$sql3 = "SELECT login_usr, nom_usr, apa_usr, ama_usr FROM users WHERE (tipo2_usr='A' OR tipo2_usr='T') AND bloquear=0 ORDER BY apa_usr";
			$result3 = mysql_db_query($db,$sql3,$link);
			while ($row3 = mysql_fetch_array($result3)) 
			   {
                            if ($row3['login_usr']<>null)
			 	echo '<option value="'.$row3['login_usr'].'" selected>'.$row3['apa_usr'].' '.$row3['ama_usr'].' '.$row3['nom_usr'].'</option>';
                            else
				echo '<option value="'.$row3['login_usr'].'">'.$row3['apa_usr'].' '.$row3['ama_usr'].' '.$row3['nom_usr'].'</option>';
                            }
                    ?>
                   </select>
                </font></td>
              </tr>
              
              <tr>
                <td width="63%">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;TIEMPO 2(en dias):</font> 
                <select name="tiempo2">
                <option value="1" <?php if ($rowz['tiempo']=="1") echo "selected";?>>1</option>
		<option value="2" <?php if ($rowz['tiempo']=="2") echo "selected";?>>2</option>
                <option value="3" <?php if ($rowz['tiempo']=="3") echo "selected";?>>3</option>
                <option value="4" <?php if ($rowz['tiempo']=="4") echo "selected";?>>4</option>
                <option value="5" <?php if ($rowz['tiempo']=="5") echo "selected";?>>5</option>
              </select></td>
              </tr>
              
              <tr>                    
                <td><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABLE 3(opcional) : &nbsp; 
                   <select name="resp3">
                    <option value="0"></option>
                    <?php 
			$sql3 = "SELECT login_usr, nom_usr, apa_usr, ama_usr FROM users WHERE (tipo2_usr='A' OR tipo2_usr='T') AND bloquear=0 ORDER BY apa_usr";
			$result3 = mysql_db_query($db,$sql3,$link);
			while ($row3 = mysql_fetch_array($result3)) 
			   {
                            if ($row3['login_usr']<>null)
			 	echo '<option value="'.$row3['login_usr'].'" selected>'.$row3['apa_usr'].' '.$row3['ama_usr'].' '.$row3['nom_usr'].'</option>';
                            else
				echo '<option value="'.$row3['login_usr'].'">'.$row3['apa_usr'].' '.$row3['ama_usr'].' '.$row3['nom_usr'].'</option>';
                            }
                    ?>
                   </select>
                </font></td>
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
                    <input name="cmdsave" type="submit" id="cmdsave2" value="GUARDAR" <?php echo $valid->onSubmit(); ?> >
                  </div></td>
                <td>&nbsp;</td>
                <td><input name="cmdvolver" type="submit" id="cmdvolver2" value="RETORNAR"></td>
              </tr>
            </table>
          </div>
        </form>
        </td>
    </tr>
  </table>
<?php include('top_.php'); ?>
</div>
</html>
<script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GestorF1.\");\n";
		} ?>
		-->
</script>