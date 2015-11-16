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
if (isset($Salir)){header("location: lista_calen.php");}
require("conexion.php");
include("funciones.inc.php");	
//====================== HERE
unset($agencia);
unset($mat);
unset($c);
$sql = "SELECT * FROM datfichatec ORDER BY IdFicha";
$res = mysql_query( $sql);
while ($row = mysql_fetch_array($res))
{	$sql2 = "SELECT MAX(IdCust) AS IdCust FROM asigcustficha WHERE IdFicha=$row[IdFicha]";
	$res2 = mysql_query( $sql2);
	$row2 = mysql_fetch_array($res2);
	if (!(empty($row2['IdCust'])))
	{	$sql3 = "SELECT IdCust, IdFicha, tipo1, NombAsig FROM asigcustficha WHERE IdCust=$row2[IdCust]";	
		$res3 = mysql_query( $sql3);
		$row3 = mysql_fetch_array($res3);
		if ($row3['tipo1']!="Devuelto")
		{	$sql4 = "SELECT login_usr, adicional1, nombre_dadicional FROM users, datos_adicionales WHERE adicional1=id_dadicional AND login_usr='$row3[NombAsig]'";
			$res4 = mysql_query( $sql4);
			$row4 = mysql_fetch_array($res4);
			if (!empty($row4['nombre_dadicional']))		
			{	
				$listResAct[$row4['adicional1']] = $row4['nombre_dadicional'];
			}
		}
	}
}
$c=0;
if(isset($listResAct) && count($listResAct)<>0){
	foreach ($listResAct as $k => $v) {
		$agencia[$c] = $k;
		$c++;
	} 
}
else
	$listResAct=0;
for ($i=0; $i<count($listResAct); $i++){	
$sql = "SELECT * FROM datfichatec ORDER BY IdFicha";
$res = mysql_query( $sql);
$j = 1;
while ( $row = mysql_fetch_array($res) )
{	$sql2 = "SELECT MAX(IdCust) AS IdCust FROM asigcustficha WHERE IdFicha=$row[IdFicha]";
	$res2 = mysql_query( $sql2);
	$row2 = mysql_fetch_array($res2);
	if (!(empty($row2['IdCust'])))
	{	$sql3 = "SELECT IdCust, IdFicha, tipo1, NombAsig FROM asigcustficha WHERE IdCust=$row2[IdCust]";
		$res3 = mysql_query( $sql3);
		$row3 = mysql_fetch_array($res3);
		if ($row3['tipo1']!="Devuelto")
		{	$sql4 = "SELECT login_usr,nom_usr,apa_usr,ama_usr, adicional1, nombre_dadicional FROM users, datos_adicionales WHERE adicional1=id_dadicional AND login_usr='$row3[NombAsig]'";
			$res4 = mysql_query( $sql4);
			$row4 = mysql_fetch_array($res4);
			$nc = $row4['apa_usr']." ".$row4['ama_usr']." ".$row4['nom_usr'];
			if (isset($agencia) && $row4['adicional1']==$agencia[$i])
			{	$sql5 = "SELECT IdFicha, AdicUSI FROM datfichatec WHERE IdFicha='$row3[IdFicha]'";							
				$res5 = mysql_query( $sql5);
				$row5 = mysql_fetch_array($res5);
				$mat[$i][$j] = $row4['nombre_dadicional']."*".$row3['IdFicha']."*".$row5['AdicUSI']."*".$nc;
				$j++;
			}
		}
	}		
}
$mat[$i][0] = $j-1;
}

$i = 0;	
for ($j =1; $j<$mat[0][0]+1; $j++ )
{	$dat = explode("*",$mat[$i][$j]);
	$listUser[$dat[2]] = $dat[2]." [".$dat[3]."]";
}	
//------------------------here end
if (isset($reg_form))
{	
	include("conexion.php");
	$fecha_del="$AD-$MD-$DD";	
	$fecha_al="$AA-$MA-$DA";	
	$sql7 = "SELECT MAX(id_cmant) as id_cmant FROM calenmantplanif";
	$result7 = mysql_query($sql7);
	$fil = mysql_fetch_array($result7);
	if ($fil['id_cmant'])	$id_cmant = $fil['id_cmant']+1;
	else  $id_cmant = 1;	
	//==
	$sql4 = "SELECT * FROM datfichatec WHERE AdicUSI='$AdicUSI'";
	$result4=mysql_query($sql4);
	$row4=mysql_fetch_array($result4);
	$sql5 = "SELECT * FROM datfichatec WHERE AdicUSI='$AdicUSI2'";
	$result5=mysql_query($sql5);
	$row5=mysql_fetch_array($result5);
	$de = $row4['IdFicha'];
	$al = $row5['IdFicha'];
	for($i=$de;$i<=$al;$i++)
	{	
		$sql6 = "SELECT * FROM datfichatec WHERE IdFicha='$i'";
		$result6 = mysql_query($sql6);
		$row6 = mysql_fetch_array($result6);
		$sql8 = "SELECT MAX(IdCust) AS IdCust FROM asigcustficha WHERE IdFicha=$i";
		$res8 = mysql_query($sql8);
		$row8 = mysql_fetch_array($res8);
		if (isset($row8['IdCust']))
		{	$sql9 = "SELECT  IdCust, NombAsig FROM asigcustficha WHERE IdCust = $row8[IdCust]";
			$res9 = mysql_query($sql9);
			$row9 = mysql_fetch_array($res9);
			$sql0 = "SELECT login_usr,adicional1 FROM users WHERE login_usr='$row9[NombAsig]'";
			//$sql0 = "SELECT login_usr,adicional1 FROM users WHERE login_usr='$row6[RealizFicha]'";
			$res0 = mysql_query($sql0);
			$row0 = mysql_fetch_array($res0);
			if ( $row0['adicional1'] == $menu)		
			{	$str="INSERT INTO ".
				"calenmantplanif (id_cmant,AdicUSI,estado,fecha_del,fecha_al) ".
				"VALUES ('$id_cmant','$row6[AdicUSI]','Planificado','$fecha_del','$fecha_al')";
				mysql_query($str);
				$id_cmant=$id_cmant+1;
				$var1=$id_cmant;
			}
						
		}
		//echo ":P".$row0[adicional1];
	}
	header("location: calendarizacion_agencia.php?varia=$var&varia1=$var1&AdicUSI=$var2&usr2=$usr2");
}
else
{

include ("top.php");
if (isset($_GET['varia']))$cod=($_GET['varia']);
if (isset($_GET['varia1']))$cod1=($_GET['varia1']);
if (isset($_GET['AdicUSI']))$AdicUS=($_GET['AdicUSI']);

?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "AdicUSI",  "Codigo Adicional USI De, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "AdicUSI2",  "Codigo Adicional USI Al, $errorMsgJs[empty]" );
$valid->addIsDate ( "DD", "MD", "AD", "Fecha de: $errorMsgJs[date]" );
$valid->addIsDate ( "DA", "MA", "AA", "Fecha a: $errorMsgJs[date]" );
$valid->addCompareDates ( "DD", "MD", "AD", "DA", "MA", "AA", "$errorMsgJs[compareDates]" );
$valid->addFunction ( "compareAdicUsi",  "" );
$valid->addFunction ( "compareYear",  "" );
print $valid->toHtml();
		$sql = "SELECT IdFicha, AdicUSI FROM datfichatec";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result)) 			  	
		{		$listAdicUSI[$row['AdicUSI']]=$row['IdFicha'];
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
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>	
<table width="95%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="get" action="<?php echo $PHP_SELF ?> " onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php if(isset($cod)) echo $cod;?>">
	<input name="var2" type="hidden" value="<?php if(isset($AdicUS)) echo $AdicUS;?>">
	<input name="var1" type="hidden" value="<?php if(isset($cod1)) echo $cod1;?>">
	<input name="var" type="hidden" value="<?php if(isset($cod)) echo $cod;?>">
	<input name="varia" type="hidden" value="<?php if(isset($cod)) echo $cod;?>">
	<input name="varia1" type="hidden" value="<?php if(isset($cod1)) echo $cod1;?>">
	<tr> 	
      <td>
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4">
           <tr bgcolor="#006699"> 
            <td colspan="15"> <div align="center"><font size="3" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong> 
                CALENDARIZACION DE MANTENIMIENTO </strong></font></div></td>
          </tr>
          <tr bgcolor="#006699"> 
            <th colspan="2" height="42"><div align="center"></div></th>
            <th width="66" rowspan="2" height="10"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Estado</font></th>
            <th colspan="4"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cuatrimestre1</font></th>
            <th colspan="4"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cuatrimestre2</font></th>
            <th colspan="4"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Cuatrimestre3</font></th>
          </tr>
          <tr bgcolor="#006699"> 
            <th width="149"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Agencia</font></font></th>
            <th width="142"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Codigo Adicional</font></th>
            <th width="33"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Ene</font></th>
            <th width="35"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Feb</font></th>
            <th width="33"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Mar</font></th>
            <th width="34"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Abr</font></th>
            <th width="33"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">May</font></th>
            <th width="33"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Jun</font></th>
            <th width="34"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Jul</font></th>
            <th width="35"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Ago</font></th>
            <th width="37"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Sept</font></th>
            <th width="33"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Oct</font></th>
            <th width="33"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nov</font></th>
            <th width="35"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Dic</font></th>
          </tr>
          <?php
		$sql = "SELECT * FROM calenmantplanif where id_cmant>='$cod'";
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
            <td colspan="2">&nbsp;
			<?php 
			$sql2="SELECT IdFicha, login_usr, CONCAT(apa_usr, ' ', ama_usr, ' ', nom_usr) AS nombre FROM asigcustficha, users WHERE asigcustficha.NombAsig=users.login_usr AND tipo1 IS NULL";
			$rs=mysql_query($sql2);
			while ($tmp=mysql_fetch_array($rs)) 
			{	$lstTecnico[$tmp['IdFicha']]=$tmp['nombre'];}
			  $str = "SELECT * FROM datfichatec";
			  $res = mysql_query($str);
			  while ($row9 = mysql_fetch_array($res)) 
			  {	
			  	$usr = $lstTecnico[$row9['IdFicha']];
				if (!isset($usr)) $usr="No asignado";
				if ( $row['AdicUSI']==$row9['AdicUSI'])
				{	echo $row['AdicUSI']." [".$usr."]";}
	            }

			?></td>
            <td width="66">&nbsp;<?php echo  $row['estado'];?></td>
            <td width="33">&nbsp; 
              <?php if($mesd=="01"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa"; }}?>
            </td>
            <td width="35">&nbsp; 
              <?php if($mesd=="02"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="33">&nbsp; 
              <?php if($mesd=="03"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="34">&nbsp; 
              <?php if($mesd=="04"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="33">&nbsp; 
              <?php if($mesd=="05"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="33">&nbsp; 
              <?php if($mesd=="06"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="34">&nbsp; 
              <?php if($mesd=="07"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="35">&nbsp; 
              <?php if($mesd=="08"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="37">&nbsp; 
              <?php if($mesd=="09"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="33">&nbsp; 
              <?php if($mesd=="10"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="33">&nbsp; 
              <?php if($mesd=="11"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
            <td width="35">&nbsp; 
              <?php if($mesd=="12"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
            </td>
          </tr>
          <?php } ?>
          <tr> 
            <td align="center"  nowrap><strong> 
              <select name="menu" id="select3" onChange=redirect(this.options.selectedIndex)>
			  	<!--option value=0> General </option-->      
                <?php 
              
				if (isset($listResAct) && sizeof($listResAct) > 0) {
					foreach ($listResAct as $k => $v) {
						print "<option value=\"$k\"";
						if ($k == $recordDb[resact]) print "selected";
						print ">$v</option>";
					} 
				} 			  

			  ?>
              </select>
              </strong></td>
            <td align="center"  nowrap>De:<strong> 
              <select name="AdicUSI" id="select6">
                <?php 
					if (isset($listUser) && sizeof($listUser) > 0) 
					{	foreach ($listUser as $k => $v) {
							print "<option value=\"$k\"";
							if ($k == $recordDb['nombresin']) print "selected";
							print ">$v</option>";
						} 
					} 
			    ?>
              </select>
              </strong> <br>Al:&nbsp;
             <select name="AdicUSI2" id="select5">
                <?php 
				if (isset($listUser) && sizeof($listUser) > 0) {
					foreach ($listUser as $k => $v) {
						print "<option value=\"$k\"";
						if ($k == $recordDb['nombresin']) print "selected";
						print ">$v</option>";
					} 
				} 
			  ?>
              </select> </td>
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
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong> 
              </font></strong></font></strong></td>
            <td height="71" colspan="6" nowrap align="center"><p>al: <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
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
                <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong> 
                </font></strong></font></strong></p></td>
          </tr>
          <tr> 
            <td height="74" colspan="15" nowrap> 
              <div align="center"> <br>
                <table width="75%" border="0">
                  <tr> 
                    <td align="center"><input name="reg_form" type="submit" id="reg_form" value="ANADIR" <?php print $valid->onSubmit() ?>> 
            
                      <input type="submit" name="Salir" value="RETORNAR"> </td>
					
                    <td align="center">&nbsp;</td>
                  </tr>
                </table>
              </div></td>
          </tr>
        </table>
      </td>
    </tr></form>
  </table>

  
<script language="JavaScript">

var groups=document.form2.menu.options.length
var group=new Array(groups)
for (i=0; i<groups; i++)
group[i] = new Array()
<?php

for ($i = 0; $i<count($mat); $i++)
{	$t = 0;	
	for ($j =1; $j<$mat[$i][0]+1; $j++ )
	{	$listUser[$mat[$i][$j]] = $mat[$i][$j];
		$d = explode("*",$listUser[$mat[$i][$j]]);
		$v = $d[2]." [".$d[3]."]";
		$k = $d[2];
		print "group[$i][$t]=new Option(\"$v\",\"$k\")\n";
		$t++;
	}	
}

?>
var temp=document.form2.AdicUSI;
var temp2=document.form2.AdicUSI2;
function redirect(x){
	for (m=temp.options.length-1;m>0;m--)
	{ temp.options[m]  = null
	  temp2.options[m] = null	
	}
	for (i=0;i<group[x].length;i++){
		temp.options[i]  = new Option(group[x][i].text,group[x][i].value)
		temp2.options[i] = new Option(group[x][i].text,group[x][i].value)
	}
	temp.options[0].selected=true
	temp2.options[0].selected=true	
}					

</script>
  
 <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DD'], document.forms[form].elements['MD'], document.forms[form].elements['AD']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		<?php
			if (isset($errorMsg)) print "alert (\"$errorMsg\");";
		?>
//-->
</script>

 <p>
  <?php } ?>
</p>