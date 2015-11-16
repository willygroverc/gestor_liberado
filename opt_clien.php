<?php
@session_start();
require ('conexion.php');
require ('funciones.php');
$login_usr = $_SESSION["login"];
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

function cancelar(){  //elimina todo el contenido de la tabla y vuelve a cero los contadores
    
    $respuesta = new xajaxResponse();
    $respuesta->addRemove("tbDetalle"); //vuelve a crear la tabla vacia
    $respuesta->addCreate("tblDetalle", "tbody", "tbDetalle");
    $respuesta->addAssign("num_campos", "value", "0");
	$respuesta->addAssign("cant_campos", "value", "0");
    return $respuesta;
}

function agregarFila($formulario){
    $respuesta = new xajaxResponse();    
	extract($formulario);
	$id_campos = $cant_campos = $num_campos+1;
	$str_html_td1 = "$txtFichero" ;
    $str_html_td2 = "$txtObs";
    $str_html_td3 = '<a href="javascript:if(confirm(\'Realmente desea eliminar este detalle?\')){xajax_eliminarFila('. $id_campos .', adjunto.cant_campos.value);} void(0);"><img src="images/delete.png" width="16" height="16" alt="Eliminar"/></a>';

	if($num_campos == 0){ // creamos un encabezado de lo contrario solo agragamos la fila
		$respuesta->addCreate("tbDetalle", "tr", "rowDetalle_0");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_01");    //creamos los campos
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_02");
        $respuesta->addCreate("rowDetalle_0", "th", "tdDetalle_03");
        
      //asignamos el contenido
        $respuesta->addAssign("tdDetalle_01", "innerHTML", "Fichero");
        $respuesta->addAssign("tdDetalle_02", "innerHTML", "Observaciones");
        $respuesta->addAssign("tdDetalle_03", "innerHTML", "Eliminar");
		
		$respuesta->addAssign("tdDetalle_01", "width", "20%");
        $respuesta->addAssign("tdDetalle_02", "width", "60%");
        $respuesta->addAssign("tdDetalle_03", "width", "10%");
	}
    $idRow = "rowDetalle_$id_campos";
    $idTd = "tdDetalle_$id_campos";
	$respuesta->addCreate("tbDetalle", "tr", $idRow);
    $respuesta->addCreate($idRow, "td", $idTd."1");     //creamos los campos
    $respuesta->addCreate($idRow, "td", $idTd."2");
    $respuesta->addCreate($idRow, "td", $idTd."3");
/*
 *     Esta parte podria estar dentro de algun ciclo iterativo  */
    
    $respuesta->addAssign($idTd."1", "innerHTML", $str_html_td1);   //asignamos el contenido
    $respuesta->addAssign($idTd."2", "innerHTML", $str_html_td2);
    $respuesta->addAssign($idTd."3", "innerHTML", $str_html_td3);
    $respuesta->addAssign($idTd."3", "align", "center");
/*  aumentamos el contador de campos  */

	$respuesta->addAssign("num_campos","value", $id_campos);
	$respuesta->addAssign("cant_campos" ,"value", $id_campos);    
	return $respuesta;
}

$xajax=new xajax();         // Crea un nuevo objeto xajax
$xajax->setCharEncoding("iso-8859-1"); // le indica la codificaci�n que debe utilizar
$xajax->decodeUTF8InputOn();            // decodifica los caracteres extra�os
$xajax->registerFunction("agregarFila"); //Registramos la funci�n para indicar que se utilizar� con xajax.
$xajax->registerFunction("cancelar");
$xajax->registerFunction("eliminarFila");
$xajax->processRequests();

$xajax->printJavascript("xajax");
?>
<script type="text/javascript" src="js/validate.js"></script>
<script type="text/javascript" src="js/ordenes.js"></script>
<?php
	include ("top.php");
	$sql="SELECT visualizacion FROM users WHERE login_usr='".$_SESSION['login']."'";
	$recordset=mysql_query($sql);
	$fila=mysql_fetch_array($recordset);
	if($fila['visualizacion']==1){
		echo '<table width="75%" border="1" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th align="center" colspan="10">CLIENTE / TITULAR</th>
    </tr>
    <tr> 
      <td align="center" colspan="10">CI&nbsp;/&nbsp;RUC: 
        <input name="ci_ruc" id="ci_ruc" type="text" size="20" maxlength="20"> 
        </td> </tr>
    <tr> 
      <td align="right">NOMBRES:</td>
      <td> <input name="nombre1" id="nombre1" type="text" size="20" maxlength="20"></td>
      <td width="12%" align="right">AP.PATERNO:</td>
      <td width="16%"><input name="apaterno" id="apaterno" type="text" size="20" maxlength="50"></td>
      <td width="12%" align="right"> AP.MATERNO:</td>
      <td width="12%"> <input name="amaterno" id="amaterno" type="text" size="20" maxlength="50"></td>
      <td width="17%"><div align="right">AP. CASADA:</div></td>
      <td width="15%"><input name="acasada" id="acasada" type="text" size="20"></td>
    </tr> 
    <tr> 
      <td align="right">E-MAIL: </td>
      <td> <input name="email" id="email" type="text" size="20" maxlength="50"></td>
      <td align="right">ENTIDAD: </td>
      <td> <input name="entidad" id="entidad" type="text" size="20" maxlength="40"></td>
      <td align="right">AREA:</td>
      <td><input name="area1" id="area1" type="text" size="20" maxlength="40"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td align="right">CARGO:</td>
      <td><input name="cargo" id="cargo" type="text" size="20" maxlength="40"></td>
      <td align="right">TELEFONO:</td>
      <td><input name="telf" id="telf" type="text" size="20" maxlength="15"></td>
      <td align="right">FAX:</td>
      <td><input name="especialidad" id="especialidad" type="text" size="20" maxlength="15"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td align="right">EXT:</td>
      <td><input name="externo" id="externo" type="text" size="20" maxlength="15"></td>
      <td align="right">CIUDAD:</td>
      <td><input name="ciudad" name="ciudad" id="ciudad" type="text" size="20" maxlength="15"></td>
      <td align="right"> DIRECCION:</td>
      <td><input name="direccion" id="direccion" type="text" size="20" maxlength="80"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="8" align="center"> <input id="guardar_cliente" name="guardar_cliente" type="submit" value="GUARDAR" onclick=guardar_cliente();> 
										
      </td>
    </tr>
  </table>';
	}
	echo '<input id="flag" type="hidden" value="'.$fila['visualizacion'].'"></input>';
	echo '<table width="60%" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center">
					<div id="div_ajax">
					<div style="display: block;" class="success_box">Descripcion de la incidencia, debe ser mayor a 10 caracteres y menor a 500. Si la descripcion es demasiado extensa, adjunte un fichero.</div>
					<div style="display: none;" class="error_box" id="error_box"></div>
					</div>
				</td>
			</tr>
		</table>';
 
	echo '<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" >
			<tr>
				<th colspan="3" background="images/main-button-tileR2.jpg">INGRESE SU CONSULTA O RECLAMO</th>
			</tr>
			<tr>
				<td width="10%"><font size="2"><strong>Nivel 1:</strong></font></td>
				<td width="30%">
					<select name="area" id="area" onchange="filtrar_dominio();" style="font-size:15">
						<option value="0" selected>General</option>';
					$sql = " SELECT area_cod, area_nombre FROM area ORDER BY area_nombre";
					$recordset = mysql_query($sql);
					for($i=1;$i<=mysql_num_rows($recordset);$i++){
						$fila=mysql_fetch_array($recordset);
						echo '<option value="'.$fila['area_cod'].'">'.$fila['area_nombre'].'</option>';
					}
				
	echo '			</select>
				</td>
				<td rowspan="4" valign="top" width="60%" align="center">
					<table border="1" >
						<tr>
							<th colspan="2">Descripci&oacute;n de la Incidencia</th>
						</tr>
						<tr>
							<td align="center" colspan="2">
							<strong> 
								<textarea name="desc_inc" cols="60" rows="4" id="desc_inc" style="font-size:15;"></textarea>
							</strong>
						</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><font size="2"><strong>Nivel 2:</strong></font></td>
				<td><div id="div_dominio">
					<select id="dominio" name="dominio" style="font-size:15">
						<option value="0">General</option>';
	echo '			</select></div>
				</td>
			</tr>
			<tr>
				<td><font size="2"><strong>Nivel 3:</strong></font></td>
				<td><div id="div_objetivo">
					<select name="objetivo" id="objetivo" style="font-size:15">
						<option value="0">General</option>';
	echo '			</select></div>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><br><a href="impresion_niveles.php" target="_blank">VER NIVELES</a></td>
			</tr>
			<tr>
				<td colspan="3">
					<table width="100%" id="tblDetalle" border="1"><tbody id="tbDetalle"></tbody></table>
				</td>
			</tr>
			<tr>
				<td colspan="3" align="center">
					
					<input type="button" id="guardar_orden" value="REGISTRAR ORDEN" onclick="validar_orden();"></input>
				</td>
			</tr>
		</table><br>';
	echo '<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" >
			<tr>
				<th colspan="2">Desea Adjuntar Archivos?&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;<input id="chk_adj" name="chk_adj" type="checkbox" onchange="mostrar_adj();"></input></th>
			</tr>
		</table>
		
		<form action="subir.php" class="formularios" method="post" enctype="multipart/form-data" target="contenedor_subir_archivo">
           <table id="tbl_adj" name="tbl_adj" width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" style="display:none"> 
			<tr>
				<td align="center">
					<label> Archivo:</label>
				</td>
				<td align="center">
					<input type="file" name="archivo" id="archivo" />
				</td>
			</tr>
			<tr>
				<td align="center">
					<font size="2"><strong>Observaciones:</strong></font></td>
				</td>
				<td align="center">
					<textarea id="txtObs" name="txtObs" cols="90" rows="1"></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="center">
					<input type="submit" id="boton_subir_archivo" />
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div id="respuesta"></div>
					<iframe width="1" height="1" frameborder="0" name="contenedor_subir_archivo" style="display: none"></iframe>
				</td>
			</tr>
		   </table>
		</form>
	
	<br>';
?>
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript">       
       function cargando(){
           $("#respuesta").html('Cargando...');
       }      
       function resultadoOk(){
           $("#respuesta").html('El archivo ha sido subido exitosamente.');
       }      
       function resultadoErroneo(){
          $("#respuesta").html('Ha surgido un error y no se ha podido subir el archivo.');
       }       
       $(document).ready(function(){
          $("#boton_subir_archivo").click(function(){
             cargando();
          });
	   });  
</script>
<br><br>