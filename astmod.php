<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		06/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])) {
    if ($_SESSION['tipo'] == 'C') {
        header('location:pagina_inicio.php');
    }
}

if (isset($_REQUEST['GUARDATOS'])) {
    require("conexion.php");
    $des_infAST=$_REQUEST['des_infAST'];
    $clasifi=$_REQUEST['clasifi'];
    $numero=$_REQUEST['numero'];
    $tiempo=$_REQUEST['tiempo'];
    $medio_ret=$_REQUEST['medio_ret'];
    $medio_dest=$_REQUEST['medio_dest'];
    $control_dest=$_REQUEST['control_dest'];
    $acta_dest=$_REQUEST['acta_dest'];
    $control=$_REQUEST['control'];
    $tecnico=$_REQUEST['tecnico'];
    $var=$_REQUEST['var'];
    if ($medio_ret == "Impreso") {
        $medio_dest = "Picado";
    }
    $sql6 = "UPDATE informacionast SET des_infAST='$des_infAST',clasifi='$clasifi',tiempo_ret='$numero',clas_tiempo='$tiempo',medio_ret='$medio_ret',medio_dest='$medio_dest',control_dest='$control_dest',acta_dest='$acta_dest',control='$control',tecnico='$tecnico' " .
            "WHERE id_infAST='$var'";
    mysql_query($sql6);
    header("location: ast11.php");
}
if (isset($_REQUEST['RETORNAR']))
    header('location: ast11.php');
include("top.php");
@$id_infAST = ($_GET['id_infAST']);
$sql = "SELECT * FROM informacionast WHERE id_infAST='$id_infAST'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

require_once ( "ValidatorJs.php" );
$valid = new Validator("form1");
$valid->addIsNotEmpty("tecnico", "Tecnico, $errorMsgJs[empty]");
$valid->addExists("des_infAST", "Descripcion, $errorMsgJs[empty]");
$valid->addIsNumber("numero", "Retencion, $errorMsgJs[number]");
$valid->addExists("acta_dest", "Acta, $errorMsgJs[empty]");
$valid->addExists("control", "Procedimiento de Control, $errorMsgJs[empty]");
print $valid->toHtml();
?>  
<script language="JavaScript">
<!--
    function Form() {
        var key = window.event.keyCode;
        if (key == 13)
            return false;
        else
            return true;
    }
-->
</script>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
    <input name="var" type="hidden" value="<?php echo $id_infAST; ?>">
    <table width="90%" border="2" align="center" cellpadding="0" cellspacing="1" background="images/fondo.jpg">
        <tr> 
            <td colspan="9" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>CLASIFICACION 
                        DE LA INFORMACION MANEJADA</strong></font></div></td>
        </tr>
        <tr bgcolor="#006699"> 
            <td width="17%" rowspan="2"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tecnico</font></div></td>
            <td width="22%" rowspan="2"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Descripcion</font></div></td>
            <td width="10%" rowspan="2"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Clasificacion</font></div></td>
            <td colspan="2"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Retencion</font></div></td>
            <td colspan="3"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Destruccion</font></div></td>
            <td width="16%" rowspan="2"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Control</font></div></td>
        </tr>
        <tr bgcolor="#006699"> 
            <td width="8%" height="21"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tiempo</font></div></td>
            <td width="7%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Medio</font></div></td>
            <td width="6%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Medio</font></div></td>
            <td width="7%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Control</font></div></td>
            <td width="7%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Acta</font></div></td>
        </tr>
        <tr> 
            <?php
            $sql2 = "SELECT * FROM users WHERE login_usr='$row[tecnico]'";
            $result2 = mysql_query($sql2);
            $row2 = mysql_fetch_array($result2);
            echo '<td align="center"><font size="1">&nbsp;' . $row2['nom_usr'] . ' ' . $row2['apa_usr'] . ' ' . $row2['ama_usr'] . '</font></td>';
            ?>
            <td><div align="center">&nbsp;<?php echo $row['des_infAST']; ?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['clasifi']; ?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['tiempo_ret'] ?> <?php echo $row['clas_tiempo']; ?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['medio_ret']; ?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['medio_dest']; ?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['control_dest']; ?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['acta_dest']; ?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['control']; ?></div></td>
        </tr>
        <tr> 
            <td colspan="9">&nbsp;</td>
        </tr>
    </table>
    <br>
    <table width="85%" border="2" bgcolor="#CCCCCC" background="images/fondo.jpg" align="center" >
        <tr> 
            <td width="34%" rowspan="3" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tecnico</font></div></td>
            <td width="26%" colspan="-4" rowspan="3" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Descripcion</font></div></td>
            <td width="17%" colspan="-4" rowspan="3" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Clasificacion</font></div></td>
        </tr>
        <tr> 
            <td colspan="-4" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Retencion</font></div></td>
        </tr>
        <tr> 
            <td width="23%" colspan="-4" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tiempo</font></div></td>
        </tr>
        <tr> 
            <td rowspan="2"><div align="center">
                    <select name="tecnico" id="select">
                        <option value="0"></option>
                        <?php
                        $link = mysql_connect($host, $user, $pass) or die("Error durante la conexion a la base de datos");
                        $sql8 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear='0' ORDER BY apa_usr ASC";
                        $result8 = mysql_query($sql8);
                        while ($row8 = mysql_fetch_array($result8)) {
                            echo "<option value=\"$row8[login_usr]\"";
                            if ($row8['login_usr'] == $row['tecnico'])
                                echo "selected";
                            echo ' >  ' . $row8['nom_usr'] . ' ' . $row8['apa_usr'] . ' ' . $row8['ama_usr'] . '</option>';
                        }
                        ?>
                    </select>
                </div></td>
            <td colspan="-4" rowspan="2"> <div align="center"> 
                    <textarea name="des_infAST" cols="25"><?php echo $row['des_infAST'] ?></textarea>
                </div></td>
            <td colspan="-4" rowspan="2"><div align="center"> 
                    <select name="clasifi">
                        <option value="Confidencial"  <?php if ($row['clasifi'] == "Confidencial") echo "selected"; ?>>Confidencial</option>
                        <option value="Reservada"  <?php if ($row['clasifi'] == "Reservada") echo "selected"; ?>>Reservada</option>
                        <option value="Interna"  <?php if ($row['clasifi'] == "Interna") echo "selected"; ?>>Interna</option>
                        <option value="Publica"  <?php if ($row['clasifi'] == "Publica") echo "selected"; ?>>Publica</option>
                    </select>
                </div></td>
            <td colspan="-4" rowspan="2"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                    <input name="numero" type="text" size="2" value="<?php echo $row['tiempo_ret']; ?>">
                    &nbsp; 
                    <select name="tiempo">
                        <option value="Dias" <?php if ($row['clas_tiempo'] == "Dias") echo "selected"; ?>>Dias</option>
                        <option value="Semanas" <?php if ($row['clas_tiempo'] == "Semanas") echo "selected"; ?>>Semanas</option>
                        <option value="Meses" <?php if ($row['clas_tiempo'] == "Meses") echo "selected"; ?>>Meses</option>
                        <option value="Anos" <?php if ($row['clas_tiempo'] == "Anos") echo "selected"; ?>>Anos</option>
                    </select>
                    </font> </div></td>
        </tr>
        <tr> </tr>
    </table>
    <table width="85%" border="2" bgcolor="#CCCCCC" background="images/fondo.jpg" align="center" >
        <tr> 
            <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Retencion 
                    </font></div></td>
            <td colspan="3" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Destruccion 
                    </font></div></td>
            <td width="23%" rowspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Control</font></div></td>
        </tr>
        <tr> 
            <td width="22%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Medio</font></div></td>
            <td width="19%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Medio</font></div></td>
            <td width="19%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Control</font></div></td>
            <td width="17%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Acta</font></div></td>
        </tr>
        <tr> 
            <td height="23"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif"> 
                    <input type="radio" name="medio_ret" value="Impreso" <?php if ($row['medio_ret'] == "Impreso") echo "checked"; ?>>
                    <font size="2">Impreso</font></font></div></td>
            <td rowspan="2"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"> 
                    </font><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
                    </font><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
                    </font></font></font></font><font size="1" face="Arial, Helvetica, sans-serif"> 
                    </font></font></font><font size="1"></font></font><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
                    </font></font></font></font></font></font></font><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font face="Times New Roman, Times, serif"> 
                    <font face="Arial, Helvetica, sans-serif"> <font size="2"> 
                    <input type="radio" name="medio_dest" value="Triturado" <?php if ($row['medio_dest'] == "Triturado") echo "checked"; ?>>
                    </font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font><font size="2" face="Arial, Helvetica, sans-serif">Triturado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="medio_dest" value="Picado" <?php if ($row['medio_dest'] == "Picado") echo "checked"; ?>>
                    Picado </font><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp; <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="medio_dest" value="Incinerado" <?php if ($row['medio_dest'] == "Incinerado") echo "checked"; ?>>
                    Incinerado </font></p> </font></div></td>
            <td rowspan="2"><div align="center"> 
                    <select name="control_dest">
                        <option value="Dual" <?php if ($row['control_dest'] == "Dual") echo "selected"; ?>>Dual</option>
                        <option value="Personal" <?php if ($row['control_dest'] == "Personal") echo "selected"; ?>>Personal</option>
                    </select>
                </div></td>
            <td rowspan="2"><div align="center"> 
                    <input name="acta_dest" type="text" size="20" value="<?php echo $row['acta_dest']; ?>">
                </div></td>
            <td rowspan="2"><div align="center"> 
                    <textarea name="control" cols="20"><?php echo $row['control']; ?></textarea>
                </div></td>
        </tr>
        <tr> 
            <td height="36"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
                    &nbsp;&nbsp;&nbsp; 
                    <input type="radio" name="medio_ret" value="Digitalizado" <?php if ($row['medio_ret'] == "Digitalizado") echo "checked"; ?>>
                    <font size="2"> Digitalizado</font></font></div></td>
        </tr>
        <tr> 
            <td colspan="5"><div align="center"><br>
                    <input type="submit" name="GUARDATOS" value="GUARDAR CAMBIOS" <?php print $valid->onSubmit(); ?>>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    <input type="submit" name="RETORNAR" value="RETORNAR">
                </div></td>
        </tr>
    </table>
    <tr>
        <td colspan="1"><blockquote>

</form>