<?php 
if(isset($GUARDAR)){
	include("conexion.php");
	for($k=0;$k<$i;$k++){
		$sql_modif="UPDATE riesgo_resptabla SET obs='$obs[$k]' WHERE id_riesgo='$id_riesgo[$k]' AND titulo='$titulo'";
		mysql_db_query($db,$sql_modif,$link);
	}
	header("location: resultados_evaluacion.php?variable1=$variable1");
	//header("location: riesgo-resultados1.php?variable1=$variable1&var2=$var2&idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
}
require_once("funciones.php");
//if (valida("Riesgo")=="bad") {header("location: pagina_error.php");}
if(!isset($cons) && isset($consolidar)) header ("location: riesgo-resultados1.php?msg=1");
if (isset($retornar)) {header("location: riesgo-opciones.php?pg=$pg&idproc=$idproc&BUSCAR=$BUSCAR&menu=$menu&busc=$busc"); }
//if (isset($terminar)) { header("location: riesgo-opciones.php"); }
if (!isset($orden)){ $orden="val3";}
include("header_resultados_evaluacion.php");

?> 
<style type="text/css">
<!--
.mio {
	height: 20px;
	width: 30px;
}
.mio2 {
	height: 20px;
	width: 40px;
}
-->
</style>
<script language="javascript" type="text/javascript">
<!-- Begin

function chcol() {
  var chidc = new Array();
  var hexc = new Array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
  var chidn = new Array(100,70,40);
  var step = new Array(10,10,10);
  var chway = new Array(step[0],step[1],step[2]);
  var tone = new Array(1,1,1);

   for (i=0; i<3; i++) {
      chidn[i]+=chway[i];
      if (chidn[i]>=255) {
        chidn[i] = 255;
        chway[i] = -step[i];
      }
    else if (chidn[i]<=40) {
        chidn[i] = 40;
        chway[i] = step[i];
        tone[i]>=3? tone[i] = 1:tone[i]++;
      }
      col1 = hexc[Math.floor(chidn[i]/16)];
      col2 = hexc[chidn[i]%16];
      tored = '';
      toblue = '';
      for (j=1; j<tone[i]; j++) tored+='00';
      for (j=3; j>tone[i]; j--) toblue+='00';
      chidc[i] = '#'+tored+col1+col2+toblue;
      td = eval('document.all.chcol'+i);                                
      td.style.backgroundColor = chidc[i];
    }
//    setTimeout('chcol()',100);
}
//  End -->
</script>



<form name="form1" method="post" action="<?php=$PHP_SELF ?>" onKeyPress="return Form()">
<input name="idproc" type="hidden" value="<?php echo $idproc;?>">
<input name="pg" type="hidden" value="<?php echo $pg;?>">
<input name="BUSCAR" type="hidden" value="<?php echo $BUSCAR;?>">
<input name="menu" type="hidden" value="<?php echo $menu;?>">
<input name="busc" type="hidden" value="<?php echo $busc;?>">
<div align="center"><br>
<br>
<br>
    <?php 
	if($variable1) $sql = "SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y') as fecha1 FROM riesgo_resptabla WHERE id_riesgo0='$variable1' LIMIT 1";
  	if(isset($consolidar)){
		unset($variable1);
		$var=implode(", ",$cons);
		$sql = "SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y') as fecha1 FROM riesgo_resptabla WHERE id_riesgo0 IN ($var) LIMIT 1";
	} 
  	if($variable1 || isset($consolidar)){ 
		$result=mysql_fetch_array(mysql_db_query($db,$sql,$link));
  ?>
  </div>
  <table width="85%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <tr> 
      <th colspan="6">RESULTADOS DE EVALUACION
      <input name="variable1" type="hidden" id="variable1" value="<?php echo $variable1;?>">
      <input name="var2" type="hidden" id="var2" value="<?php echo $var2;?>">      </th>
    </tr>
	<tr align="center"> 
      <td height="27" colspan="6"> 
        <table width="100%" border="0">
          <tr> 
            <td width="5%"><strong>TITULO:</strong></td><td width="17%">
			<?php if(isset($consolidar)){ 
				$sql_titu="SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y') as fecha1 FROM riesgo_resptabla WHERE id_riesgo0 IN ($var) GROUP BY id_riesgo0";
				$res_titu=mysql_db_query($db,$sql_titu,$link);
				while($row_titu=mysql_fetch_array($res_titu)){
					echo "- ".$row_titu[titulo]."<br>";
				}
			}else{echo $result[titulo];}?>
              <input name="titulo" type="hidden" id="titulo" value="<?php echo $result[titulo];?>">
              
            </td>
            <td width="17%" valign="top"><div align="right"><strong>DESCRIPCION :</strong> </div></td>
            <td width="41%" valign="top"> 
              <?php if(isset($consolidar)){echo "CONSOLIDADO";}else{echo $result[descripcion];}?>
            </td>
            <td width="20%"><?php if($idproc){?><strong>PROCESO: </strong><?php echo $result[proceso]; }?></td>
          </tr>
        </table>
        
      </td>
    </tr>
    <tr align="center"> 
      <td colspan="6">&nbsp;FECHA: <?php=$result[fecha1]?></td>
    </tr>
    <tr align="center"> 
      <td width="38" class="menu">NRO</td>
      <td width="269" class="menu">DESCRIPCION</td>
      <td width="138" class="menu"><a class="menu" href="resultados_evaluacion.php?orden=val1&variable1=<?php echo $variable1;?>&var2=<?php echo $var2;?>">PROBABILIDAD
        <?php if($orden=="val1") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >"; ?>
        </a></td>
      <td width="104" class="menu"><a class="menu" href="resultados_evaluacion.php?orden=val2&variable1=<?php echo $variable1;?>&var2=<?php echo $var2;?>">IMPACTO <?php if($orden=="val2") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >"; ?> </a></td>
      <td width="94" class="menu"><a class="menu" href="resultados_evaluacion.php?orden=val3&variable1=<?php echo $variable1;?>&var2=<?php echo $var2;?>">RIESGO <?php if($orden=="val3") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >"; ?> </a></td>
      <td width="94" class="menu">OBSERVACIONES</td>
    </tr>
    <?php
		$sql_prob="SELECT MAX(valoracion) AS maxi_prob FROM riesgo_probabilidad";
		$res_prob=mysql_db_query($db,$sql_prob,$link);
		$row_prob=mysql_fetch_array($res_prob);
		
		$sql_imp="SELECT MAX(val_impac) AS maxi_imp FROM riesgo_impacto";
		$res_imp=mysql_db_query($db,$sql_imp,$link);
		$row_imp=mysql_fetch_array($res_imp);
		
		$total=$row_prob[maxi_prob]*$row_imp[maxi_imp];
		$stotal=round($total/5,2);
		
		if(isset($consolidar)) $sql = "SELECT * FROM riesgo_resptabla WHERE id_riesgo0 IN ($var) ORDER BY $orden DESC";
		else $sql = "SELECT * FROM riesgo_resptabla WHERE id_riesgo0='$variable1' ORDER BY $orden DESC";

		$result=mysql_db_query($db,$sql,$link);
		$i=0;
		while($row=mysql_fetch_array($result)) {
			if ($row[val3]>=1 AND $row[val3]<$stotal){$color="bgcolor=#00FF00";}
			if ($row[val3]>=$stotal AND $row[val3]<$stotal*2){$color="bgcolor=#E2FD86";}
			if ($row[val3]>=$stotal*2 AND $row[val3]<$stotal*3){$color="bgcolor=#FFFF00";}
			if ($row[val3]>=$stotal*3 AND $row[val3]<$stotal*4){$color="bgcolor=#FDC042";}
			if ($row[val3]>=$stotal*4 AND $row[val3]<=$total){$color="bgcolor=#FF0000";}
			
			$sql2 = "SELECT * FROM riesgo_pregunta WHERE id_riesgo='$row[id_riesgo]'";
			$result2=mysql_db_query($db,$sql2,$link);
			$row2=mysql_fetch_array($result2);
			$desc=$row2[desc_riesgo];
			if(isset($consolidar)) $titulox=" - ".$row[titulo];
			echo "<tr align=\"center\">";
			printf(" <td ".$color." width=\"38\"><input name=\"id_riesgo[$i]\" type=\"hidden\" value=\"$row[id_riesgo]\">".$row[id_riesgo]."</td>",$i);
			printf (" <td ".$color." width=\"269\">".$desc.$titulox."</td>",$i);
			printf (" <td ".$color." width=\"138\"><input name=\"v11$num\" type=\"text\" class=\"mio2\" maxlenght=\"3\" readonly=\"\" value=\"$row[val1]\"></td>",$i);
			printf (" <td ".$color." width=\"104\"><input name=\"v12$num\" type=\"text\" class=\"mio2\" maxlenght=\"3\" readonly=\"\" value=\"$row[val2]\"></td>",$i);			
			printf (" <td ".$color." width=\"94\" ><input name=\"v13$num\" type=\"text\" class=\"mio2\" maxlenght=\"3\" readonly=\"\" value=\"$row[val3]\"></td>",$i);			
			echo "<td ".$color."><textarea name=\"obs[$i]\" cols=\"20\" rows=\"1\">$row[obs]&nbsp;</textarea></td>";
			echo "<tr>";
			$i=$i+1;
		}
	 ?>
  </table>
  <table width="85%" border="0" align="center">
    <tr> 
      <td width="16%" height="34"><strong><font size="2" face="Arial, Helvetica, sans-serif">Promedio 
        Riesgo : </font></strong></td>
      <td width="84%"><font size="2" face="Arial, Helvetica, sans-serif"> 
        <?php
	  if(isset($consolidar)) $sql8 = "SELECT COUNT(*) AS num,SUM(val3)AS suma FROM riesgo_resptabla WHERE id_riesgo0 IN ($var)";
	  else $sql8 = "SELECT COUNT(*) AS num,SUM(val3)AS suma FROM riesgo_resptabla WHERE id_riesgo0='$variable1'";
	  $result8 = mysql_db_query($db,$sql8,$link);
	  $row8 = mysql_fetch_array($result8);
	  $prom=round($row8[suma]/$row8[num],2);
	  echo "&nbsp;$prom";
	  ?>
        </font></td>
    </tr>
  </table>
  <input name="i" type="hidden" id="i" value="<?php echo $i;?>">
  <?php } ?>
  <br>
  <?php if($variable1!=""){?>
  <input type="button" name="imprimir" value="IMPRIMIR" onClick="riesgo_imp()">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;
  <input name="GUARDAR" type="submit" id="GUARDAR" value="GUARDAR">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; 
  <?php }  if(isset($consolidar)){?>
    <input type="button" name="imprimir" value="IMPRIMIR" onClick="riesgo_imp2()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input name="GUARDAR" type="submit" id="GUARDAR" value="GUARDAR">	<?php
  }
  ?>
 
  <input name="idproc" type="hidden" id="idproc" value="<?php echo $idproc;?>">
  <input name="pg" type="hidden" id="pg" value="<?php echo $pg;?>">
</form>
<br>
<?php include("top_.php");?>
<script language="JavaScript">
<!--
<?php if($variable1!=""){?>
function riesgo_imp()
{
	var hola="<?php echo $variable1;?>";
	window.open("riesgo_imp.php?codigo="+hola, "Estadisticas", 'width=500,height=190,status=no,resizable=no,top=250,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=no');
}
<?php }; if(isset($consolidar)){?>
function riesgo_imp2()
{
	var hola="<?php echo implode('*',$cons);?>";
	window.open("riesgo_imp.php?cons="+hola, "Estadisticas", 'width=500,height=190,status=no,resizable=no,top=250,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=no');
}
<?php }?>
<?php if ($msg==1) {
	print "var msg=\"Debe seleccionar por lo menos una evaluacion\";\n";
	print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
} ?>
-->
</script>