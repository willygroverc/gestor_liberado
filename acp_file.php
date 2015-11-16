<?php  
if (isset($RETORNAR))
{
	header("location: lista_soliccambios.php?Naveg=Cambios >> Solicitud de Cambios");
}
include("top.php");
require_once('funciones.php');
$sql5="SELECT * FROM control_parametros";
$result5=mysql_db_query($db,$sql5,$link);
$row5=mysql_fetch_array($result5);
$tam_max=1048576*$row5['tam_archivo'];
$id_orden=SanitizeString($id_orden);
if (isset($reg_form)) 
{
	$sql5="SELECT * FROM control_parametros";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);

	$extension = explode(".",$archivo_name); 
	$num = count($extension)-1; 
	$tam_max=1048576*$row5['tam_archivo'];
	
	if($archivo_size < $tam_max){
		$sql2 = "SELECT Usr_archivos, Archivos, Hash_archi, Observ_archi FROM soliccambiodatos WHERE Codigo='$id_orden'";
		$result2=mysql_query($sql2);
		$row2=mysql_fetch_array($result2);
		$Usr_archivos1=explode("|*|",$row2['Usr_archivos']);
		$Archivos1=explode("|*|",$row2['Archivos']);
		$Hash_archi1=explode("|*|",$row2['Hash_archi']);
		$Observ_archi1=explode("|*|",$row2['Observ_archi']);

		if($Archivos1[0]==""){$numero=1;}
		else {$numero=count($Archivos1)+1;}
		$arch_nomb = "Archivo_cambio_".$id_orden."_".$numero.".".$extension[$num];
		if($archivo){$hash_nomb = md5_file($archivo);}
		else{$hash_nomb="SIN HASH";}
				
		if($Usr_archivos1[0]=="") {$cadena1=$login;}
		else 
		{
			array_push($Usr_archivos1,$login);
			$cadena1=implode("|*|",$Usr_archivos1);
		}
		
		if($Archivos1[0]=="") {$cadena2=$arch_nomb;}
		else 
		{
			array_push($Archivos1,$arch_nomb);
			$cadena2=implode("|*|",$Archivos1);
		}
		
		if($Hash_archi1[0]=="") {$cadena3=$hash_nomb;}
		else 
		{
			array_push($Hash_archi1,$hash_nomb);
			$cadena3=implode("|*|",$Hash_archi1);
		}
		
		if($Observ_archi1[0]=="") {$cadena4=$Observ_archi;}
		else 
		{
			array_push($Observ_archi1,$Observ_archi);
			$cadena4=implode("|*|",$Observ_archi1);
		}
		require_once('funciones.php');
		$cadena1=SanitizeString($cadena1);
		$cadena2=SanitizeString($cadena2);
		$cadena3=SanitizeString($cadena3);
		$cadena4=SanitizeString($cadena4);
		$sql="UPDATE soliccambiodatos SET Usr_archivos='$cadena1', Archivos='$cadena2', Hash_archi='$cadena3', Observ_archi='$cadena4' WHERE Codigo='$id_orden'";
		mysql_db_query($db,$sql,$link);
		copy($archivo,"archivos adjuntos/".$arch_nomb);
	}else{
		unset($msg);
		$msg="EL TAMAÑO DEL ARCHIVO ADJUNTO NO DEBE SER MAYOR A ".$row5['tam_archivo']." Mb";
	}
}
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
print $valid->toHtml ();
?>

<script language="JavaScript">
<!--
function Form () 
{
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>


<form name="form1" method="post" enctype="multipart/form-data">
 <table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" background="images/fondo.jpg">
    <tr> 
      <td> 
        <table width="100%" border="1" align="center" cellpadding="2" cellspacing="1">
          <tr> 
            <th colspan="8">CAMBIOS EN PRODUCCION- ADJUNTOS</th>
          </tr>
          <tr align="center"> 
            <td height="77" colspan="8"><div align="left">
                <table width="100%" border="0">
                  <tr>
				    <td width="10%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Orden 
                      Nro :</strong></font></td>
                    <td width="90%"><input name="id_orden" type="text" value="<?php echo $id_orden;?>" size="3" readonly=""></td>
                  </tr>
                  <tr>
                    <td valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Descripcion:</strong></font></td>
                    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                      	<?php 
						$sqlTmp="SELECT desc_inc FROM ordenes WHERE id_orden='$id_orden'";
						$ordenTmp=mysql_fetch_array(mysql_query($sqlTmp));
						echo $ordenTmp['desc_inc'];
					?>
                      </font></td>
                  </tr>
                </table>
                <hr>
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font> 
              </div>
              
            </td>
          </tr>
        </table>
		 <input name="id_orden" type="hidden" value="<?php echo $id_orden;?>">
		 <input name="id_segui" type="hidden" value="<?php echo $id_segui;?>">
		 <input name="var2" type="hidden" value="<?php echo $var2;?>">
        <br>
        <table width="700" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="9" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              ARCHIVOS ADJUNTOS</font></th>
          </tr>
          <tr> 
            <th width="20" height="26" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="150" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">ADJUNTADO 
              POR </font></th>
            <th width="100" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ARCHIVO</font></th>
            <th width="200" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">HASH</font></th>
            <th width="300" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></th>
          </tr>
          <?php 
		  	$sql_aas="SELECT Usr_archivos, Archivos, Hash_archi, Observ_archi FROM soliccambiodatos WHERE Codigo='$id_orden'";
			//echo $sql_aas; 
			$row_aas=mysql_fetch_array(mysql_db_query($db,$sql_aas, $link));
			
			if($row_aas['Archivos']!="")
			{	
				$usr_ar1=explode("|*|",$row_aas['Usr_archivos']);
				$arch1=explode("|*|",$row_aas['Archivos']);
				$arch2=count($arch1);
				$ha_ar1=explode("|*|",$row_aas['Hash_archi']);
				$ob_ar1=explode("|*|",$row_aas['Observ_archi']);
				
				for($c=0;$c<$arch2;$c++)
				{
		  ?>
          <tr align="center"> 
            <td width="20" height="26" nowrap> 
              <?php echo $c+1;?>
              &nbsp;</td>
            <td width="150" nowrap> 
              <?php 
					$sql_us="SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$usr_ar1[$c]'";
					$row_us=mysql_fetch_array(mysql_db_query($db,$sql_us,$link));
					echo "$row_us[nom_usr] $row_us[apa_usr] $row_us[ama_usr]";?>
              &nbsp;</td>
            <td width="100" nowrap> 
              <?php 
					$nom_ar=explode("_",$arch1[$c]);
					$nom_ar1="$nom_ar[0]_$nom_ar[1]_$nom_ar[3]";			
					echo "<a href=\"archivos adjuntos/$arch1[$c]\" target=\"_blank\">$nom_ar1</a>";?>
              &nbsp;</td>
            <td width="200" nowrap> 
              <?php echo $ha_ar1[$c];?>
              &nbsp;</td>
            <td width="300"><?php echo $ob_ar1[$c];?>&nbsp;</td>
          </tr>
          <?php }
		  }?>
          <tr> 
            <td height="26" colspan="5" nowrap>&nbsp;</td>
          </tr>
        </table>
          <table width="100%" border="1">
                  <tr>
                    <td width="67%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2"><strong>ARCHIVO 
                        A ADJUNTAR</strong></font></div></td>
                    
            <td width="33%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2"><strong>OBSERVACIONES</strong></font></div></td>
                  </tr>
                  <tr>
                    <td height="59"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
                <tr> 
                  <td height="18" align="center"> 
                    <div align="left"><font color="#000000" size="2"><strong>Tamano 
                      maximo: 
                      <?php echo "$row5[tam_archivo] Mb";?>
                      </strong></font></div></td>
                </tr>
                <tr> 
                  <td align="center"> <div align="center"> 
                      <input name="archivo" type="file" size="60" value="<?php print $arch_adj;?>">
                    </div></td>
                </tr>
              </table></td>
                    
            <td><textarea name="Observ_archi" cols="30" rows="3" onKeyDown="textCounter(form1.Observ_archi,form1.remLen,200);" onKeyUp="textCounter(form1.Observ_archi,form1.remLen,200);"></textarea></td>
			<input name="remLen" type="hidden" value="200">
                  </tr>
                </table>
        <div align="center"><br>
          <input name="reg_form" type="submit" value="ADJUNTAR" onClick="return validar()" >
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input name="RETORNAR" type="submit" value="RETORNAR">
          <br>
          <br>
        </div></td>
    </tr>
  </table>
</form>
<script language="JavaScript">
		<!-- 
<?php 	if ($msg) 
	{
		print "var msg=\"$msg\";\n";
		print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
	} 
?>
function validar()
{
	msg1 = "\nMensaje generado por GesTor F1.";
	sCad = "";
	if(document.form1.archivo.value == ""){sCad = sCad + "Primero seleccione el archivo a adjuntar\n";}
	else if(document.form1.observ_arch.value == ""){sCad = sCad + "\nEl campo Observaciones no puede ser vacio\n";}
	if(sCad == ""){return true;}
	else
	{
		sCad = sCad + msg1;
		alert(sCad);
		return false;
	}
}
function textCounter(field, countfield, maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
	field.value = field.value.substring(0, maxlimit);
	// otherwise, update 'characters left' counter
	else 
	countfield.value = maxlimit - field.value.length;
	}
</script>
<?php include("top_.php");?> 
