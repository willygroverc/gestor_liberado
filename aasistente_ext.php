<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		06/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require("conexion.php");
if(isset($_REQUEST['var']))
	$var=$_REQUEST['var'];
if(isset($_REQUEST['insertado']))
	$insertado=$_REQUEST['insertado'];
	
if(isset($_REQUEST['num_cod']))
	$num_cod=$_REQUEST['num_cod'];

$id_minuta=$_REQUEST['id_minuta'];
$cad = $_GET['dato'];
if(isset($_REQUEST['dato']))
	$dato=$_REQUEST['dato'];
else
	$dato="";

if ( isset($_GET['insertado']) && $_GET['insertado'] == "1" )
{	$num_cod=$_REQUEST['num_cod'];

	$fila = explode(":",$dato);		
	$enfecha  = explode("/", $fila[1]);
	$en_fecha = "$enfecha[0]-$enfecha[1]-$enfecha[2]";
	$fechad = explode("/", $fila[2]);
	$fecha = "$fechad[0]-$fechad[1]-$fechad[2]";
	$horad = explode ("/", $fila[5]);
	$hora = "$horad[0]:$horad[1]";
	$sql="INSERT INTO ".
	"minuta (codigo,elab_por,en_fecha,tipo_min,fecha,hora,lugar,id_minuta,num_codigo,comentario)".
	"VALUES ('$fila[0]','$fila[3]','$en_fecha','$fila[4]','$fecha','$hora','$fila[6]','$id_minuta','$num_cod','$fila[7]')";
	mysql_query($sql);												
	$insertado = "2";
}
if ( isset($_GET['insertado']) && $_GET['insertado'] == "0" )
{	$fila = explode(":",$dato);
	$enfecha  = explode("/", $fila[1]);
	$en_fecha = "$enfecha[0]-$enfecha[1]-$enfecha[2]";
	$fechad = explode("/", $fila[2]);
	$fecha = "$fechad[0]-$fechad[1]-$fechad[2]";
	$horad = explode ("/", $fila[5]);
	$hora = "$horad[0]:$horad[1]";	
	$sql = "UPDATE minuta SET codigo='$fila[0]',elab_por='$fila[3]',en_fecha='$en_fecha',tipo_min='$fila[4]',
			fecha='$fecha', hora='$hora',lugar='$fila[6]', comentario='$fila[7]' WHERE id_minuta='$id_minuta'";
	mysql_query($sql);
	$insertado = "2";
}
if (isset($_REQUEST['Terminar'])){header("location: minuta.php?cad=$cad&id_minuta=$var&verif=$verif&insertado=$insertado");}
if (isset($_REQUEST['reg_form']))
{   $nombre=$_REQUEST['nombre'];
	$sel="SELECT cargo FROM us_ext_user WHERE nombre='$nombre'"; 
	$resultado=mysql_query($sel);
	$row=mysql_fetch_array($resultado);
	
	$sql="INSERT INTO asistentes (nombre,cargo,id_minuta,tipo) ".
	"VALUES ('$nombre','".$row['cargo']."','$var','Nuevo_ext')";
	//echo $sql;
	//exit;
	mysql_query($sql);
	header("location: aasistente_ext.php?id_minuta=$var&verif=2&dato=$dato&insertado=$insertado");
}
include("top.php");
$id_minuta=($_GET['id_minuta']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "nombre",  "Nombre, $errorMsgJs[empty]" );
//$valid->addIsTextNormal ( "cargo",  "Cargo, $errorMsgJs[empty]" );
print $valid->toHtml ();
?>    
<script language="JavaScript" type="text/JavaScript">

function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}



</script>
<table width="62%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_minuta;?>">
	<input name="verif" type="hidden" value="<?php if ($_GET[verif]) {echo $_GET[verif];}else{echo "1";};?>">
	<input name="dato" type="hidden" value="<?php echo $dato; ?>">
	<input name="num_cod" type="hidden" value="<?php echo $num_cod; ?>">
	<input name="insertado" type="hidden" value="<?php echo $insertado; ?>">
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="7" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              ASISTENTE NUEVO</font></th>
          </tr>
          <tr> 
            <th width="10%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="45%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NOMBRE</font></th>
            <th width="45%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">CARGO 
              / ROL</font></th>
          </tr>
          <?php
		$cont=0;	
		$sql = "SELECT * FROM asistentes WHERE id_minuta='$id_minuta' and tipo='Nuevo_ext'";
		$result=mysql_query($sql);
		$ident=array();
		while($row=mysql_fetch_array($result)) 
  		{
		$cont=$cont+1;
		 ?>
          <tr> 
            <td align="center">&nbsp;<?php echo $cont?></td>
            <td align="center">&nbsp;<?php echo $row['nombre']?></td>
            <td align="center">&nbsp;<?php echo $row['cargo']?></td>
			<?php if ($row['tipo']=="Nuevo_ext") array_push($ident,"'".$row['nombre']."'");?>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="7" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
             <?php //echo $cad; ?> <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="33" height="7" nowrap bgcolor="#006699">
<div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nuevo</font></strong></div></td>
            <td width="171" nowrap><div align="center"><strong>
                <select name="select" id="select" onChange="abrir(this.value)">
                  <option value="0">Seleccione un Modulo</option>
                  <?php
				   if(isset($_GET['id_mod']))
				  	$id_mod=$_GET['id_mod'];
				  else
				  	$id_mod=0;
				  $sql_ext="SELECT * FROM us_ext_mod ORDER BY nombre";
				  $res_ext=mysql_query($sql_ext);
				  while($row_ext=mysql_fetch_array($res_ext)){
				  	if ($row_ext['id_mod']==$id_mod) $vas="selected='selected'";
					else $vas="";
					echo "<option value=\"$row_ext[id_mod]\" $vas>$row_ext[nombre]</option>";
					//echo '<option value="'.$row_ext['id_mod'].' "'.$vas>$row_ext['nombre'].'</option>';
				  }
				  ?>
                </select>
                </strong></div></td>
            <td width="296" nowrap height="7"><div align="center"><strong>
                <select name="nombre" id="nombre">
                  <option value="">Seleccione un Invitado</option>
                  <?php
				  $lista=implode(", ",$ident);
				  if(strlen($lista)==0) $sql_ext="SELECT nombre FROM us_ext_user WHERE id_mod='$id_mod' ORDER BY nombre";
				  else $sql_ext="SELECT nombre FROM us_ext_user WHERE id_mod='$id_mod' AND nombre NOT IN ($lista) ORDER BY nombre";
				  
				  $res_ext=mysql_query($sql_ext);
				  while($row_ext=mysql_fetch_array($res_ext)){
				  	echo '<option value="'.$row_ext['nombre'].'">'.$row_ext['nombre'].'</option>';
				  }
				  ?>
                </select>
                </strong> </div></td>
          </tr>
          <tr> 
            <td height="28" colspan="7" nowrap> <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR DATOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<script language="JavaScript" type="text/JavaScript">
function abrir(x){
	dir="aasistente_ext.php?id_minuta=<?php echo $id_minuta; ?>&dato=<?php echo $dato; ?>&insertado=<?php echo $insertado;?>&num_cod=<?php echo $num_cod; ?>&id_mod="+x
	self.location=dir
}
</script>