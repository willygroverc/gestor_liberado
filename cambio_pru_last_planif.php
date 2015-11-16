<?php
include("conexion.php");
require_once('funciones.php');
if (isset($retornar)){header("location: lista_prueba_planif.php");}
if (isset($mas_pruebas))
{	
	$ha=md5($orden);
	$tp_e=explode("_",$tp);
	if($tp_e[1]==$ha)
	{	require_once('funciones.php');
		
		$fecha_r="$Ano-$Mes-$Dia";
		$fecha_r=SanitizeString($fecha_r);
		$obj_pru=SanitizeString($obj_pru);
		$obs_pru0=SanitizeString($obs_pru0);
		$obs_pru1=SanitizeString($obs_pru1);
		$sql6="UPDATE cambios_prueba_planif SET fecha_pru='$fecha_r',obj_pru='$obj_pru',obs_pru0='$obs_pru0',obs_pru1='$obs_pru1' ".
		"WHERE id_orden='$orden' AND tipo_pru='$tpo'";
		mysql_db_query($db,$sql6,$link);
		
		$sql_i = "SELECT id_pru FROM cambios_prueba_planif WHERE id_orden='$orden' AND tipo_pru='$tpo'";
		$result_i = mysql_db_query($db,$sql_i,$link);
		$row_i = mysql_fetch_array($result_i);
		header("location: cambio_pru2_last_planif.php?orden=$orden&tp=$tp&num=$row_i[id_pru]");
	}
	else
	{ header("location: lista_prueba.php?Naveg=Cambios >> Pruebas&msg=2");}
}
include("top.php");
?> 
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "obj_pru",  "Objetivo de la Prueba,  $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "obs_pru0",  "Observaciones Generales del Responsable,  $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "obs_pru1",  "Observaciones Generales,  $errorMsgJs[empty]" );
$valid->addLength ( "obj_pru",  "Objetivo de la Prueba,  $errorMsgJs[length]" );
$valid->addLength ( "obs_pru0",  "Observaciones Generales del Responsable,  $errorMsgJs[length]" );
$valid->addLength ( "obs_pru1",  "Observaciones Generales,  $errorMsgJs[length]" );
print $valid->toHtml ();
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
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<style>
.cl2 { FONT-SIZE:8PT;}
</style>	
</head>
<body>
<form name="form1" method="post" onKeyPress="return Form()">
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <th>PRUEBAS 
        <?php	$tp2=md5($orden);
	  		if($tp=="258db52a0b75ba2448af531309ad5eac_".$tp2)
			{	echo "USUARIAS"; 
				$tpo="1";
			 	$sql_ed="SELECT *, DATE_FORMAT(fecha_reg, '%d/%m/%Y') AS fecha_reg FROM cambios_prueba_planif WHERE id_orden='$orden' AND tipo_pru='1'";
			}
			elseif($tp=="7d428547b8723786029735cde7b75d7d_".$tp2)
			{
				echo "DE SISTEMAS"; 
				$tpo="2";
				$sql_ed="SELECT *, DATE_FORMAT(fecha_reg, '%d/%m/%Y') AS fecha_reg FROM cambios_prueba_planif WHERE id_orden='$orden' AND tipo_pru='2'";
			}
			elseif($tp=="f4b29b15eee509a8fa39344471561d29_".$tp2)
			{
				echo "DE SEGURIDAD"; 
				$tpo="3";
				$sql_ed="SELECT *, DATE_FORMAT(fecha_reg, '%d/%m/%Y') AS fecha_reg FROM cambios_prueba_planif WHERE id_orden='$orden' AND tipo_pru='3'";
			}
			$result_ed=mysql_db_query($db,$sql_ed,$link);
			$row_ed=mysql_fetch_array($result_ed);
	  ?>
<input name="tpo" type="hidden" value="<?php echo $tpo;?>">
      </th>
    </tr>
    <tr> 
      <td height="52"><table width="100%" border="0">
          <tr> 
            <td width="2%">&nbsp;</td>
            <td><font size="2"><strong>Orden Nro.:</strong></font></td>
            <td width="55%"><font size="2"><?php echo $orden;?></font></td>
            <td width="11%"><font size="2"><strong>Fecha y Hora :</strong></font></td>
            <td width="23%"><font size="2">&nbsp;<?php echo "$row_ed[fecha_reg] $row_ed[hora_reg]";?></font></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td width="9%"><font size="2"><strong>Descripcion:</strong></font></td>
            <td colspan="3"><font size="2"> 
              <?php $sqlTmp="SELECT desc_inc FROM ordenes WHERE id_orden=$orden";
				$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
				print $ordenTmp[desc_inc];
				?>
              &nbsp;</font></td>
          </tr>
        </table></td>
    </tr>
  </table>	
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
  <tr> 
      <td width="29%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">RESPONSABLE</font></div></td>
      <td width="22%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA 
          DE LA PRUEBA</font></div></td>
      <td width="49%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBJETIVO 
          DE LA PRUEBA</font></div></td>
    </tr>
    <tr align="center"> 
      <td> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
	  <?php
	  	$sql_a = "SELECT asig FROM asignacion WHERE id_orden='$orden' ORDER BY id_asig DESC limit 1";
		$result_a=mysql_db_query($db,$sql_a,$link);
		$row_a=mysql_fetch_array($result_a); 
		
		$sql_a1 = "SELECT asig FROM asignacion WHERE id_asig='$row_a[id_asig]'";
		$result_a1=mysql_db_query($db,$sql_a1,$link);
		$row_a1=mysql_fetch_array($result_a1);
		
		$sql4 = "SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$row_a[asig]'";
		$result4=mysql_db_query($db,$sql4,$link);
		$row4=mysql_fetch_array($result4);
		echo $row4['nom_usr']." ".$row4['apa_usr']." ".$row4['ama_usr'];
	  ?>
	  </font></div>
        <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
          </font></div></td>
	  <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
        <select name="Dia" >
          <?php
				$fsist=$row_ed[fecha_pru];
  				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
				for($i=1;$i<=31;$i++)
				{
	              echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
				}
				?>
        </select>
        <select name="Mes">
          <?php
				for($i=1;$i<=12;$i++)
				{
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
				}
				?>
        </select>
        <select name="Ano">
          <?php
				for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
        </select>
        <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></td>
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">
        <textarea name="obj_pru" cols="50"><?php echo $row_ed['obj_pru'];?></textarea>
        </font><font  size="1" face="Arial, Helvetica, sans-serif">&nbsp; </font></td>
    </tr>
	</table>
	<table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="51%" bgcolor="#006699" > <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBSERVACIONES 
          GENERALES DEL RESPONSABLE</font></div></td>
      <td width="49%" bgcolor="#006699" align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica"> 
        OBSERVACIONES GENERALES</font></td>
    </tr>
	<tr> 
	
	  <td width="51%"  > <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
          <textarea name="obs_pru0" cols="50"><?php echo $row_ed['obs_pru0'];?></textarea>
          </font></div></td>
      <td width="49%"  align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica">
	   <textarea name="obs_pru1" cols="50"><?php echo $row_ed['obs_pru1'];?></textarea>
	  </font></td>
    </tr>
   <tr> 
      <td colspan="2"><div align="center"> <br>
          <input type="submit" name="mas_pruebas" value = "GUARDAR Y CONTINUAR"   <?php print $valid->onSubmit() ?>Z> 
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="retornar" value="RETORNAR">
        </div></td>
    </tr>
  </table>
<tr>
    <td colspan="1"><blockquote>
</form>
</body>
</html>
 <script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
		var form="form1";
		var cal = new calendar1(document.forms[form].elements['Dia'], document.forms[form].elements['Mes'], document.forms[form].elements['Ano']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>
<?php include("top_.php");?>
