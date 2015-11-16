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
if (isset($RETORNAR))
{   header("location: lista_controlinvent.php");}
if (isset($insertar))
{	include("conexion.php");
	
	$sql = "SELECT *, DATE_FORMAT(FechaAlta, '%d/%m/%Y') AS FechaAlta FROM controlinvent WHERE Codigo='$Codigo'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	
	$sql_cor="SELECT MAX(nro_corre) as num_cor FROM controlinvent WHERE codigo_usu='$codigo_usu' AND tipo_medio='$tipo_medio' AND tipo_dato='$tipo_dato'";
	$row_cor=mysql_fetch_array(mysql_query($sql_cor));
		
	if($row['codigo_usu']!=$codigo_usu OR $row['tipo_dato']!=$tipo_dato OR $row['tipo_medio']!=$tipo_medio)
	{
		$num_fin=$row_cor['num_cor']+1;
		$sql_mo="SELECT * FROM controlinvent WHERE codigo_usu='$row[codigo_usu]' AND tipo_medio='$row[tipo_medio]' AND tipo_dato='$row[tipo_dato]' AND nro_corre>'$row[nro_corre]'";
		$res_mo=mysql_query($sql_mo);
		while($row_mo=mysql_fetch_array($res_mo))
		{
			$val=$row_mo['nro_corre']-1;
			$sql_mo1="UPDATE controlinvent SET nro_corre='$val' WHERE Codigo='$row_mo[Codigo]'";
			mysql_query($sql_mo1);
		}
	}
	else{$num_fin=$row_cor['num_cor'];}
		
	$sql3="UPDATE controlinvent SET Observ='$Observ',codigo_usu='$codigo_usu',tipo_medio='$tipo_medio',tipo_dato='$tipo_dato',".
		  "nro_cds='$nro_cds',nro_corre='$nro_corre' WHERE Codigo='$Codigo'";
	mysql_query($sql3);
	header("location:lista_controlinvent.php?msg=si");
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
if (isset($Cod)){
?>
<script language="JavaScript">
	window.alert("El codigo ya existe, introduzca otro.");
</script>
<?php
}

$sql = "SELECT *, DATE_FORMAT(FechaAlta, '%d/%m/%Y') AS FechaAlta FROM controlinvent WHERE Codigo='$Codigo'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
  		
if(!isset($varia2)){$varia2=$row['codigo_usu'];}
if(!isset($varia3)){$varia3=$row['tipo_medio'];}
if(!isset($varia4)){$varia4=$row['tipo_dato'];}
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
	<input name="Codigo" type="hidden" value="<?php echo $Codigo;?>">
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
          <tr> 
            <td width="49" height="7"> <div align="center"> 
                <p><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="1">MODIFICA</font></strong></p>
              </div></td>
            <td width="203" nowrap height="3"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong> 
                <?php echo $row['FechaAlta'];?></strong>
                </font></div></td>
            <td width="67" height="7"> <div> <div align="center"> 
                <select name="codigo_usu" onChange="tip_dat('<?phpif (isset($codigo)) echo $Codigo;?>',this.value,'<?phpif (isset($varia3))  echo $varia3;?>','<?phpif (isset($varia4))  echo $varia4;?>')">
                  <option value="INF" <?php if($varia2=="INF"){echo "selected";}?>>INF</option>
                  <option value="FRL" <?php if($varia2=="FRL"){echo "selected";}?>>FRL</option>
                  <option value="SBF" <?php if($varia2=="SBF"){echo "selected";}?>>SBF</option>
                </select>
              </div></td>
            <td width="89" height="7" nowrap> <div align="center"> 
                <select name="tipo_medio" onChange="tip_dat1('<?phpif (isset($codigo)) echo $Codigo;?>','<?phpif (isset($varia2))  echo $varia2;?>',this.value,'<?phpif (isset($varia4))  echo $varia4;?>')">
                  <option value="CDL" <?php if(isset($varia3) && $varia3=="CDL"){echo "selected";}?>>CDL</option>
		   		  <option value="CDT" <?php if(isset($varia3) && $varia3=="CDT"){echo "selected";}?>>CDT</option>
                  <option value="DCD" <?php if(isset($varia3) && $varia3=="DCD"){echo "selected";}?>>DCD</option>
                  <option value="DVD" <?php if(isset($varia3) && $varia3=="DVD"){echo "selected";}?>>DVD</option>
                  <option value="DSK" <?php if(isset($varia3) && $varia3=="DSK"){echo "selected";}?>>DSK</option>
                  <option value="HDD" <?php if(isset($varia3) && $varia3=="HDD"){echo "selected";}?>>HDD</option>
                </select>
              </div></td>
            <td height="7" colspan="1"> <div align="center"> 
                <select name="tipo_dato" onChange="tip_dat2('<?phpif (isset($codigo))  echo $Codigo;?>','<?php if (isset($varia2)) echo $varia2;?>','<?php if (isset($varia3)) echo $varia3;?>',this.value)">
                  <?php if($varia2=="INF" OR $varia2=="FRL"){?>
                  <option value="APP" <?php if(isset($varia4) && $varia4=="APP"){echo "selected";}?>>APP</option>
				  <option value="BCK" <?php if(isset($varia4) && $varia4=="BCK"){echo "selected";}?>>BCK</option>
				  <option value="BIC" <?php if(isset($varia4) && $varia4=="BIC"){echo "selected";}?>>BIC</option>
                  <option value="DAT" <?php if(isset($varia4) && $varia4=="DAT"){echo "selected";}?>>DAT</option>
                  <option value="DRI" <?php if(isset($varia4) && $varia4=="DRI"){echo "selected";}?>>DRI</option>
                  <option value="OFI" <?php if(isset($varia4) && $varia4=="OFI"){echo "selected";}?>>OFI</option>
				  <option value="SOP" <?php if(isset($varia4) && $varia4=="SOP"){echo "selected";}?>>SOP</option>
                  <option value="VAR" <?php if(isset($varia4) && $varia4=="VAR"){echo "selected";}?>>VAR</option>
                  <?php }else{?>
                  <option value="CCR" <?php if(isset($varia4) && $varia4=="CCR"){echo "selected";}?>>CCR</option>
                  <option value="DAT" <?php if(isset($varia4) && $varia4=="DAT"){echo "selected";}?>>DAT</option>
                  <option value="EJC" <?php if(isset($varia4) && $varia4=="EJC"){echo "selected";}?>>EJC</option>
                  <option value="JUI" <?php if(isset($varia4) && $varia4=="JUI"){echo "selected";}?>>JUI</option>
                  <option value="PER" <?php if(isset($varia4) && $varia4=="PER"){echo "selected";}?>>PER</option>
                  <option value="VAR" <?php if(isset($varia4) && $varia4=="VAR"){echo "selected";}?>>VAR</option>
                  <?php }?>
                </select>
              </div></td>
            <td align="center"><input name="nro_cds" type="text" size="3" maxlength="2" value="<?php echo "$row[nro_cds]";?>"></td>
            <?php 
			  	$sql_cor="SELECT MAX(nro_corre) as num_cor FROM controlinvent WHERE codigo_usu='$varia2' AND tipo_medio='$varia3' AND tipo_dato='$varia4'";
			 	$row_cor=mysql_fetch_array(mysql_query($sql_cor));
				if($row['codigo_usu']!=$varia2 OR $row['tipo_dato']!=$varia4 OR $row['tipo_medio']!=$varia3){$num_fin=$row_cor['num_cor']+1;}
				else{$num_fin=$row_cor['num_cor'];}
			 ?>
            <td align="center"><input name="nro_corre" type="text" size="3" maxlength="3" value="<?php echo $num_fin;?>" readonly></td>
            <td height="7" align="center"> <textarea name="Observ" cols="30" rows="2"><?php echo $row['Observ'];?></textarea> 
            </td>
          </tr>
          <tr> 
            <td height="28" colspan="9"> <div align="center"><br>
                <input name="insertar" type="submit" id="reg_form3" value="  MODIFICAR  " <?php echo $valid->onSubmit(); ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
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
	function irapagina_c(pagina)
	{         
 		 if (pagina!="") {self.location = pagina;}
	}
	function tip_dat(numr,co,med,dat)
	{        
		irapagina_c("lista_controlinvent_modi.php?Codigo="+numr+"&varia2="+co+"&varia3="+med+"&varia4="+dat); 
	}
	function tip_dat1(numr,co,med,dat)
	{        
		irapagina_c("lista_controlinvent_modi.php?Codigo="+numr+"&varia2="+co+"&varia3="+med+"&varia4="+dat); 
	}
	function tip_dat2(numr,co,med,dat)
	{        
		irapagina_c("lista_controlinvent_modi.php?Codigo="+numr+"&varia2="+co+"&varia3="+med+"&varia4="+dat); 
	}
//-->
</script>