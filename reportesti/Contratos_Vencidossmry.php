<?php include "rptinc/ewcommon.php"; ?>
<?php include "rptinc/ewconfig.php"; ?>
<?php include "rptinc/phprptfn.php"; ?>
<?php include "rptinc/advsecu.php"; ?>
<?php

// PHP Report Maker 1.0 - Table level configuration (Contratos Vencidos)
// Table Level Constants

define("EW_TABLE_VAR", "Contratos_Vencidos", TRUE);
define("EW_TABLE_GROUP_PER_PAGE", "grpperpage", TRUE);
define("EW_TABLE_SESSION_GROUP_PER_PAGE", "Contratos_Vencidos_grpperpage", TRUE);
define("EW_TABLE_START_GROUP", "start", TRUE);
define("EW_TABLE_SESSION_START_GROUP", "Contratos_Vencidos_start", TRUE);
define("EW_TABLE_SESSION_SEARCH", "Contratos_Vencidos_search", TRUE);
define("EW_TABLE_CHILD_USER_ID", "childuserid", TRUE);
define("EW_TABLE_SESSION_CHILD_USER_ID", "Contratos_Vencidos_childuserid", TRUE);

// Table Level SQL
define("EW_TABLE_SQL_FROM", "contratodatos", TRUE);
$EW_TABLE_SQL_SELECT = "SELECT count(*) AS total, count(contratodatos.TipoContra) / count(contratodatos.TipoContra) AS aux, contratodatos.TipoContra, contratodatos.CodLegalContra, contratodatos.EmpContra, contratodatos.PartCont, contratodatos.FechDe, contratodatos.FechAl, contratodatos.IdContra FROM " . EW_TABLE_SQL_FROM;
$EW_TABLE_SQL_WHERE = "(contratodatos.FechAl < NOW())";
define("EW_TABLE_SQL_GROUPBY", "contratodatos.TipoContra, contratodatos.CodLegalContra, contratodatos.EmpContra, contratodatos.PartCont, contratodatos.FechDe, contratodatos.FechAl, contratodatos.IdContra", TRUE);
define("EW_TABLE_SQL_HAVING", "", TRUE);
define("EW_TABLE_SQL_ORDERBY", "", TRUE);
define("EW_TABLE_SQL_USERID_FILTER", "", TRUE);
$af_IdContra = NULL; // Advanced filter for IdContra
$af_TipoContra = NULL; // Advanced filter for TipoContra
$af_CodLegalContra = NULL; // Advanced filter for CodLegalContra
$af_EmpContra = NULL; // Advanced filter for EmpContra
$af_FechDe = NULL; // Advanced filter for FechDe
$af_FechAl = NULL; // Advanced filter for FechAl
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

// Detail variables
$x_IdContra = NULL; $ox_IdContra = NULL; $tx_IdContra = NULL; $ftx_IdContra = 3; $rf_IdContra = NULL; $rt_IdContra = NULL;
$x_TipoContra = NULL; $ox_TipoContra = NULL; $tx_TipoContra = NULL; $ftx_TipoContra = 200; $rf_TipoContra = NULL; $rt_TipoContra = NULL;
$x_CodLegalContra = NULL; $ox_CodLegalContra = NULL; $tx_CodLegalContra = NULL; $ftx_CodLegalContra = 200; $rf_CodLegalContra = NULL; $rt_CodLegalContra = NULL;
$x_EmpContra = NULL; $ox_EmpContra = NULL; $tx_EmpContra = NULL; $ftx_EmpContra = 200; $rf_EmpContra = NULL; $rt_EmpContra = NULL;
$x_FechDe = NULL; $ox_FechDe = NULL; $tx_FechDe = NULL; $ftx_FechDe = 133; $rf_FechDe = NULL; $rt_FechDe = NULL;
$x_FechAl = NULL; $ox_FechAl = NULL; $tx_FechAl = NULL; $ftx_FechAl = 133; $rf_FechAl = NULL; $rt_FechAl = NULL;
?>
<?php

// Chart configuration parameters
$Contratos_Vencidos_cht_parms = NULL; // Store all chart parameters

// Chart data
$Contratos_Vencidos_cht_index = NULL;
$Contratos_Vencidos_cht_id = NULL;
$Contratos_Vencidos_cht_smry = NULL;
$Contratos_Vencidos_cht_XFld = NULL;
$Contratos_Vencidos_cht_YFld = NULL;
$Contratos_Vencidos_cht_YFldBase = NULL;
$Contratos_Vencidos_cht_XFld = "aux";
$Contratos_Vencidos_cht_YFld = "total";
$Contratos_Vencidos_cht_XDateFld = "";
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
$nGrps = 1;
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
Contratos Vencidos
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="Contratos_Vencidossmry.php?export=html">Imprimir</a>
&nbsp;&nbsp;<a href="Contratos_Vencidossmry.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="Contratos_Vencidossmry.php?export=word">Exportar a Word</a>
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
<form action="Contratos_Vencidossmry.php" name="ewpagerform" id="ewpagerform">
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
	<td><a href="Contratos_Vencidossmry.php?start=1"><img src="rptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($PrevStart == $nStartGrp) { ?>
	<td><img src="rptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Contratos_Vencidossmry.php?start=<?php echo $PrevStart; ?>"><img src="rptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" value="<?php echo intval(($nStartGrp-1)/$nDisplayGrps+1); ?>" size="4"></td>
<!--next page button-->
	<?php if ($NextStart == $nStartGrp) { ?>
	<td><img src="rptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Contratos_Vencidossmry.php?start=<?php echo $NextStart; ?>"><img src="rptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>
	<?php  } ?>
<!--last page button-->
	<?php if ($LastStart == $nStartGrp) { ?>
	<td><img src="rptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Contratos_Vencidossmry.php?start=<?php echo $LastStart; ?>"><img src="rptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>
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
$bShowFirstHeader = TRUE;
while ($row || $bShowFirstHeader) {

	// Show Header
	if ($bShowFirstHeader) {
?>
	<tr>
		<td valign="bottom" class="ewTableHeader">
		Id Contra
		</td>
		<td valign="bottom" class="ewTableHeader">
		Tipo de Contrato
		</td>
		<td valign="bottom" class="ewTableHeader">
		Cod. Legal de Contrato
		</td>
		<td valign="bottom" class="ewTableHeader">
		Empresa Contratada
		</td>
		<td valign="bottom" class="ewTableHeader">
		Fecha Inicio
		</td>
		<td valign="bottom" class="ewTableHeader">
		Fecha Fin
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
?>
	<tr<?php echo $sItemRowClass; ?>>
		<td class="ewRptDtlField">
<?php echo $x_IdContra ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_TipoContra ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_CodLegalContra ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_EmpContra ?>
</td>
		<td class="ewRptDtlField">
<?php echo ew_FormatDateTime($x_FechDe,5) ?>
</td>
		<td class="ewRptDtlField">
<?php echo ew_FormatDateTime($x_FechAl,5) ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();
	}

	// Accumulate grand summary
	AccumulateGrandSummary();

	// Get next record
	GetRow(2);
	$nGrpCount++;
} // End while
?>
<?php if ($nTotalGrps > 0) { ?>
	<!-- tr><td colspan="6"><span class="phpreportmaker">&nbsp;<br></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="6">Total Registros (<?php echo ew_FormatNumber($cnt[0][0],0,-2,-2,-2); ?> Registros Detallados)</td></tr>
	<!--tr><td colspan="6"><span class="phpreportmaker">&nbsp;<br></span></td></tr-->
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
<a name="cht_Contratos_Vencidos"></a>
<div id="div_Contratos_Vencidos">
<?php

// Initialize chart data
$Contratos_Vencidos_cht_id = "Contratos_Vencidos_Contratos_Vencidos"; // Chart ID
$Contratos_Vencidos_cht_parms .= "type=1,"; // Chart type
$Contratos_Vencidos_cht_parms .= "bgcolor=#FCFCFC,"; // Background color
$Contratos_Vencidos_cht_parms .= "caption=" . ew_Encode("Contratos Vencidos") . ","; // Chart caption
$Contratos_Vencidos_cht_parms .= "borderleftcolor=#808080,"; // Border left color
$Contratos_Vencidos_cht_parms .= "bordertopcolor=#808080,"; // Border top color
$Contratos_Vencidos_cht_parms .= "borderbottomcolor=#808080,"; // Border bottom color
$Contratos_Vencidos_cht_parms .= "borderrightcolor=#808080,"; // Border right color
$Contratos_Vencidos_cht_parms .= "chartbgcolor=#EEEEEE,"; // Chart background color
$Contratos_Vencidos_cht_parms .= "chartbordercolor=#A9A9A9,"; // Chart border color
$Contratos_Vencidos_cht_parms .= "numgridlines=3,"; // Number of grid lines
$Contratos_Vencidos_cht_parms .= "gridlinecolor=#DCDCDC,"; // Grid line color
$Contratos_Vencidos_cht_parms .= "xaxisname=" . ew_Encode("Contratos Vencidos") . ","; // X axis name
$Contratos_Vencidos_cht_parms .= "xaxisnamerotated=0,"; // X axis name rotated
$Contratos_Vencidos_cht_parms .= "xaxisvaluemaxchar=20,"; // X axis value max char
$Contratos_Vencidos_cht_parms .= "yaxisname=" . ew_Encode("Total") . ","; // Y axis name
$Contratos_Vencidos_cht_parms .= "yaxisnamerotated=1,"; // Y axis name rotated
$Contratos_Vencidos_cht_parms .= "shownames=0,"; // Show names
$Contratos_Vencidos_cht_parms .= "showvalues=1,"; // Show values
$Contratos_Vencidos_cht_parms .= "showhover=1,"; // Show hover
$Contratos_Vencidos_cht_parms .= "alpha=50,"; // Chart alpha
$Contratos_Vencidos_cht_parms .= "colorpalette=#FF0000|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF,"; // Chart color palette
$Contratos_Vencidos_cht_parms .= "cssurl=rptcss/ewchart.css"; // Chart css
ew_SortChartData($Contratos_Vencidos_cht_smry, 0);
echo ew_ShowChart($Contratos_Vencidos_cht_id, $Contratos_Vencidos_cht_parms, $Contratos_Vencidos_cht_smry, 550, 440, "");
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
			$GLOBALS["x_IdContra"] = $row["IdContra"];
			$val[1] = $GLOBALS["x_IdContra"];
			$GLOBALS["x_TipoContra"] = $row["TipoContra"];
			$val[2] = $GLOBALS["x_TipoContra"];
			$GLOBALS["x_CodLegalContra"] = $row["CodLegalContra"];
			$val[3] = $GLOBALS["x_CodLegalContra"];
			$GLOBALS["x_EmpContra"] = $row["EmpContra"];
			$val[4] = $GLOBALS["x_EmpContra"];
			$GLOBALS["x_FechDe"] = $row["FechDe"];
			$val[5] = $GLOBALS["x_FechDe"];
			$GLOBALS["x_FechAl"] = $row["FechAl"];
			$val[6] = $GLOBALS["x_FechAl"];
			break;
		} else {
			$rsidx++;
			$row = ($rsidx < $rscnt) ? $rs[$rsidx] : FALSE;
		}
	}
	if (!$row) {
		$GLOBALS["x_IdContra"] = "";
		$GLOBALS["x_TipoContra"] = "";
		$GLOBALS["x_CodLegalContra"] = "";
		$GLOBALS["x_EmpContra"] = "";
		$GLOBALS["x_FechDe"] = "";
		$GLOBALS["x_FechAl"] = "";
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
		if ($bValidRow) $grpcnt++;

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
	AccumulateChartSummary($rs, $GLOBALS["Contratos_Vencidos_cht_smry"], $GLOBALS["Contratos_Vencidos_cht_XFld"], "", $GLOBALS["Contratos_Vencidos_cht_YFld"], 0, "", "SUM");
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
