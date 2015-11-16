<?php 
/////DESCRIPCION: ESTE ARCHIVO HA SIDO  MODIFICADO PARA SANEAR LA ENTRADA DE DE DATOS PARA ARAQUES XSS  DE TIPO ALERT
/////AUTOR: ALVARO RODRIGUEZ
/////FECHA: 12'09'2012
if (isset($_REQUEST['RETORNAR'])){header("location: lista_asig.php");}
session_start();
$id_orden=$_REQUEST['id_orden'];
if(isset($_REQUEST['adjunt'])){
	
	$sDetail = $_REQUEST['detalles_sol'];
	if($sDetail == ""){$sDetail = $_REQUEST['detalles'];}
	$sMedidas = $_REQUEST['medprev_sol'];
	if($sMedidas == ""){$sMedidas = $_REQUEST['medidas'];}
	
	if($_FILES["archivo"]["name"]){
	require("conexion.php");
	$sql5="SELECT * FROM control_parametros";
	$result5=mysql_query($sql5);
	$row5=mysql_fetch_array($result5);

	$extension = explode(".",$_FILES["archivo"]["name"]); 
	$num = count($extension)-1; 
	$tam_max=1048576*$row5['tam_archivo'];

	if($_FILES["archivo"]["size"] < $tam_max){
		/*
		$sql1="SELECT MAX(id_orden)+1 AS id_orden FROM ordenes"; 
		$result1=mysql_query($sql1);
		$row1=mysql_fetch_array($result1);
		$var="ajuntos_bosol_".$row1[nomb_archivo];
		$var_hash="ajuntos_bosol_hash_".$row1[hash_archivo];//nuevo
		$var_obs="ajuntos_bosol_obs_".$row1[observaciones];//nuevo
		*/
		$var1="ajuntos_bosol_".$id_orden;
		$var1_hash="ajuntos_bosol_hash_".$id_orden;//num
		$var1_obs = "ajuntos_bosol_obs_".$id_orden;//num
		$adjuntos_bo=$_SESSION[$var1];
		$adjuntos_bo_hash=$_SESSION[$var1_hash];//num
		$adjuntos_bo_obs=$_SESSION[$var1_obs];//num
		$num1=array();
		$num1_hash=array();//num
		$num1_obs=array();//num
		
		if($adjuntos_bo=="") $alfa=1;
		else {
			$num1=explode("|",$adjuntos_bo);
			$alfa=count($num1)+1;
		}
		///
		if($adjuntos_bo_hash=="") $alfa_hash=1;
		else {
			$num1_hash=explode("|",$adjuntos_bo_hash);
			$alfa_hash=count($num1_hash)+1;
		}
		//
		if($adjuntos_bo_obs=="") $alfa_obs=1;
		else {
			$num1_obs=explode("|",$adjuntos_bo_obs);
			$alfa_obs=count($num1_obs)+1;
		}
		///
		$arch_nomb="sol".$id_orden."[".$alfa."].".$extension[$num];
		$hash_nomb = md5_file($_FILES["archivo"]["tmp_name"]);//nuevo
		array_push($num1,$arch_nomb);
		array_push($num1_hash,$hash_nomb);//nuevo
		array_push($num1_obs, $_REQUEST['txtObservacion']);//nuevo
		$num=implode("|",$num1);
		$num_hash=implode("|",$num1_hash);
		$num_obs=implode("|",$num1_obs);
		$_SESSION[$var1]=$num;
		$_SESSION[$var1_hash]=$num_hash;
		$_SESSION[$var1_obs]=$num_obs;
		copy($_FILES["archivo"]["tmp_name"],"archivos adjuntos/".$arch_nomb);
	}else{
	unset($msg);
	$msg="EL TAMA�O DEL ARCHIVO ADJUNTO NO DEBE SER MAYOR A ".$row5['tam_archivo']." Mb";
	}}else{$msg="Archivo Adjunto no debe estar vac�o.";}
}
//ini_set("error_reporting", "E_ALL & ~E_NOTICE & ~E_WARNING");
include ("conexion.php");
function sendMail(){
	global $db;
	global $link;
	global $id_orden;
	global $msg;
	$sqlSystem="SELECT nombre, mail, web, conformidad, mail_institucion FROM control_parametros";
	$systemData=mysql_fetch_array(mysql_query( $sqlSystem));
	if ($systemData['conformidad']==1 OR $systemData['conformidad']==3)
	{
		$sqlTmp="SELECT cod_usr, desc_inc, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha, time FROM ordenes WHERE id_orden=$id_orden";
		$ordenTmp=mysql_fetch_array(mysql_query( $sqlTmp));
		if($ordenTmp[cod_usr]!="SISTEMA") 
		{
			$sqlCliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$ordenTmp[cod_usr]'";
			$ordenCliente=mysql_fetch_array(mysql_query( $sqlCliente));
			$clienteNombre=$ordenCliente['nom_usr'].' '.$ordenCliente['apa_usr'].' '.$ordenCliente['ama_usr'];
		}
		else 
		{	$msg=1;	}
	//*************************************************
		if ( !(empty($ordenCliente['email'])))
		{
			$asunto = "Nro. $id_orden. Solucion de Orden de Mesa de Ayuda";	
			$mail = $ordenCliente['email'];
			$mensaje = "
	Solucion de Orden de Mesa de Ayuda: Nro. $id_orden <br>
	Fecha de envio: $ordenTmp[fecha] $ordenTmp[time] <br>
	Descripcion: $ordenTmp[desc_inc] <br>

Su Orden ha sido solucionado. Por favor, ingrese su conformidad. <br>
Para mayores detalles, consulte el Sistema GesTor F1. $systemData[nombre]";
			$tunombre = $systemData['nombre'];		
			$tuemail  = $systemData['mail_institucion'];	
			$headers = "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			$headers .= "From: $tunombre <$tuemail>\r\n"; 						

			if(!mail($mail,$asunto,$mensaje,$headers))
			{ //$msg = "Precaucion, no se ha podido enviar la orden de solucion por correo electronico al Cliente.";				
			  $msg+=2;
			}
		}//end isset si correo no es vacio
		else {	$msg+=2;  }	 
	//***************************************************************
	}
}

//****************************************
$sql5="SELECT * FROM control_parametros";
$result5=mysql_query($sql5);
$row5=mysql_fetch_array($result5);
if (isset($_REQUEST['reg_form']))
{
	$login=$_SESSION["login"];
        $detalles_sol=$_REQUEST['detalles_sol'];
        $medprev_sol=$_REQUEST['medprev_sol'];
        /*$adjuntos_bo=$_REQUEST['medprev_sol'];
        $adjuntos_bo_hash=$_REQUEST['medprev_sol'];
        $adjuntos_bo_obs=$_REQUEST['medprev_sol'];*/
	if (!isset($login)) {header("location: index.php");}
	$sql1="SELECT * FROM solicitud WHERE OrdAyuda='$id_orden'";
	$result1=mysql_query($sql1);
	$row1=mysql_fetch_array($result1);

	$sql2="SELECT * FROM aprobus WHERE OrdAyuda='$id_orden'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);

	$sql4="SELECT * FROM asignacion WHERE id_orden='$id_orden' ORDER BY id_asig desc";
	$result4=mysql_query($sql4);
	$row4=mysql_fetch_array($result4);

	$detalles_sol = strip_tags($detalles_sol);
	$detalles = strip_tags($detalles);
	$medprev_sol = strip_tags($medprev_sol);
	$medidas = strip_tags($medidas);
	$f_sol_e=$_REQUEST['AnoD'].'-'.$_REQUEST['MesD'].'-'.$_REQUEST['DiaD'];
	//////////////
		$var1="ajuntos_bosol_".$id_orden;
		$adjuntos_bo=$_SESSION[$var1];
		$var1_hash="ajuntos_bosol_hash_".$id_orden;
		$adjuntos_bo_hash=$_SESSION[$var1_hash];
		$var1_obs="ajuntos_bosol_obs_".$id_orden;
		$adjuntos_bo_obs=$_SESSION[$var1_obs];
//////////////////
	$sql3="INSERT INTO ".
	"solucion (id_orden,detalles_sol,fecha_sol_e,fecha_sol,hora_sol,medprev_sol,login_sol,nomb_archivo,hash_archivo,observaciones) ".
	"VALUES('$id_orden','$detalles_sol','$f_sol_e','".date("Y-m-d")."','".date("H:i:s")."','$medprev_sol','$login','$adjuntos_bo','$adjuntos_bo_hash','$adjuntos_bo_obs')";
//print_r($sql3);exit;
        //session_unregister($var1);
	//session_unregister($var1_hash);//nuevo
	//session_unregister($var1_obs);//nuevo
	if ($row4['area']=="DyM")
	{	if (!$row1['OrdAyuda'] or !$row2['OrdAyuda'])
			{$msg = "LLENAR LOS DATOS DE LA SOLICITUD Y APROBACION EN DESARROLLO Y MANTENIMIENTO";}
		else
		{ 	mysql_query($sql3);
		
			if($conf=="1")
			{
			  $sql_conf="INSERT INTO ".
			  "conformidad (id_orden,fecha_conf,hora_conf,tiemposol_conf,calidaten_conf,obscli_conf,reg_conf, tipo_conf)".
			  "VALUES('$id_orden','".date("Y-m-d")."','".date("H:i:s")."','2','2','El cliente y el tecnico son los mismos','$login','1')";
			  mysql_query($sql_conf);
			}
			
			sendMail();
			header("location: lista_asig.php?msg=$msg");
			exit;
		}
	}
	else
	{
		if (mysql_query($sql3)) 
		{	
			if($conf=="1")
			{
			  $sql_conf="INSERT INTO ".
			  "conformidad (id_orden,fecha_conf,hora_conf,tiemposol_conf,calidaten_conf,obscli_conf,reg_conf, tipo_conf)".
			  "VALUES('$id_orden','".date("Y-m-d")."','".date("H:i:s")."','2','2','El cliente y el tecnico son los mismos','$login','1')";				mysql_query($sql_conf);
			}else{
			    sendMail(); 
			}
			
			//sendMail(); 
			header("location: lista_asig.php?msg=$msg&aaaa=asdfg");
			exit;
		}
	}
}
else
{$id_orden=($_GET['id_orden']);}
include("top.php");
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addCompareDates ("DiaD","MesD","AnoD","d1","m1","a1", "Fecha de Ejecucion y Fecha de Registro, $errorMsgJs[compareDates2]");
$valid->addExists( "detalles_sol",  "Detalles de la Solucion, $errorMsgJs[empty]" );
$valid->addLength ( "detalles_sol",  "Detalles de la Solucion, $errorMsgJs[length]" );
$valid->addExists( "medprev_sol",  "Medidas Preventivas Recomendadas, $errorMsgJs[empty]" );
$valid->addLength ( "medprev_sol",  "Medidas Preventivas Recomendadas, $errorMsgJs[length]" );
print $valid->toHtml ();
?> 
<script language="JavaScript">
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}

</script>
<strong><font face="Verdana, Arial, Helvetica, sans-serif" color='#FF0000'><?php //echo $msg;?></font></strong> 
<form name="form2" method="post" enctype="multipart/form-data" onKeyPress="return Form()">
<input name="id_orden" type="hidden" value="<?php echo $id_orden;?>">
<?php $hoy=date("Y-m-d");
$a1=substr($hoy,0,4);
$m1=substr($hoy,5,2);
$d1=substr($hoy,8,2);?>
<input name="a1" type="hidden" value="<?php echo $a1;?>">
<input name="m1" type="hidden" value="<?php echo $m1;?>">
<input name="d1" type="hidden" value="<?php echo $d1;?>">
  
 <table width="600" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" background="images/fondo.jpg">
 <tr><td>
  <table >
    <tr> 
      <td width="100%" colspan="1"><table width="600" border="0" align="center" cellpadding="0" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" bgcolor="#006699"><font color="#FFFFFF">SOLUCION</font></th>
          </tr>
          <tr align="center"> 
            <td colspan="2"><div align="left"><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Orden 
                Nro :</font> 
                <input name="id_orden2" type="text" id="id_orden" value="<?php echo $id_orden;?>" size="4" readonly="">
                </strong></font></div></td>
          </tr>
          <tr> 
            <td colspan="2" align="center"><div align="left"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Descripcion:</font> 
                </b> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <?php $sqlTmp="SELECT desc_inc,cod_usr,nomb_archivo,hash_archivo,observaciones FROM ordenes WHERE id_orden=$id_orden";
				$ordenTmp=mysql_fetch_array(mysql_query( $sqlTmp));
				print $ordenTmp['desc_inc'];
				?>
                </font> </div>
              
            </td>
          </tr>
          <tr>
            <td height="40" colspan="2" align="left"><table width="100%" border="0">
                <tr>
                  <td width="99%" valign="top"><div align="left"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Archivos 
                      Adjuntos: </font></b></div></td>
                  <td width="1%">
				</tr>
				<tr>
				 <td>
					<?php
					if($ordenTmp['nomb_archivo'])
					{
						echo"
						<table width='100%' border='1' cellpadding='0' cellspacing='0'>
						<tr>
						 <td width='50%' align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>Nombre</b></font></td>
						 <td width='50%' align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>Observaciones</b></font></td>
						</tr>";
						
						$adj=explode("|",$ordenTmp['nomb_archivo']);
						$adj_hash=explode("|",$ordenTmp['hash_archivo']);
						$adj_obs=explode("|",$ordenTmp['observaciones']);
						//echo "<br>archivo : ".$adj[0];
						//echo "<br>hash : ".$adj_hash[0];
						//echo "<br>observa : ".$adj_obs[0];
						$i=0;
						foreach($adj as $valor)
						{
							echo "<tr><td align=\"center\"><a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor</a><br>&nbsp;$adj_hash[$i]</td><td>&nbsp;&nbsp;$adj_obs[$i]</td></tr>";
							$i++;
						}
					}
					else
					{
						echo "
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
						<tr><td align=\"center\" colspan='2'>NINGUNO</td></tr>
						";
					}
					echo "</table>";
					?>
                    </td>
                </tr>
              </table>
              <hr></td>
          </tr>
          <?php
		  	$sql = "SELECT *, DATE_FORMAT(fecha_sol, '%d/%m/%Y') as fecha_sol, DATE_FORMAT(fecha_sol_e, '%d/%m/%Y') as fecha_sol_e FROM solucion WHERE id_orden='$id_orden'";
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
		  ?>
          <tr> 
            <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Fecha 
              de ejecucion de solucion:</strong> </font>&nbsp; <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <?php 
			  if (!$row['id_orden']){
			  ?>
              <select name="DiaD" id="select">
                <?php
					$fsist=date("Y-m-d");
					$a2=substr($fsist,0,4);
					$m2=substr($fsist,5,2);
					$d2=substr($fsist,8,2);
					
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d2=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select>
              <select name="MesD" id="select2">
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m2=="$i") echo "selected"; echo">$i</option>";
					  }
			      ?>
              </select>
              <select name="AnoD" id="select3">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a2=="$i") echo "selected"; echo">$i</option>";
				      }
	    			?>
              </select>
              <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
              <?php }
			  else
			  {echo $row['fecha_sol_e'];}
			  ?>
              </font> </td>
          </tr>
          <tr> 
            <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Fecha 
              de registro de solucion:</strong> </font><font size="2"> 
              <?php if (!$row['id_orden']){echo date("d/m/Y");}
			  		else{echo $row['fecha_sol'];}?>
              </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
              <strong>Hora:</strong> </font><font size="2"> 
              <?php if (!$row['id_orden']){echo date("H:i:s");}
	  				else{echo $row['hora_sol'];}?>
              </font></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Detalles 
                de la Solucion</strong></font></div></td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <?php if (!$row['id_orden']) {?>
                    <textarea name="detalles_sol" cols="80" rows="4" id="textarea"><?php=$sDetail?></textarea>
                    <textarea name="detalles" cols="80" rows="4" id="textarea" style="display:none"><?php=$sDetail?></textarea>
                <?php } else
				{echo $row['detalles_sol'];}
				?>
                </font></div></td>
          </tr>
          <tr> 
            <td height="16" colspan="2"><div align="center"></div>
              <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><br>
                </strong></font></div></td>
          </tr>
          <tr> 
            <td height="16" colspan="2"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Medidas 
                Preventivas Recomendadas</font></strong> </div></td>
          </tr>
          <tr> 
            <td colspan="2"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <?php if (!$row['id_orden']) {?>
                    <textarea name="medprev_sol" cols="80" rows="4" id="textarea2"><?php=$sMedidas?></textarea>
                    <textarea name="medidas" cols="80" rows="4" id="textarea2" style="display:none"><?php=$sMedidas?></textarea>
                <?php } else
				{echo $row['medprev_sol'];}?>
                </font></div></td>
          </tr>
          <tr align="center"> 
            <td height="26" colspan="2" align="center">&nbsp;</td>
          </tr>
          <?php if (!$row['id_orden']) {?>
          <?php 
		 	$sql_a="SELECT asig FROM asignacion WHERE id_orden='$id_orden' ORDER BY id_asig desc";
			$result_a=mysql_query($sql_a);
			$row_a=mysql_fetch_array($result_a);
			 if ($row_a['asig']==$ordenTmp['cod_usr']){?>
          <tr> 
            <td align="center"><div align="left"><b><font size="2" face="Arial, Helvetica, sans-serif">Dar 
                su conformidad automaticamente: 
                <input type="radio" name="conf" value="1" checked>
                SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="radio" name="conf" value="0">
                NO </font></b></div></td>
          </tr>
          <?php }}
		  else
		  {
			echo "<tr>";
		//	echo "<td width=\"5%\"></td>";
			if (!$row['nomb_archivo']){
			echo "<td width=\"5%\"></td>";
			echo "<td width=\"95%\"><div align=\"center\"><font face=\"arial,helvetica\" size=\"2\"><strong>ARCHIVO ADJUNTO : </strong>Ninguno</font></div></td></tr>";}
			else {
				$adjuntos_bo=explode("|",$row['nomb_archivo']);
				$adjuntos_bo_hash=explode("|",$row['hash_archivo']);
				$adjuntos_bo_obs=explode("|",$row['observaciones']);
				echo "<td width=\"95%\"><div align=\"center\"><font face=\"arial,helvetica\" size=\"2\"><strong>Archivos Adjuntos :</strong></font></div></td></tr>";
				$i=0;
				
				echo"
				<tr> 
					<td width='93%' >
						<table width='591' cellpadding='0' cellspacing='0' border='1'>
						<tr>
							<td width='293'><div align='center'><strong><font size='2'>Nombre</font></strong></div></td>
							<td width='292'><div align='center'><strong><font size='2'>Observaciones</font></strong></div></td>
						</tr>
				
				";
                                $i=0;
				foreach($adjuntos_bo as $valor){
					echo "<tr><td align='center'><a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor</a><br>MD5: $adjuntos_bo_hash[$i]<td>&nbsp;&nbsp;$adjuntos_bo_obs[$i]</td></tr>";
					$i++;
				}
				//echo "<td width=\"95%\"><div align=\"center\"><font face=\"arial,helvetica\" size=\"2\"><strong>Archivo Adjunto : </strong><a href=\"archivos adjuntos/".$row[nomb_archivo]."\" target=\"_blank\">$row[nomb_archivo]</a></font></div></td>";
				}
		    echo "
				</table>
				</td>
			  </tr>
			";
		  }
		  ?>
          <tr align="center"> 
            <td height="30" colspan="2"><br> 
              <?php if (!$row['id_orden']) {?>
              <input name="reg_form" type="submit" id="reg_form" value="GUARDAR" <?php print $valid->onSubmit() ?>> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <?php }?>
              <input type="submit" name="RETORNAR" value="RETORNAR"></td>
          </tr>
          <tr> 
            <td height="19" colspan="2">&nbsp;</td>
          </tr>
          <!--</form>-->
          <!--<form name="form1" method="post" enctype="multipart/form-data" onKeyPress="return Form()">-->
          <?php if (!$row['id_orden']) {?>
          <?php
			$var1="ajuntos_bosol_".$id_orden;
			$var1_hash="ajuntos_bosol_hash_".$id_orden;
			$var1_obs="ajuntos_bosol_obs_".$id_orden;
			if(isset($_SESSION[$var1])){
				$adjuntos_bo=$_SESSION[$var1];
                                //echo $adjuntos_bo;
				$adjuntos_bo=explode("|",$adjuntos_bo);
				$adjuntos_bo_hash=$_SESSION[$var1_hash];
				$adjuntos_bo_hash=explode("|",$adjuntos_bo_hash);
				$adjuntos_bo_obs=$_SESSION[$var1_obs];
				$adjuntos_bo_obs=explode("|",$adjuntos_bo_obs);
				?>
          <tr> 
            <td colspan="2"><div align="left"><strong><font size="2">Archivos Adjuntos:</font></strong></div></td>
          </tr>
		 <!---->
		 <tr> 
            
			<td width="93%" >
				<table width="591" cellpadding="0" cellspacing="0" border="1">
				<tr>
					<td width="293"><div align="center"><strong><font size="2">Nombre</font></strong></div></td>
					<td width="292"><div align="center"><strong><font size="2">Observaciones</font></strong></div></td>
				</tr>
			 
			 <?php	$i=0;
		  		foreach($adjuntos_bo as $valor){
					echo "<tr><td align='center'><a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor</a><br>MD5: $adjuntos_bo_hash[$i]<td>&nbsp;&nbsp;$adjuntos_bo_obs[$i]</td></tr>";
					$i++;
				}
			 }
			 ?>
			 </table>
			</td>
		  </tr>
		  <!---->
          <tr align="center"> 
            
            <td width="96%" align="center"><div align="left"><b><font size="2" face="Arial, Helvetica, sans-serif"> 
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;Enviar Archivo Adjunto <br>
                </font></b><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;( 
                tipo : .gif &nbsp;&nbsp;.jpg&nbsp;&nbsp; .doc &nbsp;&nbsp;&nbsp;&nbsp;y 
                &nbsp;&nbsp;tamano maximo : <?php echo $row5['tam_archivo'];?> Mb ) 
                : </font></div></td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> <div align="center"> 
                <input name="archivo" type="file" size="60" value="<?php print $archivo ?>" onClick="msgFile()">
                <br>
              </div></td>
          </tr>
		  <!---->
		  <tr>
  		    <td colspan="2">
				<table width="534">
					<tr>
						<td width="127" align="right"><font size="2" face="Arial, Helvetica, sans-serif"><b>Observaciones</b></font></td>
						<td width="395"><textarea name="txtObservacion" cols="50" rows="2"></textarea></td>
					</tr>
			  </table>
			</td>
	     </tr>
		  <!---->
          <tr>
            <td align="center"><input name="adjunt" type="submit" value=" ADJUNTAR " onClick="return validar()"></td>
          </tr>
          <tr>
           <td>&nbsp;</td>
          </tr>
          <?php }?>
        </table></td>
    </tr>
  </table>
  </td>
 </tr>
</table>
</form>
<script language="JavaScript">
		<!-- 
		<?php if (!$row[id_orden]){?>
		var form="form2";
	 	var cal = new calendar1(document.forms[form].elements['DiaD'], document.forms[form].elements['MesD'], document.forms[form].elements['AnoD']);
	 	cal.year_scroll = true;
		cal.time_comp = false;
		<?php }
		print "function msgFile () {\n
				alert (\"Atencion, solamente puede enviar archivos menor o igual a $row5[tam_archivo] Mb de tamano.\\n \\nMensaje generado por GesTor F1.\");\n
				}\n";
		if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
</script>
<script language="javascript1.2">
function validar()
{
	msg1 = "\nMensaje generado por GesTor F1.";
	sCad = "";
	if(document.form2.archivo.value == ""){sCad = sCad + "Debe adjuntar un archivo\n";}
	if(document.form2.txtObservacion.value == ""){sCad = sCad + "Debe llenar el campo de Observaciones\n";}
	if(sCad == ""){return true;}
	else{
		sCad = sCad + msg1;
		alert(sCad);
		return false;
	}
}
</script>
<?php include("top_.php");?>
