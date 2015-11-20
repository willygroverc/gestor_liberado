<?php 
if(isset($_REQUEST['var']))
	$var=$_REQUEST['var'];
if (isset($_REQUEST['Terminar']))
	header("location: agenda_last.php?id_agenda=$var&verif=1");
?>
<?php
if (isset($_REQUEST['reg_form']))
{   include("conexion.php");
	$nombre=$_REQUEST['nombre'];
	
	$sel="SELECT cargo FROM us_ext_user WHERE nombre='$nombre'"; 
	$resultado=mysql_db_query($db,$sel,$link);
	$row=mysql_fetch_array($resultado);

	$sql="INSERT INTO ".
	"invitados (nombre,cargo,id_agenda,tipo) ".
	"VALUES ('$nombre','$row[cargo]','$var','Externo')";
    
	mysql_db_query($db,$sql,$link);
	header("location: iiexterno_last.php?id_agenda=$var");
}
else { 
include("top.php");
$id_agenda=($_GET['id_agenda']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "nombre",  "Nombre, $errorMsgJs[empty]" );
//$valid->addExists( "cargo",  "Cargo, $errorMsgJs[empty]" );
print $valid->toHtml ();
?>    
<script language="JavaScript">

function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
function abrir(x){
	dir="iiexterno_last.php?id_agenda=<?php echo $id_agenda;?>&id_mod="+x
	self.location=dir
}
</script>
<table width="54%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_agenda;?>">
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              INVITADO EXTERNO</font></th>
          </tr>
          <tr> 
            <th width="27" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="195" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NOMBRE</font></th>
            <th width="175" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">CARGO 
              / ROL</font></th>
          </tr>
          <?php
		$cont=0;	
		$sql = "SELECT * FROM invitados WHERE id_agenda='$id_agenda' and tipo='Externo'";
		$result=mysql_db_query($db,$sql,$link);
		$ident=array();
		while($row=mysql_fetch_array($result)) 
  		{
		$cont=$cont+1;
		 ?>
          <tr> 
            <td>&nbsp;<?php echo $cont?></td>
            <td>&nbsp;<?php echo $row['nombre']?></td>
            <td>&nbsp;<?php echo $row['cargo']?></td>
			<?php if ($row['tipo']=="Externo") array_push($ident,"'".$row['nombre']."'");?>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="3" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="27" nowrap height="7"><strong> </strong></td>
            <td width="195" nowrap><div align="center"><strong> 
                <select name="select" id="select" onChange="abrir(this.value)">
                  <option value="0">Seleccione un Modulo</option>
                  <?php
				  if(isset($_GET['id_mod']))
				  	$id_mod=$_GET['id_mod'];
				  else
				  	$id_mod=0;
				  $sql_ext="SELECT * FROM us_ext_mod ORDER BY nombre";
				  $res_ext=mysql_db_query($db,$sql_ext,$link);
				  while($row_ext=mysql_fetch_array($res_ext)){
				  	if ($row_ext['id_mod']==$id_mod) $vas="selected";
					else $vas="";
					echo "<option value=\"$row_ext[id_mod]\" $vas>$row_ext[nombre]</option>";
				  }
				  ?>
                </select>
                </strong></div></td>
            <td width="175" nowrap height="7"><div align="center"><strong>
                <select name="nombre" id="nombre">
                  <option value="">Seleccione un Invitado</option>
                  <?php
				 
				  $lista=implode(", ",$ident);
				  if(strlen($lista)==0) $sql_ext="SELECT nombre FROM us_ext_user WHERE id_mod='$id_mod' ORDER BY nombre";
				  else $sql_ext="SELECT nombre FROM us_ext_user WHERE id_mod='$id_mod' AND nombre NOT IN ($lista) ORDER BY nombre";
				  $res_ext=mysql_db_query($db,$sql_ext,$link);
				  while($row_ext=mysql_fetch_array($res_ext)){
				  	echo "<option value=\"$row_ext[nombre]\">$row_ext[nombre]</option>";
				  }
				  ?>
                </select>
                </strong> </div></td>
          </tr>
          <tr> 
            <td height="28" colspan="3" nowrap> <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR DATOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<p> 
  <?php } ?>
</p>
<?php include("top_.php");?>

