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
if (isset($Terminar)){header("location: minuta_last.php?id_minuta=$var&verif=1");}
if (isset($reg_form))
{   require("conexion.php");
    $sql0 = "SELECT * FROM users WHERE login_usr='$nombre'";
    $result0=mysql_query($sql0);
    $row0=mysql_fetch_array($result0);
	
	$sql="INSERT INTO asistentes (nombre,cargo,id_minuta,tipo) ".
	"VALUES ('$nombre','$row0[cargo_usr]','$var','Nuevo')";
	mysql_query($sql);
	header("location: aasistente_last.php?id_minuta=$var");
}
include("top.php");
$id_minuta=($_GET['id_minuta']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "nombre",  "Nombre, $errorMsgJs[empty]" );
print $valid->toHtml ();
?>    
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<table width="62%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_minuta;?>">
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
		$sql2 = "SELECT * FROM asistentes WHERE id_minuta='$id_minuta' AND tipo='Nuevo'";
		$result2=mysql_query($sql2);
		
		while($row2=mysql_fetch_array($result2)) 
  		{
		$cont=$cont+1;
		 ?>
          <tr> 
            <td align="center">&nbsp;<?php echo $cont?></td>
			<?php 	$sql3 = "SELECT * FROM users WHERE login_usr='$row2[nombre]'";
		    	$result3 = mysql_query($sql3);
		    	$row3 = mysql_fetch_array($result3);
				echo "<td align=\"center\">&nbsp;$row3[nom_usr] $row3[apa_usr] $row3[ama_usr]</td>";?>
            <td align="center">&nbsp;<?php echo $row3['cargo_usr'];?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="7" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="33" height="7" nowrap bgcolor="#006699">
<div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nuevo</font></strong></div></td>
            <td width="171" nowrap><div align="center"><strong> 
                <select name="nombre">
                  <option value="0"></option>
                  <?php 
 			  $sql0 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
			  $result0=mysql_query($sql0);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				$sql01 = "SELECT * FROM invitados WHERE nombre='$row0[login_usr]' AND id_agenda='$id_minuta'";
			  	$result01=mysql_query($sql01);
			  	$row01=mysql_fetch_array($result01);
				$sql02 = "SELECT * FROM asistentes WHERE nombre='$row0[login_usr]' AND id_minuta='$id_minuta'";
			  	$result02=mysql_query($sql02);
			  	$row02=mysql_fetch_array($result02);
				if (!isset($row01['nombre']) and !isset($row02['nombre']))
				{echo '<option value="'.$row0['login_usr'].'">'.$row0['apa_usr'].' '.$row0['ama_usr'].' '.$row0['nom_usr'].'</option>';}
				}

 
 				?>
                </select>
                </strong></div></td>
            <td width="296" nowrap height="7"></td>
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
