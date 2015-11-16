<?php include "rptinc/ewcommon.php"; ?>
<?php include "rptinc/ewconfig.php"; ?>
<?php include "rptinc/phprptfn.php"; ?>
<?php include "rptinc/advsecu.php"; ?>
<?php

// PHP Report Maker 1.0 - Table level configuration (Inventario de Medios de Respaldo)
// Table Level Constants

define("EW_TABLE_VAR", "Inventario_de_Medios_de_Respaldo", TRUE);
define("EW_TABLE_GROUP_PER_PAGE", "grpperpage", TRUE);
define("EW_TABLE_SESSION_GROUP_PER_PAGE", "Inventario_de_Medios_de_Respaldo_grpperpage", TRUE);
define("EW_TABLE_START_GROUP", "start", TRUE);
define("EW_TABLE_SESSION_START_GROUP", "Inventario_de_Medios_de_Respaldo_start", TRUE);
define("EW_TABLE_SESSION_SEARCH", "Inventario_de_Medios_de_Respaldo_search", TRUE);
define("EW_TABLE_CHILD_USER_ID", "childuserid", TRUE);
define("EW_TABLE_SESSION_CHILD_USER_ID", "Inventario_de_Medios_de_Respaldo_childuserid", TRUE);

// Table Level SQL
define("EW_TABLE_SQL_FROM", "controlinvent", TRUE);
$EW_TABLE_SQL_SELECT = "SELECT count(*) AS total, controlinvent.nro_cds, controlinvent.nro_corre, controlinvent.FechaAlta, controlinvent.FechaBaja, controlinvent.FechaDestruc, controlinvent.Observ, controlinvent.codigo_usu, controlinvent.tipo_medio, controlinvent.tipo_dato FROM " . EW_TABLE_SQL_FROM;
$EW_TABLE_SQL_WHERE = "";
define("EW_TABLE_SQL_GROUPBY", "controlinvent.nro_cds, controlinvent.nro_corre, controlinvent.FechaAlta, controlinvent.FechaBaja, controlinvent.FechaDestruc, controlinvent.Observ, controlinvent.codigo_usu, controlinvent.tipo_medio, controlinvent.tipo_dato", TRUE);
define("EW_TABLE_SQL_HAVING", "", TRUE);
define("EW_TABLE_SQL_ORDERBY", "controlinvent.codigo_usu ASC, controlinvent.tipo_medio ASC, controlinvent.tipo_dato ASC", TRUE);
define("EW_TABLE_SQL_USERID_FILTER", "", TRUE);
$af_nro_cds = NULL; // Advanced filter for nro_cds
$af_nro_corre = NULL; // Advanced filter for nro_corre
$af_FechaAlta = NULL; // Advanced filter for FechaAlta
$af_FechaBaja = NULL; // Advanced filter for FechaBaja
$af_FechaDestruc = NULL; // Advanced filter for FechaDestruc
$af_Observ = NULL; // Advanced filter for Observ
$af_codigo_usu = NULL; // Advanced filter for codigo_usu
$af_tipo_medio = NULL; // Advanced filter for tipo_medio
$af_tipo_dato = NULL; // Advanced filter for tipo_dato
?>
<?php
$sExport = @$PHP_GET["export"]; // Load export request
if ($sExport == "html") {

	// Printer friendly
}
if ($sExport == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . EW_TABLE_VAR .'.xls');
}
if ($sExport == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . EW_TABLE_VAR .'.doc');
}
?>
<?php
?>
<?php

// Initialize common variables
// Paging variables

$nRecCount = 0; // Record Count
$nStartGrp = 0; // Start Group
$nStopGrp = 0; // Stop Group
$nTotalGrps = 0; // Total Groups
$nGrpCount = 0; // Group Count
$nDisplayGrps = 3; // Groups per page
$nGrpRange = 10;

// Group variables
$x_codigo_usu = NULL; $ox_codigo_usu = NULL; $gx_codigo_usu = NULL; $dgx_codigo_usu = NULL; $tx_codigo_usu = NULL; $ftx_codigo_usu = 200; $gfx_codigo_usu = $ftx_codigo_usu; $gbx_codigo_usu = ""; $gix_codigo_usu = "0"; $rf_codigo_usu = NULL; $rt_codigo_usu = NULL;
$x_tipo_medio = NULL; $ox_tipo_medio = NULL; $gx_tipo_medio = NULL; $dgx_tipo_medio = NULL; $tx_tipo_medio = NULL; $ftx_tipo_medio = 200; $gfx_tipo_medio = $ftx_tipo_medio; $gbx_tipo_medio = ""; $gix_tipo_medio = "0"; $rf_tipo_medio = NULL; $rt_tipo_medio = NULL;
$x_tipo_dato = NULL; $ox_tipo_dato = NULL; $gx_tipo_dato = NULL; $dgx_tipo_dato = NULL; $tx_tipo_dato = NULL; $ftx_tipo_dato = 200; $gfx_tipo_dato = $ftx_tipo_dato; $gbx_tipo_dato = ""; $gix_tipo_dato = "0"; $rf_tipo_dato = NULL; $rt_tipo_dato = NULL;

// Detail variables
$x_nro_cds = NULL; $ox_nro_cds = NULL; $tx_nro_cds = NULL; $ftx_nro_cds = 3; $rf_nro_cds = NULL; $rt_nro_cds = NULL;
$x_nro_corre = NULL; $ox_nro_corre = NULL; $tx_nro_corre = NULL; $ftx_nro_corre = 3; $rf_nro_corre = NULL; $rt_nro_corre = NULL;
$x_FechaAlta = NULL; $ox_FechaAlta = NULL; $tx_FechaAlta = NULL; $ftx_FechaAlta = 133; $rf_FechaAlta = NULL; $rt_FechaAlta = NULL;
$x_FechaBaja = NULL; $ox_FechaBaja = NULL; $tx_FechaBaja = NULL; $ftx_FechaBaja = 133; $rf_FechaBaja = NULL; $rt_FechaBaja = NULL;
$x_FechaDestruc = NULL; $ox_FechaDestruc = NULL; $tx_FechaDestruc = NULL; $ftx_FechaDestruc = 133; $rf_FechaDestruc = NULL; $rt_FechaDestruc = NULL;
$x_Observ = NULL; $ox_Observ = NULL; $tx_Observ = NULL; $ftx_Observ = 201; $rf_Observ = NULL; $rt_Observ = NULL;
?>
<?php

// Open connection to the database
$conn = php_connect(HOST, USER, PASS, DB, PORT);

// Filter
$sFilter = "";
$bFilterApplied = FALSE;

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 7;
$nGrps = 4;
$val = ew_InitArray($nDtls, 0);
$cnt = ew_Init2DArray($nGrps, $nDtls, 0);
$smry = ew_Init2DArray($nGrps, $nDtls, 0);
$mn = ew_Init2DArray($nGrps, $nDtls, NULL);
$mx = ew_Init2DArray($nGrps, $nDtls, NULL);
$grandsmry = ew_InitArray($nDtls, 0);
$grandmn = ew_InitArray($nDtls, NULL);
$grandmx = ew_InitArray($nDtls, NULL);

// Set up if accumulation required
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

// Reset
ResetCmd();

// Set up groups per page dynamically
SetUpDisplayGrps();

// Set up selection
SetupSelection();

// Build sql
$sSql = ew_BuildReportSql("", $EW_TABLE_SQL_SELECT, $EW_TABLE_SQL_WHERE, EW_TABLE_SQL_GROUPBY, EW_TABLE_SQL_HAVING, EW_TABLE_SQL_ORDERBY, "", $sFilter, @$sSort);

// echo $sSql . "<br>"; // uncomment to show sql
// Load recordset

$rs = ew_LoadRs($sSql);
$row = FALSE;
$rsidx = 0;

// Detail distinct & selection values
InitReportData($rs);
if ($nDisplayGrps <= 0) { // Display All Records
	$nDisplayGrps = $nTotalGrps;
}
$nStartGrp = 1;
SetUpStartGroup(); // Set Up Start Record Position
?>
<?php include "rptinc/header.php"; ?>
<?php if (@$sExport == "") { ?>
<script language="JavaScript" src="rptjs/x/x_core.js" type="text/javascript"></script>
<script language="JavaScript" src="rptjs/x/x_event.js" type="text/javascript"></script>
<script language="JavaScript" src="rptjs/x/x_drag.js" type="text/javascript"></script>
<script language="JavaScript" src="rptjs/popup.js" type="text/javascript"></script>
<script language="JavaScript" src="rptjs/ewrptpop.js" type="text/javascript"></script>
<script language="JavaScript" src="rptjs/swfobject.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
<!--
var EW_POPUP_ALL = "(All)";
var EW_POPUP_OK = "  OK  ";
var EW_POPUP_CANCEL = "Cancel";
var EW_POPUP_FROM = "From";
var EW_POPUP_TO = "To";
var EW_POPUP_PLEASE_SELECT = "Please Select";
var EW_POPUP_NO_VALUE = "No value selected!";
var EW_POPUP_CLASSNAME = "phpreportmaker";

// popup fields
//-->

</script>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3" class="ewPadding"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
Inventario de Medios de Respaldo
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="Inventario_de_Medios_de_Respaldosmry.php?export=html">Imprimir</a>
&nbsp;&nbsp;<a href="Inventario_de_Medios_de_Respaldosmry.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="Inventario_de_Medios_de_Respaldosmry.php?export=word">Exportar a Word</a>
<?php } ?>
<br><br>
<?php if (@$sExport == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td valign="top"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- summary report starts -->
<div id="report_summary">
<?php if (@$sExport == "") { ?>
<form action="Inventario_de_Medios_de_Respaldosmry.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php
if ($nTotalGrps > 0) {
	$rsEof = ($nTotalGrps < ($nStartGrp + $nDisplayGrps));
	$PrevStart = $nStartGrp - $nDisplayGrps;
	if ($PrevStart < 1) { $PrevStart = 1; }
	$NextStart = $nStartGrp + $nDisplayGrps;
	if ($NextStart > $nTotalGrps) { $NextStart = $nStartGrp ; }
	$LastStart = intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1;
	?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Pagina&nbsp;</span></td>
<!--first page button-->
	<?php if ($nStartGrp == 1) { ?>
	<td><img src="rptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Inventario_de_Medios_de_Respaldosmry.php?start=1"><img src="rptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($PrevStart == $nStartGrp) { ?>
	<td><img src="rptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Inventario_de_Medios_de_Respaldosmry.php?start=<?php echo $PrevStart; ?>"><img src="rptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" value="<?php echo intval(($nStartGrp-1)/$nDisplayGrps+1); ?>" size="4"></td>
<!--next page button-->
	<?php if ($NextStart == $nStartGrp) { ?>
	<td><img src="rptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Inventario_de_Medios_de_Respaldosmry.php?start=<?php echo $NextStart; ?>"><img src="rptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>
	<?php  } ?>
<!--last page button-->
	<?php if ($LastStart == $nStartGrp) { ?>
	<td><img src="rptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Inventario_de_Medios_de_Respaldosmry.php?start=<?php echo $LastStart; ?>"><img src="rptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;de <?php echo intval(($nTotalGrps-1)/$nDisplayGrps+1);?></span></td>
	</tr></table>
	<?php if ($nStartGrp > $nTotalGrps) { $nStartGrp = $nTotalGrps; }
	$nStopGrp = $nStartGrp + $nDisplayGrps - 1;
	$nGrpCount = $nTotalGrps - 1;
	if ($rsEof) { $nGrpCount = $nTotalGrps; }
	if ($nStopGrp > $nGrpCount) { $nStopGrp = $nGrpCount; } ?>
	<span class="phpreportmaker"> <?php echo $nStartGrp; ?> al <?php echo $nStopGrp; ?> de <?php echo $nTotalGrps; ?></span>
<?php } else { ?>
	<span class="phpreportmaker"></span>	
<?php } ?>
		</td>
<?php if ($nTotalGrps > 0) { ?>
		<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" valign="top" nowrap><span class="phpreportmaker">Grupos por Pagina&nbsp;
<select name="<?php echo EW_TABLE_GROUP_PER_PAGE; ?>" onChange="this.form.submit();" class="phpreportmaker">
<option value="1"<?php if ($nDisplayGrps == 1) echo " selected" ?>>1</option>
<option value="2"<?php if ($nDisplayGrps == 2) echo " selected" ?>>2</option>
<option value="3"<?php if ($nDisplayGrps == 3) echo " selected" ?>>3</option>
<option value="4"<?php if ($nDisplayGrps == 4) echo " selected" ?>>4</option>
<option value="5"<?php if ($nDisplayGrps == 5) echo " selected" ?>>5</option>
<option value="10"<?php if ($nDisplayGrps == 10) echo " selected" ?>>10</option>
<option value="20"<?php if ($nDisplayGrps == 20) echo " selected" ?>>20</option>
<option value="50"<?php if ($nDisplayGrps == 50) echo " selected" ?>>50</option>
<option value="ALL"<?php if (@$PHP_SESSION[EW_TABLE_SESSION_GROUP_PER_PAGE] == -1) echo " selected" ?>>All Records</option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<!-- <form method="get"> -->
<!-- Report Grid (Begin) -->
<table id="ewReport" class="ewTable">
<?php

// Start group <= total number of groups
if (intval($nStartGrp) > intval($nTotalGrps)) {
	$nStartGrp = $nTotalGrps;
}

// Set the last group to display
$nStopGrp = $nStartGrp + $nDisplayGrps - 1;

// Stop group <= total number of groups
if (intval($nStopGrp) > intval($nTotalGrps)) {
	$nStopGrp = $nTotalGrps;
}
$nRecCount = 0;

// Init Summary Values
ResetLevelSummary(0);

// Get First Row
if (count($rs) > 0) {
	GetRow(1);
	$nGrpCount = 1;
}

// Force show first header
$bShowFirstHeader = ($nStartGrp <= 1);
while ($row || $bShowFirstHeader) {

	// Show Header
	if ($bShowFirstHeader || (intval($nGrpCount) >= intval($nStartGrp) && $nGrpCount <= $nStopGrp && ChkLvlBreak(3))) {
?>
	<tr>
		<td valign="bottom" class="ewRptGrpHeader1">
		<?php if ($bShowFirstHeader || ChkLvlBreak(1)) { ?>
		codigo usu
		<?php } ?>
		</td>
		<td valign="bottom" class="ewRptGrpHeader2">
		<?php if ($bShowFirstHeader || ChkLvlBreak(2)) { ?>
		Tipo de Medio
		<?php } ?>
		</td>
		<td valign="bottom" class="ewRptGrpHeader3">
		<?php if ($bShowFirstHeader || ChkLvlBreak(3)) { ?>
		Tipo Dato
		<?php } ?>
		</td>
		<td valign="bottom" class="ewTableHeader">
		nro cds
		</td>
		<td valign="bottom" class="ewTableHeader">
		nro corre
		</td>
		<td valign="bottom" class="ewTableHeader">
		Fecha Alta
		</td>
		<td valign="bottom" class="ewTableHeader">
		Fecha Baja
		</td>
		<td valign="bottom" class="ewTableHeader">
		Fecha Destruc
		</td>
		<td valign="bottom" class="ewTableHeader">
		Observ
		</td>
	</tr>
<?php
		$bShowFirstHeader = FALSE;
	}
	if (intval($nGrpCount) >= intval($nStartGrp) && $nGrpCount <= $nStopGrp) {
		$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1) {
			$sItemRowClass = " class=\"ewTableAltRow\"";
		}

		// Show group values
		$dgx_codigo_usu = $x_codigo_usu;
		if (($x_codigo_usu == NULL && $ox_codigo_usu == NULL) ||
			(($x_codigo_usu <> "" && $ox_codigo_usu == $dgx_codigo_usu) && !ChkLvlBreak(1))) {
			$dgx_codigo_usu = "";
		} elseif ($x_codigo_usu == NULL) {
			$dgx_codigo_usu = EW_NULL_LABEL;
		} elseif ($x_codigo_usu == "") {
			$dgx_codigo_usu = EW_EMPTY_LABEL;
		}
		$dgx_tipo_medio = $x_tipo_medio;
		if (($x_tipo_medio == NULL && $ox_tipo_medio == NULL) ||
			(($x_tipo_medio <> "" && $ox_tipo_medio == $dgx_tipo_medio) && !ChkLvlBreak(2))) {
			$dgx_tipo_medio = "";
		} elseif ($x_tipo_medio == NULL) {
			$dgx_tipo_medio = EW_NULL_LABEL;
		} elseif ($x_tipo_medio == "") {
			$dgx_tipo_medio = EW_EMPTY_LABEL;
		}
		$dgx_tipo_dato = $x_tipo_dato;
		if (($x_tipo_dato == NULL && $ox_tipo_dato == NULL) ||
			(($x_tipo_dato <> "" && $ox_tipo_dato == $dgx_tipo_dato) && !ChkLvlBreak(3))) {
			$dgx_tipo_dato = "";
		} elseif ($x_tipo_dato == NULL) {
			$dgx_tipo_dato = EW_NULL_LABEL;
		} elseif ($x_tipo_dato == "") {
			$dgx_tipo_dato = EW_EMPTY_LABEL;
		}
?>
	<tr<?php echo $sItemRowClass; ?>>
		<td class="ewRptGrpField1">
		<?php $tx_codigo_usu = $x_codigo_usu; $x_codigo_usu = $dgx_codigo_usu; ?>
<?php echo $x_codigo_usu ?>
		<?php $x_codigo_usu = $tx_codigo_usu; ?></td>
		<td class="ewRptGrpField2">
		<?php $tx_tipo_medio = $x_tipo_medio; $x_tipo_medio = $dgx_tipo_medio; ?>
<?php echo $x_tipo_medio ?>
		<?php $x_tipo_medio = $tx_tipo_medio; ?></td>
		<td class="ewRptGrpField3">
		<?php $tx_tipo_dato = $x_tipo_dato; $x_tipo_dato = $dgx_tipo_dato; ?>
<?php echo $x_tipo_dato ?>
		<?php $x_tipo_dato = $tx_tipo_dato; ?></td>
		<td class="ewRptDtlField">
<?php echo $x_nro_cds ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_nro_corre ?>
</td>
		<td class="ewRptDtlField">
<?php echo ew_FormatDateTime($x_FechaAlta,5) ?>
</td>
		<td class="ewRptDtlField">
<?php echo ew_FormatDateTime($x_FechaBaja,5) ?>
</td>
		<td class="ewRptDtlField">
<?php echo ew_FormatDateTime($x_FechaDestruc,5) ?>
</td>
		<td class="ewRptDtlField">
<?php echo str_replace(chr(10), "<br>", $x_Observ); ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();
	}

	// Accumulate grand summary
	AccumulateGrandSummary();

	// Save old group values
	$ox_codigo_usu = $x_codigo_usu;
	$ox_tipo_medio = $x_tipo_medio;
	$ox_tipo_dato = $x_tipo_dato;

	// Get next record
	GetRow(2);

	// Show Footers
	if (intval($nGrpCount) >= intval($nStartGrp) && $nGrpCount <= $nStopGrp) {
?>
<?php
	}

	// Increment group count
	if (ChkLvlBreak(1)) $nGrpCount++;
} // End while
?>
<?php if ($nTotalGrps > 0) { ?>
	<!-- tr><td colspan="9"><span class="phpreportmaker">&nbsp;<br></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="9">Total Registros (<?php echo ew_FormatNumber($cnt[0][0],0,-2,-2,-2); ?> Registros Detallados)</td></tr>
	<!--tr><td colspan="9"><span class="phpreportmaker">&nbsp;<br></span></td></tr-->
<?php } ?>
</table>
<!-- </form> -->
</div>
<!-- Summary Report Ends -->
<?php if (@$sExport == "") { ?>
	</div><br></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td valign="top"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
	</div><br></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php
php_close($conn);
?>
<?php include "rptinc/footer.php"; ?>
<?php

// Check level break
function ChkLvlBreak($lvl) {
	switch ($lvl) {
		case 1:
			return ($GLOBALS["x_codigo_usu"] == NULL && $GLOBALS["ox_codigo_usu"] != NULL) ||
				($GLOBALS["x_codigo_usu"] !== NULL && $GLOBALS["ox_codigo_usu"] == NULL) ||
				($GLOBALS["x_codigo_usu"] <> $GLOBALS["ox_codigo_usu"]);
		case 2:
			return ($GLOBALS["x_tipo_medio"] == NULL && $GLOBALS["ox_tipo_medio"] != NULL) ||
				($GLOBALS["x_tipo_medio"] !== NULL && $GLOBALS["ox_tipo_medio"] == NULL) ||
				($GLOBALS["x_tipo_medio"] <> $GLOBALS["ox_tipo_medio"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return ($GLOBALS["x_tipo_dato"] == NULL && $GLOBALS["ox_tipo_dato"] != NULL) ||
				($GLOBALS["x_tipo_dato"] !== NULL && $GLOBALS["ox_tipo_dato"] == NULL) ||
				($GLOBALS["x_tipo_dato"] <> $GLOBALS["ox_tipo_dato"]) || ChkLvlBreak(2); // Recurse upper level
	}
}

// Accummulate summary
function AccumulateSummary() {
	global $smry, $cnt, $col, $val, $mn, $mx;
	for ($ix = 0; $ix < count($smry); $ix++) {
		for ($iy = 1; $iy < count($smry[$ix]); $iy++) {
			$cnt[$ix][$iy]++;
			if ($col[$iy]) {
				$valwrk = $val[$iy];
				if ($valwrk == NULL || !is_numeric($valwrk)) {

					// skip
				} else {
					$smry[$ix][$iy] += $valwrk;
					if ($mn[$ix][$iy] == NULL) {
						$mn[$ix][$iy] = $valwrk;
						$mx[$ix][$iy] = $valwrk;
					} else {
						if ($mn[$ix][$iy] > $valwrk) $mn[$ix][$iy] = $valwrk;
						if ($mx[$ix][$iy] < $valwrk) $mx[$ix][$iy] = $valwrk;
					}
				}
			}
		}
	}
	for ($ix = 1; $ix < count($smry); $ix++) {
		$cnt[$ix][0]++;
	}
}

// Reset level summary
function ResetLevelSummary($lvl) {
	global $smry, $cnt, $col, $mn, $mx, $nRecCount, $grandsmry;

	// Clear summary values
	for ($ix = $lvl; $ix < count($smry); $ix++) {
		for ($iy = 1; $iy < count($smry[$ix]); $iy++) {
			$cnt[$ix][$iy] = 0;
			if ($col[$iy]) {
				$smry[$ix][$iy] = 0;
				$mn[$ix][$iy] = NULL;
				$mx[$ix][$iy] = NULL;
			}
		}
	}
	for ($ix = $lvl; $ix < count($smry); $ix++) {
		$cnt[$ix][0] = 0;
	}

	// Clear grand summary
	if ($lvl == 0) {
		for ($iy = 1; $iy < count($grandsmry[$iy]); $iy++) {
			if ($col[$iy]) {
				$grandsmry[$iy] = 0;
				$grandmn[$iy] = NULL;
				$grandmx[$iy] = NULL;
			}
		}
	}

	// Clear old values
	if ($lvl <= 1) $GLOBALS["ox_codigo_usu"] = "";
	if ($lvl <= 2) $GLOBALS["ox_tipo_medio"] = "";
	if ($lvl <= 3) $GLOBALS["ox_tipo_dato"] = "";

	// Reset record count
	$nRecCount = 0;
}

// Accummulate grand summary
function AccumulateGrandSummary() {
	global $cnt, $col, $val, $grandsmry, $grandmn, $grandmx;
	@$cnt[0][0]++;
	for ($iy = 1; $iy < count($grandsmry); $iy++) {
		if ($col[$iy]) {
			$valwrk = $val[$iy];
			if ($valwrk == NULL || !is_numeric($valwrk)) {

				// skip
			} else {
				$grandsmry[$iy] += $valwrk;
				if ($grandmn[$iy] == NULL) {
					$grandmn[$iy] = $valwrk;
					$grandmx[$iy] = $valwrk;
				} else {
					if ($grandmn[$iy] > $valwrk) $grandmn[$iy] = $valwrk;
					if ($grandmx[$iy] < $valwrk) $grandmx[$iy] = $valwrk;
				}
			}
		}
	}
}

// Get row values
function GetRow($opt) {
	global $rs, $rsidx, $row, $val;
	$rscnt = count($rs);
	if ($rscnt == 0) return;
	if ($opt == 1) { // Get first row
		$row = $rs[0];
	} else { // Get next row
		$rsidx++;
		$row = ($rsidx < $rscnt) ? $rs[$rsidx] : FALSE;
	}
	while ($row) {
		if (ValidRow($row)) {
			$GLOBALS["x_codigo_usu"] = $row["codigo_usu"];
			$GLOBALS["x_tipo_medio"] = $row["tipo_medio"];
			$GLOBALS["x_tipo_dato"] = $row["tipo_dato"];
			$GLOBALS["x_nro_cds"] = $row["nro_cds"];
			$val[1] = $GLOBALS["x_nro_cds"];
			$GLOBALS["x_nro_corre"] = $row["nro_corre"];
			$val[2] = $GLOBALS["x_nro_corre"];
			$GLOBALS["x_FechaAlta"] = $row["FechaAlta"];
			$val[3] = $GLOBALS["x_FechaAlta"];
			$GLOBALS["x_FechaBaja"] = $row["FechaBaja"];
			$val[4] = $GLOBALS["x_FechaBaja"];
			$GLOBALS["x_FechaDestruc"] = $row["FechaDestruc"];
			$val[5] = $GLOBALS["x_FechaDestruc"];
			$GLOBALS["x_Observ"] = $row["Observ"];
			$val[6] = $GLOBALS["x_Observ"];
			break;
		} else {
			$rsidx++;
			$row = ($rsidx < $rscnt) ? $rs[$rsidx] : FALSE;
		}
	}
	if (!$row) {
		$GLOBALS["x_codigo_usu"] = "";
		$GLOBALS["x_tipo_medio"] = "";
		$GLOBALS["x_tipo_dato"] = "";
		$GLOBALS["x_nro_cds"] = "";
		$GLOBALS["x_nro_corre"] = "";
		$GLOBALS["x_FechaAlta"] = "";
		$GLOBALS["x_FechaBaja"] = "";
		$GLOBALS["x_FechaDestruc"] = "";
		$GLOBALS["x_Observ"] = "";
	}
}

//-------------------------------------------------------------------------------
// Function SetUpStartGroup
// - Set up Starting Record parameters based on Pager Navigation
// - Variables setup: nStartGrp

function SetUpStartGroup() {
	global $PHP_SESSION, $PHP_GET;
	global $nStartGrp, $nTotalGrps, $nDisplayGrps;

	// Check for a START parameter
	if (@$PHP_GET[EW_TABLE_START_GROUP] != "") {
		$nStartGrp = $PHP_GET[EW_TABLE_START_GROUP];
		$PHP_SESSION[EW_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (@$PHP_GET["pageno"] != "") {
		$nPageNo = $PHP_GET["pageno"];
		if (is_numeric($nPageNo)) {
			$nStartGrp = ($nPageNo-1)*$nDisplayGrps+1;
			if ($nStartGrp <= 0) {
				$nStartGrp = 1;
			} elseif ($nStartGrp >= intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1) {
				$nStartGrp = intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1;
			}
			$PHP_SESSION[EW_TABLE_SESSION_START_GROUP] = $nStartGrp;
		} else {
			$nStartGrp = @$PHP_SESSION[EW_TABLE_SESSION_START_GROUP];
			if (!is_numeric($nStartGrp) || $nStartGrp == "") {
				$nStartGrp = 1; // Reset start record counter
				$PHP_SESSION[EW_TABLE_SESSION_START_GROUP] = $nStartGrp;
			}
		}
	} else {
		$nStartGrp = @$PHP_SESSION[EW_TABLE_SESSION_START_GROUP];
		if (!is_numeric($nStartGrp) || $nStartGrp == "") {
			$nStartGrp = 1; // Reset start record counter
			$PHP_SESSION[EW_TABLE_SESSION_START_GROUP] = $nStartGrp;
		}
	}
}

//-------------------------------------------------------------------------------
// Function ResetCmd
// - RESET: reset search parameters

function ResetCmd() {
	global $PHP_SESSION, $PHP_POST, $PHP_GET;

	// Skip if post back
	if (count($PHP_POST) > 0) return;

	// Get Reset Cmd
	if (@$PHP_GET["cmd"] != "") {
		$sCmd = $PHP_GET["cmd"];
		if (strtolower($sCmd) == "reset") {
			ResetPager();
		}
	}
}

// Reset pager
function ResetPager() {

	// Reset Start Position (Reset Command)
	global $PHP_SESSION, $nStartGrp;
	$nStartGrp = 1;
	$PHP_SESSION[EW_TABLE_SESSION_START_GROUP] = $nStartGrp;
}

// Set up selection
function SetupSelection() {
	global $PHP_SESSION, $PHP_POST, $PHP_GET;

	// Process post back form
	$sName = @$PHP_POST["popup"]; // Get popup form name
	$sName = (get_magic_quotes_gpc()) ? stripslashes($sName) : $sName;
	if ($sName <> "") {
		$arValues = @$PHP_POST["sel_" . $sName];
		if (is_array($arValues)) {
			if (get_magic_quotes_gpc()) array_walk($arValues, 'ew_StripSlashes');
			if (trim($arValues[0]) == "") { // Select all
				$PHP_SESSION["all_" . $sName] = TRUE;
				array_shift($arValues); // Remove first entry
			} else {
				$PHP_SESSION["all_" . $sName] = FALSE;
			}
			$PHP_SESSION["sel_" . $sName] = $arValues;
			$PHP_SESSION["rf_" . $sName] = (get_magic_quotes_gpc()) ? stripslashes(@$PHP_POST["from_" . $sName]) : @$PHP_POST["from_" . $sName];
			$PHP_SESSION["rt_" . $sName] = (get_magic_quotes_gpc()) ? stripslashes(@$PHP_POST["to_" . $sName]) : @$PHP_POST["to_" . $sName];
			ResetPager();
		}
	}

	// Load selection criteria to array
}

// Initialize group data - total number of groups + grouping field arrays
function InitReportData(&$rs) {
	global $conn, $nTotalGrps, $bFilterApplied;
	global $EW_TABLE_SQL_WHERE, $sFilter;

	// Initialize group count
	$grpcnt = 0;
	foreach ($rs as $row) {
		$bValidRow = ValidRow($row);
		if (!$bValidRow) $bFilterApplied = TRUE;

		// Update group count
		if ($bValidRow) {
			$x_codigo_usu = $row["codigo_usu"];
			$gx_codigo_usu = $x_codigo_usu;
			$bNewGroup = ($grpcnt == 0) ||
				($grpvalue == NULL && $x_codigo_usu != NULL) ||
				($grpvalue != NULL && $x_codigo_usu == NULL) ||
				(@$grpvalue <> $gx_codigo_usu);
			if ($bNewGroup) {
				$grpvalue = $gx_codigo_usu;
				$grpcnt++;
			}
		}
	}

	// Set up total number of groups
	$nTotalGrps = $grpcnt;
}

// Check if row is valid
function ValidRow($row) {
	$ValidRow = TRUE;
	return $ValidRow;
}
?>
<?php

//-------------------------------------------------------------------------------
// Function SetUpDisplayGrps
// - Set up Number of Groups displayed per page based on Form element GrpPerPage
// - Variables setup: nDisplayGrps

function SetUpDisplayGrps() {
	global $PHP_GET;
	global $PHP_SESSION;
	global $nDisplayGrps;
	global $nStartGrp;
	$sWrk = @$PHP_GET[EW_TABLE_GROUP_PER_PAGE];
	if ($sWrk <> "") {
		if (is_numeric($sWrk)) {
			$nDisplayGrps = intval($sWrk);
		} else {
			if (strtoupper($sWrk) == "ALL") { // Display All Records
				$nDisplayGrps = -1;
			} else {
				$nDisplayGrps = 3; // Non-numeric, Load Default
			}
		}
		$PHP_SESSION[EW_TABLE_SESSION_GROUP_PER_PAGE] = $nDisplayGrps; // Save to Session

		// Reset Start Position (Reset Command)
		$nStartGrp = 1;
		$PHP_SESSION[EW_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} else {
		if (@$PHP_SESSION[EW_TABLE_SESSION_GROUP_PER_PAGE] <> "") {
			$nDisplayGrps = $PHP_SESSION[EW_TABLE_SESSION_GROUP_PER_PAGE]; // Restore from Session
		} else {
			$nDisplayGrps = 3; // Load Default
		}
	}
}
?>
