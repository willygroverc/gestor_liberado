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
if(isset($RETORNAR)){header("location: lista_calen.php");}
require("conexion.php");
if(isset($GUARDAR)){
require_once('funciones.php');
$FechDe="$AnoD-$MesD-$DiaD";
$FechAl="$AnoA-$MesA-$DiaA";
$idTabla=_clean($idTabla);
$IdContra=_clean($IdContra);
$FechDe=_clean($FechDe);
$FechAl=_clean($FechAl);
$obs=_clean($obs);
$cont_manten=_clean($cont_manten);
$cont_garantia=_clean($cont_garantia);
	
$idTabla=SanitizeString($idTabla);
$IdContra=SanitizeString($IdContra);
$FechDe=SanitizeString($FechDe);
$FechAl=SanitizeString($FechAl);
$obs=SanitizeString($obs);
$cont_manten=SanitizeString($cont_manten);
$cont_garantia=SanitizeString($cont_garantia);

$sql="INSERT INTO contyman (idmant, IdContra, fecha_del, fecha_al, obs, cont_manten, cont_garantia) 
VALUES ('$idTabla','$IdContra','$FechDe','$FechAl','$obs','$cont_manten','$cont_garantia');";
mysql_query($sql);
header("location: lista_calen.php");
}
include("top.php");
$fsist=date("Y-m-d");
?>
<script language="JavaScript" src="calendar.js"></script>
<table width="63%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <td bgcolor="#006699"><div align="center"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="3"><strong>CONTRATO 
        / GARANTIA</strong></font></div></td>
  </tr>
  <tr> 
    <td align="center">
<form name="form1" method="post" action="">
        <table width="97%" border="0" align="center">
          <tr> 
            <td><strong>CONTRATO No. 
              <input name="IdContra" type="text" id="IdContra" value="<?php echo $IdContra?>" size="10" maxlength="10" readonly="yes">
              </strong></td>
            <td align="right"><strong>TIPO :</strong></td>
            <td> <p> 
                <input name="cont_garantia" type="checkbox" id="cont_garantia" value="1" <?php if (isset($valor2) && $valor2=="true") echo 'checked';?>>
                Garantia <br>
                <input name="cont_manten" type="checkbox" id="cont_manten" <?php if ($valor=="true") echo 'checked';?>  value="1">            
            Mantenimiento Preventivo</p></td>
          </tr>
          <tr> 
            <td align="right">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr> 
            <td align="right"><strong>FECHA DE:</strong></td>
            <td align="left"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
<select name="DiaD" id="select19" <?php if($valor=="false" || !$valor) echo 'disabled';?>>
  <?php
				if (isset($GyC)){
					$a1=$AnoD;
					$m1=$MesD;
					$d1=$DiaD;
				}
				else{
					$a1=substr($fsist,0,4);
					$m1=substr($fsist,5,2);
					$d1=substr($fsist,8,2);
				}
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
</select>              
<select name="MesD" id="select20" <?php if($valor=="false" || !$valor) echo 'disabled';?>>
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="AnoD" id="select21" <?php if($valor=="false" || !$valor) echo 'disabled';?>>
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
            <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();">
            <?php if($valor=="true") echo "<img src='images/cal.gif' width='16' height='16' border='0' alt='Haga click para seleccionar una fecha'>";?>
            </a></font></strong></font></strong></font><font size="2" face="Arial, Helvetica, sans-serif"></font></strong></font></strong></font></strong></td>
            <td align="left"><strong>AL:<font size="2" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="DiaA" id="select" <?php if($valor=="false" || !$valor) echo 'disabled';?>>
                <?php
				if (isset($GyC)) {
					$a2=$AnoA;
					$m2=$MesA;
					$d2=$DiaA;
				}
				else{
					$a2=substr($fsist,0,4);
					$m2=substr($fsist,5,2);
					$d2=substr($fsist,8,2);
				}
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d2=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select>
              <select name="MesA" id="select2" <?php if($valor=="false" || !$valor) echo 'disabled';?>>
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m2=="$i") echo "selected"; echo">$i</option>";
					  }
			      ?>
              </select>
              <select name="AnoA" id="select3" <?php if($valor=="false" || !$valor) echo 'disabled';?>>
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a2=="$i") echo "selected"; echo">$i</option>";
				      }
	    			?>
              </select>
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();">
              <?php if($valor=="true") echo "<img src='images/cal.gif' width='16' height='16' border='0' alt='Haga click para seleccionar una fecha'>";?>
              </a></font></strong></font></strong></font><font size="2" face="Arial, Helvetica, sans-serif"></font></strong></font></strong></font></strong></font></strong></td>
          </tr>
          <tr> 
            <td align="right">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr> 
            <td align="right"><strong>OBSERVACIONES:</strong></td>
            <td colspan="2" align="left"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
              <textarea name="obs" cols="50" rows="4" <?php if($valor=="false" || !$valor) echo 'disabled';?> id="obs"></textarea>
              </font></strong></td>
          </tr>
        </table>
		<br>
        
        <input name="GUARDAR" type="submit" id="GUARDAR" value="GUARDAR">
		&nbsp;&nbsp;&nbsp;
        <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
</form>
    </td>
  </tr>
</table>
<script language="JavaScript">
		<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['DiaD'], document.forms[form].elements['MesD'], document.forms[form].elements['AnoD']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DiaA'], document.forms[form].elements['MesA'], document.forms[form].elements['AnoA']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		<?php
			if (isset($errorMsg)) print "alert (\"$errorMsg\");";
		?>
		function abrir(valor){
			var idcontra="<?php echo $IdContra;?>"
			alert(idcontra);
			var dir="contrato_garantia.php?valor="+valor+"&valor2="+document.form1.cont_garantia.checked+"&IdContra="+idcontra;
			self.location=dir;
		}
//-->
</script>