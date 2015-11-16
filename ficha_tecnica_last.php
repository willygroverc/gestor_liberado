<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		12/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Sanitizacion de variables para evitar ataques de SQL injection
// Fecha: 		03/OCT/2013
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])) {
    if ($_SESSION['tipo'] == 'C') {
        header('location:pagina_inicio.php');
    }
}
$var = isset($_REQUEST['var']);
$TpRegFicha = isset($_REQUEST['TpRegFicha']);
if (isset($_REQUEST['RETORNAR'])) {
    header("location: lista_ficha.php");
}
if (isset($_REQUEST['ModCarac'])) {
    header("location: caracteristica_last.php?variable1=$var&variable2=$TpRegFicha");
}
if (isset($_REQUEST['ModCarac2'])) {
    header("location: caracteristica2_last.php?variable1=$var&variable2=$TpRegFicha&visual=1");
}
if (isset($_REQUEST['GUARDATOS'])) {
    include("conexion.php");
    $FechAlta = $_REQUEST['ano1'] . '-' . $_REQUEST['mes1'] . '-' . $_REQUEST['dia1'];
    $GarantDe = $_REQUEST['ano2'] . '-' . $_REQUEST['mes2'] . '-' . $_REQUEST['dia2'];
    $GarantAl = $_REQUEST['ano3'] . '-' . $_REQUEST['mes3'] . '-' . $_REQUEST['dia3'];
    $RealizFicha=$_REQUEST['RealizFicha'];
    $Marca=$_REQUEST['Marca'];
    $AdicUSI=$_REQUEST['AdicUSI'];
    $Modelo=$_REQUEST['Modelo'];
    $CodActFijo=$_REQUEST['CodActFijo'];
    $NumSerie=$_REQUEST['NumSerie'];
    $Proveedor=$_REQUEST['Proveedor'];
    $TpRegFicha = $_REQUEST['TpRegFicha'];
    
    if ($_REQUEST['AdicUSI'] != $_REQUEST['AdicUSI2'])
        $sql5 = "UPDATE datfichatec SET TpRegFicha='$TpRegFicha',FechPruFunc='" . date("Y-m-d") . "',RealizFicha='$RealizFicha',Marca='$Marca'," .
                "AdicUSI='$AdicUSI',Modelo='$Modelo',CodActFijo='$CodActFijo',NumSerie='$NumSerie',FechAlta='$FechAlta',Proveedor='$Proveedor',GarantDe='$GarantDe',GarantAl='$GarantAl' " .
                "WHERE IdFicha='$var'";
    else
        $sql5 = "UPDATE datfichatec SET TpRegFicha='$TpRegFicha',FechPruFunc='" . date("Y-m-d") . "',RealizFicha='$RealizFicha',Marca='$Marca'," .
                "Modelo='$Modelo',CodActFijo='$CodActFijo',NumSerie='$NumSerie',FechAlta='$FechAlta',Proveedor='$Proveedor',GarantDe='$GarantDe',GarantAl='$GarantAl' " .
                "WHERE IdFicha='$var'";
    //print_r($sql5);
    //exit;
    mysql_query($sql5);
    $errorNumber = 0;
    if (mysql_affected_rows() == 1) {
        header("location: lista_ficha.php");
    } else {
        if (mysql_errno() == 1062) {
            $errorForm[$errorNumber++] = "Adicional USI $AdicUSI ya existe. ";
        } else
            $errorForm[$errorNumber++] = "Se ha producido un error al registrar los datos. ";
    }
}
include("top.php");
require_once('funciones.php');
$IdFicha = SanitizeString($_GET['IdFicha']); //modificado FechPruFunc
$sql = "SELECT *, DATE_FORMAT( FechPruFunc, '%d/%m/%Y') AS  FechPruFunc FROM datfichatec WHERE IdFicha='$IdFicha'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
//print_r ($errorForm);
{
    ?>
    <script language="JavaScript" src="calendar.js"></script>
    <?php
    require_once ( "ValidatorJs.php" );
    $valid = new Validator("form1");
    $valid->addIsTextNormal("Marca", "Marca, $errorMsgJs[expresion]");
    $valid->addIsTextNormal("Modelo", "Modelo, $errorMsgJs[expresion]");
    $valid->addIsTextNormal("NumSerie", "Numero de Serie, $errorMsgJs[expresion]");
    $valid->addIsNotEmpty("Proveedor", "Proveedor, $errorMsgJs[empty]");
    $valid->addIsNotEmpty("RealizFicha", "Realizado por, $errorMsgJs[empty]");
    $valid->addIsTextNormal("AdicUSI", "Adicional USI, $errorMsgJs[expresion]");
    $valid->addIsTextNormal("CodActFijo", "Codigo Activo Fijo, $errorMsgJs[expresion]");
    $valid->addIsDate("dia1", "mes1", "ano1", "Fecha de Alta, $errorMsgJs[date]");
    $valid->addIsDate("dia2", "mes2", "ano2", "Fecha de Garantia Inicio, $errorMsgJs[date]");
    $valid->addIsDate("dia3", "mes3", "ano3", "Fecha de Garantia Final, $errorMsgJs[date]");
//$valid->addCompareDates   ( "dia1", "mes1", "ano1","dia2", "mes2", "ano2", $errorMsgJs[compareDates]);
    $valid->addCompareDates("dia2", "mes2", "ano2", "dia3", "mes3", "ano3", $errorMsgJs['compareDates']);
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
        <input name="var" type="hidden" value="<?php echo $IdFicha; ?>"><br>
        <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
            <tr> 
                <td background="images/main-button-tileR1.jpg" height="25"><div align="center"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">FICHA 
                            TECNICA</font></strong></div></td>
            </tr>
        </table>
        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="326">
                    <div align="center">
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" background="images/fondo.jpg">
                            <tr>
                                <td height="440"> 
                                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr> 
                                            <td colspan="2"> <div align="center"> 
                                                    <table width="80%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr> 
                                                            <td width="63%"><div align="right"><strong><font size="2" face="Arial, Helvetica, sans-serif">TIPO 
                                                                        DE REGISTRO : </font></strong> 
                                                                    <select name="TpRegFicha">
                                                                        <?php
                                                                        $IdFicha=$_REQUEST['IdFicha'];
                                                                        $sqlaux = "SELECT * FROM menu_parametros WHERE cat='ft' AND estado = 1 ORDER BY descrip ASC";
                                                                        $resultaux = mysql_query($sqlaux);
                                                                        while ($rowaux = mysql_fetch_array($resultaux)) {
                                                                            $sqlt = "select TpRegFicha from datfichatec where IdFicha='$IdFicha'";
                                                                            $resultt = mysql_query($sqlt);
                                                                            while ($rowt = mysql_fetch_array($resultt)) {
                                                                                if ($rowt['TpRegFicha'] == $rowaux['descrip']) {
                                                                                    echo "<option value=\"$rowaux[descrip]\">$rowaux[descrip]</option>";
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    &nbsp;</div></td>
                                                            <td width="37%"><div align="right"><font size="3" face="Arial, Helvetica, sans-serif"><strong>N&deg;&nbsp; 
    <?php echo $IdFicha; ?> </strong></font></div></td>
                                                        </tr>
                                                    </table>
                                                    <p>&nbsp;</p>
                                                </div></td>
                                        </tr>
                                        <tr> 
                                            <td width="53%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;Fecha 
                                                de Prueba de Funcionamiento :</font> <?php echo $row['FechPruFunc']; ?>                    </td>
                                            <td width="47%"> <font size="2" face="Arial, Helvetica, sans-serif">Realizado 
                                                por&nbsp;&nbsp; :</font>&nbsp;&nbsp;&nbsp;&nbsp; 
                                                <select name="RealizFicha" id="select2">
                                                    <option value="0"></option>
                                                    <?php
                                                    $sql2 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0 ORDER BY apa_usr ASC";
                                                    $result2 = mysql_query($sql2);
                                                    while ($row2 = mysql_fetch_array($result2)) {
                                                        if ($row['RealizFicha'] == $row2['login_usr'])
                                                            echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
                                                        else
                                                            echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
                                                    }
                                                    ?>
                                                </select></td>
                                        </tr>
                                    </table>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <!--DWLayoutTable-->
                                        <tr> 
                                            <td width="103" height="25" align="left" valign="middle"><font size="2" face="Arial, Helvetica, sans-serif"> Marca :</font></td>
                                            <td width="342" valign="top"><strong>&nbsp;</strong>
                                                <input name="Marca" type="text" value="<?php echo $row['Marca']; ?>" size="40%" maxlength="40"></td>
                                            <td width="411"><font size="2" face="Arial, Helvetica, sans-serif">Codigo 
                                                Adicional&nbsp;:&nbsp;</font> 
                                                <input name="AdicUSI" type="text" value="<?php echo $row['AdicUSI']; ?>" size="40%" maxlength="40"></td>
                                        </tr>
                                        <tr> 
                                            <td height="22" align="left" valign="middle"><font size="2" face="Arial, Helvetica, sans-serif">Modelo:</font></td>
                                            <td valign="top"><strong>&nbsp;</strong>
                                                <input name="Modelo" type="text" value="<?php echo $row['Modelo']; ?>" size="40%" maxlength="40"></td>
                                            <td><font size="2" face="Arial, Helvetica, sans-serif">Codigo 
                                                Activo Fijo: </font> 
                                                <input name="CodActFijo" type="text" value="<?php echo $row['CodActFijo']; ?>" size="40%" maxlength="40"></td>
                                        </tr>
                                        <tr> 
                                            <td height="23" align="left" valign="middle"><font size="2" face="Arial, Helvetica, sans-serif">Num. Serie: </font></td>
                                            <td valign="top"><strong>&nbsp;</strong>
                                                <input name="NumSerie" type="text" value="<?php echo $row['NumSerie']; ?>" size="40%" maxlength="20" /></td>
                                            <td><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
                                                de Alta :</font>  
                                                <select name="dia1" >
                                                    <?php
                                                    $a1 = substr($row['FechAlta'], 0, 4);
                                                    $m1 = substr($row['FechAlta'], 5, 2);
                                                    $d1 = substr($row['FechAlta'], 8, 2);
                                                    for ($i = 1; $i <= 31; $i++) {
                                                        echo "<option value=\"$i\"";
                                                        if ($d1 == "$i")
                                                            echo "selected";
                                                        echo">$i</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <select name="mes1">
                                                    <?php
                                                    for ($i = 1; $i <= 12; $i++) {
                                                        echo "<option value=\"$i\"";
                                                        if ($m1 == "$i")
                                                            echo "selected";
                                                        echo">$i</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <select name="ano1">
    <?php
    for ($i = 2003; $i <= 2020; $i++) {
        echo "<option value=\"$i\"";
        if ($a1 == "$i")
            echo "selected";
        echo">$i</option>";
    }
    ?>
                                                </select>
                                                <strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong>                    </td>
                                        </tr>
                                        <tr> 
                                            <td height="24" align="left" valign="middle"><font size="2" face="Arial, Helvetica, sans-serif">Proveedor:</font></td>

                                            <td valign="top"><strong>&nbsp;</strong>
                                                <select name="Proveedor" id="proveedor">
                                                    <option value="0"></option>
                                                    <?php
                                                    $sql3 = "SELECT IdProv, NombProv FROM proveedor";
                                                    $result3 = mysql_query($sql3);
                                                    while ($row3 = mysql_fetch_array($result3)) {
                                                        if ($row['Proveedor'] == $row3['IdProv'])
                                                            echo "<option value=\"$row3[IdProv]\" selected> $row3[NombProv]</option>";
                                                        else
                                                            echo "<option value=\"$row3[IdProv]\"> $row3[NombProv] </option>";
                                                    }
                                                    ?>
                                                </select>                    </td>

                                            <td><font size="2" face="Arial, Helvetica, sans-serif">Garantia 
                                                del&nbsp;&nbsp;&nbsp;</font><strong>&nbsp;&nbsp;</strong> 
                                                <select name="dia2" >
                                                    <?php
                                                    $a2 = substr($row['GarantDe'], 0, 4);
                                                    $m2 = substr($row['GarantDe'], 5, 2);
                                                    $d2 = substr($row['GarantDe'], 8, 2);
                                                    for ($i = 1; $i <= 31; $i++) {
                                                        echo "<option value=\"$i\"";
                                                        if ($d2 == "$i")
                                                            echo "selected";
                                                        echo">$i</option>";
                                                    }
                                                    ?>
                                                </select> 
                                                <select name="mes2">
    <?php
    for ($i = 1; $i <= 12; $i++) {
        echo "<option value=\"$i\"";
        if ($m2 == "$i")
            echo "selected";
        echo">$i</option>";
    }
    ?>
                                                </select> 
                                                <select name="ano2">
                                                    <?php
                                                    for ($i = 2003; $i <= 2020; $i++) {
                                                        echo "<option value=\"$i\"";
                                                        if ($a2 == "$i")
                                                            echo "selected";
                                                        echo">$i</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal2.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></td>
                                        </tr>
                                    </table>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr> 
                                            <td width="53%">&nbsp;</td>
                                            <td width="47%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;al&nbsp;</font> 
                                                <font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font>&nbsp;&nbsp;&nbsp; 
                                                <select name="dia3" >
    <?php
    $a3 = substr($row['GarantAl'], 0, 4);
    $m3 = substr($row['GarantAl'], 5, 2);
    $d3 = substr($row['GarantAl'], 8, 2);
    for ($i = 1; $i <= 31; $i++) {
        echo "<option value=\"$i\"";
        if ($d3 == "$i")
            echo "selected";
        echo">$i</option>";
    }
    ?>
                                                </select> <select name="mes3">
                                                <?php
                                                for ($i = 1; $i <= 12; $i++) {
                                                    echo "<option value=\"$i\"";
                                                    if ($m3 == "$i")
                                                        echo "selected";
                                                    echo">$i</option>";
                                                }
                                                ?>
                                                </select> <select name="ano3">
                                                <?php
                                                for ($i = 2003; $i <= 2020; $i++) {
                                                    echo "<option value=\"$i\"";
                                                    if ($a3 == "$i")
                                                        echo "selected";
                                                    echo">$i</option>";
                                                }
                                                ?>
                                                </select> &nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal3.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></td>
                                        </tr>
                                        <tr> 
                                            <td height="231" colspan="2"> 
    <?php
    $IdFicha = $_REQUEST['IdFicha'];
    $aux = "info";
    $sql_aux = "SELECT MAX(idTabla) AS nom FROM caracfichtec WHERE IdFicha='$IdFicha' GROUP BY idTabla";
    $result = mysql_query($sql_aux);
    while ($row = mysql_fetch_array($result)) {
        $aux.=",'" . $row['nom'] . "'";
    }
    $aux = str_replace("info,", "", $aux);
    //echo $aux;
    $sql4 = "SELECT * FROM caracfichtec WHERE idTabla IN (" . $aux . ") ORDER BY IdFicha ASC";
    $result4 = mysql_query($sql4);
    $aux = "info";
    ///esta consulta da un error por eso se cambio la sql
    //$sql_aux="SELECT MAX(idTabla) AS nom FROM ficha_software WHERE IdFicha='$_REQUEST[IdFicha]' GROUP BY idTabla";
    $sql_aux = "SELECT MAX(IdFicha) AS nom FROM ficha_software WHERE IdFicha='$_REQUEST[IdFicha]' GROUP BY IdFicha";

    $result = mysql_query($sql_aux);
    while ($row = mysql_fetch_array($result)) {
        $aux.=",'" . $row['nom'] . "'";
    }
    $aux = str_replace("info,", "", $aux);
    $sql5 = "SELECT * FROM ficha_software WHERE idTabla IN (" . $aux . ") ORDER BY IdFicha ASC";
    $result5 = mysql_query($sql5);
    ?>
                                                <p>&nbsp;</p>
                                                <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
                                                    <tr> 
                                                        <td background="images/main-button-tileR1.jpg" height="25"><div align="center"><strong><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">CARACTERISTICAS 
                                                                    (VELOCIDAD, HD, RAM)</font></strong></div></td>
                                                    </tr>
                                                </table>
                                                <table width="90%" border="2" align="center" cellpadding="0" cellspacing="0">
                                                    <tr bgcolor="#006699"> 
                                                        <td width="25%" background="images/main-button-tileR1.jpg" height="25"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Accesorios</font></strong></font></div></td>
                                                        <td width="15%" background="images/main-button-tileR1.jpg" height="25"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Capacidad</font></strong></font></div></td>
                                                        <td width="15%" background="images/main-button-tileR1.jpg" height="25"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Velocidad</font></strong></font></div></td>
                                                        <td width="15%" background="images/main-button-tileR1.jpg" height="25"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Marca</font></strong></font></div></td>
                                                        <td width="15%" background="images/main-button-tileR1.jpg" height="25"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Modelo 
                                                                    / Serie</font></strong></font></div></td>
                                                        <td width="15%" background="images/main-button-tileR1.jpg" height="25"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Adicional</font></strong></font></div></td>
                                                    </tr>
    <?php
    while ($row = mysql_fetch_array($result4)) {
        ?>
                                                        <tr> 
                                                            <td><div align="center">&nbsp;<?php echo $row['Accesorio']; ?></div></td>
                                                            <td><div align="center">&nbsp;<?php echo $row['Capacid']; ?></div></td>
                                                            <td><div align="center">&nbsp;<?php echo $row['Veloc']; ?></div></td>
                                                            <td><div align="center">&nbsp;<?php echo $row['Marca']; ?></div></td>
                                                            <td><div align="center">&nbsp;<?php echo $row['ModSerie']; ?></div></td>
                                                            <td><div align="center">&nbsp;<?php echo $row['Adicio']; ?></div></td>
                                                        </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    <tr> 
                                                        <td colspan="6">&nbsp;</td>
                                                    </tr>
                                                    <tr> 
                                                        <td colspan="6"><div align="right"> 
                                                                <input type="submit" name="ModCarac" value="MODIFICAR CARACTERISTICAS">
                                                            </div></td>
                                                    </tr>
                                                </table><br><br>
                                                <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
                                                    <tr> 
                                                        <td background="images/main-button-tileR1.jpg" height="25"><div align="center"><strong><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">CARACTERISTICAS 
                                                                    DEL SOFTWARE</font></strong></div></td>
                                                    </tr>
                                                </table>

                                                <div align="center">
                                                    <table width="90%" border="2" align="center" cellpadding="0" cellspacing="0">
                                                        <tr bgcolor="#006699"> 
                                                            <td width="25%" background="images/main-button-tileR1.jpg" height="25"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Software</font></strong></font></div></td>
                                                            <td width="15%" background="images/main-button-tileR1.jpg" height="25"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Tipo</font></strong></font></div></td>
                                                            <td width="15%" background="images/main-button-tileR1.jpg" height="25"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Plataforma</font></strong></font></div></td>
                                                            <td width="15%" background="images/main-button-tileR1.jpg" height="25"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Compa&ntilde;ia</font></strong></font></div></td>
                                                            <td width="15%" background="images/main-button-tileR1.jpg" height="25"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Version</font></strong></font></div></td>
                                                            <td width="15%" background="images/main-button-tileR1.jpg" height="25"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Adicional</font></strong></font></div></td>
                                                        </tr>
    <?php
    while (@$row = mysql_fetch_array($result5)) {
        ?>
                                                            <tr> 
                                                                <td><div align="center">&nbsp;<?php echo $row['soft'] ?></div></td>
                                                                <td><div align="center">&nbsp;<?php echo $row['tipo'] ?></div></td>
                                                                <td><div align="center">&nbsp;<?php echo $row['plataforma'] ?></div></td>
                                                                <td><div align="center">&nbsp;<?php echo $row['comp'] ?></div></td>
                                                                <td><div align="center">&nbsp;<?php echo $row['ver'] ?></div></td>
                                                                <td><div align="center">&nbsp;<?php echo $row['adicio'] ?></div></td>
                                                            </tr>
        <?php
    }
    ?>
                                                        <tr> 
                                                            <td colspan="6">&nbsp;</td>
                                                        </tr>
                                                        <tr> 
                                                            <td colspan="6"><div align="right"> 
                                                                    <input type="submit" name="ModCarac2" value="MODIFICAR CARACTERISTICAS">
                                                                </div></td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <input type="submit" name="GUARDATOS" value="GUARDAR CAMBIOS" <?php print $valid->onSubmit() ?>>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                    <input type="submit" name="RETORNAR" value="RETORNAR">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input name="IdFicha" type="hidden" id="IdFicha" value="<?php print $IdFicha ?>">
                                                    <input name="AdicUSI2" type="hidden" id="AdicUSI2" value="<?php print $row['AdicUSI'] ?>">
                                                </div>
                                                <p></p></td>
                                        </tr>
                                    </table></td>
                            </tr>
                        </table>

                    </div></td>
            </tr>
        </table>
    </form>
    <script language="JavaScript">
        <!-- 
                  var cal1 = new calendar1(document.forms['form1'].elements['dia1'], document.forms['form1'].elements['mes1'], document.forms['form1'].elements['ano1']);
        cal1.year_scroll = true;
        cal1.time_comp = false;
        var cal2 = new calendar1(document.forms['form1'].elements['dia2'], document.forms['form1'].elements['mes2'], document.forms['form1'].elements['ano2']);
        cal2.year_scroll = true;
        cal2.time_comp = false
        var cal3 = new calendar1(document.forms['form1'].elements['dia3'], document.forms['form1'].elements['mes3'], document.forms['form1'].elements['ano3']);
        cal3.year_scroll = true;
        cal3.time_comp = false;
    //-->
    </script>
    <?php
    if (isset($errorForm)) {
        print "<script language=\"JavaScript\">\n<!--\n";
        foreach ($errorForm as $tmp) {
            print "alert (\"$tmp\");\n";
        }
        print "-->\n</script>";
    }
    ?>  
<?php
}?>