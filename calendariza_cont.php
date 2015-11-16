<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
require("conexion.php");
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($Salir))
if ($var2<>""){header("location: lista_ficha.php");}
else{header("location: lista_calen_cont.php");}
?>
<?php
if (isset($reg_form)){	
	$fecha_del="$AD-$MD-$DD";
	$fecha_al="$AA-$MA-$DA";
	$sql3="INSERT INTO ".
	"calen_contingencia (id_cmant,TipoPru,estado,fecha_del,fecha_al) ".
	"VALUES ('$var1','$var3','Planificado','$fecha_del','$fecha_al')";
	mysql_query($sql3);
	$var1=$var1+1;
	header("location: calendariza_cont.php?varia=$var&varia1=$var1&TipoPru=$var2");
}
include ("top.php");
require_once('funciones.php');
$cod=SanitizeString($_GET['varia']);
$cod1=SanitizeString($_GET['varia1']);
@$opt=SanitizeString($_GET['opt']);
@$AdicUS=SanitizeString($_GET['TipoPru']);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "AdicUSI",  "Codigo Adicional USI De, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "AdicUSI2",  "Codigo Adicional USI Al, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "menu1",  "Incidencia/Orden de Trabajo, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "textarea",  "Incidencia, $errorMsgJs[empty]" );
$valid->addIsDate ( "DD", "MD", "AD", "Fecha de: $errorMsgJs[date]" );
$valid->addIsDate ( "DA", "MA", "AA", "Fecha a: $errorMsgJs[date]" );
$valid->addCompareDates ( "DD", "MD", "AD", "DA", "MA", "AA", "Fecha De y Al, $errorMsgJs[compareDates]" );
$valid->addFunction ( "compareYear",  "" );
print $valid->toHtml();
			  $sql = "SELECT IdFicha, AdicUSI FROM datfichatec";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{	
					$listAdicUSI[$row['AdicUSI']]=$row['IdFicha'];
				}
?>
<script language="JavaScript">
<!--
function compareAdicUsi () {
	var form=document.form2;
	var id = new Array();
	<?php 
		foreach ($listAdicUSI as $key => $value) {
			print "id[\"$key\"]=$value;\n";
		}
	 ?>
	if (id[form.AdicUSI2.value] < id[form.AdicUSI.value]) {
		alert ("Codigo Adicional USI De debe ser menor o igual a Codigo Adicional USI A. \n \n Mensaje generado por GesTor F1.");
		return false;
	}
	return true;
}
function compareYear () {
	var form=document.form2;
	if (form.AD.value != form.AA.value) {
		alert ("Los anos deben ser los mismos. \n \n Mensaje generado por GesTor F1.");
		return false;
	}	
	return true;
}
-->
</script>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="get" action="<?php echo $PHP_SELF ?> " onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $cod;?>">
	<input name="var2" type="hidden" value="<?php echo $AdicUS;?>">
	<input name="var1" type="hidden" value="<?php echo $cod1;?>">
	<input name="var3" type="hidden" value="<?php echo $opt;?>">
	<tr> 
      <td> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4">
          <tr bgcolor="#006699"> 
            <td colspan="15" background="images/main-button-tileR2.jpg" height="22"> <div align="center"><font size="3" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong> 
                CALENDARIZACION DE CONTINGENCIA - PLANIFICACION</strong></font></div></td>
          </tr>
          <tr bgcolor="#006699" align="center"> 
            <th width="35" rowspan="2" background="images/main-button-tileR2.jpg"> <font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Ord. 
              Trabajo</font></th>
            <td width="245" rowspan="2" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Incidencia</font></td>
            <td width="53" rowspan="2" height="42" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Estado</font></td>
            <td colspan="4" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cuatrimestre1</font></td>
            <td colspan="4" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cuatrimestre2</font></td>
            <td colspan="4" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cuatrimestre3</font></td>
          </tr>
          <tr bgcolor="#006699"> 
            <th width="35" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Ene</font></th>
            <th width="35" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Feb</font></th>
            <th width="35" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Mar</font></th>
            <th width="35" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Abr</font></th>
            <th width="35" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">May</font></th>
            <th width="35" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Jun</font></th>
            <th width="35" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Jul</font></th>
            <th width="35" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Ago</font></th>
            <th width="35" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Sept</font></th>
            <th width="35" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Oct</font></th>
            <th width="35" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nov</font></th>
            <th width="37"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Dic</font></th>
          </tr>
          <?php
		$sql = "SELECT * FROM calen_contingencia WHERE id_cmant>='$cod'";
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
          <tr align="center"> 
            <td width="35">&nbsp;<?php echo $row['TipoPru'];?></td>
            <?php $sql4 = "SELECT * FROM ordenes WHERE id_orden='$row[TipoPru]'";
			$result4=mysql_query($sql4);
			$row4=mysql_fetch_array($result4);?>
            <td> <?php echo '<font size="1">'.$row4['desc_inc'];?> </td>
            <td width="53">&nbsp;<?php echo $row['estado'];?></td>
            <td width="35">&nbsp; 
              <?php if($mesd=="01"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa"; }}?>
            </td>
            <td width="35" >&nbsp; 
              <?php if($mesd=="02"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="35" >&nbsp; 
              <?php if($mesd=="03"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="35" >&nbsp; 
              <?php if($mesd=="04"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="35">&nbsp; 
              <?php if($mesd=="05"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="35">&nbsp; 
              <?php if($mesd=="06"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="35">&nbsp; 
              <?php if($mesd=="07"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="35">&nbsp; 
              <?php if($mesd=="08"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="35">&nbsp; 
              <?php if($mesd=="09"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="35"">&nbsp; 
              <?php if($mesd=="10"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="35">&nbsp; 
              <?php if($mesd=="11"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="37">&nbsp; 
              <?php if($mesd=="12"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
          </tr>
          <?php } ?>
        </table>
        <table width="100%" border="2" cellpadding="2" cellspacing="4">
          <tr align="center"> 
            <td width="295"> 
              <select name="menu1" onChange="MM_jumpMenu('parent',this,1)">
            <option></option>
			    <?php 
			  	$sql6 = "SELECT id_orden FROM asignacion GROUP BY id_orden";
				$result6=mysql_query($sql6);
					while ($row6=mysql_fetch_array($result6)) 
					{
						$sql8 = "SELECT asignacion.*, ordenes.desc_inc FROM asignacion, ordenes WHERE asignacion.id_orden=ordenes.id_orden AND asignacion.id_orden='$row6[id_orden]' ORDER BY id_asig DESC limit 1";
						$result8=mysql_query($sql8);
						$row8=mysql_fetch_array($result8);
						if ($row8['area']=='Contingencia')
		  				{
						if (strlen($row8['desc_inc'])>40) $tmp="...";
						else $tmp="";
						if ($row8['id_orden']==$opt)					
							{echo "<option value=\"calendariza_cont.php?varia=$cod&varia1=$cod1&opt=$row8[id_orden]\" selected>$row8[id_orden]. ".substr($row8['desc_inc'],0,40).$tmp."</option>";}
	            		else
							{echo "<option value=\"calendariza_cont.php?varia=$cod&varia1=$cod1&opt=$row8[id_orden]\">$row8[id_orden]. ".substr($row8['desc_inc'],0,40).$tmp."</option>";}
						}
					}
			   ?>
              </select>
              &nbsp; 
              <?php 
				if ($opt<>"")
				{$sql9="SELECT * FROM ordenes WHERE id_orden='$opt'";
				$result9=mysql_query($sql9);
				$row9=mysql_fetch_array($result9);
				?>
              <textarea name="textarea" cols="40"><?php echo $row9['desc_inc']?></textarea>
              <?php }?>
            </td>
            <td width="53">Planificado</td>
            <td>del: <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <?php 
			  $fsist=date("Y-m-d");
			  
			   ?>
              <select name="DD" id="select4">
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
              <select name="MD" id="select5">
                <?php for($i=1;$i<=12;$i++)
					  {echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   ?>
              </select>
              <select name="AD" id="select6">
                <?php for($i=2003;$i<=2020;$i++)
				      {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				?>
              </select>
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></td>
            <td>al: <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="DA" id="select10">
                <?php
  				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
					for($i=1;$i<=31;$i++)
					{echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";}
			    ?>
              </select>
              </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="MA" id="select11">
                <?php for($i=1;$i<=12;$i++)
					  {echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   ?>
              </select>
              <select name="AA" id="select12">
                <?php for($i=2003;$i<=2020;$i++)
				      {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				?>
              </select>
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></td>
          </tr>
          <tr> 
            <td height="34" colspan="4">
<table width="75%" border="0" align="center">
                <tr> 
                  <td align="center"><input name="reg_form" type="submit" id="reg_form" value="INSERTAR" <?php print $valid->onSubmit() ?>></td>
                  <td align="center"><input type="submit" name="Salir" value="RETORNAR"></td>
                </tr>
              </table></td>
          </tr>
        </table> </td>
    </tr></form>
  </table>
 <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DD'], document.forms[form].elements['MD'], document.forms[form].elements['AD']);			
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);			
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>  