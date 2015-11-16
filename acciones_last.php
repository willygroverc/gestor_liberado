<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		06/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($Terminar))
header("location: minuta_last.php?id_minuta=$var&verif=1");

if (isset($reg_form))
{   require("conexion.php");
	$flimite="$eano-$emes-$edia";
		$sql2 = "SELECT * FROM atema WHERE tema='$tema' AND id_minuta='$var'";
		$result2=mysql_query($sql2);
		$row2=mysql_fetch_array($result2);
	if (!$row2['id_tema'])
		{$sql0 = "SELECT * FROM rtema WHERE id_minuta='$var' AND tema='$tema'";
		$result0=mysql_query($sql0);
		$row0=mysql_fetch_array($result0);
		$sql="INSERT INTO atema (accion,responsable,flimite,tema,id_minuta,id_tema) ".
		"VALUES ('$accion','$responsable','$flimite','$tema','$var','$row0[id_tema]')";
		mysql_query($sql);
		header("location: acciones_last.php?id_minuta=$var");}
	else
	{$sql="UPDATE atema SET accion='$accion',responsable='$responsable',flimite='$flimite' ".
	"WHERE id_minuta='$var' AND tema='$tema'";
	mysql_query($sql);
	header("location: acciones_last.php?id_minuta=$var");}
}
else {
include("top.php");
@$id_minuta=($_GET['id_minuta']);
@$id_te=($_GET['id_tema']);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "tema",  "Tema, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "accion",  "Accion, $errorMsgJs[empty]" );
$valid->addLength ( "accion",  "Accion, $errorMsgJs[length]" );
$valid->addIsNotEmpty ( "responsable",  "Responsable, $errorMsgJs[empty]" );
$valid->addIsDate   ( "edia", "emes", "eano", "Fecha Limite, $errorMsgJs[date]" );
print $valid->toHtml ();
?>  
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_minuta;?>">
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="9" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              ACCIONES POR TEMA</font></th>
          </tr>
          <tr> 
            <th width="5%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="28%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">TEMA</font></th>
            <th width="28%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ACCION</font></th>
            <th width="28%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">RESPONSABLE</font></th>
            <th width="10%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA 
              LIMITE</font></th>
          </tr>
          <?php
		$sql = "SELECT *, DATE_FORMAT(flimite, '%d/%m/%Y') AS flimite FROM atema WHERE id_minuta='$id_minuta' ORDER BY id_tema ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		?>
          <tr align="center"> 
            <?php echo "<td><a href=\"acciones_last.php?id_minuta=$id_minuta&id_tema=".$row[id_tema]."\">".$row[id_tema]."</a></td>";
				$sql5 = "SELECT * FROM temas WHERE id_tema='$row[tema]' AND id_agenda='$id_minuta'";
		    	$result5 = mysql_query($sql5);
		    	$row5 = mysql_fetch_array($result5);
				if (!isset($row5['id_tema']))
				{echo "<td>&nbsp;".$row['tema']."</td>";}
				else
				{echo "<td>&nbsp;".$row5['tema']."</td>";}
			?>
            <td>&nbsp;<?php echo $row['accion'];?></td>
			<?php	$sql5 = "SELECT * FROM users WHERE login_usr='".$row['responsable']."'";
		    $result5 = mysql_query($sql5);
		    $row5 = mysql_fetch_array($result5);
			echo '<td>&nbsp;'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';?>
            <td>&nbsp;<?php echo $row['flimite']?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="9" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
		   <?php @$sql3 = "SELECT * FROM atema WHERE id_tema='$id_tema' AND id_minuta='$id_minuta' ";
		  	 $result3=mysql_query($sql3);
	      	 $row3=mysql_fetch_array($result3)?>
		  <tr> 
            <td width="36" nowrap height="7"><div align="center"><strong> <?php if (isset($id_tema)) echo $id_tema; ?> 
                </strong></div></td>
            <td nowrap><div align="center"><strong>
			<select name="tema" id="select8">
              <?php 
			  $sql0 = "SELECT * FROM rtema WHERE id_minuta='$id_minuta'";
			  $result0=mysql_query($sql0);
			  while ($row0=mysql_fetch_array($result0)) 
					{$sql5 = "SELECT * FROM temas WHERE id_tema='$row0[tema]' AND id_agenda='$id_minuta'";
		    		$result5 = mysql_query($sql5);
		    		$row5 = mysql_fetch_array($result5);
					if (!isset($row5['id_tema']))
						{if ($row0['id_tema']==$id_tema)
						{echo '<option value="'.$row0['tema'].'" selected>'.$row0['tema'].'</option>';}
						else
						{echo '<option value="'.$row0['tema'].'">'.$row0['tema'].'</option>';}}
					else
						{if ($row0['id_tema']==$id_tema)
						{echo '<option value="'.$row5['id_tema'].'"selected>'.$row5['tema'].'</option>';}	
						else
						{echo '<option value="'.$row5['id_tema'].'">'.$row5['tema'].'</option>';}}	
		    	}
				 ?>
                </select>
				</strong></div></td>
            <td nowrap><strong>
              <textarea name="accion" cols="28"><?php echo $row3['accion'];?></textarea>
              </strong></td>
            <td width="158" nowrap><div align="center"><strong> 
                <select name="responsable" id="select10">
                  <option value="0"></option>
                  <?php 
			  $sql21 = "SELECT * FROM users WHERE tipo2_usr='T' OR tipo2_usr='A' ORDER BY apa_usr ASC";
			  $result21 = mysql_query($sql21);
			  while ($row21 = mysql_fetch_array($result21)) 
				{
				if ($row3['responsable']==$row21['login_usr'])
							echo '<option value="'.$row21['login_usr'].'" selected>'.$row21['apa_usr'].' '.$row21['ama_usr'].' '.$row21['nom_usr'].'</option>';
						else
							echo '<option value="'.$row21['login_usr'].'">'.$row21['apa_usr'].' '.$row21['ama_usr'].' '.$row21['nom_usr'].'</option>';
	            }
			   ?>
                </select>
                </strong></div></td>
            <td width="181" nowrap height="7"><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="edia" >
                  <?php
				if(!$row3['flimite'])
				{$fechahoy=date("Y-m-d");
				$a1=substr($fechahoy,0,4);
				$m1=substr($fechahoy,5,2);
				$d1=substr($fechahoy,8,2);}
				else
				{$a1=substr($row3['flimite'],0,4);
				$m1=substr($row3['flimite'],5,2);
				$d1=substr($row3['flimite'],8,2);
  				}
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			  ?>
                </select>
                <select name="emes">
                  <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                </select>
                <select name="eano">
                  <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>
                </font><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font> </strong> </div></td>
          </tr>
          <tr> 
            <td height="28" colspan="9" nowrap> <div align="center"><br>
                <input name="reg_form" type="submit" id="reg_form3" value="MODIFICAR DATOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="RETORNAR">
              </div></td>
          </tr>
        </table>
      </td>
    </tr></form>
  </table>
<script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['edia'], document.forms[form].elements['emes'], document.forms[form].elements['eano']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
//-->
</script>
<p> 
  <?php } ?>
</p>