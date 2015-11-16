<?php  
include("conexion.php");
$cad = $dato;
if (isset($insertar))
{	
		session_start();
		$login=$_SESSION["login"];

		$fecas_ac="$Ano-$Mes-$Dia";
		if($selecciona=="nuevo")
		{
		$sql_i = "SELECT MAX(id_ac) AS num_pru FROM acciones WHERE id_acc=$num";
		$result_i = mysql_db_query($db,$sql_i,$link);
		$row_i = mysql_fetch_array($result_i);
		$id_ac=$row_i[num_pru]+1;
		
		$sql_t = "SELECT MAX(id_acciones) AS num_t FROM acciones";
		$result_t = mysql_query($sql_t);
		$row_t = mysql_fetch_array($result_t);
		$id_act=$row_t['num_t']+1;
		
		$sql="INSERT INTO acciones (id_ac, serie_ac,valor_ac,fecas_ac,num_ac,id_acc,class_ac,id_accionistas,estado) VALUES ('$id_ac','$serie_ac','$valor_ac','$fecas_ac','$num_ac','$num','$class_ac','$num','0')";
		//$sql_bk="INSERT INTO acciones_bk (id_ac, serie_ac,valor_ac,fecas_ac,num_ac,id_acc,class_ac,id_accionistas) VALUES ('$id_ac','$serie_ac','$valor_ac','$fecas_ac','$num_ac','$num','$class_ac','$num')";
		$sql_bk="INSERT INTO acciones_bk (id_acciones,id_ac, serie_ac,valor_ac,fecas_ac,num_ac,id_acc,class_ac,id_accionistas) VALUES ('$id_act','$id_ac','$serie_ac','$valor_ac','$fecas_ac','$num_ac','$num','$class_ac','$num')";
	
		}
		else
		{
			$sql="UPDATE acciones SET serie_ac='$serie_ac', valor_ac='$valor_ac', fecas_ac='$fecas_ac',num_ac='$num_ac', class_ac='$class_ac' WHERE id_acc='$num' AND id_ac='$selecciona'";
		}
		if(mysql_query($sql))
		{	mysql_query($sql_bk) or die("Error en consulta <br>MySQL dice: ".mysql_error());	}
		$sql=str_replace("'","´",$sql);
		$sql_log="INSERT INTO accion_log (date_log, acc_log, usr_log, ip_log) VALUES ('".date("Y-m-d")." ".date("H:m:s")."', '$sql', '$login','".$_SERVER['REMOTE_ADDR']."')";
		mysql_db_query($db,$sql_log,$link);
}
if (isset($Terminar))
{
	header("location: accionistas.php");
}
include("top.php");
$id_minuta=($_GET['id_minuta']);
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "serie_ac",  "Descripcion de la Prueba,  $errorMsgJs[empty]" );
$valid->addLength ( "desc_pru",  "Descripcion de la Prueba,  $errorMsgJs[length]" );
$valid->addFunction ( "validaTiempo2",  "" );
//$valid->addIsNotEmpty ( "tiem_est",  "Tiempo Estimado, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "obs_pru",  "Observaciones,  $errorMsgJs[empty]" );
$valid->addLength ( "obs_pru",  "Observaciones,  $errorMsgJs[length]" );
print $valid->toHtml ();
?>  
<script language="JavaScript" src="calendar.js"></script>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
	background-color:#FFFFFF
}
-->
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
				$sql_acc="SELECT * FROM accionistas WHERE id_acc = '$num'";
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
?>">Modificar</div></td>
                </tr>
              </table></td>
          </tr>
    </table>
        <input name="num" type="hidden" value="<?php=$num?>">
  <table width="75%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th colspan="7" background="images/main-button-tileR1.jpg">DETALLE DE ACIONES<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
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
		$sql = "SELECT * FROM acciones WHERE id_accionistas='$num' ORDER BY id_ac ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
	?>
    <tr align="center"> 
      <td>&nbsp;<?php echo "<a href=\"naccionista_det.php?np=$row[id_ac]&num=$num\">$row[id_ac]</a>";?></td>
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

    <tr> 
      <td colspan="7" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
        <div align="center"></div></td>
    </tr>
    <tr> 
      <td height="7" nowrap bgcolor="#006699"><select name="selecciona" onChange="cambia(this.value)">
        <option value="nuevo" selected>Nuevo</option>
        <?php 
		  	$sql_r = "SELECT id_ac FROM acciones WHERE id_acc='$num' ORDER BY id_ac ASC";
			$result_r=mysql_db_query($db,$sql_r,$link);
			while($row_r=mysql_fetch_array($result_r)) 
			{	
				echo "<option value=\"$row_r[id_ac]\"";
				if($np==$row_r[id_ac]){echo "selected";}
				echo ">$row_r[id_ac]</option>";
			}
		  ?>
      </select></td>
      <td><div align="center">
        <input name="serie_ac" type="text" value="<?php echo $row_ed[serie_ac];?>">
      </div></td>
      <td><div align="center">
        <input name="valor_ac" type="text" value="<?php echo $row_ed[valor_ac];?>" size="10">
      </div></td>
      <td>
	    <div align="center">
	      <select name="Dia" class="Estilo1">	
	        <?php
				$fsist=date("Y-m-d");
  				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
				if (!(empty($nro)))
				{	$fec = explode("-", $row9[FechaPlanifica]);
					$a1 = substr($row9[FechaPlanifica],0,4);
					$m1 = substr($row9[FechaPlanifica],5,2);
					$d1 = substr($row9[FechaPlanifica],8,2);
				}
				for($i=1;$i<=31;$i++)
				{
	              echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
				}
				?>
          </select>
	      <select name="Mes" class="Estilo1">
	        <?php
				for($i=1;$i<=12;$i++)
				{
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
				}
				?>
          </select>
	      <select name="Ano" class="Estilo1">
	        <?php
				for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
          </select>
      <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a>        </div></td>
      <td><div align="center"><input name="num_ac" type="text" value="<?php echo $row_ed[num_ac];?>" size="10" /></div></td>
	  <td><div align="center"><input name="class_ac" type="text" value="<?php if($row_ed[class_ac]) echo $row_ed[class_ac]; else echo "Ordinaria";?>" size="15" /></div></td>
    </tr>
    <tr> 
      <td height="28" colspan="11" nowrap> <div align="center"><br>
          <input name="insertar" type="submit" id="reg_form3" value="INSERTAR DATOS" <?php print $valid->onSubmit() ?>>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="Terminar" value="TERMINAR">
        </div></td>
    </tr>
  </table>     
  </form>
  
<script language="JavaScript">
<!-- 
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}			

		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
		var form="form2";
		var cal = new calendar1(document.forms[form].elements['Dia'], document.forms[form].elements['Mes'], document.forms[form].elements['Ano']);
		 cal.year_scroll = true;
		cal.time_comp = false;
		
function validaTiempo2 () {
	var form=document.form2;
	var msg="\n \n Mensaje generado por GesTor F1.";
	 if (form.tiem_est.value == "")
	{
		alert ("Tiempo Estimado, no puede ser vacio" + msg);
		return ( false );
	}
	else if (form.tiem_est.value.length > 0) 
	{
		if (form.tiem_est.value.search(new RegExp("^([0-9])+$","g"))<0) 
		{
			alert ("Tiempo, debe ser un valor numerico entero" + msg);
			return ( false );
		}
		else
		{
			if (form.tiem_est.value>9000000)
			{
				alert ("Tiempo, debe ser un valor menor o igual a 9000000" + msg);
				return ( false );
			}
		}
	}
	else if (form.tiem_est.value.length < 0)
	{
		alert ("Tiempo, debe ser un valor mayor o igual a 0" + msg);
		return ( false );
	}
	return true;
}
function irapagina_c(pagina){        
     	 	self.location = pagina;
 		 }
function cambia(numero)
{        

		var num="<?php echo $num;?>";
		if (numero == "nuevo") {irapagina_c("naccionista_det.php?num="+num);}
		else {irapagina_c("naccionista_det.php?np="+numero+"&num="+num);}
}
//-->
</script>
<?php include("top_.php");?>
