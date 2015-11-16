<?php 
if(isset($retornar))
{
	header("location: lista_proced.php");
}
ini_set("error_reporting", "E_ALL & ~E_NOTICE & ~E_WARNING");
include ("conexion.php");
$sql="SELECT detalles_pro, resp_act FROM proced WHERE ordenamiento='$id_pro'";
$rs=mysql_db_query($db,$sql,$link);
$rw=mysql_fetch_array($rs);
$tmp=explode("*|*",$rw[detalles_pro]);
$tmp2=explode("*|*",$rw[resp_act]);
foreach($tmp as $valor){
	$solucion[$valor]=$valor;
}
while ($tmp=mysql_fetch_array($rs)) {
	$lstTecnico[$tmp[login_usr]]=$tmp[nombre];
}
////////////////
if (isset($GUARDAR))
{
	if(!$id_pro)
	{	$sql_m="SELECT MAX(id_pro) AS id_pro FROM proced";
		$result_m=mysql_db_query($db,$sql_m,$link);
		$row_m=mysql_fetch_array($result_m);
		$id_pro=$row_m[id_pro]+1;
	}
	
	unset($msg_e);
	if(strlen($detalles_pro)<2 && $elim!="si")
	{	
		$id_pro=$id_pro;
		$pg=$pg;
		$msg_e="La Actividad debe contener al menos dos caracteres";
	}
	elseif($resp_act=="0" AND ($opt=="0" OR $opt=="1"))
	{	
		$id_pro=$id_pro;
		$pg=$pg;
		$msg_e="Debe seleccionar un Responsable";
	}
	else
	{
		$sel="SELECT detalles_pro,resp_act FROM proced WHERE ordenamiento='$id_pro'";
		$res_sel=mysql_db_query($db,$sel,$link);
		$row_sel=mysql_fetch_array($res_sel);
		$numero=mysql_num_rows($res_sel);
		$soluciones=explode("*|*",$row_sel[detalles_pro]);
		$soluciones_2=explode("*|*",$row_sel[resp_act]);
		$num_sols=count($soluciones);
		if($numero==0){	
			$sql3="INSERT INTO proced (titulo_pro,detalles_pro,resp_act,ordenamiento) ".
			"VALUES('$titulo_pro','$detalles_pro','$resp_act','$id_pro')";
			mysql_db_query($db,$sql3,$link);
			$detalles_pro="";
		}
		else
		{
			if($opt=='0')
			{
				for($i=$num_sols;$i>=$ordena;$i--)
				{
					$soluciones[$i]=$soluciones[$i-1];
				}
				for($j=$num_sols;$j>=$ordena;$j--)
				{
					$soluciones_2[$j]=$soluciones_2[$j-1];
				}
			}
			if($opt=='2')
			{
				$soluciones[$num_sols]="--fin-->";
				for($i=$ordena;$i<=$num_sols;$i++)
				{
					$soluciones[$i-1]=$soluciones[$i];
				}
				
				$soluciones_2[$num_sols]="--fin-->";
				for($j=$ordena;$j<=$num_sols;$j++)
				{
					$soluciones_2[$j-1]=$soluciones_2[$j];
				}
			}
			if($opt!='2')
			{ 
				$soluciones[$ordena-1]=$detalles_pro;
				$soluciones_2[$ordena-1]=$resp_act;
			}
			$detalle=implode("*|*",$soluciones);
			$detalle=str_replace("*|*--fin-->","",$detalle);
			$detalle=str_replace("--fin-->","",$detalle);
			$detalle_inv=strrev($detalle);
			
				
			$detalle2=implode("*|*",$soluciones_2);
			$detalle2=str_replace("*|*--fin-->","",$detalle2);
			$detalle2=str_replace("--fin-->","",$detalle2);
			$detalle_inv2=strrev($detalle2);
			
			if(substr($detalle_inv,0,3)=="*|*") $detalle=strrev(substr($detalle_inv,3));
			if(substr($detalle_inv2,0,3)=="*|*") $detalle2=strrev(substr($detalle_inv2,3));
			$sql3="UPDATE proced SET detalles_pro='$detalle',resp_act='$detalle2', titulo_pro='$titulo_pro' WHERE ordenamiento='$id_pro'";
			mysql_db_query($db,$sql3,$link);
			$detalles_pro="";
		}
	}
}
if (isset($reg_form))
{
	$sql_ver="SELECT detalles_pro FROM proced WHERE ordenamiento='$id_pro'";
	$res_ver=mysql_db_query($db,$sql_ver,$link);
	$row_ver=mysql_fetch_array($res_ver);

	if($row_ver[detalles_pro]!="")
	{
		$sql3="UPDATE proced SET titulo_pro='$titulo_pro',login_pro='$login_pro',resp_pro='$resp_pro',fecha_pro='".date("Y-m-d")."',hora_pro='".date("H:i:s")."' WHERE ordenamiento='$id_pro'";
		mysql_db_query($db,$sql3,$link);
		header("location: lista_proced.php");
		exit;
	}
	else
	{
		$msg="Debe introducir como minimo una actividad";
	}
	
}
?>
<script language="JavaScript">
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}

</script>
<title>Nuevo Procedimiento</title>
<form name="form1" method="post" enctype="multipart/form-data" onKeyPress="return Form()">
<input name="pg" type="hidden" value="<?php echo $pg;?>">
<?php 
$sql_sol="SELECT * FROM proced WHERE ordenamiento='$id_pro'";
$res_sol=mysql_db_query($db,$sql_sol,$link);
$row_sol=mysql_fetch_array($res_sol);
?>
  <table width="95%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" background="images/fondo.jpg">
    <tr> 
      <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>PROCEDIMIENTO</strong></font></th>
          </tr>
          <tr a align="center"> 
            <td height="39" colspan="3"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Fecha 
              de Proceso:</strong></font><font size="2"><?php echo date("d/m/Y");?> 
              </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              </font><font size="2" face="Arial, Helvetica, sans-serif"><strong>Hora 
              de Proceso:</strong></font><font size="2"> <?php echo date("H:i:s");?> 
              </font></td>
          </tr>
          <tr a align="center"> 
            <td height="22" colspan="3"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Titulo 
                del Procedimiento : 
                <input name="titulo_pro" type="text" size="100" value="<?php echo $row_sol[titulo_pro];?>">
                </strong></font></div></td>
          </tr>
          <tr> 
            <td height="21" colspan="3" align="center"><div align="left"></div>
              <hr> </td>
          </tr>
          <tr> 
            <td colspan="3"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Detalles 
                del Procedimiento:</strong></font></div></td>
          </tr>
          <?php 
				if($row_sol[detalles_pro] || $row_sol[detalles_pro]!="")
				{
				$matrix=explode("*|*",$row_sol[detalles_pro]);
				$matrix2=explode("*|*",$row_sol[resp_act]);
				$nume=count($matrix);
			?>
          <tr> 
            <td height="26" colspan="3"><div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font> 
                <table width="97%" border="0">
                  <tr> 
                    <?php for($i=0;$i<$nume;$i++)
					{ $k=$i+1;?>
                    <td width="16%" valign="top"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>&nbsp;ACTIV. 
                        <?php echo $k;?> :</strong></font></div></td>
                    <td width="32%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <?php echo $matrix[$i];?> </font></td>
                    <td width="3%">&nbsp;</td>
                    <td width="49%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Responsable: 
                      </strong> 
                      <?php 
					  $sql_ra="SELECT * FROM users WHERE login_usr='$matrix2[$i]'";
					  $result_ra=mysql_db_query($db,$sql_ra,$link);
					  $row_ra=mysql_fetch_array($result_ra);
					  
					  echo "$row_ra[nom_usr] $row_ra[apa_usr] $row_ra[ama_usr]";?>
                      </font></td>
                  </tr>
                  <?php }?>
                </table>
              </div></td>
          </tr>
          <?php
		  }else{
				$sql_sol="SELECT * FROM proced WHERE id_pro='$id_pro'";
				$res_sol=mysql_db_query($db,$sql_sol,$link);
				$row_sol=mysql_fetch_array($res_sol);
			  	if($row_sol[detalles_sol]!="") echo "<tr align=\"center\"><td colspan=\"2\"><font size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$row_sol[detalles_pro]."</font>";
		  }
		  	$sql = "SELECT *, DATE_FORMAT(fecha_pro, '%d/%m/%Y') as fecha_pro FROM proced WHERE id_pro='$id_pro'";
			$result=mysql_db_query($db,$sql,$link);
			$row=mysql_fetch_array($result);?>
          <tr> 
            <td height="54" colspan="2"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <textarea name="detalles_pro" cols="40" rows="2" id="textarea" <?php if($elim=="si") echo "disabled"?>><?php echo $detalles_pro;?></textarea>
                </font></div></td>
            <td width="80%" height="54"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Responsable 
              Actividad:<font size="2" face="Arial, Helvetica, sans-serif"> 
              <select name="resp_act">
                <option value="0">Seleccione un Responsable</option>
                <?php  $sql_log="SELECT * FROM users";
					$result_log=mysql_db_query($db,$sql_log,$link);
					while($row_log=mysql_fetch_array($result_log))
					{
						echo "<option value=\"$row_log[login_usr]\">$row_log[apa_usr] $row_log[ama_usr] $row_log[nom_usr] - [$row_log[cargo_usr]]</option>";
					}
				?>
              </select>
              </font></strong></font></td>
          </tr>
          <tr> 
            <td height="19" colspan="3"> <div align="center"><font size="2"> </font></div></td>
          </tr>
          <tr> 
            <td colspan="3"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Posicionar 
                en Registro: </font></strong> 
                <select name="ordena" id="ordena" <?php if($modif=="si") echo "onChange=\"redirect(this.options.selectedIndex)\""?>>
                  <?php
		$sel="SELECT detalles_pro FROM proced WHERE ordenamiento='$id_pro'";
		$res_sel=mysql_db_query($db,$sel,$link);
		$row_sel=mysql_fetch_array($res_sel);
		if($row_sel[detalles_pro]=="" || !$row_sel[detalles_pro]) echo "<option value=\"1\">ACTIV. 1</option>";
		else{
			$num_it=count(explode("*|*",$row_sel[detalles_pro]));
			if($modif=="si"){
					echo "<option value=\"0\">Seleccione</option>";
				for($i=1;$i<=$num_it;$i++){
					echo "<option value=\"$i\">ACTIV. $i</option>";
				}
			}elseif($elim=="si"){
				for($i=1;$i<=$num_it;$i++){
					echo "<option value=\"$i\">ACTIV. $i</option>";
				}
			}else{
				for($i=$num_it;$i>=0;$i--){
					$tt=$i+1;
					echo "<option value=\"$tt\">ACTIV. $tt</option>";
				}
			}
		}
		?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif">Insertar 
                <input name="opt" type="radio" value="0" checked onClick="insertar()">
                &nbsp;&nbsp;&nbsp;</font></strong><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                Modificar 
                <input type="radio" name="opt" value="1" onClick="modificar()" <?php if($modif=="si") echo "checked"?>>
                &nbsp;&nbsp;&nbsp;&nbsp;</font></strong><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                Eliminar 
                <input type="radio" name="opt" value="2" onClick="eliminar()" <?php if($elim=="si") echo "checked"?>>
                </font></strong><br>
                <br>
                <input name="GUARDAR" type="submit" id="GUARDAR" value="<?php 	
					if($modif=="si"){echo "MODIFICAR";}
					elseif($elim=="si"){echo "ELIMINAR";}
					else{echo "GUARDAR";}
					
				?>">
                <br>
                <br>
              </div></td>
          </tr>
          <tr> 
            <td height="6" colspan="3"><hr></td>
          </tr>
          <tr> 
            <td width="6%" height="6"> <div align="center"></div></td>
            <td height="6" colspan="2"><strong><font size="2" face="Arial, Helvetica, sans-serif">Realizado 
              por:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <select name="login_pro">
                <?php  $sql_log="SELECT * FROM users";
					$result_log=mysql_db_query($db,$sql_log,$link);
					while($row_log=mysql_fetch_array($result_log))
					{
						echo "<option value=\"$row_log[login_usr]\"";
						if ($row_log[login_usr]==$row_sol[login_pro]){echo "selected";}
						echo ">$row_log[apa_usr] $row_log[ama_usr] $row_log[nom_usr] - [$row_log[cargo_usr]]</option>";
					}
				?>
              </select>
              </font></strong><strong></strong> <strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              </font></strong><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              </font></strong></td>
          </tr>
          <tr> 
            <td height="6"><strong></strong></td>
            <td height="6" colspan="2"><strong><font size="2" face="Arial, Helvetica, sans-serif">Responsable 
              del Proceso: &nbsp;&nbsp; 
              <select name="resp_pro">
                <?php  $sql_log="SELECT * FROM users";
					$result_log=mysql_db_query($db,$sql_log,$link);
					while($row_log=mysql_fetch_array($result_log))
					{
						echo "<option value=\"$row_log[login_usr]\"";
						if ($row_log[login_usr]==$row_sol[resp_pro]){echo "selected";}
						echo ">$row_log[apa_usr] $row_log[ama_usr] $row_log[nom_usr] - [$row_log[cargo_usr]]</option>";
					}
				?>
              </select>
              </font></strong><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              </font></strong><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              </font></strong></td>
          </tr>
          <tr align="center"> 
            <td height="52" colspan="3"><br> 
              <?php 
				$sql_sol="SELECT detalles_pro FROM proced WHERE id_pro='$id_pro'";
				$res_sol=mysql_db_query($db,$sql_sol,$link);
				$row_sol=mysql_fetch_array($res_sol);
			  	if($row_sol[detalles_pro]) 
				{?>
              <input name="reg_form" type="submit" id="reg_form" value="GUARDAR Y TERMINAR"> 
              <?php }
			  else
			  {?>
              <input name="retornar" type="submit" id="reg_form" value="RETORNAR"> 
              <?php 
			  }?>
            </td>
          </tr>
          <tr> 
            <td height="19" colspan="3">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
<input name="id_pro" type="hidden" value="<?php echo $id_pro;?>">
</form>
<script language="JavaScript">
<!-- 
<?php 
print "function msgFile () {\n
	alert (\"Atencion, solamente puede enviar archivos menor o igual a $row5[tam_archivo] Mb de tamano.\\n \\nMensaje generado por GesTor F1.\");\n
	}\n";
if ($msg) {
	print "var msg=\"$msg\";\n";
	print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
} 
if ($msg_e) {
	print "var msg=\"$msg_e\";\n";
	print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
} ?>
function insertar(){
	var pru=document.form1.detalles_pro.value;
	dir="proced.php?id_pro=<?php=$id_pro?>&detalles_pro="+pru;
	self.location=dir
}
function modificar(){
	var pru=document.form1.detalles_pro.value;
	dir="proced.php?id_pro=<?php=$id_pro?>&modif=si&detalles_pro="+pru;
	self.location=dir
}
function eliminar(){
	dir="proced.php?id_pro=<?php=$id_pro?>&elim=si"
	self.location=dir
}
<?php if($modif=="si"){?>
var groups=document.form1.ordena.options.length
var group=new Array(groups)
for (i=0; i<groups; i++)
group[i]=new Array()
<?php
	print "group[0]=new Option(\"\",\"\")\n";
	$i = 1;
	foreach ($solucion as $k => $v){
		print "group[$i]=new Option(\"$v\",\"$k\")\n";
		$i++;
	}
?>
//var temp=document.form1.detalles_pro;
<?php }?>
function redirect(x){
	temp.value=group[x].text
}
-->
</script>
