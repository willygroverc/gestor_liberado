<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
require ("conexion.php");
@session_start();
$idproc=  isset($_REQUEST['idproc']);
$pg=  isset($_REQUEST['pg']);
$BUSCAR=isset($_REQUEST['BUSCAR']);
$menu=isset($_REQUEST['menu']);
$busc=isset($_REQUEST['busc']);
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require_once("funciones.php");
//if (valida("Riesgo")=="bad") {header("location: pagina_error.php");}

if (isset($_REQUEST['retornar'])) { header("location: menu_parametros.php"); }

if (isset($_REQUEST['guardar'])) {
   	$sql = "SELECT * FROM riesgo_parametros";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if ($row['id_parametro']=="")	{
		$sql = "INSERT INTO riesgo_parametros (participantes) VALUES ('$_REQUEST[participantes]')";
	}
   	else{
		$sql = "UPDATE riesgo_parametros SET participantes='$_REQUEST[participantes]'";   
	}
	if (!mysql_query($sql)){ 
		$msg="OCURRIO UN ERROR EN LA MIENTRAS SE ACTUALIZABA";
	}
	header("location: riesgo-parametros.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
} 

else if (isset($_REQUEST['reg_form'])) {
	if($_REQUEST['fase']=="nuevo"){
		$sql3="INSERT INTO riesgo_probabilidad (descripcion,valoracion) VALUES ('$_REQUEST[descripcion]','$_REQUEST[valoracion]')";
	}
	else {
		$sql3="UPDATE riesgo_probabilidad SET descripcion='$_REQUEST[descripcion]',valoracion='$_REQUEST[valoracion]' WHERE id_probabilidad='$_REQUEST[fase]'";
	}
	mysql_query($sql3);
	header("location: riesgo-parametros.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
}

else if (isset($_REQUEST['reg_form1'])) {
	if($_REQUEST['fase1']=="nuevo"){
		$sql3="INSERT INTO riesgo_impacto (desc_impac,val_impac) VALUES ('$_REQUEST[desc_impac]','$_REQUEST[val_impac]')";
	}
	else {
		$sql3="UPDATE riesgo_impacto SET desc_impac='$_REQUEST[desc_impac]',val_impac='$_REQUEST[val_impac]' WHERE id_impacto='$_REQUEST[fase1]'";
	}
	mysql_query($sql3);
	header("location: riesgo-parametros.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
}
else if (isset($_REQUEST['reg_form2'])) 
{
	$sql_nr = "SELECT count(*) AS numreg FROM riesgo_tipos";
	$result_nr = mysql_query($sql_nr);
	$row_nr = mysql_fetch_array($result_nr);
	if ($row_nr['numreg']<25 AND $_REQUEST['fase0']=="nuevo")
	{
		$sql3="INSERT INTO riesgo_tipos (descripcion) VALUES ('$_REQUEST[descripcion0]')";
                //print_r($sql3);exit;
	}
	elseif ($row_nr['numreg']>=25 AND $_REQUEST['fase0']=="nuevo")
	{ $msg="Solo puede introducir como maximo 25 tipos de riesgos";}
	else {
		$sql3="UPDATE riesgo_tipos SET descripcion='$_REQUEST[descripcion0]' WHERE id_riesgo='$_REQUEST[fase0]'";
	}
	mysql_query($sql3);
	header("location: riesgo-parametros.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc&msg=$msg");
}
if (isset($_REQUEST['accion'])){
	if ($_REQUEST['accion']=="elimina")
	{	$sql = "DELETE FROM riesgo_probabilidad WHERE id_probabilidad='$_REQUEST[nom]'";
                //print_r($sql);exit;
		mysql_query($sql);
		header("location: riesgo-parametros.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
	}
        elseif ($_REQUEST['accion']=="elimina1")
	{	$sql = "DELETE FROM riesgo_probabilidad WHERE id_probabilidad='$_REQUEST[nom]'";
                //print_r($sql);exit;
                mysql_query($sql);
		header("location: riesgo-parametros.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
	}
	elseif ($_REQUEST['accion']=="elimina2")
	{	$sql = "DELETE FROM riesgo_impacto WHERE id_impacto='$_REQUEST[nom]'";
		//print_r($sql);exit;
                mysql_query($sql);
		header("location: riesgo-parametros.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
	}
	elseif ($_REQUEST['accion']=="elimina3")
	{	$sql = "DELETE FROM riesgo_tipos WHERE id_riesgo='$_REQUEST[nom]'";
		//print_r($sql);exit;
                mysql_query($sql);
		header("location: riesgo-parametros.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
	}
}
include("top.php");
$sql = "SELECT * FROM riesgo_parametros";
$result=mysql_query($sql);
$row=mysql_fetch_array($result); 
?>

<script language="JavaScript">
<!--
function Check()
{
	var parti=document.form1.participantes.value;
	var valo=document.form1.valoracion.value;
	var val_impac=document.form1.val_impac.value;

	if (isNaN(parti)){
		alert("Ingrese solo numeros \n \n Mensaje generado por GesTor F1.");
		document.form1.participantes.focus();
		return false;
	}
	if(isNaN(valo)){
		alert("Ingrese solo numeros \n \n Mensaje generado por GesTor F1.");
		document.form1.valoracion.focus();
		return false;
	}
	if(isNaN(val_impac)){
		alert("Ingrese solo numeros \\n Mensaje generado por GesTor F1.");
		document.form1.val_impac.focus();
		return false;
	}
	return true;
} 
function confirmLink(theLink, usuario)
{
    var is_confirmed = confirm("Desea Realmente Eliminar "+ ' :\n' + usuario);
    if (is_confirmed) {
        theLink.href += '&accion=elimina1';
    }
    return is_confirmed;
}
function confirmLink2(theLink, usuario)
{
    var is_confirmed = confirm("Desea Realmente Eliminar "+ ' :\n' + usuario);
    if (is_confirmed) {
        theLink.href += '&accion=elimina2';
    }
    return is_confirmed;
}
function confirmLink3(theLink, usuario)
{
    var is_confirmed = confirm("Desea Realmente Eliminar "+ ' :\n' + usuario);
    if (is_confirmed) {
        theLink.href += '&accion=elimina3';
    }
    return is_confirmed;
}
-->
</script>

  <form name="form1" method="post" action="<?php=$_SERVER['PHP_SELF'] ?>"  onSubmit="return Check()">
  <table width="88%" border="0">
    <tr>
      <td width="52%">
	<input name="pg" type="hidden" id="pg" value="<?php echo $_REQUEST['pg']?>">
	<input name="idproc" type="hidden" id="idproc" value="<?php echo $_REQUEST['idproc']?>">
	<input name="BUSCAR" type="hidden" value="<?php echo $_REQUEST['BUSCAR'];?>">
	<input name="menu" type="hidden" value="<?php echo $_REQUEST['menu'];?>">
	<input name="busc" type="hidden" value="<?php echo $_REQUEST['busc'];?>">
<table border="1" align="center" cellpadding="2" cellspacing="2" bgcolor="#EAEAEA"  background="images/fondo.jpg">
          <tr> 
            <th colspan="2" background="images/main-button-tileR1.jpg" height="22">PARAMETROS DE RIESGOS</th>
          </tr>
          <tr> 
            <td>NUMERO DE PARTICIPANTES</td>
            <td align="center" height="47"><input name="participantes" type="text" value="<?php echo $row['participantes']?>" size="3" maxlength="3"> 
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"><input type="submit" name="guardar" value="GUARDAR"></td>
          </tr>
        </table></td>
      <td width="48%">
	  
	  <table border="1" align="center" cellpadding="2" cellspacing="2" bgcolor="#EAEAEA"  background="images/fondo.jpg">
          <tr> 
            <th colspan="4" background="images/main-button-tileR1.jpg" height="22">TIPOS DE RIESGO</th>
          </tr>
          <tr align="center"> 
            <td width="67" class="menu" background="images/main-button-tileR1.jpg" height="22">Nro</td>
            <td width="239" class="menu" background="images/main-button-tileR1.jpg" height="22">Descripcion</td>
            <td width="48" class="menu" background="images/main-button-tileR1.jpg" height="22">Eliminar</td>
          </tr>
		  <?php
			$j=1;
			$sql3 = "SELECT * FROM riesgo_tipos";
			$result3 = mysql_query($sql3);
			while($row3=mysql_fetch_array($result3)) {
      	?>
            <tr align="center"> 
            <td><a href="riesgo-parametros.php?var0=<?php echo $row3['id_riesgo']?>&var0_1=<?php echo $row3['descripcion']?>&idproc=<?php echo $idproc?>&pg=<?php echo $pg.'&BUSCAR='.$BUSCAR.'&menu='.$menu.'&busc='.$busc;?>"> 
              <?php=$j++?>
              </a></td>
            <td><?php echo $row3['descripcion']?></td>
            <?php echo '<td><a href="riesgo-parametros.php?nom='.$row3['id_riesgo'].'&idproc='.$idproc.'&pg='.$pg.'&BUSCAR='.$BUSCAR.'&menu='.$menu.'&busc='.$busc.'" onClick="return confirmLink3(this,\''.$row3['descripcion'].'\')"><img src="images/eliminar.gif" border="0" alt="Eliminar"></a></td>';?> 
          </tr>
          <?php } ?>
          <tr> 
          <tr> 
            <th colspan="4">NUEVO / MODIFICAR</th>
          </tr>
          <tr align="center"> 
              <?php if(isset($_REQUEST['var0'])==''){ $_REQUEST['var0']='';}
              if(isset($_REQUEST['var0_1'])==''){$_REQUEST['var0_1']='';}                  
              ?>
            <td><select name="fase0">
                    <option value="<?php echo isset($_REQUEST['var0']);?>" > <?php echo $_REQUEST['var0'];?></option>
                <option value="nuevo" <?php if(!isset($_REQUEST['var0'])) echo "selected"?> >Nuevo</option>
              </select> </td>
            <td><input name="descripcion0" type="text" size="33" maxlength="43" value="<?php echo $_REQUEST['var0_1'];?>"> 
            <td>&nbsp;</td>
          <tr align="center"> 
            <td colspan="4"><input name="reg_form2" type="submit" value="GUARDAR"> 
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
  <br>
	
  <table width="75%" border="0">
    <tr valign="top">
      <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="2"  background="images/fondo.jpg" bgcolor="#EAEAEA">
          <tr> 
            <th colspan="4" background="images/main-button-tileR1.jpg" height="22">PROBABILIDAD</th>
          </tr>
          <tr align="center"> 
            <td width="67" class="menu" background="images/main-button-tileR1.jpg" height="22">Nro</td>
            <td width="199" class="menu" background="images/main-button-tileR1.jpg" height="22">Descripcion</td>
            <td width="34" class="menu" background="images/main-button-tileR1.jpg" height="22">Valor</td>
            <td width="25" class="menu" background="images/main-button-tileR1.jpg" height="22">Eliminar</td>
          </tr>
          <?php
		$sql1 = "SELECT * FROM riesgo_probabilidad ORDER BY valoracion";
		$result1 = mysql_query($sql1);
		while($row1=mysql_fetch_array($result1)) {
		 ?>
          <tr align="center"> 
            <td><a href="riesgo-parametros.php?variable1=<?php=$row1['id_probabilidad']?>&variable2=<?php=$row1['descripcion']?>&variable3=<?php=$row1['valoracion']?>&idproc=<?php=$idproc?>&pg=<?php echo $pg."&BUSCAR=$BUSCAR&menu=$menu&busc=$busc"?>"> 
              <?php=$row1['id_probabilidad']?>
              </a></td>
            <td><?php echo $row1['descripcion']?></td>
            <td><?php echo $row1['valoracion']?></td>
            <?php echo '<td><a href="riesgo-parametros.php?nom='.$row1['id_probabilidad'].'&idproc='.$idproc.'&pg='.$pg.'&BUSCAR='.$BUSCAR.'&menu='.$menu.'&busc='.$busc.'" onClick="return confirmLink(this,\''.$row1['descripcion'].'\')"><img src="images/eliminar.gif" border="0" alt="Eliminar"></a></td>';?>
          </tr>
          <?php } ?>
          <tr> 
            <th colspan="4" background="images/main-button-tileR1.jpg" height="22">NUEVO / MODIFICAR</th>
          </tr>
          <tr align="center"> 
              <?php if(isset($_REQUEST['variable1'])==''){ $_REQUEST['variable1']='';}
                    if(isset($_REQUEST['variable2'])==''){$_REQUEST['variable2']='';} 
                    if(isset($_REQUEST['variable3'])==''){$_REQUEST['variable3']='';} 
              ?>
            <td><select name="fase">
                <option value="<?php echo $_REQUEST['variable1']?>" > 
                <?php echo $_REQUEST['variable1'] ?></option>
                <option value="nuevo" <?php if(!isset($_REQUEST['variable1'])) echo "selected"?> >Nuevo</option>
              </select> </td>
            <td><input name="descripcion" type="text" size="33" maxlength="43" value="<?php echo $_REQUEST['variable2'];?>"> 
            </td>
            <td><input name="valoracion" type="text" size="3" maxlength="3" value="<?php echo $_REQUEST['variable3'];?>"> 
            </td>
            <td>&nbsp;</td>
          <tr align="center"> 
            <td colspan="4"><input name="reg_form" type="submit" value="GUARDAR"> 
            </td>
          </tr>
        </table>
	  </td>
   
   
    <td valign="top">
     <table border="1" align="center" cellpadding="2" cellspacing="2" bgcolor="#EAEAEA"  background="images/fondo.jpg">
          <tr> 
            <th colspan="4" background="images/main-button-tileR1.jpg" height="22">NIVEL DE IMPACTO</th>
          </tr>
          <tr align="center"> 
            <td width="67" class="menu" background="images/main-button-tileR1.jpg" height="22">Nro</td>
            <td width="198" class="menu" background="images/main-button-tileR1.jpg" height="22">Descripcion</td>
            <td width="34" class="menu" background="images/main-button-tileR1.jpg" height="22">Valor</td>
            <td width="23" class="menu" background="images/main-button-tileR1.jpg" height="22">Eliminar</td>
          </tr>
          <?php
			$i=1;
			$sql2 = "SELECT * FROM riesgo_impacto";
			$result2 = mysql_query($sql2);
			while($row2=mysql_fetch_array($result2)) {
	       ?>
          <tr align="center"> 
            <td><a href="riesgo-parametros.php?var1=<?php=$row2['id_impacto']?>&var2=<?php=$row2['desc_impac']?>&var3=<?php=$row2['val_impac']?>&idproc=<?php=$idproc?>&pg=<?php echo $pg."&BUSCAR=$BUSCAR&menu=$menu&busc=$busc"?>"> 
              <?php=$i++;?>
              </a></td>
            <td><?php echo $row2['desc_impac'];?></td>
            <td><?php echo $row2['val_impac'];?></td>
            <?php echo '<td><a href="riesgo-parametros.php?nom='.$row2['id_impacto'].'&idproc='.$idproc.'&pg='.$pg.'&BUSCAR='.$BUSCAR.'&menu='.$menu.'&busc='.$busc.'" onClick="return confirmLink2(this,\''.$row2['desc_impac'].'\')"><img src="images/eliminar.gif" border="0" alt="Eliminar"></a></td>';?>
          </tr>
          <?php } ?>
          <tr> 
          <tr> 
            <th colspan="4" background="images/main-button-tileR1.jpg" height="22">NUEVO / MODIFICAR</th>
          </tr>
          <tr align="center"> 
              <?php if(isset($_REQUEST['var1'])==''){ $_REQUEST['var1']='';}
                    if(isset($_REQUEST['var2'])==''){$_REQUEST['var2']='';} 
                    if(isset($_REQUEST['var3'])==''){$_REQUEST['var3']='';} 
              ?>
            <td><select name="fase1">
                <option value="<?php echo $_REQUEST['var1']?>" > 
                <?php echo $_REQUEST['var1']?></option>
                <option value="nuevo" <?php if(!isset($_REQUEST['var1'])) echo "selected"?> >Nuevo</option>
              </select> </td>
            <td><input name="desc_impac" type="text" size="33" maxlength="43" value="<?php echo $_REQUEST['var2'];?>"> 
            </td>
            <td><input name="val_impac" type="text" size="3" maxlength="3" value="<?php echo $_REQUEST['var3'];?>"> 
            </td>
            <td>&nbsp;</td>
          <tr align="center"> 
            <td colspan="4"><input name="reg_form1" type="submit" value="GUARDAR"> 
            </td>
          </tr>
        </table>
		</td>
    </tr>
  </table>
  <br>
	<input type="submit" name="retornar" value="RETORNAR">
</form>
<br>
<script language="JavaScript">
		<!-- 
		<?php
		 	if (isset($msg)){
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
			} ?>
//-->
</script>