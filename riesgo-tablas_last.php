
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
if(isset($_REQUEST['op'])) $op=$_REQUEST['op']; else $op="";
if(isset($_REQUEST['idproc'])) $idproc=$_REQUEST['idproc']; else $idproc="";
if(isset($_REQUEST['pg'])) $pg=$_REQUEST['pg']; else $pg="";
if(isset($_REQUEST['BUSCAR'])) $BUSCAR=$_REQUEST['BUSCAR']; else $BUSCAR="";
if(isset($_REQUEST['menu'])) $menu=$_REQUEST['menu']; else $menu="";
if(isset($_REQUEST['busc'])) $busc=$_REQUEST['busc']; else $busc="";
if(isset($_REQUEST['modif'])) $modif=$_REQUEST['modif']; else $modif="";
if(isset($_REQUEST['id_riesgo0'])) $id_riesgo0=$_REQUEST['id_riesgo0']; else $id_riesgo0="";
if(isset($_REQUEST['id_riesgo0mod'])) $id_riesgo0mod=$_REQUEST['id_riesgo0mod']; else $id_riesgo0mod="";

if(isset($_REQUEST['titulo'])) $titulo=$_REQUEST['titulo']; else $titulo="";
if(isset($_REQUEST['descrip'])) $descrip=$_REQUEST['descrip']; else $descrip="";
	
	
$login=$_SESSION["login"];
if (isset($retornar)) { 
header("location: riesgo-opciones.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
	//else { header("location:procesos_last.php?pg=$pg&id_proceso=$idproc&pg=$pg"); }
//	if (!idproc) { header("location: riesgo-opciones.php?idproc=$idproc"); }
//	else { header("location:procesos_last.php?pg=$pg&id_proceso=$idproc&pg=$pg"); }
}
else if (isset($graficar)) { header("location: riesgo-tablamatrix.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc"); }

include("conexion.php");	
$num=0;

$sql0 = "SELECT * FROM riesgo_parametros";
$result0 = mysql_query($sql0);
$row0 = mysql_fetch_array($result0);
$partic = $row0['participantes'];

$matrix0[]=0;
$matrix1[]=0;
$sql0 = "SELECT * FROM riesgo_probabilidad ORDER BY valoracion";
$result0 = mysql_query($sql0);
while($row=mysql_fetch_array($result0)) {
	$matrix0[$num]=$row['descripcion'];
	$matrix1[$num]=$row['valoracion'];
	$num++;
}

$num=0;
$matrix2[]=0;
$matrix3[]=0;
$sql1 = "SELECT * FROM riesgo_impacto ORDER BY val_impac";
$result1 = mysql_query($sql1);
while($row1=mysql_fetch_array($result1)) {
	$matrix2[$num]=$row1['desc_impac'];
	$matrix3[$num]=$row1['val_impac'];
	$num++;
}

$num=0;
if(isset($_REQUEST['guardar'])){
	if($modif=="si"){
		$borr="DELETE FROM riesgo_resptabla WHERE id_riesgo0='$id_riesgo0mod'";
		if ($op=="T" OR $op==""){$sql = "SELECT * FROM riesgo_pregunta ORDER BY tipo_r ASC";}
		else{$sql = "SELECT * FROM riesgo_pregunta WHERE tipo_r='$op'";}
		$result = mysql_query($sql);
		$cuantos = mysql_num_rows($result);
		$nume=0;
		$fecha=date("Y-m-d");
		$mriesgo=$id_riesgo0;
		while($row=mysql_fetch_array($result)) {
			$num++;
			$val1 = $_POST["va$num"];
			$val2 = $_POST["vb$num"];
			$val3 = $_POST["vc$num"];
			if($nume=="0") $sql3="INSERT INTO riesgo_resptabla(id_riesgo0,id_riesgo,realizado_por,val1,val2,val3,titulo,descripcion,fecha,proceso) VALUES ('$id_riesgo0mod','$row[id_riesgo]','$login','$val1','$val2','$val3','$titulo','$descrip','$fecha','$idproc')";
			else $sql3="INSERT INTO riesgo_resptabla(id_riesgo0,id_riesgo,val1,val2,val3,titulo,fecha,proceso) VALUES ('$id_riesgo0mod','$row[id_riesgo]','$val1','$val2','$val3','$titulo','$fecha','$idproc')";
			mysql_query($sql3);
			$nume++;
		}
	}else{
		$sql = "SELECT * FROM riesgo_pregunta a, riesgo_resptabla b WHERE b.id_riesgo=a.id_riesgo AND b.id_riesgo0='$id_riesgo0' ORDER BY tipo_r ASC";
		$res = mysql_query($sql);
		while($row = mysql_fetch_array($res)){
			$num++;
			$fecha=date("Y-m-d");
			$val1 = $_POST["va$num"];
			$val2 = $_POST["vb$num"];
			$val3 = $_POST["vc$num"];
			if($num==1) $sqlmod="UPDATE riesgo_resptabla SET realizado_por='$login',val1='$val1',val2='$val2',val3='$val3',titulo='$titulo',descripcion='$descrip',fecha='$fecha',proceso='$idproc' WHERE id_riesgo0='$id_riesgo0' AND id_riesgo='$row[id_riesgo]'";
			else $sqlmod="UPDATE riesgo_resptabla SET val1='$val1',val2='$val2',val3='$val3',titulo='$titulo',fecha='$fecha',proceso='$idproc' WHERE id_riesgo0='$id_riesgo0' AND id_riesgo='$row[id_riesgo]'";
			mysql_query($sqlmod);
		}
	}
	//exit;
	header("location: riesgo-resultados1.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
}

@$sql_mod="SELECT * FROM riesgo_resptabla WHERE id_riesgo0='$id_riesgo0' LIMIT 1";
$res_mod=mysql_query($sql_mod);
$row_mod=mysql_fetch_array($res_mod);

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
<form name="form2" action="" method="post">

<table width="70%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <tr> 
      <th height="23" colspan="5" background="images/main-button-tileR1.jpg">TABLAS</th>
    </tr>
	<tr>
      <th height="39" colspan="5" background="images/main-button-tileR2.jpg"><font size="2">Seleccione el Grupo de Riesgo 
        : 
        <select name="select" onChange="tipo(this.value)">
          <option value="T">TODOS</option>
          <?php
		$sql3 = "SELECT * FROM riesgo_tipos";
		$result3 = mysql_query($sql3);
		while($row3=mysql_fetch_array($result3)) 
		{
			echo "<option value=\"$row3[id_riesgo]\"";
			if (isset ($op) && $op==$row3['id_riesgo']){echo "selected";}
			echo ">$row3[descripcion]</option>";
		}
		?>
        </select>
        </font></th>
    </tr>
	</table>

</form>
<form name="form1" method="post" action="" onKeyPress="multiplicar()" onClick="multiplicar()">
  <table width="70%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <tr align="center"> 
      <td height="24" colspan="2">TITULO: 
        <input name="titulo" type="text" id="titulo" value="<?php echo $row_mod['titulo'];?>"></td>
      <td colspan="3" valign="top">
<div align="center">
          <table width="100%" border="0">
            <tr>
              <td width="36%" valign="middle"><div align="right">DESCRIPCION: </div></td>
              <td width="64%"><textarea name="descrip" cols="30" rows="2"><?php echo $row_mod['descripcion'];?></textarea></td>
            </tr>
          </table>
        </div></td>
    </tr>
    <tr align="center"> 
      <td width="34" class="menu" background="images/main-button-tileR1.jpg" height="20">NRO</td>
      <td width="301" class="menu" background="images/main-button-tileR1.jpg" height="20">DESCRIPCION</td>
      <td class="menu" background="images/main-button-tileR1.jpg" height="20">PROBABILIDAD (VALOR)</td>
      <td class="menu" background="images/main-button-tileR1.jpg" height="20">IMPACTO (VALOR)</td>
      <td width="56" class="menu" background="images/main-button-tileR1.jpg" height="20">RIESGO</td>
    </tr>
    <?php
		if(isset($id_riesgo0)){
			$sql= "SELECT * FROM riesgo_pregunta a, riesgo_resptabla b WHERE b.id_riesgo=a.id_riesgo AND b.id_riesgo0='$id_riesgo0' ORDER BY tipo_r ASC";
		}else{
			if ($op=="T" OR $op==""){$sql = "SELECT * FROM riesgo_pregunta ORDER BY tipo_r ASC";}
			else {$sql = "SELECT * FROM riesgo_pregunta WHERE tipo_r='$op'";}
		}
		$result=mysql_query($sql);
		$num=0;
		while($row=mysql_fetch_array($result)) {
			$num++;
			echo "<tr align=\"center\">";
			echo " <td>".$num."</td>";
			echo " <td align=\"center\">".$row['desc_riesgo']."</td>"; //echo " <td><input name=\"v".$num."a \" type=\"text\" class=\"mio2\" maxlength=\"4\"></td>";
			echo " <td><select name=\"va".$num."\">";
			for($j=0;$j<count($matrix0);$j++){			
				echo "<option value=\"".$matrix1[$j]."\"";
				if($row['val1'] == $matrix1[$j]) echo " selected";
				echo ">".$matrix0[$j]." (".$matrix1[$j]. ") </option>";
			}
			echo "</select></td>\n";

			echo " <td><select name=\"vb".$num."\" >";
			for($jj=0;$jj<count($matrix2);$jj++){			
				echo "<option value=\"".$matrix3[$jj]."\"";
				if($row['val2'] == $matrix3[$jj]) echo " selected";
				echo ">".$matrix2[$jj]." (".$matrix3[$jj]. ") </option>";
			}
			echo "</select></td>\n";
			echo " <td><input name=\"vc".$num."\" type=\"text\" value=\"$row[val3]\" class=\"mio2\" maxlength=\"4\" readonly=\"\"></td>";
			echo "<tr>\n";
       	}
	 ?>
  </table>
  <br>
   <input type="submit" name="guardar" value="GUARDAR" <?php echo $valid->onSubmit(); ?>>
  <input name="op" type="hidden" value="<?php echo $op;?>">
   <input name="idproc" type="hidden" id="idproc" value="<?php echo $idproc;?>">
   <input name="pg" type="hidden" id="pg" value="<?php echo $pg;?>">
   <input name="BUSCAR" type="hidden" value="<?php echo $BUSCAR;?>">
   <input name="menu" type="hidden" value="<?php echo $menu;?>">
   <input name="busc" type="hidden" value="<?php echo $busc;?>">
   
  <input name="modif" type="hidden" id="modif" value="<?php echo $modif;?>">
  <input name="id_riesgo0" type="hidden" id="id_riesgo0" value="<?php echo $id_riesgo0;?>">
  <input name="id_riesgo0mod" type="hidden" id="id_riesgo0mod" value="<?php echo $id_riesgo0mod;?>">
</form>
<script language="JavaScript">
<!--
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function tipo(numero){        
	if(confirm("Los datos almacenados se perderan.\nMensaje generado por GestorF1")){
		var idproc="<?php echo @$idproc?>"
		var pg="<?php echo @$pg?>"
		irapagina("riesgo-tablas_last.php?op="+numero+"&idproc="+idproc+"&pg="+pg+"&modif=si&id_riesgo0mod=<?php=$id_riesgo0?>");}
}
//-->
</script>