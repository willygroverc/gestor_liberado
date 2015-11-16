<?php include "rptinc/ewcommon.php"; ?>
<?php include "rptinc/ewconfig.php"; ?>
<?php include "rptinc/phprptfn.php"; ?>
<?php include "rptinc/advsecu.php"; ?>
<?php

// PHP Report Maker 1.0 - Table level configuration (Por Asignaado)
// Table Level Constants

define("EW_TABLE_VAR", "Por_Asignaado", TRUE);
define("EW_TABLE_GROUP_PER_PAGE", "grpperpage", TRUE);
define("EW_TABLE_SESSION_GROUP_PER_PAGE", "Por_Asignaado_grpperpage", TRUE);
define("EW_TABLE_START_GROUP", "start", TRUE);
define("EW_TABLE_SESSION_START_GROUP", "Por_Asignaado_start", TRUE);
define("EW_TABLE_SESSION_SEARCH", "Por_Asignaado_search", TRUE);
define("EW_TABLE_CHILD_USER_ID", "childuserid", TRUE);
define("EW_TABLE_SESSION_CHILD_USER_ID", "Por_Asignaado_childuserid", TRUE);

// Table Level SQL
define("EW_TABLE_SQL_FROM", "asignacion LEFT OUTER JOIN ordenes ON (asignacion.id_orden = ordenes.id_orden) LEFT OUTER JOIN solucion ON (asignacion.id_orden = solucion.id_orden)", TRUE);
$EW_TABLE_SQL_SELECT = "SELECT count(*) AS total, count(to_days(solucion.fecha_sol) - to_days(asignacion.fecha_asig)) AS fila, to_days(solucion.fecha_sol) - to_days(asignacion.fecha_asig) AS aux, Sum(to_days(solucion.fecha_sol) - to_days(asignacion.fecha_asig)) as Suma1, AVG(to_days(solucion.fecha_sol) - to_days(asignacion.fecha_asig)) AS promedio, ordenes.fecha, ordenes.`time`, asignacion.asig, asignacion.fecha_asig, asignacion.hora_asig, solucion.detalles_sol, solucion.fecha_sol, solucion.hora_sol FROM " . EW_TABLE_SQL_FROM;
$EW_TABLE_SQL_WHERE = "";
define("EW_TABLE_SQL_GROUPBY", "to_days(solucion.fecha_sol) - to_days(asignacion.fecha_asig), ordenes.fecha, ordenes.`time`, asignacion.asig, asignacion.fecha_asig, asignacion.hora_asig, solucion.detalles_sol, solucion.fecha_sol, solucion.hora_sol", TRUE);
define("EW_TABLE_SQL_HAVING", "", TRUE);
define("EW_TABLE_SQL_ORDERBY", "asignacion.asig ASC", TRUE);
define("EW_TABLE_SQL_USERID_FILTER", "", TRUE);
$af_fecha = NULL; // Advanced filter for fecha
$af_time = NULL; // Advanced filter for time
$af_asig = NULL; // Advanced filter for asig
$af_fecha_asig = NULL; // Advanced filter for fecha_asig
$af_hora_asig = NULL; // Advanced filter for hora_asig
$af_detalles_sol = NULL; // Advanced filter for detalles_sol
$af_fecha_sol = NULL; // Advanced filter for fecha_sol
$af_hora_sol = NULL; // Advanced filter for hora_sol
$af_aux = NULL; // Advanced filter for aux
$af_total = NULL; // Advanced filter for total
$af_promedio = NULL; // Advanced filter for promedio
$af_fila = NULL; // Advanced filter for fila
$af_Suma1 = NULL; // Advanced filter for Suma1
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
$x_asig = NULL; $ox_asig = NULL; $gx_asig = NULL; $dgx_asig = NULL; $tx_asig = NULL; $ftx_asig = 201; $gfx_asig = $ftx_asig; $gbx_asig = ""; $gix_asig = "0"; $rf_asig = NULL; $rt_asig = NULL;

// Detail variables
$x_fecha = NULL; $ox_fecha = NULL; $tx_fecha = NULL; $ftx_fecha = 133; $rf_fecha = NULL; $rt_fecha = NULL;
$x_time = NULL; $ox_time = NULL; $tx_time = NULL; $ftx_time = 134; $rf_time = NULL; $rt_time = NULL;
$x_fecha_asig = NULL; $ox_fecha_asig = NULL; $tx_fecha_asig = NULL; $ftx_fecha_asig = 133; $rf_fecha_asig = NULL; $rt_fecha_asig = NULL;
$x_hora_asig = NULL; $ox_hora_asig = NULL; $tx_hora_asig = NULL; $ftx_hora_asig = 134; $rf_hora_asig = NULL; $rt_hora_asig = NULL;
$x_detalles_sol = NULL; $ox_detalles_sol = NULL; $tx_detalles_sol = NULL; $ftx_detalles_sol = 201; $rf_detalles_sol = NULL; $rt_detalles_sol = NULL;
$x_fecha_sol = NULL; $ox_fecha_sol = NULL; $tx_fecha_sol = NULL; $ftx_fecha_sol = 133; $rf_fecha_sol = NULL; $rt_fecha_sol = NULL;
$x_hora_sol = NULL; $ox_hora_sol = NULL; $tx_hora_sol = NULL; $ftx_hora_sol = 134; $rf_hora_sol = NULL; $rt_hora_sol = NULL;
$x_aux = NULL; $ox_aux = NULL; $tx_aux = NULL; $ftx_aux = 20; $rf_aux = NULL; $rt_aux = NULL;
$x_total = NULL; $ox_total = NULL; $tx_total = NULL; $ftx_total = 20; $rf_total = NULL; $rt_total = NULL;
$x_promedio = NULL; $ox_promedio = NULL; $tx_promedio = NULL; $ftx_promedio = 131; $rf_promedio = NULL; $rt_promedio = NULL;
$x_fila = NULL; $ox_fila = NULL; $tx_fila = NULL; $ftx_fila = 20; $rf_fila = NULL; $rt_fila = NULL;
$x_Suma1 = NULL; $ox_Suma1 = NULL; $tx_Suma1 = NULL; $ftx_Suma1 = 131; $rf_Suma1 = NULL; $rt_Suma1 = NULL;
?>
<?php

// Chart configuration parameters
$Prueba_cht_parms = NULL; // Store all chart parameters

// Chart data
$Prueba_cht_index = NULL;
$Prueba_cht_id = NULL;
$Prueba_cht_smry = NULL;
$Prueba_cht_XFld = NULL;
$Prueba_cht_YFld = NULL;
$Prueba_cht_YFldBase = NULL;
$Prueba_cht_XFld = "aux";
$Prueba_cht_YFld = "total";
$Prueba_cht_XDateFld = "";
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

$nDtls = 13;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

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
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3" class="ewPadding"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
Por Asignaado
<br><br>
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
<!-- summary report starts -->
<div id="report_summary">
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
		Asignado a
		<?php } ?>
		</td>
		<td valign="bottom" class="ewTableHeader">
		Fecha
		</td>
		<td valign="bottom" class="ewTableHeader">
		Hora 
		</td>
		<td valign="bottom" class="ewTableHeader">
		fecha asig
		</td>
		<td valign="bottom" class="ewTableHeader">
		hora asig
		</td>
		<td valign="bottom" class="ewTableHeader">
		detalles sol
		</td>
		<td valign="bottom" class="ewTableHeader">
		fecha sol
		</td>
		<td valign="bottom" class="ewTableHeader">
		hora sol
		</td>
		<td valign="bottom" class="ewTableHeader">
		aux
		</td>
		<td valign="bottom" class="ewTableHeader">
		total
		</td>
		<td valign="bottom" class="ewTableHeader">
		promedio
		</td>
		<td valign="bottom" class="ewTableHeader">
		fila
		</td>
		<td valign="bottom" class="ewTableHeader">
		Suma 1
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
		$dgx_asig = $x_asig;
		if (($x_asig == NULL && $ox_asig == NULL) ||
			(($x_asig <> "" && $ox_asig == $dgx_asig) && !ChkLvlBreak(1))) {
			$dgx_asig = "";
		} elseif ($x_asig == NULL) {
			$dgx_asig = EW_NULL_LABEL;
		} elseif ($x_asig == "") {
			$dgx_asig = EW_EMPTY_LABEL;
		}
?>
	<tr<?php echo $sItemRowClass; ?>>
		<td class="ewRptGrpField1">
		<?php $tx_asig = $x_asig; $x_asig = $dgx_asig; ?>
<?php echo $x_asig ?>
		<?php $x_asig = $tx_asig; ?></td>
		<td class="ewRptDtlField">
<?php echo ew_FormatDateTime($x_fecha,5) ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_time ?>
</td>
		<td class="ewRptDtlField">
<?php echo ew_FormatDateTime($x_fecha_asig,5) ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_hora_asig ?>
</td>
		<td class="ewRptDtlField">
<?php echo str_replace(chr(10), "<br>", $x_detalles_sol); ?>
</td>
		<td class="ewRptDtlField">
<?php echo ew_FormatDateTime($x_fecha_sol,5) ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_hora_sol ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_aux ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_total ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_promedio ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_fila ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_Suma1 ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();
	}

	// Accumulate grand summary
	AccumulateGrandSummary();

	// Save old group values
	$ox_asig = $x_asig;

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
	<!-- tr><td colspan="13"><span class="phpreportmaker">&nbsp;<br></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="13">Total Registros (<?php echo ew_FormatNumber($cnt[0][0],0,-2,-2,-2); ?> Registros Detallados)</td></tr>
	<!--tr><td colspan="13"><span class="phpreportmaker">&nbsp;<br></span></td></tr-->
<?php } ?>
</table>
<!-- </form> -->
<form action="Por_Asignaadosmry.php" name="ewpagerform" id="ewpagerform">
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
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($nStartGrp == 1) { ?>
	<td><img src="rptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Por_Asignaadosmry.php?start=1"><img src="rptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($PrevStart == $nStartGrp) { ?>
	<td><img src="rptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Por_Asignaadosmry.php?start=<?php echo $PrevStart; ?>"><img src="rptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" value="<?php echo intval(($nStartGrp-1)/$nDisplayGrps+1); ?>" size="4"></td>
<!--next page button-->
	<?php if ($NextStart == $nStartGrp) { ?>
	<td><img src="rptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Por_Asignaadosmry.php?start=<?php echo $NextStart; ?>"><img src="rptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>
	<?php  } ?>
<!--last page button-->
	<?php if ($LastStart == $nStartGrp) { ?>
	<td><img src="rptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } else { ?>
	<td><a href="Por_Asignaadosmry.php?start=<?php echo $LastStart; ?>"><img src="rptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;of <?php echo intval(($nTotalGrps-1)/$nDisplayGrps+1);?></span></td>
	</tr></table>
	<?php if ($nStartGrp > $nTotalGrps) { $nStartGrp = $nTotalGrps; }
	$nStopGrp = $nStartGrp + $nDisplayGrps - 1;
	$nGrpCount = $nTotalGrps - 1;
	if ($rsEof) { $nGrpCount = $nTotalGrps; }
	if ($nStopGrp > $nGrpCount) { $nStopGrp = $nGrpCount; } ?>
	<span class="phpreportmaker"> <?php echo $nStartGrp; ?> to <?php echo $nStopGrp; ?> of <?php echo $nTotalGrps; ?></span>
<?php } else { ?>
	<span class="phpreportmaker"></span>	
<?php } ?>
		</td>
<?php if ($nTotalGrps > 0) { ?>
		<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" valign="top" nowrap><span class="phpreportmaker">Groups Per Page&nbsp;
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
</div>
<!-- Summary Report Ends -->
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
<a name="cht_Prueba"></a>
<div id="div_Prueba">
<?php

// Initialize chart data
$Prueba_cht_id = "Por_Asignaado_Prueba"; // Chart ID
$Prueba_cht_parms .= "type=1,"; // Chart type
$Prueba_cht_parms .= "bgcolor=#FCFCFC,"; // Background color
$Prueba_cht_parms .= "caption=" . ew_Encode("Prueba") . ","; // Chart caption
$Prueba_cht_parms .= "borderleftcolor=#808080,"; // Border left color
$Prueba_cht_parms .= "bordertopcolor=#808080,"; // Border top color
$Prueba_cht_parms .= "borderbottomcolor=#808080,"; // Border bottom color
$Prueba_cht_parms .= "borderrightcolor=#808080,"; // Border right color
$Prueba_cht_parms .= "chartbgcolor=#EEEEEE,"; // Chart background color
$Prueba_cht_parms .= "chartbordercolor=#A9A9A9,"; // Chart border color
$Prueba_cht_parms .= "numgridlines=3,"; // Number of grid lines
$Prueba_cht_parms .= "gridlinecolor=#DCDCDC,"; // Grid line color
$Prueba_cht_parms .= "xaxisname=" . ew_Encode("aux") . ","; // X axis name
$Prueba_cht_parms .= "xaxisnamerotated=0,"; // X axis name rotated
$Prueba_cht_parms .= "xaxisvaluemaxchar=20,"; // X axis value max char
$Prueba_cht_parms .= "yaxisname=" . ew_Encode("total") . ","; // Y axis name
$Prueba_cht_parms .= "yaxisnamerotated=1,"; // Y axis name rotated
$Prueba_cht_parms .= "shownames=1,"; // Show names
$Prueba_cht_parms .= "showvalues=1,"; // Show values
$Prueba_cht_parms .= "showhover=1,"; // Show hover
$Prueba_cht_parms .= "alpha=50,"; // Chart alpha
$Prueba_cht_parms .= "colorpalette=#FF0000|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF,"; // Chart color palette
$Prueba_cht_parms .= "cssurl=rptcss/ewchart.css"; // Chart css
ew_SortChartData($Prueba_cht_smry, 0);
echo ew_ShowChart($Prueba_cht_id, $Prueba_cht_parms, $Prueba_cht_smry, 550, 440, "");
?>
</div>
<a href="#top">Top</a>
<br><br>
	</div><br></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php
php_close($conn);
?>
<?php include "rptinc/footer.php"; ?>
<?php

// Check level break
function ChkLvlBreak($lvl) {
	switch ($lvl) {
		case 1:
			return ($GLOBALS["x_asig"] == NULL && $GLOBALS["ox_asig"] != NULL) ||
				($GLOBALS["x_asig"] !== NULL && $GLOBALS["ox_asig"] == NULL) ||
				($GLOBALS["x_asig"] <> $GLOBALS["ox_asig"]);
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
	if ($lvl <= 1) $GLOBALS["ox_asig"] = "";

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
			$GLOBALS["x_asig"] = $row["asig"];
			$GLOBALS["x_fecha"] = $row["fecha"];
			$val[1] = $GLOBALS["x_fecha"];
			$GLOBALS["x_time"] = $row["time"];
			$val[2] = $GLOBALS["x_time"];
			$GLOBALS["x_fecha_asig"] = $row["fecha_asig"];
			$val[3] = $GLOBALS["x_fecha_asig"];
			$GLOBALS["x_hora_asig"] = $row["hora_asig"];
			$val[4] = $GLOBALS["x_hora_asig"];
			$GLOBALS["x_detalles_sol"] = $row["detalles_sol"];
			$val[5] = $GLOBALS["x_detalles_sol"];
			$GLOBALS["x_fecha_sol"] = $row["fecha_sol"];
			$val[6] = $GLOBALS["x_fecha_sol"];
			$GLOBALS["x_hora_sol"] = $row["hora_sol"];
			$val[7] = $GLOBALS["x_hora_sol"];
			$GLOBALS["x_aux"] = $row["aux"];
			$val[8] = $GLOBALS["x_aux"];
			$GLOBALS["x_total"] = $row["total"];
			$val[9] = $GLOBALS["x_total"];
			$GLOBALS["x_promedio"] = $row["promedio"];
			$val[10] = $GLOBALS["x_promedio"];
			$GLOBALS["x_fila"] = $row["fila"];
			$val[11] = $GLOBALS["x_fila"];
			$GLOBALS["x_Suma1"] = $row["Suma1"];
			$val[12] = $GLOBALS["x_Suma1"];
			break;
		} else {
			$rsidx++;
			$row = ($rsidx < $rscnt) ? $rs[$rsidx] : FALSE;
		}
	}
	if (!$row) {
		$GLOBALS["x_asig"] = "";
		$GLOBALS["x_fecha"] = "";
		$GLOBALS["x_time"] = "";
		$GLOBALS["x_fecha_asig"] = "";
		$GLOBALS["x_hora_asig"] = "";
		$GLOBALS["x_detalles_sol"] = "";
		$GLOBALS["x_fecha_sol"] = "";
		$GLOBALS["x_hora_sol"] = "";
		$GLOBALS["x_aux"] = "";
		$GLOBALS["x_total"] = "";
		$GLOBALS["x_promedio"] = "";
		$GLOBALS["x_fila"] = "";
		$GLOBALS["x_Suma1"] = "";
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
			$x_asig = $row["asig"];
			$gx_asig = $x_asig;
			$bNewGroup = ($grpcnt == 0) ||
				($grpvalue == NULL && $x_asig != NULL) ||
				($grpvalue != NULL && $x_asig == NULL) ||
				(@$grpvalue <> $gx_asig);
			if ($bNewGroup) {
				$grpvalue = $gx_asig;
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
	AccumulateChartSummary($rs, $GLOBALS["Prueba_cht_smry"], $GLOBALS["Prueba_cht_XFld"], "", $GLOBALS["Prueba_cht_YFld"], 0, "", "SUM");
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
