<?php if ($Terminar)
header("location: minuta_last.php?id_minuta=$var&verif=1");
?>
<?php
if ($reg_form)
{   include("conexion.php");
	 	$sql2 = "SELECT * FROM rtema WHERE tema='$tema' AND id_minuta='$var'";
		$result2=mysql_db_query($db,$sql2,$link);
		$row2=mysql_fetch_array($result2);
	if (!$row2[tema])
		{$sql0 = "SELECT * FROM temad WHERE id_minuta='$var' AND tema='$tema'";
		$result0=mysql_db_query($db,$sql0,$link);
		$row0=mysql_fetch_array($result0);
		$sql="INSERT INTO rtema (id_tema,resultado,id_minuta,tema) VALUES ('$row0[id_tema]','$resultado','$var','$tema')";
		mysql_db_query($db,$sql,$link);
		header("location: resultados_last.php?id_minuta=$var");}
	else
	{$sql="UPDATE rtema SET resultado='$resultado' WHERE id_minuta='$var' AND tema='$tema'";
	mysql_db_query($db,$sql,$link);
	header("location: resultados_last.php?id_minuta=$var");}
}
else { 
include("top.php");
$id_minuta=($_GET['id_minuta']);
$id_tema=($_GET['id_tema']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal( "resultado",  "Resultados, $errorMsgJs[empty]" );
$valid->addLength ( "resultado",  "Resultados, $errorMsgJs[length]" );
print $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>

  <table width="71%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_minuta;?>">
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              RESULTADOS POR TEMA</font></th>
          </tr>
          <tr> 
            <th width="49" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="429" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">TEMA</font></th>
            <th width="189" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">RESULTADOS</font></th>
          
		  </tr>
          <?php
		$sql = "SELECT * FROM rtema WHERE id_minuta='$id_minuta' ORDER BY id_tema ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr align="center"> 
            <?php echo "<td><a href=\"resultados_last.php?id_minuta=$id_minuta&id_tema=".$row[id_tema]."\">".$row[id_tema]."</a></td>";
			 	$sql5 = "SELECT * FROM temas WHERE id_tema='$row[tema]' AND id_agenda='$id_minuta'";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5[id_tema])
				{echo "<td>&nbsp;$row[tema]</td>";}
				else
				{echo "<td>&nbsp;$row5[tema]</td>";}?>
			
           <td>&nbsp;<?php echo $row[resultado]?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="3" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
		  <?php $sql3 = "SELECT * FROM rtema WHERE id_tema='$id_tema' AND id_minuta='$id_minuta' ";
		  	 $result3=mysql_db_query($db,$sql3,$link);
	      	 $row3=mysql_fetch_array($result3)?>
          <tr> 
            <td width="49" nowrap height="7"><div align="center"><strong> 
			<?php echo $id_tema ?>
			</strong></div></td>
            <td width="429" nowrap><div align="center"><strong> 
               <select name="tema" id="select8">
              <?php 
			  $sql0 = "SELECT * FROM temad WHERE id_minuta='$id_minuta'";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
					{$sql5 = "SELECT * FROM temas WHERE id_tema='$row0[tema]' AND id_agenda='$id_minuta'";
		    		$result5 = mysql_db_query($db,$sql5,$link);
		    		$row5 = mysql_fetch_array($result5);
					if (!$row5[id_tema])
						{if ($row0[id_tema]==$id_tema)
						{echo "<option value=\"$row0[tema]\"selected>$row0[tema] </option>";}
						else
						{echo "<option value=\"$row0[tema]\">$row0[tema] </option>";}}
					else
						{if ($row0[id_tema]==$id_tema)
						{echo "<option value=\"$row5[id_tema]\"selected>$row5[tema] </option>";}	
						else
						{echo "<option value=\"$row5[id_tema]\">$row5[tema] </option>";}}	
		    	}
				 ?>
                </select>
			                  
                </strong></div></td>
            <td width="189" nowrap><strong>
              <textarea name="resultado" cols="30"><?php echo $row3[resultado]?></textarea>
              </strong></td>
          </tr>
          <tr> 
            <td height="28" colspan="3" nowrap> <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="MODIFICAR/INSERTAR  RESULTADOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<p> 
  <?php } ?>
</p>
<?php include("top_.php");?>
