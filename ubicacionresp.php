<?php
// Version: 	2.0
// Objetivo: 	Cambio de la estructura de registro, reduccion de tiempo en procesamiento de datos.
//				Control Acceso Directo a Fichero No Autorizado.
//				Limpieza de registro de datos.
// Fecha: 		03/SEP/2012
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
require_once('xajax/xajax.inc.php'); 
require_once('funciones.php');
function eliminarFila($id_campo, $cant_campos){
	$respuesta = new xajaxResponse();
	$respuesta->addRemove("rowDetalle_$id_campo"); 
	-- $cant_campos;
	if($cant_campos == 0){
		$respuesta->addRemove("rowDetalle_0");
		$respuesta->addAssign("num_campos", "value", "0"); 
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
	if(empty($formulario['codigo'])) {
		$respuesta->addAlert('El campo "CODIGO" es obligatorio');
		return $respuesta;
	}
	if(empty($formulario['fecha_ubica'])) {
		$respuesta->addAlert('El campo "FECHA" es obligatorio');
		return $respuesta;
	}
	if(empty($formulario['contenido'])) {
		$respuesta->addAlert('El campo "CONTENIDO" es obligatorio');
		return $respuesta;
	}
	if(empty($formulario['observ'])) {
		$respuesta->addAlert('El campo "OBSERVACIONES" es obligatorio');
		return $respuesta;
	}
	$codigo=_clean($codigo);
	$fecha_ubica=_clean($fecha_ubica);
	$contenido=_clean($contenido);
	$observ=_clean($observ);
	
	$codigo=SanitizeString($codigo);
	$fecha_ubica=SanitizeString($fecha_ubica);
	$contenido=SanitizeString($contenido);
	$observ=SanitizeString($observ);
	$str_html_td1 = $codigo . '<input type="hidden" id="hdncodigo_' . $id_campos . '" name="hdncodigo_' . $id_campos . '" value="' . $codigo . '"/>' ;
	$str_html_td2 = "$fecha_ubica" . '<input type="hidden" id="hdnfecha_ubica_' . $id_campos . '" name="hdnfecha_ubica_' . $id_campos . '" value="' . $fecha_ubica . '"/>' ;
	$str_html_td3 = "$contenido" . '<input type="hidden" id="hdncontenido_' . $id_campos . '" name="hdncontenido_' . $id_campos . '" value="' . $contenido . '"/>' ;
	$str_html_td4 = "$observ" . '<input type="hidden" id="hdnobserv_' . $id_campos . '" name="hdnobserv_' . $id_campos . '" value="' . $observ . '"/>' ;
	
	if (isset($Sistema))
	{	$Sistema="<inut type=\"hidden\" name=\"Sistema\" id=\"Sistema\" value=\"1\">";
		$str_html_td5 = '<img src="images/si1.png" width="16" height="16" alt="Si" />';
		$str_html_td5 .= "$Sistema" . '<input type="hidden" id="hdnSistema_' . $id_campos . '" name="hdnSistema_' . $id_campos . '" value="1"/>' ;}
	else
	{	$Sistema="<inut type=\"hidden\" name=\"Sistema\" id=\"Sistema\" value=\"0\">";
		$str_html_td5 = '<img src="images/no1.png" width="16" height="16" alt="No" />';	 
		$str_html_td5 .= "$Sistema" . '<input type="hidden" id="hdnSistema_' . $id_campos . '" name="hdnSistema_' . $id_campos . '" value="0"/>' ;}
	
	if (isset($Negocio))
	{	$Negocio="<inut type=\"hidden\" name=\"Negocio\" id=\"Negocio\" value=\"1\">";
		$str_html_td6 = '<img src="images/si1.png" width="16" height="16" alt="Si" />';
		$str_html_td6 .= "$Negocio" . '<input type="hidden" id="hdnNegocio_' . $id_campos . '" name="hdnNegocio_' . $id_campos . '" value="1"/>' ;}
	else
	{	$Negocio="<inut type=\"hidden\" name=\"Negocio\" id=\"Negocio\" value=\"0\">";
		$str_html_td6 = '<img src="images/no1.png" width="16" height="16" alt="No" />';	 
		$str_html_td6 .= "$Negocio" . '<input type="hidden" id="hdnNegocio_' . $id_campos . '" name="hdnNegocio_' . $id_campos . '" value="0"/>' ;}
		
	if (isset($SE1))
	{	$SE1="<inut type=\"hidden\" name=\"SE1\" id=\"SE1\" value=\"1\">";
		$str_html_td7 = '<img src="images/si1.png" width="16" height="16" alt="Si" />';
		$str_html_td7 .= "$SE1" . '<input type="hidden" id="hdnSE1_' . $id_campos . '" name="hdnSE1_' . $id_campos . '" value="1"/>' ;}
	else
	{	$SE1="<inut type=\"hidden\" name=\"SE1\" id=\"SE1\" value=\"0\">";
		$str_html_td7 = '<img src="images/no1.png" width="16" height="16" alt="No" />';	 
		$str_html_td7 .= "$SE1" . '<input type="hidden" id="hdnSE1_' . $id_campos . '" name="hdnSE1_' . $id_campos . '" value="0"/>' ;}
		
	if (isset($SE2))
	{	$SE2="<inut type=\"hidden\" name=\"SE2\" id=\"SE2\" value=\"1\">";
		$str_html_td8 = '<img src="images/si1.png" width="16" height="16" alt="Si" />';
		$str_html_td8 .= "$SE2" . '<input type="hidden" id="hdnSE2_' . $id_campos . '" name="hdnSE2_' . $id_campos . '" value="1"/>' ;}
	else
	{	$SE2="<inut type=\"hidden\" name=\"SE2\" id=\"SE2\" value=\"0\">";
		$str_html_td8 = '<img src="images/no1.png" width="16" height="16" alt="No" />';	 
		$str_html_td8 .= "$SE2" . '<input type="hidden" id="hdnSE2_' . $id_campos . '" name="hdnSE2_' . $id_campos . '" value="0"/>' ;}
	
	$str_html_td9 = '<img src="images/delete.png" width="16" height="16" alt="Eliminar" onclick="if(confirm(\'Realmente desea eliminar este detalle?\')){xajax_eliminarFila('. $id_campos .', proyecto.cant_campos.value);}"/>';
	$str_html_td9 .= '<input type="hidden" id="hdnIdCampos_'. $id_campos .'" name="hdnIdCampos[]" value="'. $id_campos .'" />';
	if($num_campos == 0){ 
		$respuesta->addCreate("tbDetalle", "tr", "rowDetalle_0");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_01");  
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_02");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_03");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_04");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_05");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_06");
		$respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_07");
		$respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_08");
		$respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_09");

        $respuesta->addAssign("tdDetalle_01", "innerHTML", "Codigos");   
        $respuesta->addAssign("tdDetalle_02", "innerHTML", "Tipo");
        $respuesta->addAssign("tdDetalle_03", "innerHTML", "Fecha");
        $respuesta->addAssign("tdDetalle_04", "innerHTML", "Contenido");
        $respuesta->addAssign("tdDetalle_05", "innerHTML", "Sistema");
        $respuesta->addAssign("tdDetalle_06", "innerHTML", "Negocio");
		$respuesta->addAssign("tdDetalle_07", "innerHTML", "SE1");
		$respuesta->addAssign("tdDetalle_08", "innerHTML", "SE2");
		$respuesta->addAssign("tdDetalle_09", "innerHTML", "Eliminar");
	}
    $idRow = "rowDetalle_$id_campos";
    $idTd = "tdDetalle_$id_campos";
	$respuesta->addCreate("tbDetalle", "tr", $idRow);
    $respuesta->addCreate($idRow, "td", $idTd."1");  
    $respuesta->addCreate($idRow, "td", $idTd."2");
    $respuesta->addCreate($idRow, "td", $idTd."3");
    $respuesta->addCreate($idRow, "td", $idTd."4");
    $respuesta->addCreate($idRow, "td", $idTd."5");
    $respuesta->addCreate($idRow, "td", $idTd."6");
	$respuesta->addCreate($idRow, "td", $idTd."7");
	$respuesta->addCreate($idRow, "td", $idTd."8");
	$respuesta->addCreate($idRow, "td", $idTd."9");
	
    $respuesta->addAssign($idTd."1", "innerHTML", $str_html_td1);  
	$respuesta->addAssign($idTd."1", "align", "center"); 
    $respuesta->addAssign($idTd."2", "innerHTML", $str_html_td2);
	$respuesta->addAssign($idTd."2", "align", "center");
    $respuesta->addAssign($idTd."3", "innerHTML", $str_html_td3);
	$respuesta->addAssign($idTd."3", "align", "center");
    $respuesta->addAssign($idTd."4", "innerHTML", $str_html_td4);
	$respuesta->addAssign($idTd."4", "align", "center");
    $respuesta->addAssign($idTd."5", "innerHTML", $str_html_td5);
	$respuesta->addAssign($idTd."5", "align", "center");
    $respuesta->addAssign($idTd."6", "innerHTML", $str_html_td6);
	$respuesta->addAssign($idTd."6", "align", "center");
	$respuesta->addAssign($idTd."7", "innerHTML", $str_html_td7);
	$respuesta->addAssign($idTd."7", "align", "center");
	$respuesta->addAssign($idTd."8", "innerHTML", $str_html_td8);
	$respuesta->addAssign($idTd."8", "align", "center");
	$respuesta->addAssign($idTd."9", "innerHTML", $str_html_td9);
	$respuesta->addAssign($idTd."9", "align", "center");

	$respuesta->addAssign("num_campos","value", $id_campos);
	$respuesta->addAssign("cant_campos" ,"value", $id_campos);    
	return $respuesta;
}
function guardar($formulario) {
	$flag=0;
	extract($formulario);
	$respuesta = new xajaxResponse();
	include("conexion.php");
    foreach($hdnIdCampos as $id){
	$formulario['hdncodigo_' . $id]=_clean($formulario['hdncodigo_' . $id]);
	$formulario['hdnfecha_ubica_' . $id]=_clean($formulario['hdnfecha_ubica_' . $id]);
	$formulario['hdncontenido_' . $id]=_clean($formulario['hdncontenido_' . $id]);
	$formulario['hdnSistema_' . $id]=_clean($formulario['hdnSistema_' . $id]);
	$formulario['hdnobserv_' . $id]=_clean($formulario['hdnobserv_' . $id]);
	
	$formulario['hdncodigo_' . $id]=SanitizeString($formulario['hdncodigo_' . $id]);
	$formulario['hdnfecha_ubica_' . $id]=SanitizeString($formulario['hdnfecha_ubica_' . $id]);
	$formulario['hdncontenido_' . $id]=SanitizeString($formulario['hdncontenido_' . $id]);
	$formulario['hdnSistema_' . $id]=SanitizeString($formulario['hdnSistema_' . $id]);
	$formulario['hdnobserv_' . $id]=_clean($formulario['hdnobserv_' . $id]);
	$sqlin = "INSERT INTO ubicacionresp (codigo,fecha,contenido,ubi_sistema,ubi_negocio,ubi_SE1,ubi_SE2,observ)
             VALUES('" . $formulario['hdncodigo_' . $id] . "', '" . $formulario['hdnfecha_ubica_' . $id] . "', '" . $formulario['hdncontenido_' . $id] . "',
                        '" . $formulario['hdnSistema_' . $id] . "', '" . $formulario['hdnNegocio_' . $id] . "', '" . $formulario['hdnSE1_' . $id] . "', '" . $formulario['hdnSE2_' . $id] . "', '" . $formulario['hdnobserv_' . $id] . "')";   
	
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
	$respuesta->redirect('lista_ubicacionr.php', 0);
    return $respuesta;
	
}
function retornar($formlario) {
	$respuesta = new xajaxResponse();
	$respuesta->redirect('lista_ubicacionr.php', 0);
    return $respuesta;
}
$xajax=new xajax();        
$xajax->setCharEncoding("iso-8859-1");
$xajax->decodeUTF8InputOn();         
$xajax->registerFunction("agregarFila"); 
$xajax->registerFunction("cancelar");
$xajax->registerFunction("guardar"); 
$xajax->registerFunction("retornar");
$xajax->registerFunction("eliminarFila");
$xajax->processRequests();
?>

<html>
<meta http-equiv="Pragma"content="no-cache">
<meta http-equiv="expires"content="0">
<head>
<?php $xajax->printJavascript("xajax"); include('top.php');?>
</head>
<body>
<form name="proyecto" id="proyecto" action="" method="post">
    <input type="hidden" id="num_campos" name="num_campos" value="0" />
    <input type="hidden" id="cant_campos" name="cant_campos" value="0" />
<div id="cont" class="container">
<div class="top">
<!-------------------------------------------------------------------------------------------------------------------------->
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onKeyPress="return Form()">
	<tr> 
      <td> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="9" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">UBICACION 
              DE RESPALDOS</font></th>
          </tr>
          <tr> 
            <th width="45" rowspan="2" nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Codigo</font></th>
            <th width="39" rowspan="2" nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tipo</font></th>
            <th width="140" rowspan="2" nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha</font></th>
            <th width="175" rowspan="2" nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Contenido</font></th>
            <th colspan="4" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Ubicacion</font></th>
            <th width="150" rowspan="2" nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Observaciones</font></th>
          </tr>
          <tr> 
            <th width="60" nowrap background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Sistema</font></div></th>
            <th width="60" nowrap background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Negocio 
                </font></div></th>
            <th width="60" nowrap background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SE1</font></div></th>
            <th width="60" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SE2</font></th>
          </tr>
          <tr> 
            <td colspan="9" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center">
                <input name="var" type="hidden" id="var" value="<?php echo $var?>">
              </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="2" nowrap>
              <select name="codigo" id="codigo">
                <option value="0"></option>
                <?php 
			  $sql = "SELECT * FROM controlinvent";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{if($row['FechaBaja']=="0000-00-00")
					{echo '<option value="'.$row['codigo_usu'].'">'.$row['codigo_usu'].'. '.$row['tipo_medio'].'</option>';}
	            }
			   ?>
              </select>
            </td>
			  
            <td nowrap height="7" align="center">
           
		   <input type="text" name="fecha_ubica" id="fecha_ubica" maxlength="10" value="<?php echo date('Y-m-d');	?>" />
			<td nowrap height="7"><div align="center"><strong> 
                <textarea name="contenido" id="contenido" cols="25"></textarea>
                </strong> </div></td>
            <td nowrap height="7" align="center"><strong>
              <input type="checkbox" name="Sistema" id="Sistema" value="1">
              </strong></td>
            <td nowrap height="7"> <div align="center"><strong>
                <input type="checkbox" name="Negocio" id="Negocio" value="1">
                </strong></div></td>
            <td nowrap height="7" align="center"><input type="checkbox" name="SE1" id="SE1" value="1"></td>
            <td nowrap align="center"><input type="checkbox" name="SE2" id="SE2" value="1"></td>
			<td><strong>
			  <textarea name="observ" cols="20" id="observ"></textarea>
			</strong></td>
          </tr>
        </table>
      </td>
    </tr>
</form>
</table>
	<!-------------------------------------------------------------------------------------------------------------------------->
</div>
<div class="button_div"> 
	</br>
    <input type="reset" id="btnCancel" name="btnCancel" value="Limpiar Campos" class="buttons_CANCEL" onclick="xajax_cancelar();" />
    <input type="button" id="btnAgregar" name="btnAgregar" value="Agregar Registro" class="buttons_aplicar" onclick="xajax_agregarFila(xajax.getFormValues('proyecto'));" />
	<input type="button" id="btnAgregar" name="btnAgregar" value="Guardar Todo" class="buttons_aplicar" onclick="xajax_guardar(xajax.getFormValues('proyecto'));" />
	<input type="button" id="btnRetornar" name="btnRetornar" value="Retornar" class="buttons_aplicar" onclick="xajax_retornar(xajax.getFormValues('proyecto'));" />
</div>
    <div class="clear"></div>
    <div id="form3" class="form-horiz">
		</br>
        <table width="83%" id="tblDetalle" class="tbl2" background="images/fondo.jpg" border="1"><tbody id="tbDetalle"></tbody></table>
    </div>
</div>
</form>
</body>
</html>