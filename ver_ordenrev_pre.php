<?php 
include ("conexion.php");
if(isset($impre1))
{
	if($menu=="GENERAL"){$campos="";}
	else
	{
		$campos="";
		$num=count($nombre);
		for ($i=0;$i<$num;$i++)
		{	if($i==$num-1){$campos=$campos.$nombre[$i];}
			else {$campos=$campos.$nombre[$i]."*";}
		}
	}
?>
	<script language="JavaScript" type="text/JavaScript">
	<!--
		var menu="<?php echo $menu?>";
		var campo="<?php echo $campos?>";
		window.open ("ver_ordenrev2.php?menu="+menu+"&campos="+campo, "Limberg");
		close();		
	-->
	</script>

<?php
}

if(isset($impre2))
{
	if($menu=="GENERAL"){$campos="";}
	else
	{
		$campos="";
		$num=count($nombre);
		for ($i=0;$i<$num;$i++)
		{	if($i==$num-1){$campos=$campos.$nombre[$i];}
			else {$campos=$campos.$nombre[$i]."*";}
		}
	}
?>
	<script language="JavaScript" type="text/JavaScript">
	<!--
		var menu="<?php echo $menu?>";
		var campo="<?php echo $campos?>";
		var DA="<?php echo $DA?>";
		var MA="<?php echo $MA?>";
		var AA="<?php echo $AA?>";
		var DE="<?php echo $DE?>";
		var ME="<?php echo $ME?>";
		var AE="<?php echo $AE?>";
		window.open ("ver_ordenrev2.php?menu=" + menu + "&campos=" + campo + "&DA=" + DA + "&MA=" + MA + "&AA=" + AA + "&DE=" + DE + "&ME=" + ME + "&AE=" + AE, "Limberg");
		close();		
	-->
	</script>

<?php
}
?>
<script lenguaje="javascript" type="text/javascript">
function irapagina(pagina)
{         
 		 if (pagina!="") 
		 {
     	 	self.location = pagina;
 		 }
}
function cambio(numero)
{        
		 if (!foco_texto)
		 {
				 irapagina("ver_ordenrev_pre.php?op="+numero);
		 } 
}
function cambio2(numero2)
{        
		 var op2="<?php echo $op;?>";
		 if (!foco_texto)
		 {
				 irapagina("ver_ordenrev_pre.php?op="+op2+"&tip="+numero2);
		 } 
}
var foco_texto=false;
</script>
</head>
<title>GesTor F1 - Impresiones</title></head>
<body topmargin="0" >
<script language="JavaScript" src="calendar.js"></script>
<?php
if ( $op == "F"){ 
	require_once ( "ValidatorJs.php" );
	$valid = new Validator ( "form2" );
	$valid->addIsDate   ( "DA", "MA", "AA", "Fecha de Inicio, $errorMsgJs[date]" );
	$valid->addIsDate   ( "DE", "ME", "AE", "Fecha de Conclusion, $errorMsgJs[date]" );
	$valid->addCompareDates   ( "DA", "MA", "AA","DE", "ME", "AE", "Fecha Del y Fecha Al, $errorMsgJs[compareDates]");
	print $valid->toHtml ();
}
?>
<form name="form2" method="post" action="">
<table width="100%" border="0">
  <tr>
    <td height="235" valign="middle">
	<table background="images/fondo.jpg" width="100%"  align="center" border="1">
        <tr> 
          <td  bgcolor="#006699" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica"><b>PROBLEMAS 
            PRODUCCION - IMPRESION </b></font></td>
        </tr>
        <tr> 
          <td align="center"> <input type="radio" name="opcion" value="G" onClick="cambio(this.value)" <?php if ($op == G) print "checked"; else print "checked"; ?>> 
            <font face="Arial, Helvetica, sans-serif" size="2"><B>GENERAL</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="radio" name="opcion" value="F" onClick="cambio(this.value)" <?php if ($op == F) print "checked";  ?>> 
            <font face="Arial, Helvetica, sans-serif" size="2"><B>POR FECHAS</B></font> 
          </td>
        </tr>
        <tr>
           <input type="hidden" name="op" value=<?php echo $op;?>>
            <td height="50"> <table border="1">
                <tr>
                  <td> <table width="100%" border="0">
                      <tr> 
                        <td width="32"></td>
                        <td width="187"><font size="2" face="Arial, Helvetica"><B>Agrupar 
                          por:</B></font></td>
                        <td width="703"> <select name="menu" id="select" onChange="cambio2(this.options.selectedIndex)">
                            <option value="GENERAL" <?php if($tip=="0" OR !$tip){echo "selected";}?>>GENERAL</option>
                            <option value="POR_CAMPOS" <?php if($tip=="1"){echo "selected";}?>>POR 
                            CAMPOS</option>
                          </select> </td>
                      </tr>
                      <tr> 
                        <td width="32"></td>
                        <td width="187"><font size="2" face="Arial, Helvetica"><B>Campos:</B></font></td>
                        <td width="703"> <table width="100%" border="0">
                            <tr> 
                              <td width="39%"> 
                                <?php if($tip=="0" OR !$tip){?>
                                <select name="nombre" id="nombre">
                                  <option value="G">GENERAL</option>
                                </select> 
                                <?php }
				elseif($tip==="1"){?>
                                <select name="nombre[]" size="4" multiple style="width:250px">
                                  <option value="1" selected>Nro. Orden</option>
                                  <option value="2">Fecha y Hora de Envio</option>
                                  <option value="3">Descripcion Incidencia</option>
                                  <option value="4">Fecha Inicio</option>
                                  <option value="5">Fecha Fin</option>
                                  <option value="6">Responsable de Revision</option>
                                  <option value="7">Fecha - Revision</option>
                                  <option value="8">Responsable de Auditoria</option>
                                  <option value="9">Fecha - Auditoria</option>
								  <option value="10">Observaciones</option>
                                </select> <font size="1" face="Arial, Helvetica, sans-serif"><strong>Nota:</strong> 
                                Para marcar mas de un campo mantenga presionada 
                                la techa Ctrl(Control).</font> 
                                <?php }?>
                              </td>
                              <td width="61%" valign="bottom"> 
                                <?php if ($op != "F"){?>
                                <input name="impre1" type="submit" value="    VER    "> 
                                <?php }?>
                              </td>
                            </tr>
                          </table></td>
                      </tr>
                      <?php if ($op == "F"){?>
                      <tr> 
                        <td>&nbsp;</td>
                        <td colspan="2"><font face="Arial, Helvetica" size="2"><b>Del:</b></font>&nbsp; 
                          <select name="DA" id="select">
                            <?php		  		
				$fsist=date("Y-m-d");				
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);
				for($i=1;$i<=31;$i++)
				{	if ( isset ($DA) ){echo "<option value=\"$i\""; if($DA=="$i") echo "selected"; echo">$i</option>";}						
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
                          </select> <select name="MA" id="select9">
                            <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) )  {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else  {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
					}
				}
				?>
                          </select> <select name="AA" id="select6">
                            <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($AA) ) {echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
                          </select>
                          <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                          <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
                          </font> &nbsp;&nbsp;<font face="Arial, Helvetica" size="2"><b>Al:</b></font> 
                          <select name="DE" id="select7">
                            <?php
				$fsist=date("Y-m-d");
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);				
				for($i=1;$i<=31;$i++)
				{	if (isset($DE)) {echo "<option value=\"$i\""; if($DE=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
                          </select> <select name="ME" id="select2">
                            <?php
				for($i=1;$i<=12;$i++)
				{	if (isset($ME)) {echo "<option value=\"$i\""; if($ME=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
                          </select> <select name="AE" id="select4">
                            <?php
				for($i=2003;$i<=2020;$i++)
				{	if (isset($AE)) {echo "<option value=\"$i\""; if( $AE=="$i" ) echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if( $ano=="$i" ) echo "selected"; echo">$i</option>";}
				}
				?>
                          </select>
                          <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                          <a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
                          </font> &nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" value="    VER    " name="impre2" > 
                        </td>
                      </tr>
                      <script language="JavaScript">
			 var form="form2";
			 var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
				cal.year_scroll = true;
				cal.time_comp = false;
			var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
				cal1.year_scroll = true;
				cal1.time_comp = false;
				
			</script>
                      <?php }else{?>
                      <tr>
                        <td></td>
                      </tr>
                      <?php }?>
                    </table></td>
                </tr>
              </table></td>
        
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>