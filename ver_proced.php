<title>IMPRESION - PROCEDIMIENTOS</title>
<?php 
include("conexion.php");
$sql_sol="SELECT * FROM proced WHERE ordenamiento='$id_pro'";
$res_sol=mysql_db_query($db,$sql_sol,$link);
$row_sol=mysql_fetch_array($res_sol);
?>
  
<div align="center"><font color="#000000" size="3" face="Arial, Helvetica, sans-serif"><strong><u>PROCEDIMIENTO 
        Nro. <?php echo $id_pro;?><br>
        <br>
        </u></strong></font></div>
<table width="80%" border="1" align="center">
       	<tr align="left"> 
    			
    <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;Fecha 
      de Proceso</strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>:</strong> 
      </font><font size="3"> <?php echo date("d/m/Y");?> </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      </font><font size="2" face="Arial, Helvetica, sans-serif"><strong>Hora de 
      Proceso</strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>:</strong> 
      </font><font size="3"> <?php echo date("H:i:s");?> </font></td>
  			</tr>
        	<tr>
          		<td>
					<table width="100%" border="0">
              			<tr align="center"> 
    						<td width="25%" height="22"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;Titulo 
              del Procedimiento : </strong></font></div></td>
    						<td width="75%" height="22" colspan="3"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row_sol[titulo_pro];?></font></div></td>
  						</tr>
            		</table>
				</td>
        	</tr>
        	<tr>
          		<td height="65">
		  		  <table width="100%" border="0">
        <tr> 
          <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;Detalles 
              del Procedimiento:</strong></font></div></td>
        </tr>
        <tr> 
          <td height="37"> <table width="100%" border="0">
              <?php 
									if($row_sol[detalles_pro] || $row_sol[detalles_pro]!="")
									{
									$matrix=explode("*|*",$row_sol[detalles_pro]);
									$matrix2=explode("*|*",$row_sol[resp_act]);
									$nume=count($matrix);
								?>
              <tr> 
                <td height="31" colspan="3"><div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font> 
                    <table width="100%" border="1">
                      <tr> 
                        <?php for($i=0;$i<$nume;$i++)
					{ $k=$i+1;?>
                        <td width="38%" valign="top"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Responsable: 
                            </strong> 
                            <?php 
					  $sql_ra="SELECT * FROM users WHERE login_usr='$matrix2[$i]'";
					  $result_ra=mysql_db_query($db,$sql_ra,$link);
					  $row_ra=mysql_fetch_array($result_ra);
					  
					  echo "$row_ra[nom_usr] $row_ra[apa_usr] $row_ra[ama_usr]";?>
                            </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>&nbsp;</strong></font></div></td>
                        <td width="13%" valign="top"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>ACTIV. 
                            <?php echo $k;?> :</strong></font></div></td>
                        <td width="49%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                          <?php echo $matrix[$i];?> </font></td>
                      </tr>
                      <?php }?>
                    </table>
                  </div></td>
              </tr>
              <?php }
				else{
				$sql_sol="SELECT * FROM proced WHERE id_pro='$id_pro'";
				$res_sol=mysql_db_query($db,$sql_sol,$link);
				$row_sol=mysql_fetch_array($res_sol);
			  	if($row_sol[detalles_sol]!="") echo "<tr align=\"center\"><td colspan=\"2\"><font size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$row_sol[detalles_pro]."</font>";
		  }
		  	$sql = "SELECT *, DATE_FORMAT(fecha_pro, '%d/%m/%Y') as fecha_pro FROM proced WHERE id_pro='$id_pro'";
			$result=mysql_db_query($db,$sql,$link);
			$row=mysql_fetch_array($result);?>
            </table></td>
        </tr>
      </table>
</td>
 </tr>
 <tr><td height="75">
 <table width="100%" border="0">
        <tr> 
          <td height="6" colspan="4">&nbsp;</td>
        </tr>
        <tr> 
          <td height="6"> <div align="center"></div>
            <strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;Realizado 
            por: </font></strong> <strong><font size="2" face="Arial, Helvetica, sans-serif"> 
            </font></strong> </td>
          <td width="31%" height="6"><font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php  $sql_log="SELECT * FROM users WHERE login_usr='$row_sol[login_pro]'";
						$result_log=mysql_db_query($db,$sql_log,$link);
						$row_log=mysql_fetch_array($result_log);
						echo " $row_log[nom_usr] $row_log[apa_usr] $row_log[ama_usr] ";
					?>
            </font> </td>
          <td width="11%" height="6"><div align="right"><strong><font size="2" face="Arial, Helvetica, sans-serif">Firma:</font></strong></div></td>
          <td width="34%">_________________________</td>
        </tr>
        <tr> 
          <td height="6" colspan="4">&nbsp;</td>
        </tr>
        <tr> 
          <td height="21"><strong></strong><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;Responsable 
            del Proceso: </font></strong></td>
          <td height="21"><font size="2" face="Arial, Helvetica, sans-serif"> 
            <?php  $sql_log="SELECT * FROM users WHERE login_usr='$row_sol[resp_pro]'";
						$result_log=mysql_db_query($db,$sql_log,$link);
						$row_log=mysql_fetch_array($result_log);
						echo " $row_log[nom_usr] $row_log[apa_usr] $row_log[ama_usr] ";
					?>
            </font></td>
          <td><div align="right"><strong><font size="2" face="Arial, Helvetica, sans-serif">Firma:</font></strong></div></td>
          <td height="21">_________________________</td>
        </tr>
      </table>
 </td></tr>
 </table>

