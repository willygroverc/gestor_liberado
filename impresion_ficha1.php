<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
  <title>GesTor F1</title>
</head>
<body background="images/fondo.jpg" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<script language="JavaScript" src="calendar.js"></script>
<CENTER>
<?php
include("conexion.php");
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsDate   ( "DA", "MA", "AA", "Fecha de Inicio, $errorMsgJs[date]" );
$valid->addIsDate   ( "DE", "ME", "AE", "Fecha de Conclusion, $errorMsgJs[date]" );
$valid->addCompareDates   ( "DA", "MA", "AA","DE", "ME", "AE", "Fecha Del y Fecha Al, $errorMsgJs[compareDates]");
$valid->addFunction("OpenPrint7","");
print $valid->toHtml ();

if (!empty($enviar))
{		//
		echo "<table align='center' width='100%'><tr>  <td colspan='4' bgcolor='#006699'>";
		echo "<div align=center><strong><font color=#FFFFFF size=3 face=Arial, Helvetica, sans-serif> ";
		echo "ELIJA  EL TIPO DE IMPRESION QUE DESEA</font></strong></div>";
		echo "</td></tr></table>";
		echo "<TABLE >";
		echo "<TR>";
		echo "<TD><center>";
		echo " <FORM >";
		if ($uno == "1")
		echo "<INPUT  type=radio value=1 name='uno' checked><font size='2' face='Verdana, arial'>General&nbsp;&nbsp;</font>";
		else
		echo "<INPUT  type=radio value=1 name='uno'><font size='2' face='Verdana, arial'>General&nbsp;&nbsp;</font>";
		if ($uno == "2")
		echo "<INPUT  type=radio value=2 name='uno' checked><font size='2' face='Verdana, arial'>Por Fecha &nbsp;&nbsp;</font>";
		else
		echo "<INPUT  type=radio value=2 name='uno'><font size='2' face='Verdana, arial'>Por Fecha &nbsp;&nbsp;</font> ";
		echo " <input type=submit value='ELEGIR OPCION' name='enviar'>";
		echo " </FORM></center>";
		echo "</TD></tr></table>";	
	
	if ( $uno == "1")
	{	//echo "";
		echo "<FORM name='form2'><table border=1 width='450' height='60' ><tr><td align='center'>";
		echo " <font size='2' face='Verdana, arial'>Agrupar por:</font>";
		echo "<select name= 'menu' id='menu'>";		
		echo "<option value='TODO'>General</option>"; 
		echo "<option value='Computadores de Escritorio'>Computadoras de Escritorio </option>"; 
		echo "<option value='Computadores Portatiles'>Computadoras Portatiles </option>"; 
		echo "<option value='Servidores'>Servidores</option>"; 
		echo "<option value='Otros'>Otros</option>"; 	       
		echo "</select>	";
		echo "<input type='button' value='   Ver  ' name='enviar' onClick='OpenPrint()'></center>";
		echo "</FORM>";
		?>	
		<script language="JavaScript">
		function OpenPrint () {
			var form=document.form2;
			window.open ( "ver_fichatecnica2.php?menu=" + form.menu.value + "");
			return false;	
		}
	    </script>		
		<?php
		echo "</td></tr></table>";	
	}
	if ( $uno == "2" )
	{	?>
	<FORM name="form1"  action="orden_estadistica2.php"  method="post">
	<table width="95%" border="1" align=center height="70"><tr><td>
	<center> <font size=2 face=verdana,arial>Por Fecha&nbsp;</font>
	
Del: 
<select name="DA" id="select">
  <?php		  		
				$fsist=date("Y-m-d");				
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);
				echo "dia".$dia;
					for($i=1;$i<=31;$i++)
					{	if ( isset ($DA) )						
		                {echo "<option value=\"$i\""; if($DA=="$i") echo "selected"; echo">$i</option>";}
						else
						{echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
					}
				?>
</select>
<select name="MA" id="select9">
                <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) )
    	            {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else
					{echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
              </select>
        <select name="AA" id="select6">
          <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($AA) )
        	        {echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
					else
					{echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
        </select> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
        <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong> 
        &nbsp;&nbsp;
              Al:<select name="DE" id="select7">
                <?php
				$fsist=date("Y-m-d");
				
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);				

				for($i=1;$i<=31;$i++)
				{	if (isset($DE))
	                {echo "<option value=\"$i\""; if($DE=="$i") echo "selected"; echo">$i</option>";}
					else
					{echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
              </select>
        <select name="ME" id="select2">
          <?php
				for($i=1;$i<=12;$i++)
				{	if (isset($ME))
    	            {echo "<option value=\"$i\""; if($ME=="$i") echo "selected"; echo">$i</option>";}
					else
					{echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
        </select>
        <select name="AE" id="select4">
          <?php
				for($i=2003;$i<=2020;$i++)
				{	
					if (isset($AE))
					{echo "<option value=\"$i\""; if( $AE=="$i" ) echo "selected"; echo">$i</option>";}
					else
        	        {echo "<option value=\"$i\""; if( $ano=="$i" ) echo "selected"; echo">$i</option>";}
				}
				?>
        </select>
        <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
        <a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong> 
		<input type="submit" value="  Ver  " name="enviar2" id="enviar2"  <?php=$valid->onSubmit()?>>
		</center>
		</td></tr></table>
		</FORM>
		<script language="JavaScript">
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
		
		function OpenPrint7 () {	
			var form = document.form1;
			window.open ( "ver_fichatecnica3.php?DA=" + form.DA.value + "&MA=" + form.MA.value + "&AA=" + form.AA.value + "&DE=" + form.DE.value + "&ME=" + form.ME.value + "&AE=" + form.AE.value + "");
			return false;	
		}
	    </script>					
		<?php
		echo "</td></tr></table>";	
	}	
}
else{
?>
<table align="center" width="100%"><tr>  <td colspan="4" bgcolor="#006699">                      
<div align="center"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"> 
ELIJA  EL TIPO DE IMPRESION QUE DESEA</font></strong></div>          
</td></tr></table>
  <TABLE >
    <TR>
      <TD align='center'>
		<center>
      	<FORM name="form3">		   	
		   <INPUT  type=radio value='1' name=uno checked> <font size='2' face='Verdana, arial'>General &nbsp;&nbsp;</font>  	   	  
		   <INPUT  type=radio value='2' name=uno> <font size='2' face='Verdana, arial'>Por Fecha &nbsp;&nbsp; </font>
           <input type=submit value="ELEGIR OPCION" name="enviar">
       	</FORM></center>
    </TD>
  </TR>
</TABLE>
<?php 
}
?>

</CENTER>
</body>
</html>
