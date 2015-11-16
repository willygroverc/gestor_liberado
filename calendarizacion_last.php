<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require("conexion.php");
include ( "funciones.inc.php" );
if (isset($RETORNAR)){header("location: lista_calen.php");}
if (isset($reg_form))
{   
	$fecha_del="$AA1-$MA1-$DA1";
	$fecha_al="$AA-$MA-$DA";
	$sql_1="SELECT orden FROM calenmantplanif WHERE id_cmant='$var'";
	$res_1=mysql_query($sql_1);
	$row_1=mysql_fetch_array($res_1);
	$sql3="INSERT INTO ".
	"calenmantplanif (id_cmant,AdicUSI,estado,fecha_al,fecha_del,Observ,orden) ".
	"VALUES ('$var','$var1','Realizado','$fecha_al','$fecha_del','$Observ','$row_1[orden]')";
	mysql_query($sql3);
	header("location: lista_calen.php");
}
else {
include("top.php"); 
$IdRe=($_GET['id_cmant']);
$IdRe1=($_GET['AdicUSI']);?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsDate ( "DA1", "MA1", "AA1", "Fecha de: $errorMsgJs[date]" );
$valid->addIsDate ( "DA", "MA", "AA", "Fecha a: $errorMsgJs[date]" );
$valid->addCompareDates ( "DA1", "MA1", "AA1", "DA", "MA", "AA", "$errorMsgJs[compareDates]" );
$valid->addLength ( "Observ",  "Observaciones, $errorMsgJs[length]" );
print $valid->toHtml();
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
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <form name="form2" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $IdRe;?>">
	<input name="var1" type="hidden" value="<?php echo $IdRe1;?>">
	<tr> 
      <td height="173"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="7" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">CALENDARIZACION 
              DE MANTENIMIENTO</font></th>
          </tr>
          <tr> 
            <th width="44" nowrap bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></div></th>
            <th width="144" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Codigo 
              Adicional</font>
			 </th>
            <th width="144" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF"> 
              Asignado A</font>
			 </th>			 
            <th width="70" nowrap bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Estado</font></div></th>
            <th width="166" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Fecha 
                Inicio</font></div></th>
            <th width="167" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
              final</font></th>
            <th width="215" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Observaciones</font></th>
          </tr>
          <?php
			
		$sql = "SELECT *, DATE_FORMAT(fecha_del, '%d/%m/%Y') AS fecha_del,DATE_FORMAT(fecha_al, '%d/%m/%Y') AS fecha_al FROM calenmantplanif WHERE id_cmant='$IdRe'";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr align="center"> 
            <td height="25">&nbsp; &nbsp;<?php echo $IdRe?></td>
            <td>&nbsp;<?php echo $row['AdicUSI']; ?></td>
			<td>&nbsp;
			<?php 
					
			//new code
			
			$sqla = "select *from datfichatec where AdicUSI = '$row[AdicUSI]'";
			$resa = mysql_query($sqla);
			$rowa = mysql_fetch_array($resa);
			
			$sqlb = "select *from asigcustficha where IdFicha = '$rowa[IdFicha]'";
			$resb = mysql_query($sqlb);
			if(mysql_num_rows($resb) >= 1)
			{
				while($rowb = mysql_fetch_array($resb))
				{
					$sel = "select *from users where login_usr='$rowb[NombAsig]' and bloquear = 0";
					$rel = mysql_query($sel);
					$rol = mysql_fetch_array($rel);
				}
				$valor = $rol['login_usr'];	
			}else{
				$valor = '';
			}
			
			$sqlc = "select *from users where login_usr = '$valor'";
			$resc = mysql_query($sqlc);
			$rowc = mysql_fetch_array($resc);
			
			
			$datos = $rowc['nom_usr']." ".$rowc['apa_usr']." ".$rowc['ama_usr'];
			if(mysql_num_rows($resc) == 0)
			{
				$datos = 'No Asignado';
			}
			
			if ( !empty($datos) )	
				$datos;
			else
				$datos;	
				
			echo $datos;
					
			//end new code	
				
			?> 
			</td>
            <td>&nbsp;<?php echo $row['estado'];?></td>
            <td>&nbsp;<?php echo $row['fecha_del'];?></td>
            <td>&nbsp;<?php echo $row['fecha_al'];?></td>
            <td>&nbsp;<?php echo $row['Observ'];?></td>
          </tr>
          <input name="var2" type="hidden" value="<?php echo $row['AdicUSI'];?>">
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="7" height="7" nowrap><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font> 
              </div>
              <div align="center"></div></td>
          </tr>
          <tr align="center"> 
            <td height="30" nowrap><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $IdRe?> 
              </font> </td>
            <td height="30" nowrap><font face="Arial, Helvetica, sans-serif"><strong><?php echo $IdRe1?></strong> 
                </font></td>
            <td height="30" nowrap><font face="Arial, Helvetica, sans-serif"><strong><?php echo $datos?></strong> 
                </font></td>
			<td width="70" nowrap height="30"> <strong><font size="2" face="Arial, Helvetica, sans-serif">Realizado</font></strong></td>
            <td width="166" nowrap height="30"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="DA1" id="select">
                  <?php
				$fsist=date("Y-m-d");
				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
                </select>
                <select name="MA1" id="select2">
                  <?php
				for($i=1;$i<=12;$i++)
				{
                echo "<option value=\"$i\"";if($m1=="$i")echo "selected";echo">$i</option>";
				}
				?>
                </select>
                <select name="AA1" id="select3">
                  <?php
				for($i=2003;$i<=2020;$i++)
				{
                echo "<option value=\"$i\"";if($a1=="$i")echo "selected";echo">$i</option>";
				}
				?>
                </select>
                <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong> 
                </font> </strong></div></td>
            <td width="167" nowrap><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="DA" id="select13">
                  <?php
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
                </select>
                </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="MA" id="select14">
                  <?php
				for($i=1;$i<=12;$i++)
				{
                echo "<option value=\"$i\"";if($m1=="$i")echo "selected";echo">$i</option>";
				}
				?>
                </select>
                <select name="AA" id="select15">
                  <?php
				for($i=2003;$i<=2020;$i++)
				{
                echo "<option value=\"$i\"";if($a1=="$i")echo "selected";echo">$i</option>";
				}
				?>
                </select>
                <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong> 
                </font></strong></div></td>
            <td width="215" nowrap><textarea name="Observ" cols="30"></textarea></td>
          </tr>
          <tr> 
            <td height="28" colspan="6" nowrap> <div align="left"></div>
              <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="GUARDAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
 <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DA1'], document.forms[form].elements['MA1'], document.forms[form].elements['AA1']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>
<p> 
  <?php } ?>
</p>