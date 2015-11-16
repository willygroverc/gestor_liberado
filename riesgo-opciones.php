<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		12/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

require_once("funciones.php");
//if (valida("Riesgo")=="bad") {header("location: pagina_error.php");}
if (isset($_REQUEST['RETORNAR'])){header("location: menu_parametros.php?Naveg=Seguridad >> Menu Parametros");}
include ("top.php");
?>
<form action="" method="get" name="form1">
  <table width="100%" border="0" align="center">
    <tr> 
      <td width="50%" height="75"> 
        <?php 
	$sql_n = "SELECT count(*) AS numriesgo FROM riesgo_tipos";
	$result_n = mysql_query($sql_n);
	$row_n=mysql_fetch_array($result_n);
?>
        <input name="BUSCAR" type="hidden" value="<?php echo @$BUSCAR;?>">
		<input name="menu" type="hidden" value="<?php echo @$menu;?>">
		<input name="busc" type="hidden" value="<?php echo @$busc;?>">
		<input name="pg" type="hidden" id="pg" value="<?php echo @$pg?>">
		<input name="idproc" type="hidden" id="idproc" value="<?php echo $_REQUEST['idproc']?>">
        <TABLE WIDTH="100%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">
          <TR bgcolor="#006699" align="center" valign="middle"> 
            <td colspan="<?php echo $row_n['numriesgo']?>" class="menu" background="images/main-button-tileR11.jpg" height="35">DEFINICION</td>
          </TR>
             <?php
			$sql3 = "SELECT * FROM riesgo_tipos";
			
			$result3 = mysql_query($sql3);
			$b=0;
			while($row3=mysql_fetch_array($result3)) {
				if($b%5==0) echo "<TR bgcolor=\"#006699\" align=\"center\" valign=\"middle\">";
				$nombre=strtoupper($row3['descripcion']);	
				echo '<td width="9%"><a class="menu" href="riesgo-preguntas.php?tipo_riesgo='.@$row3['id_riesgo'].'&idproc='.@$idproc.'&pg='.@$pg.'&BUSCAR='.@$BUSCAR.'&menu='.@$menu.'&busc='.@$busc.'">'.@$nombre.'</a></td>';
				$b++;
            }?>
        </TABLE></td>
      <td width="20%" valign="top"><TABLE WIDTH="100%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">
          <TR bgcolor="#006699" align="center" valign="middle"> 
            <td colspan="2" class="menu" background="images/main-button-tileR11.jpg" height="35">EJERCICIO</td>
          </TR>
          <TR bgcolor="#006699" align="center" valign="middle"> 
            <td width="41%"><a class="menu" href="riesgo-tablas.php?op=T&idproc=<?php echo @$idproc;?>&pg=<?php echo @$pg."&BUSCAR=".@$BUSCAR."&menu=".@$menu."&busc=".@$busc;?>">TABLAS</a></td>
            <td width="59%"><a class="menu" href="riesgo-ejercicio.php?idproc=<?php echo @$idproc;?>&pg=<?php echo @$pg."&BUSCAR=".@$BUSCAR."&menu=".@$menu."&busc=".@$busc;?>">MATRIZ 
              &nbsp;&nbsp; DELPHI</a></td>
          </TR>
        </TABLE></td>
      <td width="20%" valign="top"><TABLE WIDTH="100%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">
          <TR bgcolor="#006699" align="center" valign="middle"> 
            <td colspan="2" class="menu" background="images/main-button-tileR11.jpg" height="35">RESULTADOS</td>
          </TR>
          <TR bgcolor="#006699" align="center" valign="middle"> 
            <td width="39%"><a class="menu" href="riesgo-resultados1.php?idproc=<?php echo @$idproc;?>&pg=<?php echo @$pg."&BUSCAR=".@$BUSCAR."&menu=".@$menu."&busc=".@$busc;?>">TABLAS</a></td>
            <td width="61%"><a class="menu" href="riesgo-resultados.php?idproc=<?php echo @$idproc;?>&pg=<?php echo @$pg."&BUSCAR=".@$BUSCAR."&menu=".@$menu."&busc=".@$busc;?>">MATRIZ 
              &nbsp;&nbsp; DELPHI</a></td>
          </TR>
        </TABLE></td>
      <td width="10%" valign="top"><TABLE WIDTH="100%"  BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">
           <TR bgcolor="#006699" align="center" valign="middle"> 
            <td width="16%" background="images/main-button-tileR11.jpg" height="35"><a class="menu" href="lista_alarmas.php?idproc=<?php echo @$idproc;?>&pg=<?php echo @$pg."&BUSCAR=".@$BUSCAR."&menu=".@$menu."&busc=".@$busc;?>">ALARMAS</a></td>
          </TR>		  
        </TABLE></td>
    </tr>
  </table>
  <br><?php if(isset($idproc)){?>
    	<input name="RETORNAR" type="button" onClick="volver('<?php echo @$idproc?>','<?php echo @$pg?>')" value="RETORNAR">
	<?php }?>
</form>

<script language="JavaScript">
<!--
function volver(id_proceso,pg){
	history.back(1);
}
-->
</script>