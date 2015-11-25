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
if(isset($_REQUEST['var']))
	$var=$_REQUEST['var'];

if (isset($_REQUEST['Terminar']))
header("location: minuta_last.php?id_minuta=$var&verif=1");

if (isset($_REQUEST['reg_form']))
{   require("conexion.php");
	$nombre1=$_REQUEST['nombre1'];
	$sql11 = "SELECT * FROM invitados WHERE nombre='$nombre1'";
	$result11=mysql_query($sql11);		
	$row11=mysql_fetch_array($result11);
	$cargo=$row11['cargo'];

	$sql="INSERT INTO ".
	"asistentes (nombre,cargo,id_minuta,tipo,prop,adjunto,hash_archivo) ".
	"VALUES ('$nombre1','$cargo','$var','0','0','0','0')";
	/*echo $sql;
	exit;*/
	mysql_query($sql);
	header("location: vasistente_last.php?id_minuta=$var");
}
else { 
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

<table width="55%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_minuta;?>">
	
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">VERIFICAR 
              ASISTENTE </font></th>
          </tr>
          <tr> 
            <th width="22" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="177" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NOMBRE</font></th>
            <th width="188" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CARGO 
              / ROL</font></th>
          </tr>
          <?php
		
		$cont=0;	
		$sql = "SELECT * FROM asistentes WHERE id_minuta='$id_minuta' and tipo<>'Nuevo'";
		$result=mysql_query($sql);
		
		while($row=mysql_fetch_array($result)) 
  		{
		$cont=$cont+1;
		 ?>
          <tr> 
            <td>&nbsp;<?php echo $cont?></td>
            <?php 	$sql5 = "SELECT * FROM users WHERE login_usr='$row[nombre]'";
		    	$result5 = mysql_query($sql5);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5['login_usr'])
				{echo "<td>&nbsp;$row[nombre]</td>";}
				else
				{echo '<td>&nbsp;'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';}?>
            <td>&nbsp;<?php echo $row['cargo']?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="3" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="22" nowrap height="7"><strong> </strong></td>
            <td width="177" nowrap><div align="center"><strong> 
                <select name="nombre1" id="select8">
                  <option value="0"></option>
                  <?php 
			  $sql0 = "SELECT * FROM invitados WHERE id_agenda='$id_minuta'";
			  $result0=mysql_query($sql0);
			  while ($row0=mysql_fetch_array($result0)) 
				{$sql01 = "SELECT * FROM asistentes WHERE nombre='$row0[nombre]' AND id_minuta='$id_minuta'";
			  	$result01=mysql_query($sql01);
			  	$row01=mysql_fetch_array($result01);
				if (!$row01['nombre'])
				{$sql5 = "SELECT * FROM users WHERE login_usr='$row0[nombre]' ORDER BY apa_usr ASC";
		    	$result5 = mysql_query($sql5);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5['login_usr'])
					{echo '<option value="'.$row0['nombre'].'">'.$row0['nombre'].'</option>';}
				else
					{echo '<option value="'.$row5['login_usr'].'">'.$row5['apa_usr'].' '.$row5['ama_usr'].' '.$row5['nom_usr'].'</option>';}
				
                }}
			 ?>
                </select>
                </strong></div></td>
            <td width="188" nowrap height="7"><div align="center"><strong> </strong> 
              </div></td>
          </tr>
          <tr> 
            <td height="28" colspan="3" nowrap> <div align="center"><br>
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

