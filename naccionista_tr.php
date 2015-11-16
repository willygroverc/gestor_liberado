<?php 
include("conexion.php");
$cad = $dato;
include("top.php");
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "txtObservacion",  "Observaciones, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "list1",  "Usuario origen, $errorMsgJs[empty]" );
$valid->addFunction ( "autocompleteDate",  "" );
echo $valid->toHtml ();
if (isset($retornar)){
			header("location: accionistas.php");
}
?>
<form name="form1" method="post" action="traspaso.php">
<table width="65%" border="1" align="center" background="images/fondo.jpg">
    <tr>         
      <th background="images/main-button-tileR1.jpg" colspan="2">DATOS DEL ACCIONISTA
	  </th>
    </tr>
	<tr>
		<td align="center">
			</br>
            De: <select multiple name="list1" size="8" style="width:250px"">  
			<?php	
				$sql = "SELECT a.*, DATE_FORMAT(fecha_acc, '%d/%m/%Y') AS fecha_acc FROM accionistas a GROUP BY a.id_acc";
				$result=mysql_db_query($db,$sql,$link);
				while ($row=mysql_fetch_array($result)){
				?>
					<option value="<?php echo $row[id_acc];?>"><?php echo "$row[nom_acc]";	?></option>
				<?php
				}
			?>
			</select>
		</td>
		</br>
		<td align="center">
				 <br>A: 
			<select multiple name="list2" id="list2" size="8" style="width:250px">  
					<?php	
					$sql = "SELECT a.*, DATE_FORMAT(fecha_acc, '%d/%m/%Y') AS fecha_acc FROM accionistas a GROUP BY a.id_acc";
					$result=mysql_db_query($db,$sql,$link);
					while ($row=mysql_fetch_array($result)){
					?>
						<option value="<?php echo $row[id_acc];?>"><?php echo "$row[nom_acc]";	?></option>
					<?php
					}
				?>
			</select>
				
		</td>
	</tr>
    <tr>
		<td colspan="2" align="center">
			<label>
			<input type="radio" name="GrupoOpciones1" value="Si" id="GrupoOpciones1_0" onClick="document.getElementById('list2').disabled=false;document.getElementById('txtpregunta2').disabled=false;" checked/>
			Existente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<!--<input type="radio" name="existe" value="1" checked> -->
			<label>
			  <input type="radio" name="GrupoOpciones1" value="No" id="GrupoOpciones1_1" onClick="document.getElementById('list2').disabled=true;document.getElementById('txtpregunta2').disabled=true;"/>
			  Nuevo</label><br>
			
			Obserbaciones: &nbsp;&nbsp<textarea name="txtObservacion" cols="50" rows="2"></textarea>
			</br>
			<input name="traspasar" type="submit" value="REALIZAR PROCESO" <?php echo $valid->onSubmit(); ?>> 
		</td>
	</tr>
    </table>
</form>
<?php include("top_.php");?>
