<?php include "rptinc/ewcommon.php"; ?>
<?php include "rptinc/ewconfig.php"; ?>
<?php include "rptinc/phprptfn.php"; ?>
<?php

// Default use utf-8
header("Content-Type: text/xml; charset=UTF-8");

//-------------------------------
//  Default chart parameters
//-------------------------------
// Chart type & bg color

$ewChartType = "1";
$ewChartBgColor = "";

// Chart caption
$ewChartCaption = "Chart";

// Chart border colors
$ewChartBorderLeftColor = "";
$ewChartBorderTopColor = "";
$ewChartBorderBottomColor = "";
$ewChartBorderRightColor = "";

// Chart colors
$ewChartChartBgColor = "";
$ewChartChartBorderColor = "";

// Grid line
$ewChartNumGridLines = "3";
$ewChartGridLineColor = "";

// Chart X, Y parameters
$ewChartXAxisName = "X Axis Name";
$ewChartXAxisNameRotated = "0";
$ewChartXAxisValueMaxChar = "10";
$ewChartXAxisValueRotation = "0";
$ewChartYAxisName = "Y Axis Name";
$ewChartYAxisNameRotated = "0";
$ewChartYAxisMinValue = "0";
$ewChartYAxisMaxValue = "0";

// Show names/values/hover
$ewChartShowNames = "0";
$ewChartShowValues = "0";
$ewChartShowHover = "0";

// Chart alpha
$ewChartAlpha = "50";

// Chart Color Palette
$ewChartColorPalette = "";

// Chart Css Url
$ewChartCssUrl = "";

// Get chart id
$cht_id = @$PHP_GET["id"];

// Get chart configuration from Session
$parms = @$PHP_SESSION[$cht_id . "_parms"];
$arParms = explode(",", $parms);

// Chart type & bg color
$cht_type = LoadParm("type");
if ($cht_type <> "") $ewChartType = $cht_type;
$cht_bgcolor = LoadParm("bgcolor");
if ($cht_bgcolor <> "") $ewChartBgColor = $cht_bgcolor;

// Chart caption
$cht_caption = LoadParm("caption");
if ($cht_caption <> "") $ewChartCaption = ew_Decode($cht_caption);

// Chart border colors
$cht_borderleftcolor = LoadParm("borderleftcolor");
if ($cht_borderleftcolor <> "") $ewChartBorderLeftColor = $cht_borderleftcolor;
$cht_bordertopcolor = LoadParm("bordertopcolor");
if ($cht_bordertopcolor <> "") $ewChartBorderTopColor = $cht_bordertopcolor;
$cht_borderbottomcolor = LoadParm("borderbottomcolor");
if ($cht_borderbottomcolor <> "") $ewChartBorderBottomColor = $cht_borderbottomcolor;
$cht_borderrightcolor = LoadParm("borderrightcolor");
if ($cht_borderrightcolor <> "") $ewChartBorderRightColor = $cht_borderrightcolor;

// Chart colors
$cht_chartbgcolor = LoadParm("chartbgcolor");
if ($cht_chartbgcolor <> "") $ewChartChartBgColor = $cht_chartbgcolor;
$cht_chartbordercolor = LoadParm("chartbordercolor");
if ($cht_chartbordercolor <> "") $ewChartChartBorderColor = $cht_chartbordercolor;

// Grid Line
$cht_numgridlines = LoadParm("numgridlines");
if ($cht_numgridlines <> "") $ewChartNumGridLines = $cht_numgridlines;
$cht_gridlinecolor = LoadParm("gridlinecolor");
if ($cht_gridlinecolor <> "") $ewChartGridLineColor = $cht_gridlinecolor;

// Chart X, Y parameter
$cht_xaxisname = LoadParm("xaxisname");
if ($cht_xaxisname <> "") $ewChartXAxisName = ew_Decode($cht_xaxisname);
$cht_xaxisnamerotated = LoadParm("xaxisnamerotated");
if ($cht_xaxisnamerotated <> "") $ewChartXAxisNameRotated = $cht_xaxisnamerotated;
$cht_xaxisvaluemaxchar = LoadParm("xaxisvaluemaxchar");
if ($cht_xaxisvaluemaxchar <> "") $ewChartXAxisValueMaxChar = $cht_xaxisvaluemaxchar;
$cht_xaxisvaluerotation = LoadParm("xaxisvaluerotation");
if ($cht_xaxisvaluerotation <> "") $ewChartXAxisValueRotation = $cht_xaxisvaluerotation * -1;
$cht_yaxisname = LoadParm("yaxisname");
if ($cht_yaxisname <> "") $ewChartYAxisName = ew_Decode($cht_yaxisname);
$cht_yaxisnamerotated = LoadParm("yaxisnamerotated");
if ($cht_yaxisnamerotated <> "") $ewChartYAxisNameRotated = $cht_yaxisnamerotated;
$cht_yaxisminvalue = LoadParm("yaxisminvalue");
if ($cht_yaxisminvalue <> "") $ewChartYAxisMinValue = $cht_yaxisminvalue;
$cht_yaxismaxvalue = LoadParm("yaxismaxvalue");
if ($cht_yaxismaxvalue <> "") $ewChartYAxisMaxValue = $cht_yaxismaxvalue;

// Show names/values/hover
$cht_shownames = LoadParm("shownames");
if ($cht_shownames <> "") $ewChartShowNames = $cht_shownames;
$cht_showvalues = LoadParm("showvalues");
if ($cht_showvalues <> "") $ewChartShowValues = $cht_showvalues;
$cht_showhover = LoadParm("showhover");
if ($cht_showhover <> "") $ewChartShowHover = $cht_showhover;

// Chart alpha
$cht_alpha = LoadParm("alpha");
if ($cht_alpha <> "") $ewChartAlpha = $cht_alpha;

// Color palette
$cht_colorpalette = LoadParm("colorpalette");
if ($cht_colorpalette <> "") $ewChartColorPalette = $cht_colorpalette;

// Chart Css Url
$cht_cssurl = LoadParm("cssurl");
if ($cht_cssurl <> "") $ewChartCssUrl = $cht_cssurl;
$sChartContent = ChartXml($cht_id);

// Write utf-8 encoding
echo "<?phpxml version=\"1.0\" encoding=\"utf-8\" ?>";

// Write content
echo $sChartContent;

// Load URL parameter
function LoadParm($parm) {
	global $arParms, $PHP_GET;
	if (@$PHP_GET[$parm] <> "") {
		return (get_magic_quotes_gpc()) ? stripslashes($PHP_GET[$parm]) : $PHP_GET[$parm];
	} else {
		foreach ($arParms as $key => $value) {
			$arVal = explode("=", $value);
			if (count($arVal) == 2 && strtolower($arVal[0]) == strtolower($parm))
				return $arVal[1]; 
		}
	}
	return "";
}

// Output XML for chart
function ChartXml($id) {
	global $PHP_SESSION;
	$wrk = "";
	$chartdata = @$PHP_SESSION[$id . "_data"];  // Load chart data from Session
	if (is_array($chartdata)) {
			$maxval = 0;
			foreach ($chartdata as $val)
				if (count($val) == 3 && $val[2] > $maxval) $maxval = $val[2];
			if ($GLOBALS["cht_yaxismaxvalue"] == "" || $GLOBALS["cht_yaxismaxvalue"] == NULL) {
				$GLOBALS["ewChartYAxisMaxValue"] = $maxval;
				GetBound($GLOBALS["ewChartYAxisMinValue"], $GLOBALS["ewChartYAxisMaxValue"]);
			}
			$wrk = ChartHeader(1); // Get chart header
			for ($i = 0; $i < count($chartdata); $i++) {
				if (count($chartdata[$i]) == 3) {
					$name = $chartdata[$i][0];
					$name = ($name == NULL) ? "(Null)" : ($name == "") ? "(Empty)" : $name;
					$color = GetPaletteColor($i);
					if ($chartdata[$i][1] <> "") $name .= ", " . $chartdata[$i][1];
					$val = ($chartdata[$i][2] == NULL) ? 0 : intval($chartdata[$i][2]);
					$wrk .= ChartContent($name, $val, $color, $GLOBALS["ewChartAlpha"], @$link); // Get chart content
				}
			}
			$wrk .= ChartHeader(2); // Get chart footer
	}

// ew_Trace($wrk);
	return $wrk;
}

// Get color from palette
function GetPaletteColor($i) {
	global $ewChartColorPalette;
	$arColor = explode("|", $ewChartColorPalette);
	return $arColor[$i % count($arColor)];
}

// Convert to HTML color
function ColorCode($c) {
	if ($c <> "") {

		// remove #
		$color = str_replace("#", "", $c);

		// fill to 6 digits
		return str_pad($color, 6, "0", STR_PAD_LEFT);
	} else {
		return "";
	}
}

// Get chart value bounds
function GetBound(&$min, &$max) {
	$maxp10 = (intval($max) == 0) ? 0 : intval(log10(abs($max)));
	$minp10 = (intval($min) == 0) ? 0 : intval(log10(abs($min)));
	$p10 = $minp10;
	if ($maxp10 > $p10) $p10 = $maxp10;
	$intv = pow(10, $p10);
	if (abs($max) / $intv < 2 && abs($min) / $intv < 2) {
		$p10 -= 1;
		$intv = pow(10, $p10);
	}
	$upper = (intval($max / $intv) + 1) * $intv;
	$lower = ($min < 0) ? intval($min / $intv) * $intv : 0;
	if ($max < 0) $upper = 0;
	$min = $lower;
	$max = $upper;
}

// Generate XML header for chart
function ChartHeader($typ) {
	if ($typ == 1) {
		$wrk = "<ewchart";
		WriteAtt($wrk, "type", $GLOBALS["ewChartType"]);
		WriteAtt($wrk, "bgcolor", ColorCode($GLOBALS["ewChartBgColor"]));
		WriteAtt($wrk, "caption", $GLOBALS["ewChartCaption"]);
		WriteAtt($wrk, "borderleftcolor", ColorCode($GLOBALS["ewChartBorderLeftColor"]));
		WriteAtt($wrk, "bordertopcolor", ColorCode($GLOBALS["ewChartBorderTopColor"]));
		WriteAtt($wrk, "borderbottomcolor", ColorCode($GLOBALS["ewChartBorderBottomColor"]));
		WriteAtt($wrk, "borderrightcolor", ColorCode($GLOBALS["ewChartBorderRightColor"]));
		WriteAtt($wrk, "chartbgcolor", ColorCode($GLOBALS["ewChartChartBgColor"]));
		WriteAtt($wrk, "chartbordercolor", ColorCode($GLOBALS["ewChartChartBorderColor"]));
		WriteAtt($wrk, "numgridlines", $GLOBALS["ewChartNumGridLines"]);
		WriteAtt($wrk, "gridlinecolor", ColorCode($GLOBALS["ewChartGridLineColor"]));
		WriteAtt($wrk, "xaxisname", $GLOBALS["ewChartXAxisName"]);
		WriteAtt($wrk, "xaxisnamerotated", $GLOBALS["ewChartXAxisNameRotated"]);
		WriteAtt($wrk, "xaxisvaluemaxchar", $GLOBALS["ewChartXAxisValueMaxChar"]);
		WriteAtt($wrk, "xaxisvaluerotation", $GLOBALS["ewChartXAxisValueRotation"]);
		WriteAtt($wrk, "yaxisname", $GLOBALS["ewChartYAxisName"]);
		WriteAtt($wrk, "yaxisnamerotated", $GLOBALS["ewChartYAxisNameRotated"]);
		WriteAtt($wrk, "yaxisminvalue", $GLOBALS["ewChartYAxisMinValue"]);
		WriteAtt($wrk, "yaxismaxvalue", $GLOBALS["ewChartYAxisMaxValue"]);
		WriteAtt($wrk, "shownames", $GLOBALS["ewChartShowNames"]);
		WriteAtt($wrk, "showvalues", $GLOBALS["ewChartShowValues"]);
		WriteAtt($wrk, "showhover", $GLOBALS["ewChartShowHover"]);
		WriteAtt($wrk, "cssurl", $GLOBALS["ewChartCssUrl"]);
		$wrk .= ">";
	} else {
		$wrk = "</ewchart>";
	}
	return $wrk;
}

// Generate data content in XML for chart
function ChartContent($name, $val, $color, $alpha, $lnk) {
	$wrk = "<data";
	WriteAtt($wrk, "name", $name);
	WriteAtt($wrk, "value", $val);
	WriteAtt($wrk, "color", ColorCode($color));
	WriteAtt($wrk, "alpha", $alpha);
	WriteAtt($wrk, "link", $lnk);
	$wrk .= " />";
	return $wrk;
}

// Write XML attribute
function WriteAtt(&$str, $name, $val) {
	$val = strval($val);
	if ($val <> "") $str .= " " . $name . "=\"" . ewConvertToUtf8(XmlEncode($val)) . "\"";
}
?>
