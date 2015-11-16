<?php
require_once('funciones.php');
require_once('xajax/xajax.inc.php'); //incluimos la librelia xajax

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
	$ocadena=$formulario["observ"];
	$tcadena=$formulario["temperatura"];
	$ncadena=$formulario["nombresp"];
	$hcadena=$formulario["hr"];
	if(empty($tcadena))	{
      $respuesta->addAlert("El campo TEMPERATURA no puede ser vacio");
	  return $respuesta;
    }
	if(empty($hcadena))	{
      $respuesta->addAlert("El campo HUMEDAD no puede ser vacio");
	  return $respuesta;
    }
	if(empty($ncadena))	{
      $respuesta->addAlert("El campo RESPONSABLE no puede ser vacio");
	  return $respuesta;
    }
	if(empty($ocadena))	{
      $respuesta->addAlert("El campo observaciones no puede ser vacio");
	  return $respuesta;
    }
	$txthora=$horas.":".$minutos;
	require_once('funciones.php');
	$txthora=_clean($txthora);
	$fecha_temp=_clean($fecha_temp);
	$temperatura=_clean($temperatura);
	$hr=_clean($hr);
	$nombresp=_clean($nombresp);
	$observ=_clean($observ);
	
	$txthora=SanitizeString($txthora);
	$fecha_temp=SanitizeString($fecha_temp);
	$temperatura=SanitizeString($temperatura);
	$hr=SanitizeString($hr);
	$nombresp=SanitizeString($nombresp);
	$observ=SanitizeString($observ);
	
	$str_html_td1 = $txthora . '<input type="hidden" id="hdntxthora_' . $id_campos . '" name="hdntxthora_' . $id_campos . '" value="' . $txthora . '"/>' ;
    $str_html_td2 = "$fecha_temp" . '<input type="hidden" id="hdnfecha_temp_' . $id_campos . '" name="hdnfecha_temp_' . $id_campos . '" value="' . $fecha_temp . '"/>' ;
    $str_html_td3 = "$temperatura" . '<input type="hidden" id="hdntemperatura_' . $id_campos . '" name="hdntemperatura_' . $id_campos . '" value="' . $temperatura . '"/>' ;
    $str_html_td4 = "$hr" . '<input type="hidden" id="hdnhr_' . $id_campos . '" name="hdnhr_' . $id_campos . '" value="' . $hr . '"/>' ;
    $str_html_td5 = "$nombresp" . '<input type="hidden" id="hdnombresp_' . $id_campos . '" name="hdnombresp_' . $id_campos . '" value="' . $nombresp . '"/>' ;
	$str_html_td6 = "$observ" . '<input type="hidden" id="hdnobserv_' . $id_campos . '" name="hdnobserv_' . $id_campos . '" value="' . $observ . '"/>' ;
	$str_html_td7 = '<img src="images/delete.png" width="16" height="16" alt="Eliminar" onclick="if(confirm(\'Realmente desea eliminar este detalle?\')){xajax_eliminarFila('. $id_campos .', frm_temp.cant_campos.value);}"/>';
    $str_html_td7 .= '<input type="hidden" id="hdnIdCampos_'. $id_campos .'" name="hdnIdCampos[]" value="'. $id_campos .'" />';
	

	if($num_campos == 0){ // creamos un encabezado de lo contrario solo agragamos la fila
		$respuesta->addCreate("tbDetalle", "tr", "rowDetalle_0");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_01");    //creamos los campos
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_02");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_03");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_04");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_05");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_06");
		$respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_07");

        $respuesta->addAssign("tdDetalle_01", "innerHTML", "HORA");   //asignamos el contenido
        $respuesta->addAssign("tdDetalle_02", "innerHTML", "FECHA");
        $respuesta->addAssign("tdDetalle_03", "innerHTML", "TEMPERATURA");
        $respuesta->addAssign("tdDetalle_04", "innerHTML", "HUMEDAD RELATIVA");
        $respuesta->addAssign("tdDetalle_05", "innerHTML", "NOMBRE RESPONSABLE");
        $respuesta->addAssign("tdDetalle_06", "innerHTML", "OBSERVACIONES");
		$respuesta->addAssign("tdDetalle_07", "innerHTML", "Eliminar");
	}
    $idRow = "rowDetalle_$id_campos";
    $idTd = "tdDetalle_$id_campos";
	$respuesta->addCreate("tbDetalle", "tr", $idRow);
    $respuesta->addCreate($idRow, "td", $idTd."1");     //creamos los campos
    $respuesta->addCreate($idRow, "td", $idTd."2");
    $respuesta->addCreate($idRow, "td", $idTd."3");
    $respuesta->addCreate($idRow, "td", $idTd."4");
    $respuesta->addCreate($idRow, "td", $idTd."5");
    $respuesta->addCreate($idRow, "td", $idTd."6");
	$respuesta->addCreate($idRow, "td", $idTd."7");
    
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

	$respuesta->addAssign("num_campos","value", $id_campos);
	$respuesta->addAssign("cant_campos" ,"value", $id_campos);    
	return $respuesta;
}
function retornar($formulario){
	$respuesta = new xajaxResponse();
	$respuesta->redirect('lista_controltemp.php', 0);
    return $respuesta;
}
function guardar($formulario){
	$flag = 0;
    extract($formulario);
    $respuesta = new xajaxResponse();
	include("conexion.php");
    foreach($hdnIdCampos as $id){ 
	$formulario['hdntxthora_' . $id]=_clean($formulario['hdntxthora_' . $id]);
	$formulario['hdnfecha_temp_' . $id]=_clean($formulario['hdnfecha_temp_' . $id]);
	$formulario['hdntemperatura_' . $id]=_clean($formulario['hdntemperatura_' . $id]);
	$formulario['hdnhr_' . $id]=_clean($formulario['hdnhr_' . $id]);
	$formulario['hdnombresp_' . $id]=_clean($formulario['hdnombresp_' . $id]);
	$formulario['hdnobserv_' . $id]=_clean($formulario['hdnobserv_' . $id]);
	
	$formulario['hdntxthora_' . $id]=SanitizeString($formulario['hdntxthora_' . $id]);
	$formulario['hdnfecha_temp_' . $id]=SanitizeString($formulario['hdnfecha_temp_' . $id]);
	$formulario['hdntemperatura_' . $id]=SanitizeString($formulario['hdntemperatura_' . $id]);
	$formulario['hdnhr_' . $id]=SanitizeString($formulario['hdnhr_' . $id]);
	$formulario['hdnombresp_' . $id]=SanitizeString($formulario['hdnombresp_' . $id]);
	$formulario['hdnobserv_' . $id]=SanitizeString($formulario['hdnobserv_' . $id]);
	$sqlin= "INSERT INTO controltemp (hora,fecha,temperatura,hr,nombresp,observ)
			VALUES('" . $formulario['hdntxthora_' . $id] . "', '" . $formulario['hdnfecha_temp_' . $id] . "', '" . $formulario['hdntemperatura_' . $id] . "',
                        '" . $formulario['hdnhr_' . $id] . "', '". $formulario['hdnombresp_' . $id] . "', '". $formulario['hdnobserv_' . $id] . "')";   
	
		if(mysql_query($sqlin))
		{	$flag=1;	}
    }
	
	if($flag==1)
    $MSG = "Datos Registrados...";
    $respuesta->addAlert($MSG);
	$respuesta->redirect('lista_controltemp.php', 0);
    return $respuesta;
}
$xajax=new xajax();         // Crea un nuevo objeto xajax
$xajax->setCharEncoding("iso-8859-1"); // le indica la codificaci�n que debe utilizar
$xajax->decodeUTF8InputOn();            // decodifica los caracteres extra�os
$xajax->registerFunction("agregarFila"); //Registramos la funci�n para indicar que se utilizar� con xajax.
$xajax->registerFunction("cancelar");
$xajax->registerFunction("guardar");
$xajax->registerFunction("eliminarFila");
$xajax->registerFunction("retornar");
$xajax->processRequests();
?>

<html>
<meta http-equiv="Pragma"content="no-cache">
<meta http-equiv="expires"content="0">
<head>
<?php $xajax->printJavascript("xajax"); require_once('top.php'); $numero=$_REQUEST['varia1']; ?>
<link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="stylesheet" href="css/calendar.css" />
	<script language="javascript" src="js/jquery.js"></script>
	<script language="JavaScript" src="js/fichas.js"></script>
	<script language="JavaScript" src="js/ajax.js"></script>
	<script language="javascript" src="js/validate.js"></script>
	<script language="javascript" src="js/jquery-ui.js"></script>
</head>
<body>
<form name="frm_temp" id="frm_temp" action="#" method="post">
    <input type="hidden" id="num_campos" name="num_campos" value="0" />
    <input type="hidden" id="cant_campos" name="cant_campos" value="0" />
	<input name="var" type="hidden" value="<?php echo $numero;?>">
<div id="cont" class="container">
	<div class="top">
	
	<table width="83%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td colspan="6" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>CONTROL 
          DE TEMPERATURA Y HUMEDAD RELATIVA</strong></font></div></td>
    </tr>
  </table>
 <!---------------------------------------------------------------------------------------------------------------------------->
 <table width="83%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="32%" height="19" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HORA</font></div></td>
      <td width="27%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font></div></td>
      <td width="41%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">TEMPERATURA 
          (&ordm;C) </font></div></td>
    </tr>
    <tr> 
      <td><div align="center"> 
          <div align="center"></div>
          <div align="center"> 
            <input name="horas" id="horas" type="text" value="<?php echo date("H"); ?>" size="2" maxlength="2" >
            <strong>:</strong> 
            <input name="minutos" id="minutos" type="text" value="<?php echo date("i");?>" size="2" maxlength="2">
          </div>
        </div></td>
      <td>
	  <div align="center"> 
	   <?php $fsist=date("Y-m-d"); ?>
          
          <input type="text" id="fecha_temp" name="fecha_temp" size="10" maxlength="10" value="<?php echo date('Y-m-d');	?>"></input>
	  <td><div align="center"> 
          <input name="temperatura" id="temperatura" type="text" size="5" maxlength="3">
        </div></td>
    </tr>
    <tr> 
      <td background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HUMEDAD 
          RELATIVA (%)</font></div></td>
      <td background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NOMBRE 
          RESPONSABLE</font></div></td>
      <td background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></div></td>
    </tr>
    <tr> 
      <td> <div align="center"> 
          <input name="hr" id="hr" type="text" size="5" maxlength="3">
        </div></td>
      <td> <div align="center"> 
          <select name="nombresp" id="nombresp" class="textbox txtFec">
            <option value="0"></option>
            <?php 
			  require ("conexion.php");
			  $sql1 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  $result1 = mysql_query($sql1);
			  while ($row1 = mysql_fetch_array($result1)) 
				{
				echo "<option value=\"$row1[login_usr]\">$row1[apa_usr] $row1[ama_usr] $row1[nom_usr]</option>";
	            }
			   ?>
          </select>
        </div></td>
      <td> <div align="center"> 
          <textarea name="observ" id="observ" cols="20"></textarea>
        </div></td>
    </tr>
  </table>
 <!---------------------------------------------------------------------------------------------------------------------------->
	
	</div>
<div class="button_div">   
	</br> 
    <input type="reset" id="btnCancel" name="btnCancel" value="LIMPIAR DATOS" class="buttons_CANCEL" onclick="xajax_cancelar();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" id="btnAgregar" name="btnAgregar" value="Agregar Registro" class="buttons_aplicar" onclick="xajax_agregarFila(xajax.getFormValues('frm_temp'));" />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" id="btnAgregar" name="btnAgregar" value="GUARDAR TODO Y VOLVER" class="buttons_OK" onclick="xajax_guardar(xajax.getFormValues('frm_temp'));" />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" id="btnRetornar" name="btnRetornar" value="RETORNAR" class="buttons_OK" onclick="xajax_retornar(xajax.getFormValues('frm_temp'));" />
</div>
        
    </legend>
    <div class="clear"></div>
    <div id="form3" class="form-horiz">
	</br>
        <table width="83%" id="tblDetalle" class="tbl2" background="images/fondo.jpg" border="1"><tbody id="tbDetalle"></tbody></table>
    </div>
</div>
</form>
<?php include('top_.php'); ?>
</body>
</html>