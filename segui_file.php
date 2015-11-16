<?php 
if ($RETORNAR)
{
	header("location: segui.php?id_orden=$id_orden&var2=$var2");
}
include("top.php");
$sql5="SELECT * FROM control_parametros";
$result5=mysql_db_query($db,$sql5,$link);
$row5=mysql_fetch_array($result5);
$tam_max=1048576*$row5[tam_archivo];
if (isset($reg_form)) 
{
	$sql5="SELECT * FROM control_parametros";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);

	$extension = explode(".",$archivo_name); 
	$num = count($extension)-1; 
	$tam_max=1048576*$row5[tam_archivo];
	
	if($archivo_size < $tam_max){
		$sql2 = "SELECT usr_archivos, archivos, hash_archi, observ_arch FROM seguimiento WHERE id_seg='$id_segui'";
		$result2=mysql_db_query($db,$sql2,$link);
		$row2=mysql_fetch_array($result2);
		$usr_archivos1=explode("|*|",$row2['usr_archivos']);
		$archivos1=explode("|*|",$row2['archivos']);
		$hash_archi1=explode("|*|",$row2['hash_archi']);
		$observ_arch1=explode("|*|",$row2['observ_arch']);

		if($archivos1[0]==""){$numero=1;}
		else {$numero=count($archivos1)+1;}
		$arch_nomb = "Archivo_segui_".$id_segui."_".$numero.".".$extension[$num];
		if($archivo){$hash_nomb= md5_file($archivo);}
		else{$hash_nomb="SIN HASH";}
				
		if($usr_archivos1[0]=="") {$cadena1=$login;}
		else 
		{
			array_push($usr_archivos1,$login);
			$cadena1=implode("|*|",$usr_archivos1);
		}
		
		if($archivos1[0]=="") {$cadena2=$arch_nomb;}
		else 
		{
			array_push($archivos1,$arch_nomb);
			$cadena2=implode("|*|",$archivos1);
		}
		
		if($hash_archi1[0]=="") {$cadena3=$hash_nomb;}
		else 
		{
			array_push($hash_archi1,$hash_nomb);
			$cadena3=implode("|*|",$hash_archi1);
		}
		
		if($observ_arch1[0]=="") {$cadena4=$observ_arch;}
		else 
		{
			array_push($observ_arch1,$observ_arch);
			$cadena4=implode("|*|",$observ_arch1);
		}
		
		$sql="UPDATE seguimiento SET usr_archivos='$cadena1', archivos='$cadena2', hash_archi='$cadena3', observ_arch='$cadena4' WHERE id_seg='$id_segui'";
		mysql_db_query($db,$sql,$link);
		copy($archivo,"archivos adjuntos/".$arch_nomb);
	}else{
		unset($msg);
		$msg="EL TAMAÑO DEL ARCHIVO ADJUNTO NO DEBE SER MAYOR A ".$row5[tam_archivo]." Mb";
	}
}
?>

<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
//$valid->addExists ( "estado_seg",  "Estado, $errorMsgJs[empty]" );
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
            <th colspan="8">SEGUIMIENTO - ADJUNTOS</th>
          </tr>
          <tr align="center"> 
            <td height="123" colspan="8"><div align="left">
                <table width="100%" border="0">
                  <tr>
				  <?php 
				  	$sql_se = "SELECT id_orden, estado_seg, obs_seg FROM seguimiento WHERE id_seg='$id_segui' ORDER BY fecha_seg ASC, hora_seg ASC";
					$res_se=mysql_fetch_array(mysql_db_query($db, $sql_se, $link));
				  ?>
                    <td width="10%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Orden 
                      Nro :</strong></font></td>
                    <td width="90%"><input name="id_orden" type="text" value="<?php echo $res_se[id_orden];?>" size="3" readonly=""></td>
                  </tr>
                  <tr>
                    <td valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Descripcion:</strong></font></td>
                    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                      	<?php 
						$sqlTmp="SELECT desc_inc FROM ordenes WHERE id_orden=$res_se[id_orden]";
						$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
						echo $ordenTmp[desc_inc];
					?>
                      </font></td>
                  </tr>
                </table>
                <hr>
                <table width="100%" border="0">
                  <tr> 
                    <td width="10%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Estado 
                      :</strong></font></td>
                    <td width="90%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <?php 
						if ($res_se[estado_seg]=="1")
						{echo "Cumplida en fecha";}
						if ($res_se[estado_seg]=="2")
						{echo "Cumplida retrasada";}
						if ($res_se[estado_seg]=="3")
						{echo "Pendiente en fecha";}
						if ($res_se[estado_seg]=="4")
						{echo "Pendiente retrasada";}
						if ($res_se[estado_seg]=="5")
						{echo "Desestimada";}
					?>
                      </font> </td>
                  </tr>
                  <tr> 
                    <td valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Observacion:</strong></font></td>
                    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <?php echo $res_se[obs_seg];?>
                      </font></td>
                  </tr>
                </table>
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font> 
              </div>
              
            </td>
          </tr>
        </table>
		 <input name="id_orden" type="hidden" value="<?php echo $res_se[id_orden];?>">
		 <input name="id_segui" type="hidden" value="<?php echo $id_segui;?>">
		 <input name="var2" type="hidden" value="<?php echo $var2;?>">
        <br>
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="9" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              ARCHIVOS ADJUNTOS</font></th>
          </tr>
          <tr> 
            <th width="8%" height="26" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="23%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">ADJUNTADO 
              POR </font></th>
            <th width="23%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ARCHIVO</font></th>
            <th width="20%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">HASH</font></th>
            <th width="26%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></th>
          </tr>
          <?php 
		  	$sql_aas="SELECT usr_archivos, archivos, hash_archi, observ_arch FROM seguimiento WHERE id_seg='$id_segui'";
			$row_aas=mysql_fetch_array(mysql_db_query($db,$sql_aas, $link));
			
			if($row_aas[archivos]!="")
			{	
				$usr_ar1=explode("|*|",$row_aas[usr_archivos]);
				$arch1=explode("|*|",$row_aas[archivos]);
				$arch2=count($arch1);
				$ha_ar1=explode("|*|",$row_aas[hash_archi]);
				$ob_ar1=explode("|*|",$row_aas[observ_arch]);
				
				for($c=0;$c<$arch2;$c++)
				{
		  ?>
          <tr align="center"> 
            <td height="26" nowrap> 
              <?php echo $c+1;?>
              &nbsp;</td>
            <td nowrap> 
              <?php 
					$sql_us="SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$usr_ar1[$c]'";
					$row_us=mysql_fetch_array(mysql_db_query($db,$sql_us,$link));
					echo "$row_us[nom_usr] $row_us[apa_usr] $row_us[ama_usr]";?>
              &nbsp;</td>
            <td nowrap> 
              <?php 
					$nom_ar=explode("_",$arch1[$c]);
					$nom_ar1="$nom_ar[0]_$nom_ar[1]_$nom_ar[3]";			
					echo "<a href=\"archivos adjuntos/$arch1[$c]\" target=\"_blank\">$nom_ar1</a>";?>
              &nbsp;</td>
            <td nowrap> 
              <?php echo $ha_ar1[$c];?>
              &nbsp;</td>
            <td width="300" nowrap><?php echo $ob_ar1[$c];?>&nbsp;</td>
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
                    
            <td><textarea name="observ_arch" cols="30" rows="3" onKeyDown="textCounter(form1.observ_arch,form1.remLen,200);" onKeyUp="textCounter(form1.observ_arch,form1.remLen,200);"></textarea></td>
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
		<?php 	if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
			
		} ?>
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
//-->
</script>
<SCRIPT LANGUAGE="JavaScript">
<!-- 
function textCounter(field, countfield, maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
	field.value = field.value.substring(0, maxlimit);
	// otherwise, update 'characters left' counter
	else 
	countfield.value = maxlimit - field.value.length;
	}
// End 
-->
</script>
<?php include("top_.php");?> 
