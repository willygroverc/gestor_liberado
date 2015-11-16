<?php
require_once('xajax/xajax.inc.php'); 
$varia2=  isset($_REQUEST['varia2']);
$varia3=  isset($_REQUEST['varia3']);
$varia4=  isset($_REQUEST['varia4']);
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
	$nro_corre=$id_campos;
	$sCadena = $formulario["nro_cds"];
	$sCadena_o = $formulario["Observ"];
   if (empty($sCadena))
   {   $respuesta->alert("El campo Nro. CDs, no puede ser vacio. \n \n Mensaje generado por GesTor F1.");
	   return $respuesta;
   }
	if (empty($sCadena_o))
   {   $respuesta->alert("El campo OBSERVACIONES, no puede ser vacio. \n \n Mensaje generado por GesTor F1.");
	   return $respuesta;
   }
	require_once('funciones.php');
	$fecha_alta=_clean($fecha_alta);
	$codigo_usu=_clean($codigo_usu);
	$tipo_medio=_clean($tipo_medio);
	$tipo_dato=_clean($tipo_dato);
	$nro_cds=_clean($nro_cds);
	$nro_corre=_clean($nro_corre);
	$Observ=_clean($Observ);
	
	$fecha_alta=SanitizeString($fecha_alta);
	$codigo_usu=SanitizeString($codigo_usu);
	$tipo_medio=SanitizeString($tipo_medio);
	$tipo_dato=SanitizeString($tipo_dato);
	$nro_cds=SanitizeString($nro_cds);
	$nro_corre=SanitizeString($nro_corre);
	$Observ=SanitizeString($Observ);
	$str_html_td1 = $fecha_alta . '<input type="hidden" id="hdnfecha_alta_' . $id_campos . '" name="hdnfecha_alta_' . $id_campos . '" value="' . $fecha_alta . '"/>' ;
    $str_html_td2 = "$codigo_usu" . '<input type="hidden" id="hdncodigo_usu_' . $id_campos . '" name="hdncodigo_usu_' . $id_campos . '" value="' . $codigo_usu . '"/>' ;
    $str_html_td3 = "$tipo_medio" . '<input type="hidden" id="hdntipo_medio_' . $id_campos . '" name="hdntipo_medio_' . $id_campos . '" value="' . $tipo_medio . '"/>' ;
    $str_html_td4 = "$tipo_dato" . '<input type="hidden" id="hdntipo_dato_' . $id_campos . '" name="hdntipo_dato_' . $id_campos . '" value="' . $tipo_dato . '"/>' ;
    $str_html_td5 = "$nro_cds" . '<input type="hidden" id="hdnnro_cds_' . $id_campos . '" name="hdnnro_cds_' . $id_campos . '" value="' . $nro_cds . '"/>' ;
	$str_html_td6 = "$nro_corre" . '<input type="hidden" id="hdnnro_corre_' . $id_campos . '" name="hdnnro_corre_' . $id_campos . '" value="' . $nro_corre . '"/>' ;
	$str_html_td7 = "$Observ" . '<input type="hidden" id="hdnObserv_' . $id_campos . '" name="hdnObserv_' . $id_campos . '" value="' . $Observ . '"/>' ;
    $str_html_td8 = '<img src="images/delete.png" width="16" height="16" alt="Eliminar" onclick="if(confirm(\'Realmente desea eliminar este detalle?\')){xajax_eliminarFila('. $id_campos .', frm_medios.cant_campos.value);}"/>';
    $str_html_td8 .= '<input type="hidden" id="hdnIdCampos_'. $id_campos .'" name="hdnIdCampos[]" value="'. $id_campos .'" />';

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
		
		
        $respuesta->addAssign("tdDetalle_01", "innerHTML", "FECHA ALTA");
        $respuesta->addAssign("tdDetalle_01", "aling", "center");
        $respuesta->addAssign("tdDetalle_02", "innerHTML", "CODIGO");
        $respuesta->addAssign("tdDetalle_03", "innerHTML", "TIPO MEDIO");
        $respuesta->addAssign("tdDetalle_04", "innerHTML", "TIPO DATO");
        $respuesta->addAssign("tdDetalle_05", "innerHTML", "Nro. CDs");
        $respuesta->addAssign("tdDetalle_06", "innerHTML", "Nro. Correlativo");
		$respuesta->addAssign("tdDetalle_07", "innerHTML", "OBSERVACIONES");
        $respuesta->addAssign("tdDetalle_08", "innerHTML", "Eliminar");
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
	
/*
 *     Esta parte podria estar dentro de algun ciclo iterativo  */
    
    $respuesta->addAssign($idTd."1", "innerHTML", $str_html_td1);   
    $respuesta->addAssign($idTd."2", "innerHTML", $str_html_td2);
    $respuesta->addAssign($idTd."3", "innerHTML", $str_html_td3);
    $respuesta->addAssign($idTd."4", "innerHTML", $str_html_td4);
    $respuesta->addAssign($idTd."5", "innerHTML", $str_html_td5);
    $respuesta->addAssign($idTd."6", "innerHTML", $str_html_td6);
	$respuesta->addAssign($idTd."7", "innerHTML", $str_html_td7);
    $respuesta->addAssign($idTd."8", "innerHTML", $str_html_td8);
	$respuesta->addAssign($idTd."1", "align", "center");
	$respuesta->addAssign($idTd."2", "align", "center");
	$respuesta->addAssign($idTd."3", "align", "center");
	$respuesta->addAssign($idTd."4", "align", "center");
	$respuesta->addAssign($idTd."5", "align", "center");
	$respuesta->addAssign($idTd."6", "align", "center");
	$respuesta->addAssign($idTd."7", "align", "center");
	$respuesta->addAssign($idTd."8", "align", "center");

/*  aumentamos el contador de campos  */

	$respuesta->addAssign("num_campos","value", $id_campos);
	$respuesta->addAssign("cant_campos" ,"value", $id_campos);  
	return $respuesta;
}
function retornar($formulario){
	$respuesta = new xajaxResponse();
	//$respuesta->alert('¡Correcto!');
	$respuesta->redirect('lista_controlinvent.php', 0);
    return $respuesta;
}
function guardar($formulario){
	$flag = 0;
    extract($formulario);
    $respuesta = new xajaxResponse();
	include("conexion.php");
	
    foreach($hdnIdCampos as $id){  
	require_once('funciones.php');
	$formulario['hdnfecha_alta_' . $id]=_clean($formulario['hdnfecha_alta_' . $id]);
	$formulario['hdnObserv_' . $id]=_clean($formulario['hdnObserv_' . $id]);
	$formulario['hdncodigo_usu_' . $id]=_clean($formulario['hdncodigo_usu_' . $id]);
	$formulario['hdntipo_medio_' . $id]=_clean($formulario['hdntipo_medio_' . $id]);
	$formulario['hdntipo_dato_' . $id]=_clean($formulario['hdntipo_dato_' . $id]);
	$formulario['hdnnro_cds_' . $id]=_clean($formulario['hdnnro_cds_' . $id]);
	$formulario['hdnnro_corre_' . $id]=_clean($formulario['hdnnro_corre_' . $id]);
	
	$formulario['hdnfecha_alta_' . $id]=_clean($formulario['hdnfecha_alta_' . $id]);
	$formulario['hdnObserv_' . $id]=_clean($formulario['hdnObserv_' . $id]);
	$formulario['hdncodigo_usu_' . $id]=_clean($formulario['hdncodigo_usu_' . $id]);
	$formulario['hdntipo_medio_' . $id]=_clean($formulario['hdntipo_medio_' . $id]);
	$formulario['hdntipo_dato_' . $id]=_clean($formulario['hdntipo_dato_' . $id]);
	$formulario['hdnnro_cds_' . $id]=_clean($formulario['hdnnro_cds_' . $id]);
	$formulario['hdnnro_corre_' . $id]=_clean($formulario['hdnnro_corre_' . $id]);
	$sqlin="INSERT INTO controlinvent(FechaAlta,Observ,codigo_usu,tipo_medio,tipo_dato,nro_cds,nro_corre)".
		  " VALUES('" . $formulario['hdnfecha_alta_' . $id] . "','" . $formulario['hdnObserv_' . $id] . "',
		  '" . $formulario['hdncodigo_usu_' . $id] . "','" . $formulario['hdntipo_medio_' . $id] . "','" . $formulario['hdntipo_dato_' . $id] . "',
		  '" . $formulario['hdnnro_cds_' . $id] . "','" . $formulario['hdnnro_corre_' . $id] . "')";
	
	if(mysql_query($sqlin))
	{	$MSG = "Datos guardados con exito";	}
	else
	{	$MSG = "Los datos no se han registrado.\n \n Consulte con el administrador";	}
}
    //$MSG = "Datos guardados con exito";
    $respuesta->addAlert($MSG);
	$respuesta->redirect('lista_controlinvent.php', 0);
    return $respuesta;
}

$xajax=new xajax();         // Crea un nuevo objeto xajax
$xajax->setCharEncoding("iso-8859-1"); // le indica la codificación que debe utilizar
$xajax->decodeUTF8InputOn();            // decodifica los caracteres extraños
$xajax->registerFunction("agregarFila"); //Registramos la función para indicar que se utilizará con xajax.
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
<?php $xajax->printJavascript("xajax"); include('top.php'); $num_fin=1;?>
<link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="stylesheet" href="css/calendar.css" />
	<script language="javascript" src="js/jquery.js"></script>
	<script language="JavaScript" src="js/ajax.js"></script>
	<script language="javascript" src="js/validate.js"></script>
	<script language="javascript" src="js/jquery-ui.js"></script>
	<script>
$(function() {
	$( "#fecha_alta" ).datepicker({
	dateFormat: 'yy/mm/dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
});
</script>
	<script language="javascript">
		var siguienteCampo = "Marca";  
		var nombreForm = "frm_medios" ;
		document.onkeydown = TelcaPulsada;          //asigna el evento pulsacion tecla a la funcion  
		function TelcaPulsada( e ) {  
		   if ( window.event != null)               //IE4+  
			  tecla = window.event.keyCode;  
		   else if ( e != null )                //N4+ o W3C compatibles  
			  tecla = e.which;  
		   else  
			  return;  
		   if (tecla == 13) {                   //se pulso enter  
			  if ( siguienteCampo == 'fin' ) {          //fin de la secuencia, hace el submit  
						guardar_nueva_ficha();
						return false ;                 //sustituir por return true para hacer el submit  
			  } else {                      //da el foco al siguiente campo  
				 eval('document.' + nombreForm + '.' + siguienteCampo + '.focus()');
				 return false ; 
			  }  
		   }  
		}  
  
		if (document.captureEvents)             //netscape es especial: requiere activar la captura del evento  
			document.captureEvents(Event.KEYDOWN) ; 
	</script>
</head>
<body>
<form name="frm_medios" id="frm_medios" action="" method="post">
    <input type="hidden" id="num_campos" name="num_campos" value="0" />
    <input type="hidden" id="cant_campos" name="cant_campos" value="0" />
<div id="cont" class="container">
	<div class="top">
	<table width="90%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="9" nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">INVENTARIO 
              DE MEDIOS - ALTA DE MEDIO DE ALMACENAMIENTO</font></th>
          </tr>
          <tr> 
            <th width="49" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">N&ordm;</font></th>
            <th width="203" background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA 
              ALTA </font></th>
            <th width="67" background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">CODIGO</font></th>
            <th width="89" background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">TIPO 
              MEDIO </font></th>
            <th width="71" background="images/main-button-tileR2.jpg"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">TIPO 
              DATO</font></th>
            <th width="70" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nro. 
              CDs </font></th>
			<th width="71" background="images/main-button-tileR2.jpg"> <div>
                <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Nro. 
                  Correlativo</font></div>
              </div></th>
            <th width="264" colspan="1" nowrap background="images/main-button-tileR2.jpg"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF">OBSERVACIONES</font></div></th>
          </tr>
          <tr> 
            <td width="49" height="7"> <div align="center"> 
                <p><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="1">NUEVO</font></strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                  </font></p>
              </div></td>
            <td width="203" nowrap height="3"><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font> 
                </strong> 
				<input type="text" id="fecha_alta" name="fecha_alta" value="<?php echo date('Y/m/d');	?>" size="10" maxlength="10"></input>
			<td width="67" height="7"> <div> <div align="center"> 
                <select name="codigo_usu" id="codigo_usu">
                  <option value="INF" <?php if($varia2=="INF"){echo "selected";}?>>INF</option>
                  <option value="FRL" <?php if($varia2=="FRL"){echo "selected";}?>>FRL</option>
                  <option value="SBF" <?php if($varia2=="SBF"){echo "selected";}?>>SBF</option>
                </select>
              </div></td>
            <td width="89" height="7" nowrap> <div align="center"> 
                <select name="tipo_medio" id="tipo_medio">
				  <option value="CDL" <?php if($varia3=="CDL"){echo "selected";}?>>CDL</option>
				  <option value="CDT" <?php if($varia3=="CDT"){echo "selected";}?>>CDT</option>
                  <option value="DCD" <?php if($varia3=="DCD"){echo "selected";}?>>DCD</option>
                  <option value="DVD" <?php if($varia3=="DVD"){echo "selected";}?>>DVD</option>
                  <option value="DSK" <?php if($varia3=="DSK"){echo "selected";}?>>DSK</option>
                  <option value="HDD" <?php if($varia3=="HDD"){echo "selected";}?>>HDD</option>
				  <option value="CDAT" <?php if($varia3=="CDAT"){echo "selected";}?>>CDAT</option>
                </select>
              </div></td>
          	<td height="7" colspan="1"> 
			 <div align="center"> 
                <select name="tipo_dato" id="tipo_dato">
                  <?php if($varia2=="INF" OR $varia2=="FRL"){?>
				  <option value="APP" <?php if($varia4=="APP"){echo "selected";}?>>APP</option>
				  <option value="BCK" <?php if($varia4=="BCK"){echo "selected";}?>>BCK</option>
				  <option value="BIC" <?php if($varia4=="BIC"){echo "selected";}?>>BIC</option>
				  <option value="DAT" <?php if($varia4=="DAT"){echo "selected";}?>>DAT</option>
				  <option value="DRI" <?php if($varia4=="DRI"){echo "selected";}?>>DRI</option>
				  <option value="OFI" <?php if($varia4=="OFI"){echo "selected";}?>>OFI</option>
                  <option value="SOP" <?php if($varia4=="SOP"){echo "selected";}?>>SOP</option>
                  <option value="VAR" <?php if($varia4=="VAR"){echo "selected";}?>>VAR</option>
				  <option value="EXC" <?php if($varia4=="EXC"){echo "selected";}?>>EXC</option>
				  <?php }else{?>
			      <option value="CCR" <?php if($varia4=="CCR"){echo "selected";}?>>CCR</option>
				  <option value="DAT" <?php if($varia4=="DAT"){echo "selected";}?>>DAT</option>
				  <option value="EJC" <?php if($varia4=="EJC"){echo "selected";}?>>EJC</option>
				  <option value="JUI" <?php if($varia4=="JUI"){echo "selected";}?>>JUI</option>
                  <option value="PER" <?php if($varia4=="PER"){echo "selected";}?>>PER</option>
                  <option value="VAR" <?php if($varia4=="VAR"){echo "selected";}?>>VAR</option>
				  <option value="EXC" <?php if($varia4=="EXC"){echo "selected";}?>>EXC</option>
				  <?php }?>
                </select>
			 </div>
			</td>
			 <td align="center"><input name="nro_cds" id="nro_cds" type="text" size="3" maxlength="2"></td>
			 
            <td align="center"><input name="nro_corre" id="nro_corre" type="text" size="3" maxlength="3" value="<?php echo $num_fin;?>" readonly></td>
			<td height="7" align="center">
                <textarea name="Observ" id="Observ" cols="30" rows="2"></textarea>
            </td>
          </tr>
        </table>
	</div>
<div class="button_div">  
</br>  
    <input type="reset" id="btnCancel" name="btnCancel" value="LIMPIAR" class="buttons_CANCEL" onclick="xajax_cancelar();" />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" id="btnAgregar" name="btnAgregar" value="Agregar Registro" class="buttons_aplicar" onclick="xajax_agregarFila(xajax.getFormValues('frm_medios'));" />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" id="btnAgregar" name="btnAgregar" value="GUARDAR TODO" class="buttons_OK" onclick="xajax_guardar(xajax.getFormValues('frm_medios'));" />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" id="btnRetornar" name="btnRetornar" value="RETORNAR" class="buttons_OK" onclick="xajax_retornar(xajax.getFormValues('frm_medios'));" />
	</br>
</div>
    <div class="clear"></div>
    <div id="form3" class="form-horiz">
	</br>
        <table width="90%" id="tblDetalle" class="tbl2" background="images/fondo.jpg" border="1"><tbody id="tbDetalle" ></tbody></table>
    </div>
</div>
</form>
</body>
</html>