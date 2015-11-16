<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($RETORNAR)){header("location: lista_planifpru2.php");}
if (isset($guardar3) )
{
  include("conexion.php");
	$sql66= "SELECT * FROM resp_resulteval WHERE id_resulpru='$idresulpru' AND nombre='$nombrespeval'";
	$result66=mysql_query($sql66);
	$row66=mysql_fetch_array($result66);
	if(!$row66['nombre'])	
	{	
	$sql10= "INSERT INTO resp_resulteval (id_resulpru,nombre,comentario)".
	"VALUES ('$idresulpru','$nombrespeval','$comentarioeval')";
	mysql_query($sql10);
	header("location: resprelac_result.php?varia2=$idresulpru&varia1=$var");
	}
	else
	{
	$sql6="UPDATE resp_resulteval SET comentario='$comentarioeval'".
	"WHERE nombre='$nombrespeval' AND id_resulpru='$idresulpru'";
	mysql_query($sql6);
	header("location: resprelac_result.php?varia2=$idresulpru&varia1=$var");
	}
} 
else {
include ("top.php");

$OrdAyuda=($_GET['varia1']);
$idresulpru=($_GET['varia2']);
	$sql20 = "SELECT * FROM planprueba WHERE ordayuda='$OrdAyuda'";
	$result=mysql_query($sql20);
	$row=mysql_fetch_array($result);

?> 
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "nombrespeval",  "Nombre Responsable, $errorMsgJs[empty]" );
$valid->addLength ( "comentarioeval",  "Comentarios, $errorMsgJs[length]" );
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

<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr>
    <td>
	<form name="form1" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $OrdAyuda;?>">
	<input name="idresulpru" type="hidden" value="<?php echo $idresulpru;?>">
      <table width="100%" border="1">
        <tr> 
          <td colspan="2" bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF">Responsables 
              Relacionados - RESULTADOS</font></strong></font></div>
            <div align="center"></div></td>
        </tr>
        <tr> 
          <td width="27%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre 
              del responsable </font></div></td>
          <td width="73%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Comentario 
              del responsable </font></div></td>
        </tr>
        <?php
			$sql1 = "SELECT * FROM resp_resulteval WHERE id_resulpru='$idresulpru' ORDER BY id_resulpru ASC";
			$result1=mysql_query($sql1);
			while($row1=mysql_fetch_array($result1)) 
  			{
				$sql44="SELECT * FROM users WHERE login_usr='$row1[nombre]'";
				$result44 = mysql_query($sql44);
				$row44 = mysql_fetch_array($result44);
		 ?>
        <tr> 
          <?php $nom="$row44[nom_usr]";
		  $ap="$row44[apa_usr]";
		  $am="$row44[ama_usr]";
		   $name="$nom $ap $am";?>
          <td><?php echo $name;?></td>
          <td><?php echo $row1['comentario'];?>&nbsp;</td>
        </tr>
        <?php 
		 }
		 ?>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td><div align="center"> 
              <select name="nombrespeval" id="select24">
                <option value="0"></option>
                <?php 
					$sql = "SELECT * FROM users ORDER BY apa_usr ASC";
					$result1=mysql_query($sql);
				 	 while ($row1 = mysql_fetch_array($result1)) 
					{
					
					echo '<option value="'.$row1['login_usr'].'">'.$row1['apa_usr'].' '.$row1['ama_usr'].' '.$row1['nom_usr'].'</option>';
					}
			   ?>
              </select>
            </div></td>
          <td align="center"><textarea name="comentarioeval" cols="60"></textarea></td>
        </tr>
        <tr> 
          <td colspan="2"><div align="center"><br>
              <input type="Submit" name="guardar3" value="GUARDAR" <?php print $valid->onSubmit() ?>>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <input type="submit" name="RETORNAR" value="TERMINAR">
            </div></td>
        </tr>
      </table>
 </table>
<?php }?>
