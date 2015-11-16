<?php
include("top.php");
echo '<script language="javascript" src="js/ajax.js"></script>';
echo '<script language="javascript" src="js/usuarios.js"></script>';
@session_start();
$login_usr = $_SESSION["login"];
require ("conexion.php");
$sql = "SELECT u.login_usr, u.password_usr, u.tipo_usr, u.tipo2_usr, u.nom_usr, u.apa_usr, u.ama_usr, u.email, u.email_alter, u.enti_usr, u.cargo_usr, 
		da.nombre_dadicional, telf_usr, u.ext_usr, u.ciu_usr, u.direc_usr, u.esp_usr, u.datetimereg_usr, u.bloquear 
		FROM users u LEFT JOIN datos_adicionales da ON u.area_usr=da.id_dadicional
		WHERE u.login_usr='".$_SESSION['login']."' ";
$recordset=mysql_query($sql);
$fila=mysql_fetch_array($recordset);

echo '<table border="0" cellpadding="2" cellspacing="0" background="images/fondo.jpg" width="70%">
		   <tr> 
			  <th align="center" background="images/main-button-tileR2.jpg" height="30">DATOS DE USUARIO</th>
		   </tr>
			<tr> 
			  <td align="center"> 
			  <br>
				<table class="tbl1" border="1" >
					<tr><th colspan="4" class="menu">PERFIL DE USUARIO</th></tr>
					<tr> 
						<td align="right"><strong>Login:</strong></td>
						<td>'.$_SESSION['login'].'</td>
						<td align="right"><strong>Correo:</strong></td>
						<td align="center">';
						if ($fila['email']=='')
							echo '<font color="red">No se ha establecido un correo electr&oacute;nico</font>';
						else
							echo $fila['email'];
						echo '</td>
					</tr>
					<tr> 
						<td align="right"><strong>Tipo:</strong></td>
						<td align="center">';
							if ($fila['tipo2_usr']=="C"){
								echo "Cliente";
							}
							if ($fila['tipo2_usr']=="T"){ 
								echo "Tecnico ";
							}
						
							echo '<input name="password_copy" type="hidden" value="'.$fila['password_usr'].'">
							</td>
							<td align="right"><strong>Correo Alternativo:</strong></td>
							<td>'.$fila['email_alter'].'</td>
					</tr>
					<tr> 
						<td align="right"><strong>Cliente:</strong></td>
						<td colspan="3" align="center">Interno'; 
						if ($fila['tipo_usr']=="INTERNO"){
							echo '<img src="images/si1.gif" border="1">';}
						else{
							echo '<img src="images/no1.gif" border="1">';}
						
						echo 'Externo';  
						if ($fila['tipo_usr']=="EXTERNO"){
							echo '<img src="images/si1.gif" border="1">';}
						else{
							echo '<img src="images/no1.gif" border="1">';}
						
						echo '</td>
					</tr>
				 </table>
				 </td>
			</tr>
		<tr>
		<td align="center">
		 <br>
		 <table class="tbl1" border="1">
			<tr> 
				<th colspan="7" class="menu">INFORMACION PERSONAL</th>
			</tr>
			<tr> 
				<td align="right"><strong>NOMBRES:</strong></td><td colspan="2">'.$fila['nom_usr'].'</td>
				<td align="right"><strong>AP. PATERNO:</strong></td><td>'.$fila['apa_usr'].'</td>
				<td align="right"><strong>AP.MATERNO:</td><td>'.$fila['ama_usr'].'</td>
			</tr>
			<tr> 
				<td align="right"><strong>ENTIDAD:</strong></td>
				<td colspan="2">'.$fila['enti_usr'].'</td>
				<td align="right"><strong>AREA:</strong></td>
				<td>'.$fila['nombre_dadicional'].'</td>
				<td align="right"><strong>ESPECIALIDAD:</strong></td>
				<td align="left">'.$fila['esp_usr'].'&nbsp;</td>
			</tr>
			<tr>
				<td align="right"><strong>CARGO:</strong></td>
				<td colspan="2">'.$fila['cargo_usr'].'</td>
				<td align="right"><strong>TELEFONO:</strong></td>
				<td>'.$fila['telf_usr'].'</td>
				<td align="right"><strong>CELULAR:</strong></td>
				<td>'.$fila['ext_usr'].'&nbsp;</td>
			</tr>
			<tr>
				<th colspan="7" class="menu">UBICACION FISICA</th>
			</tr>
			<tr> 
				<td align="right" colspan="2"><strong>CIUDAD:</strong></td>
				<td>'.$fila['ciu_usr'].'</td>
				<td align="right"><strong>DIRECCION:</strong></td>
				<td colspan="3">'.$fila['direc_usr'].'</td>
			</tr>
         </table>
		 <br>';
		 if ($_SESSION['tipo']=='T'){
			echo '<table class="tbl1" border="1">
			<tr>
				<th colspan="2" class="menu">OPCIONES</th>
			</tr>
			<tr>
				<td><b>Modo de Asignaci&oacute;n:</b></td>
				<td align="left">';
				$sql="SELECT visualizacion, visualizacion_1 FROM users WHERE login_usr='$login_usr'";
				$recordset=mysql_query($sql);
				$fila=mysql_fetch_array($recordset);
				echo '<select id="vista1" name="vista1">';
					if ($fila['visualizacion']==0){
						echo '<option value="0" selected>Normal</option>';
						echo '<option value="1">R&aacute;pida</option>';
					}
					else{
						echo '<option value="0">Normal</option>';	
						echo '<option value="1" selected>R&aacute;pida</option>';
					}
				echo '</select></td>
				</tr>
				<tr>
					<td><b>Registro de Ordenes:</b></td>
					<td align="left">
						<select id="vista2" name="vista2">';
						if ($fila['visualizacion']==0){
							echo '<option value="0" selected>Sin cliente titular</option>';
							echo '<option value="1">Con cliente titular</option>';
						}
						else{
							echo '<option value="0">Sin cliente titular</option>';
							echo '<option value="1" selected>Con cliente titular</option>';
						}
				echo '</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="button" value="GUARDAR" onclick="guardar_opciones(\''.$_SESSION['login'].'\');"></input></td>
				</tr>';
			
    echo '</table><br>';
}