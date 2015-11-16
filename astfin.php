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
if (isset($_REQUEST['RETORNAR'])) {
    header("location: ast11.php");
}
if (isset($_REQUEST['reg_form2'])) {
    require("conexion.php");
    /* 	if ($medio_ret == "Impreso")
      {
      $medio_dest = "Triturado";
      }
     */
    $var=$_REQUEST['var'];
    $des_infAST=$_REQUEST['des_infAST'];
    $clasifi=$_REQUEST['clasifi'];
    $numero=$_REQUEST['numero'];
    $medio_ret=$_REQUEST['medio_ret'];
    $medio_dest=$_REQUEST['medio_dest'];
    $control_dest=$_REQUEST['control_dest'];
    $acta_dest=$_REQUEST['acta_dest'];
    $control=$_REQUEST['control'];
    $tecnico=$_REQUEST['tecnico'];
    $tiempo=$_REQUEST['tiempo'];

    $sql4 = "INSERT INTO " .
            "informacionast(des_infAST,clasifi,tiempo_ret,medio_ret,medio_dest,control_dest,acta_dest,control,tecnico,clas_tiempo) " .
            "VALUES('$des_infAST','$clasifi','$numero','$medio_ret','$medio_dest','$control_dest','$acta_dest','$control','$tecnico','$tiempo')";
    print_r($sql4);
    //exit;
    mysql_query($sql4);

    header("location: astfin.php?varia1=$var");
} else {
    include("top.php");
    $id_infAST = ($_GET['varia1']);
    ?>
    <?php
    require_once ( "ValidatorJs.php" );
    $valid = new Validator("form1");
    $valid->addIsNotEmpty("tecnico", "Tecnico, $errorMsgJs[empty]");
    $valid->addExists("des_infAST", "Descripcion, $errorMsgJs[empty]");
    $valid->addLength("des_infAST", "Descripcion, $errorMsgJs[length]");
    $valid->addIsNumber("numero", "Retencion, $errorMsgJs[number]");
    $valid->addExists("acta_dest", "Acta, $errorMsgJs[empty]");
    $valid->addExists("control", "Procedimiento de Control, $errorMsgJs[empty]");
    $valid->addLength("control", "Procedimiento de Control, $errorMsgJs[length]");
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
    <table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#EAEAEA"  background="images/fondo.jpg">   
        <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
            <input name="var" type="hidden" value="<?php echo $id_infAST; ?>">
            <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
                <tr> 
                    <td colspan="9" background="images/main-button-tileR1.jpg"><div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CLASIFICACION 
                                DE LA INFORMACION MANEJADA</font></strong></div></td>
                </tr>
                <tr bgcolor="#006699"> 
                    <td width="14%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tecnico</font></div></td>
                    <td width="12%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Descripcion</font></div></td>
                    <td width="11%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Clasificacion</font></div></td>
                    <td colspan="2" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Retencion</font></div></td>
                    <td colspan="3" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Destruccion</font></div></td>
                    <td width="18%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Procedimiento 
                            de Control</font></div></td>
                </tr>
                <tr bgcolor="#006699"> 
                    <td width="9%" height="18" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tiempo</font></div></td>
                    <td width="8%" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Medio</font></div></td>
                    <td width="10%" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Medio</font></div></td>
                    <td width="8%" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Control</font></div></td>
                    <td width="10%" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Acta</font></div></td>
                </tr>
                <?php
                $sql1 = "SELECT * FROM informacionast WHERE id_infAST>='$id_infAST' ORDER BY id_infAST ASC";
                $result1 = mysql_query($sql1);
                while ($row1 = mysql_fetch_array($result1)) {
                    ?>
                    <tr> 
                        <?php
                        $sql2 = "SELECT * FROM users WHERE login_usr='" . $row1['tecnico'] . "'";
                        $result2 = mysql_query($sql2);
                        $row2 = mysql_fetch_array($result2);
                        echo '<td align="center"><font size="1">&nbsp;' . $row2['nom_usr'] . ' ' . $row2['apa_usr'] . ' ' . $row2['ama_usr'] . '</font></td>';
                        ?>
                        <td><div align="center">&nbsp;<?php echo $row1['des_infAST']; ?></div></td>
                        <td><div align="center">&nbsp;<?php echo $row1['clasifi']; ?></div></td>
                        <td><div align="center">&nbsp;<?php echo $row1['tiempo_ret']; ?>&nbsp;<?php echo $row1['clas_tiempo']; ?> 
                            </div></td>
                        <td><div align="center">&nbsp;<?php echo $row1['medio_ret']; ?></div></td>
                        <td><div align="center">&nbsp;<?php echo $row1['medio_dest']; ?></div></td>
                        <td><div align="center">&nbsp;<?php echo $row1['control_dest']; ?></div></td>
                        <td><div align="center">&nbsp;<?php echo $row1['acta_dest']; ?></div></td>
                        <td><div align="center">&nbsp;<?php echo $row1['control']; ?></div></td>
                    </tr>
                    <?php
                }
                ?>
                <tr> 
                    <td colspan="9">&nbsp;</td>
                </tr>
            </table>
            <br>
            <table width="90%" border="2" align="center" background="images/fondo.jpg">
                <tr> 
                    <td width="26%" rowspan="3" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tecnico</font></div></td>
                    <td width="35%" rowspan="3" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Descripcion</font></div></td>
                    <td width="18%" rowspan="3" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Clasificacion</font></div></td>
                </tr>
                <tr> 
                    <td background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Retencion</font></div></td>
                </tr>
                <tr> 
                    <td width="21%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tiempo</font></div></td>
                </tr>
                <tr> 
                    <td rowspan="2"><div align="center">
                            <select name="tecnico" id="select5">
                                <option value="0"></option>
                                <?php
                                include ("conexion.php");
                                $link = mysql_connect($host, $user, $pass) or die("Error durante la conexion a la base de datos");
                                $sql = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear='0' ORDER BY apa_usr ASC";
                                $result = mysql_query($sql);
                                while ($row = mysql_fetch_array($result)) {
                                    echo '<option value="' . $row['login_usr'] . '">' . $row['apa_usr'] . ' ' . $row['ama_usr'] . ' ' . $row['nom_usr'] . '</option>';
                                }
                                ?>
                            </select>
                        </div></td>
                    <td rowspan="2"> <div align="center"> 
                            <textarea name="des_infAST" cols="30"></textarea>
                        </div></td>
                    <td rowspan="2"><div align="center"> 
                            <select name="clasifi">
                                <option value="Confidencial">Confidencial</option>
                                <option value="Reservada">Reservada</option>
                                <option value="Interna">Interna</option>
                                <option value="Publica">Publica</option>
                            </select>
                        </div></td>
                    <td rowspan="2"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                            </font> 
                            <input name="numero" type="text" size="3" maxlength="3">
                            &nbsp; 
                            <select name="tiempo">
                                <option value="Dias">Dias</option>
                                <option value="Semanas">Semanas</option>
                                <option value="Meses">Meses</option>
                                <option value="Anos">Anos</option>
                            </select>
                        </div></td>
                </tr>
            </table>
            <table width="90%" border="2" align="center" background="images/fondo.jpg">
                <tr> 
                    <td background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Retencion 
                            </font></div></td>
                    <td colspan="3" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Destruccion 
                            </font></div></td>
                    <td width="30%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Procedimiento 
                            de Control</font></div></td>
                </tr>
                <tr> 
                    <td width="18%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Medio</font></div></td>
                    <td width="16%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Medio</font></div></td>
                    <td width="17%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Control</font></div></td>
                    <td width="19%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Acta</font></div></td>
                </tr>
                <tr> 
                    <td> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif"> 
                            <input name="medio_ret" type="radio" id="radio2" value="Impreso" checked>
                            Impreso</font></div></td>
                    <td rowspan="2"><div align="left"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="medio_dest" value="Triturado" checked>
                            </font></font></font></font></font></font></font><font size="1" face="Arial, Helvetica, sans-serif">Triturado</font><font size="1" face="Arial, Helvetica, sans-serif"><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="medio_dest" value="Picado">
                            Picado </font>&nbsp;<font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="medio_dest" value="Incinerado">
                            Incinerado</font></font></font></font></div></td>
                    <td rowspan="2"><div align="center"> 
                            <select name="control_dest">
                                <option value="Dual">Dual</option>
                                <option value="Personal">Personal</option>
                            </select>
                        </div></td>
                    <td rowspan="2"><div align="center"> 
                            <input name="acta_dest" type="text" size="20" maxlength="20">
                        </div></td>
                    <td rowspan="2"><div align="center"> 
                            <textarea name="control" cols="30"></textarea>
                        </div></td>
                </tr>
                <tr> 
                    <td height="31"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif"> 
                            &nbsp;&nbsp;&nbsp;&nbsp; 
                            <input type="radio" name="medio_ret" value="Digitalizado" id="radio5">
                            Digitalizado</font></div></td></tr><tr>
                    <td height="54" colspan="5" align="center"> <div align="center"><br>
                            <input name="reg_form2" type="submit" id="reg_form22" value="GUARDAR" <?php print $valid->onSubmit() ?>>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            <input type="submit" name="RETORNAR" value="RETORNAR">
                        </div></tr>
            </table>
        </form>

    <?php } ?>
