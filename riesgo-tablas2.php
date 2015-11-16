<?php 
require_once("funciones.php");
//if (valida("Riesgo")=="bad") {header("location: pagina_error.php");}

if (isset($retornar)) { header("location: riesgo-opciones.php"); }
else if (isset($graficar)) { header("location: riesgo-tablamatrix.php"); }

include("conexion.php");	
$num=0;

$sql0 = "SELECT * FROM riesgo_parametros";
$result0 = mysql_db_query($db,$sql0,$link);
$row0 = mysql_fetch_array($result0);
$partic = $row0[participantes];

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
$sql = "SELECT * FROM riesgo_pregunta";
$result = mysql_db_query($db,$sql,$link);
$cuantos = mysql_num_rows($result);
if (isset($guardar)){
	while($row=mysql_fetch_array($result)) {
		$num++;
		$val1 = $_POST["va$num"];
		$val2 = $_POST["vb$num"];
		$val3 = $_POST["vc$num"];
		$sql3="INSERT INTO riesgo_resptabla(id_riesgo,val1,val2,val3,titulo) VALUES ('$row[id_riesgo]','$val1','$val2','$val3','$titulo')";
		mysql_db_query($db,$sql3,$link);
	}
	header("location: riesgo-resultados1.php");
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
    for (var i = 1; i < elts.length-1; i=i+3) {
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
<?php echo $val1."  "; echo $val2;?>
<form name="form1" method="post" action="<?php=$PHP_SELF ?>" onKeyPress="multiplicar()" onClick="multiplicar()">
  <table width="70%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <tr> 
      <th height="10" colspan="5">TABLAS</th>
    </tr>
    <tr>
      <th height="11" colspan="5"><font size="2">Seleccione el Grupo de Riesgo 
        : 
        <input type="radio" name="t_grupo" value="T" <?php if ($op=="T" OR $op==""){echo "checked";}?> onClick="tipo(this.value)">
        Todos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input type="radio" name="t_grupo" value="N" <?php if ($op=="N"){echo "checked";}?> onClick="tipo(this.value)">
        Natural&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input type="radio" name="t_grupo" value="E" <?php if ($op=="E"){echo "checked";}?> onClick="tipo(this.value)">
        Entorno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input type="radio" name="t_grupo" value="H" <?php if ($op=="H"){echo "checked";}?> onClick="tipo(this.value)">
        Humanos</font></th>
    </tr>
    <tr align="center"> 
      <td colspan="5">TITULO: 
        <input name="titulo" type="text" id="titulo"></td>
    </tr>
    <tr align="center"> 
      <td width="34" class="menu">NRO</td>
      <td width="301" class="menu">DESCRIPCION</td>
      <td class="menu">PROBABILIDAD (VALOR)</td>
      <td class="menu">IMPACTO (VALOR)</td>
      <td width="56" class="menu">RIESGO</td>
    </tr>
    <?php
		if ($op=="T" OR $op==""){$sql = "SELECT * FROM riesgo_pregunta ORDER BY tipo ASC";}
		if ($op=="N"){$sql = "SELECT * FROM riesgo_pregunta WHERE tipo='1'";}
		if ($op=="E"){$sql = "SELECT * FROM riesgo_pregunta WHERE tipo='2'";}
		if ($op=="H"){$sql = "SELECT * FROM riesgo_pregunta WHERE tipo='3'";}
		$result=mysql_db_query($db,$sql,$link);
		$num=0;
		while($row=mysql_fetch_array($result)) {
			$num++;
			echo "<tr align=\"center\">";
			echo " <td>".$num."</td>";
			echo " <td align=\"center\">".$row[desc_riesgo]."</td>"; //echo " <td><input name=\"v".$num."a \" type=\"text\" class=\"mio2\" maxlength=\"4\"></td>";
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
	 irapagina("riesgo-tablas.php?op="+numero);
}
//-->
</script>