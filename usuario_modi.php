<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
$_SESSION['modulo']='usuario_modi';
require ("conexion.php");
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']!='A'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}
$login_usr=$_GET['login_usr'];
$login_r=$_SESSION["login"];
$sql="SELECT pass_longitud, pass_secuencial, pass_repetidos FROM control_parametros";
$rs=mysql_query($sql); 
$pass=mysql_fetch_array($rs);
require_once('funciones.php');
//$login_usr=SanitizeString($login_usr);
$sql_d="SELECT password_usr FROM users WHERE login_usr='$login_usr'";
$rs_d=mysql_query($sql_d); 
$pass_d=mysql_fetch_array($rs_d);
$pass_longitud = $pass["pass_longitud"];


include("top.php");
//$login_usr=SanitizeString($login_usr);
$sql0 = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacion, DATE_FORMAT(fecha_eliminacion, '%d/%m/%Y') AS fecha_eliminacion FROM users WHERE login_usr='$login_usr'";
$result0=mysql_query($sql0);
$row0=mysql_fetch_array($result0);

?>
<link href="css/validation.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<style>
	#passwordStrength{
	height:10px;
	display:block;
	float:left;
	margin-left:100px;
}

.strength0{
	margin-left:100px;
	width:250px;
	background:#cccccc;
}

.strength1{
	margin-left:100px;
	width:50px;
	background:#ff0000;
}

.strength2{
	margin-left:100px;
	width:100px;	
	background:#ff5f5f;
}

.strength3{
	margin-left:100px;
	width:150px;
	background:#56e500;
}

.strength4{
	margin-left:100px;
	background:#4dcd00;
	width:200px;
}

.strength5{
	margin-left:100px;
	background:#399800;
	width:250px;
}

</style>
<script language="JavaScript" src="js/usuarios.js"></script>
<script language="javascript" src="js/validate.js"></script>
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript" src="js/ajax.js"></script>
<script language="javascript" src="js/modal.js"></script>
<script language="javascript" src="js/usuarios.js"></script>
<script>
	function pass_seguro(password){
		var desc = new Array();
		desc[0] = "Muy Debil";
		desc[1] = "Debil";
		desc[2] = "Mejor";
		desc[3] = "Medio";
		desc[4] = "Fuerte";
		desc[5] = "Muy Fuerte";

		var score   = 0;

		//if password bigger than 6 give 1 point
		if (password.length > 6) score++;

		//if password has both lower and uppercase characters give 1 point	
		if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;

		//if password has at least one number give 1 point
		if (password.match(/\d+/)) score++;

		//if password has at least one special caracther give 1 point
		if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;

		//if password bigger than 12 give another 1 point
		if (password.length > 12) score++;

		 document.getElementById("passwordDescription").innerHTML = desc[score];
		 document.getElementById("passwordStrength").className = "strength" + score;
	}
</script>
	
<form name="form1" action="usuario_modi.php" method="post">
  <table width="90%" border="1" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
	<tr> 
		<th align="center" background="images/main-button-tileR2.jpg" height="25">USUARIO
		<?php 
			echo ' - Creado el: '.$row0['fecha_creacion']; 
			if ($row0['bloquear']==2)
				echo ' - Eliminado el: '.$row0['fecha_eliminacion'];
		?>
		</th>
	</tr>
	<tr> 
		<td align="center"><br> 
			<table border="1" class="tbl1" >
				<tr>
					<td>LOGIN:</td>
					<td><input name="login_usr" type="text" id="login_usr" value="<?php echo $row0['login_usr'];?>" size="25" maxlength="25" readonly></td>
					
					<td>PASSWORD:</td>
					<td><input name="password_usr" type="password" id="password_usr" value="************" onkeyup="pass_seguro(this.value)" size="25" maxlength="20" disabled="true"></td>
					
					<td>TIPO:</td>
					<td>
						<select name="tipo2_usr" id="tipo2_usr">
							<option value="A" <?php if ($row0['tipo2_usr']=="A") echo "selected";?>>Administrador</option>
							<option value="B" <?php if ($row0['tipo2_usr']=="B") echo "selected"; ?>>Backup</option>
							<option value="C" <?php if ($row0['tipo2_usr']=="C") echo "selected";?>>Cliente</option>
							<option value="T" <?php if ($row0['tipo2_usr']=="T") echo "selected";?>>Tecnico</option>
						</select>
					</td>
				</tr>
				<tr> 
					<td>EMAIL:</td>
					<td>
						<input name="email_usr" id="email_usr" value="<?php echo $row0['email'];?>" size="25" maxlength="50">
					</td>
					<td>PASSWORD<br>(REPETIR)</td>
					<td>
						<input name="password_usr2" type="password" id="password_usr2" value="************" size="25" maxlength="20" disabled="true">
					</td>
					<td align="right">CLIENTE:</td>
					<td>
						Interno 
						<input name="tipo_usr" id="tipo_usr" type="radio" value="INTERNO" <?php if ($row0['tipo_usr']=="INTERNO") echo "checked";?>>
						Externo 
						<input type="radio" name="tipo_usr" id="tipo_usr" value="EXTERNO" <?php if ($row0['tipo_usr']=="EXTERNO") echo "checked";?>>
					</td>
				</tr>
				<tr>
					<td>EMAIL ALTERNATIVO</td>
					<td><input name="email_alter_usr" id="email_alter_usr" value="<?php echo $row0['email_alter'];?>" size="25" maxlength="50"></td>
					<td colspan="4" align="center">
						<input type="hidden" name="sw_pass" id="sw_pass" value="0"></input>
						<h5><div id="lbl_pass"><a href="javascript:habilitar_edicion_pass();">Habilitar Modificacion de Password</a></div></h5>
					</td>
				</tr>
				<tr>
					<th colspan="6"></th>
				</tr>
          </table>
		  <br>
		  <table border="1" class="tbl1">
			<tr> 
				<th colspan="6"><strong>Datos del Cliente:</strong></th>
			</tr>
			<tr> 
				<td>NOMBRES</td>
				<td><input name="nom_usr" type="text" id="nom_usr" value="<?php echo $row0['nom_usr'];?>" size="20" maxlength="20">
				</td>
				<td>AP.PATERNO:</td>
				<td><input name="apa_usr" type="text" id="apa_usr" value="<?php echo $row0['apa_usr'];?>" size="20" maxlength="20">
				</td>
				<td>AP.MATERNO:</td>
				<td><input name="ama_usr" type="text" id="ama_usr" value="<?php echo $row0['ama_usr'];?>" size="20" maxlength="20">
				</td>
			</tr>
			<tr> 
				<td>ENTIDAD:</td>
				<td><input name="enti_usr" type="text" id="enti_usr" value="<?php echo $row0['enti_usr'];?>" size="20" maxlength="40">
				</td>
				<td>AREA:</td>
				<td><div id="ajax_area">
				<?php
					$sql="SELECT id_dadicional, nombre_dadicional FROM datos_adicionales WHERE tipo_dadicional='area'";
					$recordset=mysql_query($sql);
					echo '<select id="area_usr" name="area_usr">';
					echo '<option value="0">Sin Area</option>';
					for ($i=1;$i<=mysql_num_rows($recordset);$i++){
						$fila_area=mysql_fetch_array($recordset);
						if ($fila_area['id_dadicional']==$row0['area_usr'])
							echo '<option value="'.$fila_area['id_dadicional'].'" selected>'.$fila_area['nombre_dadicional'].'</option>';
						else
							echo '<option value="'.$fila_area['id_dadicional'].'">'.$fila_area['nombre_dadicional'].'</option>';
					}
					echo '</select>';
				?>
				<!--<a class="modal" href="javascript:mostrar_frm('frm_area.php','cmb_area');"><img src="images/btn_agregar.png" style="width:25px;"></img></a>-->
				<!--<a class="modal" href="javascript:TINY.box.show({url:\'lib/frm_area.php\',width:200,height:40})"><img src="images/btn_agregar.png" style="width:25px;"></img></a>-->
				</div></td>
				
				<td>ESPECIALIDAD:</td>
				<td><input name="esp_usr" type="text" id="esp_usr" value="<?php echo $row0['esp_usr'];?>" size="20" maxlength="100">
                </td>
			</tr>
			<tr> 
				<td>CARGO:</td>
				<td>
					<input name="cargo_usr" type="text" id="cargo_usr" value="<?php echo $row0['cargo_usr'];?>" size="20" maxlength="40">
				</td>
				<td>TELEFONO:</td>
				<td><input name="telf_usr" type="text" id="telf_usr" value="<?php echo $row0['telf_usr'];?>" size="20" maxlength="15">
				</td>
				<td>MOVIL:</td>
				<td><input name="ext_usr" type="text" id="ext_usr" value="<?php echo $row0['ext_usr'];?>" size="10" maxlength="8">
					<select name="id_dat_tel_movil" id="id_dat_tel_movil">
                <?php
					echo '<option value="0">Sin seleccionar</option>';
					$sql2 = "SELECT id_dat_tel_movil, nombre FROM dat_tel_movil ORDER BY nombre ASC";
 			  		$result2=mysql_query($sql2);
			  		while ($row2=mysql_fetch_array($result2)) {
						if ($row0['id_dat_tel_movil']==$row2['id_dat_tel_movil'])
							echo '<option value="'.$row2['id_dat_tel_movil'].'" selected>'.$row2['nombre'].'</option>';
						else
							echo '<option value="'.$row2['id_dat_tel_movil'].'">'.$row2['nombre'].'</option>';
					}
				?>
				</select>
				</td>
			</tr>
			<tr>
				<td>SUELDO:</td>
				<td><input name="costo_usr" id="costo_usr"type="text" value="<?php echo $row0['costo_usr'];?>" size="10" maxlength="25">
				</td>
            <td>AGENCIA:</td>
            <td align="left" valign="middle"><div id="ajax_agencia">
                <?php
					echo '<select name="agencia_usr" id="agencia_usr">';
					echo '<option value="0">Sin Agencia</option>';
					$sql = "SELECT id_dadicional, nombre_dadicional FROM datos_adicionales WHERE tipo_dadicional='agencia' ORDER BY nombre_dadicional ASC";
 			  		$recordset=mysql_query($sql);
			  		while ($fila_agencia=mysql_fetch_array($recordset)) {
						if ($row0['adicional1']==$fila_agencia['id_dadicional'])
							echo '<option value="'.$fila_agencia['id_dadicional'].'" selected>'.$fila_agencia['nombre_dadicional'].'</option>';
						else
							echo '<option value="'.$fila_agencia['id_dadicional'].'">'.$fila_agencia['nombre_dadicional'].'</option>';
					}
					echo '</select>';
				?>
				<!--<a href="javascript:mostrar_frm('frm_agencia.php','cmb_agencia');"><img src="images/btn_agregar.png" style="width:25px;"></img></a>-->
                <!--<a class="modal" href="javascript:TINY.box.show({url:\'lib/frm_agencia.php\',width:200,height:40})"><img src="images/btn_agregar.png" style="width:25px;"></img></a>-->
			  </div></td>
          </tr>
          <tr> 
            <td colspan="6"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          </tr>
          <tr> 
            <th colspan="6">Ubicaci�n Fisica</strong></th>
          </tr>
          <tr> 
            <td>CIUDAD:</td>
            <td><input name="ciu_usr" type="text" id="ciu_usr" value="<?php echo $row0['ciu_usr'];?>" size="20"></td>
            <td>DIRECCION:</td>
            <td colspan="2"><input name="direc_usr" size="50" type="text" id="direc_usr" value="<?php echo $row0['direc_usr'];?>" size="20"></td>
			<td>
				<input type="button" value="GUARDAR" onclick="guardar_edicion();">&nbsp;<input name="reg_usr" type="button" value="RETORNAR" onclick="retornar(1);">
			</td>
		  </tr>
		  <tr>
            <th colspan="6"></th>
          </tr>
        </table>
		<br>
		<div id="lbl_ajax">
			<div style="display: none;" class="success_box"></div>
			<div style="display: block;" class="error_box" id="error_box">Los campos con marcados con (*) son obligatorios</div>
		</div>
</td> 
</tr> 
</table>
<br>
</form>
 
