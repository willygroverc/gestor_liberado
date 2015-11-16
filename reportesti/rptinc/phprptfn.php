<?php
// Functions for PHP Report Maker 1.0
// (C)2007 e.World Technology Ltd.

//------------------------------------------------------------------------------
// Functions to init arrays
function ew_InitArray($iLen, $vValue) {
	if (function_exists('array_fill')) {
		return array_fill(0, $iLen, $vValue);
	} else {
		$aResult = array();
		for ($iCount = 0; $iCount < $iLen; $iCount++)
			$aResult[] = $vValue;
		return $aResult;
	}
}

function ew_Init2DArray($iLen1, $iLen2, $vValue) {
	return ew_InitArray($iLen1, ew_InitArray($iLen2, $vValue));
}

//------------------------------------------------------------------------------
// Functions for charting

// Functions to convert encoding
function ewConvertToUtf8($str)
{
	return ewConvert(EW_ENCODING, "UTF-8", $str);
}

function ewConvertFromUtf8($str)
{
	return ewConvert("UTF-8", EW_ENCODING, $str);
}

function ewConvert($from, $to, $str)
{
	if ($from != "" && $to != "" && $from != $to) {
		if (function_exists("iconv")) {
			return iconv($from, $to, $str);
		} elseif (function_exists("mb_convert_encoding")) {
			return mb_convert_encoding($str, $to, $from);
		} else {
			return $str;
		}
	} else {
	return $str;
	}
}

// Function for encoding comma
function ew_Encode($val) {
	return str_replace(",", "%2C", $val); // encode comma
}

// Function for decoding comma
function ew_Decode($src) {
	return str_replace("%2C", ",", $src);
}

//------------------------------------------------------------------------------
// Functions to connect database
function php_connect($HOST, $USER, $PASS, $DB, $PORT) {
	if (EW_USE_MYSQLI) {
		$conn = mysqli_connect($HOST, $USER, $PASS, $DB, $PORT);
	} else {
		$conn = mysql_connect($HOST . ":" . $PORT, $USER, $PASS);
		mysql_select_db($DB);
	}
	return $conn;
}

function php_close($conn) {
	return (EW_USE_MYSQLI) ? mysqli_close($conn) :	mysql_close($conn);
}

function php_query($strsql, $conn) {
	$rs = (EW_USE_MYSQLI) ? mysqli_query($conn, $strsql) : mysql_query($strsql, $conn);
	return $rs;
}

function php_num_rows($rs) {
	return (EW_USE_MYSQLI) ? @mysqli_num_rows($rs) :	@mysql_num_rows($rs);
}

function php_fetch_array($rs) {
	return (EW_USE_MYSQLI) ? mysqli_fetch_array($rs) : mysql_fetch_array($rs);
}

function php_fetch_row($rs) {
	return (EW_USE_MYSQLI) ? mysqli_fetch_row($rs) : mysql_fetch_row($rs);
}

function php_free_result($rs) {
	return (EW_USE_MYSQLI) ? @mysqli_free_result($rs) : @mysql_free_result($rs);
}

function php_data_seek($rs, $cnt) {
	return (EW_USE_MYSQLI) ? @mysqli_data_seek($rs, $cnt) : @mysql_data_seek($rs, $cnt);
}

function php_error($conn) {
	return (EW_USE_MYSQLI) ? mysqli_error($conn) : mysql_error($conn);
}

function php_insert_id($conn) {
	return (EW_USE_MYSQLI) ? @mysqli_insert_id($conn) : @mysql_insert_id($conn);
}

function php_affected_rows($conn) {
	return (EW_USE_MYSQLI) ? @mysqli_affected_rows($conn) : @mysql_affected_rows($conn);
}

//-------------------------------------------------------------------------------
// Functions for default date format
// FormatDateTime
/*
Format a timestamp, datetime, date or time field from MySQL
$namedformat:
0 - General Date,
1 - Long Date,
2 - Short Date (Default),
3 - Long Time,
4 - Short Time,
5 - Short Date (yyyy/mm/dd),
6 - Short Date (mm/dd/yyyy),
7 - Short Date (dd/mm/yyyy)
*/

// Convert a date to MySQL format
function ew_UnFormatDateTime($dateStr)
{
	@list($datePt, $timePt) = explode(" ", $dateStr);
	$arDatePt = explode(EW_DATE_SEPARATOR, $datePt);
	if (count($arDatePt) == 3) {
		switch (DEFAULT_DATE_FORMAT) {
		case "yyyy" . EW_DATE_SEPARATOR . "mm" . EW_DATE_SEPARATOR . "dd":
			list($year, $month, $day) = $arDatePt;
			break;
		case "mm" . EW_DATE_SEPARATOR . "dd" . EW_DATE_SEPARATOR . "yyyy":
			list($month, $day, $year) = $arDatePt;
			break;
		case "dd" . EW_DATE_SEPARATOR . "mm" . EW_DATE_SEPARATOR . "yyyy":
			list($day, $month, $year) = $arDatePt;
			break;
		}
		return trim($year . "-" . $month . "-" . $day . " " . $timePt);
	} else {
		return $dateStr;
	}
}

function ew_FormatDateTime($ts, $namedformat)
{
	$DefDateFormat = str_replace("yyyy", "%Y", DEFAULT_DATE_FORMAT);
	$DefDateFormat = str_replace("mm", "%m", $DefDateFormat);
	$DefDateFormat = str_replace("dd", "%d", $DefDateFormat);
	if (is_numeric($ts)) // timestamp
	{
		switch (strlen($ts)) {
			case 14:
				$patt = '/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
				break;
			case 12:
				$patt = '/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
				break;
			case 10:
				$patt = '/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
				break;
			case 8:
				$patt = '/(\d{4})(\d{2})(\d{2})/';
				break;
			case 6:
				$patt = '/(\d{2})(\d{2})(\d{2})/';
				break;
			case 4:
				$patt = '/(\d{2})(\d{2})/';
				break;
			case 2:
				$patt = '/(\d{2})/';
				break;
			default:
				return $ts;
		}
		if ((isset($patt))&&(preg_match($patt, $ts, $matches)))
		{
			$year = $matches[1];
			$month = @$matches[2];
			$day = @$matches[3];
			$hour = @$matches[4];
			$min = @$matches[5];
			$sec = @$matches[6];
		}
		if (($namedformat==0)&&(strlen($ts)<10)) $namedformat = 2;
	}
	elseif (is_string($ts))
	{
		if (preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $ts, $matches)) // datetime
		{
			$year = $matches[1];
			$month = $matches[2];
			$day = $matches[3];
			$hour = $matches[4];
			$min = $matches[5];
			$sec = $matches[6];
		}
		elseif (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $ts, $matches)) // date
		{
			$year = $matches[1];
			$month = $matches[2];
			$day = $matches[3];
			if ($namedformat==0) $namedformat = 2;
		}
		elseif (preg_match('/(^|\s)(\d{2}):(\d{2}):(\d{2})/', $ts, $matches)) // time
		{
			$hour = $matches[2];
			$min = $matches[3];
			$sec = $matches[4];
			if (($namedformat==0)||($namedformat==1)) $namedformat = 3;
			if ($namedformat==2) $namedformat = 4;
		}
		else
		{
			return $ts;
		}
	}
	else
	{
		return $ts;
	}
	if (!isset($year)) $year = 0; // dummy value for times
	if (!isset($month)) $month = 1;
	if (!isset($day)) $day = 1;
	if (!isset($hour)) $hour = 0;
	if (!isset($min)) $min = 0;
	if (!isset($sec)) $sec = 0;
	$uts = @mktime($hour, $min, $sec, $month, $day, $year);
	if ($uts < 0) { // failed to convert
		$year = substr_replace("0000", $year, -1 * strlen($year));
		$month = substr_replace("00", $month, -1 * strlen($month));
		$day = substr_replace("00", $day, -1 * strlen($day));
		$hour = substr_replace("00", $hour, -1 * strlen($hour));
		$min = substr_replace("00", $min, -1 * strlen($min));
		$sec = substr_replace("00", $sec, -1 * strlen($sec));
		$DefDateFormat = str_replace("yyyy", $year, DEFAULT_DATE_FORMAT);
		$DefDateFormat = str_replace("mm", $month, $DefDateFormat);
		$DefDateFormat = str_replace("dd", $day, $DefDateFormat);
		switch ($namedformat) {
			case 0:
				return $DefDateFormat." $hour:$min:$sec";
				break;
			case 1://unsupported, return general date
				return $DefDateFormat." $hour:$min:$sec";
				break;
			case 2:
				return $DefDateFormat;
				break;
			case 3:
				if (intval($hour)==0)
					return "12:$min:$sec AM";
				elseif (intval($hour)>0 && intval($hour)<12)
					return "$hour:$min:$sec AM";
				elseif (intval($hour)==12)
					return "$hour:$min:$sec PM";
				elseif (intval($hour)>12 && intval($hour)<=23)
					return (intval($hour)-12).":$min:$sec PM";
				else
					return "$hour:$min:$sec";
				break;
			case 4:
				return "$hour:$min:$sec";
				break;
			case 5:
				return "$year". EW_DATE_SEPARATOR . "$month" . EW_DATE_SEPARATOR . "$day";
				break;
			case 6:
				return "$month". EW_DATE_SEPARATOR ."$day" . EW_DATE_SEPARATOR . "$year";
				break;
			case 7:
				return "$day" . EW_DATE_SEPARATOR ."$month" . EW_DATE_SEPARATOR . "$year";
				break;
		}
	} else {
		switch ($namedformat) {
			case 0:
				return strftime($DefDateFormat." %H:%M:%S", $uts);
				break;
			case 1:
				return strftime("%A, %B %d, %Y", $uts);
				break;
			case 2:
				return strftime($DefDateFormat, $uts);
				break;
			case 3:
				return strftime("%I:%M:%S %p", $uts);
				break;
			case 4:
				return strftime("%H:%M:%S", $uts);
				break;
			case 5:
				return strftime("%Y" . EW_DATE_SEPARATOR . "%m" . EW_DATE_SEPARATOR . "%d", $uts);
				break;
			case 6:
				return strftime("%m" . EW_DATE_SEPARATOR . "%d" . EW_DATE_SEPARATOR . "%Y", $uts);
				break;
			case 7:
				return strftime("%d" . EW_DATE_SEPARATOR . "%m" . EW_DATE_SEPARATOR . "%Y", $uts);
				break;
		}
	}
}

// FormatCurrency
/*
FormatCurrency(Expression[,NumDigitsAfterDecimal [,IncludeLeadingDigit
 [,UseParensForNegativeNumbers [,GroupDigits]]]])
NumDigitsAfterDecimal is the numeric value indicating how many places to the
right of the decimal are displayed
-1 Use Default
The IncludeLeadingDigit, UseParensForNegativeNumbers, and GroupDigits
arguments have the following settings:
-1 True
0 False
-2 Use Default
*/
function ew_FormatCurrency($amount, $NumDigitsAfterDecimal, $IncludeLeadingDigit, $UseParensForNegativeNumbers, $GroupDigits)
{

	// export the values returned by localeconv into the local scope
	if (function_exists("localeconv")) extract(localeconv());

	// set defaults if locale is not set
	if (empty($currency_symbol)) $currency_symbol = DEFAULT_CURRENCY_SYMBOL;
	if (empty($mon_decimal_point)) $mon_decimal_point = DEFAULT_MON_DECIMAL_POINT;
	if (empty($mon_thousands_sep)) $mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	if (empty($positive_sign)) $positive_sign = DEFAULT_POSITIVE_SIGN;
	if (empty($negative_sign)) $negative_sign = DEFAULT_NEGATIVE_SIGN;
	if (empty($frac_digits) || $frac_digits == CHAR_MAX) $frac_digits = DEFAULT_FRAC_DIGITS;
	if (empty($p_cs_precedes) || $p_cs_precedes == CHAR_MAX) $p_cs_precedes = DEFAULT_P_CS_PRECEDES;
	if (empty($p_sep_by_space) || $p_sep_by_space == CHAR_MAX) $p_sep_by_space = DEFAULT_P_SEP_BY_SPACE;
	if (empty($n_cs_precedes) || $n_cs_precedes == CHAR_MAX) $n_cs_precedes = DEFAULT_N_CS_PRECEDES;
	if (empty($n_sep_by_space) || $n_sep_by_space == CHAR_MAX) $n_sep_by_space = DEFAULT_N_SEP_BY_SPACE;
	if (empty($p_sign_posn) || $p_sign_posn == CHAR_MAX) $p_sign_posn = DEFAULT_P_SIGN_POSN;
	if (empty($n_sign_posn) || $n_sign_posn == CHAR_MAX) $n_sign_posn = DEFAULT_N_SIGN_POSN;

	// check $NumDigitsAfterDecimal
	if ($NumDigitsAfterDecimal > -1)
		$frac_digits = $NumDigitsAfterDecimal;

	// check $UseParensForNegativeNumbers
	if ($UseParensForNegativeNumbers == -1) {
		$n_sign_posn = 0;
		if ($p_sign_posn == 0) {
			if (DEFAULT_P_SIGN_POSN != 0)
				$p_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$p_sign_posn = 3;
		}
	} elseif ($UseParensForNegativeNumbers == 0) {
		if ($n_sign_posn == 0)
			if (DEFAULT_P_SIGN_POSN != 0)
				$n_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$n_sign_posn = 3;
	}

	// check $GroupDigits
	if ($GroupDigits == -1) {
		$mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	} elseif ($GroupDigits == 0) {
		$mon_thousands_sep = "";
	}

	// start by formatting the unsigned number
	$number = number_format(abs($amount),
							$frac_digits,
							$mon_decimal_point,
							$mon_thousands_sep);

	// check $IncludeLeadingDigit
	if ($IncludeLeadingDigit == 0) {
		if (substr($number, 0, 2) == "0.")
			$number = substr($number, 1, strlen($number)-1);
	}
	if ($amount < 0) {
		$sign = $negative_sign;

		// "extracts" the boolean value as an integer
		$n_cs_precedes  = intval($n_cs_precedes  == true);
		$n_sep_by_space = intval($n_sep_by_space == true);
		$key = $n_cs_precedes . $n_sep_by_space . $n_sign_posn;
	} else {
		$sign = $positive_sign;
		$p_cs_precedes  = intval($p_cs_precedes  == true);
		$p_sep_by_space = intval($p_sep_by_space == true);
		$key = $p_cs_precedes . $p_sep_by_space . $p_sign_posn;
	}
	$formats = array(

	  // currency symbol is after amount

	  // no space between amount and sign
	  '000' => '(%s' . $currency_symbol . ')',
	  '001' => $sign . '%s ' . $currency_symbol,
	  '002' => '%s' . $currency_symbol . $sign,
	  '003' => '%s' . $sign . $currency_symbol,
	  '004' => '%s' . $sign . $currency_symbol,

	  // one space between amount and sign
	  '010' => '(%s ' . $currency_symbol . ')',
	  '011' => $sign . '%s ' . $currency_symbol,
	  '012' => '%s ' . $currency_symbol . $sign,
	  '013' => '%s ' . $sign . $currency_symbol,
	  '014' => '%s ' . $sign . $currency_symbol,

	  // currency symbol is before amount

	  // no space between amount and sign
	  '100' => '(' . $currency_symbol . '%s)',
	  '101' => $sign . $currency_symbol . '%s',
	  '102' => $currency_symbol . '%s' . $sign,
	  '103' => $sign . $currency_symbol . '%s',
	  '104' => $currency_symbol . $sign . '%s',

	  // one space between amount and sign
	  '110' => '(' . $currency_symbol . ' %s)',
	  '111' => $sign . $currency_symbol . ' %s',
	  '112' => $currency_symbol . ' %s' . $sign,
	  '113' => $sign . $currency_symbol . ' %s',
	  '114' => $currency_symbol . ' ' . $sign . '%s');

  // lookup the key in the above array
	return sprintf($formats[$key], $number);
}

// FormatNumber
/*
FormatNumber(Expression[,NumDigitsAfterDecimal [,IncludeLeadingDigit
	[,UseParensForNegativeNumbers [,GroupDigits]]]])
NumDigitsAfterDecimal is the numeric value indicating how many places to the
right of the decimal are displayed
-1 Use Default
The IncludeLeadingDigit, UseParensForNegativeNumbers, and GroupDigits
arguments have the following settings:
-1 True
0 False
-2 Use Default
*/
function ew_FormatNumber($amount, $NumDigitsAfterDecimal, $IncludeLeadingDigit, $UseParensForNegativeNumbers, $GroupDigits)
{

	// export the values returned by localeconv into the local scope
	if (function_exists("localeconv")) extract(localeconv());

	// set defaults if locale is not set
	if (empty($currency_symbol)) $currency_symbol = DEFAULT_CURRENCY_SYMBOL;
	if (empty($mon_decimal_point)) $mon_decimal_point = DEFAULT_MON_DECIMAL_POINT;
	if (empty($mon_thousands_sep)) $mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	if (empty($positive_sign)) $positive_sign = DEFAULT_POSITIVE_SIGN;
	if (empty($negative_sign)) $negative_sign = DEFAULT_NEGATIVE_SIGN;
	if (empty($frac_digits) || $frac_digits == CHAR_MAX) $frac_digits = DEFAULT_FRAC_DIGITS;
	if (empty($p_cs_precedes) || $p_cs_precedes == CHAR_MAX) $p_cs_precedes = DEFAULT_P_CS_PRECEDES;
	if (empty($p_sep_by_space) || $p_sep_by_space == CHAR_MAX) $p_sep_by_space = DEFAULT_P_SEP_BY_SPACE;
	if (empty($n_cs_precedes) || $n_cs_precedes == CHAR_MAX) $n_cs_precedes = DEFAULT_N_CS_PRECEDES;
	if (empty($n_sep_by_space) || $n_sep_by_space == CHAR_MAX) $n_sep_by_space = DEFAULT_N_SEP_BY_SPACE;
	if (empty($p_sign_posn) || $p_sign_posn == CHAR_MAX) $p_sign_posn = DEFAULT_P_SIGN_POSN;
	if (empty($n_sign_posn) || $n_sign_posn == CHAR_MAX) $n_sign_posn = DEFAULT_N_SIGN_POSN;

	// check $NumDigitsAfterDecimal
	if ($NumDigitsAfterDecimal > -1)
		$frac_digits = $NumDigitsAfterDecimal;

	// check $UseParensForNegativeNumbers
	if ($UseParensForNegativeNumbers == -1) {
		$n_sign_posn = 0;
		if ($p_sign_posn == 0) {
			if (DEFAULT_P_SIGN_POSN != 0)
				$p_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$p_sign_posn = 3;
		}
	} elseif ($UseParensForNegativeNumbers == 0) {
		if ($n_sign_posn == 0)
			if (DEFAULT_P_SIGN_POSN != 0)
				$n_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$n_sign_posn = 3;
	}

	// check $GroupDigits
	if ($GroupDigits == -1) {
		$mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	} elseif ($GroupDigits == 0) {
		$mon_thousands_sep = "";
	}

	// start by formatting the unsigned number
	$number = number_format(abs($amount),
						  $frac_digits,
						  $mon_decimal_point,
						  $mon_thousands_sep);

	// check $IncludeLeadingDigit
	if ($IncludeLeadingDigit == 0) {
		if (substr($number, 0, 2) == "0.")
			$number = substr($number, 1, strlen($number)-1);
	}
	if ($amount < 0) {
		$sign = $negative_sign;
		$key = $n_sign_posn;
	} else {
		$sign = $positive_sign;
		$key = $p_sign_posn;
	}
	$formats = array(
		'0' => '(%s)',
		'1' => $sign . '%s',
		'2' => $sign . '%s',
		'3' => $sign . '%s',
		'4' => $sign . '%s');

	// lookup the key in the above array
	return sprintf($formats[$key], $number);
}

// FormatPercent
/*
FormatPercent(Expression[,NumDigitsAfterDecimal [,IncludeLeadingDigit
	[,UseParensForNegativeNumbers [,GroupDigits]]]])
NumDigitsAfterDecimal is the numeric value indicating how many places to the
right of the decimal are displayed
-1 Use Default
The IncludeLeadingDigit, UseParensForNegativeNumbers, and GroupDigits
arguments have the following settings:
-1 True
0 False
-2 Use Default
*/
function ew_FormatPercent($amount, $NumDigitsAfterDecimal, $IncludeLeadingDigit, $UseParensForNegativeNumbers, $GroupDigits)
{

	// export the values returned by localeconv into the local scope
	if (function_exists("localeconv")) extract(localeconv());

	// set defaults if locale is not set
	if (empty($currency_symbol)) $currency_symbol = DEFAULT_CURRENCY_SYMBOL;
	if (empty($mon_decimal_point)) $mon_decimal_point = DEFAULT_MON_DECIMAL_POINT;
	if (empty($mon_thousands_sep)) $mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	if (empty($positive_sign)) $positive_sign = DEFAULT_POSITIVE_SIGN;
	if (empty($negative_sign)) $negative_sign = DEFAULT_NEGATIVE_SIGN;
	if (empty($frac_digits) || $frac_digits == CHAR_MAX) $frac_digits = DEFAULT_FRAC_DIGITS;
	if (empty($p_cs_precedes) || $p_cs_precedes == CHAR_MAX) $p_cs_precedes = DEFAULT_P_CS_PRECEDES;
	if (empty($p_sep_by_space) || $p_sep_by_space == CHAR_MAX) $p_sep_by_space = DEFAULT_P_SEP_BY_SPACE;
	if (empty($n_cs_precedes) || $n_cs_precedes == CHAR_MAX) $n_cs_precedes = DEFAULT_N_CS_PRECEDES;
	if (empty($n_sep_by_space) || $n_sep_by_space == CHAR_MAX) $n_sep_by_space = DEFAULT_N_SEP_BY_SPACE;
	if (empty($p_sign_posn) || $p_sign_posn == CHAR_MAX) $p_sign_posn = DEFAULT_P_SIGN_POSN;
	if (empty($n_sign_posn) || $n_sign_posn == CHAR_MAX) $n_sign_posn = DEFAULT_N_SIGN_POSN;

	// check $NumDigitsAfterDecimal
	if ($NumDigitsAfterDecimal > -1)
		$frac_digits = $NumDigitsAfterDecimal;

	// check $UseParensForNegativeNumbers
	if ($UseParensForNegativeNumbers == -1) {
		$n_sign_posn = 0;
		if ($p_sign_posn == 0) {
			if (DEFAULT_P_SIGN_POSN != 0)
				$p_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$p_sign_posn = 3;
		}
	} elseif ($UseParensForNegativeNumbers == 0) {
		if ($n_sign_posn == 0)
			if (DEFAULT_P_SIGN_POSN != 0)
				$n_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$n_sign_posn = 3;
	}

	// check $GroupDigits
	if ($GroupDigits == -1) {
		$mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	} elseif ($GroupDigits == 0) {
		$mon_thousands_sep = "";
	}

	// start by formatting the unsigned number
	$number = number_format(abs($amount)*100,
							$frac_digits,
							$mon_decimal_point,
							$mon_thousands_sep);

	// check $IncludeLeadingDigit
	if ($IncludeLeadingDigit == 0) {
		if (substr($number, 0, 2) == "0.")
			$number = substr($number, 1, strlen($number)-1);
	}
	if ($amount < 0) {
		$sign = $negative_sign;
		$key = $n_sign_posn;
	} else {
		$sign = $positive_sign;
		$key = $p_sign_posn;
	}
	$formats = array(
		'0' => '(%s%%)',
		'1' => $sign . '%s%%',
		'2' => $sign . '%s%%',
		'3' => $sign . '%s%%',
		'4' => $sign . '%s%%');

	// lookup the key in the above array
	return sprintf($formats[$key], $number);
}

//-------------------------------------------------------------------------------
// Function to Adjust SQL

function ew_AdjustSql($str) {
	$sWrk = trim($str);
	addslashes($sWrk); // Adjust for Single Quote
	return $sWrk;
}

//-------------------------------------------------------------------------------
// Function to Build Report SQL

function ew_BuildReportSql($sTransform, $sSelect, $sWhere, $sGroupBy, $sHaving, $sOrderBy, $sPivot, $sFilter, $sSort) {

	$sDbWhere = $sWhere;
	if ($sDbWhere <> "") $sDbWhere = "(" . $sDbWhere . ")";
	if ($sFilter <> "") {
		if ($sDbWhere <> "") $sDbWhere .= " AND ";
		$sDbWhere .= "(" . $sFilter . ")";
	}
	$sDbOrderBy = $sOrderBy;
	if ($sSort <> "") {
		if ($sDbOrderBy <> "") $sDbOrderBy .= ", ";
		$sDbOrderBy .= $sSort;
	}
	$sSql = $sSelect;
	if ($sDbWhere <> "") $sSql .= " WHERE " . $sDbWhere;
	if ($sGroupBy <> "") $sSql .= " GROUP BY " . $sGroupBy;
	if ($sHaving <> "") $sSql .= " HAVING " . $sHaving;
	if ($sDbOrderBy <> "") $sSql .= " ORDER BY " . $sDbOrderBy;
//	if ($sTransform <> "" && $sPivot <> "") {
//		$sSql = "TRANSFORM " . $sTransform . " " . $sSql . " PIVOT " . $sPivot;
//	}

	return $sSql;

}

//-------------------------------------------------------------------------------
// Function to Load Recordset based on Sql

function ew_LoadRs($sSql) {
	global $conn;
	$rs = array();
	$temprs = php_query($sSql, $conn) or die("<!--##@FailedToExecuteQuery##-->" . __LINE__ . ": " . php_error($conn) . '<br>SQL: ' . $sSql);
	while ($temp = php_fetch_array($temprs)) {
		$rs[] = $temp;
	}
	return $rs;
}

//-------------------------------------------------------------------------------
// Function to Construct a crosstab field name

function ew_CrossTabField($smrytype, $smryfld, $colfld, $datetype, $val, $qc, $id) {
	if ($val == "##null") {
		$wrkval = "NULL";
		$wrkqc = "";
	} elseif ($val == "##empty") {
		$wrkval = "";
		$wrkqc = $qc;
	} else {
		$wrkval = $val;
		$wrkqc = $qc;
	}
	switch ($smrytype) {
	case "SUM":
		return $smrytype . "(" . $smryfld . "*" . ew_SQLDistinctFactor(EW_DBMSNAME, $colfld, $datetype, $val, $qc) . ") AS C" . $id;
	case "COUNT":
		return "SUM(" . ew_SQLDistinctFactor(EW_DBMSNAME, $colfld, $datetype, $wrkval, $wrkqc) . ") AS C" . $id;
	case "MIN":
	case "MAX":
		$aggwrk = ew_SQLDistinctFactor(EW_DBMSNAME, $colfld, $datetype, $wrkval, $wrkqc);
		return $smrytype . "(IF(" . $aggwrk . "=0,NULL," . $smryfld . ")) AS C" . $id;
	case "AVG":
		$sumwrk = "SUM(" . $smryfld . "*" .
			ew_SQLDistinctFactor(EW_DBMSNAME, $colfld, $datetype, $wrkval, $wrkqc) . ")";
		$cntwrk =	"SUM(" .
			ew_SQLDistinctFactor(EW_DBMSNAME, $colfld, $datetype, $wrkval, $wrkqc) . ")";
		return "IF(" . $cntwrk . "=0,0," . $sumwrk . "/" . $cntwrk . ") AS C" . $id;
	}
}

//-------------------------------------------------------------------------------
// Function to construct SQL Distinct factor
// - MySQL
// y: IF(YEAR(`OrderDate`)=1996,1,0))
// q: IF(QUARTER(`OrderDate`)=1,1,0))
// m: IF(MONTH(`OrderDate`)=1,1,0))

function ew_SQLDistinctFactor($dbmsName, $sFld, $dateType, $val, $qc) {
	if ($dateType == "y" && is_numeric($val)) {
		return "IF(YEAR(" . $sFld . ")=" . $val . ",1,0)";
	} elseif ($dateType == "q" && is_numeric($val)) {
		return "IF(QUARTER(" . $sFld . ")=" . $val . ",1,0)";
	} elseif ($dateType == "m" && is_numeric($val)) {
		return "IF(MONTH(" . $sFld . ")=" . $val . ",1,0)";
	} else {
		if ($val == "NULL") {
			return "IF(" . $sFld . " IS NULL,1,0)";
		} else {
			return "IF(" . $sFld . "=" . $qc . ew_AdjustSql($val) . $qc . ",1,0)";
		}
	}
}

//-------------------------------------------------------------------------------
// Function to evaluate summary value

function ew_SummaryValue($val1, $val2, $ityp) {
	switch ($ityp) {
	case "SUM":
	case "COUNT":
		if ($val2 == NULL || !is_numeric($val2)) {
			return $val1;
		} else {
			return ($val1 + $val2);
		}
	case "MIN":
		if ($val2 == NULL || !is_numeric($val2)) {
			return $val1; // Skip null and non-numeric
		} elseif ($val1 == NULL) {
			return $val2; // Initialize for first valid value
		} elseif ($val1 < $val2) {
			return $val1;
		} else {
			return $val2;
		}
	case "MAX":
		if ($val2 == NULL || !is_numeric($val2)) {
			return $val1; // Skip null and non-numeric
		} elseif ($val1 == NULL) {
			return $val2; // Initialize for first valid value
		} elseif ($val1 > $val2) {
			return $val1;
		} else {
			return $val2;
		}
	}
}

//-------------------------------------------------------------------------------
// Function to check if all values are selected
// sName: popup name

function ew_IsSelectedAll($sName) {
	global $PHP_SESSION;
	$bSelectedAll = @$PHP_SESSION["all_" . $sName];
	if (!isset($bSelectedAll)) {
		return True;
	} elseif ($bSelectedAll) {
		return True;
	} else {
		return False;
	}
}

//-------------------------------------------------------------------------------
// Function to check if the value is selected
// sName: popup name
// value: supplied value

function ew_IsSelectedValue($sName, $value, $ft) {
	global $PHP_SESSION;
	$arSelectedValues = $PHP_SESSION["sel_" . $sName];
	if (!is_array($arSelectedValues)) return True;
	foreach ($arSelectedValues as $val) {
		$val = (get_magic_quotes_gpc()) ? stripslashes($val) : $val;
		if (substr($value, 0, 2) == "@@" || substr($val, 0, 2) == "@@") { // Advanced filters
			if ($val == $value) return True;
		} elseif (ew_CompareValue($val, $value, $ft)) {
			return True;
		}
	}
	return False;
}

//-------------------------------------------------------------------------------
// Function to set up distinct values
// ar: array for distinct values
// val: value
// label: display value
// dup: check duplicate

function ew_SetupDistinctValues(&$ar, $val, $label, $dup) {
	if ($dup && is_array($ar) && in_array($val, array_keys($ar)))
			return;
	if (!is_array($ar)) {
		$ar = array($val => $label);
	} elseif ($val == "##empty" || $val == "##null") { // null/empty
		$ar = array_reverse($ar, TRUE);
		$ar[$val] = $label; // insert at top
		$ar = array_reverse($ar, TRUE);
	} else {
		$ar[$val] = $label; // default insert at end
	}
}

//-------------------------------------------------------------------------------
// Function to compare values based on field type

function ew_CompareValue($v1, $v2, $ft) {
	switch ($ft) {
	// Case adBigInt, adInteger, adSmallInt, adTinyInt, adUnsignedTinyInt, adUnsignedSmallInt, adUnsignedInt, adUnsignedBigInt
	case 20:
	case 3:
	case 2:
	case 16:
	case 17:
	case 18:
	case 19:
	case 21:
		if (is_numeric($v1) && is_numeric($v2)) {
			return (intval($v1) == intval($v2));
		}
		break;
	// Case adSingle, adDouble, adNumeric, adCurrency
	case 4:
	case 5:
	case 131:
	case 6:
		if (is_numeric($v1) && is_numeric($v2)) {
			return ((float)$v1 == (float)$v2);
		}
		break;
//	Case adDate, adDBDate, adDBTime, adDBTimeStamp
//	case 7:
//	case 133:
//	case 134:
//	case 135:
	default:
		return (strval($v1."") == strval($v2."")); // treat as string
	}
}

// "Past"
function ew_IsPast($dt) {
	$dif = ew_DateDiff($dt, "now", "s");
	return ($dif === FALSE) ? TRUE : ($dif > 0);
}

// "Future";
function ew_IsFuture($dt) {
	$dif = ew_DateDiff($dt, "now", "s");
	return ($dif < 0);
}

// "Last 30 days"
function ew_IsLast30Days($dt) {
	$dif = ew_DateDiff($dt, "now");
	return ($dif >= 0 && $dif <= 29);
}

// "Last 14 days"
function ew_IsLast14Days($dt) {
	$dif = ew_DateDiff($dt, "now");
	return ($dif >= 0 && $dif <= 13);
}

// "Last 7 days"
function ew_IsLast7Days($dt) {
	$dif = ew_DateDiff($dt, "now");
	return ($dif >= 0 && $dif <= 6);
}

// "Next 30 days"
function ew_IsNext30Days($dt) {
	$dif = ew_DateDiff("now", $dt);
	return ($dif >= 0 && $dif <= 29);
}

// "Next 14 days"
function ew_IsNext14Days($dt) {
	$dif = ew_DateDiff("now", $dt);
	return ($dif >= 0 && $dif <= 13);
}

// "Last 7 days"
function ew_IsNext7Days($dt) {
	$dif = ew_DateDiff("now", $dt);
	return ($dif >= 0 && $dif <= 6);
}

// "Yesterday"
function ew_IsYesterday($dt) {
	$dif = ew_DateDiff($dt, "now");
	return ($dif == 1);
}

// "Today"
function ew_IsToday($dt) {
	$dif = ew_DateDiff("now", $dt);
	return ($dif == 0);
}

// "Tomorrow"
function ew_IsTomorrow($dt) {
	$dif = ew_DateDiff("now", $dt);
	return ($dif == 1);
}

// "Last month"
function ew_IsLastMonth($dt) {
	$dif = ew_DateDiff($dt, "now", "m");
	return ($dif == 1);
}

// "This month"
function ew_IsThisMonth($dt) {
	$dif = ew_DateDiff("now", $dt, "m");
	return ($dif == 0);
}

// "Next month"
function ew_IsNextMonth($dt) {
	$dif = ew_DateDiff("now", $dt, "m");
	return ($dif == 1);
}

// "Last two weeks"
function ew_IsLast2Weeks($dt) {
	$dif = ew_DateDiff($dt, "now", "ww");
	return ($dif == 1 || $dif == 2);
}

// "Last week"
function ew_IsLastWeek($dt) {
	$dif = ew_DateDiff($dt, "now", "ww");
	return ($dif == 1);
}

// "This week"
function ew_IsThisWeek($dt) {
	$dif = ew_DateDiff($dt, "now", "ww");
	return ($dif == 0);
}

// "Next week"
function ew_IsNextWeek($dt) {
	$dif = ew_DateDiff("now", $dt, "ww");
	return ($dif == 1);
}

// "Next two week"
function ew_IsNext2Weeks($dt) {
	$dif = ew_DateDiff("now", $dt, "ww");
	return ($dif == 1 || $dif == 2);
}

// "Last year"
function ew_IsLastYear($dt) {
	$dif = ew_DateDiff($dt, "now", "yyyy");
	return ($dif == 1);
}

// "This year"
function ew_IsThisYear($dt) {
	$dif = ew_DateDiff($dt, "now", "yyyy");
	return ($dif == 0);
}

// "Next year"
function ew_IsNextYear($dt) {
	$dif = ew_DateDiff("now", $dt, "yyyy");
	return ($dif == 1);
}

// Function to calculate date difference
function ew_DateDiff($dateTimeBegin, $dateTimeEnd, $interval = "d") {

	$dateTimeBegin = strtotime($dateTimeBegin);
	if ($dateTimeBegin === -1 || $dateTimeBegin === FALSE)
		return FALSE;
	
	$dateTimeEnd = strtotime($dateTimeEnd);
	if($dateTimeEnd === -1 || $dateTimeEnd === FALSE)
		return FALSE;
	
	$dif = $dateTimeEnd - $dateTimeBegin;	
	$arBegin = getdate($dateTimeBegin);
	$dateBegin = mktime(0, 0, 0, $arBegin["mon"], $arBegin["mday"], $arBegin["year"]);
	$arEnd = getdate($dateTimeEnd);
	$dateEnd = mktime(0, 0, 0, $arEnd["mon"], $arEnd["mday"], $arEnd["year"]);
	$difDate = $dateEnd - $dateBegin;
	
	switch ($interval) {
		case "s": // seconds
			return $dif;
		case "n": // minutes
			return ($dif > 0) ? floor($dif/60) : ceil($dif/60);
		case "h": // hours
			return ($dif > 0) ? floor($dif/3600) : ceil($dif/3600);
		case "d": // days
			return ($difDate > 0) ? floor($difDate/86400) : ceil($difDate/86400);
		case "w": // weeks
			return ($difDate > 0) ? floor($difDate/604800) : ceil($difDate/604800);
		case "ww": // calendar weeks
			$difWeek = (($dateEnd - $arEnd["wday"]*86400) - ($dateBegin - $arBegin["wday"]*86400))/604800;
			return ($difWeek > 0) ? floor($difWeek) : ceil($difWeek);
		case "m": // months
			return (($arEnd["year"]*12 + $arEnd["mon"]) -	($arBegin["year"]*12 + $arBegin["mon"]));
		case "yyyy": // years
			return ($arEnd["year"] - $arBegin["year"]);
	}
}

//-------------------------------------------------------------------------------
// Function to set up distinct values from advanced filter

function ew_SetupDistinctValuesFromFilter(&$ar, $af) {
	if (is_array($af)) {
		foreach ($af as $value) {
			ew_SetupDistinctValues($ar, $value[0], $value[1], FALSE);
		}
	}
}

//-------------------------------------------------------------------------------
// Function to get group value
// - Get the group value based on field type, group type and interval
// - ft: field type
// * 1: numeric, 2: date, 3: string
// - gt: group type
// * numeric: i = interval, n = normal
// * date: d = Day, w = Week, m = Month, q = Quarter, y = Year
// * string: f = first nth character, n = normal
// - intv: interval

function ew_GroupValue($val, $ft, $grp, $intv) {
	switch ($ft) {
	// Case adBigInt, adInteger, adSmallInt, adTinyInt, adSingle, adDouble, adNumeric, adCurrency, adUnsignedTinyInt, adUnsignedSmallInt, adUnsignedInt, adUnsignedBigInt (numeric)
	case 20:
	case 3:
	case 2:
	case 16:
	case 4:
	case 5:
	case 131:
	case 6:
	case 17:
	case 18:
	case 19:
	case 21:
		if (!is_numeric($val)) return $val;	
		$wrkIntv = intval($intv);
		if ($wrkIntv <= 0) $wrkIntv = 10;
		switch ($grp) {
			case "i":
				return intval($val/$wrkIntv);
			default:
				return $val;
		}
	// Case adDate, adDBDate, adDBTime, adDBTimeStamp (date)
//	case 7:
//	case 133:
//	case 134:
//	case 135:
	// Case adLongVarChar, adLongVarWChar, adChar, adWChar, adVarChar, adVarWChar (string)
	case 201: // string
	case 203:
	case 129:
	case 130:
	case 200:
	case 202:
		$wrkIntv = intval($intv);
		if ($wrkIntv <= 0) $wrkIntv = 1;
		switch ($grp) {
			case "f":
				return substr($val, 0, $wrkIntv);
			default:
				return $val;
		}
	default:
		return $val; // ignore
	}
}

//-------------------------------------------------------------------------------
// Functions to display group value

function ew_DisplayGroupValue($val, $ft, $grp, $intv) {
	if ($val == NULL) return $val;
	switch ($ft) {
	// Case adBigInt, adInteger, adSmallInt, adTinyInt, adSingle, adDouble, adNumeric, adCurrency, adUnsignedTinyInt, adUnsignedSmallInt, adUnsignedInt, adUnsignedBigInt (numeric)
	case 20:
	case 3:
	case 2:
	case 16:
	case 4:
	case 5:
	case 131:
	case 6:
	case 17:
	case 18:
	case 19:
	case 21:
		$wrkIntv = intval($intv);
		if ($wrkIntv <= 0) $wrkIntv = 10;
		switch ($grp) {
			case "i":
				return strval($val*$wrkIntv) . " - " . strval(($val+1)*$wrkIntv);
			default:
				return $val;
		}
		break;
	// Case adDate, adDBDate, adDBTime, adDBTimeStamp (date)
	case 7:
	case 133:
	case 134:
	case 135:
		$ar = explode("|", $val);
		switch ($grp) {
			Case "y":
				return $ar[0];
			Case "q":
				return ew_FormatQuarter($ar[0], $ar[1]);
			Case "m":
				return ew_FormatMonth($ar[0], $ar[1]);
			Case "w":
				return ew_FormatWeek($ar[0], $ar[1]);
			Case "d":
				return ew_FormatDay($ar[0], $ar[1], $ar[2]);
			Case "h":
				return ew_FormatHour($ar[0]);
			Case "min":
				return ew_FormatMinute($ar[0]);
			default:
				return $val;
		}
		break;
	default: // string and others
		return $val; // ignore
	}
}

function ew_FormatQuarter($y, $q) {
	return "Q" . $q . "/" . $y;
}

function ew_FormatMonth($y, $m) {
	return $m . "/" . $y;
}

function ew_FormatWeek($y, $w) {
	return "WK" . $w . "/" . $y;
}

function ew_FormatDay($y, $m, $d) {
	return $y . "-" . $m . "-" . $d;
}

function ew_FormatHour($h) {
	if (intval($h) == 0) {
		return "12 AM";
	} elseif (intval($h) < 12) {
		return $h . " AM";
	} elseif (intval($h) == 12) {
		return "12 PM";
	} else {
		return ($h-12) . " PM";
	}
}

function ew_FormatMinute($n) {
	return $n . " MIN";
}

//-------------------------------------------------------------------------------
// Function to get Js data in the form of:
// - new Array(value1, text1, selected), new Array(value2, text2, selected) ...
// - value1: "value 1", text1: "text 1": selected: true|false
// name: popup name
// list: comma separated list

function ew_GetJsData($name, &$ar, $ft) {
	$bAllSelected = ew_IsSelectedAll($name);
	$jsdata = "";
	if (is_array($ar)) {
		foreach ($ar as $key => $value) {
			$bSelected = ($bAllSelected) ? TRUE : ew_IsSelectedValue($name, $key, $ft);
			$jsselect = ($bSelected) ? "true" : "false";
			if ($jsdata <> "") $jsdata .= ",";
			$jsdata .= "new Array(\"" . ew_EscapeJs($key) . "\",\"" . ew_EscapeJs($value) . "\"," . $jsselect . ")";
		}
	}
	return $jsdata;
}

//-------------------------------------------------------------------------------
// Function to check if selected value

function ew_SelectedValue(&$ar, $val, $ft, $af) {
	if (!is_array($ar)) {
		return TRUE;
	} else {
		foreach ($ar as $value) {
			if ($value == "##empty" && $val == "") { // empty string
				return TRUE;
			} elseif ($value == "##null" && $val == NULL) { // null value
				return TRUE;
			} elseif (substr($val, 0, 2) == "@@" || substr($value, 0, 2) == "@@") { // advanced filter
				if (is_array($af) && $val != NULL) {
					$result = ew_SelectedFilter($af, $value, $val); // process advanced filter
					if ($result) return TRUE;
				}
			} elseif (ew_CompareValue($value, $val, $ft)) {
				return TRUE;
			}
		}
	}
	return FALSE;
}

//-------------------------------------------------------------------------------
// Function to check for advanced filter

function ew_SelectedFilter(&$ar, $sel, $val) {
	if (!is_array($ar)) {
		return TRUE;
	} elseif ($val == NULL) {
		return FALSE;
	} else {
		foreach ($ar as $value) {
			if (strval($sel) == strval($value[0])) {
				$sEvalFunc = $value[2];
				return $sEvalFunc($val);
			}
		}
		return TRUE;
	}
}

//-------------------------------------------------------------------------------
// Function to truncate Memo Field based on specified length,
// string truncated to nearest space or CrLf

function TruncateMemo($str, $ln) {
	if (strlen($str) > 0 && strlen($str) > $ln) {
		$k = 0;
		while ($k >= 0 && $k < strlen($str)) {
			$i = strpos($str, " ", $k);
			$j = strpos($str,chr(10), $k);
			if ($i === FALSE && $j === FALSE) { // Not able to truncate
				return $str;
			} else { // Get nearest space or CrLf
				if ($i > 0 && $j > 0) {
					if ($i < $j) {
						$k = $i;
					} else {
						$k = $j;
					}
				} elseif ($i > 0) {
					$k = $i;
				} elseif ($j > 0) {
					$k = $j;
				}
				// Get truncated text
				if ($k >= $ln) {
					return substr($str, 0, $k) . "...";
				} else {
					$k++;
				}
			}
		}
	} else {
		return $str;
	}
}

//-------------------------------------------------------------------------------
// Function to escape Js

function ew_EscapeJs($str) {
	$str = str_replace("\\", "\\\\", $str . "");
	$str = str_replace("\"", "\\\"", $str);
	$str = str_replace("\r", "\\r", $str);
	$str = str_replace("\n", "\\n", $str);
	return $str;
}

//-------------------------------------------------------------------------------
// Function to show chart
// id: chart id
// parms: "type=1,bgcolor=FFFFFF,..."

function ew_ShowChart($id, $parms, $data, $width, $height, $align) {
	global $PHP_SESSION;

	$url = "ewchart.php*id=" . $id;
	$PHP_SESSION[$id . "_parms"] = $parms; // Save parms to session
	$PHP_SESSION[$id . "_data"] = $data; // Save chart data to session
	if (is_numeric($width) && is_numeric($height)) {
		$wrkwidth = $width;
		$wrkheight = $height;
	} else {
		$wrkwidth = 550;
		$wrkheight = 450; // default
	}
	if (strtolower($align) == "left" || strtolower($align) == "right") {
		$wrkalign = strtolower($align);
	} else {
		$wrkalign = "middle"; // default
	}
	$wrk = "<div id=\"$id\"></div>\n";
	$wrk .= "<script language=\"JavaScript\" type=\"text/javascript\">\n";
	$wrk .= "<!--\n";
	$wrk .= "var so = new SWFObject(\"ewchart.swf\", \"ewchart_$id\", \"$wrkwidth\", \"$wrkheight\", \"8\", \"#FFFFFF\");\n";
	$wrk .= "so.setAttribute(\"align\", \"$wrkalign\");\n";
	$wrk .= "so.addVariable(\"dataurl\", \"$url\");\n";
	$wrk .= "so.write(\"$id\");\n";
	$wrk .= "//-->\n";
	$wrk .= "</script>\n";

// ew_Trace($wrk); // uncomment to debug
	return $wrk;
}

//-------------------------------------------------------------------------------
// Function to sort chart data

function ew_SortChartData(&$ar, $opt) {
	if ($opt < 1 || $opt > 4) return;
	if (is_array($ar)) {
		for ($i = 0; $i < count($ar); $i++) {
			for ($j = $i+1; $j < count($ar); $j++) {
				switch ($opt) {
					case 1: // X values ascending
						$bSwap = ($ar[$i][0] > $ar[$j][0]) || ($ar[$i][0] == $ar[$j][0] && $ar[$i][1] > $ar[$j][1]);
						break;
					case 2: // X values descending
						$bSwap = ($ar[$i][0] < $ar[$j][0]) || ($ar[$i][0] == $ar[$j][0] && $ar[$i][1] < $ar[$j][1]);
						break;
					case 3: // Y values ascending
						$bSwap = ($ar[$i][2] > $ar[$j][2]);
						break;
					case 4: // Y values descending
						$bSwap = ($ar[$i][2] < $ar[$j][2]);
				}
				if ($bSwap) {
			   	$tmpname1 = $ar[$i][0];
					$tmpname2 = $ar[$i][1];
					$tmpval = $ar[$i][2];
			   	$ar[$i][0] = $ar[$j][0];
					$ar[$i][1] = $ar[$j][1];
					$ar[$i][2] = $ar[$j][2];
		   		$ar[$j][0] = $tmpname1;
					$ar[$j][1] = $tmpname2;
					$ar[$j][2] = $tmpval;
				}
			}
		}
	}
}

// Function to escape chars for XML
function XmlEncode($val) {
	return htmlspecialchars($val);
}

// Function for debug
function ew_Trace($msg) {
	$filename = "debug.txt";
	if (!$handle = fopen($filename, 'a')) exit;
	if (is_writable($filename)) fwrite($handle, $msg . "\n");
	fclose($handle);
}

// Function to get script name
function ew_ScriptFileName() {
	global $PHP_SERVER, $PHP_ENV;
	$fn = @$PHP_ENV["PHP_SELF"];
	if (empty($fn)) $fn = @$PHP_SERVER["PHP_SELF"];
	if (empty($fn)) $fn = @$PHP_ENV["SCRIPT_NAME"];
	if (empty($fn)) $fn = @$PHP_SERVER["SCRIPT_NAME"];
	if (empty($fn)) $fn = @$PHP_ENV["ORIG_PATH_INFO"];
	if (empty($fn)) $fn = @$PHP_SERVER["ORIG_PATH_INFO"];
	if (empty($fn)) $fn = @$PHP_ENV["ORIG_SCRIPT_NAME"];
	if (empty($fn)) $fn = @$PHP_SERVER["ORIG_SCRIPT_NAME"];
	if (empty($fn)) $fn = @$PHP_ENV["REQUEST_URI"];
	if (empty($fn)) $fn = @$PHP_SERVER["REQUEST_URI"];
	if (empty($fn)) $fn = @$PHP_ENV["URL"];
	if (empty($fn)) $fn = @$PHP_SERVER["URL"];
	if (empty($fn)) $fn = "UNKNOWN";
	return $fn;
}

// Function to stripslashes for array
function ew_StripSlashes(&$value, $key)
{
   $value = stripslashes($value);
}


// Function for TEA encrypt
function TEAencrypt($str, $key)
{
	if ($str == "") {
		return "";
	}
	$v = str2long($str, true);
	$k = str2long($key, false);
	if (count($k) < 4)
	{
		for ($i = count($k); $i < 4; $i++) {
			$k[$i] = 0;
		}
	}
	$n = count($v) - 1;
	
	$z = $v[$n];
	$y = $v[0];
	$delta = 0x9E3779B9;
	$q = floor(6 + 52 / ($n + 1));
	$sum = 0;
	while (0 < $q--) {
		$sum = int32($sum + $delta);
		$e = $sum >> 2 & 3;
		for ($p = 0; $p < $n; $p++) {
			$y = $v[$p + 1];
			$mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
			$z = $v[$p] = int32($v[$p] + $mx);
		}
		$y = $v[0];
		$mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
		$z = $v[$n] = int32($v[$n] + $mx);
	}
	return urlencode(long2str($v, false));
}

// Function for TEA decrypt
function TEAdecrypt($str, $key)
{
	$str = urldecode($str);
	if ($str == "") {
		return "";
	}
	$v = str2long($str, false);
	$k = str2long($key, false);
	if (count($k) < 4)
	{
		for ($i = count($k); $i < 4; $i++) {
			$k[$i] = 0;
		}
	}
	$n = count($v) - 1;
	
	$z = $v[$n];
	$y = $v[0];
	$delta = 0x9E3779B9;
	$q = floor(6 + 52 / ($n + 1));
	$sum = int32($q * $delta);
	while ($sum != 0) {
		$e = $sum >> 2 & 3;
		for ($p = $n; $p > 0; $p--) {
			$z = $v[$p - 1];
			$mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
			$y = $v[$p] = int32($v[$p] - $mx);
		}
		$z = $v[$n];
		$mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
		$y = $v[0] = int32($v[0] - $mx);
		$sum = int32($sum - $delta);
	}
	return long2str($v, true);
}

function long2str($v, $w)
{
	$len = count($v);
	$s = array();
	for ($i = 0; $i < $len; $i++)
	{
		$s[$i] = pack("V", $v[$i]);
	}
	if ($w) {
		return substr(join('', $s), 0, $v[$len - 1]);
	}	else {
		return join('', $s);
	}
}

function str2long($s, $w)
{
	$v = unpack("V*", $s. str_repeat("\0", (4 - strlen($s) % 4) & 3));
	$v = array_values($v);
	if ($w) {
		$v[count($v)] = strlen($s);
	}
	return $v;
}

function int32($n) {
	while ($n >= 2147483648) $n -= 4294967296;
	while ($n <= -2147483649) $n += 4294967296; 
	return (int)$n;
}
?>
