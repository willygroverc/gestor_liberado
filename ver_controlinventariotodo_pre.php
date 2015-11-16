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
include ("top_ver.php");
//$varia2= $_REQUEST['varia2'];
if(!isset($_REQUEST['varia2'])){$_REQUEST['varia2']="INF";}
?>
<html>
<head>
	<title>GesTor F1 - CONTINGENCIA-PROAPC - CALENDARIZACION</title>
	<style>
		select {FONT-SIZE: 8pt; Font-Family: Arial, Verdana;}
	</style>
</head>
<body topmargin="0">
<form action="ver_controlinventariotodo.php" method="POST" name="form1">
    <input name="varia2" type="hidden" value="<?php echo $_REQUEST['varia2'];?>">
  <table width="100%" border="1" align="center">
    <tr>
      <td>
	    <table width="100%" height="84" background="images/fondo.jpg">
          <tr> 
            <td height="18" colspan="4" align="center" bgcolor="#006699"> 
              <strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                Inventario de Medios, elija el tipo para generar el reporte 
			  </font></strong>
		     </td>
          </tr>
          <tr> 
             <td width="43%" align="right">
				<font size="2" face="Verdana, Helvetica, sans-serif">Agrupar por Tipo:</font> 
             </td>
             <td width="57%" align="left"> 
				 <select name="codigo_usu" onChange="tip_dat(this.value,'<?php if(isset($_REQUEST['varia3'])) echo $_REQUEST['varia3'];?>','<?php if(isset($_REQUEST['varia4'])) echo $_REQUEST['varia4'];?>')">
				 <option value="G" <?php if($_REQUEST['varia2']=="G"){echo "selected";}?>>TODO</option>
                  <option value="INF" <?php if($_REQUEST['varia2']=="INF"){echo "selected";}?>>INF</option>
                  <option value="FRL" <?php if($_REQUEST['varia2']=="FRL"){echo "selected";}?>>FRL</option>
                  <option value="SBF" <?php if($_REQUEST['varia2']=="SBF"){echo "selected";}?>>SBF</option>
                </select>
              &nbsp; 
              <select name="tipo_medio">
				  <option value="G">TODO</option>
                  <option value="CDL">CDL</option>
				  <option value="CDT">CDT</option>
                  <option value="DCD">DCD</option>
                  <option value="DVD">DVD</option>
                  <option value="DSK">DSK</option>
                  <option value="HDD">HDD</option>
                </select>
              &nbsp; 
              <select name="tipo_dato">
				  <option value="G">TODO</option>
                  <?php if($_REQUEST['varia2']=="INF" OR $_REQUEST['varia2']=="FRL"){?>
				  <option value="APP">APP</option>
				  <option value="BCK">BCK</option>
				  <option value="BIC">BIC</option>
				  <option value="DAT">DAT</option>
				  <option value="DRI">DRI</option>
				  <option value="OFI">OFI</option>
                  <option value="SOP">SOP</option>
                  <option value="VAR">VAR</option>
				  <?php }else{?>
			      <option value="CCR">CCR</option>
				  <option value="DAT">DAT</option>
				  <option value="EJC">EJC</option>
				  <option value="JUI">JUI</option>
                  <option value="PER">PER</option>
                  <option value="VAR">VAR</option>
				  <?php }?>
                </select>
				  <input name="IMPRE" type="button" value="   VER   " onClick="Mostrar()">
			  </td>               
          </tr>
         
        </table>
	  </td>
    </tr>
  </table>

</form>
<script language="JavaScript">
	function irapagina_c(pagina)
	{         
 		 if (pagina!="") {self.location = pagina;}
	}
	function tip_dat(co,med,dat)
	{        
		irapagina_c("ver_controlinventariotodo_pre.php?varia2="+co+"&varia3="+med+"&varia4="+dat); 
	}

	function Mostrar () 
	{
		window.open ("ver_controlinventariotodo.php?varia1="+form1.codigo_usu.value+"&varia2="+form1.tipo_medio.value+"&varia3="+form1.tipo_dato.value);
		close();
	}
-->
</script>
<center>
</center>
</body>
</html>