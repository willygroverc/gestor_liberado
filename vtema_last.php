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
	
if(isset($_REQUEST['tema']))
	$tema=$_REQUEST['tema'];
if (isset($_REQUEST['Terminar']))
header("location: minuta_last.php?id_minuta=$var&verif=1");

if (isset($_REQUEST['reg_form']))
{   require("conexion.php");
	
		$sql11 = "SELECT * FROM temas WHERE id_agenda='$var' AND id_tema='$tema'";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		$responsable=$row11['responsable'];
		$duracion=$row11['duracion'];
		
		$sql35 = "SELECT MAX(id_tema) AS ntem FROM temad WHERE id_minuta='$var'";
		$result35=mysql_query($sql35);
		$row35=mysql_fetch_array($result35);
		$id_tema=$row35['ntem']+1;
		
	
	$sql="INSERT INTO ".
	"temad (tema,responsable,duracion,id_minuta,id_tema) ".
	"VALUES ('$tema','$responsable','$duracion','$var','$id_tema')";
	/*echo $sql;
	exit;*/
	mysql_query($sql);
	header("location: vtema_last.php?id_minuta=$var");
}
else { 
include("top.php");
$id_minuta=($_GET['id_minuta']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "tema",  "Tema, $errorMsgJs[empty]" );
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
<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_minuta;?>">
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="8" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              VERIFICAR TEMA</font></th>
          </tr>
          <tr> 
            <th width="34" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="222" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">TEMA</font></th>
            <th width="312" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">RESPONSABLE</font></th>
            <th width="107" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">DURACION(min)</font></th>
          </tr>
          <?php
		$cont=0;	
		$sql = "SELECT * FROM temad WHERE id_minuta='$id_minuta' and tipo <>'Nuevo'";
		$result=mysql_query($sql);
		
		while($row=mysql_fetch_array($result)) 
  		{
		$cont=$cont+1;
		 ?>
          <tr> 
            <td>&nbsp;<?php echo $row['id_tema']?></td>
            	<?php $sql5 = "SELECT * FROM temas WHERE id_tema='$row[tema]' AND id_agenda='$id_minuta'";
		    	$result5 = mysql_query($sql5);
		    	$row5 = mysql_fetch_array($result5);
				if (!isset($row5['id_tema']))
				{echo "<td>&nbsp;".$row['tema']."</td>";}
				else
				{echo "<td>&nbsp;".$row5['tema']."</td>";}
				
				$sql5 = "SELECT * FROM users WHERE login_usr='".$row['responsable']."'";
		    	$result5 = mysql_query($sql5);
		    	$row5 = mysql_fetch_array($result5);
				echo "<td>&nbsp;".$row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr']."</td>";?>
          <td>&nbsp;<?php echo $row['duracion'];?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="8" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="34" nowrap height="7"><strong> </strong></td>
            <td width="222" nowrap><div align="center"><strong> 
                <select name="tema" id="select8">
                  <option value="0"></option>
                  <?php 
			  $sql0 = "SELECT * FROM temas where id_agenda='$id_minuta'";
			  $result0=mysql_query($sql0);
			  while ($row0=mysql_fetch_array($result0)) 
				{$sql01 = "SELECT * FROM temad WHERE tema='$row0[id_tema]' AND id_minuta='$id_minuta'";
			  	$result01=mysql_query($sql01);
			  	$row01=mysql_fetch_array($result01);
				if (!$row01['tema'])
				{echo '<option value="'.$row0['id_tema'].'">'.$row0['tema'].'</option>';}
				
                }
			   ?>
                </select>
                </strong></div></td>
            <td width="312" nowrap><div align="center"><strong> </strong></div></td>
            <td width="107" nowrap height="7"><div align="center"><strong> </strong> 
              </div></td>
          </tr>
          <tr> 
            <td height="28" colspan="8" nowrap> <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="AGREGAR"  <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
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
