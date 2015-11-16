<?php
include ("top.php");

//==========ORDENES DE TRABAJO==========================
//NUMERO TOTAL DE ORDENES
$sql = "SELECT COUNT(id_orden) AS numtot FROM ordenes";
$row=mysql_fetch_array(mysql_db_query($db,$sql,$link));

//NUMERO DE ORDENES ASIGNADAS
$sql1 = "SELECT COUNT(id_orden) AS asig FROM asignacion";
$row1=mysql_fetch_array(mysql_db_query($db,$sql1,$link));

//NUMERO DE ORDENES NO ASIGNADAS
$noasig=$row[numtot]-$row1[asig];

//NUMERO DE ORDENES ESCALADAS
$sql2 = "SELECT COUNT(id_orden) AS esc FROM asignacion WHERE escal<>'0'";
$row2=mysql_fetch_array(mysql_db_query($db,$sql2,$link));

//NUMERO DE ORDENES NO ESCALADAS
$noesc=$row[numtot]-$row2[esc];

//NUMERO DE ORDENES CON SEGUIMIENTO ++++++++++++++++++++++++
//$sql3 = "SELECT DISTINCT id_orden AS seg FROM seguimiento";
$sql3 = "SELECT id_orden AS seg FROM seguimiento GROUP BY id_orden";
$row3 = mysql_fetch_array(mysql_db_query($db,$sql3,$link));

//MUMERO DE ORDENES SIN SEGUIMIENTO ++++++++++++++++++++++++
$noseg=$row[numtot]-$row3[seg];

//NUMERO DE ORDENES CON SOLUCION
$sql4 = "SELECT count(id_orden) AS solu FROM solucion";
$row4 = mysql_fetch_array(mysql_db_query($db,$sql4,$link));

//NUMERO DE ORDENES SIN SOLUCION
$nosolu=$row[numtot]-$row4[solu];

//NUMERO DE ORDNES CON CONFORMIDAD DEL CLIENTE
$sql5 = "SELECT count(id_orden) AS conf FROM conformidad";
$row5 = mysql_fetch_array(mysql_db_query($db,$sql5,$link));

//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
$noconf=$row[numtot]-$row5[conf];

//NUMERO DE ORDENES CON COSTO
$sql6 = "SELECT count(id_orden) AS cost FROM costo";
$row6 = mysql_fetch_array(mysql_db_query($db,$sql6,$link));

//NUMERO DE ORDENES SIN COSTO
$nocost=$row[numtot]-$row6[cost];

//=============USUARIOS=================
//NUMERO DE ADMINISTRADORES
$sql7 = "SELECT count(tipo2_usr) AS adm FROM users WHERE tipo2_usr='A'";
$row7 = mysql_fetch_array(mysql_db_query($db,$sql7,$link));

//NUMERO DE CLIENTES
$sql8 = "SELECT count(tipo2_usr) AS cli FROM users WHERE tipo2_usr='C'";
$row8 = mysql_fetch_array(mysql_db_query($db,$sql8,$link));

//NUMERO DE TECNICOS
$sql9 = "SELECT count(tipo2_usr) AS tec FROM users WHERE tipo2_usr='T'";
$row9 = mysql_fetch_array(mysql_db_query($db,$sql9,$link));

//NUMERO TOTAL DE TECNICOS
$totuser=$row7[adm]+$row8[cli]+$row9[tec];
?>
<?php 
$pasig=intval($row1[asig]*100/$row[0],10);
$npasig=intval($noasig*100/$row[0],10);

$pesc=intval($row2[esc]*100/$row[0],10);
$npesc=intval($noesc*100/$row[0],10);

$pseg=intval($row3[seg]*100/$row[0],10);
$npseg=intval($noseg*100/$row[0],10);

$psolu=intval($row4[solu]*100/$row[0],10);
$npsolu=intval($nosolu*100/$row[0],10);

$pconf=intval($row5[conf]*100/$row[0],10);
$npconf=intval($noconf*100/$row[0],10);

$pcost=intval($row6[cost]*100/$row[0],10);
$npcost=intval($nocost*100/$row[0],10);

$ptoto=intval($row[0]*100/$row[0],10);
?>

<?php 
$padm=$row7[adm]*100/$totuser;
$padm=intval ( $padm ,10);

$pcli=$row8[cli]*100/$totuser;
$pcli=intval ( $pcli ,10);

$ptec=$row9[tec]*100/$totuser;
$ptec=intval ( $ptec ,10);

$ptotu=$totuser*100/$totuser;
$ptotu=intval ( $ptotu ,10);

?> 

<table width="455" border="1" align="center"  background="images/fondo.jpg">
  <tr> 
    <td width="455"> 
      <table border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr align="center">
	  <th width="198" bgcolor="#006699"><font size="1" color="#FFFFFF" face="Arial, Helvetica, sans-serif">Orden de Trabajo</font></th>
	  <th width="80" bgcolor="#006699"><font size="1" color="#FFFFFF" face="Arial, Helvetica, sans-serif">Cantidad</font></th>
	  <th width="51" bgcolor="#006699"><font size="1" color="#FFFFFF" face="Arial, Helvetica, sans-serif">%</font></th>
	  <th width="32" bgcolor="#006699"><font size="1" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
        </tr>
        <tr> 
          <td width="198"> 
            <div align="left">Asignadas</div>
          </td>
          <td width="80"> 
            <div align="right">&nbsp;<?php echo $row1[asig];?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $pasig;?> %</div>
          </td>
          <td nowrap width="32" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$pasig SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="198"> 
            <div align="left">no Asignadas</div>
          </td>
          <td width="80"> 
            <div align="right">&nbsp;<?php echo $noasig;?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $npasig;?> %</div>
          </td>
          <td nowrap width="32" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$npasig SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="198"></td>
          <td height="10" width="80"> </td>
          <td height="10" width="51"> </td>
          <td height="10" width="32"></td>
        </tr>
        <tr> 
          <td width="198"> 
            <div align="left">Escaladas</div>
          </td>
          <td width="80"> 
            <div align="right">&nbsp;<?php echo $row2[esc];?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $pesc;?> %</div>
          </td>
          <td nowrap width="32" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$pesc SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="198"> 
            <div align="left">no Escaladas</div>
          </td>
          <td width="80"> 
            <div align="right">&nbsp;<?php echo $noesc;?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $npesc;?> %</div>
          </td>
          <td nowrap width="32" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$npesc SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="198"></td>
          <td height="10" width="80"> </td>
          <td height="10" width="51"> </td>
          <td height="10" width="32"></td>
        </tr>
        <tr> 
          <td width="198"> 
            <div align="left">con Seguimiento</div>
          </td>
          <td width="80"> 
            <div align="right">&nbsp;<?php echo $row3[seg];?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $pseg;?> %</div>
          </td>
          <td nowrap width="32" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$pseg SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="198"> 
            <div align="left">sin Seguimiento</div>
          </td>
          <td width="80"> 
            <div align="right">&nbsp;<?php echo $noseg;?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $npseg;?> %</div>
          </td>
          <td nowrap width="32" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$npseg SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="198"></td>
          <td height="10" width="80"> </td>
          <td height="10" width="51"> </td>
          <td height="10" width="32"></td>
        </tr>
        <tr> 
          <td width="198"> 
            <div align="left">con Solucion</div>
          </td>
          <td width="80"> 
            <div align="right">&nbsp;<?php echo $row4[solu];?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $psolu;?> %</div>
          </td>
          <td nowrap width="32" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$psolu SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="198"> 
            <div align="left">sin Solucion</div>
          </td>
          <td width="80"> 
            <div align="right">&nbsp;<?php echo $nosolu;?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $npsolu;?> %</div>
          </td>
          <td nowrap width="32" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$npsolu SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="198"></td>
          <td height="10" width="80"> </td>
          <td height="10" width="51"> </td>
          <td height="10" width="32"></td>
        </tr>
        <tr> 
          <td width="198"> 
            <div align="left">con Conformidad</div>
          </td>
          <td width="80"> 
            <div align="right">&nbsp;<?php echo $row5[conf];?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $pconf;?> %</div>
          </td>
          <td nowrap width="32" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$pconf SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="198"> 
            <div align="left">sin Conformidad</div>
          </td>
          <td width="80"> 
            <div align="right">&nbsp;<?php echo $noconf;?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $npconf;?> %</div>
          </td>
          <td nowrap width="32" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$npconf SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="198"></td>
          <td height="10" width="80"> </td>
          <td height="10" width="51"> </td>
          <td height="10" width="32"></td>
        </tr>
        <tr> 
          <td width="198"> 
            <div align="left">con Costo</div>
          </td>
          <td width="80"> 
            <div align="right">&nbsp;<?php echo $row6[cost];?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $pcost;?> %</div>
          </td>
          <td nowrap width="32" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$pcost SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="198"> 
            <div align="left">sin Costo</div>
          </td>
          <td width="80"> 
            <div align="right">&nbsp;<?php echo $nocost;?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $npcost;?> %</div>
          </td>
          <td nowrap width="32" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$npcost SRC=images/barra.jpg>";?></td>
        </tr>
        <tr bgcolor="#CCCCCC" align="center"> 
          <th nowrap width="198">Nro TOTAL DE ORDENES</th>
          <td width="80"> 
            <div align="right">&nbsp;<?php echo $row[numtot];?></div>
          </td>
          <td nowrap width="51">100%</td>
          <td nowrap width="32"><?php echo "<IMG HEIGHT=15 WIDTH=100 SRC=images/barra.jpg>";?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table border="1" align="center" width="455"  background="images/fondo.jpg">
  <tr>
    <td>
      <table border="1" cellpadding="0" cellspacing="0" width="100%">

        <tr align="center">
	  <th width="136" bgcolor="#006699"><font size="1" color="#FFFFFF" face="Arial, Helvetica, sans-serif">Usuarios</font></th>
	  <th width="51" bgcolor="#006699"><font size="1" color="#FFFFFF" face="Arial, Helvetica, sans-serif">Cantidad</font></th>
	  <th width="51" bgcolor="#006699"><font size="1" color="#FFFFFF" face="Arial, Helvetica, sans-serif">%</font></th>
	  <th width="32" bgcolor="#006699"><font size="1" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
        </tr>
        <tr> 
          <td width="136">Administradores</td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $row7[adm];?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $padm;?> %</div>
          </td>
          <td bgcolor="#006699" width="32"><?php echo "<IMG HEIGHT=15 WIDTH=$padm SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="136">Clientes</td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $row8[cli];?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $pcli;?> %</div>
          </td>
          <td bgcolor="#006699" width="32"><?php echo "<IMG HEIGHT=15 WIDTH=$pcli SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="136">Tecnicos</td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $row9[tec];?></div>
          </td>
          <td width="51"> 
            <div align="right">&nbsp;<?php echo $ptec;?> %</div>
          </td>
          <td bgcolor="#006699" width="32"><?php echo "<IMG HEIGHT=15 WIDTH=$ptec SRC=images/barra.jpg>";?></td>
        </tr>
        <tr bgcolor="#CCCCCC"> 
          <td width="136">Nro Total de Usuarios</td>
          <td width="51"> <div align="right">&nbsp;<?php echo $totuser;?></div></td>
          <td width="51"> <div align="right">&nbsp;<?php echo $ptotu;?>%</div></td> 
	  <td width="16"> <?php echo "<IMG HEIGHT=15 WIDTH=$ptotu SRC=images/barra.jpg>";?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<?php
include ("top_.php");
?>