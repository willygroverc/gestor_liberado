<?php
// Version: 	1.0
// Objetivo:	Modificación de funciones php obsoletas para version 5.3 
//				Control de Acceso No Autorizado por URL
///
// Autor:		Cesar Cuenca
// Fecha:		20/Nov/12
//__________________________________________________________________________
@session_start();
if ($_SESSION['tipo']=='C'){
	header("location: pagina_inicio.php");
	return;
}
include("top.php"); 		
?> 
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/calendar.css" />
<script language="javascript" src="js/jquery.js"></script>
<script language="JavaScript" src="js/asignacion.js"></script>
<script language="JavaScript" src="js/ajax.js"></script>
<script language="javascript" src="js/validate.js"></script>
<script language="javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript">
    function showContent() {
        element = document.getElementById("content");
        check = document.getElementById("check");
        if (check.checked) {
            element.style.display='none';
        }
        else {
            element.style.display='block';
        }
    }
</script>
<script>
$(function() {
	$( "#fecha_sol" ).datepicker({
	dateFormat: 'dd/mm/yy',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});

	$( "#fecha_escal" ).datepicker({
	dateFormat: 'dd/mm/yy',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
});
</script>
<form name="frm_asig" id="frm_asig">
<?php
	require('conexion.php');
	require('funciones.php');
	$id=$_REQUEST['id_orden'];
	$id=_clean($id);
	$id=SanitizeString($id);
	$sql="SELECT desc_inc, fecha, time FROM ordenes WHERE id_orden=$id";
	$recordset=mysql_query($sql);
	$fila=mysql_fetch_array($recordset);
	$fecha=substr($fila['fecha'],8,2).'-'.substr($fila['fecha'],5,2).'-'.substr($fila['fecha'],0,4);

$sql_asig="SELECT a.id_asig, ac.s_desc as complej, ac1.s_desc as critic, ac2.s_desc as priori, a.asig, DATE_FORMAT(a.fecha_asig,'%d/%m/%Y') as fecha_asig, a.hora_asig, ".
		" DATE_FORMAT(a.fechaestsol_asig,'%d/%m/%Y') as fechaestsol_asig,". 
		" a.reg_asig, a.diagnos, a.escal, a.fechasol_esc, a.area, a.area_1, a.nivel_asig, a.criticidad_asig, a.prioridad_asig ".
		" FROM asignacion a". 
		" LEFT JOIN t_asig_complejidad ac ON a.nivel_asig=ac.n_cod_complejidad". 
		" LEFT JOIN t_asig_criticidad ac1 ON a.criticidad_asig=ac1.n_cod_criticidad". 
		" LEFT JOIN t_asig_prioridad ac2 ON a.prioridad_asig=ac2.n_cod_prioridad". 
		" WHERE id_orden=".$id;
$recordset_asig=mysql_query($sql_asig);
$num_asig=mysql_num_rows($recordset_asig);
if ($num_asig>0){
	echo  '<table width="95%" border="1" align="center" background="images/fondo.jpg">
			<tr bgcolor="#006699"> 
				<td colspan="9" align="center"> 
					<font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">
					<strong>HISTORIAL DE ASIGNACIONES DE LA ORDEN DE TRABAJO Nro. </strong>'.$id.'</font></td>
			</tr>
			<tr bgcolor="#006699"> 
				<td width="8%" align="center">
					<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha y Hora</font></td>
				<td width="15%" align="center">
					<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Asignado por</font></td>
				<td width="15%" align="center"> 
					<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Asignado a</font></td>
				<td width="12%" align="center">
					<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Diagnostico</font></td>
				<td width="8%" align="center">
					<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha de Solucion</font></td>
				<td width="13%" align="center">
					<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Area</font></td>
				<td width="10%" align="center">
					<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Complejidad</font></td>
				<td width="10%" align="center">
					<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Criticidad</font></td>
				<td width="10%" align="center"> 
					<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Prioridad</font></td>
			</tr>';
			for ($i=1;$i<=mysql_num_rows($recordset_asig);$i++){
				$fila_asig=mysql_fetch_array($recordset_asig);
				echo '<tr>';
				echo '<td align="center">'.$fila_asig['fecha_asig'].' '.$fila_asig['hora_asig'].'</td>';
				echo '<td align="center">'.$fila_asig['reg_asig'].'</td>';
				echo '<td align="center">'.$fila_asig['asig'].'</td>';
				echo '<td>'.$fila_asig['diagnos'].'</td>';
				echo '<td align="center">'.$fila_asig['fechaestsol_asig'].'</td>';
				echo '<td align="center">'.$fila_asig['area'].'</td>';
				echo '<td align="center">'.$fila_asig['complej'].'</td>';
				echo '<td align="center">'.$fila_asig['critic'].'</td>';
				echo '<td align="center">'.$fila_asig['priori'].'</td>';
				echo '</tr>';
			}
	echo'</table><br>';	
}
	
echo '<table width="77%" border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#F4F2EA" style="border-collapse:collapse;" background="images/fondo.jpg">
    <tr>
		<th colspan="2">ASIGNACION</th>
	</tr>
	<tr>
		<td class="normal" align="center"><font size="2"><strong>Descripcion:</strong>'.$fila['desc_inc'].'</font></hr></td>
	</tr>
	<tr>
		<td><br>
			<table align="center">
				<tr>
					<td class="normal"><strong>Nro Orden:</strong></td>
					<td><input type="text" id="id_orden" value="'.$id.'" disabled></td>				
					<td class="normal"><strong>Fecha:</strong></td>
					<td><input type="text" value="'.$fecha.'" disabled></td>
					<td class="normal"><strong>Hora:</strong></td>
					<td><input type="text" value="'.$fila['time'].'" disabled></td>
				</tr>
			</table><br>';	
echo '<div align="center"><b>Asignacion Automatica definida por el objetivo?</b>';
echo '<input type="checkbox" name="check" id="check"  onchange="javascript:showContent()" /></div>';
echo '<div id="content" style="display: none;">';
echo			'<table align="center" border="0">
				<tr>
				</tr>';

				if ($num_asig==0){
				
					echo '<tr>
							<td colspan="6" align="center"><font size="2"><strong>TECNICOS DISPONIBLES</strong></font></td>
						</tr>
						<tr>
							<td colspan="6" align="center">
								<select  name="lista" id="lista" size="8" style="width:250px" multiple="multiple">';
								//$sql_tecnicos="SELECT login_usr, nom_usr, apa_usr, ama_usr FROM users 
								//		WHERE (tipo2_usr='T' OR tipo2_usr='A' OR tipo2_usr='S') 
								//		AND adicional1='".$_SESSION['agencia']."' AND bloquear=0 ORDER BY apa_usr, ama_usr, nom_usr";
								$sql_tecnicos="SELECT login_usr, nom_usr, apa_usr, ama_usr FROM users 
										WHERE (tipo2_usr='T' OR tipo2_usr='A' OR tipo2_usr='S') 
										 AND bloquear=0 ORDER BY apa_usr, ama_usr, nom_usr";				
								$recordset_tecnicos=mysql_query($sql_tecnicos);
								for ($i=1;$i<=mysql_num_rows($recordset_tecnicos);$i++){
									$fila=mysql_fetch_array($recordset_tecnicos);
									echo '<option value="'.$fila['login_usr'].'">'.$fila['apa_usr'].' '.$fila['ama_usr'].' '.$fila['nom_usr'].'</option>';
								}
								echo '</select>
							</td>
						</tr>';
					}
				else{
					echo '<tr><td colspan="6" align="center"><font size="2"><strong>SELECCIONE TECNICO PARA REASIGNACION</strong></font></td></tr>';
					echo '<tr>
							<td colspan="6" align="center">
								<select name="lista" id="lista">';
								$sql_tecnicos="SELECT login_usr, nom_usr, apa_usr, ama_usr FROM users WHERE (tipo2_usr='A' OR tipo2_usr='T') AND bloquear=0 ORDER BY apa_usr";
								$recordset_tecnicos=mysql_query($sql_tecnicos);
								for ($i=1;$i<=mysql_num_rows($recordset_tecnicos);$i++){
									$fila_tecnicos=mysql_fetch_array($recordset_tecnicos);
									if ($fila_asig['asig']==$fila_tecnicos['login_usr'])
										echo '<option value="'.$fila_tecnicos['login_usr'].'" selected>'.$fila_tecnicos['apa_usr'].' '.$fila_tecnicos['ama_usr'].' '.$fila_tecnicos['nom_usr'].'</option>';
									else
										echo '<option value="'.$fila_tecnicos['login_usr'].'">'.$fila_tecnicos['apa_usr'].' '.$fila_tecnicos['ama_usr'].' '.$fila_tecnicos['nom_usr'].'</option>';
								}
					echo 		'</select>
							</td>
						</tr>';	
				}
echo			'<tr>
                        <tr> 
					<td colspan="7" class="normal" align="center">
						<strong>Fecha estimada de solucion:</strong>
						<input type="text" id="fecha_sol" name="fecha_sol" size="10" maxlength="10" value="';
						if ($num_asig>0)
							echo $fila_asig['fechaestsol_asig'];
						else
							echo date('d/m/Y');
						echo '"> 
					</td>
				</tr>
                                </table>
</div>
<table align="center" border="0">
                
					<td align="center"><br>
						<table border="1">
							<tr>
								<td class="normal"><strong>Complejidad:</strong></td>
								<td>					
									<select name="nivel_asig" id="nivel_asig">';
									$sql="SELECT n_cod_complejidad, n_indice, s_desc, s_defecto FROM t_asig_complejidad";
									$recordset=mysql_query($sql);
									for ($i=1;$i<=mysql_num_rows($recordset);$i++){
										$fila=mysql_fetch_array($recordset);
										if ($num_asig==0){
											echo '<option value="'.$fila['n_cod_complejidad'].'" '.$fila['s_defecto'].'>'.$fila['n_indice'].' ('.$fila['s_desc'].')</option>';
										}
										else{
											if ($fila_asig['nivel_asig']==$fila['n_cod_complejidad'])
												echo '<option value="'.$fila['n_cod_complejidad'].'" selected >'.$fila['n_indice'].' ('.$fila['s_desc'].')</option>';
											else
												echo '<option value="'.$fila['n_cod_complejidad'].'">'.$fila['n_indice'].' ('.$fila['s_desc'].')</option>';
										}
									}
								echo '</select>
								</td>
								<td class="normal"><strong>Criticidad:</strong></td>
								<td>
									<select name="criticidad_asig" id="criticidad_asig">';
									$sql="SELECT n_cod_criticidad, n_indice, s_desc, s_defecto FROM t_asig_criticidad";
									$recordset=mysql_query($sql);
									for ($i=1;$i<=mysql_num_rows($recordset);$i++){
										$fila=mysql_fetch_array($recordset);
										if ($num_asig==0){
											echo '<option value="'.$fila['n_cod_criticidad'].'" '.$fila['s_defecto'].'>'.$fila['n_indice'].' ('.$fila['s_desc'].')</option>';
										}
										else{
											if ($fila_asig['criticidad_asig']==$fila['n_cod_criticidad'])
												echo '<option value="'.$fila['n_cod_criticidad'].'" selected>'.$fila['n_indice'].' ('.$fila['s_desc'].')</option>';
											else	
												echo '<option value="'.$fila['n_cod_criticidad'].'">'.$fila['n_indice'].' ('.$fila['s_desc'].')</option>';
										}
									}
								echo '</select>
								</td>
								<td class="normal"><strong>Prioridad:</strong></td>
								<td>
									<select name="prioridad_asig" id="prioridad_asig">';
									$sql="SELECT n_cod_prioridad, n_indice, s_desc, s_defecto FROM t_asig_prioridad";
									$recordset=mysql_query($sql);
									for ($i=1;$i<=mysql_num_rows($recordset);$i++){
										$fila=mysql_fetch_array($recordset);
										if($num_asig==0){
											echo ' <option value="'.$fila['n_cod_prioridad'].'" '.$fila['s_defecto'].'>'.$fila['n_indice'].' ('.$fila['s_desc'].')</option>';
										}
										else{
											if ($fila_asig['prioridad_asig']==$fila['n_cod_prioridad'])
												echo ' <option value="'.$fila['n_cod_prioridad'].'"selected>'.$fila['n_indice'].' ('.$fila['s_desc'].')</option>';
											else	
												echo ' <option value="'.$fila['n_cod_prioridad'].'">'.$fila['n_indice'].' ('.$fila['s_desc'].')</option>';
										}
									}
								echo '</select>
								</td>
							</tr>
							<tr>
								<td class="normal"><strong>Diagn&oacute;stico:</strong></td>
								<td colspan="5">
									<input name="txt_diagnos" id="txt_diagnos" type="text" value="';
									if ($num_asig>0)
										echo $fila_asig['diagnos'];
									echo '" style="width:500px; font-size:12px; color:#000000; padding:6px;border:solid 1px #999999;">
								</td>
							</tr>
							<tr>
								<td class="normal"><strong>Area:</strong></td>
								<td colspan="5">
									<input type="radio" name="area" value="Mesa" onClick="disabled1();" checked>MESA DE AYUDA&nbsp;&nbsp;&nbsp;&nbsp; 
									<input type="radio" name="area" value="DyM" onClick="disabled1();">D y M&nbsp;&nbsp;&nbsp;&nbsp; 
									<input type="radio" name="area" value="Problemas" onClick="disabled1();">PROBLEMAS&nbsp;&nbsp;&nbsp;&nbsp; 
									<input type="radio" name="area" value="Contingencia" onClick="disabled1();">CONTINGENCIA &nbsp;&nbsp;&nbsp; 
									<input type="radio" name="area" value="Cambios" onClick="enabled1();">CAMBIOS
								</td>
							</tr>
							<tr>
								<td class="normal"><strong>Tipo de Prueba:</strong></td>
								<td colspan="5">
									<table  border="0">
										<tr>
											<td width="22%">
											  <input type="checkbox" name="pru1" id="pru1" value="pru1" disabled>
											  Prueba Usuaria</strong></td>
											<td width="28%">
											  <input type="checkbox" name="pru2" id="pru2" value="pru2" disabled>
											  Prueba de Sistemas</td>
											<td width="25%">
											  <input type="checkbox" name="pru3" id="pru3" value="pru3" disabled>
											  Prueba de Seguridad</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td class="normal"><strong>Escalamiento:</strong></td>
								<td colspan="5">
									<table>
										<tr>
											<td>SI</td>
											<td><input type="checkbox" name="chkEscalar" id="chkEscalar" onclick="mostrar_escal()"></input></td>
											<td>
												<select name="escal" id="escal" style="display:none;">
													<option value="0">Seleccione un Usuario</option>';
													$recordset1=mysql_query($sql_tecnicos);
													for($i=1;$i<=mysql_num_rows($recordset1);$i++){
														$fila=mysql_fetch_array($recordset1);
														echo '<option value="'.$fila['login_usr'].'">'.$fila['apa_usr'].' '.$fila['ama_usr'].' '.$fila['nom_usr'].'</option>';
													}
												echo '</select>
											</td>
											<td class="normal">
												<div id="div_fecha_escal" style="display:none;">
												<strong>Fecha Soluci&oacute;n Escalamiento:</strong>&nbsp;
												<input type="text" id="fecha_escal" size="10" maxlength="10"></input></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
				<tr>
					<td colspan="7" align="center">
						<input type="button" value="GUARDAR" id="btn_guardar" onclick="document.getElementById(\'btn_guardar\').value=\'GUARDAR\';document.getElementById(\'btn_guardar\').disabled=false;validar_asignacion();">
					</td>
				</tr>
				<tr>
					<td colspan="7" align="center">
						<br>
						<div id="div_ajax">
							<div style="display: block;" class="success_box">
							Seleccione un T&eacute;cnico o Administrador, y a continuaci&oacute;n  introduzca diagn&oacute;stico.
							</div>
						<div style="display: none;" class="error_box" id="error_box"></div>
						</div>
					</td>
				</tr>
			</table/>
		<br></td>
 </table></form>';
?>
<!--------------------Fin de Formulario------------------------------

<?php


function envioMail($id,$nivel_asig,$criticidad_asig,$prioridad_asig,$asig,$diagnos,$DA,$MA,$AA,$row5,$flag)
{
	require("conexion.php");
	$login_usr=$_SESSION["login"];
	$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
	$systemData=mysql_fetch_array(mysql_query($sqlSystem));
	$sqlNom="SELECT nom_usr, apa_usr, ama_usr, email FROM users WHERE login_usr='$asig'";
	//echo "<br>sql NOm: ".$sqlNom;
	$rowNom=mysql_fetch_array(mysql_query($sqlNom));
	$nomasig=$rowNom['nom_usr'].' '.$rowNom['apa_usr'].' '.$rowNom['ama_usr'];
	$sqlEnv="SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$login_usr'";
	$rowEnv=mysql_fetch_array(mysql_query($sqlEnv));
	$nomEnv=$rowEnv['nom_usr'].' '.$rowEnv['apa_usr'].' '.$rowEnv['ama_usr'];

	//envio de mail
	$userData = array();
	$userData=$row5;
	$userName=$userData['nom_usr'].' '.$userData['apa_usr'].' '.$userData['ama_usr'];
	$sqlTmp="SELECT cod_usr, desc_inc FROM ordenes WHERE id_orden=$id";
	$ordenTmp=mysql_fetch_array(mysql_query($sqlTmp));
	if($ordenTmp['cod_usr']!="SISTEMA"){
		$sqlCliente="SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='".$ordenTmp['cod_usr']."'";
		$ordenCliente=mysql_fetch_array(mysql_query($sqlCliente));
		$clienteNombre=$ordenCliente['nom_usr'].' '.$ordenCliente['apa_usr'].' '.$ordenCliente['ama_usr'];
	}
	else $clienteNombre="SISTEMA";
	
	if($systemData["conf_mail"]==3 || $systemData["conf_mail"]==4)
	{																				
			$tmpComplejidad=array(1=>"1 - Baja", 2=>"2 - Media", 3=>"3 - Alta");
			$tmpPrioridad=array(3=>"3 - Baja", 2=>"2 - Media", 1=>"1 - Alta");
			$sqls = "SELECT email FROM users WHERE login_usr='$asig'";
			$ress = mysql_query($sqls);
			$fila = mysql_fetch_array($ress);					
			if ( !(empty($fila['email'])))
			{
		   //*************
				$asunto = "Nro. $id. Nueva Asignacion de Orden de Trabajo";	
				$mail = $rowNom['email'];
				$mensaje = "
					Nueva Asignacion de Orden de Trabajo: Nro. $id <br>												
					Cliente/Tecnico: $clienteNombre <br>
					Descripcion: $ordenTmp[desc_inc] <br>						
					Complejidad: $tmpComplejidad[$nivel_asig] <br>
					Criticidad: $tmpPrioridad[$criticidad_asig] <br>						
					Prioridad: $tmpPrioridad[$prioridad_asig] <br>
					Diagnostico Inicial: $diagnos <br>
					Fecha Estimada de Solucion: $DA/$MA/$AA <br><br>
					Para mayores detalles, consulte el Sistema GesTor F1. <br>
					$systemData[nombre]";
				$tunombre = $systemData['nombre'];		
				$tuemail = $systemData['mail_institucion'];
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
				$headers .= "From: $tunombre <$tuemail>\r\n"; 
				if(!mail($mail,$asunto,$mensaje,$headers))
				{
					if($flag == 0)
					{
						$msg ="Precaucion, no se ha podido enviar la orden por correo electronico al Usuario asignado.";
					}
					else{
						$msg ="Precaucion, no se ha podido enviar la orden por correo electronico a los Usuarios asignados.";
					}
				}																
				else{
					if($flag == 0){
						$msg="Mensaje enviado exitosamente a: $mail";
					}
					else{
						$msg="Los Mensajes han sido enviados exitosamente al grupo de usuarios asignado";
					}
				}
			}//end isset si correo no es vacio
			else {	$msg ="Precaucion, no se ha podido enviar la orden por correo electronico. El Usuario no tiene registrado su cuenta de correo";  }
  }
  return $msg;
}//END FUNCTION
?>
