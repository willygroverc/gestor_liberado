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
if (isset($Terminar))
header("location: minuta_last.php?id_minuta=$var&verif=1");
if (isset($reg_form))
{   
	 	$sql2 = "SELECT * FROM compromisos WHERE tema='$tema' AND id_minuta='$var'";
		$result2=mysql_query($sql2);
		$row2=mysql_fetch_array($result2);
	if (!isset($row2['tema']))
		{$sql0 = "SELECT * FROM temad WHERE id_minuta='$var' AND tema='$tema'";
		$result0=mysql_query($sql0);
		$row0=mysql_fetch_array($result0);
		$sql="INSERT INTO compromisos (id_tema,compromiso,id_minuta,tema) VALUES ('$row0[id_tema]','$compromiso','$var','$tema')";
		mysql_query($sql);
		header("location: compromisos_last.php?id_minuta=$var");}
	else
	{$sql="UPDATE compromisos SET compromiso='$compromiso' WHERE id_minuta='$var' AND tema='$tema'";
	mysql_query($sql);
	header("location: compromisos_last.php?id_minuta=$var");}
}
else { 
include("top.php");
@$id_minuta=($_GET['id_minuta']);
@$id_tema=($_GET['id_tema']);

require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal( "resultado",  "Resultados, $errorMsgJs[empty]" );
$valid->addLength ( "resultado",  "Resultados, $errorMsgJs[length]" );
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

  <table width="71%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <form name="form2" method="post" action="<?php echo $PHP_SELF;?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_minuta;?>">
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              COMPROMISOS POR TEMA</font></th>
          </tr>
          <tr> 
            <th width="49" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="429" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">TEMA</font></th>
            <th width="189" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">COMPROMISOS</font></th>
          
		  </tr>
          <?php
		$sql = "SELECT * FROM compromisos WHERE id_minuta='$id_minuta' ORDER BY id_tema ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) {
		 
			echo '<tr align="center">';
			echo "<td><a href=\"compromisos_last.php?id_minuta=$id_minuta&id_tema=".$row['id_tema']."\">".$row['id_tema']."</a></td>";
			$sql5 = "SELECT * FROM compromisos WHERE id_tema='$row[tema]' AND id_minuta='$id_minuta'";
			$result5 = mysql_query($sql5);
			$row5 = mysql_fetch_array($result5);
			if (!$row5['id_tema'])
			{echo "<td>&nbsp;$row[tema]</td>";}
			else
			{echo "<td>&nbsp;$row5[tema]</td>";}
			echo '<td>&nbsp;'.$row['compromiso'].'</td>';
			echo '</tr>';
		 }
		 
		 ?>
          <tr> 
            <td colspan="3" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
		  <?php $sql3 = "SELECT * FROM compromisos WHERE id_tema='$id_tema' AND id_minuta='$id_minuta' ";
		  	 $result3=mysql_query($sql3);
	      	 $row3=mysql_fetch_array($result3);
		?>
          <tr> 
            <td width="49" nowrap height="7"><div align="center"><strong> 
			<?php echo $id_tema;?>
			</strong></div></td>
            <td width="429" nowrap><div align="center"><strong> 
               <select name="tema" id="select8">
              <?php 
			 $sql0 = "SELECT * FROM temas WHERE id_agenda='$id_minuta'";
			  $result0=mysql_query($sql0);
			  while ($row0=mysql_fetch_array($result0)) 
				{
					$sql01 = "SELECT * FROM atema WHERE id_tema='$row0[id_tema]' AND id_minuta='$id_minuta'";
			  		$result01=mysql_query($sql01);
			  		$row01=mysql_fetch_array($result01);
					if (!$row01[tema])//Si NO existe en la tabla atema muestra en el combo box y si SI existe no muestra
					{$sql5 = "SELECT * FROM rtema WHERE id_minuta='$id_minuta' AND id_tema = '$row0[id_tema]' ORDER BY id_tema ASC";
		    		$result5 = mysql_query($sql5);
		    		while($row5 = mysql_fetch_array($result5))
					{	if ($row5['id_tema'])
						{echo "<option value=\"$row5[id_tema]\">$row5[resultado]</option>";}
					/*else
					{echo "<option value=\"$row0[id_tema]\">$row0[tema] </option>";}*/
					}
				}
			}
				 ?>
                </select>
			                  
                </strong></div></td>
            <td width="189" nowrap><strong>
              <textarea name="compromiso" cols="30" id="compromiso"><?php echo $row3['compromiso'];?></textarea>
              </strong></td>
          </tr>
          <tr> 
            <td height="28" colspan="3" nowrap> <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="MODIFICAR/INSERTAR  COMPROMISOS" <?php print $valid->onSubmit() ?>>
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
