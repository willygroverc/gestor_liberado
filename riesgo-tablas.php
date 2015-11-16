<?php 
session_start();
$login=$_SESSION["login"];
if (isset($_REQUEST['retornar'])) { 
header("location: riesgo-opciones.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
	//else { header("location:procesos_last.php?pg=$pg&id_proceso=$idproc&pg=$pg"); }
//	if (!idproc) { header("location: riesgo-opciones.php?idproc=$idproc"); }
//	else { header("location:procesos_last.php?pg=$pg&id_proceso=$idproc&pg=$pg"); }
}
else if (isset($_REQUEST['graficar'])) { header("location: riesgo-tablamatrix.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc"); }

include("conexion.php");	
$num=0;

$sql0 = "SELECT * FROM riesgo_parametros";
$result0 = mysql_db_query($db,$sql0,$link);
$row0 = mysql_fetch_array($result0);
$partic = $row0['participantes'];

$matrix0[]=0;
$matrix1[]=0;
$sql0 = "SELECT * FROM riesgo_probabilidad ORDER BY valoracion";
$result0 = mysql_db_query($db,$sql0,$link);
while($row=mysql_fetch_array($result0)) {
	$matrix0[$num]=$row['descripcion'];
	$matrix1[$num]=$row['valoracion'];
	$num++;
}

$num=0;
$matrix2[]=0;
$matrix3[]=0;
$sql1 = "SELECT * FROM riesgo_impacto ORDER BY val_impac";
$result1 = mysql_db_query($db,$sql1,$link);
while($row1=mysql_fetch_array($result1)) {
	$matrix2[$num]=$row1['desc_impac'];
	$matrix3[$num]=$row1['val_impac'];
	$num++;
}

$num=0;

if ($_REQUEST['op']=="T" OR $_REQUEST['op']==""){$sql = "SELECT * FROM riesgo_pregunta ORDER BY tipo_r ASC";}
else{$sql = "SELECT * FROM riesgo_pregunta WHERE tipo_r='$_REQUEST[op]'";}
$result = mysql_db_query($db,$sql,$link);
$cuantos = mysql_num_rows($result);
$nume=0;
$fecha=date("Y-m-d");
$hora=date("H:i:s");
$sql0_1 = "SELECT MAX(id_riesgo0) AS maxid FROM riesgo_resptabla";
$result0_1 = mysql_db_query($db,$sql0_1,$link);
$row0_1 = mysql_fetch_array($result0_1);
$mriesgo=$row0_1['maxid']+1;
if (isset($_REQUEST['guardar'])){
        $titulo=$_REQUEST['titulo'];
        $descrip=$_REQUEST['descrip'];
        $idproc=$_REQUEST['idproc'];
	while($row=mysql_fetch_array($result)) {
		$num++;
		$val1 = $_POST["va$num"];
		$val2 = $_POST["vb$num"];
		$val3 = $_POST["vc$num"];
		if($nume=="0")
		{
			$sql3="INSERT INTO riesgo_resptabla(id_riesgo0,id_riesgo,realizado_por,val1,val2,val3,titulo,descripcion,fecha,hora,proceso) VALUES ('$mriesgo','$row[id_riesgo]','$login','$val1','$val2','$val3','$titulo','$descrip','$fecha','$hora','$idproc')";
			//print_r($sql3);exit;
                        mysql_query($sql3);
		}
		else
		{
			$sql3="INSERT INTO riesgo_resptabla(id_riesgo0,id_riesgo,realizado_por,val1,val2,val3,titulo,descripcion,fecha,hora,proceso,obs) VALUES ('$mriesgo','$row[id_riesgo]','$login','$val1','$val2','$val3','$titulo','$descrip','$fecha','$hora','0','0')";
			//print_r($sql3);exit;
                        mysql_query($sql3);
		}
		$nume++;
	}
	//echo $sql3;
	header("location: riesgo-resultados1.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
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
function multiplicar(){
    var elts      = document.form1.elements; //document.forms[the_form].elements['selected_tbl[]'];
	var a,b;
    for (var i = 2; i < elts.length-1; i=i+3) {
		if (elts[i].type=="select-one") {
			a=parseFloat(elts[i].value);
			b=parseFloat(elts[i+1].value);
			if (isNaN(a)) {a = 0;} 
			if (isNaN(b)) {b = 0;} 
			
			elts[i+2].value = a*b;
		}
    } 
}
//-->
</script>
<form name="form2" action="<?php=$_SERVER['PHP_SELF'] ?>" method="post">

<table width="70%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <tr> 
      <th height="23" colspan="5">TABLAS</th>
    </tr>
	<tr>
      <th height="39" colspan="5"><font size="2">Seleccione el Grupo de Riesgo 
        : 
        <select name="select" onChange="tipo(this.value)">
          <option value="T">TODOS</option>
          <?php
		$sql3 = "SELECT * FROM riesgo_tipos";
		$result3 = mysql_db_query($db,$sql3,$link);
		while($row3=mysql_fetch_array($result3)) 
		{
			echo "<option value=\"$row3[id_riesgo]\"";
			if ($_REQUEST['op']==$row3['id_riesgo']){echo "selected";}
			echo ">$row3[descripcion]</option>";
		}
		?>
        </select>
        </font></th>
    </tr>
	</table>

</form>
<?php 
                echo @$val1."  "; echo @$val2;?> 
<form name="form1" method="post" action="<?php=$_SERVER['PHP_SELF'] ?>" onKeyPress="multiplicar()" onClick="multiplicar()">
  <table width="70%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <tr align="center"> 
      <td height="24" colspan="2">TITULO: 
        <input name="titulo" type="text" id="titulo"></td>
      <td colspan="3" valign="top">
<div align="center">
          <table width="100%" border="0">
            <tr>
              <td width="36%" valign="middle"><div align="right">DESCRIPCION: </div></td>
              <td width="64%"><textarea name="descrip" id="descrip" cols="30" rows="2"></textarea></td>
            </tr>
          </table>
        </div></td>
    </tr>
    <tr align="center"> 
      <td width="34" class="menu">NRO</td>
      <td width="301" class="menu">DESCRIPCION</td>
      <td class="menu">PROBABILIDAD (VALOR)</td>
      <td class="menu">IMPACTO (VALOR)</td>
      <td width="56" class="menu">RIESGO</td>
    </tr>
    <?php
		if ($_REQUEST['op']=="T" OR $_REQUEST['op']==""){$sql = "SELECT * FROM riesgo_pregunta ORDER BY tipo_r ASC";}
		else {$sql = "SELECT * FROM riesgo_pregunta WHERE tipo_r='$_REQUEST[op]'";}
		$result=mysql_db_query($db,$sql,$link);
		$num=0;
		while($row=mysql_fetch_array($result)) {
			$num++;
			echo "<tr align=\"center\">";
			echo " <td>".$num."</td>";
			echo " <td align=\"center\">".$row['desc_riesgo']."</td>"; //echo " <td><input name=\"v".$num."a \" type=\"text\" class=\"mio2\" maxlength=\"4\"></td>";
			echo " <td><select name=\"va".$num."\" >";
			for($j=0;$j<count($matrix0);$j++){			
				echo "<option value=\"".$matrix1[$j]."\">".$matrix0[$j]." (".$matrix1[$j]. ") </option>";
			}
			echo "</select></td>\n";

			echo " <td><select name=\"vb".$num."\" >";
			for($jj=0;$jj<count($matrix2);$jj++){			
				echo "<option value=\"".$matrix3[$jj]."\">".$matrix2[$jj]." (".$matrix3[$jj]. ") </option>";
			}
			echo "</select></td>\n";
			echo " <td><input name=\"vc".$num."\" type=\"text\" class=\"mio2\" maxlength=\"4\" readonly=\"\"></td>";
			echo "<tr>\n";
       	}

	 ?>
  </table>
  <br>
   <input type="submit" name="guardar" value="GUARDAR" <?php echo $valid->onSubmit(); ?>>&nbsp;&nbsp;&nbsp;
   <input type="submit" name="retornar" value="RETORNAR">
   <input name="op" type="hidden" value="<?php echo $_REQUEST['op'];?>">
   <input name="idproc" type="hidden" id="idproc" value="<?php echo $_REQUEST['idproc'];?>">
   <input name="pg" type="hidden" id="pg" value="<?php echo $_REQUEST['pg'];?>">
   <input name="BUSCAR" type="hidden" value="<?php echo $_REQUEST['BUSCAR'];?>">
   <input name="menu" type="hidden" value="<?php echo $_REQUEST['menu'];?>">
   <input name="busc" type="hidden" value="<?php echo $_REQUEST['busc'];?>">
</form>
<?php include("top_.php");?>
<script language="JavaScript">
<!--
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function tipo(numero){        
	var idproc="<?php echo $_REQUEST['idproc']?>"
	var pg="<?php echo $_REQUEST['pg']?>"
	 irapagina("riesgo-tablas.php?op="+numero+"&idproc="+idproc+"&pg="+pg);
}
//-->
</script>