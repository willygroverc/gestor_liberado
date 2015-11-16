<?php 
if (isset($retornar)) 
{ 
	header("location: riesgo-ejercicio.php?idproc=$idproc&pg=$pg");
}
include("conexion.php");	
$num=0;

$sql0 = "SELECT * FROM riesgo_parametros";
$result0 = mysql_db_query($db,$sql0,$link);
$row0 = mysql_fetch_array($result0);
$partic = $row0[participantes];

$sql = "SELECT * FROM riesgo_pregunta WHERE sel='1'";
$result = mysql_db_query($db,$sql,$link);
$cuantos = mysql_num_rows($result);
$nume=0;
$fecha=date("Y-m-d H:i:s");
if (isset($guardar)){
	$sql0_1 = "SELECT MAX(id_riesgo_0) AS maxid FROM riesgo_respuesta";
	$result0_1 = mysql_db_query($db,$sql0_1,$link);
	$row0_1 = mysql_fetch_array($result0_1);
	$mriesgo=$row0_1[maxid]+1;
	while($row=mysql_fetch_array($result)) {
		$num++;
		$val=$_POST["v11$num"];
		if($nume=="0")
		{
			session_start();
			$login=$_SESSION["login"];
			$sql3="INSERT INTO riesgo_respuesta(id_riesgo_0,id_riesgo,realizado_por,val,fecha,titulo,descripcion,proceso) ".
				  "VALUES ($mriesgo,'$row[id_riesgo]','$login','$val','".$fecha."','$titulo','$descripcion','$idproc')";
		}
		else
		{
			$sql3="INSERT INTO riesgo_respuesta(id_riesgo_0,id_riesgo,val,fecha, titulo,proceso) ".
				  "VALUES ($mriesgo,'$row[id_riesgo]','$val','".$fecha."', '$titulo','$idproc')";
		}
		mysql_db_query($db,$sql3,$link);
		$nume++;
		//print $sql;
	}
	header("location: riesgo-resultados.php?idproc=$idproc&pg=$pg");
	exit;
}

include("top.php");

require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTextNormal ( "titulo",  "Titulo, $errorMsgJs[expresion]" );
echo $valid->toHtml ();
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
<script language="JavaScript">
<!--
function Form() {
	<?php if ($cuantos>=1) { ?>
	document.form1.v111.value=valor(parseFloat(document.form1.v21b.value),parseFloat(document.form1.v31b.value),
	parseFloat(document.form1.v41b.value),parseFloat(document.form1.v51b.value),parseFloat(document.form1.v61b.value),
	parseFloat(document.form1.v71b.value),parseFloat(document.form1.v81b.value),parseFloat(document.form1.v91b.value),
	parseFloat(document.form1.v101b.value));
	document.form1.v111a.value=document.form1.v111.value;
	sumar(parseFloat(document.form1.v21a.value), parseFloat(document.form1.v21b.value));

	<?php } if ($cuantos>=2) { ?>
	document.form1.v112.value=valor(parseFloat(document.form1.v21a.value), //primer valor
	parseFloat(document.form1.v32b.value),parseFloat(document.form1.v42b.value),
	parseFloat(document.form1.v52b.value),parseFloat(document.form1.v62b.value),parseFloat(document.form1.v72b.value),
	parseFloat(document.form1.v82b.value),parseFloat(document.form1.v92b.value),parseFloat(document.form1.v102b.value));
	document.form1.v112a.value=document.form1.v112.value;
	sumar(parseFloat(document.form1.v31a.value),parseFloat(document.form1.v31b.value));
	sumar(parseFloat(document.form1.v32a.value),parseFloat(document.form1.v32b.value));
	
	<?php } if ($cuantos>=3) { ?>
	document.form1.v113.value=valor(parseFloat(document.form1.v31a.value),parseFloat(document.form1.v32a.value), //dos valores
	parseFloat(document.form1.v43b.value),parseFloat(document.form1.v53b.value),
	parseFloat(document.form1.v63b.value),parseFloat(document.form1.v73b.value),parseFloat(document.form1.v83b.value),
	parseFloat(document.form1.v93b.value),parseFloat(document.form1.v103b.value));
	document.form1.v113a.value=document.form1.v113.value;
	sumar(parseFloat(document.form1.v41a.value),parseFloat(document.form1.v41b.value));
	sumar(parseFloat(document.form1.v42a.value),parseFloat(document.form1.v42b.value));
	sumar(parseFloat(document.form1.v43a.value),parseFloat(document.form1.v43b.value));


	<?php } if ($cuantos>=4) { ?>
	document.form1.v114.value=valor(parseFloat(document.form1.v41a.value),parseFloat(document.form1.v42a.value), 
	parseFloat(document.form1.v43a.value), //tres valores
	parseFloat(document.form1.v54b.value),parseFloat(document.form1.v64b.value),
	parseFloat(document.form1.v74b.value),parseFloat(document.form1.v84b.value),
	parseFloat(document.form1.v94b.value),parseFloat(document.form1.v104b.value));
	document.form1.v114a.value=document.form1.v114.value;
	sumar(parseFloat(document.form1.v51a.value),parseFloat(document.form1.v51b.value));
	sumar(parseFloat(document.form1.v52a.value),parseFloat(document.form1.v52b.value));
	sumar(parseFloat(document.form1.v53a.value),parseFloat(document.form1.v53b.value));
	sumar(parseFloat(document.form1.v54a.value),parseFloat(document.form1.v54b.value));


	<?php } if ($cuantos>=5) { ?>
	document.form1.v115.value=valor(parseFloat(document.form1.v51a.value),parseFloat(document.form1.v52a.value), 
	parseFloat(document.form1.v53a.value),parseFloat(document.form1.v54a.value), //cuatro valores
	parseFloat(document.form1.v65b.value),parseFloat(document.form1.v75b.value),
	parseFloat(document.form1.v85b.value),parseFloat(document.form1.v95b.value),parseFloat(document.form1.v105b.value));
	document.form1.v115a.value=document.form1.v115.value;
	sumar(parseFloat(document.form1.v61a.value),parseFloat(document.form1.v61b.value));
	sumar(parseFloat(document.form1.v62a.value),parseFloat(document.form1.v62b.value));
	sumar(parseFloat(document.form1.v63a.value),parseFloat(document.form1.v63b.value));
	sumar(parseFloat(document.form1.v64a.value),parseFloat(document.form1.v64b.value));
	sumar(parseFloat(document.form1.v65a.value),parseFloat(document.form1.v65b.value));

	
	<?php } if ($cuantos>=6) { ?>
	document.form1.v116.value=valor(parseFloat(document.form1.v61a.value),parseFloat(document.form1.v62a.value), 
	parseFloat(document.form1.v63a.value),parseFloat(document.form1.v64a.value), 
	parseFloat(document.form1.v65a.value), //cinco valores
	parseFloat(document.form1.v76b.value),parseFloat(document.form1.v86b.value),
	parseFloat(document.form1.v96b.value),parseFloat(document.form1.v106b.value));
	document.form1.v116a.value=document.form1.v116.value;
	sumar(parseFloat(document.form1.v71a.value),parseFloat(document.form1.v71b.value));
	sumar(parseFloat(document.form1.v72a.value),parseFloat(document.form1.v72b.value));
	sumar(parseFloat(document.form1.v73a.value),parseFloat(document.form1.v73b.value));
	sumar(parseFloat(document.form1.v74a.value),parseFloat(document.form1.v74b.value));
	sumar(parseFloat(document.form1.v75a.value),parseFloat(document.form1.v75b.value));
	sumar(parseFloat(document.form1.v76a.value),parseFloat(document.form1.v76b.value));

	<?php } if ($cuantos>=7) { ?>
	document.form1.v117.value=valor(parseFloat(document.form1.v71a.value),parseFloat(document.form1.v72a.value), 
	parseFloat(document.form1.v73a.value),parseFloat(document.form1.v74a.value), 
	parseFloat(document.form1.v75a.value),parseFloat(document.form1.v76a.value), //seis valores
	parseFloat(document.form1.v87b.value),
	parseFloat(document.form1.v97b.value),parseFloat(document.form1.v107b.value));
	document.form1.v117a.value=document.form1.v117.value;
	sumar(parseFloat(document.form1.v81a.value),parseFloat(document.form1.v81b.value));
	sumar(parseFloat(document.form1.v82a.value),parseFloat(document.form1.v82b.value));
	sumar(parseFloat(document.form1.v83a.value),parseFloat(document.form1.v83b.value));
	sumar(parseFloat(document.form1.v84a.value),parseFloat(document.form1.v84b.value));
	sumar(parseFloat(document.form1.v85a.value),parseFloat(document.form1.v85b.value));
	sumar(parseFloat(document.form1.v86a.value),parseFloat(document.form1.v86b.value));
	sumar(parseFloat(document.form1.v87a.value),parseFloat(document.form1.v87b.value));
	
	<?php } if ($cuantos>=8) { ?>
	document.form1.v118.value=valor(parseFloat(document.form1.v81a.value),parseFloat(document.form1.v82a.value), 
	parseFloat(document.form1.v83a.value),parseFloat(document.form1.v84a.value), 
	parseFloat(document.form1.v85a.value),parseFloat(document.form1.v86a.value), 
	parseFloat(document.form1.v87a.value), //siete valores
	parseFloat(document.form1.v98b.value),parseFloat(document.form1.v108b.value));
	document.form1.v118a.value=document.form1.v118.value;
	sumar(parseFloat(document.form1.v91a.value),parseFloat(document.form1.v91b.value));
	sumar(parseFloat(document.form1.v92a.value),parseFloat(document.form1.v92b.value));
	sumar(parseFloat(document.form1.v93a.value),parseFloat(document.form1.v93b.value));
	sumar(parseFloat(document.form1.v94a.value),parseFloat(document.form1.v94b.value));
	sumar(parseFloat(document.form1.v95a.value),parseFloat(document.form1.v95b.value));
	sumar(parseFloat(document.form1.v96a.value),parseFloat(document.form1.v96b.value));
	sumar(parseFloat(document.form1.v97a.value),parseFloat(document.form1.v97b.value));
	sumar(parseFloat(document.form1.v98a.value),parseFloat(document.form1.v98b.value));

	<?php } if ($cuantos>=9) { ?>
	document.form1.v119.value=valor(parseFloat(document.form1.v91a.value),parseFloat(document.form1.v92a.value), 
	parseFloat(document.form1.v93a.value),parseFloat(document.form1.v94a.value), 
	parseFloat(document.form1.v95a.value),parseFloat(document.form1.v96a.value), 
	parseFloat(document.form1.v97a.value), parseFloat(document.form1.v98a.value),//ocho valores
	parseFloat(document.form1.v109b.value));
	document.form1.v119a.value=document.form1.v119.value;
	sumar(parseFloat(document.form1.v101a.value),parseFloat(document.form1.v101b.value));
	sumar(parseFloat(document.form1.v102a.value),parseFloat(document.form1.v102b.value));
	sumar(parseFloat(document.form1.v103a.value),parseFloat(document.form1.v103b.value));
	sumar(parseFloat(document.form1.v104a.value),parseFloat(document.form1.v104b.value));
	sumar(parseFloat(document.form1.v105a.value),parseFloat(document.form1.v105b.value));
	sumar(parseFloat(document.form1.v106a.value),parseFloat(document.form1.v106b.value));
	sumar(parseFloat(document.form1.v107a.value),parseFloat(document.form1.v107b.value));
	sumar(parseFloat(document.form1.v108a.value),parseFloat(document.form1.v108b.value));
	sumar(parseFloat(document.form1.v109a.value),parseFloat(document.form1.v109b.value));
		
	<?php } if ($cuantos>=10) { ?>	
	document.form1.v1110.value=valor(parseFloat(document.form1.v101a.value),parseFloat(document.form1.v102a.value), 
	parseFloat(document.form1.v103a.value),parseFloat(document.form1.v104a.value), 
	parseFloat(document.form1.v105a.value),parseFloat(document.form1.v106a.value), 
	parseFloat(document.form1.v107a.value),parseFloat(document.form1.v108a.value),
	parseFloat(document.form1.v109a.value));
	document.form1.v1110a.value=document.form1.v1110.value;
	<?php } ?>
}

function valor(a,b,c,d,e,f,g,h,i) {
	var j;
	if (isNaN(a)) {a = 0;}
	if (isNaN(b)) {b = 0;} 
	if (isNaN(c)) {c = 0;} 
	if (isNaN(d)) {d = 0;} 
	if (isNaN(e)) {e = 0;} 
	if (isNaN(f)) {f = 0;} 
	if (isNaN(g)) {g = 0;} 
	if (isNaN(h)) {h = 0;} 
	if (isNaN(i)) {i = 0;} 
/*	mas=<?php echo $partic ?>;
	if ((a>mas) || (b>mas) || (c>mas) || (d>mas) || (e>mas) || (f>mas) || (g>mas) || (h>mas) || (i>mas)) {
		alert("La cantidad introducida no es valida, esta debe ser menor a '" + mas + "'"+ "\n \n Mensaje generado por GesTor F1.");
	}*/
	j = a + b + c + d + e + f + g + h + i; 
	return j;
}

function sumar(aa,bb) {
	/*if (isNaN(aa)) {aa = 0;} 
	if (isNaN(bb)) {bb = 0;} */
	if (isNaN(aa)) { return; }
	if (isNaN(bb)) { return; }
	var sum,partc;
	sum=aa+bb;
	partc=<?php echo $partic ?>;
	/*if (sum < partic && sum != 0 )  {
		alert("La cantidad introducida no es valida, la suma de los valores debe ser siempre igual a a "+partic+" \n \n Mensaje generado por GesTor F1.");
	}
	else if (sum >  partic && sum != 0) {
		alert("La cantidad introducida no es valida, la suma de los valores debe ser siempre igual a "+partic);
	}*/
	if (sum!=partc && sum!=0) { alert("La cantidad introducida no es valida, la suma de los valores debe ser siempre igual a "+partc+" \n \n Mensaje generado por GesTor F1."); }
}
</script>

<form name="form1" method="post" action="<?php=$PHP_SELF ?>">
<input name="idproc" type="hidden" value="<?php echo $idproc;?>">
<input name="pg" type="hidden" value="<?php echo $pg;?>">
  <table border="1" align="center" cellpadding="2" cellspacing="2" bgcolor="#EAEAEA"  background="images/fondo.jpg">
    <tr> 
      <th width="126">Nro. DE PARTICIPANTES</th>
      <th width="240">TITULO</th>
      <th width="215">DESCRIPCION</th>
    </tr>
    <tr align="center"> 
      <td> <input name="v21a2" type="text" value="<?php echo $partic?>" class="mio" maxlength="3" readonly="yes"></td>
      <td><input name="titulo" type="text" id="titulo2" size="30" maxlength="30"></td>
	  <?php
	  if(!empty($idproc))
	  {
	  	$sql_p="SELECT descripcion FROM procesos WHERE id_proceso='$idproc'";
		$result_p=mysql_db_query($db,$sql_p,$link);
		$row_p=mysql_fetch_array($result_p);
	  }
	  ?>
	  
      <td><textarea name="descripcion" cols="30" rows="2"><?php echo $row_p[descripcion];?></textarea></td>
    </tr>
  </table>
  <br>
  <table border="1" align="center" cellpadding="0" cellspacing="2" bgcolor="#EAEAEA"  background="images/fondo.jpg">
    <tr> 
      <th height="21" colspan="5">VALORAR RIESGOS POTENCIALES </th>
    </tr>
    <tr align="center"> 
      <td class="menu">NRO</td>
      <td class="menu">DESCRIPCION</td>
      <td class="menu">SUMA</td>
    </tr>
    <?php
		$sql = "SELECT * FROM riesgo_pregunta WHERE sel='1' ORDER BY id_riesgo";
		$result=mysql_db_query($db,$sql,$link);
		$num=0;
		$matrix[]=0;
		while($row=mysql_fetch_array($result)) {
			$num++;
			$matrix[$num-1]=$row[desc_riesgo];
			echo "<tr align=\"center\">";
			echo " <td>" . $num . "</td>";
			echo " <td align='center'>".$row[desc_riesgo]."</td>";
			echo " <td><input name=\"v11$num\" type=\"text\" class=\"mio2\" maxlenght=\"3\" readonly=\"\" ></td>";
			echo "<tr>";
       	}
	 ?>
  </table>
  <br>
  <input name="guardar" type="submit" id="guardar" value="GUARDAR" <?php echo $valid->onSubmit(); ?>>
  &nbsp;&nbsp;&nbsp; 
  <input type="submit" name="retornar" value="RETORNAR">
  <br>
  <br>
  <table border="1" align="center" cellpadding="0" cellspacing="2" bgcolor="#EAEAEA"  background="images/fondo.jpg">
    <?php $sql = "SELECT * FROM riesgo_pregunta WHERE sel='1' ORDER BY id_riesgo";
	$result=mysql_db_query($db,$sql,$link); 
	$i=0;
	while ($nombres=mysql_fetch_array($result))
	{
		$cab[$i]=$nombres[desc_riesgo];
		$i++;
	}
	?>
    <tr align="center"> 
      <td width="18"><div align="center"><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[0]'>"; echo substr($cab[0],0,10).".."; echo "</a></div>"; ?></strong></font></div></td>
      <td width="58"><div align="center"><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[0]'>"; echo substr($cab[0],0,10).".."; echo "</a></div>"; ?></strong></font></div></td>
      <td width="60"><div align="center"><font size="3"><font size="2"><font size="1"></font></font></font></div></td>
      <td width="60"><div align="center"><font size="3"><font size="2"><font size="1"></font></font></font></div></td>
      <td width="60"><div align="center"><font size="3"><font size="2"><font size="1"></font></font></font></div></td>
      <td width="60"><div align="center"><font size="3"><font size="2"><font size="1"></font></font></font></div></td>
      <td width="60"><div align="center"><font size="3"><font size="2"><font size="1"></font></font></font></div></td>
      <td width="60"><div align="center"><font size="3"><font size="2"><font size="1"></font></font></font></div></td>
      <td width="60"><div align="center"><font size="3"><font size="2"><font size="1"></font></font></font></div></td>
      <td width="60"><div align="center"><font size="3"><font size="2"><font size="1"></font></font></font></div></td>
      <td width="40"><div align="center"><font size="3"><font size="2"><font size="1"></font></font></font></div></td>
    </tr>
    <tr align="center" <?php if ($num<=1) {echo "bgcolor=\"#9999CC\""; }?> > 
      <td><div align="center"><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[1]'>"; echo substr($cab[1],0,10).".."; echo "</a></div>"; ?></strong></font></div></td>
      <td onKeyUp="Form()"><input name="v21a" type="text"  class="mio" onChange="Form()" maxlength="3"> <input name="v21b" type="text" class="mio" onChange="Form()" maxlength="3" ></td>
      <td><strong><?php echo "<div style=cursor:hand><a title='$cab[1]'>"; echo substr($cab[1],0,10).".."; echo "</a></div>"; ?></strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center" <?php if ($num<=2) {echo "bgcolor=\"#9999CC\""; }?> > 
      <td height="21"><div align="center"><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[2]'>"; echo substr($cab[2],0,10).".."; echo "</a></div>"; ?></strong></font></div></td>
      <td onKeyUp="Form()"><input name="v31a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=2) { echo "readonly=\"\"";}?>> 
        <input name="v31b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=2) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v32a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=2) { echo "readonly=\"\"";}?> > 
        <input name="v32b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=2) { echo "readonly=\"\"";}?>></td>
      <td><strong><?php echo "<div style=cursor:hand><a title='$cab[2]'>"; echo substr($cab[2],0,10).".."; echo "</a></div>"; ?></strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center" <?php if ($num<=3) {echo "bgcolor=\"#9999CC\""; }?> > 
      <td height="21"><div align="center"><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[3]'>"; echo substr($cab[3],0,10).".."; echo "</a></div>"; ?></strong></font></div></td>
      <td onKeyUp="Form()"><input name="v41a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=3) { echo "readonly=\"\"";}?>> 
        <input name="v41b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=3) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v42a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=3) { echo "readonly=\"\"";}?>> 
        <input name="v42b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=3) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v43a" type="text" class="mio" maxlength="3" <?php if ($num<=3) { echo "readonly=\"\"";}?>> 
        <input name="v43b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=3) { echo "readonly=\"\"";}?>></td>
      <td><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[3]'>"; echo substr($cab[3],0,10).".."; echo "</a></div>"; ?></strong></font></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center"  <?php if ($num<=4) {echo "bgcolor=\"#9999CC\""; }?>> 
      <td height="21"><div align="center"><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[4]'>"; echo substr($cab[4],0,10).".."; echo "</a></div>"; ?></strong></font></div></td>
      <td onKeyUp="Form()"><input name="v51a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=4) { echo "readonly=\"\"";}?>> 
        <input name="v51b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=4) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v52a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=4) { echo "readonly=\"\"";}?>> 
        <input name="v52b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=4) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v53a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=4) { echo "readonly=\"\"";}?>> 
        <input name="v53b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=4) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v54a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=4) { echo "readonly=\"\"";}?>> 
        <input name="v54b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=4) { echo "readonly=\"\"";}?>></td>
      <td><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[4]'>"; echo substr($cab[4],0,10).".."; echo "</a></div>"; ?></strong></font></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center"  <?php if ($num<=5) {echo "bgcolor=\"#9999CC\""; }?>> 
      <td height="21"><div align="center"><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[5]'>"; echo substr($cab[5],0,10).".."; echo "</a></div>"; ?></strong></font></div></td>
      <td onKeyUp="Form()"><input name="v61a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=5) { echo "readonly=\"\"";}?>> 
        <input name="v61b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=5) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v62a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=5) { echo "readonly=\"\"";}?>> 
        <input name="v62b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=5) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v63a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=5) { echo "readonly=\"\"";}?>> 
        <input name="v63b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=5) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v64a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=5) { echo "readonly=\"\"";}?>> 
        <input name="v64b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=5) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v65a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=5) { echo "readonly=\"\"";}?>> 
        <input name="v65b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=5) { echo "readonly=\"\"";}?>></td>
      <td><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[5]'>"; echo substr($cab[5],0,10).".."; echo "</a></div>"; ?></strong></font></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center"  <?php if ($num<=6) {echo "bgcolor=\"#9999CC\""; }?> > 
      <td height="21"><div align="center"><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[6]'>"; echo substr($cab[6],0,10).".."; echo "</a></div>"; ?></strong></font></div></td>
      <td onKeyUp="Form()"><input name="v71a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=6) { echo "readonly=\"\"";}?>> 
        <input name="v71b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=6) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v72a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=6) { echo "readonly=\"\"";}?>> 
        <input name="v72b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=6) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v73a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=6) { echo "readonly=\"\"";}?>> 
        <input name="v73b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=6) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v74a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=6) { echo "readonly=\"\"";}?>> 
        <input name="v74b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=6) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v75a" type="text" class="mio" maxlength="3" <?php if ($num<=6) { echo "readonly=\"\"";}?>> 
        <input name="v75b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=6) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v76a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=6) { echo "readonly=\"\"";}?>> 
        <input name="v76b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=6) { echo "readonly=\"\"";}?>></td>
      <td><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[6]'>"; echo substr($cab[6],0,10).".."; echo "</a></div>"; ?></strong></font></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center"  <?php if ($num<=7) {echo "bgcolor=\"#9999CC\"";}?> > 
      <td height="21"><div align="center"><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[7]'>"; echo substr($cab[7],0,10).".."; echo "</a></div>"; ?></strong></font></div></td>
      <td onKeyUp="Form()"><input name="v81a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=7) { echo "readonly=\"\"";}?>> 
        <input name="v81b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=7) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v82a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=7) { echo "readonly=\"\"";}?>> 
        <input name="v82b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=7) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v83a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=7) { echo "readonly=\"\"";}?>> 
        <input name="v83b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=7) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v84a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=7) { echo "readonly=\"\"";}?>> 
        <input name="v84b" type="text" class="mio" onChange="Form()" maxlength="3"<?php if ($num<=7) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v85a" type="text" class="mio" onChange="Form()" maxlength="3"<?php if ($num<=7) { echo "readonly=\"\"";}?>> 
        <input name="v85b" type="text" class="mio" onChange="Form()" maxlength="3"<?php if ($num<=7) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v86a" type="text" class="mio" onChange="Form()" maxlength="3"<?php if ($num<=7) { echo "readonly=\"\"";}?>> 
        <input name="v86b" type="text" class="mio" onChange="Form()" maxlength="3"<?php if ($num<=7) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v87a" type="text" class="mio" onChange="Form()" maxlength="3"<?php if ($num<=7) { echo "readonly=\"\"";}?>> 
        <input name="v87b" type="text" class="mio" onChange="Form()" maxlength="3"<?php if ($num<=7) { echo "readonly=\"\"";}?>></td>
      <td><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[7]'>"; echo substr($cab[7],0,10).".."; echo "</a></div>"; ?></strong></font></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center"  <?php if ($num<=8) {echo "bgcolor=\"#9999CC\""; }?>> 
      <td height="21"><div align="center"><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[8]'>"; echo substr($cab[8],0,10).".."; echo "</a></div>"; ?></strong></font></div></td>
      <td onKeyUp="Form()"><input name="v91a" type="text" class="mio" onChange="Form()" maxlength="3"<?php if ($num<=8) { echo "readonly=\"\"";}?>> 
        <input name="v91b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v92a" type="text" class="mio" onChange="Form()"  maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>> 
        <input name="v92b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v93a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>> 
        <input name="v93b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v94a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>> 
        <input name="v94b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v95a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>> 
        <input name="v95b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v96a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>> 
        <input name="v96b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v97a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>> 
        <input name="v97b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v98a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>> 
        <input name="v98b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=8) { echo "readonly=\"\"";}?>></td>
      <td><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[8]'>"; echo substr($cab[8],0,10).".."; echo "</a></div>"; ?></strong></font></td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center"  <?php if ($num<=9) {echo "bgcolor=\"#9999CC\""; }?>> 
      <td height="24"><div align="center"><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[9]'>"; echo substr($cab[9],0,10).".."; echo "</a></div>"; ?></strong></font></div></td>
      <td onKeyUp="Form()"><input name="v101a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>> 
        <input name="v101b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v102a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>> 
        <input name="v102b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v103a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>> 
        <input name="v103b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v104a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>> 
        <input name="v104b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v105a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>> 
        <input name="v105b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v106a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>> 
        <input name="v106b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v107a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>> 
        <input name="v107b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v108a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>> 
        <input name="v108b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>></td>
      <td onKeyUp="Form()"><input name="v109a" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>> 
        <input name="v109b" type="text" class="mio" onChange="Form()" maxlength="3" <?php if ($num<=9) { echo "readonly=\"\"";}?>></td>
      <td><font size="1"><strong><?php echo "<div style=cursor:hand><a title='$cab[9]'>"; echo substr($cab[9],0,10).".."; echo "</a></div>"; ?></strong></font></td>
    </tr>
    <tr align="center"> 
      <td height="21"><div align="center"><img src="images/sum.jpg" width="10" height="18"></div></td>
      <td><input name="v111a" type="text" class="mio2"  maxlength="3" readdonly=""></td>
      <td><input name="v112a" type="text" class="mio2" maxlength="3" readonly=""></td>
      <td><input name="v113a" type="text" class="mio2"  maxlength="3" readonly=""></td>
      <td><input name="v114a" type="text" class="mio2"  maxlength="3" readonly=""></td>
      <td><input name="v115a" type="text" class="mio2"  maxlength="3" readonly=""></td>
      <td><input name="v116a" type="text" class="mio2"  maxlength="3" readonly=""></td>
      <td><input name="v117a" type="text" class="mio2"  maxlength="3" readonly=""></td>
      <td><input name="v118a" type="text" class="mio2"  maxlength="3" readonly=""></td>
      <td><input name="v119a" type="text" class="mio2"  maxlength="3" readonly=""></td>
      <td><input name="v1110a" type="text" class="mio2"  maxlength="3" readonly=""></td>
    </tr>
  </table>
  <br>
</form>
<br>
<?php include("top_.php");?>