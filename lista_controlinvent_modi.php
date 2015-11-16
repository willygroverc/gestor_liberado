<?php
include('top.php');
require_once('funciones.php');
$Codigo=$_REQUEST['Codigo'];
$Codigo=SanitizeString($Codigo);
@session_start();
if($_SESSION['tipo']=="C") {
	header("location:pagina_inicio.php");
	return;
}
?>
<html>
<head>
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/calendar.css" />
<script language="javascript" src="js/jquery.js"></script>
<script language="JavaScript" src="js/inventario.js"></script>
<script language="JavaScript" src="js/ajax.js"></script>
<script language="javascript" src="js/validate.js"></script>
<script language="javascript" src="js/jquery-ui.js"></script>
<script>
$(function() {
	$( "#fecha_sol" ).datepicker({
	dateFormat: 'dd/mm/yy',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});

	$( "#fecha_escal" ).datepicker({
	dateFormat: 'dd/mm/yy',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
});
</script>
</head>
<body onload="document.getElementById('nro_cds').focus();">
<?php
$sql = "SELECT *, DATE_FORMAT(FechaAlta, '%d/%m/%Y') AS FechaAlta FROM controlinvent WHERE Codigo='$Codigo'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
  		
if(!isset($varia2)){$varia2=$row['codigo_usu'];}
if(!isset($varia3)){$varia3=$row['tipo_medio'];}
if(!isset($varia4)){$varia4=$row['tipo_dato'];}
echo '<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
<form name="frm_inv" id="frm_inv" method="POST" action="#">
	<input name="Codigo" id="Codigo" type="hidden" value="'; echo $Codigo; echo '">
	<input name="varia2" type="hidden" value="'; echo $varia2; echo '">
	<input name="varia3" type="hidden" value="'; echo $varia3; echo '">
	<input name="varia4" type="hidden" value="'; echo $varia4; echo '">
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
            <td width="203" nowrap height="3"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>';
			echo $row['FechaAlta']; echo '</strong>
                </font></div></td>
            <td width="67" height="7"> <div> <div align="center"> 
                <select name="codigo_usu" id="codigo_usu" onChange="tip_dat(';if (isset($codigo)) echo $Codigo; echo ',this.value,';if (isset($varia3))  echo $varia3; echo ',';if (isset($varia4))  echo $varia4; echo ')">
                  <option value="INF"'; if($varia2=="INF"){echo "selected";} echo '>INF</option>
                  <option value="FRL"'; if($varia2=="FRL"){echo "selected";} echo '>FRL</option>
                  <option value="SBF"'; if($varia2=="SBF"){echo "selected";} echo '>SBF</option>
                </select>
              </div></td>
            <td width="89" height="7" nowrap> <div align="center"> 
                <select name="tipo_medio" id="tipo_medio" onChange="tip_dat1(';if (isset($codigo)) echo $Codigo; echo ',';if (isset($varia2))  echo $varia2; echo ',this.value,'; if (isset($varia4))  echo $varia4; echo ')">
                  <option value="CDL"'; if(isset($varia3) && $varia3=="CDL"){echo "selected";} echo '>CDL</option>
		   		  <option value="CDT"'; if(isset($varia3) && $varia3=="CDT"){echo "selected";} echo '>CDT</option>
                  <option value="DCD"'; if(isset($varia3) && $varia3=="DCD"){echo "selected";} echo '>DCD</option>
                  <option value="DVD"'; if(isset($varia3) && $varia3=="DVD"){echo "selected";} echo '>DVD</option>
                  <option value="DSK"'; if(isset($varia3) && $varia3=="DSK"){echo "selected";} echo '>DSK</option>
                  <option value="HDD"'; if(isset($varia3) && $varia3=="HDD"){echo "selected";} echo '>HDD</option>
                </select>
              </div></td>
            <td height="7" colspan="1"> <div align="center"> 
                <select name="tipo_dato" id="tipo_dato" onChange="tip_dat2(';if (isset($codigo))  echo $Codigo; echo ','; if (isset($varia2)) echo $varia2; echo ','; if (isset($varia3)) echo $varia3; echo ',this.value)">';
                   if($varia2=="INF" OR $varia2=="FRL"){
                  echo '<option value="APP"'; if(isset($varia4) && $varia4=="APP"){echo "selected";} echo '>APP</option>
				  <option value="BCK"'; if(isset($varia4) && $varia4=="BCK"){echo "selected";} echo '>BCK</option>
				  <option value="BIC"'; if(isset($varia4) && $varia4=="BIC"){echo "selected";} echo '>BIC</option>
                  <option value="DAT"'; if(isset($varia4) && $varia4=="DAT"){echo "selected";} echo '>DAT</option>
                  <option value="DRI"'; if(isset($varia4) && $varia4=="DRI"){echo "selected";} echo '>DRI</option>
                  <option value="OFI"'; if(isset($varia4) && $varia4=="OFI"){echo "selected";} echo '>OFI</option>
				  <option value="SOP"'; if(isset($varia4) && $varia4=="SOP"){echo "selected";} echo '>SOP</option>
                  <option value="VAR"'; if(isset($varia4) && $varia4=="VAR"){echo "selected";} echo '>VAR</option>';
                   }else{
                  echo '<option value="CCR"'; if(isset($varia4) && $varia4=="CCR"){echo "selected";} echo '>CCR</option>
                  <option value="DAT"'; if(isset($varia4) && $varia4=="DAT"){echo "selected";} echo '>DAT</option>
                  <option value="EJC"'; if(isset($varia4) && $varia4=="EJC"){echo "selected";} echo '>EJC</option>
                  <option value="JUI"'; if(isset($varia4) && $varia4=="JUI"){echo "selected";} echo '>JUI</option>
                  <option value="PER"'; if(isset($varia4) && $varia4=="PER"){echo "selected";} echo '>PER</option>
                  <option value="VAR"'; if(isset($varia4) && $varia4=="VAR"){echo "selected";} echo '>VAR</option>';
                   }
                echo '</select>
              </div></td>
            <td align="center"><input name="nro_cds" id="nro_cds" type="text" size="3" maxlength="2" value="'; echo "$row[nro_cds]"; echo '"></td>';
             
			  	$sql_cor="SELECT MAX(nro_corre) as num_cor FROM controlinvent WHERE codigo_usu='$varia2' AND tipo_medio='$varia3' AND tipo_dato='$varia4'";
			 	$row_cor=mysql_fetch_array(mysql_query($sql_cor));
				if($row['codigo_usu']!=$varia2 OR $row['tipo_dato']!=$varia4 OR $row['tipo_medio']!=$varia3){$num_fin=$row_cor['num_cor']+1;}
				else{$num_fin=$row_cor['num_cor'];}
            echo '<td align="center"><input name="nro_corre" id="nro_corre" type="text" size="3" maxlength="3" value="'; echo $num_fin; echo '" readonly></td>
            <td height="7" align="center"> <textarea name="Observ" id="Observ" cols="30" rows="2">'; echo $row['Observ']; echo '</textarea> 
            </td>
          </tr>
          <tr> 
            <td height="28" colspan="9"> <div align="center"><br>
                <input type="button" name="submit" id="submit" value="MODIFICAR" onclick="guardar_inventario();" >
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="button" name="RETORNAR" value="  RETORNAR  " onclick="retornar(1);">
              </div></td>
          </tr>
        </table>
		</br>
		<center><div id="lbl_ajax">
			<div style="display: none;" class="success_box">Valida...</div>
			<div style="display: block;" class="error_box" id="error_box">Los campos con marcados con (*) son obligatorios</div>
		</div></center>
      </td>
    </tr>
	</form>
  </table>';
?>
</body>
</html>
