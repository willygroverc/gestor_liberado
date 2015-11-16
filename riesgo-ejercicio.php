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
require_once("funciones.php");
//if (valida("Riesgo")=="bad") {header("location: pagina_error.php");}

if (isset($retornar)) { header("location: riesgo-opciones.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc"); }
if (isset($continuar)) {
	$clase = $_POST['clasi'];
	require("conexion.php");
	$sql="UPDATE riesgo_pregunta SET sel='0'";
	mysql_query($sql);
	for($i=0 ; $i < count($clase) ; $i++) {
		$sql="UPDATE riesgo_pregunta SET sel='1' WHERE id_riesgo='$clase[$i]'";
		if (!mysql_query($sql)){
			$msg="OCURRIO UN ERROR MIENTRAS SE ACTUALIZABA LA BASE DE DATOS ".mysql_errno().": ".mysql_error();
		}
	}
	if ($continuar){header("location: riesgo-matrix.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");}
}

if (isset($reg_form)) {
	include("conexion.php");
	if($fase=="nuevo"){
		$sql3="INSERT INTO riesgo_pregunta (desc_riesgo,tipo,sel) VALUES ('$desc_riesgo','$tipo''0')";
	}
	else{
		$sql3="UPDATE riesgo_pregunta SET desc_riesgo='$desc_riesgo',tipo='$tipo' WHERE id_riesgo='$fase'";
	}
	mysql_query($sql3);
}
include("top.php");
?>
<script language="JavaScript">
<!--
function Check()
{
    var elts      = document.form1.elements['clasi[]']; //document.forms[the_form].elements['selected_tbl[]'];
    var elts_cnt  = elts.length;
	var u=0;
    for (var i = 0; i < elts_cnt; i++) {
        if (elts[i].checked) u++;
    } 
	
	if (u > 10){
		alert("Solo se pueden seleccionar 10 riesgos \n \n Mensaje generado por GesTor F1.");
		return false;
	}
	return true;
} 
-->
</script>
  
<form name="form2" method="post" action="">  
<table width="70%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <tr> 
      <th colspan="5" background="images/main-button-tileR1.jpg" height="20">IDENTIFICAR RIESGOS</th>
    </tr>
	<tr>
      <th height="39" colspan="5" background="images/main-button-tileR2.jpg"><font size="2">Seleccione el Grupo de Riesgo : 
        </font> 
        <select name="select" onChange="tipo(this.value)">
		<option value="T">TODOS</option>
		 <?php
		$sql3 = "SELECT * FROM riesgo_tipos";
		$result3 = mysql_query($sql3);
		while($row3=mysql_fetch_array($result3)) 
		{
			echo '<option value="'.$row3['id_riesgo'].'"';
			if ($op==$row3['id_riesgo']){echo "selected";}
			echo ">$row3[descripcion]</option>";
		}
		?>
        </select>
  
      
    </th>
    </tr>
	</table>    </form>
	<form name="form1" method="post" action="<?php=$PHP_SELF ?>" onClick="return Check()" >
	
  <table width="70%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <tr align="center"> 
      <td class="menu" background="images/main-button-tileR1.jpg" height="20">NRO</td>
      <td class="menu" background="images/main-button-tileR1.jpg" height="20">DESCRIPCION DEL RIESGO</td>
      <td class="menu" background="images/main-button-tileR1.jpg" height="20">TIPO</td>
      <td class="menu" background="images/main-button-tileR1.jpg" height="20">SELECCION</td>
    </tr>
    <?php
		if (@$op=="T" OR @$op==""){$sql = "SELECT * FROM riesgo_pregunta ORDER BY tipo_r ASC";}
		else {$sql = "SELECT * FROM riesgo_pregunta WHERE tipo_r='$op'";}
		$result=mysql_query($sql);
		$i=1;
		while($row=mysql_fetch_array($result)) {
		 ?>
    <tr> <?php echo "<td align=\"center\">".$i."</a></td>";?> 
      <td><div align="center"><?php echo $row['desc_riesgo'];?> </div></td>
      <td align="center"><div align="center">
        <?php 
	  	  	$sql3_1 = "SELECT * FROM riesgo_tipos WHERE id_riesgo='".$row['tipo_r']."'";
			$result3_1 = mysql_query($sql3_1);
			$row3_1=mysql_fetch_array($result3_1); 
		  	echo $row3_1['descripcion'];   
		  ?>
        </div></td>
      <td align="center"><input type="checkbox" name="clasi[]" value="<?php echo urlencode($row['id_riesgo']);?>" <?php if ($row['sel']== "1") echo "checked"?>> 
      </td>
    </tr>
    <?php $i=$i+1;} ?>
    
	<!--
	<tr> 
      <th colspan="4">NUEVO / MODIFICAR</th>
    </tr>
    <tr> 
      <td> <select name="fase">
          <option value="<?php //echo $variable1?>" > 
          <?php //echo $variable1?></option>
          <option value="nuevo" <?php //if(!isset($variable1)) echo "selected"?> >Nuevo</option>
        </select> </td>
      <?php 
	/* $sql2 = "SELECT * FROM riesgo_pregunta WHERE id_riesgo='$variable1'";
	 $result2 = mysql_query($sql2);
	 $row2 = mysql_fetch_array($result2);*/
	 ?>
      <td> <input name="desc_riesgo" type="text" size="55" maxlength="255" value="<?php //echo $row2[desc_riesgo];?>" > 
      </td>
      <td> <select name="tipo">
          <option value="1" <?php //if ($row2[tipo]=="1") echo "selected"?> >NATURAL</option>
          <option value="2" <?php //if ($row2[tipo]=="2") echo "selected"?> >ENTORNO</option>
          <option value="3" <?php //if ($row2[tipo]=="3") echo "selected"?> >HUMANO</option>
        </select> </td>
      <td width="76" nowrap height="7"><input name="reg_form" type="submit" value="GUARDAR" > 
    </tr>
	-->
	
  </table>
	<br>
	<!-- <input name="guardar" type="submit" value="GUARDAR"> &nbsp;&nbsp;&nbsp;-->
	<input name="continuar" type="submit" value="CONTINUAR"> &nbsp;&nbsp;&nbsp;
    <input type="submit" name="retornar" value="RETORNAR">
    <input name="BUSCAR" type="hidden" value="<?php echo $BUSCAR;?>">
    <input name="menu" type="hidden" value="<?php echo $menu;?>">
    <input name="busc" type="hidden" value="<?php echo $busc;?>">
    <input name="idproc" type="hidden" id="idproc" value="<?php echo $idproc;?>">
    <input name="pg" type="hidden" id="pg" value="<?php echo $pg;?>">
    </form>
<br>
<script language="JavaScript">
<!--
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function tipo(numero){        
	 irapagina("riesgo-ejercicio.php?op="+numero);
}
//-->
</script>