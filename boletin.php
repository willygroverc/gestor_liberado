<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
require ("conexion.php");
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

if (isset($_REQUEST['retornar'])) {header("location: menu_parametros.php");}
if (isset($_REQUEST['reg_form'])) 
{
	session_start();
	$login=$_SESSION["login"];
	if ($_REQUEST['desc_bol']=="")
		{$msg="Descripcion, no puede ser un campo vacio";}
	if ($_REQUEST['clasificacion']=="0")
		{$msg="Clasificacion, no puede ser un campo vacio";}
	if (($_REQUEST['desc_bol']<>"") and ($_REQUEST['clasificacion']<>"0"))
	{
		if ($archivo_name=="")				
		{
			$sql="INSERT INTO boletin (fecha, hora, cod_usr, desc_bol, clasificacion) ".
			"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$_REQUEST[desc_bol]','$_REQUEST[clasificacion]')"; 
			mysql_query($sql);
	//		$desc_bol=""; 
//			header("location:boletin.php");
		}
		elseif ($archivo_name<>"")
		{	
			$extension = explode(".",$archivo_name); 
			$num = count($extension)-1; 
			$tam_max=1048576*7;
			if($archivo_size < $tam_max)
			{
				$sql="INSERT INTO boletin (fecha, hora, cod_usr, desc_bol, clasificacion) ".
				"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$desc_bol','$clasificacion')"; 
				mysql_query($sql); 
				$sql1="SELECT MAX(id_boletin) AS id_bol FROM boletin"; 
				$result1=mysql_query($sql1);
				$row1=mysql_fetch_array($result1);
				$arch_nomb = "bol".$row1[id_bol].".".$extension[$num];
				$sql2="UPDATE boletin SET nomb_archivo='$arch_nomb' WHERE id_boletin='$row1[id_bol]'";
				mysql_query($sql2);	
				copy($archivo,"archivos adjuntos/".$arch_nomb);
		//		$desc_bol="";
//				header("location:boletin.php");
			}
			else{$msg="EL TAMA�O DEL ARCHIVO ADJUNTO NO DEBE SER MAYOR A 7 Mb";}
		}
	}
	if($mail==1 || $sms==1){
		$mail_msg=$desc_bol;
		if(strlen($desc_bol)>150) $mail_sms=substr($desc_bol,0,150)." ...";
		else $mail_sms=$desc_bol;
		$asunto="BOLETIN-Gestor TI";
		if($clasificacion=="interno") $sql_msg="SELECT email, ext_usr, id_dat_tel_movil FROM users WHERE bloquear=0";
		if($clasificacion=="reservado") $sql_msg="SELECT email, ext_usr, id_dat_tel_movil FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0";
		$res_msg=mysql_query($sql_msg);
		while($row_msg=mysql_fetch_array($res_msg)){
			if($mail==1) @mail($row_msg[email],$asunto,$mail_msg);
			if($sms==1){ 
				$dat="SELECT direccion FROM dat_tel_movil WHERE id_dat_tel_movil='$row_msg[id_dat_tel_movil]'";
				$res_dat=mysql_query($dat);
				$row_dat=mysql_fetch_array($res_dat);
				@mail("591".$row_msg[ext_usr]."@".$row_dat[direccion],$asunto,$mail_sms);
			}
		}
	}
}
?>
<?php
include ("top.php");
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addExists ( "desc_bol", "Descripcion, $errorMsgJs[empty]" );
$valid->addExists ( "clasificacion", "Clasificacion, $errorMsgJs[empty]" );
$valid->addFunction ( "verifica_desc_bol",  "" );
echo $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function verifica_desc_bol () {
	var form = document.form1;
  	if ( form.desc_bol ) {
		if (form.desc_bol.value.length > 500)
			{ alert ("Descripcion, debe ser menor a 500 caracteres.\n \nMensaje generado por GesTor F1.");
			return false;} 
		return true; 
	}
}
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<form name="form1" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']?>" onKeyPress="return Form()">
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" >
  <tr bgcolor="#006699"> 
    <th colspan="2">BOLETIN INFORMATIVO</th>
  </tr>
  <tr>
    <td><table border="0" align="center" cellpadding="0" cellspacing="4">        
        <tr> 
          <td colspan="2" align="center"><strong>FECHA : <?php echo date("d/m/Y");?></strong><strong>&nbsp;&nbsp;HORA : <?php echo date("H:i:s");?></strong></td>
        </tr>
        <tr> 
          <td width="20%" align="right" class="normal"><strong>Descripcion :</strong></td>
		  <td width="80%" align="left"><textarea name="desc_bol" cols="50" rows="5" value="<?php echo $desc_bol; ?>"></textarea></td>
		</tr>
        <tr> 
          <td width="20%" align="right" class="normal"><strong>Clasificacion :</strong></td>
		  <td width="80%" align="left">
				<select name="clasificacion">
				<option value="interno">Interno</option>
				<option value="reservado" <?php if ($clasificacion=="reservado") echo "selected"; ?>>Reservado</option>
			    </select></td>
        </tr><br>
		<tr>
		    <td width="20%" align="right" class="normal"><strong>Tipo de Emision:</strong></td>
		<td> <input type="checkbox"  name="mail" value="1">
              Correo electronico &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <input name="sms" type="checkbox" id="sms" value="1">
              Mensaje por Celular </td>
		</tr>
        <tr> 
            <td width="5%" align="center"><br></td>
  		  <td width="48%" align="center"><div align="left"><b><font size="2" face="Arial, Helvetica, sans-serif"><br>
                Enviar Archivo Adjunto <br>
                </font></b><font size="2" face="Arial, Helvetica, sans-serif">( 
                tipo : .gif &nbsp;&nbsp;.jpg&nbsp;&nbsp; .doc &nbsp;&nbsp;&nbsp;&nbsp;y 
                &nbsp;&nbsp;tamano maximo : 7 Mb ) : </font> </div></td>
        </tr>
        <tr> 
          <td colspan="2" align="center"> <div align="center"><input name="archivo" type="file" size="60" value="<?php print $archivo ?>"><br></div></td>
        </tr>
        <tr> 
          <td height="43" colspan="2" align="center"><br><input name="reg_form" type="submit" value="GUARDAR" <?php print $valid->onSubmit() ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <input name="retornar" type="submit" value="RETORNAR">
		  </td>
        </tr>
		</table>
	  </tr>
	</td>	
</table>
  <p> 
    <?php include("pagina_inicio2.php")?>
</form>
<script language="JavaScript">
		<!-- 
		<?php 	if (isset($msg)) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
			
		} ?>
//-->
</script>