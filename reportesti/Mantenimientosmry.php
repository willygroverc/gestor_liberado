<?php include "rptinc/ewcommon.php"; ?>
<?php include "rptinc/ewconfig.php"; ?>
<?php include "rptinc/phprptfn.php"; ?>
<?php include "rptinc/advsecu.php"; ?>
<?php

// PHP Report Maker 1.0 - Table level configuration (Mantenimiento)
// Table Level Constants

define("EW_TABLE_VAR", "Mantenimiento", TRUE);
define("EW_TABLE_GROUP_PER_PAGE", "grpperpage", TRUE);
define("EW_TABLE_SESSION_GROUP_PER_PAGE", "Mantenimiento_grpperpage", TRUE);
define("EW_TABLE_START_GROUP", "start", TRUE);
define("EW_TABLE_SESSION_START_GROUP", "Mantenimiento_start", TRUE);
define("EW_TABLE_SESSION_SEARCH", "Mantenimiento_search", TRUE);
define("EW_TABLE_CHILD_USER_ID", "childuserid", TRUE);
define("EW_TABLE_SESSION_CHILD_USER_ID", "Mantenimiento_childuserid", TRUE);

// Table Level SQL
define("EW_TABLE_SQL_FROM", "pcontrol LEFT OUTER JOIN datfichatec ON (pcontrol.AdicUSI = datfichatec.AdicUSI) LEFT OUTER JOIN asigcustficha ON (datfichatec.IdFicha = asigcustficha.IdFicha)", TRUE);
$EW_TABLE_SQL_SELECT = "SELECT count(*) AS total, pcontrol.id_regPC, pcontrol.CodActFijo, asigcustficha.NombAsig, pcontrol.des_disp, pcontrol.NombProv, pcontrol.Observ, pcontrol.tipo_mant FROM " . EW_TABLE_SQL_FROM;
$EW_TABLE_SQL_WHERE = "";
define("EW_TABLE_SQL_GROUPBY", "pcontrol.id_regPC, pcontrol.CodActFijo, asigcustficha.NombAsig, pcontrol.des_disp, pcontrol.NombProv, pcontrol.Observ, pcontrol.tipo_mant", TRUE);
define("EW_TABLE_SQL_HAVING", "", TRUE);
define("EW_TABLE_SQL_ORDERBY", "pcontrol.tipo_mant ASC", TRUE);
define("EW_TABLE_SQL_USERID_FILTER", "", TRUE);
$af_id_regPC = NULL; // Advanced filter for id_regPC
$af_CodActFijo = NULL; // Advanced filter for CodActFijo
$af_NombAsig = NULL; // Advanced filter for NombAsig
$af_des_disp = NULL; // Advanced filter for des_disp
$af_NombProv = NULL; // Advanced filter for NombProv
$af_Observ = NULL; // Advanced filter for Observ
$af_tipo_mant = NULL; // Advanced filter for tipo_mant
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
$x_tipo_mant = NULL; $ox_tipo_mant = NULL; $gx_tipo_mant = NULL; $dgx_tipo_mant = NULL; $tx_tipo_mant = NULL; $ftx_tipo_mant = 200; $gfx_tipo_mant = $ftx_tipo_mant; $gbx_tipo_mant = ""; $gix_tipo_mant = "0"; $rf_tipo_mant = NULL; $rt_tipo_mant = NULL;

// Detail variables
$x_id_regPC = NULL; $ox_id_regPC = NULL; $tx_id_regPC = NULL; $ftx_id_regPC = 3; $rf_id_regPC = NULL; $rt_id_regPC = NULL;
$x_CodActFijo = NULL; $ox_CodActFijo = NULL; $tx_CodActFijo = NULL; $ftx_CodActFijo = 200; $rf_CodActFijo = NULL; $rt_CodActFijo = NULL;
$x_NombAsig = NULL; $ox_NombAsig = NULL; $tx_NombAsig = NULL; $ftx_NombAsig = 200; $rf_NombAsig = NULL; $rt_NombAsig = NULL;
$x_des_disp = NULL; $ox_des_disp = NULL; $tx_des_disp = NULL; $ftx_des_disp = 200; $rf_des_disp = NULL; $rt_des_disp = NULL;
$x_NombProv = NULL; $ox_NombProv = NULL; $tx_NombProv = NULL; $ftx_NombProv = 200; $rf_NombProv = NULL; $rt_NombProv = NULL;
$x_Observ = NULL; $ox_Observ = NULL; $tx_Observ = NULL; $ftx_Observ = 201; $rf_Observ = NULL; $rt_Observ = NULL;
?>
<?php

// Chart configuration parameters
$Mantenimiento_cht_parms = NULL; // Store all chart parameters

// Chart data
$Mantenimiento_cht_index = NULL;
$Mantenimiento_cht_id = NULL;
$Mantenimiento_cht_smry = NULL;
$Mantenimiento_cht_XFld = NULL;
$Mantenimiento_cht_YFld = NULL;
$Mantenimiento_cht_YFldBase = NULL;
$Mantenimiento_cht_XFld = "tipo_mant";
$Mantenimiento_cht_YFld = "total";
$Mantenimiento_cht_XDateFld = "";
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
$nGrps = 2;
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
Mantenimiento
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="Mantenimientosmry.php?export=html">Imprimir</a>
&nbsp;&nbsp;<a href="Mantenimientosmry.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="Mantenimientosmry.php?export=word">Exportar a Word</a>
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
<form action="Mantenimientosmry.php" name="ewpagerform" id="ewpagerform">
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
	<td><a href="Mantenimientosmry.php?start=1"><img src="rptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($PrevStart == $nStartGrp) { ?>
	<td><img src="rptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Mantenimientosmry.php?start=<?php echo $PrevStart; ?>"><img src="rptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" value="<?php echo intval(($nStartGrp-1)/$nDisplayGrps+1); ?>" size="4"></td>
<!--next page button-->
	<?php if ($NextStart == $nStartGrp) { ?>
	<td><img src="rptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Mantenimientosmry.php?start=<?php echo $NextStart; ?>"><img src="rptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>
	<?php  } ?>
<!--last page button-->
	<?php if ($LastStart == $nStartGrp) { ?>
	<td><img src="rptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Mantenimientosmry.php?start=<?php echo $LastStart; ?>"><img src="rptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>
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
	if ($bShowFirstHeader || (intval($nGrpCount) >= intval($nStartGrp) && $nGrpCount <= $nStopGrp && ChkLvlBreak(1))) {
?>
	<tr>
		<td valign="bottom" class="ewRptGrpHeader1">
		<?php if ($bShowFirstHeader || ChkLvlBreak(1)) { ?>
		Tipo de Mantenimiento
		<?php } ?>
		</td>
		<td valign="bottom" class="ewTableHeader">
		Id
		</td>
		<td valign="bottom" class="ewTableHeader">
		Cod Act Fijo
		</td>
		<td valign="bottom" class="ewTableHeader">
		Asignado a
		</td>
		<td valign="bottom" class="ewTableHeader">
		Descripcion
		</td>
		<td valign="bottom" class="ewTableHeader">
		Empresa
		</td>
		<td valign="bottom" class="ewTableHeader">
		Observaciones
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
		$dgx_tipo_mant = $x_tipo_mant;
		if (($x_tipo_mant == NULL && $ox_tipo_mant == NULL) ||
			(($x_tipo_mant <> "" && $ox_tipo_mant == $dgx_tipo_mant) && !ChkLvlBreak(1))) {
			$dgx_tipo_mant = "";
		} elseif ($x_tipo_mant == NULL) {
			$dgx_tipo_mant = EW_NULL_LABEL;
		} elseif ($x_tipo_mant == "") {
			$dgx_tipo_mant = EW_EMPTY_LABEL;
		}
?>
	<tr<?php echo $sItemRowClass; ?>>
		<td class="ewRptGrpField1">
		<?php $tx_tipo_mant = $x_tipo_mant; $x_tipo_mant = $dgx_tipo_mant; ?>
<?php echo $x_tipo_mant ?>
		<?php $x_tipo_mant = $tx_tipo_mant; ?></td>
		<td class="ewRptDtlField">
<?php echo $x_id_regPC ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_CodActFijo ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_NombAsig ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_des_disp ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_NombProv ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_Observ ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();
	}

	// Accumulate grand summary
	AccumulateGrandSummary();

	// Save old group values
	$ox_tipo_mant = $x_tipo_mant;

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
	<!-- tr><td colspan="7"><span class="phpreportmaker">&nbsp;<br></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="7">Total Registros (<?php echo ew_FormatNumber($cnt[0][0],0,-2,-2,-2); ?> Registros Detallados)</td></tr>
	<!--tr><td colspan="7"><span class="phpreportmaker">&nbsp;<br></span></td></tr-->
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
<tr><td colspan="3" class="ewPadding"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
<a name="cht_Mantenimiento"></a>
<div id="div_Mantenimiento">
<?php

// Initialize chart data
$Mantenimiento_cht_id = "Mantenimiento_Mantenimiento"; // Chart ID
$Mantenimiento_cht_parms .= "type=1,"; // Chart type
$Mantenimiento_cht_parms .= "bgcolor=#FCFCFC,"; // Background color
$Mantenimiento_cht_parms .= "caption=" . ew_Encode("Mantenimiento") . ","; // Chart caption
$Mantenimiento_cht_parms .= "borderleftcolor=#808080,"; // Border left color
$Mantenimiento_cht_parms .= "bordertopcolor=#808080,"; // Border top color
$Mantenimiento_cht_parms .= "borderbottomcolor=#808080,"; // Border bottom color
$Mantenimiento_cht_parms .= "borderrightcolor=#808080,"; // Border right color
$Mantenimiento_cht_parms .= "chartbgcolor=#EEEEEE,"; // Chart background color
$Mantenimiento_cht_parms .= "chartbordercolor=#A9A9A9,"; // Chart border color
$Mantenimiento_cht_parms .= "numgridlines=3,"; // Number of grid lines
$Mantenimiento_cht_parms .= "gridlinecolor=#DCDCDC,"; // Grid line color
$Mantenimiento_cht_parms .= "xaxisname=" . ew_Encode("Tipo de Mantenimiento") . ","; // X axis name
$Mantenimiento_cht_parms .= "xaxisnamerotated=0,"; // X axis name rotated
$Mantenimiento_cht_parms .= "xaxisvaluemaxchar=20,"; // X axis value max char
$Mantenimiento_cht_parms .= "yaxisname=" . ew_Encode("Total") . ","; // Y axis name
$Mantenimiento_cht_parms .= "yaxisnamerotated=1,"; // Y axis name rotated
$Mantenimiento_cht_parms .= "shownames=1,"; // Show names
$Mantenimiento_cht_parms .= "showvalues=1,"; // Show values
$Mantenimiento_cht_parms .= "showhover=1,"; // Show hover
$Mantenimiento_cht_parms .= "alpha=50,"; // Chart alpha
$Mantenimiento_cht_parms .= "colorpalette=#FF0000|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF,"; // Chart color palette
$Mantenimiento_cht_parms .= "cssurl=rptcss/ewchart.css"; // Chart css
ew_SortChartData($Mantenimiento_cht_smry, 0);
echo ew_ShowChart($Mantenimiento_cht_id, $Mantenimiento_cht_parms, $Mantenimiento_cht_smry, 550, 440, "");
?>
</div>
<a href="#top">Top</a>
<br><br>
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
			return ($GLOBALS["x_tipo_mant"] == NULL && $GLOBALS["ox_tipo_mant"] != NULL) ||
				($GLOBALS["x_tipo_mant"] !== NULL && $GLOBALS["ox_tipo_mant"] == NULL) ||
				($GLOBALS["x_tipo_mant"] <> $GLOBALS["ox_tipo_mant"]);
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
	if ($lvl <= 1) $GLOBALS["ox_tipo_mant"] = "";

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
			$GLOBALS["x_tipo_mant"] = $row["tipo_mant"];
			$GLOBALS["x_id_regPC"] = $row["id_regPC"];
			$val[1] = $GLOBALS["x_id_regPC"];
			$GLOBALS["x_CodActFijo"] = $row["CodActFijo"];
			$val[2] = $GLOBALS["x_CodActFijo"];
			$GLOBALS["x_NombAsig"] = $row["NombAsig"];
			$val[3] = $GLOBALS["x_NombAsig"];
			$GLOBALS["x_des_disp"] = $row["des_disp"];
			$val[4] = $GLOBALS["x_des_disp"];
			$GLOBALS["x_NombProv"] = $row["NombProv"];
			$val[5] = $GLOBALS["x_NombProv"];
			$GLOBALS["x_Observ"] = $row["Observ"];
			$val[6] = $GLOBALS["x_Observ"];
			break;
		} else {
			$rsidx++;
			$row = ($rsidx < $rscnt) ? $rs[$rsidx] : FALSE;
		}
	}
	if (!$row) {
		$GLOBALS["x_tipo_mant"] = "";
		$GLOBALS["x_id_regPC"] = "";
		$GLOBALS["x_CodActFijo"] = "";
		$GLOBALS["x_NombAsig"] = "";
		$GLOBALS["x_des_disp"] = "";
		$GLOBALS["x_NombProv"] = "";
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
			$x_tipo_mant = $row["tipo_mant"];
			$gx_tipo_mant = $x_tipo_mant;
			$bNewGroup = ($grpcnt == 0) ||
				($grpvalue == NULL && $x_tipo_mant != NULL) ||
				($grpvalue != NULL && $x_tipo_mant == NULL) ||
				(@$grpvalue <> $gx_tipo_mant);
			if ($bNewGroup) {
				$grpvalue = $gx_tipo_mant;
				$grpcnt++;
			}
		}

		// Update chart values
		if ($bValidRow) ProcessChartData($row);
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

// Process chart data
function ProcessChartData(&$rs) {
	AccumulateChartSummary($rs, $GLOBALS["Mantenimiento_cht_smry"], $GLOBALS["Mantenimiento_cht_XFld"], "", $GLOBALS["Mantenimiento_cht_YFld"], 0, "", "SUM");
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
<?php

// Accummulate chart summary
function AccumulateChartSummary(&$rs, &$cht_smry, $xfld, $xdatefld, $yfld, $ybase, $col, $smrytype) {
	if (!is_array($cht_smry)) {
		AddChartEntry($rs, $cht_smry, $xfld, $xdatefld, $yfld, $ybase, $col, $smrytype);
	} else {
		if (!UpdateChartEntry($rs, $cht_smry, $xfld, $xdatefld, $yfld, $ybase, $col, $smrytype)) {
			AddChartEntry($rs, $cht_smry, $xfld, $xdatefld, $yfld, $ybase, $col, $smrytype);
		}
	}
}

// Add chart entry
function AddChartEntry(&$rs, &$cht_smry, $xfld, $xdatefld, $yfld, $ybase, $col, $smrytype) {
	switch ($smrytype) {
		case "SUM":
		case "COUNT":
			$initval = 0;
			break;
		case "MIN":
		case "MAX":
			$initval = NULL;
			break;
	}
	if (is_array($xfld)) { // X = crosstab column field
		if ($ybase > 0) {
			$ny = count($xfld) - 2;
			if ($xdatefld <> "") { // column field with date type q/m
				for ($i = $nbase; $i <= $ny; $i++) {
					$temp = array();
					$temp[0] = $rs[$xdatefld]; // x value = date field
					$temp[1] = $xfld[$i - $nbase + 1][0]; // date q/m value
					$valwrk = $rs[$ybase + $i];
					$temp[2] = $initval; // initialize Y
					if ($valwrk != NULL) $valwrk = (float)$valwrk;
					if ($xfld[$i + 1][2]) // column selected
						$temp[2] = ew_SummaryValue($temp[2], $valwrk, $smrytype); // accumulate Y
					$cht_smry[] = $temp;
				}
			} else { // column field without date type
				for ($i = 0; $i <= $ny; $i++) {
					$temp = array();
					$temp[0] = $xfld[$i + 1][0]; // x value
					$temp[1] = NULL;
					$temp[2] = $initval; // initialize Y
					$valwrk = $rs[$ybase + $i];
					if ($valwrk != NULL) $valwrk = (float)$valwrk;
					if ($xfld[$i + 1][2]) // column selected
						$temp[2] = ew_SummaryValue($temp[2], $valwrk, $smrytype); // accumulate Y
					$cht_smry[] = $temp;
				}
			}
		}
	} else {
		$temp = array();
		$temp[0] = $rs[$xfld]; // X value
		$temp[1] = NULL;
		$temp[2] = $initval; // initialize Y
		if ($ybase > 0 && is_array($col)) { // X = crosstab row field
			$ylen = count($col) - 1;
			if ($ylen > 0) {
				$temp[2] = 0;
				for ($i = 0; $i < $ylen; $i++) {
					if ($col[$i+1][2]) {
						$valwrk = $rs[$ybase + $i];
						if ($valwrk != NULL) $valwrk = (float)$valwrk;
						$temp[2] = ew_SummaryValue($temp[2], $valwrk, $smrytype); // accumulate Y
					}
				}
			}
		} elseif ($yfld <> "") { // List/Summary report
			$valwrk = $rs[$yfld];
			if ($valwrk != NULL) $valwrk = (float)$valwrk;
			$temp[2] = ew_SummaryValue($temp[2], $valwrk, $smrytype); // accumulate Y
		}
		$cht_smry[] = $temp;
	}
}

// Update Chart entry
function UpdateChartEntry(&$rs, &$cht_smry, $xfld, $xdatefld, $yfld, $ybase, $col, $smrytype) {
	if (is_array($xfld)) { // X = crosstab column field
		if ($ybase > 0) {
			$ny = count($xfld) - 1;
			if ($xdatefld <> "") { // Column field with date type q/m
				for ($i = 0; $i < count($cht_smry) - 2; $i += $ny) {
					if (trim($cht_smry[$i][0]) == trim($rs[$xdatefld])) {
						for ($j = $i; $j < $i+$ny; $j++) {
							if ($xfld[$j-$i+1][2]) { // column selected
								$valwrk = $rs[$ybase+$j-$i];
								if ($valwrk != NULL) $valwrk = (float)$valwrk;
								$cht_smry[$j][2] = ew_SummaryValue($cht_smry[$j][2], $valwrk, $smrytype); // accumulate Y
							}
						}
						return TRUE;
					}
				}
			} else {
				for ($i = 0; $i < $ny; $i++) {
					if ($xfld[$i+1][2]) { //column selected
						$valwrk = $rs[$ybase + $i];
						if ($valwrk != NULL) $valwrk = (float)$valwrk;
						$cht_smry[$i][2] = ew_SummaryValue($cht_smry[$i][2], $valwrk, $smrytype); // accumulate Y
					}
				}
				return TRUE;
			}
		}
	} else {
		for ($ny = 0; $ny < count($cht_smry); $ny++) {
			if (trim($cht_smry[$ny][0]) == trim($rs[$xfld])) {
				if ($ybase > 0 && is_array($col)) { // X = crosstab row field
					$ylen = count($col) - 1;
					if ($ylen > 0) {
						for ($i = 0; $i < $ylen; $i++) {
							if ($col[$i+1][2]) {
								$valwrk = $rs[$ybase+$i];
								if ($valwrk != NULL) $valwrk = (float)$valwrk;
								$cht_smry[$ny][2] = ew_SummaryValue($cht_smry[$ny][2], $valwrk, $smrytype); // accumulate Y
							}
						}
						return TRUE;
					}
				} else { // List/Summary report
					$valwrk = $rs[$yfld];
					if ($valwrk != NULL) $valwrk = (float)$valwrk;
					$cht_smry[$ny][2] = ew_SummaryValue($cht_smry[$ny][2], $valwrk, $smrytype); // accumulate Y
					return TRUE;
				}
			}
		}
	}
	return FALSE;
}
?>
