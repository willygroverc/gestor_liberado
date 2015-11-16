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
	
		$sql = "SELECT MAX(id_tema) AS ntem FROM temad WHERE id_minuta='$var'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
		$id_tema=$row['ntem']+1;
		
	$sql="INSERT INTO ".
	"temad (tema,responsable,duracion,id_tema,id_minuta,tipo)".
	"VALUES ('$tema','$responsable','$duracion','$id_tema','$var','Nuevo')";
	mysql_query($sql);
	header("location: atema_last.php?id_minuta=$var");
}
else { 
include("top.php");
$id_minuta=($_GET['id_minuta']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "tema",  "Tema, $errorMsgJs[empty]" );
$valid->addLength ( "tema",  "Tema, $errorMsgJs[length]" );
$valid->addIsTextNormal ( "responsable",  "Responsable, $errorMsgJs[empty]" );
$valid->addIsNumber ( "duracion",  "Duracion, $errorMsgJs[empty]" );
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
<table width="65%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_minuta;?>">
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="8" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              TEMA NUEVO</font></th>
          </tr>
          <tr> 
            <th width="5%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="40%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">TEMA</font></th>
            <th width="40%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">RESPONSABLE</font></th>
            <th width="15%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">DURACION(min)</font></th>
          </tr>
          <?php
		$cont=0;	
		$sql = "SELECT * FROM temad WHERE id_minuta='$id_minuta' AND tipo='Nuevo'";
		$result=mysql_query($sql);
		
		while($row=mysql_fetch_array($result)) 
  		{

		 ?>
          <tr align="center"> 
            <td>&nbsp;<?php echo $row['id_tema'];?></td> 
				<?php $sql5 = "SELECT * FROM temas WHERE id_tema='$row[tema]' AND id_agenda='$id_minuta'";
		    	$result5 = mysql_query($sql5);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5['id_tema'])
				{echo "<td>&nbsp;".$row['tema']."</td>";}
				else
				{echo "<td>&nbsp;".$row5['tema']."</td>";}
				
				$sql5 = "SELECT * FROM users WHERE login_usr='".$row['responsable']."'";
		    	$result5 = mysql_query($sql5);
		    	$row5 = mysql_fetch_array($result5);
				if (!isset($row5['login_usr']))
				{echo "<td>&nbsp;".$row['responsable']."</td>";}
				else
				{echo "<td>&nbsp;".$row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr']."</td>";}?>
		  <td>&nbsp;<?php echo $row['duracion']?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="8" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="22" height="7" nowrap bgcolor="#006699">
<div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nuevo</font> 
                </strong></div></td>
            <td width="158" nowrap><div align="center"><strong> 
                <textarea name="tema" cols="40"></textarea>
                </strong></div></td>
            <td width="192" nowrap><div align="center"><strong> 
                <select name="responsable" id="select8">
                  <option value="0"></option>
                  <?php 
			  $sql0 = "SELECT * FROM asistentes WHERE id_minuta='$id_minuta'";
			  $result0=mysql_query($sql0);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				$sql01 = "SELECT * FROM temad WHERE responsable='$row0[nombre]' AND id_minuta='$id_minuta'";
			  	$result01=mysql_query($sql01);
			  	$row01=mysql_fetch_array($result01);
				if (!$row01[responsable])
				{$sql02 = "SELECT * FROM users WHERE login_usr='$row0[nombre]' ORDER BY apa_usr ASC";
		    	$result02 = mysql_query($sql02);
		    	$row02 = mysql_fetch_array($result02);
				if (!$row02[login_usr])
					{echo '<option value="'.$row0['nombre'].'">'.$row0['nombre'].'</option>';}
				else
					{echo '<option value="'.$row02['login_usr'].'">'.$row02['apa_usr'].' '.$row02['ama_usr'].' '.$row02['nom_usr'].'</option>';}
			   }}
			 ?>
                </select>
                </strong></div></td>
            <td width="100" nowrap height="7"><div align="center"><strong> 
                <input name="duracion" type="text" size="3" maxlength="4">
                <font size="2" face="Arial, Helvetica, sans-serif">Min.</font> </strong> </div></td>
          </tr>
          <tr> 
            <td height="28" colspan="8" nowrap> <div align="center"> 
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
