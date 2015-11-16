<?php

// Advanced User Level Security for PHP Report Maker 1.0
define("ewAllowList", 8, true);
define("ewAllowReport", 8, true);
define("ewAllowAdmin", 16, true);
$arUserLevel = NULL;
$arUserLevelPriv = NULL;

// Define User Level Variables
$ewCurLvl = CurrentUserLevel();
$ewCurSec = NULL;

// No user level security
function SetUpUserLevel() {

	// User Level not used
}

// Get current user privilege
function CurrentUserLevelPriv($TableName)
{
	return GetUserLevelPrivEx($TableName, CurrentUserLevel());
}

// Get anonymous user privilege
function GetAnonymousPriv($TableName)
{
	return GetUserLevelPrivEx($TableName, 0);
}

// Get user privilege based on table name and user level
function GetUserLevelPrivEx($TableName, $UserLevel)
{
	global $arUserLevelPriv;
	$userLevelPrivEx = 0;
	if (strval($UserLevel) == "-1") {
		return 31;
	} elseif ($UserLevel >=0) {
		if (is_array($arUserLevelPriv)) {
			foreach ($arUserLevelPriv as $row) {
				if ((strtolower($row[0]) == strtolower($TableName)) And (strval($row[1]) == strval($UserLevel))) {
					$userLevelPrivEx = $row[2];
				if (($userLevelPrivEx == NULL)) $userLevelPrivEx = 0;
				if (!is_numeric($userLevelPrivEx)) $userLevelPrivEx = 0;
				return (int)($userLevelPrivEx);
				}
			}
		}
	}
}

// Get current user level name
function CurrentUserLevelName()
{
	return GetUserLevelName(CurrentUserLevel());
}

// Get user level name based on user level
function GetUserLevelName($UserLevel)
{
	global $arUserLevel;
	if (strval($UserLevel) == "-1") {
		return "Administrator";
	} elseif ($UserLevel >= 0) {
		if (is_array($arUserLevel)) {
			foreach ($arUserLevel as $row) {
				if (strval($row[0]) == strval($UserLevel)) {
					return $row[1];
				}
			}
		}
	}
}

// Function to display all the User Level settings (for debug only)
function ShowUserLevelInfo()
{
	if (is_array($GLOBALS["arUserLevel"])) {
		print "User Levels:<br>";
		print "UserLevelID, UserLevelName<br>";
		$rows = $GLOBALS["arUserLevel"];
		for ($i=0;$i<count($rows);$i++) {
			print "&nbsp;&nbsp;".$rows[$i][0].",".$rows[$i][1]."<br>";
		}
	}	else {
		print "No User Level definitions."."<br>";
	}
	if (is_array($GLOBALS["arUserLevelPriv"])) {
		print "User Levels Privs:<br>";
		print "TableName, UserLevelID, UserLevelPriv<br>";
		$rows = $GLOBALS["arUserLevelPriv"];
		for ($i=0; $i<count($rows); $i++) {
			print "&nbsp;&nbsp;".$rows[$i][0].",".$rows[$i][1].",".$rows[$i][2]."<br>";
		}
	}	else {
		print "No User Level privilege settings."."<br>";
	}
	print "CurrentUserLevel = " . CurrentUserLevel()."<br>";
}

// Function to check privilege for List page (for menu items)
function AllowList($TableName)
{
	return (CurrentUserLevelPriv($TableName) & ewAllowList);
}

// Get current user name from session
function CurrentUserName()
{
	global $PHP_SESSION;
	return @$PHP_SESSION[EW_SESSION_USERNAME];
}

// Get current user id from session
function CurrentUserID()
{
	global $PHP_SESSION;
	return @$PHP_SESSION[EW_SESSION_USERID];
}

// Get current parent user id from session
function CurrentParentUserID()
{
	global $PHP_SESSION;
	return @$PHP_SESSION[EW_SESSION_PARENT_USERID];
}

// Get current user level from session
function CurrentUserLevel()
{
	global $PHP_SESSION;
	if (IsLoggedIn()) {
		return @$PHP_SESSION[EW_SESSION_USERLEVEL];
	} else {
		return 0; //Anonymous if not logged in
	}
}

// Check if user is logged in
function IsLoggedIn()
{
	global $PHP_SESSION;
	return (@$PHP_SESSION[EW_SESSION_STATUS] == "login");
}

// Check if user is system administrator
function IsSysAdmin()
{
	global $PHP_SESSION;
	return (@$PHP_SESSION[EW_SESSION_SYSTEM_ADMIN] == 1);
}

// Load user level from session
function LoadUserLevel()
{
	SetupUserLevel();
}
?>
