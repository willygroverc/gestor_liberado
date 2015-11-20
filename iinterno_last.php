<?php 
 
if(isset($_REQUEST['var']))
	$var=$_REQUEST['var'];

if (isset($_REQUEST['Terminar']))
	header("location: agenda_last.php?id_agenda=$var&verif=1");
?>
<?php
if (isset($_REQUEST['reg_form']))
{   include("conexion.php");
		  		if(isset($_REQUEST['nombre']))
		$nombre=$_REQUEST['nombre'];	
			  $sql33 = "SELECT * FROM users WHERE login_usr='$nombre'";
			  $result33=mysql_db_query($db,$sql33,$link);
			  $row33=mysql_fetch_array($result33); 
			  $cargo=$row33['cargo_usr'];
			  
	$sql="INSERT INTO ".
	"invitados (nombre,id_agenda,tipo,cargo) ".
	"VALUES ('$nombre','$var','Interno','$cargo')";
	
	
	mysql_db_query($db,$sql,$link);
	/*echo $sql;
	exit;*/
	header("location: iinterno_last.php?id_agenda=$var");
}
else { 
include("top.php");

$id_agenda=$_GET['id_agenda'];
/*if(isset($_REQUEST['id_agenda']))
	$id_agenda=$_REQUEST['id_agenda'];
else
	$id_agenda=$var;*/
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
<table width="59%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_agenda;?>">
	
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">EMPLEADO 
              INVITADO</font></th>
          </tr>
          <tr> 
            <th width="23" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="186" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NOMBRE</font></th>
            <th width="194" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">CARGO</font></th>
          </tr>
          <?php
		$cont=0;	
		$sql = "SELECT * FROM invitados WHERE id_agenda='$id_agenda' and tipo='Interno' ";
		$result=mysql_db_query($db,$sql,$link);
		
		while($row=mysql_fetch_array($result)) 
  		{
		$cont=$cont+1;

			  
		 ?>
          <tr> 
            <td>&nbsp;<?php echo $cont?></td>
			<?php 
			 $sql5 = "SELECT * FROM users WHERE login_usr='$row[nombre]'";
		    $result5 = mysql_db_query($db,$sql5,$link);
		    $row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";?>
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
            <td width="23" nowrap height="7"><strong> </strong></td>
            <td width="186" nowrap><div align="center"><strong> 
                <select name="nombre" id="select8">
                  <option value="0"></option>
                  <?php 
			  $sql0 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				$sql01 = "SELECT * FROM invitados WHERE nombre='$row0[login_usr]' AND id_agenda='$id_agenda'";
			  	$result01=mysql_db_query($db,$sql01,$link);
			  	$row01=mysql_fetch_array($result01);
				if (!$row01['nombre'])
				{echo "<option value=\"$row0[login_usr]\">$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";}
				}
			   ?>
                </select>
                </strong></div></td>
            <td width="194" nowrap height="7"><div align="center"><strong> </strong> 
              </div></td>
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
