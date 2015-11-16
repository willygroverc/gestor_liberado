<?php 
if (isset($RETORNAR))
{   header("location: lista_controlinvent.php");}
if (isset($insertar))
{	include("conexion.php");
		$sql_cor="SELECT MAX(nro_corre) as num_cor FROM controlinvent WHERE codigo_usu='$codigo_usu' AND tipo_medio='$tipo_medio' AND tipo_dato='$tipo_dato'";
		$row_cor=mysql_fetch_array(mysql_db_query($db,$sql_cor,$link));
		$num_fin=$row_cor[num_cor]+1;
	$FechaAlta="$AnoA-$MesA-$DiaA";
	$sql3="INSERT INTO controlinvent(FechaAlta,Observ,codigo_usu,tipo_medio,tipo_dato,nro_cds,nro_corre)".
		  " VALUES('$FechaAlta','$Observ','$codigo_usu','$tipo_medio','$tipo_dato','$nro_cds','$nro_corre')";
	mysql_db_query($db,$sql3,$link);
	//header("location: controlinventario.php?varia1=$varia1");
}
include("top.php");
?>
<script language="JavaScript" src="calendar.js"></script>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsDate ( "DiaA", "MesA", "AnoA", "Fecha Alta, $errorMsgJs[date]" );
$valid->addExists ( "nro_cds", "Numero de CDs, $errorMsgJs[empty]");
$valid->addIsTextNormal ( "Observ",  "Observaciones, $errorMsgJs[expresion]" );
$valid->addFunction ( "valida_nro_cds",  "" );
echo $valid->toHtml ();
if ($Cod){
?>
<script language="JavaScript">
	window.alert("El codigo ya existe, introduzca otro.");
</script>
<?php
}
if($varia2==""){$varia2="INF";}
if($varia3==""){$varia3="CIN";}
if($varia4==""){$varia4="APP";}
?>
<script language="JavaScript">
function valida_nro_cds () 
{
	var form=document.form2;
	var msg="\n \n Mensaje generado por GesTor F1.";
	if (form.nro_cds.value.length > 0) {
		if (form.nro_cds.value.search(new RegExp("^([0-9])+$","g"))<0) {
			alert ("Numero de Cds, debe ser un valor numerico entero" + msg);
			return ( false );
		}
		else
		{
			if (form.nro_cds.value>99 || form.nro_cds.value<1)
			{
				alert ("Numero de Cds, debe ser un valor mayor a 0 y menor o igual a 99" + msg);
				return ( false );
			}
		}
	}
	return true;
}
</script>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
<form name="form2" method="post" onKeyPress="return Form()">
	<input name="varia1" type="hidden" value="<?php echo $varia1;?>">
	<input name="varia2" type="hidden" value="<?php echo $varia2;?>">
	<input name="varia3" type="hidden" value="<?php echo $varia3;?>">
	<input name="varia4" type="hidden" value="<?php echo $varia4;?>">
	<tr> 
      <td height="150"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="9" nowrap bgcolor="#006699"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">INVENTARIO 
              DE MEDIOS - ALTA DE MEDIO DE ALMACENAMIENTO</font></th>
          </tr>
          <tr> 
            <th width="49" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">N&ordm;</font></th>
            <th width="203" nowrap bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA 
              ALTA </font></th>
            <th width="67" bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">CODIGO</font></th>
            <th width="89" bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">TIPO 
              MEDIO </font></th>
            <th width="71" bgcolor="#006699"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">TIPO 
              DATO</font></th>
            <th width="70" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nro. 
              CDs </font></th>
			<th width="71" bgcolor="#006699"> <div>
                <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Nro. 
                  Correlativo</font></div>
              </div></th>
            <th width="264" colspan="1" nowrap bgcolor="#006699"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">OBSERVACIONES</font></div></th>
          </tr>
          <?php
		$sql = "SELECT *, DATE_FORMAT(FechaAlta, '%d/%m/%Y') AS FechaAlta FROM controlinvent WHERE Codigo >='$varia1'";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{ 
		 ?>
          <tr align="center"> 
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row[Codigo]?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row[FechaAlta]?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row[codigo_usu]?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row[tipo_medio]?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row[tipo_dato]?></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row[nro_cds]?></font></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row[nro_corre]?></font></td>            
			<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row[Observ]?></font></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="9" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="49" height="7"> <div align="center"> 
                <p><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="1">NUEVO</font></strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                  </font></p>
              </div></td>
            <td width="203" nowrap height="3"><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font> 
                <select name="DiaA" id="select">
                  <?php
				  	$a=date("Y-m-d");
				   	$a1=substr($a,0,4);
					$m1=substr($a,5,2);
					$d1=substr($a,8,2);
				for($i=1;$i<=31;$i++)
				{
                if ($Cod){echo "<option value=\"$i\"";if($Dia=="$i")echo "selected";echo">$i</option>";
				}else{
				echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";}
				}
				?>
                </select>
                <select name="MesA" id="select2">
                  <?php
				for($i=1;$i<=12;$i++)
					  {
					  if ($Cod){echo "<option value=\"$i\"";if($Mes=="$i")echo "selected";echo">$i</option>";
						}else{
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
					  }
			   ?>
                </select>
                <select name="AnoA" id="select3">
                  <?php for($i=2002;$i<=2020;$i++)
				      {
					   if ($Cod){echo "<option value=\"$i\"";if($Ano=="$i")echo "selected";echo">$i</option>";
						}else{
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				      }
				?>
                </select>
                </strong> <font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></div></td>
            <td width="67" height="7"> <div> <div align="center"> 
                <select name="codigo_usu" onChange="tip_dat('<?php echo $varia1;?>',this.value,'<?php echo $varia3;?>','<?php echo $varia4;?>')">
                  <option value="INF" <?php if($varia2=="INF"){echo "selected";}?>>INF</option>
                  <option value="FRL" <?php if($varia2=="FRL"){echo "selected";}?>>FRL</option>
                  <option value="SBF" <?php if($varia2=="SBF"){echo "selected";}?>>SBF</option>
                </select>
              </div></td>
            <td width="89" height="7" nowrap> <div align="center"> 
                <select name="tipo_medio" onChange="tip_dat1('<?php echo $varia1;?>','<?php echo $varia2;?>',this.value,'<?php echo $varia4;?>')">
				  <option value="CDL" <?php if($varia3=="CDL"){echo "selected";}?>>CDL</option>
				  <option value="CDT" <?php if($varia3=="CDT"){echo "selected";}?>>CDT</option>
                  <option value="DCD" <?php if($varia3=="DCD"){echo "selected";}?>>DCD</option>
                  <option value="DVD" <?php if($varia3=="DVD"){echo "selected";}?>>DVD</option>
                  <option value="DSK" <?php if($varia3=="DSK"){echo "selected";}?>>DSK</option>
                  <option value="HDD" <?php if($varia3=="HDD"){echo "selected";}?>>HDD</option>
                </select>
              </div></td>
          	<td height="7" colspan="1"> 
			 <div align="center"> 
                <select name="tipo_dato" onChange="tip_dat2('<?php echo $varia1;?>','<?php echo $varia2;?>','<?php echo $varia3;?>',this.value)">
                  <?php if($varia2=="INF" OR $varia2=="FRL"){?>
				  <option value="APP" <?php if($varia4=="APP"){echo "selected";}?>>APP</option>
				  <option value="BCK" <?php if($varia4=="BCK"){echo "selected";}?>>BCK</option>
				  <option value="BIC" <?php if($varia4=="BIC"){echo "selected";}?>>BIC</option>
				  <option value="DAT" <?php if($varia4=="DAT"){echo "selected";}?>>DAT</option>
				  <option value="DRI" <?php if($varia4=="DRI"){echo "selected";}?>>DRI</option>
				  <option value="OFI" <?php if($varia4=="OFI"){echo "selected";}?>>OFI</option>
                  <option value="SOP" <?php if($varia4=="SOP"){echo "selected";}?>>SOP</option>
                  <option value="VAR" <?php if($varia4=="VAR"){echo "selected";}?>>VAR</option>
				  <?php }else{?>
			      <option value="CCR" <?php if($varia4=="CCR"){echo "selected";}?>>CCR</option>
				  <option value="DAT" <?php if($varia4=="DAT"){echo "selected";}?>>DAT</option>
				  <option value="EJC" <?php if($varia4=="EJC"){echo "selected";}?>>EJC</option>
				  <option value="JUI" <?php if($varia4=="JUI"){echo "selected";}?>>JUI</option>
                  <option value="PER" <?php if($varia4=="PER"){echo "selected";}?>>PER</option>
                  <option value="VAR" <?php if($varia4=="VAR"){echo "selected";}?>>VAR</option>
				  <?php }?>
                </select>
			 </div>
			</td>
			 <td align="center"><input name="nro_cds" type="text" size="3" maxlength="2"></td>
			 <?php 
			  	$sql_cor="SELECT MAX(nro_corre) as num_cor FROM controlinvent WHERE codigo_usu='$varia2' AND tipo_medio='$varia3' AND tipo_dato='$varia4'";
			 	$row_cor=mysql_fetch_array(mysql_db_query($db,$sql_cor,$link));
				$num_fin=$row_cor[num_cor]+1;
			 ?>
			 
            <td align="center"><input name="nro_corre" type="text" size="3" maxlength="3" value="<?php echo $num_fin;?>" readonly></td>
			<td height="7" align="center">
                <textarea name="Observ" cols="30" rows="2"><?php echo $Obs?></textarea>
            </td>
          </tr>
          <tr> 
            <td height="28" colspan="9"> <div align="center"><br>
                <input name="insertar" type="submit" id="reg_form3" value="  INSERTAR  " <?php echo $valid->onSubmit(); ?>>
                &nbsp; 
                <input type="submit" name="RETORNAR" value="  RETORNAR  ">
              </div></td>
          </tr>
        </table>
      </td>
    </tr></form>
  </table>
<strong> </strong><br>
<script language="JavaScript">
<!-- 
	var form="form2";
	var cal = new calendar1(document.forms[form].elements['DiaA'], document.forms[form].elements['MesA'], document.forms[form].elements['AnoA']);
	cal.year_scroll = true;
	cal.time_comp = false;
	
	function irapagina_c(pagina)
	{         
 		 if (pagina!="") {self.location = pagina;}
	}
	function tip_dat(numr,co,med,dat)
	{        
		irapagina_c("controlinventario.php?varia1="+numr+"&varia2="+co+"&varia3="+med+"&varia4="+dat); 
	}
	function tip_dat1(numr,co,med,dat)
	{        
		irapagina_c("controlinventario.php?varia1="+numr+"&varia2="+co+"&varia3="+med+"&varia4="+dat); 
	}
	function tip_dat2(numr,co,med,dat)
	{        
		irapagina_c("controlinventario.php?varia1="+numr+"&varia2="+co+"&varia3="+med+"&varia4="+dat); 
	}
//-->
</script>
<?php include("top_.php");?>