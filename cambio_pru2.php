<?php 
include("conexion.php");
if(!empty($dato)) {$cad = $dato; }
if (isset($insertar))
{	
	$ha=md5($orden);
	$tp_e=explode("_",$tp);
	if($tp_e[1]==$ha)
	{
		
		if($codifica=="nuevo")
		{
			$sql_i1 = "SELECT MAX(num_pru) AS num_pru FROM cambios_prueba2_planif WHERE id_pru='$num'";
			$result_i1 = mysql_db_query($db,$sql_i1,$link);
			$row_i1 = mysql_fetch_array($result_i1);
						
			$sql_i2 = "SELECT MAX(num_pru) AS num_pru FROM cambios_prueba2 WHERE id_pru='$num'";
			$result_i2 = mysql_db_query($db,$sql_i2,$link);
			$row_i2 = mysql_fetch_array($result_i2);
			
			if($row_i1['num_pru']>$row_i2['num_pru']){$num_pru1=$row_i1['num_pru']+1;}
			else{$num_pru1=$row_i2['num_pru']+1;}
			
			$sql="INSERT INTO cambios_prueba2 (id_pru,num_pru,desc_pru,tiem_est,tiem_real,calif,obs_pru)".
			"VALUES ('$num','$num_pru1','$desc_pru','$tiem_est','$tiem_real','$calif','$obs_pru')";
			mysql_db_query($db,$sql,$link);		
		}
		else
		{
			$sqled = "SELECT count(*) as filas FROM cambios_prueba2 WHERE id_pru='$num' AND num_pru='$np'";
			$resulted=mysql_db_query($db,$sqled,$link);
			$rowed=mysql_fetch_array($resulted);
			
			if($rowed['filas']=="0")
			{
				$sql="INSERT INTO cambios_prueba2 (id_pru,num_pru,desc_pru,tiem_est,tiem_real,calif,obs_pru)".
				"VALUES ('$num','$np','$desc_pru2','$tiem_est','$tiem_real','$calif','$obs_pru')";
				mysql_db_query($db,$sql,$link);
			}
			else
			{
				$sql="UPDATE cambios_prueba2 SET tiem_real='$tiem_real',calif='$calif',obs_pru='$obs_pru' WHERE id_pru='$num' AND num_pru='$np'";
				mysql_db_query($db,$sql,$link);		
			}
		}
	}
	else
	{ header("location: lista_prueba.php?Naveg=Cambios >> Pruebas&msg=2");}												
}
if (isset($Terminar))
{
	header("location: lista_prueba.php?Naveg=Cambios >> Pruebas");
}

include("top.php");

require_once ("ValidatorJs.php");
$valid = new Validator ("form1");
$valid->addIsNotEmpty ("desc_pru","Descripcion de la Prueba, $errorMsgJs[empty]");
$valid->addLength ( "desc_pru",  "Descripcion de la Prueba,  $errorMsgJs[length]" );
$valid->addFunction ( "validaTiempo1",  "" );
$valid->addFunction ( "validaTiempo2",  "" );
//$valid->addIsNotEmpty ( "tiem_est",  "Tiempo Estimado, $errorMsgJs[empty]" );
//$valid->addIsNotEmpty ( "tiem_real",  "Tiempo Real, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "obs_pru",  "Observaciones,  $errorMsgJs[empty]" );
$valid->addLength ( "obs_pru",  "Observaciones,  $errorMsgJs[length]" );

print $valid->toHtml ();


if(!isset($np)){$codifica="nuevo";}
else{$codifica="";}
?>  
  <form action="<?php echo $PHP_SELF?>" name="form1" method="post"  onKeyPress="return Form()">
	<input name="orden" type="hidden" value="<?php echo $orden;?>">
	<input name="tp" type="hidden" value="<?php echo $tp; ?>">
	<input name="num" type="hidden" value="<?php echo $num; ?>">
	<input name="codifica" type="hidden" value="<?php echo $codifica; ?>">
	<table width="95%" border="1" align="center" background="images/fondo.jpg">
          <tr> 
            
      <th>EJECUCION - PRUEBAS 
        <?php	
			 $tp2=md5($orden);
	  		if($tp=="258db52a0b75ba2448af531309ad5eac_".$tp2){echo "USUARIAS";}
			elseif($tp=="7d428547b8723786029735cde7b75d7d_".$tp2){echo "DE SISTEMAS";}
			elseif($tp=="f4b29b15eee509a8fa39344471561d29_".$tp2){echo "DE SEGURIDAD";}
	  ?>
      </th>
          </tr>
          <tr> 
            <td height="52"><table width="100%" border="0">
                <tr> 
                  <td width="2%">&nbsp;</td>
                  <td><font size="2"><strong>Orden Nro.:</strong></font></td>
                  <td width="55%"><font size="2"><?php echo $orden;?></font></td>
                  <td width="11%"><font size="2"><strong>Fecha y Hora :</strong></font></td>
                  <td width="23%"><font size="2">&nbsp;<?php echo date("d/m/Y  H:i:s")?></font></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td width="9%"><font size="2"><strong>Descripcion:</strong></font></td>
                  <td colspan="3"><font size="2"> 
                    <?php $sqlTmp="SELECT desc_inc FROM ordenes WHERE id_orden=$orden";
				$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
				print $ordenTmp['desc_inc'];
				?>
                    &nbsp;</font></td>
                </tr>
              </table></td>
          </tr>
        </table>
        
  <table width="95%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th colspan="11" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
        TIPOS DE PRUEBA</font></th>
    </tr>
    <tr> 
      <th width="44" nowrap bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
      <th width="200" nowrap bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">DESCRIPCION 
        DE LA PRUEBA</font></th>
      <th width="180" nowrap bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">TIEMPO 
        ESTIMADO (Minutos)</font></th>
      <th width="180" nowrap bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">TIEMPO 
        REAL (Minutos)</font></th>
      <th width="20" nowrap bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">SI</font></th>
      <th width="20" nowrap bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NO</font></th>
      <th width="200" nowrap bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">OBSERVACIONES</font></th>
    </tr>
    <?php
		$cont=0;	
		$sql = "SELECT * FROM cambios_prueba2_planif WHERE id_pru='$num' ORDER BY num_pru ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
	?>
    <tr align="center"> 
      <td>&nbsp;<?php echo "<a href=\"cambio_pru2.php?orden=$orden&tp=$tp&np=$row[num_pru]&num=$num\">$row[num_pru]</a>";?></td>
	  <td>&nbsp;<?php echo $row['desc_pru']?></td>
      <td>&nbsp;<?php echo $row['tiem_est']?></td>
	  
	  <?php
	  	$sql2 = "SELECT * FROM cambios_prueba2 WHERE id_pru='$num' AND num_pru='$row[num_pru]'";
		$result2=mysql_db_query($db,$sql2,$link);
		$row2=mysql_fetch_array($result2);
	  ?>
      <td>&nbsp;<?php if($row2['tiem_real']){echo $row2['tiem_real'];}else{echo "&nbsp;";}?></td>
      <?php 
	  
	  	if($row2['calif']=="SI")
	    {echo "<td><img src=\"images/si1.gif\" width=\"10\" height=\"10\"></td>";
		 echo "<td>&nbsp;</td>";}
		elseif($row2['calif']=="NO")
		{echo "<td>&nbsp;</td>";
		echo "<td><img src=\"images/si1.gif\" width=\"10\" height=\"10\"></td>";}
		elseif(!$row2['calif'])
		{echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";}
	  ?>
      <td>&nbsp;<?php if($row2['obs_pru']){echo $row2['obs_pru'];}else{echo $row['obs_pru'];}?></td>
    </tr>
    <?php 
		 }
		 ?>
	
	<?php  $sql = "SELECT * FROM cambios_prueba2 WHERE id_pru='$num' ORDER BY num_pru ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
			$sql2 = "SELECT count(*) as holas FROM cambios_prueba2_planif WHERE id_pru='$num' AND num_pru='$row[num_pru]'";
			$result2=mysql_db_query($db,$sql2,$link);
			$row2=mysql_fetch_array($result2);
			
			if($row2['holas']=="0")
			{  ?>
				<tr align="center"> 
				  <td>&nbsp;<?php echo "<a href=\"cambio_pru2.php?orden=$orden&tp=$tp&np=$row[num_pru]&num=$num\">$row[num_pru]</a>";?></td>
				  <td>&nbsp;<?php echo $row['desc_pru']?></td>
				  <td>&nbsp;<?php echo $row['tiem_est']?></td>
				  <td>&nbsp;<?php echo $row['tiem_real'];?></td>
				  <?php 
				  
					if($row['calif']=="SI")
					{echo "<td><img src=\"images/si1.gif\" width=\"10\" height=\"10\"></td>";
					 echo "<td>&nbsp;</td>";}
					elseif($row['calif']=="NO")
					{echo "<td>&nbsp;</td>";
					echo "<td><img src=\"images/si1.gif\" width=\"10\" height=\"10\"></td>";}
				?>
				  <td>&nbsp;<?php echo $row['obs_pru'];?></td>
				</tr>
				<?php 
					} }
					 ?>
	
	
		 
		 
    <tr> 
      <td colspan="11" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
        <div align="center"></div></td>
    </tr>
   <?php
	if(!empty($np))
	{		
		$sql_ed = "SELECT count(*) as filas FROM cambios_prueba2 WHERE id_pru='$num' AND num_pru='$np'";
		$result_ed=mysql_db_query($db,$sql_ed,$link);
		$row_ed=mysql_fetch_array($result_ed);
		
		if($row_ed['filas']=="0")
		{
			$sql_ed = "SELECT * FROM cambios_prueba2_planif WHERE id_pru='$num' AND num_pru='$np'";
			$result_ed=mysql_db_query($db,$sql_ed,$link);
			$row_ed=mysql_fetch_array($result_ed);
		}
		else
		{
			$sql_ed = "SELECT * FROM cambios_prueba2 WHERE id_pru='$num' AND num_pru='$np'";
			$result_ed=mysql_db_query($db,$sql_ed,$link);
			$row_ed=mysql_fetch_array($result_ed);
		}
	}
	?>
    <tr> 
      <td width="44" height="7" nowrap><div align="center">
          <select name="selecciona" onChange="cambia(this.value)">
		  <option value="nuevo" selected>Nuevo</option>
		  <?php 
		  	$sql_r = "SELECT num_pru FROM cambios_prueba2_planif WHERE id_pru='$num' ORDER BY num_pru ASC";
			$result_r=mysql_db_query($db,$sql_r,$link);
			while($row_r=mysql_fetch_array($result_r)) 
			{	echo "<option value=\"$row_r[num_pru]\"";
				if($np==$row_r['num_pru']){echo "selected";}
				echo ">$row_r[num_pru]</option>";
			}
			
			
			$sql_r = "SELECT * FROM cambios_prueba2 WHERE id_pru='$num' ORDER BY num_pru ASC";
			$result_r=mysql_db_query($db,$sql_r,$link);
			while($row_r=mysql_fetch_array($result_r)) 
			{
				$sql2_r = "SELECT count(*) as holas FROM cambios_prueba2_planif WHERE id_pru='$num' AND num_pru='$row_r[num_pru]'";
				$result2_r=mysql_db_query($db,$sql2_r,$link);
				$row2_r=mysql_fetch_array($result2_r);
				
				if($row2_r['holas']=="0")
				{  	
					echo "<option value=\"$row_r[num_pru]\"";
					if($np==$row_r['num_pru']){echo "selected";}
					echo ">$row_r[num_pru]</option>";
				}
			}
			 ?>
				
			
			
		
            
          </select>
        </div></td>
      <td nowrap><div align="center"><strong> 
	    <input name="desc_pru2" type="hidden" value="<?php echo $row_ed['desc_pru'];?>">
	  <?php 
	  if($codifica=="nuevo"){?>
	  <textarea name="desc_pru" cols="25" rows=""></textarea>
	  <?php }
	  else {?>
          &nbsp;<?php echo $row_ed['desc_pru'];?>
	<?php }?>
          </strong></div></td>
      <td nowrap><div align="center"><strong> 
          <input name="tiem_est" type="text" size="15" maxlength="15" value="<?php if(!empty($row_ed['tiem_est'])) { echo $row_ed['tiem_est']; } ?>" <?php if($codifica!="nuevo"){echo "readonly";}?>>
          Min. </strong></div></td>
      <td width="180" nowrap><div align="center"><strong> 
          <input name="tiem_real" type="text" size="15" maxlength="15" value="<?php if(!empty($row_ed['tiem_real'])) { echo $row_ed['tiem_real']; } ?>">
          Min. </strong></div></td>
      <td width="20" height="7" nowrap><div align="center">
	  <input type="radio" name="calif" value="SI" <?php if($row_ed['calif']=="SI" OR !$np OR !$row_ed['calif']){echo "checked";}?>></div></td>
      <td width="20" height="7" nowrap><div align="center"><input type="radio" name="calif" value="NO" <?php if($row_ed['calif']=="NO"){echo "checked";}?>></div></td>
      <td width="200" height="7" nowrap><strong>
        <textarea name="obs_pru" cols="30"><?php if(!empty($row_ed['obs_pru'])) { echo $row_ed['obs_pru']; }?></textarea>
        </strong></td>
    </tr>
    <tr> 
      <td height="7" colspan="7">&nbsp;</td>
    </tr>
    <tr> 
      <td height="7" colspan="7"><font size="2"><strong>Total Tiempo Estimado: 
        </strong></font> 
        <?php 
		$sql_tot="SELECT SUM(tiem_est) AS total_tiempo FROM cambios_prueba2_planif WHERE id_pru='$num'";
		$result_tot=mysql_db_query($db,$sql_tot,$link);
		$row_tot=mysql_fetch_array($result_tot);
		if(!$row_tot['total_tiempo']){echo "0 minutos";}
		else{echo $row_tot['total_tiempo']." minutos";}
		?>
        <font size="2"><strong><br>
        Total Tiempo Real: </strong></font> 
        <?php 
		$sql_tot="SELECT SUM(tiem_real) AS total_tiempo_r FROM cambios_prueba2 WHERE id_pru='$num'";
		$result_tot=mysql_db_query($db,$sql_tot,$link);
		$row_tot=mysql_fetch_array($result_tot);
		if(!$row_tot['total_tiempo_r']){echo "0 minutos";}
		else{echo $row_tot['total_tiempo_r']." minutos";}
		?>
      </td>
    </tr>
    <tr> 
      <td height="28" colspan="11" nowrap> <div align="center"><br>
	
	  <input name="np" type="hidden" value="<?php echo $np; ?>">
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
function irapagina_c(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function cambia(numero)
{        
		var orden="<?php echo $orden;?>";
		var tp="<?php echo $tp;?>";
		var num="<?php echo $num;?>";
		if (numero == "nuevo") {irapagina_c("cambio_pru2.php?orden="+orden+"&tp="+tp+"&num="+num+"&codifica=nuevo");}
		else {irapagina_c("cambio_pru2.php?orden="+orden+"&tp="+tp+"&np="+numero+"&num="+num);}
}	

function validaTiempo1 () {
	var form=document.form1;
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
function validaTiempo2 () {
	var form=document.form1;
	var msg="\n \n Mensaje generado por GesTor F1.";
	 if (form.tiem_real.value == "")
	{
		alert ("Tiempo Real, no puede ser vacio" + msg);
		return ( false );
	}
	else if (form.tiem_real.value.length > 0) 
	{
		if (form.tiem_real.value.search(new RegExp("^([0-9])+$","g"))<0) 
		{
			alert ("Tiempo, debe ser un valor numerico entero" + msg);
			return ( false );
		}
		else
		{
			if (form.tiem_real.value>9000000)
			{
				alert ("Tiempo, debe ser un valor menor o igual a 9000000" + msg);
				return ( false );
			}
		}
	}
	else if (form.tiem_real.value.length < 0)
	{
		alert ("Tiempo, debe ser un valor mayor o igual a 0" + msg);
		return ( false );
	}
	return true;
}


//-->
</script>
<?php include("top_.php");?>
