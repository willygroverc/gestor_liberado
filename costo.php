<?php 
if (isset($_REQUEST['RETORNAR'])){
header("location: listae.php");
if ($op == 2) header("location: listae.php");
elseif ( $op == 3) header("location: listans.php");
	else header("location: lista.php?pg=$pg");
}
include("top.php");
require_once('funciones.php');
$id_orden=SanitizeString($_REQUEST['id_orden']);
$login_usr = $_SESSION['login'];
if (isset($_REQUEST['reg_form']))
{
	$subtotal = $_REQUEST['cosxh_cos'] * $_REQUEST['tiemph_cos'];
	require_once('funciones.php');
	$id_orden=SanitizeString($_REQUEST['id_orden']);
	$responsable=SanitizeString($_REQUEST['responsable']);
	$desc_cos=SanitizeString($_REQUEST['desc_cos']);
	$tiemph_cos=SanitizeString($_REQUEST['tiemph_cos']);
	$cosxh_cos=SanitizeString($_REQUEST['cosxh_cos']);
	$subtotal=SanitizeString($subtotal);
	$login=SanitizeString($login);
	$sql3="INSERT INTO ".
	"costo (id_orden,responsable,desc_cos,tiemph_cos,cosxh_cos,subtot_cos,reg_cos) ".
	"VALUES('$id_orden','$responsable','$desc_cos','$tiemph_cos','$cosxh_cos','$subtotal','$login')";

	mysql_query($sql3);
	
}
if(isset($_REQUEST['elimina'])==1)
{
	$sqld="DELETE FROM costo WHERE id_cost=$id_cost";
	mysql_query($sqld);
}
$elimina=0;
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addExists ( "desc_cos",  "Descripcion, $errorMsgJs[empty]" );
$valid->addIsNumber ( "tiemph_cos",  "Tiempo Horas, $errorMsgJs[number]" );
$valid->addIsNumber ( "cosxh_cos",  "Costo x Hora, $errorMsgJs[number]" );
//$valid->addIsNumber ( "chorahombre",  "Costo x Hora Hombre $errorMsgJs[number]" );
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
  <form name="form2" method="post" action="<?php=$_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
  <input type="hidden" name="pg" value="<?php=$pg?>">
<table border="1" align="center" cellpadding="0" cellspacing="2" bgcolor="#EAEAEA"  background="images/fondo.jpg">  
	<tr> <th colspan="8" background="images/main-button-tileR1.jpg" height="20">COSTO DEL SERVICIO</th>
    </tr>
    <tr align="center"> 
      <td colspan="8"><strong><font size="2">&nbsp;Nro O.T. : 
        <input name="id_orden" type="text" value="<?php echo $id_orden;?>" size="11" readonly="">
        <br>
        Descripcion: </font></strong> <font size="2">
        <?php 		$sqlTmp="SELECT desc_inc FROM ordenes WHERE id_orden='$id_orden'";
				$ordenTmp=mysql_fetch_array(mysql_query($sqlTmp));
				print $ordenTmp['desc_inc'];
		?>
        </font> 
        <hr>
        <strong> </strong></td>
    </tr>
	<tr align="center"> 
	  <td class="menu" width="44" background="images/main-button-tileR2.jpg" height="25">Nro</td>
	  <td class="menu" width="77" background="images/main-button-tileR2.jpg" height="25">Responsable</td>
	  <td class="menu" background="images/main-button-tileR2.jpg" height="25">Descripcion</td>
	  <td class="menu" width="60" align="center" background="images/main-button-tileR2.jpg" height="25">Tiempo Horas</td>
	  <td class="menu" width="99" background="images/main-button-tileR2.jpg" height="25">Costo x Hora Servicio</td>
	  <td class="menu" width="117" background="images/main-button-tileR2.jpg" height="25">Sub Total</td>
	  <td class="menu" width="88" background="images/main-button-tileR2.jpg" height="25">Costo Hora Hombre</td>
	  <td class="menu" width="90" background="images/main-button-tileR2.jpg" height="25">Costo x Hora Responsable</td>
	  
	</tr>
            <?php
		
		$sql2 = "SELECT SUM(subtot_cos) AS total_cos FROM costo where id_orden='$id_orden'";
		$result2=mysql_query($sql2);
		$row2=mysql_fetch_array($result2); 

		$sql = "SELECT * FROM costo where id_orden='$id_orden' ORDER BY id_orden ASC";
		$result=mysql_query($sql);
		$c=1;
		$costo_total = 0;
		while($row=mysql_fetch_array($result)) 
  		{
			$sql3 = "SELECT * FROM users where login_usr='$row[responsable]'";
			$res3=mysql_query($sql3);
			$row3=mysql_fetch_array($res3);
			$costo_tiempo = $row3['costo_usr'] * $row['tiemph_cos'];
			$costo_total = $costo_total + $costo_tiempo;
		 ?>
            <tr > 
              <td>&nbsp;<?php echo "Rec".$c++?></td>
			  <td align="center">&nbsp;<?php echo $row3['apa_usr']." ".$row3['ama_usr']." ".$row3['nom_usr'] ?></td>
              <td align="center">&nbsp;<?php echo $row['desc_cos']?></td>
              <td align="right">&nbsp;<?php echo $row['tiemph_cos']?></td>
              <td align="right">&nbsp;<?php echo $row['cosxh_cos']?></td>
			  <td align="right">&nbsp;<?php echo $row['subtot_cos']?></td>
			  <td align="right">&nbsp;<?php echo $row3['costo_usr']?></td>
			  <td align="right">&nbsp;<?php echo number_format($costo_tiempo,2)?></td>
              
            </tr>
            <?php
		 }
		 ?>
            <tr> 
               <td colspan="3" height="7">&nbsp;</td>
			   <td colspan="1" height="7">&nbsp;</td>
               <td width="99" class="menu" height="7">Total Bs.</td>
			   <td width="117" class="menu" height="7" align="right"><strong><?php echo $row2['total_cos'];?></strong></td>
			   <td height="7" class="menu">&nbsp;</td>
			   <td width="90" class="menu" height="7" align="right"><strong><?php if($costo_total <> 0)echo number_format($costo_total,2);?></strong></td>
            </tr>
			<tr>
				<td colspan="8">&nbsp;</td>
			</tr>
			

            <tr> 
              <td class="menu" height="7" background="images/main-button-tileR1.jpg"><strong>Nuevo</strong></td>
			  <td height="7">
			  	<?php 
					$sql = "SELECT  *FROM users WHERE bloquear=0 AND (tipo2_usr='T' OR tipo2_usr='A') ORDER BY apa_usr ASC";
					$res = mysql_query($sql);
				?>
			  	<select name="responsable">
					<option value="0"></option>
					<?php 	while($reg=mysql_fetch_array($res))
						{
							if($reg['login_usr'] == $login_usr)
							{
								echo "<option value='$reg[login_usr]' selected>$reg[apa_usr] $reg[ama_usr] $reg[nom_usr]</option>";
							}else
							{
								echo "<option value='$reg[login_usr]'>$reg[apa_usr] $reg[ama_usr] $reg[nom_usr]</option>";	
							}
						}
					?>
				</select>
				</td>
              <td width="240" nowrap height="7"><input name="desc_cos" type="text" id="obs_seg2" value="" size="40" maxlength="255"></td>
              <td width="60" nowrap height="7"><input name="tiemph_cos" type="text" id="estado_seg4" size="10" maxlength="11"></td>
              <td width="99" nowrap height="7" align="center">
			  <input name="cosxh_cos" type="text" id="estado_seg3" size="10" maxlength="12">
			  </td>
              <td width="117" nowrap height="7"></td>
            </tr>
            <tr> 
              <td colspan="8" nowrap align="center">
             <?php $sql_1="SELECT id_orden FROM conformidad WHERE id_orden='$id_orden'";
				$orden_1=mysql_fetch_array(mysql_query($sql_1));
				if(!$orden_1['id_orden'])
				{
				?>
				  <input name="reg_form" type="submit" id="reg_form" value="ADICIONAR" <?php print $valid->onSubmit() ?>>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<?php }?>
                  <input type="submit" name="RETORNAR" value="RETORNAR">
                </td>
            </tr>
  </table>
</form>
<br>
<?php include("top_.php");?>
