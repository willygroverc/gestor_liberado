<?php
// Version: 	2.0
// Objetivo: 	Cambio de la estructura de registro, reduccion de tiempo en procesamiento de datos.
//				Control Acceso Directo a Fichero No Autorizado.
//				Limpieza de registro de datos.
// Fecha: 		02/SEP/2012
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
header('Content-Type: text/html; charset=ISO-8859-1');
require_once('xajax/xajax.inc.php'); //incluimos la librelia xajax
$idplanpru=$varia2;
$OrdAyuda=$varia1;
function eliminarFila($id_campo, $cant_campos){
	$respuesta = new xajaxResponse();
	$respuesta->addRemove("rowDetalle_$id_campo"); //borro el detalle que indica el parametro id_campo
	-- $cant_campos; //Resto uno al numero de campos y si es cero borro todo
	if($cant_campos == 0){
		$respuesta->addRemove("rowDetalle_0");
		$respuesta->addAssign("num_campos", "value", "0"); //dejo en cero la cantidad de campos para seguir agregando si asi lo desea el usuario
		$respuesta->addAssign("cant_campos", "value", "0");
	}
    $respuesta->addAssign("cant_campos", "value", $cant_campos);    
	return $respuesta;
}

function cancelar(){ 
    
    $respuesta = new xajaxResponse();
	$respuesta->addAssign("cant_campos", "value", "0");
    return $respuesta;
}

function agregarFila($formulario){
    $respuesta = new xajaxResponse();    
	extract($formulario);	
	$id_campos = $cant_campos = $num_campos+1;
	require_once('funciones.php');
	
	$comentresp=_clean($comentresp);
	$nombresp=_clean($nombresp);
	$idplanpru=_clean($idplanpru);
	
	$comentresp=SanitizeString($comentresp);
	$nombresp=SanitizeString($nombresp);
	$idplanpru=SanitizeString($idplanpru);
	
	$str_html_td1 = $comentresp . '<input type="hidden" id="hdncomentresp' . $id_campos . '" name="hdncomentresp' . $id_campos . '" value="' . $comentresp . '"/>' ;
    $str_html_td2 = "$nombresp" . '<input type="hidden" id="hdnnombresp' . $id_campos . '" name="hdnnombresp' . $id_campos . '" value="' . $nombresp . '"/>' ;
    $str_html_td3 = '<img src="images/delete.png" width="16" height="16" alt="Eliminar" onclick="if(confirm(\'Realmente desea eliminar este detalle?\')){xajax_eliminarFila('. $id_campos .', proyecto.cant_campos.value);}"/>';
    $str_html_td3 .= '<input type="hidden" id="hdnIdCampos_'. $id_campos .'" name="hdnIdCampos[]" value="'. $id_campos .'" />';
	$str_html_td3 .= '<input type="hidden" id="hdnidplanpru' . $id_campos . '" name="hdnidplanpru' . $id_campos . '" value="' . $idplanpru . '"/>';
	

	if($num_campos == 0){ // creamos un encabezado de lo contrario solo agragamos la fila
		$respuesta->addCreate("tbDetalle", "tr", "rowDetalle_0");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_01");    //creamos los campos
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_02");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_03");

        $respuesta->addAssign("tdDetalle_01", "innerHTML", "NOMBRE");   //asignamos el contenido
        $respuesta->addAssign("tdDetalle_02", "innerHTML", "COMENTARIOS");
        $respuesta->addAssign("tdDetalle_03", "innerHTML", "Eliminar");
	}
    $idRow = "rowDetalle_$id_campos";
    $idTd = "tdDetalle_$id_campos";
	$respuesta->addCreate("tbDetalle", "tr", $idRow);
    $respuesta->addCreate($idRow, "td", $idTd."1");     
    $respuesta->addCreate($idRow, "td", $idTd."2");
    $respuesta->addCreate($idRow, "td", $idTd."3");
/*
 *     Esta parte podria estar dentro de algun ciclo iterativo  */
    
    $respuesta->addAssign($idTd."1", "innerHTML", $str_html_td1);  
	$respuesta->addAssign($idTd."1", "align", "center");
    $respuesta->addAssign($idTd."2", "innerHTML", $str_html_td2);
	$respuesta->addAssign($idTd."2", "align", "center");
    $respuesta->addAssign($idTd."3", "innerHTML", $str_html_td3);
	$respuesta->addAssign($idTd."3", "align", "center");

/*  aumentamos el contador de campos  */

	$respuesta->addAssign("num_campos","value", $id_campos);
	$respuesta->addAssign("cant_campos" ,"value", $id_campos); 
	return $respuesta;
}
function guardar($formulario){
	$flag = 0;
    extract($formulario);
    $respuesta = new xajaxResponse();
	include("conexion.php");
    foreach($hdnIdCampos as $id){  
	$sqlin = "INSERT INTO resprelac (idplanpru,nombresp,comentresp)
                        VALUES('" . $formulario['hdnidplanpru' . $id] . "', '" . $formulario['hdnnombresp' . $id] . "', '" . $formulario['hdncomentresp' . $id] . "')";   
		if(mysql_query($sqlin))
		{	$flag=1;	}
    }
	if($flag==1)	{
		$MSG="Datos registrados...";
		$respuesta->addAlert($MSG);
	} else {
		$MSG="No se han registrados los datos";
		$respuesta->addAlert($MSG);
	}  
	$respuesta->redirect('lista_planifpru1.php', 0);
    return $respuesta;
}
function retornar($formulario){
	$respuesta = new xajaxResponse();
	//$respuesta->alert('¡Correcto!');
	$respuesta->redirect('lista_sistemas.php', 0);
    return $respuesta;
}
$xajax=new xajax();         // Crea un nuevo objeto xajax
$xajax->setCharEncoding('ISO-8859-1');
$xajax->setFlag("decodeUTF8Input",true);         
$xajax->registerFunction("agregarFila"); 
$xajax->registerFunction("cancelar");
$xajax->registerFunction("eliminarFila");
$xajax->registerFunction("guardar");
$xajax->registerFunction("retornar");
$xajax->processRequests();
?>

<html>
<meta http-equiv="Pragma"content="no-cache">
<meta http-equiv="expires"content="0">
<head>
<?php $xajax->printJavascript("xajax"); require_once('top.php'); ?>
<link href="CSS/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="proyecto" id="proyecto" action="" method="post">
    <input type="hidden" id="num_campos" name="num_campos" value="0" />
    <input type="hidden" id="cant_campos" name="cant_campos" value="0" />
<div id="cont" class="container">
	<div class="top">
<table width="75%" height="27" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
  <tr>
    <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Responsables 
        Relacionados - PLANIFICACION</strong></font></div></td>
  </tr>
</table>
<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr>
    <td height="70"> 
      <form name="form1" method="post" action="resprelac.php">
	<table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
	<input name="var" type="hidden" value="<?php echo $OrdAyuda;?>">
	<input name="idplanpru" type="hidden" value="<?php echo $idplanpru;?>">
         
            <td height="21" bgcolor="#006699"> <div align="center"><strong></strong></div>
              <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre 
                Responsable </font></strong></div></td>
            <td width="64%" bgcolor="#006699"><div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Comentarios</font></strong></div></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td> <div align="center">
                <select name="nombresp" id="nombresp">
                  <option value="0"></option>
                  <?php 
			  require("conexion.php");
			  $sql1 = "SELECT * FROM users WHERE tipo2_usr='T' OR tipo2_usr='C' ORDER BY apa_usr ASC";
			  $result1 = mysql_query($sql1);
			  while ($row1 = mysql_fetch_array($result1)){
					echo '<option value="'.$row1['login_usr'].'">'.$row1['apa_usr'].' '.$row1['ama_usr'].' '.$row1['nom_usr'].'</option>';
	           }
			   ?>
                </select>
              </div></td>
            <td align="center"><textarea name="comentresp" id="comentresp" cols="60"></textarea></td>
          </tr>
        </table>
      </form>
     
    </td>
  </tr>
</table>
	</div>
	</br>
<div class="button_div">    
    <input type="reset" id="btnCancel" name="btnCancel" value="LIMPIAR DATOS" class="buttons_CANCEL" onclick="xajax_cancelar();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" id="btnAgregar" name="btnAgregar" value="INSERTAR" class="buttons_aplicar" onclick="xajax_agregarFila(xajax.getFormValues('proyecto'));" />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" id="btnAgregar" name="btnAgregar" value="GUARDAR TODO" class="buttons_OK" onclick="xajax_guardar(xajax.getFormValues('proyecto'));" />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" id="btnRetornar" name="btnRetornar" value="RETORNAR" class="buttons_OK" onclick="xajax_retornar(xajax.getFormValues('proyecto'));" />
	</div>
    <div class="clear"></div>
    <div id="form3" class="form-horiz">
	</br>
        <table border="1" width="90%" id="tblDetalle" class="tbl2" background="images/fondo.jpg"><tbody id="tbDetalle"></tbody></table>
    </div>
</div>
</form>
<?php	include('top_.php');	?>
</body>
</html>