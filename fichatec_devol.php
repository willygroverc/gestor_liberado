<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		12/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Se valido que tenia sql injeciton, por lo tanto se validaron los datos
// Fecha: 		12/NOV/2012
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($_REQUEST['RETORNAR'])){header("location: lista_ficha.php");}
if (isset($_REQUEST['GyS']))
{   require("conexion.php");
	require_once('funciones.php');
        $var=$_REQUEST['var'];
        $var2=$_REQUEST['var2'];
	$var=SanitizeString($var);
	$var2=SanitizeString($var2);
	$FechaD=$_REQUEST['AnoD'].'-'.$_REQUEST['MesD'].'-'.$_REQUEST['DiaD'];
        
	$FechaD=SanitizeString($FechaD);
	$sql="UPDATE asigcustficha SET Tipo1='Devuelto',FechaD='$FechaD' WHERE IdFicha='$var' AND IdCust='$var2'";
        //print_r($sql);exit;
	mysql_query($sql); 
	header("location: lista_ficha.php");
}
else { 
include("top.php");
require_once('funciones.php');
$IdFi=SanitizeString($_GET['IdFicha']);
$IdFi2=SanitizeString($_GET['IdCust']);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsDate ( "DiaD", "MesD", "AnoD",  "Fecha de Devolucion, $errorMsgJs[date]" );
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
</script><br>
<table width="85%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $IdFi;?>">
	<input name="var2" type="hidden" value="<?php echo $IdFi2;?>">
	<tr> 
      <td height="91"> <p>&nbsp;&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><strong>Devuelto 
          por :</strong></font> </p>
        <table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr bgcolor="#006699"> 
            <td width="42%" background="images/main-button-tileR1.jpg" height="20"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF">NOMBRE</font></strong></font></div></td>
            <td width="32%" background="images/main-button-tileR1.jpg" height="20"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF">AREA</font></strong></font></div></td>
            <td width="26%" background="images/main-button-tileR1.jpg" height="20"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF">FECHA 
                DE DEVOLUCION</font></strong></font></div></td>
          </tr>
          <tr> 
		<?php $sql2 = "SELECT * FROM asigcustficha WHERE IdFicha='$IdFi' AND IdCust='$IdFi2'";
    	   $result2 = mysql_query($sql2);
		   $row2 = mysql_fetch_array($result2);
		   
		   $sql3 = "SELECT * FROM users WHERE login_usr='$row2[NombAsig]'";
    	   $result3 = mysql_query($sql3);
		   $row3 = mysql_fetch_array($result3);?>
			<td>&nbsp;<?php echo "$row2[NombAsig] : $row3[nom_usr] $row3[apa_usr] $row3[ama_usr]" ;?></td>
            <td>&nbsp;<?php echo $row2['Area'];?></td>
            <td><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <?php $fsist=date("Y-m-d"); ?>
                <select name="DiaD" id="select19">
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
                <select name="MesD" id="select20">
                  <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   	  ?>
                </select>
                <select name="AnoD" id="select21">
                  <?php for($i=1990;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>
                </font><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></strong></div></td>
          </tr>
        </table>
        
        <p align="center"> 
          <input type="submit" name="GyS" value="GUARDAR" <?php print $valid->onSubmit() ?>>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
        </p></td>
    </tr></form>
  </table>
 <script language="JavaScript">
		<!-- 
		 var cal = new calendar1(document.forms['form2'].elements['DiaD'], document.forms['form2'].elements['MesD'], document.forms['form2'].elements['AnoD']);			
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>

  <?php } ?>