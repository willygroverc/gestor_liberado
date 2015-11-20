<?php
//ISRAEL
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require_once("funciones.php");
if (valida("PlanifEstrat")=="bad") {header("location: pagina_error.php");}
if (isset($_REQUEST['RETORNAR'])){
	echo "<script type=\"text/javascript\">
           history.go(-2);
       </script>";}
if (isset($_REQUEST['IMPRIMIR'])){header("location: ver_planife.php");}
if (isset($_REQUEST['NUEVO'])) {header("location: planif_estrategica.php"); }
include ("top.php"); 
include_once ("help.class.php");
$help=new Help();
$help->AddHelp("numo","Numero de Objetivos");
print $help->ToHtml();
?>
<table  width="70%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td valign="top"><table width="100%"  border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="6" background="windowsvista-assets1/main-button-tile.jpg" height="30px">PLANIFICACION ESTRATEGICA</th>
        </tr>
        <tr align=\"center\"> 
			
          <th width="22%" class="menu" background="windowsvista-assets1/main-button-tile.jpg" height="30px">TIPO DE PLANIFICACION </th>
		    
          <th width="16%" class="menu" background="windowsvista-assets1/main-button-tile.jpg" height="30px"><?php print $help->AddLink("numo", "Nro DE OBJETIVOS"); ?></th>
	  	    <th width="16%" class="menu" background="windowsvista-assets1/main-button-tile.jpg" height="30px">INSERTAR NUEVO OBJETIVO</th>
	  	    <th width="16%" class="menu" background="windowsvista-assets1/main-button-tile.jpg" height="30px">COSTO TOTAL ($us)</th>
          <?php if ($tipo=="A" or $tipo=="B") {?>
			<th width="10%" class="menu" background="windowsvista-assets1/main-button-tile.jpg" height="30px">MODIFICAR</th>
          <?php } ?>
			<th width="10%" class="menu" background="windowsvista-assets1/main-button-tile.jpg" height="30px">IMPRIMIR </th>
 	  
      </tr>
<?php
$tip="LARGO PLAZO";
for($i=1;$i<=3;$i++)
{
	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">$tip</td>";
	$sql = "SELECT * FROM planif_estrategica GROUP BY TipoPlanifica";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	
		$sql2="SELECT MAX(NumPlanif) AS numo FROM planif_estrategica WHERE TipoPlanifica='$tip'";
		$result2=mysql_query($sql2);
		$row2=mysql_fetch_array($result2);
		if ($row2['numo']==""){echo "<td><font size=\"1\">0</td>";}
		else
		{echo '<td><font size="1">'.$row2['numo'].'</td>';}
		echo '<td><font size="1"><a href="planif_estrategica.php?varia2='.$tip.'"><img src="images/nuevo.gif" border="0" alt="Nuevo"></a></font></td>';
		//costo total
		$sql0 = "SELECT costo FROM planif_estrategica WHERE TipoPlanifica='$tip'";
		$result0=mysql_query($sql0);
		$costo_ee=0;
		while($row0=mysql_fetch_array($result0)){
			$subcosto=array_sum(explode("|",$row0['costo']));
			$costo_ee+=$subcosto;
		}
		echo "<td><font size=\"1\">&nbsp;$costo_ee</td>";
		//
		if ($tipo=="A" or $tipo=="B")
		{echo "<td><font size=\"1\"><a href=\"planif_estrategica_last.php?varia2=$tip\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";}
		echo "<td><font size=\"1\"><a href=\"ver_planife.php?variable1=$tip\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
		echo "</tr>";
		if ($i=="1"){$tip="MEDIANO PLAZO";}
		if($i=="2"){$tip="CORTO PLAZO";}	
}	
?>
      </table></td>
  </tr>
</table><br>
<form name="form1" method="post" action="">
  <div align="center"> 
    <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
   
  </div>
</form>