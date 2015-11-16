<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		12/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
header('Content-Type: text/html; charset=iso-8859-1');
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($_REQUEST['Salir'])){header("location: lista_vacaciones.php");}

if (isset($_REQUEST['reg_form']))
{	require("conexion.php");
	$fecha_del=$_REQUEST['AD'].'-'.$_REQUEST['MD'].'-'.$_REQUEST['DD'];
	$fecha_al=$_REQUEST['AA'].'-'.$_REQUEST['MA'].'-'.$_REQUEST['DA'];
        $var1=$_REQUEST['var1'];
        $var=$_REQUEST['var'];
        $Nombre=$_REQUEST['Nombre'];
        $ausencia=$_REQUEST['ausencia'];
	$sql3="INSERT INTO ".
	"vacaciones (id_vacac,Nombre,estado,fecha_del,fecha_al, ausencia) ".
	"VALUES ('$var1','$Nombre','Planificado','$fecha_del','$fecha_al', '$ausencia')";
print_r($sql3);
//exit;
	mysql_query($sql3);
	$var1=$var1+1;
	header("location: vacaciones.php?varia=$var&varia1=$var1");
}
else
{

include ("top.php");
$cod=($_GET['varia']);
$cod1=($_GET['varia1']);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "Nombre",  "Nombre, $errorMsgJs[empty]" );
$valid->addIsDate   ( "DD", "MD", "AD", "Fecha del, $errorMsgJs[date]" );
$valid->addIsDate   ( "DA", "MA", "AA", "Fecha al, $errorMsgJs[date]" );
$valid->addCompareDates   ( "DD", "MD", "AD", "DA", "MA", "AA",   "Fecha del y Fecha al, $errorMsgJs[compareDates]" );
$valid->addFunction( "compareYear",  "" );
print $valid->toHtml ();
?>  
<script language="JavaScript">
<!--
function compareYear () {
	var form=document.form2;
	if (form.AD.value != form.AA.value) {
		alert ("Los anos deben ser los mismos. \n \n Mensaje generado por GesTor F1.");
		return false;
	}	
	return true;
}
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script><br>
<table width="957" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">  
    <form name="form2" method="get" action="<?php echo $_SERVER['PHP_SELF'] ?> " onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $cod;?>">
	<input name="var1" type="hidden" value="<?php echo $cod1;?>">
	<tr> 
      <td width="953">
        <table width="953" border="2" align="center" cellpadding="2" cellspacing="4">
          <tr bgcolor="#006699"> 
            <td background="images/main-button-tileR1.jpg" colspan="18"><div align="center"><font size="3" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong> 
                CALENDARIZACION DE AUSENCIA PROGRAMADA</strong></font></div></td>
          </tr>
          <tr bgcolor="#006699"> 
            <th width="53" rowspan="2" nowrap background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nombre</font></div></th>
            <th width="66" rowspan="2" nowrap background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Estado</font></div></th>
            <th height="17" colspan="4" nowrap background="images/main-button-tileR1.jpg">
<div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cuatrimestre1</font></div></th>
            <th colspan="4" nowrap background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cuatrimestre2</font></div></th>
            <th colspan="4" nowrap background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cuatrimestre3</font></div></th>
			<th width="129" colspan="4" rowspan="2" nowrap background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">AUSENCIA</font></div></th>
          </tr>
          <tr bgcolor="#006699"> 
            <th nowrap  id="1" width="29" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Ene</font></div></th>
            <th nowrap id="2" width="29" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Feb</font></div></th>
            <th nowrap id="3" width="29" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Mar</font></div></th>
            <th nowrap id="4" width="29" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Abr</font></div></th>
            <th nowrap id="5" width="29" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">May</font></div></th>
            <th nowrap id="6" width="29" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Jun</font></div></th>
            <th nowrap id="7" width="29" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Jul</font></div></th>
            <th nowrap id="8" width="29" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Ago</font></div></th>
            <th nowrap id="9" width="29" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Sept</font></div></th>
            <th nowrap id="10" width="31" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Oct</font></div></th>
            <th nowrap id="11" width="32" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nov</font></div></th>
            <th nowrap id="12" width="26" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Dic</font></div></th>
          </tr>
          <?php
		$sql = "SELECT * FROM vacaciones where id_vacac>='$cod'";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <?php
				$anod=substr($row['fecha_del'],0,4);
				$mesd=substr($row['fecha_del'],5,2);
				$diad=substr($row['fecha_del'],8,2);
	
				$anoa=substr($row['fecha_al'],0,4);
				$mesa=substr($row['fecha_al'],5,2);
				$diaa=substr($row['fecha_al'],8,2);?>
          <?php if($mesd==$mesa) 
			$fechac="$diad-$diaa";
		 ?>
          <tr> 
            <?php 
	 		  $sql5 = "SELECT * FROM users WHERE login_usr='$row[Nombre]'";
			  $result5 = mysql_query($sql5);
			  $row5 = mysql_fetch_array($result5);
			echo "<td>$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>"?>
            <td height="25" align="center"> <div align="center"></div>
              <?php echo $row['estado']?></td>
            <td align="center">&nbsp; 
              <?php if($mesd=="01"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa"; }}?>
            </td>
            <td align="center">&nbsp; 
              <?php if($mesd=="02"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td align="center">&nbsp; 
              <?php if($mesd=="03"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td align="center">&nbsp; 
              <?php if($mesd=="04"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td align="center">&nbsp; 
              <?php if($mesd=="05"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td align="center">&nbsp; 
              <?php if($mesd=="06"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td align="center">&nbsp; 
              <?php if($mesd=="07"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td align="center">&nbsp; 
              <?php if($mesd=="08"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td align="center">&nbsp; 
              <?php if($mesd=="09"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td align="center">&nbsp; 
              <?php if($mesd=="10"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td align="center">&nbsp; 
              <?php if($mesd=="11"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td align="center">&nbsp; 
              <?php if($mesd=="12"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
			<td align="center">&nbsp;<?php=$row['ausencia']?></td>
          </tr>
          <?php } ?>
          <tr> 
            <td width="53"  nowrap align="center"><strong> 
              <select name="Nombre">
                <option value="0"></option>
                <?php 
			  $sql = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				echo "<option value=\"$row[login_usr]\"> $row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            
			  ?>
              </select>
              </strong></td>
            <td width="66" nowrap align="center">Planificado</td>
            <td colspan="6" nowrap align="center">del: <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <?php 
			  $fsist=date("Y-m-d");
			  
			   ?>
              <select name="DD" id="select18">
                <?php
  				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select>
              </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="MD" id="select19">
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="AD" id="select20">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              </font><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></strong></font></strong></td>
            <td height="7" colspan="6" nowrap align="center"><p>al: <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="DA" id="select">
                  <?php
  				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
                </select>
                </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="MA" id="select2">
                  <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                </select>
                <select name="AA" id="select3">
                  <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>
                </font><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></strong></font></strong></p></td>
				<td width="53"  nowrap align="center">
					<strong><textarea name="ausencia" id="ausen" rows="3"></textarea></strong>
				</td>
          </tr>
          <tr> 
            <td colspan="18" nowrap> <div align="center"><br>
                <table width="75%" border="0">
                  <tr> 
                    <td align="center"><input name="reg_form" type="submit" id="reg_form3" value="ADICIONAR" <?php print $valid->onSubmit() ?>></td>
                    <td align="center"><input type="submit" name="Salir" value="RETORNAR"></td>
                  </tr>
                </table>
              </div></td>
          </tr>
        </table>
      </td>
    </tr></form>
</table>
  <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DD'], document.forms[form].elements['MD'], document.forms[form].elements['AD']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
//-->
</script>
 <p>
  <?php } ?>
</p>
