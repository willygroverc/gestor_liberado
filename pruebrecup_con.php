<?php
// Version: 	1.0
// Objetivo: 	Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
if ($SALIR){header("location: lista_pruebrecup.php");}
if ($RESINT){header("location: pruebrecup1_con.php?id_pru=$id_pru");}
if ($RESEXT){header("location: pruebrecup2_con.php?id_pru=$id_pru");}
if ($HDWREQ){header("location: pruebrecup3_con.php?id_pru=$id_pru");}
if ($INSBD){header("location: pruebrecup4_con.php?id_pru=$id_pru");}
if ($INSSB){header("location: pruebrecup5_con.php?id_pru=$id_pru");}
if ($INSAPLI){header("location: pruebrecup6_con.php?id_pru=$id_pru");}
if ($RESTBD){header("location: pruebrecup7_con.php?id_pru=$id_pru");}
if ($PRUINT){header("location: pruebrecup8_con.php?id_pru=$id_pru");}
if ($PRUURS){header("location: pruebrecup9_con.php?id_pru=$id_pru");}
include ("top.php");
include("conexion.php");
include("DbTools.class.php");
include("PruebasRecuperacion.class.php");
include ("validator.php");

$prueba = new PruebasRecuperacion($cn, $db);
$list = new DbTools($cn, $db);
// obtener los valores de las variables
$listSistema = $list -> GetTable1(2);
$listUsuario = $list -> GetTable2("TC");
// edicion del registro
if ($action == "edit") {
	$record[ord_ayu]=$ord_ayu;
    $tmp = $prueba -> GetMaster($record);
//	print_r ($tmp);
    $recordDb = $tmp[0];
	//print_r ($recordDb);
} else unset($recordDb); 

	$record[ord_ayu]=$ord_ayu;
	$chkord_ayu=$prueba->ChkMaster($record);
	$listPrueba=$recordDb;
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

<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#EAEAEA" background="images/fondo.jpg">   
   	<form name="form1" method="get" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
	 <input name="id_pru" type="hidden" value="<?php echo $id_pru;?>"> 
     <input name="ord_ayu" type="hidden" value="<?php echo $ord_ayu;?>">
  <table width="100%" border="2" align="center" background="./images/fondo.jpg">
    <tr> 
      <td colspan="6" bgcolor="#006699"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong><font size="3">PRUEBAS 
          DE RECUPERACION</font></strong></font></div></td>
    </tr>
    <tr> 
      <td width="6%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&deg; 
          Orden</font></div></td>
      <td width="26%" bgcolor="#006699"> <div align="center"></div>
        <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha</font></div></td>
      <td width="13%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Recurso 
          Probado </font></div></td>
      <td width="11%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Sitio 
          de Contingencia</font></div></td>
     
      <td width="20%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre 
          del Evaluador</font></div></td>
    </tr>
    <tr align="center"> 
      <td nowrap><?php echo $listPrueba[0][ord_ayu]?> <div align="center"></div></td>
      <?php
	  $aux = $listPrueba[fecpru];
	  $mez = substr ($aux, 5, 2);
	  $dia = substr ($aux, 8, 2);
	  $ano = substr ($aux, 0, 4);
	  $fecha = $dia."/".$mez."/".$ano;
	  //$listPrueba[fecpru]
	  ?>
      <td nowrap height="48"><div align="center">&nbsp;<?php echo $fecha;//here?></div></td>
      <td nowrap height="48"><div align="center">&nbsp;<?php echo $listPrueba[serpro];?></div></td>
      <td nowrap><div align="center">&nbsp;<?php echo $listPrueba[sitconti]?></div></td>
      
      <td nowrap><div align="center">&nbsp;<?php echo $listUsuario[$listPrueba[nomeval]]?></div></td>
    </tr>
    <?php if (!$chkord_ayu) { ?>
    <?php } ?>
  </table>
    
  <p align="center">&nbsp;</p>
  </form>
<?php if ($chkord_ayu) { ?>
<form name="form2" method="get" action="">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr bgcolor="#006699"> 
      <td colspan="3" width ="100"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"></font></div></td>
    </tr>
    <tr> 
      <td width="30%" align="center"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>1.-</strong></font> 
          <input name="RESINT" type="submit" id="RESINT" value="Responsables Internos" >
        </div></td>
      <td width="30%" align="center"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">2.-</font></strong> 
          <input name="RESEXT" type="submit" id="RESEXT" value="Responsables Externos">
        </div></td>
      <td width="30%" align="center"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>3.-</strong></font> 
          <input name="HDWREQ" type="submit" id="HDWREQ" value="Hardware Requerido">
        </div></td>
    </tr>
    <tr> 
      <td align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>4.-</strong></font>
<input name="INSBD" type="submit" id="INSBD2" value="Instaladores y Bases de Datos"></td>
      <td align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">5.-</font></strong>
<input name="INSSB" type="submit" id="INSSB" value="Instalacion de Software Base"></td>
      <td align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">6.-</font></strong>
<input name="INSAPLI" type="submit" id="INSAPLI" value="Instalacion de Aplicaciones"></td>
    </tr>
    <tr> 
      <td align="center"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>7.-</strong></font> 
          <input name="RESTBD" type="submit" id="RESTBD2" value="Restauracion de BD">
        </div></td>
      <td> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">8.-</font></strong> 
          <input name="PRUINT" type="submit" id="PRUINT2" value="Pruebas Internas">
        </div></td>
      <td> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">9.-</font></strong> 
          <input name="PRUURS" type="submit" id="PRUURS" value="Pruebas de Usuario">
		  <input name="id_pru" type="hidden" id="id_pru" value="<?php print $id_pru; ?>"> 
        </div></td>
    </tr>
<tr><td colspan="3"><br><div align="center"><input name="SALIR" type="submit" id="SALIR" value="  RETORNAR  "></div></td></tr>
  </table>
</form>
<p>&nbsp;</p>
<p>   <?php } ?><br> 
</p>
<?php include("top_.php");
//print "id_pru".$_SESSION["id_pruInsert"];
?>