<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Limpieza de datos al guardar en la base de datos.
// Fecha: 		05/SEP/2012
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
// Version: 	3.0
// Objetivo: 	Validacion de datos de url para evitar ataques SQL injection
// Fecha: 		04/OCT/2012
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
require_once('funciones.php');
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($_REQUEST['RETORNAR']))
{   header("location: lista_controlinvent.php");}
$Codigo=SanitizeString('$Codigo');
?>
<?php if (isset($_REQUEST['insertar'])){
	require("conexion.php");
	$FechaBaja=$_REQUEST['AnoB'].'-'.$_REQUEST['MesB'].'-'.$_REQUEST['DiaB'];
	$FechaBaja=SanitizeString($FechaBaja);
        $var=$_REQUEST['var'];
	$var=SanitizeString($var);
	$sql3="UPDATE controlinvent SET FechaBaja='$FechaBaja' WHERE Codigo='$var'";
        //print_r($sql3);exit;
	mysql_query($sql3);
	header("location: lista_controlinvent.php");
}

else { 
include("top.php");
require_once('funciones.php');
$Codigo=SanitizeString($_GET['Codigo']);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsDate   ( "DiaB", "MesB", "AnoB", "Fecha, $errorMsgJs[date]" );
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
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $Codigo;?>">
	
	<tr> 
      <td height="210"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="4" nowrap bgcolor="#006699"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">INVENTARIO 
              DE MEDIOS - BAJA DE MEDIO DE ALMACENAMIENTO</font></th>
          </tr>
          <tr> 
            <th width="230" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CODIGO</font></th>
            <th width="250" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA 
              ALTA </font></th>
           
            <th width="297" colspan="1" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">OBSERVACIONES</font></div></th>
          </tr>
          <?php
			
		$sql = "SELECT *, DATE_FORMAT(FechaAlta, '%d/%m/%Y') AS FechaAlta FROM controlinvent WHERE Codigo ='$Codigo'"; 
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{ 
		 ?>
          <tr align="center"> 
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo "$row[codigo_usu] - $row[tipo_medio] - $row[tipo_dato] - $row[nro_cds] - $row[nro_corre]"?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['FechaAlta'];?></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['Observ'];?></font></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="5" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
        </table>
        <table width="100%" border="1">
          <tr> 
            <td width="74%"><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">INSERTE 
                LA FECHA EN LA QUE SE DARA DE BAJA AL MEDIO DE ALMACENAMIENTO 
                DESCRITO</font></strong></div></td>
            <td width="26%"><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="DiaB" id="select">
                  <?php 
				  	$a=date("Y-m-d");
				   	$a1=substr($a,0,4);
					$m1=substr($a,5,2);
					$d1=substr($a,8,2);
				 for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				  ?>
                </select>
                <select name="MesB" id="select2">
                  <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
      			  ?>
                </select>
                <select name="AnoB" id="select3">
                  <?php for($i=2002;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				  ?>
                </select>
                </font><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></strong></div></td>
          </tr>
        </table>
        <table width="100%" border="1">
          <tr> 
            <td><div align="center"><br>
                <input name="insertar" type="submit" id="reg_form3" value="GUARDAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
              </div>
              </td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
 
  <?php } ?>
<strong> </strong><br>
  <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DiaB'], document.forms[form].elements['MesB'], document.forms[form].elements['AnoB']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>