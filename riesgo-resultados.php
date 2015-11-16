<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		13/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if(isset($GUARDAR)){
	require("conexion.php");
	for($k=0;$k<$i;$k++){
		$sql_modif="UPDATE riesgo_respuesta SET obs='$obs[$k]' WHERE id_riesgo='$id_riesgo[$k]' AND id_riesgo_0='$id_riesgo_0'";
		mysql_query($sql_modif);
	}
	header("location: riesgo-resultados.php?variable1=$variable1&var2=$var2&idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
}
if(!isset($cons) && isset($consolidar)) header ("location: riesgo-resultados.php?msg=1");
require_once("funciones.php");
//if (valida("Riesgo")=="bad") {header("location: pagina_error.php");}
if (isset($retornar)) {header("location: riesgo-opciones.php?pg=$pg&idproc=$idproc&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");}
//if (isset($terminar)) { header("location: riesgo-opciones.php"); }
include("top.php");
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
<form name="form1" method="post" action="<?php echo $PHP_SELF;?>">
<input name="idproc" type="hidden" value="<?php echo $idproc;?>">
<input name="pg" type="hidden" value="<?php echo $pg;?>">
<input name="busc" type="hidden" value="<?php echo $busc;?>">
<input name="idproc" type="hidden" id="idproc" value="<?php echo $idproc;?>">
<input name="pg" type="hidden" id="pg" value="<?php echo $pg;?>">
  <table width="70%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <tr> 
      <th height="21" colspan="8" background="images/main-button-tileR1.jpg">EVALUACIONES</th>
    </tr>
    <tr align="center"> 
  	  <td class="menu" background="images/main-button-tileR1.jpg" height="20">Cons.</td>
      <td class="menu" background="images/main-button-tileR1.jpg" height="20">NRO</td>
      <td class="menu" background="images/main-button-tileR1.jpg" height="20">REALIZADO POR</td>
      <td class="menu" background="images/main-button-tileR1.jpg" height="20">TITULO</td>
      <td class="menu" background="images/main-button-tileR1.jpg" height="20">DESCRIPCION</td>
      <td class="menu" background="images/main-button-tileR1.jpg" height="20">PROMEDIO</td>
      <td class="menu" background="images/main-button-tileR1.jpg" height="20">FECHA</td>
	  <td class="menu" background="images/main-button-tileR1.jpg" height="20">MODIFICAR</td>
      <?php if($idproc) echo"<td class=\"menu\">PROCESO</td>";?>
    </tr>
    <?php
		if($idproc){$sql = "SELECT val, DATE_FORMAT(fecha,'%d/%m/%Y %H:%i:%s') as fecha1,fecha,titulo,id_riesgo_0 FROM riesgo_respuesta WHERE proceso='$idproc' GROUP BY id_riesgo_0";}
		else{$sql = "SELECT val, DATE_FORMAT(fecha,'%d/%m/%Y %H:%i:%s') as fecha1,fecha,titulo,id_riesgo_0 FROM riesgo_respuesta WHERE proceso='0' GROUP BY id_riesgo_0";}
		$result=mysql_query($sql);
		$num=0;
		$xxx=0;
		while($row=mysql_fetch_array($result)) {
			$num++;
			echo "<tr align=\"center\">";			
			if (!idproc) { echo " <td><input name=\"cons[$xxx]\" type=\"checkbox\" id=\"cons\" value=\"$row[id_riesgo_0]\"></td><td><a href=\"riesgo-resultados.php?variable1=$row[id_riesgo_0]&var2=$row[fecha1]\">$num</a></td>"; }
			else { echo " <td><input name=\"cons[$xxx]\" type=\"checkbox\" id=\"cons\" value=\"$row[id_riesgo_0]\"></td><td><a href=\"riesgo-resultados.php?variable1=$row[id_riesgo_0]&var2=$row[fecha1]&idproc=$idproc&pg=$pg\">$num</a></td>"; }
			$xxx++;
			$sql5 = "SELECT realizado_por FROM riesgo_respuesta WHERE id_riesgo_0='$row[id_riesgo_0]' limit 1";
		  	$result5 = mysql_query($sql5);
			$row5 = mysql_fetch_array($result5);
			$sql6 = "SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$row5[realizado_por]'";
		  	$result6 = mysql_query($sql6);
			$row6 = mysql_fetch_array($result6);
			echo " <td>&nbsp;$row6[nom_usr] $row6[apa_usr] $row6[ama_usr]</td>";
			echo " <td>&nbsp;".$row['titulo']."</td>";
			$sql5 = "SELECT descripcion,proceso FROM riesgo_respuesta WHERE id_riesgo_0='$row[id_riesgo_0]' limit 1";
		  	$result5 = mysql_query($sql5);
			$row5 = mysql_fetch_array($result5);
			echo " <td>&nbsp;".$row5['descripcion']."</td>";
			$sql7 = "SELECT COUNT(*) AS num,SUM(val)AS suma FROM riesgo_respuesta WHERE id_riesgo_0='$row[id_riesgo_0]'";
		  	$result7 = mysql_query($sql7);
			$row7 = mysql_fetch_array($result7);
			$prom=$row7['suma']/$row7['num'];
			echo " <td>&nbsp;$prom</td>";			
			echo " <td>".$row['fecha1']."</td>";
			echo " <td><a href=\"riesgo-matrix_last.php?id_riesgo_0=$row[id_riesgo_0]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></td>";
			if($idproc)echo " <td>".$row5['proceso']."</td>";
			echo "<tr>";
       	}
	 ?>
  </table>
  <div align="center"><br>
    <br>
    <input name="consolidar" type="submit" id="consolidar" value="CONSOLIDAR">
    <br><br>
    <?php if(isset($variable1)){ 
  		$sql = "SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y %H:%i:%s') as fecha1 FROM riesgo_respuesta WHERE id_riesgo_0='$variable1' LIMIT 1";}
	if(isset($consolidar)){
		unset($variable1);
		$var=implode(", ",$cons);
		$sql = "SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y %H:%i:%s') as fecha1 FROM riesgo_respuesta WHERE id_riesgo_0 IN ($var) LIMIT 1";
	}
	if(isset($variable1) || isset($consolidar)){ 
		$result=mysql_fetch_array(mysql_query($sql));
  ?>
  </div>
  <table width="70%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg" bgcolor="#EAEAEA" >
    <tr> 
      <th height="21" colspan="4" background="images/main-button-tileR1.jpg"><input name="id_riesgo_0" type="hidden" id="id_riesgo_0" value="<?php echo $variable1;?>">
        RESULTADOS DE EVALUACION
        <input name="variable1" type="hidden" id="variable1" value="<?php echo $variable1;?>">
      <input name="var2" type="hidden" id="var2" value="<?php echo $var2;?>"></th>
    </tr>
    <tr align="center"> 
      <td height="27" colspan="4"> 
        <table width="100%" border="0">
          <tr> 
            <td width="13%" height="21">&nbsp;&nbsp;&nbsp;&nbsp;<strong>TITULO: </strong></td>
			<td width="22%">
              <?php
			  if(isset($consolidar)){ 
				$sql_titu="SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y') as fecha1 FROM riesgo_respuesta WHERE id_riesgo_0 IN ($var) GROUP BY id_riesgo_0";
				$res_titu=mysql_query($sql_titu);
				while($row_titu=mysql_fetch_array($res_titu)){
					echo "- ".$row_titu['titulo']."<br>";
				}
				}else{echo $result['titulo'];}
			  ?>
              <strong> </strong></td>
            <td width="19%" valign="top"> 
              <div align="right"><strong>DESCRIPCION 
                : </strong></div></td>
            <td width="21%" valign="top"> 
              <?php if(isset($consolidar)){echo "CONSOLIDADO";}else{echo $result['descripcion'];}?>
            </td>
            <td width="25%"><?php if(isset($idproc)){?><strong>PROCESO: <?php echo $result['proceso']; }?>
            </strong></td>
          </tr>
        </table></td>
    </tr>
    <tr align="center"> 
      <td colspan="4">&nbsp;FECHA: <?php=$result[fecha1]?></td>
    </tr>
    <tr align="center"> 
      <td width="59" class="menu">NRO</td>
      <td width="408" class="menu">DESCRIPCION</td>
      <td width="68" class="menu">SUMA</td>
       <td width="94" class="menu">OBSERVACIONES</td>
    </tr>
	
    <?php
		$i1=0;
		if(isset($consolidar)) $sql_prob="SELECT COUNT(*) AS numselec FROM riesgo_respuesta WHERE id_riesgo_0 IN ($var)";
		else $sql_prob="SELECT COUNT(*) AS numselec FROM riesgo_respuesta WHERE id_riesgo_0='$variable1'";
		$res_prob=mysql_query($sql_prob);
		$row_prob=mysql_fetch_array($res_prob);
		for ($i=1;$i<$row_prob['numselec'];$i++)
		{
			$i1=$i1+$i;
		}
		if(isset($consolidar)) $sql_prob2="SELECT SUM(val) AS sumselec FROM riesgo_respuesta WHERE id_riesgo_0 IN ($var)";
		else $sql_prob2="SELECT SUM(val) AS sumselec FROM riesgo_respuesta WHERE id_riesgo_0='$variable1'";
		$res_prob2=mysql_query($sql_prob2);
		$row_prob2=mysql_fetch_array($res_prob2);
		$numpart=$row_prob2['sumselec']/$i1;
		$valormax=$numpart*($row_prob['numselec']-1);
				
		$stotal=round($valormax/5,2);
		$i=0;
		if(isset($consolidar)) $sql = "SELECT * FROM riesgo_respuesta WHERE id_riesgo_0 IN ($var) ORDER BY val DESC";
		else $sql = "SELECT * FROM riesgo_respuesta WHERE id_riesgo_0='$variable1' ORDER BY val DESC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) {
			
			if ($row[val]>=0 AND $row[val]<=$stotal){$color="bgcolor=#00FF00";}
			if ($row[val]>$stotal AND $row['val']<=$stotal*2){$color="bgcolor=#E2FD86";}
			if ($row[val]>$stotal*2 AND $row['val']<=$stotal*3){$color="bgcolor=#FFFF00";}
			if ($row[val]>$stotal*3 AND $row['val']<=$stotal*4){$color="bgcolor=#FDC042";}
			if ($row[val]>$stotal*4 AND $row['val']<=$total){$color="bgcolor=#FF0000";}
			
			$sql2 = "SELECT * FROM riesgo_pregunta WHERE id_riesgo='".$row['id_riesgo']."'";
			$result2=mysql_query($sql2);
			$row2=mysql_fetch_array($result2);
			$desc=$row2['desc_riesgo'];
			if(isset($consolidar)) $titulox=" - ".$row['titulo'];
			echo "<tr align=\"center\">";
			echo " <td ".$color." width=\"59\"><input name=\"id_riesgo[$i]\" type=\"hidden\" value=\"$row[id_riesgo]\">".$row['id_riesgo']."</td>";
			echo " <td ".$color." width=\"408\">".$desc.$titulox."</td>";
			echo " <td ".$color." width=\"68\"> <input name=\"v11$num\" type=\"text\" class=\"mio2\" maxlenght=\"3\" readonly=\"\" value=\"$row[val]\"></td>";
			echo "<td ".$color."><textarea name=\"obs[$i]\" cols=\"20\" rows=\"1\">$row[obs]&nbsp;</textarea></td>";
			echo "<tr>";
			$i=$i+1;
       	}
	 ?>
  </table>
  <table width="70%" border="0" align="center">
    <tr>
      <td width="11%" height="34"><strong><font size="2" face="Arial, Helvetica, sans-serif">Promedio 
        : </font></strong></td>
      <td width="89%"><font size="2" face="Arial, Helvetica, sans-serif">
	  <?php
	  if(isset($consolidar)) $sql8 = "SELECT COUNT(*) AS num,SUM(val)AS suma FROM riesgo_respuesta WHERE id_riesgo_0 IN ($var)";
	  else $sql8 = "SELECT COUNT(*) AS num,SUM(val)AS suma FROM riesgo_respuesta WHERE id_riesgo_0='$variable1'";
	  $result8 = mysql_query($sql8);
	  $row8 = mysql_fetch_array($result8);
	  $prom=round($row8['suma']/$row8['num'],2);
	  echo "&nbsp;$prom";
	  ?></font></td>
    </tr>
  </table>
  <input name="i" type="hidden" id="i" value="<?php echo $i;?>">
  <?php } ?>
  <br>
  <?php if(@$variable1!=""){?>
  <input type="button" name="imprimir" value="IMPRIMIR" onClick="riesgo_imp()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input name="GUARDAR" type="submit" id="GUARDAR" value="GUARDAR">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; 
  <?php }
  if(isset($consolidar)){?>
    <input type="button" name="imprimir" value="IMPRIMIR" onClick="riesgo_imp2()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input name="GUARDAR" type="submit" id="GUARDAR" value="GUARDAR">	<?php
  }
  ?>
  <input name="idproc" type="hidden" id="idproc" value="<?php echo $idproc;?>">
<input name="pg" type="hidden" id="pg" value="<?php echo $pg;?>">
</form>
<br>
<script language="JavaScript">
<!--
<?php if(isset($variable1) && $variable1!=""){?>
function riesgo_imp()
{
	var hola="<?php echo $variable1;?>";
	window.open ( "riesgo-resultados_impre.php?variable1="+hola);
}
<?php}; if(isset($consolidar)){?>
function riesgo_imp2()
{
	var hola="<?php echo implode('*',$cons);?>";
	window.open ( "riesgo-resultados_impre.php?cons="+hola);
}
<?php }?>
function modificar(id_riesgo,titulo){
	var url=window.location.href
	var mod ="<?php echo @$mod?>"
	var num=url.lastIndexOf("riesgo-resultados.php");
	if(mod){
	var num2=url.lastIndexOf("&mod");
	url=url.substring(num,num2);}else{
	url=url.substring(num)
	}
	url=url+"&mod=OK&id_riesgo="+id_riesgo+"&id_riesgo_0="+titulo+"#modif"
	self.location=url
}

<?php if (isset($msg) && $msg==1) {
	print "var msg=\"Debe seleccionar por lo menos una evaluacion\";\n";
	print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
} ?>
-->
</script>